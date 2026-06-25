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
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'stok_id');
    }
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'stok_id');
    }
}
