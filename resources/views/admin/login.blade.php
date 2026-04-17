<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .soft-shadow {
            box-shadow: 0 24px 60px rgba(92, 68, 50, 0.15);
        }

        .brown-gradient {
            background: linear-gradient(135deg, #c9b8a6 0%, #b9a48f 100%);
        }

        .left-gradient {
            background: linear-gradient(135deg, #c9b8a6 0%, #b9a48f 45%, #a78d78 100%);
        }

        .fade-up {
            animation: fadeUp 0.5s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#e6dbcf] flex items-center justify-center px-4 py-8">
    <!-- <body class="min-h-screen bg-[#f7f2eb] flex items-center justify-center px-4 py-8"> -->

    <div class="w-full max-w-6xl rounded-[34px] overflow-hidden bg-white soft-shadow fade-up">
        <div class="grid md:grid-cols-2 min-h-[620px]">

            <!-- LEFT SIDE -->
            <div class="relative bg-gradient-to-r from-[#c9b8a6] via-[#b9a48f] to-[#a78d78] text-white overflow-hidden">
                <div class="absolute inset-0 bg-black/5"></div>
                <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-24 -right-16 w-72 h-72 rounded-full bg-white/10"></div>

                <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-10 py-12">
                    <div class="w-[290px] h-[360px] rounded-[30px] overflow-hidden border border-white/20 shadow-2xl bg-white/10 backdrop-blur-sm">
                        <img src="{{ asset('images/logo.png') }}"
                            alt="Fashion wanita"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="bg-[#f4ede5] flex items-center justify-center px-8 py-10 md:px-14">
                <div class="w-full max-w-md">
                    <div class="text-center mb-10">
                        <h2 class="text-4xl font-bold text-[#5c4432]">Login</h2>
                    </div>

                    <form class="space-y-5" onsubmit="return false;">

                        <!-- USERNAME -->
                        <div>
                            <label class="block text-sm font-semibold text-[#5c4432] mb-2">
                                Username
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#a78d78]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                                    </svg>
                                </span>
                                <input
                                    name="username"
                                    type="text"
                                    placeholder="Masukkan username"
                                    class="w-full h-14 rounded-2xl border border-[#e0d2c3] bg-[#fbf7f2] pl-12 pr-4 text-[#5c4432] placeholder:text-[#b7a08c] focus:outline-none focus:ring-2 focus:ring-[#a78d78] focus:border-[#a78d78] transition">
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <label class="block text-sm font-semibold text-[#5c4432] mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#a78d78]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5M5.25 10.5h13.5v8.25a2.25 2.25 0 01-2.25 2.25H7.5a2.25 2.25 0 01-2.25-2.25V10.5z" />
                                    </svg>
                                </span>
                                <input
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    class="w-full h-14 rounded-2xl border border-[#e0d2c3] bg-[#fbf7f2] pl-12 pr-4 text-[#5c4432] placeholder:text-[#b7a08c] focus:outline-none focus:ring-2 focus:ring-[#a78d78] focus:border-[#a78d78] transition">
                            </div>
                        </div>

                        <br>

                        <button
                            type="button"
                            class="w-full h-14 rounded-2xl bg-[#a78d78] hover:bg-[#8f7561] text-white text-lg font-semibold shadow-[0_14px_28px_rgba(167,141,120,0.28)] transition">
                            Login
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>