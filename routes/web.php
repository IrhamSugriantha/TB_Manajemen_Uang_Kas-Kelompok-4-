<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Bendahara Routes
Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Bendahara\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('mahasiswa', App\Http\Controllers\Bendahara\MahasiswaController::class);
    Route::resource('kas-bulanan', App\Http\Controllers\Bendahara\KasBulananController::class);
    Route::resource('pembayaran', App\Http\Controllers\Bendahara\PembayaranController::class);
    Route::resource('pengeluaran', App\Http\Controllers\Bendahara\PengeluaranController::class);
    Route::get('/laporan', [App\Http\Controllers\Bendahara\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [App\Http\Controllers\Bendahara\LaporanController::class, 'downloadPdf'])->name('laporan.pdf');
});

// Anggota Routes
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Anggota\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/status-kas', [App\Http\Controllers\Anggota\DashboardController::class, 'status'])->name('status-kas');
    Route::get('/riwayat', [App\Http\Controllers\Anggota\DashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/transparansi', [App\Http\Controllers\Anggota\DashboardController::class, 'transparansi'])->name('transparansi');
});

// Auth Shared Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/password', [\App\Http\Controllers\ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
