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
                                    class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-cart-add text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Ajukan Peminjaman</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Pilih alat yang ingin dipinjam dan isi tanggal peminjaman</p>
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

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <!-- Informasi Peminjaman Card -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-calendar text-cyan-600'></i>
                                Informasi Peminjaman
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class='bx bx-calendar-plus text-gray-400'></i>
                                        Tanggal Pinjam
                                    </label>
                                    <input type="date" name="tanggal_pinjam"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 @error('tanggal_pinjam') border-red-500 @enderror"
                                        value="{{ old('tanggal_pinjam') }}" required>
                                    @error('tanggal_pinjam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class='bx bx-calendar-check text-gray-400'></i>
                                        Tanggal Rencana Kembali
                                    </label>
                                    <input type="date" name="tanggal_kembali_rencana"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 @error('tanggal_kembali_rencana') border-red-500 @enderror"
                                        value="{{ old('tanggal_kembali_rencana') }}" required>
                                    @error('tanggal_kembali_rencana')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alat Card -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-package text-cyan-600'></i>
                                Daftar Alat
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Centang alat yang ingin dipinjam, lalu isi jumlahnya</p>
                        </div>

                        <!-- Search Tool -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="relative">
                                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl'></i>
                                <input type="text" id="toolSearch" placeholder="Cari alat berdasarkan nama atau kode..."
                                    class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Tools Table -->
                        <div class=" max-h-96 overflow-y-auto">
                            <table class="w-full" id="toolsTable">
                                <thead class="bg-gray-50 border-b sticky top-0 shadow border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left">
                                            <input type="checkbox" id="selectAll"
                                                class="h-4 w-4 cursor-pointer rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama
                                            Alat</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Stok
                                            Tersedia</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                            Jumlah Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($alat as $item)
                                        <tr class="hover:bg-gray-50 transition-colors tool-row"
                                            data-name="{{ strtolower($item->nama_alat) }}"
                                            data-code="{{ strtolower($item->kode_alat) }}">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" name="alat_id[]" value="{{ $item->id }}"
                                                    class="itemCheckbox h-4 w-4 cursor-pointer rounded border-gray-300 text-cyan-600 focus:ring-cyan-500"
                                                    onchange="toggleQuantityInput(this)">
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $item->kode_alat }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center text-white">
                                                        <i class='bx bx-box text-sm'></i>
                                                    </div>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $item->nama_alat }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                    <i class='bx bxs-package text-sm'></i>
                                                    {{ $item->stok }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <input type="number"
                                                    class="quantityInput w-24 border border-gray-300 rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                    name="jumlah[{{ $item->id }}]" min="1"
                                                    max="{{ $item->stok }}" placeholder="0" disabled
                                                    onchange="validateQuantity(this)"
                                                    @error("jumlah.$item->id") is-invalid @enderror>
                                                @error("jumlah.$item->id")
                                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                        <i class='bx bx-box text-4xl text-gray-400'></i>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada alat
                                                        tersedia</h3>
                                                    <p class="text-gray-500 text-sm">Belum ada alat yang dapat dipinjam</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <a href="{{ route('peminjaman.index') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                            <i class='bx bx-x text-xl'></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" onclick="return validateForm()"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class='bx bx-send text-xl'></i>
                            <span>Ajukan Peminjaman</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column - Info -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Info Card -->
                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-cyan-900">Informasi Penting</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-cyan-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-cyan-600 text-lg shrink-0'></i>
                            <span>Pilih minimal 1 alat untuk dipinjam</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-cyan-600 text-lg shrink-0'></i>
                            <span>Pastikan jumlah tidak melebihi stok tersedia</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-cyan-600 text-lg shrink-0'></i>
                            <span>Tanggal kembali harus setelah tanggal pinjam</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-cyan-600 text-lg shrink-0'></i>
                            <span>Pengajuan akan menunggu persetujuan petugas</span>
                        </li>
                    </ul>
                </div>

                <!-- Status Flow -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-git-branch text-purple-600'></i>
                        Alur Peminjaman
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-yellow-700 font-bold text-sm">1</span>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900 text-sm">Ajukan</h5>
                                <p class="text-xs text-gray-600">Isi form dan kirim pengajuan</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-blue-700 font-bold text-sm">2</span>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900 text-sm">Disetujui</h5>
                                <p class="text-xs text-gray-600">Menunggu persetujuan petugas</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-green-700 font-bold text-sm">3</span>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900 text-sm">Pinjam & Kembali</h5>
                                <p class="text-xs text-gray-600">Ambil alat dan kembalikan tepat waktu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-900 mb-2">Tips</h4>
                            <p class="text-xs text-amber-800 leading-relaxed">
                                Ajukan peminjaman minimal 1 hari sebelum tanggal pinjam untuk memastikan persetujuan tepat
                                waktu.
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

    <script>
        // Select All checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.itemCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                toggleQuantityInput(checkbox);
            });
        });

        // Toggle quantity input
        function toggleQuantityInput(checkbox) {
            const row = checkbox.closest('tr');
            const input = row.querySelector('.quantityInput');

            if (checkbox.checked) {
                input.disabled = false;
                input.focus();
            } else {
                input.disabled = true;
                input.value = '';
            }
        }

        // Validate quantity
        function validateQuantity(input) {
            const max = parseInt(input.max);
            const value = parseInt(input.value) || 0;

            if (value > max) {
                alert(`Stok hanya tersedia ${max} unit`);
                input.value = max;
                return;
            }

            if (value < 0) {
                alert('Jumlah tidak boleh kurang dari 0');
                input.value = 0;
            }
        }

        // Form validation
        function validateForm() {
            const checkedItems = document.querySelectorAll('.itemCheckbox:checked').length;

            if (checkedItems === 0) {
                alert('Pilih minimal 1 alat untuk dipinjam');
                return false;
            }

            // Check if quantity is filled for all checked items
            let isValid = true;
            document.querySelectorAll('.itemCheckbox:checked').forEach(checkbox => {
                const row = checkbox.closest('tr');
                const input = row.querySelector('.quantityInput');
                const value = parseInt(input.value) || 0;

                if (value <= 0) {
                    alert('Isi jumlah untuk setiap alat yang dipilih');
                    input.focus();
                    isValid = false;
                    return;
                }
            });

            return isValid;
        }

        // Search functionality
        document.getElementById('toolSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.tool-row');

            rows.forEach(row => {
                const name = row.dataset.name;
                const code = row.dataset.code;

                if (name.includes(searchTerm) || code.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
