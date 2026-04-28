@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    @php
        $products = [
            [
                'id' => 1,
                'name' => 'Kemeja Stripe',
                'category' => 'Kemeja',
                'image' => 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                'desc' => 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 10,
                'price' => 100000,
            ],
            [
                'id' => 2,
                'name' => 'Gaun Biru Wrap',
                'category' => 'Gaun',
                'image' => 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg',
                'desc' => 'Dress midi wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan ringan dan nyaman.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 8,
                'price' => 170000,
            ],
            [
                'id' => 3,
                'name' => 'Cardigan Rajut Pink',
                'category' => 'Cardigan',
                'image' => 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
                'desc' => 'Cardigan rajut dengan tekstur lembut dan warna feminin. Cocok untuk tampilan kasual yang tetap manis dan nyaman dipakai.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 10,
                'price' => 112000,
            ],
            [
                'id' => 4,
                'name' => 'Rok Midi A-line',
                'category' => 'Rok',
                'image' => 'https://i.pinimg.com/1200x/93/a8/b8/93a8b826cf1dbc2ed088b009718e5df8.jpg',
                'desc' => 'Rok midi dengan potongan A-line yang sederhana dan rapi. Nyaman digunakan untuk aktivitas sehari-hari dengan tampilan elegan.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 12,
                'price' => 100000,
            ],
        ];
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
    </style>

    <div id="toast"
        class="fixed top-5 right-5 z-[999] hidden rounded-2xl bg-[#5c4432] px-5 py-3 text-sm font-medium text-white shadow-xl">
        Ditambahkan ke keranjang
    </div>

    <!-- Banner -->
    <section class="mx-auto max-w-7xl px-6 pt-8">
        <div class="relative min-h-[300px] overflow-hidden rounded-[32px] md:min-h-[380px]">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=80"
                alt="Banner Velora" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-[#5c4432]/40"></div>

            <div class="relative z-10 flex min-h-[300px] items-center justify-center px-8 text-center md:min-h-[380px]">
                <div class="max-w-3xl text-white">
                    <h1 class="mb-4 text-4xl font-bold leading-tight md:text-6xl">
                        Temukan Fashion Wanita Favoritmu
                    </h1>
                    <p class="text-base leading-8 text-white/90 md:text-xl">
                        Koleksi kemeja, gaun, cardigan, dan rok dengan gaya modern, nyaman, dan elegan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori -->
    <section id="kategori" class="mx-auto max-w-7xl px-6 pb-6 pt-8">
        <h2 class="mb-5 text-center text-2xl font-bold md:text-3xl">Kategori</h2>

        <div class="flex flex-wrap justify-center gap-3" id="categoryTabs">
            <a href="{{ route('product') }}?category=kemeja" class="cat-tab active">
                <span class="cat-icon">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#A78D78" stroke-width="1.3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M1 4l3-2 2 2h4l2-2 3 2-2 3h-2v7H5V7H3L1 4z" />
                    </svg>
                </span>
                Kemeja
            </a>

            <a href="{{ route('product') }}?category=gaun" class="cat-tab">
                <span class="cat-icon">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#A78D78" stroke-width="1.3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M6 1h4" />
                        <path d="M8 1v3" />
                        <path d="M5 4L3 15h10L11 4" />
                        <path d="M5 4Q8 7 11 4" />
                    </svg>
                </span>
                Gaun
            </a>

            <a href="{{ route('product') }}?category=cardigan" class="cat-tab">
                <span class="cat-icon">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#A78D78" stroke-width="1.3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M1 4l3-2 2 2 1 1 1-1 2-2 3 2-1 3H10v7H6V7H4L1 4z" />
                        <path d="M6 7v7" />
                        <path d="M10 7v7" />
                    </svg>
                </span>
                Cardigan
            </a>

            <a href="{{ route('product') }}?category=rok" class="cat-tab">
                <span class="cat-icon">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#A78D78" stroke-width="1.3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="4" y="1" width="8" height="3" rx="1" />
                        <path d="M4 4l-2 11h12L12 4" />
                    </svg>
                </span>
                Rok
            </a>
        </div>
    </section>

    <!-- Produk Terbaru -->
    <section class="mx-auto max-w-7xl px-6 pb-12">
        <h2 class="mb-8 text-2xl font-bold md:text-3xl">Produk Terbaru</h2>

        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products as $product)
                <div class="cursor-pointer overflow-hidden rounded-[28px] bg-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    onclick='openModal(@json($product))'>
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-56 w-full object-cover">

                    <div class="p-4">
                        <p class="mb-2 text-[11px] font-semibold uppercase tracking-[3px] text-[#b08b68]">
                            {{ $product['category'] }}
                        </p>

                        <h3 class="mb-2 text-xl font-semibold leading-snug text-[#5c4432]">
                            {{ $product['name'] }}
                        </h3>

                        <p class="mb-3 text-2xl font-bold text-[#7a5a43]">
                            Rp{{ number_format($product['price'], 0, ',', '.') }}
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

    <!-- Tentang -->
    <section id="tentang" class="mx-auto max-w-7xl px-6 pb-4">
        <div class="rounded-[32px] bg-[#e9ddd0] px-8 py-10 md:px-12 md:py-12">
            <div class="grid items-center gap-8 md:grid-cols-2">
                <div>
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[4px] text-[#b08b68]">
                        Tentang Velora
                    </p>
                    <h2 class="text-3xl font-bold md:text-4xl">
                        Fashion wanita yang modern, nyaman, dan elegan.
                    </h2>
                </div>
                <div>
                    <p class="leading-8 text-[#7b6858]">
                        Velora adalah toko fashion wanita yang menyediakan berbagai pilihan pakaian seperti
                        kemeja, gaun, cardigan, dan rok dengan model modern dan harga terjangkau.
                        Kami hadir untuk membantu pelanggan menemukan outfit yang nyaman, stylish,
                        dan sesuai kebutuhan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Produk -->
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
                            <button onclick="decreaseQty()"
                                class="h-11 w-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">-</button>
                            <span id="qtyValue" class="w-10 text-center text-xl font-semibold text-[#5c4432]">1</span>
                            <button onclick="increaseQty()"
                                class="h-11 w-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">+</button>
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
@endsection

@push('scripts')
    <script>
        let currentQty = 1;
        let currentStock = 1;
        let selectedSize = null;
        let currentProduct = null;

        function openModal(product) {
            currentProduct = product;
            selectedSize = null;
            currentQty = 1;
            currentStock = parseInt(product.stock);

            document.getElementById('modalName').innerText = product.name;
            document.getElementById('modalCategory').innerText = product.category;
            document.getElementById('modalImage').src = product.image;
            document.getElementById('modalDesc').innerText = product.desc;
            document.getElementById('modalPrice').innerText = 'Rp' + Number(product.price).toLocaleString('id-ID');
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

            showToast('Ditambahkan ke keranjang');
            closeModal();
        }

        function buyNow() {
            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }

            const url = `{{ route('checkout') }}?name=${currentProduct.name}&price=${currentProduct.price}&qty=${currentQty}`;
            window.location.href = url;
        }

        window.addEventListener('click', function (event) {
            const modal = document.getElementById('productModal');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
@endpush