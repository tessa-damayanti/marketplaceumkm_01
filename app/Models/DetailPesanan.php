<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans';

    protected $fillable = [
        'pesanan_id',
        'stok_id',
        'harga_satuan',
        'jumlah'
    ];
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }
}
