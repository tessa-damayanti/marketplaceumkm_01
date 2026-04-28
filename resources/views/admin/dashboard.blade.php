<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/css/admin-dashboard.css', 'resources/js/app.js'])

</head>

<body class="bg-white">

  <div class="shell min-h-screen">

    <!-- sidebar -->
    <aside class="sidebar hidden md:flex">
      <div class="sidebar-logo">Velora</div>
      <div class="sidebar-section-label">Menu Utama</div>

      <div class="nav-item active" onclick="goPage('dashboard')">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        Dashboard
      </div>
      <div class="nav-item" onclick="goPage('produk')">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path
            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
        </svg>  
        Produk
      </div>
      <div class="nav-item" onclick="goPage('kategori')">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7" />
          <rect x="14" y="3" width="7" height="7" />
          <rect x="3" y="14" width="7" height="7" />
          <rect x="14" y="14" width="7" height="7" />
        </svg>
        Kategori
      </div>
      <div class="nav-item" onclick="goPage('stok')">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <line x1="18" y1="20" x2="18" y2="10" />
          <line x1="12" y1="20" x2="12" y2="4" />
          <line x1="6" y1="20" x2="6" y2="14" />
        </svg>
        Stok Produk
      </div>
      <div class="nav-item" onclick="goPage('pesanan')">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
          <polyline points="14 2 14 8 20 8" />
          <line x1="16" y1="13" x2="8" y2="13" />
          <line x1="16" y1="17" x2="8" y2="17" />
        </svg>
        Pesanan
      </div>

      <div class="sidebar-spacer"></div>
      <a href="{{ route('home') }}" class="sidebar-logout" onclick="confirmLogout(event)">
        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          <polyline points="16 17 21 12 16 7" />
          <line x1="21" y1="12" x2="9" y2="12" />
        </svg>
        Keluar
      </a>
    </aside>

    <!-- MAIN WRAP -->
    <div class="main-wrap">
      <div class="topbar sticky top-0 z-20">
        <span class="topbar-title" id="topbar-title">Dashboard</span>
        <span class="topbar-greeting">Selamat Datang, Admin</span>
      </div>

      <div class="main-content">

        @include('admin.sections.dashboard-page')
        @include('admin.sections.produk-page')
        @include('admin.sections.kategori-page')
        @include('admin.sections.stok-page')
        @include('admin.sections.pesanan-page')

      </div>
    </div>
  </div>


  <!-- modal-->
  <!-- tambah dan edit produk -->
  <div class="overlay" id="modal-tambah-produk">
    <div class="modal">
      <div class="modal-header">
        <span class="modal-title" id="prod-modal-title">Tambah Produk</span>
        <button class="modal-close" onclick="closeModal('modal-tambah-produk')">&times;</button>
      </div>
      <div class="modal-body">
        <div>
          <label class="field-label">Upload File</label>
          <div class="upload-zone" onclick="document.getElementById('file-upload').click()">
            <span class="upload-btn-fake">Pilih File</span>
            <span class="upload-hint" id="upload-hint">Belum ada file dipilih</span>
            <input type="file" id="file-upload" accept="image/*" onchange="handleFileChange(this)">
          </div>
        </div>
        <div>
          <label class="field-label">Nama Produk</label>
          <input type="text" id="prod-nama" placeholder="Kemeja Stripe" style="width:100%">
        </div>
        <div>
          <label class="field-label">Kategori</label>
          <select id="prod-kat" style="width:100%">
            <option>Gaun</option>
            <option>Kemeja</option>
            <option>Kardigan</option>
            <option>Rok</option>
          </select>
        </div>
        <div>
          <label class="field-label">Harga</label>
          <input type="text" id="prod-harga" placeholder="Rp 100.000" style="width:100%">
        </div>
        <div>
          <label class="field-label">Deskripsi</label>
          <textarea id="prod-desk" rows="4" placeholder="Deskripsi produk..."
            style="width:100%;resize:vertical;"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-tambah-produk')">Batal</button>
        <button class="btn btn-dark" onclick="saveProduk()">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Hapus Produk Konfirmasi -->
  <div class="overlay overlay-top" id="modal-hapus-produk">
    <div class="modal modal-sm">
      <div class="confirm-box">
        <p>Apakah Anda yakin ingin menghapus produk ini?</p>
        <div class="confirm-actions">
          <button class="btn" onclick="closeModal('modal-hapus-produk')">Batal</button>
          <button class="btn btn-danger" onclick="confirmHapusProduk()">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <!-- tambah dan edit kategori -->
  <div class="overlay" id="modal-tambah-kat">
    <div class="modal modal-sm">
      <div class="modal-header">
        <span class="modal-title" id="kat-modal-title">Tambah Kategori</span>
        <button class="modal-close" onclick="closeModal('modal-tambah-kat')">&times;</button>
      </div>
      <div class="modal-body">
        <div>
          <label class="field-label">Nama Kategori</label>
          <input type="text" id="kat-nama" placeholder="Nama Kategori..." style="width:100%">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-tambah-kat')">Batal</button>
        <button class="btn btn-dark" onclick="saveKategori()">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Hapus Kategori -->
  <div class="overlay overlay-top" id="modal-hapus-kat">
    <div class="modal modal-sm">
      <div class="confirm-box">
        <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
        <div class="confirm-actions">
          <button class="btn" onclick="closeModal('modal-hapus-kat')">Batal</button>
          <button class="btn btn-danger" onclick="confirmHapusKat()">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Konfirmasi Keluar -->
  <div class="overlay overlay-top" id="modal-logout">
    <div class="modal modal-sm">
      <div class="confirm-box">
        <p>Apakah Anda yakin ingin keluar dari dashboard?</p>
        <div class="confirm-actions">
          <button class="btn" onclick="closeModal('modal-logout')">Batal</button>
          <button class="btn btn-danger" onclick="proceedLogout()">Ya, Keluar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Stok -->
  <div class="overlay" id="modal-stok">
    <div class="modal modal-sm">
      <div class="modal-header">
        <span class="modal-title">Edit Stok Produk</span>
        <button class="modal-close" onclick="closeModal('modal-stok')">&times;</button>
      </div>
      <div class="modal-body">
        <p style="font-size:13.5px;font-weight:700;color:#555;" id="stok-modal-produk-name">Produk: -</p>
        <div class="stok-row">
          <label>Ukuran S:</label>
          <input type="number" id="stok-s" min="0" value="0">
        </div>
        <div class="stok-row">
          <label>Ukuran M:</label>
          <input type="number" id="stok-m" min="0" value="0">
        </div>
        <div class="stok-row">
          <label>Ukuran L:</label>
          <input type="number" id="stok-l" min="0" value="0">
        </div>
        <div class="stok-row">
          <label>Ukuran XL:</label>
          <input type="number" id="stok-xl" min="0" value="0">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-stok')">Batal</button>
        <button class="btn btn-dark" onclick="saveStok()">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Detail Pesanan -->
  <div class="overlay" id="modal-pesanan">
    <div class="modal" style="width:520px;">
      <div class="modal-header">
        <span class="modal-title" id="pesanan-modal-title">Detail Pesanan - ID</span>
      </div>
      <div class="modal-body" id="pesanan-modal-body"></div>
      <div class="modal-footer">
        <button class="btn" onclick="closeModal('modal-pesanan')">Batal</button>
        <button class="btn btn-dark" onclick="saveEditStatus()">Simpan</button>
      </div>
    </div>
  </div>


  <script>
    // data

    let produkList = [{
      id: 'P001',
      nama: 'Kemeja Stripe',
      kategori: 'Kemeja',
      harga: 100000,
      deskripsi: 'Kemeja wanita bermotif garis.',
      stok: {
        S: 4,
        M: 4,
        L: 4,
        XL: 4
      }
    },
    {
      id: 'P002',
      nama: 'Gaun Ivory',
      kategori: 'Gaun',
      harga: 175000,
      deskripsi: 'Gaun wanita elegan warna ivory.',
      stok: {
        S: 3,
        M: 5,
        L: 2,
        XL: 1
      }
    },
    {
      id: 'P003',
      nama: 'Kardigan Floral',
      kategori: 'Kardigan',
      harga: 118000,
      deskripsi: 'Kardigan motif bunga cantik.',
      stok: {
        S: 6,
        M: 4,
        L: 3,
        XL: 2
      }
    },
    {
      id: 'P004',
      nama: 'Rok Denim',
      kategori: 'Rok',
      harga: 132000,
      deskripsi: 'Rok denim kasual modern.',
      stok: {
        S: 5,
        M: 5,
        L: 4,
        XL: 3
      }
    },
    {
      id: 'P005',
      nama: 'Gaun Floral Pastel',
      kategori: 'Gaun',
      harga: 210000,
      deskripsi: 'Gaun pastel bermotif floral.',
      stok: {
        S: 2,
        M: 4,
        L: 3,
        XL: 1
      }
    },
    {
      id: 'P006',
      nama: 'Kemeja Hitam',
      kategori: 'Kemeja',
      harga: 105000,
      deskripsi: 'Kemeja polos warna hitam.',
      stok: {
        S: 4,
        M: 4,
        L: 4,
        XL: 4
      }
    },
    {
      id: 'P007',
      nama: 'Kardigan Rajut',
      kategori: 'Kardigan',
      harga: 145000,
      deskripsi: 'Kardigan rajut hangat nyaman.',
      stok: {
        S: 3,
        M: 5,
        L: 4,
        XL: 2
      }
    },
    {
      id: 'P008',
      nama: 'Rok Plisket',
      kategori: 'Rok',
      harga: 98000,
      deskripsi: 'Rok plisket elegan.',
      stok: {
        S: 5,
        M: 6,
        L: 4,
        XL: 3
      }
    },
    ];

    let kategoriList = [{
      id: 'K001',
      nama: 'Kemeja'
    },
    {
      id: 'K002',
      nama: 'Gaun'
    },
    {
      id: 'K003',
      nama: 'Kardigan'
    },
    {
      id: 'K004',
      nama: 'Rok'
    },
    ];

    let pesananList = [{
      id: 'P001',
      tanggal: '12-05-2026',
      nama: 'Citra',
      hp: '08132244551',
      alamat: 'Jln. Ahmad Yani No. 22',
      status: 'Menunggu Verifikasi',
      items: [{
        produk: 'Kemeja Hitam',
        ukuran: 'L',
        qty: 1,
        harga: 105000
      }]
    },
    {
      id: 'P002',
      tanggal: '12-05-2026',
      nama: 'Ayu Putri',
      hp: '08211234567',
      alamat: 'Jln. Sudirman No. 45',
      status: 'Pembayaran Valid',
      items: [{
        produk: 'Gaun Floral Pastel',
        ukuran: 'M',
        qty: 1,
        harga: 210000
      }]
    },
    {
      id: 'P003',
      tanggal: '12-05-2026',
      nama: 'Dinda',
      hp: '08567890123',
      alamat: 'Jln. Merdeka Blok C5',
      status: 'Pembayaran Ditolak',
      items: [{
        produk: 'Rok Plisket',
        ukuran: 'S',
        qty: 1,
        harga: 98000
      }, {
        produk: 'Kardigan Rajut',
        ukuran: 'M',
        qty: 1,
        harga: 145000
      }]
    },
    {
      id: 'P004',
      tanggal: '11-05-2026',
      nama: 'Naura',
      hp: '08129876543',
      alamat: 'Jln. Pahlawan No. 8',
      status: 'Menunggu Verifikasi',
      items: [{
        produk: 'Gaun Ivory',
        ukuran: 'S',
        qty: 1,
        harga: 175000
      }]
    },
    {
      id: 'P005',
      tanggal: '11-05-2026',
      nama: 'Cahya Yanti',
      hp: '08561234567',
      alamat: 'Jln. Diponegoro No. 3',
      status: 'Konfirmasi Ulang',
      items: [{
        produk: 'Kemeja Stripe',
        ukuran: 'M',
        qty: 2,
        harga: 100000
      }]
    },
    {
      id: 'P006',
      tanggal: '10-05-2026',
      nama: 'Merita Anisa',
      hp: '08781234567',
      alamat: 'Jln. Kenanga No. 12',
      status: 'Pembayaran Valid',
      items: [{
        produk: 'Kardigan Floral',
        ukuran: 'L',
        qty: 1,
        harga: 118000
      }]
    },
    ];

    // STATE
    let editingProdukId = null;
    let deletingProdukId = null;
    let editingKatId = null;
    let deletingKatId = null;
    let editingStokId = null;
    let viewingPesananId = null;
    let selectedProdukImage = '';
    let produkIdCounter = 9;
    let katIdCounter = 5;

    // NAVIGATION
    const pageTitles = {
      dashboard: 'Dashboard',
      produk: 'Produk',
      kategori: 'Kategori',
      stok: 'Stok Produk',
      pesanan: 'Pesanan',
    };

    function goPage(page) {
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      document.getElementById('page-' + page).classList.add('active');
      document.getElementById('topbar-title').textContent = pageTitles[page];

      const navMap = {
        dashboard: 0,
        produk: 1,
        kategori: 2,
        stok: 3,
        pesanan: 4
      };
      document.querySelectorAll('.nav-item')[navMap[page]]?.classList.add('active');

      if (page === 'dashboard') renderDashboard();
      if (page === 'produk') renderProdukTable();
      if (page === 'kategori') renderKategoriTable();
      if (page === 'stok') renderStokTable();
      if (page === 'pesanan') renderPesananTable();
    }

    // HELPERS
    function rp(n) {
      return 'Rp' + Number(n).toLocaleString('id-ID');
    }

    const produkImages = {
      'Kemeja Stripe': 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
      'Kemeja Hitam': 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg',
      'Gaun Ivory': 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg',
      'Gaun Floral Pastel': 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg',
      'Kardigan Floral': 'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg',
      'Kardigan Rajut': 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
      'Rok Denim': 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg',
      'Rok Plisket': 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg',
    };

    const editIcon = `
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path d="M3 17.25V21h3.75L17.8 9.94l-3.75-3.75L3 17.25z"></path>
        <path d="M14.06 4.94l3.75 3.75"></path>
      </svg>`;

    const deleteIcon = `
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path d="M3 6h18"></path>
        <path d="M8 6V4h8v2"></path>
        <path d="M19 6l-1 14H6L5 6"></path>
        <path d="M10 11v6"></path>
        <path d="M14 11v6"></path>
      </svg>`;

    const detailIcon = `
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
        <circle cx="12" cy="12" r="9"></circle>
        <path d="M12 16v-4"></path>
        <path d="M12 8h.01"></path>
      </svg>`;

    function getProdukImage(name = '', explicitImage = '') {
      if (explicitImage) return explicitImage;
      const produk = produkList.find(item => item.nama === name);
      if (produk?.image) return produk.image;
      return produkImages[name] || '';
    }

    function renderThumb(name = '', className = 'foto-cell', imageUrl = '') {
      const image = getProdukImage(name, imageUrl);
      if (image) {
        return `<div class="${className}" title="Foto ${name}"><img src="${image}" alt="${name}" class="thumb-image"></div>`;
      }
      return `<div class="${className}" title="Foto ${name}">${name.split(' ').map(part => part[0]).slice(0, 2).join('').toUpperCase() || '--'}</div>`;
    }

    function statusBadge(s) {
      if (s === 'Pembayaran Valid') {
        return `<span class="inline-flex items-center rounded-full bg-[#dfe8da] px-2.5 py-0.5 text-[12px] font-semibold text-[#6f7f67]">${s}</span>`;
      }

      if (s === 'Pembayaran Ditolak') {
        return `<span class="inline-flex items-center rounded-full bg-[#eadfd8] px-2.5 py-0.5 text-[12px] font-semibold text-[#9a6238]">${s}</span>`;
      }

      if (s === 'Konfirmasi Ulang') {
        return `<span class="inline-flex items-center rounded-full bg-[#dfe3f1] px-2.5 py-0.5 text-[12px] font-semibold text-[#5870a6]">${s}</span>`;
      }

      return `<span class="inline-flex items-center rounded-full bg-[#dfe3f1] px-2.5 py-0.5 text-[12px] font-semibold text-[#5870a6]">${s}</span>`;
    }

    function openModal(id) {
      document.getElementById(id).classList.add('open');
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove('open');
    }

    let logoutUrl = "{{ route('home') }}";

    function confirmLogout(event) {
      event.preventDefault();
      openModal('modal-logout');
    }

    function proceedLogout() {
      window.location.href = logoutUrl;
    }

    // DASHBOARD
    function renderDashboard() {
      document.getElementById('s-pesanan').textContent = pesananList.length;
      document.getElementById('s-produk').textContent = produkList.length;
      document.getElementById('s-kategori').textContent = kategoriList.length;

      // Calculate sold items and stock items
      let totalSold = 0;
      pesananList.forEach(pesanan => {
        if (pesanan.status !== 'Pembayaran Ditolak') {
          pesanan.items.forEach(item => {
            totalSold += item.qty;
          });
        }
      });

      let totalStock = 0;
      produkList.forEach(produk => {
        totalStock += produk.stok.S + produk.stok.M + produk.stok.L + produk.stok.XL;
      });

      let totalItems = totalSold + totalStock;
      let percentageSold = totalItems > 0 ? Math.round((totalSold / totalItems) * 100) : 0;

      const elPersentase = document.getElementById('s-persentase');
      if (elPersentase) elPersentase.textContent = totalSold;
      const elTerjual = document.getElementById('s-terjual');
      if (elTerjual) elTerjual.textContent = totalSold;
      const elTotalStok = document.getElementById('s-total-stok');
      if (elTotalStok) elTotalStok.textContent = totalItems;

      // Update circular progress
      const circle = document.getElementById('dash-progress-circle');
      if (circle) {
        const circumference = 2 * Math.PI * 40; // 251.2
        const offset = circumference - (percentageSold / 100) * circumference;
        circle.style.strokeDashoffset = offset;
      }
      const progressText = document.getElementById('dash-progress-text');
      if (progressText) progressText.textContent = totalSold;

      const statStok = document.getElementById('dash-stat-stok');
      if (statStok) statStok.textContent = totalStock;
      const statTerjual = document.getElementById('dash-stat-terjual');
      if (statTerjual) statTerjual.textContent = totalSold;

      const barTerjual = document.getElementById('dash-bar-terjual');
      if (barTerjual) barTerjual.style.width = percentageSold + '%';
      const barStok = document.getElementById('dash-bar-stok');
      if (barStok) barStok.style.width = (100 - percentageSold) + '%';

      const recent = pesananList.slice(0, 5);
      document.getElementById('dash-orders-tbody').innerHTML = recent.map(o => `
    <tr class="transition-colors">
      <td class="px-6 py-4 font-medium text-[#4a3628]">${o.id}</td>
      <td class="px-6 py-4"><strong>${o.nama}</strong></td>
      <td class="px-6 py-4">${o.items.map(i => i.produk).join(', ')}</td>
      <td class="px-6 py-4">${statusBadge(o.status)}</td>
      <td class="px-6 py-4 text-right font-bold text-[#4a3628]">${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
    </tr>`).join('');

      const dashPagiInfo = document.getElementById('dash-pagi-info');
      if (dashPagiInfo) {
        dashPagiInfo.innerHTML = `<span class="font-bold text-[#5c4432]">1 - ${recent.length}</span> dari <span class="font-bold text-[#5c4432]">${pesananList.length}</span>`;
      }
    }

    // PRODUK
    function renderProdukTable() {
      const filterKat = document.getElementById('produk-filter-kat')?.value || '';
      const search = document.getElementById('produk-search')?.value.toLowerCase() || '';

      let list = filterKat ? produkList.filter(p => p.kategori === filterKat) : produkList;
      if (search) {
        list = list.filter(p => p.nama.toLowerCase().includes(search) || p.id.toLowerCase().includes(search));
      }

      const limit = 10;
      const total = list.length;
      const start = 0; // Simplified for now, only showing first 10
      const end = Math.min(start + limit, total);
      const displayList = list.slice(start, end);

      document.getElementById('produk-tbody').innerHTML = displayList.map(p => `
    <tr>
      <td class="id-cell">${p.id}</td>
      <td>${renderThumb(p.nama, 'foto-cell', p.image || '')}</td>
      <td><strong>${p.nama}</strong></td>
      <td>${p.kategori}</td>
      <td>${rp(p.harga)}</td>
      <td class="action-cell">
        <div class="action-buttons">
          <button class="icon-btn icon-btn-edit" type="button" onclick="openEditProduk('${p.id}')" aria-label="Edit produk">${editIcon}</button>
          <button class="icon-btn icon-btn-delete" type="button" onclick="openHapusProduk('${p.id}')" aria-label="Hapus produk">${deleteIcon}</button>
        </div>
      </td>
    </tr>`).join('');

      document.getElementById('produk-pagi-info').innerHTML = `<span class="font-bold text-[#5c4432]">${total > 0 ? start + 1 : 0} - ${end}</span> dari <span class="font-bold text-[#5c4432]">${total}</span>`;
    }

    function setModalMode(mode) {
      editingProdukId = null;
      selectedProdukImage = '';
      document.getElementById('prod-modal-title').textContent = 'Tambah Produk';
      document.getElementById('prod-nama').value = '';
      document.getElementById('prod-kat').value = 'Gaun';
      document.getElementById('prod-harga').value = '';
      document.getElementById('prod-desk').value = '';
      document.getElementById('file-upload').value = '';
      document.getElementById('upload-hint').textContent = 'Belum ada file dipilih';
    }

    function openEditProduk(id) {
      const p = produkList.find(x => x.id === id);
      if (!p) return;
      editingProdukId = id;
      document.getElementById('prod-modal-title').textContent = 'Edit Produk';
      document.getElementById('prod-nama').value = p.nama;
      document.getElementById('prod-kat').value = p.kategori;
      document.getElementById('prod-harga').value = p.harga;
      document.getElementById('prod-desk').value = p.deskripsi;
      selectedProdukImage = p.image || '';
      document.getElementById('file-upload').value = '';
      document.getElementById('upload-hint').textContent = 'Foto tersimpan';
      openModal('modal-tambah-produk');
    }

    function openHapusProduk(id) {
      deletingProdukId = id;
      openModal('modal-hapus-produk');
    }

    function saveProduk() {
      const nama = document.getElementById('prod-nama').value.trim();
      const kat = document.getElementById('prod-kat').value;
      const harga = parseInt(document.getElementById('prod-harga').value.replace(/\D/g, '')) || 0;
      const desk = document.getElementById('prod-desk').value.trim();

      if (!nama) {
        alert('Nama produk wajib diisi.');
        return;
      }

      if (editingProdukId) {
        const p = produkList.find(x => x.id === editingProdukId);
        if (p) {
          p.nama = nama;
          p.kategori = kat;
          p.harga = harga;
          p.deskripsi = desk;
          if (selectedProdukImage) p.image = selectedProdukImage;
        }
      } else {
        const newId = 'P' + String(produkIdCounter++).padStart(3, '0');
        produkList.push({
          id: newId,
          nama,
          kategori: kat,
          harga,
          deskripsi: desk,
          image: selectedProdukImage,
          stok: {
            S: 0,
            M: 0,
            L: 0,
            XL: 0
          }
        });
      }
      closeModal('modal-tambah-produk');
      renderProdukTable();
    }

    function confirmHapusProduk() {
      produkList = produkList.filter(x => x.id !== deletingProdukId);
      closeModal('modal-hapus-produk');
      renderProdukTable();
    }

    function handleFileChange(input) {
      const file = input.files[0];
      document.getElementById('upload-hint').textContent = file?.name || 'Belum ada file dipilih';
      if (!file) {
        selectedProdukImage = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = () => {
        selectedProdukImage = String(reader.result || '');
      };
      reader.readAsDataURL(file);
    }

    // KATEGORI
    function renderKategoriTable() {
      const search = document.getElementById('kategori-search')?.value.toLowerCase() || '';
      let list = kategoriList;
      if (search) {
        list = list.filter(k => k.nama.toLowerCase().includes(search) || k.id.toLowerCase().includes(search));
      }

      const limit = 10;
      const total = list.length;
      const start = 0;
      const end = Math.min(start + limit, total);
      const displayList = list.slice(start, end);

      document.getElementById('kategori-tbody').innerHTML = displayList.map(k => `
    <tr>
      <td class="id-cell">${k.id}</td>
      <td><strong>${k.nama}</strong></td>
      <td class="action-cell">
        <div class="action-buttons">
          <button class="icon-btn icon-btn-edit" type="button" onclick="openEditKat('${k.id}')" aria-label="Edit kategori">${editIcon}</button>
          <button class="icon-btn icon-btn-delete" type="button" onclick="openHapusKat('${k.id}')" aria-label="Hapus kategori">${deleteIcon}</button>
        </div>
      </td>
    </tr>`).join('');

      document.getElementById('kategori-pagi-info').innerHTML = `<span class="font-bold text-[#5c4432]">${total > 0 ? start + 1 : 0} - ${end}</span> dari <span class="font-bold text-[#5c4432]">${total}</span>`;
    }

    function setKatModalMode(mode) {
      editingKatId = null;
      document.getElementById('kat-modal-title').textContent = 'Tambah Kategori';
      document.getElementById('kat-nama').value = '';
    }

    function openEditKat(id) {
      const k = kategoriList.find(x => x.id === id);
      if (!k) return;
      editingKatId = id;
      document.getElementById('kat-modal-title').textContent = 'Edit Kategori';
      document.getElementById('kat-nama').value = k.nama;
      openModal('modal-tambah-kat');
    }

    function openHapusKat(id) {
      deletingKatId = id;
      openModal('modal-hapus-kat');
    }

    function saveKategori() {
      const nama = document.getElementById('kat-nama').value.trim();
      if (!nama) {
        alert('Nama kategori wajib diisi.');
        return;
      }

      if (editingKatId) {
        const k = kategoriList.find(x => x.id === editingKatId);
        if (k) k.nama = nama;
      } else {
        const newId = 'K' + String(katIdCounter++).padStart(3, '0');
        kategoriList.push({
          id: newId,
          nama
        });
      }
      closeModal('modal-tambah-kat');
      renderKategoriTable();
    }

    function confirmHapusKat() {
      kategoriList = kategoriList.filter(x => x.id !== deletingKatId);
      closeModal('modal-hapus-kat');
      renderKategoriTable();
    }

    // STOK
    function renderStokTable() {
      const search = document.getElementById('stok-search')?.value.toLowerCase() || '';
      let list = produkList;
      if (search) {
        list = list.filter(p => p.nama.toLowerCase().includes(search) || p.id.toLowerCase().includes(search));
      }

      const limit = 10;
      const total = list.length;
      const start = 0;
      const end = Math.min(start + limit, total);
      const displayList = list.slice(start, end);

      document.getElementById('stok-tbody').innerHTML = displayList.map(p => `
    <tr>
      <td><strong>${p.nama}</strong></td>
      <td style="text-align:center;">${p.stok.S}</td>
      <td style="text-align:center;">${p.stok.M}</td>
      <td style="text-align:center;">${p.stok.L}</td>
      <td style="text-align:center;">${p.stok.XL}</td>
      <td class="action-cell">
        <div class="action-buttons">
          <button class="icon-btn icon-btn-edit" type="button" onclick="openEditStok('${p.id}')" aria-label="Edit stok">${editIcon}</button>
        </div>
      </td>
    </tr>`).join('');

      document.getElementById('stok-pagi-info').innerHTML = `<span class="font-bold text-[#5c4432]">${total > 0 ? start + 1 : 0} - ${end}</span> dari <span class="font-bold text-[#5c4432]">${total}</span>`;
    }

    function openEditStok(id) {
      const p = produkList.find(x => x.id === id);
      if (!p) return;
      editingStokId = id;
      document.getElementById('stok-modal-produk-name').textContent = 'Produk: ' + p.nama;
      document.getElementById('stok-s').value = p.stok.S;
      document.getElementById('stok-m').value = p.stok.M;
      document.getElementById('stok-l').value = p.stok.L;
      document.getElementById('stok-xl').value = p.stok.XL;
      openModal('modal-stok');
    }

    function saveStok() {
      const p = produkList.find(x => x.id === editingStokId);
      if (!p) return;
      p.stok.S = parseInt(document.getElementById('stok-s').value) || 0;
      p.stok.M = parseInt(document.getElementById('stok-m').value) || 0;
      p.stok.L = parseInt(document.getElementById('stok-l').value) || 0;
      p.stok.XL = parseInt(document.getElementById('stok-xl').value) || 0;
      closeModal('modal-stok');
      renderStokTable();
    }

    // PESANAN
    function renderPesananTable() {
      const filterStatus = document.getElementById('pesanan-filter-status')?.value || '';
      const dateFrom = document.getElementById('pesanan-date-from')?.value || '';
      const dateTo = document.getElementById('pesanan-date-to')?.value || '';
      const search = document.getElementById('pesanan-search')?.value.toLowerCase() || '';

      let list = pesananList.filter(o => {
        const matchStatus = !filterStatus || o.status === filterStatus;
        const matchSearch = !search || o.nama.toLowerCase().includes(search) || o.id.toLowerCase().includes(search);

        let matchDate = true;
        if (dateFrom || dateTo) {
          const parts = o.tanggal.split('-'); // dd-mm-yyyy
          const tglISO = parts[2] + '-' + parts[1] + '-' + parts[0];

          if (dateFrom && tglISO < dateFrom) matchDate = false;
          if (dateTo && tglISO > dateTo) matchDate = false;
        }

        return matchStatus && matchDate && matchSearch;
      });

      const limit = 10;
      const total = list.length;
      const start = 0;
      const end = Math.min(start + limit, total);
      const displayList = list.slice(start, end);

      document.getElementById('pesanan-tbody').innerHTML = displayList.length ?
        displayList.map(o => `
      <tr class="border-t border-[#e2d4c5]">
        <td class="px-6 py-4 text-center font-semibold text-[#5c4432]">${o.id}</td>
        <td class="px-6 py-4 text-[#5c4432]">${o.tanggal}</td>
        <td class="px-6 py-4 text-[#5c4432] font-semibold">${o.nama}</td>
        <td class="px-6 py-4">${statusBadge(o.status)}</td>
        <td class="px-6 py-4 text-[#5c4432] font-semibold">
          ${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}
        </td>
        <td class="px-6 py-4 text-center">
          <button
            type="button"
            onclick="openDetailPesanan('${o.id}')"
            class="inline-flex items-center justify-center rounded-xl border border-[#d8c3af] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
          >
            Detail
          </button>
        </td>
      </tr>
    `).join('') :
        `
      <tr>
        <td colspan="6" class="px-6 py-6 text-center text-[#b7a08c]">
          Tidak ada pesanan ditemukan.
        </td>
      </tr>
    `;

      document.getElementById('pesanan-pagi-info').innerHTML = `<span class="font-bold text-[#5c4432]">${total > 0 ? start + 1 : 0} - ${end}</span> dari <span class="font-bold text-[#5c4432]">${total}</span>`;
    }

    function openDetailPesanan(id) {
      const o = pesananList.find(x => x.id === id);
      if (!o) return;
      viewingPesananId = id;
      const total = o.items.reduce((s, i) => s + i.harga * i.qty, 0);

      document.getElementById('pesanan-modal-title').textContent = `Detail Pesanan - ${o.id}`;
      document.getElementById('pesanan-modal-body').innerHTML = `
    <div class="detail-grid">
      <div class="detail-field">
        <div class="detail-field-label">Nama Pembeli</div>
        <div class="detail-field-value">${o.nama}</div>
      </div>
      <div class="detail-field">
        <div class="detail-field-label">No HP</div>
        <div class="detail-field-value">${o.hp}</div>
      </div>
      <div class="detail-field">
        <div class="detail-field-label">Tanggal Pesanan</div>
        <div class="detail-field-value">${o.tanggal}</div>
      </div>
      <div class="detail-field">
        <div class="detail-field-label">Alamat</div>
        <div class="detail-field-value">${o.alamat}</div>
      </div>
      <div class="detail-field">
        <div class="detail-field-label">Status Pembayaran</div>
        <div class="detail-field-value">${o.status}</div>
      </div>
    </div>

    <div>
      <label class="field-label" style="margin-bottom:6px;">Bukti Pembayaran</label>
      <div class="bukti-row">
        ${renderThumb(o.items[0]?.produk || o.nama, 'bukti-thumb')}
        <button class="btn btn-sm" style="margin-left:auto;">Lihat Bukti</button>
      </div>
    </div>

    <div>
      <label class="field-label" style="margin-bottom:8px;">Item Pesanan</label>
      <div class="items-block">
        ${o.items.map(i => `
          <div class="item-row">
            ${renderThumb(i.produk, 'item-thumb')}
            <div class="item-info">
              <div class="item-name">${i.produk}</div>
              <div class="item-size">${i.ukuran}</div>
            </div>
            <div class="item-price">${rp(i.harga)}<br><span style="font-size:11px;color:#999;font-weight:400;">x${i.qty}</span></div>
          </div>`).join('')}
        <div class="total-row">
          <span>Total Pembayaran</span>
          <span>${rp(total)}</span>
        </div>
      </div>
    </div>

    <div class="status-edit-wrap">
      <label class="field-label" for="status-select">Update Status</label>
      <select class="status-edit-sel" id="status-select">
        <option ${o.status === 'Menunggu Verifikasi' ? 'selected' : ''}>Menunggu Verifikasi</option>
        <option ${o.status === 'Pembayaran Valid' ? 'selected' : ''}>Pembayaran Valid</option>
        <option ${o.status === 'Pembayaran Ditolak' ? 'selected' : ''}>Pembayaran Ditolak</option>
        <option ${o.status === 'Konfirmasi Ulang' ? 'selected' : ''}>Konfirmasi Ulang</option>
      </select>
    </div>`;

      openModal('modal-pesanan');
    }

    function saveEditStatus() {
      const o = pesananList.find(x => x.id === viewingPesananId);
      if (!o) return;
      o.status = document.getElementById('status-select').value;
      closeModal('modal-pesanan');
      renderPesananTable();
      if (document.getElementById('page-dashboard').classList.contains('active')) renderDashboard();
    }

    renderDashboard();
  </script>
</body>

</html>