<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.string' => 'Nomor WhatsApp harus berupa teks.',
            'phone.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berupa gambar JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);

        $user = User::find(Auth::id());
        
        $user->nama_lengkap = $request->name;
        $user->no_wa = $request->phone;
        $user->alamat = $request->address;

        if ($request->hasFile('profile_photo')) {
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }
            
            $path = $request->file('profile_photo')->store('profile', 'public');
            $user->foto_profile = $path;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}

