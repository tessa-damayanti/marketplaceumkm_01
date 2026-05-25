@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Data $products disediakan oleh ProductController::home() --}}

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

        html,
        body {
            overscroll-behavior: none;
        }
    </style>

    <meta name="is-buyer" content="{{ session('role') === 'buyer' ? 'true' : 'false' }}">

    <!-- Toast session success -->
    @if (session('success'))
        <div id="cart-toast"
            class="pointer-events-none fixed right-6 top-6 z-[999] translate-y-3 opacity-0 transition-all duration-500">
            <div
                class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
                <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-[#5c4432]">Berhasil</p>
                    <p class="mt-1 text-sm leading-6 text-[#7b6858]">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = document.getElementById('cart-toast');
                if (toast) {
                    requestAnimationFrame(() => {
                        toast.classList.remove('opacity-0', 'translate-y-3');
                        toast.classList.add('opacity-100', 'translate-y-0');
                    });
                    setTimeout(() => {
                        toast.classList.add('opacity-0', 'translate-y-3');
                        toast.classList.remove('opacity-100', 'translate-y-0');
                        setTimeout(() => toast.remove(), 500);
                    }, 3000);
                }
            });
        </script>
    @endif

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

        <div class="relative flex items-center gap-2">
            {{-- Arrow Kiri --}}
            <button id="cat-prev-home"
                class="hidden shrink-0 h-9 w-9 items-center justify-center rounded-full bg-white border border-[#e2d4c5] shadow-sm text-[#6B4F3A] transition hover:bg-[#EDE4DA] hover:shadow-md"
                onclick="scrollCatHome(-1)">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            </button>

            <div id="categoryTabs"
                class="flex gap-[0.45rem] overflow-hidden scroll-smooth"
                style="max-width: 100%;">

                @foreach($categories as $cat)
                    @php $catLower = strtolower($cat->nama); @endphp
                    <a href="{{ route('product') }}?category={{ $catLower }}"
                        class="cat-tab-home group inline-flex shrink-0 cursor-pointer items-center gap-[6px] text-center break-words rounded-full border-[1.5px] border-transparent
                                  w-[100px] max-w-[100px] min-h-[42px] px-4 py-2 justify-center text-[0.72rem] font-semibold no-underline transition-all duration-200
                                  sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                        {{ $cat->nama }}
                    </a>
                @endforeach
            </div>

            {{-- Arrow Kanan --}}
            <button id="cat-next-home"
                class="hidden shrink-0 h-9 w-9 items-center justify-center rounded-full bg-white border border-[#e2d4c5] shadow-sm text-[#6B4F3A] transition hover:bg-[#EDE4DA] hover:shadow-md"
                onclick="scrollCatHome(1)">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6"/></svg>
            </button>
        </div>
    </section>

    <script>
    (function() {
        const MAX_VISIBLE = 10;
        const container = document.getElementById('categoryTabs');
        const tabs = Array.from(container.querySelectorAll('.cat-tab-home'));
        const prevBtn = document.getElementById('cat-prev-home');
        const nextBtn = document.getElementById('cat-next-home');
        let currentOffset = 0;

        function updateVisibility() {
            tabs.forEach((tab, i) => {
                tab.style.display = (i >= currentOffset && i < currentOffset + MAX_VISIBLE) ? '' : 'none';
            });
            // Show/hide arrows
            const needArrows = tabs.length > MAX_VISIBLE;
            prevBtn.classList.toggle('hidden', !needArrows);
            nextBtn.classList.toggle('hidden', !needArrows);
            prevBtn.style.display = needArrows ? 'inline-flex' : 'none';
            nextBtn.style.display = needArrows ? 'inline-flex' : 'none';
            prevBtn.disabled = currentOffset === 0;
            prevBtn.style.opacity = currentOffset === 0 ? '0.4' : '1';
            nextBtn.disabled = currentOffset + MAX_VISIBLE >= tabs.length;
            nextBtn.style.opacity = currentOffset + MAX_VISIBLE >= tabs.length ? '0.4' : '1';
        }

       window.scrollCatHome = function(dir) {
    currentOffset = Math.max(
        0,
        Math.min(currentOffset + (dir * MAX_VISIBLE), tabs.length - MAX_VISIBLE)
    );

    updateVisibility();
};

        updateVisibility();
    })();
    </script>

    <!-- Produk Terbaru -->
    <section class="mx-auto max-w-7xl px-6 pb-12">
        <div class="mb-8 flex items-center gap-4">
    <h2 class="text-2xl font-bold md:text-3xl">Produk Terbaru</h2>

    <a href="{{ route('product') }}?category=semua"
       class="mt-2 text-sm font-semibold text-[#000000] no-underline transition hover:text-[#6B4F3A] hover:underline">
       Lihat semua
    </a>
</div>

        <div id="product-grid" class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products as $index => $product)
                <x-user.product-card :product="$product" :index="$index" />
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

    <x-product-modal />
    @push('scripts')
        <script src="{{ asset('js/product.js') }}"></script>
    @endpush
@endsection

@push('scripts')
    <script>
        let currentQty = 1;
        let currentStock = 1;
        let selectedSize = null;
        let currentProduct = null;

       const isBuyerLoggedIn = document.querySelector('meta[name="is-buyer"]').content === 'true';

        function requireBuyerLogin() {
            if (!isBuyerLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return false;
            }

            return true;
        }

        function openModal(product) {
            currentProduct = product;
            selectedSize = null;
            currentQty = 1;
            currentStock = 0;

            document.getElementById('modalName').innerText = product.name;
            document.getElementById('modalCategory').innerText = product.category;
            document.getElementById('modalImage').src = product.image;
            document.getElementById('modalDesc').innerText = product.desc;
            document.getElementById('modalPrice').innerText = 'Rp' + Number(product.price).toLocaleString('id-ID');
            document.getElementById('modalStock').innerText = 'Pilih ukuran';
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

            currentStock = parseInt(currentProduct.stock[size]) || 0;
            currentQty = 1;
            document.getElementById('modalStock').innerText = currentStock + ' pcs tersedia';
            document.getElementById('qtyValue').innerText = currentQty;
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

        function addToCart() {
            if (!requireBuyerLogin()) return;

            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.add") }}';

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);

            const fields = {
                name: currentProduct.name,
                category: currentProduct.category,
                price: currentProduct.price,
                size: selectedSize,
                qty: currentQty,
                stock: currentProduct.stock[selectedSize],
                image: currentProduct.image
            };

            Object.entries(fields).forEach(([k, v]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = k;
                input.value = v;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        function buyNow() {
            if (!requireBuyerLogin()) return;

            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }

            const url =
                `{{ route('checkout') }}?name=${encodeURIComponent(currentProduct.name)}` +
                `&price=${currentProduct.price}` +
                `&qty=${currentQty}` +
                `&size=${encodeURIComponent(selectedSize)}` +
                `&image=${encodeURIComponent(currentProduct.image)}`;

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