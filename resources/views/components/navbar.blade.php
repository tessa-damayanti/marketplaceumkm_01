<nav class="sticky top-0 z-50 border-b border-[#d8c3af] bg-[#d8c3af]">
    <div class="flex w-full items-center justify-between px-6 py-4">

        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-[#5c4432]">Velora</a>

            <div class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="{{ route('home') }}" id="nav-beranda" class="transition hover:text-[#8f7561] {{ request()->routeIs('home') ? 'font-bold text-[#5c4432]' : '' }}">Beranda</a>
                <a href="{{ route('product') }}" id="nav-kategori" class="transition hover:text-[#8f7561] {{ request()->routeIs('product') ? 'font-bold text-[#5c4432]' : '' }}">Kategori</a>
                <a href="{{ route('home') }}#tentang" id="nav-tentang" class="transition hover:text-[#8f7561]">Tentang</a>
            </div>
        </div>

        <div class="flex items-center gap-5">
            {{-- Search --}}
            <form action="{{ route('product') }}" method="GET" class="relative hidden w-[520px] md:block">
                <input
                    type="text"
                    name="search"
                    id="desktop-search"
                    autocomplete="off"
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
                    @php
                        $cartCount = auth()->check() ? \App\Models\Keranjang::where('user_id', auth()->id())->count() : 0;
                    @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-[#5c4432] text-[10px] font-bold text-white">
                        {{ $cartCount }}
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
            <a href="{{ route('home') }}" id="mobile-nav-beranda" class="py-1 transition hover:text-[#8f7561] {{ request()->routeIs('home') ? 'font-bold text-[#5c4432]' : '' }}">Beranda</a>
            <a href="{{ route('product') }}" id="mobile-nav-kategori" class="py-1 transition hover:text-[#8f7561] {{ request()->routeIs('product') ? 'font-bold text-[#5c4432]' : '' }}">Kategori</a>
            <a href="{{ route('home') }}#tentang" id="mobile-nav-tentang" class="py-1 transition hover:text-[#8f7561]">Tentang</a>
        </div>
        <form action="{{ route('product') }}" method="GET" class="relative mt-2">
            <input type="text" name="search" id="mobile-search" autocomplete="off" placeholder="Cari Produk..." class="w-full rounded-full border border-[#bfa58e] bg-[#fdfaf7] px-5 py-2.5 pl-11 text-sm outline-none focus:border-[#8f7561]">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8b6f58]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="M20 20L17 17"></path></svg>
            </span>
        </form>
    </div>
</nav>

{{-- Auto-search: ketik nama kategori langsung redirect ke kategori --}}
<script>
(function() {
    const categories = @json($categories ?? \App\Models\Kategori::orderBy('id','asc')->pluck('nama'));
    const productUrl = "{{ route('product') }}";
    let autoSearchTimer = null;

    function setupAutoSearch(inputEl) {
        if (!inputEl) return;

        inputEl.addEventListener('input', function() {
            clearTimeout(autoSearchTimer);
            const val = this.value.trim().toLowerCase();
            if (val.length < 2) return;

            autoSearchTimer = setTimeout(function() {
                // Cek apakah ketikan cocok dengan nama kategori
                const matched = categories.find(function(catName) {
                    const catLower = (typeof catName === 'string' ? catName : catName.nama).toLowerCase();
                    return catLower === val
                        || (val.length >= 3 && catLower.includes(val))
                        || (val.length >= 3 && val.includes(catLower));
                });

                if (matched) {
                    const name = (typeof matched === 'string' ? matched : matched.nama).toLowerCase();
                    window.location.href = productUrl + '?category=' + encodeURIComponent(name);
                }
            }, 400); // Tunggu 400ms setelah berhenti mengetik
        });
    }

    setupAutoSearch(document.getElementById('desktop-search'));
    setupAutoSearch(document.getElementById('mobile-search'));
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isHomeRoute = "{{ request()->routeIs('home') ? 'true' : 'false' }}" === "true";

    if (!isHomeRoute) return;

    const navBeranda = document.getElementById('nav-beranda');
    const navTentang = document.getElementById('nav-tentang');
    const mobileBeranda = document.getElementById('mobile-nav-beranda');
    const mobileTentang = document.getElementById('mobile-nav-tentang');

    function setTentangActive(isActive) {
        if (isActive) {
            navBeranda?.classList.remove('font-bold', 'text-[#5c4432]');
            navTentang?.classList.add('font-bold', 'text-[#5c4432]');
            mobileBeranda?.classList.remove('font-bold', 'text-[#5c4432]');
            mobileTentang?.classList.add('font-bold', 'text-[#5c4432]');
        } else {
            navBeranda?.classList.add('font-bold', 'text-[#5c4432]');
            navTentang?.classList.remove('font-bold', 'text-[#5c4432]');
            mobileBeranda?.classList.add('font-bold', 'text-[#5c4432]');
            mobileTentang?.classList.remove('font-bold', 'text-[#5c4432]');
        }
    }

    function checkHash() {
        if (window.location.hash === '#tentang') {
            setTentangActive(true);
        } else {
            setTentangActive(false);
        }
    }

    window.addEventListener('hashchange', checkHash);

    checkHash();

    const tentangSection = document.getElementById('tentang');

    if (tentangSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTentangActive(true);
                    history.replaceState(null, null, '#tentang');
                } else if (window.scrollY < tentangSection.offsetTop - 300) {
                    setTentangActive(false);
                    history.replaceState(null, null, window.location.pathname);
                }
            });
        }, { threshold: 0.3 });

        observer.observe(tentangSection);
    }
});
</script>