<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pesanan;
use Midtrans\Config;
use Midtrans\Snap;

class ProfileController extends Controller
{
    public function index()
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $user = Auth::user();

        // Sinkronisasi status pesanan pending dari Midtrans (untuk localhost)
        Pesanan::syncPendingStatuses();

        $pesanans = Pesanan::with(['detailPesanans.stok.produk', 'detailPesanans.stok.ukuran'])
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMonths(3))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.profile', compact('user', 'pesanans'));
    }

    public function update(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 50 karakter.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.string' => 'Nomor WhatsApp harus berupa teks.',
            'phone.max' => 'Nomor WhatsApp maksimal 15 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berupa gambar JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ];

        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
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

    public function updatePassword(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::find(Auth::id());

        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function cancelOrder(int $id)
    {
        if (session('role') !== 'buyer') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pesanan = Pesanan::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->status_pembayaran !== 'pending') {
            return response()->json(['error' => 'Pesanan tidak dapat dibatalkan karena status sudah berubah'], 422);
        }

        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$curlOptions  = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER     => [],
            ];
            $orderId = $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT);
            \Midtrans\Transaction::cancel($orderId);
        } catch (\Exception $e) {
            // Silently ignore if not found in Midtrans
        }

        $pesanan->load('detailPesanans');
        $pesanan->update(['status_pembayaran' => 'cancel']);

        // Kembalikan stok saat pesanan dibatalkan
        $pesanan->restoreStok();

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
    }

    //Refresh generate ulang snap_token untuk pesanan pending. Dipanggil dari frontend ketika token lama sudah kadaluwarsa.
    public function refreshSnapToken(int $id)
    {
        if (session('role') !== 'buyer') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pesanan = Pesanan::with(['detailPesanans.stok.produk', 'detailPesanans.stok.ukuran', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->status_pembayaran !== 'pending') {
            return response()->json(['error' => 'Pesanan sudah tidak dalam status pending'], 422);
        }

        try {
            // Konfigurasi Midtrans
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;
            Config::$curlOptions  = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER     => [],
            ];

            $user    = $pesanan->user;

            // Generate order_id baru menggunakan format custom agar unik di Midtrans
            $newOrderId = Pesanan::generateOrderId();

            // Item details dari detail pesanan
            $itemDetails = $pesanan->detailPesanans->map(function ($d) {
                $produk = $d->stok?->produk;
                $ukuran = $d->stok?->ukuran?->nama_ukuran ?? '-';
                return [
                    'id'       => (string) $d->stok_id,
                    'price'    => (int) ($produk?->harga ?? 0),
                    'quantity' => $d->jumlah,
                    'name'     => mb_substr(($produk?->nama ?? 'Produk') . ' (' . $ukuran . ')', 0, 50),
                ];
            })->toArray();

            $params = [
                'transaction_details' => [
                    'order_id'     => $newOrderId,
                    'gross_amount' => (int) $pesanan->total_harga,
                ],
                'item_details'     => $itemDetails,
                'customer_details' => [
                    'first_name' => $pesanan->nama_penerima ?? $user?->nama_lengkap ?? '-',
                    'phone'      => $pesanan->no_wa_penerima ?? $user?->no_wa ?? '-',
                    'billing_address' => [
                        'address' => $pesanan->alamat_penerima ?? $user?->alamat ?? '-',
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan token baru dan order_id baru ke database
            $pesanan->update([
                'snap_token' => $snapToken,
                'order_id'   => $newOrderId,
            ]);

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal generate token: ' . $e->getMessage()], 500);
        }
    }
}

