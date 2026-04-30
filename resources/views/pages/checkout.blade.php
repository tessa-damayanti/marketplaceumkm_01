@php
    $buyerName = session('buyer_name', 'Nikita Willy');
    $buyerPhone = session('buyer_phone', '0812-3456-7890');
    $buyerAddress = session('buyer_address', 'Jl. Melati No. 12, Bandung');

    if (request('name')) {
        $cartItems = [[
            'name' => request('name'),
            'price' => (int) request('price'),
            'qty' => (int) request('qty', 1),
            'size' => request('size') ?: 'M',
            'image' => request('image') ?: 'https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg',
        ]];
    } else {
        $allCartItems = session('cart', []);
        $selected = request('selected');
        
        if (is_array($selected) && count($selected) > 0) {
            $cartItems = collect($allCartItems)->filter(function ($item, $key) use ($selected) {
                return in_array($key, $selected);
            })->all();
        } else {
            $cartItems = $allCartItems;
        }
    }

    $grandTotal = collect($cartItems)->sum(fn ($item) => (int) $item['price'] * (int) $item['qty']);
@endphp

@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
    <style>
        html, body {
            overscroll-behavior: none;
        }
        body {
            background-color: #f7f2eb;
            color: #2f241d;
        }
    </style>
@endpush

@section('content')
<div class="min-h-screen px-5 py-8 md:px-10">
    <div class="mx-auto max-w-6xl overflow-hidden rounded-[28px] border border-[#e5d8ca] bg-white shadow-[0_14px_45px_rgba(92,68,50,0.10)]">

        <div class="border-b border-[#e5d8ca] bg-[#efe4d8] px-5 py-4 sm:px-8 sm:py-6">
            <h1 class="text-xl font-bold text-[#5c4432] sm:text-3xl">Beli Sekarang</h1>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" onsubmit="showOrderToast(event)">
            @csrf

            <div class="grid md:grid-cols-[1fr_1.05fr]">
                @include('components.user.checkout-buyer')

                <div class="p-5 sm:p-8">
                    @include('components.user.checkout-summary')
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.user.checkout-toast')
@endsection