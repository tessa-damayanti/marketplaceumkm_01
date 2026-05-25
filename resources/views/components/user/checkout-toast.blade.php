<!-- Checkout Toast -->
<div id="checkoutToast"
    class="pointer-events-none fixed right-6 top-6 z-[10000] translate-y-3 opacity-0 transition-all duration-500">
    <div class="flex min-w-[300px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">

        <!-- Icon -->
        <div id="checkoutToastIcon"
            class="mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
            <!-- Success icon -->
            <svg id="checkoutToastIconSuccess" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <!-- Error icon -->
            <svg id="checkoutToastIconError" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- Text -->
        <div class="min-w-0 flex-1">
            <p id="checkoutToastTitle" class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p id="checkoutToastMessage" class="mt-1 text-sm leading-snug text-[#7b6858]">Pembayaran berhasil</p>
        </div>
    </div>
</div>

<script>
    let _toastTimer = null;
    let _toastCallback = null;

    window.showCustomAlert = function(message, type = 'success', callback = null) {
        const toast       = document.getElementById('checkoutToast');
        const icon        = document.getElementById('checkoutToastIcon');
        const iconSuccess = document.getElementById('checkoutToastIconSuccess');
        const iconError   = document.getElementById('checkoutToastIconError');
        const title       = document.getElementById('checkoutToastTitle');
        const msg         = document.getElementById('checkoutToastMessage');

        _toastCallback = callback;
        msg.textContent = message;

        if (type === 'success') {
            title.textContent = 'Berhasil';
            icon.className = 'mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]';
            iconSuccess.classList.remove('hidden');
            iconError.classList.add('hidden');
        } else {
            title.textContent = 'Perhatian';
            icon.className = 'mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-[#fee2e2] text-[#ef4444]';
            iconSuccess.classList.add('hidden');
            iconError.classList.remove('hidden');
        }

        // Tampilkan
        toast.classList.remove('opacity-0', 'translate-y-3');
        toast.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');

        // Auto-dismiss setelah 5 detik
        if (_toastTimer) clearTimeout(_toastTimer);
        _toastTimer = setTimeout(() => dismissToast(), 5000);
    };

    function dismissToast() {
        const toast = document.getElementById('checkoutToast');
        if (_toastTimer) { clearTimeout(_toastTimer); _toastTimer = null; }

        toast.classList.add('opacity-0', 'translate-y-3');
        toast.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
        toast.classList.add('pointer-events-none');

        if (_toastCallback) {
            setTimeout(() => {
                _toastCallback();
                _toastCallback = null;
            }, 500);
        }
    }

</script>