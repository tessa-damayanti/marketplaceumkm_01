<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta-description', 'Velora - Toko fashion wanita modern dengan koleksi kemeja, gaun, cardigan, dan rok berkualitas.')">
    <title>@yield('title', 'Velora') — Velora Fashion</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
        
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body
    class="bg-[#f7f2eb] text-[#5c4432] scroll-smooth font-['Poppins',sans-serif]"
    data-checkout-url="{{ route('checkout') }}"
    data-login-url="{{ route('login') }}"
    data-is-buyer="{{ session('role') === 'buyer' ? 'true' : 'false' }}"
>

    @if(!request()->routeIs('cart', 'checkout'))
        <x-navbar />
    @endif

    <main>
        @yield('content')
    </main>

    @if(!request()->routeIs('cart', 'checkout'))
        <x-footer />
    @endif

    @stack('scripts')
</body>

</html>