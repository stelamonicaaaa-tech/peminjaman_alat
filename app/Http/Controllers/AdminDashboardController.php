<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalUsers = User::count();
        $totalAlat = Alat::sum('stok');
        $totalKategori = Kategori::count();
        $totalPeminjaman = Peminjaman::count();
        
        // Peminjaman statistics by status
        $peminjamanMenunggu = Peminjaman::where('status', 'menunggu persetujuan')->count();
        $peminjamanDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $peminjamanSelesai = Peminjaman::where('status', 'selesai')->count();
        $peminjamanDitolak = Peminjaman::where('status', 'ditolak')->count();
        
        // Recent activities
        $recentActivities = LogAktivitas::with('user')
            ->orderBy('waktu', 'desc')
            ->limit(10)
            ->get();
        
        // Peminjaman pending approval
        $pendingPeminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->where('status', 'menunggu persetujuan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Alat dengan stok rendah (kurang dari 10)
        $lowStockAlat = Alat::with('kategori')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();
        
        // Chart data: Peminjaman per bulan (6 bulan terakhir)
        $peminjamanChart = Peminjaman::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Top borrowed items
        $topBorrowedItems = DB::table('detail_peminjaman')
            ->select('alat_id', DB::raw('SUM(jumlah) as total_borrowed'))
            ->groupBy('alat_id')
            ->orderBy('total_borrowed', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $alat = Alat::find($item->alat_id);
                return [
                    'nama_alat' => $alat->nama_alat ?? 'Unknown',
                    'kode_alat' => $alat->kode_alat ?? 'Unknown',
                    'total_borrowed' => $item->total_borrowed
                ];
            });
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAlat',
            'totalKategori',
            'totalPeminjaman',
            'peminjamanMenunggu',
            'peminjamanDisetujui',
            'peminjamanSelesai',
            'peminjamanDitolak',
            'recentActivities',
            'pendingPeminjaman',
            'lowStockAlat',
            'peminjamanChart',
            'topBorrowedItems'
        ));
    }
}