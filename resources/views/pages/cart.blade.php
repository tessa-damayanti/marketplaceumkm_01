@extends('layouts.app')
@section('title', 'Keranjang')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <style>
        html, body {
            overscroll-behavior: none;
        }
        body {
            background-color: #f5ede4;
        }

        .qty-btn {
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            transform-origin: center;
        }
        .qty-btn:not(:disabled):active {
            transform: scale(0.82);
        }
        .qty-btn:not(:disabled) {
            transition: background-color 0.18s ease, transform 0.12s cubic-bezier(.34,1.56,.64,1), box-shadow 0.18s ease;
        }
        .qty-btn:not(:disabled):hover {
            box-shadow: 0 4px 12px rgba(92,68,50,0.18);
        }

        .qty-value {
            display: block;
            transition: opacity 0.15s ease, transform 0.15s cubic-bezier(.34,1.56,.64,1);
        }
        .qty-value.qty-changing {
            opacity: 0;
            transform: translateY(4px) scale(0.85);
        }
        .qty-value.qty-changed {
            animation: qtyPop 0.28s cubic-bezier(.34,1.56,.64,1) forwards;
        }
        @keyframes qtyPop {
            0%   { opacity: 0; transform: translateY(-5px) scale(0.8); }
            60%  { opacity: 1; transform: translateY(1px) scale(1.08); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

       /* Efek animasi saat total harga diperbarui */
        #cart-total {
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        #cart-total.total-updating {
            opacity: 0.4;
            transform: scale(0.97);
        }

      /* Menampilkan loading spinner saat tombol jumlah diproses */
        .qty-btn.loading {
            pointer-events: none;
            opacity: 0.6;
        }
        .qty-btn.loading span {
            visibility: hidden;
        }
        .qty-btn.loading::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border: 2px solid currentColor;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.5s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    @php
    $total = collect($cartItems)->filter(fn($item) => $item['stock'] > 0)->sum(fn($item) => $item['price'] * $item['qty']);
    @endphp

    @if (session('success'))
    <div id="cart-toast" class="pointer-events-none fixed right-6 top-6 z-[999] translate-y-3 opacity-0 transition-all duration-500">
        <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] bg-[#fffaf6] px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)]" style="border:none;outline:none;">
            <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-[#5c4432]">Berhasil</p>
                <p class="mt-1 text-sm leading-6 text-[#7b6858]">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('cart-toast');
            if (toast) {
                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-3');
                    toast.classList.add('opacity-100', 'translate-y-0');
                });
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-3');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
            }
        });
    </script>
    @endif

    <div class="min-h-screen px-5 py-8 md:px-10">
        <section class="mx-auto max-w-6xl">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('product') }}" class="inline-flex items-center gap-2 text-sm text-[#8c7563] transition hover:text-[#A98B76]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali Belanja
            </a>
        </div>

        <!-- Main Card -->
        <div class="overflow-hidden rounded-[28px] border border-[#e5d8ca] bg-white shadow-[0_14px_45px_rgba(92,68,50,0.10)]">

            <!-- Header Card -->
            <div class="border-b border-[#e5d8ca] bg-[#efe4d8] px-5 sm:px-8 py-4 sm:py-6">
                <h1 class="text-xl sm:text-3xl font-bold text-[#5c4432]">Keranjang Saya</h1>
            </div>

            <!-- Pilih Semua -->
            <div class="border-b border-[#eee3d8] px-5 sm:px-7 py-4">
                <div class="flex items-center gap-3">
                    <input
                        id="check-all"
                        type="checkbox"
                        class="w-4 h-4 rounded border-[#c4ab96] bg-[#f4ede5] text-[#BFA28C] focus:ring-[#BFA28C] focus:ring-2">
                    <label for="check-all" class="text-base font-semibold text-[#5c4432] cursor-pointer">
                        Pilih Semua
                    </label>
                </div>
            </div>

            <!-- Item List -->
            <div class="px-3 sm:px-5 py-4">
                @forelse ($cartItems as $key => $item)
                <x-user.cart-item :item="$item" :itemKey="$key" />
                @empty
                <div class="py-10 text-center">
                    <p class="text-lg font-medium text-[#7b6858]">Keranjang masih kosong</p>
                    <a href="{{ route('product') }}"
                        class="mt-4 inline-flex rounded-[12px] bg-[#BFA28C] px-6 py-3 text-white transition hover:bg-[#A88A72] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                        Belanja Sekarang
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="flex flex-col gap-4 border-t border-[#eee3d8] px-5 sm:px-7 pt-5 pb-8 sm:flex-row sm:items-end sm:justify-between sm:pb-10">
                <div>
                    <p class="text-sm font-medium text-[#9b8778]">Total</p>
                    <p id="cart-total" class="mt-1 text-lg sm:text-xl font-bold leading-none text-[#5c4432]">
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                <div class="relative w-full sm:w-auto">
                    <a href="{{ route('checkout') }}" id="btn-checkout"
                        class="inline-flex h-[42px] sm:h-[46px] w-full sm:w-[120px] items-center justify-center rounded-[14px] bg-[#A98B76] text-sm font-semibold text-white transition hover:bg-[#967A66] focus:outline-none focus:ring-2 focus:ring-[#c4ab96]">
                        Beli
                    </a>
                    <p id="validation-msg" class="hidden absolute top-full right-0 mt-1 whitespace-nowrap text-[10px] sm:text-xs font-medium text-red-600">
                        Silahkan pilih produk yang akan dibeli
                    </p>
                </div>
            </div>
        </div>
        </section>
    </div>

@push('scripts')
    <script>
        function formatRupiah(number) {
            return 'Rp' + number.toLocaleString('id-ID');
        }

        function updateCartTotal() {
            let total = 0;
            const checkboxes = document.querySelectorAll('.item-check');
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked && !checkbox.disabled) {
                    const price = parseInt(checkbox.dataset.price);
                    const qty   = parseInt(checkbox.dataset.qty);
                    total += price * qty;
                }
            });
            const el = document.getElementById('cart-total');
            
            if (el.classList.contains('total-updating')) {
                setTimeout(() => {
                    el.textContent = formatRupiah(total);
                }, 250);
            } else {
                el.textContent = formatRupiah(total);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('check-all');
            const itemChecks = document.querySelectorAll('.item-check');
            
            const savedStates = JSON.parse(localStorage.getItem('cartCheckedStates')) || {};
            const reorderedStoks = JSON.parse(localStorage.getItem('reordered_stoks'));

            function saveStates() {
                const states = {};
                itemChecks.forEach((item) => {
                    states[item.dataset.key] = item.checked;
                });
                localStorage.setItem('cartCheckedStates', JSON.stringify(states));
            }
            
            if (reorderedStoks && Array.isArray(reorderedStoks)) {
                // Centang untuk produk yang dibeli ulang
                itemChecks.forEach((item) => {
                    if (item.disabled) {
                        item.checked = false;
                    } else {
                        const stokId = parseInt(item.dataset.stok);
                        item.checked = reorderedStoks.includes(stokId);
                    }
                });
                localStorage.removeItem('reordered_stoks');
                saveStates(); 
            } else {
                // Mengembalikan status centang produk yang tersimpan sebelumnya
                itemChecks.forEach((item) => {
                    if (item.disabled) {
                        item.checked = false;
                        return;
                    }
                    const key = item.dataset.key;
                    if (savedStates[key] === undefined) {
                        item.checked = true;
                    } else {
                        item.checked = savedStates[key];
                    }
                });
            }

            const activeChecks = [...itemChecks].filter(cb => !cb.disabled);
            const allChecked = activeChecks.length > 0 && activeChecks.every((cb) => cb.checked);
            if (checkAll) checkAll.checked = allChecked;

            updateCartTotal();

            checkAll.addEventListener('change', function() {
                itemChecks.forEach((item) => { 
                    if (!item.disabled) {
                        item.checked = checkAll.checked; 
                    }
                });
                saveStates();
                updateCartTotal();
                
                // Menyembunyikan pesan validasi jika minimal satu produk dipilih //
                const validationMsg = document.getElementById('validation-msg');
                if (validationMsg && checkAll.checked && activeChecks.length > 0) {
                    validationMsg.classList.add('hidden');
                }
            });

            itemChecks.forEach((item) => {
                item.addEventListener('change', function() {
                    const activeChecks = [...itemChecks].filter(cb => !cb.disabled);
                    const allChecked = activeChecks.length > 0 && activeChecks.every((cb) => cb.checked);
                    checkAll.checked = allChecked;
                    saveStates();
                    updateCartTotal();

                    // Menyembunyikan pesan validasi jika minimal satu produk dipilih //
                    const validationMsg = document.getElementById('validation-msg');
                    if (validationMsg) {
                        const anyChecked = activeChecks.some((cb) => cb.checked);
                        if (anyChecked) {
                            validationMsg.classList.add('hidden');
                        }
                    }
                });
            });

            // Menutup modal ubah ukuran saat area luar modal diklik
            const changeSizeModal = document.getElementById('changeSizeModal');
            if (changeSizeModal) {
                changeSizeModal.addEventListener('click', function(e) {
                    if (e.target === this) closeChangeSizeModal();
                });
            }

            const btnCheckout = document.getElementById('btn-checkout');
            if (btnCheckout) {
                btnCheckout.addEventListener('click', function(e) {
                    e.preventDefault();
                    let selectedKeys = [];
                    itemChecks.forEach((item) => {
                        if (item.checked) {
                            selectedKeys.push(item.dataset.key);
                        }
                    });

                    if (selectedKeys.length === 0) {
                        const validationMsg = document.getElementById('validation-msg');
                        if (validationMsg) {
                            validationMsg.classList.remove('hidden');
                        }
                        return;
                    }

                    let url = new URL(this.href);
                    selectedKeys.forEach(key => {
                        url.searchParams.append('selected[]', key);
                    });
                    window.location.href = url.toString();
                });
            }
        });
    </script>

    <script>
        // Mengubah jumlah produk pada keranjang tanpa mereload halaman keranjang //
        const AJAX_URL  = '{{ route("cart.update") }}';
        const CSRF      = '{{ csrf_token() }}';

        function formatRupiah(n) {
            return 'Rp' + Math.round(n).toLocaleString('id-ID');
        }

        // Memberikan animasi saat jumlah produk berubah //
        function animateQty(qtyEl, newQty) {
            qtyEl.classList.add('qty-changing');
            setTimeout(() => {
                qtyEl.textContent = newQty;
                qtyEl.dataset.qty = newQty;
                qtyEl.classList.remove('qty-changing');
                qtyEl.classList.add('qty-changed');
                setTimeout(() => qtyEl.classList.remove('qty-changed'), 400);
            }, 150);
        }

        // Memberikan animasi saat total harga diperbarui //
        function animateTotal(newTotal) {
            const el = document.getElementById('cart-total');
            el.classList.add('total-updating');
            setTimeout(() => {
                el.textContent = formatRupiah(newTotal);
                el.classList.remove('total-updating');
            }, 200);
        }

        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                if (this.disabled || this.classList.contains('loading')) return;

                const key     = this.dataset.key;
                const action  = this.dataset.action;
                const wrapper = this.closest('.cart-item-wrapper');

                this.classList.add('loading');

                try {
                    const res = await fetch(AJAX_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ key, action }),
                    });

                    if (!res.ok) throw new Error('Gagal memperbarui keranjang');
                    const data = await res.json();

                    // Memperbarui jumlah produk //
                    const qtyEl = wrapper.querySelector('.qty-value');
                    if (qtyEl) animateQty(qtyEl, data.qty);

                    // Memperbarui data jumlah dan harga pada checkbox //
                    const cb = wrapper.querySelector('.item-check');
                    if (cb) {
                        cb.dataset.qty   = data.qty;
                        cb.dataset.price = data.price;
                    }

                    // Memperbarui total harga seluruh keranjang
                    animateTotal(data.grand_total);

                    // Menampilkan atau menyembunyikan pesan ketika batas stok maksimal
                    const limitMsg = wrapper.querySelector('.limit-msg');
                    if (limitMsg) {
                        if (data.limit_reached) {
                            limitMsg.classList.remove('hidden');
                            setTimeout(() => limitMsg.classList.add('hidden'), 3000);
                        } else {
                            limitMsg.classList.add('hidden');
                        }
                    }

                    // Menghitung kembali total harga berdasarkan produk yang dipilih
                    updateCartTotal();

                } catch (err) {
                    console.error(err);
                } finally {
                    this.classList.remove('loading');
                }
            });
        });
    </script>
@endpush
@endsection