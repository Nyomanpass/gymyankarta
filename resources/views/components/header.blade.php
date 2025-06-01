<header class="flex items-center justify-between bg-gray-100 px-6 py-7 shadow-sm lg:pl-72">
    
  <button @click="$dispatch('toggle-sidebar')" class="text-black lg:hidden">
    <ion-icon name="menu-outline" class="text-3xl"></ion-icon>
  </button>

  <h1 class="text-2xl font-bold text-black hidden lg:block">Admin</h1>

  <div class="flex items-center space-x-4 ml-auto">
    <ion-icon name="notifications-outline" class="text-2xl text-black cursor-pointer"></ion-icon>
    <div class="flex items-center space-x-2 cursor-pointer">
      <span class="text-sm font-medium text-black">Hello Pastika</span>
      <ion-icon name="chevron-down-outline" class="text-md text-black"></ion-icon>
    </div>
  </div>
</header>
