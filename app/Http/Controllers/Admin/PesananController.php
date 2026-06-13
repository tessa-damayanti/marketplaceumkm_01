<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function pesanan()
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.pesanan', [
            'pesanan' => $this->getPesananData(),
        ]);
    }

    private function getPesananData()
    {
        // Sinkronisasi status pesanan pending dari Midtrans untuk halaman pesanan
        \App\Models\Pesanan::syncPendingStatuses();

        $pesanans = \App\Models\Pesanan::with([
            'user',
            'detailPesanans.stok.produk',
            'detailPesanans.stok.ukuran',
        ])->orderByDesc('created_at')->get();

        return $pesanans->map(function ($p) {
            $items = $p->detailPesanans->map(function ($d) {
                return [
                    'produk' => $d->stok?->produk?->nama ?? '-',
                    'ukuran' => $d->stok?->ukuran?->nama_ukuran ?? '-',
                    'qty'    => $d->jumlah,
                    'harga'  => (int) $d->harga_satuan,
                    'image'  => ($d->stok?->produk?->image)
                        ? asset('images/' . $d->stok->produk->image)
                        : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                ];
            })->toArray();

            return [
                'id'      => $p->order_id ?? 'PSN-' . str_pad($p->id, 3, '0', STR_PAD_LEFT),
                'raw_order_id' => $p->order_id ?? 'PSN-' . str_pad($p->id, 3, '0', STR_PAD_LEFT),
                'tanggal' => \Carbon\Carbon::parse($p->tanggal_pesanan)->format('d-m-Y'),
                'nama'    => $p->user?->nama_lengkap ?? 'Pembeli',
                'avatar'  => null,
                'hp'      => $p->user?->no_wa ?? '-',
                'alamat'  => $p->user?->alamat ?? '-',
                'status'  => $p->status_label,
                'total'   => $p->total_harga,
                'items'   => $items,
            ];
        })->toArray();
    }
}
