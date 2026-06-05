<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\ProductController;
use App\Http\Controllers\Pembeli\CheckoutController;
use App\Http\Controllers\Pembeli\ProfileController;
// Public routes
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/checkout', function () {
    if (session('role') !== 'buyer') {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk checkout.');
    }
    return view('pages.checkout');
})->name('checkout');
Route::post('/checkout/charge',  [CheckoutController::class, 'charge'])->name('checkout.charge');
Route::post('/checkout/status',  [CheckoutController::class, 'checkStatus'])->name('checkout.status');


// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/login', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Auth Views
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'registerSubmit'])->name('register.submit');

Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'forgotPasswordSubmit'])->name('password.email');

Route::get('/reset-password/{token}', [LoginController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPasswordSubmit'])->name('password.update');

//Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/produk', [AdminProdukController::class, 'produk'])->name('admin.produk');
    Route::get('/kategori', [AdminKategoriController::class, 'kategori'])->name('admin.kategori');
    Route::post('/kategori', [AdminKategoriController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'updateKategori'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroyKategori'])->name('admin.kategori.destroy');
    Route::post('/produk', [AdminProdukController::class, 'storeProduk'])->name('admin.produk.store');
    Route::post('/produk/{id}', [AdminProdukController::class, 'updateProduk'])->name('admin.produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroyProduk'])->name('admin.produk.destroy');
    Route::get('/stok', [StokController::class, 'stok'])->name('admin.stok');
    Route::put('/stok/{produk_id}', [StokController::class, 'updateStok'])->name('admin.stok.update');
    Route::get('/pesanan', [PesananController::class, 'pesanan'])->name('admin.pesanan');
});

// Legacy — redirect old routes
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');