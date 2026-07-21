@php
    $activeTab = request()->query('tab');
    if (!in_array($activeTab, ['akun', 'riwayat', 'password'])) {
        $activeTab = (request()->query('page') || request()->query('status')) ? 'riwayat' : 'akun';
    }
@endphp
<div id="tab-akun" class="{{ $activeTab === 'akun' ? 'block' : 'hidden' }} rounded-[32px] bg-white p-10 shadow-[0_8px_30px_rgba(92,68,50,0.06)] min-h-[500px]">

    <h2 class="text-3xl font-bold text-[#5c4432]">Edit Profil</h2>
    <p class="mt-2 text-[#7b6858] mb-10">
        Perbarui informasi diri Anda agar pengiriman pesanan lebih akurat.
    </p>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">

        @csrf
        @method('PUT')

        <div class="col-span-1 md:border-r md:border-[#f4ece3] md:pr-8">
            <label class="mb-4 block text-sm font-bold text-[#5c4432]">
                Foto Profil
            </label>

            <div class="relative inline-block mt-2 flex-shrink-0">
                <img id="profilePreview" src="{{ Auth::user()->foto_profile_url }}"
                    class="h-36 w-36 aspect-square rounded-full object-cover shadow-sm ring-4 ring-[#f4ece3]" alt="Foto Profil">

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
            <!-- Tempat untuk menampilkan error message -->
            <p id="profilePhotoError" class="mt-2 text-xs font-semibold text-red-500 w-36 text-center transition-all duration-300 {{ $errors->has('profile_photo') ? 'block' : 'hidden' }}">
                {{ $errors->first('profile_photo') }}
            </p>
        </div>

        <div class="col-span-1 md:col-span-2 space-y-5">

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Nama Lengkap
                </label>
                <input id="profileName" name="name" type="text" value="{{ old('name', Auth::user()->nama_lengkap ?? Auth::user()->username) }}"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                @error('name')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    No WhatsApp
                </label>
                <input id="profilePhone" name="phone" type="text" value="{{ old('phone', Auth::user()->no_wa) }}"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">
                @error('phone')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Email
                </label>
                <input id="profileEmail" name="email" type="email" value="{{ Auth::user()->email }}" readonly
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] bg-gray-50 focus:outline-none focus:border-[#a16223] transition-all">
                @error('email')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-[#5c4432]">
                    Alamat
                </label>
                <textarea id="profileAddress" name="address" rows="4"
                    class="w-full rounded-2xl border border-[#f2e4d8] px-5 py-3.5 text-[#7b6858] focus:outline-none focus:border-[#a16223] transition-all">{{ old('address', Auth::user()->alamat) }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="rounded-2xl bg-[#d8c3af] px-8 py-4 font-bold text-white transition hover:bg-[#BFA28C]">
                    Simpan
                </button>
            </div>

        </div>

    </form>
</div>

<script>
    // State to store if the selected file is valid
    let isFileValid = true;

    function previewProfilePhoto(event) {
        const file = event.target.files[0];
        const errorEl = document.getElementById('profilePhotoError');
        const preview = document.getElementById('profilePreview');

        if (!file) return;

        // Reset state
        isFileValid = true;
        errorEl.classList.add('hidden');
        errorEl.classList.remove('block');
        errorEl.textContent = '';
        errorEl.style.opacity = '0';

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showError('aFormat foto harus jpeg, png, atau jpg.');
            event.target.value = ''; // Reset input file
            isFileValid = false;
            return;
        }

        // Validasi ukuran file 
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            showError('Ukuran foto profil maksimal 2 MB.');
            event.target.value = ''; // Reset input file
            isFileValid = false;
            return;
        }

        // Tampilkan pratinjau jika valid
        preview.src = URL.createObjectURL(file);
    }

    function showError(message) {
        const errorEl = document.getElementById('profilePhotoError');
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
        errorEl.classList.add('block');
        
        // Animasi fade-in sederhana
        errorEl.style.opacity = '0';
        errorEl.style.transform = 'translateY(-5px)';
        errorEl.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            errorEl.style.opacity = '1';
            errorEl.style.transform = 'translateY(0)';
        }, 10);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector(`form[action="{{ route('profile.update') }}"]`);
        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Cek sekali lagi validasi file
                if (!isFileValid) {
                    e.preventDefault();
                    // Scroll ke bagian foto profil agar terlihat
                    document.getElementById('profilePhotoError').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
            });
        }
    });
</script>