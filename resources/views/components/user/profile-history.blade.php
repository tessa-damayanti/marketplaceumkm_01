@php
    // Badge mapping: status_pembayaran → class CSS
    $badgeMap = [
        'pending'    => ['bg' => 'bg-[#fff1bd]', 'text' => 'text-[#b45a00]'],
        'settlement' => ['bg' => 'bg-[#dcfce7]', 'text' => 'text-[#15803d]'],
        'cancel'     => ['bg' => 'bg-[#fee2e2]', 'text' => 'text-[#dc2626]'],
        'expire'     => ['bg' => 'bg-[#f3f4f6]', 'text' => 'text-[#6b7280]'],
    ];
@endphp

<div id="tab-riwayat" class="block">
    <h2 class="mb-6 text-3xl font-bold text-[#5c4432]">
        Riwayat Pembelian
    </h2>

    <!-- Tab Status Berdasarkan Permintaan User -->
    <div class="mb-6">
        <div class="flex w-full gap-1">
            <button onclick="window.location.href='?tab=riwayat&status=all'" id="btn-subtab-all" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-200 {{ $status === 'all' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C]' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Semua
            </button>
            <button onclick="window.location.href='?tab=riwayat&status=pending'" id="btn-subtab-pending" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-200 {{ $status === 'pending' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C]' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Menunggu Pembayaran
            </button>
            <button onclick="window.location.href='?tab=riwayat&status=settlement'" id="btn-subtab-settlement" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-200 {{ $status === 'settlement' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C]' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Berhasil
            </button>
            <button onclick="window.location.href='?tab=riwayat&status=cancel'" id="btn-subtab-cancel" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-200 {{ $status === 'cancel' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C]' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Dibatalkan
            </button>
            <button onclick="window.location.href='?tab=riwayat&status=expire'" id="btn-subtab-expire" class="subtab-btn flex-1 rounded-lg border py-2 text-xs transition-all duration-200 {{ $status === 'expire' ? 'font-bold bg-[#e8ded3] text-[#5c4432] border-[#BFA28C]' : 'font-medium bg-transparent text-[#8b6f58] border-[#e8ded3]' }}">
                Pembayaran Kadaluwarsa
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-[18px] bg-white shadow-[0_6px_22px_rgba(92,68,50,0.08)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left">
                <thead>
                <tr class="border-b border-[#eee5dc] bg-[#fcfaf8] text-sm font-bold text-[#5c4432]">
                    <th class="px-6 py-5 whitespace-nowrap">ID. Pesanan</th>
                    <th class="px-6 py-5 whitespace-nowrap">Produk</th>
                    @if ($status === 'all')
                    <th class="px-6 py-5 text-center whitespace-nowrap col-status">Status Pembayaran</th>
                    @endif
                    <th class="px-6 py-5 whitespace-nowrap">Total</th>
                    <th class="px-6 py-5 text-center whitespace-nowrap">Aksi</th>
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
                            <td class="px-6 py-6 font-bold whitespace-nowrap">{{ $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT) }}</td>

                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-[#fcfaf8]">
                                        <img src="{{ $firstImg }}" alt="{{ $firstName }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-base font-bold text-[#5c4432]">{{ $firstName }}</p>
                                        @if ($extraCount > 0)
                                            <p class="mt-1 text-sm text-[#7b6858]">+{{ $extraCount }} produk lainnya</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            @if ($status === 'all')
                            <td class="px-6 py-6 text-center col-status">
                                <span class="inline-flex whitespace-nowrap rounded-full {{ $badge['bg'] }} px-5 py-2 text-sm font-semibold {{ $badge['text'] }}">
                                    {{ $pesanan->status_label }}
                                </span>
                            </td>
                            @endif

                            <td class="px-6 py-6 text-base font-bold whitespace-nowrap text-[#5c4432]">
                                Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-6">
                                <div class="flex justify-center">
                                    <button
                                        data-order-id="{{ $pesanan->id }}"
                                        onclick="openOrderDetail(this.dataset.orderId)"
                                        class="whitespace-nowrap rounded-xl border-0 bg-[#BFA28C] px-4 py-2 text-sm font-semibold text-white transition-all hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)]">
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
        @if ($pesanans->hasPages())
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
                        <a href="{{ $pesanans->previousPageUrl() }}" class="flex h-7 w-7 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-colors hover:bg-[#fbf8f5] hover:text-[#BFA28C]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6" /></svg>
                        </a>
                    @endif

                    {{-- Halaman Saat Ini (Hanya menampilkan 1 kotak aktif) --}}
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#BFA28C] text-xs font-bold text-white shadow-sm">
                        {{ $pesanans->currentPage() }}
                    </span>

                    {{-- Tombol Next --}}
                    @if ($pesanans->hasMorePages())
                        <a href="{{ $pesanans->nextPageUrl() }}" class="flex h-7 w-7 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-colors hover:bg-[#fbf8f5] hover:text-[#BFA28C]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6" /></svg>
                        </a>
                    @else
                        <span class="flex h-7 w-7 cursor-not-allowed items-center justify-center rounded-lg border border-[#f0e7dd] text-[#d8c3af]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l6 6-6 6" /></svg>
                        </span>
                    @endif
                </div>
            </div>
        @elseif ($pesanans->count() > 0)
            <div class="flex items-center justify-between border-t border-[#f0e7dd] bg-white px-6 py-4">
                <span class="text-xs font-semibold text-[#9a8575]">
                    1 - {{ $pesanans->count() }} dari {{ $pesanans->count() }}
                </span>
            </div>
        @endif
    </div>
</div>