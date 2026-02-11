@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class='bx bxs-detail text-white text-2xl'></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Detail Pengembalian</h1>
                            <p class="text-sm text-gray-500">ID: <span
                                    class="font-mono font-semibold text-gray-700">#{{ $pengembalian->id }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex flex-wrap gap-2">
                    @php
                        $kondisiColors = [
                            'baik' => 'bg-green-100 text-green-700 border-green-200',
                            'rusak ringan' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'rusak berat' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                        $kondisiIcons = [
                            'baik' => 'bx-check-circle',
                            'rusak ringan' => 'bx-error',
                            'rusak berat' => 'bx-x-circle',
                        ];
                        $kondisiClass =
                            $kondisiColors[$pengembalian->status_kondisi] ??
                            'bg-gray-100 text-gray-700 border-gray-200';
                        $kondisiIcon = $kondisiIcons[$pengembalian->status_kondisi] ?? 'bx-info-circle';
                    @endphp
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border-2 {{ $kondisiClass }}">
                        <i class='bx {{ $kondisiIcon }} text-lg'></i>
                        {{ ucfirst($pengembalian->status_kondisi) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Informasi Peminjaman Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-info-square text-green-600'></i>
                            Informasi Peminjaman
                        </h2>
                    </div>

                    <div class="p-6">
                        <!-- Peminjam Info -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                    {{ strtoupper(substr($pengembalian->peminjaman->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-600 mb-1">Peminjam</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $pengembalian->peminjaman->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <i class='bx bx-envelope text-sm'></i>
                                        {{ $pengembalian->peminjaman->user->email }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-600 mb-1">ID Peminjaman</p>
                                    <p class="text-lg font-mono font-bold text-gray-900">
                                        #{{ $pengembalian->peminjaman->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Date Info Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start gap-3">
                                    <i class='bx bx-calendar-plus text-blue-500 text-2xl'></i>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal Pinjam</p>
                                        <p class="font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start gap-3">
                                    <i class='bx bx-calendar-check text-amber-500 text-2xl'></i>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Rencana Kembali</p>
                                        <p class="font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_kembali_rencana)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start gap-3">
                                    <i class='bx bx-calendar-event text-green-500 text-2xl'></i>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal Kembali</p>
                                        <p class="font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alat yang Dikembalikan Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class='bx bx-package text-green-600'></i>
                            Alat yang Dikembalikan
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Alat
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Dipinjam
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Dikembalikan Ini</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Total
                                        Kembali</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pengembalian->detailPengembalian as $detail)
                                    @php
                                        $totalKembaliBefore = \App\Models\DetailPengembalian::where(
                                            'alat_id',
                                            $detail->alat_id,
                                        )
                                            ->whereIn(
                                                'pengembalian_id',
                                                \App\Models\Pengembalian::where(
                                                    'peminjaman_id',
                                                    $pengembalian->peminjaman_id,
                                                )
                                                    ->where('id', '<', $pengembalian->id)
                                                    ->pluck('id'),
                                            )
                                            ->sum('jumlah');

                                        $borrowed = $pengembalian->peminjaman
                                            ->detailPeminjaman()
                                            ->where('alat_id', $detail->alat_id)
                                            ->sum('jumlah');
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white">
                                                    <i class='bx bx-box text-lg'></i>
                                                </div>
                                                <div>
                                                    <span
                                                        class="text-sm font-semibold text-gray-900">{{ $detail->alat->nama_alat }}</span>
                                                    <p class="text-xs text-gray-500">{{ $detail->alat->kode_alat }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                <i class='bx bxs-package text-sm'></i>
                                                {{ $borrowed }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                <i class='bx bx-check-circle text-sm'></i>
                                                {{ $detail->jumlah }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                                <i class='bx bx-archive text-sm'></i>
                                                {{ $totalKembaliBefore + $detail->jumlah }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class='bx bx-package text-4xl text-gray-400'></i>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada data</h3>
                                                <p class="text-gray-500 text-sm">Tidak ada alat yang dikembalikan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    @if ($pengembalian->peminjaman->status === 'disetujui' && auth()->user()->role === 'peminjam' || auth()->user()->role === 'admin')
                        <a href="{{ route('pengembalian.edit', $pengembalian->id) }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class='bx bx-plus-circle text-xl'></i>
                            <span>Tambah Pengembalian</span>
                        </a>
                    @endif

                    <a href="{{ route('pengembalian.index') }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-200 border border-gray-300">
                        <i class='bx bx-arrow-back text-xl'></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            <!-- Right Column - Status & Info -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Status Peminjaman Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-info-circle text-indigo-600'></i>
                        Status Peminjaman
                    </h4>

                    <div
                        class="p-4 rounded-lg border-2 {{ $pengembalian->peminjaman->status === 'selesai' ? 'bg-green-50 border-green-200' : ($pengembalian->peminjaman->status === 'disetujui' ? 'bg-blue-50 border-blue-200' : 'bg-yellow-50 border-yellow-200') }}">
                        <div class="flex items-center gap-3">
                            @if ($pengembalian->peminjaman->status === 'selesai')
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class='bx bx-check text-white text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600 mb-0.5">Status</p>
                                    <p class="font-bold text-green-700">Selesai</p>
                                </div>
                            @elseif($pengembalian->peminjaman->status === 'disetujui')
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class='bx bx-time-five text-white text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600 mb-0.5">Status</p>
                                    <p class="font-bold text-blue-700">Disetujui</p>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <i class='bx bx-hourglass text-white text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-xs text-yellow-600 mb-0.5">Status</p>
                                    <p class="font-bold text-yellow-700">{{ ucfirst($pengembalian->peminjaman->status) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Warning for Partial Return -->
                @if ($pengembalian->peminjaman->status === 'disetujui' && auth()->user()->role !== 'peminjam')
                    <div
                        class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                                <i class='bx bx-info-circle text-white text-xl'></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-amber-900 mb-2">Perhatian</h4>
                                <p class="text-xs text-amber-800 leading-relaxed">
                                    Masih ada alat yang belum dikembalikan. Peminjam dapat menambah pengembalian lanjutan.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Kondisi Alat Detail -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-check-shield text-green-600'></i>
                        Kondisi Alat
                    </h4>

                    @php
                        $kondisiDescriptions = [
                            'baik' => 'Alat dalam kondisi normal tanpa kerusakan',
                            'rusak ringan' => 'Alat masih bisa digunakan dengan perbaikan kecil',
                            'rusak berat' => 'Alat tidak dapat digunakan dan perlu perbaikan besar',
                        ];
                        $kondisiColorsBg = [
                            'baik' => 'bg-green-50 border-green-200',
                            'rusak ringan' => 'bg-yellow-50 border-yellow-200',
                            'rusak berat' => 'bg-red-50 border-red-200',
                        ];
                        $kondisiColorsText = [
                            'baik' => 'text-green-900',
                            'rusak ringan' => 'text-yellow-900',
                            'rusak berat' => 'text-red-900',
                        ];
                    @endphp

                    <div
                        class="p-4 rounded-lg border-2 {{ $kondisiColorsBg[$pengembalian->status_kondisi] ?? 'bg-gray-50 border-gray-200' }}">
                        <div class="flex items-center gap-2 mb-2">
                            <i
                                class='bx {{ $kondisiIcon }} text-xl {{ str_replace('text-', '', str_replace('100', '600', $kondisiClass)) }}'></i>
                            <h5
                                class="font-bold {{ $kondisiColorsText[$pengembalian->status_kondisi] ?? 'text-gray-900' }}">
                                {{ ucfirst($pengembalian->status_kondisi) }}
                            </h5>
                        </div>
                        <p class="text-xs {{ $kondisiColorsText[$pengembalian->status_kondisi] ?? 'text-gray-700' }}">
                            {{ $kondisiDescriptions[$pengembalian->status_kondisi] ?? 'Status tidak diketahui' }}
                        </p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-time-five text-purple-600'></i>
                        Timeline
                    </h4>

                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                            <i class='bx bx-calendar-plus text-gray-400 text-lg'></i>
                            <div>
                                <p class="text-xs text-gray-500">Dibuat pada</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $pengembalian->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                            <i class='bx bx-calendar-edit text-gray-400 text-lg'></i>
                            <div>
                                <p class="text-xs text-gray-500">Terakhir diupdate</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $pengembalian->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
