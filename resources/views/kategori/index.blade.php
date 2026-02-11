@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <i class='bx bxs-category text-white text-xl'></i>
                        </div>
                        Data Kategori
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola kategori alat yang tersedia</p>
                </div>
                <a href="{{ route('kategori.create') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class='bx bx-plus-circle text-xl'></i>
                    <span>Tambah Kategori</span>
                </a>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Kategori</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-category text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Halaman</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $kategori->currentPage() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-book text-2xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Kategori</h2>
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
                                Nama Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Keterangan
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($kategori as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white font-semibold shadow">
                                            <i class='bx bxs-category-alt text-xl'></i>
                                        </div>
                                        <div>
                                            <span
                                                class="text-sm font-semibold text-gray-900">{{ $item->nama_kategori }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class='bx bx-info-circle text-gray-400 text-sm mt-0.5'></i>
                                        <span class="text-sm text-gray-600">{{ $item->keterangan ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kategori.edit', $item->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                            <i class='bx bx-edit-alt text-base'></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?')">
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class='bx bx-category text-4xl text-gray-400'></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada data kategori</h3>
                                        <p class="text-gray-500 text-sm">Silakan tambahkan kategori baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($kategori->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $kategori->links() }}
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
