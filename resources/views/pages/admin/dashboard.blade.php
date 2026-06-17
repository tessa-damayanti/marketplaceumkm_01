@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

  <!-- page dashboard -->
  <div class="page active" id="page-dashboard">

    <!-- 4 Top Cards -->
    <div class="mb-6 grid gap-4 lg:grid-cols-4">

      <!-- Card 1 -->
      <x-admin.metric-card title="Total Pesanan" valueId="s-pesanan" value="6" subtitle="Pesanan masuk">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
          <polyline points="14 2 14 8 20 8" />
        </svg>
      </x-admin.metric-card>

      <!-- Card 2 -->
      <x-admin.metric-card title="Total Produk" valueId="s-produk" value="8" subtitle="Katalog Produk">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path
            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
        </svg>
      </x-admin.metric-card>

      <!-- Card 3 -->
      <x-admin.metric-card title="Total Kategori" valueId="s-kategori" value="4" subtitle="Kategori Aktif">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7" />
          <rect x="14" y="3" width="7" height="7" />
          <rect x="3" y="14" width="7" height="7" />
          <rect x="14" y="14" width="7" height="7" />
        </svg>
      </x-admin.metric-card>

      <!-- Card 4 -->
      <x-admin.metric-card title="Produk Terjual" value="6" subtitle="6 dari 123 items" iconBgColor="bg-[#e5f0e1]" iconTextColor="text-[#4a6341]">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
          <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
          <polyline points="17 6 23 6 23 12" />
        </svg>
      </x-admin.metric-card>
    </div>

    <div class="flex flex-col gap-8">

      <!-- Section Statistik (Atas) -->
      <div class="w-full">
        <div class="flex flex-col overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.06)]">
          <!-- Header -->
          <div class="border-b border-[#e2d4c5] bg-[#f0e7dd] px-6 py-4">
            <h2 class="text-lg font-extrabold tracking-tight text-[#5c4432]">Statistik Penjualan</h2>
          </div>
          <div class="flex flex-col p-6">
            <div class="relative w-full flex flex-col justify-center min-h-[300px]">
              <canvas id="salesChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section (Bawah) -->
      <div class="w-full">
        <div class="flex flex-col overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.06)]">
          <div class="flex items-center justify-between px-6 py-5">
            <div class="text-xl font-bold tracking-tight text-[#5c4432]">Pesanan Terbaru</div>
            <a href="{{ route('admin.pesanan') }}"
              class="rounded-xl border border-[#d8c3af] bg-[#fbf7f2] px-4 py-1.5 text-xs font-bold text-[#5c4432] transition hover:bg-[#f3ecdf]">
              Lihat Semua
            </a>
          </div>
          <div class="tbl-wrap">
            <table class="w-full">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="dash-orders-tbody"></tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
