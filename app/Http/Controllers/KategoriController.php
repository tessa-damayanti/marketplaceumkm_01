<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = [
            [
                'id'        => 1,
                'nama'      => 'Gaun',
                'deskripsi' => 'Koleksi gaun sopan dan elegan untuk berbagai acara',
                'icon'      => 'gaun',
                'produk'    => [
                    ['nama' => 'Gaun Maxi Floral',    'icon' => 'gaun'],
                    ['nama' => 'Gaun Panjang Elegan',  'icon' => 'gaun'],
                    ['nama' => 'Gaun Midi Formal',     'icon' => 'gaun'],
                ],
            ],
            [
                'id'        => 2,
                'nama'      => 'Kemeja',
                'deskripsi' => 'Kemeja wanita formal dan kasual modern',
                'icon'      => 'kemeja',
                'produk'    => [
                    ['nama' => 'Kemeja Putih Formal',      'icon' => 'kemeja'],
                    ['nama' => 'Kemeja Lengan Panjang',    'icon' => 'kemeja'],
                    ['nama' => 'Kemeja Kasual Wanita',     'icon' => 'kemeja'],
                ],
            ],
            [
                'id'        => 3,
                'nama'      => 'Cardigan',
                'deskripsi' => 'Cardigan rajut hangat dan stylish untuk berbagai kesempatan',
                'icon'      => 'cardigan',
                'produk'    => [
                    ['nama' => 'Cardigan Rajut Coklat', 'icon' => 'cardigan'],
                    ['nama' => 'Cardigan Rajut Krem',   'icon' => 'cardigan'],
                    ['nama' => 'Cardigan Rajut Abu',    'icon' => 'cardigan'],
                ],
            ],
            [
                'id'        => 4,
                'nama'      => 'Rok',
                'deskripsi' => 'Rok wanita berbagai model dan panjang untuk gaya feminin yang anggun',
                'icon'      => 'rok',
                'produk'    => [
                    ['nama' => 'Rok Midi Kasual',   'icon' => 'rok'],
                    ['nama' => 'Rok Plisket Trendy', 'icon' => 'rok'],
                    ['nama' => 'Rok Maxi Elegan',   'icon' => 'rok'],
                ],
            ],
        ];

        return view('list_kategori', compact('kategori'));
    }
}
