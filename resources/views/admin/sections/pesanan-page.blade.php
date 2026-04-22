<div class="page" id="page-pesanan">
 <div class="surface data-surface rounded-xl border border-[#e2d4c5] bg-[#fffaf5] shadow-[0_12px_28px_rgba(92,68,50,0.08)]">

    {{-- Filter Row --}}
    <div class="flex flex-wrap items-center gap-3 px-5 py-4">

      {{-- Dropdown Status --}}
      <select
        id="pesanan-filter-status"
        onchange="renderPesananTable()"
        class="h-10 rounded-[10px] border border-[#e0d2c3] bg-[#fbf7f2] px-3 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">
        <option value="">Semua Status</option>
        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
        <option value="Pembayaran Valid">Pembayaran Valid</option>
        <option value="Pembayaran Ditolak">Pembayaran Ditolak</option>
        <option value="Menunggu Konfirmasi">Konfirmasi Ulang</option>
      </select>

      {{-- Dari --}}
      <span class="text-xs font-semibold uppercase tracking-wide text-[#a78d78]">Dari</span>
      <input
        type="date"
        id="pesanan-date-from"
        onchange="renderPesananTable()"
        class="h-10 rounded-[10px] border border-[#e0d2c3] bg-[#fbf7f2] px-3 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">

      {{-- Sampai --}}
      <span class="text-xs font-semibold uppercase tracking-wide text-[#a78d78]">Sampai</span>
      <input
        type="date"
        id="pesanan-date-to"
        onchange="renderPesananTable()"
        class="h-10 rounded-[10px] border border-[#e0d2c3] bg-[#fbf7f2] px-3 text-sm text-[#5c4432] focus:outline-none focus:ring-2 focus:ring-[#a78d78]/20 focus:border-[#a78d78] transition">

    </div>

    {{-- Tabel --}}
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Tanggal Pemesanan</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="pesanan-tbody"></tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="pagi-row">
      <span id="pesanan-pagi-info">1 - 6 dari 6</span>
      <div class="pagi-btns">
        <button class="pagi-btn">&lt;</button>
        <button class="pagi-btn active">1</button>
        <button class="pagi-btn">&gt;</button>
      </div>
    </div>

  </div>
</div>