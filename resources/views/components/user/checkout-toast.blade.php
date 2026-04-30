<div id="orderToast"
    class="fixed right-6 top-6 z-[9999] hidden rounded-2xl bg-white px-5 py-4 shadow-[0_8px_20px_rgba(0,0,0,0.1)]">

    <div class="flex items-center gap-3">
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


        <div>
            <p class="text-sm font-bold text-[#5c4432]">
                Pesanan berhasil dibuat
            </p>
            <p class="text-xs text-[#8b7a6d]">
                Pesananmu sedang menunggu verifikasi admin.
            </p>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('bukti-transfer');
    const previewImage = document.getElementById('previewImage');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        });
    }

    function showOrderToast(event) {
        event.preventDefault();

        const toast = document.getElementById('orderToast');

        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
            window.location.href = "{{ route('home') }}";
        }, 2000);
    }
</script>