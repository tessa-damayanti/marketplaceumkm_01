@props(['product', 'index'])

<div class="product-card flex h-full flex-col group cursor-pointer overflow-hidden rounded-[18px] bg-white shadow-[0_2px_14px_rgba(167,141,120,0.10)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_14px_32px_rgba(167,141,120,0.20)]"
    data-index="{{ $index }}"
    data-original-index="{{ $index }}"
    data-price="{{ str_replace('.', '', $product['price']) }}"
    data-name="{{ strtolower($product['name']) }}"
    data-product='@json($product)'
    onclick="openModalFromElement(this)">

    <!-- Gambar produk -->
    <div class="card-thumb overflow-hidden">
        <img src="{{ $product['image'] }}"
            alt="{{ $product['name'] }}"
            loading="lazy"
            class="block h-[160px] w-full object-cover transition-transform duration-500 ease-out will-change-transform group-hover:scale-[1.06] min-[480px]:h-[185px] md:h-[215px] lg:h-[235px]">
    </div>

    <!-- Info produk -->
    <div class="flex flex-1 flex-col p-[0.65rem_0.75rem_0.85rem] sm:p-4">
        <!-- Label kategori -->
        <p class="mb-0.5 text-[9px] font-bold uppercase tracking-[2.5px] text-[#b08b68] sm:text-[10px] sm:tracking-[3px]">
            {{ $product['category'] }}
        </p>
        <!-- Nama produk -->
        <h3 class="mb-2 text-[0.79rem] font-semibold leading-snug text-[#5c4432] sm:mb-1.5 sm:text-[0.94rem]">
            {{ $product['name'] }}
        </h3>

        <div class="mt-auto">
            <!-- Harga dan terjual -->
            <div class="mb-2.5 flex flex-wrap items-center justify-between gap-1 sm:mb-3">
                <p class="text-sm font-bold text-[#7a5a43] sm:text-[1.05rem]">
                    Rp{{ number_format((int) str_replace('.', '', $product['price']), 0, ',', '.') }}
                </p>
                <p class="whitespace-nowrap text-[11px] font-semibold text-[#b08b68] sm:text-[12px] [font-family:Poppins,sans-serif]">
                    {{ $product['sold'] ?? 0 }} terjual
                </p>
            </div>

            <!-- Tombol lihat detail -->
            <button type="button"
                class="w-full rounded-xl border-0 bg-[#BFA28C] px-4 py-2 text-xs font-semibold text-white transition-all duration-200 hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)] sm:rounded-2xl sm:py-2.5 sm:text-sm [font-family:Poppins,sans-serif]">
                Lihat Detail
            </button>
        </div>
    </div>
</div>
