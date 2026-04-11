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
            box-shadow: 0 24px 60px rgba(105, 76, 57, 0.15);
        }

        .brown-gradient {
            background: linear-gradient(135deg, #c59a7d 0%, #a97d5d 100%);
        }

        .left-gradient {
            background: linear-gradient(135deg, #c59a7d 0%, #b08467 45%, #8f654a 100%);
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

<body class="min-h-screen bg-[#f8f3ee] flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-6xl rounded-[34px] overflow-hidden bg-white soft-shadow fade-up">
        <div class="grid md:grid-cols-2 min-h-[620px]">

            <!-- LEFT SIDE -->
            <div class="relative left-gradient text-white overflow-hidden">
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
            <div class="bg-[#fffaf6] flex items-center justify-center px-8 py-10 md:px-14">
                <div class="w-full max-w-md">
                    <div class="text-center mb-10">
                        <h2 class="text-4xl font-bold text-[#5d4030]">Login</h2>
                    </div>

                    <form class="space-y-5" method="GET" action="{{ route('admin.dashboard') }}">
                        <div>
                            <label class="block text-sm font-semibold text-[#6f5443] mb-2">
                                Username
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#b08a71] text-lg">👤</span>
                                <input
                                    name="username"
                                    type="text"
                                    placeholder="Masukkan username"
                                    class="w-full h-14 rounded-2xl border border-[#e5d6c8] bg-white pl-12 pr-4 text-[#5a4030] placeholder:text-[#b79b87] focus:outline-none focus:ring-2 focus:ring-[#c79d7d] focus:border-[#c79d7d] transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#6f5443] mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#b08a71] text-lg">🔒</span>
                                <input
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    class="w-full h-14 rounded-2xl border border-[#e5d6c8] bg-white pl-12 pr-4 text-[#5a4030] placeholder:text-[#b79b87] focus:outline-none focus:ring-2 focus:ring-[#c79d7d] focus:border-[#c79d7d] transition">
                            </div>
                        </div>
                        <br>
                        <button
                            type="submit"
                            class="w-full h-14 rounded-2xl bg-[#b08467] hover:bg-[#996e52] text-white text-lg font-semibold shadow-[0_14px_28px_rgba(176,132,103,0.28)] transition">
                            Login
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>