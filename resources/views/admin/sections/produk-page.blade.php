<!-- page produk -->
<div class="page" id="page-produk">
  <div class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
      <div class="flex min-w-0 flex-1 flex-wrap items-center gap-3">
        <select id="produk-filter-kat" onchange="renderProdukTable()" class="min-h-[42px] min-w-[190px] rounded-xl border border-[#d8c3af] bg-[#fffaf5] px-3 py-2 text-sm text-[#5c4432] outline-none focus:border-[#a78d78]">
          <option value="">Semua Kategori</option>
          <option>Gaun</option>
          <option>Kemeja</option>
          <option>Kardigan</option>
          <option>Rok</option>
        </select>
      </div>
      <button class="rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]" onclick="openModal('modal-tambah-produk'); setModalMode('add')">+ Tambah Produk</button>
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
      <span id="produk-pagi-info">1 - 4 dari 4</span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;</button>
      </div>
    </div>
  </div>
</div>
