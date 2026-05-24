@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div id="login-config" data-login-url="{{ route('login.submit') }}" hidden></div>

@push('styles')
<style>
    html,
    body {
        overscroll-behavior: none;
    }
</style>
@endpush

<!-- Toast -->
<div id="login-toast" class="pointer-events-none fixed right-6 top-6 z-50 translate-y-3 opacity-0 transition-all duration-300">
    <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
        <div id="login-toast-icon" class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p id="login-toast-title" class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p id="login-toast-message" class="mt-1 text-sm leading-6 text-[#7b6858]">Login berhasil.</p>
        </div>
    </div>
</div>

<div class="w-full max-w-5xl rounded-[34px] overflow-hidden bg-white shadow-[0_24px_60px_rgba(92,68,50,0.18)] animate-fade-up scale-[0.92]">
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

                <!-- LOGIN VIEW -->
                <div id="login-view" class="fade-up-soft">
                    <div class="text-center mb-9">
                        <h2 class="text-4xl font-bold text-[#fffaf6]">Login</h2>
                    </div>

                    <form class="space-y-5" onsubmit="return false;">

                        <div>
                            <label class="block text-sm font-semibold text-[#fff4eb] mb-2">
                                Username
                            </label>
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
                            <p id="username-msg" class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#fff4eb] mb-2">
                                Password
                            </label>
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
                                    oninput="validatePassword()"
                                    class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-14 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
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
                            <p id="password-msg" class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]"></p>
                        </div>

                        <div class="text-right -mt-1">
                            <button type="button" onclick="showForgotPassword()" class="text-[#fff4eb] hover:text-white text-xs font-medium transition">
                                Lupa Password?
                            </button>
                        </div>

                        <button
                            type="button"
                            onclick="validateForm()"
                            class="w-full h-14 rounded-2xl bg-[#e6dbcf] text-[#5c4432] text-base font-semibold shadow-[0_14px_28px_rgba(92,68,50,0.22)] transition-[background,box-shadow,transform] duration-200 hover:bg-[#d9cec1] hover:shadow-[0_16px_32px_rgba(92,68,50,0.25)] active:translate-y-0 hover:-translate-y-[1px]">
                            Login
                        </button>

                        <p class="text-center text-sm text-[#f2e4d8] pt-1">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-[#fffaf6] font-semibold ml-1 hover:text-white transition">
                                Daftar disini
                            </a>
                        </p>

                    </form>
                </div>

                <!-- FORGOT PASSWORD -->
                <div id="forgot-view" class="hidden">
                    <div class="w-full max-w-md fade-up-soft">

                        <div class="text-center mb-9">
                            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#e6dbcf] text-[#5c4432] shadow-[0_12px_28px_rgba(92,68,50,0.18)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V7.875a4.5 4.5 0 00-9 0V10.5m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6A1.75 1.75 0 016.75 10.5z" />
                                </svg>
                            </div>
                            <h2 class="text-4xl font-bold text-[#fffaf6]">Lupa Password ?</h2>
                            <p class="mt-4 text-[#f2e4d8] text-base leading-relaxed">
                                Masukkan email Anda
                        </div>

                        <form class="space-y-5" onsubmit="return false;">



                            <div>
                                <label class="block text-sm font-semibold text-[#fff4eb] mb-2">
                                    Alamat email
                                </label>
                                <div class="relative">
                                    <input
                                        id="forgot-email"
                                        type="email"
                                        placeholder="nama@gmail.com"
                                        oninput="validateForgotEmail()"
                                        class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] px-6 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
                                </div>
                                <p id="forgot-email-msg" class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]"></p>
                            </div>

                            <button
                                type="button"
                                onclick="validateForgotForm()"
                                class="w-full h-14 rounded-2xl bg-[#e6dbcf] text-[#5c4432] text-base font-semibold shadow-[0_14px_28px_rgba(92,68,50,0.22)] transition-[background,box-shadow,transform] duration-200 hover:bg-[#d9cec1] hover:shadow-[0_16px_32px_rgba(92,68,50,0.25)] active:translate-y-0 hover:-translate-y-[1px]">
                                Kirim
                            </button>

                            <div class="pt-2 text-center">
                                <button type="button" onclick="showLogin()"
                                    class="text-sm font-semibold text-[#fff4eb] transition hover:text-white">
                                    Kembali ke halaman login
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let toastTimer = null;
    const loginConfig = document.getElementById('login-config');
    const loginUrl = loginConfig?.dataset.loginUrl || '';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('login-toast');
        const icon = document.getElementById('login-toast-icon');
        const titleEl = document.getElementById('login-toast-title');
        const messageEl = document.getElementById('login-toast-message');

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
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        }
    }

    function setError(inputId, msgId, message) {
        const input = document.getElementById(inputId);
        const msg = document.getElementById(msgId);

        if (message) {
            msg.textContent = message;
            msg.classList.remove('hidden');
        } else {
            msg.classList.add('hidden');
        }
        input.classList.add('border-[#dc2626]', 'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]');
    }

    function clearError(inputId, msgId) {
        const input = document.getElementById(inputId);
        const msg = document.getElementById(msgId);

        msg.textContent = '';
        msg.classList.add('hidden');
        input.classList.remove('border-[#dc2626]', 'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]');
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
        clearError('password', 'password-msg');
        return true;
    }

    async function validateForm() {
        const isUsernameValid = validateUsername();
        const isPasswordValid = validatePassword();

        if (isUsernameValid && isPasswordValid) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(loginUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        username,
                        password
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('Login berhasil', username === 'admin1' ? 'Selamat datang, Admin' : 'Selamat Datang');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 900);
                } else {
                    let errorMsg = data.message || 'Username atau password salah';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors)[0][0];
                    }
                    setError('username', 'username-msg', '');
                    setError('password', 'password-msg', errorMsg);
                    showToast('Login gagal', errorMsg, 'error');
                }
            } catch (error) {
                showToast('Terjadi kesalahan', 'Tidak dapat terhubung ke server.', 'error');
            }
        }
    }

    function showForgotPassword() {
        document.getElementById('login-view').classList.add('hidden');
        document.getElementById('forgot-view').classList.remove('hidden');
    }

    function showLogin() {
        document.getElementById('forgot-view').classList.add('hidden');
        document.getElementById('login-view').classList.remove('hidden');
    }

    function validateForgotEmail() {
        const email = document.getElementById('forgot-email').value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            setError('forgot-email', 'forgot-email-msg', 'Email wajib diisi');
            return false;
        }
        if (!emailPattern.test(email)) {
            setError('forgot-email', 'forgot-email-msg', 'Format email tidak valid');
            return false;
        }
        clearError('forgot-email', 'forgot-email-msg');
        return true;
    }

    async function validateForgotForm() {
        const isEmailValid = validateForgotEmail();

        if (isEmailValid) {
            const email = document.getElementById('forgot-email').value.trim();

            try {
                const response = await fetch("{{ route('password.email') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        email
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('Berhasil', 'Silakan cek email Anda untuk melanjutkan reset password.');
                    setTimeout(() => { showLogin(); }, 2000);
                } else {
                    let errorMsg = data.message || 'Gagal mengirim link reset password.';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors)[0][0];
                    }
                    showToast('Gagal', errorMsg, 'error');
                }
            } catch (error) {
                showToast('Terjadi kesalahan', 'Tidak dapat terhubung ke server.', 'error');
            }
        }
    }
</script>
@endpush