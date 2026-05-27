<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $fillable = ['nama_ukuran'];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'ukuran_id');
    }
}
