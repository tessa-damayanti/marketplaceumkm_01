<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Marketplace UMKM Fashion Wanita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f5eee6] flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl w-[400px] p-10">

        <!-- LOGO -->
        <div class="flex flex-col items-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                class="w-20 mb-3">

            <h1 class="text-2xl font-bold text-[#5c3d2e]">
                Marketplace UMKM
            </h1>

        </div>

        <form method="POST" action="/login">
            @csrf

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-2">Username</label>
                <input type="text"
                    name="username"
                    class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#a47148]"
                    placeholder="Masukkan username">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-600 mb-2">Password</label>
                <input type="password"
                    name="password"
                    class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#a47148]"
                    placeholder="Masukkan password">
            </div>

            <!-- Button -->
            <button
                class="w-full bg-[#8b5e3c] text-white py-3 rounded-lg hover:bg-[#6f4e37] transition">
                Login
            </button>

        </form>

        <p class="text-xs text-gray-400 text-center mt-6">
            © 2026 Marketplace UMKM Fashion Wanita
        </p>

    </div>

</body>

</html>