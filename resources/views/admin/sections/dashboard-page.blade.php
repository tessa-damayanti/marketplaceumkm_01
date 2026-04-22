<!-- page dashboard -->
<div class="page active" id="page-dashboard">
  <div class="mb-5 grid gap-4 lg:grid-cols-3">
    <div class="rounded-xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="mb-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#7b6858]">Total Pesanan</div>
      <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" id="s-pesanan">6</div>
      <div class="text-sm font-semibold text-[#7b6858]">Pesanan masuk</div>
    </div>
    <div class="rounded-xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="mb-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#7b6858]">Total Produk</div>
      <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" id="s-produk">8</div>
      <div class="text-sm font-semibold text-[#7b6858]">Produk</div>
    </div>
    <div class="rounded-xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="mb-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#7b6858]">Total Kategori</div>
      <div class="mb-1 text-4xl font-extrabold text-[#5c4432]">4</div>
      <div class="text-sm font-semibold text-[#7b6858]">Kategori</div>
    </div>
  </div>

  <div class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex items-start justify-between px-6 pt-5">
      <div>
        <div class="text-[2rem] font-extrabold tracking-[-0.03em] text-[#5c4432]">Pesanan Terbaru</div>
      </div>
      <button class="rounded-2xl border border-[#d8c3af] bg-[#f3ecdf] px-5 py-2 text-sm font-semibold text-[#5c4432] transition hover:bg-[#e8ded3]" onclick="goPage('pesanan')">Lihat Semua</button>
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
      <span id="dash-pagi-info">1 - 5 dari 5</span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;</button>
      </div>
    </div>
  </div>
</div>
