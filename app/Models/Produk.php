<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produks';

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga',
        'deskripsi',
        'image',
    ];

    // Satu produk hanya boleh punya satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    //Satu produk bisa memiliki banyak  stok
    public function stoks()
    {
        return $this->hasMany(Stok::class, 'produk_id');
    }
}
