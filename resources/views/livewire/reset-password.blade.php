<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>

    @if($isNotificationModalOpen)
     <div class="fixed z-50 inset-0 flex items-center justify-center bg-warna-300/50 ">
       <x-notification-modal class="relative bg-white rounded-lg shadow-lg p-6 mx-7 md:mx-0 w-full max-w-md text-center">
            <x-slot name="title">{{ session('message.title') }}</x-slot>
            <x-slot name="description">{{ session('message.description') }}</x-slot>
            <x-slot name="button">
                <button @click="show = false" wire:click="closeNotificationModal" class="px-12 py-2 bg-warna-200/60 hover:bg-warna-200/80 active:scale-95 transition-all text-warna-50 rounded-lg">OK</button>
            </x-slot>
        </x-notification-modal>
     </div>
    @endif

    <form wire:submit.prevent="resetPassword">
        <!-- Password Lama -->
        <div class="relative mb-6">
            <input type="password" id="old_password" wire:model.defer="old_password" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " />
            <label for="old_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password Lama</label>
            <button type="button" onclick="togglePassword('old_password', 'eyeOld')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                <span id="eyeOld"><i class="fa-solid fa-eye"></i></span>
            </button>
            @error('old_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password Baru -->
        <div class="relative mb-6">
            <input type="password" id="new_password" wire:model.defer="new_password" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " />
            <label for="new_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password Baru</label>
            <button type="button" onclick="togglePassword('new_password', 'eyeNew')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                <span id="eyeNew"><i class="fa-solid fa-eye"></i></span>
            </button>
            @error('new_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="relative mb-6">
            <input type="password" id="new_password_confirmation" wire:model.defer="new_password_confirmation" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " />
            <label for="new_password_confirmation" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Konfirmasi Password Baru</label>
            <button type="button" onclick="togglePassword('new_password_confirmation', 'eyeConfirm')" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                <span id="eyeConfirm"><i class="fa-solid fa-eye"></i></span>
            </button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-3 py-2 bg-warna-400 text-white rounded-lg hover:bg-warna-400/80">
                Simpan
            </button>
        </div>
    </form>
</div>


<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
    }
</script>
