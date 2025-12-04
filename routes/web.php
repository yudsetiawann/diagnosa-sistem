<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;

// Rute default Breeze mengarah ke dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Rute di dalam grup 'auth' memerlukan login
Route::middleware('auth')->group(function () {
    // === AKSES UNTUK SEMUA USER (Admin & Pasien) ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (Bisa diakses semua, tapi nanti tampilannya beda)
    Route::get('/', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    // Fitur Diagnosa (Semua bisa akses)
    Route::get('/diagnosis/search', [DiagnosisController::class, 'searchView'])->name('diagnosis.search');
    Route::get('/diagnosis/quick', [DiagnosisController::class, 'quickView'])->name('diagnosis.quick-view');
    Route::post('/diagnosis/quick', [DiagnosisController::class, 'quickDiagnose'])->name('diagnosis.quick-diagnose');
    Route::post('/diagnosis/save', [DiagnosisController::class, 'saveDiagnosis'])->name('diagnosis.save');

    // Riwayat (Semua bisa akses, tapi Pasien cuma lihat punya sendiri)
    Route::resource('visits', VisitController::class)->only(['index', 'show', 'destroy']);

    // Route Detail Penyakit (Public Read-Only)
    Route::get('/diagnosis/disease/{disease}', [DiagnosisController::class, 'showDisease'])
        ->name('diagnosis.disease.show');


    // === KHUSUS ADMIN (Diproteksi Middleware 'admin') ===
    Route::middleware('admin')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('symptoms', SymptomController::class);
        Route::resource('diseases', DiseaseController::class);
    });
});

// Load rute autentikasi (login, register, dll)
require __DIR__ . '/auth.php';
