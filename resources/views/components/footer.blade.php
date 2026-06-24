<footer class="mt-12 bg-[#d8c3af]">
        <div class="grid w-full gap-10 px-10 md:px-16 py-12 md:grid-cols-2 md:items-center">
            <div class="flex items-center justify-center md:justify-start">
            <h2 class="text-4xl font-bold text-[#5c4432]">Velora</h2>
        </div>

            <div class="max-w-md md:ml-auto">
                <h3 class="text-2xl font-bold text-[#5c4432]">Hubungi Kami</h3>

            <p class="mt-2 text-sm leading-6 text-[#7b6858]">
                Ada pertanyaan seputar produk, pemesanan, atau pengiriman?<br>
                Hubungi kami langsung via WhatsApp.
                Kami siap membantu!
            </p>

            @php
                $waAdmin = env('WHATSAPP_ADMIN', '62882005627129');
                $waPesan = rawurlencode('Halo Admin Velora, saya ingin bertanya mengenai produk.');
            @endphp
            <a href="https://wa.me/{{ $waAdmin }}?text={{ $waPesan }}" target="_blank" class="mt-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] hover:bg-[#20ba56] transition-colors shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-7 w-7 text-white">
                    <path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zM223.9 414.7c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 334.1l-4.4-7.1c-18.5-29.7-28.2-64.2-28.2-99.3 0-103.6 84.4-188 188.1-188 50.3 0 97.6 19.6 133.2 55.2 35.6 35.6 55.2 82.9 55.2 133.3 0 103.5-84.5 188-188 188zm103-141.5c-5.6-2.8-33.5-16.5-38.7-18.4-5.2-1.9-9-2.8-12.8 2.8-3.8 5.6-14.6 18.4-17.9 22.1-3.3 3.8-6.6 4.2-12.2 1.4-5.6-2.8-23.9-8.8-45.5-28.1-16.8-15-28.1-33.6-31.4-39.2-3.3-5.6-.3-8.6 2.5-11.4 2.5-2.5 5.6-6.6 8.4-9.9 2.8-3.3 3.8-5.6 5.6-9.4 1.9-3.8.9-7.1-.5-9.9-1.4-2.8-12.8-30.9-17.5-42.3-4.6-11.2-9.3-9.7-12.8-9.9-3.3-.2-7.1-.2-10.8-.2-3.8 0-9.9 1.4-15 7.1-5.2 5.6-20.2 19.7-20.2 48s20.7 55.6 23.5 59.4c2.8 3.8 40.5 61.9 98.1 86.7 13.7 5.9 24.4 9.4 32.8 12 13.8 4.4 26.4 3.8 36.4 2.3 11.2-1.7 34.5-14.1 39.3-27.7 4.9-13.6 4.9-25.3 3.4-27.7-1.4-2.4-5.2-3.8-10.8-6.6z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>