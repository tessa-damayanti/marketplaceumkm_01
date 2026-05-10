<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return [
            ['id' => 'P001', 'nama' => 'Kemeja Stripe', 'kategori' => 'Kemeja', 'harga' => 100000, 'deskripsi' => 'Kemeja wanita bermotif garis.', 'stok' => ['S' => 4, 'M' => 4, 'L' => 4, 'XL' => 4]],
            ['id' => 'P002', 'nama' => 'Gaun Ivory', 'kategori' => 'Gaun', 'harga' => 175000, 'deskripsi' => 'Gaun wanita elegan warna ivory.', 'stok' => ['S' => 3, 'M' => 5, 'L' => 2, 'XL' => 1]],
            ['id' => 'P003', 'nama' => 'Cardigan Floral', 'kategori' => 'Cardigan', 'harga' => 118000, 'deskripsi' => 'Cardigan motif bunga cantik.', 'stok' => ['S' => 6, 'M' => 4, 'L' => 3, 'XL' => 2]],
            ['id' => 'P004', 'nama' => 'Rok Denim', 'kategori' => 'Rok', 'harga' => 132000, 'deskripsi' => 'Rok denim kasual modern.', 'stok' => ['S' => 5, 'M' => 5, 'L' => 4, 'XL' => 3]],
            ['id' => 'P005', 'nama' => 'Gaun Floral Pastel', 'kategori' => 'Gaun', 'harga' => 210000, 'deskripsi' => 'Gaun pastel bermotif floral.', 'stok' => ['S' => 2, 'M' => 4, 'L' => 3, 'XL' => 1]],
            ['id' => 'P006', 'nama' => 'Kemeja Hitam', 'kategori' => 'Kemeja', 'harga' => 105000, 'deskripsi' => 'Kemeja polos warna hitam.', 'stok' => ['S' => 4, 'M' => 4, 'L' => 4, 'XL' => 4]],
            ['id' => 'P007', 'nama' => 'Cardigan Rajut', 'kategori' => 'Cardigan', 'harga' => 145000, 'deskripsi' => 'Cardigan rajut hangat nyaman.', 'stok' => ['S' => 3, 'M' => 5, 'L' => 4, 'XL' => 2]],
            ['id' => 'P008', 'nama' => 'Rok Plisket', 'kategori' => 'Rok', 'harga' => 98000, 'deskripsi' => 'Rok plisket elegan.', 'stok' => ['S' => 5, 'M' => 6, 'L' => 4, 'XL' => 3]],
        ];
    }

    private function getKategoriData()
    {
        return [
            ['id' => 'K001', 'nama' => 'Kemeja'],
            ['id' => 'K002', 'nama' => 'Gaun'],
            ['id' => 'K003', 'nama' => 'Cardigan'],
            ['id' => 'K004', 'nama' => 'Rok'],
        ];
    }

    private function getPesananData()
    {
        return [
            ['id' => 'P001', 'tanggal' => '12-05-2026', 'nama' => 'Citra', 'avatar' => 'https://i.pinimg.com/736x/eb/83/ff/eb83ff83acbc90ed83e255ce196384e8.jpg', 'hp' => '08132244551', 'alamat' => 'Jln. Ahmad Yani No. 22', 'status' => 'Menunggu Verifikasi', 'items' => [['produk' => 'Kemeja Hitam', 'ukuran' => 'L', 'qty' => 1, 'harga' => 105000]]],
            ['id' => 'P002', 'tanggal' => '12-05-2026', 'nama' => 'Ayu Putri', 'avatar' => 'https://i.pinimg.com/736x/92/fa/8b/92fa8bb9ea86031088ec01c66aa26bd6.jpg', 'hp' => '08211234567', 'alamat' => 'Jln. Sudirman No. 45', 'status' => 'Pembayaran Valid', 'items' => [['produk' => 'Gaun Floral Pastel', 'ukuran' => 'M', 'qty' => 1, 'harga' => 210000]]],
            ['id' => 'P003', 'tanggal' => '12-05-2026', 'nama' => 'Dinda', 'hp' => '08567890123', 'alamat' => 'Jln. Merdeka Blok C5', 'status' => 'Pembayaran Ditolak', 'items' => [['produk' => 'Rok Plisket', 'ukuran' => 'S', 'qty' => 1, 'harga' => 98000], ['produk' => 'Cardigan Rajut', 'ukuran' => 'M', 'qty' => 1, 'harga' => 145000]]],
            ['id' => 'P004', 'tanggal' => '11-05-2026', 'nama' => 'Naura', 'avatar' => 'https://i.pinimg.com/736x/48/c1/80/48c18006494e711924f23763202d02d3.jpg', 'hp' => '08129876543', 'alamat' => 'Jln. Pahlawan No. 8', 'status' => 'Menunggu Verifikasi', 'items' => [['produk' => 'Gaun Ivory', 'ukuran' => 'S', 'qty' => 1, 'harga' => 175000]]],
            ['id' => 'P005', 'tanggal' => '11-05-2026', 'nama' => 'Cahya Yanti', 'hp' => '08561234567', 'alamat' => 'Jln. Diponegoro No. 3', 'status' => 'Konfirmasi Ulang', 'items' => [['produk' => 'Kemeja Stripe', 'ukuran' => 'M', 'qty' => 2, 'harga' => 100000]]],
            ['id' => 'P006', 'tanggal' => '10-05-2026', 'nama' => 'Merita Anisa', 'avatar' => 'https://i.pinimg.com/736x/7d/da/3a/7dda3a925e7da5407cb83c71d7a0192b.jpg', 'hp' => '08781234567', 'alamat' => 'Jln. Kenanga No. 12', 'status' => 'Pembayaran Valid', 'items' => [['produk' => 'Cardigan Floral', 'ukuran' => 'L', 'qty' => 1, 'harga' => 118000]]],
        ];
    }
}
