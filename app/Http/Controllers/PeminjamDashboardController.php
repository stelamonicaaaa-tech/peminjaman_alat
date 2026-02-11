<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Statistics
        $totalPeminjaman = Peminjaman::where('user_id', $userId)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->count();
        $peminjamanSelesai = Peminjaman::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();
        $peminjamanMenunggu = Peminjaman::where('user_id', $userId)
            ->where('status', 'menunggu persetujuan')
            ->count();
        
        // Peminjaman user saat ini
        $myPeminjaman = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu persetujuan', 'disetujui'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Riwayat peminjaman
        $riwayatPeminjaman = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', $userId)
            ->whereIn('status', ['selesai', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        // Alat tersedia (stok > 0)
        $alatTersedia = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->where('kondisi', '!=', 'rusak berat')
            ->orderBy('nama_alat', 'asc')
            ->limit(10)
            ->get();
        
        // Kategori alat
        $kategoriList = Kategori::withCount('alat')->get();
        
        // Peminjaman yang perlu dikembalikan segera (dalam 2 hari)
        $perluDikembalikan = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->whereBetween('tanggal_kembali_rencana', [now(), now()->addDays(2)])
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->get();
        
        // Peminjaman yang terlambat
        $peminjamanTerlambat = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('tanggal_kembali_rencana', '<', now())
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->get();
        
        return view('peminjam.dashboard', compact(
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanSelesai',
            'peminjamanMenunggu',
            'myPeminjaman',
            'riwayatPeminjaman',
            'alatTersedia',
            'kategoriList',
            'perluDikembalikan',
            'peminjamanTerlambat'
        ));
    }
}