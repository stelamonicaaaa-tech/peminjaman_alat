@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class='bx bxs-dashboard text-white text-3xl'></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Peminjam</h1>
                    <p class="text-gray-500 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if($peminjamanTerlambat->count() > 0)
            <div class="mb-6 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-lg p-4 animate-pulse">
                <div class="flex items-start gap-3">
                    <i class='bx bx-error-circle text-red-500 text-2xl'></i>
                    <div>
                        <h3 class="font-bold text-red-900 mb-1">Peminjaman Terlambat!</h3>
                        <p class="text-sm text-red-700">Anda memiliki {{ $peminjamanTerlambat->count() }} peminjaman yang terlambat. Segera kembalikan untuk menghindari sanksi!</p>
                    </div>
                </div>
            </div>
        @endif

        @if($perluDikembalikan->count() > 0)
            <div class="mb-6 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class='bx bx-alarm text-amber-600 text-2xl'></i>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-1">Jatuh Tempo Segera</h3>
                        <p class="text-sm text-amber-700">{{ $perluDikembalikan->count() }} peminjaman perlu dikembalikan dalam 2 hari ke depan.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Peminjaman -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-shopping-bag text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $totalPeminjaman }}</span>
                </div>
                <h3 class="text-lg font-semibold">Total Peminjaman</h3>
                <p class="text-blue-100 text-sm">Semua waktu</p>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-cart-add text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $peminjamanAktif }}</span>
                </div>
                <h3 class="text-lg font-semibold">Peminjaman Aktif</h3>
                <p class="text-green-100 text-sm">Sedang dipinjam</p>
            </div>

            <!-- Peminjaman Selesai -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check-double text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $peminjamanSelesai }}</span>
                </div>
                <h3 class="text-lg font-semibold">Selesai</h3>
                <p class="text-purple-100 text-sm">Sudah dikembalikan</p>
            </div>

            <!-- Menunggu Persetujuan -->
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time-five text-3xl'></i>
                    </div>
                    <span class="text-4xl font-bold">{{ $peminjamanMenunggu }}</span>
                </div>
                <h3 class="text-lg font-semibold">Menunggu</h3>
                <p class="text-amber-100 text-sm">Perlu persetujuan</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Peminjaman Saya -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bxs-cart text-green-600'></i>
                                Peminjaman Saya
                            </h2>
                            <a href="{{ route('peminjaman.create') }}" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors">
                                <i class='bx bx-plus'></i> Ajukan Peminjaman
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($myPeminjaman as $item)
                            <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-sm font-mono font-semibold text-gray-700">#{{ $item->id }}</span>
                                            @php
                                                $statusColors = [
                                                    'menunggu persetujuan' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                    'disetujui' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                                    'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                                ];
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">Diajukan {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($item->status === 'menunggu persetujuan')
                                            <a href="{{ route('peminjaman.edit', $item->id) }}" 
                                                class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-sm font-medium transition-colors">
                                                <i class='bx bx-edit'></i> Edit
                                            </a>
                                        @endif
                                        <a href="{{ route('peminjaman.index') }}" 
                                            class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg text-sm font-medium transition-colors">
                                            <i class='bx bx-show'></i> Detail
                                        </a>
                                    </div>
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
                                    @foreach($item->detailPeminjaman->take(3) as $detail)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">
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
                        @empty
                            <div class="text-center py-12">
                                <i class='bx bx-shopping-bag text-6xl text-gray-300 mb-4'></i>
                                <p class="text-gray-500 mb-4">Belum ada peminjaman aktif</p>
                                <a href="{{ route('peminjaman.create') }}" 
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class='bx bx-plus'></i>
                                    Ajukan Peminjaman Baru
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Alat Tersedia -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-package text-blue-600'></i>
                                Alat Tersedia
                            </h2>
                            <a href="{{ route('alat.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($alatTersedia->take(6) as $alat)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:bg-blue-50 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center text-white flex-shrink-0">
                                            <i class='bx bx-box text-2xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 text-sm mb-1 truncate">{{ $alat->nama_alat }}</h3>
                                            <p class="text-xs text-gray-500 mb-2">{{ $alat->kode_alat }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-600">Stok:</span>
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                    {{ $alat->stok }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-8 text-gray-500">
                                    Tidak ada alat tersedia
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                <!-- Terlambat Warning -->
                @if($peminjamanTerlambat->count() > 0)
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 border border-red-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-error text-white text-xl'></i>
                            </div>
                            <h3 class="font-bold text-red-900">Terlambat!</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($peminjamanTerlambat as $item)
                                <div class="bg-white rounded-lg p-3 border border-red-100">
                                    <p class="font-medium text-gray-900 text-sm mb-1">Peminjaman #{{ $item->id }}</p>
                                    <p class="text-xs text-red-600 mb-2">
                                        Harusnya kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                                    </p>
                                    <a href="{{ route('pengembalian.create') }}" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-semibold">
                                        <i class='bx bx-package'></i>
                                        Kembalikan Sekarang
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Jatuh Tempo Segera -->
                @if($perluDikembalikan->count() > 0)
                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-alarm text-white text-xl'></i>
                            </div>
                            <h3 class="font-bold text-amber-900">Segera Dikembalikan</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($perluDikembalikan as $item)
                                <div class="bg-white rounded-lg p-3 border border-amber-100">
                                    <p class="font-medium text-gray-900 text-sm mb-1">Peminjaman #{{ $item->id }}</p>
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

                <!-- Riwayat Peminjaman -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-history text-purple-600'></i>
                            Riwayat Peminjaman
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse($riwayatPeminjaman as $item)
                                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                    @php
                                        $iconColor = $item->status === 'selesai' ? 'from-green-400 to-emerald-500' : 'from-red-400 to-orange-500';
                                        $iconClass = $item->status === 'selesai' ? 'bx-check-circle' : 'bx-x-circle';
                                    @endphp
                                    <div class="w-8 h-8 bg-gradient-to-br {{ $iconColor }} rounded-full flex items-center justify-center text-white flex-shrink-0">
                                        <i class='bx {{ $iconClass }} text-lg'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">#{{ $item->id }}</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</p>
                                        <p class="text-xs {{ $item->status === 'selesai' ? 'text-green-600' : 'text-red-600' }} mt-1 font-medium">
                                            {{ ucfirst($item->status) }}
                                        </p>
                                    </div>
                                    <a href="{{ route('peminjaman.index') }}" 
                                        class="text-gray-400 hover:text-gray-600">
                                        <i class='bx bx-right-arrow-alt text-xl'></i>
                                    </a>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 text-sm py-8">Belum ada riwayat</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-green-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-rocket'></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('peminjaman.create') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-green-50 rounded-lg transition-colors border border-green-100">
                            <i class='bx bx-plus-circle text-green-600'></i>
                            <span class="text-sm font-medium text-gray-700">Ajukan Peminjaman</span>
                        </a>
                        <a href="{{ route('pengembalian.create') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-green-50 rounded-lg transition-colors border border-green-100">
                            <i class='bx bx-package text-green-600'></i>
                            <span class="text-sm font-medium text-gray-700">Kembalikan Alat</span>
                        </a>
                        <a href="{{ route('alat.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-green-50 rounded-lg transition-colors border border-green-100">
                            <i class='bx bx-box text-green-600'></i>
                            <span class="text-sm font-medium text-gray-700">Lihat Daftar Alat</span>
                        </a>
                        <a href="{{ route('peminjaman.index') }}" 
                            class="flex items-center gap-3 px-4 py-3 bg-white hover:bg-green-50 rounded-lg transition-colors border border-green-100">
                            <i class='bx bx-history text-green-600'></i>
                            <span class="text-sm font-medium text-gray-700">Riwayat Lengkap</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection