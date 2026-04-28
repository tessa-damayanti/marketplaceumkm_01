<!-- page dashboard -->
<div class="page active" id="page-dashboard">
  <!-- Top Cards -->
  <div class="mb-6 grid gap-5 lg:grid-cols-4">
    <!-- Card 1 -->
    <div
      class="rounded-2xl border border-[#e2d4c5] bg-gradient-to-br from-[#fffaf5] to-[#fbf3e9] px-6 py-6 shadow-[0_4px_20px_rgba(92,68,50,0.05)] transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(92,68,50,0.08)]">
      <div class="mb-3 flex items-center justify-between">
        <div class="text-[11px] font-bold uppercase tracking-widest text-[#8b7868]">Total Pesanan</div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f3e7d8] text-[#5c4432] shadow-inner">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
          </svg>
        </div>
      </div>
      <div class="mb-1 text-5xl font-black text-[#4a3628]" id="s-pesanan">0</div>
      <div class="text-sm font-medium text-[#8b7868]">Pesanan masuk</div>
    </div>
    <!-- Card 2 -->
    <div
      class="rounded-2xl border border-[#e2d4c5] bg-gradient-to-br from-[#fffaf5] to-[#fbf3e9] px-6 py-6 shadow-[0_4px_20px_rgba(92,68,50,0.05)] transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(92,68,50,0.08)]">
      <div class="mb-3 flex items-center justify-between">
        <div class="text-[11px] font-bold uppercase tracking-widest text-[#8b7868]">Total Produk</div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f3e7d8] text-[#5c4432] shadow-inner">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path
              d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
            </path>
          </svg>
        </div>
      </div>
      <div class="mb-1 text-5xl font-black text-[#4a3628]" id="s-produk">0</div>
      <div class="text-sm font-medium text-[#8b7868]">Katalog Produk</div>
    </div>
    <!-- Card 3 -->
    <div
      class="rounded-2xl border border-[#e2d4c5] bg-gradient-to-br from-[#fffaf5] to-[#fbf3e9] px-6 py-6 shadow-[0_4px_20px_rgba(92,68,50,0.05)] transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(92,68,50,0.08)]">
      <div class="mb-3 flex items-center justify-between">
        <div class="text-[11px] font-bold uppercase tracking-widest text-[#8b7868]">Total Kategori</div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f3e7d8] text-[#5c4432] shadow-inner">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
          </svg>
        </div>
      </div>
      <div class="mb-1 text-5xl font-black text-[#4a3628]" id="s-kategori">0</div>
      <div class="text-sm font-medium text-[#8b7868]">Kategori Aktif</div>
    </div>
    <!-- Card 4 (New: Percentage Sold) -->
    <div
      class="rounded-2xl border border-[#e2d4c5] bg-gradient-to-br from-[#fffaf5] to-[#fbf3e9] px-6 py-6 shadow-[0_4px_20px_rgba(92,68,50,0.05)] transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(92,68,50,0.08)]">
      <div class="mb-3 flex items-center justify-between">
        <div class="text-[11px] font-bold uppercase tracking-widest text-[#8b7868]">Produk Terjual</div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#e8f3d8] text-[#5c7a32] shadow-inner">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
            <polyline points="17 6 23 6 23 12"></polyline>
          </svg>
        </div>
      </div>
      <div class="mb-1 flex items-baseline gap-2">
        <span class="text-5xl font-black text-[#4a3628]" id="s-persentase">0</span>
      </div>
      <div class="text-sm font-medium text-[#8b7868]"><span id="s-terjual" class="font-bold text-[#5c4432]">0</span>
        dari
        <span id="s-total-stok" class="font-bold text-[#5c4432]">0</span> items
      </div>
    </div>
  </div>

  <div class="grid gap-6 lg:grid-cols-3">
    <!-- Left Col: Table (smaller now, taking 2 cols) -->
    <div
      class="lg:col-span-2 flex flex-col overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="flex items-center justify-between border-b border-[#f0e8df] px-6 py-5">
        <h2 class="text-xl font-bold tracking-tight text-[#4a3628]">Pesanan Terbaru</h2>
        <button
          class="rounded-xl border border-[#d8c3af] bg-white px-4 py-2 text-sm font-bold text-[#5c4432] shadow-sm transition hover:bg-[#f3ecdf]"
          onclick="goPage('pesanan')">Lihat Semua</button>
      </div>
      <div class="flex-1 overflow-x-auto bg-white">
        <table class="w-full text-sm text-[#5c4432]">
          <thead class="bg-white text-xs font-bold uppercase tracking-wider text-[#8b7868]">
            <tr>
              <th class="px-6 py-4">ID</th>
              <th class="px-6 py-4">Nama</th>
              <th class="px-6 py-4">Produk</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4 text-right">Total</th>
            </tr>
          </thead>
          <tbody id="dash-orders-tbody" class="divide-y divide-[#f0e8df] bg-white"></tbody>
        </table>
      </div>
      <!-- Bottom Pagination Row (Dashboard) -->
      <div class="pagi-row border-t border-[#f0e8df]">
        <span id="dash-pagi-info"><span class="font-bold text-[#5c4432]">1 - 5</span> dari <span
            class="font-bold text-[#5c4432]">5</span></span>
        <div class="pagi-btns">
          <button class="pagi-btn" disabled>&lt;</button>
          <button class="pagi-btn active">1</button>
          <button class="pagi-btn" disabled>&gt;</button>
        </div>
      </div>
    </div>

    <div
      class="lg:col-span-1 flex flex-col overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="border-b border-[#f0e8df] px-6 py-5">
        <h2 class="text-xl font-bold tracking-tight text-[#4a3628]">Statistik Penjualan</h2>
      </div>
      <div class="flex flex-1 flex-col items-center justify-center p-6 bg-white">
        <!-- Circular progress -->
        <div class="relative mb-8 h-48 w-48">
          <svg class="h-full w-full -rotate-90 transform drop-shadow-sm" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#f0e8df" stroke-width="12" />
            <circle id="dash-progress-circle" cx="50" cy="50" r="40" fill="transparent" stroke="#5c4432"
              stroke-width="12" stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round"
              class="transition-all duration-1000 ease-out" />
          </svg>
          <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span class="text-4xl font-black text-[#4a3628]" id="dash-progress-text">0</span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#8b7868] mt-1">Terjual</span>
          </div>
        </div>
        <div class="w-full space-y-5">
          <div>
            <div class="mb-1 flex items-center justify-between">
              <span class="text-sm font-medium text-[#8b7868]">Stok Tersedia</span>
              <span class="text-sm font-black text-[#4a3628]" id="dash-stat-stok">0</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-[#f0e8df]">
              <div id="dash-bar-stok" class="h-full rounded-full bg-[#d8c3af] transition-all duration-1000"
                style="width: 100%"></div>
            </div>
          </div>
          <div>
            <div class="mb-1 flex items-center justify-between">
              <span class="text-sm font-medium text-[#8b7868]">Barang Terjual</span>
              <span class="text-sm font-black text-[#4a3628]" id="dash-stat-terjual">0</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-[#f0e8df]">
              <div id="dash-bar-terjual" class="h-full rounded-full bg-[#5c4432] transition-all duration-1000"
                style="width: 0%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>