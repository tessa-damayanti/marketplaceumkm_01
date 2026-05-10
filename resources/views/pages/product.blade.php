@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<!-- Toast -->
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

@push('scripts')
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

@php

@endphp

<style>
    /* Animasi kartu produk  */
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

    /* Style untuk tombol ukuran yang dipilih */
    .size-btn.active {
        background-color: #BFA28C !important;
        color: white !important;
        border-color: #BFA28C !important;
        box-shadow: 0 4px 12px rgba(191, 162, 140, 0.3);
    }

    html,
    body {
        overscroll-behavior: none;
    }
</style>

<div id="toast"
    class="fixed top-5 right-5 z-[999] hidden items-center gap-2 rounded-2xl bg-[#A98B76] px-5 py-3 text-sm font-medium text-white shadow-xl">
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
        <div class="relative min-[480px]:min-w-[180px]">
            <button id="sortButton" type="button" data-dropdown-toggle="sortMenu" data-dropdown-placement="bottom-end"
                class="flex w-full items-center justify-between gap-2 rounded-xl border border-[#DDD0C4] bg-white px-3 py-2 text-xs font-semibold text-[#7A5A43] outline-none transition-all duration-200 hover:border-[#BFA28C] focus:border-[#BFA28C] focus:ring-2 focus:ring-[#BFA28C]/20 sm:rounded-2xl sm:px-4 sm:py-3 sm:text-sm [font-family:Poppins,sans-serif]">
                <span id="sortLabel">Terbaru</span>
                <svg width="12" height="8" viewBox="0 0 14 8" fill="none" class="transition-transform duration-200" id="sortArrow">
                    <path d="M2 2l5 4 5-4" stroke="#7A5A43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <!-- Menu Dropdown  -->
            <div id="sortMenu"
                class="z-[100] hidden w-[180px] overflow-hidden rounded-xl border border-[#DDD0C4] bg-white shadow-xl">
                <ul>
                    <li>
                        <button type="button" data-value="default" class="sort-option block w-full cursor-pointer px-4 py-2 text-left text-xs font-medium text-[#7A5A43] transition-colors hover:bg-[#BFA28C] hover:text-white sm:py-2.5 sm:text-sm">Terbaru</button>
                    </li>
                    <li>
                        <button type="button" data-value="price-asc" class="sort-option block w-full cursor-pointer px-4 py-2 text-left text-xs font-medium text-[#7A5A43] transition-colors hover:bg-[#BFA28C] hover:text-white sm:py-2.5 sm:text-sm">Harga Termurah</button>
                    </li>
                    <li>
                        <button type="button" data-value="price-desc" class="sort-option block w-full cursor-pointer px-4 py-2 text-left text-xs font-medium text-[#7A5A43] transition-colors hover:bg-[#BFA28C] hover:text-white sm:py-2.5 sm:text-sm">Harga Termahal</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-4 pt-4 sm:px-6 sm:pb-6 sm:pt-5 [font-family:Poppins,sans-serif]">
    <div id="categoryTabs"
        class="flex flex-nowrap gap-[0.45rem] overflow-x-auto scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] sm:flex-wrap sm:overflow-x-visible [&::-webkit-scrollbar]:hidden">

        <!-- Semua -->
        <a href="{{ route('product') }}?category=semua"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                  sm:px-3.5 sm:py-2 sm:text-[0.78rem]
                  {{ $defaultCategory === 'semua'
                       ? 'bg-[#BFA28C] text-white border-[#BFA28C] shadow-[0_4px_14px_rgba(191,162,140,0.35)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px' }}">
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
                  px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                  sm:px-3.5 sm:py-2 sm:text-[0.78rem]
                  {{ $defaultCategory === 'kemeja'
                       ? 'bg-[#BFA28C] text-white border-[#BFA28C] shadow-[0_4px_14px_rgba(191,162,140,0.35)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px' }}">
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
                  sm:px-3.5 sm:py-2 sm:text-[0.78rem]
                  {{ $defaultCategory === 'gaun'
                       ? 'bg-[#BFA28C] text-white border-[#BFA28C] shadow-[0_4px_14px_rgba(191,162,140,0.35)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px' }}">
            <span class="inline-flex h-[22px] w-[22px] shrink-0 items-center justify-center transition duration-200 group-hover:scale-110">
                <svg viewBox="0 0 64 64" fill="none" class="h-full w-full">
                    <path d="M25 8
                 C27 11 29 12 32 12
                 C35 12 37 11 39 8
                 L41 22
                 L36 25
                 L33 19
                 H31
                 L28 25
                 L23 22
                 L25 8Z"
                        stroke="currentColor"
                        stroke-width="3.6"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M25 25H39"
                        stroke="currentColor"
                        stroke-width="4"
                        stroke-linecap="round" />
                    <path d="M25 27
                 L15 55
                 C22 58 42 58 49 55
                 L39 27
                 Z"
                        stroke="currentColor"
                        stroke-width="3.8"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M27 31L24 55M32 31V57M37 31L40 55"
                        stroke="currentColor"
                        stroke-width="2.4"
                        stroke-linecap="round" />
                </svg>
            </span>
            Gaun
        </a>

        <!-- Cardigan -->
        <a href="{{ route('product') }}?category=cardigan"
            class="group inline-flex shrink-0 cursor-pointer items-center gap-[6px] whitespace-nowrap rounded-full border-[1.5px] border-transparent
                  px-2.5 py-1.5 text-[0.72rem] font-semibold no-underline transition-all duration-200
                  sm:px-3.5 sm:py-2 sm:text-[0.78rem]
                  {{ $defaultCategory === 'cardigan'
                       ? 'bg-[#BFA28C] text-white border-[#BFA28C] shadow-[0_4px_14px_rgba(191,162,140,0.35)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px' }}">
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
                  sm:px-3.5 sm:py-2 sm:text-[0.78rem]
                  {{ $defaultCategory === 'rok'
                       ? 'bg-[#BFA28C] text-white border-[#BFA28C] shadow-[0_4px_14px_rgba(191,162,140,0.35)]'
                       : 'bg-[#EDE4DA] text-[#6B4F3A] hover:bg-[#BFA28C] hover:text-white hover:border-[#BFA28C] hover:shadow-[0_4px_14px_rgba(191,162,140,0.25)] hover:-translate-y-px' }}">
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

<section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 [font-family:Poppins,sans-serif]">
    @if(count($displayProducts) > 0)
    <div id="product-grid"
        class="grid grid-cols-2 gap-[0.85rem] md:grid-cols-3 md:gap-5 lg:grid-cols-4 lg:gap-6">

        @foreach ($displayProducts as $index => $product)
        <x-user.product-card :product="$product" :index="$index" />
        @endforeach

    </div>
    @else
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-[#EDE4DA]">
            <svg class="h-10 w-10 text-[#BFA28C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-[#5c4432]">Produk tidak ditemukan</h3>
    </div>
    @endif
</section>

    <x-product-modal />
@endsection