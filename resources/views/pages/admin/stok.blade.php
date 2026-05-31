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
          <input type="text" id="stok-search" onkeyup="searchStok()" placeholder="Cari produk..."
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
      <x-admin.pagination infoId="stok-pagi-info" infoText="1 - 8 dari 8" />
    </div>
  </div>
@endsection