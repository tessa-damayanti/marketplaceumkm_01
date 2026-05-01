@extends('layouts.admin')

@section('title', 'Produk')
@section('page_title', 'Produk')

@section('content')
  <!-- page produk -->
  <div class="page active" id="page-produk">
    <div
      class="surface data-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="produk-header flex flex-wrap items-center justify-between gap-4 px-5 py-4">
        <div class="produk-filter-row flex min-w-0 flex-1 flex-wrap items-center gap-3">
          <div class="search-wrap">
            <input type="text" id="produk-search" onkeyup="renderProdukTable()" placeholder="Cari produk..."
              class="search-input">
          </div>
          <div class="produk-filter-select relative min-w-[190px]">
            <button type="button" id="produk-filter-kat-btn" onclick="toggleProdukKategoriFilter(event)"
              class="flex min-h-[42px] w-full items-center justify-between gap-3 rounded-xl border border-[#d8c3af] bg-white px-3 py-2 text-left text-sm text-[#5c4432] outline-none transition hover:border-[#a78d78]">
              <span id="produk-filter-kat-label">Semua Kategori</span>
              <svg id="produk-filter-kat-icon" width="12" height="8" viewBox="0 0 14 8" fill="none"
                class="shrink-0 transition-transform duration-200">
                <path d="M2 2l5 4 5-4" stroke="#5c4432" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
            <ul id="produk-filter-kat-menu"
              class="produk-filter-menu absolute left-0 top-[calc(100%+6px)] z-[80] hidden w-full overflow-hidden rounded-xl border border-[#d8c3af] bg-white shadow-xl">
              <li class="produk-kategori-option cursor-pointer border-b border-[#f0e7dd] bg-[#fbf8f5] px-4 py-2.5 text-sm font-medium text-[#BFA28C] transition-colors hover:bg-[#BFA28C] hover:text-white"
                onclick="selectProdukKategoriFilter('')">Semua Kategori</li>
              <li class="produk-kategori-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
                onclick="selectProdukKategoriFilter('Gaun')">Gaun</li>
              <li class="produk-kategori-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
                onclick="selectProdukKategoriFilter('Kemeja')">Kemeja</li>
              <li class="produk-kategori-option cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
                onclick="selectProdukKategoriFilter('Kardigan')">Kardigan</li>
              <li class="produk-kategori-option cursor-pointer px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
                onclick="selectProdukKategoriFilter('Rok')">Rok</li>
            </ul>
            <input type="hidden" id="produk-filter-kat" value="">
          </div>
        </div>
        <button
          class="produk-add-btn rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
          onclick="openModal('modal-tambah-produk'); setModalMode('add')">+ Tambah Produk</button>
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
      <x-admin.pagination infoId="produk-pagi-info" infoText="1 - 8 dari 8" />
    </div>
  </div>
@endsection
