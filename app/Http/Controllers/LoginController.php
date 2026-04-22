<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function showRegister()
    {
        return view('pages.register'); // sesuaikan nama view blade register kamu
    }
}