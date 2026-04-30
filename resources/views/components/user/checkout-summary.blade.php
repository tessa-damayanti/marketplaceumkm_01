<h2 class="mb-5 text-xl font-bold text-[#5c4432] sm:mb-7 sm:text-2xl">Ringkasan Pesanan</h2>

<div class="mb-7 rounded-3xl border border-[#e5d8ca] bg-[#faf7f4] p-5">
    <p class="mb-3 text-sm font-bold uppercase tracking-[3px] text-[#BFA28C]">
        Metode Pembayaran
    </p>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-[#7b6858]">Transfer BNI</p>
            <p class="text-2xl font-bold text-[#5c4432]">1992345919</p>
        </div>

        <div class="rounded-2xl bg-white px-5 py-3 text-base font-bold text-[#5c4432] shadow-sm">
            A.n Velora
        </div>
    </div>
</div>

<div class="mb-5 sm:mb-7">
    <h3 class="mb-3 text-lg font-bold text-[#5c4432] sm:mb-4 sm:text-xl">Item Pesanan</h3>

    <div class="space-y-4">
        @foreach ($cartItems as $item)
            @php
                $subtotal = (int) $item['price'] * (int) $item['qty'];
            @endphp

            <div class="mb-4 rounded-[20px] bg-[#f4ede5] px-3 sm:px-4 py-4 sm:py-5 last:mb-0">
                <div class="flex items-start gap-3 sm:gap-4">
                    <!-- Gambar -->
                    <img
                        src="{{ $item['image'] ?? '' }}"
                        alt="{{ $item['name'] }}"
                        class="h-[72px] w-[72px] sm:h-[82px] sm:w-[82px] flex-shrink-0 rounded-[14px] object-cover"
                    >

                    <!-- Info Produk -->
                    <div class="min-w-0 flex-1 flex justify-between">
                        <!-- Kiri: Nama dan Ukuran -->
                        <div>
                            <h4 class="text-sm sm:text-base font-semibold text-[#5c4432] leading-snug">
                                {{ $item['name'] }}
                            </h4>
                            <p class="mt-1 text-xs text-[#7b6858]">
                                Ukuran : {{ $item['size'] ?? '-' }}
                            </p>
                        </div>

                        <!-- Kanan: Harga dan Qty -->
                        <div class="text-right ml-2">
                            <p class="text-sm sm:text-base font-semibold leading-none text-[#7a5a43]">
                                Rp{{ number_format($item['price'], 0, ',', '.') }}
                            </p>
                            <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium text-[#7b6858]">
                                x{{ $item['qty'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-5 rounded-[20px] bg-[#efe4d8] p-4 sm:mb-7 sm:rounded-3xl sm:p-5">
    <div class="flex items-center justify-between gap-4">
        <p class="text-base font-bold text-[#5c4432] sm:text-xl">Total Pembayaran</p>
        <p class="text-lg font-bold text-[#5c4432] sm:text-2xl">
            Rp{{ number_format($grandTotal, 0, ',', '.') }}
        </p>
    </div>
</div>

<div class="mb-5 sm:mb-7">
    <p class="mb-2 text-lg font-bold text-[#5c4432] sm:mb-3 sm:text-xl">Bukti Pembayaran</p>

    <label for="bukti-transfer" class="block cursor-pointer">
        <div id="uploadBox" class="flex h-[170px] items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-[#d8c3af] bg-[#faf7f4] transition hover:border-[#a78d78] hover:bg-[#efe4d8]">
            <div id="uploadPlaceholder" class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-14 w-14 text-[#7b6858]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                    <path d="M8 15l2.5-3 2.5 3 2-2 3 4"></path>
                    <circle cx="9" cy="9" r="1"></circle>
                </svg>
                <p class="font-medium text-[#6e5a4c]">Klik untuk upload bukti</p>
                <p class="mt-1 text-sm text-[#9a8575]">Format: JPG / PNG</p>
            </div>

            <img id="previewImage" src="" class="hidden h-full w-full object-cover" alt="Preview Bukti Pembayaran">
        </div>

        <input id="bukti-transfer" name="payment_proof" type="file" accept=".jpg,.jpeg,.png" class="hidden">
    </label>
</div>

<button
    type="submit"
    class="w-full rounded-2xl bg-[#BFA28C] py-3 text-base font-bold text-white shadow-md transition hover:bg-[#A88A72] sm:py-4 sm:text-lg"
>
    Buat Pesanan

</button>