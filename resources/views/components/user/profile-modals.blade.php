<div id="orderModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/55 p-4">

    <div class="flex max-h-[88vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">

        <!-- HEADER -->
        <div class="relative border-b border-[#f1e8df] px-7 py-5">
            <h3 class="text-2xl font-extrabold text-[#5c4432]">
                Detail Pesanan
            </h3>

            <p id="modal-order-id" class="mt-1 text-sm text-[#7b6858]"></p>

            <button onclick="closeOrderModal()"
                class="absolute right-3 top-3 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-base leading-none text-[#5c4432] shadow-md transition-all duration-150 hover:scale-110 hover:bg-white sm:right-4 sm:top-4"
                aria-label="Tutup modal">
                &#x2715;
            </button>
        </div>

        <!-- BODY -->
        <div class="overflow-y-auto px-7 py-6">

            <!-- ORDER INFO -->
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <p class="text-sm font-bold text-[#5c4432]">Tanggal Pesanan</p>
                    <p id="modal-date" class="mt-2 text-[#8b7a6d]"></p>

                </div>

                <div>
                    <p class="text-sm font-bold text-[#5c4432]">Status Pembayaran</p>
                    <span id="modal-status-badge" class="mt-2 inline-flex rounded-full px-5 py-2 text-sm font-semibold">
                    </span>
                </div>
            </div>

            <hr class="my-6 border-[#f1e8df]">

            <!-- BUYER INFO -->
            <h4 class="mb-4 text-lg font-extrabold text-[#5c4432]">
                Informasi
            </h4>

            <div class="rounded-xl bg-[#fbf8f5] p-5">
                <div class="grid grid-cols-[140px_1fr] gap-y-3 text-sm">
                    <p class="font-bold text-[#5c4432]">Nama</p>
                    <p id="modal-buyer-name" class="text-[#8b7a6d]">-</p>

                    <p class="font-bold text-[#5c4432]">No. WhatsApp</p>
                    <p id="modal-buyer-phone" class="text-[#8b7a6d]">-</p>

                    <p class="font-bold text-[#5c4432]">Alamat</p>
                    <p id="modal-buyer-address" class="text-[#8b7a6d]">-</p>
                </div>
            </div>

            <hr class="my-6 border-[#f1e8df]">

            <!-- ITEMS -->
            <h4 class="mb-4 text-lg font-extrabold text-[#5c4432]">
                Item Pesanan
            </h4>

            <div id="modal-items" class="space-y-4"></div>

            <!-- TOTAL -->
            <div class="mt-5 flex items-center justify-between rounded-xl bg-[#fbf8f5] px-5 py-4">
                <p class="font-extrabold text-[#5c4432]">
                    Total Pembayaran
                </p>

                <p id="modal-total" class="text-2xl font-extrabold text-[#5c4432]"></p>
            </div>
        </div>

        <!-- FOOTER / ACTIONS -->
        <div id="modal-footer" class="border-t border-[#f1e8df] px-7 py-4 bg-[#fbf8f5] flex justify-end gap-3 hidden">
            <!-- Dinamis via JS -->
        </div>
    </div>
</div>

{{-- Modal Logout --}}
<div id="modal-logout" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40">
    <div class="w-[380px] max-w-[calc(100%-32px)] animate-fade-up-soft rounded-[20px] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] transition-transform">
        <div class="px-6 py-7">
            <p class="text-center text-sm font-semibold leading-relaxed text-[#1a1a1a]">
                Apakah Anda yakin ingin keluar dari Profile?
            </p>
            <div class="mt-5 flex justify-center gap-[10px]">
                <button onclick="closeLogoutModal()" 
                    class="rounded-xl border border-[#d8c3af] bg-white px-7 py-2.5 text-sm font-bold text-[#5c4432] transition hover:bg-[#fcf8f3] hover:border-[#c7b09b]">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" 
                        class="rounded-xl bg-[#ef4444] px-7 py-2.5 text-sm font-semibold text-white transition hover:brightness-105">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Batal Pesanan --}}
<div id="modal-confirm-cancel" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40">
    <div class="w-[380px] max-w-[calc(100%-32px)] animate-fade-up-soft rounded-[20px] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] transition-transform">
        <div class="px-6 py-7">
            <p class="text-center text-sm font-semibold leading-relaxed text-[#1a1a1a]">
                Apakah Anda yakin ingin membatalkan pesanan ini?
            </p>
            <div class="mt-5 flex justify-center gap-[10px]">
                <button id="btn-cancel-modal-close"
                    class="rounded-xl border border-[#d8c3af] bg-white px-7 py-2.5 text-sm font-bold text-[#5c4432] transition hover:bg-[#fcf8f3] hover:border-[#c7b09b]">
                    Kembali
                </button>
                <button id="btn-cancel-modal-submit"
                    class="rounded-xl bg-[#ef4444] px-7 py-2.5 text-sm font-semibold text-white transition hover:brightness-105">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>