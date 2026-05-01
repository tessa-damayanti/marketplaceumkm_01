@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page_title', 'Pesanan')

@section('content')
  <div class="page active" id="page-pesanan">
    <div
      class="surface data-surface pesanan-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">

      <!-- Filter Row -->
      <div class="pesanan-filter-row flex flex-wrap items-center gap-3 px-5 py-4">

        <!-- Search -->
        <div class="search-wrap !w-56 !min-w-[14rem] !flex-[0_0_14rem]">
          <input type="text" id="pesanan-search" onkeyup="renderPesananTable()" placeholder="Cari pesanan..."
            class="search-input">
        </div>

        <!-- Dropdown Status -->
        <div class="pesanan-status-filter relative min-w-[190px] flex-shrink-0">
          <button type="button" id="pesanan-status-filter-btn" onclick="togglePesananStatusFilter(event)"
            class="flex min-h-[42px] w-full items-center justify-between gap-3 rounded-xl border border-[#d8c3af] bg-white px-3 py-2 text-left text-sm text-[#5c4432] outline-none transition hover:border-[#a78d78]">
            <span id="pesanan-status-filter-label">Semua Status</span>
            <svg id="pesanan-status-filter-icon" width="12" height="8" viewBox="0 0 14 8" fill="none"
              class="shrink-0 transition-transform duration-200">
              <path d="M2 2l5 4 5-4" stroke="#5c4432" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </button>
          <ul id="pesanan-status-filter-menu"
            class="pesanan-status-filter-menu absolute left-0 top-[calc(100%+6px)] z-[80] hidden w-full overflow-hidden rounded-xl border border-[#d8c3af] bg-white shadow-xl">
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] bg-[#fbf8f5] px-4 py-2.5 text-sm font-medium text-[#BFA28C] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('')">Semua Status</li>
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Menunggu Verifikasi')">Menunggu Verifikasi</li>
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Pembayaran Valid')">Pembayaran Valid</li>
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Pembayaran Ditolak')">Pembayaran Ditolak</li>
            <li class="pesanan-status-option cursor-pointer px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Konfirmasi Ulang')">Konfirmasi Ulang</li>
          </ul>
          <input type="hidden" id="pesanan-filter-status" value="">
        </div>

        <!-- Date -->
        <div class="pesanan-date-filter flex flex-shrink-0 items-center gap-2">
          <span class="text-[10px] font-bold uppercase tracking-wider text-[#a78d78]">Dari</span>
          <input type="date" id="pesanan-date-from" oninput="renderPesananTable()" onchange="renderPesananTable()"
            class="h-10 rounded-[10px] border border-[#e0d2c3] bg-white px-2 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">

          <span class="text-[10px] font-bold uppercase tracking-wider text-[#a78d78]">Sampai</span>
          <input type="date" id="pesanan-date-to" oninput="renderPesananTable()" onchange="renderPesananTable()"
            class="h-10 rounded-[10px] border border-[#e0d2c3] bg-white px-2 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">
        </div>
      </div>

      <!-- Tabel -->
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

      <x-admin.pagination infoId="pesanan-pagi-info" infoText="1 - 6 dari 6" />

    </div>
  </div>
@endsection
