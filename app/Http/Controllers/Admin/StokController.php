<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class StokController extends Controller
{
    public function stok()
    {
        // cek akses admin
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.stok', [
            'produk' => $this->getProdukData(),
        ]);
    }

    // Ambil data produk sekalian kategori & stoknya buat ditampilin di tabel stok admin.
    private function getProdukData()
    {
        $produks = Produk::with(['kategori', 'stoks.ukuran'])->orderBy('id', 'desc')->get();
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
                'kategori_id' => $produk->kategori_id,
                'kategori' => $produk->kategori ? $produk->kategori->nama : '',
                'harga' => $produk->harga,
                'deskripsi' => $produk->deskripsi,
                'image' => $produk->image,
                'stok' => $stokArray
            ];
        }
        return $data;
    }

    public function updateStok(Request $request, $produk_id)
    {
        // Cek akses admin
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        //memastikan semua ukuran (S, M, L, XL) diisi angka dan minimal 0
        $request->validate([
            'S' => 'required|integer|min:0',
            'M' => 'required|integer|min:0',
            'L' => 'required|integer|min:0',
            'XL' => 'required|integer|min:0',
        ]);

        // menyimpan atau Update stok tiap ukuran ke database.
        $sizes = ['S', 'M', 'L', 'XL'];
        foreach ($sizes as $size) {
            $ukuran = \App\Models\Ukuran::where('nama_ukuran', $size)->first();
            if ($ukuran) {
                //mengupdate data stok
                \App\Models\Stok::updateOrCreate(
                    ['produk_id' => $produk_id, 'ukuran_id' => $ukuran->id],
                    ['jumlah_stok' => $request->$size]
                );
            }
        }

        return response()->json(['success' => true]);
    }
}
