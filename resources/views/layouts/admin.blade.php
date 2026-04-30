<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Admin Dashboard')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/css/admin-dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-[#5c4432] antialiased">

  <div class="shell">
    <!-- sidebar -->
    <x-admin.sidebar />

    <!-- MAIN WRAP -->
    <div class="main-wrap">
      <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
      <!-- topbar -->
      <x-admin.topbar :title="$__env->yieldContent('page_title', 'Dashboard')" />

      <div class="main-content">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- modals -->
  <x-admin.modals />
  <!-- admin toast -->
  <x-admin.toast />

  <div id="admin-json-data" data-produk="{{ json_encode($produk ?? []) }}"
    data-kategori="{{ json_encode($kategori ?? []) }}" data-pesanan="{{ json_encode($pesanan ?? []) }}" hidden></div>

  <script>
    // ADMIN TOAST
    let adminToastTimer = null;
    function showAdminToast(title, message, type = 'success') {
      const toast = document.getElementById('admin-toast');
      const icon = document.getElementById('admin-toast-icon');
      const iconSuccess = document.getElementById('admin-toast-icon-success');
      const iconError = document.getElementById('admin-toast-icon-error');
      const titleEl = document.getElementById('admin-toast-title');
      const messageEl = document.getElementById('admin-toast-message');

      titleEl.innerText = title;
      messageEl.innerText = message;

      if (type === 'error') {
        icon.className = 'flex h-10 w-10 items-center justify-center rounded-full bg-[#fde8e8]';
        iconSuccess.classList.add('hidden');
        iconError.classList.remove('hidden');
      } else {
        icon.className = 'flex h-10 w-10 items-center justify-center rounded-full bg-[#d9f8df]';
        iconSuccess.classList.remove('hidden');
        iconError.classList.add('hidden');
      }

      toast.classList.remove('opacity-0', 'translate-y-3');
      toast.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');

      if (adminToastTimer) clearTimeout(adminToastTimer);
      adminToastTimer = setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-3');
        toast.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
      }, 2500);
    }
    const adminJsonData = document.getElementById('admin-json-data');
    let produkList = JSON.parse(adminJsonData?.dataset.produk || '[]');
    let kategoriList = JSON.parse(adminJsonData?.dataset.kategori || '[]');
    let pesananList = JSON.parse(adminJsonData?.dataset.pesanan || '[]');

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
        'Pembayaran Valid': 'bg-[#dcfce7] text-[#15803d]',
        'Pembayaran Ditolak': 'bg-[#fee2e2] text-[#dc2626]',
        'Konfirmasi Ulang': 'bg-[#e0e7ff] text-[#4338ca]',
        'Menunggu Verifikasi': 'bg-[#fff1bd] text-[#b45a00]'
      };
      return `<span class="inline-flex items-center rounded-full ${colors[s] || colors['Menunggu Verifikasi']} px-3 py-1 text-sm font-medium">${s}</span>`;
    }

    function openAdminModal(id) { document.getElementById(id).classList.add('open'); }
    function closeAdminModal(id) { document.getElementById(id).classList.remove('open'); }

    window.openModal = openAdminModal;
    window.closeModal = closeAdminModal;

    function confirmLogout(event) { event.preventDefault(); openAdminModal('modal-logout'); }
    function proceedLogout() { window.location.href = "{{ route('home') }}"; }

    function toggleMobileSidebar() {
      const sidebar = document.getElementById('admin-sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      sidebar.classList.toggle('mobile-open');
      overlay.classList.toggle('show');
    }

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
          <td>
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-full border border-[#e2d4c5] bg-[#fbf8f5] flex items-center justify-center overflow-hidden shrink-0">
                <img src="${o.avatar ? o.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.nama)}&background=f3e6db&color=5c4432&bold=true&size=64`}" alt="${o.nama}" class="h-full w-full object-cover">
              </div>
              <span class="font-medium text-[#5c4432]">${o.nama}</span>
            </div>
          </td>
          <td>${o.items.map(i => i.produk).join(', ')}</td>
          <td>${statusBadge(o.status)}</td>
          <td>${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
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
          <td class="action-cell">${renderThumb(p.nama, 'foto-cell', p.image || '')}</td>
          <td>${p.nama}</td>
          <td>${p.kategori}</td>
          <td>${rp(p.harga)}</td>
          <td class="action-cell">
            <div class="action-buttons">
              <button class="icon-btn icon-btn-edit" data-tooltip="Edit" type="button" onclick="openEditProduk('${p.id}')">${editIcon}</button>
              <button class="icon-btn icon-btn-delete" data-tooltip="Hapus" type="button" onclick="openHapusProduk('${p.id}')">${deleteIcon}</button>
            </div>
          </td>
        </tr>`).join('');
    }

    function toggleProdukKategoriFilter(e) {
      e.stopPropagation();
      const menu = document.getElementById('produk-filter-kat-menu');
      const icon = document.getElementById('produk-filter-kat-icon');
      menu?.classList.toggle('hidden');
      icon?.classList.toggle('rotate-180');
    }

    function selectProdukKategoriFilter(val) {
      const input = document.getElementById('produk-filter-kat');
      const label = document.getElementById('produk-filter-kat-label');
      if (input) input.value = val;
      if (label) label.innerText = val || 'Semua Kategori';

      const options = document.querySelectorAll('.produk-kategori-option');
      options.forEach(opt => {
        if (opt.innerText.trim() === (val || 'Semua Kategori')) {
          opt.classList.add('bg-[#fbf8f5]', 'text-[#BFA28C]');
          opt.classList.remove('text-[#5c4432]');
        } else {
          opt.classList.remove('bg-[#fbf8f5]', 'text-[#BFA28C]');
          opt.classList.add('text-[#5c4432]');
        }
      });

      document.getElementById('produk-filter-kat-menu')?.classList.add('hidden');
      document.getElementById('produk-filter-kat-icon')?.classList.remove('rotate-180');
      renderProdukTable();
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
      openAdminModal('modal-tambah-produk');
    }

    function openHapusProduk(id) { deletingProdukId = id; openAdminModal('modal-hapus-produk'); }

    function saveProduk() {
      const nama = document.getElementById('prod-nama').value.trim();
      const kat = document.getElementById('prod-kat').value;
      const harga = parseInt(document.getElementById('prod-harga').value.replace(/\D/g, '')) || 0;
      const desk = document.getElementById('prod-desk').value.trim();

      if (!nama) return alert('Nama produk wajib diisi.');
      if (!harga || harga <= 0) return alert('Harga produk wajib diisi dengan benar.');
      if (!desk) return alert('Keterangan/Deskripsi produk wajib diisi.');

      if (editingProdukId) {
        const p = produkList.find(x => x.id === editingProdukId);
        if (p) { Object.assign(p, { nama, kategori: kat, harga, deskripsi: desk }); if (selectedProdukImage) p.image = selectedProdukImage; }
      } else {
        produkList.push({ id: 'P' + String(produkIdCounter++).padStart(3, '0'), nama, kategori: kat, harga, deskripsi: desk, image: selectedProdukImage, stok: { S: 0, M: 0, L: 0, XL: 0 } });
      }
      closeAdminModal('modal-tambah-produk');
      renderProdukTable();
      showAdminToast('Berhasil', editingProdukId ? 'Produk berhasil diperbarui.' : 'Produk baru berhasil ditambahkan.');
    }

    function confirmHapusProduk() {
      produkList = produkList.filter(x => x.id !== deletingProdukId);
      closeAdminModal('modal-hapus-produk');
      renderProdukTable();
      showAdminToast('Berhasil Dihapus', 'Produk telah dihapus dari daftar.', 'error');
    }

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
          <td>${k.nama}</td>
          <td class="action-cell">
            <div class="action-buttons">
              <button class="icon-btn icon-btn-edit" data-tooltip="Edit" onclick="openEditKat('${k.id}')">${editIcon}</button>
              <button class="icon-btn icon-btn-delete" data-tooltip="Hapus" onclick="openHapusKat('${k.id}')">${deleteIcon}</button>
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
      openAdminModal('modal-tambah-kat');
    }
    function openHapusKat(id) { deletingKatId = id; openAdminModal('modal-hapus-kat'); }
    function saveKategori() {
      const nama = document.getElementById('kat-nama').value.trim();
      if (!nama) return alert('Nama kategori wajib diisi.');
      if (editingKatId) {
        const k = kategoriList.find(x => x.id === editingKatId);
        if (k) k.nama = nama;
      } else {
        kategoriList.push({ id: 'K' + String(katIdCounter++).padStart(3, '0'), nama });
      }
      closeAdminModal('modal-tambah-kat');
      renderKategoriTable();
      showAdminToast('Berhasil', editingKatId ? 'Kategori berhasil diperbarui.' : 'Kategori baru berhasil ditambahkan.');
    }
    function confirmHapusKat() {
      kategoriList = kategoriList.filter(x => x.id !== deletingKatId);
      closeAdminModal('modal-hapus-kat');
      renderKategoriTable();
      showAdminToast('Berhasil Dihapus', 'Kategori telah dihapus.', 'error');
    }

    // STOK
    function renderStokTable() {
      if (!document.getElementById('stok-tbody')) return;
      const searchQuery = document.getElementById('stok-search')?.value.toLowerCase() || '';
      let list = produkList;
      if (searchQuery) list = list.filter(p => p.nama.toLowerCase().includes(searchQuery));

      document.getElementById('stok-tbody').innerHTML = list.map(p => `
        <tr>
          <td>${p.nama}</td>
          <td style="text-align:center;">${p.stok.S}</td>
          <td style="text-align:center;">${p.stok.M}</td>
          <td style="text-align:center;">${p.stok.L}</td>
          <td style="text-align:center;">${p.stok.XL}</td>
          <td class="action-cell"><button class="icon-btn icon-btn-edit" data-tooltip="Edit Stok" onclick="openEditStok('${p.id}')">${editIcon}</button></td>
        </tr>`).join('');
    }

    function openEditStok(id) {
      const p = produkList.find(x => x.id === id);
      if (!p) return;
      editingStokId = id;
      document.getElementById('stok-modal-produk-name').textContent = 'Produk: ' + p.nama;
      ['s', 'm', 'l', 'xl'].forEach(sz => document.getElementById('stok-' + sz).value = p.stok[sz.toUpperCase()]);
      openAdminModal('modal-stok');
    }

    function saveStok() {
      const p = produkList.find(x => x.id === editingStokId);
      if (!p) return;
      ['s', 'm', 'l', 'xl'].forEach(sz => p.stok[sz.toUpperCase()] = parseInt(document.getElementById('stok-' + sz).value) || 0);
      closeAdminModal('modal-stok');
      renderStokTable();
      showAdminToast('Berhasil', 'Stok produk berhasil diperbarui.');
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
        <tr>
          <td class="px-6 py-4 text-center">${o.id}</td>
          <td class="px-6 py-4">${o.tanggal}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-full border border-[#e2d4c5] bg-[#fbf8f5] flex items-center justify-center overflow-hidden shrink-0">
                <img src="${o.avatar ? o.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.nama)}&background=f3e6db&color=5c4432&bold=true&size=64`}" alt="${o.nama}" class="h-full w-full object-cover">
              </div>
              <span class="font-medium text-[#5c4432]">${o.nama}</span>
            </div>
          </td>
          <td class="px-6 py-4">${statusBadge(o.status)}</td>
          <td class="px-6 py-4">${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
          <td class="px-6 py-4 text-center"><button onclick="openDetailPesanan('${o.id}')" class="inline-flex items-center justify-center rounded-xl border border-[#d8c3af] bg-[#a78d78] px-4 py-2 text-sm font-normal text-white transition hover:bg-[#8f7561]">Detail</button></td>
        </tr>`).join('') : `<tr><td colspan="6" class="px-6 py-6 text-center text-[#b7a08c]">Tidak ada pesanan ditemukan.</td></tr>`;
    }

    function openDetailPesanan(id) {
      const o = pesananList.find(x => x.id === id);
      if (!o) return;

      viewingPesananId = id;
      const total = o.items.reduce((s, i) => s + i.harga * i.qty, 0);
      const statusOptions = ['Menunggu Verifikasi', 'Pembayaran Valid', 'Pembayaran Ditolak', 'Konfirmasi Ulang'];

      document.getElementById('pesanan-modal-content').innerHTML = `
        <div class="modal-header">
          <h2 class="modal-title">Detail Pesanan - ${o.id}</h2>
        </div>

        <div class="modal-body">
          <div class="detail-grid">
            <div class="detail-field">
              <div class="detail-field-label">Nama Pembeli</div>
              <div class="detail-field-value flex items-center gap-2 mt-1">
                <div class="h-6 w-6 rounded-full border border-[#e2d4c5] bg-[#fbf8f5] flex items-center justify-center overflow-hidden shrink-0">
                  <img src="${o.avatar ? o.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.nama)}&background=f3e6db&color=5c4432&bold=true&size=64`}" alt="${o.nama}" class="h-full w-full object-cover">
                </div>
                ${o.nama}
              </div>
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
            <div class="detail-field detail-field-full">
              <div class="detail-field-label">Status Pembayaran</div>
              <div class="detail-field-value">${o.status}</div>
            </div>
          </div>

          <div class="detail-section-title">Bukti Pembayaran</div>
          <div class="payment-proof-card">
            <img src="https://i.pinimg.com/1200x/82/65/1b/82651bb05dfea5ea161f389688fb4ec2.jpg" class="proof-thumb cursor-pointer hover:opacity-80 transition" 
            onclick="viewBukti('https://i.pinimg.com/1200x/82/65/1b/82651bb05dfea5ea161f389688fb4ec2.jpg')">
            <button type="button" class="btn-lihat-bukti" onclick="viewBukti('https://i.pinimg.com/1200x/82/65/1b/82651bb05dfea5ea161f389688fb4ec2.jpg')">Lihat Bukti</button>
          </div>

          <div class="detail-section-title">Item Pesanan</div>
          <div class="space-y-3">
            ${o.items.map(item => {
        const p = produkList.find(x => x.nama === item.produk);
        return `
                <div class="flex items-center gap-4 rounded-xl bg-[#fbf8f5] p-3 border border-[#f0e7dd]">
                  <div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-[#f0e7dd] bg-white">
                    <img src="${getProdukImage(item.produk, p?.image)}" class="h-full w-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="font-medium text-[#5c4432] text-sm truncate">${item.produk}</div>
                    <div class="text-[12px] text-[#9a8575] mt-0.5">Ukuran: ${item.ukuran}</div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm font-medium text-[#5c4432]">${rp(item.harga)}</div>
                    <div class="text-[12px] text-[#9a8575] mt-0.5">x${item.qty}</div>
                  </div>
                </div>`;
      }).join('')}
          </div>

          <div class="mt-4 flex items-center justify-between rounded-xl bg-[#fbf8f5] px-4 py-3 border border-[#f0e7dd]">
            <div class="text-sm font-medium text-[#5c4432]">Total Pembayaran</div>
            <div class="text-lg font-semibold text-[#5c4432]">${rp(total)}</div>
          </div>

          <div class="update-status-section">
            <div class="update-status-label">Update Status</div>
            <div class="relative flex-1">
              <button type="button" onclick="toggleStatusDropdown(event)" id="status-dropdown-btn" class="flex w-full items-center justify-between gap-2 rounded-2xl border border-[#d8c3af] bg-white px-4 py-2.5 text-[14px] font-medium text-[#5c4432] outline-none transition-all duration-200 hover:border-[#BFA28C]">
                <span id="current-status-label">${o.status}</span>
                <svg id="status-dropdown-icon" width="10" height="6" viewBox="0 0 14 8" fill="none" class="transition-transform duration-200">
                    <path d="M2 2l5 4 5-4" stroke="#5c4432" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
               <ul id="status-dropdown-menu" class="absolute left-0 top-[calc(100%+6px)] z-[100] hidden w-full overflow-hidden border border-[#d8c3af] bg-white shadow-xl">
                ${statusOptions.map(st => `
                  <li onclick="selectStatus('${st}')" class="status-option-item cursor-pointer px-4 py-2 text-[14px] font-medium transition-colors border-b border-[#f0e7dd] last:border-0 ${st === o.status ? 'bg-[#fbf8f5] text-[#BFA28C]' : 'text-[#5c4432]'} hover:bg-[#BFA28C] hover:text-white">
                    ${st}
                  </li>
                `).join('')}
              </ul>
              <input type="hidden" id="status-select" value="${o.status}">
            </div>
          </div>
        </div>

        <div class="modal-action-footer">
          <button type="button" onclick="closeAdminModal('modal-pesanan')" class="btn-modal-cancel">Batal</button>
          <button type="button" onclick="saveEditStatus()" class="btn-modal-save">Simpan</button>
        </div>
      `;

      openAdminModal('modal-pesanan');
    }

    function toggleStatusDropdown(e) {
      e.stopPropagation();
      const menu = document.getElementById('status-dropdown-menu');
      const icon = document.getElementById('status-dropdown-icon');
      menu.classList.toggle('hidden');
      icon.classList.toggle('rotate-180');
    }

    function selectStatus(val) {
      document.getElementById('status-select').value = val;
      document.getElementById('current-status-label').innerText = val;

      const items = document.querySelectorAll('.status-option-item');
      items.forEach(item => {
        if (item.innerText.trim() === val) {
          item.classList.add('bg-[#fbf8f5]', 'text-[#BFA28C]');
          item.classList.remove('text-[#5c4432]');
        } else {
          item.classList.remove('bg-[#fbf8f5]', 'text-[#BFA28C]');
          item.classList.add('text-[#5c4432]');
        }
      });

      document.getElementById('status-dropdown-menu').classList.add('hidden');
      document.getElementById('status-dropdown-icon').classList.remove('rotate-180');
    }

    function viewBukti(url) {
      document.getElementById('bukti-image-full').src = url;
      openAdminModal('modal-bukti');
    }

    // PESANAN FILTER
    function togglePesananStatusFilter(e) {
      e.stopPropagation();
      const menu = document.getElementById('pesanan-status-filter-menu');
      const icon = document.getElementById('pesanan-status-filter-icon');
      if (menu) menu.classList.toggle('hidden');
      if (icon) icon.classList.toggle('rotate-180');
    }

    function selectPesananStatusFilter(val) {
      const input = document.getElementById('pesanan-filter-status');
      const label = document.getElementById('pesanan-status-filter-label');
      if (input) input.value = val;
      if (label) label.innerText = val || 'Semua Status';

      const options = document.querySelectorAll('.pesanan-status-option');
      options.forEach(opt => {
        if (opt.innerText.trim() === (val || 'Semua Status')) {
          opt.classList.add('bg-[#fbf8f5]', 'text-[#BFA28C]');
          opt.classList.remove('text-[#5c4432]');
        } else {
          opt.classList.remove('bg-[#fbf8f5]', 'text-[#BFA28C]');
          opt.classList.add('text-[#5c4432]');
        }
      });

      const menu = document.getElementById('pesanan-status-filter-menu');
      const icon = document.getElementById('pesanan-status-filter-icon');
      if (menu) menu.classList.add('hidden');
      if (icon) icon.classList.remove('rotate-180');

      renderPesananTable();
    }

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
      const btn = document.getElementById('status-dropdown-btn');
      const menu = document.getElementById('status-dropdown-menu');
      const icon = document.getElementById('status-dropdown-icon');
      if (btn && !btn.contains(e.target)) {
        menu?.classList.add('hidden');
        icon?.classList.remove('rotate-180');
      }

      const produkBtn = document.getElementById('produk-filter-kat-btn');
      const produkMenu = document.getElementById('produk-filter-kat-menu');
      const produkIcon = document.getElementById('produk-filter-kat-icon');
      if (produkBtn && !produkBtn.contains(e.target) && !produkMenu?.contains(e.target)) {
        produkMenu?.classList.add('hidden');
        produkIcon?.classList.remove('rotate-180');
      }
    });

    function saveEditStatus() {
      const o = pesananList.find(x => x.id === viewingPesananId);
      if (o) o.status = document.getElementById('status-select').value;
      closeAdminModal('modal-pesanan');
      renderPesananTable();
      renderDashboard();
      showAdminToast('Status Diperbarui', 'Status pesanan berhasil disimpan.');
    }

    document.addEventListener('DOMContentLoaded', () => { renderDashboard(); renderProdukTable(); renderKategoriTable(); renderStokTable(); renderPesananTable(); });
  </script>
</body>

</html>
