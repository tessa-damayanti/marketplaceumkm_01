<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('pages.cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|string',
            'price' => 'required|integer',
            'size' => 'required|string',
            'qty' => 'required|integer|min:1',
            'stock' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        $key = md5($request->name . '-' . $request->size);

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $request->qty;

            if ($cart[$key]['qty'] > $cart[$key]['stock']) {
                $cart[$key]['qty'] = $cart[$key]['stock'];
            }
        } else {
            $cart[$key] = [
                'name' => $request->name,
                'category' => $request->category,
                'image' => $request->image,
                'price' => (int) $request->price,
                'size' => $request->size,
                'qty' => (int) $request->qty,
                'stock' => (int) $request->stock,
            ];
        }

        session()->put('cart', $cart);

        if ($request->redirect_to === 'cart') {
            return redirect()
                ->route('cart')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            if ($request->action === 'plus') {
                if ($cart[$request->key]['qty'] < $cart[$request->key]['stock']) {
                    $cart[$request->key]['qty']++;
                } else {
                    return back()->with('limit_reached', $request->key);
                }
            }

            if ($request->action === 'minus') {
                if ($cart[$request->key]['qty'] > 1) {
                    $cart[$request->key]['qty']--;
                }
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart');
    }
}