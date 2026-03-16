<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'index']);
use App\Http\Controllers\KategoriController;

Route::get('/kategori',[KategoriController::class,'index']);
Route::get('/kategori/{nama}',[KategoriController::class,'show']);