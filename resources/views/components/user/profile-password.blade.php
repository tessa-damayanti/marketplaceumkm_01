<style>
    /* Sembunyikan ikon mata bawaan browser */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }
</style>

@php
    $activeTab = request()->query('tab');
    if (!in_array($activeTab, ['akun', 'riwayat', 'password'])) {
        $activeTab = (request()->query('page') || request()->query('status')) ? 'riwayat' : 'akun';
    }
@endphp
<div id="tab-password" class="{{ $activeTab === 'password' ? 'block' : 'hidden' }} rounded-[32px] bg-white p-10 shadow-[0_8px_30px_rgba(92,68,50,0.06)] min-h-[500px]">

    <h2 class="text-3xl font-bold text-[#5c4432]">Ubah Password</h2>
    <p class="mt-2 text-[#7b6858] mb-10">
        Untuk keamanan akun Anda, gunakan password yang kuat dan jangan membagikannya kepada siapa pun.
    </p>

    <form action="{{ route('profile.password.update') }}" method="POST" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        {{-- Password Lama --}}
        <div>
            <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                Password Lama
            </label>
            <div class="relative">
                <input id="oldPassword" name="old_password" type="password" placeholder="Masukkan password lama"
                    class="w-full rounded-2xl border @error('old_password') border-red-500 bg-red-50 @else border-[#f2e4d8] @enderror px-5 py-3.5 pr-12 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <button type="button" onclick="togglePassword('oldPassword', 'eyeOld')" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7b6858] hover:text-[#5c4432]">
                    <svg id="eyeOld" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('old_password')
                <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div>
            <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                Password Baru
            </label>
            <div class="relative">
                <input id="newPassword" name="new_password" type="password" placeholder="Masukkan password baru"
                    class="w-full rounded-2xl border @error('new_password') border-red-500 bg-red-50 @else border-[#f2e4d8] @enderror px-5 py-3.5 pr-12 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <button type="button" onclick="togglePassword('newPassword', 'eyeNew')" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7b6858] hover:text-[#5c4432]">
                    <svg id="eyeNew" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('new_password')
                <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div>
            <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                Konfirmasi Password Baru
            </label>
            <div class="relative">
                <input id="confirmPassword" name="new_password_confirmation" type="password" placeholder="Masukkan ulang password baru"
                    class="w-full rounded-2xl border @error('new_password_confirmation') border-red-500 bg-red-50 @else border-[#f2e4d8] @enderror px-5 py-3.5 pr-12 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <button type="button" onclick="togglePassword('confirmPassword', 'eyeConfirm')" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7b6858] hover:text-[#5c4432]">
                    <svg id="eyeConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('new_password_confirmation')
                <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <div class="flex justify-end pt-4">
            <button type="submit"
                class="rounded-2xl bg-[#d8c3af] px-8 py-4 font-bold text-white transition hover:bg-[#BFA28C]">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
        }
    }
</script>
