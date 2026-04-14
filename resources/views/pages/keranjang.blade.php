<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5ede4]">

    @php
        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['qty']);
    @endphp

    <section class="mx-auto max-w-6xl px-6 py-8">
        <div class="mb-4">
            <a href="{{ route('product') }}" class="inline-flex items-center gap-2 text-sm text-[#8c7563] transition hover:text-[#5c4432]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali Belanja
            </a>
        </div>

        <div class="mb-4 rounded-[24px] bg-white px-7 py-5 shadow-[0_4px_18px_rgba(167,141,120,0.12)]">
            <h1 class="text-2xl font-bold text-[#5c4432]">Keranjang Saya</h1>
        </div>

        <div class="overflow-hidden rounded-[24px] bg-white shadow-[0_4px_18px_rgba(167,141,120,0.12)]">
            <div class="border-b border-[#eee3d8] px-7 py-4">
                <label class="inline-flex items-center gap-3 text-base font-semibold text-[#5c4432]">
                    <input id="check-all" type="checkbox" class="h-4 w-4 accent-[#6b4d37]">
                    Pilih Semua
                </label>
            </div>

            <div class="px-5 py-4">
                @forelse ($cartItems as $key => $item)
                    <div class="mb-4 rounded-[20px] bg-[#f4ede5] px-4 py-5 last:mb-0">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center">
                            <div class="flex items-center gap-4">
                                <input
                                    type="checkbox"
                                    class="item-check h-4 w-4 accent-[#6b4d37]"
                                    data-price="{{ $item['price'] }}"
                                    data-qty="{{ $item['qty'] }}"
                                    checked>

                                <img
                                    src="{{ $item['image'] }}"
                                    alt="{{ $item['name'] }}"
                                    class="h-[82px] w-[82px] rounded-[14px] object-cover">

                                <div>
                                    <h2 class="text-xl font-semibold text-[#5c4432]">
                                        {{ $item['name'] }}
                                    </h2>
                                    <p class="mt-1 text-sm text-[#7b6858]">
                                        Ukuran : {{ $item['size'] }}
                                    </p>
                                    <p class="mt-2 text-[28px] font-bold leading-none text-[#7a5a43]">
                                        Rp{{ number_format($item['price'], 0, ',', '.') }}
                                    </p>

                                    <div class="mt-4 flex items-center gap-4">
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <input type="hidden" name="action" value="minus">
                                            <button
                                                type="submit"
                                                class="flex h-10 w-10 items-center justify-center rounded-[10px] bg-[#ded1c2] text-xl font-bold text-[#6b5848] transition hover:bg-[#d2c2b0]">
                                                -
                                            </button>
                                        </form>

                                        <span class="w-6 text-center text-lg font-semibold text-[#5c4432] qty-value">
                                            {{ $item['qty'] }}
                                        </span>

                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <input type="hidden" name="action" value="plus">
                                            <button
                                                type="submit"
                                                class="flex h-10 w-10 items-center justify-center rounded-[10px] bg-[#ded1c2] text-xl font-bold text-[#6b5848] transition hover:bg-[#d2c2b0]">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="md:ml-auto">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button
                                        type="submit"
                                        class="rounded-[12px] bg-[#ded1c2] px-7 py-3 text-base font-medium text-[#6b5848] transition hover:bg-[#d2c2b0]">
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
                           class="mt-4 inline-flex rounded-[12px] bg-[#a78d78] px-6 py-3 text-white transition hover:bg-[#8f7561]">
                            Belanja Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="flex flex-col justify-between gap-5 border-t border-[#eee3d8] px-7 py-5 md:flex-row md:items-end">
                <div>
                    <p class="text-base text-[#7b6858]">Total</p>
                    <p id="cart-total" class="mt-1 text-[34px] font-bold leading-none text-[#5c4432]">
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                
                    <a href="{{ route('checkout') }}"
                    class="inline-flex h-[54px] w-[140px] items-center justify-center rounded-[16px] bg-[#6b4d37] text-lg font-semibold text-white transition hover:bg-[#5a3f2e]">
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

        document.addEventListener('DOMContentLoaded', function () {
            const checkAll = document.getElementById('check-all');
            const itemChecks = document.querySelectorAll('.item-check');

            updateCartTotal();

            checkAll.addEventListener('change', function () {
                itemChecks.forEach((item) => {
                    item.checked = checkAll.checked;
                });
                updateCartTotal();
            });

            itemChecks.forEach((item) => {
                item.addEventListener('change', function () {
                    const allChecked = [...itemChecks].every((cb) => cb.checked);
                    checkAll.checked = allChecked;
                    updateCartTotal();
                });
            });
        });
    </script>

</body>
</html>