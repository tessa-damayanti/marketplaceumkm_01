<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $dbCart = Keranjang::with(['stok.produk.kategori', 'stok.ukuran'])
            ->where('user_id', Auth::id())
            ->get();

        $cartItems = [];
        foreach ($dbCart as $item) {
            if (!$item->stok || !$item->stok->produk) {
                continue;
            }
            $p = $item->stok->produk;
            $catName = $p->kategori ? $p->kategori->nama : 'Lainnya';
            
            $cartItems[$item->id] = [
                'id' => $item->id,
                'stok_id' => $item->stok_id,
                'name' => $p->nama,
                'category' => $catName,
                'image' => $p->image ? asset('images/' . $p->image) : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'price' => (int) $p->harga,
                'size' => $item->stok->ukuran ? $item->stok->ukuran->nama_ukuran : 'M',
                'qty' => $item->jumlah,
                'stock' => $item->stok->jumlah_stok,
            ];
        }

        return view('pages.cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'stok_id' => 'required|exists:stoks,id',
            'qty' => 'required|integer|min:1',
        ]);

        $stok = Stok::with('produk')->findOrFail($request->stok_id);
        $userId = Auth::id();

        // Memeriksa produk dengan stok yang dipilih sudah ada di keranjang
        $cartItem = Keranjang::where('user_id', $userId)
            ->where('stok_id', $request->stok_id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->jumlah + $request->qty;
            if ($newQty > $stok->jumlah_stok) {
                $newQty = $stok->jumlah_stok;
            }
            $cartItem->update([
                'jumlah' => $newQty,
                'subtotal' => $newQty * $stok->produk->harga,
            ]);
        } else {
            $qty = $request->qty;
            if ($qty > $stok->jumlah_stok) {
                $qty = $stok->jumlah_stok;
            }
            Keranjang::create([
                'user_id' => $userId,
                'stok_id' => $request->stok_id,
                'jumlah' => $qty,
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

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cartItem = Keranjang::with('stok.produk')
            ->where('user_id', Auth::id())
            ->where('id', $request->key)
            ->first();

        if ($cartItem) {
            $stokMax = $cartItem->stok->jumlah_stok;
            
            if ($request->action === 'plus') {
                if ($cartItem->jumlah < $stokMax) {
                    $newQty = $cartItem->jumlah + 1;
                    $cartItem->update([
                        'jumlah' => $newQty,
                        'subtotal' => $newQty * $cartItem->stok->produk->harga,
                    ]);
                } else {
                    return back()->with('limit_reached', $request->key);
                }
            }

            if ($request->action === 'minus') {
                if ($cartItem->jumlah > 1) {
                    $newQty = $cartItem->jumlah - 1;
                    $cartItem->update([
                        'jumlah' => $newQty,
                        'subtotal' => $newQty * $cartItem->stok->produk->harga,
                    ]);
                }
            }
        }

        return redirect()->route('cart');
    }
}
