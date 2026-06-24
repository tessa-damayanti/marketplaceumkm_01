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

        // Ambil user yang sedang login
        /** @var User $user */
        $user   = Auth::user();
        $userId = $user->id;

        // Kumpulkan item checkout
        if ($request->has('cart_ids') && is_array($request->cart_ids) && count($request->cart_ids) > 0) {
            $keranjangItems = Keranjang::with(['stok.produk', 'stok.ukuran'])
                ->where('user_id', $userId)
                ->whereIn('id', $request->cart_ids)
                ->get();

            if ($keranjangItems->isEmpty()) {
                return response()->json(['error' => 'Tidak ada item keranjang yang valid.'], 422);
            }

            $items = [];
            foreach ($keranjangItems as $k) {
                if (!$k->stok || !$k->stok->produk) continue;

                if ($k->jumlah > $k->stok->jumlah_stok) {
                    return response()->json([
                        'error' => 'Stok ' . $k->stok->produk->nama . ' (' . ($k->stok->ukuran?->nama_ukuran ?? '-') . ') tidak mencukupi. Stok tersedia: ' . $k->stok->jumlah_stok
                    ], 422);
                }

                $items[] = [
                    'keranjang_id' => $k->id,
                    'stok_id'      => $k->stok->id,
                    'qty'          => $k->jumlah,
                    'harga'        => (int) $k->stok->produk->harga,
                    'nama'         => $k->stok->produk->nama,
                    'ukuran'       => $k->stok->ukuran ? $k->stok->ukuran->nama_ukuran : '-',
                ];
            }

            if (empty($items)) {
                return response()->json(['error' => 'Item checkout tidak valid.'], 422);
            }
        } elseif ($request->has('stok_id')) {
            $request->validate([
                'stok_id' => 'required|exists:stoks,id',
                'qty'     => 'required|integer|min:1',
            ]);

            $stok = Stok::with(['produk', 'ukuran'])->findOrFail($request->stok_id);

            if (!$stok->produk) {
                return response()->json(['error' => 'Produk tidak ditemukan.'], 422);
            }

            $qty = (int) $request->qty;
            if ($qty > $stok->jumlah_stok) {
                return response()->json(['error' => 'Stok tidak mencukupi.'], 422);
            }

            $items = [[
                'keranjang_id' => null,
                'stok_id'      => $stok->id,
                'qty'          => $qty,
                'harga'        => (int) $stok->produk->harga,
                'nama'         => $stok->produk->nama,
                'ukuran'       => $stok->ukuran ? $stok->ukuran->nama_ukuran : '-',
            ]];
        } else {
            return response()->json(['error' => 'Tidak ada item yang dipilih untuk checkout.'], 422);
        }

        //Hitung total dan validasi
        $totalHarga = collect($items)->sum(fn($i) => $i['harga'] * $i['qty']);
        $grandTotal = (int) $request->grand_total;

        // Toleransi selisih kecil (misal pembulatan)
        if (abs($totalHarga - $grandTotal) > 100) {
            return response()->json(['error' => 'Total harga tidak sesuai. Silakan refresh halaman.'], 422);
        }

        // 1. Simpan pesanan dan kurangi stok
        /** @var Pesanan $pesanan */
        $pesanan = DB::transaction(fn () => $this->processOrder($items, $totalHarga, $user, $request));

        // 2. Generate Snap Token
        $snapToken = $this->generateSnapToken($pesanan, $items, $request);

        // 3. Simpan snap_token ke pesanan
        $pesanan->update(['snap_token' => $snapToken]);

        Log::info('[Checkout] Pesanan dibuat dan stok dikurangi', [
            'order_id'   => $pesanan->order_id,
            'snap_token' => $snapToken ? 'OK' : 'NULL',
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    //Simpan pesanan, detail, kurangi stok, dan hapus keranjang.
    private function processOrder(array $items, int $totalHarga, User $user, Request $request): Pesanan
    {
        $orderId = Pesanan::generateOrderId();

        // 1. Buat record pesanan (snap_token diisi setelah transaksi selesai)
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

            Log::info('[Stok] Dikurangi', [
                'stok_id'   => $item['stok_id'],
                'dikurangi' => $item['qty'],
            ]);
        }

        // 3. Hapus item keranjang yang sudah dicheckout
        $cartIds = collect($items)->pluck('keranjang_id')->filter()->values()->toArray();
        if (!empty($cartIds)) {
            Keranjang::whereIn('id', $cartIds)->where('user_id', $user->id)->delete();
        }

        return $pesanan;
    }

    //Generate Snap Token Midtrans
    private function generateSnapToken(Pesanan $pesanan, array $items, Request $request): string
    {
        $itemDetails = collect($items)->map(fn($i) => [
            'id'       => (string) $i['stok_id'],
            'price'    => $i['harga'],
            'quantity' => $i['qty'],
            'name'     => mb_substr($i['nama'] . ' (' . $i['ukuran'] . ')', 0, 50),
        ])->toArray();

        // Atur waktu kedaluwarsa berdasarkan waktu pembuatan pesanan
        $params = [
            'transaction_details' => [
                'order_id'     => $pesanan->order_id,
                'gross_amount' => (int) $pesanan->total_harga,
            ],
            'item_details'     => $itemDetails,
            'customer_details' => [
                'first_name'      => $request->buyer_name,
                'phone'           => $request->buyer_phone,
                'billing_address' => [
                    'address' => $request->buyer_address,
                ],
            ],
            'expiry' => [
                'start_time' => \Carbon\Carbon::parse($pesanan->created_at)->format('Y-m-d H:i:s O'),
                'unit'       => 'hours',
                'duration'   => 24,
            ],
        ];

        return Snap::getSnapToken($params);
    }

    //Cek status pembayaran
    public function checkStatus(Request $request)
    {
        $this->boot();
        $request->validate(['order_id' => 'required|string']);

        try {
            $raw = (array) Transaction::status($request->order_id);

            $transactionStatus = $raw['transaction_status'] ?? null;
            $paymentType       = $raw['payment_type'] ?? null;

            // Update status di database
            if ($transactionStatus && $transactionStatus !== 'pending') {
                $pesanan = Pesanan::where('order_id', $request->order_id)->first();

                if ($pesanan && $pesanan->status_pembayaran === 'pending') {
                    $newStatus = match (true) {
                        in_array($transactionStatus, ['capture', 'settlement']) => 'settlement',
                        $transactionStatus === 'cancel'  => 'cancel',
                        $transactionStatus === 'expire'  => 'expire',
                        default                          => $transactionStatus,
                    };

                    $oldStatus = $pesanan->status_pembayaran;
                    
                    $pesanan->update([
                        'status_pembayaran' => $newStatus,
                        'metode_pembayaran' => $paymentType ?? $pesanan->metode_pembayaran,
                    ]);

                    if ($oldStatus === 'pending' && $newStatus === 'settlement') {
                        $pesanan->sendWhatsAppNotification();
                    }

                    // Kembalikan stok jika pesanan dibatalkan atau kadaluwarsa
                    if (in_array($newStatus, ['cancel', 'expire'])) {
                        $pesanan->load('detailPesanans');
                        $pesanan->restoreStok();
                    }

                    Log::info('[CheckStatus] ' . $request->order_id . ' diupdate ke: ' . $newStatus);
                }
            }

            return response()->json([
                'transaction_status' => $transactionStatus,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
