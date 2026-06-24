<!-- tambah dan edit produk -->
<div class="overlay" id="modal-tambah-produk">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="prod-modal-title">Tambah Produk</span>
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
        <input type="text" id="prod-nama" placeholder="Nama produk.." style="width:100%" oninput="document.getElementById('err-prod-nama').style.display='none'">
        <span class="error-msg" id="err-prod-nama" style="color: #ef4444; font-size: 12px; font-weight: 500; display: none; margin-top: 4px;">Nama produk wajib diisi.</span>
      </div>
      <div>
        <label class="field-label">Kategori</label>
        <select id="prod-kat" style="width:100%">
        </select>
      </div>
      <div>
        <label class="field-label">Harga</label>
        <input type="text" id="prod-harga" placeholder="Rp 100.000" style="width:100%" oninput="formatRupiahInput(this); document.getElementById('err-prod-harga').style.display='none'">
        <span class="error-msg" id="err-prod-harga" style="color: #ef4444; font-size: 12px; font-weight: 500; display: none; margin-top: 4px;">Harga produk wajib diisi.</span>
      </div>
      <div>
        <label class="field-label">Deskripsi</label>
        <textarea id="prod-desk" rows="4" placeholder="Deskripsi produk..."
          style="width:100%;resize:vertical;" oninput="document.getElementById('err-prod-desk').style.display='none'"></textarea>
        <span class="error-msg" id="err-prod-desk" style="color: #ef4444; font-size: 12px; font-weight: 500; display: none; margin-top: 4px;">Deskripsi produk wajib diisi.</span>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-modal-cancel" onclick="closeAdminModal('modal-tambah-produk')">Batal</button>
      <button class="btn-modal-save" onclick="saveProduk()">Simpan</button>
    </div>
  </div>
</div>

<!-- Hapus Produk Konfirmasi -->
<div class="overlay overlay-top" id="modal-hapus-produk">
  <div class="modal modal-sm">
    <div class="confirm-box">
      <p>Apakah Anda yakin ingin menghapus produk ini?</p>
      <div class="confirm-actions">
        <button class="btn-modal-cancel" onclick="closeAdminModal('modal-hapus-produk')">Batal</button>
        <button class="btn-modal-save" style="background: #ef4444;" onclick="confirmHapusProduk()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- tambah dan edit kategori -->
<div class="overlay" id="modal-tambah-kat">
  <div class="modal modal-sm">
    <div class="modal-header">
      <span class="modal-title" id="kat-modal-title">Tambah Kategori</span>
    </div>
    <div class="modal-body">
      <div>
        <label class="field-label">Nama Kategori</label>
        <input type="text" id="kat-nama" placeholder="Nama Kategori..." style="width:100%" oninput="document.getElementById('err-kat-nama').style.display='none'">
        <span class="error-msg" id="err-kat-nama" style="color: #ef4444; font-size: 12px; font-weight: 500; display: none; margin-top: 4px;">Nama kategori wajib diisi.</span>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-modal-cancel" onclick="closeAdminModal('modal-tambah-kat')">Batal</button>
      <button class="btn-modal-save" onclick="saveKategori()">Simpan</button>
    </div>
  </div>
</div>

<!-- Hapus Kategori -->
<div class="overlay overlay-top" id="modal-hapus-kat">
  <div class="modal modal-sm">
    <div class="confirm-box">
      <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
      <div class="confirm-actions">
        <button class="btn-modal-cancel" onclick="closeAdminModal('modal-hapus-kat')">Batal</button>
        <button class="btn-modal-save" style="background: #ef4444;" onclick="confirmHapusKat()">Hapus</button>
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
        <button class="btn-modal-cancel" onclick="closeAdminModal('modal-logout')">Batal</button>
        <button class="btn-modal-save" style="background: #ef4444;" onclick="proceedLogout()">Ya, Keluar</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Stok -->
<div class="overlay" id="modal-stok">
  <div class="modal modal-sm">
    <div class="modal-header">
      <span class="modal-title">Edit Stok Produk</span>
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
      <button class="btn-modal-cancel" onclick="closeAdminModal('modal-stok')">Batal</button>
      <button class="btn-modal-save" onclick="saveStok()">Simpan</button>
    </div>
  </div>
</div>

<!-- Detail Pesanan -->
<div class="overlay" id="modal-pesanan">
  <div class="modal" style="width:520px;" id="pesanan-modal-content">

  </div>
</div>