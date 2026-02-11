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
                                    class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-category-alt text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Tambah Kategori</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Tambahkan kategori alat baru</p>
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
                            <i class='bx bx-edit text-green-600'></i>
                            Form Data Kategori
                        </h2>
                    </div>

                    <!-- Card Body -->
                    <form action="{{ route('kategori.store') }}" method="POST" class="p-6">
                        @csrf

                        <div class="space-y-4">
                            <!-- Nama Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-category text-gray-400'></i>
                                    Nama Kategori
                                </label>
                                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Contoh: Elektronik, Peralatan Kantor, dll" required>
                                @error('nama_kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-detail text-gray-400'></i>
                                    Keterangan
                                    <span class="text-xs font-normal text-gray-500">(opsional)</span>
                                </label>
                                <textarea name="keterangan" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Deskripsi singkat tentang kategori ini...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <a href="{{ route('kategori.index') }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                                    <i class='bx bx-x text-xl'></i>
                                    <span>Batal</span>
                                </a>
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
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
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-900">Informasi Penting</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Nama kategori harus unik dan jelas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Keterangan bersifat opsional</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Kategori akan digunakan untuk klasifikasi alat</span>
                        </li>
                    </ul>
                </div>

                <!-- Example Categories -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-list-ul text-indigo-600'></i>
                        Contoh Kategori
                    </h4>
                    <div class="space-y-2">
                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-laptop text-purple-600'></i>
                                <span class="text-sm font-semibold text-purple-900">Elektronik</span>
                            </div>
                            <p class="text-xs text-purple-700 mt-1">Laptop, Proyektor, Kamera, dll</p>
                        </div>

                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-wrench text-blue-600'></i>
                                <span class="text-sm font-semibold text-blue-900">Peralatan Kantor</span>
                            </div>
                            <p class="text-xs text-blue-700 mt-1">Printer, Scanner, Mesin Fax, dll</p>
                        </div>

                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-book text-green-600'></i>
                                <span class="text-sm font-semibold text-green-900">Pendukung Acara</span>
                            </div>
                            <p class="text-xs text-green-700 mt-1">Sound System, Mic, Podium, dll</p>
                        </div>

                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-hard-hat text-amber-600'></i>
                                <span class="text-sm font-semibold text-amber-900">Keamanan</span>
                            </div>
                            <p class="text-xs text-amber-700 mt-1">CCTV, Access Control, Alarm, dll</p>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Buat kategori yang spesifik dan mudah dipahami agar memudahkan pencarian dan pengelolaan
                                alat di masa mendatang.
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
