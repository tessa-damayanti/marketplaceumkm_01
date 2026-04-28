<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Admin Dashboard')</title>
  @vite(['resources/css/app.css', 'resources/css/admin-dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f7f2eb] text-[#5c4432] antialiased">

  <div class="shell">
    <!-- sidebar -->
    <x-admin.sidebar />

    <!-- MAIN WRAP -->
    <div class="main-wrap">
      <!-- topbar -->
      <x-admin.topbar :title="$__env->yieldContent('page_title', 'Dashboard')" />

      <div class="main-content">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- all modals -->
  <x-admin.modals />

  <script>
    // data
    let produkList = [{
        id: 'P001',
        nama: 'Kemeja Stripe',
        kategori: 'Kemeja',
        harga: 100000,
        deskripsi: 'Kemeja wanita bermotif garis.',
        stok: { S: 4, M: 4, L: 4, XL: 4 }
      },
      {
        id: 'P002',
        nama: 'Gaun Ivory',
        kategori: 'Gaun',
        harga: 175000,
        deskripsi: 'Gaun wanita elegan warna ivory.',
        stok: { S: 3, M: 5, L: 2, XL: 1 }
      },
      {
        id: 'P003',
        nama: 'Kardigan Floral',
        kategori: 'Kardigan',
        harga: 118000,
        deskripsi: 'Kardigan motif bunga cantik.',
        stok: { S: 6, M: 4, L: 3, XL: 2 }
      },
      {
        id: 'P004',
        nama: 'Rok Denim',
        kategori: 'Rok',
        harga: 132000,
        deskripsi: 'Rok denim kasual modern.',
        stok: { S: 5, M: 5, L: 4, XL: 3 }
      },
      {
        id: 'P005',
        nama: 'Gaun Floral Pastel',
        kategori: 'Gaun',
        harga: 210000,
        deskripsi: 'Gaun pastel bermotif floral.',
        stok: { S: 2, M: 4, L: 3, XL: 1 }
      },
      {
        id: 'P006',
        nama: 'Kemeja Hitam',
        kategori: 'Kemeja',
        harga: 105000,
        deskripsi: 'Kemeja polos warna hitam.',
        stok: { S: 4, M: 4, L: 4, XL: 4 }
      },
      {
        id: 'P007',
        nama: 'Kardigan Rajut',
        kategori: 'Kardigan',
        harga: 145000,
        deskripsi: 'Kardigan rajut hangat nyaman.',
        stok: { S: 3, M: 5, L: 4, XL: 2 }
      },
      {
        id: 'P008',
        nama: 'Rok Plisket',
        kategori: 'Rok',
        harga: 98000,
        deskripsi: 'Rok plisket elegan.',
        stok: { S: 5, M: 6, L: 4, XL: 3 }
      },
    ];

    let kategoriList = [{ id: 'K001', nama: 'Kemeja' }, { id: 'K002', nama: 'Gaun' }, { id: 'K003', nama: 'Kardigan' }, { id: 'K004', nama: 'Rok' }];

    let pesananList = [
      { id: 'P001', tanggal: '12-05-2026', nama: 'Citra', hp: '08132244551', alamat: 'Jln. Ahmad Yani No. 22', status: 'Menunggu Verifikasi', items: [{ produk: 'Kemeja Hitam', ukuran: 'L', qty: 1, harga: 105000 }] },
      { id: 'P002', tanggal: '12-05-2026', nama: 'Ayu Putri', hp: '08211234567', alamat: 'Jln. Sudirman No. 45', status: 'Pembayaran Valid', items: [{ produk: 'Gaun Floral Pastel', ukuran: 'M', qty: 1, harga: 210000 }] },
      { id: 'P003', tanggal: '12-05-2026', nama: 'Dinda', hp: '08567890123', alamat: 'Jln. Merdeka Blok C5', status: 'Pembayaran Ditolak', items: [{ produk: 'Rok Plisket', ukuran: 'S', qty: 1, harga: 98000 }, { produk: 'Kardigan Rajut', ukuran: 'M', qty: 1, harga: 145000 }] },
      { id: 'P004', tanggal: '11-05-2026', nama: 'Naura', hp: '08129876543', alamat: 'Jln. Pahlawan No. 8', status: 'Menunggu Verifikasi', items: [{ produk: 'Gaun Ivory', ukuran: 'S', qty: 1, harga: 175000 }] },
      { id: 'P005', tanggal: '11-05-2026', nama: 'Cahya Yanti', hp: '08561234567', alamat: 'Jln. Diponegoro No. 3', status: 'Konfirmasi Ulang', items: [{ produk: 'Kemeja Stripe', ukuran: 'M', qty: 2, harga: 100000 }] },
      { id: 'P006', tanggal: '10-05-2026', nama: 'Merita Anisa', hp: '08781234567', alamat: 'Jln. Kenanga No. 12', status: 'Pembayaran Valid', items: [{ produk: 'Kardigan Floral', ukuran: 'L', qty: 1, harga: 118000 }] },
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

    // HELPERS
    function rp(n) { return 'Rp' + Number(n).toLocaleString('id-ID'); }

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

    const editIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 17.25V21h3.75L17.8 9.94l-3.75-3.75L3 17.25z"></path><path d="M14.06 4.94l3.75 3.75"></path></svg>`;
    const deleteIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></svg>`;

    function getProdukImage(name = '', explicitImage = '') { return explicitImage || produkImages[name] || ''; }

    function renderThumb(name = '', className = 'foto-cell', imageUrl = '') {
      const image = getProdukImage(name, imageUrl);
      if (image) return `<div class="${className}" title="Foto ${name}"><img src="${image}" alt="${name}" class="thumb-image"></div>`;
      return `<div class="${className}" title="Foto ${name}">${name.split(' ').map(part => part[0]).slice(0, 2).join('').toUpperCase() || '--'}</div>`;
    }

    function statusBadge(s) {
      const colors = {
        'Pembayaran Valid': 'bg-[#dfe8da] text-[#6f7f67]',
        'Pembayaran Ditolak': 'bg-[#eadfd8] text-[#9a6238]',
        'Konfirmasi Ulang': 'bg-[#dfe3f1] text-[#5870a6]',
        'Menunggu Verifikasi': 'bg-[#dfe3f1] text-[#5870a6]'
      };
      return `<span class="inline-flex items-center rounded-full ${colors[s] || colors['Menunggu Verifikasi']} px-4 py-1.5 text-sm font-semibold">${s}</span>`;
    }

    function openModal(id) { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    function confirmLogout(event) { event.preventDefault(); openModal('modal-logout'); }
    function proceedLogout() { window.location.href = "{{ route('home') }}"; }

    // DASHBOARD
    function renderDashboard() {
      if (!document.getElementById('s-pesanan')) return;
      document.getElementById('s-pesanan').textContent = pesananList.length;
      document.getElementById('s-produk').textContent = produkList.length;
      document.getElementById('s-kategori').textContent = kategoriList.length;

      const recent = pesananList.slice(0, 5);
      document.getElementById('dash-orders-tbody').innerHTML = recent.map(o => `
        <tr>
          <td class="id-cell">${o.id}</td>
          <td><strong>${o.nama}</strong></td>
          <td>${o.items.map(i => i.produk).join(', ')}</td>
          <td>${statusBadge(o.status)}</td>
          <td>${rp(o.items.reduce((s,i) => s + i.harga * i.qty, 0))}</td>
        </tr>`).join('');
    }

    // PRODUK
    function renderProdukTable() {
      if (!document.getElementById('produk-tbody')) return;
      const filterKat = document.getElementById('produk-filter-kat')?.value || '';
      const searchQuery = document.getElementById('produk-search')?.value.toLowerCase() || '';

      let list = produkList;
      if (filterKat) list = list.filter(p => p.kategori === filterKat);
      if (searchQuery) list = list.filter(p => p.nama.toLowerCase().includes(searchQuery));

      document.getElementById('produk-tbody').innerHTML = list.map(p => `
        <tr>
          <td class="id-cell">${p.id}</td>
          <td>${renderThumb(p.nama, 'foto-cell', p.image || '')}</td>
          <td><strong>${p.nama}</strong></td>
          <td>${p.kategori}</td>
          <td>${rp(p.harga)}</td>
          <td class="action-cell">
            <div class="action-buttons">
              <button class="icon-btn icon-btn-edit" type="button" onclick="openEditProduk('${p.id}')">${editIcon}</button>
              <button class="icon-btn icon-btn-delete" type="button" onclick="openHapusProduk('${p.id}')">${deleteIcon}</button>
            </div>
          </td>
        </tr>`).join('');
    }

    function setModalMode(mode) {
      editingProdukId = null;
      selectedProdukImage = '';
      document.getElementById('prod-modal-title').textContent = 'Tambah Produk';
      ['prod-nama', 'prod-harga', 'prod-desk', 'file-upload'].forEach(id => document.getElementById(id).value = '');
      document.getElementById('prod-kat').value = 'Gaun';
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
      document.getElementById('upload-hint').textContent = 'Foto tersimpan';
      openModal('modal-tambah-produk');
    }

    function openHapusProduk(id) { deletingProdukId = id; openModal('modal-hapus-produk'); }

    function saveProduk() {
      const nama = document.getElementById('prod-nama').value.trim();
      const kat = document.getElementById('prod-kat').value;
      const harga = parseInt(document.getElementById('prod-harga').value.replace(/\D/g, '')) || 0;
      const desk = document.getElementById('prod-desk').value.trim();

      if (!nama) return alert('Nama produk wajib diisi.');

      if (editingProdukId) {
        const p = produkList.find(x => x.id === editingProdukId);
        if (p) { Object.assign(p, { nama, kategori: kat, harga, deskripsi: desk }); if (selectedProdukImage) p.image = selectedProdukImage; }
      } else {
        produkList.push({ id: 'P' + String(produkIdCounter++).padStart(3, '0'), nama, kategori: kat, harga, deskripsi: desk, image: selectedProdukImage, stok: { S: 0, M: 0, L: 0, XL: 0 } });
      }
      closeModal('modal-tambah-produk');
      renderProdukTable();
    }

    function confirmHapusProduk() { produkList = produkList.filter(x => x.id !== deletingProdukId); closeModal('modal-hapus-produk'); renderProdukTable(); }

    function handleFileChange(input) {
      const file = input.files[0];
      document.getElementById('upload-hint').textContent = file?.name || 'Belum ada file dipilih';
      if (!file) return selectedProdukImage = '';
      const reader = new FileReader();
      reader.onload = () => selectedProdukImage = String(reader.result || '');
      reader.readAsDataURL(file);
    }

    // KATEGORI
    function renderKategoriTable() {
      if (!document.getElementById('kategori-tbody')) return;
      const searchQuery = document.getElementById('kat-search')?.value.toLowerCase() || '';
      let list = kategoriList;
      if (searchQuery) list = list.filter(k => k.nama.toLowerCase().includes(searchQuery));

      document.getElementById('kategori-tbody').innerHTML = list.map(k => `
        <tr>
          <td class="id-cell">${k.id}</td>
          <td><strong>${k.nama}</strong></td>
          <td class="action-cell">
            <div class="action-buttons">
              <button class="icon-btn icon-btn-edit" onclick="openEditKat('${k.id}')">${editIcon}</button>
              <button class="icon-btn icon-btn-delete" onclick="openHapusKat('${k.id}')">${deleteIcon}</button>
            </div>
          </td>
        </tr>`).join('');
    }

    function setKatModalMode(mode) { editingKatId = null; document.getElementById('kat-modal-title').textContent = 'Tambah Kategori'; document.getElementById('kat-nama').value = ''; }
    function openEditKat(id) {
      const k = kategoriList.find(x => x.id === id);
      if (!k) return;
      editingKatId = id;
      document.getElementById('kat-modal-title').textContent = 'Edit Kategori';
      document.getElementById('kat-nama').value = k.nama;
      openModal('modal-tambah-kat');
    }
    function openHapusKat(id) { deletingKatId = id; openModal('modal-hapus-kat'); }
    function saveKategori() {
      const nama = document.getElementById('kat-nama').value.trim();
      if (!nama) return alert('Nama kategori wajib diisi.');
      if (editingKatId) { const k = kategoriList.find(x => x.id === editingKatId); if (k) k.nama = nama; }
      else { kategoriList.push({ id: 'K' + String(katIdCounter++).padStart(3, '0'), nama }); }
      closeModal('modal-tambah-kat');
      renderKategoriTable();
    }
    function confirmHapusKat() { kategoriList = kategoriList.filter(x => x.id !== deletingKatId); closeModal('modal-hapus-kat'); renderKategoriTable(); }

    // STOK
    function renderStokTable() {
      if (!document.getElementById('stok-tbody')) return;
      const searchQuery = document.getElementById('stok-search')?.value.toLowerCase() || '';
      let list = produkList;
      if (searchQuery) list = list.filter(p => p.nama.toLowerCase().includes(searchQuery));

      document.getElementById('stok-tbody').innerHTML = list.map(p => `
        <tr>
          <td><strong>${p.nama}</strong></td>
          <td style="text-align:center;">${p.stok.S}</td>
          <td style="text-align:center;">${p.stok.M}</td>
          <td style="text-align:center;">${p.stok.L}</td>
          <td style="text-align:center;">${p.stok.XL}</td>
          <td class="action-cell"><button class="icon-btn icon-btn-edit" onclick="openEditStok('${p.id}')">${editIcon}</button></td>
        </tr>`).join('');
    }

    function openEditStok(id) {
      const p = produkList.find(x => x.id === id);
      if (!p) return;
      editingStokId = id;
      document.getElementById('stok-modal-produk-name').textContent = 'Produk: ' + p.nama;
      ['s', 'm', 'l', 'xl'].forEach(sz => document.getElementById('stok-'+sz).value = p.stok[sz.toUpperCase()]);
      openModal('modal-stok');
    }

    function saveStok() {
      const p = produkList.find(x => x.id === editingStokId);
      if (!p) return;
      ['s', 'm', 'l', 'xl'].forEach(sz => p.stok[sz.toUpperCase()] = parseInt(document.getElementById('stok-'+sz).value) || 0);
      closeModal('modal-stok');
      renderStokTable();
    }

    // PESANAN
    function renderPesananTable() {
      if (!document.getElementById('pesanan-tbody')) return;
      const filterStatus = document.getElementById('pesanan-filter-status')?.value || '';
      const searchQuery = document.getElementById('pesanan-search')?.value.toLowerCase() || '';
      const dateFrom = document.getElementById('pesanan-date-from')?.value || '';
      const dateTo = document.getElementById('pesanan-date-to')?.value || '';

      const list = pesananList.filter(o => {
        const matchStatus = !filterStatus || o.status === filterStatus;
        const matchSearch = !searchQuery || o.nama.toLowerCase().includes(searchQuery) || o.id.toLowerCase().includes(searchQuery);
        let matchDate = true;
        if (dateFrom || dateTo) {
          const parts = o.tanggal.split('-'); const tglISO = parts[2] + '-' + parts[1] + '-' + parts[0];
          if (dateFrom && tglISO < dateFrom) matchDate = false;
          if (dateTo && tglISO > dateTo) matchDate = false;
        }
        return matchStatus && matchSearch && matchDate;
      });

      document.getElementById('pesanan-tbody').innerHTML = list.length ? list.map(o => `
        <tr class="border-t border-[#e2d4c5]">
          <td class="px-6 py-4 text-center font-semibold">${o.id}</td>
          <td class="px-6 py-4">${o.tanggal}</td>
          <td class="px-6 py-4 font-semibold">${o.nama}</td>
          <td class="px-6 py-4">${statusBadge(o.status)}</td>
          <td class="px-6 py-4 font-semibold">${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
          <td class="px-6 py-4 text-center"><button onclick="openDetailPesanan('${o.id}')" class="inline-flex items-center justify-center rounded-xl border border-[#d8c3af] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]">Detail</button></td>
        </tr>`).join('') : `<tr><td colspan="6" class="px-6 py-6 text-center text-[#b7a08c]">Tidak ada pesanan ditemukan.</td></tr>`;
    }

    function openDetailPesanan(id) {
      const o = pesananList.find(x => x.id === id); if (!o) return; viewingPesananId = id;
      const total = o.items.reduce((s, i) => s + i.harga * i.qty, 0);
      document.getElementById('pesanan-modal-title').textContent = `Detail Pesanan - ${o.id}`;
      document.getElementById('pesanan-modal-body').innerHTML = `
        <div class="detail-grid">
          <div class="detail-field"><div class="detail-field-label">Nama Pembeli</div><div class="detail-field-value">${o.nama}</div></div>
          <div class="detail-field"><div class="detail-field-label">No HP</div><div class="detail-field-value">${o.hp}</div></div>
          <div class="detail-field"><div class="detail-field-label">Tanggal Pesanan</div><div class="detail-field-value">${o.tanggal}</div></div>
          <div class="detail-field"><div class="detail-field-label">Alamat</div><div class="detail-field-value">${o.alamat}</div></div>
          <div class="detail-field"><div class="detail-field-label">Status Pembayaran</div><div class="detail-field-value">${o.status}</div></div>
        </div>
        <div class="status-edit-wrap">
          <label class="field-label" for="status-select">Update Status</label>
          <select class="status-edit-sel" id="status-select">
            ${['Menunggu Verifikasi', 'Pembayaran Valid', 'Pembayaran Ditolak', 'Konfirmasi Ulang'].map(st => `<option ${o.status===st?'selected':''}>${st}</option>`).join('')}
          </select>
        </div>`;
      openModal('modal-pesanan');
    }

    function saveEditStatus() { const o = pesananList.find(x => x.id === viewingPesananId); if (o) o.status = document.getElementById('status-select').value; closeModal('modal-pesanan'); renderPesananTable(); }

    document.addEventListener('DOMContentLoaded', () => { renderDashboard(); renderProdukTable(); renderKategoriTable(); renderStokTable(); renderPesananTable(); });
  </script>
</body>

</html>
