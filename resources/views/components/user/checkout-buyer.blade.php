@props(['buyerName', 'buyerPhone', 'buyerAddress'])

<div class="border-b border-[#e5d8ca] p-5 md:border-b-0 md:border-r sm:p-8">
    <h2 class="mb-5 text-xl font-bold text-[#5c4432] sm:mb-7 sm:text-2xl">Informasi Pengiriman</h2>

    <div class="space-y-5">
        <div>
            <label class="mb-2 block font-semibold">Nama Lengkap</label>
            <input
                type="text"
                name="buyer_name"
                value="{{ $buyerName }}"
                class="w-full rounded-2xl border border-[#dccabb] bg-white px-5 py-4 outline-none transition focus:border-[#a78d78] focus:ring-4 focus:ring-[#a78d78]/15"
            >
            <p id="name-msg" class="hidden mt-2 text-sm font-semibold text-[#dc2626]"></p>
        </div>

        <div>
            <label class="mb-2 block font-semibold">No WhatsApp</label>
            <input
                type="text"
                name="buyer_phone"
                value="{{ $buyerPhone }}"
                class="w-full rounded-2xl border border-[#dccabb] bg-white px-5 py-4 outline-none transition focus:border-[#a78d78] focus:ring-4 focus:ring-[#a78d78]/15"
            >
            <p id="phone-msg" class="hidden mt-2 text-sm font-semibold text-[#dc2626]"></p>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Alamat</label>
            <textarea
                name="buyer_address"
                rows="7"
                class="w-full resize-none rounded-2xl border border-[#dccabb] bg-white px-5 py-4 outline-none transition focus:border-[#a78d78] focus:ring-4 focus:ring-[#a78d78]/15"
            >{{ $buyerAddress }}</textarea>
            <p id="address-msg" class="hidden mt-2 text-sm font-semibold text-[#dc2626]"></p>
        </div>
    </div>
</div>