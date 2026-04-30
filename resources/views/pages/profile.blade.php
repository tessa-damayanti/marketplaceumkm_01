@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 md:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

            {{-- Sidebar --}}
            <div class="lg:col-span-3">
                @include('components.user.profile-sidebar')
            </div>

            {{-- Konten --}}
            <div class="lg:col-span-9">
                @include('components.user.profile-account')
                @include('components.user.profile-history')
            </div>

        </div>
    </div>

    {{-- Modal --}}
    @include('components.user.profile-order-modal')

    {{-- Toast --}}
    @include('components.user.profile-toast')

@endsection

@push('scripts')
    <script>
        function switchTab(tabId) {
            document.getElementById('tab-akun').classList.add('hidden');
            document.getElementById('tab-riwayat').classList.add('hidden');

            document.getElementById('tab-' + tabId).classList.remove('hidden');

            const btnAkun = document.getElementById('btn-tab-akun');
            const btnRiwayat = document.getElementById('btn-tab-riwayat');

            const inactive = ['text-[#8b6f58]', 'font-medium'];
            const active = ['bg-[#f4ece3]', 'text-[#5c4432]', 'font-bold'];

            btnAkun.classList.remove(...active);
            btnAkun.classList.add(...inactive);

            btnRiwayat.classList.remove(...active);
            btnRiwayat.classList.add(...inactive);

            const activeBtn = document.getElementById('btn-tab-' + tabId);
            activeBtn.classList.remove(...inactive);
            activeBtn.classList.add(...active);
        }

        const orders = {
            'VL-250212-001': {
                id: 'VL-250212-001',
                date: '12 Feb 2026, 10:23 WIB',
                status: 'Menunggu Verifikasi',
                badgeBg: 'bg-[#fff1bd]',
                badgeText: 'text-[#b45a00]',
                total: 'Rp382.000',
                items: [
                    {
                        name: 'Kemeja Stripe',
                        size: 'S',
                        qty: '1 x Rp100.000',
                        subtotal: 'Rp100.000',
                        img: 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg'
                    },
                    {
                        name: 'Gaun Biru Wrap',
                        size: 'M',
                        qty: '1 x Rp170.000',
                        subtotal: 'Rp170.000',
                        img: 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg'
                    },
                    {
                        name: 'Cardigan Rajut Pink',
                        size: 'All Size',
                        qty: '1 x Rp112.000',
                        subtotal: 'Rp112.000',
                        img: 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg'
                    }
                ]
            },

            'VL-250209-002': {
                id: 'VL-250209-002',
                date: '09 Feb 2026, 15:40 WIB',
                status: 'Pembayaran Valid',
                badgeBg: 'bg-[#dcfce7]',
                badgeText: 'text-[#15803d]',
                total: 'Rp170.000',
                items: [
                    {
                        name: 'Gaun Biru Wrap',
                        size: 'M',
                        qty: '1 x Rp170.000',
                        subtotal: 'Rp170.000',
                        img: 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg'
                    }
                ]
            },

            'VL-250206-003': {
                id: 'VL-250206-003',
                date: '06 Feb 2026, 09:12 WIB',
                status: 'Pembayaran Ditolak',
                badgeBg: 'bg-[#fee2e2]',
                badgeText: 'text-[#dc2626]',
                total: 'Rp332.000',
                items: [
                    {
                        name: 'Cardigan Rajut Pink',
                        size: 'All Size',
                        qty: '1 x Rp112.000',
                        subtotal: 'Rp112.000',
                        img: 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg'
                    }
                ]
            }
        };

        function lockScroll() {
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        function unlockScroll() {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        function openModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            lockScroll();
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            unlockScroll();
        }

        function rupiahToNumber(value) {
            return Number(String(value).replace(/[^0-9]/g, ''));
        }

        function getQty(item) {
            return Number(String(item.qty).split('x')[0].trim()) || 1;
        }

        function getPrice(item) {
            return rupiahToNumber(item.subtotal) / getQty(item);
        }

        function openOrderDetail(orderId) {
            const order = orders[orderId];

            document.getElementById('modal-order-id').textContent = order.id;
            document.getElementById('modal-date').textContent = order.date;

            const badge = document.getElementById('modal-status-badge');
            badge.textContent = order.status;
            badge.className = `mt-2 inline-flex rounded-full ${order.badgeBg} px-5 py-2 text-sm font-semibold ${order.badgeText}`;

            const itemsWrapper = document.getElementById('modal-items');
            itemsWrapper.innerHTML = '';

            order.items.forEach(item => {
                itemsWrapper.innerHTML += `
                            <div class="flex items-center justify-between rounded-xl bg-[#fbf8f5] p-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-white">
                                        <img src="${item.img}" class="h-full w-full object-cover" alt="${item.name}">
                                    </div>

                                    <div>
                                        <p class="font-bold text-[#2f1f16]">${item.name}</p>
                                        <p class="mt-1 text-sm text-[#8b7a6d]">Ukuran: ${item.size}</p>
                                        <p class="text-sm text-[#8b7a6d]">Qty: ${item.qty}</p>
                                        <p class="mt-1 text-sm font-bold text-[#2f1f16]">Subtotal: ${item.subtotal}</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('cart.add') }}">
        @csrf

        <input type="hidden" name="name" value="${item.name}">
        <input type="hidden" name="category" value="Riwayat Pesanan">
        <input type="hidden" name="image" value="${item.img}">
        <input type="hidden" name="price" value="${getPrice(item)}">
        <input type="hidden" name="size" value="${item.size}">
        <input type="hidden" name="qty" value="${getQty(item)}">
        <input type="hidden" name="stock" value="99">

        <button type="submit"
            class="rounded-lg border border-[#BFA28C] px-5 py-2 text-sm font-semibold text-[#6b422b] transition hover:bg-[#A88A72] hover:text-white">
            Beli Lagi
        </button>
    </form>

                            </div>
                        `;
            });

            document.getElementById('modal-total').textContent = order.total;

            openModal();
        }
    </script>
@endpush