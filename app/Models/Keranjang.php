<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = ['user_id', 'stok_id', 'jumlah', 'subtotal'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }
}
