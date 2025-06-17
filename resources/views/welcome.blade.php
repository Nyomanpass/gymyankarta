<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
          html {
            scroll-behavior: smooth;
          }
        </style>


    </head>
  
<body class="bg-gray-100">

 
    <header 
  id="header" 
  class="fixed top-0 left-0 w-full z-50 bg-transparent text-white transition-all duration-300">
  <!-- Container -->
  <div class="container mx-auto flex items-center justify-between py-2 px-4 md:px-14 z-20">
    <!-- Logo -->
    <div class="flex items-center">
      <img src="logo.png" alt="Company Logo" class="h-14 md:h-16">
      <h1 class="text-white font-bold ml-3">GYM YANKARTA</h1>
    </div>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex items-center space-x-6">
      <a href="#home" class="hover:text-warna-400">Home</a>
      <a href="#about" class="hover:text-warna-400">About</a>
      <a href="#faq" class="hover:text-warna-400">FAQ</a>
      <a href="#contact" class="hover:text-warna-400">Contact</a>
      <div class="flex space-x-3">
          <a href="{{ route('register') }}" class="px-5 py-1 rounded-3xl bg-warna-400 text-white">Join Member</a>
          <a href="{{ route('login') }}" class="px-5 py-1 rounded-3xl bg-blue-700 text-white">Login</a>
      </div>
    </nav>

    <!-- Mobile Menu Button -->
    <button 
      id="mobile-menu" 
      aria-label="Toggle Mobile Menu"
      class="block md:hidden focus:outline-none">
      <span class="block w-6 md:w-8 h-1 bg-white mb-1 transition duration-300"></span>
      <span class="block w-6 md:w-8 h-1 bg-white mb-1 transition duration-300"></span>
      <span class="block w-6 md:w-8 h-1 bg-white transition duration-300"></span>
    </button>
  </div>

  <!-- Mobile Dropdown -->
  <div 
  id="mobile-dropdown" 
  class="hidden w-full bg-warna-300 transition-all duration-500 transform -translate-y-full shadow-lg rounded-lg">
<nav class="flex flex-col space-y-2 py-4 px-6">
  <a href="#home" class="block py-2 px-4 rounded-lg text-white hover:bg-blue-700 hover:text-warna-400">Home</a>
  <a href="#about" class="block py-2 px-4 rounded-lg text-white hover:bg-blue-700 hover:text-warna-400">About</a>
  <a href="#faq" class="block py-2 px-4 rounded-lg text-white hover:bg-blue-700 hover:text-warna-400">FAQ</a>
  <a href="#contact" class="block py-2 px-4 rounded-lg text-white hover:bg-blue-700 hover:text-warna-400">Contact</a>
  <a href="{{ route('register') }}" class="px-5 py-2 rounded-3xl bg-warna-400 text-white">Join Member</a>
  <a href="{{ route('login') }}" class="px-5 py-2 rounded-3xl bg-blue-700 text-white">Login</a>
</nav>
</div>

</header>


    <!-- Hero Section -->
    <section id="home" class="relative bg-cover bg-center h-screen"
    style="background-image: url('gymjimbaran.jpg');">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black opacity-60"></div>
    
    <!-- Konten Hero -->
   <div class="container mx-auto h-screen flex items-center justify-center px-6 lg:px-14 relative z-10">
        <div class="max-w-3xl text-center text-white">
            <h1 class="text-2xl md:text-5xl font-bold leading-tight">
                Bukan Tentang Siapa yang Terkuat, Tapi Siapa yang Tidak Menyerah
            </h1>
            <p class="mt-4 text-md px-5 md:text-lg">
                Akses Alat Gym Terlengkap, Personal Trainer Profesional, dan Suasana Latihan yang Membakar Semangat!
            </p>
            <a href="https://wa.me/6281936011544?text=Halo,%20saya%20ingin%20menanyakan%20informasi%20seputar%20gym%20ini." target="_blank"
                class="mt-6 inline-block bg-warna-400 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                HUBUNGI KAMI
            </a>
        </div>
    </div>

</section>


    <!-- Why Choose Us -->
 <section id="about" class="pt-24 bg-gray-100">
  <div class="container mx-auto px-6 lg:px-16 text-center">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      
      <!-- Card -->
      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
        <div class="text-orange-500 text-5xl mb-4">
          <i class="fas fa-dumbbell"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Peralatan Modern</h3>
        <p class="text-gray-600 text-sm">Kami menyediakan alat gym berkualitas dan lengkap, langsung dari brand ternama.</p>
      </div>

      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
        <div class="text-orange-500 text-5xl mb-4">
          <i class="fas fa-tags"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Harga Terjangkau</h3>
        <p class="text-gray-600 text-sm">Biaya keanggotaan kami terjangkau untuk semua kalangan tanpa mengurangi kualitas.</p>
      </div>

      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
        <div class="text-orange-500 text-5xl mb-4">
          <i class="fas fa-spa"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tempat Bersih & Nyaman</h3>
        <p class="text-gray-600 text-sm">Lingkungan yang bersih, sejuk, dan menyenangkan bikin kamu betah latihan rutin.</p>
      </div>

    </div>
  </div>
</section>


    <!-- About Us -->
   <section id="profil" class="py-32 px-6 md:px-14 mx-auto container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center justify-between">
            <div class="">
                <h2 class="text-3xl font-bold mb-4">Tentang Kami</h2>
                <p class="mb-4 font-semibold text-warna-400">Tempat Gym Modern di Jimbaran, Bali</p>
                <p class="text-gray-600 text-sm md:text-lg">
                    Gym Yankarta adalah pusat kebugaran yang berlokasi di <strong>Jalan Nuansa Utama Tukad Nangka No.I, Jimbaran, Kec. Kuta Selatan, Kabupaten Badung, Bali</strong>. Kami hadir untuk mendukung gaya hidup sehat masyarakat Bali dengan menyediakan fasilitas gym lengkap, peralatan modern, dan suasana latihan yang nyaman.

                    Dengan suasana yang bersih, alat berkualitas, dan lingkungan yang mendukung, Gym Yankarta cocok untuk semua kalangan — baik pemula maupun yang sudah rutin berlatih. Komitmen kami adalah memberikan pengalaman gym yang menyenangkan, aman, dan hasil yang nyata.
                </p>
            </div>
            <div class="mt-8 md:mt-0 w-full xl:ml-6">
                <img src="gymjimbaran3.jpg" alt="Tentang Kami" class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>


<section id="langkah-member" class="bg-warna-300 py-20">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-2xl md:text-4xl font-bold text-white mb-22">Langkah Menjadi Member Gym Yankarta</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

      <!-- Langkah -->
      <div class="flex flex-col items-center text-center px-2">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-warna-400 text-white flex items-center justify-center text-lg font-bold mb-4 shadow-lg">1</div>
        <h3 class="text-white font-semibold text-base md:text-lg">Pendaftaran</h3>
        <p class="text-gray-400 mt-2 text-sm">Klik tombol <strong>"Join Us"</strong> dan lengkapi data diri pada formulir pendaftaran member.</p>
      </div>

      <div class="flex flex-col items-center text-center px-2">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-warna-400 text-white flex items-center justify-center text-lg font-bold mb-4 shadow-lg">2</div>
        <h3 class="text-white font-semibold text-base md:text-lg">Verifikasi Email</h3>
        <p class="text-gray-400 mt-2 text-sm">Kami akan mengirim email verifikasi. Buka email kamu dan klik tautan untuk aktivasi.</p>
      </div>

      <div class="flex flex-col items-center text-center px-2">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-warna-400 text-white flex items-center justify-center text-lg font-bold mb-4 shadow-lg">3</div>
        <h3 class="text-white font-semibold text-base md:text-lg">Lakukan Pembayaran</h3>
        <p class="text-gray-400 mt-2 text-sm">Transfer biaya pendaftaran sesuai instruksi. Cantumkan nama pada bukti transfer.</p>
      </div>

      <div class="flex flex-col items-center text-center px-2">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-warna-400 text-white flex items-center justify-center text-lg font-bold mb-4 shadow-lg">4</div>
        <h3 class="text-white font-semibold text-base md:text-lg">Verifikasi oleh Admin</h3>
        <p class="text-gray-400 mt-2 text-sm">Admin kami akan memverifikasi data dan pembayaran kamu dalam waktu singkat.</p>
      </div>

      <div class="flex flex-col items-center text-center px-2">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-warna-400 text-white flex items-center justify-center text-lg font-bold mb-4 shadow-lg">5</div>
        <h3 class="text-white font-semibold text-base md:text-lg">Akses Dashboard</h3>
        <p class="text-gray-400 mt-2 text-sm">Login ke dashboard untuk melihat jadwal, absensi, dan info member lainnya.</p>
      </div>
    </div>

    <a href="{{ route('register') }}" class="mt-12 inline-block bg-warna-400 hover:bg-warna-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md">
      Join Sekarang
    </a>
  </div>
</section>

<section id="harga-member" class="text-gray-900 py-24">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-12">Pilihan Membership yang Terjangkau</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
      
      <!-- Harian -->
      <div class="bg-white text-gray-800 rounded-2xl shadow-lg p-8 hover:shadow-2xl transition">
        <h3 class="text-2xl font-bold mb-2">Harian</h3>
        <p class="text-orange-500 text-3xl font-extrabold mb-4">Rp15.000</p>
        <ul class="text-sm text-gray-600 mb-6 space-y-2">
          <li>• Akses 1 Hari Penuh</li>
          <li>• Bebas Gunakan Semua Alat</li>
          <li>• Cocok untuk yang ingin coba dulu</li>
        </ul>
        <a href="#join" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition">Coba Sekarang</a>
      </div>

      <!-- Bulanan -->
      <div class="bg-white text-gray-800 rounded-2xl shadow-lg p-8 hover:shadow-2xl transition border-2 border-orange-500">
        <h3 class="text-2xl font-bold mb-2">Member Bulanan</h3>
        <p class="text-orange-500 text-3xl font-extrabold mb-4">Rp100.000</p>
        <ul class="text-sm text-gray-600 mb-6 space-y-2">
          <li>• Akses Bebas 30 Hari</li>
          <li>• Jadwal Fleksibel</li>
          <li>• Lebih Hemat & Praktis</li>
        </ul>
        <a href="{{ route('register') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition">Join Member</a>
      </div>

    </div>
  </div>
</section>


    <section id="faq" class="py-24 bg-white text-gray-800">
  <div class="container mx-auto px-6 max-w-3xl">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Pertanyaan yang Sering Ditanyakan</h2>

    <!-- FAQ 1 -->
    <div id="faq1" class="cursor-pointer bg-gray-100 rounded-lg p-4 mb-4">
      <h3 class="font-semibold text-lg">Apa saja fasilitas yang tersedia di Gym Yankarta?</h3>
      <p id="answer1" class="mt-2 text-sm text-gray-700 hidden">Kami menyediakan alat gym lengkap dan berkualitas untuk latihan beban dan kardio, serta loker penyimpanan.</p>
    </div>

    <!-- FAQ 2 -->
    <div id="faq2" class="cursor-pointer bg-gray-100 rounded-lg p-4 mb-4">
      <h3 class="font-semibold text-lg">Apakah bisa bayar harian tanpa jadi member?</h3>
      <p id="answer2" class="mt-2 text-sm text-gray-700 hidden">Bisa. Kamu cukup membayar Rp15.000 dan bisa menggunakan fasilitas gym selama satu hari penuh.</p>
    </div>

    <!-- FAQ 3 (Revisi) -->
    <div id="faq3" class="cursor-pointer bg-gray-100 rounded-lg p-4 mb-4">
      <h3 class="font-semibold text-lg">Apakah pemula boleh latihan di Gym Yankarta?</h3>
      <p id="answer3" class="mt-2 text-sm text-gray-700 hidden">
        Tentu saja! Gym kami terbuka untuk semua level, termasuk pemula. Staff kami siap membantu jika kamu bingung memulai latihan.
      </p>
    </div>


    <!-- FAQ 4 -->
    <div id="faq4" class="cursor-pointer bg-gray-100 rounded-lg p-4 mb-4">
      <h3 class="font-semibold text-lg">Jam operasional Gym Yankarta?</h3>
      <p id="answer4" class="mt-2 text-sm text-gray-700 hidden">Kami buka setiap hari pukul 08.00 – 21.00 WIB.</p>
    </div>

    <!-- FAQ 5 -->
    <div id="faq5" class="cursor-pointer bg-gray-100 rounded-lg p-4 mb-4">
      <h3 class="font-semibold text-lg">Bagaimana cara mendaftar menjadi member?</h3>
      <p id="answer5" class="mt-2 text-sm text-gray-700 hidden">Klik tombol "Join Us", isi formulir, verifikasi email, lakukan pembayaran, dan tunggu verifikasi dari admin.</p>
    </div>
  </div>
</section>


    
    
    
      
      <section id="contact" class="py-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
          <h2 class="text-2xl font-bold mb-6">Ayo Latihan di Lokasi Kami!</h2>
          <p class="text-black-200 mb-8">Gym Yankarta hadir di Jimbaran dengan fasilitas lengkap dan suasana nyaman. Kunjungi kami sekarang!</p>

          <div class="relative rounded-lg overflow-hidden shadow-lg" style="height: 400px;">
            <iframe 
              class="w-full h-full border-0"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5680.855906333656!2d115.183003541377!3d-8.795953837296734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd245d62cc0d2c3%3A0xa03e0537f2942537!2sYAN%20KARTA%20GYM!5e1!3m2!1sid!2sid!4v1750061481689!5m2!1sid!2sid"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>


          </div>
        </div>
      </section>

  <footer id="contact" class="bg-warna-300 text-white py-24">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      
      <!-- Tentang Kami -->
      <div>
        <div class="flex items-center">
          <img src="logo.png" alt="Company Logo" class="h-14 md:h-16">
          <h1 class="text-white font-bold ml-3">GYM YANKARTA</h1>
        </div>
        <p class="text-sm leading-6 mt-4">
          <strong>Gym Yankarta</strong> adalah tempat latihan yang nyaman dan terjangkau di kawasan Jimbaran. Dilengkapi dengan alat modern dan suasana yang mendukung, kami hadir untuk bantu kamu hidup lebih sehat dan bugar.
        </p>
      </div>

      <!-- Navigasi Cepat -->
      <div>
        <h3 class="text-md font-bold mb-4">Navigasi</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#home" class="hover:underline">Home</a></li>
          <li><a href="#about" class="hover:underline">About</a></li>
          <li><a href="#faq" class="hover:underline">FAQ</a></li>
          <li><a href="{{ route('register') }}" class="hover:underline">join member</a></li>
        </ul>
      </div>

      <!-- Fasilitas -->
      <div>
        <h3 class="text-md font-bold mb-4">Fasilitas</h3>
        <ul class="space-y-2 text-sm">
          <li><i class="fas fa-dumbbell mr-2"></i> Alat Gym Lengkap</li>
          <li><i class="fas fa-snowflake mr-2"></i> Ruangan Sejuk</li>
          <li><i class="fas fa-clock mr-2"></i> Jam Operasional 08.00 - 21.00</li>
        </ul>
      </div>

      <!-- Kontak Kami -->
      <div>
        <h3 class="text-md font-bold mb-4">Kontak Kami</h3>
        <ul class="space-y-2 text-sm">
          <li><i class="fas fa-map-marker-alt mr-2"></i>Jl. Nuansa Utama Tukad Nangka No.I, Jimbaran, Kuta Selatan, Badung - Bali 80361</li>
          <li><i class="fas fa-phone-alt mr-2"></i> +62 819-3601-1544</li>
          <li>
            <a href="https://wa.me/6281936011544?text=Halo,%20saya%20ingin%20tanya%20tentang%20member%20Gym%20Yankarta" class="hover:underline" target="_blank">
              <i class="fab fa-whatsapp mr-2"></i> Chat via WhatsApp
            </a>
          </li>
        </ul>
      </div>
    </div>

  

    <!-- Hak Cipta -->
    <div class="mt-8 text-center border-t border-white pt-6">
      <p class="text-sm">&copy; 2024 Gym Yankarta. All rights reserved.</p>
    </div>
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


        const faqItems = document.querySelectorAll('[id^="faq"]');

        faqItems.forEach(item => {
          item.addEventListener('click', () => {
            const answerId = `answer${item.id.replace('faq', '')}`;
            const answer = document.getElementById(answerId);

            // Toggle the visibility of the answer
            answer.classList.toggle('hidden');
          });
        });

        // JavaScript to toggle the mobile dropdown menu
        const mobileMenuButton = document.getElementById('mobile-menu');
        const mobileDropdown = document.getElementById('mobile-dropdown');
        const header = document.getElementById('header');

        mobileMenuButton.addEventListener('click', () => {
          // Cek apakah dropdown sedang tersembunyi
          const isHidden = mobileDropdown.classList.contains('hidden');

          if (isHidden) {
            // Jika dropdown disembunyikan, munculkan dropdown dan tambahkan background pada header
            mobileDropdown.classList.remove('hidden', '-translate-y-full');
            header.classList.add('bg-warna-300');
          } else {
            // Jika dropdown terlihat, sembunyikan dropdown dan hapus background pada header
            mobileDropdown.classList.add('-translate-y-full');
            setTimeout(() => {
              mobileDropdown.classList.add('hidden');
           
            }, 300); // Tunggu animasi selesai
          }
        });

        // JavaScript to close mobile dropdown and scroll to top when clicking a link
        const mobileMenuLinks = document.querySelectorAll('#mobile-dropdown a');

        mobileMenuLinks.forEach(link => {
          link.addEventListener('click', () => {
            // Sembunyikan dropdown menu
            mobileDropdown.classList.add('-translate-y-full');
            setTimeout(() => {
              mobileDropdown.classList.add('hidden');
            }, 300); // Tunggu animasi selesai

            // Scroll halaman ke atas
            window.scrollTo({
              top: 0,
              behavior: 'smooth' // Animasi smooth
            });
          });
        });



    </script>

</body>
</html>
