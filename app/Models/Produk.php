<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga',
        'deskripsi',
        'image',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'produk_id');
    }
}
