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
                                    class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-package text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Pengembalian Alat</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Pilih alat yang ingin dikembalikan dan isi informasi
                            kondisinya</p>
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

                @if ($peminjaman->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <i class='bx bx-package text-5xl text-blue-500'></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Peminjaman Aktif</h3>
                            <p class="text-gray-500 mb-6">Tidak ada peminjaman yang sedang aktif untuk dikembalikan</p>
                            <a href="{{ route('peminjaman.index') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class='bx bx-list-ul text-xl'></i>
                                <span>Lihat Daftar Peminjaman</span>
                            </a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('pengembalian.store') }}" method="POST" id="returnForm">
                        @csrf

                        <!-- Select Peminjaman -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Peminjaman yang akan dikembalikan
                            </label>
                            <select name="peminjaman_id" id="peminjamanSelect" required
                                class="w-full appearance-none rounded-xl border border-gray-200 
                                    bg-gradient-to-r from-white to-gray-50
                                    px-4 py-3 pr-10 text-sm font-medium text-gray-800
                                    shadow-sm transition-all duration-200
                                    focus:border-green-500 focus:ring-2 focus:ring-green-500
                                    hover:border-green-400">
                                @foreach ($peminjaman as $pinjam)
                                    <option value="{{ $pinjam->id }}">
                                        Peminjaman #{{ $pinjam->id }} • {{ $pinjam->created_at->format('d M Y H:i') }}
                                        • {{ $pinjam->detailPeminjaman->count() }} item
                                    </option>
                                @endforeach
                            </select>
                            @error('peminjaman_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Daftar Alat Card -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class='bx bx-package text-green-600'></i>
                                    Daftar Alat yang Dipinjam
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Centang alat yang ingin dikembalikan, lalu isi
                                    jumlahnya</p>
                            </div>

                            <!-- Tools Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-4 text-left">
                                                <input type="checkbox" id="selectAll"
                                                    class="h-4 w-4 cursor-pointer rounded border-gray-300 text-green-600 focus:ring-green-500">
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                                Nama Alat</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                                Kode</th>
                                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                                Masih Dipinjam</th>
                                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                                Pengembalian Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($peminjaman as $pinjam)
                                            @foreach ($pinjam->detailPeminjaman as $detail)
                                                <tr class="hover:bg-gray-50 transition-colors"
                                                    data-peminjaman-id="{{ $pinjam->id }}">
                                                    <td class="px-6 py-4">
                                                        <input type="checkbox"
                                                            class="itemCheckbox h-4 w-4 cursor-pointer rounded border-gray-300 text-green-600 focus:ring-green-500"
                                                            name="alat_id[]" value="{{ $detail->alat_id }}"
                                                            onchange="toggleQuantityInput(this)">
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white">
                                                                <i class='bx bx-box text-sm'></i>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="text-sm font-medium text-gray-900">{{ $detail->alat->nama_alat }}</span>
                                                                <p class="text-xs text-gray-500">ID: {{ $detail->alat_id }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                                            {{ $detail->alat->kode_alat }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                            <i class='bx bxs-package text-sm'></i>
                                                            {{ $detail->sisa }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <input type="number"
                                                            class="quantityInput w-24 border border-gray-300 rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                            name="jumlah[{{ $detail->alat_id }}]" min="1"
                                                            max="{{ $detail->sisa }}" placeholder="0" disabled
                                                            onchange="validateQuantity(this)"
                                                            @error("jumlah.$detail->alat_id") is-invalid @enderror>
                                                        @error("jumlah.$detail->alat_id")
                                                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Status Kondisi Card -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class='bx bx-check-shield text-green-600'></i>
                                    Status Kondisi Alat
                                </h2>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-green-50 rounded-xl cursor-pointer transition-all hover:border-green-600 hover:bg-green-100">
                                        <input type="radio" name="status_kondisi" value="baik"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-check-circle text-green-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Baik</span>
                                        </span>
                                    </label>

                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-amber-50 rounded-xl cursor-pointer transition-all hover:border-yellow-500 hover:bg-yellow-50">
                                        <input type="radio" name="status_kondisi" value="rusak ringan"
                                            class="h-4 w-4 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-error text-yellow-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Ringan</span>
                                        </span>
                                    </label>

                                    <label
                                        class="relative flex items-center p-4 border-2 border-gray-200 bg-red-50 rounded-xl cursor-pointer transition-all hover:border-red-500 hover:bg-red-50">
                                        <input type="radio" name="status_kondisi" value="rusak berat"
                                            class="h-4 w-4 text-red-600 focus:ring-red-500">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i class='bx bx-x-circle text-red-600 text-xl'></i>
                                            <span class="font-semibold text-gray-900">Rusak Berat</span>
                                        </span>
                                    </label>
                                </div>
                                @error('status_kondisi')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('pengembalian.index') }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200 border border-gray-300">
                                <i class='bx bx-x text-xl'></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" onclick="return validateForm()"
                                class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class='bx bx-check-circle text-xl'></i>
                                <span>Proses Pengembalian</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Right Column - Info -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Instructions Card -->
                <div
                    class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-900">Petunjuk Pengembalian</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Pilih alat yang ingin dikembalikan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Isi jumlah yang dikembalikan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Pilih kondisi alat dengan teliti</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Klik "Proses Pengembalian" untuk menyimpan</span>
                        </li>
                    </ul>
                </div>

                <!-- Status Info -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-check-shield text-indigo-600'></i>
                        Status Kondisi
                    </h4>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center gap-2 mb-1">
                                <i class='bx bx-check-circle text-green-600 text-lg'></i>
                                <h5 class="font-semibold text-green-900 text-sm">Baik</h5>
                            </div>
                            <p class="text-xs text-green-700">Alat dalam kondisi normal tanpa kerusakan</p>
                        </div>

                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex items-center gap-2 mb-1">
                                <i class='bx bx-error text-yellow-600 text-lg'></i>
                                <h5 class="font-semibold text-yellow-900 text-sm">Rusak Ringan</h5>
                            </div>
                            <p class="text-xs text-yellow-700">Alat masih bisa digunakan dengan perbaikan kecil</p>
                        </div>

                        <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-center gap-2 mb-1">
                                <i class='bx bx-x-circle text-red-600 text-lg'></i>
                                <h5 class="font-semibold text-red-900 text-sm">Rusak Berat</h5>
                            </div>
                            <p class="text-xs text-red-700">Alat tidak dapat digunakan dan perlu perbaikan besar</p>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips Penting</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Periksa kondisi alat dengan teliti sebelum memproses pengembalian untuk menghindari
                                kesalahan pencatatan.
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
        document.getElementById('selectAll')?.addEventListener('change', function() {
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
                alert(`Jumlah tidak boleh melebihi ${max}`);
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
                alert('Pilih minimal 1 alat untuk dikembalikan');
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

        // Filter table by peminjaman_id
        document.getElementById('peminjamanSelect')?.addEventListener('change', function() {
            const selectedId = this.value;
            document.querySelectorAll('tr[data-peminjaman-id]').forEach(row => {
                row.style.display = row.dataset.peminjamanId === selectedId ? '' : 'none';
            });
            // Reset checkboxes and inputs
            document.querySelectorAll('.itemCheckbox').forEach(cb => {
                cb.checked = false;
                toggleQuantityInput(cb);
            });
        });
        // Trigger initial filter
        document.getElementById('peminjamanSelect')?.dispatchEvent(new Event('change'));
    </script>
@endsection
