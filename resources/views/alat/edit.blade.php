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
                                    class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-edit text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Edit Alat</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Perbarui informasi alat</p>
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

                <!-- Alat Info Card -->
                <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center text-white shadow-lg">
                            <i class='bx bx-box text-3xl'></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-lg font-bold text-gray-800">{{ $alat->nama_alat }}</h3>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200">
                                    {{ $alat->kode_alat }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $alat->kategori->nama_kategori }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-edit text-amber-600'></i>
                            Form Edit Alat
                        </h2>
                    </div>

                    <!-- Card Body -->
                    <form action="{{ route('alat.update', $alat->id) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <!-- Kode Alat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-barcode text-gray-400'></i>
                                    Kode Alat
                                </label>
                                <input type="text" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Contoh: ALT001, PROJ001" required>
                                @error('kode_alat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Alat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-box text-gray-400'></i>
                                    Nama Alat
                                </label>
                                <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Contoh: Laptop Dell, Proyektor Epson" required>
                                @error('nama_alat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-category text-gray-400'></i>
                                    Kategori
                                </label>
                                <select name="kategori_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 appearance-none bg-white"
                                    required>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('kategori_id', $alat->kategori_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-package text-gray-400'></i>
                                    Stok
                                </label>
                                <input type="number" name="stok" min="0" value="{{ old('stok', $alat->stok) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    placeholder="Jumlah stok tersedia" required>
                                @error('stok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-check-shield text-gray-400'></i>
                                    Kondisi
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    {{-- Baik --}}
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all
                                            {{ old('kondisi', $alat->kondisi) == 'Baik'
                                                ? 'border-green-600 bg-green-100'
                                                : 'border-gray-200 bg-green-50 hover:border-green-600 hover:bg-green-100' }}">

                                        <input type="radio" name="kondisi" value="Baik"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500"
                                            {{ old('kondisi', $alat->kondisi) == 'Baik' ? 'checked' : '' }}>

                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-check-circle text-green-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Baik</span>
                                        </span>
                                    </label>

                                    {{-- Rusak Ringan --}}
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all
                                            {{ old('kondisi', $alat->kondisi) == 'Rusak Ringan'
                                                ? 'border-yellow-500 bg-yellow-100'
                                                : 'border-gray-200 bg-amber-50 hover:border-yellow-500 hover:bg-yellow-100' }}">

                                        <input type="radio" name="kondisi" value="Rusak Ringan"
                                            class="h-4 w-4 text-yellow-600 focus:ring-yellow-500"
                                            {{ old('kondisi', $alat->kondisi) == 'Rusak Ringan' ? 'checked' : '' }}>

                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-error text-yellow-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Ringan</span>
                                        </span>
                                    </label>

                                    {{-- Rusak Berat --}}
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all
                                            {{ old('kondisi', $alat->kondisi) == 'Rusak Berat'
                                                ? 'border-red-500 bg-red-100'
                                                : 'border-gray-200 bg-red-50 hover:border-red-500 hover:bg-red-100' }}">

                                        <input type="radio" name="kondisi" value="Rusak Berat"
                                            class="h-4 w-4 text-red-600 focus:ring-red-500"
                                            {{ old('kondisi', $alat->kondisi) == 'Rusak Berat' ? 'checked' : '' }}>

                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-x-circle text-red-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Berat</span>
                                        </span>
                                    </label>
                                </div>


                                {{-- @error('kondisi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror --}}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <a href="{{ route('alat.index') }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                                    <i class='bx bx-x text-xl'></i>
                                    <span>Batal</span>
                                </a>
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    <i class='bx bx-save text-xl'></i>
                                    <span>Update Data</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Info & Preview -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Warning Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-error text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-900">Perhatian!</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-amber-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-amber-600 text-lg shrink-0'></i>
                            <span>Perubahan akan langsung tersimpan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-amber-600 text-lg shrink-0'></i>
                            <span>Pastikan data yang diinput sudah benar</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-amber-600 text-lg shrink-0'></i>
                            <span>Kode alat harus tetap unik</span>
                        </li>
                    </ul>
                </div>

                <!-- Stats Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-bar-chart text-indigo-600'></i>
                        Informasi Alat
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                            <i class='bx bx-calendar-plus text-gray-400 text-lg'></i>
                            <div>
                                <p class="text-xs text-gray-500">Dibuat pada</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $alat->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                            <i class='bx bx-calendar-edit text-gray-400 text-lg'></i>
                            <div>
                                <p class="text-xs text-gray-500">Terakhir diupdate</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $alat->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
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
                            <p class="text-xs text-green-700">Alat dalam kondisi normal</p>
                        </div>

                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">⚠️</span>
                                <h5 class="font-semibold text-amber-900 text-sm">Rusak Ringan</h5>
                            </div>
                            <p class="text-xs text-amber-700">Alat sedang dalam kondisi rusak ringan dan membutuhkan
                                perhatian</p>
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
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Jika mengubah kondisi alat menjadi "Rusak", pastikan untuk mengurangi stok agar tidak
                                dipinjam.
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
