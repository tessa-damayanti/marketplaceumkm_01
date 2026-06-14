<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class CheckoutController extends Controller
{
    /**
     * Konfigurasi Midtrans SDK.
     */
    private function boot(): void
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
        Config::$curlOptions  = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER     => [],
        ];
    }

    // Proses pemesanan dan generate Snap Token

    public function charge(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
        }

        $this->boot();

        $request->validate([
            'buyer_name'    => 'required|string|max:50',
            'buyer_phone'   => 'required|string|max:15',
            'buyer_address' => 'required|string',
            'grand_total'   => 'required|numeric|min:1',
        ]);

        /** @var User $user */
        $user   = Auth::user();
        $userId = $user->id;

        //Kumpulkan item yang akan dibeli
        // Format: [ ['stok_id' => X, 'qty' => Y, 'harga' => Z, 'nama' => '', 'ukuran' => '']]
        $result = $this->collectItems($request, $userId);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['code']);
        }

        $items = $result;

        //Hitung total dan validasi
        $totalHarga = collect($items)->sum(fn($i) => $i['harga'] * $i['qty']);
        $grandTotal = (int) $request->grand_total;

        // Toleransi selisih kecil (misal pembulatan)
        if (abs($totalHarga - $grandTotal) > 100) {
            return response()->json(['error' => 'Total harga tidak sesuai. Silakan refresh halaman.'], 422);
        }

        //Buat Pesanan dan Detail + Snap Token dalam satu transaksi
        $snapToken = null;
        $pesanan   = null;

        DB::transaction(function () use ($items, $totalHarga, $user, $request, &$pesanan, &$snapToken) {
            [$pesanan, $snapToken] = $this->processOrder($items, $totalHarga, $user, $request);
        });

        return response()->json(['snap_token' => $snapToken]);
    }

    /**
     * Kumpulkan item yang akan dibeli dari keranjang atau beli sekarang.
     * Mengembalikan array item, atau array ['error' => ..., 'code' => ...] jika gagal.
     */
    private function collectItems(Request $request, int $userId): array
    {
        //Checkout dari keranjang
        if ($request->has('cart_ids') && is_array($request->cart_ids) && count($request->cart_ids) > 0) {
            return $this->collectFromCart($request, $userId);
        }

        //Beli sekarang
        if ($request->has('stok_id')) {
            return $this->collectBuyNow($request);
        }

        return ['error' => 'Tidak ada item yang dipilih untuk checkout.', 'code' => 422];
    }

    /**
     * Kumpulkan item dari keranjang.
     */
    private function collectFromCart(Request $request, int $userId): array
    {
        $keranjangItems = Keranjang::with(['stok.produk', 'stok.ukuran'])
            ->where('user_id', $userId)
            ->whereIn('id', $request->cart_ids)
            ->get();

        if ($keranjangItems->isEmpty()) {
            return ['error' => 'Tidak ada item keranjang yang valid.', 'code' => 422];
        }

        $items = [];

        foreach ($keranjangItems as $k) {
            if (!$k->stok || !$k->stok->produk) continue;

            // Validasi stok mencukupi saat checkout
            if ($k->jumlah > $k->stok->jumlah_stok) {
                return [
                    'error' => 'Stok ' . $k->stok->produk->nama . ' (' . ($k->stok->ukuran?->nama_ukuran ?? '-') . ') tidak mencukupi. Stok tersedia: ' . $k->stok->jumlah_stok,
                    'code'  => 422,
                ];
            }

            $items[] = [
                'keranjang_id' => $k->id,
                'stok_id'      => $k->stok_id,
                'qty'          => $k->jumlah,
                'harga'        => (int) $k->stok->produk->harga,
                'nama'         => $k->stok->produk->nama,
                'ukuran'       => $k->stok->ukuran ? $k->stok->ukuran->nama_ukuran : '-',
            ];
        }

        if (empty($items)) {
            return ['error' => 'Item checkout tidak valid.', 'code' => 422];
        }

        return $items;
    }

    /**
     * Kumpulkan item dari beli sekarang (langsung dari halaman produk).
     */
    private function collectBuyNow(Request $request): array
    {
        $request->validate([
            'stok_id' => 'required|exists:stoks,id',
            'qty'     => 'required|integer|min:1',
        ]);

        $stok = Stok::with(['produk', 'ukuran'])->findOrFail($request->stok_id);

        if (!$stok->produk) {
            return ['error' => 'Produk tidak ditemukan.', 'code' => 422];
        }

        $qty = (int) $request->qty;
        if ($qty > $stok->jumlah_stok) {
            return ['error' => 'Stok tidak mencukupi.', 'code' => 422];
        }

        return [[
            'keranjang_id' => null,
            'stok_id'      => $stok->id,
            'qty'          => $qty,
            'harga'        => (int) $stok->produk->harga,
            'nama'         => $stok->produk->nama,
            'ukuran'       => $stok->ukuran ? $stok->ukuran->nama_ukuran : '-',
        ]];
    }

    /**
     * Proses pembuatan pesanan, detail, pengurangan stok, dan generate Snap Token.
     * Dipanggil di dalam DB::transaction.
     */
    private function processOrder(array $items, int $totalHarga, User $user, Request $request): array
    {
        // Hapus update profile, data pengiriman disimpan khusus di pesanan ini

        $orderId = Pesanan::generateOrderId();

        // 1. Buat record pesanan (snap_token diisi setelah dapat dari Midtrans)
        $pesanan = Pesanan::create([
            'order_id'          => $orderId,
            'user_id'           => $user->id,
            'tanggal_pesanan'   => now(),
            'total_harga'       => $totalHarga,
            'metode_pembayaran' => 'midtrans',
            'status_pembayaran' => 'pending',
            'snap_token'        => null,
            'nama_penerima'     => $request->buyer_name,
            'no_wa_penerima'    => $request->buyer_phone,
            'alamat_penerima'   => $request->buyer_address,
        ]);

        // 2. Buat detail pesanan dan kurangi stok
        foreach ($items as $item) {
            DetailPesanan::create([
                'pesanan_id'   => $pesanan->id,
                'stok_id'      => $item['stok_id'],
                'harga_satuan' => $item['harga'],
                'jumlah'       => $item['qty'],
            ]);

            // Kurangi stok
            Stok::where('id', $item['stok_id'])
                ->decrement('jumlah_stok', $item['qty']);
        }

        // 3. Hapus item keranjang yang sudah dicheckout
        $cartIds = collect($items)->pluck('keranjang_id')->filter()->values()->toArray();
        if (!empty($cartIds)) {
            Keranjang::whereIn('id', $cartIds)->where('user_id', $user->id)->delete();
        }

        // 4. Bangun payload Midtrans
        $itemDetails = collect($items)->map(fn($i) => [
            'id'       => (string) $i['stok_id'],
            'price'    => $i['harga'],
            'quantity' => $i['qty'],
            'name'     => mb_substr($i['nama'] . ' (' . $i['ukuran'] . ')', 0, 50),
        ])->toArray();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalHarga,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $request->buyer_name,
                'phone'      => $request->buyer_phone,
                'billing_address' => [
                    'address' => $request->buyer_address,
                ],
            ],
        ];

        // 5. Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        // 6. Simpan snap_token ke pesanan
        $pesanan->update(['snap_token' => $snapToken]);

        return [$pesanan, $snapToken];
    }

    //Webhook handler dipanggil otomatis oleh server Midtrans setiap kali status transaksi berubah.

    public function notification(Request $request)
    {
        $this->boot();

        try {
            $notif    = new Notification();
            $orderId  = $notif->order_id;
            $status   = $notif->transaction_status;
            $fraud    = $notif->fraud_status ?? null;
            $type     = $notif->payment_type ?? null;

            Log::info('[Midtrans Webhook]', compact('orderId', 'status', 'fraud', 'type'));

            // Ekstrak ID pesanan dari order_id
            $pesanan = Pesanan::where('order_id', $orderId)->first();

            if (!$pesanan) {
                // Fallback: coba cari via prefix PSN-
                $pesananId = (int) substr($orderId, 4);
                $pesanan   = Pesanan::find($pesananId);
            }

            if (!$pesanan) {
                Log::warning('[Midtrans Webhook] Pesanan tidak ditemukan', ['order_id' => $orderId]);
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            // Map status Midtrans menjadi status internal
            $newStatus = match (true) {
                in_array($status, ['capture', 'settlement']) && $fraud !== 'challenge' => 'settlement',
                $status === 'pending'                => 'pending',
                $status === 'cancel'                 => 'cancel',
                $status === 'expire'                 => 'expire',
                default                              => $status,
            };

            $oldStatus = $pesanan->status_pembayaran;

            $pesanan->update([
                'status_pembayaran' => $newStatus,
                'metode_pembayaran' => $type ?? $pesanan->metode_pembayaran,
            ]);

            // Kembalikan stok jika pesanan dibatalkan atau expired via webhook
            if ($oldStatus === 'pending' && in_array($newStatus, ['cancel', 'expire'])) {
                $pesanan->load('detailPesanans');
                $pesanan->restoreStok();
            }

            Log::info('[Midtrans Webhook] Status updated', [
                'pesanan_id' => $pesanan->id,
                'new_status' => $newStatus,
            ]);

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error('[Midtrans Webhook] Exception: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Cek status transaksi secara manual (opsional, bisa dipanggil dari frontend).
    public function checkStatus(Request $request)
    {
        $this->boot();
        $request->validate(['order_id' => 'required|string']);

        try {
            $s = (array) Transaction::status($request->order_id);
            return response()->json([
                'transaction_status' => $s['transaction_status'] ?? null,
                'fraud_status'       => $s['fraud_status'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
