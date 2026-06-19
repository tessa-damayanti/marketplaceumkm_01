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

        /** @var User $user */
        $user   = Auth::user();
        $userId = $user->id;

        // Kumpulkan item checkout
        if ($request->has('cart_ids') && is_array($request->cart_ids) && count($request->cart_ids) > 0) {
            $strategy = new \App\Models\CheckoutKeranjang();
        } elseif ($request->has('stok_id')) {
            $strategy = new \App\Models\CheckoutLangsung();
        } else {
            return response()->json(['error' => 'Tidak ada item yang dipilih untuk checkout.'], 422);
        }

        $result = $strategy->collectItems($request, $userId);

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
            $fraudStatus       = $raw['fraud_status'] ?? null;
            $paymentType       = $raw['payment_type'] ?? null;

            // Update status di database
            if ($transactionStatus && $transactionStatus !== 'pending') {
                $pesanan = \App\Models\Pesanan::where('order_id', $request->order_id)->first();

                if ($pesanan && $pesanan->status_pembayaran === 'pending') {
                    $newStatus = match (true) {
                        in_array($transactionStatus, ['capture', 'settlement']) && $fraudStatus !== 'challenge' => 'settlement',
                        $transactionStatus === 'cancel'  => 'cancel',
                        $transactionStatus === 'expire'  => 'expire',
                        default                          => $transactionStatus,
                    };

                    $pesanan->update([
                        'status_pembayaran' => $newStatus,
                        'metode_pembayaran' => $paymentType ?? $pesanan->metode_pembayaran,
                    ]);

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
                'fraud_status'       => $fraudStatus,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
