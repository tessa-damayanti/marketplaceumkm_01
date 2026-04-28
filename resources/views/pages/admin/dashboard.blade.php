@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<!-- page dashboard -->
<div class="page active" id="page-dashboard">
  <!-- 4 Top Cards -->
  <div class="mb-6 grid gap-4 lg:grid-cols-4">
    <!-- Card 1 -->
    <div class="relative rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.06)] transition-all hover:shadow-[0_15px_35px_rgba(92,68,50,0.1)]">
      <div class="flex items-start justify-between">
        <div>
          <div class="mb-1 text-[11px] font-bold uppercase tracking-[0.1em] text-[#9a8575]">Total Pesanan</div>
          <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" id="s-pesanan">6</div>
          <div class="text-[13px] font-medium text-[#7b6858]">Pesanan masuk</div>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3ecdf] text-[#5c4432]">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="relative rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.06)] transition-all hover:shadow-[0_15px_35px_rgba(92,68,50,0.1)]">
      <div class="flex items-start justify-between">
        <div>
          <div class="mb-1 text-[11px] font-bold uppercase tracking-[0.1em] text-[#9a8575]">Total Produk</div>
          <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" id="s-produk">8</div>
          <div class="text-[13px] font-medium text-[#7b6858]">Katalog Produk</div>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3ecdf] text-[#5c4432]">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        </div>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="relative rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.06)] transition-all hover:shadow-[0_15px_35px_rgba(92,68,50,0.1)]">
      <div class="flex items-start justify-between">
        <div>
          <div class="mb-1 text-[11px] font-bold uppercase tracking-[0.1em] text-[#9a8575]">Total Kategori</div>
          <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" id="s-kategori">4</div>
          <div class="text-[13px] font-medium text-[#7b6858]">Kategori Aktif</div>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3ecdf] text-[#5c4432]">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        </div>
      </div>
    </div>
    <!-- Card 4 -->
    <div class="relative rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.06)] transition-all hover:shadow-[0_15px_35px_rgba(92,68,50,0.1)]">
      <div class="flex items-start justify-between">
        <div>
          <div class="mb-1 text-[11px] font-bold uppercase tracking-[0.1em] text-[#9a8575]">Produk Terjual</div>
          <div class="mb-1 text-4xl font-extrabold text-[#5c4432]">6</div>
          <div class="text-[13px] font-medium text-[#7b6858]">6 dari 123 items</div>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e5f0e1] text-[#4a6341]">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Main Table Section (Left) -->
    <div class="lg:col-span-2">
      <div class="surface data-surface h-full overflow-hidden rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.06)]">
        <div class="flex items-center justify-between px-6 py-5">
          <div class="text-xl font-bold tracking-tight text-[#5c4432]">Pesanan Terbaru</div>
          <button class="rounded-xl border border-[#d8c3af] bg-[#fbf7f2] px-4 py-1.5 text-xs font-bold text-[#5c4432] transition hover:bg-[#f3ecdf]" onclick="location.href='{{ route('admin.pesanan') }}'">Lihat Semua</button>
        </div>
        <div class="tbl-wrap">
          <table class="w-full">
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
        <div class="pagi-row border-t border-[#f0e7dd] bg-transparent px-6 py-4">
          <span class="text-xs font-semibold text-[#9a8575]" id="dash-pagi-info">1 - 5 dari 6</span>
          <div class="pagi-btns">
            <button class="pagi-btn"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="pagi-btn active">1</button>
            <button class="pagi-btn"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6"/></svg></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section (Right) -->
    <div class="lg:col-span-1">
      <div class="flex h-full flex-col rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] p-6 shadow-[0_12px_28px_rgba(92,68,50,0.06)]">
        <div class="mb-6 text-xl font-bold tracking-tight text-[#5c4432]">Statistik Penjualan</div>
        
        <div class="relative flex flex-1 flex-col items-center justify-center py-4">
          <div class="relative flex items-center justify-center">
            <!-- Circular Chart -->
            <svg class="h-44 w-44 transform -rotate-90">
              <circle cx="88" cy="88" r="76" stroke="#f0e7dd" stroke-width="14" fill="transparent" />
              <circle cx="88" cy="88" r="76" stroke="#5c4432" stroke-width="14" fill="transparent" stroke-dasharray="477" stroke-dashoffset="430" stroke-linecap="round" />
            </svg>
            <div class="absolute flex flex-col items-center">
              <span class="text-5xl font-extrabold text-[#5c4432]">6</span>
              <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#9a8575]">Terjual</span>
            </div>
          </div>
        </div>

        <div class="mt-auto space-y-6 pt-6">
          <div>
            <div class="mb-2 flex justify-between text-xs font-bold">
              <span class="text-[#7b6858]">Stok Tersedia</span>
              <span class="text-[#5c4432]">117</span>
            </div>
            <div class="h-2.5 w-full rounded-full bg-[#f0e7dd]">
              <div class="h-2.5 rounded-full bg-[#d8c3af]" style="width: 85%"></div>
            </div>
          </div>
          <div>
            <div class="mb-2 flex justify-between text-xs font-bold">
              <span class="text-[#7b6858]">Barang Terjual</span>
              <span class="text-[#5c4432]">6</span>
            </div>
            <div class="h-2.5 w-full rounded-full bg-[#f0e7dd]">
              <div class="h-2.5 rounded-full bg-[#5c4432]" style="width: 5%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection