@extends('layouts.auth')

@section('title', 'Reset Password')

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
<div id="reset-toast" class="pointer-events-none fixed right-6 top-6 z-50 translate-y-3 opacity-0 transition-all duration-300">
    <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
        <div id="reset-toast-icon" class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p id="reset-toast-title" class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p id="reset-toast-message" class="mt-1 text-sm leading-6 text-[#7b6858]">Password berhasil diubah.</p>
        </div>
    </div>
</div>

<div class="w-full max-w-5xl rounded-[34px] overflow-hidden bg-white shadow-[0_24px_60px_rgba(92,68,50,0.18)] animate-fade-up scale-[0.92]">
    <div class="grid md:grid-cols-2 min-h-[600px]">

        <!-- LEFT SIDE -->
        <div class="relative h-[350px] md:h-auto md:min-h-[600px] overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Velora" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#b9a48f]/30"></div>
            <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-24 -right-16 w-72 h-72 rounded-full bg-white/10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-white/5"></div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="bg-[#a78d78] flex items-center justify-center px-8 py-10 md:px-14">
            <div class="w-full max-w-md fade-up-soft">

                <div class="text-center mb-9">
                    <h2 class="text-4xl font-bold text-[#fffaf6]">Reset Password</h2>
                </div>

                <form class="space-y-5" onsubmit="return false;">
                    <input type="hidden" id="reset-token" value="{{ $token }}">
                    <input type="hidden" id="reset-email" value="{{ request('email') }}">

                    <div>
                        <label class="block text-sm font-semibold text-[#fff4eb] mb-2">Password Baru</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5M5.25 10.5h13.5v8.25a2.25 2.25 0 01-2.25 2.25H7.5a2.25 2.25 0 01-2.25-2.25V10.5z" />
                                </svg>
                            </span>
                            <input id="password" type="password" placeholder="Minimal 6 karakter" oninput="validatePassword(); checkMatch();" class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-14 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <p id="password-msg" class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#fff4eb] mb-2 mt-4">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#cdb6a3]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </span>
                            <input id="confirm-password" type="password" placeholder="Ulangi password" oninput="checkMatch()" class="w-full h-14 rounded-2xl border border-[#d8c7ba] bg-[#fbf7f2] pl-12 pr-14 text-[#5c4432] placeholder:text-[#b79f8a] transition-[border-color,box-shadow,background-color] duration-200 focus:border-[#8f7561] focus:shadow-[0_0_0_3px_rgba(143,117,97,0.18)] focus:outline-none focus:bg-[#fffdfb]">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#b8967b] transition hover:text-[#5c4432]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <p id="confirm-password-msg" class="hidden mt-[10px] text-[15px] leading-[1.5] font-semibold text-[#dc2626]"></p>
                    </div>

                    <button type="button" onclick="submitReset()" class="w-full h-14 mt-4 rounded-2xl bg-[#e6dbcf] text-[#5c4432] text-base font-semibold shadow-[0_14px_28px_rgba(92,68,50,0.22)] transition-[background,box-shadow,transform] duration-200 hover:bg-[#d9cec1] hover:shadow-[0_16px_32px_rgba(92,68,50,0.25)] active:translate-y-0 hover:-translate-y-[1px]">
                        Simpan
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let toastTimer = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('reset-toast');
        const icon = document.getElementById('reset-toast-icon');
        const titleEl = document.getElementById('reset-toast-title');
        const messageEl = document.getElementById('reset-toast-message');

        titleEl.textContent = title;
        messageEl.textContent = message;

        if (type === 'error') {
            icon.className = 'mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#f8dede] text-[#c45b5b]';
            icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.18 12.44A2 2 0 004.82 19h14.36a2 2 0 001.71-2.7L13.71 3.86a2 2 0 00-3.42 0z" /></svg>`;
        } else {
            icon.className = 'mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]';
            icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`;
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
        msg.textContent = message;
        msg.classList.remove('hidden');
        input.classList.add('border-[#dc2626]', 'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]');
    }

    function clearError(inputId, msgId) {
        const input = document.getElementById(inputId);
        const msg = document.getElementById(msgId);
        msg.textContent = '';
        msg.classList.add('hidden');
        input.classList.remove('border-[#dc2626]', 'shadow-[0_0_0_3px_rgba(220,38,38,0.15)]');
    }

    function validatePassword() {
        const password = document.getElementById('password').value;
        if (!password.trim() || password.length < 6) {
            setError('password', 'password-msg', 'Password wajib diisi minimal 6 karakter');
            return false;
        }
        clearError('password', 'password-msg');
        return true;
    }

    function checkMatch() {
        const pw = document.getElementById('password').value;
        const cpw = document.getElementById('confirm-password').value;
        if (!cpw.trim()) {
            setError('confirm-password', 'confirm-password-msg', 'Konfirmasi password wajib diisi');
            return false;
        }
        if (pw !== cpw) {
            setError('confirm-password', 'confirm-password-msg', 'Password tidak sesuai');
            return false;
        }
        clearError('confirm-password', 'confirm-password-msg');
        return true;
    }

    async function submitReset() {
        const isPasswordValid = validatePassword();
        const isMatchValid = checkMatch();

        if (isPasswordValid && isMatchValid) {
            const password = document.getElementById('password').value;
            const token = document.getElementById('reset-token').value;
            const email = document.getElementById('reset-email').value;

            try {
                const response = await fetch("{{ route('password.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        token,
                        email,
                        password
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('Berhasil', 'Password Anda berhasil diperbarui!');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1500);
                } else {
                    let errorMsg = data.message || 'Gagal mengubah password.';
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