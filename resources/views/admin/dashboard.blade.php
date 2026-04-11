<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#f5efe9] text-[#5d4030]" style="font-family: 'Poppins', sans-serif;">
  <div class="min-h-screen">
    <header class="sticky top-0 z-40 border-b border-[#eadccf] bg-[#fffaf6]/95 backdrop-blur">
      <div class="mx-auto flex w-full max-w-[1500px] items-center justify-between px-4 py-4 md:px-6">
        <div class="text-2xl font-extrabold tracking-[0.04em] text-[#8f654a] md:text-3xl">Velora</div>
        <div class="text-sm font-medium text-[#8c6f5b]">Selamat datang, Admin</div>
      </div>

      <div class="mx-auto flex w-full max-w-[1500px] gap-2 overflow-x-auto px-4 pb-4 md:hidden">
        <button class="nav-link mobile-nav whitespace-nowrap rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="dashboard" onclick="showPage('dashboard')">Dashboard</button>
        <button class="nav-link mobile-nav whitespace-nowrap rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="produk" onclick="showPage('produk')">Produk</button>
        <button class="nav-link mobile-nav whitespace-nowrap rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="pesanan" onclick="showPage('pesanan')">Pesanan</button>
      </div>
    </header>

    <div class="mx-auto grid w-full max-w-[1500px] md:min-h-[calc(100vh-80px)] md:grid-cols-[270px_minmax(0,1fr)]">
      <aside class="hidden border-r border-[#eadccf] bg-[#fffaf6] md:block">
        <div class="px-6 py-6">
          <p class="px-3 pb-3 text-[11px] font-bold uppercase tracking-[0.18em] text-[#a68a77]">Menu Utama</p>
          <div class="space-y-1">
            <button class="nav-link flex w-full items-center rounded-xl border-l-4 border-transparent px-3 py-3 text-left text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="dashboard" onclick="showPage('dashboard')">Dashboard</button>
            <button class="nav-link flex w-full items-center rounded-xl border-l-4 border-transparent px-3 py-3 text-left text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="produk" onclick="showPage('produk')">Produk</button>
            <button class="nav-link flex w-full items-center rounded-xl border-l-4 border-transparent px-3 py-3 text-left text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f3e6da]" data-nav="pesanan" onclick="showPage('pesanan')">Pesanan</button>
          </div>

          <p class="mt-7 px-3 pb-3 text-[11px] font-bold uppercase tracking-[0.18em] text-[#a68a77]">Kategori</p>
          <div class="space-y-1">
            <button class="flex w-full items-center rounded-xl px-3 py-3 text-left text-sm font-medium text-[#8c6f5b] transition hover:bg-[#f3e6da]" onclick="showPage('produk');switchCat('Gaun')">Gaun</button>
            <button class="flex w-full items-center rounded-xl px-3 py-3 text-left text-sm font-medium text-[#8c6f5b] transition hover:bg-[#f3e6da]" onclick="showPage('produk');switchCat('Kemeja')">Kemeja</button>
            <button class="flex w-full items-center rounded-xl px-3 py-3 text-left text-sm font-medium text-[#8c6f5b] transition hover:bg-[#f3e6da]" onclick="showPage('produk');switchCat('Kardigan')">Kardigan</button>
            <button class="flex w-full items-center rounded-xl px-3 py-3 text-left text-sm font-medium text-[#8c6f5b] transition hover:bg-[#f3e6da]" onclick="showPage('produk');switchCat('Rok')">Rok</button>
          </div>
        </div>
      </aside>

      <main class="bg-gradient-to-b from-[#fbf7f3] to-[#f6f1ec] p-4 md:p-7">
        <section class="page" id="page-dashboard">
          <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-[#5d4030]">Dashboard</h1>
            <p class="mt-1 text-sm text-[#8c6f5b]">Ringkasan aktivitas toko dan performa produk terbaru.</p>
          </div>

          <div class="mb-5 grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="rounded-3xl border border-[#eadccf] bg-white p-5 shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
              <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#a0826f]">Total Produk</p>
              <p class="mt-2 text-4xl font-extrabold" id="stat-produk">18</p>
              <p class="mt-1 text-sm text-[#8f654a]">4 kategori aktif</p>
            </div>
            <div class="rounded-3xl border border-[#eadccf] bg-white p-5 shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
              <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#a0826f]">Total Pesanan</p>
              <p class="mt-2 text-4xl font-extrabold" id="stat-pesanan">8</p>
              <p class="mt-1 text-sm text-[#8f654a]">Pesanan masuk</p>
            </div>
            <div class="rounded-3xl border border-[#eadccf] bg-white p-5 shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
              <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#a0826f]">Total Kategori</p>
              <p class="mt-2 text-4xl font-extrabold">4</p>
              <p class="mt-1 text-sm text-[#8f654a]">Gaun, Kemeja, Kardigan, Rok</p>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4 xl:grid-cols-[1.3fr_0.9fr]">
            <div class="overflow-hidden rounded-3xl border border-[#eadccf] bg-white shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
              <div class="flex items-start justify-between border-b border-[#eadccf] px-5 py-4">
                <div>
                  <h2 class="text-lg font-bold text-[#5d4030]">Pesanan Terbaru</h2>
                  <p class="text-sm text-[#8c6f5b]">Daftar pesanan terbaru dari pembeli.</p>
                </div>
                <button class="rounded-xl border border-[#dbc6b4] px-3 py-2 text-xs font-semibold transition hover:bg-[#f6ece4]" onclick="showPage('pesanan')">Lihat Semua</button>
              </div>
              <div class="overflow-x-auto px-5 py-4">
                <table class="min-w-full border-separate border-spacing-y-2 text-sm">
                  <thead>
                    <tr class="text-left text-xs font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">
                      <th class="px-3 py-2">Pembeli</th>
                      <th class="px-3 py-2">Produk</th>
                      <th class="px-3 py-2">Total</th>
                    </tr>
                  </thead>
                  <tbody id="latest-orders-body"></tbody>
                </table>
              </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-[#eadccf] bg-white shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
              <div class="border-b border-[#eadccf] px-5 py-4">
                <h2 class="text-lg font-bold text-[#5d4030]">Produk per Kategori</h2>
                <p class="text-sm text-[#8c6f5b]">Jumlah produk pada tiap kategori.</p>
              </div>
              <div class="space-y-4 px-5 py-5" id="cat-bars"></div>
            </div>
          </div>
        </section>

        <section class="page hidden" id="page-produk">
          <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
              <h1 class="text-3xl font-extrabold text-[#5d4030]">Manajemen Produk</h1>
              <p class="mt-1 text-sm text-[#8c6f5b]">Kelola katalog dan stok produk untuk setiap kategori.</p>
            </div>
            <button class="rounded-2xl bg-[#b08467] px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(176,132,103,0.26)] transition hover:bg-[#996e52]" onclick="openAddModal()">+ Tambah Produk</button>
          </div>

          <div class="rounded-3xl border border-[#eadccf] bg-white p-5 shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
            <div class="mb-4 flex flex-wrap gap-2">
              <button class="cat-tab rounded-full border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f6ece4]" data-cat="Gaun" onclick="switchCat('Gaun')">Gaun</button>
              <button class="cat-tab rounded-full border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f6ece4]" data-cat="Kemeja" onclick="switchCat('Kemeja')">Kemeja</button>
              <button class="cat-tab rounded-full border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f6ece4]" data-cat="Kardigan" onclick="switchCat('Kardigan')">Kardigan</button>
              <button class="cat-tab rounded-full border border-[#dbc6b4] px-4 py-2 text-sm font-semibold text-[#8c6f5b] transition hover:bg-[#f6ece4]" data-cat="Rok" onclick="switchCat('Rok')">Rok</button>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3" id="product-grid"></div>
          </div>
        </section>

        <section class="page hidden" id="page-pesanan">
          <div class="mb-5">
            <h1 class="text-3xl font-extrabold text-[#5d4030]">Daftar Pesanan</h1>
            <p class="mt-1 text-sm text-[#8c6f5b]">Pantau transaksi dan detail pembelian pelanggan.</p>
          </div>

          <div class="rounded-3xl border border-[#eadccf] bg-white p-5 shadow-[0_14px_32px_rgba(105,76,57,0.08)]">
            <div class="mb-4 flex flex-wrap gap-2">
              <input class="w-full min-w-[220px] flex-1 rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="order-search" placeholder="Cari nama / ID pesanan" oninput="filterOrders()" type="text">
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead>
                  <tr class="border-b border-[#eadccf] text-left text-xs font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">
                    <th class="px-3 py-3">ID</th>
                    <th class="px-3 py-3">Nama</th>
                    <th class="px-3 py-3">No HP</th>
                    <th class="px-3 py-3">Alamat</th>
                    <th class="px-3 py-3">Produk</th>
                    <th class="px-3 py-3">Total</th>
                    <th class="px-3 py-3">Aksi</th>
                  </tr>
                </thead>
                <tbody id="orders-tbody"></tbody>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
  <div class="fixed inset-0 z-50 hidden items-center justify-center bg-[#311f14]/40 p-4" id="modal-product">
    <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-3xl border border-[#eadccf] bg-white">
      <div class="flex items-center justify-between border-b border-[#eadccf] px-6 py-4">
        <h2 class="text-2xl font-extrabold" id="modal-product-title">Tambah Produk</h2>
        <button class="h-10 w-10 rounded-full border border-[#dbc6b4] text-lg text-[#8c6f5b] transition hover:bg-[#f6ece4]" onclick="closeModal('modal-product')">&times;</button>
      </div>

      <div class="px-6 py-5">
        <div class="mb-4 cursor-pointer rounded-3xl border-2 border-dashed border-[#d8bca9] bg-[#fbf3ec] px-6 py-8 text-center transition hover:bg-[#f6ece4]" id="upload-zone" onclick="simulateUpload()">
          <p class="text-3xl">&#128444;</p>
          <p class="mt-2 text-lg font-bold">Klik untuk upload foto produk</p>
          <p class="mt-1 text-sm text-[#8c6f5b]">JPG, PNG, WEBP (maks. 5MB)</p>
        </div>

        <div class="mb-3">
          <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Nama Produk</label>
          <input class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-name" placeholder="Contoh: Gaun Floral Pastel" type="text">
        </div>

        <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
          <div>
            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Kategori</label>
            <select class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-cat">
              <option>Gaun</option>
              <option>Kemeja</option>
              <option>Kardigan</option>
              <option>Rok</option>
            </select>
          </div>
          <div>
            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Harga (Rp)</label>
            <input class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-price" placeholder="150000" type="number">
          </div>
        </div>

        <div class="mt-3 grid grid-cols-1 gap-3 md:grid-cols-2">
          <div>
            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Stok</label>
            <input class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-stock" placeholder="50" type="number">
          </div>
          <div>
            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Ukuran</label>
            <input class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-size" placeholder="S, M, L, XL" type="text">
          </div>
        </div>

        <div class="mt-3">
          <label class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-[#8c6f5b]">Deskripsi</label>
          <textarea class="w-full rounded-2xl border border-[#dbc6b4] px-4 py-3 text-sm outline-none transition focus:border-[#c79d7d] focus:ring-2 focus:ring-[#c79d7d]/25" id="prod-desc" placeholder="Deskripsi produk..." rows="4"></textarea>
        </div>
      </div>

      <div class="sticky bottom-0 flex justify-end gap-2 border-t border-[#eadccf] bg-white px-6 py-4">
        <button class="rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold transition hover:bg-[#f6ece4]" onclick="closeModal('modal-product')">Batal</button>
        <button class="rounded-xl bg-[#b08467] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#996e52]" onclick="saveProduct()">Simpan Produk</button>
      </div>
    </div>
  </div>

  <div class="fixed inset-0 z-50 hidden items-center justify-center bg-[#311f14]/40 p-4" id="modal-order">
    <div class="max-h-[92vh] w-full max-w-3xl overflow-y-auto rounded-3xl border border-[#eadccf] bg-white">
      <div class="flex items-center justify-between border-b border-[#eadccf] px-6 py-4">
        <h2 class="text-2xl font-extrabold" id="order-modal-title">Detail Pesanan</h2>
        <button class="h-10 w-10 rounded-full border border-[#dbc6b4] text-lg text-[#8c6f5b] transition hover:bg-[#f6ece4]" onclick="closeModal('modal-order')">&times;</button>
      </div>
      <div class="px-6 py-5" id="order-modal-body"></div>
      <div class="flex justify-end border-t border-[#eadccf] px-6 py-4">
        <button class="rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold transition hover:bg-[#f6ece4]" onclick="closeModal('modal-order')">Tutup</button>
      </div>
    </div>
  </div>

  <div class="fixed inset-0 z-50 hidden items-center justify-center bg-[#311f14]/40 p-4" id="modal-delete">
    <div class="w-full max-w-md rounded-3xl border border-[#eadccf] bg-white">
      <div class="flex items-center justify-between border-b border-[#eadccf] px-6 py-4">
        <h2 class="text-2xl font-extrabold">Hapus Produk?</h2>
        <button class="h-10 w-10 rounded-full border border-[#dbc6b4] text-lg text-[#8c6f5b] transition hover:bg-[#f6ece4]" onclick="closeModal('modal-delete')">&times;</button>
      </div>
      <div class="px-6 py-5 text-sm leading-7 text-[#8c6f5b]">
        Produk <strong class="text-[#5d4030]" id="delete-prod-name"></strong> akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
      </div>
      <div class="flex justify-end gap-2 border-t border-[#eadccf] px-6 py-4">
        <button class="rounded-xl border border-[#dbc6b4] px-4 py-2 text-sm font-semibold transition hover:bg-[#f6ece4]" onclick="closeModal('modal-delete')">Batal</button>
        <button class="rounded-xl border border-[#e8c3c3] bg-[#fff8f8] px-4 py-2 text-sm font-semibold text-[#b55151] transition hover:bg-[#fff1f1]" onclick="confirmDelete()">Ya, Hapus</button>
      </div>
    </div>
  </div>

  <script>
    const defaultPhoto = 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=1000&auto=format&fit=crop';

    let products = [{
        id: 1,
        name: 'Gaun Floral Pastel',
        cat: 'Gaun',
        price: 285000,
        stock: 15,
        size: 'S, M, L',
        desc: 'Gaun cantik motif bunga.',
        photo: 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg'
      },
      {
        id: 2,
        name: 'Gaun Midi Satin',
        cat: 'Gaun',
        price: 340000,
        stock: 8,
        size: 'S, M, L, XL',
        desc: 'Gaun satin elegan.',
        photo: 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg'
      },
      {
        id: 3,
        name: 'Gaun Maxi Bohemian',
        cat: 'Gaun',
        price: 420000,
        stock: 12,
        size: 'M, L, XL',
        desc: 'Gaun maxi ala boho.',
        photo: 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg'
      },
      {
        id: 4,
        name: 'Gaun A-Line Polos',
        cat: 'Gaun',
        price: 195000,
        stock: 20,
        size: 'S, M, L',
        desc: 'Gaun polos minimalis.',
        photo: 'https://i.pinimg.com/1200x/b7/71/41/b7714197aa110db547613c08e9bf5edb.jpg'
      },
      {
        id: 6,
        name: 'Kemeja Linen Putih',
        cat: 'Kemeja',
        price: 175000,
        stock: 25,
        size: 'S, M, L, XL',
        desc: 'Kemeja linen nyaman.',
        photo: 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg'
      },
      {
        id: 7,
        name: 'Kemeja Batik Modern',
        cat: 'Kemeja',
        price: 220000,
        stock: 18,
        size: 'S, M, L',
        desc: 'Batik motif modern.',
        photo: 'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg'
      },
      {
        id: 8,
        name: 'Kemeja Stripe Casual',
        cat: 'Kemeja',
        price: 160000,
        stock: 30,
        size: 'S, M, L, XL',
        desc: 'Kemeja kasual bergaris.',
        photo: 'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg'
      },
      {
        id: 9,
        name: 'Kemeja Silk Polos',
        cat: 'Kemeja',
        price: 310000,
        stock: 10,
        size: 'S, M, L',
        desc: 'Kemeja sutra halus.',
        photo: 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg'
      },
      {
        id: 11,
        name: 'Kardigan Rajut Cream',
        cat: 'Kardigan',
        price: 195000,
        stock: 20,
        size: 'S, M, L',
        desc: 'Kardigan rajut lembut.',
        photo: 'https://i.pinimg.com/1200x/06/d9/af/06d9af1a9fa1a2e6f85bda67ddc5b30c.jpg'
      },
      {
        id: 12,
        name: 'Kardigan Panjang Hitam',
        cat: 'Kardigan',
        price: 265000,
        stock: 15,
        size: 'S, M, L, XL',
        desc: 'Kardigan panjang elegan.',
        photo: 'https://i.pinimg.com/1200x/46/91/61/4691615a5685cfc9785a8dc6ce04a0e5.jpg'
      },
      {
        id: 13,
        name: 'Kardigan Belang Pastel',
        cat: 'Kardigan',
        price: 210000,
        stock: 12,
        size: 'S, M, L',
        desc: 'Kardigan motif belang.',
        photo: 'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg'
      },
      {
        id: 14,
        name: 'Kardigan Oversize',
        cat: 'Kardigan',
        price: 285000,
        stock: 8,
        size: 'M, L, XL',
        desc: 'Kardigan oversized cozy.',
        photo: 'https://i.pinimg.com/1200x/11/d7/51/11d751ea4f28b895cca8f7acdb0ffcc7.jpg'
      },
      {
        id: 15,
        name: 'Rok Plisket Midi',
        cat: 'Rok',
        price: 175000,
        stock: 25,
        size: 'S, M, L',
        desc: 'Rok plisket cantik.',
        photo: 'https://i.pinimg.com/736x/9e/af/46/9eaf465a3d23d2c7ca0faa9f232ad980.jpg'
      },
      {
        id: 16,
        name: 'Rok Denim Pendek',
        cat: 'Rok',
        price: 145000,
        stock: 30,
        size: 'S, M, L, XL',
        desc: 'Rok denim casual.',
        photo: 'https://i.pinimg.com/1200x/51/77/97/517797ca83ffd194e823cf35b7cf861c.jpg'
      },
      {
        id: 17,
        name: 'Rok Batik Panjang',
        cat: 'Rok',
        price: 230000,
        stock: 15,
        size: 'S, M, L',
        desc: 'Rok batik tradisional.',
        photo: 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg'
      },
      {
        id: 18,
        name: 'Rok Tutu Organza',
        cat: 'Rok',
        price: 310000,
        stock: 8,
        size: 'S, M, L',
        desc: 'Rok organza romantis.',
        photo: 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg'
      }
    ];

    let orders = [{
        id: 'ORD001',
        nama: 'Siti Rahayu',
        hp: '0812-3456-7890',
        alamat: 'Jl. Merdeka No. 12, Bandung',
        items: [{
          name: 'Gaun Floral Pastel',
          qty: 1,
          price: 285000
        }]
      },
      {
        id: 'ORD002',
        nama: 'Dewi Lestari',
        hp: '0856-7890-1234',
        alamat: 'Jl. Sudirman No. 45, Jakarta',
        items: [{
          name: 'Kemeja Linen Putih',
          qty: 2,
          price: 175000
        }, {
          name: 'Rok Plisket Midi',
          qty: 1,
          price: 175000
        }]
      },
      {
        id: 'ORD003',
        nama: 'Ayu Maharani',
        hp: '0878-9012-3456',
        alamat: 'Jl. Diponegoro No. 8, Surabaya',
        items: [{
          name: 'Kardigan Rajut Cream',
          qty: 1,
          price: 195000
        }]
      },
      {
        id: 'ORD004',
        nama: 'Rizki Amalia',
        hp: '0821-4567-8901',
        alamat: 'Jl. Gatot Subroto No. 22, Medan',
        items: [{
          name: 'Gaun Midi Satin',
          qty: 1,
          price: 340000
        }]
      },
      {
        id: 'ORD005',
        nama: 'Fitri Handayani',
        hp: '0812-0987-6543',
        alamat: 'Jl. Ahmad Yani No. 3, Yogyakarta',
        items: [{
          name: 'Rok Denim Pendek',
          qty: 1,
          price: 145000
        }, {
          name: 'Kemeja Stripe Casual',
          qty: 1,
          price: 160000
        }]
      },
      {
        id: 'ORD006',
        nama: 'Lina Susanti',
        hp: '0896-3456-7891',
        alamat: 'Jl. Pahlawan No. 17, Semarang',
        items: [{
          name: 'Kardigan Panjang Hitam',
          qty: 1,
          price: 265000
        }]
      },
      {
        id: 'ORD007',
        nama: 'Maya Putri',
        hp: '0857-1234-5678',
        alamat: 'Jl. Kenanga No. 5, Batam',
        items: [{
          name: 'Gaun Maxi Bohemian',
          qty: 1,
          price: 420000
        }]
      },
      {
        id: 'ORD008',
        nama: 'Citra Dewi',
        hp: '0813-8765-4321',
        alamat: 'Jl. Pemuda No. 9, Makassar',
        items: [{
          name: 'Kemeja Batik Modern',
          qty: 2,
          price: 220000
        }, {
          name: 'Rok Batik Panjang',
          qty: 1,
          price: 230000
        }]
      }
    ];
    let currentCat = 'Gaun';
    let editingProductId = null;
    let deletingProductId = null;
    let nextProductId = 19;
    let uploadedPhoto = '';

    function fmt(n) {
      return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    function totalOrder(order) {
      return order.items.reduce((sum, item) => sum + item.price * item.qty, 0);
    }

    function updateNavState(page) {
      document.querySelectorAll('.nav-link').forEach((button) => {
        const isActive = button.dataset.nav === page;
        button.classList.toggle('border-[#b08467]', isActive);
        button.classList.toggle('bg-[#efe1d4]', isActive);
        button.classList.toggle('text-[#8f654a]', isActive);
        button.classList.toggle('font-bold', isActive);
        button.classList.toggle('border-transparent', !isActive);
      });
    }

    function updateCatState(cat) {
      document.querySelectorAll('.cat-tab').forEach((tab) => {
        const isActive = tab.dataset.cat === cat;
        tab.classList.toggle('bg-[#efe1d4]', isActive);
        tab.classList.toggle('border-[#d7b9a3]', isActive);
        tab.classList.toggle('text-[#8f654a]', isActive);
      });
    }

    function refreshStats() {
      document.getElementById('stat-produk').textContent = products.length;
      document.getElementById('stat-pesanan').textContent = orders.length;
    }

    function renderLatestOrders() {
      const tbody = document.getElementById('latest-orders-body');
      const latest = orders.slice(0, 4);

      tbody.innerHTML = latest.map((order) => `
        <tr class="cursor-pointer rounded-xl bg-[#fffaf6] transition hover:bg-[#f7ede4]" onclick="openOrderDetail('${order.id}')">
          <td class="rounded-l-xl px-3 py-3 align-top">
            <p class="font-semibold text-[#5d4030]">${order.nama}</p>
            <p class="mt-1 text-xs text-[#8c6f5b]">${order.hp}</p>
          </td>
          <td class="px-3 py-3 text-[#6f5443]">${order.items.map((item) => item.name).join(', ')}</td>
          <td class="rounded-r-xl px-3 py-3 font-semibold text-[#5d4030]">${fmt(totalOrder(order))}</td>
        </tr>
      `).join('');
    }

    function renderCatBars() {
      const cats = ['Gaun', 'Kemeja', 'Kardigan', 'Rok'];
      const max = Math.max(...cats.map((cat) => products.filter((p) => p.cat === cat).length), 1);
      const container = document.getElementById('cat-bars');

      container.innerHTML = cats.map((cat) => {
        const count = products.filter((p) => p.cat === cat).length;
        const pct = Math.round((count / max) * 100);

        return `
          <div class="grid grid-cols-[92px_minmax(0,1fr)_32px] items-center gap-3">
            <div class="text-sm font-medium text-[#6f5443]">${cat}</div>
            <div class="h-2.5 overflow-hidden rounded-full bg-[#efe2d7]"><div class="h-full rounded-full bg-gradient-to-r from-[#c59a7d] to-[#a97d5d]" style="width:${pct}%;"></div></div>
            <div class="text-right text-sm font-bold text-[#5d4030]">${count}</div>
          </div>
        `;
      }).join('');
    }

    function showPage(page) {
      document.querySelectorAll('.page').forEach((section) => section.classList.add('hidden'));
      document.getElementById('page-' + page).classList.remove('hidden');
      updateNavState(page);

      if (page === 'produk') renderProducts();
      if (page === 'pesanan') renderOrders();
    }

    function switchCat(cat) {
      currentCat = cat;
      updateCatState(cat);
      renderProducts();
    }

    function renderProducts() {
      const grid = document.getElementById('product-grid');
      const filtered = products.filter((p) => p.cat === currentCat);

      grid.innerHTML = filtered.map((p) => `
        <article class="overflow-hidden rounded-3xl border border-[#eadccf] bg-[#fffaf6] shadow-[0_10px_24px_rgba(105,76,57,0.08)]">
          <div class="relative h-56 overflow-hidden bg-[#ede3da]">
            <img src="${p.photo || defaultPhoto}" alt="${p.name}" class="h-full w-full object-cover">
            <div class="absolute inset-x-0 bottom-0 border-t border-[#decec1]/80 bg-[#fffaf6]/90 px-3 py-2 text-xs text-[#8c6f5b] backdrop-blur">${p.name}</div>
          </div>
          <div class="p-4">
            <h3 class="min-h-[48px] text-base font-bold leading-6 text-[#5d4030]">${p.name}</h3>
            <p class="mt-1 text-base font-bold text-[#8f654a]">${fmt(p.price)}</p>
            <p class="mt-1 text-sm text-[#8c6f5b]">Stok: ${p.stock} | ${p.size}</p>
          </div>
          <div class="flex gap-2 px-4 pb-4">
            <button class="flex-1 rounded-xl border border-[#dbc6b4] px-3 py-2 text-sm font-semibold transition hover:bg-[#f6ece4]" onclick="openEditModal(${p.id})">Edit</button>
            <button class="flex-1 rounded-xl border border-[#e8c3c3] bg-[#fff8f8] px-3 py-2 text-sm font-semibold text-[#b55151] transition hover:bg-[#fff1f1]" onclick="openDeleteModal(${p.id})">Hapus</button>
          </div>
        </article>
      `).join('');
    }

    function renderOrders(list) {
      const tbody = document.getElementById('orders-tbody');
      const data = list || orders;

      tbody.innerHTML = data.map((o) => `
        <tr class="border-b border-[#eadccf] text-[#6f5443] hover:bg-[#fffaf6]">
          <td class="px-3 py-3 font-bold text-[#8f654a]">${o.id}</td>
          <td class="px-3 py-3">${o.nama}</td>
          <td class="px-3 py-3">${o.hp}</td>
          <td class="max-w-[220px] truncate px-3 py-3" title="${o.alamat}">${o.alamat}</td>
          <td class="max-w-[220px] truncate px-3 py-3" title="${o.items.map((i) => i.name).join(', ')}">${o.items.map((i) => i.name).join(', ')}</td>
          <td class="px-3 py-3 font-bold text-[#5d4030]">${fmt(totalOrder(o))}</td>
          <td class="px-3 py-3">
            <button class="rounded-xl border border-[#dbc6b4] px-3 py-2 text-xs font-semibold transition hover:bg-[#f6ece4]" onclick="openOrderDetail('${o.id}')">Detail</button>
          </td>
        </tr>
      `).join('');
    }

    function filterOrders() {
      const q = document.getElementById('order-search').value.toLowerCase().trim();
      const filtered = orders.filter((o) => o.nama.toLowerCase().includes(q) || o.id.toLowerCase().includes(q));
      renderOrders(filtered);
    }

    function resetProductForm() {
      document.getElementById('prod-name').value = '';
      document.getElementById('prod-price').value = '';
      document.getElementById('prod-stock').value = '';
      document.getElementById('prod-size').value = '';
      document.getElementById('prod-desc').value = '';
      document.getElementById('prod-cat').value = 'Gaun';
      uploadedPhoto = '';
      document.getElementById('upload-zone').innerHTML = `
        <p class="text-3xl">&#128444;</p>
        <p class="mt-2 text-lg font-bold">Klik untuk upload foto produk</p>
        <p class="mt-1 text-sm text-[#8c6f5b]">JPG, PNG, WEBP (maks. 5MB)</p>
      `;
    }

    function openModal(id) {
      const modal = document.getElementById(id);
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeModal(id) {
      const modal = document.getElementById(id);
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    function openAddModal() {
      editingProductId = null;
      document.getElementById('modal-product-title').textContent = 'Tambah Produk';
      resetProductForm();
      openModal('modal-product');
    }

    function openEditModal(id) {
      const p = products.find((x) => x.id === id);
      if (!p) return;

      editingProductId = id;
      document.getElementById('modal-product-title').textContent = 'Edit Produk';
      document.getElementById('prod-name').value = p.name;
      document.getElementById('prod-price').value = p.price;
      document.getElementById('prod-stock').value = p.stock;
      document.getElementById('prod-size').value = p.size;
      document.getElementById('prod-desc').value = p.desc;
      document.getElementById('prod-cat').value = p.cat;
      uploadedPhoto = p.photo || '';
      document.getElementById('upload-zone').innerHTML = `
        <p class="text-3xl">&#128248;</p>
        <p class="mt-2 text-lg font-bold">Foto produk tersimpan</p>
        <p class="mt-1 text-sm text-[#8c6f5b]">Klik untuk ganti foto produk</p>
      `;

      openModal('modal-product');
    }

    function saveProduct() {
      const name = document.getElementById('prod-name').value.trim();
      const cat = document.getElementById('prod-cat').value;
      const price = parseInt(document.getElementById('prod-price').value, 10) || 0;
      const stock = parseInt(document.getElementById('prod-stock').value, 10) || 0;
      const size = document.getElementById('prod-size').value.trim();
      const desc = document.getElementById('prod-desc').value.trim();

      if (!name || !price) {
        alert('Nama produk dan harga wajib diisi.');
        return;
      }

      if (editingProductId) {
        const idx = products.findIndex((x) => x.id === editingProductId);
        if (idx > -1) {
          products[idx] = {
            ...products[idx],
            name,
            cat,
            price,
            stock,
            size,
            desc,
            photo: uploadedPhoto || products[idx].photo || defaultPhoto
          };
        }
      } else {
        products.unshift({
          id: nextProductId++,
          name,
          cat,
          price,
          stock,
          size,
          desc,
          photo: uploadedPhoto || defaultPhoto
        });
      }

      closeModal('modal-product');
      currentCat = cat;
      switchCat(cat);
      refreshStats();
      renderCatBars();
      renderLatestOrders();
    }

    function openDeleteModal(id) {
      deletingProductId = id;
      const p = products.find((x) => x.id === id);
      document.getElementById('delete-prod-name').textContent = p?.name || '';
      openModal('modal-delete');
    }

    function confirmDelete() {
      products = products.filter((x) => x.id !== deletingProductId);
      closeModal('modal-delete');
      renderProducts();
      renderCatBars();
      refreshStats();
    }

    function getCategoryIcon(name) {
      const text = name.toLowerCase();
      if (text.includes('gaun')) return '&#128087;';
      if (text.includes('kemeja')) return '&#128085;';
      if (text.includes('kardigan')) return '&#129526;';
      if (text.includes('rok')) return '&#128090;';
      return '&#128717;';
    }

    function openOrderDetail(orderId) {
      const o = orders.find((x) => x.id === orderId);
      if (!o) return;

      document.getElementById('order-modal-title').textContent = 'Detail Pesanan - ' + orderId;
      document.getElementById('order-modal-body').innerHTML = `
        <div class="mb-4 grid grid-cols-1 gap-3 md:grid-cols-2">
          <div class="rounded-2xl border border-[#eadccf] bg-[#fffaf6] p-4">
            <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">Nama Pembeli</p>
            <p class="mt-1 text-sm font-semibold text-[#5d4030]">${o.nama}</p>
          </div>
          <div class="rounded-2xl border border-[#eadccf] bg-[#fffaf6] p-4">
            <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">No HP</p>
            <p class="mt-1 text-sm font-semibold text-[#5d4030]">${o.hp}</p>
          </div>
        </div>

        <div class="mb-4 rounded-2xl border border-[#eadccf] bg-[#fffaf6] p-4">
          <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">Alamat Pengiriman</p>
          <p class="mt-1 text-sm font-medium leading-6 text-[#5d4030]">${o.alamat}</p>
        </div>

        <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.12em] text-[#9a7e6d]">Item Pesanan</p>
        <div class="overflow-hidden rounded-2xl border border-[#eadccf]">
          ${o.items.map((i) => `
            <div class="flex items-center gap-3 border-b border-[#eadccf] bg-white px-4 py-3 last:border-b-0">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f2e6db] text-lg">${getCategoryIcon(i.name)}</div>
              <div class="flex-1">
                <p class="font-semibold text-[#5d4030]">${i.name}</p>
                <p class="text-xs text-[#8c6f5b]">Qty ${i.qty}</p>
              </div>
              <p class="font-bold text-[#8f654a]">${fmt(i.price * i.qty)}</p>
            </div>
          `).join('')}
          <div class="flex items-center justify-between bg-[#fbf3ec] px-4 py-3">
            <p class="font-semibold text-[#5d4030]">Total Pembayaran</p>
            <p class="font-bold text-[#8f654a]">${fmt(totalOrder(o))}</p>
          </div>
        </div>
      `;

      openModal('modal-order');
    }

    function simulateUpload() {
      uploadedPhoto = defaultPhoto;
      document.getElementById('upload-zone').innerHTML = `
        <p class="text-3xl">&#128248;</p>
        <p class="mt-2 text-lg font-bold">Foto berhasil diupload</p>
        <p class="mt-1 text-sm text-[#8c6f5b]">Klik lagi jika ingin mengganti foto produk</p>
      `;
    }

    window.addEventListener('click', (e) => {
      document.querySelectorAll('#modal-product, #modal-order, #modal-delete').forEach((overlay) => {
        if (e.target === overlay) closeModal(overlay.id);
      });
    });

    refreshStats();
    renderLatestOrders();
    renderCatBars();
    switchCat('Gaun');
    renderOrders();
    showPage('dashboard');
  </script>
</body>

</html>