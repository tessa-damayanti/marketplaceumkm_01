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
            <button onclick="filterHistoryTab('all')" id="btn-subtab-all" class="subtab-btn flex-1 rounded-lg border py-2 text-xs font-bold transition-all duration-200" style="background:#e8ded3; color:#5c4432; border-color:#BFA28C;">
                Semua
            </button>
            <button onclick="filterHistoryTab('pending')" id="btn-subtab-pending" class="subtab-btn flex-1 rounded-lg border py-2 text-xs font-medium transition-all duration-200" style="background:transparent; color:#8b6f58; border-color:#e8ded3;">
                Menunggu Pembayaran
            </button>
            <button onclick="filterHistoryTab('settlement')" id="btn-subtab-settlement" class="subtab-btn flex-1 rounded-lg border py-2 text-xs font-medium transition-all duration-200" style="background:transparent; color:#8b6f58; border-color:#e8ded3;">
                Pembayaran Berhasil
            </button>
            <button onclick="filterHistoryTab('cancel')" id="btn-subtab-cancel" class="subtab-btn flex-1 rounded-lg border py-2 text-xs font-medium transition-all duration-200" style="background:transparent; color:#8b6f58; border-color:#e8ded3;">
                Pembayaran Dibatalkan
            </button>
            <button onclick="filterHistoryTab('expire')" id="btn-subtab-expire" class="subtab-btn flex-1 rounded-lg border py-2 text-xs font-medium transition-all duration-200" style="background:transparent; color:#8b6f58; border-color:#e8ded3;">
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
                    <th class="px-6 py-5 text-center whitespace-nowrap col-status">Status Pembayaran</th>
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
                        <tr class="border-b border-[#eee5dc] order-row" data-status="{{ $pesanan->status_pembayaran }}">
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

                            <td class="px-6 py-6 text-center col-status">
                                <span class="inline-flex whitespace-nowrap rounded-full {{ $badge['bg'] }} px-5 py-2 text-sm font-semibold {{ $badge['text'] }}">
                                    {{ $pesanan->status_label }}
                                </span>
                            </td>

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
                        <td id="empty-history-cell" colspan="5" class="px-6 py-12 text-center text-[#8b7a6d]">
                            Belum ada riwayat pembelian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-[#eee5dc] px-6 py-4">
            <p class="text-xs text-[#8b6f58]">
                {{ $pesanans->count() }} pesanan
            </p>
        </div>
    </div>
</div>