@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page_title', 'Pesanan')

@section('content')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <div class="page active" id="page-pesanan">
    <div
      class="surface data-surface pesanan-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">

      <!-- Filter Row -->
      <div class="pesanan-filter-row flex flex-wrap items-center gap-3 px-5 py-4">

        <!-- Search -->
        <div class="search-wrap !w-56 !min-w-[14rem] !flex-[0_0_14rem]">
          <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input type="text" id="pesanan-search" onkeyup="renderPesananTable()" placeholder="Cari pesanan..."
            class="search-input" style="padding-left: 40px;">
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
              onclick="selectPesananStatusFilter('Menunggu Pembayaran')">Menunggu Pembayaran</li>
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Pembayaran Berhasil')">Pembayaran Berhasil</li>
            <li class="pesanan-status-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Pembayaran Dibatalkan')">Pembayaran Dibatalkan</li>
            <li class="pesanan-status-option cursor-pointer px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
              onclick="selectPesananStatusFilter('Pembayaran Kedaluwarsa')">Pembayaran Kedaluwarsa</li>
          </ul>
          <input type="hidden" id="pesanan-filter-status" value="">
        </div>

        <!-- Date -->
        <div class="flex w-full flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2 shrink-0 sm:gap-2 sm:w-auto sm:justify-start">
          <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-normal sm:tracking-wider text-[#a78d78] shrink-0 w-10 sm:w-auto">Dari</span>
            <div class="relative flex-1 min-w-0">
              <input type="text" id="pesanan-date-from" placeholder="yyyy-mm-dd" readonly
                class="h-10 w-full cursor-pointer rounded-[10px] border border-[#e0d2c3] bg-white px-1.5 pr-6 sm:px-2 sm:pr-7 text-[10px] sm:text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">
              <svg class="absolute right-1.5 sm:right-2 top-1/2 -translate-y-1/2 h-3.5 w-3.5 sm:h-5 sm:w-5 text-[#a78d78] pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>

          <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-normal sm:tracking-wider text-[#a78d78] shrink-0 w-10 sm:w-auto">Sampai</span>
            <div class="relative flex-1 min-w-0">
              <input type="text" id="pesanan-date-to" placeholder="yyyy-mm-dd" readonly
                class="h-10 w-full cursor-pointer rounded-[10px] border border-[#e0d2c3] bg-white px-1.5 pr-6 sm:px-2 sm:pr-7 text-[10px] sm:text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">
              <svg class="absolute right-1.5 sm:right-2 top-1/2 -translate-y-1/2 h-3.5 w-3.5 sm:h-5 sm:w-5 text-[#a78d78] pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel -->
      <div class="hidden md:block tbl-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="pesanan-tbody"></tbody>
        </table>
      </div>
      <div id="pesanan-cards" class="block md:hidden divide-y divide-[#eee5dc]"></div>

      <x-admin.pagination infoId="pesanan-pagi-info" infoText="1 - 8 dari 0" prevId="pesanan-pagi-prev" nextId="pesanan-pagi-next" prevFn="pesananPrevPage()" nextFn="pesananNextPage()" />

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#pesanan-date-from", {
            disableMobile: true,
            dateFormat: "Y-m-d",
            onChange: function() {
                if(typeof renderPesananTable === 'function') renderPesananTable();
            }
        });
        flatpickr("#pesanan-date-to", {
            disableMobile: true,
            dateFormat: "Y-m-d",
            onChange: function() {
                if(typeof renderPesananTable === 'function') renderPesananTable();
            }
        });
    });
  </script>
@endsection
