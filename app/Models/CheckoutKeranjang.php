<?php

namespace App\Models;

use Illuminate\Http\Request;

class CheckoutKeranjang extends DasarCheckout
{
    public function collectItems(Request $request, int $userId): array
    {
        if (!is_array($request->cart_ids) || count($request->cart_ids) === 0) {
            return ['error' => 'Tidak ada item keranjang yang dipilih.', 'code' => 422];
        }

        $keranjangItems = Keranjang::with(['stok.produk', 'stok.ukuran'])
            ->where('user_id', $userId)
            ->whereIn('id', $request->cart_ids)
            ->get();

        if ($keranjangItems->isEmpty()) {
            return ['error' => 'Tidak ada item keranjang yang valid.', 'code' => 422];
        }

        $items = [];

        foreach ($keranjangItems as $k) {
            if (!$k->stok || !$k->stok->produk) continue;

            // Validasi ketersediaan stok
            if ($k->jumlah > $k->stok->jumlah_stok) {
                return [
                    'error' => 'Stok ' . $k->stok->produk->nama . ' (' . ($k->stok->ukuran?->nama_ukuran ?? '-') . ') tidak mencukupi. Stok tersedia: ' . $k->stok->jumlah_stok,
                    'code'  => 422,
                ];
            }

            // Panggil method dari parent class
            $items[] = $this->formatItem($k->stok, $k->jumlah, $k->id);
        }

        if (empty($items)) {
            return ['error' => 'Item checkout tidak valid.', 'code' => 422];
        }

        return $items;
    }
}
