<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stoks';

    protected $fillable = [
        'produk_id',
        'ukuran_id',
        'jumlah_stok'
    ];
    // Data stok punya satu produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    //Data stok mewakili SATU ukuran tertentu
    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
    //Satu stok bisa dimasukin ke banyak keranjang belanja milik user yang beda-beda
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'stok_id');
    }
    //Satu stok bisa catat di banyak riwayat detail pesanan kalau udah dibeli
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'stok_id');
    }
}
