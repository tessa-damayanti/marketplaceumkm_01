<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function produk()
    {
        return view('pages.admin.produk');
    }

    public function kategori()
    {
        return view('pages.admin.kategori');
    }

    public function stok()
    {
        return view('pages.admin.stok');
    }

    public function pesanan()
    {
        return view('pages.admin.pesanan');
    }
}
