@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

@push('styles')
<style>
    html,
    body {
        overscroll-behavior: none;
    }
</style>
@endpush
    <div class="mx-auto max-w-7xl px-4 py-10 md:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

            {{-- Sidebar --}}
            <div class="lg:col-span-3">
                <x-user.profile-sidebar />
            </div>

            {{-- Konten --}}
            <div class="lg:col-span-9">
                <x-user.profile-account />
                <x-user.profile-history />
            </div>

        </div>
    </div>

    {{-- Modals --}}
    <x-user.profile-modals />

    {{-- Toast --}}
    <x-user.profile-toast />

@endsection

@push('scripts')
    <script>
        function switchTab(tabId) {
            document.getElementById('tab-akun').classList.add('hidden');
            document.getElementById('tab-riwayat').classList.add('hidden');

            document.getElementById('tab-' + tabId).classList.remove('hidden');

            const btnAkun = document.getElementById('btn-tab-akun');
            const btnRiwayat = document.getElementById('btn-tab-riwayat');

            const inactive = ['text-[#8b6f58]', 'font-medium', 'bg-transparent'];
            const active = ['bg-[#e8ded3]', 'text-[#5c4432]', 'font-bold'];

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
                total: 'Rp362.000',
                items: [
                    {
                        name: 'Kemeja Stripe',
                        size: 'S',
                        qty: '1 x Rp102.000',
                        subtotal: 'Rp102.000',
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
                        size: 'M',
                        qty: '1 x Rp90.000',
                        subtotal: 'Rp90.000',
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
                date: '06 Feb 2026, 09:15 WIB',
                status: 'Pembayaran Ditolak',
                badgeBg: 'bg-[#fee2e2]',
                badgeText: 'text-[#dc2626]',
                total: 'Rp90.000',
                items: [
                    {
                        name: 'Cardigan Rajut Pink',
                        size: 'M',
                        qty: '1 x Rp90.000',
                        subtotal: 'Rp90.000',
                        img: 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg'
                    }
                ]
            }
        };

        function openOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openOrderDetail(orderId) {
            const order = orders[orderId];
            if (!order) return;

            document.getElementById('modal-order-id').textContent = 'ID Pesanan: ' + order.id;
            document.getElementById('modal-date').textContent = order.date;

            const badge = document.getElementById('modal-status-badge');
            badge.className = 'mt-2 inline-flex rounded-full px-5 py-2 text-sm font-semibold ' + order.badgeBg + ' ' + order.badgeText;
            badge.textContent = order.status;

            const itemsContainer = document.getElementById('modal-items');
            itemsContainer.innerHTML = '';

            const getPrice = (item) => parseInt(item.qty.split('Rp')[1].replace(/\./g, ''));
            const getQty = (item) => parseInt(item.qty.split('x')[0]);

            order.items.forEach(item => {
                itemsContainer.innerHTML += `
                            <div class="mb-4 rounded-[20px] bg-[#f4ede5] px-3 py-4 sm:px-4 sm:py-5 last:mb-0">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <img src="${item.img}" alt="${item.name}" class="h-[72px] w-[72px] flex-shrink-0 rounded-[14px] object-cover sm:h-[82px] sm:w-[82px]">
                                    
                                    <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                                        <div class="flex flex-1 items-start justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold leading-snug text-[#5c4432] sm:text-base">${item.name}</h4>
                                                <p class="mt-1 text-xs text-[#7b6858]">Ukuran : ${item.size}</p>
                                            </div>
                                            <div class="ml-2 text-right">
                                                <p class="text-sm font-semibold leading-none text-[#7a5a43] sm:text-base">${item.subtotal}</p>
                                                <p class="mt-1 text-xs font-medium text-[#7b6858] sm:mt-2 sm:text-sm">x${getQty(item)}</p>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('cart.add') }}" class="flex-shrink-0 text-right sm:ml-2">
                                            @csrf
                                            <input type="hidden" name="name" value="${item.name}">
                                            <input type="hidden" name="category" value="Riwayat Pesanan">
                                            <input type="hidden" name="image" value="${item.img}">
                                            <input type="hidden" name="price" value="${getPrice(item)}">
                                            <input type="hidden" name="size" value="${item.size}">
                                            <input type="hidden" name="qty" value="${getQty(item)}">
                                            <input type="hidden" name="stock" value="99">
                                            <input type="hidden" name="redirect_to" value="cart">
                                            <button type="submit" class="rounded-xl bg-[#BFA28C] px-5 py-2 text-xs font-bold text-white transition hover:bg-[#A88A72] sm:text-sm">
                                                Beli Lagi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
            });

            document.getElementById('modal-total').textContent = order.total;

            openOrderModal();
        }

        function openLogoutModal() {
            const modal = document.getElementById('modal-logout');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            const modal = document.getElementById('modal-logout');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.addEventListener('DOMContentLoaded', () => {
            // Set Riwayat sebagai tab aktif secara default
            switchTab('riwayat');
        });
    </script>
@endpush