@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class='bx bxs-dashboard text-white text-3xl'></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                    <p class="text-gray-500 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-user-account text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalUsers }}</span>
                </div>
                <h3 class="text-lg font-semibold">Total Users</h3>
                <p class="text-blue-100 text-sm">Pengguna terdaftar</p>
            </div>

            <!-- Total Alat -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-package text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalAlat }}</span>
                </div>
                <h3 class="text-lg font-semibold">Total Stok Alat</h3>
                <p class="text-green-100 text-sm">Stok keseluruhan</p>
            </div>

            <!-- Total Kategori -->
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-category text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalKategori }}</span>
                </div>
                <h3 class="text-lg font-semibold">Kategori Alat</h3>
                <p class="text-amber-100 text-sm">Jenis kategori</p>
            </div>

            <!-- Total Peminjaman -->
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-cart-add text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalPeminjaman }}</span>
                </div>
                <h3 class="text-lg font-semibold">Total Peminjaman</h3>
                <p class="text-purple-100 text-sm">Semua transaksi</p>
            </div>
        </div>

        <!-- Peminjaman Status Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 shadow border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-medium mb-1">Menunggu</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $peminjamanMenunggu }}</p>
                    </div>
                    <i class='bx bx-time-five text-4xl text-yellow-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium mb-1">Disetujui</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $peminjamanDisetujui }}</p>
                    </div>
                    <i class='bx bx-check-circle text-4xl text-blue-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium mb-1">Selesai</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $peminjamanSelesai }}</p>
                    </div>
                    <i class='bx bx-check-double text-4xl text-green-500'></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-medium mb-1">Ditolak</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $peminjamanDitolak }}</p>
                    </div>
                    <i class='bx bx-x-circle text-4xl text-red-500'></i>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Pending Approvals -->
                @if($pendingPeminjaman->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-white">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class='bx bx-time-five text-yellow-600'></i>
                                    Peminjaman Menunggu Persetujuan
                                </h2>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $pendingPeminjaman->count() }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($pendingPeminjaman as $item)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $item->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('peminjaman.show', $item->id) }}" 
                                            class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-sm font-medium transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($item->detailPeminjaman->take(3) as $detail)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-700 rounded-md text-xs">
                                                <i class='bx bx-box'></i>
                                                {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                                            </span>
                                        @endforeach
                                        @if($item->detailPeminjaman->count() > 3)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-200 text-gray-600 rounded-md text-xs font-medium">
                                                +{{ $item->detailPeminjaman->count() - 3 }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Top Borrowed Items -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-trending-up text-purple-600'></i>
                            Alat Paling Sering Dipinjam
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($topBorrowedItems as $index => $item)
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item['nama_alat'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $item['kode_alat'] }}</p>
                                    </div>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                        {{ $item['total_borrowed'] }}x
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-purple-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-rocket'></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('users.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-purple-50 rounded-lg transition-colors border border-purple-100">
                            <i class='bx bx-user-plus text-purple-600'></i>
                            <span class="text-sm font-medium text-gray-700">Kelola User</span>
                        </a>
                        <a href="{{ route('alat.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-purple-50 rounded-lg transition-colors border border-purple-100">
                            <i class='bx bx-package text-purple-600'></i>
                            <span class="text-sm font-medium text-gray-700">Kelola Alat</span>
                        </a>
                        <a href="{{ route('peminjaman.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-purple-50 rounded-lg transition-colors border border-purple-100">
                            <i class='bx bx-list-ul text-purple-600'></i>
                            <span class="text-sm font-medium text-gray-700">Lihat Peminjaman</span>
                        </a>
                        <a href="{{ route('logAktivitas.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-purple-50 rounded-lg transition-colors border border-purple-100">
                            <i class='bx bx-history text-purple-600'></i>
                            <span class="text-sm font-medium text-gray-700">Log Aktivitas</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                <!-- Low Stock Alert -->
                @if($lowStockAlat->count() > 0)
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 border border-red-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-error text-white text-xl'></i>
                            </div>
                            <h3 class="font-bold text-red-900">Stok Menipis!</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($lowStockAlat as $alat)
                                <div class="bg-white rounded-lg p-3 border border-red-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $alat->nama_alat }}</p>
                                            <p class="text-xs text-gray-500">{{ $alat->kode_alat }}</p>
                                        </div>
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                            {{ $alat->stok }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-history text-indigo-600'></i>
                            Aktivitas Terbaru
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 max-h-[575px] overflow-y-auto">
                            @forelse($recentActivities as $activity)
                                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-semibold">{{ $activity->user->name ?? 'User' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-600">{{ $activity->aktivitas }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($activity->waktu)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 text-sm py-8">Belum ada aktivitas</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
@endsection