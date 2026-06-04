<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = \App\Models\User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'buyer',
        ]);

        return response()->json(['success' => true]);
    }

    public function showForgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'Alamat email tidak ditemukan.'
            ], 404);
        }

        if ($user->role === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Admin tidak diizinkan menggunakan fitur Lupa Password.'
            ], 403);
        }

        $token = \Illuminate\Support\Str::random(60);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => \Illuminate\Support\Facades\Hash::make($token),
                'created_at' => \Carbon\Carbon::now()
            ]
        );

        $resetUrl = route('password.reset', ['token' => $token]) . '?email=' . urlencode($user->email);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($resetUrl));

        return response()->json(['success' => true]);
    }

    public function showResetPassword($token)
    {
        return view('pages.auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                            ->where('email', $request->email)
                            ->first();

        if (!$resetRecord || !\Illuminate\Support\Facades\Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false, 
                'message' => 'Token reset password tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['success' => true]);
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            session(['role' => $role]);

            if ($role === 'admin') {
                return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
            }

            return response()->json(['success' => true, 'redirect' => route('home')]);
        }

        return response()->json(['success' => false, 'message' => 'Username atau password salah'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
