<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GYM YANKARTA | Pusat Kebugaran Modern di Taman Griya - Fasilitas Lengkap & Terjangkau</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <!--alpinejs-->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <style>
          html {
            scroll-behavior: smooth;
          }
        </style>


    </head>
  
<body class="bg-gray-100 font-poppins">

 
    <header 
      id="header" 
      x-data="{ mobileMenuOpen: false, scrolled: false }"
      class="fixed top-0 left-0 w-full z-50 text-white transition-all duration-300"
      @scroll.window="scrolled = window.pageYOffset > 50"
      :class="(scrolled || mobileMenuOpen) ? 'bg-warna-300' : 'bg-transparent'"
      >
      <!-- Container -->
      <div class="container mx-auto flex items-center justify-between py-3 px-6 lg:px-14">
        <!-- Logo -->
        <div class="flex items-center">
          <img src="logo.png" alt="Company Logo" class="h-12 md:h-14">
          <h1 class="text-white font-bold ml-3 text-lg md:text-xl">GYM YANKARTA</h1>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center space-x-8">
          <a href="#home" class="hover:text-warna-400 transition duration-300">Home</a>
          <a href="#about" class="hover:text-warna-400 transition duration-300">About</a>
          <a href="#faq" class="hover:text-warna-400 transition duration-300">FAQ</a>
          <a href="#contact" class="hover:text-warna-400 transition duration-300">Contact</a>
          <div class="flex items-center space-x-3 ml-6">
              <a href="{{ route('register') }}" 
                 class="px-5 py-2 rounded-full bg-warna-400 hover:bg-warna-500 text-white text-sm font-medium transition duration-300 shadow-md">
                 Join Member
              </a>
              <a href="{{ route('login') }}" 
                 class="px-5 py-2 rounded-full text-warna-400 border border-warna-400 hover:bg-warna-400 hover:text-white text-sm font-medium transition duration-300 shadow-md">
                 Login
              </a>
          </div>
        </nav>

        <!-- Mobile Menu Button -->
        <button 
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white/20">
          <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
            <span class="block w-5 h-0.5 bg-white transition-all duration-300"
                  :class="mobileMenuOpen ? 'rotate-45 translate-y-1.5' : ''"></span>
            <span class="block w-5 h-0.5 bg-white transition-all duration-300"
                  :class="mobileMenuOpen ? 'opacity-0' : ''"></span>
            <span class="block w-5 h-0.5 bg-white transition-all duration-300"
                  :class="mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : ''"></span>
          </div>
        </button>
      </div>

      <!-- Mobile Dropdown -->
      <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full"
        class="lg:hidden w-full bg-warna-300/95 backdrop-blur-sm shadow-xl border-t border-white/10">
        <nav class="container mx-auto px-6 py-6">
          <div class="flex flex-col space-y-3">
            <a href="#home" 
               @click="mobileMenuOpen = false"
               class="block py-3 px-4 rounded-lg text-white hover:bg-white/10 hover:text-warna-400 transition duration-300">
               Home
            </a>
            <a href="#about" 
               @click="mobileMenuOpen = false"
               class="block py-3 px-4 rounded-lg text-white hover:bg-white/10 hover:text-warna-400 transition duration-300">
               About
            </a>
            <a href="#faq" 
               @click="mobileMenuOpen = false"
               class="block py-3 px-4 rounded-lg text-white hover:bg-white/10 hover:text-warna-400 transition duration-300">
               FAQ
            </a>
            <a href="#contact" 
               @click="mobileMenuOpen = false"
               class="block py-3 px-4 rounded-lg text-white hover:bg-white/10 hover:text-warna-400 transition duration-300">
               Contact
            </a>
            <div class="pt-5 border-t border-white/20 space-y-3">
              <a href="{{ route('register') }}" 
                 class="block w-full py-3 px-4 rounded-lg bg-warna-400 hover:bg-warna-500 text-white text-center font-medium transition duration-300 shadow-md">
                 Join Member
              </a>
              <a href="{{ route('login') }}" 
                 class="block w-full py-3 px-4 rounded-lg text-warna-400 border border-warna-400 hover:bg-warna-400 hover:text-white text-center font-medium transition duration-300 shadow-md">
                 Login
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>


    <!-- Hero Section -->
    <section id="home" class="relative bg-cover bg-center h-screen overflow-hidden"
    style="background-image: url('gymjimbaran.webp');">
      <!-- Overlay dengan gradient yang lebih dinamis -->
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-transparent"></div>
      
      <!-- Animated particles background -->
      <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-2 h-2 bg-warna-400 rounded-full animate-pulse"></div>
        <div class="absolute top-40 right-20 w-3 h-3 bg-warna-500 rounded-full animate-bounce"></div>
        <div class="absolute bottom-32 left-16 w-1 h-1 bg-white rounded-full animate-ping"></div>
        <div class="absolute bottom-20 right-32 w-2 h-2 bg-warna-400 rounded-full animate-pulse"></div>
      </div>
      
      <!-- Konten Hero -->
      <div class="container mx-auto h-screen flex items-center justify-center px-6 lg:px-14 relative z-10">
        <div class="max-w-4xl text-center text-white" data-aos="fade-up" data-aos-duration="1000">
          <!-- Badge -->
          <div class="inline-flex items-center bg-warna-400/20 backdrop-blur-sm border border-warna-400/30 text-warna-400 px-4 py-2 rounded-full text-sm font-medium mb-6 animate-fade-in">
            <i class="fas fa-fire mr-2"></i>
            Gym Terbaik di Jimbaran
          </div>
          
          <!-- Main Heading dengan efek typing -->
          <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-6 bg-gradient-to-r from-white via-gray-100 to-warna-400 bg-clip-text text-transparent">
            Bukan Tentang Siapa yang 
            <span class="text-warna-400 animate-pulse">Terkuat</span>, 
            <br class="hidden md:block">
            Tapi Siapa yang 
            <span class="text-warna-400 animate-pulse">Tidak Menyerah</span>
          </h1>
          
          <!-- Subtitle -->
          <p class="mt-6 text-lg md:text-xl text-gray-200 leading-relaxed max-w-2xl mx-auto">
            Akses Alat Gym Terlengkap, Personal Trainer Profesional, dan Suasana Latihan yang Membakar Semangat!
          </p>
          
          <!-- Stats Row -->
          <div class="flex flex-wrap justify-center gap-6 md:gap-8 mt-8 mb-10">
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold text-warna-400">500+</div>
              <div class="text-sm text-gray-300">Member Aktif</div>
            </div>
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold text-warna-400">50+</div>
              <div class="text-sm text-gray-300">Alat Modern</div>
            </div>
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold text-warna-400">13h</div>
              <div class="text-sm text-gray-300">Buka/Hari</div>
            </div>
          </div>
          
          <!-- CTA Buttons -->
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
            <a href="{{ route('register') }}" 
               class="group relative overflow-hidden bg-gradient-to-r from-warna-400 to-warna-500 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-warna-400/25">
              <span class="relative z-10 flex items-center">
                <i class="fas fa-rocket mr-2"></i>
                JOIN MEMBER SEKARANG
              </span>
              <div class="absolute inset-0 bg-gradient-to-r from-warna-500 to-warna-600 translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
            </a>
            
            <a href="https://wa.me/6281936011544?text=Halo,%20saya%20ingin%20menanyakan%20informasi%20seputar%20gym%20ini." 
               target="_blank"
               class="group flex items-center bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 hover:bg-white hover:text-gray-800 hover:scale-105">
              <i class="fab fa-whatsapp mr-2 group-hover:animate-bounce"></i>
              HUBUNGI KAMI
            </a>
          </div>
        </div>
      </div>
      
      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
        <div class="flex flex-col items-center">
          <span class="text-sm mb-2">Scroll Down</span>
          <i class="fas fa-chevron-down text-warna-400"></i>
        </div>
      </div>
      
      <!-- Floating elements -->
      <div class="absolute top-1/4 left-10 hidden lg:block">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <i class="fas fa-dumbbell text-warna-400 text-2xl"></i>
        </div>
      </div>
      
      <div class="absolute bottom-1/4 right-10 hidden lg:block">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <i class="fas fa-trophy text-warna-400 text-2xl"></i>
        </div>
      </div>
    </section>




    <!-- Why Choose Us -->
<!-- Why Choose Us Section -->
<section id="about" class="py-16 md:py-24 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4 md:px-6 lg:px-16">
    <!-- Section Header -->
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">Mengapa Memilih Gym Yankarta?</h2>
      <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">Fasilitas terbaik dengan harga terjangkau untuk mendukung perjalanan fitness Anda</p>
    </div>

    <!-- Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-16">
      <!-- Card 1 -->
      <div class="group bg-white p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-warna-400 to-warna-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-dumbbell text-white text-2xl md:text-3xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3">Peralatan Modern</h3>
        <p class="text-sm md:text-base text-gray-600 leading-relaxed">Alat gym berkualitas tinggi dari brand ternama internasional untuk hasil latihan maksimal</p>
      </div>

      <!-- Card 2 -->
      <div class="group bg-white p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-green-400 to-green-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-tags text-white text-2xl md:text-3xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3">Harga Terjangkau</h3>
        <p class="text-sm md:text-base text-gray-600 leading-relaxed">Membership dengan harga bersahabat tanpa mengurangi kualitas fasilitas dan pelayanan</p>
      </div>

      <!-- Card 3 -->
      <div class="group bg-white p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 md:col-span-2 lg:col-span-1">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-spa text-white text-2xl md:text-3xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3">Tempat Bersih & Nyaman</h3>
        <p class="text-sm md:text-base text-gray-600 leading-relaxed">Lingkungan higienis, sejuk, dan atmosfer yang mendukung untuk latihan optimal</p>
      </div>
    </div>
  </div>
</section>

<!-- About Us Section -->
<section id="profil" class="py-16 md:py-24 bg-white">
  <div class="container mx-auto px-4 md:px-6 lg:px-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
      <!-- Content -->
      <div class="order-2 lg:order-1">
        <div class="inline-block bg-warna-400/10 text-warna-500 px-4 py-2 rounded-full text-sm font-medium mb-4">
          Tentang Kami
        </div>
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-6">Gym Modern Terdepan di Jimbaran</h2>
        <p class="text-base md:text-lg text-gray-600 mb-6 leading-relaxed">
          Gym Yankarta hadir sebagai pusat kebugaran terdepan di <span class="font-semibold text-warna-500">Jimbaran, Bali</span>. Berlokasi strategis di Jalan Nuansa Utama, kami menawarkan pengalaman fitness yang tak terlupakan.
        </p>
        <p class="text-sm md:text-base text-gray-600 mb-8 leading-relaxed">
          Dengan fasilitas lengkap, lingkungan bersih, dan atmosfer yang motivatif, Gym Yankarta cocok untuk semua kalangan - dari pemula hingga atlet berpengalaman. Komitmen kami adalah memberikan hasil nyata melalui latihan yang aman dan menyenangkan.
        </p>
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
          <div class="text-center p-4 bg-gray-50 rounded-xl">
            <div class="text-2xl md:text-3xl font-bold text-warna-500 mb-1">500+</div>
            <div class="text-xs md:text-sm text-gray-600">Member Aktif</div>
          </div>
          <div class="text-center p-4 bg-gray-50 rounded-xl">
            <div class="text-2xl md:text-3xl font-bold text-warna-500 mb-1">50+</div>
            <div class="text-xs md:text-sm text-gray-600">Alat Modern</div>
          </div>
          <div class="text-center p-4 bg-gray-50 rounded-xl col-span-2 md:col-span-1">
            <div class="text-2xl md:text-3xl font-bold text-warna-500 mb-1">13 Jam</div>
            <div class="text-xs md:text-sm text-gray-600">Operasional/Hari</div>
          </div>
        </div>
      </div>

      <!-- Image -->
      <div class="order-1 lg:order-2">
        <div class="relative">
          <img src="gymjimbaran3.webp" alt="Gym Yankarta Interior" class="w-full h-64 md:h-80 lg:h-96 object-cover rounded-2xl shadow-2xl">
          <div class="absolute -bottom-4 -left-4 w-20 h-20 md:w-24 md:h-24 bg-warna-400 rounded-2xl flex items-center justify-center shadow-xl">
            <i class="fas fa-award text-white text-xl md:text-2xl"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Membership Steps Section -->
<section id="langkah-member" class="py-16 md:py-24 bg-gradient-to-r from-warna-300 to-warna-400 relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white rounded-full"></div>
    <div class="absolute bottom-20 right-20 w-32 h-32 border-2 border-white rounded-full"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 border border-white rounded-full"></div>
  </div>

  <div class="container mx-auto px-4 md:px-6 text-center relative z-10">
    <div class="mb-12 md:mb-16">
      <h2 class="text-2xl md:text-4xl font-bold text-white mb-4">5 Langkah Mudah Jadi Member</h2>
      <p class="text-base md:text-lg text-white/90 max-w-2xl mx-auto">Proses pendaftaran yang simple dan cepat untuk memulai perjalanan fitness Anda</p>
    </div>

    <!-- Steps -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 md:gap-8 mb-12">
      <!-- Step 1 -->
      <div class="group">
        <div class="relative mb-6">
          <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white text-warna-500 flex items-center justify-center text-xl md:text-2xl font-bold mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
            1
          </div>
          <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-white/50"></div>
        </div>
        <h3 class="text-white font-semibold text-base md:text-lg mb-3">Pendaftaran</h3>
        <p class="text-white/80 text-xs md:text-sm leading-relaxed">Klik "Join Member" dan isi formulir pendaftaran dengan data lengkap</p>
      </div>

      <!-- Step 2 -->
      <div class="group">
        <div class="relative mb-6">
          <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white text-warna-500 flex items-center justify-center text-xl md:text-2xl font-bold mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
            2
          </div>
          <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-white/50"></div>
        </div>
        <h3 class="text-white font-semibold text-base md:text-lg mb-3">Verifikasi Email</h3>
        <p class="text-white/80 text-xs md:text-sm leading-relaxed">Cek email dan klik link aktivasi untuk melanjutkan proses</p>
      </div>

      <!-- Step 3 -->
      <div class="group">
        <div class="relative mb-6">
          <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white text-warna-500 flex items-center justify-center text-xl md:text-2xl font-bold mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
            3
          </div>
          <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-white/50"></div>
        </div>
        <h3 class="text-white font-semibold text-base md:text-lg mb-3">Pembayaran</h3>
        <p class="text-white/80 text-xs md:text-sm leading-relaxed">Lakukan pembayaran di kasir sesuai dengan jumlah yang telah ditentukan</p>
      </div>

      <!-- Step 4 -->
      <div class="group">
        <div class="relative mb-6">
          <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white text-warna-500 flex items-center justify-center text-xl md:text-2xl font-bold mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
            4
          </div>
          <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-white/50"></div>
        </div>
        <h3 class="text-white font-semibold text-base md:text-lg mb-3">Verifikasi Admin</h3>
        <p class="text-white/80 text-xs md:text-sm leading-relaxed">Admin memverifikasi data dan pembayaran dalam waktu cepat</p>
      </div>

      <!-- Step 5 -->
      <div class="group">
        <div class="relative mb-6">
          <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white text-warna-500 flex items-center justify-center text-xl md:text-2xl font-bold mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
            5
          </div>
        </div>
        <h3 class="text-white font-semibold text-base md:text-lg mb-3">Akses Dashboard</h3>
        <p class="text-white/80 text-xs md:text-sm leading-relaxed">Login dan nikmati fitur lengkap dashboard member</p>
      </div>
    </div>

    <a href="{{ route('register') }}" class="inline-flex items-center bg-white text-warna-500 font-semibold py-3 md:py-4 px-6 md:px-8 rounded-full hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
      <span class="mr-2">Mulai Sekarang</span>
      <i class="fas fa-arrow-right"></i>
    </a>
  </div>
</section>

<!-- Pricing Section -->
<section id="harga-member" class="py-16 md:py-24 bg-gray-50">
  <div class="container mx-auto px-4 md:px-6">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">Paket Membership Terjangkau</h2>
      <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan dan budget Anda</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 max-w-4xl mx-auto">
      <!-- Daily Package -->
      <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-6 md:p-8">
        <div class="text-center">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-calendar-day text-white text-2xl"></i>
          </div>
          <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Paket Harian</h3>
          <div class="mb-6">
            <span class="text-3xl md:text-4xl font-extrabold text-blue-500">Rp15.000</span>
            <span class="text-gray-500 text-sm">/hari</span>
          </div>
          
          <ul class="text-left space-y-3 mb-8 text-sm md:text-base">
            <li class="flex items-center">
              <i class="fas fa-check-circle text-green-500 mr-3"></i>
              <span>Akses gym selama 1 hari penuh</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check-circle text-green-500 mr-3"></i>
              <span>Semua alat gym tersedia</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check-circle text-green-500 mr-3"></i>
              <span>Perfect untuk trial pertama</span>
            </li>
          </ul>
          
          <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-md hover:shadow-lg">
            Coba Hari Ini
          </button>
        </div>
      </div>

      <!-- Monthly Package (Featured) -->
      <div class="bg-gradient-to-br from-warna-400 to-warna-500 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-6 md:p-8 text-white relative overflow-hidden">
        <!-- Popular Badge -->
        <div class="absolute -top-1 -right-1 bg-yellow-400 text-gray-800 px-3 py-1 rounded-bl-xl text-xs font-bold">
          POPULER
        </div>
        
        <div class="text-center relative z-10">
          <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-crown text-white text-2xl"></i>
          </div>
          <h3 class="text-xl md:text-2xl font-bold mb-2">Member Bulanan</h3>
          <div class="mb-6">
            <span class="text-3xl md:text-4xl font-extrabold">Rp100.000</span>
            <span class="text-white/80 text-sm">/bulan</span>
          </div>
          
          <ul class="text-left space-y-3 mb-8 text-sm md:text-base">
            <li class="flex items-center">
              <i class="fas fa-check-circle text-white mr-3"></i>
              <span>Akses unlimited 30 hari</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check-circle text-white mr-3"></i>
              <span>Jadwal latihan fleksibel</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check-circle text-white mr-3"></i>
              <span>Hemat 50% dari harian</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check-circle text-white mr-3"></i>
              <span>Dashboard member eksklusif</span>
            </li>
          </ul>
          
          <a href="{{ route('register') }}" class="block w-full bg-white text-warna-500 font-semibold py-3 rounded-xl transition duration-300 shadow-md hover:shadow-lg hover:bg-gray-100">
            Join Member Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-16 md:py-24 bg-white">
  <div class="container mx-auto px-4 md:px-6 max-w-4xl">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">Pertanyaan yang Sering Ditanyakan</h2>
      <p class="text-base md:text-lg text-gray-600">Temukan jawaban untuk pertanyaan umum seputar Gym Yankarta</p>
    </div>

    <div class="space-y-4">
      <div id="faq1" class="group cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-2xl p-4 md:p-6 transition-all duration-300">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold text-base md:text-lg text-gray-800 pr-4">Apa saja fasilitas yang tersedia di Gym Yankarta?</h3>
          <div class="text-warna-500 group-hover:rotate-180 transition-transform duration-300">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
        <p id="answer1" class="mt-4 text-sm md:text-base text-gray-600 leading-relaxed hidden">
          Kami menyediakan alat gym lengkap untuk latihan beban dan kardio dari brand ternama, loker penyimpanan yang aman, dan area istirahat yang nyaman.
        </p>
      </div>

      <div id="faq2" class="group cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-2xl p-4 md:p-6 transition-all duration-300">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold text-base md:text-lg text-gray-800 pr-4">Apakah bisa bayar harian tanpa jadi member?</h3>
          <div class="text-warna-500 group-hover:rotate-180 transition-transform duration-300">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
        <p id="answer2" class="mt-4 text-sm md:text-base text-gray-600 leading-relaxed hidden">
          Tentu saja! Kami menyediakan paket harian dengan harga Rp15.000 untuk akses gym selama satu hari penuh. Cocok untuk yang ingin mencoba terlebih dahulu.
        </p>
      </div>

      <div id="faq3" class="group cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-2xl p-4 md:p-6 transition-all duration-300">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold text-base md:text-lg text-gray-800 pr-4">Apakah pemula boleh latihan di Gym Yankarta?</h3>
          <div class="text-warna-500 group-hover:rotate-180 transition-transform duration-300">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
        <p id="answer3" class="mt-4 text-sm md:text-base text-gray-600 leading-relaxed hidden">
          Sangat welcome! Gym kami sangat ramah untuk pemula. Staff kami yang berpengalaman siap membantu memberikan panduan dasar dan tips keamanan latihan.
        </p>
      </div>

      <div id="faq4" class="group cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-2xl p-4 md:p-6 transition-all duration-300">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold text-base md:text-lg text-gray-800 pr-4">Jam operasional Gym Yankarta?</h3>
          <div class="text-warna-500 group-hover:rotate-180 transition-transform duration-300">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
        <p id="answer4" class="mt-4 text-sm md:text-base text-gray-600 leading-relaxed hidden">
          Kami buka setiap hari dari pukul 08.00 – 21.00 WIB, memberikan fleksibilitas untuk latihan pagi, siang, maupun malam sesuai jadwal Anda.
        </p>
      </div>

      <div id="faq5" class="group cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-2xl p-4 md:p-6 transition-all duration-300">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold text-base md:text-lg text-gray-800 pr-4">Bagaimana cara mendaftar menjadi member?</h3>
          <div class="text-warna-500 group-hover:rotate-180 transition-transform duration-300">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
        <p id="answer5" class="mt-4 text-sm md:text-base text-gray-600 leading-relaxed hidden">
          Prosesnya mudah: 1) Klik "Join Us" dan isi formulir, 2) Verifikasi email, 3) Lakukan pembayaran, 4) Tunggu verifikasi admin, 5) Akses dashboard member Anda.
        </p>
      </div>
    </div>
  </div>
</section>

    
    
      <!-- Contact Section -->
      <section id="contact" class="py-16 md:py-24 bg-gradient-to-br from-gray-900 via-warna-300 to-warna-400 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-20 left-10 w-32 h-32 border-2 border-white rounded-full animate-pulse"></div>
          <div class="absolute bottom-20 right-20 w-20 h-20 border border-white rounded-full animate-bounce"></div>
          <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/20 rounded-full"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
          <!-- Section Header -->
          <div class="text-center mb-12 md:mb-16">
            <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium mb-4">
              <i class="fas fa-map-marker-alt mr-2"></i>
              Lokasi Kami
            </div>
            <h2 class="text-2xl md:text-4xl font-bold text-white mb-4">Ayo Latihan di Lokasi Kami!</h2>
            <p class="text-base md:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed">
              Gym Yankarta hadir di <span class="font-semibold text-yellow-300">Jimbaran</span> dengan fasilitas lengkap dan suasana nyaman. Kunjungi kami sekarang!
            </p>
          </div>

          <!-- Map Container -->
          <div class="relative">
            <div class="bg-white rounded-3xl p-4 md:p-6 shadow-2xl transform hover:scale-[1.02] transition-transform duration-300">
              <div class="relative rounded-2xl overflow-hidden shadow-lg" style="height: 350px; md:height: 450px;">
                <iframe 
                  class="w-full h-full border-0"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5680.855906333656!2d115.183003541377!3d-8.795953837296734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd245d62cc0d2c3%3A0xa03e0537f2942537!2sYAN%20KARTA%20GYM!5e1!3m2!1sid!2sid!4v1750061481689!5m2!1sid!2sid"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                
                <!-- Map Overlay Info -->
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm rounded-xl p-3 shadow-lg">
                  <div class="flex items-center text-warna-500">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span class="text-sm font-semibold">Gym Yankarta</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
              <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 md:p-6 text-center text-white">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                  <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="font-semibold mb-2">Jam Operasional</h3>
                <p class="text-sm text-white/80">08.00 - 21.00 WIB</p>
                <p class="text-xs text-white/70">Setiap Hari</p>
              </div>

              <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 md:p-6 text-center text-white">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                  <i class="fas fa-phone text-white"></i>
                </div>
                <h3 class="font-semibold mb-2">Hubungi Kami</h3>
                <p class="text-sm text-white/80">+62 819-3601-1544</p>
                <a href="https://wa.me/6281936011544?text=Halo,%20saya%20ingin%20tanya%20tentang%20Gym%20Yankarta" 
                   target="_blank" 
                   class="text-xs text-yellow-300 hover:text-yellow-200 transition duration-300">
                  Chat WhatsApp
                </a>
              </div>

              <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 md:p-6 text-center text-white">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                  <i class="fas fa-car text-white"></i>
                </div>
                <h3 class="font-semibold mb-2">Akses Mudah</h3>
                <p class="text-sm text-white/80">Parkir Luas</p>
                <p class="text-xs text-white/70">Lokasi Strategis</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <footer id="footer" class="bg-gradient-to-br from-gray-900 to-black text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
          <div class="absolute top-10 left-10 w-40 h-40 border border-warna-400 rounded-full"></div>
          <div class="absolute bottom-20 right-20 w-60 h-60 border border-warna-400 rounded-full"></div>
          <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-warna-400 rounded-full"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
          <!-- Main Footer Content -->
          <div class="py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
              
              <!-- Company Info -->
              <div class="lg:col-span-2">
                <div class="flex items-center mb-6">
                  <img src="logo.png" alt="Gym Yankarta Logo" class="h-12 md:h-16">
                  <div class="ml-4">
                    <h1 class="text-xl md:text-2xl font-bold text-white">GYM YANKARTA</h1>
                    <p class="text-warna-400 text-sm">Your Fitness Journey Starts Here</p>
                  </div>
                </div>
                
                <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-6 max-w-md">
                  <strong class="text-warna-400">Gym Yankarta</strong> adalah tempat latihan yang nyaman dan terjangkau di kawasan Jimbaran. Dilengkapi dengan alat modern dan suasana yang mendukung, kami hadir untuk membantu Anda hidup lebih sehat dan bugar.
                </p>

                <!-- Social Media -->
                <div class="flex space-x-4">
                  <a href="https://wa.me/6281936011544" target="_blank" 
                     class="w-10 h-10 bg-warna-400/20 hover:bg-warna-400 rounded-full flex items-center justify-center transition duration-300 group">
                    <i class="fab fa-whatsapp text-warna-400 group-hover:text-white"></i>
                  </a>
                  <a href="https://www.instagram.com/yankartagym/" class="w-10 h-10 bg-warna-400/20 hover:bg-warna-400 rounded-full flex items-center justify-center transition duration-300 group" target="_blank">
                    <i class="fab fa-instagram text-warna-400 group-hover:text-white"></i>
                  </a>
                  <a href="https://www.tiktok.com/@yan.karta.gym" class="w-10 h-10 bg-warna-400/20 hover:bg-warna-400 rounded-full flex items-center justify-center transition duration-300 group" target="_blank" >
                    <i class="fab fa-tiktok text-warna-400 group-hover:text-white"></i>
                  </a>
                </div>
              </div>

              <!-- Quick Links -->
              <div>
                <h3 class="text-lg font-bold mb-6 text-white relative">
                  Navigasi Cepat
                  <div class="absolute bottom-0 left-0 w-8 h-0.5 bg-warna-400"></div>
                </h3>
                <ul class="space-y-3">
                  <li><a href="#home" class="text-gray-300 hover:text-warna-400 transition duration-300 text-sm flex items-center group">
                    <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    Home
                  </a></li>
                  <li><a href="#about" class="text-gray-300 hover:text-warna-400 transition duration-300 text-sm flex items-center group">
                    <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    About Us
                  </a></li>
                  <li><a href="#faq" class="text-gray-300 hover:text-warna-400 transition duration-300 text-sm flex items-center group">
                    <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    FAQ
                  </a></li>
                  <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-warna-400 transition duration-300 text-sm flex items-center group">
                    <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    Join Member
                  </a></li>
                </ul>
              </div>

              <!-- Contact Info -->
              <div>
                <h3 class="text-lg font-bold mb-6 text-white relative">
                  Hubungi Kami
                  <div class="absolute bottom-0 left-0 w-8 h-0.5 bg-warna-400"></div>
                </h3>
                <ul class="space-y-4">
                  <li class="flex items-start text-gray-300 text-sm">
                    <div class="w-5 h-5 bg-warna-400/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                      <i class="fas fa-map-marker-alt text-warna-400 text-xs"></i>
                    </div>
                    <span>Jl. Nuansa Utama Tukad Nangka No.I, Jimbaran, Kuta Selatan, Badung - Bali 80361</span>
                  </li>
                  <li class="flex items-center text-gray-300 text-sm">
                    <div class="w-5 h-5 bg-warna-400/20 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                      <i class="fas fa-phone text-warna-400 text-xs"></i>
                    </div>
                    <span>+62 819-3601-1544</span>
                  </li>
                  <li class="flex items-center text-gray-300 text-sm">
                    <div class="w-5 h-5 bg-warna-400/20 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                      <i class="fas fa-clock text-warna-400 text-xs"></i>
                    </div>
                    <span>08.00 - 21.00 WIB (Setiap Hari)</span>
                  </li>
                </ul>

                <!-- CTA Button -->
                <a href="https://wa.me/6281936011544?text=Halo,%20saya%20ingin%20tanya%20tentang%20member%20Gym%20Yankarta" 
                   target="_blank"
                   class="inline-flex items-center mt-6 bg-gradient-to-r from-warna-400 to-warna-500 hover:from-warna-500 hover:to-warna-600 text-white px-4 py-2 rounded-full text-sm font-medium transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                  <i class="fab fa-whatsapp mr-2"></i>
                  Chat WhatsApp
                </a>
              </div>
            </div>
          </div>

          <!-- Bottom Footer -->
          <div class="border-t border-gray-800 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
              <div class="text-center md:text-left">
                <p class="text-gray-400 text-sm">
                  &copy; 2024 <span class="text-warna-400 font-semibold">Gym Yankarta</span>. All rights reserved.
                </p>
                <p class="text-gray-500 text-xs mt-1">Designed with ❤️ for your fitness journey</p>
              </div>
              
              <div class="flex items-center space-x-6 text-xs text-gray-400">
                <a href="#" class="hover:text-warna-400 transition duration-300">Privacy Policy</a>
                <a href="#" class="hover:text-warna-400 transition duration-300">Terms of Service</a>
                <a href="#contact" class="hover:text-warna-400 transition duration-300">Contact</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Floating Back to Top Button -->
        <div class="fixed bottom-6 right-6 z-50">
          <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                  class="w-12 h-12 bg-gradient-to-r from-warna-400 to-warna-500 hover:from-warna-500 hover:to-warna-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
            <i class="fas fa-chevron-up"></i>
          </button>
        </div>
      </footer>

<script>
    // JavaScript untuk mendeteksi scroll dan mengubah background header
    window.addEventListener("scroll", function () {
        const header = document.getElementById("header");
        const mobileDropdown = document.getElementById("mobile-dropdown");

        const isDropdownVisible = !mobileDropdown.classList.contains("hidden"); // Cek apakah dropdown terbuka
        if (window.scrollY > 50 || isDropdownVisible) {
            // Jika scroll lebih dari 50px atau dropdown terbuka
            header.classList.add("bg-warna-300", "shadow-lg");
            header.classList.remove("bg-transparent");
        } else {
            header.classList.add("bg-transparent");
            header.classList.remove("bg-warna-300", "shadow-lg");
        }
    });

    // START FAQ ACCORDION LOGIC - VERSI DIPERBAIKI
    const faqItems = document.querySelectorAll('[id^="faq"]'); // Memilih semua elemen FAQ

    faqItems.forEach(item => {
        item.addEventListener('click', () => {
            const answerId = `answer${item.id.replace('faq', '')}`;
            const currentAnswer = document.getElementById(answerId);
            const chevronIcon = item.querySelector('.fa-chevron-down');

            // Cek apakah jawaban yang sedang diklik sudah terbuka
            const isOpen = !currentAnswer.classList.contains('hidden');

            // Tutup semua jawaban FAQ yang sedang terbuka (kecuali yang baru saja diklik jika mau dibuka)
            faqItems.forEach(otherItem => {
                const otherAnswerId = `answer${otherItem.id.replace('faq', '')}`;
                const otherAnswer = document.getElementById(otherAnswerId);
                const otherChevronIcon = otherItem.querySelector('.fa-chevron-down');

                // Jika jawaban item lain terbuka, tutup mereka
                if (otherAnswer && !otherAnswer.classList.contains('hidden')) { // Pastikan otherAnswer ada dan terbuka
                    otherAnswer.classList.add('hidden'); // Sembunyikan jawaban
                    otherChevronIcon.classList.remove('rotate-180'); // Putar ikon kembali
                }
            });

            // Hanya jika item yang diklik sebelumnya tertutup, buka sekarang
            // Jika sebelumnya sudah terbuka (dan sudah ditutup di loop di atas), biarkan tertutup
            if (!isOpen) {
                currentAnswer.classList.remove('hidden'); // Buka jawaban yang diklik
                chevronIcon.classList.add('rotate-180'); // Putar ikon
            }
            // Jika `isOpen` adalah true, artinya diklik untuk menutupnya,
            // maka class 'hidden' sudah ditambahkan dan rotate-180 sudah dihapus di loop atas.
            // Tidak perlu tindakan tambahan di sini.
        });
    });
    // END FAQ ACCORDION LOGIC

    // JavaScript to toggle the mobile dropdown menu
    const mobileMenuButton = document.getElementById('mobile-menu');
    const mobileDropdown = document.getElementById('mobile-dropdown');
    const header = document.getElementById('header');

    mobileMenuButton.addEventListener('click', () => {
        const isHidden = mobileDropdown.classList.contains('hidden');

        if (isHidden) {
            mobileDropdown.classList.remove('hidden', '-translate-y-full');
            header.classList.add('bg-warna-300');
        } else {
            mobileDropdown.classList.add('-translate-y-full');
            setTimeout(() => {
                mobileDropdown.classList.add('hidden');
            }, 300);
        }
    });

    // JavaScript to close mobile dropdown and scroll to top when clicking a link
    const mobileMenuLinks = document.querySelectorAll('#mobile-dropdown a');

    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileDropdown.classList.add('-translate-y-full');
            setTimeout(() => {
                mobileDropdown.classList.add('hidden');
            }, 300);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

</body>
</html>
