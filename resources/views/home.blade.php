<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .home-page {
            background: #fbf6f0;
            color: #4e3427;
        }

        .navbar-velora {
            background: rgba(255, 250, 245, 0.96);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 30px rgba(111, 78, 55, 0.08);
        }

        .brand-link {
            color: #6f4e37;
        }

        .brand-link:hover {
            color: #6f4e37;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .hero-box {
            position: relative;
            overflow: hidden;
            border-radius: 36px;
            background: linear-gradient(135deg, #fff5ea 0%, #f0ddcb 100%);
        }

        .hero-box::before,
        .hero-box::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            background: rgba(167, 123, 93, 0.14);
        }

        .hero-box::before {
            top: -80px;
            right: -60px;
            width: 240px;
            height: 240px;
        }

        .hero-box::after {
            bottom: -60px;
            left: -40px;
            width: 180px;
            height: 180px;
        }

        .hero-content {
            z-index: 1;
        }

        .hero-text {
            max-width: 560px;
        }

        .hero-image-box {
            position: relative;
            overflow: hidden;
            min-height: 360px;
            border-radius: 28px;
            background: linear-gradient(180deg, #d99582 0%, #c97e68 100%);
        }

        .hero-icon-wrap {
            z-index: 1;
        }

        .hero-main-icon {
            font-size: 5rem;
            line-height: 1;
        }

        .image-accent {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(78, 52, 39, 0.18), rgba(255, 255, 255, 0));
        }

        .hero-badge,
        .section-badge {
            display: inline-block;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            background: #f2dfd0;
            color: #9a6b4a;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .section-title {
            color: #5c3d2e;
        }

        .section-text {
            color: #8b6c58;
        }

        .btn-velora {
            background: #8b5e3c;
            color: #fff;
            border: none;
        }

        .btn-velora:hover {
            background: #71492d;
            color: #fff;
        }

        .btn-outline-velora {
            border: 1px solid #c9a58a;
            color: #8b5e3c;
            background: #fffaf5;
        }

        .btn-outline-velora:hover {
            background: #f1dfcf;
            color: #6d452f;
        }

        .top-card {
            overflow: hidden;
            border: 0;
            border-radius: 28px;
            background: #fff;
            box-shadow: 0 18px 40px rgba(111, 78, 55, 0.09);
        }

        .top-thumb {
            position: relative;
            display: flex;
            align-items: end;
            min-height: 240px;
            padding: 1.25rem;
            color: #fff;
        }

        .thumb-one {
            background: linear-gradient(180deg, #d77973, #bb5c58);
        }

        .thumb-two {
            background: linear-gradient(180deg, #e9af88, #d48b66);
        }

        .thumb-three {
            background: linear-gradient(180deg, #cf8ea0, #b56a80);
        }

        .top-thumb i {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 2rem;
            opacity: 0.25;
        }

        .product-price {
            color: #8b5e3c;
        }

        .section-shell {
            border-radius: 32px;
            background: #fffaf5;
            box-shadow: 0 18px 40px rgba(111, 78, 55, 0.06);
        }

        .category-item {
            text-align: center;
        }

        .category-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 84px;
            height: 84px;
            margin: 0 auto 0.75rem;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 12px 24px rgba(111, 78, 55, 0.1);
            font-size: 2rem;
            color: #a36d4a;
        }

        .category-label {
            font-weight: 600;
            color: #85583c;
        }
    </style>
</head>

<body class="home-page">
    <nav class="navbar navbar-expand-lg navbar-velora sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3 fw-bold brand-link" href="/home">
                <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                    alt="Logo Velora"
                    class="brand-logo">
                <span>Velora</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVelora">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarVelora">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/home">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/product">Product</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/about">About</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/contact">Contact</a></li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-velora px-4 rounded-pill" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 py-lg-5">
        <div class="container">
            <section class="hero-box p-4 p-lg-5 mb-5">
                <div class="row align-items-center g-4 position-relative hero-content">
                    <div class="col-lg-6">
                        <span class="hero-badge mb-3">New Collection Velora</span>
                        <h1 class="display-4 fw-bold mb-3 section-title">
                            Pilihan fashion wanita yang manis, modern, dan nyaman dipakai.
                        </h1>
                        <p class="fs-5 mb-4 section-text hero-text">
                            Temukan outfit favoritmu mulai dari gaya santai sampai semi formal dalam nuansa yang elegan dan hangat.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="/product" class="btn btn-velora btn-lg rounded-pill px-4">Belanja Sekarang</a>
                            <a href="#kategori" class="btn btn-outline-velora btn-lg rounded-pill px-4">Lihat Kategori</a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image-box d-flex align-items-center justify-content-center">
                            <div class="text-center text-white position-relative hero-icon-wrap">
                                <div class="mb-3 hero-main-icon">
                                    <i class="bi bi-bag-heart-fill"></i>
                                </div>
                                <h2 class="fw-bold mb-2">Gaya Terbaikmu Dimulai Di Sini</h2>
                                <p class="mb-0 fs-5">Simple, soft, dan tetap stylish setiap hari.</p>
                            </div>
                            <div class="image-accent"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-5">
                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                    <div>
                        <span class="section-badge mb-2">Terlaris</span>
                        <h2 class="fw-bold mb-1 section-title">Produk paling disukai minggu ini</h2>
                        <p class="mb-0 section-text">Sementara ini kita tampilkan contoh terlaris dulu sebelum bagian produk lengkap dibuat.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-4">
                        <div class="top-card h-100">
                            <div class="top-thumb thumb-one">
                                <i class="bi bi-stars"></i>
                                <div>
                                    <div class="badge rounded-pill text-bg-light mb-2">Best Seller</div>
                                    <h4 class="fw-bold mb-1">Rose Midi Dress</h4>
                                    <p class="mb-0">Gaun manis untuk acara santai dan semi formal.</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold product-price">Rp189.000</span>
                                    <a href="/product" class="btn btn-sm btn-outline-velora rounded-pill px-3">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="top-card h-100">
                            <div class="top-thumb thumb-two">
                                <i class="bi bi-heart"></i>
                                <div>
                                    <div class="badge rounded-pill text-bg-light mb-2">Favorit</div>
                                    <h4 class="fw-bold mb-1">Classic Office Shirt</h4>
                                    <p class="mb-0">Kemeja clean look yang cocok untuk harian.</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold product-price">Rp149.000</span>
                                    <a href="/product" class="btn btn-sm btn-outline-velora rounded-pill px-3">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="top-card h-100">
                            <div class="top-thumb thumb-three">
                                <i class="bi bi-fire"></i>
                                <div>
                                    <div class="badge rounded-pill text-bg-light mb-2">Hot Item</div>
                                    <h4 class="fw-bold mb-1">Soft Knit Cardigan</h4>
                                    <p class="mb-0">Cardigan nyaman dengan warna lembut dan feminim.</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold product-price">Rp175.000</span>
                                    <a href="/product" class="btn btn-sm btn-outline-velora rounded-pill px-3">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="kategori" class="section-shell p-4 p-lg-5">
                <div class="text-center mb-4 mb-lg-5">
                    <span class="section-badge mb-2">Category</span>
                    <h2 class="fw-bold mb-2 section-title">Belanja berdasarkan kategori</h2>
                    <p class="mb-0 section-text">Empat kategori utama yang ingin kamu tampilkan di homepage.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-6 col-md-3">
                        <div class="category-item">
                            <div class="category-icon"><i class="bi bi-person-dress"></i></div>
                            <div class="category-label">Gaun</div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="category-item">
                            <div class="category-icon"><i class="bi bi-person-workspace"></i></div>
                            <div class="category-label">Kemeja</div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="category-item">
                            <div class="category-icon"><i class="bi bi-bag-heart"></i></div>
                            <div class="category-label">Cardigan</div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="category-item">
                            <div class="category-icon"><i class="bi bi-brilliance"></i></div>
                            <div class="category-label">Rok</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
