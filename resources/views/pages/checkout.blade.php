@php
    $name = request('name');
    $price = request('price');
    $qty = request('qty');
    $total = (int) $price * (int) $qty;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f2eb] text-[#5c4432]">

<div class="min-h-screen w-full p-4 md:p-8">
    <div class="flex min-h-[calc(100vh-2rem)] w-full items-stretch overflow-hidden rounded-2xl border border-[#c9b7a7] bg-white shadow-sm md:min-h-[calc(100vh-4rem)]">

        <div class="flex w-full flex-col">
            <div class="border-b border-[#c9b7a7] px-8 py-6">
                <h1 class="text-4xl font-bold text-[#5c4432]">Form Pemesanan</h1>
            </div>

            <div class="grid flex-1 md:grid-cols-2">
                <div class="border-b border-[#c9b7a7] p-8 md:border-b-0 md:border-r">
                    <h2 class="mb-8 text-2xl font-semibold text-[#2f241d]">Informasi Pembeli</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="mb-2 block text-lg font-medium text-[#2f241d]">Nama Pembeli</label>
                            <input
                                type="text"
                                class="w-full rounded-xl border border-[#8f7561] px-4 py-3 outline-none focus:border-[#5c4432]"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-lg font-medium text-[#2f241d]">No Hp</label>
                            <input
                                type="text"
                                class="w-full rounded-xl border border-[#8f7561] px-4 py-3 outline-none focus:border-[#5c4432]"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-lg font-medium text-[#2f241d]">Alamat</label>
                            <textarea
                                rows="6"
                                class="w-full rounded-xl border border-[#8f7561] px-4 py-3 outline-none focus:border-[#5c4432]"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col p-8">
                    <h2 class="mb-8 text-2xl font-semibold text-[#2f241d]">Pembayaran (DANA)</h2>

                    <div class="mb-6">
                        <p class="mb-2 text-lg text-[#2f241d]">No. Dana Tujuan</p>
                        <p class="text-3xl font-bold text-[#2f241d]">0812-3456-7890</p>
                    </div>

                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-lg font-medium text-[#2f241d]">Total Pembayaran</p>
                            @if($name)
                                <p class="mt-1 text-sm text-[#7b6858]">{{ $name }} x {{ $qty }}</p>
                            @endif
                        </div>
                        <p class="text-2xl font-bold text-[#5c4432]">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="mb-8 flex-1">
                        <p class="mb-4 text-2xl font-semibold text-[#2f241d]">Upload Bukti Pembayaran</p>

                        <label for="bukti-transfer" class="block h-full cursor-pointer">
                            <div class="flex h-[260px] w-full items-center justify-center rounded-2xl border border-[#8f7561] bg-[#f8f5f1] transition hover:bg-[#f2ebe3]">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-24 w-24 text-[#6e5a4c]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                        <path d="M8 15l2.5-3 2.5 3 2-2 3 4"></path>
                                        <circle cx="9" cy="9" r="1"></circle>
                                    </svg>
                                    <p class="text-base text-[#6e5a4c]">Klik untuk upload gambar</p>
                                    <p class="mt-1 text-sm text-[#9a8575]">Format: JPG / PNG</p>
                                </div>
                            </div>
                            <input id="bukti-transfer" type="file" accept=".jpg,.jpeg,.png" class="hidden">
                        </label>
                    </div>

                    <button class="w-full rounded-xl bg-[#d9d4d0] py-4 text-xl font-semibold text-[#2f241d] transition hover:bg-[#cfc8c2]">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>