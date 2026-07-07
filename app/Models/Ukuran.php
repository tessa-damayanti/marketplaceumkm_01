<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $table = 'ukurans';

    protected $fillable = ['nama_ukuran'];

    // satu ukuran bisa nyambung ke BANYAK baris stok
    public function stoks()
    {
        return $this->hasMany(Stok::class, 'ukuran_id');
    }
}
