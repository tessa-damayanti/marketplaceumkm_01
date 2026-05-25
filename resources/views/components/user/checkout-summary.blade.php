@props(['cartItems', 'grandTotal'])

<h2 class="mb-5 text-xl font-bold text-[#5c4432] sm:mb-7 sm:text-2xl">Ringkasan Pesanan</h2>

{{-- Item Pesanan --}}
<div class="mb-6">
    <h3 class="mb-3 text-lg font-bold text-[#5c4432]">Item Pesanan</h3>
    <div class="space-y-3">
        @foreach ($cartItems as $item)
            <div class="flex items-center gap-3 rounded-[18px] bg-[#f4ede5] px-4 py-3">
                <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}"
                    class="h-16 w-16 flex-shrink-0 rounded-[12px] object-cover">
                <div class="min-w-0 flex-1 flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-[#5c4432]">{{ $item['name'] }}</p>
                        <p class="text-xs text-[#7b6858]">Ukuran: {{ $item['size'] ?? '-' }}</p>
                    </div>
                    <div class="text-right ml-2 flex-shrink-0">
                        <p class="text-sm font-semibold text-[#7a5a43]">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="text-xs text-[#7b6858]">x{{ $item['qty'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Total --}}
<div class="mb-5 rounded-[18px] bg-[#efe4d8] p-3 sm:mb-6 sm:rounded-2xl sm:p-4">
    <div class="flex items-center justify-between gap-4">
        <p class="text-sm font-bold text-[#5c4432] sm:text-lg">Total Pembayaran</p>
        <p class="text-base font-bold text-[#5c4432] sm:text-xl">
            Rp{{ number_format($grandTotal, 0, ',', '.') }}
        </p>
    </div>
</div>

<button type="submit" id="pay-btn"
    class="w-full rounded-2xl bg-[#BFA28C] py-3 text-base font-bold text-white shadow-md transition hover:bg-[#A88A72] active:scale-[0.98] sm:py-4 sm:text-lg">
    Bayar Sekarang
</button>

</script>