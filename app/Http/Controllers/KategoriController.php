<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = [
            [
                'id' => 1,
                'nama' => 'Kemeja',
                'deskripsi' => 'Kemeja wanita formal dan kasual modern',
                'icon' => 'kemeja',
                'produk' => [
                    ['nama' => 'Kemeja Stripe'],
                    ['nama' => 'Kemeja Putih Basic'],
                    ['nama' => 'Kemeja Linen Pita'],
                ],
            ],
            [
                'id' => 2,
                'nama' => 'Gaun',
                'deskripsi' => 'Koleksi gaun sopan dan elegan untuk berbagai acara',
                'icon' => 'gaun',
                'produk' => [
                    ['nama' => 'Gaun Biru Wrap'],
                    ['nama' => 'Gaun Ivory'],
                    ['nama' => 'Gaun Pita Merah'],
                ],
            ],
            [
                'id' => 3,
                'nama' => 'Cardigan',
                'deskripsi' => 'Cardigan rajut dan knit yang lembut dan nyaman',
                'icon' => 'cardigan',
                'produk' => [
                    ['nama' => 'Cardigan Rajut Pink'],
                    ['nama' => 'Cardigan Knit Cream'],
                    ['nama' => 'Cardigan Pita Biru'],
                ],
            ],
            [
                'id' => 4,
                'nama' => 'Rok',
                'deskripsi' => 'Rok feminin dengan berbagai model dan motif',
                'icon' => 'rok',
                'produk' => [
                    ['nama' => 'Rok Layer Putih'],
                    ['nama' => 'Rok Tiered Floral Cream'],
                    ['nama' => 'Rok Ruffle Pita'],
                ],
            ],
        ];

        // Redirect ke halaman product karena list_kategori sudah dihapus
        return redirect()->route('product');
    }
}