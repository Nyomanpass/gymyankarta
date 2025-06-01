@php
    $navLinks = [
        ['label' => 'Dashboard', 'url' => '/', 'match' => '/'],
        ['label' => 'Kelola Member', 'url' => '/member', 'match' => 'member*'],
        ['label' => 'Input Pendapatan', 'url' => '/pendapatan', 'match' => 'pendapatan*'],
    ];
@endphp

<div 
  class="fixed inset-y-0 left-0 z-30 w-72 bg-[#1e2c3a] text-white transform transition-transform duration-200 ease-in-out
         lg:translate-x-0 lg:static lg:inset-0"
         :class="{ '-translate-x-full': !sidebarOpen }"
>
<!-- Tombol close hanya muncul di mobile -->
<div class="flex justify-end px-4 py-2 lg:hidden">
  <button @click="sidebarOpen = false">
    <ion-icon name="close-outline" class="text-3xl text-white"></ion-icon>
  </button>
</div>


  <div class="flex items-center px-4 py-5 h-20 border-b border-gray-700">
      <img src="/images/logo.png" alt="Logo" class="w-16 h-16 rounded-full mr-2">
      <div>
          <h1 class="text-lg font-bold">YANKARTA <span class="text-orange-400">GYM</span></h1>
          <p class="text-sm italic">FITNESS CENTER</p>
      </div>
  </div>
  <nav class="mt-6 space-y-5 px-4">
      @foreach ($navLinks as $link)
          <a href="{{ url($link['url']) }}"
            class="flex items-center space-x-3 px-3 py-2 rounded
              {{ request()->is($link['match']) 
                  ? 'bg-orange-500' 
                  : 'hover:bg-gray-700' }}"
          >
              {{-- Pilih icon sesuai label, contoh sederhana --}}
              @if ($link['label'] === 'Dashboard')
                <ion-icon name="home-outline" class="text-xl"></ion-icon>
              @elseif ($link['label'] === 'Kelola Member')
                <ion-icon name="person-outline" class="text-xl"></ion-icon>
              @elseif ($link['label'] === 'Input Pendapatan')
                <ion-icon name="cash-outline" class="text-xl"></ion-icon>
              @endif

              <span>{{ $link['label'] }}</span>
          </a>
      @endforeach
  </nav>
</div>
