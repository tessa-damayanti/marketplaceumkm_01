<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'tanggal_pesanan', 'total_harga', 'metode_pembayaran', 'status_pembayaran', 'snap_token'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function getStatusLabelAttribute(): string
    {
        $mapping = [
            'pending'    => 'Menunggu Pembayaran',
            'settlement' => 'Pembayaran Valid',
            'deny'       => 'Pembayaran Ditolak',
            'expire'     => 'Pembayaran Kedaluwarsa',
            'cancel'     => 'Pembayaran Dibatalkan',
        ];

        return $mapping[$this->status_pembayaran] ?? $this->status_pembayaran;
    }
}
