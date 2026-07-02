<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function produk()
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.produk', [
            'produk' => $this->getProdukData(),
            'kategori' => $this->getKategoriData(),
        ]);
    }

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

    private function getKategoriData()
    {
        return \App\Models\Kategori::orderBy('id', 'asc')->get()->map(function ($k) {
            return ['id' => $k->id, 'nama' => $k->nama];
        })->toArray();
    }

    public function storeProduk(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nama' => 'required|string|max:30|unique:produks,nama',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama.unique' => 'Nama produk sudah ada.',
            'image.image' => 'File harus berupa foto/gambar.',
            'image.mimes' => 'Format foto harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran foto tidak boleh lebih dari 2MB.'
        ]);

        $data = $request->only(['nama', 'kategori_id', 'harga', 'deskripsi']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $produk = Produk::create($data);

        $ukurans = \App\Models\Ukuran::all();
        foreach ($ukurans as $ukuran) {
            \App\Models\Stok::create([
                'produk_id' => $produk->id,
                'ukuran_id' => $ukuran->id,
                'jumlah_stok' => 0
            ]);
        }

        $produk->load(['kategori', 'stoks.ukuran']);

        $stokArray = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
        foreach ($produk->stoks as $stok) {
            if ($stok->ukuran) {
                $stokArray[$stok->ukuran->nama_ukuran] = $stok->jumlah_stok;
            }
        }

        $produkData = [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'kategori_id' => $produk->kategori_id,
            'kategori' => $produk->kategori ? $produk->kategori->nama : '',
            'harga' => $produk->harga,
            'deskripsi' => $produk->deskripsi,
            'image' => $produk->image,
            'stok' => $stokArray
        ];

        return response()->json(['success' => true, 'produk' => $produkData]);
    }

    public function updateProduk(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nama' => 'required|string|max:30|unique:produks,nama,' . $id,
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama.unique' => 'Nama produk sudah ada.',
            'image.image' => 'File harus berupa foto/gambar.',
            'image.mimes' => 'Format foto harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran foto tidak boleh lebih dari 2MB.'
        ]);

        $produk = Produk::findOrFail($id);
        $data = $request->only(['nama', 'kategori_id', 'harga', 'deskripsi']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            
            if ($produk->image && file_exists(public_path('images/' . $produk->image))) {
                unlink(public_path('images/' . $produk->image));
            }
            
            $data['image'] = $filename;
        }

        $produk->update($data);

        $produk->load(['kategori', 'stoks.ukuran']);

        $stokArray = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
        foreach ($produk->stoks as $stok) {
            if ($stok->ukuran) {
                $stokArray[$stok->ukuran->nama_ukuran] = $stok->jumlah_stok;
            }
        }

        $produkData = [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'kategori_id' => $produk->kategori_id,
            'kategori' => $produk->kategori ? $produk->kategori->nama : '',
            'harga' => $produk->harga,
            'deskripsi' => $produk->deskripsi,
            'image' => $produk->image,
            'stok' => $stokArray
        ];

        return response()->json(['success' => true, 'produk' => $produkData]);
    }

    public function destroyProduk($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $produk = Produk::findOrFail($id);

        $totalStok = $produk->stoks()->sum('jumlah_stok');
        if ($totalStok > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal dihapus karena masih memiliki stok sebanyak ' . $totalStok . ' item. Silakan kosongkan stok terlebih dahulu.'
            ], 400);
        }

        $produk->delete();
        return response()->json(['success' => true]);
    }
}
