<h2 class="mb-7 text-2xl font-bold text-[#5c4432]">Ringkasan Pesanan</h2>

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

<div class="mb-7">
    <h3 class="mb-4 text-xl font-bold text-[#5c4432]">Item Pesanan</h3>

    <div class="space-y-4">
        @foreach ($cartItems as $item)
            @php
                $subtotal = (int) $item['price'] * (int) $item['qty'];
            @endphp

            <div class="flex items-center gap-5 rounded-3xl bg-[#faf7f4] p-5">
                <img
                    src="{{ $item['image'] ?? '' }}"
                    alt="{{ $item['name'] }}"
                    class="h-24 w-24 rounded-2xl border border-[#eaded3] object-cover"
                >

                <div class="flex-1">
                    <h4 class="text-xl font-bold text-[#2f241d]">
                        {{ $item['name'] }}
                    </h4>

                    <p class="mt-1 text-[#8a7668]">
                        Ukuran: {{ $item['size'] ?? '-' }}
                    </p>

                    <p class="text-[#8a7668]">
                        Qty: {{ $item['qty'] }} x Rp{{ number_format($item['price'], 0, ',', '.') }}
                    </p>

                    <p class="mt-1 font-bold text-[#2f241d]">
                        Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-7 rounded-3xl bg-[#efe4d8] p-5">
    <div class="flex items-center justify-between gap-4">
        <p class="text-xl font-bold text-[#5c4432]">Total Pembayaran</p>
        <p class="text-2xl font-bold text-[#5c4432]">
            Rp{{ number_format($grandTotal, 0, ',', '.') }}
        </p>
    </div>
</div>

<div class="mb-7">
    <p class="mb-3 text-xl font-bold text-[#5c4432]">Bukti Pembayaran</p>

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
    class="w-full rounded-2xl bg-[#BFA28C] py-4 text-lg font-bold text-white shadow-md transition hover:bg-[#A88A72]"
>
    Buat Pesanan

</button>