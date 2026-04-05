<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'home');
Route::view('/home', 'home');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/product', 'product');
Route::get('/login', [LoginController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

// route lama dari praktikum sebelumnya
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/{nama}', [KategoriController::class, 'show']);

// route khusus praktikum minggu 4
Route::get('/praktikum', [KategoriController::class, 'tampilkan']);