<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

Route::view('/', 'home');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/product', 'product');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::redirect('/login', '/admin/login')->name('login');
Route::redirect('/dashboard', '/admin/dashboard');

Route::get('/kategori', [KategoriController::class, 'index']);  
Route::get('/kategori/{nama}', [KategoriController::class, 'show']);
Route::get('/praktikum', [KategoriController::class, 'tampilkan']);
