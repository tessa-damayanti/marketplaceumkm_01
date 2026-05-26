<div id="tab-akun" class="hidden rounded-[32px] bg-white p-10 shadow-[0_8px_30px_rgba(92,68,50,0.06)] min-h-[500px]">

    <h2 class="text-3xl font-bold text-[#5c4432]">Edit Profil</h2>
    <p class="mt-2 text-[#7b6858] mb-10">
        Perbarui informasi diri Anda agar pengiriman pesanan lebih akurat.
    </p>

    <form action="#" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8"
        onsubmit="saveProfile(event)">

        @csrf

        <div class="col-span-1 md:border-r md:border-[#f4ece3] md:pr-8">
            <label class="mb-4 block text-sm font-bold text-[#5c4432]">
                Foto Profil
            </label>

            <div class="relative inline-block mt-2">
                <img id="profilePreview" src="{{ asset('images/1.png') }}"
                    class="h-36 w-36 rounded-full object-cover shadow-sm ring-4 ring-[#f4ece3]" alt="Foto Profil">

                <label for="profilePhoto"
                    class="absolute bottom-1 right-1 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-[#a16223] text-white shadow-md transition hover:bg-[#86511b]">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                </label>

                <input id="profilePhoto" name="profile_photo" type="file" accept="image/*" class="hidden"
                    onchange="previewProfilePhoto(event)">
            </div>
        </div>

        <div class="col-span-1 md:col-span-2 space-y-5">

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Nama Lengkap
                </label>
                <input id="profileName" name="name" type="text" value="Nikita Willy"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <p id="name-error" class="mt-1 hidden text-xs font-semibold text-red-500">Nama wajib diisi</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    No WhatsApp
                </label>
                <input id="profilePhone" name="phone" type="text" value="0812-3456-7890"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <p id="phone-error" class="mt-1 hidden text-xs font-semibold text-red-500">No WhatsApp wajib diisi</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Email
                </label>
                <input id="profileEmail" name="email" type="email" value="nikita@example.com"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                <p id="email-error" class="mt-1 hidden text-xs font-semibold text-red-500">Email wajib diisi</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Alamat
                </label>
                <textarea id="profileAddress" name="address" rows="4"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">Jl. Melati No. 12, Bandung</textarea>
                <p id="address-error" class="mt-1 hidden text-xs font-semibold text-red-500">Alamat wajib diisi</p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="relative z-10 rounded-xl bg-[#BFA28C] px-8 py-3 font-bold text-white transition hover:bg-[#A88A72]">
                    Simpan
                </button>
            </div>

        </div>

    </form>
</div>

<script>
    function previewProfilePhoto(event) {
        const file = event.target.files[0];

        if (!file) return;

        const preview = document.getElementById('profilePreview');
        preview.src = URL.createObjectURL(file);
    }

    function saveProfile(event) {
        event.preventDefault();

        const nameInput = document.getElementById('profileName');
        const phoneInput = document.getElementById('profilePhone');
        const emailInput = document.getElementById('profileEmail');
        const addressInput = document.getElementById('profileAddress');

        const nameError = document.getElementById('name-error');
        const phoneError = document.getElementById('phone-error');
        const emailError = document.getElementById('email-error');
        const addressError = document.getElementById('address-error');

        let isValid = true;

        // Validasi Nama
        if (!nameInput.value.trim()) {
            nameInput.classList.add('border-red-500');
            nameError.classList.remove('hidden');
            isValid = false;
        } else {
            nameInput.classList.remove('border-red-500');
            nameError.classList.add('hidden');
        }

        // Validasi Phone
        if (!phoneInput.value.trim()) {
            phoneInput.classList.add('border-red-500');
            phoneError.classList.remove('hidden');
            isValid = false;
        } else {
            phoneInput.classList.remove('border-red-500');
            phoneError.classList.add('hidden');
        }

        // Validasi Email
        if (!emailInput.value.trim()) {
            emailInput.classList.add('border-red-500');
            emailError.classList.remove('hidden');
            isValid = false;
        } else {
            emailInput.classList.remove('border-red-500');
            emailError.classList.add('hidden');
        }

        // Validasi Alamat
        if (!addressInput.value.trim()) {
            addressInput.classList.add('border-red-500');
            addressError.classList.remove('hidden');
            isValid = false;
        } else {
            addressInput.classList.remove('border-red-500');
            addressError.classList.add('hidden');
        }

        if (!isValid) return;

        const name = nameInput.value;
        const preview = document.getElementById('profilePreview').src;

        const sidebarName = document.getElementById('sidebarProfileName');
        const sidebarImage = document.getElementById('sidebarProfileImage');

        if (sidebarName) {
            sidebarName.innerText = 'Halo, ' + name;
        }

        if (sidebarImage) {
            sidebarImage.src = preview;
        }

        showToast('Berhasil', 'Profil berhasil diperbarui.');
    }
</script>