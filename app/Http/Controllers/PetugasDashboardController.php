<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $pendingApproval = Peminjaman::where('status', 'menunggu persetujuan')->count();
        $activeBorrowings = Peminjaman::where('status', 'disetujui')->count();
        $completedToday = Peminjaman::where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->count();
        $totalReturns = Pengembalian::count();
        
        // Peminjaman yang perlu disetujui
        $peminjamanMenunggu = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'menunggu persetujuan')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Peminjaman aktif (disetujui) yang perlu dipantau
        $peminjamanAktif = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'disetujui')
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->limit(10)
            ->get();
        
        // Pengembalian terbaru
        $pengembalianTerbaru = Pengembalian::with(['peminjaman.user', 'detailPengembalian.alat'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Peminjaman yang mendekati jatuh tempo (dalam 3 hari)
        $mendekatiJatuhTempo = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'disetujui')
            ->whereBetween('tanggal_kembali_rencana', [now(), now()->addDays(3)])
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->limit(5)
            ->get();
        
        // Peminjaman yang sudah lewat jatuh tempo
        $terlambat = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'disetujui')
            ->where('tanggal_kembali_rencana', '<', now())
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->limit(5)
            ->get();
        
        // Chart: Peminjaman per status (untuk pie chart)
        $statusChart = [
            'menunggu' => Peminjaman::where('status', 'menunggu persetujuan')->count(),
            'disetujui' => Peminjaman::where('status', 'disetujui')->count(),
            'selesai' => Peminjaman::where('status', 'selesai')->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];
        
        return view('petugas.dashboard', compact(
            'pendingApproval',
            'activeBorrowings',
            'completedToday',
            'totalReturns',
            'peminjamanMenunggu',
            'peminjamanAktif',
            'pengembalianTerbaru',
            'mendekatiJatuhTempo',
            'terlambat',
            'statusChart'
        ));
    }
}