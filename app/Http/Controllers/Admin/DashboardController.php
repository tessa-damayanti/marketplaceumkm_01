<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.dashboard', [
            'produk'   => $this->getProdukData(),
            'kategori' => $this->getKategoriData(),
            'pesanan'  => $this->getPesananData(),
        ]);
    }

    private function getProdukData()
    {
        $produks = Produk::with(['kategori', 'stoks.ukuran'])->get();
        $data = [];
        foreach ($produks as $produk) {
            $stokArray = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
            foreach ($produk->stoks as $stok) {
                if ($stok->ukuran) {
                    $stokArray[$stok->ukuran->nama_ukuran] = $stok->jumlah_stok;
                }
            }

            $data[] = [
                'id'          => $produk->id,
                'nama'        => $produk->nama,
                'kategori_id' => $produk->kategori_id,
                'kategori'    => $produk->kategori ? $produk->kategori->nama : '',
                'harga'       => $produk->harga,
                'deskripsi'   => $produk->deskripsi,
                'image'       => $produk->image,
                'stok'        => $stokArray
            ];
        }
        return $data;
    }

    private function getKategoriData()
    {
        return Kategori::orderBy('id', 'asc')->get()->map(function (Kategori $k) {
            return ['id' => $k->id, 'nama' => $k->nama];
        })->toArray();
    }

    private function getPesananData()
    {
        // Sinkronisasi status pesanan
        Pesanan::syncPendingStatuses();

        $pesanans = Pesanan::with([
            'user',
            'detailPesanans.stok.produk',
            'detailPesanans.stok.ukuran',
        ])->orderByDesc('created_at')->get();

        return $pesanans->map(function (Pesanan$p) {
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
                'nama'    => $p->nama_penerima ?? $p->user?->nama_lengkap ?? 'Pembeli',
                'avatar'  => $p->user?->foto_profile
                    ? asset('storage/' . $p->user->foto_profile)
                    : null,
                'hp'      => $p->no_wa_penerima ?? $p->user?->no_wa ?? '-',
                'alamat'  => $p->alamat_penerima ?? $p->user?->alamat ?? '-',
                'status'  => $p->status_label,
                'total'   => $p->total_harga,
                'items'   => $items,
            ];
        })->toArray();
    }
}
