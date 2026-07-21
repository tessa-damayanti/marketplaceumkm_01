@extends('layouts.admin')

@section('title', 'Stok Produk')
@section('page_title', 'Stok Produk')

@section('content')

  <!-- page stok produk -->
  <div class="page active" id="page-stok">
    <div
      class="surface data-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="flex flex-wrap items-center gap-4 px-5 py-4">
        <div class="search-wrap">
          <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input type="text" id="stok-search" onkeyup="searchStok()" placeholder="Cari produk..."
            class="search-input" style="padding-left: 40px;">
        </div>
      </div>
      <div class="hidden md:block tbl-wrap">
        <table>
          <thead>
            <tr class="bg-[#f3ecdf]">
              <th>Produk</th>
              <th>S</th>
              <th>M</th>
              <th>L</th>
              <th>XL</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="stok-tbody"></tbody>
        </table>
      </div>
      <div id="stok-cards" class="block md:hidden divide-y divide-[#eee5dc]"></div>
      <x-admin.pagination infoId="stok-pagi-info" infoText="1 - 8 dari 8" />
    </div>
  </div>
@endsection