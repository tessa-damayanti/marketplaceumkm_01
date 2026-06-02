<div id="demo-toast"
    class="pointer-events-none fixed right-6 top-6 z-50 translate-y-3 opacity-0 transition-all duration-300">

    <div class="flex items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-[0_8px_20px_rgba(0,0,0,0.1)]">

        <!-- Icon -->
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d9f8df]">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-[#4fa463]"
                fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <!-- Text -->
        <div>
            <p id="demo-toast-title" class="text-sm font-bold text-[#5c4432]">
                Berhasil
            </p>
            <p id="demo-toast-message" class="text-xs text-[#8b7a6d]">
                Profil berhasil diperbarui.
            </p>
        </div>

    </div>
</div>

<script>
function showToast(title, message) {
    const toast = document.getElementById('demo-toast');
    const titleEl = document.getElementById('demo-toast-title');
    const messageEl = document.getElementById('demo-toast-message');

    // set isi
    titleEl.innerText = title;
    messageEl.innerText = message;

    // tampilkan (animasi masuk)
    toast.classList.remove('opacity-0', 'translate-y-3');
    toast.classList.add('opacity-100', 'translate-y-0');

    // sembunyikan lagi setelah 2 detik
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-3');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2000);
}

@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
        showToast('Berhasil', '{{ session('success') }}');
    });
@endif
</script>