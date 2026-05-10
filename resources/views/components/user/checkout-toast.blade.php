<!-- Toast Pesanan Berhasil -->
<div id="orderToast"
    class="pointer-events-none fixed right-6 top-6 z-[9999] translate-y-3 opacity-0 transition-all duration-500">
    <div class="flex min-w-[320px] max-w-[360px] items-start gap-3 rounded-[24px] border border-white/60 bg-[#fffaf6]/95 px-5 py-4 shadow-[0_24px_60px_rgba(92,68,50,0.18)] backdrop-blur">
        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-[#dff1e3] text-[#5e936c]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-bold text-[#5c4432]">Berhasil</p>
            <p class="mt-1 text-sm leading-6 text-[#7b6858]">Pesanan berhasil dibuat</p>
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

    function setError(inputId, msgId, message, isTextarea = false, isUpload = false) {
        const input = isUpload ? document.getElementById('uploadBox') : (isTextarea ? document.querySelector('textarea[name="' + inputId + '"]') : document.querySelector('input[name="' + inputId + '"]'));
        const msg = document.getElementById(msgId);

        if (msg) {
            msg.textContent = message;
            msg.classList.remove('hidden');
        }
        if (input) {
            input.classList.add('border-[#dc2626]', 'ring-4', 'ring-[#dc2626]/10');
        }
    }

    function clearError(inputId, msgId, isTextarea = false, isUpload = false) {
        const input = isUpload ? document.getElementById('uploadBox') : (isTextarea ? document.querySelector('textarea[name="' + inputId + '"]') : document.querySelector('input[name="' + inputId + '"]'));
        const msg = document.getElementById(msgId);

        if (msg) {
            msg.textContent = '';
            msg.classList.add('hidden');
        }
        if (input) {
            input.classList.remove('border-[#dc2626]', 'ring-4', 'ring-[#dc2626]/10');
        }
    }

    function showOrderToast(event) {
        event.preventDefault();

        const name = document.querySelector('input[name="buyer_name"]');
        const phone = document.querySelector('input[name="buyer_phone"]');
        const address = document.querySelector('textarea[name="buyer_address"]');
        const proof = document.getElementById('bukti-transfer');

        // Clear all previous errors
        clearError('buyer_name', 'name-msg');
        clearError('buyer_phone', 'phone-msg');
        clearError('buyer_address', 'address-msg', true);
        clearError('uploadBox', 'proof-msg', false, true);

        let isValid = true;

        if (!name.value.trim()) {
            setError('buyer_name', 'name-msg', 'Nama lengkap wajib diisi');
            isValid = false;
        }
        if (!phone.value.trim()) {
            setError('buyer_phone', 'phone-msg', 'No WhatsApp wajib diisi');
            isValid = false;
        }
        if (!address.value.trim()) {
            setError('buyer_address', 'address-msg', 'Alamat pengiriman wajib diisi', true);
            isValid = false;
        }
        if (!proof.files || proof.files.length === 0) {
            setError('uploadBox', 'proof-msg', 'Bukti pembayaran wajib diunggah', false, true);
            isValid = false;
        } else {
            const file = proof.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                setError('uploadBox', 'proof-msg', 'Format file harus JPG atau PNG', false, true);
                isValid = false;
            }
        }

        if (!isValid) return;

        // Tampilkan Toast Berhasil
        const toast = document.getElementById('orderToast');
        if (toast) {
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-3', 'pointer-events-none');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 1200);
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }
</script>