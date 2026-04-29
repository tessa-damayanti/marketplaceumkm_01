<div id="demo-toast"
    class="pointer-events-none fixed right-6 top-6 z-50 translate-y-3 opacity-0 transition-all duration-300">

    <div class="flex items-center gap-3 rounded-2xl bg-[#5c4432] px-6 py-4 text-white shadow-xl">

        {{-- Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-[#dff1e3]"
            fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 13l4 4L19 7" />
        </svg>

        {{-- Text --}}
        <div>
            <p id="demo-toast-title" class="text-sm font-bold">
                Berhasil
            </p>
            <p id="demo-toast-message" class="text-xs text-[#e2d5c8]">
                Pesan disini.
            </p>
        </div>

    </div>
</div>