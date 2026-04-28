<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-[#f5ede4]">

    @php
    $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['qty']);
    @endphp

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-6 sm:py-8">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('product') }}" class="inline-flex items-center gap-2 text-sm text-[#8c7563] transition hover:text-[#5c4432]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali Belanja
            </a>
        </div>

        <!-- Header Card -->
        <div class="mb-4 rounded-[24px] bg-white px-5 sm:px-7 py-4 sm:py-5 shadow-[0_4px_18px_rgba(167,141,120,0.12)]">
            <h1 class="text-xl sm:text-2xl font-bold text-[#5c4432]">Keranjang Saya</h1>
        </div>

        <!-- Main Card -->
        <div class="overflow-hidden rounded-[24px] bg-white shadow-[0_4px_18px_rgba(167,141,120,0.12)]">

            <!-- Pilih Semua -->
            <div class="border-b border-[#eee3d8] px-5 sm:px-7 py-4">
                <div class="flex items-center gap-3">
                    <input
                        id="check-all"
                        type="checkbox"
                        class="w-4 h-4 rounded border-[#c4ab96] bg-[#f4ede5] text-[#6b4d37] focus:ring-[#6b4d37] focus:ring-2">
                    <label for="check-all" class="text-base font-semibold text-[#5c4432] cursor-pointer">
                        Pilih Semua
                    </label>
                </div>
            </div>

            <!-- Item List -->
            <div class="px-3 sm:px-5 py-4">
                @forelse ($cartItems as $key => $item)
                <div class="mb-4 rounded-[20px] bg-[#f4ede5] px-3 sm:px-4 py-4 sm:py-5 last:mb-0">
                    <div class="flex flex-col gap-4">

                        <!-- Baris 1: Checkbox + Gambar + Info -->
                        <div class="flex items-start gap-3 sm:gap-4">

                            <div class="pt-1">
                                <input
                                    type="checkbox"
                                    class="item-check w-4 h-4 rounded border-[#c4ab96] bg-white text-[#6b4d37] focus:ring-[#6b4d37] focus:ring-2"
                                    data-price="{{ $item['price'] }}"
                                    data-qty="{{ $item['qty'] }}"
                                    checked>
                            </div>

                            <!-- Gambar -->
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['name'] }}"
                                class="h-[72px] w-[72px] sm:h-[82px] sm:w-[82px] flex-shrink-0 rounded-[14px] object-cover">

                            <!-- Info Produk -->
                            <div class="min-w-0 flex-1">
                                <h2 class="text-sm sm:text-base font-semibold text-[#5c4432] leading-snug">
                                    {{ $item['name'] }}
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
                        <div class="flex items-center justify-between pl-[calc(0.75rem+72px)] sm:pl-[calc(1rem+82px)]">

                            <!-- Qty Counter -->
                            <div class="flex items-center gap-3">
                                <!-- Tombol Kurang -->
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
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
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <input type="hidden" name="action" value="plus">
                                    <button
                                        type="submit"
                                        class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-[10px] bg-[#ded1c2] text-base font-bold text-[#6b5848] transition hover:bg-[#d2c2b0] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                                        +
                                    </button>
                                </form>
                            </div>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="key" value="{{ $key }}">
                                <button
                                    type="submit"
                                    class="rounded-[12px] bg-[#ded1c2] px-4 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-[#6b5848] transition hover:bg-[#d2c2b0] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                                    Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                @empty
                <div class="py-10 text-center">
                    <p class="text-lg font-medium text-[#7b6858]">Keranjang masih kosong</p>
                    <a href="{{ route('product') }}"
                        class="mt-4 inline-flex rounded-[12px] bg-[#a78d78] px-6 py-3 text-white transition hover:bg-[#8f7561] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                        Belanja Sekarang
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="flex flex-col gap-4 border-t border-[#eee3d8] px-5 sm:px-7 py-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-[#9b8778]">Total</p>
                    <p id="cart-total" class="mt-1 text-lg sm:text-xl font-bold leading-none text-[#5c4432]">
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                <a href="{{ route('checkout') }}"
                    class="inline-flex h-[42px] sm:h-[46px] w-full sm:w-[120px] items-center justify-center rounded-[14px] bg-[#6b4d37] text-sm font-semibold text-white transition hover:bg-[#5a3f2e] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                    Beli
                </a>
            </div>
        </div>
    </section>

    <script>
        function formatRupiah(number) {
            return 'Rp' + number.toLocaleString('id-ID');
        }

        function updateCartTotal() {
            let total = 0;
            const checkboxes = document.querySelectorAll('.item-check');
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    const price = parseInt(checkbox.dataset.price);
                    const qty = parseInt(checkbox.dataset.qty);
                    total += price * qty;
                }
            });
            document.getElementById('cart-total').innerText = formatRupiah(total);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('check-all');
            const itemChecks = document.querySelectorAll('.item-check');

            updateCartTotal();

            checkAll.addEventListener('change', function() {
                itemChecks.forEach((item) => { item.checked = checkAll.checked; });
                updateCartTotal();
            });

            itemChecks.forEach((item) => {
                item.addEventListener('change', function() {
                    const allChecked = [...itemChecks].every((cb) => cb.checked);
                    checkAll.checked = allChecked;
                    updateCartTotal();
                });
            });
        });
    </script>

</body>

</html>