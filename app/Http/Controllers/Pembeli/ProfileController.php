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
    public function index(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $user = Auth::user();

        // Sinkronisasi status pembayaran
        Pesanan::syncPendingStatuses();

        $status = $request->query('status', 'all');

        $query = Pesanan::with(['detailPesanans.stok.produk', 'detailPesanans.stok.ukuran'])
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMonths(3));

        if ($status !== 'all') {
            $query->where('status_pembayaran', $status);
        }

        $pesanans = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        return view('pages.profile', compact('user', 'pesanans', 'status'));
    }

    public function update(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses profil.');
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 25 karakter.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'phone.digits_between' => 'Nomor WhatsApp harus antara 12 hingga 15 digit.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berupa gambar JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ];

        $request->validate([
            'name' => 'required|string|max:25',
            'phone' => 'required|numeric|digits_between:10,15',
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

        return redirect()->route('profile', ['tab' => 'akun'])->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        if (session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'old_password' => ['required', 'current_password'],
            'new_password' => 'required|min:6|different:old_password',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Password lama wajib diisi.',
            'old_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'new_password_confirmation.same' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile', ['tab' => 'password'])
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = User::find(Auth::id());

        $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile', ['tab' => 'password'])->with('success', 'Password berhasil diperbarui.');
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
           
        }

        $pesanan->load('detailPesanans');
        $pesanan->update(['status_pembayaran' => 'cancel']);

        // Kembalikan stok saat pesanan dibatalkan
        $pesanan->restoreStok();

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
    }

    // Refresh snap_token untuk status Menunggu Pembayaran
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

        // Cek pesanan yang sudah melewati batas 24 jam
        $expiryAt        = \Carbon\Carbon::parse($pesanan->created_at)->addHours(24);
        $remainingMinutes = (int) now()->diffInMinutes($expiryAt, false);

        if ($remainingMinutes <= 0) {
            // Batas waktu habis maka update status Pembayaran Kadaluwarsa dan kembalikan stok
            $pesanan->load('detailPesanans');
            $pesanan->update(['status_pembayaran' => 'expire']);
            $pesanan->restoreStok();
            return response()->json(['error' => 'Batas waktu pembayaran sudah habis. Pesanan dibatalkan.'], 422);
        }

        try {
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;
            Config::$curlOptions  = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER     => [],
            ];

            $user       = $pesanan->user;
            $newOrderId = Pesanan::generateOrderId();

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

            // Waktu pesanan dibuat agar timer tidak reset ke 24 jam
            $params = [
                'transaction_details' => [
                    'order_id'     => $newOrderId,
                    'gross_amount' => (int) $pesanan->total_harga,
                ],
                'item_details'     => $itemDetails,
                'customer_details' => [
                    'first_name'      => $pesanan->nama_penerima ?? $user?->nama_lengkap ?? '-',
                    'phone'           => $pesanan->no_wa_penerima ?? $user?->no_wa ?? '-',
                    'billing_address' => [
                        'address' => $pesanan->alamat_penerima ?? $user?->alamat ?? '-',
                    ],
                ],
                'expiry' => [
                    'start_time' => \Carbon\Carbon::parse($pesanan->created_at)->format('Y-m-d H:i:s O'),
                    'unit'       => 'hours',
                    'duration'   => 24,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan snap_token dan order_id Midtrans terbaru
            $pesanan->update([
                'snap_token' => $snapToken,
                'order_id'   => $newOrderId,
            ]);

            return response()->json([
                'snap_token'        => $snapToken,
                'new_order_id'      => $newOrderId,
                'remaining_minutes' => $remainingMinutes,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal generate token: ' . $e->getMessage()], 500);
        }
    }
}

