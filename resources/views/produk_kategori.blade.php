<!DOCTYPE html>
<html>

<head>
    <title>Produk</title>

    <style>
        body {
            font-family: 'Segoe UI';
            margin: 0;
            background: #f5efe6;
        }

        .header {
            background: #6b4f3b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 85%;
            margin: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 40px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .info {
            padding: 15px;
        }

        .nama {
            font-size: 18px;
            color: #4b3621;
        }

        .harga {
            font-weight: bold;
            color: #6b4f3b;
            margin-top: 5px;
        }

        button {
            background: #6b4f3b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
        }

        button:hover {
            background: #4b3621;
        }

        .back {
            margin-top: 40px;
            display: block;
        }
    </style>

</head>

<body>

    <div class="header">
        <h1>Kategori {{ $nama }}</h1>
    </div>

    <div class="container">

        <div class="grid">

            @foreach($listProduk as $produk)

            <div class="card">

                <img src="{{ $produk['gambar'] }}">

                <div class="info">

                    <div class="nama">{{ $produk['nama'] }}</div>

                    <div class="harga">{{ $produk['harga'] }}</div>

                    <button>Beli Produk</button>

                </div>

            </div>

            @endforeach

        </div>

        <a href="/kategori" class="back">← Kembali ke Kategori</a>

    </div>

</body>

</html>