<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Data dummy produk — dikelompokkan per kategori.
     */
    private function getAllProducts(): array
    {
        return [
            'kemeja' => [
                ['name'=>'Kemeja Stripe','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg','desc'=>'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>8,'L'=>3,'XL'=>6],'price'=>100000],
                ['name'=>'Kemeja Putih Basic','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg','desc'=>'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>7,'M'=>10,'L'=>5,'XL'=>4],'price'=>110000],
                ['name'=>'Kemeja Linen Pita','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg','desc'=>'Kemeja berbahan linen dengan desain feminin dan detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang rapi dan elegan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>4,'L'=>1,'XL'=>2],'price'=>145000],
                ['name'=>'Kemeja Slim Fit','category'=>'Kemeja','image'=>'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg','desc'=>'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman dan cocok untuk tampilan formal maupun semi formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>152000],
                ['name'=>'Kemeja Pink Oversize','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/d3/db/ae/d3dbaeb17fcee123f3c128fd9e0c1223.jpg','desc'=>'Kemeja oversized berbahan katun poplin premium dengan warna pink pastel yang lembut, memberikan tampilan santai sekaligus elegan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>4,'L'=>3,'XL'=>5],'price'=>132000],
                ['name'=>'Kemeja Kotak','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/9e/4a/db/9e4adb09d0d982dd3edfbd66c7f1ed2d.jpg','desc'=>'Kemeja berbahan cotton blend dengan motif kotak dan kerah besar yang unik, memberikan tampilan stylish. Bahannya tebal, adem, dan tidak mudah kusut.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>7,'M'=>2,'L'=>9,'XL'=>4],'price'=>147000],
                ['name'=>'Kemeja Stripe Ruched Waist','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/e7/38/9b/e7389b41028ff1490b16193a8f03a9fc.jpg','desc'=>'Kemeja slim fit berbahan rayon premium dengan motif garis biru yang memberi kesan rapi dan nyaman digunakan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>135000],
                ['name'=>'Kemeja Coklat Kerut','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/d1/a0/41/d1a041440b4775b5c86204ba906b03e5.jpg','desc'=>'Kemeja berbahan poly-cotton dengan detail kerut di pinggang yang memberikan siluet yang lebih terbentuk. Bahannya tidak mudah kusut, ringan, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>122000],
            ],
            'gaun' => [
                ['name'=>'Gaun Biru Wrap','category'=>'Gaun','image'=>'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg','desc'=>'Gaun wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan katun ringan dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>5,'L'=>2,'XL'=>7],'price'=>170000],
                ['name'=>'Gaun Ivory','category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg','desc'=>'Gaun wanita dengan desain polos dan kancing depan yang memberikan tampilan rapi dan bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>10,'L'=>11,'XL'=>12],'price'=>175000],
                ['name'=>'Gaun Pita Merah','category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/ce/cb/19/cecb194077a785432ed8c8691ecf1107.jpg','desc'=>'Gaun berbahan katun premium dengan warna merah cerah dan detail pita di bagian leher yang memberi tampilan manis dan standout.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>9,'L'=>15,'XL'=>18],'price'=>155000],
                ['name'=>'Gaun Stripe','category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/c0/18/71/c01871e6da2cacfeafe01662046fddda.jpg','desc'=>'Gaun dengan motif stripe memberikan tampilan rapi dan stylish, dilengkapi kancing depan serta tali pinggang yang bisa disesuaikan untuk membentuk siluet tubuh.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>9,'L'=>17,'XL'=>15],'price'=>147000],
                ['name'=>'Gaun Tiered Floral','category'=>'Gaun','image'=>'https://i.pinimg.com/736x/11/de/65/11de6566f49e6d16a836163987f3af6c.jpg','desc'=>'Gaun panjang berbahan rayon premium dengan motif dan warna cokelat serta desain berlapis yang memberi tampilan anggun dan flowy. Bahannya ringan, jatuh, dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>3,'L'=>12,'XL'=>9],'price'=>160000],
                ['name'=>'Gaun Cream Floral','category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/6b/0d/20/6b0d20f18a55bb233aa6bd2ea4391ebe.jpg','desc'=>'Gaun midi berbahan katun rayon dengan motif bunga kecil dan potongan simpel yang terlihat manis dan rapi. Bahannya adem, halus, dan cocok untuk aktivitas santai maupun semi-formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>11,'L'=>7,'XL'=>2],'price'=>172000],
                ['name'=>'Gaun Midi A line','category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/dd/8f/61/dd8f61197741a45ec6c475017dc44774.jpg','desc'=>'Gaun berbahan poly-cotton dengan desain simpel dan potongan yang membentuk siluet rapi, cocok untuk tampilan klasik. Bahannya tidak mudah kusut, tebal, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>9,'M'=>10,'L'=>8,'XL'=>6],'price'=>157000],
                ['name'=>'Gaun Floral','category'=>'Gaun','image'=>'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg','desc'=>'Gaun wanita dengan motif floral yang memberikan tampilan feminin dan segar. Menggunakan bahan chiffon yang nyaman dipakai untuk aktivitas santai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>3,'L'=>7,'XL'=>5],'price'=>168000],
            ],
            'cardigan' => [
                ['name'=>'Cardigan Rajut Pink','category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg','desc'=>'Cardigan pink dengan desain simpel dan feminin, dilengkapi kancing depan. Terbuat dari bahan rajut cotton blend dan acrylic yang ringan, halus, dan tidak panas.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>2,'L'=>3,'XL'=>1],'price'=>90000],
                ['name'=>'Cardigan Knit Cream','category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/23/2c/97/232c97d74f40e276f4527520494dfc4d.jpg','desc'=>'Cardigan cream dengan desain elegan dilengkapi kantong depan dan kancing aksen yang memberi kesan classy. Terbuat dari bahan knit yang lembut dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>2,'L'=>2,'XL'=>2],'price'=>112000],
                ['name'=>'Cardigan Pita Biru','category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg','desc'=>'Cardigan dengan detail renda dan pita yang memberikan tampilan feminin dan elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas sehari hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>4,'L'=>3,'XL'=>2],'price'=>95000],
                ['name'=>'Cardigan Floral','category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg','desc'=>'Cardigan bermotif floral dengan desain ringan dan tampilan feminin. Menggunakan bahan knit halus dan memberikan tampilan santai yang tetap menarik.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>3,'L'=>2,'XL'=>2],'price'=>118000],
                ['name'=>'Cardigan Rajut Peach','category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/88/9c/82/889c8231bece5e435376ef7415b1687d.jpg','desc'=>'Cardigan berbahan rajut katun dengan warna peach lembut dan detail pola berlubang yang memberi tampilan manis dan ringan. Bahannya hangat namun tetap nyaman dan tidak gerah saat dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>3,'L'=>2,'XL'=>2],'price'=>118000],
                ['name'=>'Cardigan Kotak Pink','category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/e0/3b/aa/e03baac2a3719337d9fd5fcd8a20746e.jpg','desc'=>'Cardigan berbahan rajut cotton blend dengan motif kotak dan potongan rapi, memberikan kesan klasik. Bahannya tebal, lembut, dan nyaman untuk dipakai sehari-hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>10,'M'=>7,'L'=>8,'XL'=>9],'price'=>100000],
                ['name'=>'Cardigan Hijau Soft','category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/ca/08/5b/ca085bdd54f25faf4a0cc6a67ec16e1c.jpg','desc'=>'Cardigan berbahan rajut halus dengan warna hijau lembut dan desain simpel yang mudah dipadukan. Bahannya ringan, lembut di kulit, dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>10,'L'=>17,'XL'=>12],'price'=>88000],
                ['name'=>'Cardigan Abu Pita','category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/96/d3/c0/96d3c0b84e0935fc8bae0b9e2a6031fd.jpg','desc'=>'Cardigan berbahan rajut halus dengan warna abu dan detail pita hitam di bagian depan yang memberi tampilan unik. Bahannya lembut, hangat, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>6,'L'=>5,'XL'=>2],'price'=>105000],
            ],
            'rok' => [
                ['name'=>'Rok Layer Putih','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg','desc'=>'Rok putih dengan desain layer bertingkat yang memberikan tampilan anggun dan feminin. Detail lace menambah kesan elegan dan flowy saat dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>3,'L'=>2,'XL'=>2],'price'=>120000],
                ['name'=>'Rok Tiered Floral Cream','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/0c/d1/5f/0cd15f2868e8b150e2cc7a6bc726702f.jpg','desc'=>'Rok dengan desain layer bertingkat dan motif bunga kecil yang memberikan tampilan feminin dan anggun.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>6,'L'=>2,'XL'=>9],'price'=>132000],
                ['name'=>'Rok Ruffle Pita','category'=>'Rok','image'=>'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg','desc'=>'Rok panjang dengan detail pita kecil yang memberikan tampilan manis dan feminin dan terbuat dari bahan katun ringan yang nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>2,'L'=>8,'XL'=>11],'price'=>115000],
                ['name'=>'Rok Denim','category'=>'Rok','image'=>'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg','desc'=>'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>13,'M'=>5,'L'=>18,'XL'=>19],'price'=>132000],
                ['name'=>'Rok Ruffle Ungu','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/d1/47/8a/d1478a52a1c17e2ff342e15e0f4e369d.jpg','desc'=>'Rok berbahan katun ringan dengan warna ungu lembut dan desain bertingkat yang memberi tampilan flowy dan feminin. Bahannya adem dan halus.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>10,'M'=>8,'L'=>4,'XL'=>2],'price'=>118000],
                ['name'=>'Rok Polkadot','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/ce/32/ba/ce32ba61f24f2d19f8c1850586fe348b.jpg','desc'=>'Rok putih dengan motif polkadot hitam yang manis dan playful, dilengkapi pinggang karet yang nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>7,'L'=>8,'XL'=>9],'price'=>100000],
                ['name'=>'Rok Bunga Layer','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/d6/03/df/d603df0209be73a4645c2c87605d9dcc.jpg','desc'=>'Rok berbahan katun ringan dengan motif bunga dan desain bertingkat yang memberi tampilan manis dan flowy.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>6,'M'=>17,'L'=>14,'XL'=>10],'price'=>128000],
                ['name'=>'Rok Coklat Lipit','category'=>'Rok','image'=>'https://i.pinimg.com/736x/28/2b/5c/282b5cb736c82098c344d62ed3d66abb.jpg','desc'=>'Rok coklat dengan desain lipit yang klasik dan elegan, dilengkapi pinggang karet yang nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>14,'L'=>20,'XL'=>8],'price'=>135000],
            ],
        ];
    }

    /**
     * Halaman beranda — tampilkan 4 produk unggulan.
     */
    public function home()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Kemeja Stripe',
                'category' => 'Kemeja',
                'image' => 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'desc' => 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => ['S'=>2,'M'=>3,'L'=>2,'XL'=>3],
                'price' => 100000,
            ],
            [
                'id' => 2,
                'name' => 'Gaun Biru Wrap',
                'category' => 'Gaun',
                'image' => 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg',
                'desc' => 'Dress midi wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => ['S'=>2,'M'=>2,'L'=>2,'XL'=>2],
                'price' => 170000,
            ],
            [
                'id' => 3,
                'name' => 'Cardigan Rajut Pink',
                'category' => 'Cardigan',
                'image' => 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
                'desc' => 'Cardigan rajut dengan tekstur lembut dan warna feminin. Cocok untuk tampilan kasual yang tetap manis dan nyaman dipakai.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => ['S'=>3,'M'=>3,'L'=>2,'XL'=>2],
                'price' => 112000,
            ],
            [
                'id' => 4,
                'name' => 'Rok Midi A-line',
                'category' => 'Rok',
                'image' => 'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg',
                'desc' => 'Rok midi dengan potongan A-line yang sederhana dan rapi. Nyaman digunakan untuk aktivitas sehari-hari dengan tampilan elegan.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => ['S'=>3,'M'=>4,'L'=>3,'XL'=>2],
                'price' => 100000,
            ],
        ];

        return view('pages.home', compact('products'));
    }

    /**
     * Halaman produk — filter kategori & search.
     */
    public function index(Request $request)
    {
        $products = $this->getAllProducts();

        $defaultCategory = $request->input('category', 'kemeja');
        $search = $request->input('search', '');

        // Gabungkan produk sesuai kategori
        if ($defaultCategory === 'semua') {
            $displayProducts = array_merge(...array_values($products));
        } else {
            $displayProducts = $products[$defaultCategory] ?? [];
        }

        // Filter search
        if ($search) {
            $displayProducts = array_filter($displayProducts, function ($product) use ($search) {
                return str_contains(strtolower($product['name']), strtolower($search))
                    || str_contains(strtolower($product['category']), strtolower($search));
            });
            $displayProducts = array_values($displayProducts);
        }

        return view('pages.product', compact('displayProducts', 'defaultCategory', 'search'));
    }
}
