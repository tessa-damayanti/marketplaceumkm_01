<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Kategori;

class ProductController extends Controller
{
    private function getAllProducts(): array
    {
        $dbProduks = \App\Models\Produk::with(['kategori', 'stoks.ukuran'])->get();
        $mapped = [];

        foreach ($dbProduks as $p) {
            $catName = $p->kategori ? $p->kategori->nama : 'Lainnya';
            $cat = strtolower($catName);
            if (!isset($mapped[$cat])) {
                $mapped[$cat] = [];
            }

            $stokArray = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
            $stokIds = [];
            foreach ($p->stoks as $stok) {
                if ($stok->ukuran) {
                    $namaUkuran = $stok->ukuran->nama_ukuran;
                    $stokArray[$namaUkuran] = $stok->jumlah_stok;
                    $stokIds[$namaUkuran] = $stok->id;
                }
            }   

            $mapped[$cat][] = [
                'name' => $p->nama,
                'category' => $catName,
                'image' => $p->image ? asset('images/' . $p->image) : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'desc' => $p->deskripsi,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => $stokArray,
                'stok_ids' => $stokIds,
                'price' => number_format($p->harga, 0, ',', '.'),
                'sold' => $p->id <= 20 ? (($p->id * 7) % 45) + 5 : 0
            ];
        }

        return $mapped;
    }

    public function home()
    {
        $allProducts = $this->getAllProducts();
        $products = [];

        $categories = Kategori::orderBy('id', 'asc')->get();

        // Ambil produk terbaru dari setiap kategori secara dinamis
        foreach ($categories as $kategori) {
            $catKey = strtolower($kategori->nama);
            if (isset($allProducts[$catKey]) && count($allProducts[$catKey]) > 0) {
                $products[] = end($allProducts[$catKey]);
            }
        }

        return view('pages.home', compact('products', 'categories'));
    }

    public function index(Request $request)
    {
        $products = $this->getAllProducts();
        $categories = Kategori::orderBy('id', 'asc')->get();

        $defaultCategory = $request->input('category', 'semua');
        $search = $request->input('search', '');

        $searchLower = strtolower(trim($search));

        if ($searchLower === 'tentang') {
            return redirect()->to(route('home') . '#tentang');
        }

        if ($defaultCategory === 'semua') {
            $displayProducts = [];
            foreach ($products as $category => $items) {
                $displayProducts = array_merge($displayProducts, array_reverse($items));
            }
        } else {
            $displayProducts = array_reverse($products[$defaultCategory] ?? []);
        }

        // Filter search
        if ($searchLower) {
            $displayProducts = array_filter($displayProducts, function ($product) use ($searchLower) {
                return str_contains(strtolower($product['name']), $searchLower)
                    || str_contains(strtolower($product['category']), $searchLower);
            });
            $displayProducts = array_values($displayProducts);

            if (count($displayProducts) > 0) {
                $matchedCategories = array_unique(array_map(function ($item) {
                    return strtolower($item['category']);
                }, $displayProducts));

                if (count($matchedCategories) === 1) {
                    $defaultCategory = array_values($matchedCategories)[0];
                }
            } else if (array_key_exists($searchLower, $products)) {
                $defaultCategory = $searchLower;
            }
        }

        return view('pages.product', compact('displayProducts', 'defaultCategory', 'search', 'categories'));
    }
}

