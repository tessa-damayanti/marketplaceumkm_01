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
          <input type="text" id="stok-search" onkeyup="renderStokTable()" placeholder="Cari produk..."
            class="search-input">
        </div>
      </div>
      <div class="tbl-wrap">
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
      <div class="pagi-row border-t border-[#f0e7dd] bg-white px-6 py-4">
        <span id="stok-pagi-info" class="text-xs font-semibold text-[#9a8575]">1 - 8 dari 8</span>
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