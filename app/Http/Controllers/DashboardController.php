<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'produk' => $this->getProdukData(),
            'kategori' => $this->getKategoriData(),
            'pesanan' => $this->getPesananData(),
        ]);
    }

    public function produk()
    {
        return view('pages.admin.produk', [
            'produk' => $this->getProdukData(),
            'kategori' => $this->getKategoriData(),
        ]);
    }

    public function kategori()
    {
        return view('pages.admin.kategori', [
            'kategori' => $this->getKategoriData(),
        ]);
    }

    public function stok()
    {
        return view('pages.admin.stok', [
            'produk' => $this->getProdukData(),
        ]);
    }

    public function pesanan()
    {
        return view('pages.admin.pesanan', [
            'pesanan' => $this->getPesananData(),
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
                'id' => $produk->id,
                'nama' => $produk->nama,
                'kategori' => $produk->kategori ? $produk->kategori->nama : '',
                'harga' => $produk->harga,
                'deskripsi' => $produk->deskripsi,
                'image' => $produk->image,
                'stok' => $stokArray
            ];
        }
        return $data;
    }

    private function getKategoriData()
    {
        return Kategori::orderBy('id', 'asc')->get()->map(function ($k) {
            return ['id' => $k->id, 'nama' => $k->nama];
        })->toArray();
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:kategoris,nama']);
        $kat = Kategori::create(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:kategoris,nama,' . $id]);
        $kat = Kategori::findOrFail($id);
        $kat->update(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function destroyKategori($id)
    {
        $kat = Kategori::findOrFail($id);
        $kat->delete();
        return response()->json(['success' => true]);
    }

    private function getPesananData()
    {
        return [
            ['id' => 'ORD-260524-X9Z8', 'tanggal' => '12-05-2026', 'nama' => 'Citra', 'avatar' => 'https://i.pinimg.com/736x/eb/83/ff/eb83ff83acbc90ed83e255ce196384e8.jpg', 'hp' => '08132244551', 'alamat' => 'Jln. Ahmad Yani No. 22', 'status' => 'Menunggu Verifikasi', 'items' => [['produk' => 'Kemeja Hitam', 'ukuran' => 'L', 'qty' => 1, 'harga' => 105000]]],
            ['id' => 'ORD-260524-K4M5', 'tanggal' => '12-05-2026', 'nama' => 'Ayu Putri', 'avatar' => 'https://i.pinimg.com/736x/92/fa/8b/92fa8bb9ea86031088ec01c66aa26bd6.jpg', 'hp' => '08211234567', 'alamat' => 'Jln. Sudirman No. 45', 'status' => 'Pembayaran Valid', 'items' => [['produk' => 'Gaun Floral Pastel', 'ukuran' => 'M', 'qty' => 1, 'harga' => 210000]]],
            ['id' => 'ORD-260524-P2Q3', 'tanggal' => '12-05-2026', 'nama' => 'Dinda', 'hp' => '08567890123', 'alamat' => 'Jln. Merdeka Blok C5', 'status' => 'Pembayaran Ditolak', 'items' => [['produk' => 'Rok Plisket', 'ukuran' => 'S', 'qty' => 1, 'harga' => 98000], ['produk' => 'Cardigan Rajut', 'ukuran' => 'M', 'qty' => 1, 'harga' => 145000]]],
            ['id' => 'ORD-260511-L7N8', 'tanggal' => '11-05-2026', 'nama' => 'Naura', 'avatar' => 'https://i.pinimg.com/736x/48/c1/80/48c18006494e711924f23763202d02d3.jpg', 'hp' => '08129876543', 'alamat' => 'Jln. Pahlawan No. 8', 'status' => 'Menunggu Verifikasi', 'items' => [['produk' => 'Gaun Ivory', 'ukuran' => 'S', 'qty' => 1, 'harga' => 175000]]],
            ['id' => 'ORD-260511-V5W6', 'tanggal' => '11-05-2026', 'nama' => 'Cahya Yanti', 'hp' => '08561234567', 'alamat' => 'Jln. Diponegoro No. 3', 'status' => 'Konfirmasi Ulang', 'items' => [['produk' => 'Kemeja Stripe', 'ukuran' => 'M', 'qty' => 2, 'harga' => 100000]]],
            ['id' => 'ORD-260510-R1S2', 'tanggal' => '10-05-2026', 'nama' => 'Merita Anisa', 'avatar' => 'https://i.pinimg.com/736x/7d/da/3a/7dda3a925e7da5407cb83c71d7a0192b.jpg', 'hp' => '08781234567', 'alamat' => 'Jln. Kenanga No. 12', 'status' => 'Pembayaran Valid', 'items' => [['produk' => 'Cardigan Floral', 'ukuran' => 'L', 'qty' => 1, 'harga' => 118000]]],
        ];
    }
}
