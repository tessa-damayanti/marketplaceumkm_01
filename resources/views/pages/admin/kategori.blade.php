@extends('layouts.admin')

@section('title', 'Kategori')
@section('page_title', 'Kategori')

@section('content')

  <!-- page kategori -->
  <div class="page active" id="page-kategori">
    <div
      class="surface data-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="kategori-header flex flex-wrap items-center justify-between gap-4 px-5 py-4">
        <div class="kategori-filter-row search-wrap">
          <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input type="text" id="kat-search" onkeyup="searchKategori()" placeholder="Cari kategori..."
            class="search-input" style="padding-left: 40px;">
        </div>
        <button
          class="kategori-add-btn rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
          onclick="openModal('modal-tambah-kat'); setKatModalMode('add')">+ Tambah Kategori</button>
      </div>
      <div class="tbl-wrap">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="kategori-tbody"></tbody>
        </table>
      </div>
      <x-admin.pagination infoId="kat-pagi-info" infoText="1 - 4 dari 4" />
    </div>
  </div>
@endsection
