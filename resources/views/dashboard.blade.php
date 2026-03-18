<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FemmeMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f4ef;
            color: #4b3425;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 230px;
            background: #8b5e3c;
            color: white;
            padding: 28px 18px;
        }

        .brand {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 35px;
            text-align: center;
        }

        .menu-title {
            font-size: 12px;
            color: #ead8c8;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #6f472c;
        }

        .main {
            flex: 1;
            padding: 28px;
        }

        .topbar {
            background: white;
            border-radius: 18px;
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 6px 18px rgba(91, 63, 39, 0.08);
            margin-bottom: 24px;
        }

        .topbar h1 {
            font-size: 32px;
            color: #6f472c;
            margin-bottom: 6px;
        }

        .topbar p {
            color: #8a6b55;
            font-size: 14px;
        }

        .admin-box {
            text-align: right;
        }

        .admin-box h3 {
            font-size: 16px;
            color: #6f472c;
            margin-bottom: 4px;
        }

        .admin-box span {
            font-size: 13px;
            color: #9a7c67;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(91, 63, 39, 0.08);
        }

        .card h3 {
            font-size: 15px;
            color: #8a6b55;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 34px;
            font-weight: bold;
            color: #8b5e3c;
        }

        .panel {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(91, 63, 39, 0.08);
        }

        .panel h2 {
            font-size: 22px;
            color: #6f472c;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #eee3d9;
            font-size: 14px;
        }

        table th {
            color: #7d614d;
        }

        table td {
            color: #5a4330;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fff1d6;
            color: #b7791f;
        }

        .proses {
            background: #dbeafe;
            color: #2563eb;
        }

        .selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            background: #8b5e3c;
            color: white;
            padding: 16px;
            border-radius: 14px;
            font-size: 13px;
        }

        @media (max-width: 992px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 18px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .admin-box {
                text-align: left;
            }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="sidebar">
            <div class="brand">FemmeMart</div>

            <div class="menu-title">Menu Admin</div>

            <a href="/dashboard" class="active">Dashboard</a>
            <a href="/kategori">Kategori</a>
            <a href="#">Produk</a>
            <a href="#">Pesanan</a>
            <a href="/login">Logout</a>
        </div>

        <main class="main">
            <div class="topbar">
                <div>
                    <h1>Dashboard Admin</h1>
                    <p>Ringkasan pengelolaan produk, kategori, dan pesanan FemmeMart</p>
                </div>
                <div class="admin-box">
                    <h3>Admin FemmeMart</h3>
                    <span>Fashion Marketplace</span>
                </div>
            </div>

            <section class="cards">
                <div class="card">
                    <h3>Total Produk</h3>
                    <p>12</p>
                </div>
                <div class="card">
                    <h3>Total Kategori</h3>
                    <p>4</p>
                </div>
                <div class="card">
                    <h3>Total Pesanan</h3>
                    <p>8</p>
                </div>
            </section>

            <section>
                <div class="panel">
                    <h2>Pesanan Terbaru</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rina</td>
                                <td>Gaun Pesta</td>
                                <td><span class="status pending">Menunggu</span></td>
                            </tr>
                            <tr>
                                <td>Salsa</td>
                                <td>Cardigan Rajut</td>
                                <td><span class="status proses">Diproses</span></td>
                            </tr>
                            <tr>
                                <td>Nadia</td>
                                <td>Rok Plisket</td>
                                <td><span class="status selesai">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>Alya</td>
                                <td>Kemeja Formal</td>
                                <td><span class="status pending">Menunggu</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="footer">
                &copy; 2026 FemmeMart - Marketplace UMKM Fashion Wanita
            </div>
        </main>
    </div>

</body>
</html>