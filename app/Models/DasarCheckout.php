<?php

namespace App\Models;

use Illuminate\Http\Request;

abstract class DasarCheckout implements AturanCheckout
{
    /**
     * Format seragam untuk data item pesanan.
     * 
     * @param Stok $stok
     * @param int $qty
     * @param int|null $keranjangId
     * @return array
     */
    protected function formatItem(Stok $stok, int $qty, ?int $keranjangId = null): array
    {
        return [
            'keranjang_id' => $keranjangId,
            'stok_id'      => $stok->id,
            'qty'          => $qty,
            'harga'        => (int) $stok->produk->harga,
            'nama'         => $stok->produk->nama,
            'ukuran'       => $stok->ukuran ? $stok->ukuran->nama_ukuran : '-',
        ];
    }

    // Method abstrak yang wajib diisi oleh class turunan
    abstract public function collectItems(Request $request, int $userId): array;
}
