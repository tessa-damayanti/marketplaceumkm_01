<nav class="sticky top-0 z-50 border-b border-[#d8c3af] bg-[#d8c3af]">
    <div class="flex w-full items-center justify-between px-6 py-4">

        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-[#5c4432]">Velora</a>

            <div class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="{{ route('home') }}" class="transition hover:text-[#8f7561] {{ request()->routeIs('home') ? 'font-bold text-[#5c4432]' : '' }}">Beranda</a>
                <a href="{{ route('product') }}" class="transition hover:text-[#8f7561] {{ request()->routeIs('product') ? 'font-bold text-[#5c4432]' : '' }}">Kategori</a>
                <a href="{{ route('home') }}#tentang" class="transition hover:text-[#8f7561]">Tentang</a>
            </div>
        </div>

        <div class="flex items-center gap-5">
            {{-- Search --}}
            <form action="{{ route('product') }}" method="GET" class="relative hidden w-[520px] md:block">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Produk..."
                    class="w-full rounded-full border border-[#bfa58e] bg-[#fdfaf7] px-5 py-2.5 pl-11 text-sm outline-none focus:border-[#8f7561]"
                >
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8b6f58]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="M20 20L17 17"></path>
                    </svg>
                </span>
            </form>

            @if(session('role') === 'buyer')
                {{-- Cart with badge --}}
                <a href="{{ route('cart') }}" class="relative text-[#8b6f58] transition hover:text-[#5c4432]" title="Keranjang">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="9" cy="20" r="1.5"></circle>
                        <circle cx="18" cy="20" r="1.5"></circle>
                        <path d="M3 4h2l2.2 9.2a1 1 0 0 0 1 .8h8.8a1 1 0 0 0 1-.8L20 7H7"></path>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-[#5c4432] text-[10px] font-bold text-white">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>

                {{-- Profile --}}
                <a href="{{ route('profile') }}" class="text-[#8b6f58] transition hover:text-[#5c4432]" title="Profil Saya">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z"/>
                    </svg>
                </a>
            @else
                {{-- Login (If not logged in) --}}
                <a href="{{ route('login') }}" class="flex items-center justify-center rounded-full bg-white px-8 py-2.5 text-sm font-bold text-[#5c4432] transition hover:bg-[#BFA28C] hover:shadow-md active:scale-95" title="Login">
                    Login
                </a>
            @endif

            {{-- Mobile hamburger --}}
            <button class="flex items-center md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <svg class="h-6 w-6 text-[#5c4432]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

    </div>

    {{-- Mobile menu --}}
    <div id="mobileMenu" class="hidden border-t border-[#c9a882] bg-[#d8c3af] px-6 pb-4 md:hidden">
        <div class="flex flex-col gap-3 py-3 text-sm font-medium">
            <a href="{{ route('home') }}" class="py-1 transition hover:text-[#8f7561]">Beranda</a>
            <a href="{{ route('product') }}" class="py-1 transition hover:text-[#8f7561]">Kategori</a>
            <a href="{{ route('home') }}#tentang" class="py-1 transition hover:text-[#8f7561]">Tentang</a>
        </div>
        <form action="{{ route('product') }}" method="GET" class="relative mt-2">
            <input type="text" name="search" placeholder="Cari Produk..." class="w-full rounded-full border border-[#bfa58e] bg-[#fdfaf7] px-5 py-2.5 pl-11 text-sm outline-none focus:border-[#8f7561]">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8b6f58]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="M20 20L17 17"></path></svg>
            </span>
        </form>
    </div>
</nav>