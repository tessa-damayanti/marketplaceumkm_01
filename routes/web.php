<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [LoginController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/{nama}', [KategoriController::class, 'show']);

Route::get('/dashboard', [DashboardController::class, 'index']);
