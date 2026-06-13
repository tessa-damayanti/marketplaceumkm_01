<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['order_id', 'user_id', 'tanggal_pesanan', 'total_harga', 'metode_pembayaran', 'status_pembayaran', 'snap_token'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    //Kembalikan stok semua item pada pesanan ini, saat pesanan dibatalkan atau expired
    public function restoreStok(): void
    {
        foreach ($this->detailPesanans as $detail) {
            \App\Models\Stok::where('id', $detail->stok_id)
                ->increment('jumlah_stok', $detail->jumlah);
        }

        \Illuminate\Support\Facades\Log::info('[Stok] Stok dikembalikan untuk pesanan: ' . $this->order_id);
    }

    //Hitung total produk terjual (berhasil) dari produk tertentu
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
        
        $latest = self::where('order_id', 'like', "PSN-{$dateStr}-%")
                      ->orderBy('order_id', 'desc')
                      ->first();
                      
        if ($latest) {
            $lastSequence = (int) substr($latest->order_id, -4);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }
        
        return "PSN-{$dateStr}-" . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
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
                // Handle response Midtrans yang bisa berupa object atau array
                $raw            = \Midtrans\Transaction::status($orderId);
                $statusResponse = is_array($raw) ? $raw : (array) $raw;

                $transactionStatus = $statusResponse['transaction_status'] ?? null;
                $fraudStatus       = $statusResponse['fraud_status'] ?? null;
                $paymentType       = $statusResponse['payment_type'] ?? null;

                if ($transactionStatus && $transactionStatus !== 'pending') {
                    $newStatus = match (true) {
                        in_array($transactionStatus, ['capture', 'settlement']) && $fraudStatus !== 'challenge' => 'settlement',
                        $transactionStatus === 'cancel' => 'cancel',
                        $transactionStatus === 'expire' => 'expire',
                        default                         => $transactionStatus,
                    };

                    $oldStatus = $pesanan->status_pembayaran;
                    $pesanan->update([
                        'status_pembayaran' => $newStatus,
                        'metode_pembayaran' => $paymentType ?? $pesanan->metode_pembayaran,
                    ]);

                    // Kembalikan stok jika pesanan dibatalkan atau expired
                    if ($oldStatus === 'pending' && in_array($newStatus, ['cancel', 'expire'])) {
                        $pesanan->load('detailPesanans');
                        $pesanan->restoreStok();
                    }

                    \Illuminate\Support\Facades\Log::info('[SyncStatus] ' . $orderId . ' diupdate ke: ' . $newStatus);
                }
            } catch (\Throwable $e) {
                // Tangkap semua error termasuk ErrorException dari library Midtrans
                \Illuminate\Support\Facades\Log::warning('[SyncStatus] Gagal cek ' . ($orderId ?? '?') . ': ' . $e->getMessage());
            }
        }
    }
}
