<!-- page pesanan -->
<div class="page" id="page-pesanan">
  <div class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
      <div class="flex min-w-0 flex-1 flex-wrap items-center gap-3">
        <div class="search-wrap">
          <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="M20 20L17 17"></path>
          </svg>
          <input type="text" id="pesanan-search" class="search-input" placeholder="Cari pesanan..." oninput="renderPesananTable()">
        </div>
      </div>
    </div>
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
      <span id="pesanan-pagi-info">1 - 3 dari 3</span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;&gt;</button>
      </div>
    </div>
  </div>
</div>
