<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    function rp(n) {
      return 'Rp' + Number(n).toLocaleString('id-ID');
    }

    // Format untuk angka besar (Juta/Ribu) agar muat di kotak dashboard
    function rpShort(n) {
      if (n >= 1000000000) return 'Rp' + (n / 1000000000).toFixed(1).replace(/\.0$/, '').replace('.', ',') + ' M';
      if (n >= 1000000) return 'Rp' + (n / 1000000).toFixed(1).replace(/\.0$/, '').replace('.', ',') + ' Jt';
      return 'Rp' + Number(n).toLocaleString('id-ID');
    }

    const produkImages = {
      'Kemeja Stripe': 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
      'Kemeja Hitam': 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg',
      'Gaun Ivory': 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg',
      'Gaun Floral Pastel': 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg',
      'Cardigan Floral': 'https://i.pinimg.com/1200x/9f/d0/5b/9fd05ba93f69906a9875be57f76906ed.jpg',
      'Cardigan Rajut': 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
      'Rok Denim': 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg',
      'Rok Plisket': 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg',
    };

    const editIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 17.25V21h3.75L17.8 9.94l-3.75-3.75L3 17.25z"></path><path d="M14.06 4.94l3.75 3.75"></path></svg>`;
    const deleteIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></svg>`;

    function getProdukImage(name = '', explicitImage = '') {
      if (explicitImage) {
        if (explicitImage.startsWith('http')) return explicitImage;
        return '/images/' + explicitImage;
      }
      return produkImages[name] || '';
    }

    function renderThumb(name = '', className = 'foto-cell', imageUrl = '') {
      const image = getProdukImage(name, imageUrl);
      if (image) return `<div class="${className}" title="Foto ${name}"><img src="${image}" alt="${name}" class="thumb-image"></div>`;
      return `<div class="${className}" title="Foto ${name}">${name.split(' ').map(part => part[0]).slice(0, 2).join('').toUpperCase() || '--'}</div>`;
    }

    function statusBadge(s) {
      const colors = {
        'Pembayaran Berhasil': 'bg-[#dcfce7] text-[#15803d]',
        'Pembayaran Dibatalkan': 'bg-[#fee2e2] text-[#dc2626]',
        'Pembayaran Kedaluwarsa': 'bg-[#f3f4f6] text-[#6b7280]',
        'Menunggu Pembayaran': 'bg-[#fff1bd] text-[#b45a00]',
      };
      return `<span class="inline-flex items-center whitespace-nowrap rounded-full ${colors[s] || 'bg-[#fff1bd] text-[#b45a00]'} px-3 py-1 text-sm font-medium">${s}</span>`;
    }

    function openAdminModal(id) {
      document.getElementById(id).classList.add('open');
    }

    function closeAdminModal(id) {
      document.getElementById(id).classList.remove('open');
    }

    window.openModal = openAdminModal;
    window.closeModal = closeAdminModal;

    function confirmLogout(event) {
      event.preventDefault();
      openAdminModal('modal-logout');
    }

    function proceedLogout() {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = "{{ route('logout') }}";

      const csrf = document.createElement('input');
      csrf.type = 'hidden';
      csrf.name = '_token';
      csrf.value = "{{ csrf_token() }}";

      form.appendChild(csrf);
      document.body.appendChild(form);
      form.submit();
    }

    function toggleMobileSidebar() {
      const sidebar = document.getElementById('admin-sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      sidebar.classList.toggle('mobile-open');
      overlay.classList.toggle('show');
    }

    // INCOME FILTER DROPDOWN
    function toggleIncomeFilter(e) {
      e.stopPropagation();
      const menu = document.getElementById('income-filter-menu');
      const icon = document.getElementById('income-filter-icon');
      menu?.classList.toggle('hidden');
      icon?.classList.toggle('rotate-180');
    }

    function selectIncomeFilter(val, label) {
      const input = document.getElementById('income-filter');
      const labelEl = document.getElementById('income-filter-label');
      if (input) input.value = val;
      if (labelEl) labelEl.innerText = label;

      const items = document.querySelectorAll('#income-filter-menu li');
      items.forEach(item => {
        if (item.innerText.trim() === label) {
          item.classList.add('bg-[#fbf8f5]', 'text-[#BFA28C]');
          item.classList.remove('text-[#5c4432]');
        } else {
          item.classList.remove('bg-[#fbf8f5]', 'text-[#BFA28C]');
          item.classList.add('text-[#5c4432]');
        }
      });

      document.getElementById('income-filter-menu')?.classList.add('hidden');
      document.getElementById('income-filter-icon')?.classList.remove('rotate-180');
      renderDashboard();
    }

    document.addEventListener('click', function(e) {
      const menu = document.getElementById('income-filter-menu');
      const btn = document.getElementById('income-filter-btn');
      if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
        document.getElementById('income-filter-icon')?.classList.remove('rotate-180');
      }
    });

    // DASHBOARD
    function renderDashboard() {
      if (!document.getElementById('s-pesanan')) return;
      document.getElementById('s-pesanan').textContent = pesananList.length;
      document.getElementById('s-produk').textContent = produkList.length;
      document.getElementById('s-kategori').textContent = kategoriList.length;

      // Hitung Pendapatan Berdasarkan Filter
      const filterEl = document.getElementById('income-filter');
      const filterVal = filterEl ? filterEl.value : 'this_month';

      const today = new Date();
      const currentMonth = today.getMonth() + 1;
      const currentYear = today.getFullYear();

      let lastMonth = currentMonth - 1;
      let lastMonthYear = currentYear;
      if (lastMonth === 0) {
        lastMonth = 12;
        lastMonthYear = currentYear - 1;
      }

      let calculatedIncome = 0;
      let subtitleText = 'Bulan Ini';

      pesananList.forEach(p => {
        if (p.status !== 'Pembayaran Berhasil') return;

        const income = parseInt(p.total) || 0;
        const parts = p.tanggal.split('-'); // Format: DD-MM-YYYY

        if (parts.length === 3) {
          const m = parseInt(parts[1], 10);
          const y = parseInt(parts[2], 10);

          if (filterVal === 'this_month') {
            if (m === currentMonth && y === currentYear) calculatedIncome += income;
            subtitleText = 'Bulan Ini';
          } else if (filterVal === 'last_month') {
            if (m === lastMonth && y === lastMonthYear) calculatedIncome += income;
            subtitleText = 'Bulan Lalu';
          } else {
            calculatedIncome += income;
            subtitleText = 'Semua Waktu';
          }
        }
      });

      if (document.getElementById('s-income')) {
        document.getElementById('s-income').textContent = rpShort(calculatedIncome);
      }
      if (document.getElementById('s-income-sub')) {
        document.getElementById('s-income-sub').textContent = subtitleText;
      }

      const recent = pesananList.slice(0, 5);
      document.getElementById('dash-orders-tbody').innerHTML = recent.map(o => `
        <tr>
          <td class="id-cell">${o.id}</td>
          <td>${o.tanggal}</td>
          <td>
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-full border border-[#e2d4c5] bg-[#fbf8f5] flex items-center justify-center overflow-hidden shrink-0">
                <img src="${o.avatar ? o.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.nama)}&background=f3e6db&color=5c4432&bold=true&size=64`}" alt="${o.nama}" class="h-full w-full object-cover">
              </div>
              <span class="font-medium text-[#5c4432]">${o.nama}</span>
            </div>
          </td>
          <td>${statusBadge(o.status)}</td>
          <td>${rp(o.total ?? o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
        </tr>`).join('');

      renderSalesChart();
    }

    let salesChartInstance = null;

    function renderSalesChart() {
      const ctx = document.getElementById('salesChart');
      if (!ctx) return;

      const dataPerBulan = {
        'Jan': 0,
        'Feb': 0,
        'Mar': 0,
        'Apr': 0,
        'Mei': 0,
        'Jun': 0,
        'Jul': 0,
        'Agt': 0,
        'Sep': 0,
        'Okt': 0,
        'Nov': 0,
        'Des': 0
      };

      const namaBulan = Object.keys(dataPerBulan);

      pesananList.forEach(p => {
        if (p.status !== 'Pembayaran Berhasil') return;

        const parts = p.tanggal.split('-');
        if (parts.length === 3) {
          const indexBulan = parseInt(parts[1], 10) - 1;
          if (indexBulan >= 0 && indexBulan < 12) {
            dataPerBulan[namaBulan[indexBulan]] += 1; // 1 pesanan dihitung 1
          }
        }
      });

      if (salesChartInstance) salesChartInstance.destroy();

      salesChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: Object.keys(dataPerBulan),
          datasets: [{
            label: 'Pesanan Terjual',
            data: Object.values(dataPerBulan),
            backgroundColor: '#5c4432', // Warna coklat tema seperti semula
            borderRadius: 4,
            barThickness: 24
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              suggestedMax: 100, // Paksa chart memiliki batas atas minimal 100 agar step 20 terlihat
              grid: {
                color: '#f0e7dd'
              },
              ticks: {
                color: '#9a8575',
                font: {
                  family: 'Plus Jakarta Sans',
                  weight: 'bold'
                },
                stepSize: 20 // Sumbu Y akan menampilkan kelipatan 20, 40, 60 dst
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                color: '#9a8575',
                font: {
                  family: 'Plus Jakarta Sans',
                  weight: 'bold'
                }
              }
            }
          }
        }
      });
    }

    // PRODUK
    let produkCurrentPage = 1;
    const produkPerPage = 8;

    function searchProduk() {
      produkCurrentPage = 1;
      renderProdukTable();
    }

    function renderProdukTable() {
      if (!document.getElementById('produk-tbody')) return;
      const filterKat = document.getElementById('produk-filter-kat')?.value || '';
      const searchQuery = document.getElementById('produk-search')?.value.toLowerCase() || '';

      let list = produkList;
      if (filterKat) list = list.filter(p => p.kategori === filterKat);
      if (searchQuery) list = list.filter(p => p.nama.toLowerCase().includes(searchQuery));

      const totalItems = list.length;
      const totalPages = Math.ceil(totalItems / produkPerPage) || 1;
      if (produkCurrentPage > totalPages) produkCurrentPage = totalPages;
      if (produkCurrentPage < 1) produkCurrentPage = 1;

      const startIdx = (produkCurrentPage - 1) * produkPerPage;
      const paginatedList = list.slice(startIdx, startIdx + produkPerPage);

      document.getElementById('produk-tbody').innerHTML = paginatedList.map((p, index) => {
        const seqNum = startIdx + index + 1;
        return `
        <tr>
          <td class="id-cell">${seqNum}</td>
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
        </tr>`;
      }).join('');

      const infoEl = document.getElementById('produk-pagi-info');
      if (infoEl) {
        const endIdx = Math.min(startIdx + produkPerPage, totalItems);
        infoEl.textContent = totalItems === 0 ? '0 dari 0' : `${startIdx + 1} - ${endIdx} dari ${totalItems}`;
      }

      const pagiContainer = document.querySelector('#page-produk .pagi-btns');
      if (pagiContainer) {
        let btnsHtml = `<button class="pagi-btn" ${produkCurrentPage === 1 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="produkCurrentPage--; renderProdukTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>`;

        btnsHtml += `<button class="pagi-btn active">${produkCurrentPage}</button>`;

        btnsHtml += `<button class="pagi-btn" ${produkCurrentPage === totalPages ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="produkCurrentPage++; renderProdukTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6"/></svg>
        </button>`;

        pagiContainer.innerHTML = btnsHtml;
      }
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
      produkCurrentPage = 1;
      renderProdukTable();
    }

    function populateKategoriSelect() {
      const select = document.getElementById('prod-kat');
      if (select) {
        select.innerHTML = kategoriList.map(k => `<option value="${k.id}">${k.nama}</option>`).join('');
      }
    }

    function setModalMode(mode) {
      editingProdukId = null;
      selectedProdukImage = '';
      populateKategoriSelect();
      document.getElementById('prod-modal-title').textContent = 'Tambah Produk';
      ['prod-nama', 'prod-harga', 'prod-desk', 'file-upload'].forEach(id => document.getElementById(id).value = '');
      document.getElementById('upload-hint').textContent = 'Belum ada file dipilih';
      ['err-prod-nama', 'err-prod-harga', 'err-prod-desk'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
      });
    }

    function openEditProduk(id) {
      const p = produkList.find(x => String(x.id) === String(id));
      if (!p) return;
      editingProdukId = id;
      populateKategoriSelect();
      document.getElementById('prod-modal-title').textContent = 'Edit Produk';
      document.getElementById('prod-nama').value = p.nama;
      document.getElementById('prod-kat').value = p.kategori_id || '';
      document.getElementById('prod-harga').value = p.harga ? 'Rp' + Number(p.harga).toLocaleString('id-ID') : '';
      document.getElementById('prod-desk').value = p.deskripsi;
      selectedProdukImage = p.image || '';
      document.getElementById('upload-hint').textContent = 'Foto tersimpan';
      ['err-prod-nama', 'err-prod-harga', 'err-prod-desk'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
      });
      openAdminModal('modal-tambah-produk');
    }

    function formatRupiahInput(input) {
      let value = input.value.replace(/\D/g, '');
      if (value) {
        input.value = 'Rp' + parseInt(value).toLocaleString('id-ID');
      } else {
        input.value = '';
      }
    }

    function openHapusProduk(id) {
      deletingProdukId = id;
      openAdminModal('modal-hapus-produk');
    }

    async function saveProduk() {
      const nama = document.getElementById('prod-nama').value.trim();
      const kat = document.getElementById('prod-kat').value;
      const harga = parseInt(document.getElementById('prod-harga').value.replace(/\D/g, '')) || 0;
      const desk = document.getElementById('prod-desk').value.trim();
      const fileInput = document.getElementById('file-upload');

      let isValid = true;
      if (!nama) {
        document.getElementById('err-prod-nama').style.display = 'block';
        isValid = false;
      }
      if (!harga || harga <= 0) {
        document.getElementById('err-prod-harga').style.display = 'block';
        isValid = false;
      }
      if (!desk) {
        document.getElementById('err-prod-desk').style.display = 'block';
        isValid = false;
      }
      // Validasi foto wajib saat tambah produk baru
      if (!editingProdukId && fileInput.files.length === 0) {
        const errFoto = document.getElementById('err-prod-foto');
        if (errFoto) {
          errFoto.textContent = 'Foto produk wajib diunggah.';
          errFoto.style.display = 'block';
        }
        isValid = false;
      }
      if (!isValid) return;

      const formData = new FormData();
      formData.append('nama', nama);
      formData.append('kategori_id', kat);
      formData.append('harga', harga);
      formData.append('deskripsi', desk);
      if (fileInput.files.length > 0) {
        formData.append('image', fileInput.files[0]);
      }

      const isEdit = !!editingProdukId;
      const url = isEdit ? `/admin/produk/${editingProdukId}` : `/admin/produk`;
      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();

        if (res.status === 422 && data.errors && data.errors.nama) {
          const errEl = document.getElementById('err-prod-nama');
          if (errEl) {
            errEl.textContent = 'Nama produk sudah ada.';
            errEl.style.display = 'block';
          }
          return;
        }

        if (data.success) {
          if (isEdit) {
            const idx = produkList.findIndex(x => String(x.id) === String(editingProdukId));
            if (idx > -1) produkList[idx] = data.produk;
          } else {
            produkList.push(data.produk);
          }
          closeAdminModal('modal-tambah-produk');
          renderProdukTable();
          showAdminToast('Berhasil', isEdit ? 'Produk berhasil diperbarui!' : 'Produk berhasil ditambahkan!', 'success');
        } else {
          showAdminToast('Gagal', 'Terjadi kesalahan.', 'error');
        }
      } catch (err) {
        showAdminToast('Gagal', 'Koneksi bermasalah.', 'error');
      }
    }

    async function confirmHapusProduk() {
      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      try {
        const res = await fetch(`/admin/produk/${deletingProdukId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (data.success) {
          produkList = produkList.filter(x => String(x.id) !== String(deletingProdukId));
          closeAdminModal('modal-hapus-produk');
          renderProdukTable();
          showAdminToast('Berhasil Dihapus', 'Produk telah dihapus dari daftar.', 'success');
        } else {
          showAdminToast('Gagal', 'Terjadi kesalahan.', 'error');
        }
      } catch (err) {
        showAdminToast('Gagal', 'Koneksi bermasalah.', 'error');
      }
    }

    function handleFileChange(input) {
      const file = input.files[0];
      const errEl = document.getElementById('err-prod-foto');
      document.getElementById('upload-hint').textContent = file?.name || 'Belum ada file dipilih';
      
      if (!file) {
        selectedProdukImage = '';
        return;
      }

      // Validasi ukuran maksimal 2MB
      if (file.size > 2 * 1024 * 1024) {
        if (errEl) {
          errEl.textContent = 'Ukuran file maksimal 2MB.';
          errEl.style.display = 'block';
        }
        input.value = '';
        document.getElementById('upload-hint').textContent = 'Belum ada file dipilih';
        selectedProdukImage = '';
        return;
      }

      // File valid, sembunyikan error
      if (errEl) errEl.style.display = 'none';
      
      const reader = new FileReader();
      reader.onload = () => selectedProdukImage = String(reader.result || '');
      reader.readAsDataURL(file);
    }

    // KATEGORI
    let katCurrentPage = 1;
    const katPerPage = 8;

    function searchKategori() {
      katCurrentPage = 1;
      renderKategoriTable();
    }

    function renderKategoriTable() {
      if (!document.getElementById('kategori-tbody')) return;
      const searchQuery = document.getElementById('kat-search')?.value.toLowerCase() || '';
      let list = kategoriList;
      if (searchQuery) list = list.filter(k => k.nama.toLowerCase().includes(searchQuery));

      const totalItems = list.length;
      const totalPages = Math.ceil(totalItems / katPerPage) || 1;
      if (katCurrentPage > totalPages) katCurrentPage = totalPages;

      const startIdx = (katCurrentPage - 1) * katPerPage;
      const paginatedList = list.slice(startIdx, startIdx + katPerPage);

      document.getElementById('kategori-tbody').innerHTML = paginatedList.map((k, index) => {
        const seqNum = startIdx + index + 1;
        return `
        <tr>
          <td class="id-cell">${seqNum}</td>
          <td>${k.nama}</td>
          <td class="action-cell">
            <div class="action-buttons">
              <button class="icon-btn icon-btn-edit" data-tooltip="Edit" onclick="openEditKat('${k.id}')">${editIcon}</button>
              <button class="icon-btn icon-btn-delete" data-tooltip="Hapus" onclick="openHapusKat('${k.id}')">${deleteIcon}</button>
            </div>
          </td>
        </tr>`;
      }).join('');

      const infoEl = document.getElementById('kat-pagi-info');
      if (infoEl) {
        const endIdx = Math.min(startIdx + katPerPage, totalItems);
        infoEl.textContent = totalItems === 0 ? '0 dari 0' : `${startIdx + 1} - ${endIdx} dari ${totalItems}`;
      }

      const pagiContainer = document.querySelector('#page-kategori .pagi-btns');
      if (pagiContainer) {
        let btnsHtml = `<button class="pagi-btn" ${katCurrentPage === 1 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="katCurrentPage--; renderKategoriTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>`;

        btnsHtml += `<button class="pagi-btn active">${katCurrentPage}</button>`;

        btnsHtml += `<button class="pagi-btn" ${katCurrentPage === totalPages ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="katCurrentPage++; renderKategoriTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6"/></svg>
        </button>`;

        pagiContainer.innerHTML = btnsHtml;
      }
    }

    function setKatModalMode(mode) {
      editingKatId = null;
      document.getElementById('kat-modal-title').textContent = 'Tambah Kategori';
      document.getElementById('kat-nama').value = '';
      const errEl = document.getElementById('err-kat-nama');
      if (errEl) {
        errEl.textContent = 'Nama kategori wajib diisi.';
        errEl.style.display = 'none';
      }
    }

    function openEditKat(id) {
      const k = kategoriList.find(x => String(x.id) === String(id));
      if (!k) return;
      editingKatId = id;
      document.getElementById('kat-modal-title').textContent = 'Edit Kategori';
      document.getElementById('kat-nama').value = k.nama;
      const errEl = document.getElementById('err-kat-nama');
      if (errEl) {
        errEl.textContent = 'Nama kategori wajib diisi.';
        errEl.style.display = 'none';
      }
      openAdminModal('modal-tambah-kat');
    }

    function openHapusKat(id) {
      deletingKatId = id;
      openAdminModal('modal-hapus-kat');
    }
    async function saveKategori() {
      const nama = document.getElementById('kat-nama').value.trim();
      const errEl = document.getElementById('err-kat-nama');
      if (!nama) {
        if (errEl) {
          errEl.textContent = 'Nama kategori wajib diisi.';
          errEl.style.display = 'block';
        }
        return;
      }

      const isEdit = !!editingKatId;
      const url = isEdit ? `/admin/kategori/${editingKatId}` : `/admin/kategori`;
      const method = isEdit ? 'PUT' : 'POST';
      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const res = await fetch(url, {
          method,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            nama
          })
        });

        const data = await res.json();

        if (res.status === 422 && data.errors && data.errors.nama) {
          if (errEl) {
            errEl.textContent = 'Nama kategori sudah ada.';
            errEl.style.display = 'block';
          }
          return;
        }

        if (data.success) {
          if (isEdit) {
            const k = kategoriList.find(x => String(x.id) === String(editingKatId));
            if (k) k.nama = nama;
          } else {
            kategoriList.push(data.data);
          }
          closeAdminModal('modal-tambah-kat');
          renderKategoriTable();
          showAdminToast('Berhasil', isEdit ? 'Kategori berhasil diperbarui.' : 'Kategori baru berhasil ditambahkan.');
        } else {
          showAdminToast('Gagal', 'Terjadi kesalahan.', 'error');
        }
      } catch (err) {
        showAdminToast('Gagal', 'Koneksi bermasalah.', 'error');
      }
    }

    async function confirmHapusKat() {
      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      try {
        const res = await fetch(`/admin/kategori/${deletingKatId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (data.success) {
          kategoriList = kategoriList.filter(x => String(x.id) !== String(deletingKatId));
          closeAdminModal('modal-hapus-kat');
          renderKategoriTable();
          showAdminToast('Berhasil Dihapus', 'Kategori telah dihapus.', 'success');
        } else {
          showAdminToast('Gagal', data.message || 'Terjadi kesalahan.', 'error');
        }
      } catch (err) {
        showAdminToast('Gagal', 'Koneksi bermasalah.', 'error');
      }
    }

    // STOK
    let stokCurrentPage = 1;
    const stokPerPage = 8;

    function searchStok() {
      stokCurrentPage = 1;
      renderStokTable();
    }

    function renderStokTable() {
      if (!document.getElementById('stok-tbody')) return;
      const searchQuery = document.getElementById('stok-search')?.value.toLowerCase() || '';
      let list = produkList;
      if (searchQuery) list = list.filter(p => p.nama.toLowerCase().includes(searchQuery));

      const totalItems = list.length;
      const totalPages = Math.ceil(totalItems / stokPerPage) || 1;
      if (stokCurrentPage > totalPages) stokCurrentPage = totalPages;
      if (stokCurrentPage < 1) stokCurrentPage = 1;

      const startIdx = (stokCurrentPage - 1) * stokPerPage;
      const paginatedList = list.slice(startIdx, startIdx + stokPerPage);

      document.getElementById('stok-tbody').innerHTML = paginatedList.map(p => `
        <tr>
          <td>${p.nama}</td>
          <td style="text-align:center;">${p.stok.S}</td>
          <td style="text-align:center;">${p.stok.M}</td>
          <td style="text-align:center;">${p.stok.L}</td>
          <td style="text-align:center;">${p.stok.XL}</td>
          <td class="action-cell"><button class="icon-btn icon-btn-edit" data-tooltip="Edit Stok" onclick="openEditStok('${p.id}')">${editIcon}</button></td>
        </tr>`).join('');

      const infoEl = document.getElementById('stok-pagi-info');
      if (infoEl) {
        const endIdx = Math.min(startIdx + stokPerPage, totalItems);
        infoEl.textContent = totalItems === 0 ? '0 dari 0' : `${startIdx + 1} - ${endIdx} dari ${totalItems}`;
      }

      const pagiContainer = document.querySelector('#page-stok .pagi-btns');
      if (pagiContainer) {
        let btnsHtml = `<button class="pagi-btn" ${stokCurrentPage === 1 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="stokCurrentPage--; renderStokTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>`;

        btnsHtml += `<button class="pagi-btn active">${stokCurrentPage}</button>`;

        btnsHtml += `<button class="pagi-btn" ${stokCurrentPage === totalPages ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="stokCurrentPage++; renderStokTable()">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6"/></svg>
        </button>`;

        pagiContainer.innerHTML = btnsHtml;
      }
    }

    function openEditStok(id) {
      const p = produkList.find(x => String(x.id) === String(id));
      if (!p) return;
      editingStokId = id;
      document.getElementById('stok-modal-produk-name').textContent = 'Produk: ' + p.nama;
      ['s', 'm', 'l', 'xl'].forEach(sz => document.getElementById('stok-' + sz).value = p.stok[sz.toUpperCase()]);
      openAdminModal('modal-stok');
    }

    async function saveStok() {
      const p = produkList.find(x => String(x.id) === String(editingStokId));
      if (!p) return;

      const payload = {};
      let hasError = false;
      ['s', 'm', 'l', 'xl'].forEach(sz => {
        let val = parseInt(document.getElementById('stok-' + sz).value);
        if (isNaN(val) || val < 0) {
          val = 0;
        }
        payload[sz.toUpperCase()] = val;
      });

      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const res = await fetch(`/admin/stok/${editingStokId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (data.success) {
          p.stok = {
            ...p.stok,
            ...payload
          };
          closeAdminModal('modal-stok');
          renderStokTable();
          showAdminToast('Berhasil', 'Stok berhasil diperbarui.');
        } else {
          showAdminToast('Gagal', 'Terjadi kesalahan saat menyimpan stok.', 'error');
        }
      } catch (err) {
        showAdminToast('Gagal', 'Koneksi bermasalah.', 'error');
      }
    }

    function normalizePesananFilterDate(value = '') {
      const date = String(value).trim();
      if (/^\d{4}-\d{2}-\d{2}$/.test(date)) return date;

      const match = date.match(/^(\d{1,2})[/-](\d{1,2})[/-](\d{4})$/);
      if (!match) return '';

      const day = match[1].padStart(2, '0');
      const month = match[2].padStart(2, '0');
      return `${match[3]}-${month}-${day}`;
    }

    function setupPesananDateInputs() {
      const isMobile = window.matchMedia('(max-width: 640px)').matches;
      ['pesanan-date-from', 'pesanan-date-to'].forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;

        input.type = isMobile ? 'text' : 'date';
        input.placeholder = isMobile ? 'yyyy-mm-dd' : '';
        input.inputMode = isMobile ? 'numeric' : '';
        input.autocomplete = 'off';
      });
    }

    // PESANAN
    let pesananCurrentPage = 1;
    const pesananPerPage = 8;

    function renderPesananTable() {
      if (!document.getElementById('pesanan-tbody')) return;
      const filterStatus = document.getElementById('pesanan-filter-status')?.value || '';
      const searchQuery = document.getElementById('pesanan-search')?.value.toLowerCase() || '';
      const dateFrom = normalizePesananFilterDate(document.getElementById('pesanan-date-from')?.value || '');
      const dateTo = normalizePesananFilterDate(document.getElementById('pesanan-date-to')?.value || '');

      const list = pesananList.filter(o => {
        const matchStatus = !filterStatus || o.status === filterStatus;
        const matchSearch = !searchQuery || o.nama.toLowerCase().includes(searchQuery) || o.id.toLowerCase().includes(searchQuery);
        let matchDate = true;
        if (dateFrom || dateTo) {
          const parts = o.tanggal.split('-');
          const tglISO = parts[2] + '-' + parts[1] + '-' + parts[0];
          if (dateFrom && tglISO < dateFrom) matchDate = false;
          if (dateTo && tglISO > dateTo) matchDate = false;
        }
        return matchStatus && matchSearch && matchDate;
      });

      const totalItems = list.length;
      const totalPages = Math.ceil(totalItems / pesananPerPage) || 1;
      if (pesananCurrentPage > totalPages) pesananCurrentPage = totalPages;

      const startIdx = (pesananCurrentPage - 1) * pesananPerPage;
      const paginatedList = list.slice(startIdx, startIdx + pesananPerPage);

      document.getElementById('pesanan-tbody').innerHTML = paginatedList.length ? paginatedList.map(o => `
        <tr>
          <td class="whitespace-nowrap px-6 py-4 text-center">${o.id}</td>
          <td class="whitespace-nowrap px-6 py-4">${o.tanggal}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-full border border-[#e2d4c5] bg-[#fbf8f5] flex items-center justify-center overflow-hidden shrink-0">
                <img src="${o.avatar ? o.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.nama)}&background=f3e6db&color=5c4432&bold=true&size=64`}" alt="${o.nama}" class="h-full w-full object-cover">
              </div>
              <span class="font-medium text-[#5c4432] line-clamp-1 break-all">${o.nama}</span>
            </div>
          </td>
          <td class="whitespace-nowrap px-6 py-4">${statusBadge(o.status)}</td>
          <td class="whitespace-nowrap px-6 py-4">${rp(o.items.reduce((s, i) => s + i.harga * i.qty, 0))}</td>
          <td class="whitespace-nowrap px-6 py-4 text-center"><button onclick="openDetailPesanan('${o.id}')" class="inline-flex items-center justify-center rounded-xl border border-[#d8c3af] bg-[#a78d78] px-4 py-2 text-sm font-normal text-white transition hover:bg-[#8f7561]">Detail</button></td>
        </tr>`).join('') : `<tr><td colspan="6" class="px-6 py-6 text-center text-[#b7a08c]">Tidak ada pesanan ditemukan.</td></tr>`;

      const endIdx = Math.min(startIdx + pesananPerPage, totalItems);
      const infoEl = document.getElementById('pesanan-pagi-info');
      if (infoEl) infoEl.textContent = totalItems === 0 ? '0 pesanan' : `${startIdx + 1} - ${endIdx} dari ${totalItems}`;

      const prevBtn = document.getElementById('pesanan-pagi-prev');
      const nextBtn = document.getElementById('pesanan-pagi-next');
      if (prevBtn) prevBtn.disabled = pesananCurrentPage <= 1;
      if (nextBtn) nextBtn.disabled = pesananCurrentPage >= totalPages;

      const activeBtn = document.querySelector('#page-pesanan .pagi-btn.active');
      if (activeBtn) activeBtn.textContent = pesananCurrentPage;
    }

    function pesananPrevPage() {
      if (pesananCurrentPage > 1) {
        pesananCurrentPage--;
        renderPesananTable();
      }
    }

    function pesananNextPage() {
      pesananCurrentPage++;
      renderPesananTable();
    }


    function openDetailPesanan(id) {
      const o = pesananList.find(x => x.id === id);
      if (!o) return;

      viewingPesananId = id;
      const total = o.items.reduce((s, i) => s + i.harga * i.qty, 0);
      const statusOptions = ['Menunggu Verifikasi', 'Pembayaran Berhasil', 'Pembayaran Ditolak', 'Konfirmasi Ulang'];

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
              <div class="detail-field-label">Tanggal</div>
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


          <div class="detail-section-title">Item Pesanan</div>
          <div class="space-y-3">
            ${o.items.map(item => {
        const p = produkList.find(x => x.nama === item.produk);
        return `
                <div class="flex items-center gap-4 rounded-xl bg-[#fbf8f5] p-3 border border-[#f0e7dd]">
                  <div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-[#f0e7dd] bg-white">
                    <img src="${getProdukImage(item.produk, item.image)}" class="h-full w-full object-cover">
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
        </div>

        <div class="modal-action-footer">
          <button type="button" onclick="closeAdminModal('modal-pesanan')" class="btn-modal-cancel">Tutup</button>
        </div>
      `;

      openAdminModal('modal-pesanan');
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

    document.addEventListener('click', (e) => {

      const produkBtn = document.getElementById('produk-filter-kat-btn');
      const produkMenu = document.getElementById('produk-filter-kat-menu');
      const produkIcon = document.getElementById('produk-filter-kat-icon');
      if (produkBtn && !produkBtn.contains(e.target) && !produkMenu?.contains(e.target)) {
        produkMenu?.classList.add('hidden');
        produkIcon?.classList.remove('rotate-180');
      }

      const pesananBtn = document.getElementById('pesanan-status-filter-btn');
      const pesananMenu = document.getElementById('pesanan-status-filter-menu');
      const pesananIcon = document.getElementById('pesanan-status-filter-icon');
      if (pesananBtn && !pesananBtn.contains(e.target) && !pesananMenu?.contains(e.target)) {
        pesananMenu?.classList.add('hidden');
        pesananIcon?.classList.remove('rotate-180');
      }
    });



    window.addEventListener('resize', setupPesananDateInputs);
    document.addEventListener('DOMContentLoaded', () => {
      setupPesananDateInputs();
      renderDashboard();
      renderProdukTable();
      renderKategoriTable();
      renderStokTable();
      renderPesananTable();

      // Auto-polling untuk admin pesanan
      const pendingOrders = pesananList.filter(o => o.status === 'Menunggu Pembayaran');
      if (pendingOrders.length > 0) {
        setInterval(async () => {
          let shouldReload = false;
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

          for (const order of pendingOrders) {
            try {
              const formData = new FormData();
              // Gunakan raw_order_id untuk pengecekan ke Midtrans
              formData.append('order_id', order.raw_order_id);

              const res = await fetch('/checkout/status', {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                  'Accept': 'application/json'
                },
                body: formData
              });

              if (res.ok) {
                const data = await res.json();
                if (data.transaction_status && !['pending', '404'].includes(data.transaction_status)) {
                  shouldReload = true;
                  break;
                }
              }
            } catch (e) {
              console.warn('Polling status error', e);
            }
          }
          if (shouldReload) {
            window.location.reload();
          }
        }, 5000);
      }
    });
  </script>
</body>

</html>