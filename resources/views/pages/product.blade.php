@extends('layouts.app')
@section('title', 'Produk')

@section('content')

{{-- Toast session success --}}
@if (session('success'))
<div id="toast-success"
    class="fixed top-5 right-5 z-[999] flex items-center gap-2 rounded-2xl bg-[#5c4432] px-5 py-3 text-sm font-medium text-white shadow-xl">
    {{-- Ikon centang --}}
    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    {{ session('success') }}
</div>
<script>
    // Hapus toast otomatis setelah 2 detik
    setTimeout(() => document.getElementById('toast-success')?.remove(), 2000);
</script>
@endif

@php
$products = [
// Kemeja
'kemeja' => [
['name'=>'Kemeja Stripe', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg','desc'=>'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>8,'L'=>3,'XL'=>6],'price'=>'100.000'],
['name'=>'Kemeja Putih Basic', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg','desc'=>'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>7,'M'=>10,'L'=>5,'XL'=>4],'price'=>'110.000'],
['name'=>'Kemeja Linen Pita', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg','desc'=>'Kemeja berbahan linen dengan desain feminin dan detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang rapi dan elegan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>4,'L'=>1,'XL'=>2],'price'=>'145.000'],
['name'=>'Kemeja Slim Fit', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg','desc'=>'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman dan cocok untuk tampilan formal maupun semi formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>'152.000'],
['name'=>'Kemeja Pink Oversize','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/d3/db/ae/d3dbaeb17fcee123f3c128fd9e0c1223.jpg','desc'=>'Kemeja oversized berbahan katun poplin premium dengan warna pink pastel yang lembut, memberikan tampilan santai sekaligus elegan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>4,'L'=>3,'XL'=>5],'price'=>'132.000'],
['name'=>'Kemeja Kotak', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/9e/4a/db/9e4adb09d0d982dd3edfbd66c7f1ed2d.jpg','desc'=>'Kemeja berbahan cotton blend dengan motif kotak dan kerah besar yang unik, memberikan tampilan stylish. Bahannya tebal, adem, dan tidak mudah kusut.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>7,'M'=>2,'L'=>9,'XL'=>4],'price'=>'147.000'],
['name'=>'Kemeja Stripe Ruched Waist', 'category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/e7/38/9b/e7389b41028ff1490b16193a8f03a9fc.jpg','desc'=>'Kemeja slim fit berbahan rayon premium dengan motif garis biru yang memberi kesan rapi dan nyaman digunakan.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>'135.000'],
['name'=>'Kemeja Coklat Kerut','category'=>'Kemeja','image'=>'https://i.pinimg.com/1200x/d1/a0/41/d1a041440b4775b5c86204ba906b03e5.jpg','desc'=>'Kemeja berbahan poly-cotton dengan detail kerut di pinggang yang memberikan siluet yang lebih terbentuk. Bahannya tidak mudah kusut, ringan, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>1,'M'=>2,'L'=>3,'XL'=>1],'price'=>'122.000'],
],
// Gaun
'gaun' => [
['name'=>'Gaun Biru Wrap', 'category'=>'Gaun','image'=>'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg','desc'=>'Gaun wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan katun ringan dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>5,'L'=>2,'XL'=>7],'price'=>'170.000'],
['name'=>'Gaun Ivory', 'category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg','desc'=>'Gaun wanita dengan desain polos dan kancing depan yang memberikan tampilan rapi dan bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>10,'L'=>11,'XL'=>12],'price'=>'175.000'],
['name'=>'Gaun Pita Merah', 'category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/ce/cb/19/cecb194077a785432ed8c8691ecf1107.jpg','desc'=>'Gaun berbahan katun premium dengan warna merah cerah dan detail pita di bagian leher yang memberi tampilan manis dan standout.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>9,'L'=>15,'XL'=>18],'price'=>'155.000'],
['name'=>'Gaun Stripe', 'category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/c0/18/71/c01871e6da2cacfeafe01662046fddda.jpg','desc'=>'Gaun dengan motif stripe memberikan tampilan rapi dan stylish, dilengkapi kancing depan serta tali pinggang yang bisa disesuaikan untuk membentuk siluet tubuh.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>9,'L'=>17,'XL'=>15],'price'=>'147.000'],
['name'=>'Gaun Tiered Floral', 'category'=>'Gaun','image'=>'https://i.pinimg.com/736x/11/de/65/11de6566f49e6d16a836163987f3af6c.jpg','desc'=>'Gaun panjang berbahan rayon premium dengan motif dan warna cokelat serta desain berlapis yang memberi tampilan anggun dan flowy. Bahannya ringan, jatuh, dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>3,'L'=>12,'XL'=>9],'price'=>'160.000'],
['name'=>'Gaun Cream Floral', 'category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/6b/0d/20/6b0d20f18a55bb233aa6bd2ea4391ebe.jpg','desc'=>'Gaun midi berbahan katun rayon dengan motif bunga kecil dan potongan simpel yang terlihat manis dan rapi. Bahannya adem, halus, dan cocok untuk aktivitas santai maupun semi-formal.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>11,'L'=>7,'XL'=>2],'price'=>'172.000'],
['name'=>'Gaun Midi A line', 'category'=>'Gaun','image'=>'https://i.pinimg.com/1200x/dd/8f/61/dd8f61197741a45ec6c475017dc44774.jpg','desc'=>'Gaun berbahan poly-cotton dengan desain simpel dan potongan yang membentuk siluet rapi, cocok untuk tampilan klasik. Bahannya tidak mudah kusut, tebal, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>9,'M'=>10,'L'=>8,'XL'=>6],'price'=>'157.000'],
['name'=>'Gaun Floral', 'category'=>'Gaun','image'=>'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg','desc'=>'Gaun wanita dengan motif floral yang memberikan tampilan feminin dan segar. Menggunakan bahan chiffon yang nyaman dipakai untuk aktivitas santai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>3,'L'=>7,'XL'=>5],'price'=>'168.000'],
],
// Cardigan
'cardigan' => [
['name'=>'Cardigan Rajut Pink', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg','desc'=>'Cardigan pink dengan desain simpel dan feminin, dilengkapi kancing depan. Terbuat dari bahan rajut cotton blend dan acrylic yang ringan, halus, dan tidak panas.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>2,'L'=>3,'XL'=>1],'price'=>'90.000'],
['name'=>'Cardigan Knit Cream', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/23/2c/97/232c97d74f40e276f4527520494dfc4d.jpg','desc'=>'Cardigan cream dengan desain elegan dilengkapi kantong depan dan kancing aksen yang memberi kesan classy. Terbuat dari bahan knit yang lembut dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>2,'L'=>2,'XL'=>2],'price'=>'112.000'],
['name'=>'Cardigan Pita Biru', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg','desc'=>'Cardigan dengan detail renda dan pita yang memberikan tampilan feminin dan elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas sehari hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>4,'L'=>3,'XL'=>2],'price'=>'95.000'],
['name'=>'Cardigan Floral', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg','desc'=>'Cardigan bermotif floral dengan desain ringan dan tampilan feminin. Menggunakan bahan knit halus dan memberikan tampilan santai yang tetap menarik.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>3,'L'=>2,'XL'=>2],'price'=>'118.000'],
['name'=>'Cardigan Rajut Peach','category'=>'Cardigan','image'=>'https://i.pinimg.com/736x/88/9c/82/889c8231bece5e435376ef7415b1687d.jpg','desc'=>'Cardigan berbahan rajut katun dengan warna peach lembut dan detail pola berlubang yang memberi tampilan manis dan ringan. Bahannya hangat namun tetap nyaman dan tidak gerah saat dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>2,'M'=>3,'L'=>2,'XL'=>2],'price'=>'118.000'],
['name'=>'Cardigan Kotak Pink', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/e0/3b/aa/e03baac2a3719337d9fd5fcd8a20746e.jpg','desc'=>'Cardigan berbahan rajut cotton blend dengan motif kotak dan potongan rapi, memberikan kesan klasik. Bahannya tebal, lembut, dan nyaman untuk dipakai sehari-hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>10,'M'=>7,'L'=>8,'XL'=>9],'price'=>'100.000'],
['name'=>'Cardigan Hijau Soft', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/ca/08/5b/ca085bdd54f25faf4a0cc6a67ec16e1c.jpg','desc'=>'Cardigan berbahan rajut halus dengan warna hijau lembut dan desain simpel yang mudah dipadukan. Bahannya ringan, lembut di kulit, dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>10,'L'=>17,'XL'=>12],'price'=>'88.000'],
['name'=>'Cardigan Abu Pita', 'category'=>'Cardigan','image'=>'https://i.pinimg.com/1200x/96/d3/c0/96d3c0b84e0935fc8bae0b9e2a6031fd.jpg','desc'=>'Cardigan berbahan rajut halus dengan warna abu dan detail pita hitam di bagian depan yang memberi tampilan unik. Bahannya lembut, hangat, dan nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>8,'M'=>6,'L'=>5,'XL'=>2],'price'=>'105.000'],
],
// Rok
'rok' => [
['name'=>'Rok Layer Putih', 'category'=>'Rok','image'=>'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg','desc'=>'Rok putih dengan desain layer bertingkat yang memberikan tampilan anggun dan feminin. Detail lace menambah kesan elegan dan flowy saat dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>3,'L'=>2,'XL'=>2],'price'=>'120.000'],
['name'=>'Rok Tiered Floral Cream', 'category'=>'Rok','image'=>'https://i.pinimg.com/1200x/0c/d1/5f/0cd15f2868e8b150e2cc7a6bc726702f.jpg','desc'=>'Rok dengan desain layer bertingkat dan motif bunga kecil yang memberikan tampilan feminin dan anggun. Menggunakan bahan yang lembut, nyaman dipakai untuk berbagai aktivitas seperti acara santai, maupun semi formal. Detail kerut di bagian atas menambah kesan manis.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>6,'L'=>2,'XL'=>9],'price'=>'132.000'],
['name'=>'Rok Ruffle Pita', 'category'=>'Rok','image'=>'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg','desc'=>'Rok panjang dengan detail pita kecil yang memberikan tampilan manis dan feminin dan terbuat dari bahan katun ringan yang nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>3,'M'=>2,'L'=>8,'XL'=>11],'price'=>'115.000'],
['name'=>'Rok Denim', 'category'=>'Rok','image'=>'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg','desc'=>'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>13,'M'=>5,'L'=>18,'XL'=>19],'price'=>'132.000'],
['name'=>'Rok Ruffle Ungu', 'category'=>'Rok','image'=>'https://i.pinimg.com/1200x/d1/47/8a/d1478a52a1c17e2ff342e15e0f4e369d.jpg','desc'=>'Rok berbahan katun ringan dengan warna ungu lembut dan desain bertingkat yang memberi tampilan flowy dan feminin. Bahannya adem dan halus.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>10,'M'=>8,'L'=>4,'XL'=>2],'price'=>'118.000'],
['name'=>'Rok Polkadot','category'=>'Rok','image'=>'https://i.pinimg.com/1200x/ce/32/ba/ce32ba61f24f2d19f8c1850586fe348b.jpg','desc'=>'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>5,'M'=>7,'L'=>8,'XL'=>9],'price'=>'100.000'],
['name'=>'Rok Bunga Layer', 'category'=>'Rok','image'=>'https://i.pinimg.com/1200x/d6/03/df/d603df0209be73a4645c2c87605d9dcc.jpg','desc'=>'Rok berbahan katun ringan dengan motif bunga dan desain bertingkat yang memberi tampilan manis dan flowy. Bahannya adem, lembut, dan nyaman dipakai untuk aktivitas sehari-hari.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>6,'M'=>17,'L'=>14,'XL'=>10],'price'=>'128.000'],
['name'=>'Rok Coklat Lipit','category'=>'Rok','image'=>'https://i.pinimg.com/736x/28/2b/5c/282b5cb736c82098c344d62ed3d66abb.jpg','desc'=>'Rok putih dengan motif polkadot hitam yang manis dan playful, dilengkapi pinggang karet yang nyaman dipakai.','sizes'=>['S','M','L','XL'],'stock'=>['S'=>4,'M'=>14,'L'=>20,'XL'=>8],'price'=>'135.000'],
],
];

// Tentukan kategori yang ditampilkan (default: kemeja)
$defaultCategory = request('category', 'kemeja');

// Gabungkan produk sesuai kategori
$displayProducts = $defaultCategory === 'semua'
? array_merge(...array_values($products))
: ($products[$defaultCategory] ?? []);
@endphp

<style>
    /* Animasi kartu produk */
    @keyframes cardFadeUp {
        from {
            opacity: 0;
            transform: translateY(24px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .product-card {
        opacity: 0;
        transform: translateY(24px) scale(0.97);
        will-change: transform, opacity;
    }

    .product-card.card-visible {
        animation: cardFadeUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    /* Zoom gambar saat kartu di-hover */
    .product-card .card-thumb {
        overflow: hidden;
    }

    .product-card .card-thumb img {
        transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }

    .product-card:hover .card-thumb img {
        transform: scale(1.06);
    }

    /*  scroll horizontal di mobile, wrap di desktop */
    #categoryTabs {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.45rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    #categoryTabs::-webkit-scrollbar {
        display: none;
    }

    @media (min-width: 640px) {
        #categoryTabs {
            flex-wrap: wrap;
            overflow-x: visible;
        }
    }

    /* Custom dropdown arrow untuk sort select */
    #sortSelect {
        appearance: none;
        -webkit-appearance: none;

        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='8' viewBox='0 0 14 8'%3E%3Cpath d='M2 2l5 4 5-4' stroke='%235B4636' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");

        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 14px 8px;
        padding-right: 2.6rem;
    }

    /* Tinggi gambar kartu responsif  */
    .card-thumb img {
        height: 160px;
        object-fit: cover;
        width: 100%;
        display: block;
    }

    @media (min-width: 480px) {
        .card-thumb img {
            height: 185px;
        }
    }

    @media (min-width: 768px) {
        .card-thumb img {
            height: 215px;
        }
    }

    @media (min-width: 1024px) {
        .card-thumb img {
            height: 235px;
        }
    }
</style>

<div id="toast"
    class="fixed top-5 right-5 z-[999] hidden items-center gap-2 rounded-2xl bg-[#5c4432] px-5 py-3 text-sm font-medium text-white shadow-xl">
    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    Ditambahkan ke keranjang
</div>

<section class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 sm:pt-8 [font-family:Poppins,sans-serif]">
    <div class="flex items-center justify-between gap-3">

        <!-- Judul kategori aktif  -->
        <h1 class="text-[clamp(1.35rem,4.5vw,2.1rem)] font-bold text-[#5c4432]">
            {{ $defaultCategory === 'semua' ? 'Semua Produk' : ucfirst($defaultCategory) }}
        </h1>

        <!-- Dropdown urutkan produk -->
        <select id="sortSelect"
            class="w-auto min-w-[180px] max-w-[200px] rounded-xl border border-[#e0d2c3] bg-[#e8ded3] px-3 py-2 text-xs font-semibold text-[#5B4636] outline-none transition hover:border-[#c4a882] sm:rounded-2xl sm:px-4 sm:py-3 sm:text-sm [font-family:Poppins,sans-serif]">
            <option value="default">Terbaru</option>
            <option value="price-asc">Harga Termurah</option>
            <option value="price-desc">Harga Termahal</option>
        </select>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-4 pt-4 sm:px-6 sm:pb-6 sm:pt-5 [font-family:Poppins,sans-serif]">
    <div id="categoryTabs">

        <!-- Semua -->
        <a href="{{ route('product') }}?category=semua"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-3 py-2 text-[0.78rem] font-semibold no-underline transition-all duration-200
                  sm:px-4 sm:py-[0.55rem] sm:text-[0.82rem]
                  {{ $defaultCategory === 'semua'
                       ? 'bg-[#7A4F2E] text-white border-[#6B3F22] shadow-[0_4px_14px_rgba(122,79,46,0.25)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#C9A98A] hover:text-white hover:border-[#B8926E] hover:shadow-[0_4px_14px_rgba(139,90,50,0.18)] hover:-translate-y-px' }}">
            <!-- Icon -->
            <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full
                         {{ $defaultCategory === 'semua' ? 'bg-white/20' : 'bg-[#F0E7DD] group-hover:bg-white/20' }}
                         transition-all duration-200">
                <svg width="11" height="11" viewBox="0 0 11 11" fill="currentColor">
                    <rect x="0" y="0" width="4.5" height="4.5" rx="1" />
                    <rect x="6.5" y="0" width="4.5" height="4.5" rx="1" />
                    <rect x="0" y="6.5" width="4.5" height="4.5" rx="1" />
                    <rect x="6.5" y="6.5" width="4.5" height="4.5" rx="1" />
                </svg>
            </span>
            Semua
        </a>

        <!-- Kemeja -->
        <a href="{{ route('product') }}?category=kemeja"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-3 py-2 text-[0.78rem] font-semibold no-underline transition-all duration-200
                  sm:px-4 sm:py-[0.55rem] sm:text-[0.82rem]
                  {{ $defaultCategory === 'kemeja'
                       ? 'bg-[#7A4F2E] text-white border-[#6B3F22] shadow-[0_4px_14px_rgba(122,79,46,0.25)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#C9A98A] hover:text-white hover:border-[#B8926E] hover:shadow-[0_4px_14px_rgba(139,90,50,0.18)] hover:-translate-y-px' }}">
            <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full
                         {{ $defaultCategory === 'kemeja' ? 'bg-white/20' : 'bg-[#F0E7DD] group-hover:bg-white/20' }}
                         transition-all duration-200">
                <!-- Icon kemeja  -->
                <svg width="13" height="13" viewBox="0 0 20 20" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 5.5l4-3 3 3h2l3-3 4 3-3 4.5H13V18H7v-8H4L2 5.5z" />
                </svg>
            </span>
            Kemeja
        </a>

        <!-- Gaun -->
        <a href="{{ route('product') }}?category=gaun"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-3 py-2 text-[0.78rem] font-semibold no-underline transition-all duration-200
                  sm:px-4 sm:py-[0.55rem] sm:text-[0.82rem]
                  {{ $defaultCategory === 'gaun'
                       ? 'bg-[#7A4F2E] text-white border-[#6B3F22] shadow-[0_4px_14px_rgba(122,79,46,0.25)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#C9A98A] hover:text-white hover:border-[#B8926E] hover:shadow-[0_4px_14px_rgba(139,90,50,0.18)] hover:-translate-y-px' }}">
            <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full
                         {{ $defaultCategory === 'gaun' ? 'bg-white/20' : 'bg-[#F0E7DD] group-hover:bg-white/20' }}
                         transition-all duration-200">
                <!-- Icon gaun -->
                <svg width="11" height="13" viewBox="0 0 18 22" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 1h6M9 1v4M6 5L3 21h12L13 5" />
                    <path d="M6 5Q9 8.5 13 5" />
                </svg>
            </span>
            Gaun
        </a>

        <!-- Cardigan -->
        <a href="{{ route('product') }}?category=cardigan"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-3 py-2 text-[0.78rem] font-semibold no-underline transition-all duration-200
                  sm:px-4 sm:py-[0.55rem] sm:text-[0.82rem]
                  {{ $defaultCategory === 'cardigan'
                       ? 'bg-[#7A4F2E] text-white border-[#6B3F22] shadow-[0_4px_14px_rgba(122,79,46,0.25)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#C9A98A] hover:text-white hover:border-[#B8926E] hover:shadow-[0_4px_14px_rgba(139,90,50,0.18)] hover:-translate-y-px' }}">
            <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full
                         {{ $defaultCategory === 'cardigan' ? 'bg-white/20' : 'bg-[#F0E7DD] group-hover:bg-white/20' }}
                         transition-all duration-200">
                <!-- Icon cardigan -->
                <svg width="13" height="13" viewBox="0 0 20 20" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 5.5l4-3 2.5 2.5L10 6.5l1.5-1.5L14 2l4 3.5-2.5 4H13V18H7V9.5H4.5L2 5.5z" />
                    <line x1="10" y1="6.5" x2="10" y2="18" />
                </svg>
            </span>
            Cardigan
        </a>

        <!-- Rok -->
        <a href="{{ route('product') }}?category=rok"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-3 py-2 text-[0.78rem] font-semibold no-underline transition-all duration-200
                  sm:px-4 sm:py-[0.55rem] sm:text-[0.82rem]
                  {{ $defaultCategory === 'rok'
                       ? 'bg-[#7A4F2E] text-white border-[#6B3F22] shadow-[0_4px_14px_rgba(122,79,46,0.25)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#C9A98A] hover:text-white hover:border-[#B8926E] hover:shadow-[0_4px_14px_rgba(139,90,50,0.18)] hover:-translate-y-px' }}">
            <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full
                         {{ $defaultCategory === 'rok' ? 'bg-white/20' : 'bg-[#F0E7DD] group-hover:bg-white/20' }}
                         transition-all duration-200">
                <!-- Icon rok -->
                <svg width="11" height="13" viewBox="0 0 18 22" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="1" width="12" height="4" rx="1.5" />
                    <path d="M3 5L1 21h16L15 5" />
                </svg>
            </span>
            Rok
        </a>

    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 [font-family:Poppins,sans-serif]">
    <div id="product-grid"
        class="grid grid-cols-2 gap-[0.85rem] md:grid-cols-3 md:gap-5 lg:grid-cols-4 lg:gap-6">

        @foreach ($displayProducts as $index => $product)
        <!-- Kartu produk untuk modal -->
        <div class="product-card cursor-pointer overflow-hidden rounded-[18px] bg-white shadow-[0_2px_14px_rgba(167,141,120,0.10)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_14px_32px_rgba(167,141,120,0.20)]"
            data-index="{{ $index }}"
            data-price="{{ str_replace('.', '', $product['price']) }}"
            data-name="{{ strtolower($product['name']) }}"
            data-product='@json($product)'
            onclick="openModalFromElement(this)">

            <!-- Gambar produk -->
            <div class="card-thumb">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy">
            </div>

            <!-- Info produk -->
            <div class="p-[0.65rem_0.75rem_0.85rem] sm:p-4">
                <!-- Label kategori -->
                <p class="mb-0.5 text-[9px] font-bold uppercase tracking-[2.5px] text-[#b08b68] sm:text-[10px] sm:tracking-[3px]">
                    {{ $product['category'] }}
                </p>
                <!-- Nama produk -->
                <h3 class="mb-1 text-[0.79rem] font-semibold leading-snug text-[#5c4432] sm:mb-1.5 sm:text-[0.94rem]">
                    {{ $product['name'] }}
                </h3>
                <!-- Harga -->
                <p class="mb-2.5 text-sm font-bold text-[#7a5a43] sm:mb-3 sm:text-[1.05rem]">
                    Rp{{ $product['price'] }}
                </p>
                <!-- Tombol lihat detail -->
                <button type="button"
                    class="w-full rounded-xl border-0 bg-[#a78d78] px-4 py-2 text-xs font-semibold text-white transition-all duration-200 hover:bg-[#8f7561] hover:shadow-[0_5px_14px_rgba(92,68,50,0.16)] sm:rounded-2xl sm:py-2.5 sm:text-sm [font-family:Poppins,sans-serif]">
                    Lihat Detail
                </button>
            </div>
        </div>
        @endforeach

    </div>
</section>

<div id="productModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-3 backdrop-blur-[2px]
            opacity-0 transition-opacity duration-200 ease-in-out
            [&.modal-hidden]:hidden sm:px-4 [font-family:Poppins,sans-serif]"
    style="display:none;">

    <!-- Panel modal -->
    <div id="productModalPanel"
        class="relative w-full max-w-[880px] overflow-hidden rounded-[24px] bg-white shadow-[0_24px_64px_rgba(92,68,50,0.22)]
                opacity-0 transition-all duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
        style="transform: translateY(18px) scale(0.98);">

        <!-- Tombol tutup -->
        <button onclick="closeModal()"
            class="absolute right-3 top-3 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-base leading-none text-[#5c4432] shadow-md transition-all duration-150 hover:scale-110 hover:bg-white sm:right-4 sm:top-4"
            aria-label="Tutup modal">
            &#x2715;
        </button>

        <!-- Grid dua kolom: kiri = gambar, kanan = info -->
        <div class="grid grid-cols-1 md:grid-cols-[46%_54%]">

            <!-- Kolom kiri: Gambar produk -->
            <div class="flex items-center justify-center bg-[#F5EDE4] p-6 md:min-h-[500px] md:p-8">
                <img id="modalImage"
                    src=""
                    alt="Foto produk"
                    class="w-full rounded-2xl object-cover shadow-[0_8px_28px_rgba(92,68,50,0.12)]
                            max-h-[220px] md:max-h-[440px]">
            </div>

            <div class="flex flex-col overflow-hidden p-5 sm:p-7 md:p-8 [font-family:'Poppins',sans-serif]">

                <!-- Label kategori -->
                <p id="modalCategory"
                    class="mb-1 text-[12px] font-bold uppercase tracking-[3.5px] text-[#B08B68]"></p>

                <!-- Nama produk -->
                <h2 id="modalName"
                    class="mb-1 font-bold leading-tight text-[#5c4432] text-[clamp(1.15rem,3.5vw,1.6rem)]"></h2>

                <!-- Harga -->
                <p id="modalPrice"
                    class="mb-4 font-bold text-[#7a5a43] text-[clamp(1.05rem,3vw,1.4rem)]"></p>

                <!-- Deskripsi produk  -->
                <div class="mb-4">
                    <h3 class="mb-1.5 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Deskripsi Produk
                    </h3>
                    <p id="modalDesc"
                        class="text-[0.78rem] leading-[1.75] text-[#8B6F5E] sm:text-[0.83rem]"></p>
                </div>

                <!-- Pilih Ukuran -->
                <div class="mb-2">
                    <h3 class="mb-2 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Pilih Ukuran
                    </h3>
                    <!-- Tombol ukuran (S / M / L / XL) -->
                    <div id="modalSizes" class="flex flex-wrap gap-2"></div>

                    <p id="sizeError"
                        class="mt-1.5 hidden text-[12px] font-semibold text-red-500">
                        Silakan pilih ukuran terlebih dahulu
                    </p>
                </div>

                <div class="mb-4">
                    <h3 class="mb-0.5 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Stok
                    </h3>
                    <p id="modalStock"
                        class="text-[0.78rem] font-medium text-[#A78D78]">
                        Pilih ukuran terlebih dahulu
                    </p>
                </div>

                <!-- Jumlah + tombol + /-->
                <div class="mb-4">
                    <h3 class="mb-2 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Jumlah
                    </h3>
                    <div class="flex items-center gap-3">
                        <!-- Tombol kurang -->
                        <button type="button" onclick="decreaseQty()"
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EDE4DA] text-lg font-bold text-[#5c4432] transition hover:bg-[#DED0C2]">
                            −
                        </button>
                        <!-- Nilai jumlah -->
                        <span id="qtyValue"
                            class="w-8 text-center text-base font-bold text-[#5c4432]">
                            1
                        </span>
                        <!-- Tombol tambah -->
                        <button type="button" onclick="increaseQty()"
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EDE4DA] text-lg font-bold text-[#5c4432] transition hover:bg-[#DED0C2]">
                            +
                        </button>
                    </div>
                    <!-- Peringatan stok maksimum -->
                    <p id="stockWarning"
                        class="mt-1.5 hidden text-[12px] font-semibold text-red-400">
                        Pembelian mencapai batas stok maksimum!
                    </p>
                </div>

                <!-- Tombol aksi: Keranjang dan Beli Sekarang -->
                <div class="mt-auto flex gap-2.5">
                    <button type="button" onclick="addToCart()"
                        class="flex-1 rounded-[14px] bg-[#a78d78] py-3 text-sm font-bold text-white transition-all duration-200 hover:-translate-y-px hover:bg-[#8f7561] hover:shadow-[0_6px_18px_rgba(92,68,50,0.18)]">
                        Tambah Ke Keranjang
                    </button>
                    <button type="button" onclick="buyNow()"
                        class="flex-1 rounded-[14px] bg-[#5c4432] py-3 text-sm font-bold text-white transition-all duration-200 hover:-translate-y-px hover:bg-[#4b3728] hover:shadow-[0_6px_18px_rgba(92,68,50,0.22)]">
                        Beli Sekarang
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<form id="cartForm" action="{{ route('cart.add') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="name" id="cart_name">
    <input type="hidden" name="category" id="cart_category">
    <input type="hidden" name="image" id="cart_image">
    <input type="hidden" name="price" id="cart_price">
    <input type="hidden" name="size" id="cart_size">
    <input type="hidden" name="qty" id="cart_qty">
    <input type="hidden" name="stock" id="cart_stock">
</form>

@endsection

@push('scripts')
<script>
    let currentQty = 1; // Jumlah item yang dipilih
    let currentStock = 0; // Stok ukuran yang dipilih
    let selectedSize = null; // Ukuran yang dipilih (S/M/L/XL)
    let currentProduct = null; // Objek produk yang sedang dibuka

    function initCardAnimations() {
        const cards = document.querySelectorAll('#product-grid .product-card');

        // Animasi cart
        cards.forEach(card => {
            card.classList.remove('card-visible');
            card.style.opacity = '0';
            card.style.transform = 'translateY(24px) scale(0.97)';
            card.style.animationDelay = '';
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;

                const card = entry.target;
                const idx = parseInt(card.dataset.index) || 0;

                card.style.animationDelay = `${idx * 60}ms`;
                card.classList.add('card-visible');
                observer.unobserve(card);
            });
        }, {
            threshold: 0.05
        });

        cards.forEach(card => observer.observe(card));
    }

    function resetProductCards() {
        document.querySelectorAll('#product-grid .product-card').forEach(card => {
            card.classList.remove('card-visible');
            card.style.opacity = '0';
            card.style.transform = 'translateY(24px) scale(0.97)';
            card.style.animationDelay = '';
        });
    }

    function openModalFromElement(el) {
        openModal(JSON.parse(el.dataset.product));
    }

    function openModal(product) {
        // Simpan produk ke state global
        currentProduct = product;
        selectedSize = null;
        currentQty = 1;
        currentStock = 0;

        // Sembunyikan peringatan stok
        document.getElementById('stockWarning').classList.add('hidden');
        document.getElementById('sizeError').classList.add('hidden');

        // Isi konten modal
        document.getElementById('modalName').innerText = product.name;
        document.getElementById('modalCategory').innerText = product.category;
        document.getElementById('modalImage').src = product.image;
        document.getElementById('modalDesc').innerText = product.desc;
        document.getElementById('modalPrice').innerText = 'Rp' + product.price;
        document.getElementById('modalStock').innerText = 'Pilih ukuran';
        document.getElementById('qtyValue').innerText = '1';

        // Render tombol ukuran secara dinamis
        const sizeContainer = document.getElementById('modalSizes');
        sizeContainer.innerHTML = '';

        product.sizes.forEach(size => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = size;
            btn.className = 'size-btn rounded-xl border-[1.5px] border-[#DDD0C4] bg-[#FBF7F3] px-4 py-2 text-xs font-semibold text-[#7A5A43] transition-all duration-150 hover:border-[#B08B68] hover:bg-[#F0E4D8] [font-family:Poppins,sans-serif]';
            btn.onclick = () => selectSize(btn, size);
            sizeContainer.appendChild(btn);
        });

        // Tampilkan modal dengan animasi
        const overlay = document.getElementById('productModal');
        const panel = document.getElementById('productModalPanel');

        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            panel.style.opacity = '1';
            panel.style.transform = 'translateY(0) scale(1)';
        });
    }

    function closeModal() {
        const overlay = document.getElementById('productModal');
        const panel = document.getElementById('productModalPanel');

        // Animasi keluar
        overlay.style.opacity = '0';
        panel.style.opacity = '0';
        panel.style.transform = 'translateY(18px) scale(0.98)';

        // Sembunyikan setelah animasi selesai 
        setTimeout(() => {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }, 260);
    }

    function selectSize(element, size) {
        selectedSize = size;
        document.getElementById('sizeError').classList.add('hidden');

        // Reset semua tombol ukuran ke state default
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('!bg-[#8B5E3C]', '!text-white', '!border-[#8B5E3C]');
        });

        // Tandai tombol yang dipilih
        element.classList.add('!bg-[#8B5E3C]', '!text-white', '!border-[#8B5E3C]');

        // Update stok dan jumlah
        currentStock = parseInt(currentProduct.stock[size]) || 0;
        currentQty = 1;

        document.getElementById('qtyValue').innerText = '1';
        document.getElementById('modalStock').innerText = `${currentStock} pcs tersedia`;
        document.getElementById('stockWarning').classList.add('hidden');
    }

    function increaseQty() {
        if (!selectedSize) {
            showSizeError();
            return;
        }
        if (currentQty < currentStock) {
            document.getElementById('qtyValue').innerText = ++currentQty;
            document.getElementById('stockWarning').classList.add('hidden');
        } else {
            // Tampilkan peringatan jika stok habis
            document.getElementById('stockWarning').classList.remove('hidden');
        }
    }

    function decreaseQty() {
        if (currentQty > 1) {
            document.getElementById('qtyValue').innerText = --currentQty;
            document.getElementById('stockWarning').classList.add('hidden');
        }
    }

    function addToCart() {
        if (!selectedSize) {
            showSizeError();
            return;
        }

        document.getElementById('cart_name').value = currentProduct.name;
        document.getElementById('cart_category').value = currentProduct.category;
        document.getElementById('cart_image').value = currentProduct.image;
        document.getElementById('cart_price').value = String(currentProduct.price).replace(/\./g, '');
        document.getElementById('cart_size').value = selectedSize;
        document.getElementById('cart_qty').value = currentQty;
        document.getElementById('cart_stock').value = currentProduct.stock[selectedSize];

        document.getElementById('cartForm').submit();
    }

    function buyNow() {
        if (!selectedSize) {
            showSizeError();
            return;
        }

        const url = `{{ route('checkout') }}?name=${encodeURIComponent(currentProduct.name)}&price=${currentProduct.price}&qty=${currentQty}`;
        window.location.href = url;
    }

    document.getElementById('sortSelect').addEventListener('change', function() {
        const sortValue = this.value;
        const grid = document.getElementById('product-grid');
        const cards = Array.from(grid.querySelectorAll('.product-card'));

        if (sortValue === 'price-asc') {
            cards.sort((a, b) => +a.dataset.price - +b.dataset.price);
        } else if (sortValue === 'price-desc') {
            cards.sort((a, b) => +b.dataset.price - +a.dataset.price);
        }

        // Reset animasi lalu susun ulang card
        resetProductCards();
        cards.forEach((card, i) => {
            card.dataset.index = i;
            grid.appendChild(card);
        });

        requestAnimationFrame(() => setTimeout(initCardAnimations, 30));
    });

    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // Tutup modal 
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });

    document.addEventListener('DOMContentLoaded', initCardAnimations);

    function showSizeError() {
        const el = document.getElementById('sizeError');
        el.classList.remove('hidden');
    }
</script>

@endpush