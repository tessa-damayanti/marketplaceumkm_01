@php
    $user = auth()->user();
    $buyerName    = session('buyer_name',    $user ? $user->nama_lengkap : '');
    $buyerPhone   = session('buyer_phone',   $user ? $user->no_wa : '');
    $buyerAddress = session('buyer_address', $user ? $user->alamat : '');

    if (request('name')) {
        $cartItems = [[
            'name'  => request('name'),
            'price' => (int) request('price'),
            'qty'   => (int) request('qty', 1),
            'size'  => request('size') ?: 'M',
            'image' => request('image') ?: '',
        ]];
    } else {
        $selected = request('selected');
        $query = \App\Models\Keranjang::with(['stok.produk.kategori', 'stok.ukuran'])
            ->where('user_id', auth()->id());
        if (is_array($selected) && count($selected) > 0) {
            $query->whereIn('id', $selected);
        }
        $dbCart = $query->get();

        $cartItems = [];
        foreach ($dbCart as $item) {
            if (!$item->stok || !$item->stok->produk) continue;
            $cartItems[$item->id] = [
                'name' => $item->stok->produk->nama,
                'price' => (int) $item->stok->produk->harga,
                'qty' => $item->jumlah,
                'size' => $item->stok->ukuran ? $item->stok->ukuran->nama_ukuran : 'M',
                'image' => $item->stok->produk->image ? asset('images/' . $item->stok->produk->image) : 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
            ];
        }
    }

    $grandTotal       = collect($cartItems)->sum(fn($i) => (int) $i['price'] * (int) $i['qty']);
    $orderFingerprint = md5($grandTotal . collect($cartItems)->pluck('name')->join(','));
@endphp

@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
<style>
    html, body { overscroll-behavior: none; }
    body { background-color: #f7f2eb; color: #2f241d; }
    #pay-modal.open  { opacity: 1; pointer-events: auto; }
    #pay-modal.open #pay-card { transform: translateY(0); }
    #section-qris.show, #section-va.show,
    #status-indicator.show { display: flex; }
</style>
@endpush

@section('content')
<div class="min-h-screen px-5 py-8 md:px-10">
    <div class="mx-auto max-w-6xl">
        
        <!-- Back Button -->
        <div class="mb-4">
            <button type="button" onclick="window.history.back()" class="inline-flex items-center gap-2 text-sm text-[#8c7563] transition hover:text-[#A98B76]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </button>
        </div>

        <div class="overflow-hidden rounded-[28px] border border-[#e5d8ca] bg-white shadow-[0_14px_45px_rgba(92,68,50,0.10)]">

        <div class="border-b border-[#e5d8ca] bg-[#efe4d8] px-5 py-4 sm:px-8 sm:py-6">
            <h1 class="text-xl font-bold text-[#5c4432] sm:text-3xl">Beli Sekarang</h1>
        </div>

        <form id="checkout-form" action="{{ route('checkout.charge') }}" method="POST">
            @csrf
            <input type="hidden" name="grand_total" value="{{ $grandTotal }}">

            {{-- Kirim item yang dibeli --}}
            @if(request('name') && request('stok_id'))
                {{-- Beli Langsung: kirim stok_id + qty --}}
                <input type="hidden" name="stok_id" value="{{ request('stok_id') }}">
                <input type="hidden" name="qty" value="{{ request('qty', 1) }}">
            @else
                {{-- Checkout dari Keranjang: kirim cart_ids[] --}}
                @foreach(array_keys($cartItems) as $cartId)
                    <input type="hidden" name="cart_ids[]" value="{{ $cartId }}">
                @endforeach
            @endif
            <div class="grid md:grid-cols-[1fr_1.05fr]">
                <x-user.checkout-buyer :buyerName="$buyerName" :buyerPhone="$buyerPhone" :buyerAddress="$buyerAddress" />
                <div class="p-5 sm:p-8">
                    <x-user.checkout-summary :cartItems="$cartItems" :grandTotal="$grandTotal" />
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const CHARGE_URL = '{{ route("checkout.charge") }}';
const PROFILE_URL = '{{ route("profile") }}?tab=riwayat';
const CSRF       = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const payBtn = document.getElementById('pay-btn');

function resetPayBtn() {
    payBtn.disabled = false;
    payBtn.textContent = 'Bayar Sekarang';
}

function showAlert(msg, type, cb) {
    if (typeof window.showCustomAlert === 'function') {
        window.showCustomAlert(msg, type, cb || null);
    } else { 
        alert(msg); 
        if (cb) cb(); 
    }
}

function clearErrors() {
    ['buyer_name', 'buyer_phone', 'buyer_address'].forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        const errSpan = document.getElementById(`err_${field}`);
        if (input) {
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/15');
            input.classList.add('border-[#dccabb]', 'focus:border-[#a78d78]', 'focus:ring-[#a78d78]/15');
        }
        if (errSpan) {
            errSpan.textContent = '';
            errSpan.classList.add('hidden');
        }
    });
}

document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    payBtn.textContent = 'Memproses...';
    payBtn.disabled    = true;
    
    clearErrors();

    const formData = new FormData(this);

    try {
        const res = await fetch(CHARGE_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData,
        });

        if (res.status === 419) { 
            resetPayBtn(); 
            showAlert('Sesi berakhir. Refresh halaman.', 'error'); 
            return; 
        }

        const data = await res.json().catch(() => { throw new Error('Respon bukan JSON'); });

        if (res.ok && data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result){
                    showAlert('Pembayaran berhasil! Terima kasih.', 'success', () => { window.location.href = PROFILE_URL; });
                },
                onPending: function(result){
                    showAlert('Menunggu pembayaran Anda!', 'success', () => { window.location.href = PROFILE_URL; });
                },
                onError: function(result){
                    showAlert('Pembayaran gagal!', 'error');
                    resetPayBtn();
                },
                onClose: function(){
                    resetPayBtn();
                }
            });
        } else if (res.status === 422) {
            resetPayBtn();
            if (data.errors) {
                for (const field in data.errors) {
                    const input = document.querySelector(`[name="${field}"]`);
                    const errSpan = document.getElementById(`err_${field}`);
                    if (input) {
                        input.classList.remove('border-[#dccabb]', 'focus:border-[#a78d78]', 'focus:ring-[#a78d78]/15');
                        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/15');
                    }
                    if (errSpan) {
                        errSpan.textContent = data.errors[field][0];
                        errSpan.classList.remove('hidden');
                    }
                }
            } else {
                showAlert('Validasi gagal: ' + (data.message || 'Periksa data Anda.'), 'error');
            }
        } else {
            resetPayBtn();
            showAlert('Gagal: ' + (data.error || data.message || 'Terjadi kesalahan.'), 'error');
        }

    } catch (err) {
        console.error('[Checkout]', err);
        resetPayBtn();
        showAlert('Kesalahan jaringan. Periksa koneksi Anda.', 'error');
    }
});
</script>
@endpush