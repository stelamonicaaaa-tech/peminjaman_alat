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
                                    <i class='bx bxs-edit text-white text-xl'></i>
                                </div>
                                <h1 class="text-3xl font-bold">Edit Pengembalian</h1>
                            </div>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Ubah detail pengembalian alat yang belum selesai</p>
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

                <!-- Info Block -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i class='bx bx-info-circle text-blue-600 text-xl shrink-0'></i>
                        <p class="text-sm text-blue-800">
                            Peminjam masih memiliki alat yang belum dikembalikan. Anda dapat menambahkan pengembalian
                            selanjutnya di sini.
                        </p>
                    </div>
                </div>

                <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Peminjaman Card -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-info-square text-green-600'></i>
                                Informasi Peminjaman
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-start gap-3">
                                        <i class='bx bx-user text-gray-400 text-xl'></i>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Peminjam</p>
                                            <p class="font-semibold text-gray-900">{{ $peminjaman->user->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-start gap-3">
                                        <i class='bx bx-hash text-gray-400 text-xl'></i>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">ID Peminjaman</p>
                                            <p class="font-semibold text-gray-900">#{{ $peminjaman->id }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-start gap-3">
                                        <i class='bx bx-calendar text-gray-400 text-xl'></i>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Tanggal Pinjam</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alat Card -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class='bx bx-package text-green-600'></i>
                                Alat yang Dapat Dikembalikan
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Centang alat yang ingin dikembalikan sekarang, lalu isi
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
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama
                                            Alat</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                            Dipinjam</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                            Sudah Dikembalikan</th>
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                            Kembalikan Sekarang</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($peminjaman->detailPeminjaman as $detail)
                                        @php
                                            // Hitung total sudah dikembalikan dari pengembalian lain (exclude current)
                                            $sudahDikembalikanSebelumnya = \App\Models\DetailPengembalian::where(
                                                'alat_id',
                                                $detail->alat_id,
                                            )
                                                ->whereIn(
                                                    'pengembalian_id',
                                                    \App\Models\Pengembalian::where('peminjaman_id', $peminjaman->id)
                                                        ->where('id', '!=', $pengembalian->id)
                                                        ->pluck('id'),
                                                )
                                                ->sum('jumlah');

                                            $sisa = $detail->jumlah - $sudahDikembalikanSebelumnya;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors return-row">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" name="alat_id[]" value="{{ $detail->alat_id }}"
                                                    class="returnCheckbox h-4 w-4 cursor-pointer rounded border-gray-300 text-green-600 focus:ring-green-500"
                                                    {{ $detail->current_return > 0 ? 'checked' : '' }}
                                                    onchange="toggleReturnInput(this)">
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
                                                        <p class="text-xs text-gray-500">Kode:
                                                            {{ $detail->alat->kode_alat }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                    <i class='bx bxs-package text-sm'></i>
                                                    {{ $detail->jumlah }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                                    <i class='bx bx-check-circle text-sm'></i>
                                                    {{ $sudahDikembalikanSebelumnya }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-6 py-4 text-center">
                                                <input type="number"
                                                    class="returnInput w-24 border border-gray-300 rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                    name="jumlah[{{ $detail->alat_id }}]" min="0"
                                                    max="{{ $sisa }}" value="{{ $detail->current_return }}"
                                                    placeholder="0" {{ $detail->current_return > 0 ? '' : 'disabled' }}
                                                    onchange="validateQuantity(this, {{ $sisa }})"
                                                    @error("jumlah.$detail->alat_id") is-invalid @enderror>
                                                @error("jumlah.$detail->alat_id")
                                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                        <i class='bx bx-box text-4xl text-gray-400'></i>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada alat
                                                        tersedia</h3>
                                                    <p class="text-gray-500 text-sm">Tidak ada alat yang dapat dikembalikan
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
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
                                    class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:border-green-500 hover:bg-green-50 {{ old('status_kondisi', $pengembalian->status_kondisi) === 'baik' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status_kondisi" value="baik"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500"
                                        {{ old('status_kondisi', $pengembalian->status_kondisi) === 'baik' ? 'checked' : '' }}>
                                    <span class="ml-3 flex items-center gap-2">
                                        <i class='bx bx-check-circle text-green-600 text-xl'></i>
                                        <span class="font-semibold text-gray-900">Baik</span>
                                    </span>
                                </label>

                                <label
                                    class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:border-yellow-500 hover:bg-yellow-50 {{ old('status_kondisi', $pengembalian->status_kondisi) === 'rusak ringan' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status_kondisi" value="rusak ringan"
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500"
                                        {{ old('status_kondisi', $pengembalian->status_kondisi) === 'rusak ringan' ? 'checked' : '' }}>
                                    <span class="ml-3 flex items-center gap-2">
                                        <i class='bx bx-error text-yellow-600 text-xl'></i>
                                        <span class="font-semibold text-gray-900">Rusak Ringan</span>
                                    </span>
                                </label>

                                <label
                                    class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:border-red-500 hover:bg-red-50 {{ old('status_kondisi', $pengembalian->status_kondisi) === 'rusak berat' ? 'border-red-500 bg-red-50' : 'border-gray-200' }}">
                                    <input type="radio" name="status_kondisi" value="rusak berat"
                                        class="h-4 w-4 text-red-600 focus:ring-red-500"
                                        {{ old('status_kondisi', $pengembalian->status_kondisi) === 'rusak berat' ? 'checked' : '' }}>
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
                            <i class='bx bx-save text-xl'></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column - Info -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Warning Card -->
                <div
                    class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-error text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-900">Perhatian!</h4>
                        </div>
                    </div>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Perubahan akan langsung tersimpan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Pastikan jumlah yang dikembalikan sesuai</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class='bx bx-check text-green-600 text-lg shrink-0'></i>
                            <span>Pilih minimal 1 alat untuk dikembalikan</span>
                        </li>
                    </ul>
                </div>

                <!-- Current Status -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class='bx bx-info-circle text-indigo-600'></i>
                        Status Pengembalian
                    </h4>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center gap-2 mb-1">
                                <i class='bx bx-check-circle text-green-600 text-lg'></i>
                                <h5 class="font-semibold text-green-900 text-sm">Status Kondisi</h5>
                            </div>
                            <p class="text-xs text-green-700">{{ ucfirst($pengembalian->status_kondisi) }}</p>
                        </div>

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

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                            <i class='bx bx-bulb text-white text-xl'></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Pastikan kondisi alat sudah diperiksa dengan teliti sebelum menyimpan perubahan.
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
            const checkboxes = document.querySelectorAll('.returnCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                toggleReturnInput(checkbox);
            });
        });

        // Toggle return input
        function toggleReturnInput(checkbox) {
            const row = checkbox.closest('tr');
            const input = row.querySelector('.returnInput');

            if (checkbox.checked) {
                input.disabled = false;
                input.focus();
                if (!input.value || input.value === '0') {
                    // Set default value to max available
                    input.value = input.max;
                }
            } else {
                input.disabled = true;
                input.value = 0;
            }
        }

        // Validate quantity
        function validateQuantity(input, maxSisa) {
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
            const checkedItems = document.querySelectorAll('.returnCheckbox:checked').length;

            if (checkedItems === 0) {
                alert('Pilih minimal 1 alat untuk dikembalikan');
                return false;
            }

            // Check if quantity is filled for all checked items
            let isValid = true;
            document.querySelectorAll('.returnCheckbox:checked').forEach(checkbox => {
                const row = checkbox.closest('tr');
                const input = row.querySelector('.returnInput');
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
    </script>
@endsection