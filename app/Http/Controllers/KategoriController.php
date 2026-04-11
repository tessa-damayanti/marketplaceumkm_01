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
                'nama' => 'Gaun',
                'deskripsi' => 'Koleksi gaun sopan dan elegan untuk berbagai acara',
                'icon' => 'gaun',
            ],
            [
                'id' => 2,
                'nama' => 'Kemeja',
                'deskripsi' => 'Kemeja wanita formal dan kasual modern',
                'icon' => 'kemeja',
            ],
        ];

        return view('pages.list_kategori', compact('kategori'));
    }
}