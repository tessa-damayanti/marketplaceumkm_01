@php
    $buyerName = session('buyer_name', 'Nikita Willy');
    $buyerPhone = session('buyer_phone', '0812-3456-7890');
    $buyerAddress = session('buyer_address', 'Jl. Melati No. 12, Bandung');

    $cartItems = session('cart', []);

    if (empty($cartItems) && request('name')) {
        $cartItems[] = [
            'name' => request('name'),
            'price' => (int) request('price'),
            'qty' => (int) request('qty', 1),
            'size' => request('size', '-'),
            'image' => request('image', ''),
        ];
    }

    $grandTotal = collect($cartItems)->sum(fn ($item) => (int) $item['price'] * (int) $item['qty']);
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f7f2eb] text-[#2f241d]">

<div class="min-h-screen px-5 py-8 md:px-10">
    <div class="mx-auto max-w-6xl overflow-hidden rounded-[28px] border border-[#e5d8ca] bg-white shadow-[0_14px_45px_rgba(92,68,50,0.10)]">

        <div class="border-b border-[#e5d8ca] bg-[#efe4d8] px-8 py-6">
            <h1 class="text-3xl font-bold text-[#5c4432]">Beli Sekarang</h1>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" onsubmit="showOrderToast(event)">
            @csrf

            <div class="grid md:grid-cols-[1fr_1.05fr]">
                @include('components.user.checkout-buyer')

                <div class="p-8">
                    @include('components.user.checkout-summary')
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.user.checkout-toast')

</body>
</html>