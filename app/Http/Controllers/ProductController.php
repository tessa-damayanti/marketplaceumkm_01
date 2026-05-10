<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //  Data dummy produk dikelompokkan per kategori
    private function getAllProducts(): array
    {
        return [
            'kemeja' => [
                ['name' => 'Kemeja Stripe', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg', 'desc' => 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 5, 'M' => 8, 'L' => 3, 'XL' => 6], 'price' => '102.000', 'sold' => 17],
                ['name' => 'Kemeja Putih Basic', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg', 'desc' => 'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 7, 'M' => 10, 'L' => 5, 'XL' => 4], 'price' => '110.000', 'sold' => 20],
                ['name' => 'Kemeja Linen Pita', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg', 'desc' => 'Kemeja berbahan linen dengan desain feminin and detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang rapi and elegan.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 2, 'M' => 4, 'L' => 11, 'XL' => 13], 'price' => '145.000', 'sold' => 25],
                ['name' => 'Kemeja Slim Fit', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg', 'desc' => 'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman and cocok untuk tampilan formal maupun semi formal.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 1], 'price' => '152.000', 'sold' => 30],
                ['name' => 'Kemeja Pink Oversize', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/d3/db/ae/d3dbaeb17fcee123f3c128fd9e0c1223.jpg', 'desc' => 'Kemeja oversized berbahan katun poplin premium dengan warna pink pastel yang lembut, memberikan tampilan santai sekaligus elegan.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 3, 'M' => 4, 'L' => 3, 'XL' => 5], 'price' => '134.000', 'sold' => 35],
                ['name' => 'Kemeja Kotak', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/9e/4a/db/9e4adb09d0d982dd3edfbd66c7f1ed2d.jpg', 'desc' => 'Kemeja berbahan cotton blend dengan motif kotak and kerah besar yang unik, memberikan tampilan stylish. Bahannya tebal, adem, and tidak mudah kusut.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 7, 'M' => 2, 'L' => 9, 'XL' => 4], 'price' => '147.000', 'sold' => 10],
                ['name' => 'Kemeja Stripe Ruched Waist', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/e7/38/9b/e7389b41028ff1490b16193a8f03a9fc.jpg', 'desc' => 'Kemeja slim fit berbahan rayon premium dengan motif garis biru yang memberi kesan rapi and nyaman digunakan.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 8, 'M' => 10, 'L' => 3, 'XL' => 7], 'price' => '135.000', 'sold' => 12],
                ['name' => 'Kemeja Coklat Kerut', 'category' => 'Kemeja', 'image' => 'https://i.pinimg.com/1200x/d1/a0/41/d1a041440b4775b5c86204ba906b03e5.jpg', 'desc' => 'Kemeja berbahan poly-cotton dengan detail kerut di pinggang yang memberikan siluet yang lebih terbentuk. Bahannya tidak mudah kusut, ringan, and nyaman dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 10, 'M' => 12, 'L' => 6, 'XL' => 9], 'price' => '122.000', 'sold' => 17],
            ],
            'gaun' => [
                ['name' => 'Gaun Biru Wrap', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg', 'desc' => 'Gaun wanita dengan model wrap and pita di pinggang yang memberikan kesan ramping and elegan. Terbuat dari bahan katun ringan and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 3, 'M' => 5, 'L' => 2, 'XL' => 7], 'price' => '170.000', 'sold' => 37],
                ['name' => 'Gaun Ivory', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg', 'desc' => 'Gaun wanita dengan desain polos and kancing depan yang memberikan tampilan rapi and bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 8, 'M' => 10, 'L' => 11, 'XL' => 12], 'price' => '175.000', 'sold' => 27],
                ['name' => 'Gaun Merah Pita Rose', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/1200x/ce/cb/19/cecb194077a785432ed8c8691ecf1107.jpg', 'desc' => 'Gaun berbahan katun premium dengan warna merah cerah and detail pita di bagian leher yang memberi tampilan manis and standout.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 9, 'L' => 15, 'XL' => 18], 'price' => '155.000', 'sold' => 40],
                ['name' => 'Gaun Stripe', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/1200x/c0/18/71/c01871e6da2cacfeafe01662046fddda.jpg', 'desc' => 'Gaun dengan motif stripe memberikan tampilan rapi and stylish, dilengkapi kancing depan serta tali pinggang yang bisa disesuaikan untuk membentuk siluet tubuh.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 8, 'M' => 9, 'L' => 17, 'XL' => 15], 'price' => '150.000', 'sold' => 33],
                ['name' => 'Gaun Tiered Floral', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/736x/11/de/65/11de6566f49e6d16a836163987f3af6c.jpg', 'desc' => 'Gaun panjang berbahan rayon premium dengan motif and warna cokelat serta desain berlapis yang memberi tampilan anggun and flowy. Bahannya ringan, jatuh, and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 5, 'M' => 3, 'L' => 12, 'XL' => 9], 'price' => '160.000', 'sold' => 19],
                ['name' => 'Gaun Cream Floral', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/1200x/6b/0d/20/6b0d20f18a55bb233aa6bd2ea4391ebe.jpg', 'desc' => 'Gaun midi berbahan katun rayon dengan motif bunga kecil and potongan simpel yang terlihat manis and rapi. Bahannya adem, halus, and cocok untuk aktivitas santai maupun semi-formal.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 11, 'L' => 7, 'XL' => 2], 'price' => '172.000', 'sold' => 22],
                ['name' => 'Gaun Midi A line', 'category' => 'Gaun', 'image' => 'https://i.pinimg.com/1200x/dd/8f/61/dd8f61197741a45ec6c475017dc44774.jpg', 'desc' => 'Gaun berbahan poly-cotton dengan desain simpel and potongan yang membentuk siluet rapi, cocok untuk tampilan klasik. Bahannya tidak mudah kusut, tebal, and nyaman dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 9, 'M' => 10, 'L' => 8, 'XL' => 6], 'price' => '157.000', 'sold' => 17],
                ['name' => 'Gaun Floral', 'category' => 'Gaun', 'image' => 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg', 'desc' => 'Gaun wanita dengan motif floral yang memberikan tampilan feminin and segar. Menggunakan bahan chiffon yang nyaman dipakai untuk aktivitas santai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 3, 'L' => 7, 'XL' => 5], 'price' => '168.000', 'sold' => 8],
            ],
            'cardigan' => [
                ['name' => 'Cardigan Rajut Pink', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg', 'desc' => 'Cardigan pink dengan desain simpel and feminin, dilengkapi kancing depan. Terbuat dari bahan rajut cotton blend and acrylic yang ringan, halus, and tidak panas.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 2, 'M' => 2, 'L' => 3, 'XL' => 1], 'price' => '90.000', 'sold' => 5],
                ['name' => 'Cardigan Knit Cream', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/736x/23/2c/97/232c97d74f40e276f4527520494dfc4d.jpg', 'desc' => 'Cardigan cream dengan desain elegan dilengkapi kantong depan and kancing aksen yang memberi kesan classy. Terbuat dari bahan knit yang lembut and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 2, 'L' => 2, 'XL' => 2], 'price' => '112.000', 'sold' => 13],
                ['name' => 'Cardigan Pita Biru', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg', 'desc' => 'Cardigan dengan detail renda and pita yang memberikan tampilan feminin and elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas sehari hari.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 3, 'M' => 4, 'L' => 3, 'XL' => 2], 'price' => '95.000', 'sold' => 14],
                ['name' => 'Cardigan Floral', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg', 'desc' => 'Cardigan bermotif floral dengan desain ringan and tampilan feminin. Menggunakan bahan knit halus and memberikan tampilan santai yang tetap menarik.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 2, 'M' => 3, 'L' => 2, 'XL' => 2], 'price' => '119.000', 'sold' => 21],
                ['name' => 'Cardigan Rajut Peach', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/736x/88/9c/82/889c8231bece5e435376ef7415b1687d.jpg', 'desc' => 'Cardigan berbahan rajut katun dengan warna peach lembut and detail pola berlubang yang memberi tampilan manis and ringan. Bahannya hangat namun tetap nyaman and tidak gerah saat dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 2, 'M' => 3, 'L' => 2, 'XL' => 2], 'price' => '118.000', 'sold' => 26],
                ['name' => 'Cardigan Kotak Pink', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/1200x/e0/3b/aa/e03baac2a3719337d9fd5fcd8a20746e.jpg', 'desc' => 'Cardigan berbahan rajut cotton blend with motif kotak and potongan rapi, memberikan kesan klasik. Bahannya tebal, lembut, and nyaman untuk dipakai sehari-hari.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 10, 'M' => 7, 'L' => 8, 'XL' => 9], 'price' => '100.000', 'sold' => 28],
                ['name' => 'Cardigan Hijau Soft', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/1200x/ca/08/5b/ca085bdd54f25faf4a0cc6a67ec16e1c.jpg', 'desc' => 'Cardigan berbahan rajut halus with warna hijau lembut and desain simpel yang mudah dipadukan. Bahannya ringan, lembut di kulit, and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 8, 'M' => 10, 'L' => 17, 'XL' => 12], 'price' => '88.000', 'sold' => 7],
                ['name' => 'Cardigan Abu Pita', 'category' => 'Cardigan', 'image' => 'https://i.pinimg.com/1200x/96/d3/c0/96d3c0b84e0935fc8bae0b9e2a6031fd.jpg', 'desc' => 'Cardigan berbahan rajut halus with warna abu and detail pita hitam di bagian depan yang memberi tampilan unik. Bahannya lembut, hangat, and nyaman dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 8, 'M' => 6, 'L' => 5, 'XL' => 2], 'price' => '105.000', 'sold' => 11],
            ],
            'rok' => [
                ['name' => 'Rok Layer Putih', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg', 'desc' => 'Rok putih dengan desain layer bertingkat yang memberikan tampilan anggun and feminin. Detail lace menambah kesan elegan and flowy saat dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 5, 'M' => 3, 'L' => 2, 'XL' => 2], 'price' => '120.000', 'sold' => 11],
                ['name' => 'Rok Tiered Floral Cream', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/1200x/0c/d1/5f/0cd15f2868e8b150e2cc7a6bc726702f.jpg', 'desc' => 'Rok dengan desain layer bertingkat and motif bunga kecil yang memberikan tampilan feminin and anggun. Menggunakan bahan yang lembut, nyaman dipakai untuk berbagai aktivitas seperti acara santai, maupun semi formal. Detail kerut di bagian atas menambah kesan manis.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 6, 'L' => 2, 'XL' => 9], 'price' => '140.000', 'sold' => 27],
                ['name' => 'Rok Ruffle Pita', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg', 'desc' => 'Rok panjang dengan detail pita kecil yang memberikan tampilan manis and feminin and terbuat dari bahan katun ringan yang nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 3, 'M' => 2, 'L' => 8, 'XL' => 11], 'price' => '115.000', 'sold' => 30],
                ['name' => 'Rok Denim', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg', 'desc' => 'Rok berbahan denim dengan model wrap and detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 13, 'M' => 5, 'L' => 18, 'XL' => 19], 'price' => '132.000', 'sold' => 24],
                ['name' => 'Rok Ruffle Ungu', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/1200x/d1/47/8a/d1478a52a1c17e2ff342e15e0f4e369d.jpg', 'desc' => 'Rok berbahan katun ringan dengan warna ungu lembut and desain bertingkat yang memberi tampilan flowy and feminin. Bahannya adem and halus.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 10, 'M' => 8, 'L' => 4, 'XL' => 2], 'price' => '117.000', 'sold' => 34],
                ['name' => 'Rok Polkadot', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/1200x/ce/32/ba/ce32ba61f24f2d19f8c1850586fe348b.jpg', 'desc' => 'Rok berbahan denim dengan model wrap and detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi and nyaman.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 5, 'M' => 7, 'L' => 8, 'XL' => 9], 'price' => '107.000', 'sold' => 14],
                ['name' => 'Rok Bunga Layer', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/1200x/d6/03/df/d603df0209be73a4645c2c87605d9dcc.jpg', 'desc' => 'Rok berbahan katun ringan dengan motif bunga and desain bertingkat yang memberi tampilan manis and flowy. Bahannya adem, lembut, and nyaman dipakai untuk aktivitas sehari-hari.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 6, 'M' => 17, 'L' => 14, 'XL' => 10], 'price' => '128.000', 'sold' => 8],
                ['name' => 'Rok Coklat Lipit', 'category' => 'Rok', 'image' => 'https://i.pinimg.com/736x/28/2b/5c/282b5cb736c82098c344d62ed3d66abb.jpg', 'desc' => 'Rok putih dengan motif polkadot hitam yang manis and playful, dilengkapi pinggang karet yang nyaman dipakai.', 'sizes' => ['S', 'M', 'L', 'XL'], 'stock' => ['S' => 4, 'M' => 14, 'L' => 20, 'XL' => 8], 'price' => '137.000', 'sold' => 9],
            ],
        ];
    }

    //  Halaman beranda dengan menampilkan 4 produk terbaru
    public function home()
    {
        $allProducts = $this->getAllProducts();
        $products = [];

        // Ambil produk terbaru dari setiap kategori
        $categories = ['kemeja', 'gaun', 'cardigan', 'rok'];

        foreach ($categories as $cat) {
            if (isset($allProducts[$cat]) && count($allProducts[$cat]) > 0) {
                $products[] = end($allProducts[$cat]);
            }
        }

        return view('pages.home', compact('products'));
    }

    //  Halaman produk, filter kategori dan search
    public function index(Request $request)
    {
        $products = $this->getAllProducts();

        $defaultCategory = $request->input('category', 'semua');
        $search = $request->input('search', '');
        
        $searchLower = strtolower(trim($search));

        // Jika pencarian tentang
        if ($searchLower === 'tentang') {
            return redirect()->to(route('home') . '#tentang');
        }

        // Gabungkan produk sesuai kategori
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
                // Jika tidak ada produk yang cocok, namun kata kunci pencarian adalah nama kategori valid
                $defaultCategory = $searchLower;
            }
        }

        return view('pages.product', compact('displayProducts', 'defaultCategory', 'search'));
    }
}
