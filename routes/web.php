<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\BasisPengetahuanController;
use App\Http\Controllers\KonsultasiController;

Route::get('/', function () {
    $penyakits = \App\Models\Penyakit::all();
    return view('welcome', compact('penyakits'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

use App\Http\Controllers\PasienController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Admin Riwayat Routes
    Route::get('/pasien/{pasien}/riwayat', [\App\Http\Controllers\AdminRiwayatController::class, 'index'])->name('admin.riwayat.index');
    Route::get('/riwayat/{riwayat}', [\App\Http\Controllers\AdminRiwayatController::class, 'show'])->name('admin.riwayat.show');
    
    Route::resource('penyakit', PenyakitController::class);
    Route::resource('gejala', GejalaController::class);
    Route::resource('basis_pengetahuan', BasisPengetahuanController::class);
    Route::resource('pasien', PasienController::class);
});

// Global Logout Route (accessible by both Admin and Pasien)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Auth Pasien Routes
// Auth Pasien Routes (Register only, login is merged to main /login)
Route::middleware('guest:pasien,web')->group(function () {
    Route::get('/register', [\App\Http\Controllers\PasienAuthController::class, 'showRegisterForm'])->name('pasien.register');
    Route::post('/register', [\App\Http\Controllers\PasienAuthController::class, 'register']);
});

// Konsultasi Routes (Requires Pasien Login)
Route::middleware('auth:pasien')->group(function () {
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::post('/konsultasi/proses', [KonsultasiController::class, 'proses'])->name('konsultasi.proses');
    Route::get('/konsultasi/hasil/{id}', [KonsultasiController::class, 'hasil'])->name('konsultasi.hasil');
    Route::get('/konsultasi/cetak/{id}', [KonsultasiController::class, 'cetak'])->name('konsultasi.cetak');
    
    // Riwayat and Profile
    Route::get('/riwayat-diagnosis', [\App\Http\Controllers\PasienDashboardController::class, 'riwayat'])->name('pasien.riwayat');
    Route::get('/profil', [\App\Http\Controllers\PasienDashboardController::class, 'profile'])->name('pasien.profile');
    Route::put('/profil', [\App\Http\Controllers\PasienDashboardController::class, 'updateProfile'])->name('pasien.profile.update');
});
