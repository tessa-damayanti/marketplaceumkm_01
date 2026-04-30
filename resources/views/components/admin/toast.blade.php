<!-- Notification -->
<div id="admin-toast"
    class="pointer-events-none fixed right-6 top-6 z-[9999] translate-y-3 opacity-0 transition-all duration-300">

    <div class="flex items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-[0_8px_20px_rgba(0,0,0,0.12)] border border-[#f0e7dd]">

        <!-- Icon -->
        <div id="admin-toast-icon"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d9f8df]">
            <svg id="admin-toast-icon-success" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-[#4fa463]"
                fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <svg id="admin-toast-icon-error" xmlns="http://www.w3.org/2000/svg"
                class="hidden h-5 w-5 text-[#e05c5c]"
                fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- Text -->
        <div>
            <p id="admin-toast-title" class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p id="admin-toast-message" class="text-xs text-[#8b7a6d]">Aksi berhasil dilakukan.</p>
        </div>

    </div>
</div>
