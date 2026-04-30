@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page_title', 'Pesanan')

@section('content')
  <div class="page active" id="page-pesanan">
    <div
      class="surface data-surface pesanan-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">

      <!-- Filter Row -->
      <div class="flex flex-nowrap items-center gap-3 overflow-x-auto px-5 py-4 scrollbar-hide">
  
        <!-- Search -->
        <div class="search-wrap !w-56 !min-w-[14rem] !flex-[0_0_14rem]">
          <input type="text" id="pesanan-search" onkeyup="renderPesananTable()" placeholder="Cari pesanan..."
            class="search-input">
        </div>

        <!-- Dropdown Status -->
        <select id="pesanan-filter-status" onchange="renderPesananTable()"
          class="h-10 min-w-[140px] flex-shrink-0 cursor-pointer rounded-[10px] border border-[#e0d2c3] bg-white px-3 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">
          <option value="">Semua Status</option>
          <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
          <option value="Pembayaran Valid">Pembayaran Valid</option>
          <option value="Pembayaran Ditolak">Pembayaran Ditolak</option>
          <option value="Konfirmasi Ulang">Konfirmasi Ulang</option>
        </select>

        <!-- Date --> 
        <div class="flex flex-shrink-0 items-center gap-2">
          <span class="text-[10px] font-bold uppercase tracking-wider text-[#a78d78]">Dari</span>
          <input type="date" id="pesanan-date-from" onchange="renderPesananTable()"
            class="h-10 rounded-[10px] border border-[#e0d2c3] bg-white px-2 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">

          <span class="text-[10px] font-bold uppercase tracking-wider text-[#a78d78]">Sampai</span>
          <input type="date" id="pesanan-date-to" onchange="renderPesananTable()"
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
      
      <div class="pagi-row border-t border-[#f0e7dd] bg-white px-6 py-4">
        <span id="pesanan-pagi-info" class="text-xs font-semibold text-[#9a8575]">1 - 6 dari 6</span>
        <div class="pagi-btns">
          <button class="pagi-btn">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M15 18l-6-6 6-6" />
            </svg>
          </button>
          <button class="pagi-btn active">1</button>
          <button class="pagi-btn">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5l6 6-6 6" />
            </svg>
          </button>
        </div>
      </div>

    </div>
  </div>
@endsection