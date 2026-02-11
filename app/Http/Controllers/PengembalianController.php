<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPengembalian;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar pengembalian
     * Admin & Petugas: lihat semua
     * Peminjam: lihat miliknya sendiri
     */
    public function index()
    {
        $query = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPeminjaman.alat'
        ])->latest();

        if (Auth::user()->role === 'peminjam') {
            $query->whereHas('peminjaman', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $pengembalian = $query->paginate(5);

        return view('pengembalian.index', compact('pengembalian'));
    }

    /**
     * Form create pengembalian
     * HANYA tampilkan alat yang dipinjam user login
     */
    public function create()
    {
        // Only peminjam can create their own returns, petugas/admin can create for anyone
        if (Auth::user()->role === 'peminjam') {
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')
                ->where('user_id', Auth::id())
                ->where('status', 'disetujui')
                ->get();
        } else {
            // Petugas/Admin bisa lihat semua peminjaman yang disetujui
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')
                ->where('status', 'disetujui')
                ->get();
        }

        foreach ($peminjaman as $pinjam) {
            foreach ($pinjam->detailPeminjaman as $detail) {

                $sudahDikembalikan = DetailPengembalian::where('alat_id', $detail->alat_id)
                    ->whereIn(
                        'pengembalian_id',
                        Pengembalian::where('peminjaman_id', $pinjam->id)->pluck('id')
                    )
                    ->sum('jumlah');

                // TAMBAHKAN ATTRIBUTE BARU (VIRTUAL)
                $detail->sisa = max(0, $detail->jumlah - $sudahDikembalikan);
            }

            // BUANG alat yang sisa = 0
            $pinjam->detailPeminjaman = $pinjam->detailPeminjaman
                ->filter(fn($d) => $d->sisa > 0)
                ->values();
        }

        // Filter hanya peminjaman yang masih punya alat
        $peminjaman = $peminjaman->filter(fn($p) => $p->detailPeminjaman->count() > 0)->values();

        return view('pengembalian.create', compact('peminjaman'));
    }

    /**
     * Simpan data pengembalian
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'alat_id' => 'required|array|min:1',
            'jumlah' => 'required|array',
            'status_kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        ], [
            'alat_id.required' => 'Pilih minimal 1 alat untuk dikembalikan',
            'alat_id.min' => 'Pilih minimal 1 alat untuk dikembalikan',
            'status_kondisi.required' => 'Status kondisi alat harus dipilih',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

                // Authorization: Peminjam hanya bisa return milik sendiri
                if (Auth::user()->role === 'peminjam' && $peminjaman->user_id !== Auth::id()) {
                    throw new \Exception('Anda tidak memiliki izin untuk membuat pengembalian ini');
                }

                $pengembalian = Pengembalian::create([
                    'peminjaman_id' => $peminjaman->id,
                    'tanggal_kembali' => now(),
                    'status_kondisi' => $request->status_kondisi,
                ]);

                $hasDetails = false;

                // Validate and insert return details
                foreach ($request->alat_id as $alatId) {
                    $jumlah = $request->jumlah[$alatId] ?? 0;

                    if ($jumlah <= 0) {
                        continue;
                    }

                    $hasDetails = true;

                    // Find detail peminjaman
                    $detailPeminjaman = $peminjaman->detailPeminjaman()
                        ->where('alat_id', $alatId)
                        ->first();

                    if (!$detailPeminjaman) {
                        throw new \Exception("Item dengan alat ID {$alatId} tidak ditemukan dalam peminjaman ini");
                    }

                    // Calculate remaining quantity
                    $sudahDikembalikan = DetailPengembalian::where('alat_id', $alatId)
                        ->whereIn(
                            'pengembalian_id',
                            Pengembalian::where('peminjaman_id', $peminjaman->id)->pluck('id')
                        )
                        ->sum('jumlah');

                    $sisa = $detailPeminjaman->jumlah - $sudahDikembalikan;

                    // Validate return quantity
                    if ($jumlah > $sisa) {
                        throw new \Exception(
                            "Jumlah pengembalian untuk {$detailPeminjaman->alat->nama_alat} " .
                                "melebihi sisa yang dapat dikembalikan ({$sisa})"
                        );
                    }

                    DetailPengembalian::create([
                        'pengembalian_id' => $pengembalian->id,
                        'alat_id' => $alatId,
                        'jumlah' => $jumlah,
                    ]);
                }

                if (!$hasDetails) {
                    throw new \Exception('Minimal satu alat dengan jumlah pengembalian lebih dari 0');
                }

                // Update peminjaman status
                $this->updatePeminjamanStatus($peminjaman->id);

                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Melakukan pengembalian untuk peminjaman ID ' . $peminjaman->id,
                ]);
            });

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil dicatat');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Detail pengembalian (opsional, jika mau pakai modal/detail page)
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPeminjaman.alat'
        ])->findOrFail($id);

        // Peminjam hanya boleh lihat miliknya
        if (
            $pengembalian->peminjaman->user_id !== Auth::id()
        ) {
            abort(403);
        }

        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Form edit pengembalian
     * Display return items with remaining quantities and existing return data
     */
    public function edit($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.detailPeminjaman.alat',
            'detailPengembalian'
        ])->findOrFail($id);

        // Authorization check: Peminjam hanya bisa edit miliknya sendiri, Admin & Petugas bisa semua
        if (
            Auth::user()->role === 'peminjam' &&
            $pengembalian->peminjaman->user_id !== Auth::id()
        ) {
            return back()->with('error', 'Tidak punya akses untuk mengedit pengembalian ini');
        }

        $peminjaman = $pengembalian->peminjaman;

        // Process detail peminjaman: add virtual attributes for sisa and current return quantity
        foreach ($peminjaman->detailPeminjaman as $detail) {
            // Calculate total returned from OTHER return records (exclude current editing record)
            $sudahDikembalikan = DetailPengembalian::where('alat_id', $detail->alat_id)
                ->whereIn(
                    'pengembalian_id',
                    Pengembalian::where('peminjaman_id', $peminjaman->id)
                        ->where('id', '!=', $id) // Exclude current return record
                        ->pluck('id')
                )
                ->sum('jumlah');

            // Sisa = borrowed - returned from OTHER records
            $detail->sisa = max(0, $detail->jumlah - $sudahDikembalikan);

            // Get current return amount from THIS return record
            $currentReturn = $pengembalian->detailPengembalian()
                ->where('alat_id', $detail->alat_id)
                ->first();

            $detail->current_return = $currentReturn ? $currentReturn->jumlah : 0;

            // Include item if it has remaining quantity OR if it's already in current return
            $detail->include = $detail->sisa > 0 || $detail->current_return > 0;
        }

        // Filter to show only items that should be displayed
        $peminjaman->detailPeminjaman = $peminjaman->detailPeminjaman
            ->filter(fn($d) => $d->include)
            ->values();

        return view('pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    /**
     * Update data pengembalian
     * Delete existing details and insert new ones based on user input
     * Use transaction to ensure data consistency
     */
    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::with('peminjaman.detailPeminjaman')->findOrFail($id);

        // Authorization check
        if (
            Auth::user()->role === 'peminjam' &&
            $pengembalian->peminjaman->user_id !== Auth::id()
        ) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah pengembalian ini');
        }

        // Validate input
        $request->validate([
            'alat_id' => 'required|array|min:1',
            'jumlah' => 'required|array',
            'status_kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        ], [
            'alat_id.required' => 'Pilih minimal 1 alat untuk dikembalikan',
            'alat_id.min' => 'Pilih minimal 1 alat untuk dikembalikan',
            'status_kondisi.required' => 'Status kondisi alat harus dipilih',
        ]);

        try {
            DB::transaction(function () use ($request, $pengembalian) {
                $peminjaman = $pengembalian->peminjaman;

                // Delete existing return details
                $pengembalian->detailPengembalian()->delete();

                $hasDetails = false;

                // Insert new return details based on user input
                foreach ($request->alat_id as $alatId) {
                    $jumlah = $request->jumlah[$alatId] ?? 0;

                    // Only insert if quantity > 0
                    if ($jumlah > 0) {
                        $hasDetails = true;

                        // Validate that return quantity doesn't exceed remaining borrowed quantity
                        $detail = $peminjaman->detailPeminjaman()
                            ->where('alat_id', $alatId)
                            ->first();

                        if (!$detail) {
                            throw new \Exception("Item dengan alat ID {$alatId} tidak ditemukan dalam peminjaman ini");
                        }

                        // Calculate remaining from OTHER returns
                        $sudahDikembalikan = DetailPengembalian::where('alat_id', $alatId)
                            ->whereIn(
                                'pengembalian_id',
                                Pengembalian::where('peminjaman_id', $peminjaman->id)
                                    ->where('id', '!=', $pengembalian->id)
                                    ->pluck('id')
                            )
                            ->sum('jumlah');

                        $sisa = $detail->jumlah - $sudahDikembalikan;

                        // Validate return quantity
                        if ($jumlah > $sisa) {
                            throw new \Exception(
                                "Jumlah pengembalian untuk {$detail->alat->nama_alat} " .
                                    "melebihi sisa yang dapat dikembalikan ({$sisa})"
                            );
                        }

                        DetailPengembalian::create([
                            'pengembalian_id' => $pengembalian->id,
                            'alat_id' => $alatId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }

                if (!$hasDetails) {
                    throw new \Exception('Minimal satu alat dengan jumlah pengembalian lebih dari 0');
                }

                // Update return record
                $pengembalian->update([
                    'tanggal_kembali' => now(),
                    'status_kondisi' => $request->status_kondisi,
                ]);

                // Update peminjaman status
                $this->updatePeminjamanStatus($peminjaman->id);

                // Log activity
                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Mengubah pengembalian ID ' . $pengembalian->id,
                ]);
            });

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Helper method: Update peminjaman status berdasarkan status pengembalian
     * 'selesai' jika semua alat sudah dikembalikan
     * 'disetujui' jika masih ada alat yang belum dikembalikan
     */
    private function updatePeminjamanStatus($peminjamanId)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')->findOrFail($peminjamanId);

        $semuaSudahKembali = true;

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $sudahDikembalikan = DetailPengembalian::where('alat_id', $detail->alat_id)
                ->whereIn(
                    'pengembalian_id',
                    Pengembalian::where('peminjaman_id', $peminjamanId)->pluck('id')
                )
                ->sum('jumlah');

            if ($sudahDikembalikan < $detail->jumlah) {
                $semuaSudahKembali = false;
                break;
            }
        }

        $peminjaman->update([
            'status' => $semuaSudahKembali ? 'selesai' : 'disetujui'
        ]);
    }

    /**
     * Hapus pengembalian (ADMIN SAJA)
     */
    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus data');
        }

        try {
            DB::transaction(function () use ($pengembalian) {
                $peminjamanId = $pengembalian->peminjaman_id;

                // Delete the return record
                $pengembalian->delete();

                // Update peminjaman status after deletion
                $this->updatePeminjamanStatus($peminjamanId);

                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Menghapus pengembalian ID ' . $pengembalian->id,
                ]);
            });

            return redirect()
                ->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
