<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Ukuran;
use App\Models\Stok;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $produks = Produk::all();
        $ukurans = Ukuran::all();

        foreach ($produks as $produk) {
            $stokManual = [
                'S'  => 10,
                'M'  => 15,
                'L'  => 20,
                'XL' => 5
            ];

            foreach ($ukurans as $ukuran) {
                Stok::create([
                    'produk_id' => $produk->id,
                    'ukuran_id' => $ukuran->id,
                    'jumlah_stok' => $stokManual[$ukuran->nama_ukuran] ?? 0
                ]);
            }
        }
    }
}