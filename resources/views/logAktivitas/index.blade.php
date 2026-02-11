@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class='bx bx-history text-white text-xl'></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Log Aktivitas</h1>
                    <p class="text-gray-500 text-sm mt-1">Riwayat aktivitas pengguna dalam sistem</p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">

            <!-- Card Header -->
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Aktivitas</h2>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aktivitas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($logAktivitas as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $logAktivitas->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-gray-800">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white">
                                            <i class='bx bx-user'></i>
                                        </div>
                                        {{ $item->user->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                                    bg-blue-100 text-blue-700 border border-blue-200">
                                        <i class='bx bx-info-circle'></i>
                                        {{ $item->aktivitas }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <i class='bx bx-time-five mr-1'></i>
                                    {{ $item->created_at->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class='bx bx-history text-4xl text-gray-400'></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada log aktivitas</h3>
                                        <p class="text-gray-500 text-sm">Belum ada aktivitas yang tercatat</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($logAktivitas->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $logAktivitas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
