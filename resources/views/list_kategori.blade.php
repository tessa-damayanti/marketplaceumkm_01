<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk - FashionHub UMKM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5ede0;
            min-height: 100vh;
        }

        .header {
            background: #5c3d2e;
            padding: 32px 40px;
            text-align: center;
        }

        .header h1 {
            color: #f5ede0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .header p {
            color: #c9a882;
            font-size: 14px;
            margin-top: 6px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 32px;
        }

        .section-title h2 {
            color: #5c3d2e;
            font-size: 22px;
        }

        .section-title p {
            color: #9e7a5a;
            font-size: 13px;
            margin-top: 6px;
        }

        .grid-kategori {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .card-kategori {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(92, 61, 46, 0.10);
            cursor: pointer;
            border: 2px solid transparent;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        }

        .card-kategori:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(92, 61, 46, 0.18);
        }

        .card-kategori.active {
            border-color: #5c3d2e;
            box-shadow: 0 8px 24px rgba(92, 61, 46, 0.25);
        }

        .icon-box {
            width: 100%;
            height: 180px;
            background: #f5ede0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-box svg {
            width: 90px;
            height: 90px;
        }

        .card-kategori-body {
            padding: 14px;
            background: #fff8f2;
        }

        .badge {
            display: inline-block;
            background: #f5ede0;
            color: #7a4f35;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .card-kategori-body h3 {
            color: #5c3d2e;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .card-kategori-body p {
            color: #9e7a5a;
            font-size: 12px;
            line-height: 1.5;
        }

        .klik-info {
            margin-top: 10px;
            font-size: 11px;
            color: #c9a882;
            font-style: italic;
        }

        .produk-section {
            display: none;
            animation: fadeIn 0.35s ease;
        }

        .produk-section.show {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .produk-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding: 16px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(92, 61, 46, 0.08);
        }

        .produk-header h3 {
            color: #5c3d2e;
            font-size: 17px;
        }

        .produk-header .jumlah {
            background: #5c3d2e;
            color: #f5ede0;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .btn-tutup {
            margin-left: auto;
            background: #f5ede0;
            color: #5c3d2e;
            border: 1px solid #c9a882;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-tutup:hover {
            background: #e8d5c0;
        }

        .grid-produk {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .card-produk {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(92, 61, 46, 0.09);
            transition: transform 0.2s;
        }

        .card-produk:hover {
            transform: translateY(-4px);
        }

        .icon-box-produk {
            width: 100%;
            height: 240px;
            background: #f5ede0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-box-produk svg {
            width: 120px;
            height: 120px;
        }

        .card-produk-body {
            padding: 14px 16px;
            background: #fff8f2;
            text-align: center;
        }

        .card-produk-body h4 {
            color: #5c3d2e;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #c9a882;
            font-size: 12px;
            background: #5c3d2e;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Marketplace UMKM</h1>
        <p>Marketplace Fashion Wanita Terpercaya</p>
    </div>

    <div class="container">

        <div class="section-title">
            <h2>Kategori Produk</h2>
            <p>Pilih kategori untuk melihat koleksi produk</p>
        </div>

        {{-- ======== GRID KATEGORI ======== --}}
        <div class="grid-kategori">
            @foreach ($kategori as $index => $item)
            <div class="card-kategori"
                id="card-{{ $index }}"
                onclick="tampilProduk('{{ $index }}')">

                <div class="icon-box">
                    @if ($item['icon'] === 'gaun')
                    <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M35 8 Q50 2 65 8 L75 28 Q62 24 50 25 Q38 24 25 28 Z" fill="#c9a882" />
                        <path d="M25 28 Q15 35 12 50 L20 52 Q22 40 30 35 L30 110 Q50 115 70 110 L70 35 Q78 40 80 52 L88 50 Q85 35 75 28 Q62 24 50 25 Q38 24 25 28 Z" fill="#5c3d2e" />
                        <ellipse cx="50" cy="8" rx="8" ry="6" fill="#e8d5c0" />
                        <line x1="50" y1="25" x2="50" y2="110" stroke="#c9a882" stroke-width="1" stroke-dasharray="3,3" />
                    </svg>

                    @elseif ($item['icon'] === 'kemeja')
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M38 10 L25 20 L10 15 L8 35 L22 38 L22 90 L78 90 L78 38 L92 35 L90 15 L75 20 L62 10 Q50 18 38 10 Z" fill="#5c3d2e" />
                        <path d="M38 10 Q50 18 62 10 L62 28 Q55 32 50 32 Q45 32 38 28 Z" fill="#c9a882" />
                        <line x1="50" y1="32" x2="50" y2="88" stroke="#c9a882" stroke-width="1.5" stroke-dasharray="3,3" />
                        <circle cx="50" cy="40" r="2" fill="#c9a882" />
                        <circle cx="50" cy="52" r="2" fill="#c9a882" />
                        <circle cx="50" cy="64" r="2" fill="#c9a882" />
                        <circle cx="50" cy="76" r="2" fill="#c9a882" />
                    </svg>

                    @elseif ($item['icon'] === 'cardigan')
                    <svg viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M38 8 L20 22 L8 18 L6 42 L20 45 L20 100 L80 100 L80 45 L94 42 L92 18 L80 22 L62 8 Q50 16 38 8 Z" fill="#7a4f35" />
                        <path d="M38 8 Q50 16 62 8 L56 35 L50 40 L44 35 Z" fill="#c9a882" />
                        <line x1="20" y1="55" x2="80" y2="55" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                        <line x1="20" y1="65" x2="80" y2="65" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                        <line x1="20" y1="75" x2="80" y2="75" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                        <line x1="20" y1="85" x2="80" y2="85" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                    </svg>

                    @elseif ($item['icon'] === 'rok')
                    <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="32" y="8" width="36" height="14" rx="3" fill="#5c3d2e" />
                        <rect x="29" y="20" width="42" height="8" rx="2" fill="#7a4f35" />
                        <path d="M24 28 Q20 32 16 105 L84 105 Q80 32 76 28 Z" fill="#5c3d2e" />
                        <path d="M24 28 Q50 35 76 28 Q80 32 84 105 Q50 110 16 105 Q20 32 24 28 Z" fill="#7a4f35" />
                        <line x1="50" y1="28" x2="44" y2="104" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                        <line x1="50" y1="28" x2="56" y2="104" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                        <path d="M16 105 Q50 110 84 105" stroke="#c9a882" stroke-width="1" fill="none" />
                    </svg>
                    @endif
                </div>

                <div class="card-kategori-body">
                    <span class="badge">K-{{ $item['id'] }}</span>
                    <h3>{{ $item['nama'] }}</h3>
                    <p>{{ $item['deskripsi'] }}</p>
                    <p class="klik-info">Klik untuk lihat produk →</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ======== SECTION PRODUK ======== --}}
        @foreach ($kategori as $index => $item)
        <div class="produk-section" id="produk-{{ $index }}">
            <div class="produk-header">
                <h3>Koleksi {{ $item['nama'] }}</h3>
                <span class="jumlah">{{ count($item['produk']) }} Produk</span>
                <button class="btn-tutup" onclick="tutupProduk('{{ $index }}')">✕ Tutup</button>
            </div>
            <div class="grid-produk">
                @foreach ($item['produk'] as $produk)
                <div class="card-produk">
                    <div class="icon-box-produk">

                        @if ($item['icon'] === 'gaun')
                        <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M35 8 Q50 2 65 8 L75 28 Q62 24 50 25 Q38 24 25 28 Z" fill="#c9a882" />
                            <path d="M25 28 Q15 35 12 50 L20 52 Q22 40 30 35 L30 110 Q50 115 70 110 L70 35 Q78 40 80 52 L88 50 Q85 35 75 28 Q62 24 50 25 Q38 24 25 28 Z" fill="#5c3d2e" />
                            <ellipse cx="50" cy="8" rx="8" ry="6" fill="#e8d5c0" />
                            <line x1="50" y1="25" x2="50" y2="110" stroke="#c9a882" stroke-width="1" stroke-dasharray="3,3" />
                        </svg>

                        @elseif ($item['icon'] === 'kemeja')
                        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M38 10 L25 20 L10 15 L8 35 L22 38 L22 90 L78 90 L78 38 L92 35 L90 15 L75 20 L62 10 Q50 18 38 10 Z" fill="#5c3d2e" />
                            <path d="M38 10 Q50 18 62 10 L62 28 Q55 32 50 32 Q45 32 38 28 Z" fill="#c9a882" />
                            <line x1="50" y1="32" x2="50" y2="88" stroke="#c9a882" stroke-width="1.5" stroke-dasharray="3,3" />
                            <circle cx="50" cy="40" r="2" fill="#c9a882" />
                            <circle cx="50" cy="52" r="2" fill="#c9a882" />
                            <circle cx="50" cy="64" r="2" fill="#c9a882" />
                            <circle cx="50" cy="76" r="2" fill="#c9a882" />
                        </svg>

                        @elseif ($item['icon'] === 'cardigan')
                        <svg viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M38 8 L20 22 L8 18 L6 42 L20 45 L20 100 L80 100 L80 45 L94 42 L92 18 L80 22 L62 8 Q50 16 38 8 Z" fill="#7a4f35" />
                            <path d="M38 8 Q50 16 62 8 L56 35 L50 40 L44 35 Z" fill="#c9a882" />
                            <line x1="20" y1="55" x2="80" y2="55" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                            <line x1="20" y1="65" x2="80" y2="65" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                            <line x1="20" y1="75" x2="80" y2="75" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                            <line x1="20" y1="85" x2="80" y2="85" stroke="#9e6b45" stroke-width="2" stroke-dasharray="4,2" />
                        </svg>

                        @elseif ($item['icon'] === 'rok')
                        @if ($loop->index === 0)
                        {{-- Rok Midi --}}
                        <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="32" y="8" width="36" height="14" rx="3" fill="#5c3d2e" />
                            <rect x="29" y="20" width="42" height="8" rx="2" fill="#7a4f35" />
                            <path d="M24 28 Q20 32 16 105 L84 105 Q80 32 76 28 Z" fill="#5c3d2e" />
                            <path d="M24 28 Q50 35 76 28 Q80 32 84 105 Q50 110 16 105 Q20 32 24 28 Z" fill="#7a4f35" />
                            <line x1="50" y1="28" x2="44" y2="104" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                            <line x1="50" y1="28" x2="56" y2="104" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                            <path d="M16 105 Q50 110 84 105" stroke="#c9a882" stroke-width="1" fill="none" />
                        </svg>

                        @elseif ($loop->index === 1)
                        {{-- Rok Plisket --}}
                        <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="32" y="8" width="36" height="14" rx="3" fill="#5c3d2e" />
                            <rect x="29" y="20" width="42" height="8" rx="2" fill="#7a4f35" />
                            <path d="M24 28 Q20 32 16 105 L84 105 Q80 32 76 28 Z" fill="#5c3d2e" />
                            <line x1="28" y1="28" x2="22" y2="104" stroke="#c9a882" stroke-width="1.2" />
                            <line x1="34" y1="28" x2="29" y2="104" stroke="#e8d5c0" stroke-width="0.8" />
                            <line x1="40" y1="28" x2="36" y2="104" stroke="#c9a882" stroke-width="1.2" />
                            <line x1="46" y1="28" x2="43" y2="104" stroke="#e8d5c0" stroke-width="0.8" />
                            <line x1="52" y1="28" x2="50" y2="104" stroke="#c9a882" stroke-width="1.2" />
                            <line x1="58" y1="28" x2="57" y2="104" stroke="#e8d5c0" stroke-width="0.8" />
                            <line x1="64" y1="28" x2="64" y2="104" stroke="#c9a882" stroke-width="1.2" />
                            <line x1="70" y1="28" x2="71" y2="104" stroke="#e8d5c0" stroke-width="0.8" />
                            <path d="M16 105 Q50 110 84 105" stroke="#c9a882" stroke-width="1" fill="none" />
                        </svg>

                        @elseif ($loop->index === 2)
                        {{-- Rok Maxi --}}
                        <svg viewBox="0 0 100 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="32" y="8" width="36" height="14" rx="3" fill="#5c3d2e" />
                            <rect x="29" y="20" width="42" height="8" rx="2" fill="#7a4f35" />
                            <path d="M26 28 Q20 35 10 118 L90 118 Q80 35 74 28 Z" fill="#5c3d2e" />
                            <path d="M26 28 Q50 35 74 28 Q80 35 90 118 Q50 124 10 118 Q20 35 26 28 Z" fill="#7a4f35" />
                            <path d="M12 95 Q50 100 88 95" stroke="#c9a882" stroke-width="1" fill="none" />
                            <path d="M10 108 Q50 114 90 108" stroke="#c9a882" stroke-width="1" fill="none" />
                            <line x1="50" y1="28" x2="43" y2="117" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                            <line x1="50" y1="28" x2="57" y2="117" stroke="#c9a882" stroke-width="0.8" stroke-dasharray="4,3" />
                        </svg>
                        @endif

                        @endif

                    </div>
                    <div class="card-produk-body">
                        <h4>{{ $produk['nama'] }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    <div class="footer">
        &copy; 2026 Marketplace UMKM
    </div>

    <script>
        let aktif = null;

        function tampilProduk(index) {
            if (aktif === index) {
                tutupProduk(index);
                return;
            }
            if (aktif !== null) {
                document.getElementById('produk-' + aktif).classList.remove('show');
                document.getElementById('card-' + aktif).classList.remove('active');
            }
            aktif = index;
            document.getElementById('produk-' + index).classList.add('show');
            document.getElementById('card-' + index).classList.add('active');
            setTimeout(() => {
                document.getElementById('produk-' + index).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        }

        function tutupProduk(index) {
            document.getElementById('produk-' + index).classList.remove('show');
            document.getElementById('card-' + index).classList.remove('active');
            aktif = null;
        }
    </script>

</body>

</html>