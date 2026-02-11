@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                            <i class='bx bxs-package text-white text-xl'></i>
                        </div>
                        Data Pengembalian
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola pengembalian alat dari peminjam</p>
                </div>
                @if (auth()->user()->role === 'peminjam' || auth()->user()->role === 'admin')
                    <a href="{{ route('pengembalian.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class='bx bx-plus-circle text-xl'></i>
                        <span>Buat Pengembalian</span>
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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Kondisi Baik</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $pengembalian->where('status_kondisi', 'baik')->count() }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-check-circle text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Rusak Ringan</p>
                        <h3 class="text-3xl font-bold mt-1">
                            {{ $pengembalian->where('status_kondisi', 'rusak ringan')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-error-alt text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Rusak Berat</p>
                        <h3 class="text-3xl font-bold mt-1">
                            {{ $pengembalian->where('status_kondisi', 'rusak berat')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-x-circle text-2xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if ($pengembalian->isEmpty())
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class='bx bx-package text-4xl text-gray-400'></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada data pengembalian</h3>
                <p class="text-gray-500 text-sm mb-6">Belum ada pengembalian alat yang tercatat</p>
                @if (auth()->user()->role === 'peminjam')
                    <a href="{{ route('pengembalian.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class='bx bx-plus-circle text-xl'></i>
                        <span>Buat Pengembalian</span>
                    </a>
                @endif
            </div>
        @else
            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Pengembalian</h2>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Peminjam
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tanggal Kembali
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Kondisi
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($pengembalian as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $pengembalian->firstItem() + $loop->index }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white font-semibold shadow">
                                                {{ strtoupper(substr($item->peminjaman->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $item->peminjaman->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->peminjaman->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class='bx bx-calendar text-gray-400'></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->status_kondisi === 'baik')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                <i class='bx bxs-check-circle text-sm'></i>
                                                Baik
                                            </span>
                                        @elseif($item->status_kondisi === 'rusak ringan')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                <i class='bx bxs-error-alt text-sm'></i>
                                                Rusak Ringan
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                                <i class='bx bxs-x-circle text-sm'></i>
                                                Rusak Berat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">
                                            <a href="{{ route('pengembalian.show', $item->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                <i class='bx bx-show text-base'></i>
                                                <span>Detail</span>
                                            </a>

                                            @if (
                                                $item->peminjaman->status === 'disetujui' &&
                                                    (auth()->user()->role === 'peminjam' || auth()->user()->role === 'admin'))
                                                <a href="{{ route('pengembalian.edit', $item->id) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                    <i class='bx bx-plus text-base'></i>
                                                    <span>Tambah</span>
                                                </a>
                                            @endif

                                            @if (auth()->user()->role === 'admin')
                                                <form action="{{ route('pengembalian.destroy', $item->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data pengembalian ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                        <i class='bx bx-trash text-base'></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($pengembalian->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $pengembalian->links() }}
                    </div>
                @endif
            </div>
        @endif
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
