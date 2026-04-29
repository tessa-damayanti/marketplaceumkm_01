<div id="orderToast"
     class="fixed right-6 top-6 z-[9999] hidden rounded-[28px] bg-[#fffaf6] px-7 py-5 shadow-2xl">
    <div class="flex items-center gap-4">
        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-2xl font-bold text-green-600">
            ✓
        </div>
        <div>
            <p class="text-lg font-bold text-[#5c4432]">Pesanan berhasil dibuat</p>
            <p class="text-[#7b6858]">Pesananmu sedang menunggu verifikasi admin.</p>
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