<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = ['pesanan_id', 'stok_id', 'harga_satuan', 'jumlah', 'status_pembayaran'];
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }
}
