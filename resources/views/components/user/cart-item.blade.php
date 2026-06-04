@props(['item', 'itemKey'])

<div class="mb-4 rounded-[20px] bg-[#f4ede5] px-3 sm:px-4 py-4 sm:py-5 last:mb-0">
    <div class="flex flex-col gap-4">

        <!-- Checkbox, Gambar, Info -->
        <div class="flex items-start gap-3 sm:gap-4">

            <div class="pt-1">
                <input
                    type="checkbox"
                    id="check-{{ $itemKey }}"
                    class="item-check w-4 h-4 rounded border-[#c4ab96] bg-white text-[#BFA28C] focus:ring-[#BFA28C] focus:ring-2"
                    data-price="{{ $item['price'] }}"
                    data-qty="{{ $item['qty'] }}"
                    data-key="{{ $itemKey }}">
            </div>

            <!-- Gambar -->
            <a href="{{ route('product') }}?show={{ urlencode($item['name']) }}" class="flex-shrink-0 hover:opacity-90 transition">
                <img
                    src="{{ $item['image'] }}"
                    alt="{{ $item['name'] }}"
                    class="h-[72px] w-[72px] sm:h-[82px] sm:w-[82px] rounded-[14px] object-cover">
            </a>

            <!-- Info Produk -->
            <div class="min-w-0 flex-1">
                <h2 class="text-sm sm:text-base font-semibold text-[#5c4432] leading-snug">
                    <a href="{{ route('product') }}?show={{ urlencode($item['name']) }}" class="hover:text-[#8f7561] transition">
                        {{ $item['name'] }}
                    </a>
                </h2>
                <p class="mt-1 text-xs text-[#7b6858]">
                    Ukuran : {{ $item['size'] }}
                </p>

                <p class="mt-1 sm:mt-2 text-sm sm:text-base font-semibold leading-none text-[#7a5a43]">
                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Kuantitas dan Hapus -->
        <div class="flex items-end justify-between pl-[calc(0.75rem+72px)] sm:pl-[calc(1rem+82px)]">
            
            <!-- Qty dan Warning Stack -->
            <div class="flex flex-col">
                <!-- Qty Counter -->
                <div class="flex items-center gap-3">
                    <!-- Tombol Kurang -->
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{ $itemKey }}">
                        <input type="hidden" name="action" value="minus">
                        <button
                            type="submit"
                            class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-[10px] bg-[#ded1c2] text-base font-bold text-[#6b5848] transition hover:bg-[#d2c2b0] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                            -
                        </button>
                    </form>

                    <span class="w-6 text-center text-sm font-semibold text-[#5c4432] qty-value">
                        {{ $item['qty'] }}
                    </span>

                    <!-- Tombol Tambah -->
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{ $itemKey }}">
                        <input type="hidden" name="action" value="plus">
                        <button
                            type="submit"
                            class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-[10px] bg-[#BFA28C] text-base font-bold text-white transition hover:bg-[#A88A72] focus:outline-none focus:ring-2 focus:ring-[#BFA28C]">
                            +
                        </button>
                    </form>
                </div>

                @if(session('limit_reached') == $itemKey)
                <p class="mt-1.5 text-[11px] sm:text-[12px] font-semibold text-red-400">
                    Pembelian mencapai batas stok maksimum!
                </p>
                @endif
            </div>

            <!-- Tombol Hapus -->
            <form action="{{ route('cart.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="key" value="{{ $itemKey }}">
                <button
                    type="submit"
                    class="rounded-[12px] bg-[#BFA28C] px-4 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white transition hover:bg-[#A88A72] focus:outline-none focus:ring-2 focus:ring-[#BFA28C]">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
