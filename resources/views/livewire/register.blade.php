<div class="flex items-center justify-center min-h-screen ">
    <div class="w-full max-w-lg p-8">
        <div class="mb-10 lg:mb-14">
            <div class="mb-3 mx-auto w-24 h-24 bg-warna-500 flex items-center justify-center rounded-full p-1">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-cover">
            </div>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-2">Buat Akun Barumu</h2>
            <p class="text-center text-warna-300">Bergabung bersama kami untuk mendapatkan akses ekslusif di GYMYAKARTA</p>
        </div>
        <form wire:submit.prevent="register">
            <x-g-input 
                id="name"
                label="Nama Lengkap"
                wire:model="name"
                type="text"

            />
            <x-g-input 
                id="name"
                label="username"
                wire:model="username"
                class="mt-4 md:mt-5"
            />
            
            <x-g-input 
                id="name"
                label="Email"
                wire:model="email"
                class="mt-4 md:mt-5"
                type="email"
            />

           
            <button
                    class="mt-10 w-full py-2 px-4 bg-warna-400 text-white font-semibold rounded-md hover:bg-warna-500 focus:outline-none active:scale-95 transition-all duration-200">
                Register
            </button>
            <p class="mt-4 text-sm">Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-warna-400 hover:underline">Masuk</a>
            </p>
        </form>
    </div>
    
</div>
