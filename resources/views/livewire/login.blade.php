<div class="flex items-center justify-center min-h-screen ">
    <div class="w-full max-w-lg p-8">
        <div class="mb-10 lg:mb-14">
            <div class="mb-3 mx-auto w-24 h-24 bg-warna-500 flex items-center justify-center rounded-full p-1">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-cover">
            </div>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Selamat Datang Kembali!</h2>
            <p class="text-center text-warna-300">Silahkan login untuk mendapatkan akses ekslusif di GYMYAKARTA</p>
        </div>
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit.prevent="login">          
              
            <div class="relative mt-6">
                <input type="text" id="username" name="username" wire:model="username" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                <label for="username" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Username</label>
            </div>

            <div class="relative mt-6">
                <input type="password" id="password" name="password" wire:model="password" class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer" placeholder=" " required/>
                <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3">Password</label>
                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-500 focus:outline-none">
                    <span id="eyeIcon"><i class="fa-solid fa-eye"></i></span>
                </button>
            </div>

            <button type="submit"
                    class="mt-10 w-full py-2 px-4 bg-warna-400 text-white font-semibold rounded-md hover:bg-warna-500 focus:outline-none active:scale-95 transition-all duration-200">
                Login
            </button>
            <p class="mt-4 text-sm">Belum punya akun? 
                <a href="{{ route('register') }}" class="text-warna-400 hover:underline">Daftar Sekarang</a>
            </p>
        </form>
    </div>
    


    <script>
        function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');
                if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                } else {
                            passwordInput.type = 'password';
                            eyeIcon.innerHTML = '<i class="fa-solid fa-eye"></i>';
                }
        }
    </script>
</div>
