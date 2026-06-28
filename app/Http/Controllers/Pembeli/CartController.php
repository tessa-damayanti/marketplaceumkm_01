<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang //
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil semua item keranjang //
        $dbCart = Keranjang::with(['stok.produk.kategori', 'stok.ukuran', 'stok.produk.stoks.ukuran'])
            ->where('user_id', Auth::id())
            ->get();

        $cartItems = [];
        foreach ($dbCart as $item) {
            if (!$item->stok || !$item->stok->produk) {
                continue;
            }

            $p       = $item->stok->produk;
            $catName = $p->kategori ? $p->kategori->nama : 'Lainnya';

            $sizes = [];

             // Mengambil seluruh pilihan ukuran yang tersedia pada produk //
            foreach ($p->stoks as $stok) {
                if ($stok->ukuran) {
                    $sizes[] = [
                        'stok_id' => $stok->id,
                        'size'    => $stok->ukuran->nama_ukuran,
                        'stock'   => $stok->jumlah_stok,
                    ];
                }
            }

            $cartItems[$item->id] = [
                'id'       => $item->id,
                'stok_id'  => $item->stok_id,
                'name'     => $p->nama,
                'category' => $catName,
                'image'    => $p->image
                                ? asset('images/' . $p->image)
                                : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'price'    => (int) $p->harga,
                'size'     => $item->stok->ukuran ? $item->stok->ukuran->nama_ukuran : 'M',
                'qty'      => $item->jumlah,
                'stock'    => $item->stok->jumlah_stok,
                'sizes'    => $sizes,
            ];
        }

        return view('pages.cart', compact('cartItems'));
    }

    // Menambahkan produk ke keranjang //
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'stok_id' => 'required|exists:stoks,id',
            'qty'     => 'required|integer|min:1',
        ]);

        $stok   = Stok::with('produk')->findOrFail($request->stok_id);
        $userId = Auth::id();

        // Mengecek produk dengan ukuran yang sama sudah ada di keranjang //
        $cartItem = Keranjang::where('user_id', $userId)
            ->where('stok_id', $request->stok_id)
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada, tambahkan jumlahnya //
            $newQty = $cartItem->jumlah + $request->qty;
            if ($newQty > $stok->jumlah_stok) {
                $newQty = $stok->jumlah_stok;
            }
            $cartItem->update([
                'jumlah'   => $newQty,
                'subtotal' => $newQty * $stok->produk->harga,
            ]);
        } else {
            // Jika produk belum ada, buat data keranjang baru //
            $qty = $request->qty;
            if ($qty > $stok->jumlah_stok) {
                $qty = $stok->jumlah_stok;
            }
            Keranjang::create([
                'user_id'  => $userId,
                'stok_id'  => $request->stok_id,
                'jumlah'   => $qty,
                'subtotal' => $qty * $stok->produk->harga,
            ]);
        }

        if ($request->redirect_to === 'cart') {
            return redirect()
                ->route('cart')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    // Menghapus item dari keranjang //
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        Keranjang::where('user_id', Auth::id())
            ->where('id', $request->key)
            ->delete();

        return redirect()->route('cart');
    }

    // Mengubah jumlah item di keranjang//
    public function update(Request $request)
    {
        if (!Auth::check()) {

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil item keranjang beserta data stok dan produk //
        $cartItem = Keranjang::with('stok.produk')
            ->where('user_id', Auth::id())
            ->where('id', $request->key)
            ->first();

        if (!$cartItem) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Item not found'], 404);
            }
            return redirect()->route('cart');
        }

        $stokMax      = $cartItem->stok->jumlah_stok; 
        $limitReached = false;
        $newQty       = $cartItem->jumlah;

        //  Menambah jumlah produk di keranjang //
        if ($request->action === 'plus') {
            if ($cartItem->jumlah < $stokMax) {
                // Jika stok masih tersedia, tambahkan jumlah produk dan perbarui data keranjang //
                $newQty = $cartItem->jumlah + 1;
                $cartItem->update([
                    'jumlah'   => $newQty,
                    'subtotal' => $newQty * $cartItem->stok->produk->harga,
                ]);
            } else {
                // Ketika stok sudah mencapai batas maksimal, tidak bisa tambah qty lagi //
                $limitReached = true;
                if (!$request->expectsJson()) {
                    return back()->with('limit_reached', $request->key);
                }
            }

        // Mengurangi jumlah produk di keranjang //
        } elseif ($request->action === 'minus') {
            if ($cartItem->jumlah > 1) {
                $newQty = $cartItem->jumlah - 1;
                $cartItem->update([
                    'jumlah'   => $newQty,
                    'subtotal' => $newQty * $cartItem->stok->produk->harga,
                ]);
            }
        }

        if ($request->expectsJson()) {
            $allItems = Keranjang::with('stok.produk')
                ->where('user_id', Auth::id())
                ->get();

            // Hitung total harga //
            $grandTotal = $allItems->filter(fn($i) => $i->stok && $i->stok->jumlah_stok > 0)
                ->sum(fn($i) => $i->jumlah * $i->stok->produk->harga);

            return response()->json([
                'qty'           => $newQty,                                      
                'subtotal'      => $newQty * $cartItem->stok->produk->harga,
                'price'         => (int) $cartItem->stok->produk->harga,
                'grand_total'   => $grandTotal,
                'limit_reached' => $limitReached,
            ]);
        }

        // Redirect kembali ke halaman keranjang //
        return redirect()->route('cart');
    }
}
