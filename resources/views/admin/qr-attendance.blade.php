<!-- filepath: c:\laragon\www\gymyankarta\resources\views\admin\qr-attendance.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi - GYMYANKARTA</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
</head>
<body class="font-poppins bg-gray-100 min-h-screen overflow-hidden">
    <div 
        x-data="{
            currentTime: '',
            showInstructions: false,
            
            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
            },
            
            updateTime() {
                this.currentTime = new Date().toLocaleTimeString('id-ID');
            }
        }"
        x-init="init()"
        class="h-screen flex items-center justify-center "
    >
        <!-- Desktop Layout -->
        <div class="hidden md:flex w-full max-w-5xl max-h-[80vh] mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden my-4">
            <!-- Left Sidebar -->
            <div class="w-1/3 bg-warna-300 p-8 flex flex-col">
                <!-- Logo & Title -->
                <div class="mb-4">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-orange-500 rounded-full flex items-center justify-center mr-4">
                            <img src="{{ asset('logo.png') }}" alt="" class="w-12 h-12 object-cover">
                        </div>
                        <div>
                            <h1 class="text-white text-xl font-bold">YANKARTA</h1>
                            <h2 class="text-orange-400 text-lg font-semibold">GYM</h2>
                        </div>
                    </div>
                    <div class="w-full h-px bg-slate-500 mb-6"></div>
                </div>
                
                <!-- Menu Item -->
                <div class="flex-1">
                    <div class="flex items-center text-white bg-slate-600/50 rounded-lg p-4">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-4"></div>
                        <span class="font-medium">Cara Melakukan Absensi</span>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="mt-6 space-y-4 text-slate-300 text-sm">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">1</div>
                            <span>Buka aplikasi member di smartphone Anda</span>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">2</div>
                            <span>Tekan tombol "Scan QR" di dashboard aplikasi</span>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">3</div>
                            <span>Arahkan kamera ke QR Code di sebelah kanan</span>
                        </div>
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">4</div>
                            <span>Tunggu konfirmasi absensi berhasil</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Content -->
            <div class="flex-1 p-8 flex flex-col items-center justify-center bg-gray-50">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Scan QR Code</h2>
                    <p class="text-gray-600">Scan QR Code ini untuk melakukan absensi</p>
                </div>
                
                <!-- QR Code Container -->
                <div class="relative">
                    <!-- QR Code Box -->
                    <div class="md:size-56 lg:size-72 bg-white rounded-2xl shadow-lg border-2 border-gray-200 flex items-center justify-center relative overflow-hidden">
                        <!-- Loading State -->
                        <div id="qr-loading" class="absolute inset-0 flex items-center justify-center bg-white z-20 transition-all duration-500">
                            <div class="text-center">
                                <div class="w-16 h-16 border-4 border-gray-200 border-t-orange-500 rounded-full animate-spin mx-auto mb-4"></div>
                                <p class="text-gray-600 font-medium">Memuat QR Code...</p>
                            </div>
                        </div>
                        
                        <!-- QR Code Display -->
                        <div id="qr-display" class="absolute inset-0 flex items-center justify-center p-3 opacity-0 z-10 transition-all duration-500">
                            <object id="qr-object" 
                                    data="{{ route('qr.generate') }}?t={{ time() }}"
                                    type="image/svg+xml"
                                    class="w-full h-full">
                                <embed src="{{ route('qr.generate') }}?t={{ time() }}"
                                       type="image/svg+xml" 
                                       class="w-full h-full" />
                            </object>
                        </div>
                        
                        <!-- Error State -->
                        <div id="qr-error" class="absolute inset-0 flex items-center justify-center bg-white opacity-0 z-10 transition-all duration-500">
                            <div class="text-center text-red-500 p-6">
                                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                                </div>
                                <p class="font-medium mb-2">QR Code Error</p>
                                <p class="text-sm text-gray-500 mb-4">Gagal memuat QR Code</p>
                                <button onclick="refreshQrCode()" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="mt-4 mb-6 text-center text-xs text-gray-500">
                    <p>Terakhir diperbarui: <span id="last-updated" x-text="currentTime" class="font-medium">{{ now()->format('H:i:s') }}</span></p>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-[90%] lg:w-[70%] mb-6">
                    <p class="text-center text-sm text-warna-300 mb-2">QR Code akan diperbarui otomatis setiap <span class="font-semibold">30 detik</span></p>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="refresh-progress" class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Manual Refresh Button -->
                <button onclick="refreshQrCode()" 
                        class="px-8 py-3 bg-white border-2 border-warna-400 text-warna-400 hover:bg-warna-400 hover:text-white rounded-xl font-medium transition-all duration-300 transform">
                    <i class="fas fa-redo mr-2"></i>
                    Refresh Manual
                </button>
                
                
            </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="md:hidden flex flex-col w-full h-screen bg-gray-50">
            <!-- Mobile Header -->
            <div class="bg-warna-300 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                            <img src="{{ asset('logo.png') }}" alt="" class="w-8 h-8 object-cover">
                        </div>
                        <div>
                            <h1 class="text-white text-lg font-bold">YANKARTA</h1>
                            <h2 class="text-orange-400 text-sm font-semibold">GYM</h2>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-white p-2">
                        <i class="fas fa-angle-left text-xl"></i>
                    </a>
                </div>
            </div>
            
            <!-- Mobile Content -->
            <div class="flex-1 flex flex-col items-center justify-center px-6 py-8">
                <!-- Title -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Scan QR Code</h2>
                    <p class="text-gray-600 text-sm">Scan QR Code ini untuk melakukan absensi</p>
                </div>
                
                <!-- QR Code Container Mobile -->
                <div class="w-72 h-72 bg-white rounded-2xl shadow border-2 border-gray-200 flex items-center justify-center relative overflow-hidden mb-6">
                    <!-- Loading State Mobile -->
                    <div id="qr-loading-mobile" class="absolute inset-0 flex items-center justify-center bg-white z-20 transition-all duration-500">
                        <div class="text-center">
                            <div class="w-12 h-12 border-4 border-gray-200 border-t-orange-500 rounded-full animate-spin mx-auto mb-3"></div>
                            <p class="text-gray-600 font-medium text-sm">Memuat QR Code...</p>
                        </div>
                    </div>
                    
                    <!-- QR Code Display Mobile -->
                    <div id="qr-display-mobile" class="absolute inset-0 flex items-center justify-center p-3 opacity-0 z-10 transition-all duration-500">
                        <object id="qr-object-mobile" 
                                data="{{ route('qr.generate') }}?t={{ time() }}"
                                type="image/svg+xml"
                                class="w-full h-full">
                            <embed src="{{ route('qr.generate') }}?t={{ time() }}"
                                   type="image/svg+xml" 
                                   class="w-full h-full" />
                        </object>
                    </div>
                    
                    <!-- Error State Mobile -->
                    <div id="qr-error-mobile" class="absolute inset-0 flex items-center justify-center bg-white opacity-0 z-10 transition-all duration-500">
                        <div class="text-center text-red-500 p-4">
                            <div class="w-12 h-12 mx-auto mb-3 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-lg"></i>
                            </div>
                            <p class="font-medium mb-2 text-sm">QR Code Error</p>
                            <p class="text-xs text-gray-500 mb-3">Gagal memuat QR Code</p>
                            <button onclick="refreshQrCode()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-xs font-medium">
                                <i class="fas fa-redo mr-1"></i>Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar Mobile -->
                <div class="w-72 mb-6">
                    <div class="flex items-center justify-between text-xs text-gray-600 mb-2">
                        <span>Auto refresh setiap</span>
                        <span class="font-semibold">30 detik</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div id="refresh-progress-mobile" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Action Button Mobile -->
                <button onclick="refreshQrCode()" 
                        class="w-full max-w-xs px-6 py-3 text-warna-400 border-2 border-warna-400 active:text-white active:bg-warna-400 rounded-xl font-medium transition-all duration-300">
                    <i class="fas fa-redo mr-2"></i>
                    Refresh Manual
                </button>
                
                <!-- Footer Info Mobile -->
                <div class="mt-6 text-center text-xs text-gray-500">
                    <p>Terakhir diperbarui: <span x-text="currentTime" class="font-medium"></span></p>
                </div>
            </div>
            
            <!-- Mobile Instructions (Collapsible) -->
            <div class="bg-white border-t border-gray-200 px-6 py-4">
                <button @click="showInstructions = !showInstructions" 
                        class="w-full flex items-center justify-between text-gray-700 font-medium">
                    <span>Cara Melakukan Absensi</span>
                    <i class="fas fa-chevron-down transition-transform duration-200" 
                       :class="showInstructions ? 'rotate-180' : ''"></i>
                </button>
                
                <div x-show="showInstructions" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-4 space-y-3">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">1</div>
                        <span class="text-sm text-gray-600">Buka aplikasi member di smartphone</span>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">2</div>
                        <span class="text-sm text-gray-600">Tekan tombol "Scan QR" di dashboard</span>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">3</div>
                        <span class="text-sm text-gray-600">Arahkan kamera ke QR Code di atas</span>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5 flex-shrink-0">4</div>
                        <span class="text-sm text-gray-600">Tunggu konfirmasi absensi berhasil</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // QR State Management (menggunakan script native yang sudah ada)
        let refreshInterval;
        let progressInterval;
        let refreshProgress = 0;
        
        let qrStates = {
            loading: document.getElementById('qr-loading'),
            display: document.getElementById('qr-display'),
            error: document.getElementById('qr-error')
        };
        
        let qrStatesMobile = {
            loading: document.getElementById('qr-loading-mobile'),
            display: document.getElementById('qr-display-mobile'),
            error: document.getElementById('qr-error-mobile')
        };
        
        function showQrState(state) {
            // Desktop states
            Object.values(qrStates).forEach(el => {
                if (el) {
                    el.style.opacity = '0';
                    el.style.zIndex = '10';
                }
            });
            
            // Mobile states
            Object.values(qrStatesMobile).forEach(el => {
                if (el) {
                    el.style.opacity = '0';
                    el.style.zIndex = '10';
                }
            });
            
            // Show selected state for both desktop and mobile
            if (qrStates[state]) {
                qrStates[state].style.opacity = '1';
                qrStates[state].style.zIndex = '20';
            }
            if (qrStatesMobile[state]) {
                qrStatesMobile[state].style.opacity = '1';
                qrStatesMobile[state].style.zIndex = '20';
            }
        }
        
        function showQrCode() {
            showQrState('display');
        }
        
        function showQrError() {
            showQrState('error');
        }
        
        function showLoading() {
            showQrState('loading');
        }
        
        function refreshQrCode() {
            const timestamp = new Date().getTime();
            
            // Show loading
            showLoading();
            
            // Update QR source for both desktop and mobile
            const qrObject = document.getElementById('qr-object');
            const qrObjectMobile = document.getElementById('qr-object-mobile');
            
            if (qrObject) {
                qrObject.data = "{{ route('qr.generate') }}?t=" + timestamp;
            }
            if (qrObjectMobile) {
                qrObjectMobile.data = "{{ route('qr.generate') }}?t=" + timestamp;
            }
            
            // Update timestamp
            const lastUpdated = document.getElementById('last-updated');
            if (lastUpdated) {
                lastUpdated.textContent = new Date().toLocaleTimeString('id-ID');
            }
            
            // Reset progress
            refreshProgress = 0;
            updateProgressBar();
            
            // Show QR after delay
            setTimeout(() => {
                showQrCode();
            }, 1500);
        }
        
        function updateProgressBar() {
            const progressBar = document.getElementById('refresh-progress');
            const progressBarMobile = document.getElementById('refresh-progress-mobile');
            
            if (progressBar) {
                progressBar.style.width = refreshProgress + '%';
            }
            if (progressBarMobile) {
                progressBarMobile.style.width = refreshProgress + '%';
            }
        }
        
        function startProgressBar() {
            refreshProgress = 0;
            
            if (progressInterval) {
                clearInterval(progressInterval);
            }
            
            progressInterval = setInterval(() => {
                refreshProgress += (100 / 30); // 30 seconds
                if (refreshProgress >= 100) {
                    refreshProgress = 0;
                }
                updateProgressBar();
            }, 1000);
        }
        
        function startAutoRefresh() {
            if (refreshInterval) clearInterval(refreshInterval);
            if (progressInterval) clearInterval(progressInterval);
            
            refreshInterval = setInterval(refreshQrCode, 30000); // 30 seconds
            startProgressBar();
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            showLoading();
            
            // Show QR after loading simulation
            setTimeout(() => {
                showQrCode();
                startAutoRefresh();
            }, 2000);
            
            // Handle QR object events
            const qrObjects = [
                document.getElementById('qr-object'),
                document.getElementById('qr-object-mobile')
            ];
            
            qrObjects.forEach(qrObject => {
                if (qrObject) {
                    qrObject.addEventListener('load', () => showQrCode());
                    qrObject.addEventListener('error', () => showQrError());
                }
            });
        });
        
        // Handle page visibility
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                refreshQrCode();
                startAutoRefresh();
            } else {
                if (refreshInterval) clearInterval(refreshInterval);
                if (progressInterval) clearInterval(progressInterval);
            }
        });
        
        // Cleanup
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) clearInterval(refreshInterval);
            if (progressInterval) clearInterval(progressInterval);
        });
    </script>
</body>
</html>