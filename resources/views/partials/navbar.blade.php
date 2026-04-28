@php
    $isLogin = true; // ubah ke false kalau mau test kondisi belum login
@endphp

<nav class="sticky top-0 z-50 border-b border-[#d8c3af] bg-[#d8c3af]">
    <div class="flex w-full items-center justify-between px-6 py-4">

        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-[#5c4432]">Velora</a>

            <div class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="{{ route('home') }}" class="transition hover:text-[#8f7561]">Beranda</a>
                <a href="{{ route('product') }}" class="transition hover:text-[#8f7561]">Kategori</a>
                <a href="#tentang" class="transition hover:text-[#8f7561]">Tentang</a>
            </div>
        </div>

        <div class="flex items-center gap-5">
            <form action="{{ route('product') }}" method="GET" class="relative w-[520px]">
                <input type="text" name="search" placeholder="Cari Produk..."
                    class="w-full rounded-full border border-[#bfa58e] bg-[#fdfaf7] px-5 py-2.5 pl-11 text-sm outline-none focus:border-[#8f7561]">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8b6f58]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="M20 20L17 17"></path>
                    </svg>
                </span>
            </form>

            @if (session('isLogin'))

    <a href="{{ route('cart') }}" class="text-[#8b6f58] transition hover:text-[#5c4432]" title="Keranjang">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="1.8">
            <circle cx="9" cy="20" r="1.5"></circle>
            <circle cx="18" cy="20" r="1.5"></circle>
            <path d="M3 4h2l2.2 9.2a1 1 0 0 0 1 .8h8.8a1 1 0 0 0 1-.8L20 7H7"></path>
        </svg>
    </a>

    <a href="{{ route('akun.index') }}" class="text-[#8b6f58] transition hover:text-[#5c4432]"
        title="Akun Saya">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z" />
        </svg>
    </a>

@else

    <a href="{{ route('login') }}"
        class="rounded-full border border-[#8b6f58] bg-white px-5 py-2 text-sm font-medium text-[#5c4432] transition hover:bg-[#f3e7da]">
        Login
    </a>

@endif
            
        </div>
    </div>
</nav>