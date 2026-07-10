@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<!-- page dashboard -->
<div class="page active" id="page-dashboard">

  <!-- 4 Top Cards -->
  <div class="mb-6 grid grid-cols-2 gap-3 md:gap-4 lg:grid-cols-4">

    <!-- Card 1 -->
    <x-admin.metric-card title="Total Pesanan" valueId="s-pesanan" value="14" subtitle="Pesanan masuk">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
        <polyline points="14 2 14 8 20 8" />
        <line x1="16" y1="13" x2="8" y2="13" />
        <line x1="16" y1="17" x2="8" y2="17" />
        <polyline points="10 9 9 9 8 9" />
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
    <x-admin.metric-card title="Total Pendapatan" valueId="s-income" value="Rp0" subtitle="Bulan Ini" subtitleId="s-income-sub" iconBgColor="bg-[#e5f0e1]" iconTextColor="text-[#4a6341]">
    </x-admin.metric-card>
  </div>

  <!-- Filter Bar (antara card dan statistik) -->
  <div class="mb-4 flex items-center justify-end gap-3">
    <span class="text-sm font-bold text-[#5c4432]">Pendapatan:</span>
    <div class="relative min-w-[180px]">
      <button type="button" id="income-filter-btn" onclick="toggleIncomeFilter(event)"
        class="flex min-h-[42px] w-full items-center justify-between gap-3 rounded-xl border border-[#d8c3af] bg-white px-3 py-2 text-left text-sm text-[#5c4432] outline-none transition hover:border-[#a78d78]">
        <span id="income-filter-label">Bulan Ini</span>
        <svg id="income-filter-icon" width="12" height="8" viewBox="0 0 14 8" fill="none"
          class="shrink-0 transition-transform duration-200">
          <path d="M2 2l5 4 5-4" stroke="#5c4432" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </button>
      <ul id="income-filter-menu"
        class="absolute left-0 top-[calc(100%+6px)] z-[80] hidden w-full overflow-hidden rounded-xl border border-[#d8c3af] bg-white shadow-xl">
        <li class="cursor-pointer border-b border-[#f0e7dd] bg-[#fbf8f5] px-4 py-2.5 text-sm font-medium text-[#BFA28C] transition-colors hover:bg-[#BFA28C] hover:text-white"
          onclick="selectIncomeFilter('this_month', 'Bulan Ini')">Bulan Ini</li>
        <li class="cursor-pointer border-b border-[#f0e7dd] px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
          onclick="selectIncomeFilter('last_month', 'Bulan Lalu')">Bulan Lalu</li>
        <li class="cursor-pointer px-4 py-2.5 text-sm font-medium text-[#5c4432] transition-colors hover:bg-[#BFA28C] hover:text-white"
          onclick="selectIncomeFilter('all_time', 'Semua Waktu')">Semua Waktu</li>
      </ul>
      <input type="hidden" id="income-filter" value="this_month">
    </div>
  </div>

  <div class="flex flex-col gap-8">

    <!-- Section Statistik -->
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

    <!-- Table Section -->
    <div class="w-full">
      <div class="flex flex-col overflow-hidden rounded-2xl border border-[#e2d4c5] bg-white shadow-[0_12px_28px_rgba(92,68,50,0.06)]">
        <div class="flex items-center justify-between px-6 py-5">
          <div class="text-xl font-bold tracking-tight text-[#5c4432]">Pesanan Terbaru</div>
          <a href="{{ route('admin.pesanan') }}"
            class="rounded-xl border border-[#d8c3af] bg-[#fbf7f2] px-4 py-1.5 text-xs font-bold text-[#5c4432] transition hover:bg-[#f3ecdf]">
            Lihat Semua
          </a>
        </div>
        <div class="hidden md:block tbl-wrap">
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
        <div id="dash-orders-cards" class="block md:hidden divide-y divide-[#eee5dc]"></div>
      </div>
    </div>

  </div>
</div>
@endsection