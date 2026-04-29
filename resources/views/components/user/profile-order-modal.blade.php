<div id="orderModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/55 p-4">

    <div
        class="flex max-h-[88vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">

        <!-- HEADER -->
        <div class="relative border-b border-[#f1e8df] px-7 py-5">
            <h3 class="text-2xl font-extrabold text-[#2f1f16]">
                Detail Pesanan
            </h3>

            <p id="modal-order-id" class="mt-1 text-sm text-[#8b7a6d]"></p>

            <button onclick="closeModal()"
                class="absolute right-6 top-6 text-2xl leading-none text-[#3e2c1e] transition hover:text-black">
                ×
            </button>
        </div>

        <!-- BODY -->
        <div class="overflow-y-auto px-7 py-6">

            <!-- ORDER INFO -->
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <p class="text-sm text-[#9b8a7c]">Tanggal Pesanan</p>
                    <p id="modal-date" class="mt-2 font-bold text-[#2f1f16]"></p>
                </div>

                <div>
                    <p class="text-sm text-[#9b8a7c]">Status Pembayaran</p>
                    <span id="modal-status-badge"
                        class="mt-2 inline-flex rounded-full px-5 py-2 text-sm font-semibold">
                    </span>
                </div>
            </div>

            <hr class="my-6 border-[#f1e8df]">

            <!-- BUYER INFO -->
            <h4 class="mb-4 text-lg font-extrabold text-[#2f1f16]">
                Informasi 
            </h4>

            <div class="rounded-xl bg-[#fbf8f5] p-5">
                <div class="grid grid-cols-[140px_1fr] gap-y-3 text-sm">
                    <p class="text-[#8b7a6d]">Nama</p>
                    <p class="font-bold text-[#2f1f16]">Nikita Willy</p>

                    <p class="text-[#8b7a6d]">No. WhatsApp</p>
                    <p class="font-bold text-[#2f1f16]">0812 3456 7890</p>

                    <p class="text-[#8b7a6d]">Alamat</p>
                    <p class="font-bold leading-relaxed text-[#2f1f16]">
                        Jl. Ahmad Yani No. 22,<br>
                        Kota Bandung, Jawa Barat 40111
                    </p>
                </div>
            </div>

            <hr class="my-6 border-[#f1e8df]">

            <!-- ITEMS -->
            <h4 class="mb-4 text-lg font-extrabold text-[#2f1f16]">
                Item Pesanan
            </h4>

            <!-- 🔥 INI YANG PENTING (FIX BUG) -->
            <div id="modal-items" class="space-y-4"></div>

            <!-- TOTAL -->
            <div class="mt-5 flex items-center justify-between rounded-xl bg-[#fbf8f5] px-5 py-4">
                <p class="font-extrabold text-[#2f1f16]">
                    Total Pembayaran
                </p>

                <p id="modal-total" class="text-2xl font-extrabold text-[#2f1f16]"></p>
            </div>
        </div>
    </div>
</div>