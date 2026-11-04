<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Utama (Landing Page)
Route::get('/', function () { 
    return view('landing'); 
})->name('landing');

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTE SISWA
// ==========================================
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa', function () { return redirect()->route('siswa.dashboard'); });
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
});

// ==========================================
// RUTE ADMIN (KURIKULUM)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa');
    Route::get('/siswa/export-pdf', [AdminController::class, 'exportPdf'])->name('siswa.export-pdf');
    
    Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
    Route::post('/verifikasi/{id}/approve', [AdminController::class, 'approveDocument'])->name('verifikasi.approve');
    Route::post('/verifikasi/{id}/reject', [AdminController::class, 'rejectDocument'])->name('verifikasi.reject');
    
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
    Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('kelas.store');
    Route::put('/kelas/{id}', [AdminController::class, 'updateKelas'])->name('kelas.update');
    Route::delete('/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('kelas.destroy');

    Route::get('/document-types', [AdminController::class, 'documentTypes'])->name('document-types');
    Route::post('/document-types', [AdminController::class, 'storeDocumentType'])->name('document-types.store');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    
    // --- TAMBAHAN RUTE HAPUS USER ---
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    Route::get('/rekap', [AdminController::class, 'rekap'])->name('rekap');
    
    // Upload Kolektif (ZIP)
    Route::get('/upload-kolektif', [AdminController::class, 'uploadKolektif'])->name('upload-kolektif');
    Route::post('/upload-kolektif', [AdminController::class, 'prosesUploadKolektif'])->name('upload-kolektif.proses');
});

// ==========================================
// RUTE GURU
// ==========================================
Route::middleware(['auth'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/', function () { return redirect()->route('guru.dashboard'); });
    
    // Dashboard & Dokumen
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/dokumen', [GuruController::class, 'dokumen'])->name('dokumen');
    Route::get('/dokumen/{id}/detail', [GuruController::class, 'detail'])->name('detail');
    Route::post('/dokumen/upload', [GuruController::class, 'storeDocument'])->name('store-document');
    Route::delete('/dokumen/{id}/delete', [GuruController::class, 'destroyDocument'])->name('destroy-document');
    
    // Laporan
    Route::get('/laporan', [GuruController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export-pdf', [GuruController::class, 'exportPdf'])->name('laporan.export-pdf');
});