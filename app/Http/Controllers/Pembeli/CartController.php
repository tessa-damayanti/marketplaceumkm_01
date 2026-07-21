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
            if (!$item->stok || !$item->stok->produk || $item->stok->produk->trashed()) {
                continue;
            }

            $p       = $item->stok->produk;
            $catName = $p->kategori ? $p->kategori->nama : 'Lainnya';

            $sizes = [];
            $stockMap = [];
            $stokIds  = [];

            // Mengambil seluruh pilihan ukuran yang tersedia pada produk //
            foreach ($p->stoks as $stok) {
                if ($stok->ukuran) {
                    $namaUkuran = $stok->ukuran->nama_ukuran;
                    $sizes[]             = [
                        'stok_id' => $stok->id,
                        'size'    => $namaUkuran,
                        'stock'   => $stok->jumlah_stok,
                    ];
                    $stockMap[$namaUkuran] = $stok->jumlah_stok;
                    $stokIds[$namaUkuran]  = $stok->id;
                }
            }

            // Membuat data produk untuk modal detail //
            $productModalData = [
                'name'     => $p->nama,
                'category' => $catName,
                'image'    => $p->image
                    ? asset('images/' . $p->image)
                    : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'desc'     => $p->deskripsi,
                'sizes'    => array_keys($stokIds),
                'stock'    => $stockMap,
                'stok_ids' => $stokIds,
                'price'    => number_format($p->harga, 0, ',', '.'),
            ];

            // Membuat data produk keranjang //
            $cartItems[$item->id] = [
                'id'                => $item->id,
                'stok_id'           => $item->stok_id,
                'name'              => $p->nama,
                'category'          => $catName,
                'image'             => $p->image
                    ? asset('images/' . $p->image)
                    : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'price'             => (int) $p->harga,
                'size'              => $item->stok->ukuran ? $item->stok->ukuran->nama_ukuran : 'M',
                'qty'               => $item->jumlah,
                'stock'             => $item->stok->jumlah_stok,
                'sizes'             => $sizes,
                'product_modal_data' => $productModalData,
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
        if (!$stok->produk || $stok->produk->trashed()) {
            return back()->with('error', 'Produk sudah tidak tersedia.');
        }
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

    // Menghapus produk dari keranjang //
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

    // Mengubah jumlah produk di keranjang//
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

    // Mengubah ukuran produk pada keranjang //
    public function updateSize(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'cart_item_id' => 'required|integer',
            'stok_id'      => 'required|exists:stoks,id',
            'qty'          => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        // Cari produk di keranjang yang ingin diubah ukurannya //
        $cartItem = Keranjang::with('stok.produk')
            ->where('user_id', $userId)
            ->where('id', $request->cart_item_id)
            ->first();

        if (!$cartItem) {
            return redirect()->route('cart')->with('error', 'Item keranjang tidak ditemukan.');
        }

        $newStok = Stok::with('produk')->findOrFail($request->stok_id);

        // Jika ukuran tidak berubah, tidak perlu update //
        if ($cartItem->stok_id == $request->stok_id) {
            return redirect()->route('cart')->with('success', 'Ukuran produk tidak berubah.');
        }

        // Memastikan ukuran yang dipilih berbeda dari ukuran sebelumnya //
        $existingItem = Keranjang::where('user_id', $userId)
            ->where('stok_id', $request->stok_id)
            ->where('id', '!=', $cartItem->id)
            ->first();

        $qty = (int) $request->qty;

        if ($existingItem) {
            // Menggabungkan jumlah produk jika ukuran sudah ada di keranjang //
            $newQty = $existingItem->jumlah + $qty;
            if ($newQty > $newStok->jumlah_stok) {
                $newQty = $newStok->jumlah_stok;
            }
            $existingItem->update([
                'jumlah'   => $newQty,
                'subtotal' => $newQty * $newStok->produk->harga,
            ]);
            // Hapus produk lama setelah jumlah digabung//
            $cartItem->delete();
        } else {
            // Memperbarui ukuran dan jumlah produk pada keranjang //
            if ($qty > $newStok->jumlah_stok) {
                $qty = $newStok->jumlah_stok;
            }
            $cartItem->update([
                'stok_id'  => $request->stok_id,
                'jumlah'   => $qty,
                'subtotal' => $qty * $newStok->produk->harga,
            ]);
        }

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
}
