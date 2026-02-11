<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\PeminjamDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware(['auth', 'role:admin,peminjam'])->group(function () {

    Route::get('/alat', [AlatController::class, 'index'])
        ->name('alat.index');

    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['create', 'store']);

        // Buat pengembalian
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])
        ->name('pengembalian.create');

    Route::post('/pengembalian', [PengembalianController::class, 'store'])
        ->name('pengembalian.store');

    Route::get('/pengembalian/edit/{id}', [PengembalianController::class, 'edit'])
        ->name('pengembalian.edit');

    Route::put('/pengembalian/{id}', [PengembalianController::class, 'update'])
        ->name('pengembalian.update');
});

Route::middleware(['auth', 'role:peminjam'])->group(function () {

    Route::get('/dashboard-peminjam', [PeminjamDashboardController::class, 'index'])
        ->name('peminjam.dashboard');

});

/*
|--------------------------------------------------------------------------
| Auth Routes (ALL ROLES)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Monitoring peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    // Detail peminjaman (modal)
    Route::get('/peminjaman/{id}/detail', [PeminjamanController::class, 'showDetail'])
        ->name('peminjaman.detail');

    // Pengembalian (LIHAT DATA)
    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian.index');

    Route::get('/pengembalian/{id}', [PengembalianController::class, 'show'])
        ->name('pengembalian.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Master Data
    Route::resource('users', UserController::class);
    Route::resource('alat', AlatController::class)->except(['index']);
    Route::resource('kategori', KategoriController::class);

    // Admin only
    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['edit', 'update', 'destroy']);

    // HAPUS pengembalian (admin saja)
    Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])
        ->name('pengembalian.destroy');

    // Log aktivitas
    Route::get('/logAktivitas', [LogAktivitasController::class, 'index'])
        ->name('logAktivitas.index');
});

/*
|--------------------------------------------------------------------------
| Petugas Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/dashboard-petugas', [PetugasDashboardController::class, 'index'])
        ->name('petugas.dashboard');

    // Approve / Reject
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])
        ->name('peminjaman.approve');

    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])
        ->name('peminjaman.reject');

    // Print laporan
    Route::get('/peminjaman/{id}/print', [PeminjamanController::class, 'print'])
        ->name('peminjaman.print');
});