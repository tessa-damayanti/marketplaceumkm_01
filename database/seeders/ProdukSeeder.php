<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{

    public function run(): void
    {
        $produks = [
            ['nama' => 'Kemeja Stripe', 'kategori' => 'Kemeja', 'harga' => 100000, 'deskripsi' => 'Kemeja wanita bermotif garis.'],
            ['nama' => 'Gaun Ivory', 'kategori' => 'Gaun', 'harga' => 175000, 'deskripsi' => 'Gaun wanita elegan warna ivory.'],
            ['nama' => 'Cardigan Floral', 'kategori' => 'Cardigan', 'harga' => 118000, 'deskripsi' => 'Cardigan motif bunga cantik.'],
            ['nama' => 'Rok Denim', 'kategori' => 'Rok', 'harga' => 132000, 'deskripsi' => 'Rok denim kasual modern.'],
            ['nama' => 'Gaun Floral Pastel', 'kategori' => 'Gaun', 'harga' => 210000, 'deskripsi' => 'Gaun pastel bermotif floral.'],
            ['nama' => 'Kemeja Hitam', 'kategori' => 'Kemeja', 'harga' => 105000, 'deskripsi' => 'Kemeja polos warna hitam.'],
            ['nama' => 'Cardigan Rajut', 'kategori' => 'Cardigan', 'harga' => 145000, 'deskripsi' => 'Cardigan rajut hangat nyaman.'],
            ['nama' => 'Rok Plisket', 'kategori' => 'Rok', 'harga' => 98000, 'deskripsi' => 'Rok plisket elegan.'],
            ['nama' => 'Blouse Putih', 'kategori' => 'Kemeja', 'harga' => 90000, 'deskripsi' => 'Blouse wanita warna putih polos.'],
            ['nama' => 'Celana Kulot', 'kategori' => 'Rok', 'harga' => 110000, 'deskripsi' => 'Celana kulot bahan jatuh dan nyaman.'],
            ['nama' => 'Tunik Batik', 'kategori' => 'Kemeja', 'harga' => 150000, 'deskripsi' => 'Tunik motif batik modern.'],
            ['nama' => 'Gamis Syari', 'kategori' => 'Gaun', 'harga' => 250000, 'deskripsi' => 'Gamis lengkap dengan hijab.'],
            ['nama' => 'Kemeja Flanel', 'kategori' => 'Kemeja', 'harga' => 125000, 'deskripsi' => 'Kemeja flanel kotak-kotak.'],
            ['nama' => 'Jaket Jeans', 'kategori' => 'Cardigan', 'harga' => 195000, 'deskripsi' => 'Jaket bahan denim tebal.'],
            ['nama' => 'Rok Span', 'kategori' => 'Rok', 'harga' => 85000, 'deskripsi' => 'Rok span formal.'],
            ['nama' => 'Dress Pesta', 'kategori' => 'Gaun', 'harga' => 300000, 'deskripsi' => 'Dress mewah untuk ke pesta.'],
            ['nama' => 'Sweater Oversize', 'kategori' => 'Cardigan', 'harga' => 140000, 'deskripsi' => 'Sweater ukuran besar yang nyaman.'],
            ['nama' => 'Kemeja Kerja', 'kategori' => 'Kemeja', 'harga' => 115000, 'deskripsi' => 'Kemeja formal untuk ngantor.'],
            ['nama' => 'Rok Tutu', 'kategori' => 'Rok', 'harga' => 120000, 'deskripsi' => 'Rok model tutu yang lucu.'],
            ['nama' => 'Cardigan Panjang', 'kategori' => 'Cardigan', 'harga' => 160000, 'deskripsi' => 'Cardigan panjang sampai lutut.'],
        ];

        $i = 1;
        foreach ($produks as $produk) {
            $produk['image'] = 'produk' . $i . '.jpg';
            \App\Models\Produk::create($produk);
            $i++;
            if ($i > 3) $i = 1;
        }
    }
}       
