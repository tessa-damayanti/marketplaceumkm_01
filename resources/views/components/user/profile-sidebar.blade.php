<div class="rounded-[32px] bg-white p-8 shadow-[0_8px_30px_rgba(92,68,50,0.06)]">

    {{-- Profil --}}
    <div class="mb-6 flex items-center gap-4 border-b border-[#f4ece3] pb-6">

        <div class="h-14 w-14 overflow-hidden rounded-full ring-4 ring-[#f4ece3] shadow-sm">
            <img
                id="sidebarProfileImage"
                src="{{ Auth::user()->foto_profile ? asset('storage/' . Auth::user()->foto_profile) : asset('images/1.png') }}"
                class="h-full w-full object-cover"
                alt="Foto Profil"
            >
        </div>

        <h3 id="sidebarProfileName" class="text-base font-bold text-[#5c4432]">
            Halo, {{ Auth::user()->nama_lengkap ?: Auth::user()->username }}
        </h3>

    </div>

    {{-- Menu --}}
    <nav class="flex flex-col gap-3">

        {{-- Akun --}}
        <button onclick="switchTab('akun')"
            id="btn-tab-akun"
            class="flex w-full items-center gap-4 rounded-2xl px-6 py-4 text-left font-medium text-[#8b6f58] hover:bg-[#f0e7dd] transition-colors">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>

            Akun Saya
        </button>

        {{-- Riwayat --}}
        <button onclick="switchTab('riwayat')"
            id="btn-tab-riwayat"
            class="flex w-full items-center gap-4 rounded-2xl px-6 py-4 text-left font-bold text-[#5c4432] bg-[#e8ded3] hover:bg-[#f0e7dd] transition-colors">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            Riwayat
        </button>

        {{-- Ubah Password --}}
        <button onclick="switchTab('password')"
            id="btn-tab-password"
            class="flex w-full items-center gap-4 rounded-2xl px-6 py-4 text-left font-medium text-[#8b6f58] hover:bg-[#f0e7dd] transition-colors">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>

            Ubah Password
        </button>

        {{-- Logout --}}
        <button onclick="openLogoutModal()"
            id="btn-tab-logout"
            class="flex w-full items-center gap-4 rounded-2xl px-6 py-4 text-left font-medium text-[#8b6f58] hover:bg-[#f0e7dd] active:bg-[#e8ded3] transition-colors">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>

            Keluar
        </button>

    </nav>
</div>