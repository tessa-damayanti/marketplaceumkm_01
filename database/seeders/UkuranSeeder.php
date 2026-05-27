<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ukuran;

class UkuranSeeder extends Seeder
{
    public function run(): void
    {
        $ukurans = ['S', 'M', 'L', 'XL'];
        foreach ($ukurans as $ukuran) {
            Ukuran::create(['nama_ukuran' => $ukuran]);
        }
    }
}