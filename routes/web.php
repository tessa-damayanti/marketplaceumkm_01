<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'pages.home')->name('home');
Route::view('/home', 'pages.home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/product', 'pages.product')->name('product');
Route::view('/cart', 'pages.keranjang')->name('cart');
Route::view('/checkout', 'pages.checkout')->name('checkout');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');