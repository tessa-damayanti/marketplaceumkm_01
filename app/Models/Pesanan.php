<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'order_id',
        'user_id',
        'tanggal_pesanan',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'snap_token',
        'nama_penerima',
        'no_wa_penerima',
        'alamat_penerima'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    //Kembalikan stok produk, jika pesanan dibatalkan atau expired
    public function restoreStok(): void
    {
        foreach ($this->detailPesanans as $detail) {
            \App\Models\Stok::where('id', $detail->stok_id)
                ->increment('jumlah_stok', $detail->jumlah);
        }

        \Illuminate\Support\Facades\Log::info('[Stok] Stok dikembalikan untuk pesanan: ' . $this->order_id);
    }

    //Kirim notifikasi WhatsApp via Fonnte
    public function sendWhatsAppNotification(): void
    {
        $token = env('FONNTE_TOKEN');
        if (!$token || !$this->no_wa_penerima) {
            return;
        }

        $namaPembeli = $this->nama_penerima ?? ($this->user ? $this->user->name : 'Pelanggan');
        
        $message = "Halo {$namaPembeli},\n\nPembayaran pesanan {$this->order_id} telah berhasil kami terima.\n\nPesanan Anda akan segera kami siapkan.\n\nTerima kasih telah berbelanja di Velora.";

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $this->no_wa_penerima,
                'message' => $message,
                'countryCode' => '62',
            ]);

            \Illuminate\Support\Facades\Log::info('[Fonnte] Notifikasi WA dikirim untuk pesanan ' . $this->order_id . ' - Status: ' . $response->status());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[Fonnte] Gagal mengirim WA untuk pesanan ' . $this->order_id . ': ' . $e->getMessage());
        }
    }

    //Hitung total produk terjual
    public static function getTotalSold(int $produkId): int
    {
        return (int) \App\Models\DetailPesanan::whereHas('pesanan', fn($q) => $q->where('status_pembayaran', 'settlement'))
            ->whereHas('stok', fn($q) => $q->where('produk_id', $produkId))
            ->sum('jumlah');
    }

    public function getStatusLabelAttribute(): string
    {
        $mapping = [
            'pending'    => 'Menunggu Pembayaran',
            'settlement' => 'Pembayaran Berhasil',
            'expire'     => 'Pembayaran Kedaluwarsa',
            'cancel'     => 'Pembayaran Dibatalkan',
        ];

        return $mapping[$this->status_pembayaran] ?? $this->status_pembayaran;
    }

    public static function generateOrderId(): string
    {
        $dateStr = now()->format('ymd');
        $kodeAcak = strtoupper(substr(uniqid(), -4));
        return "PSN-{$dateStr}-{$kodeAcak}";
    }

    public static function syncPendingStatuses(): void
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
        \Midtrans\Config::$curlOptions  = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER     => [],
        ];

        $pendingPesanans = self::where('status_pembayaran', 'pending')->get();

        foreach ($pendingPesanans as $pesanan) {
            try {
                $orderId = $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT);
                // Handle response Midtrans
                $raw            = \Midtrans\Transaction::status($orderId);
                $statusResponse = is_array($raw) ? $raw : (array) $raw;

                $transactionStatus = $statusResponse['transaction_status'] ?? null;
                $paymentType       = $statusResponse['payment_type'] ?? null;

                if ($transactionStatus && $transactionStatus !== 'pending') {
                    $newStatus = match (true) {
                        in_array($transactionStatus, ['capture', 'settlement']) => 'settlement',
                        $transactionStatus === 'cancel' => 'cancel',
                        $transactionStatus === 'expire' => 'expire',
                        default                         => $transactionStatus,
                    };

                    $oldStatus = $pesanan->status_pembayaran;
                    $pesanan->update([
                        'status_pembayaran' => $newStatus,
                        'metode_pembayaran' => $paymentType ?? $pesanan->metode_pembayaran,
                    ]);

                    // Kirim notifikasi jika status berubah menjadi settlement
                    if ($oldStatus === 'pending' && $newStatus === 'settlement') {
                        $pesanan->sendWhatsAppNotification();
                    }

                    // Kembalikan stok jika pesanan dibatalkan atau expired
                    if ($oldStatus === 'pending' && in_array($newStatus, ['cancel', 'expire'])) {
                        $pesanan->load('detailPesanans');
                        $pesanan->restoreStok();
                    }

                    \Illuminate\Support\Facades\Log::info('[SyncStatus] ' . $orderId . ' diupdate ke: ' . $newStatus);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('[SyncStatus] Gagal cek ' . ($orderId ?? '?') . ': ' . $e->getMessage());

                // Fallback: Jika gagal cek ke Midtrans tapi waktu pesanan sudah lewat 24 jam
                $expiryAt = \Carbon\Carbon::parse($pesanan->created_at)->addHours(24);
                if (now()->greaterThanOrEqualTo($expiryAt)) {
                    $pesanan->load('detailPesanans');
                    $pesanan->update(['status_pembayaran' => 'expire']);
                    $pesanan->restoreStok();
                    \Illuminate\Support\Facades\Log::info('[SyncStatus] Fallback: ' . $orderId . ' otomatis expired karena lewat 24 jam.');
                }
            }
        }
    }
}
