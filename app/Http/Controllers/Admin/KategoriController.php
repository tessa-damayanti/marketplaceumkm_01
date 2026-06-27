<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function kategori()
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('pages.admin.kategori', [
            'kategori' => $this->getKategoriData(),
        ]);
    }

    //mengambil data kategori di database untuk ditampilkan di halaman admin
    private function getKategoriData()
    {
        return Kategori::orderBy('id', 'desc')->get()->map(function ($k) {
            return ['id' => $k->id, 'nama' => $k->nama];
        })->toArray();
    }

    public function storeKategori(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nama' => 'required|string|max:25|unique:kategoris,nama'
        ], [
            'nama.max' => 'Nama kategori maksimal 25 karakter',
            'nama.unique' => 'Nama kategori sudah ada.'
        ]);
        $kat = Kategori::create(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function updateKategori(Request $request, $id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nama' => 'required|string|max:25|unique:kategoris,nama,' . $id
        ], [
            'nama.max' => 'Nama kategori maksimal 25 karakter',
            'nama.unique' => 'Nama kategori sudah ada.'
        ]);
        $kat = Kategori::findOrFail($id);
        $kat->update(['nama' => $request->nama]);
        return response()->json(['success' => true, 'data' => ['id' => $kat->id, 'nama' => $kat->nama]]);
    }

    public function destroyKategori($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $kat = Kategori::findOrFail($id);
        
        if ($kat->produks()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Kategori gagal dihapus karena masih memiliki produk di dalamnya. Silakan pindahkan atau hapus produk terlebih dahulu.'
            ], 400);
        }

        $kat->delete();
        return response()->json(['success' => true]);
    }
}
