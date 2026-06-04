@extends('layouts.auth')

@section('title', 'Registrasi')

@push('styles')
<style>
    html,
    body {
        overscroll-behavior: none;
    }
</style>
@endpush

@section('content')

<!-- Toast -->
<div id="register-toast" class="pointer-events-none fixed right-6 top-6 z-50 translate-y-3 opacity-0 transition-all duration-300">
    <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
        <div id="register-toast-icon" class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p id="register-toast-title" class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p id="register-toast-message" class="mt-1 text-sm leading-6 text-[#7b6858]">Registrasi berhasil.</p>
        </div>
    </div>
</div>

<div class="w-full max-w-5xl rounded-[34px] overflow-hidden bg-white shadow-[0_24px_60px_rgba(92,68,50,0.18)] animate-fade-up scale-[0.92]">
    <div class="grid md:grid-cols-2 min-h-[600px]">

        <!-- Left side -->
        <div class="relative min-h-[600px] overflow-hidden">
            <img src="{{ asset('images/logo.png') }}"
                alt="Logo Velora"
                class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-[#b9a48f]/30"></div>

            <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-24 -right-16 w-72 h-72 rounded-full bg-white/10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-white/5"></div>
        </div>

        <!-- Right side -->
        <div class="bg-[#a78d78] flex items-center justify-center px-8 py-8 md:px-14">
            <div class="w-full max-w-md fade-up-soft">

                <div class="text-center mb-6">
                    <h2 class="text-4xl font-bold text-[#fffaf6]">Registrasi</h2>
                </div>

                <form class="space-y-5" onsubmit="return false;">

                    <!-- Username -->
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

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-[#fff4eb] mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.909A2.25 2.25 0 012.25 6.993V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25" />
                                </svg>
                            </span>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                placeholder="Masukkan email"
                                oninput="validateEmail()"
                                class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-4 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
                        </div>
                        <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="email-msg"></p>
                    </div>

                    <!-- Password dan Konfirmasi password -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Password -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#fff4eb] sm:min-h-[42px] lg:min-h-0">Password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5M5.25 10.5h13.5v8.25a2.25 2.25 0 01-2.25 2.25H7.5a2.25 2.25 0 01-2.25-2.25V10.5z" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    oninput="validatePassword(); checkMatch();"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-9 pr-9 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb] [appearance:textfield] [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden [&::-webkit-textfield-decoration-container]:hidden text-sm">
                                <button
                                    type="button"
                                    onclick="togglePassword(this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="password-msg"></p>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#fff4eb] sm:min-h-[42px] lg:min-h-0">Konfirmasi password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </span>
                                <input
                                    id="confirm-password"
                                    name="confirm_password"
                                    type="password"
                                    placeholder="Ulangi password"
                                    oninput="checkMatch()"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-9 pr-9 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb] [appearance:textfield] [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden [&::-webkit-textfield-decoration-container]:hidden text-sm">
                                <button
                                    type="button"
                                    onclick="togglePassword(this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]" id="match-msg"></p>
                        </div>
                    </div>

                    <!-- Register button -->
                    <div class="pt-2">
                        <button
                            type="button"
                            onclick="validateForm()"
                            class="w-full h-14 rounded-2xl bg-[#e6dbcf] text-[#5c4432] text-base font-semibold shadow-[0_14px_28px_rgba(92,68,50,0.22)] transition-[background,box-shadow,transform] duration-200 hover:bg-[#d8c3af] hover:shadow-[0_16px_32px_rgba(92,68,50,0.25)] hover:-translate-y-[1px] active:translate-y-0">
                            Daftar Sekarang
                        </button>
                    </div>

                    <!-- Link login-->
                    <p class="text-center text-sm text-[#f2e4d8] mt-2">
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
@endsection

@push('scripts')
<script>
    let toastTimer = null;

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('register-toast');
        const icon = document.getElementById('register-toast-icon');
        const titleEl = document.getElementById('register-toast-title');
        const messageEl = document.getElementById('register-toast-message');

        titleEl.textContent = title;
        messageEl.textContent = message;

        if (type === 'error') {
            icon.className = 'mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#f8dede] text-[#c45b5b]';
            icon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.18 12.44A2 2 0 004.82 19h14.36a2 2 0 001.71-2.7L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
            `;
        } else {
            icon.className = 'mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]';
            icon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            `;
        }

        toast.classList.remove('opacity-0', 'translate-y-3');
        toast.classList.add('opacity-100', 'translate-y-0');

        if (toastTimer) clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-3');
            toast.classList.remove('opacity-100', 'translate-y-0');
        }, 2200);
    }

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

    function validateEmail() {
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            setError('email', 'email-msg', 'Email wajib diisi');
            return false;
        }

        if (!emailRegex.test(email)) {
            setError('email', 'email-msg', 'Email tidak valid');
            return false;
        }

        clearError('email', 'email-msg');
        return true;
    }

    function validatePassword() {
        const password = document.getElementById('password').value;

        if (!password.trim()) {
            setError('password', 'password-msg', 'Password wajib diisi');
            return false;
        }

        if (password.length < 6) {
            setError('password', 'password-msg', 'Password minimal 6 karakter');
            return false;
        }

        clearError('password', 'password-msg');
        return true;
    }

    function checkMatch() {
        const pw = document.getElementById('password').value;
        const cpw = document.getElementById('confirm-password').value;

        if (!cpw.trim()) {
            setError('confirm-password', 'match-msg', 'Konfirmasi password wajib diisi');
            return false;
        }

        if (pw !== cpw) {
            setError('confirm-password', 'match-msg', 'Password tidak sesuai');
            return false;
        }

        clearError('confirm-password', 'match-msg');
        return true;
    }

    async function validateForm() {
        const isUsernameValid = validateUsername();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isMatchValid = checkMatch();

        if (isUsernameValid && isEmailValid && isPasswordValid && isMatchValid) {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            try {
                const response = await fetch("{{ route('register.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        username,
                        email,
                        password
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('Berhasil', 'Registrasi berhasil');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1200);
                } else {
                    let errorMsg = data.message || 'Registrasi gagal';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors)[0][0];
                    }
                    showToast('Gagal', errorMsg, 'error');
                }
            } catch (error) {
                showToast('Gagal', 'Terjadi kesalahan server', 'error');
            }
        }
    }
</script>
@endpush