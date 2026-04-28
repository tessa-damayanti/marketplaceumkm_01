<!-- page aktegori -->
<div class="page" id="page-kategori">
  <div
    class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4 bg-white">
      <div class="flex min-w-0 flex-1 flex-wrap items-center gap-3">
        <input type="text" id="kategori-search" placeholder="Cari kategori..." onkeyup="renderKategoriTable()"
          class="min-h-[42px] min-w-[280px] rounded-full border border-[#d8c3af] bg-white px-4 py-2 text-sm text-[#5c4432] outline-none focus:border-[#a78d78]">
      </div>
      <button
        class="rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
        onclick="openModal('modal-tambah-kat'); setKatModalMode('add')">+ Tambah Kategori</button>
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
    <div class="pagi-row">
      <span id="kategori-pagi-info"><span class="font-bold text-[#5c4432]">1 - 0</span> dari <span class="font-bold text-[#5c4432]">0</span></span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;</button>
      </div>
    </div>
  </div>
</div>