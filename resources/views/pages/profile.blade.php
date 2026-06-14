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
                <x-user.profile-history :pesanans="$pesanans" />
                <x-user.profile-password />
            </div>

        </div>
    </div>

    {{-- Modals --}}
    <x-user.profile-modals />

    {{-- Toast --}}
    <x-user.profile-toast />

@endsection

@php
    // Mapping badge warna per status
    $badgeMap = [
        'pending'    => ['bg' => 'bg-[#fff1bd]',  'text' => 'text-[#b45a00]'],
        'settlement' => ['bg' => 'bg-[#dcfce7]',  'text' => 'text-[#15803d]'],
        'cancel'     => ['bg' => 'bg-[#fee2e2]',  'text' => 'text-[#dc2626]'],
        'expire'     => ['bg' => 'bg-[#f3f4f6]',  'text' => 'text-[#6b7280]'],
    ];

    // Mapping label status dalam Bahasa Indonesia
    $statusLabel = [
        'pending'    => 'Menunggu Pembayaran',
        'settlement' => 'Pembayaran Berhasil',
        'cancel'     => 'Pembayaran Dibatalkan',
        'expire'     => 'Pembayaran Kedaluwarsa',
    ];

    // Bangun array data pesanan untuk dikirim ke JS
    $ordersData = [];
    foreach ($pesanans as $pesanan) {
        $status = $pesanan->status_pembayaran;
        $badge  = $badgeMap[$status] ?? ['bg' => 'bg-[#f3f4f6]', 'text' => 'text-[#6b7280]'];
        $label  = $statusLabel[$status] ?? $status;

        $items = [];
        foreach ($pesanan->detailPesanans as $d) {
            $produk = $d->stok?->produk;
            $ukuran = $d->stok?->ukuran?->nama_ukuran ?? '-';
            $img    = ($produk && $produk->image)
                ? asset('images/' . $produk->image)
                : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg';

            $items[] = [
                'name'     => $produk?->nama ?? '-',
                'size'     => $ukuran,
                'price'    => (int) ($produk?->harga ?? 0),
                'qty'      => $d->jumlah,
                'subtotal' => 'Rp' . number_format($d->harga_satuan * $d->jumlah, 0, ',', '.'),
                'img'      => $img,
                'stok_id'  => $d->stok_id,
            ];
        }

        $ordersData[$pesanan->id] = [
            'id'             => $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT),
            'raw_id'         => $pesanan->id,
            'date'           => \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d M Y, H:i') . ' WIB',
            'status'         => $label,
            'raw_status'     => $pesanan->status_pembayaran,
            'snap_token'     => $pesanan->snap_token,
            'badgeBg'        => $badge['bg'],
            'badgeText'      => $badge['text'],
            'total'          => 'Rp' . number_format($pesanan->total_harga, 0, ',', '.'),
            'buyer_name'     => $pesanan->nama_penerima ?? $pesanan->user?->nama_lengkap ?? '-',
            'buyer_phone'    => $pesanan->no_wa_penerima ?? $pesanan->user?->no_wa ?? '-',
            'buyer_address'  => $pesanan->alamat_penerima ?? $pesanan->user?->alamat ?? '-',
            'items'          => $items,
        ];
    }
@endphp



@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="application/json" id="orders-data">{!! json_encode($ordersData) !!}</script>
    <script>
        // Data pesanan dari server, dibaca dari elemen JSON
        let orders = {};
        try {
            const ordersEl = document.getElementById('orders-data');
            if (ordersEl) {
                orders = JSON.parse(ordersEl.textContent);
            }
        } catch (e) {
            console.error("Gagal melakukan parse orders-data:", e);
        }

        function filterHistoryTab(status) {
            const buttons = document.querySelectorAll('.subtab-btn');
            buttons.forEach(btn => {
                btn.style.background  = 'transparent';
                btn.style.color       = '#8b6f58';
                btn.style.borderColor = 'transparent';
                btn.style.fontWeight  = '500';
            });

            const activeBtn = document.getElementById('btn-subtab-' + status);
            if (activeBtn) {
                activeBtn.style.background  = '#e8ded3';
                activeBtn.style.color       = '#5c4432';
                activeBtn.style.borderColor = '#BFA28C';
                activeBtn.style.fontWeight  = '700';
            }

            const rows = document.querySelectorAll('.order-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Show/hide status column
            const statusCols = document.querySelectorAll('.col-status');
            statusCols.forEach(col => {
                if (status === 'all') {
                    col.classList.remove('hidden');
                } else {
                    col.classList.add('hidden');
                }
            });

            // Handle empty state
            const emptyRow = document.getElementById('empty-history-row');
            const emptyCell = document.getElementById('empty-history-cell');
            if (visibleCount === 0) {
                if (emptyRow && emptyCell) {
                    emptyCell.colSpan = (status === 'all') ? 5 : 4;
                    emptyRow.classList.remove('hidden');
                }
            } else {
                if (emptyRow) {
                    emptyRow.classList.add('hidden');
                }
            }
        }

        function switchTab(tabId) {
            const tabAkun     = document.getElementById('tab-akun');
            const tabRiwayat  = document.getElementById('tab-riwayat');
            const tabPassword = document.getElementById('tab-password');

            if (tabAkun)     tabAkun.classList.add('hidden');
            if (tabRiwayat)  tabRiwayat.classList.add('hidden');
            if (tabPassword) tabPassword.classList.add('hidden');

            const activeTab = document.getElementById('tab-' + tabId);
            if (activeTab) activeTab.classList.remove('hidden');

            const btnAkun     = document.getElementById('btn-tab-akun');
            const btnRiwayat  = document.getElementById('btn-tab-riwayat');
            const btnPassword = document.getElementById('btn-tab-password');

            const inactive = ['text-[#8b6f58]', 'font-medium', 'bg-transparent'];
            const active   = ['bg-[#e8ded3]', 'text-[#5c4432]', 'font-bold'];

            if (btnAkun) {
                btnAkun.classList.remove(...active);
                btnAkun.classList.add(...inactive);
            }
            if (btnRiwayat) {
                btnRiwayat.classList.remove(...active);
                btnRiwayat.classList.add(...inactive);
            }
            if (btnPassword) {
                btnPassword.classList.remove(...active);
                btnPassword.classList.add(...inactive);
            }

            const activeBtn = document.getElementById('btn-tab-' + tabId);
            if (activeBtn) {
                activeBtn.classList.remove(...inactive);
                activeBtn.classList.add(...active);
            }

            if (tabId === 'riwayat') {
                filterHistoryTab('all');
            }
        }

        function openOrderModal() {
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            document.body.style.overflow = 'hidden';
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            document.body.style.overflow = '';
        }

        function openOrderDetail(orderId) {
            try {
                console.log("openOrderDetail called with orderId:", orderId);
                console.log("orders dictionary:", orders);
                const order = orders[orderId];
                console.log("retrieved order object:", order);
                if (!order) {
                    console.error("Order not found in dictionary for ID:", orderId);
                    return;
                }

                const elOrderId = document.getElementById('modal-order-id');
                if (elOrderId) elOrderId.textContent = 'ID Pesanan: ' + order.id;

                const elDate = document.getElementById('modal-date');
                if (elDate) elDate.textContent = order.date;

                const badge = document.getElementById('modal-status-badge');
                if (badge) {
                    badge.className = 'mt-2 inline-flex rounded-full px-5 py-2 text-sm font-semibold ' + (order.badgeBg || '') + ' ' + (order.badgeText || '');
                    badge.textContent = order.status || '';
                }

                // Isi info pembeli
                const elName    = document.getElementById('modal-buyer-name');
                const elPhone   = document.getElementById('modal-buyer-phone');
                const elAddress = document.getElementById('modal-buyer-address');
                if (elName)    elName.textContent    = order.buyer_name    || '-';
                if (elPhone)   elPhone.textContent   = order.buyer_phone   || '-';
                if (elAddress) elAddress.textContent = order.buyer_address || '-';

                const itemsContainer = document.getElementById('modal-items');
                if (itemsContainer) {
                    itemsContainer.innerHTML = '';

                    order.items.forEach(function(item) {
                        itemsContainer.innerHTML += '<div class="mb-4 rounded-[20px] bg-[#f4ede5] px-3 py-4 sm:px-4 sm:py-5 last:mb-0">'
                            + '<div class="flex items-center gap-3 sm:gap-4">'
                            + '<img src="' + item.img + '" alt="' + item.name + '" class="h-[72px] w-[72px] flex-shrink-0 rounded-[14px] object-cover sm:h-[82px] sm:w-[82px]">'
                            + '<div class="flex min-w-0 flex-1 items-center justify-between gap-4">'
                            + '<div>'
                            + '<h4 class="text-sm font-semibold leading-snug text-[#5c4432] sm:text-base">' + item.name + '</h4>'
                            + '<p class="mt-1 text-xs text-[#7b6858]">Ukuran : ' + item.size + '</p>'
                            + '</div>'
                            + '<div class="text-right">'
                            + '<p class="text-sm font-semibold leading-none text-[#7a5a43] sm:text-base">' + item.subtotal + '</p>'
                            + '<p class="mt-1 text-xs font-medium text-[#7b6858] sm:mt-2 sm:text-sm">x' + item.qty + '</p>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                            + '</div>';
                    });
                }

                const elTotal = document.getElementById('modal-total');
                if (elTotal) elTotal.textContent = order.total;

                // Konfigurasi Footer Aksi Dinamis
                const footer = document.getElementById('modal-footer');
                if (footer) {
                    footer.innerHTML = '';
                    footer.classList.add('hidden');
                    footer.classList.remove('flex');

                    if (order.raw_status === 'pending') {
                        footer.classList.remove('hidden');
                        footer.classList.add('flex');

                        // Tombol Batalkan Pesanan
                        const btnCancel = document.createElement('button');
                        btnCancel.textContent = 'Batalkan Pesanan';
                        btnCancel.className = 'rounded-xl border border-[#dc2626] bg-white px-5 py-2.5 text-sm font-semibold text-[#dc2626] transition hover:bg-[#fef2f2]';
                        btnCancel.onclick = function() {
                            cancelOrder(order.raw_id);
                        };

                        // Tombol Bayar Sekarang
                        const btnPay = document.createElement('button');
                        btnPay.textContent = 'Bayar Sekarang';
                        btnPay.className = 'rounded-xl bg-[#47c17b] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#3ca468]';
                        btnPay.onclick = function() {
                            payExistingOrder(order.raw_id, order.snap_token);
                        };

                        footer.appendChild(btnCancel);
                        footer.appendChild(btnPay);

                    } else if (order.raw_status === 'cancel' || order.raw_status === 'expire' || order.raw_status === 'settlement') {
                        footer.classList.remove('hidden');
                        footer.classList.add('flex');

                        // Tombol Beli Lagi
                        const btnReorder = document.createElement('button');
                        btnReorder.textContent = 'Beli Lagi';
                        btnReorder.className = 'rounded-xl bg-[#BFA28C] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#A88A72]';
                        btnReorder.onclick = function() {
                            btnReorder.disabled = true;
                            btnReorder.textContent = 'Memproses...';
                            reorderItems(order.items);
                        };

                        footer.appendChild(btnReorder);
                    }
                }

                openOrderModal();
            } catch (err) {
                console.error("Terjadi error di openOrderDetail:", err);
            }
        }

        function cancelOrder(orderId) {
            const modal = document.getElementById('modal-confirm-cancel');
            const btnClose = document.getElementById('btn-cancel-modal-close');
            const btnSubmit = document.getElementById('btn-cancel-modal-submit');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            btnClose.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };
            
            btnSubmit.onclick = async function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                
                const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
                const csrf = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

                try {
                    const res = await fetch('/profile/order/' + orderId + '/cancel', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();
                    if (res.ok && data.success) {
                        if (typeof window.showCustomAlert === 'function') {
                            window.showCustomAlert('Pesanan berhasil dibatalkan.', 'success', () => { window.location.reload(); });
                        } else {
                            alert('Pesanan berhasil dibatalkan.');
                            window.location.reload();
                        }
                    } else {
                        const errMsg = data.error || 'Gagal membatalkan pesanan.';
                        if (typeof window.showCustomAlert === 'function') {
                            window.showCustomAlert(errMsg, 'error');
                        } else {
                            alert(errMsg);
                        }
                    }
                } catch (err) {
                    console.error("Gagal membatalkan pesanan:", err);
                    if (typeof window.showCustomAlert === 'function') {
                        window.showCustomAlert('Terjadi kesalahan jaringan.', 'error');
                    } else {
                        alert('Terjadi kesalahan jaringan.');
                    }
                }
            };
        }

        async function reorderItems(items) {
            const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
            const csrf = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

            try {
                for (const item of items) {
                    const formData = new FormData();
                    formData.append('_token', csrf);
                    formData.append('stok_id', item.stok_id);
                    formData.append('qty', item.qty || 1);

                    await fetch('/cart/add', {
                        method: 'POST',
                        body: formData
                    });
                }
                window.location.href = '/cart';
            } catch (err) {
                console.error(err);
                alert('Gagal memproses Beli Lagi.');
            }
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

        async function payExistingOrder(rawId, snapToken) {
            if (!window.snap) {
                alert('Midtrans Snap tidak termuat dengan benar. Coba refresh halaman.');
                return;
            }

            // Cari tombol Bayar Sekarang dan set loading state
            const footer = document.getElementById('modal-footer');
            const payBtn = footer ? Array.from(footer.querySelectorAll('button')).find(b => b.textContent.includes('Bayar')) : null;
            if (payBtn) {
                payBtn.disabled = true;
                payBtn.textContent = 'Memuat...';
            }

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

            // Selalu refresh token dari server agar tidak kadaluarsa
            try {
                const res = await fetch('/profile/order/' + rawId + '/snap-token', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    }
                });

                const data = await res.json();

                if (res.ok && data.snap_token) {
                    snapToken = data.snap_token;
                } else {
                    console.warn('[payExistingOrder] Gagal refresh token, pakai token lama:', data.error);
                    // Lanjut dengan token lama jika ada
                }
            } catch (err) {
                console.warn('[payExistingOrder] Network error saat refresh token, pakai token lama:', err);
            }

            // Reset tombol sebelum buka popup
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.textContent = 'Bayar Sekarang';
            }

            if (!snapToken) {
                alert('Token pembayaran tidak valid. Silakan coba lagi.');
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    if (typeof window.showCustomAlert === 'function') {
                        window.showCustomAlert('Pembayaran berhasil! Terima kasih.', 'success', () => { window.location.reload(); });
                    } else {
                        alert('Pembayaran berhasil! Terima kasih.');
                        window.location.reload();
                    }
                },
                onPending: function(result){
                    if (typeof window.showCustomAlert === 'function') {
                        window.showCustomAlert('Menunggu pembayaran Anda!', 'success', () => { window.location.reload(); });
                    } else {
                        alert('Menunggu pembayaran Anda!');
                        window.location.reload();
                    }
                },
                onError: function(result){
                    if (typeof window.showCustomAlert === 'function') {
                        window.showCustomAlert('Pembayaran gagal!', 'error');
                    } else {
                        alert('Pembayaran gagal!');
                    }
                },
                onClose: function(){
                    // Optional: do nothing
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            switchTab('akun');

            // Auto-polling untuk pesanan pending agar status terupdate otomatis tanpa webhook
            const pendingOrders = Object.values(orders).filter(o => o.raw_status === 'pending');
            if (pendingOrders.length > 0) {
                setInterval(async () => {
                    let shouldReload = false;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
                    
                    for (const order of pendingOrders) {
                        try {
                            const formData = new FormData();
                            formData.append('order_id', order.id);
                            
                            const res = await fetch('{{ route("checkout.status") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });

                            if (res.ok) {
                                const data = await res.json();
                                // Jika status di midtrans sudah bukan pending lagi, reload halaman
                                if (data.transaction_status && !['pending'].includes(data.transaction_status)) {
                                    shouldReload = true;
                                    break;
                                }
                            }
                        } catch (e) {
                            console.warn('Polling status error', e);
                        }
                    }
                    if (shouldReload) {
                        window.location.reload();
                    }
                }, 5000); // Poll setiap 5 detik
            }
        });
    </script>
@endpush