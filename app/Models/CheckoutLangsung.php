<?php

namespace App\Models;

use Illuminate\Http\Request;

class CheckoutLangsung extends DasarCheckout
{
    public function collectItems(Request $request, int $userId): array
    {
        $request->validate([
            'stok_id' => 'required|exists:stoks,id',
            'qty'     => 'required|integer|min:1',
        ]);

        $stok = Stok::with(['produk', 'ukuran'])->findOrFail($request->stok_id);

        if (!$stok->produk) {
            return ['error' => 'Produk tidak ditemukan.', 'code' => 422];
        }

        $qty = (int) $request->qty;
        if ($qty > $stok->jumlah_stok) {
            return ['error' => 'Stok tidak mencukupi.', 'code' => 422];
        }

        // Panggil method dari parent class
        return [
            $this->formatItem($stok, $qty, null)
        ];
    }
}
