@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class='bx bx-box text-white text-xl'></i>
                        </div>
                        Data Alat
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola data alat yang tersedia</p>
                </div>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('alat.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class='bx bx-plus-circle text-xl'></i>
                        <span>Tambah Alat</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg flex items-start gap-3 animate-fade-in">
                <div class="shrink-0">
                    <i class='bx bxs-check-circle text-green-500 text-2xl'></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start gap-3 animate-fade-in">
                <div class="shrink-0">
                    <i class='bx bxs-error-circle text-red-500 text-2xl'></i>
                </div>
                <div class="flex-1">
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">Total Alat</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-box text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Alat Tersedia</p>
                        <h3 class="text-3xl font-bold mt-1">
                            {{ $allData->where('stok', '>', 0)->where('kondisi', '!=', 'Rusak')->where('kondisi', '!=', 'Perbaikan')->count() }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-check-circle text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Stok Habis</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->where('stok', 0)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-error-circle text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Perbaiki/Rusak</p>
                        <h3 class="text-3xl font-bold mt-1">
                            {{ $allData->where('kondisi', 'Perbaikan')->count() + $allData->where('kondisi', 'Rusak')->count() }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-extension text-2xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Alat</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kode Alat
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Alat
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kondisi
                            </th>
                            @if (auth()->user()->role === 'admin')
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($alat as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-700 border border-indigo-200">
                                            <i class='bx bx-barcode text-sm mr-1'></i>
                                            {{ $item->kode_alat }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-semibold shadow">
                                            <i class='bx bx-box text-xl'></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->nama_alat }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                        <i class='bx bxs-circle text-[6px]'></i>
                                        {{ $item->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($item->stok > 0)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                            <i class='bx bxs-package text-sm'></i>
                                            {{ $item->stok }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <i class='bx bxs-error text-sm'></i>
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $kondisiColors = [
                                            'Baik' => 'bg-green-100 text-green-700 border-green-200',
                                            'Rusak Ringan' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'Rusak Berat' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                        $colorClass =
                                            $kondisiColors[$item->kondisi] ??
                                            'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                        <i class='bx bxs-circle text-[6px]'></i>
                                        {{ $item->kondisi }}
                                    </span>
                                </td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('alat.edit', $item->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                <i class='bx bx-edit-alt text-base'></i>
                                                <span>Edit</span>
                                            </a>

                                            <form action="{{ route('alat.destroy', $item->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus alat {{ $item->nama_alat }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                    <i class='bx bx-trash text-base'></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class='bx bx-box text-4xl text-gray-400'></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada data alat</h3>
                                        <p class="text-gray-500 text-sm">Silakan tambahkan alat baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($alat->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $alat->links() }}
                </div>
            @endif
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
