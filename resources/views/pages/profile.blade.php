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
                <x-user.profile-history :pesanans="$pesanans" :status="$status" />
                <x-user.profile-password />
            </div>

        </div>
    </div>

    {{-- Modals --}}
    <x-user.profile-modals />

    {{-- Toast --}}
    <x-user.profile-toast />

@php
    // Mapping badge warna per status
    $badgeMap = [
        'pending'    => ['bg' => 'bg-[#fff1bd]',  'text' => 'text-[#b45a00]'],
        'settlement' => ['bg' => 'bg-[#dcfce7]',  'text' => 'text-[#15803d]'],
        'cancel'     => ['bg' => 'bg-[#fee2e2]',  'text' => 'text-[#dc2626]'],
        'expire'     => ['bg' => 'bg-[#f3f4f6]',  'text' => 'text-[#6b7280]'],
    ];

    // Status dalam Bahasa Indonesia
    $statusLabel = [
        'pending'    => 'Menunggu Pembayaran',
        'settlement' => 'Pembayaran Berhasil',
        'cancel'     => 'Pembayaran Dibatalkan',
        'expire'     => 'Pembayaran Kedaluwarsa',
    ];

    // Array data pesanan untuk dikirim ke JS
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
                'trashed'  => $produk?->trashed() ?? false,
            ];
        }

        $ordersData[$pesanan->id] = [
            'id'             => $pesanan->order_id ?? 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT),
            'raw_id'         => $pesanan->id,
            'date'           => \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->setTimezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB',
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
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="application/json" id="orders-data">{!! json_encode($ordersData) !!}</script>
    <script>
        // Data pesanan dari server
        let orders = {};
        try {
            const ordersEl = document.getElementById('orders-data');
            if (ordersEl) {
                orders = JSON.parse(ordersEl.textContent);
            }
        } catch (e) {
            console.error("Gagal melakukan parse orders-data:", e);
        }


        function switchTab(tabId, updateHistory = true) {
            const tabAkun     = document.getElementById('tab-akun');
            const tabRiwayat  = document.getElementById('tab-riwayat');
            const tabPassword = document.getElementById('tab-password');

            if (tabAkun) {
                tabAkun.classList.add('hidden');
                tabAkun.classList.remove('block');
            }
            if (tabRiwayat) {
                tabRiwayat.classList.add('hidden');
                tabRiwayat.classList.remove('block');
            }
            if (tabPassword) {
                tabPassword.classList.add('hidden');
                tabPassword.classList.remove('block');
            }

            const activeTab = document.getElementById('tab-' + tabId);
            if (activeTab) {
                activeTab.classList.remove('hidden');
                activeTab.classList.add('block');
            }

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

            if (updateHistory) {
                const cleanUrl = window.location.origin + window.location.pathname;
                if (window.location.href !== cleanUrl) {
                    window.history.pushState({path: cleanUrl}, '', cleanUrl);
                }
            }
        }

        async function loadHistory(url) {
            const container = document.getElementById('tab-riwayat');
            container.style.pointerEvents = 'none';
            
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newHistory = doc.getElementById('tab-riwayat');
                if (newHistory) {
                    container.innerHTML = newHistory.innerHTML;
                }
                
                // Update URL di browser tanpa reload
                window.history.pushState({path: url}, '', url);
                
                // Perbarui data JSON modal order
                const newOrdersData = doc.getElementById('orders-data');
                if (newOrdersData) {
                    orders = JSON.parse(newOrdersData.textContent);
                    document.getElementById('orders-data').textContent = newOrdersData.textContent;
                }
            } catch (e) {
                console.error(e);
                window.location.href = url; // Fallback jika fetch gagal
            } finally {
                container.style.pointerEvents = 'auto';
            }
        }

        function openOrderModal() {
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            document.body.classList.add('modal-open');
            document.documentElement.classList.add('modal-open');
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            document.body.classList.remove('modal-open');
            document.documentElement.classList.remove('modal-open');
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
                    badge.className = 'mt-1 md:mt-2 inline-flex rounded-full px-3 py-1 text-[10px] md:px-5 md:py-2 md:text-sm font-semibold ' + (order.badgeBg || '') + ' ' + (order.badgeText || '');
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
                        itemsContainer.innerHTML += '<div class="mb-3 rounded-[16px] bg-[#f4ede5] p-3 md:p-4 last:mb-0">'
                            + '<div class="flex items-center gap-3 md:gap-4">'
                            + '<img src="' + item.img + '" alt="' + item.name + '" class="h-14 w-14 md:h-[72px] md:w-[72px] flex-shrink-0 rounded-[12px] object-cover">'
                            + '<div class="flex min-w-0 flex-1 items-center justify-between gap-3 md:gap-4">'
                            + '<div>'
                            + '<h4 class="text-xs md:text-sm font-bold leading-snug text-[#5c4432]">' + item.name + '</h4>'
                            + '<p class="mt-1 text-[10px] md:text-xs text-[#7b6858]">Ukuran : ' + item.size + '</p>'
                            + '</div>'
                            + '<div class="text-right flex-shrink-0">'
                            + '<p class="text-xs md:text-sm font-bold leading-none text-[#7a5a43]">' + item.subtotal + '</p>'
                            + '<p class="mt-1 text-[10px] md:text-xs font-semibold text-[#7b6858]">x' + item.qty + '</p>'
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
                        btnCancel.className = 'rounded-xl border border-[#dc2626] bg-white px-4 py-2 text-xs md:px-5 md:py-2.5 md:text-sm font-semibold text-[#dc2626] transition-all duration-300 ease-in-out hover:bg-[#fef2f2] hover:scale-[1.03] active:scale-[0.97]';
                        btnCancel.onclick = function() {
                            cancelOrder(order.raw_id);
                        };
 
                        // Tombol Bayar Sekarang
                        const btnPay = document.createElement('button');
                        btnPay.textContent = 'Bayar Sekarang';
                        btnPay.className = 'rounded-xl bg-[#47c17b] px-4 py-2 text-xs md:px-5 md:py-2.5 md:text-sm font-semibold text-white transition-all duration-300 ease-in-out hover:bg-[#3ca468] hover:scale-[1.03] active:scale-[0.97] hover:shadow-lg hover:shadow-green-500/20';
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
                        btnReorder.className = 'rounded-xl bg-[#BFA28C] px-4 py-2 text-xs md:px-5 md:py-2.5 md:text-sm font-semibold text-white transition-all duration-300 ease-in-out hover:bg-[#A88A72] hover:scale-[1.03] active:scale-[0.97] hover:shadow-lg hover:shadow-[#BFA28C]/20';
                        btnReorder.onclick = function() {
                            btnReorder.disabled = true;
                            btnReorder.textContent = 'Memproses...';
                            reorderItems(order.items, btnReorder);
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
            document.body.classList.add('modal-open');
            document.documentElement.classList.add('modal-open');
            
            btnClose.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('modal-open');
                document.documentElement.classList.remove('modal-open');
            };
            
            btnSubmit.onclick = async function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('modal-open');
                document.documentElement.classList.remove('modal-open');
                
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
                            window.showCustomAlert('Pesanan berhasil dibatalkan.', 'success');
                            setTimeout(() => {
                                window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
                            }, 1500);
                        } else {
                            alert('Pesanan berhasil dibatalkan.');
                            window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
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

        async function reorderItems(items, btnEl) {
            const activeItems = items.filter(item => !item.trashed);
            if (activeItems.length === 0) {
                if (typeof window.showCustomAlert === 'function') {
                    window.showCustomAlert('Produk di dalam pesanan ini sudah tidak tersedia.', 'error');
                } else {
                    alert('Produk di dalam pesanan ini sudah tidak tersedia.');
                }
                if (btnEl) {
                    btnEl.disabled = false;
                    btnEl.textContent = 'Beli Lagi';
                }
                return;
            }

            const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
            const csrf = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

            try {
                for (const item of activeItems) {
                    const formData = new FormData();
                    formData.append('_token', csrf);
                    formData.append('stok_id', item.stok_id);
                    formData.append('qty', item.qty || 1);

                    await fetch('/cart/add', {
                        method: 'POST',
                        body: formData
                    });
                }
                const reorderedStoks = activeItems.map(i => i.stok_id);
                localStorage.setItem('reordered_stoks', JSON.stringify(reorderedStoks));
                window.location.href = '/cart';
            } catch (err) {
                console.error(err);
                alert('Gagal memproses Beli Lagi.');
                if (btnEl) {
                    btnEl.disabled = false;
                    btnEl.textContent = 'Beli Lagi';
                }
            }
        }

        function openLogoutModal() {
            const modal = document.getElementById('modal-logout');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('modal-open');
            document.documentElement.classList.add('modal-open');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('modal-logout');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('modal-open');
            document.documentElement.classList.remove('modal-open');
        }

        // Lanjutkan pembayaran pesanan pending
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
                    // Update order_id agar polling berikutnya pakai ID terbaru
                    if (data.new_order_id) {
                        const orderEntry = Object.values(orders).find(o => o.raw_id == rawId);
                        if (orderEntry) {
                            orderEntry.id = data.new_order_id;
                        }
                    }
                } else {
                    if (res.status === 422) {
                        if (typeof window.showCustomAlert === 'function') {
                            window.showCustomAlert(data.error || 'Batas waktu pembayaran sudah habis.', 'error', () => {
                                window.location.reload();
                            });
                        } else {
                            alert(data.error || 'Batas waktu pembayaran sudah habis.');
                            window.location.reload();
                        }
                        return;
                    }
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
                        window.showCustomAlert('Pembayaran berhasil! Terima kasih.', 'success');
                        setTimeout(() => {
                            window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
                        }, 1500);
                    } else {
                        alert('Pembayaran berhasil! Terima kasih.');
                        window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
                    }
                },
                onPending: function(result){
                    if (typeof window.showCustomAlert === 'function') {
                        window.showCustomAlert('Menunggu pembayaran Anda!', 'success');
                        setTimeout(() => {
                            window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
                        }, 1500);
                    } else {
                        alert('Menunggu pembayaran Anda!');
                        window.location.href = "{{ route('profile') }}?tab=riwayat&status=all";
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
                    
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            const pageParam = urlParams.get('page');
            const statusParam = urlParams.get('status') || '{{ $status ?? "all" }}';
            
            if (tabParam && ['akun', 'riwayat', 'password'].includes(tabParam)) {
                switchTab(tabParam, false);
                // Immediately clean the URL so the ?tab=... goes away from the address bar
                const cleanUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({path: cleanUrl}, '', cleanUrl);
            } else if (pageParam || urlParams.get('status')) {
                switchTab('riwayat', false);
            } else {
                switchTab('akun', false);
            }

            // Penghapusan cleanUrl karena AJAX pushState membutuhkan param tetap di URL

            // Update status pembayaran
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