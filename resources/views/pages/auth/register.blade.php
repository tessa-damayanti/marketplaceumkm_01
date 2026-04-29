<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-[#e6dbcf] flex items-center justify-center px-4 py-8 scale-[0.92] font-['Poppins',sans-serif]">

    <div class="w-full max-w-5xl rounded-[34px] overflow-hidden bg-white shadow-[0_24px_60px_rgba(92,68,50,0.18)] animate-fade-up">
        <div class="grid md:grid-cols-2 min-h-[600px]">

            <!-- LEFT SIDE -->
            <div class="relative min-h-[600px] overflow-hidden">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Logo Velora"
                    class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-[#b9a48f]/30"></div>

                <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-24 -right-16 w-72 h-72 rounded-full bg-white/10"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-white/5"></div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="bg-[#a78d78] flex items-center justify-center px-8 py-10 md:px-14">
                <div class="w-full max-w-md">

                    <div class="text-center mb-9">
                        <h2 class="text-4xl font-bold text-[#fffaf6]">Registrasi</h2>
                    </div>

                    <form class="space-y-5" onsubmit="return false;">

                        <!-- USERNAME -->
                        <div>
                            <label class="block text-sm font-semibold text-[#fff4eb] mb-2">Username</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                                    </svg>
                                </span>
                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    placeholder="Masukkan username"
                                    oninput="validateUsername()"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-4 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
                            </div>
                            <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="username-msg"></p>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <label class="block text-sm font-semibold text-[#fff4eb] mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5M5.25 10.5h13.5v8.25a2.25 2.25 0 01-2.25 2.25H7.5a2.25 2.25 0 01-2.25-2.25V10.5z" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    oninput="validatePassword(); checkMatch();"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-14 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb] [appearance:textfield] [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden [&::-webkit-textfield-decoration-container]:hidden">
                                <button
                                    type="button"
                                    onclick="togglePassword(this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="password-msg"></p>
                        </div>

                        <!-- KONFIRMASI SANDI -->
                        <div>
                            <label class="block text-sm font-semibold text-[#fff4eb] mb-2">Konfirmasi sandi</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </span>
                                <input
                                    id="confirm-password"
                                    name="confirm_password"
                                    type="password"
                                    placeholder="Ulangi sandi"
                                    oninput="checkMatch()"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-14 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb] [appearance:textfield] [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden [&::-webkit-textfield-decoration-container]:hidden">
                                <button
                                    type="button"
                                    onclick="togglePassword(this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="match-msg"></p>
                        </div>

                        <!-- REGISTER BUTTON -->
                        <button
                            type="button"
                            onclick="validateForm()"
                            class="w-full h-14 rounded-2xl bg-[#e6dbcf] text-white text-base font-semibold shadow-[0_14px_28px_rgba(92,68,50,0.22)] transition-[background,box-shadow,transform] duration-200 hover:bg-[#8f7561] hover:shadow-[0_16px_32px_rgba(92,68,50,0.25)] hover:-translate-y-[1px] active:translate-y-0">
                            Daftar Sekarang
                        </button>

                        <!-- LINK LOGIN -->
                        <p class="text-center text-sm text-[#f2e4d8] pt-1">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-[#fffaf6] font-semibold ml-1 transition-colors duration-200 hover:text-white">
                                Masuk disini
                            </a>
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(btn) {
            const input = btn.closest('.relative').querySelector('input');
            const icon = btn.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
            }
        }

        function setError(inputId, msgId, message) {
            const input = document.getElementById(inputId);
            const msg = document.getElementById(msgId);

            msg.textContent = message;
            msg.classList.remove('hidden');
            input.classList.add(
                'border-[#dc2626]',
                'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]'
            );
        }

        function clearError(inputId, msgId) {
            const input = document.getElementById(inputId);
            const msg = document.getElementById(msgId);

            msg.textContent = '';
            msg.classList.add('hidden');
            input.classList.remove(
                'border-[#dc2626]',
                'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]'
            );
        }

        function validateUsername() {
            const username = document.getElementById('username').value.trim();

            if (!username) {
                setError('username', 'username-msg', 'Username wajib diisi');
                return false;
            }

            clearError('username', 'username-msg');
            return true;
        }

        function validatePassword() {
            const password = document.getElementById('password').value;

            if (!password.trim()) {
                setError('password', 'password-msg', 'Password wajib diisi');
                return false;
            }

            if (password.length < 8) {
                setError('password', 'password-msg', 'Password minimal 8 karakter');
                return false;
            }

            clearError('password', 'password-msg');
            return true;
        }

        function checkMatch() {
            const pw = document.getElementById('password').value;
            const cpw = document.getElementById('confirm-password').value;

            if (!cpw.trim()) {
                setError('confirm-password', 'match-msg', 'Konfirmasi sandi wajib diisi');
                return false;
            }

            if (pw !== cpw) {
                setError('confirm-password', 'match-msg', 'Sandi tidak cocok');
                return false;
            }

            clearError('confirm-password', 'match-msg');
            return true;
        }

        function validateForm() {
            const isUsernameValid = validateUsername();
            const isPasswordValid = validatePassword();
            const isMatchValid = checkMatch();

            if (isUsernameValid && isPasswordValid && isMatchValid) {
                alert('Registrasi berhasil');
            }
        }
    </script>

</body>

</html>