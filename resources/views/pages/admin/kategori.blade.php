@extends('layouts.admin')

@section('title', 'Kategori')
@section('page_title', 'Kategori')

@section('content')
<!-- page kategori -->
<div class="page active" id="page-kategori">
  <div class="surface data-surface overflow-hidden rounded-xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.08)]">
    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
      <div class="search-wrap">
        <input type="text" id="kat-search" onkeyup="renderKategoriTable()" placeholder="Cari kategori..." class="search-input">
      </div>
      <button class="rounded-xl border border-[#a78d78] bg-[#a78d78] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f7561]" onclick="openModal('modal-tambah-kat'); setKatModalMode('add')">+ Tambah Kategori</button>
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
  </div>
</div>
@endsection
