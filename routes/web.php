<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HostingRequestController;
use App\Http\Controllers\HostingVerification2Controller;
use App\Http\Controllers\HostingVerificationController;
use App\Http\Controllers\IssuanceController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PseController;
use App\Http\Controllers\PseVerification2Controller;
use App\Http\Controllers\PseVerificationController;
use App\Http\Controllers\SubdomainRequestController;
use App\Http\Controllers\SubdomainVerification2Controller;
use App\Http\Controllers\SubdomainVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationHistoryController;
use Illuminate\Support\Facades\Route;

// === UMUM & PUBLIK ===
Route::middleware('check.sso.optional')->get('/', function () {
    return view('welcome');
});

// Catatan Versi Publik (Version Log)
Route::get('/published', function () {
    $filePath = public_path('version.txt');
    if (!file_exists($filePath)) {
        abort(404, 'Version log not found.');
    }
    return response()->file($filePath, [
        'Content-Type' => 'text/plain; charset=utf-8'
    ]);
});

Route::middleware(['check.sso', 'throttle:180,1'])->group(function () {
    // === ROUTE GLOBAL ===

    // Pengganti Bahasa (Language Switcher)
    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['id', 'en'])) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    })->name('lang.switch');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Unduh Dokumen Pendukung
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
        ->middleware('throttle:30,1')
        ->name('documents.download');


    // === ROLE: PETUGAS ===
    Route::middleware('role:petugas')->group(function () {
        
        // Manajemen Data PSE
        Route::resource('pse', PseController::class)->except(['store']);
        Route::post('/pse', [PseController::class, 'store'])
            ->middleware('throttle:30,1')
            ->name('pse.store');
        Route::patch('pse/{pse}/submit', [PseController::class, 'submit'])
            ->middleware('throttle:30,1')
            ->name('pse.submit');

        // Manajemen Pengajuan Subdomain
        Route::resource('subdomain', SubdomainRequestController::class)->except(['store']);
        Route::post('/subdomain', [SubdomainRequestController::class, 'store'])
            ->middleware('throttle:30,1')
            ->name('subdomain.store');
        Route::patch('subdomain/{subdomain}/submit', [SubdomainRequestController::class, 'submit'])
            ->middleware('throttle:30,1')
            ->name('subdomain.submit');

        // Manajemen Pengajuan Layanan Hosting
        Route::resource('hosting', HostingRequestController::class)->except(['store']);
        Route::post('/hosting', [HostingRequestController::class, 'store'])
            ->middleware('throttle:30,1')
            ->name('hosting.store');
        Route::patch('hosting/{hosting}/submit', [HostingRequestController::class, 'submit'])
            ->middleware('throttle:30,1')
            ->name('hosting.submit');
    });


    // === ROLE: VERIFIKATOR 1 ===
    Route::middleware('role:verifikator_1')->group(function () {
        
        // Verifikasi PSE (Tahap Awal)
        Route::prefix('pse-verification')->name('pse-verification.')->group(function () {
            Route::get('/', [PseVerificationController::class, 'index'])->name('index');
            Route::get('{pse}', [PseVerificationController::class, 'show'])->name('show');
            Route::patch('{pse}/approve', [PseVerificationController::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{pse}/reject', [PseVerificationController::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });

        // Verifikasi Subdomain (Tahap Awal)
        Route::prefix('subdomain-verification')->name('subdomain-verification.')->group(function () {
            Route::get('/', [SubdomainVerificationController::class, 'index'])->name('index');
            Route::get('{subdomain}', [SubdomainVerificationController::class, 'show'])->name('show');
            Route::patch('{subdomain}/approve', [SubdomainVerificationController::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{subdomain}/reject', [SubdomainVerificationController::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });

        // Verifikasi Layanan Hosting (Tahap Awal)
        Route::prefix('hosting-verification')->name('hosting-verification.')->group(function () {
            Route::get('/', [HostingVerificationController::class, 'index'])->name('index');
            Route::get('{hosting}', [HostingVerificationController::class, 'show'])->name('show');
            Route::patch('{hosting}/approve', [HostingVerificationController::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{hosting}/reject', [HostingVerificationController::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });
    });


    // === ROLE: VERIFIKATOR 2 ===
    Route::middleware('role:verifikator_2')->group(function () {
        
        // Verifikasi PSE (Tahap Akhir)
        Route::prefix('pse-verification2')->name('pse-verification2.')->group(function () {
            Route::get('/', [PseVerification2Controller::class, 'index'])->name('index');
            Route::get('{pse}', [PseVerification2Controller::class, 'show'])->name('show');
            Route::patch('{pse}/approve', [PseVerification2Controller::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{pse}/reject', [PseVerification2Controller::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });

        // Verifikasi Subdomain (Tahap Akhir)
        Route::prefix('subdomain-verification2')->name('subdomain-verification2.')->group(function () {
            Route::get('/', [SubdomainVerification2Controller::class, 'index'])->name('index');
            Route::get('{subdomain}', [SubdomainVerification2Controller::class, 'show'])->name('show');
            Route::patch('{subdomain}/approve', [SubdomainVerification2Controller::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{subdomain}/reject', [SubdomainVerification2Controller::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });

        // Verifikasi Layanan Hosting (Tahap Akhir)
        Route::prefix('hosting-verification2')->name('hosting-verification2.')->group(function () {
            Route::get('/', [HostingVerification2Controller::class, 'index'])->name('index');
            Route::get('{hosting}', [HostingVerification2Controller::class, 'show'])->name('show');
            Route::patch('{hosting}/approve', [HostingVerification2Controller::class, 'approve'])->middleware('throttle:30,1')->name('approve');
            Route::patch('{hosting}/reject', [HostingVerification2Controller::class, 'reject'])->middleware('throttle:30,1')->name('reject');
        });

        // Modul Penerbitan Final Update (Hanya Verifikator 2)
        Route::prefix('issuance')->name('issuance.')->group(function () {
            Route::put('/pse/{pse}', [IssuanceController::class, 'updatePse'])->name('pse.update');
        });
    });


    // === RIWAYAT VERIFIKASI (Hanya Verifikator) ===
    Route::middleware('role:verifikator_1,verifikator_2')->group(function () {
        // Riwayat Verifikasi Sistem
        Route::get('verification/history', [VerificationHistoryController::class, 'index'])->name('verification.history');
    });

    // === LAPORAN & REKAP (Shared) ===
    Route::middleware('role:verifikator_1,verifikator_2,admin,eksekutif')->group(function () {
        // Modul Penerbitan & Rekap (Issuance)
        Route::prefix('issuance')->name('issuance.')->group(function () {
            Route::get('/', [IssuanceController::class, 'index'])->name('index');
            Route::get('/print-recap', [IssuanceController::class, 'printRecap'])->name('print.recap');
            Route::get('/pse/{pse}/print', [IssuanceController::class, 'printPse'])->name('pse.print');
            Route::get('/hosting/{hosting}/print', [IssuanceController::class, 'printHosting'])->name('hosting.print');
            Route::get('/subdomain/{subdomain}/print', [IssuanceController::class, 'printSubdomain'])->name('subdomain.print');
        });
    });


    // === MANAJEMEN PENGGUNA & OPD (Shared & Admin) ===
    Route::middleware('role:petugas,verifikator_1,verifikator_2,admin,eksekutif')->group(function () {
        
        // Akses Administrator Mutlak (CRUD & Management)
        Route::middleware('role:admin')->group(function () {
            
            // Pengelolaan Master Data OPD
            Route::patch('opd/{opd}/restore', [OpdController::class, 'restore'])->middleware('throttle:30,1')->name('opd.restore');
            Route::resource('opd', OpdController::class)->except(['show']);

            // Pengelolaan Pengguna - Aksi Kritis (Hapus & Pulihkan)
            Route::patch('users/{user}/restore', [UserController::class, 'restore'])->middleware('throttle:30,1')->name('user.restore');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('throttle:30,1')->name('user.destroy');

            // Pengelolaan Pengguna - Aksi Standar
            // Harus ditempatkan SEBELUM route read-only di bawah agar /users/create tidak di-catch sebagai parameter {user} wildcard
            Route::resource('users', UserController::class)->except(['index', 'show', 'destroy'])->names('user');
        });

        // Akses Read-Only (Termasuk melihat profil user yang telah di-soft-delete)
        Route::resource('users', UserController::class)->only(['index', 'show'])->names('user');
    });
});

// === LOGOUT SYSTEM ===
// Hapus data sesi lokal (Berada di luar scope middleware SSO)
Route::post('/logout', function () {
    session()->flush();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
