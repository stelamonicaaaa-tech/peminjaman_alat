@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-linear-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class='bx bxs-cart-add text-white text-xl'></i>
                        </div>
                        Data Peminjaman
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola pengajuan dan riwayat peminjaman alat</p>
                </div>
                @if (auth()->user()->role === 'peminjam' || auth()->user()->role === 'admin')
                    <a href="{{ route('peminjaman.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class='bx bx-plus-circle text-xl'></i>
                        <span>Ajukan Peminjaman</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg flex items-start gap-3 animate-fade-in">
                <div class="flex-shrink-0">
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
                <div class="flex-shrink-0">
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
            <div class="bg-linear-to-br from-yellow-500 to-yellow-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Menunggu</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->where('status', 'menunggu')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time-five text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-linear-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Disetujui</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->where('status', 'disetujui')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-check-circle text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-linear-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Selesai</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->where('status', 'selesai')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-badge-check text-2xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-linear-to-br from-red-500 to-red-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Ditolak</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $allData->where('status', 'ditolak')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bxs-x-circle text-2xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if ($peminjaman->isEmpty())
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class='bx bx-cart text-4xl text-gray-400'></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada data peminjaman</h3>
                <p class="text-gray-500 text-sm mb-6">Belum ada pengajuan peminjaman yang tercatat</p>
                @if (auth()->user()->role === 'peminjam')
                    <a href="{{ route('peminjaman.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class='bx bx-plus-circle text-xl'></i>
                        <span>Ajukan Peminjaman</span>
                    </a>
                @endif
            </div>
        @else
            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Peminjaman</h2>
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
                                    Tanggal Pinjam
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Rencana Kembali
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($peminjaman as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-linear-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold shadow">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->user->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class='bx bx-calendar text-gray-400'></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class='bx bx-calendar-check text-gray-400'></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->status === 'menunggu')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                <i class='bx bx-time-five text-sm'></i>
                                                Menunggu
                                            </span>
                                        @elseif ($item->status === 'disetujui')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                <i class='bx bxs-check-circle text-sm'></i>
                                                Disetujui
                                            </span>
                                        @elseif ($item->status === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                <i class='bx bxs-badge-check text-sm'></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                                <i class='bx bxs-x-circle text-sm'></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">
                                            <button onclick="openDetailModal({{ $item->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                <i class='bx bx-show text-base'></i>
                                                <span>Detail</span>
                                            </button>

                                            @if (auth()->user()->role === 'admin' && $item->status === 'menunggu')
                                                <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                    <i class='bx bx-edit-alt text-base'></i>
                                                    <span>Edit</span>
                                                </a>

                                                <form action="{{ route('peminjaman.destroy', $item->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                        <i class='bx bx-trash text-base'></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            @elseif (auth()->user()->role === 'petugas' && $item->status === 'menunggu')
                                                <form action="{{ route('peminjaman.approve', $item->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                        <i class='bx bx-check text-base'></i>
                                                        <span>Setujui</span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('peminjaman.reject', $item->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <button
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg font-medium text-sm transition-colors duration-150">
                                                        <i class='bx bx-x text-base'></i>
                                                        <span>Tolak</span>
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
                @if ($peminjaman->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $peminjaman->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black opacity-50" onclick="closeDetailModal()"></div>

        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class='bx bx-detail text-cyan-600'></i>
                        Detail Peminjaman
                    </h2>
                    <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4 max-h-96 overflow-y-auto">
                <!-- Loading State -->
                <div id="modalLoading" class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-cyan-600"></div>
                </div>

                <!-- Content -->
                <div id="modalContent" class="hidden space-y-4">
                    <!-- Loan Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <i class='bx bx-user'></i>
                                Peminjam
                            </label>
                            <p id="modalPeminjam" class="text-gray-800 font-semibold mt-1"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <i class='bx bx-info-circle'></i>
                                Status
                            </label>
                            <p id="modalStatus" class="text-gray-800 font-semibold mt-1"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <i class='bx bx-calendar'></i>
                                Tanggal Pinjam
                            </label>
                            <p id="modalTanggalPinjam" class="text-gray-800 font-semibold mt-1"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <i class='bx bx-calendar-check'></i>
                                Rencana Kembali
                            </label>
                            <p id="modalTanggalKembali" class="text-gray-800 font-semibold mt-1"></p>
                        </div>
                        <div class="col-span-2 bg-gray-50 rounded-lg p-3">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <i class='bx bx-check-shield'></i>
                                Disetujui Oleh
                            </label>
                            <p id="modalDisetujui" class="text-gray-800 font-semibold mt-1"></p>
                        </div>
                    </div>

                    <!-- Tools Table -->
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class='bx bx-package text-cyan-600'></i>
                            Daftar Alat yang Dipinjam
                        </h3>
                        <div class="shadow-md rounded-lg overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Kode</th>
                                        <th class="px-4 py-2 text-left">Nama Alat</th>
                                        <th class="px-4 py-2 text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="modalToolsTable" class="divide-y">
                                    <!-- Tools will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-between">
                @if (auth()->user()->role === 'petugas')
                    <a id="printButton" href="{{ route('peminjaman.print', '__ID__') }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                        <i class='bx bx-printer'></i>
                        Print
                    </a>
                @else
                    <div></div>
                @endif

                <button onclick="closeDetailModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Tutup
                </button>
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

    <script>
        // Open Detail Modal and Fetch Data
        function openDetailModal(peminjamanId) {
            const modal = document.getElementById('detailModal');
            const loading = document.getElementById('modalLoading');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            loading.classList.remove('hidden');
            content.classList.add('hidden');

            fetch(`/peminjaman/${peminjamanId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalPeminjam').textContent = data.peminjam;
                    document.getElementById('modalStatus').textContent = data.status;
                    document.getElementById('modalTanggalPinjam').textContent = data.tanggal_pinjam;
                    document.getElementById('modalTanggalKembali').textContent = data.tanggal_kembali_rencana;
                    document.getElementById('modalDisetujui').textContent = data.disetujui_oleh;

                    const toolsTable = document.getElementById('modalToolsTable');
                    toolsTable.innerHTML = '';

                    if (data.details && data.details.length > 0) {
                        data.details.forEach(detail => {
                            const row = `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-mono text-xs">${detail.kode_alat}</td>
                                <td class="px-4 py-2">${detail.nama_alat}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        ${detail.jumlah}
                                    </span>
                                </td>
                            </tr>
                        `;
                            toolsTable.innerHTML += row;
                        });
                    }

                    loading.classList.add('hidden');
                    content.classList.remove('hidden');

                    const printBtn = document.getElementById('printButton');
                    if (printBtn) {
                        printBtn.href = printBtn.href.replace('__ID__', peminjamanId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loading.classList.add('hidden');
                    const errorDiv = document.createElement('p');
                    errorDiv.className = 'text-red-600 text-center';
                    errorDiv.textContent = 'Gagal memuat data. Silakan coba lagi.';
                    document.getElementById('modalContent').innerHTML = '';
                    document.getElementById('modalContent').appendChild(errorDiv);
                    document.getElementById('modalContent').classList.remove('hidden');
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
@endsection
