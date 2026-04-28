<!-- page stok produk -->
<div class="page" id="page-stok">
  <div
    class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4 bg-white">
      <div class="flex min-w-0 flex-1 flex-wrap items-center gap-3">
        <input type="text" id="stok-search" placeholder="Cari produk..." onkeyup="renderStokTable()"
          class="min-h-[42px] min-w-[280px] rounded-full border border-[#d8c3af] bg-white px-4 py-2 text-sm text-[#5c4432] outline-none focus:border-[#a78d78]">
      </div>
    </div>
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr class="bg-white">
            <th class="px-6 py-4 text-sm font-bold">Produk</th>
            <th class="px-4 py-4 text-center text-sm font-bold">S</th>
            <th class="px-4 py-4 text-center text-sm font-bold">M</th>
            <th class="px-4 py-4 text-center text-sm font-bold">L</th>
            <th class="px-4 py-4 text-center text-sm font-bold">XL</th>
            <th class="px-4 py-4 text-center text-sm font-bold">Aksi</th>
          </tr>
        </thead>
        <tbody id="stok-tbody"></tbody>
      </table>
    </div>
    <div class="pagi-row">
      <span id="stok-pagi-info"><span class="font-bold text-[#5c4432]">1 - 0</span> dari <span class="font-bold text-[#5c4432]">0</span></span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;</button>
      </div>
    </div>
  </div>
</div>