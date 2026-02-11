<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{

    /**
     * =========================
     * ADMIN / PETUGAS
     * =========================
     * Melihat semua peminjaman
     */
    public function index() 
    {
        $allData = Peminjaman::select('status')->get();

        $query = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->latest();
        
        if (Auth::user()->role === 'peminjam') {
            $query->where('user_id', Auth::id());
        }

        $peminjaman = $query->paginate(5);

        return view('peminjaman.index', compact('peminjaman', 'allData'));
    }

    /**
     * =========================
     * PEMINJAM
     * =========================
     * Form pengajuan peminjaman
     */
    public function create()
    {
        $alat = Alat::where('stok', '>', 0)
            ->orderBy('nama_alat', 'asc')
            ->get();

        return view('peminjaman.create', compact('alat'));
    }

    /**
     * =========================
     * PEMINJAM
     * =========================
     * Simpan pengajuan peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali_rencana'  => 'required|date|after_or_equal:tanggal_pinjam',
            'alat_id'          => 'required|array',
            'jumlah'           => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $peminjaman = Peminjaman::create([
                'user_id'         => Auth::id(),
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status'          => 'menunggu',
            ]);

            foreach ($request->alat_id as $alatId) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id'       => $alatId,
                    'jumlah'        => $request->jumlah[$alatId],
                ]);
            }

            LogAktivitas::create([
                'user_id'  => Auth::id(),
                'aktivitas' => 'Mengajukan peminjaman',
            ]);
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim');
    }

    /**
     * =========================
     * PETUGAS
     * =========================
     * Menyetujui peminjaman
     */
    public function approve($id)
    {
        DB::transaction(function () use ($id, &$error) {

            $peminjaman = Peminjaman::with('detailPeminjaman.alat')
                ->lockForUpdate()
                ->findOrFail($id);

            // ❌ SUDAH DIPROSES
            if ($peminjaman->status !== 'menunggu') {
                $error = 'Peminjaman sudah diproses sebelumnya';
                return;
            }

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = $detail->alat;

                if ($alat->stok < $detail->jumlah) {
                    $error = 'Stok alat tidak mencukupi';
                    return;
                }
            }

            $peminjaman->update([
                'status' => 'disetujui',
                'disetujui_oleh' => Auth::id(),
            ]);

            LogAktivitas::create([
                'user_id'  => Auth::id(),
                'aktivitas' => 'Menyetujui peminjaman ID ' . $peminjaman->id,
            ]);
        });

        if (isset($error)) {
            return back()->with('error', $error);
        }

        return back()->with('success', 'Peminjaman berhasil disetujui');
    }

    /**
     * =========================
     * PETUGAS
     * =========================
     * Menolak peminjaman
     */
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman sudah diproses sebelumnya');
        }

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        LogAktivitas::create([
            'user_id'  => Auth::id(),
            'aktivitas' => 'Menolak peminjaman ID ' . $peminjaman->id,
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')->findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman tidak dapat diedit');
        }

        $alat = Alat::where('stok', '>', 0)
            ->orderBy('nama_alat', 'asc')
            ->get();

        return view('peminjaman.edit', compact('peminjaman', 'alat'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')
            ->findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman tidak dapat diubah');
        }

        $request->validate([
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
            'alat_id'         => 'required|array',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {

            // ========================
            // 1️⃣ DATA LAMA
            // ========================
            $oldDetails = $peminjaman->detailPeminjaman
                ->pluck('jumlah', 'alat_id'); // [alat_id => jumlah]

            // ========================
            // 2️⃣ DATA BARU
            // ========================
            $newAlatIds = $request->alat_id;
            $newDetails = collect($request->jumlah)
                ->only($newAlatIds); // [alat_id => jumlah]

            // ========================
            // 3️⃣ ANALISIS PERUBAHAN
            // ========================
            $alatDitambah = collect($newAlatIds)
                ->diff($oldDetails->keys());

            $alatDihapus = $oldDetails->keys()
                ->diff($newAlatIds);

            // ========================
            // 4️⃣ UPDATE HEADER
            // ========================
            $peminjaman->update([
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            ]);

            // ========================
            // 5️⃣ REFRESH DETAIL
            // ========================
            $peminjaman->detailPeminjaman()->delete();

            foreach ($newDetails as $alatId => $jumlah) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id'       => $alatId,
                    'jumlah'        => $jumlah,
                ]);
            }

            // ========================
            // 6️⃣ LOG AKTIVITAS
            // ========================
            LogAktivitas::create([
                'user_id'   => Auth::id(),
                'aktivitas' => 'Mengubah data peminjaman ID ' . $peminjaman->id,
            ]);

            foreach ($alatDitambah as $alatId) {
                LogAktivitas::create([
                    'user_id'   => Auth::id(),
                    'aktivitas' => 'Menambahkan alat ID ' . $alatId .
                        ' ke peminjaman ID ' . $peminjaman->id,
                ]);
            }

            foreach ($alatDihapus as $alatId) {
                LogAktivitas::create([
                    'user_id'   => Auth::id(),
                    'aktivitas' => 'Menghapus alat ID ' . $alatId .
                        ' dari peminjaman ID ' . $peminjaman->id,
                ]);
            }
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')
            ->findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman tidak dapat dihapus');
        }

        DB::transaction(function () use ($peminjaman) {

            $peminjaman->detailPeminjaman()->delete();
            $peminjaman->delete();

            LogAktivitas::create([
                'user_id'   => Auth::id(),
                'aktivitas' => 'Menghapus peminjaman ID ' . $peminjaman->id,
            ]);
        });

        return back()->with('success', 'Peminjaman berhasil dihapus');
    }

    public function showDetail($id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat', 'petugas'])
            ->findOrFail($id);

        return response()->json([
            'id' => $peminjaman->id,
            'peminjam' => $peminjaman->user->name,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
            'tanggal_kembali_rencana' => $peminjaman->tanggal_kembali_rencana,
            'status' => ucfirst($peminjaman->status),
            'disetujui_oleh' => $peminjaman->petugas ? $peminjaman->petugas->name : '-',
            'details' => $peminjaman->detailPeminjaman->map(function ($detail) {
                return [
                    'kode_alat' => $detail->alat->kode_alat,
                    'nama_alat' => $detail->alat->nama_alat,
                    'jumlah' => $detail->jumlah,
                ];
            })->toArray(),
        ]);
    }

    public function print($id)
    {
        // HANYA PETUGAS
        if (Auth::user()->role !== 'petugas') {
            abort(403);
        }

        $peminjaman = Peminjaman::with([
            'user',
            'petugas',
            'detailPeminjaman.alat'
        ])->findOrFail($id);

        return view('peminjaman.print', compact('peminjaman'));
    }
}
