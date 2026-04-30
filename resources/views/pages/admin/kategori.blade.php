@extends('layouts.admin')

@section('title', 'Kategori')
@section('page_title', 'Kategori')

@section('content')

  <!-- page kategori -->
  <div class="page active" id="page-kategori">
    <div
      class="surface data-surface overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
      <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
        <div class="search-wrap">
          <input type="text" id="kat-search" onkeyup="renderKategoriTable()" placeholder="Cari kategori..."
            class="search-input">
        </div>
        <button
          class="rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]"
          onclick="openModal('modal-tambah-kat'); setKatModalMode('add')">+ Tambah Kategori</button>
      </div>
      <div class="tbl-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="kategori-tbody"></tbody>
        </table>
      </div>
      <div class="pagi-row border-t border-[#f0e7dd] bg-white px-6 py-4">
        <span id="kat-pagi-info" class="text-xs font-semibold text-[#9a8575]">1 - 4 dari 4</span>
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