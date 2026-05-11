<div id="tab-riwayat" class="block">
    <h2 class="mb-6 text-3xl font-bold text-[#5c4432]">
        Riwayat Pembelian
    </h2>

    <div class="overflow-hidden rounded-[18px] bg-white shadow-[0_6px_22px_rgba(92,68,50,0.08)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left">
                <thead>
                <tr class="border-b border-[#eee5dc] bg-[#fcfaf8] text-sm font-bold text-[#5c4432]">
                    <th class="px-6 py-5 whitespace-nowrap">No. Pesanan</th>
                    <th class="px-6 py-5 whitespace-nowrap">Produk</th>
                    <th class="px-6 py-5 text-center whitespace-nowrap">Status Pembayaran</th>
                    <th class="px-6 py-5 whitespace-nowrap">Total</th>
                    <th class="px-6 py-5 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-sm text-[#5c4432]">
                <!-- ROW 1 -->
                <tr class="border-b border-[#eee5dc]">
                    <td class="px-6 py-6 font-bold whitespace-nowrap">VL-250212-001</td>

                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-[#fcfaf8]">
                                <img src="https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg"
                                    alt="Kemeja Stripe" class="h-full w-full object-cover">
                            </div>

                            <div class="min-w-0">
                                <p class="text-base font-bold text-[#5c4432]">Kemeja Stripe</p>
                                <p class="mt-1 text-sm text-[#7b6858]">+2 produk lainnya</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-6 text-center">
                        <span
                            class="inline-flex whitespace-nowrap rounded-full bg-[#fff1bd] px-5 py-2 text-sm font-semibold text-[#b45a00]">
                            Menunggu Verifikasi
                        </span>
                    </td>

                    <td class="px-6 py-6 text-base font-bold whitespace-nowrap text-[#5c4432]">
                        Rp362.000
                    </td>

                    <td class="px-6 py-6">
                        <div class="flex justify-center">
                            <button onclick="openOrderDetail('VL-250212-001')"
                                class="whitespace-nowrap rounded-xl border-0 bg-[#BFA28C] px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)]">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- ROW 2 -->
                <tr class="border-b border-[#eee5dc]">
                    <td class="px-6 py-6 font-bold whitespace-nowrap">VL-250209-002</td>

                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-[#fcfaf8]">
                                <img src="https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg"
                                    alt="Gaun Biru Wrap" class="h-full w-full object-cover">
                            </div>

                            <div class="min-w-0">
                                <p class="text-base font-bold text-[#5c4432]">Gaun Biru Wrap</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-6 text-center">
                        <span
                            class="inline-flex whitespace-nowrap rounded-full bg-[#dcfce7] px-5 py-2 text-sm font-semibold text-[#15803d]">
                            Pembayaran Valid
                        </span>
                    </td>

                    <td class="px-6 py-6 text-base font-bold whitespace-nowrap text-[#5c4432]">
                        Rp170.000
                    </td>

                    <td class="px-6 py-6">
                        <div class="flex justify-center">
                            <button onclick="openOrderDetail('VL-250209-002')"
                                class="whitespace-nowrap rounded-xl border-0 bg-[#BFA28C] px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)]">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- ROW 3 -->
                <tr class="border-b border-[#eee5dc]">
                    <td class="px-6 py-6 font-bold whitespace-nowrap">VL-250206-003</td>

                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-[#f1e8df] bg-[#fcfaf8]">
                                <img src="https://i.pinimg.com/736x/78/2a/3d/782a3d260721c8f3d515966337443416.jpg"
                                    alt="Cardigan Rajut Pink" class="h-full w-full object-cover">
                            </div>

                            <div class="min-w-0">
                                <p class="text-base font-bold text-[#5c4432]">Cardigan Rajut Pink</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-6 text-center">
                        <span
                            class="inline-flex whitespace-nowrap rounded-full bg-[#fee2e2] px-5 py-2 text-sm font-semibold text-[#dc2626]">
                            Pembayaran Ditolak
                        </span>
                    </td>

                    <td class="px-6 py-6 text-base font-bold whitespace-nowrap text-[#5c4432]">
                        Rp90.000
                    </td>

                    <td class="px-6 py-6">
                        <div class="flex justify-center">
                            <button onclick="openOrderDetail('VL-250206-003')"
                                class="whitespace-nowrap rounded-xl border-0 bg-[#BFA28C] px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-[#A88A72] hover:shadow-[0_5px_14px_rgba(191,162,140,0.2)]">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>

        <div class="flex items-center justify-between border-t border-[#eee5dc] px-6 py-4">
            <p class="text-xs text-[#8b6f58]">
                1 - 3 dari 3
            </p>

            <div class="flex items-center gap-1.5">
                <button
                    class="flex h-8 w-8 items-center justify-center rounded-[10px] border border-[#f1e8df] text-sm text-[#8b6f58] transition hover:bg-[#fcfaf8]">
                    ‹
                </button>

                <button
                    class="flex h-8 w-8 items-center justify-center rounded-[10px] bg-[#BFA28C] text-sm font-bold text-white transition hover:bg-[#A88A72]">
                    1
                </button>

                <button
                    class="flex h-8 w-8 items-center justify-center rounded-[10px] border border-[#f1e8df] text-sm text-[#8b6f58] transition hover:bg-[#fcfaf8]">
                    ›
                </button>
            </div>
        </div>
    </div>
</div>