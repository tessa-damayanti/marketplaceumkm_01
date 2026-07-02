@php
    // Badge mapping: status_pembayaran → class CSS
    $badgeMap = [
        'pending'    => ['bg' => 'bg-[#fff1bd]', 'text' => 'text-[#b45a00]'],
        'settlement' => ['bg' => 'bg-[#dcfce7]', 'text' => 'text-[#15803d]'],
        'cancel'     => ['bg' => 'bg-[#fee2e2]', 'text' => 'text-[#dc2626]'],
        'expire'     => ['bg' => 'bg-[#f3f4f6]', 'text' => 'text-[#6b7280]'],
    ];
@endphp

@php
    $activeTab = request()->query('tab');
    if (!in_array($activeTab, ['akun', 'riwayat', 'password'])) {
        $activeTab = (request()->query('page') || request()->query('status')) ? 'riwayat' : 'akun';
    }
@endphp
<div id="tab-riwayat" class="{{ $activeTab === 'riwayat' ? 'block' : 'hidden' }}">
    <h2 class="mb-6 text-3xl font-bold text-[#5c4432]">
        Riwayat Pembelian
    </h2>

    <!-- Tab Status Berdasarkan Permintaan User -->
    <div class="mb-6">
        <div class="flex w-full gap-1">
            <button onclick="loadHistory('?tab=riwayat&status=all')" id="btn-subtab-all" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-300 ease-in-out hover:scale-[1.02] active:scale-[0.98] {{ $status === 'all' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C] shadow-sm' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Semua
            </button>
            <button onclick="loadHistory('?tab=riwayat&status=pending')" id="btn-subtab-pending" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-300 ease-in-out hover:scale-[1.02] active:scale-[0.98] {{ $status === 'pending' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C] shadow-sm' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Menunggu Pembayaran
            </button>
            <button onclick="loadHistory('?tab=riwayat&status=settlement')" id="btn-subtab-settlement" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-300 ease-in-out hover:scale-[1.02] active:scale-[0.98] {{ $status === 'settlement' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C] shadow-sm' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Berhasil
            </button>
            <button onclick="loadHistory('?tab=riwayat&status=cancel')" id="btn-subtab-cancel" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-300 ease-in-out hover:scale-[1.02] active:scale-[0.98] {{ $status === 'cancel' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C] shadow-sm' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Dibatalkan
            </button>
            <button onclick="loadHistory('?tab=riwayat&status=expire')" id="btn-subtab-expire" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-300 ease-in-out hover:scale-[1.02] active:scale-[0.98] {{ $status === 'expire' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C] shadow-sm' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Kadaluwarsa
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-[18px] bg-white shadow-[0_6px_22px_rgba(92,68,50,0.08)]">
        <div class="overflow-x-auto">
            @if ($status === 'all')
            <table class="w-full text-left">
            @else
            <table class="w-full min-w-[800px] table-fixed text-left">
            @endif
                <thead>
                <tr class="border-b border-[#eee5dc] bg-[#fcfaf8] text-sm font-bold text-[#5c4432]">
                    @if ($status === 'all')
                        <th class="px-4 py-4 whitespace-nowrap">ID. Pesanan</th>
                        <th class="px-4 py-4 whitespace-nowrap">Produk</th>
                        <th class="px-4 py-4 text-center whitespace-nowrap col-status">Status Pembayaran</th>
                        <th class="px-4 py-4 whitespace-nowrap">Total</th>
                        <th class="px-4 py-4 text-center whitespace-nowrap">Aksi</th>
                    @else
                        <th class="w-[20%] px-4 py-4 whitespace-nowrap" style="width: 20%;">ID. Pesanan</th>
                        <th class="w-[50%] px-4 py-4 whitespace-nowrap" style="width: 50%;">Produk</th>
                        <th class="w-[18%] px-4 py-4 whitespace-nowrap" style="width: 18%;">Total</th>
                        <th class="w-[12%] px-4 py-4 text-center whitespace-nowrap" style="width: 12%;">Aksi</th>
                    @endif
                </tr>
                </thead>

                <tbody class="text-sm text-[#5c4432]">
                    @forelse ($pesanans as $pesanan)
                        @php
                            $badge   = $badgeMap[$pesanan->status_pembayaran] ?? ['bg' => 'bg-[#f3f4f6]', 'text' => 'text-[#6b7280]'];
                            $details = $pesanan->detailPesanans;
                            $first   = $details->first();
                            $extraCount = $details->count() - 1;

                            // Gambar produk pertama
                            $firstImg = 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg';
                            $firstName = '-';
                            if ($first && $first->stok && $first->stok->produk) {
                                $firstName = $first->stok->produk->nama;
                                if ($first->stok->produk->image) {
                                    $firstImg = asset('images/' . $first->stok->produk->image);
                                }
                            }
                        @endphp
                        <tr class="border-b border-[#eee5dc] order-row">
                            <td class="px-4 py-4 text-sm font-bold whitespace-nowrap">{{ $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT) }}</td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-[#fcfaf8]">
                                        <img src="{{ $firstImg }}" alt="{{ $firstName }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        @if ($status === 'all')
                                            <p class="text-sm font-bold text-[#5c4432]">{{ $firstName }}</p>
                                        @else
                                            <p class="text-sm font-bold text-[#5c4432] truncate">{{ $firstName }}</p>
                                        @endif
                                        @if ($extraCount > 0)
                                            <p class="mt-0.5 text-xs text-[#7b6858] whitespace-nowrap">+{{ $extraCount }} produk lainnya</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            @if ($status === 'all')
                            <td class="px-4 py-4 text-center col-status">
                                <span class="inline-flex whitespace-nowrap rounded-full {{ $badge['bg'] }} px-3 py-1.5 text-xs font-semibold {{ $badge['text'] }}">
                                    {{ $pesanan->status_label }}
                                </span>
                            </td>
                            @endif

                            <td class="px-4 py-4 text-sm font-bold whitespace-nowrap text-[#5c4432]">
                                Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex justify-center">
                                    <button
                                        data-order-id="{{ $pesanan->id }}"
                                        onclick="openOrderDetail(this.dataset.orderId)"
                                        class="whitespace-nowrap rounded-xl border-0 bg-[#BFA28C] px-3.5 py-1.5 text-xs font-semibold text-white transition-all duration-300 ease-in-out hover:bg-[#A88A72] hover:scale-[1.05] active:scale-[0.95] hover:shadow-[0_5px_14px_rgba(191,162,140,0.3)]">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Empty state handled below -->
                    @endforelse

                    <tr id="empty-history-row" class="{{ $pesanans->isEmpty() ? '' : 'hidden' }}">
                        <td id="empty-history-cell" colspan="{{ $status === 'all' ? 5 : 4 }}" class="px-6 py-12 text-center text-[#8b7a6d]">
                            Belum ada riwayat pembelian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($pesanans->count() > 0)
            <div class="flex items-center justify-between border-t border-[#f0e7dd] bg-white px-6 py-4">
                <span class="text-xs font-semibold text-[#9a8575]">
                    {{ $pesanans->firstItem() ?? 0 }} - {{ $pesanans->lastItem() ?? 0 }} dari {{ $pesanans->total() }}
                </span>
                <div class="flex items-center gap-1.5">
                    {{-- Tombol Prev --}}
                    @if ($pesanans->onFirstPage())
                        <span class="flex h-7 w-7 cursor-not-allowed items-center justify-center rounded-lg border border-[#f0e7dd] text-[#d8c3af]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
                        </span>
                    @else
                        <a href="javascript:void(0)" onclick="loadHistory('{{ $pesanans->previousPageUrl() }}&tab=riwayat&status={{ $status }}')" class="flex h-7 w-7 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-all duration-300 ease-in-out hover:bg-[#fbf8f5] hover:text-[#BFA28C] hover:scale-110 active:scale-90">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
                        </a>
                    @endif

                    {{-- Halaman Saat Ini (Hanya menampilkan 1 kotak aktif) --}}
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#BFA28C] text-xs font-bold text-white shadow-sm">
                        {{ $pesanans->currentPage() }}
                    </span>

                    {{-- Tombol Next --}}
                    @if ($pesanans->hasMorePages())
                        <a href="javascript:void(0)" onclick="loadHistory('{{ $pesanans->nextPageUrl() }}&tab=riwayat&status={{ $status }}')" class="flex h-7 w-7 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-all duration-300 ease-in-out hover:bg-[#fbf8f5] hover:text-[#BFA28C] hover:scale-110 active:scale-90">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6" /></svg>
                        </a>
                    @else
                        <span class="flex h-7 w-7 cursor-not-allowed items-center justify-center rounded-lg border border-[#f0e7dd] text-[#d8c3af]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6" /></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>