<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');  
    Route::get('/bahan-ajar', [DashboardController::class, 'bahanAjar'])->name('bahan.ajar');

    Route::get('/nilai', [DashboardController::class, 'nilai'])->name('nilai');

    // Dosen Nilai Management (protected - dosen/admin only)
Route::prefix('dosen/nilai')->name('dosen.nilai.')->group(function () {
        Route::get('/', [DashboardController::class, 'nilaiIndex'])->name('index');
        Route::get('/{kadet}/form', [DashboardController::class, 'nilaiForm'])->name('form');
        Route::post('/', [DashboardController::class, 'nilaiStore'])->name('store');
        Route::delete('/{nilai}', [DashboardController::class, 'nilaiDestroy'])->name('destroy');        Route::post('/{nilai}/delete', [DashboardController::class, 'nilaiDestroy'])->name('delete');
    });



    // Dosen Jadwal CRUD (protected - dosen/admin only)

    Route::prefix('dosen/jadwal')->name('dosen.jadwal.')->group(function () {
        Route::get('/', [DashboardController::class, 'jadwalIndex'])->name('index');
        Route::get('/create', [DashboardController::class, 'jadwalCreate'])->name('create');
        Route::post('/', [DashboardController::class, 'jadwalStore'])->name('store');
        Route::get('/{jadwal}/edit', [DashboardController::class, 'jadwalEdit'])->name('edit');
        Route::put('/{jadwal}', [DashboardController::class, 'jadwalUpdate'])->name('update');
        Route::delete('/{jadwal}', [DashboardController::class, 'jadwalDestroy'])->name('destroy');
    });
    Route::get('/surat-berkas', [DashboardController::class, 'surat'])->name('surat');
    Route::get('/manajemen-akademik', [DashboardController::class, 'akademik'])->name('akademik');
    Route::get('/akun', [DashboardController::class, 'akun'])->name('akun');
    Route::get('/admin/kadet', [DashboardController::class, 'kelolaKadet'])->name('admin.kadet');
    Route::get('/admin/upload', [DashboardController::class, 'uploadMateri'])->name('admin.upload');
    
    // Staff Prodi routes
    Route::prefix('staff_prodi')->name('staff_prodi.')->group(function () {
        Route::get('/', [DashboardController::class, 'staffProdiIndex'])->name('index');
    });
    
    // Sesprodi routes
    Route::prefix('sesprodi')->name('sesprodi.')->group(function () {
        Route::get('/', [DashboardController::class, 'sesprodiIndex'])->name('index');
    });
});

// 1. Halaman Welcome
Route::get('/', function () {
    return view('welcome');
});

// 2. Halaman Pilih Role (Login atau Register)
Route::get('/pilih-role/{aksi}', [AuthController::class, 'pilihRole'])->name('pilih.role');

// 3. Halaman Form (Login/Register sesuai role)
Route::get('/auth/{aksi}/{role}', [AuthController::class, 'showForm'])->name('auth.form');

// Login redirect (fixes Route [login] not found)
Route::get('/login', function () {
    return redirect('/pilih-role/login');
})->name('login');

// Proses Action
Route::post('/register-process', [AuthController::class, 'register'])->name('register.post');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset (simple)
Route::get('/password/reset', [AuthController::class, 'showRequestReset'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Inline forgot password email
Route::post('/auth/inline-reset', [AuthController::class, 'sendInlineResetEmail'])->name('auth.inline.reset');

// Pastikan nama route sesuai dengan yang ada di Sidebar app.blade.php
Route::get('/bahan-ajar', [DashboardController::class, 'bahanAjar'])->name('bahan.ajar');
Route::get('/nilai', [DashboardController::class, 'nilai'])->name('nilai');
Route::get('/surat-berkas', [DashboardController::class, 'surat'])->name('surat');
Route::get('/manajemen-akademik', [DashboardController::class, 'akademik'])->name('akademik');
Route::get('/akun', [DashboardController::class, 'akun'])->name('akun');
