<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/checkout', 'pages.checkout')->name('checkout');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Profile & Auth Actions
Route::view('/profile', 'pages.profile')->name('profile');
Route::post('/login', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Auth Views
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/produk', [DashboardController::class, 'produk'])->name('admin.produk');
    Route::get('/kategori', [DashboardController::class, 'kategori'])->name('admin.kategori');
    Route::get('/stok', [DashboardController::class, 'stok'])->name('admin.stok');
    Route::get('/pesanan', [DashboardController::class, 'pesanan'])->name('admin.pesanan');
});

// Legacy — redirect old routes
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');