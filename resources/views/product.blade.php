<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velora — Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    @vite('resources/css/app.css')
    <style>
        :root {
            --cream: #E1D4C2;
            --soft: #F5EFE7;
            --accent: #A78D78;
            --accent-dark: #8C7563;
            --text-main: #5B4636;
            --text-soft: #8A7463;
            --white: #FFFFFF;
            --dark-header: #6B3A2A;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--soft);
            color: var(--text-main);
            margin: 0;
        }

        h1,
        h2,
        h3,
        .brand {
            font-family: 'Cormorant Garamond', serif;
        }

        /* NAV */
        nav {
            background: var(--dark-header);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .search-input {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-main);
            width: 100%;
        }

        .search-input::placeholder {
            color: #B8A899;
        }

        /* CATEGORY TABS */
        .cat-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 0.5rem 1.1rem;
            border-radius: 999px;
            border: 1.5px solid #D8C7B8;
            color: var(--text-main);
            background: var(--white);
            cursor: pointer;
            transition: all 0.22s ease;
            white-space: nowrap;
        }

        .cat-tab:hover {
            background: #EADFD6;
            border-color: var(--accent);
        }

        .cat-tab.active {
            background: var(--text-main);
            border-color: var(--text-main);
            color: var(--white);
            box-shadow: 0 4px 14px rgba(91, 70, 54, 0.22);
        }

        .cat-tab.active svg {
            stroke: white !important;
        }

        /* SORT */
        .sort-select {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            padding: 0.5rem 2.2rem 0.5rem 1rem;
            border-radius: 999px;
            border: 1.5px solid #D8C7B8;
            background: var(--white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%235B4636' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
            appearance: none;
            color: var(--text-main);
            cursor: pointer;
            font-weight: 500;
        }

        /* CARDS */
        .product-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #EDE0D4;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            animation: fadeIn 0.35s ease both;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 36px rgba(167, 141, 120, 0.18);
        }

        .product-card img {
            width: 100%;
            height: 270px;
            object-fit: cover;
            display: block;
        }

        .heart-btn {
            position: absolute;
            top: 9px;
            right: 9px;
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .heart-btn:hover {
            background: #fce8e0;
        }

        .heart-btn.liked svg {
            fill: #e05050;
            stroke: #e05050;
        }

        /* MODAL */
        #productModal {
            backdrop-filter: blur(6px);
        }

        .modal-inner {
            background: var(--white);
            border-radius: 24px;
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            position: relative;
            box-shadow: 0 30px 80px rgba(91, 70, 54, 0.2);
            animation: slideUp 0.28s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(22px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .size-btn {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            border: 1.5px solid var(--cream);
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--accent);
            background: var(--soft);
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .size-btn:hover {
            background: #EADFD6;
            border-color: var(--accent);
        }

        .size-btn.selected {
            background: var(--text-main);
            border-color: var(--text-main);
            color: white;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--cream);
            border: none;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: background 0.18s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #CDB89E;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card:nth-child(1) {
            animation-delay: 0.03s;
        }

        .product-card:nth-child(2) {
            animation-delay: 0.08s;
        }

        .product-card:nth-child(3) {
            animation-delay: 0.13s;
        }

        .product-card:nth-child(4) {
            animation-delay: 0.18s;
        }

        /* FOOTER */
        footer {
            background: var(--dark-header);
            color: #E8D5C5;
        }

        footer a {
            color: #C4A99A;
            transition: color 0.2s;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        .wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #25D366;
            color: white !important;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.6rem 1.3rem;
            border-radius: 999px;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
        }

        .wa-btn:hover {
            background: #1ebe5d;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="px-6 py-3">
        <div class="max-w-6xl mx-auto flex items-center gap-5">

            <a href="#" style="text-decoration:none;">
                <span class="brand text-white shrink-0" style="font-size:1.85rem;font-weight:500;">Velora</span>
            </a>

            <div class="hidden md:flex gap-6 shrink-0 text-sm" style="color:#D4B8A5;">
                <a href="#" class="hover:text-white transition">Beranda</a>
                <a href="#" class="hover:text-white transition">Kategori</a>
                <a href="#" class="hover:text-white transition">Tentang</a>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 mx-2">
                <div class="flex items-center gap-2 bg-white rounded-full px-4 py-2 shadow-sm" style="max-width:400px;margin:0 auto;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B8A899" stroke-width="2.2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input class="search-input" type="text" placeholder="Cari Produk..." oninput="filterSearch(this.value)">
                </div>
            </div>

            <!-- Icons -->
            <div class="flex items-center gap-4 shrink-0" style="color:#D4B8A5;">
                <button class="hover:text-white transition relative">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 01-8 0" />
                    </svg>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full text-white text-[9px] flex items-center justify-center font-bold" style="background:#A78D78;">0</span>
                </button>
                <button class="hover:text-white transition">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- PAGE TITLE -->
    <div class="px-6 pt-7 pb-1 max-w-6xl mx-auto">
        <h1 id="pageTitle" class="font-light tracking-wide" style="font-family:'Cormorant Garamond',serif;font-size:2.6rem;color:#5B4636;">
            Kemeja
        </h1>
    </div>

    <!-- MAIN -->
    <main class="max-w-6xl mx-auto px-6 py-6">

        <!-- FILTER ROW -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-7">
            <div class="flex flex-wrap gap-2" id="categoryTabs">

                <button class="cat-tab active" data-cat="kemeja" onclick="showCategory('kemeja', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5B4636" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z" />
                    </svg>
                    Kemeja
                </button>

                <button class="cat-tab" data-cat="gaun" onclick="showCategory('gaun', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5B4636" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l-3.5 6h7L12 2z" />
                        <path d="M8.5 8L4 22h16L15.5 8" />
                    </svg>
                    Gaun
                </button>

                <button class="cat-tab" data-cat="cardigan" onclick="showCategory('cardigan', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5B4636" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 7l4-3 5 4 5-4 4 3v4l-3 1v8H6V12L3 11V7z" />
                    </svg>
                    Cardigan
                </button>

                <button class="cat-tab" data-cat="rok" onclick="showCategory('rok', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5B4636" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="6" y="2" width="12" height="5" rx="1" />
                        <path d="M6 7l-3 15h18L18 7" />
                    </svg>
                    Rok
                </button>
            </div>

            <select class="sort-select" onchange="sortProducts(this.value)">
                <option value="default">Terbaru</option>
                <option value="price-asc">Harga: Terendah</option>
                <option value="price-desc">Harga: Tertinggi</option>
            </select>
        </div>

        <!-- GRID -->
        <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5"></div>

        <div id="empty-state" class="hidden text-center py-16" style="color:#B8A899;">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-3">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <p class="text-sm">Produk tidak ditemukan</p>
        </div>
    </main>

    <!--MODAL-->
    <div id="productModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4 py-8">
        <div class="modal-inner">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 z-50 w-9 h-9 bg-white rounded-full flex items-center justify-center hover:bg-[#F5EFE7] transition text-2xl shadow-md"
                style="color:#5B4636;line-height:1;">×</button>

            <div class="grid md:grid-cols-2">
                <div class="flex items-center justify-center p-4" style="background:#F5EFE7;min-height:360px;">
                    <img id="modalImage" src="" alt="Produk" class="w-full object-cover" style="max-height:460px;border-radius:14px;">
                </div>

                <div class="p-7 overflow-y-auto" style="max-height:88vh;">
                    <p id="modalCategory" class="text-[10px] tracking-[3px] uppercase font-medium mb-1" style="color:#A78D78;"></p>
                    <h2 id="modalName" class="font-normal mb-1" style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:#5B4636;"></h2>
                    <p id="modalPrice" class="font-semibold mb-5" style="font-size:1.4rem;color:#8C7563;"></p>

                    <div class="mb-4">
                        <p class="text-xs font-medium uppercase tracking-widest mb-1.5" style="color:#A78D78;">Deskripsi</p>
                        <p id="modalDesc" class="text-sm leading-7" style="color:#8A7463;"></p>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs font-medium uppercase tracking-widest mb-2" style="color:#A78D78;">Pilih Ukuran</p>
                        <div id="modalSizes" class="flex flex-wrap gap-2"></div>
                    </div>

                    <div class="mb-5">
                        <p class="text-xs font-medium uppercase tracking-widest mb-1.5" style="color:#A78D78;">Stok</p>
                        <p id="modalStock" class="text-sm" style="color:#8A7463;"></p>
                    </div>

                    <div class="mb-6">
                        <p class="text-xs font-medium uppercase tracking-widest mb-2" style="color:#A78D78;">Jumlah</p>
                        <div class="flex items-center gap-3">
                            <button class="qty-btn" onclick="decreaseQty()">−</button>
                            <span id="qtyValue" class="text-xl font-semibold w-8 text-center" style="color:#5B4636;">1</span>
                            <button class="qty-btn" onclick="increaseQty()">+</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="addToCart()" class="py-3 rounded-xl font-medium text-sm text-white transition"
                            style="background:#A78D78;" onmouseover="this.style.background='#8C7563'" onmouseout="this.style.background='#A78D78'">
                            Tambah Ke Keranjang
                        </button>
                        <button onclick="buyNow()" class="py-3 rounded-xl font-medium text-sm text-white transition"
                            style="background:#5B4636;" onmouseover="this.style.background='#47372B'" onmouseout="this.style.background='#5B4636'">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-16">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- Brand -->
                <div>
                    <span class="brand text-white" style="font-size:2rem;font-weight:500;">Velora</span>
                    <p class="mt-3 text-sm leading-6" style="color:#C4A99A;">
                        Marketplace UMKM fashion wanita pilihan. Kami menghadirkan koleksi pakaian berkualitas dari kemeja, gaun, cardigan, dan rok untuk tampilan yang elegan dan nyaman.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 rounded-full flex items-center justify-center hover:opacity-80 transition" style="background:rgba(255,255,255,0.12);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8D5C5" stroke-width="1.8">
                                <rect x="2" y="2" width="20" height="20" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="0.8" fill="#E8D5C5" />
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full flex items-center justify-center hover:opacity-80 transition" style="background:rgba(255,255,255,0.12);">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="#E8D5C5">
                                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.77 1.52V6.69a4.85 4.85 0 01-1 0z" />
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full flex items-center justify-center hover:opacity-80 transition" style="background:rgba(255,255,255,0.12);">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#E8D5C5" stroke-width="1.8">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Kategori -->
                <div>
                    <h3 class="text-white font-semibold mb-4 text-sm tracking-widest uppercase">Kategori</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" onclick="return showCategoryFromFooter('kemeja')" class="flex items-center gap-2 hover:text-white transition">
                                <span class="w-1.5 h-1.5 rounded-full inline-block shrink-0" style="background:#A78D78;"></span> Kemeja
                            </a></li>
                        <li><a href="#" onclick="return showCategoryFromFooter('gaun')" class="flex items-center gap-2 hover:text-white transition">
                                <span class="w-1.5 h-1.5 rounded-full inline-block shrink-0" style="background:#A78D78;"></span> Gaun
                            </a></li>
                        <li><a href="#" onclick="return showCategoryFromFooter('cardigan')" class="flex items-center gap-2 hover:text-white transition">
                                <span class="w-1.5 h-1.5 rounded-full inline-block shrink-0" style="background:#A78D78;"></span> Cardigan
                            </a></li>
                        <li><a href="#" onclick="return showCategoryFromFooter('rok')" class="flex items-center gap-2 hover:text-white transition">
                                <span class="w-1.5 h-1.5 rounded-full inline-block shrink-0" style="background:#A78D78;"></span> Rok
                            </a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-white font-semibold mb-4 text-sm tracking-widest uppercase">Hubungi Kami</h3>
                    <p class="text-sm mb-4 leading-6" style="color:#C4A99A;">
                        Ada pertanyaan seputar produk, pemesanan, atau pengiriman? Hubungi kami langsung via WhatsApp kami siap membantu!
                    </p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="wa-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Chat via WhatsApp
                    </a>
                </div>
            </div>

            <div class="mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-xs" style="color:#9A8070;border-top:1px solid rgba(255,255,255,0.1);">
                <p>© 2026 Velora. Marketplace UMKM Fashion Wanita Indonesia.</p>
            </div>
        </div>
    </footer>

    <script>
        const products = {
            kemeja: [{
                    name: 'Kemeja Stripe',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                    desc: 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 10,
                    price: '100.000'
                },
                {
                    name: 'Kemeja Putih Basic',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg',
                    desc: 'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 14,
                    price: '110.000'
                },
                {
                    name: 'Kemeja Linen Pita',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg',
                    desc: 'Kemeja berbahan linen ringan dengan desain feminin dan detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang tetap rapi dan elegan.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '145.000'
                },
                {
                    name: 'Kemeja Slim Fit',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg',
                    desc: 'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman dan cocok untuk tampilan formal maupun semi formal.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 7,
                    price: '152.000'
                }
            ],
            gaun: [{
                    name: 'Gaun Biru Wrap',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg',
                    desc: 'Dress midi wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan katun ringan dan nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '170.000'
                },
                {
                    name: 'Gaun Ivory',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg',
                    desc: 'Dress wanita dengan desain polos dan kancing depan yang memberikan tampilan rapi dan bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 5,
                    price: '175.000'
                },
                {
                    name: 'Gaun Floral',
                    category: 'Gaun',
                    image: 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg',
                    desc: 'Dress midi wanita dengan motif floral yang memberikan tampilan feminin dan segar. Menggunakan bahan chiffon ringan yang nyaman dipakai untuk aktivitas santai.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 11,
                    price: '155.000'
                },
                {
                    name: 'Gaun Midi Biru',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/1200x/b7/71/41/b7714197aa110db547613c08e9bf5edb.jpg',
                    desc: 'Dress wanita dengan desain minimalis ala Korean style yang memberikan tampilan manis dan rapi. Terbuat dari bahan katun ringan yang nyaman digunakan sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '147.000'
                }
            ],
            cardigan: [{
                    name: 'Cardigan Knit Cream',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/06/d9/af/06d9af1a9fa1a2e6f85bda67ddc5b30c.jpg',
                    desc: 'Cardigan rajut warna cream dengan detail tali di bagian depan yang memberikan tampilan simpel dan manis. Terbuat dari bahan knit lembut dan hangat.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '90.000'
                },
                {
                    name: 'Cardigan Rajut Pink',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/46/91/61/4691615a5685cfc9785a8dc6ce04a0e5.jpg',
                    desc: 'Cardigan rajut dengan tekstur cable knit yang lembut dan warna pink yang feminin. Menggunakan bahan rajut hangat yang nyaman untuk tampilan kasual sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 10,
                    price: '112.000'
                },
                {
                    name: 'Cardigan Pita Biru',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg',
                    desc: 'Cardigan dengan detail renda dan pita yang memberikan tampilan feminin dan elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas santai.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 12,
                    price: '95.000'
                },
                {
                    name: 'Cardigan Floral',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/11/d7/51/11d751ea4f28b895cca8f7acdb0ffcc7.jpg',
                    desc: 'Cardigan bermotif floral dengan desain ringan dan tampilan feminin. Menggunakan bahan knit halus dan memberikan tampilan santai yang tetap menarik dan feminin.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '118.000'
                }
            ],
            rok: [{
                    name: 'Rok Midi A-line',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/9e/af/46/9eaf465a3d23d2c7ca0faa9f232ad980.jpg',
                    desc: 'Rok midi dengan potongan A-line yang sederhana dan rapi. Terbuat dari bahan katun ringan yang nyaman digunakan untuk aktivitas sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 12,
                    price: '100.000'
                },
                {
                    name: 'Rok Ruffle Layer Pink',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/1200x/51/77/97/517797ca83ffd194e823cf35b7cf861c.jpg',
                    desc: 'Rok bertingkat dengan detail ruffle yang memberikan tampilan feminin dan menarik. Menggunakan bahan chiffon ringan yang nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 7,
                    price: '120.000'
                },
                {
                    name: 'Rok Pita Biru',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg',
                    desc: 'Rok panjang dengan detail pita kecil yang memberikan tampilan manis dan feminin dan terbuat dari bahan katun ringan yang nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '115.000'
                },
                {
                    name: 'Rok Denim',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg',
                    desc: 'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 6,
                    price: '132.000'
                }
            ]
        };

        let currentQty = 1;
        let currentStock = 1;
        let selectedSize = null;
        let currentProduct = null;
        let currentCategory = 'kemeja';
        let currentSort = 'default';
        let searchQuery = '';

        function priceNum(p) {
            return parseInt(p.replace(/\./g, ''));
        }

        function getSorted(list) {
            const arr = [...list];
            if (currentSort === 'price-asc') arr.sort((a, b) => priceNum(a.price) - priceNum(b.price));
            else if (currentSort === 'price-desc') arr.sort((a, b) => priceNum(b.price) - priceNum(a.price));
            else if (currentSort === 'stock') arr.sort((a, b) => b.stock - a.stock);
            return arr;
        }

        function filterSearch(q) {
            searchQuery = q.toLowerCase();
            renderProducts(currentCategory);
        }

        function renderProducts(category) {
            currentCategory = category;
            const label = category.charAt(0).toUpperCase() + category.slice(1);
            document.getElementById('pageTitle').innerText = label;

            const grid = document.getElementById('product-grid');
            const empty = document.getElementById('empty-state');
            grid.innerHTML = '';

            let list = getSorted(products[category]);
            if (searchQuery) list = list.filter(p =>
                p.name.toLowerCase().includes(searchQuery) || p.desc.toLowerCase().includes(searchQuery)
            );

            if (list.length === 0) {
                empty.classList.remove('hidden');
                return;
            }
            empty.classList.add('hidden');

            list.forEach((product, i) => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.style.animationDelay = `${i * 0.06}s`;
                card.innerHTML = `
                <div class="relative">
                <img src="${product.image}" alt="${product.name}" loading="lazy">
                </div>
                <div class="p-4">
                    <p class="text-[10px] tracking-[2px] uppercase font-medium mb-0.5" style="color:#A78D78;">${product.category}</p>
                    <h2 class="font-medium mb-0.5" style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;color:#5B4636;">${product.name}</h2>
                    <p class="text-xs leading-5 mb-3" style="color:#8A7463;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${product.desc}</p>
                    <div class="flex items-center justify-between">
                        <p class="font-semibold" style="font-size:1rem;color:#8C7563;">Rp${product.price}</p>
                        <button onclick='openModal(${JSON.stringify(product)})'
                            class="text-xs font-medium px-3 py-1.5 rounded-full transition"
                            style="background:#E1D4C2;color:#5B4636;"
                            onmouseover="this.style.background='#CDB89E'" onmouseout="this.style.background='#E1D4C2'">
                            Detail →
                        </button>
                    </div>
                </div>
            `;
                grid.appendChild(card);
            });
        }

        function showCategory(category, btn) {
            document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            renderProducts(category);
        }

        function showCategoryFromFooter(category) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            const btn = document.querySelector(`[data-cat="${category}"]`);
            if (btn) {
                document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
            renderProducts(category);
            return false;
        }

        function sortProducts(val) {
            currentSort = val;
            renderProducts(currentCategory);
        }

        function openModal(product) {
            currentProduct = product;
            document.getElementById('modalName').innerText = product.name;
            document.getElementById('modalCategory').innerText = product.category;
            document.getElementById('modalImage').src = product.image;
            document.getElementById('modalDesc').innerText = product.desc;
            document.getElementById('modalPrice').innerText = 'Rp' + product.price;
            document.getElementById('modalStock').innerText = product.stock + ' pcs tersedia';

            const sizesContainer = document.getElementById('modalSizes');
            sizesContainer.innerHTML = '';
            selectedSize = null;

            product.sizes.forEach(size => {
                const btn = document.createElement('button');
                btn.className = 'size-btn';
                btn.textContent = size;
                btn.onclick = () => {
                    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    selectedSize = size;
                };
                sizesContainer.appendChild(btn);
            });

            currentQty = 1;
            currentStock = parseInt(product.stock);
            document.getElementById('qtyValue').innerText = currentQty;

            const modal = document.getElementById('productModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

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
            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }
            alert(`Produk "${currentProduct.name}" berhasil ditambahkan ke keranjang.\nSize: ${selectedSize}\nJumlah: ${currentQty}`);
        }

        function buyNow() {
            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }
            alert(`Anda memilih beli sekarang.\nProduk: ${currentProduct.name}\nSize: ${selectedSize}\nJumlah: ${currentQty}`);
        }

        renderProducts('kemeja');
    </script>
</body>

</html>