@extends('layouts.admin')

@section('title', 'Produk')
@section('page_title', 'Produk')

@section('content')
  <!-- page produk -->
  <div class="page active" id="page-produk">
    <div
      class="surface data-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
        <div class="flex min-w-0 flex-1 flex-wrap items-center gap-3">
          <div class="search-wrap">
            <input type="text" id="produk-search" onkeyup="renderProdukTable()" placeholder="Cari produk..."
              class="search-input">
          </div>
          <select id="produk-filter-kat" onchange="renderProdukTable()"
            class="min-h-[42px] min-w-[190px] rounded-xl border border-[#d8c3af] bg-white px-3 py-2 text-sm text-[#5c4432] outline-none focus:border-[#a78d78]">
            <option value="">Semua Kategori</option>
            <option>Gaun</option>
            <option>Kemeja</option>
            <option>Kardigan</option>
            <option>Rok</option>
          </select>
        </div>
        <button
          class="rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
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
      <div class="pagi-row border-t border-[#f0e7dd] bg-white px-6 py-4">
        <span id="produk-pagi-info" class="text-xs font-semibold text-[#9a8575]">1 - 8 dari 8</span>
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