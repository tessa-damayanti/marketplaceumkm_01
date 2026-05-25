<div id="pay-modal" class="pointer-events-none fixed inset-0 z-[9999] flex items-end justify-center sm:items-center opacity-0 transition-opacity duration-300">

    <div id="pay-overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closePayModal()"></div>
    <div id="pay-card"
        class="relative z-10 w-full max-w-sm translate-y-8 rounded-t-[28px] sm:rounded-[28px] bg-white shadow-2xl transition-transform duration-300 overflow-hidden">

        <div id="pay-header" class="px-6 pt-6 pb-4 flex items-center gap-3">
            <div id="pay-logo" class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-[#f0e8e0]">
                {{-- Icon injected by JS --}}
            </div>
            <div class="flex-1 min-w-0">
                <p id="pay-title" class="font-bold text-[#5c4432] text-base leading-tight"></p>
                <p id="pay-subtitle" class="text-xs text-[#9c8070] mt-0.5"></p>
            </div>
            <button onclick="closePayModal()" class="rounded-xl p-2 hover:bg-[#f4ede5] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9c8070]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Divider --}}
        <div class="h-px bg-[#f0e8e0] mx-6"></div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-4">

            {{-- Selection section --}}
            <div id="section-selection" class="hidden flex-col gap-3">
                <button type="button" onclick="submitCheckoutForm('qris')" class="flex items-center gap-4 rounded-2xl border-2 border-[#e5d8ca] p-4 text-left transition hover:border-[#BFA28C] hover:bg-[#faf5f0]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-sm border border-[#f0e8e0]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#5c4432]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-[#5c4432]">QRIS</p>
                        <p class="text-xs text-[#9c8070]">Semua e-wallet & m-banking</p>
                    </div>
                </button>

                <button type="button" onclick="submitCheckoutForm('va')" class="flex items-center gap-4 rounded-2xl border-2 border-[#e5d8ca] p-4 text-left transition hover:border-[#BFA28C] hover:bg-[#faf5f0]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-sm border border-[#f0e8e0]">
                        <div class="text-[11px] font-extrabold text-[#5c4432] uppercase">ATM</div>
                    </div>
                    <div>
                        <p class="font-bold text-[#5c4432]">ATM/Transfer Bank</p>
                        <p class="text-xs text-[#9c8070]">Virtual Account Bank</p>
                    </div>
                </button>
            </div>

            {{-- QRIS section --}}
            <div id="section-qris" class="hidden flex-col items-center gap-3">
                <p class="text-sm text-[#7b6858] text-center">Scan QR Code di bawah ini untuk membayar</p>
                <div class="rounded-2xl border-2 border-[#e5d8ca] p-3 bg-white">
                    <img id="qr-img" src="" alt="QR Code" class="h-48 w-48 object-contain" onerror="this.src='https://via.placeholder.com/192?text=QR'">
                </div>
                <p class="text-xs text-[#9c8070] text-center">Gunakan aplikasi e-wallet, m-banking, atau kamera HP Anda</p>
            </div>

            {{-- VA section --}}
            <div id="section-va" class="hidden flex-col gap-3">
                <p class="text-sm text-[#7b6858]">Nomor Virtual Account</p>
                <div class="flex items-center gap-2 rounded-2xl border-2 border-[#e5d8ca] bg-[#faf7f4] px-4 py-3">
                    <p id="va-number" class="flex-1 font-mono text-xl font-bold tracking-widest text-[#5c4432] select-all"></p>
                    <button onclick="copyVA()" id="copy-btn"
                        class="flex items-center gap-1 rounded-xl bg-[#BFA28C] px-3 py-1.5 text-xs font-bold text-white transition hover:bg-[#A88A72] active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Salin
                    </button>
                </div>
                <p class="text-xs text-[#9c8070]">Transfer tepat sesuai jumlah yang tertera. Pembayaran akan otomatis terkonfirmasi.</p>
            </div>

            {{-- Amount & Timer --}}
            <div id="section-details" class="hidden items-center justify-between rounded-2xl bg-[#f4ede5] px-4 py-3">
                <div>
                    <p class="text-xs text-[#9c8070]">Total Pembayaran</p>
                    <p id="pay-amount" class="font-bold text-[#5c4432]"></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-[#9c8070]">Berlaku</p>
                    <p id="pay-timer" class="font-bold text-[#5c4432] tabular-nums">--:--</p>
                </div>
            </div>

            {{-- Status indicator --}}
            <div id="status-indicator" class="hidden items-center gap-2 rounded-xl bg-[#e8f5ec] px-4 py-2.5">
                <svg class="h-4 w-4 animate-spin text-[#5e936c]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <p id="status-text" class="text-xs font-semibold text-[#5e936c]">Menunggu pembayaran</p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 space-y-2">
            <button id="btn-cek-status" onclick="checkPaymentStatus()"
                class="hidden w-full rounded-2xl bg-[#BFA28C] py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#A88A72] active:scale-[0.98]">
                Cek Status Pembayaran
            </button>
            <button onclick="closePayModal()"
                class="w-full rounded-2xl border border-[#e5d8ca] py-3 text-sm font-medium text-[#7b6858] transition hover:bg-[#faf7f4] active:scale-[0.98]">
                Tutup
            </button>
        </div>

    </div>
</div>
