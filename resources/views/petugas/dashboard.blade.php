@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class='bx bxs-dashboard text-white text-3xl'></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Petugas</h1>
                    <p class="text-gray-500 text-sm">Monitor dan kelola peminjaman alat</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pending Approval -->
            <div class="bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time-five text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $pendingApproval }}</span>
                </div>
                <h3 class="text-lg font-semibold">Menunggu Persetujuan</h3>
                <p class="text-yellow-100 text-sm">Perlu diproses</p>
            </div>

            <!-- Active Borrowings -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-cart-add text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $activeBorrowings }}</span>
                </div>
                <h3 class="text-lg font-semibold">Peminjaman Aktif</h3>
                <p class="text-blue-100 text-sm">Sedang dipinjam</p>
            </div>

            <!-- Completed Today -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check-double text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $completedToday }}</span>
                </div>
                <h3 class="text-lg font-semibold">Selesai Hari Ini</h3>
                <p class="text-green-100 text-sm">Transaksi selesai</p>
            </div>

            <!-- Total Returns -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-package text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalReturns }}</span>
                </div>
                <h3 class="text-lg font-semibold">Total Pengembalian</h3>
                <p class="text-purple-100 text-sm">Semua waktu</p>
            </div>
        </div>

        <!-- Alerts -->
        @if($terlambat->count() > 0)
            <div class="mb-6 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class='bx bx-error-circle text-red-500 text-2xl'></i>
                    <div>
                        <h3 class="font-bold text-red-900 mb-1">Peminjaman Terlambat!</h3>
                        <p class="text-sm text-red-700">Ada {{ $terlambat->count() }} peminjaman yang sudah melewati batas waktu pengembalian.</p>
                    </div>
                </div>
            </div>
        @endif

        @if($mendekatiJatuhTempo->count() > 0)
            <div class="mb-6 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class='bx bx-alarm text-amber-600 text-2xl'></i>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-1">Mendekati Jatuh Tempo</h3>
                        <p class="text-sm text-amber-700">{{ $mendekatiJatuhTempo->count() }} peminjaman akan jatuh tempo dalam 3 hari ke depan.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Peminjaman Menunggu Persetujuan -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-white">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-time-five text-yellow-600'></i>
                                Perlu Persetujuan
                            </h2>
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $peminjamanMenunggu->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($peminjamanMenunggu->take(5) as $item)
                            <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('peminjaman.show', $item->id) }}" 
                                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition-colors">
                                        Review
                                    </a>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                                    <div>
                                        <span class="text-gray-500">Tanggal Pinjam:</span>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Rencana Kembali:</span>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($item->detailPeminjaman->take(2) as $detail)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">
                                            <i class='bx bx-box'></i>
                                            {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                                        </span>
                                    @endforeach
                                    @if($item->detailPeminjaman->count() > 2)
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-200 text-gray-600 rounded-md text-xs font-medium">
                                            +{{ $item->detailPeminjaman->count() - 2 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class='bx bx-check-circle text-6xl text-green-500 mb-4'></i>
                                <p class="text-gray-500">Semua peminjaman sudah diproses!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Peminjaman Aktif -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bxs-cart-add text-blue-600'></i>
                                Peminjaman Aktif
                            </h2>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $peminjamanAktif->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($peminjamanAktif->take(5) as $item)
                            <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->user->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                                                @if(\Carbon\Carbon::parse($item->tanggal_kembali_rencana)->isPast())
                                                    <span class="text-red-600 font-bold">(Terlambat!)</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('peminjaman.index') }}" 
                                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-sm font-medium transition-colors">
                                        Detail
                                    </a>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($item->detailPeminjaman->take(3) as $detail)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">
                                            <i class='bx bx-box'></i>
                                            {{ $detail->alat->nama_alat }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class='bx bx-package text-6xl text-gray-300 mb-4'></i>
                                <p class="text-gray-500">Tidak ada peminjaman aktif</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                <!-- Terlambat -->
                @if($terlambat->count() > 0)
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 border border-red-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-error text-white text-xl'></i>
                            </div>
                            <h3 class="font-bold text-red-900">Terlambat</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($terlambat as $item)
                                <div class="bg-white rounded-lg p-3 border border-red-100">
                                    <p class="font-medium text-gray-900 text-sm mb-1">{{ $item->user->name }}</p>
                                    <p class="text-xs text-red-600">
                                        Harusnya kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Terlambat {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->diffInDays(now()) }} hari
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Mendekati Jatuh Tempo -->
                @if($mendekatiJatuhTempo->count() > 0)
                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-alarm text-white text-xl'></i>
                            </div>
                            <h3 class="font-bold text-amber-900">Jatuh Tempo Segera</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($mendekatiJatuhTempo as $item)
                                <div class="bg-white rounded-lg p-3 border border-amber-100">
                                    <p class="font-medium text-gray-900 text-sm mb-1">{{ $item->user->name }}</p>
                                    <p class="text-xs text-amber-600">
                                        Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->diffForHumans() }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pengembalian Terbaru -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-package text-green-600'></i>
                            Pengembalian Terbaru
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse($pengembalianTerbaru->take(5) as $item)
                                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($item->peminjaman->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->peminjaman->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                        <p class="text-xs text-green-600 mt-1">
                                            Kondisi: {{ ucfirst($item->status_kondisi) }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 text-sm py-8">Belum ada pengembalian</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-rocket'></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('peminjaman.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-blue-50 rounded-lg transition-colors border border-blue-100">
                            <i class='bx bx-list-ul text-blue-600'></i>
                            <span class="text-sm font-medium text-gray-700">Semua Peminjaman</span>
                        </a>
                        <a href="{{ route('pengembalian.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-blue-50 rounded-lg transition-colors border border-blue-100">
                            <i class='bx bx-package text-blue-600'></i>
                            <span class="text-sm font-medium text-gray-700">Pengembalian</span>
                        </a>
                        <a href="{{ route('alat.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-blue-50 rounded-lg transition-colors border border-blue-100">
                            <i class='bx bx-box text-blue-600'></i>
                            <span class="text-sm font-medium text-gray-700">Lihat Alat</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection