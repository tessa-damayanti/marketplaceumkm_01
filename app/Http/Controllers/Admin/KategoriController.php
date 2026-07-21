<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;   

class KategoriController extends Controller
{
    public function kategori()
    {
        // Hanya admin
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.kategori', [
            'kategori' => $this->getKategoriData(),
        ]);
    }

    // Ambil semua data kategori dari database buat ditampilin di tabel admin.
    private function getKategoriData()
    {
        return Kategori::orderBy('id', 'desc')->get()->map(function ($k) {
            return ['id' => $k->id, 'nama' => $k->nama];
        })->toArray();
    }

    public function storeKategori(Request $request)
    {
        // memastikan yang nambahin data beneran admin
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        //memastikan nama kategori belum pernah dipakai sebelumnya.
        $request->validate([
            'nama' => 'required|string|max:25|unique:kategoris,nama'
        ], [
            'nama.max' => 'Nama kategori maksimal 25 karakter',
            'nama.unique' => 'Nama kategori sudah ada.'
        ]);
        
        // 2. Simpan nama kategori baru ke database.
        $kat = Kategori::create(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function updateKategori(Request $request, $id)
    {
        // Cek akses admin.
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        //  Nama boleh sama asalkan punya kategori sendiri
        $request->validate([
            'nama' => 'required|string|max:25|unique:kategoris,nama,' . $id
        ], [
            'nama.max' => 'Nama kategori maksimal 25 karakter',
            'nama.unique' => 'Nama kategori sudah ada.'
        ]);
        
        // mencari nama kategori terlebi dahulu
        $kat = Kategori::findOrFail($id);
        $kat->update(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function destroyKategori($id)
    {
        // Cek akses admin.
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $kat = Kategori::findOrFail($id);
        
        // tidak bisa dihapus kalau kategori ini masih dipakai sama suatu produk
        if ($kat->produks()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Kategori gagal dihapus karena masih memiliki produk di dalamnya. Silakan pindahkan atau hapus produk terlebih dahulu.'
            ], 400);
        }

        // menghapus produk
        $kat->delete();
        return response()->json(['success' => true]);
    }
}
