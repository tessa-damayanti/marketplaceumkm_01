<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function loginSubmit(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'admin1' && $password === 'admin123') {
            session(['role' => 'admin']);
            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        if ($username === 'user1' && $password === 'user1234') {
            session(['role' => 'buyer']);
            return response()->json(['success' => true, 'redirect' => route('home')]);
        }

        return response()->json(['success' => false, 'message' => 'Username atau password salah'], 401);
    }

    public function logout()
    {
        session()->forget('role');
        return redirect()->route('home');
    }
}
