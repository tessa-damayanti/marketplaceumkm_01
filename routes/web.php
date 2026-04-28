<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;

Route::view('/', 'pages.home')->name('home');
Route::view('/home', 'pages.home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/product', 'pages.product')->name('product');
Route::view('/checkout', 'pages.checkout')->name('checkout');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/produk', [DashboardController::class, 'produk'])->name('admin.produk');
Route::get('/kategori', [DashboardController::class, 'kategori'])->name('kategori.index');
Route::get('/stok', [DashboardController::class, 'stok'])->name('admin.stok');
Route::get('/pesanan', [DashboardController::class, 'pesanan'])->name('admin.pesanan');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/akun.index', function () {
    return view('buyer.account');
})->name('akun.index');

Route::get('/akun/riwayat', function () {
    return view('buyer.history');
})->name('akun.riwayat');

Route::get('/keluar', function () {
    $role = session('role');

    session()->flush();

    if ($role === 'admin') {
        return redirect()->route('login');
    }

    return redirect()->route('home');
})->name('akun.logout');