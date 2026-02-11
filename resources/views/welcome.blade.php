<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Peminjaman Alat - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .animated-gradient {
            background: linear-gradient(-45deg,#667eea, #764ba2, #8e2de2, #4facfe);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class='bx bx-box text-white text-2xl'></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Sistem Informasi Peminjaman Alat</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="#features"
                        class="text-gray-600 hover:text-purple-600 font-medium transition-colors">Features</a>
                    <a href="#how-it-works"
                        class="text-gray-600 hover:text-purple-600 font-medium transition-colors">How It Works</a>
                    <a href="#about"
                        class="text-gray-600 hover:text-purple-600 font-medium transition-colors">About</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $dashboardRoute = match (auth()->user()->role) {
                                'admin' => 'admin.dashboard',
                                'petugas' => 'petugas.dashboard',
                                default => 'peminjam.dashboard',
                            };
                        @endphp

                        <a href="{{ route($dashboardRoute) }}"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="animated-gradient py-20 lg:py-32 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Left Content -->
                <div class="text-white slide-in-left">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6 border border-white/30">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-sm font-medium">Sistem Terpercaya & Aman</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        <span class="text-red-300">Sistem Informasi Peminjaman Alat</span>
                    </h1>

                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        Sistem peminjaman alat yang modern, dan mudah digunakan. Proses efisien dan
                        laporan lengkap.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-600 rounded-xl font-bold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                                <i class='bx bx-rocket text-xl'></i>
                                <span>Mulai Sekarang</span>
                            </a>
                            <a href="#features"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold border-2 border-white/30 hover:bg-white/30 transition-all duration-200">
                                <i class='bx bx-info-circle text-xl'></i>
                                <span>Pelajari Lebih Lanjut</span>
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-600 rounded-xl font-bold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                                <i class='bx bx-grid-alt text-xl'></i>
                                <span>Ke Dashboard</span>
                            </a>
                        @endguest
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-12 border-t border-white/20">
                        <div>
                            <div class="text-3xl font-bold mb-1">100+</div>
                            <div class="text-white/80 text-sm">Alat Tersedia</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1">400+</div>
                            <div class="text-white/80 text-sm">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1">99%</div>
                            <div class="text-white/80 text-sm">Kepuasan</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Illustration -->
                <div class="hidden lg:block slide-in-right">
                    <div class="floating">
                        <div class="relative">
                            <!-- Main Card -->
                            <div class="bg-white/95 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                                <div class="flex items-center gap-4 mb-6">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-package text-white text-2xl'></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Status Peminjaman</div>
                                        <div class="font-bold text-gray-800">Aktif</div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Laptop ASUS ROG</span>
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Dipinjam</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Mouse Logitech</span>
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">Tersedia</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Printer Canon</span>
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">Tersedia</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Notification -->
                            <div
                                class="absolute -top-4 -right-4 bg-gradient-to-br from-green-400 to-emerald-500 text-white px-4 py-3 rounded-xl shadow-lg">
                                <div class="flex items-center gap-2">
                                    <i class='bx bx-check-circle text-xl'></i>
                                    <span class="text-sm font-semibold">Peminjaman Disetujui!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Semua yang Anda butuhkan dalam satu platform</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-purple-100">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class='bx bx-fast-forward text-white text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Proses Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">Pengajuan peminjaman dalam hitungan detik. Sistem efisien
                        dan otomatis.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-green-100">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class='bx bx-shield-alt-2 text-white text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Aman & Terpercaya</h3>
                    <p class="text-gray-600 leading-relaxed">Data dilindungi dengan enkripsi tingkat tinggi dan sistem 
                        keamanan berlapis.</p>
                </div>



                <!-- Feature 4 -->
                <div
                    class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-amber-100">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class='bx bx-mobile-alt text-white text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Responsive Design</h3>
                    <p class="text-gray-600 leading-relaxed">Dapat di akses kapan saja dan
                        di berbagai perangkat.</p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-red-100">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class='bx bx-file text-white text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Laporan Terstruktur</h3>
                    <p class="text-gray-600 leading-relaxed">Buat laporan detail dengan satu klik. Export ke PDF atau Excel 
                        dengan mudah.</p>
                </div>


            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Kerja</h2>
                <p class="text-xl text-gray-600">Tiga langkah mudah untuk meminjam alat</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold shadow-lg">
                            1
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Pilih Alat</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lihat koleksi alat yang tersedia, gunakan Fitur Filter berdasarkan kategori 
                            dan lihat detail lengkap setiap alat.
                        </p>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <i class='bx bx-right-arrow-alt text-4xl text-purple-300'></i>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold shadow-lg">
                            2
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Ajukan Peminjaman</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Isi form peminjaman dengan detail waktu dan jumlah yang dibutuhkan. Submit dan tunggu persetujuan dari petugas.
                        </p>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <i class='bx bx-right-arrow-alt text-4xl text-green-300'></i>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mb-6 text-white text-2xl font-bold shadow-lg">
                            3
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Pinjam & Kembalikan</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Setelah disetujui, ambil alat dan gunakan. Diharapkan mengembalikan tepat waktu untuk menjaga kredibilitas
                            Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                Siap untuk Memulai?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Nikmati kemudahan sistem kami bersama ratusan pengguna lainnya
            </p>
            @guest
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                    <i class='bx bx-rocket text-2xl'></i>
                    <span>Daftar Gratis Sekarang</span>
                </a>
            @endguest
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-2 px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                        <i class='bx bx-grid-alt text-2xl'></i>
                        <span>Buka Dashboard</span>
                    </a>
                @elseif (auth()->user()->role === 'petugas')
                    <a href="{{ route('petugas.dashboard') }}"
                        class="inline-flex items-center gap-2 px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                        <i class='bx bx-grid-alt text-2xl'></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('peminjam.dashboard') }}"
                        class="inline-flex items-center gap-2 px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-200">
                        <i class='bx bx-grid-alt text-2xl'></i>
                        <span>Buka Dashboard</span>
                    </a>
                @endif
            @endauth

        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class='bx bx-box text-white text-2xl'></i>
                        </div>
                        <span class="text-xl font-bold">Peminjaman Alat</span>
                    </div>
                    <p class="text-gray-400 mb-4 leading-relaxed">
                        Sistem manajemen peminjaman alat yang modern, efisien, dan mudah digunakan. Dibuat untuk
                        kemudahan Anda.
                    </p>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class='bx bxl-facebook text-xl'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class='bx bxl-twitter text-xl'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class='bx bxl-instagram text-xl'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class='bx bxl-linkedin text-xl'></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a>
                        </li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition-colors">How It
                                Works</a></li>
                        <li><a href="{{ route('login') }}"
                                class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}"
                                class="text-gray-400 hover:text-white transition-colors">Register</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Contact</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-400">
                            <i class='bx bx-map text-xl'></i>
                            <span class="text-sm">Batam, Indonesia</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-400">
                            <i class='bx bx-envelope text-xl'></i>
                            <span class="text-sm">stelamonicaaaa@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-400">
                            <i class='bx bx-phone text-xl'></i>
                            <span class="text-sm">+62 895-6291-78754</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Sistem Informasi Peminjaman Alat. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>