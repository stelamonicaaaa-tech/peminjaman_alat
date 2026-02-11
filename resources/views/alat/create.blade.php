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
                                    class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-box text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Tambah Alat</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Tambahkan alat baru ke sistem</p>
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
                            <i class='bx bx-edit text-indigo-600'></i>
                            Form Data Alat
                        </h2>
                    </div>

                    <!-- Card Body -->
                    <form action="{{ route('alat.store') }}" method="POST" class="p-6">
                        @csrf

                        <div class="space-y-4">
                            <!-- Kode Alat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-barcode text-gray-400'></i>
                                    Kode Alat
                                </label>
                                <input type="text" name="kode_alat" value="{{ old('kode_alat') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Contoh: ALT001, PROJ001" required>
                                {{-- @error('kode_alat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror --}}
                            </div>

                            <!-- Nama Alat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-box text-gray-400'></i>
                                    Nama Alat
                                </label>
                                <input type="text" name="nama_alat" value="{{ old('nama_alat') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Contoh: Laptop Dell, Proyektor Epson" required>
                                {{-- @error('nama_alat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror --}}
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-category text-gray-400'></i>
                                    Kategori
                                </label>
                                <select name="kategori_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 appearance-none bg-white"
                                    required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- @error('kategori_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror --}}
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-package text-gray-400'></i>
                                    Stok
                                </label>
                                <input type="number" name="stok" min="0" value="{{ old('stok') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Jumlah stok tersedia" required>
                                {{-- @error('stok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror --}}
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-check-shield text-gray-400'></i>
                                    Kondisi
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-green-50 rounded-xl cursor-pointer transition-all hover:border-green-600 hover:bg-green-100">
                                        <input type="radio" name="kondisi" value="Baik"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-check-circle text-green-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Baik</span>
                                        </span>
                                    </label>

                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-amber-50 rounded-xl cursor-pointer transition-all hover:border-yellow-500 hover:bg-yellow-100">
                                        <input type="radio" name="kondisi" value="Rusak Ringan"
                                            class="h-4 w-4 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-error text-yellow-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Ringan</span>
                                        </span>
                                    </label>

                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-red-50 rounded-xl cursor-pointer transition-all hover:border-red-500 hover:bg-red-100">
                                        <input type="radio" name="kondisi" value="Rusak Berat"
                                            class="h-4 w-4 text-red-600 focus:ring-red-500">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-x-circle text-red-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Berat</span>
                                        </span>
                                    </label>
                                </div>

                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <a href="{{ route('alat.index') }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                                    <i class='bx bx-x text-xl'></i>
                                    <span>Batal</span>
                                </a>
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
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
                <div
                    class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-900">Informasi Penting</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-indigo-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-indigo-600 text-lg shrink-0'></i>
                            <span>Kode alat harus unik</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-indigo-600 text-lg shrink-0'></i>
                            <span>Pastikan kategori sudah tersedia</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-indigo-600 text-lg shrink-0'></i>
                            <span>Stok minimal 0</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-indigo-600 text-lg shrink-0'></i>
                            <span>Pilih kondisi yang sesuai</span>
                        </li>
                    </ul>
                </div>

                <!-- Kondisi Info -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-check-shield text-purple-600'></i>
                        Status Kondisi
                    </h4>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">✅</span>
                                <h5 class="font-semibold text-green-900 text-sm">Baik</h5>
                            </div>
                            <p class="text-xs text-green-700">Alat dalam kondisi normal dan siap digunakan</p>
                        </div>

                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">⚠️</span>
                                <h5 class="font-semibold text-amber-900 text-sm">Rusak Ringan</h5>
                            </div>
                            <p class="text-xs text-amber-700">Alat sedang dalam kondisi rusak ringan dan membutuhkan perhatian</p>
                        </div>

                        <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">❌</span>
                                <h5 class="font-semibold text-red-900 text-sm">Rusak Berat</h5>
                            </div>
                            <p class="text-xs text-red-700">Tidak dapat digunakan</p>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Gunakan format kode yang konsisten untuk memudahkan identifikasi, misalnya: PROJ001 untuk
                                proyektor, LAP001 untuk laptop.
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
@endsection
