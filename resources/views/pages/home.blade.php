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

        html, body {
            overscroll-behavior: none;
        }
    </style>

    <!-- Toast session success -->
    @if (session('success'))
    <div id="cart-toast" class="pointer-events-none fixed right-6 top-6 z-[999] translate-y-3 opacity-0 transition-all duration-500">
        <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
            <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
            <img
                src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=80"
                alt="Banner Velora"
                class="absolute inset-0 h-full w-full object-cover"
            >
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

        <div id="categoryTabs"
            class="flex flex-wrap justify-center gap-[0.45rem] overflow-x-auto scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] sm:overflow-x-visible [&::-webkit-scrollbar]:hidden">

            <!-- Semua -->
            <a href="{{ route('product') }}?category=semua"
                class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                      px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                      sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                <span class="inline-flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full bg-[#F0E7DD] group-hover:bg-white/20 transition-all duration-200">
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
                      px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                      sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                <span class="inline-flex h-[22px] w-[22px] items-center justify-center transition group-hover:scale-110">
                    <svg viewBox="0 0 64 64" fill="none" class="h-full w-full">
                        <path d="M18 18L28 10H36L46 18L54 26L48 36L44 33V54H20V33L16 36L10 26L18 18Z"
                            stroke="currentColor" stroke-width="3.5" stroke-linejoin="round" />
                        <path d="M28 10L32 18L36 10"
                            stroke="currentColor" stroke-width="3.5" stroke-linejoin="round" />
                        <path d="M32 18V54"
                            stroke="currentColor" stroke-width="2.5" />
                        <circle cx="32" cy="26" r="1.5" fill="currentColor" />
                        <circle cx="32" cy="34" r="1.5" fill="currentColor" />
                        <circle cx="32" cy="42" r="1.5" fill="currentColor" />
                        <rect x="36" y="30" width="7" height="6" rx="1.2"
                            stroke="currentColor" stroke-width="2.5" />
                    </svg>
                </span>
                Kemeja
            </a>

            <!-- Gaun -->
            <a href="{{ route('product') }}?category=gaun"
                class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                      px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                      sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                <span class="inline-flex h-[22px] w-[22px] shrink-0 items-center justify-center transition duration-200 group-hover:scale-110">
                    <svg viewBox="0 0 64 64" fill="none" class="h-full w-full">
                        <path d="M25 8 C27 11 29 12 32 12 C35 12 37 11 39 8 L41 22 L36 25 L33 19 H31 L28 25 L23 22 L25 8Z"
                            stroke="currentColor" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M25 25H39" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                        <path d="M25 27 L15 55 C22 58 42 58 49 55 L39 27 Z" stroke="currentColor" stroke-width="3.8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M27 31L24 55M32 31V57M37 31L40 55" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" />
                    </svg>
                </span>
                Gaun
            </a>

            <!-- Cardigan -->
            <a href="{{ route('product') }}?category=cardigan"
                class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                      px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                      sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                <span class="inline-flex h-[22px] w-[22px] items-center justify-center transition group-hover:scale-110">
                    <svg viewBox="0 0 64 64" fill="none" class="h-full w-full">
                        <path d="M20 13L32 19L44 13L54 23L48 36L43 33V54H21V33L16 36L10 23L20 13Z" stroke="currentColor" stroke-width="4" stroke-linejoin="round" />
                        <path d="M32 19V54" stroke="currentColor" stroke-width="3" />
                        <path d="M25 30H30M34 30H39M25 39H30M34 39H39" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        <path d="M26 16L32 25L38 16" stroke="currentColor" stroke-width="3" stroke-linejoin="round" />
                    </svg>
                </span>
                Cardigan
            </a>

            <!-- Rok -->
            <a href="{{ route('product') }}?category=rok"
                class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                      px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                      sm:px-3.5 sm:py-2 sm:text-[0.78rem] bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px">
                <span class="inline-flex h-[22px] w-[22px] items-center justify-center transition group-hover:scale-110">
                    <svg viewBox="0 0 64 64" fill="none" class="h-full w-full">
                        <path d="M22 10H42L44 18H20L22 10Z" stroke="currentColor" stroke-width="4" stroke-linejoin="round" />
                        <path d="M20 18L12 54H52L44 18" stroke="currentColor" stroke-width="4" stroke-linejoin="round" />
                        <path d="M26 18L23 54M32 18V54M38 18L41 54" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </span>
                Rok
            </a>
        </div>
    </section>

    <!-- Produk Terbaru -->
    <section class="mx-auto max-w-7xl px-6 pb-12">
        <h2 class="mb-8 text-2xl font-bold md:text-3xl">Produk Terbaru</h2>

        <div id="product-grid" class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products as $index => $product)
                <div
                    class="product-card group cursor-pointer overflow-hidden rounded-[18px] bg-white shadow-[0_2px_14px_rgba(167,141,120,0.10)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_14px_32px_rgba(167,141,120,0.20)]"
                    data-index="{{ $index }}"
                    data-original-index="{{ $index }}"
                    data-price="{{ str_replace('.', '', $product['price']) }}"
                    data-name="{{ strtolower($product['name']) }}"
                    data-product='@json($product)'
                    onclick="openModalFromElement(this)"
                >
                    <div class="card-thumb overflow-hidden">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" 
                            class="block h-[200px] w-full object-cover transition-transform duration-500 ease-out will-change-transform group-hover:scale-[1.06] md:h-[240px]">
                    </div>

                    <div class="p-4">
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-[3px] text-[#b08b68]">
                            {{ $product['category'] }}
                        </p>

                        <h3 class="mb-1.5 text-[0.94rem] font-semibold leading-snug text-[#5c4432]">
                            {{ $product['name'] }}
                        </h3>

                        <div class="mb-3 flex items-center justify-between gap-1">
                            <p class="text-[1.05rem] font-bold text-[#7a5a43]">
                                Rp{{ number_format((int)str_replace('.', '', $product['price']), 0, ',', '.') }}
                            </p>
                            <p class="text-[12px] font-semibold text-[#b08b68]">
                                {{ $product['sold'] ?? 0 }} terjual
                            </p>
                        </div>

                        <button type="button" class="w-full rounded-2xl bg-[#BFA28C] py-2.5 text-sm font-semibold text-white transition-all duration-200 hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)]">
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

    const isBuyerLoggedIn = @json(session('role') === 'buyer');

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

        const url = `{{ route('checkout') }}?name=${encodeURIComponent(currentProduct.name)}&price=${currentProduct.price}&qty=${currentQty}&size=${encodeURIComponent(selectedSize)}`;
        window.location.href = url;
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('productModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
@endpush

