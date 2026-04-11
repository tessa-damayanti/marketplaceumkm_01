<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Velora — Admin Dashboard</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; font-family: 'Segoe UI', system-ui, sans-serif; font-size: 14px; background: #f0f0f0; color: #1a1a1a; }

    .shell { display: flex; height: 100vh; overflow: hidden; }

    .sidebar {
      width: 220px; min-width: 220px;
      background: #fff;
      border-right: 1px solid #e5e5e5;
      display: flex; flex-direction: column;
      padding: 0 0 24px;
      overflow-y: auto;
    }
    .sidebar-logo {
      padding: 22px 24px 18px;
      font-size: 22px; font-weight: 800; letter-spacing: -0.5px;
      color: #1a1a1a; border-bottom: 1px solid #f0f0f0;
    }
    .sidebar-section-label {
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 1px; color: #999; padding: 18px 24px 8px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px; margin: 1px 8px;
      border-radius: 8px; cursor: pointer;
      font-size: 13.5px; font-weight: 500; color: #555;
      transition: background 0.15s, color 0.15s;
      text-decoration: none;
    }
    .nav-item:hover { background: #f5f5f5; color: #1a1a1a; }
    .nav-item.active { background: #f0f0f0; color: #1a1a1a; font-weight: 700; }
    .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }
    .sidebar-spacer { flex: 1; }
    .sidebar-logout {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px; margin: 0 8px;
      border-radius: 8px; cursor: pointer;
      font-size: 13.5px; font-weight: 500; color: #888;
      transition: background 0.15s; user-select: none;
    }
    .sidebar-logout:hover { background: #fff0f0; color: #c0392b; }

    .main-wrap { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

    .topbar {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 28px; height: 56px; min-height: 56px;
      background: #f0f0f0; border-bottom: 1px solid #e0e0e0;
    }
    .topbar-title { font-size: 18px; font-weight: 800; letter-spacing: -0.3px; }
    .topbar-greeting { font-size: 13px; color: #777; font-weight: 500; }

    .main-content { flex: 1; overflow-y: auto; padding: 24px 28px; }

    .surface {
      background: #fff; border-radius: 12px;
      border: 1px solid #e8e8e8;
    }
    .surface-pad { padding: 20px 22px; }

    .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
    .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e8e8e8; padding: 20px 22px; }
    .stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 6px; }
    .stat-value { font-size: 32px; font-weight: 800; color: #1a1a1a; line-height: 1; margin-bottom: 4px; }
    .stat-sub { font-size: 12px; color: #888; font-weight: 500; }

    .sec-header { display: flex; align-items: flex-start; justify-content: space-between; padding: 20px 22px 0; margin-bottom: 4px; }
    .sec-title { font-size: 18px; font-weight: 800; letter-spacing: -0.3px; }
    .sec-sub { font-size: 12px; color: #999; margin-top: 2px; }

    .tbl-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      background: #f7f7f7; padding: 10px 14px;
      font-size: 12px; font-weight: 700; text-align: left;
      color: #555; border-bottom: 1px solid #ebebeb;
    }
    tbody td { padding: 11px 14px; border-bottom: 1px solid #f2f2f2; font-size: 13px; color: #333; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #fafafa; }

    .pagi-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 18px; border-top: 1px solid #f0f0f0;
      font-size: 12px; color: #888;
    }
    .pagi-btns { display: flex; align-items: center; gap: 4px; }
    .pagi-btn {
      width: 28px; height: 28px; border-radius: 7px;
      border: 1px solid #e0e0e0; background: #fff;
      font-size: 12px; cursor: pointer; color: #555;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.12s;
    }
    .pagi-btn:hover { background: #f5f5f5; }
    .pagi-btn.active { background: #1a1a1a; color: #fff; border-color: #1a1a1a; font-weight: 700; }

    .btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 16px; border-radius: 8px; cursor: pointer;
      font-size: 13px; font-weight: 600; font-family: inherit;
      border: 1px solid #d5d5d5; background: #f0f0f0; color: #333;
      transition: background 0.12s, border-color 0.12s;
    }
    .btn:hover { background: #e5e5e5; }
    .btn-dark { background: #1a1a1a; color: #fff; border-color: #1a1a1a; }
    .btn-dark:hover { background: #333; }
    .btn-sm { padding: 5px 12px; font-size: 12px; border-radius: 7px; }
    .btn-danger { background: #fff0f0; color: #c0392b; border-color: #f5c6c6; }
    .btn-danger:hover { background: #fde0e0; }

    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .badge-belum   { background: #fff3cd; color: #856404; }
    .badge-berhasil{ background: #d1f0e0; color: #1a7a4a; }
    .badge-gagal   { background: #fde8e8; color: #b91c1c; }

    .toolbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #f0f0f0; }
    .toolbar-left { display: flex; align-items: center; gap: 10px; }

    select, input[type="text"], input[type="number"], textarea {
      font-family: inherit; font-size: 13px;
      border: 1px solid #d8d8d8; border-radius: 8px;
      padding: 8px 12px; background: #fff; color: #1a1a1a;
      outline: none; transition: border-color 0.15s;
    }
    select:focus, input:focus, textarea:focus { border-color: #1a1a1a; }
    label.field-label { display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 5px; }

    .foto-cell {
      width: 36px; height: 36px; border-radius: 6px;
      background: #f0f0f0; border: 1px solid #e0e0e0;
      display: flex; align-items: center; justify-content: center;
      color: #aaa; font-size: 16px;
    }

    .overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.30); z-index: 500;
      align-items: center; justify-content: center;
    }
    .overlay.open { display: flex; }
    .modal {
      background: #fff; border-radius: 14px;
      width: 480px; max-width: 96vw; max-height: 90vh;
      overflow-y: auto; box-shadow: 0 8px 40px rgba(0,0,0,0.14);
    }
    .modal-sm { width: 380px; }
    .modal-header { padding: 20px 22px 16px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; }
    .modal-title { font-size: 17px; font-weight: 800; }
    .modal-close { background: none; border: none; cursor: pointer; font-size: 20px; color: #999; line-height: 1; }
    .modal-close:hover { color: #333; }
    .modal-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 14px; }
    .modal-footer { padding: 14px 22px; border-top: 1px solid #f0f0f0; display: flex; justify-content: flex-end; gap: 8px; }

    .field-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .upload-zone {
      border: 1.5px dashed #ccc; border-radius: 8px;
      padding: 14px 16px; background: #fafafa;
      display: flex; align-items: center; gap: 12px; cursor: pointer;
    }
    .upload-zone:hover { border-color: #999; background: #f5f5f5; }
    .upload-zone input[type="file"] { display: none; }
    .upload-btn-fake {
      padding: 6px 14px; border-radius: 7px;
      background: #e8e8e8; border: 1px solid #d0d0d0;
      font-size: 12px; font-weight: 600; color: #444; white-space: nowrap;
    }
    .upload-hint { font-size: 12px; color: #aaa; }

    .confirm-box { padding: 28px 24px; }
    .confirm-box p { font-size: 14px; font-weight: 600; color: #1a1a1a; line-height: 1.5; margin-bottom: 20px; }
    .confirm-actions { display: flex; justify-content: center; gap: 10px; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
    .detail-field { background: #f8f8f8; border-radius: 8px; padding: 10px 14px; }
    .detail-field-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #999; margin-bottom: 4px; }
    .detail-field-value { font-size: 13.5px; font-weight: 600; color: #1a1a1a; }
    .detail-field-full { grid-column: 1 / -1; }
    .bukti-row { display: flex; align-items: center; gap: 10px; background: #f8f8f8; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; }
    .bukti-thumb { width: 44px; height: 44px; background: #e5e5e5; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #bbb; font-size: 18px; }
    .items-block { border: 1px solid #ebebeb; border-radius: 8px; overflow: hidden; }
    .item-row { display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid #f2f2f2; }
    .item-row:last-child { border-bottom: none; }
    .item-thumb { width: 36px; height: 36px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #bbb; font-size: 14px; }
    .item-info { flex: 1; }
    .item-name { font-size: 13px; font-weight: 700; }
    .item-size { font-size: 11px; color: #999; }
    .item-price { font-size: 13px; font-weight: 700; }
    .total-row { display: flex; justify-content: space-between; padding: 11px 14px; font-weight: 700; background: #f8f8f8; border-top: 1px solid #ebebeb; }

    .stok-row { display: flex; align-items: center; justify-content: space-between; padding: 4px 0; }
    .stok-row label { font-size: 13.5px; font-weight: 500; }
    .stok-row input { width: 100px; text-align: right; }

    .page { display: none; }
    .page.active { display: block; }

    .status-edit-sel { border-radius: 7px; padding: 7px 12px; font-size: 13px; font-weight: 600; }

    .id-cell { font-size: 12px; color: #aaa; font-weight: 600; }
  </style>
</head>
<body>

<div class="shell">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">Velora</div>
    <div class="sidebar-section-label">Menu Utama</div>

    <div class="nav-item active" onclick="goPage('dashboard')">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Dashboard
    </div>
    <div class="nav-item" onclick="goPage('produk')">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
      Produk
    </div>
    <div class="nav-item" onclick="goPage('kategori')">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Kategori
    </div>
    <div class="nav-item" onclick="goPage('stok')">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Stok Produk
    </div>
    <div class="nav-item" onclick="goPage('pesanan')">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Pesanan
    </div>

    <div class="sidebar-spacer"></div>
    <div class="sidebar-logout">
      <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Keluar
    </div>
  </aside>

  <!-- MAIN WRAP -->
  <div class="main-wrap">
    <div class="topbar">
      <span class="topbar-title" id="topbar-title">Dashboard</span>
      <span class="topbar-greeting">Selamat Datang, Admin</span>
    </div>

    <div class="main-content">

      <!-- PAGE: DASHBOARD -->
      <div class="page active" id="page-dashboard">
        <div class="stat-row">
          <div class="stat-card">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value" id="s-pesanan">8</div>
            <div class="stat-sub">4 Kategori aktif</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Total Produk</div>
            <div class="stat-value" id="s-produk">12</div>
            <div class="stat-sub">Pesanan masuk</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value">4</div>
            <div class="stat-sub">Kategori</div>
          </div>
        </div>

        <div class="surface">
          <div class="sec-header">
            <div>
              <div class="sec-title">Pesanan Terbaru</div>
              <div class="sec-sub">Daftar pesanan terbaru.</div>
            </div>
            <button class="btn btn-sm" onclick="goPage('pesanan')">Lihat Semua</button>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Produk</th>
                  <th>Status</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="dash-orders-tbody"></tbody>
            </table>
          </div>
          <div class="pagi-row">
            <span id="dash-pagi-info">1 – 3 dari 3</span>
            <div class="pagi-btns">
              <button class="pagi-btn">«</button>
              <button class="pagi-btn active">1</button>
              <button class="pagi-btn">»</button>
            </div>
          </div>
        </div>
      </div>

      <!--PAGE: PRODUK-->
      <div class="page" id="page-produk">
        <div class="surface">
          <div class="toolbar">
            <div class="toolbar-left">
              <select id="produk-filter-kat" onchange="renderProdukTable()">
                <option value="">Semua Kategori</option>
                <option>Gaun</option>
                <option>Kemeja</option>
                <option>Kardigan</option>
                <option>Rok</option>
              </select>
            </div>
            <button class="btn btn-dark" onclick="openModal('modal-tambah-produk'); setModalMode('add')">+ Tambah Produk</button>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Foto</th>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="produk-tbody"></tbody>
            </table>
          </div>
          <div class="pagi-row">
            <span id="produk-pagi-info">1 – 4 dari 4</span>
            <div class="pagi-btns">
              <button class="pagi-btn">«</button>
              <button class="pagi-btn active">1</button>
              <button class="pagi-btn">»</button>
            </div>
          </div>
        </div>
      </div>

      <!-- PAGE: KATEGORI -->
      <div class="page" id="page-kategori">
        <div class="surface">
          <div class="toolbar">
            <div></div>
            <button class="btn btn-dark" onclick="openModal('modal-tambah-kat'); setKatModalMode('add')">+ Tambah Kategori</button>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Kategori</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="kategori-tbody"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ══ PAGE: STOK PRODUK ══ -->
      <div class="page" id="page-stok">
        <div class="surface">
          <div class="tbl-wrap">
            <table>
              <thead>
                <tr>
                  <th>Produk</th>
                  <th style="text-align:center;">S</th>
                  <th style="text-align:center;">M</th>
                  <th style="text-align:center;">L</th>
                  <th style="text-align:center;">XL</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="stok-tbody"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ══ PAGE: PESANAN ══ -->
      <div class="page" id="page-pesanan">
        <div class="surface">
          <div class="tbl-wrap">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tanggal Pemesanan</th>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="pesanan-tbody"></tbody>
            </table>
          </div>
          <div class="pagi-row">
            <span id="pesanan-pagi-info">1 – 3 dari 3</span>
            <div class="pagi-btns">
              <button class="pagi-btn">«</button>
              <button class="pagi-btn active">1</button>
              <button class="pagi-btn">»</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- MODALS-->

<!-- Tambah / Edit Produk -->
<div class="overlay" id="modal-tambah-produk">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="prod-modal-title">Tambah Produk</span>
      <button class="modal-close" onclick="closeModal('modal-tambah-produk')">×</button>
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
        <textarea id="prod-desk" rows="4" placeholder="Deskripsi produk..." style="width:100%;resize:vertical;"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal('modal-tambah-produk')">Batal</button>
      <button class="btn btn-dark" onclick="saveProduk()">Simpan</button>
    </div>
  </div>
</div>

<!-- Hapus Produk Konfirmasi -->
<div class="overlay" id="modal-hapus-produk">
  <div class="modal modal-sm">
    <div class="confirm-box">
      <p>Apakah kamu yakin ingin menghapus produk ini?</p>
      <div class="confirm-actions">
        <button class="btn" onclick="closeModal('modal-hapus-produk')">Batal</button>
        <button class="btn btn-danger" onclick="confirmHapusProduk()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- Tambah / Edit Kategori -->
<div class="overlay" id="modal-tambah-kat">
  <div class="modal modal-sm">
    <div class="modal-header">
      <span class="modal-title" id="kat-modal-title">Tambah Kategori</span>
      <button class="modal-close" onclick="closeModal('modal-tambah-kat')">×</button>
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

<!-- Hapus Kategori Konfirmasi -->
<div class="overlay" id="modal-hapus-kat">
  <div class="modal modal-sm">
    <div class="confirm-box">
      <p>Apakah kamu yakin ingin menghapus kategori ini?</p>
      <div class="confirm-actions">
        <button class="btn" onclick="closeModal('modal-hapus-kat')">Batal</button>
        <button class="btn btn-danger" onclick="confirmHapusKat()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Stok -->
<div class="overlay" id="modal-stok">
  <div class="modal modal-sm">
    <div class="modal-header">
      <span class="modal-title">Edit Stok Produk</span>
      <button class="modal-close" onclick="closeModal('modal-stok')">×</button>
    </div>
    <div class="modal-body">
      <p style="font-size:13.5px;font-weight:700;color:#555;" id="stok-modal-produk-name">Produk: —</p>
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
      <span class="modal-title" id="pesanan-modal-title">Detail Pesanan — ID</span>
      <button class="modal-close" onclick="closeModal('modal-pesanan')">⊗</button>
    </div>
    <div class="modal-body" id="pesanan-modal-body"></div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal('modal-pesanan')">Batal</button>
      <button class="btn btn-dark" onclick="saveEditStatus()">Edit Status</button>
    </div>
  </div>
</div>


<script>
// DATA

let produkList = [
  { id: 'P001', nama: 'Kemeja Stripe', kategori: 'Kemeja', harga: 100000, deskripsi: 'Kemeja wanita bermotif garis.', stok: { S:4, M:4, L:4, XL:4 } },
  { id: 'P002', nama: 'Gaun Ivory',    kategori: 'Gaun',   harga: 175000, deskripsi: 'Gaun wanita elegan warna ivory.', stok: { S:3, M:5, L:2, XL:1 } },
  { id: 'P003', nama: 'Kardigan Floral', kategori: 'Kardigan', harga: 118000, deskripsi: 'Kardigan motif bunga cantik.', stok: { S:6, M:4, L:3, XL:2 } },
  { id: 'P004', nama: 'Rok Denim',     kategori: 'Rok',    harga: 132000, deskripsi: 'Rok denim kasual modern.', stok: { S:5, M:5, L:4, XL:3 } },
  { id: 'P005', nama: 'Gaun Floral Pastel', kategori: 'Gaun', harga: 210000, deskripsi: 'Gaun pastel bermotif floral.', stok: { S:2, M:4, L:3, XL:1 } },
  { id: 'P006', nama: 'Kemeja Hitam',  kategori: 'Kemeja', harga: 105000, deskripsi: 'Kemeja polos warna hitam.', stok: { S:4, M:4, L:4, XL:4 } },
  { id: 'P007', nama: 'Kardigan Rajut', kategori: 'Kardigan', harga: 145000, deskripsi: 'Kardigan rajut hangat nyaman.', stok: { S:3, M:5, L:4, XL:2 } },
  { id: 'P008', nama: 'Rok Plisket',   kategori: 'Rok',    harga: 98000,  deskripsi: 'Rok plisket elegan.', stok: { S:5, M:6, L:4, XL:3 } },
];

let kategoriList = [
  { id: 'K001', nama: 'Kemeja' },
  { id: 'K002', nama: 'Gaun' },
  { id: 'K003', nama: 'Kardigan' },
  { id: 'K004', nama: 'Rok' },
];

let pesananList = [
  { id: 'P001', tanggal: '12-05-2026', nama: 'Citra',      hp: '08132244551',  alamat: 'Jln. Ahmad Yani No. 22', status: 'Belum Dibayar',       items: [{ produk:'Kemeja Hitam', ukuran:'L', qty:1, harga:105000 }] },
  { id: 'P002', tanggal: '12-05-2026', nama: 'Ayu Putri',  hp: '08211234567',  alamat: 'Jln. Sudirman No. 45',  status: 'Pembayaran Berhasil',  items: [{ produk:'Gaun Floral Pastel', ukuran:'M', qty:1, harga:210000 }] },
  { id: 'P003', tanggal: '12-05-2026', nama: 'Dinda',      hp: '08567890123',  alamat: 'Jln. Merdeka Blok C5',  status: 'Pembayaran Gagal',    items: [{ produk:'Rok Plisket', ukuran:'S', qty:1, harga:98000 }, { produk:'Kardigan Rajut', ukuran:'M', qty:1, harga:145000 }] },
  { id: 'P004', tanggal: '11-05-2026', nama: 'Naura',      hp: '08129876543',  alamat: 'Jln. Pahlawan No. 8',   status: 'Belum Dibayar',       items: [{ produk:'Gaun Ivory', ukuran:'S', qty:1, harga:175000 }] },
  { id: 'P005', tanggal: '11-05-2026', nama: 'Cahya Yanti',hp: '08561234567',  alamat: 'Jln. Diponegoro No. 3', status: 'Pembayaran Berhasil',  items: [{ produk:'Kemeja Stripe', ukuran:'M', qty:2, harga:100000 }] },
  { id: 'P006', tanggal: '10-05-2026', nama: 'Merita Anisa',hp:'08781234567',  alamat: 'Jln. Kenanga No. 12',   status: 'Pembayaran Berhasil',  items: [{ produk:'Kardigan Floral', ukuran:'L', qty:1, harga:118000 }] },
];

// STATE
let editingProdukId = null;
let deletingProdukId = null;
let editingKatId = null;
let deletingKatId = null;
let editingStokId = null;
let viewingPesananId = null;
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

  const navMap = { dashboard: 0, produk: 1, kategori: 2, stok: 3, pesanan: 4 };
  document.querySelectorAll('.nav-item')[navMap[page]]?.classList.add('active');

  if (page === 'dashboard') renderDashboard();
  if (page === 'produk')    renderProdukTable();
  if (page === 'kategori')  renderKategoriTable();
  if (page === 'stok')      renderStokTable();
  if (page === 'pesanan')   renderPesananTable();
}

// HELPERS
function rp(n) { return 'Rp' + Number(n).toLocaleString('id-ID'); }

function statusBadge(s) {
  if (s === 'Pembayaran Berhasil') return `<span class="badge badge-berhasil">${s}</span>`;
  if (s === 'Pembayaran Gagal')    return `<span class="badge badge-gagal">${s}</span>`;
  return `<span class="badge badge-belum">${s}</span>`;
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

// DASHBOARD
function renderDashboard() {
  document.getElementById('s-pesanan').textContent = pesananList.length;
  document.getElementById('s-produk').textContent  = produkList.length;

  const recent = pesananList.slice(0, 5);
  document.getElementById('dash-orders-tbody').innerHTML = recent.map(o => `
    <tr>
      <td class="id-cell">${o.id}</td>
      <td><strong>${o.nama}</strong></td>
      <td>${o.items.map(i => i.produk).join(', ')}</td>
      <td>${statusBadge(o.status)}</td>
      <td>${rp(o.items.reduce((s,i) => s + i.harga * i.qty, 0))}</td>
    </tr>`).join('');

  document.getElementById('dash-pagi-info').textContent = `1 – ${recent.length} dari ${pesananList.length}`;
}

// PRODUK
function renderProdukTable() {
  const filterKat = document.getElementById('produk-filter-kat')?.value || '';
  const list = filterKat ? produkList.filter(p => p.kategori === filterKat) : produkList;

  document.getElementById('produk-tbody').innerHTML = list.map(p => `
    <tr>
      <td class="id-cell">${p.id}</td>
      <td><div class="foto-cell">🖼</div></td>
      <td><strong>${p.nama}</strong></td>
      <td>${p.kategori}</td>
      <td>${rp(p.harga)}</td>
      <td style="display:flex;gap:6px;">
        <button class="btn btn-sm" onclick="openEditProduk('${p.id}')">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="openHapusProduk('${p.id}')">Hapus</button>
      </td>
    </tr>`).join('');

  document.getElementById('produk-pagi-info').textContent = `1 – ${list.length} dari ${list.length}`;
}

function setModalMode(mode) {
  editingProdukId = null;
  document.getElementById('prod-modal-title').textContent = 'Tambah Produk';
  document.getElementById('prod-nama').value = '';
  document.getElementById('prod-kat').value = 'Gaun';
  document.getElementById('prod-harga').value = '';
  document.getElementById('prod-desk').value = '';
  document.getElementById('upload-hint').textContent = 'Belum ada file dipilih';
}

function openEditProduk(id) {
  const p = produkList.find(x => x.id === id);
  if (!p) return;
  editingProdukId = id;
  document.getElementById('prod-modal-title').textContent = 'Edit Produk';
  document.getElementById('prod-nama').value  = p.nama;
  document.getElementById('prod-kat').value   = p.kategori;
  document.getElementById('prod-harga').value = p.harga;
  document.getElementById('prod-desk').value  = p.deskripsi;
  document.getElementById('upload-hint').textContent = 'Foto tersimpan';
  openModal('modal-tambah-produk');
}

function openHapusProduk(id) {
  deletingProdukId = id;
  openModal('modal-hapus-produk');
}

function saveProduk() {
  const nama  = document.getElementById('prod-nama').value.trim();
  const kat   = document.getElementById('prod-kat').value;
  const harga = parseInt(document.getElementById('prod-harga').value.replace(/\D/g,'')) || 0;
  const desk  = document.getElementById('prod-desk').value.trim();

  if (!nama) { alert('Nama produk wajib diisi.'); return; }

  if (editingProdukId) {
    const p = produkList.find(x => x.id === editingProdukId);
    if (p) { p.nama = nama; p.kategori = kat; p.harga = harga; p.deskripsi = desk; }
  } else {
    const newId = 'P' + String(produkIdCounter++).padStart(3, '0');
    produkList.push({ id: newId, nama, kategori: kat, harga, deskripsi: desk, stok: { S:0, M:0, L:0, XL:0 } });
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
  document.getElementById('upload-hint').textContent = input.files[0]?.name || 'Belum ada file dipilih';
}

// KATEGORI
function renderKategoriTable() {
  document.getElementById('kategori-tbody').innerHTML = kategoriList.map(k => `
    <tr>
      <td class="id-cell">${k.id}</td>
      <td><strong>${k.nama}</strong></td>
      <td style="display:flex;gap:6px;">
        <button class="btn btn-sm" onclick="openEditKat('${k.id}')">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="openHapusKat('${k.id}')">Hapus</button>
      </td>
    </tr>`).join('');
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
  if (!nama) { alert('Nama kategori wajib diisi.'); return; }

  if (editingKatId) {
    const k = kategoriList.find(x => x.id === editingKatId);
    if (k) k.nama = nama;
  } else {
    const newId = 'K' + String(katIdCounter++).padStart(3, '0');
    kategoriList.push({ id: newId, nama });
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
  document.getElementById('stok-tbody').innerHTML = produkList.map(p => `
    <tr>
      <td><strong>${p.nama}</strong></td>
      <td style="text-align:center;">${p.stok.S}</td>
      <td style="text-align:center;">${p.stok.M}</td>
      <td style="text-align:center;">${p.stok.L}</td>
      <td style="text-align:center;">${p.stok.XL}</td>
      <td><button class="btn btn-sm" onclick="openEditStok('${p.id}')">Edit</button></td>
    </tr>`).join('');
}

function openEditStok(id) {
  const p = produkList.find(x => x.id === id);
  if (!p) return;
  editingStokId = id;
  document.getElementById('stok-modal-produk-name').textContent = 'Produk: ' + p.nama;
  document.getElementById('stok-s').value  = p.stok.S;
  document.getElementById('stok-m').value  = p.stok.M;
  document.getElementById('stok-l').value  = p.stok.L;
  document.getElementById('stok-xl').value = p.stok.XL;
  openModal('modal-stok');
}

function saveStok() {
  const p = produkList.find(x => x.id === editingStokId);
  if (!p) return;
  p.stok.S  = parseInt(document.getElementById('stok-s').value)  || 0;
  p.stok.M  = parseInt(document.getElementById('stok-m').value)  || 0;
  p.stok.L  = parseInt(document.getElementById('stok-l').value)  || 0;
  p.stok.XL = parseInt(document.getElementById('stok-xl').value) || 0;
  closeModal('modal-stok');
  renderStokTable();
}

// PESANAN
function renderPesananTable() {
  document.getElementById('pesanan-tbody').innerHTML = pesananList.map(o => `
    <tr>
      <td class="id-cell">${o.id}</td>
      <td>${o.tanggal}</td>
      <td><strong>${o.nama}</strong></td>
      <td>${statusBadge(o.status)}</td>
      <td>${rp(o.items.reduce((s,i) => s + i.harga * i.qty, 0))}</td>
      <td><button class="btn btn-sm" onclick="openDetailPesanan('${o.id}')">Detail</button></td>
    </tr>`).join('');

  document.getElementById('pesanan-pagi-info').textContent = `1 – ${pesananList.length} dari ${pesananList.length}`;
}

function openDetailPesanan(id) {
  const o = pesananList.find(x => x.id === id);
  if (!o) return;
  viewingPesananId = id;
  const total = o.items.reduce((s,i) => s + i.harga * i.qty, 0);

  document.getElementById('pesanan-modal-title').textContent = `Detail Pesanan  —  ID ${o.id}`;
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
        <div class="bukti-thumb">🖼</div>
        <button class="btn btn-sm" style="margin-left:auto;">Lihat Bukti</button>
      </div>
    </div>

    <div>
      <label class="field-label" style="margin-bottom:8px;">Item Pesanan</label>
      <div class="items-block">
        ${o.items.map(i => `
          <div class="item-row">
            <div class="item-thumb">🖼</div>
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

    <div>
      <label class="field-label">Update Status</label>
      <select class="status-edit-sel" id="status-select" style="width:100%;">
        <option ${o.status==='Belum Dibayar'       ?'selected':''}>Belum Dibayar</option>
        <option ${o.status==='Pembayaran Berhasil' ?'selected':''}>Pembayaran Berhasil</option>
        <option ${o.status==='Pembayaran Gagal'    ?'selected':''}>Pembayaran Gagal</option>
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