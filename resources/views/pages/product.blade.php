@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@if(session('success'))
<div id="toast-success"
    class="fixed top-5 right-5 z-[999] rounded-2xl bg-[#5c4432] px-5 py-3 text-sm font-medium text-white shadow-xl">
    {{ session('success') }}
</div>

<script>
    setTimeout(() => {
        document.getElementById('toast-success').remove();
    }, 2000);
</script>
@endif

@php
$products = [
'kemeja' => [
[
'name' => 'Kemeja Stripe',
'category' => 'Kemeja',
'image' => 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
'desc' => 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 10,
'price' => '100.000',
],

[
'name' => 'Kemeja Putih Basic',
'category' => 'Kemeja',
'image' => 'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg',
'desc' => 'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 14,
'price' => '110.000',
],

[
'name' => 'Kemeja Linen Pita',
'category' => 'Kemeja',
'image' => 'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg',
'desc' => 'Kemeja berbahan linen ringan dengan desain feminin dan detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang tetap rapi dan elegan.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 9,
'price' => '145.000',
],

[
'name' => 'Kemeja Slim Fit',
'category' => 'Kemeja',
'image' => 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg',
'desc' => 'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman dan cocok untuk tampilan formal maupun semi formal.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 7,
'price' => '152.000',
],
],

'gaun' => [
[
'name' => 'Gaun Biru Wrap',
'category' => 'Gaun',
'image' => 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg',
'desc' => 'Dress midi wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan katun ringan dan nyaman.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 8,
'price' => '170.000',
],

[
'name' => 'Gaun Ivory',
'category' => 'Gaun',
'image' => 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg',
'desc' => 'Dress wanita dengan desain polos dan kancing depan yang memberikan tampilan rapi dan bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 5,
'price' => '175.000',
],

[
'name' => 'Gaun Floral',
'category' => 'Gaun',
'image' => 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg',
'desc' => 'Dress midi wanita dengan motif floral yang memberikan tampilan feminin dan segar. Menggunakan bahan chiffon ringan yang nyaman dipakai untuk aktivitas santai.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 11,
'price' => '155.000',
],

[
'name' => 'Gaun Stripe',
'category' => 'Gaun',
'image' => 'https://i.pinimg.com/1200x/c0/18/71/c01871e6da2cacfeafe01662046fddda.jpg',
'desc' => 'Dress dengan motif stripe memberikan tampilan rapi dan stylish, dilengkapi kancing depan serta tali pinggang yang bisa disesuaikan untuk membentuk siluet tubuh. Terbuat dari bahan cotton blend dan cocok untuk tampilan kasual hingga semi-formal.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 8,
'price' => '147.000',
],

],
'cardigan' => [
[
'name' => 'Cardigan Rajut Pink',
'category' => 'Cardigan',
'image' => 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
'desc' => 'Cardigan pink dengan desain simpel dan feminin, dilengkapi kancing depan serta detail rib. Terbuat dari bahan rajut cotton blend dan acrylic yang ringan, halus, dan tidak panas, sehingga nyaman digunakan dalam berbagai aktivitas.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 8,
'price' => '90.000',
],

[
'name' => 'Cardigan Knit Cream',
'category' => 'Cardigan',
'image' => 'https://i.pinimg.com/736x/23/2c/97/232c97d74f40e276f4527520494dfc4d.jpg',
'desc' => 'Cardigan cream dengan desain elegan dilengkapi kantong depan dan kancing aksen yang memberi kesan classy. Terbuat dari bahan knit yang lembut, nyaman dipakai, dan memiliki tekstur rapi sehingga terlihat stylish untuk berbagai aktivitas.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 10,
'price' => '112.000',
],

[
'name' => 'Cardigan Pita Biru',
'category' => 'Cardigan',
'image' => 'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg',
'desc' => 'Cardigan dengan detail renda dan pita yang memberikan tampilan feminin dan elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas santai.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 12,
'price' => '95.000',
],

[
'name' => 'Cardigan Floral',
'category' => 'Cardigan',
'image' => 'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg',
'desc' => 'Cardigan bermotif floral dengan desain ringan dan tampilan feminin. Menggunakan bahan knit halus dan memberikan tampilan santai yang tetap menarik dan feminin.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 9,
'price' => '118.000',
],

],
'rok' => [
[
'name' => 'Rok Layer Putih',
'category' => 'Rok',
'image' => 'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg',
'desc' => 'Rok putih dengan desain layer bertingkat yang memberikan tampilan anggun dan feminin. Detail lace menambah kesan elegan dan flowy saat dipakai. Terbuat dari bahan lace dengan furing halus yang lembut.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 12,
'price' => '120.000',
],

[
'name' => 'Rok Polkadot',
'category' => 'Rok',
'image' => 'https://i.pinimg.com/1200x/ce/32/ba/ce32ba61f24f2d19f8c1850586fe348b.jpg',
'desc' => 'Rok putih dengan motif polkadot hitam yang manis dan playful, dilengkapi pinggang karet yang nyaman dipakai. Menggunakan bahan cotton blend yang adem, ringan, dan nyaman.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 7,
'price' => '100.000',
],

[
'name' => 'Rok Pita Biru',
'category' => 'Rok',
'image' => 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg',
'desc' => 'Rok panjang dengan detail pita kecil yang memberikan tampilan manis dan feminin dan terbuat dari bahan katun ringan yang nyaman.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 9,
'price' => '115.000',
],

[
'name' => 'Rok Denim',
'category' => 'Rok',
'image' => 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg',
'desc' => 'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.',
'sizes' => ['S', 'M', 'L', 'XL'],
'stock' => 6,
'price' => '132.000',
],
],
];

$defaultCategory = request('category', 'kemeja');
@endphp

<style>
    .cat-tab {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        font-weight: 500;
        padding: 0.62rem 1rem;
        border-radius: 999px;
        border: none;
        color: #5B4636;
        background: #E8DED3;
        cursor: pointer;
        transition: all 0.22s ease;
        white-space: nowrap;
        text-decoration: none;
    }

    .cat-tab:hover {
        background: #DED1C2;
        transform: translateY(-1px);
    }

    .cat-tab.active {
        background: #E8DED3;
        box-shadow: inset 0 0 0 1px rgba(140, 117, 99, 0.18);
    }

    .cat-icon {
        width: 18px;
        height: 18px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #F0E7DD;
    }

    .cat-tab svg {
        width: 12px;
        height: 12px;
        stroke: #A78D78;
        fill: #A78D78;
    }

    .product-card {
        background: #ffffff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(167, 141, 120, 0.12);
        transition: transform 0.35s ease, box-shadow 0.35s ease, opacity 0.35s ease;
        opacity: 0;
        transform: translateY(28px) scale(0.98);
        will-change: transform, opacity;
    }

    .product-card.show {
        animation: cardReveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .product-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 14px 32px rgba(167, 141, 120, 0.18);
    }

    @keyframes cardReveal {
        0% {
            opacity: 0;
            transform: translateY(28px) scale(0.98);
        }

        60% {
            opacity: 1;
            transform: translateY(-4px) scale(1.01);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .product-card:nth-child(1).show {
        animation-delay: 0.05s;
    }

    .product-card:nth-child(2).show {
        animation-delay: 0.12s;
    }

    .product-card:nth-child(3).show {
        animation-delay: 0.19s;
    }

    .product-card:nth-child(4).show {
        animation-delay: 0.26s;
    }

    .product-card:nth-child(5).show {
        animation-delay: 0.33s;
    }

    .product-card:nth-child(6).show {
        animation-delay: 0.40s;
    }

    .product-card:nth-child(7).show {
        animation-delay: 0.47s;
    }

    .product-card:nth-child(8).show {
        animation-delay: 0.54s;
    }

    #productModal {
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    #productModal.flex {
        opacity: 1;
    }

    #productModal>div {
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    #productModal.flex>div {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    #toast-success,
    #toast {
        animation: toastSlideIn 0.45s ease;
    }

    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateY(-14px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>

<div id="toast"
    class="fixed top-5 right-5 z-[999] hidden rounded-2xl bg-[#5c4432] px-5 py-3 text-sm font-medium text-white shadow-xl">
    Ditambahkan ke keranjang
</div>

<section class="mx-auto max-w-7xl px-6 pt-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="mb-2 text-sm font-semibold uppercase tracking-[4px] text-[#b08b68]">Produk Velora</p>
            <h1 id="pageTitle" class="text-3xl font-bold text-[#5c4432] md:text-4xl">
                {{ ucfirst($defaultCategory) }}
            </h1>
        </div>

        <div>
            <select id="sortSelect"
                class="rounded-2xl border border-[#e0d2c3] bg-[#e8ded3] px-4 py-3 text-sm font-medium text-[#5B4636] outline-none">
                <option value="default">Terbaru</option>
                <option value="price-asc">Harga: Terendah</option>
                <option value="price-desc">Harga: Tertinggi</option>
            </select>
        </div>
    </div>
</section>

<section id="kategori" class="mx-auto max-w-7xl px-6 pb-6 pt-8">
    <div class="flex flex-wrap gap-3" id="categoryTabs">
        <a href="{{ route('product') }}?category=kemeja" class="cat-tab {{ $defaultCategory == 'kemeja' ? 'active' : '' }}">
            <span class="cat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M19 21H5V8l3-2 2 2h4l2-2 3 2z"></path>
                    <path d="M9 6V4h6v2"></path>
                </svg>
            </span>
            Kemeja
        </a>

        <a href="{{ route('product') }}?category=gaun" class="cat-tab {{ $defaultCategory == 'gaun' ? 'active' : '' }}">
            <span class="cat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 4l2 4 4 10H6l4-10 2-4z"></path>
                    <circle cx="12" cy="3.5" r="1.2" fill="#A78D78" stroke="none"></circle>
                </svg>
            </span>
            Gaun
        </a>

        <a href="{{ route('product') }}?category=cardigan" class="cat-tab {{ $defaultCategory == 'cardigan' ? 'active' : '' }}">
            <span class="cat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M7 21V8l3-2 2 2 2-2 3 2v13"></path>
                    <path d="M12 8v13"></path>
                </svg>
            </span>
            Cardigan
        </a>

        <a href="{{ route('product') }}?category=rok" class="cat-tab {{ $defaultCategory == 'rok' ? 'active' : '' }}">
            <span class="cat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 4h6l1 3-1.5 13h-5L8 7z"></path>
                </svg>
            </span>
            Rok
        </a>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 pb-12">
    <div id="product-grid" class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($products[$defaultCategory] as $product)
        <div
            class="product-card cursor-pointer"
            data-price="{{ str_replace('.', '', $product['price']) }}"
            data-name="{{ strtolower($product['name']) }}"
            data-product='@json($product)'
            onclick="openModalFromElement(this)">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-56 w-full object-cover">

            <div class="p-4">
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-[3px] text-[#b08b68]">
                    {{ $product['category'] }}
                </p>

                <h3 class="mb-2 text-xl font-semibold leading-snug text-[#5c4432]">
                    {{ $product['name'] }}
                </h3>

                <p class="mb-3 text-2xl font-bold text-[#7a5a43]">
                    Rp{{ $product['price'] }}
                </p>

                <button type="button"
                    class="w-full rounded-xl bg-[#a78d78] py-2.5 font-medium text-white transition hover:bg-[#8f7561]">
                    Lihat Detail
                </button>
            </div>
        </div>
        @endforeach
    </div>
</section>

<div id="productModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="relative w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-2xl">
        <button onclick="closeModal()" class="absolute right-5 top-4 z-10 text-3xl text-gray-500 hover:text-black">
            &times;
        </button>

        <div class="grid md:grid-cols-2">
            <div class="flex items-center justify-center bg-[#f4ede5] p-6">
                <img id="modalImage" src="" alt="Produk" class="max-h-[500px] w-full rounded-2xl object-cover">
            </div>

            <div class="p-8">
                <p id="modalCategory" class="mb-2 text-xs font-semibold uppercase tracking-[3px] text-[#b08b68]"></p>
                <h2 id="modalName" class="mb-3 text-3xl font-bold text-[#5c4432]"></h2>
                <p id="modalPrice" class="mb-5 text-3xl font-bold text-[#7a5a43]"></p>

                <div class="mb-5">
                    <h3 class="mb-2 font-semibold text-[#5c4432]">Deskripsi Produk</h3>
                    <p id="modalDesc" class="leading-7 text-[#7b6858]"></p>
                </div>

                <div class="mb-5">
                    <h3 class="mb-2 font-semibold text-[#5c4432]">Pilih Ukuran</h3>
                    <div id="modalSizes" class="flex flex-wrap gap-3"></div>
                </div>

                <div class="mb-5">
                    <h3 class="mb-2 font-semibold text-[#5c4432]">Stok</h3>
                    <p id="modalStock" class="text-[#7b6858]"></p>
                </div>

                <div class="mb-6">
                    <h3 class="mb-2 font-semibold text-[#5c4432]">Jumlah</h3>
                    <div class="flex items-center gap-3">
                        <button onclick="decreaseQty()" class="h-11 w-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">-</button>
                        <span id="qtyValue" class="w-10 text-center text-xl font-semibold text-[#5c4432]">1</span>
                        <button onclick="increaseQty()" class="h-11 w-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">+</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <button onclick="addToCart()"
                        class="rounded-2xl bg-[#a78d78] py-3 font-semibold text-white transition hover:bg-[#8f7561]">
                        Tambah ke Keranjang
                    </button>
                    <button onclick="buyNow()"
                        class="rounded-2xl bg-[#5c4432] py-3 font-semibold text-white transition hover:bg-[#4b3728]">
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
    const allProducts = JSON.parse('@json($products)');
    let currentQty = 1;
    let currentStock = 1;
    let selectedSize = null;
    let currentProduct = null;
    let currentCategory = JSON.parse('@json($defaultCategory)');

    function animateProductCards() {
        const cards = document.querySelectorAll('#product-grid .product-card');
        cards.forEach((card) => {
            card.classList.remove('show');
            void card.offsetWidth;
            card.classList.add('show');
        });
    }

    function openModalFromElement(element) {
        const product = JSON.parse(element.dataset.product);
        openModal(product);
    }

    function openModal(product) {
        currentProduct = product;
        selectedSize = null;
        currentQty = 1;
        currentStock = parseInt(product.stock);

        document.getElementById('modalName').innerText = product.name;
        document.getElementById('modalCategory').innerText = product.category;
        document.getElementById('modalImage').src = product.image;
        document.getElementById('modalDesc').innerText = product.desc;
        document.getElementById('modalPrice').innerText = 'Rp' + product.price;
        document.getElementById('modalStock').innerText = product.stock + ' pcs tersedia';
        document.getElementById('qtyValue').innerText = currentQty;

        const sizesContainer = document.getElementById('modalSizes');
        sizesContainer.innerHTML = '';

        product.sizes.forEach(size => {
            sizesContainer.innerHTML += `
                <button
                    type="button"
                    onclick="selectSize(this, '${size}')"
                    class="size-btn rounded-2xl border border-[#d8c3af] bg-[#fbf7f2] px-5 py-3 text-[#6d5644] transition hover:border-[#b08b68] hover:bg-[#efe3d5]">
                    ${size}
                </button>
            `;
        });

        const modal = document.getElementById('productModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function selectSize(element, size) {
        selectedSize = size;

        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('bg-[#a78d78]', 'text-white', 'border-[#a78d78]');
            btn.classList.add('bg-[#fbf7f2]', 'text-[#6d5644]', 'border-[#d8c3af]');
        });

        element.classList.remove('bg-[#fbf7f2]', 'text-[#6d5644]', 'border-[#d8c3af]');
        element.classList.add('bg-[#a78d78]', 'text-white', 'border-[#a78d78]');
    }

    function increaseQty() {
        if (currentQty < currentStock) {
            currentQty++;
            document.getElementById('qtyValue').innerText = currentQty;
        }
    }

    function decreaseQty() {
        if (currentQty > 1) {
            currentQty--;
            document.getElementById('qtyValue').innerText = currentQty;
        }
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.innerText = message;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 2000);
    }

    function addToCart() {
        if (!selectedSize) {
            alert('Silakan pilih size terlebih dahulu.');
            return;
        }

        document.getElementById('cart_name').value = currentProduct.name;
        document.getElementById('cart_category').value = currentProduct.category;
        document.getElementById('cart_image').value = currentProduct.image;
        document.getElementById('cart_price').value = String(currentProduct.price).replace(/\./g, '');
        document.getElementById('cart_size').value = selectedSize;
        document.getElementById('cart_qty').value = currentQty;
        document.getElementById('cart_stock').value = currentProduct.stock;

        document.getElementById('cartForm').submit();
    }

    function buyNow() {
        if (!selectedSize) {
            alert('Silakan pilih size terlebih dahulu.');
            return;
        }

        const url = `{{ route('checkout') }}?name=${currentProduct.name}&price=${currentProduct.price}&qty=${currentQty}`;
        window.location.href = url;
    }

    document.getElementById('sortSelect').addEventListener('change', function() {
        const sortValue = this.value;
        const grid = document.getElementById('product-grid');
        const cards = Array.from(grid.querySelectorAll('.product-card'));

        if (sortValue === 'price-asc') {
            cards.sort((a, b) => parseInt(a.dataset.price) - parseInt(b.dataset.price));
        } else if (sortValue === 'price-desc') {
            cards.sort((a, b) => parseInt(b.dataset.price) - parseInt(a.dataset.price));
        }

        grid.innerHTML = '';
        cards.forEach(card => grid.appendChild(card));

        animateProductCards();
    });

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('productModal');
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        animateProductCards();
    });
</script>
@endpush