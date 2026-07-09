<div id="productModal"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 px-3 py-6
        opacity-0 transition-opacity duration-200 ease-in-out
        [&.modal-hidden]:hidden sm:px-4 [font-family:Poppins,sans-serif]"
    style="display:none;">

    <!-- Panel modal -->
    <div id="productModalPanel"
        class="relative w-full max-w-[880px] max-h-[90vh] overflow-hidden rounded-[24px] bg-white shadow-[0_24px_64px_rgba(92,68,50,0.22)]
        opacity-0 transition-all duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
        style="transform: translateY(18px) scale(0.98);">
        <!-- Tombol tutup -->
        <button onclick="closeModal()"
            class="absolute right-3 top-3 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-base leading-none text-[#5c4432] shadow-md transition-all duration-150 hover:scale-110 hover:bg-white sm:right-4 sm:top-4"
            aria-label="Tutup modal">
            &#x2715;
        </button>

        <!-- Grid kolom gambar dan info produk  -->
        <div class="max-h-[90vh] overflow-y-auto grid grid-cols-1 md:grid-cols-[46%_54%]">

            <!-- Kolom kiri: Gambar produk -->
            <div class="flex items-center justify-center bg-[#F5EDE4] p-6 md:min-h-[500px] md:p-8">
                <img id="modalImage"
                    src=""
                    alt="Foto produk"
                    class="w-full rounded-2xl object-contain shadow-[0_8px_28px_rgba(92,68,50,0.12)]
        max-h-[260px] md:max-h-[440px]">
            </div>

            <div class="flex flex-col overflow-hidden p-5 sm:p-7 md:p-8 [font-family:'Poppins',sans-serif]">

                <!-- Label kategori -->
                <p id="modalCategory"
                    class="mb-1 text-[12px] font-bold uppercase tracking-[3.5px] text-[#B08B68]"></p>

                <!-- Nama produk -->
                <h2 id="modalName"
                    class="mb-1 font-bold leading-tight text-[#5c4432] text-[clamp(1.15rem,3.5vw,1.6rem)]"></h2>

                <!-- Harga -->
                <p id="modalPrice"
                    class="mb-4 font-bold text-[#7a5a43] text-[clamp(1.05rem,3vw,1.4rem)]"></p>

                <!-- Deskripsi produk  -->
                <div class="mb-4">
                    <h3 class="mb-1.5 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Deskripsi Produk
                    </h3>
                    <p id="modalDesc"
                        class="text-[0.78rem] leading-[1.75] text-[#8B6F5E] sm:text-[0.83rem]"></p>
                </div>

                <!-- Pilih Ukuran -->
                <div class="mb-2">
                    <h3 class="mb-2 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Pilih Ukuran
                    </h3>
                    <!-- Tombol ukuran (S / M / L / XL) -->
                    <div id="modalSizes" class="flex flex-wrap gap-2"></div>

                    <p id="sizeError"
                        class="mt-1.5 hidden text-[12px] font-semibold text-red-500">
                        Silakan pilih ukuran terlebih dahulu
                    </p>
                </div>

                <div class="mb-4">
                    <h3 class="mb-0.5 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Stok
                    </h3>
                    <p id="modalStock"
                        class="text-[0.78rem] font-medium text-[#A78D78]">
                        Pilih ukuran terlebih dahulu
                    </p>
                </div>

                <!-- Jumlah dan tombol + / - -->
                <div class="mb-4">
                    <h3 class="mb-2 text-[14px] font-bold normal-case tracking-normal text-[#9C7B62]">
                        Jumlah
                    </h3>
                    <div class="flex items-center gap-3">
                        <!-- Tombol kurang -->
                        <button type="button" onclick="decreaseQty()"
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#BFA28C] text-lg font-bold text-white transition hover:bg-[#A88A72]">
                            −
                        </button>
                        <!-- Nilai jumlah -->
                        <span id="qtyValue"
                            class="w-8 text-center text-base font-bold text-[#5c4432]">
                            1
                        </span>
                        <!-- Tombol tambah -->
                        <button type="button" onclick="increaseQty()"
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#BFA28C] text-lg font-bold text-white transition hover:bg-[#A88A72]">
                            +
                        </button>
                    </div>
                    <!-- Peringatan stok maksimum -->
                    <p id="stockWarning"
                        class="mt-1.5 hidden text-[12px] font-semibold text-red-400">
                        Pembelian mencapai batas stok maksimum!
                    </p>
                </div>

                <!-- Tombol Keranjang dan Beli Sekarang -->
                <div class="mt-auto flex gap-2.5">
                    <button type="button" onclick="addToCart()"
                        class="flex-1 rounded-[14px] bg-[#BFA28C] py-3 text-sm font-bold text-white transition-all duration-200 hover:-translate-y-px hover:bg-[#A88A72] hover:shadow-[0_6px_18px_rgba(191,162,140,0.22)]">
                        Tambah Ke Keranjang
                    </button>
                    <button type="button" onclick="buyNow()"
                        class="flex-1 rounded-[14px] bg-[#A98B76] py-3 text-sm font-bold text-white transition-all duration-200 hover:-translate-y-px hover:bg-[#967A66] hover:shadow-[0_6px_18px_rgba(169,139,118,0.22)]">
                        Beli Sekarang
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<form id="cartForm" action="{{ route('cart.add') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="name" id="cart_name">
    <input type="hidden" name="category" id="cart_category">
    <input type="hidden" name="image" id="cart_image">
    <input type="hidden" name="price" id="cart_price">
    <input type="hidden" name="size" id="cart_size">
    <input type="hidden" name="qty" id="cart_qty">
    <input type="hidden" name="stock" id="cart_stock">
    <input type="hidden" name="stok_id" id="cart_stok_id">
    <input type="hidden" name="cart_item_id" id="cart_item_id">
</form>
