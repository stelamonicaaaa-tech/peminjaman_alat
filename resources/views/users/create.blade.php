@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Form -->
            <div class="lg:col-span-2">
                <!-- Header Section -->
                <div class="mb-6">

                    <div class="bg-white p-4.5 shadow-md rounded-xl w-full">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                            <div class="flex gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-user-plus text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Tambah User</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Tambahkan pengguna baru ke sistem</p>
                    </div>
                </div>

                <!-- Alert Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-fade-in">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0">
                                <i class='bx bxs-error-circle text-red-500 text-2xl'></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-red-800 font-semibold mb-2">Terdapat beberapa kesalahan:</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-red-700 text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-edit text-blue-600'></i>
                            Form Data User
                        </h2>
                    </div>

                    <!-- Card Body -->
                    <form action="{{ route('users.store') }}" method="POST" class="p-6">
                        @csrf

                        <div class="space-y-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-user text-gray-400'></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-envelope text-gray-400'></i>
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="contoh@email.com" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-lock text-gray-400'></i>
                                    Password
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                        placeholder="Minimal 8 karakter" required>
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class='bx bx-hide text-xl' id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-shield text-gray-400'></i>
                                    Role Pengguna
                                </label>
                                <select name="role"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 appearance-none bg-white"
                                    required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        👑 Admin
                                    </option>
                                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                                        👨‍💼 Petugas
                                    </option>
                                    <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>
                                        👤 Peminjam
                                    </option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <a href="{{ route('users.index') }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                                    <i class='bx bx-x text-xl'></i>
                                    <span>Batal</span>
                                </a>
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    <i class='bx bx-save text-xl'></i>
                                    <span>Simpan Data</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Info & Preview -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Info Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900">Informasi Penting</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-blue-600 text-lg shrink-0'></i>
                            <span>Password minimal 8 karakter</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-blue-600 text-lg shrink-0'></i>
                            <span>Email harus unik dan belum terdaftar</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-blue-600 text-lg shrink-0'></i>
                            <span>Pilih role sesuai tugas pengguna</span>
                        </li>
                    </ul>
                </div>

                <!-- Role Description Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-shield-quarter text-purple-600'></i>
                        Deskripsi Role
                    </h4>
                    <div class="space-y-3">
                        <!-- Admin -->
                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">👑</span>
                                <h5 class="font-semibold text-purple-900 text-sm">Admin</h5>
                            </div>
                            <p class="text-xs text-purple-700">Akses penuh ke semua fitur sistem</p>
                        </div>

                        <!-- Petugas -->
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">👨‍💼</span>
                                <h5 class="font-semibold text-blue-900 text-sm">Petugas</h5>
                            </div>
                            <p class="text-xs text-blue-700">Mengelola peminjaman dan pengembalian</p>
                        </div>

                        <!-- Peminjam -->
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">👤</span>
                                <h5 class="font-semibold text-green-900 text-sm">Peminjam</h5>
                            </div>
                            <p class="text-xs text-green-700">Dapat melakukan peminjaman alat</p>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-900 mb-2">Tips</h4>
                            <p class="text-xs text-amber-800 leading-relaxed">
                                Pastikan email yang digunakan aktif untuk keperluan notifikasi sistem.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bx-hide');
                toggleIcon.classList.add('bx-show');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bx-show');
                toggleIcon.classList.add('bx-hide');
            }
        }
    </script>
@endsection
