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

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

Route::get('/ririn', function () {
    return view('ririn'); 
});