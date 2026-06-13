# Dokumentasi Routes - Web Pendataan PSE Kota Batam

Dokumen ini mendefinisikan struktur route yang ideal untuk sistem Web Pendataan PSE Kota Batam, mencakup semua fitur utama termasuk PSE, Subdomain, dan Hosting Request.

---

## 1. Route Structure Overview

### 1.1 Prinsip Penamaan Route

**Konvensi:**
- **Resource routes**: `{resource}.{action}` (Laravel standard)
- **Custom actions**: `{resource}.{custom-action}` 
- **Verification routes**: `{resource}-verification.{action}`
- **Final verification**: `{resource}-verification2.{action}`

**Contoh:**
```php
// Resource standard
Route::resource('pse', PseController::class);
// → pse.index, pse.create, pse.store, pse.show, pse.edit, pse.update, pse.destroy

// Custom action
Route::patch('pse/{pse}/submit', [PseController::class, 'submit'])->name('pse.submit');

// Verification
Route::get('pse-verification', [PseVerificationController::class, 'index'])->name('pse-verification.index');
```

---

## 2. Authentication (SSO Custom)

Sistem ini menggunakan **SSO Custom** melalui `CheckSsoMiddleware`. Tidak ada file `routes/auth.php`. Seluruh proses autentikasi ditangani secara otomatis melalui header-based authentication dari sistem eksternal.

> [!IMPORTANT]
> - Tidak ada formulir login lokal.
> - Middleware `check.sso` dipasang pada grup rute yang membutuhkan autentikasi.
> - Middleware `check.sso.optional` dipasang pada rute publik (seperti Landing Page).

---

## 3. Main Application Routes

**File:** `routes/web.php`

### 3.1 Public Routes

```php
// Welcome page
Route::middleware('check.sso.optional')->get('/', function () {
    return view('welcome');
});

// Version log
Route::get('/published', function () {
    // Return version.txt
});
```

### 3.2 Authenticated Routes (Global)

```php
Route::middleware(['check.sso', 'throttle:60,1'])->group(function () {
    
    // Language Switcher
    Route::get('/lang/{locale}', [/* Closure */])->name('lang.switch');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Document download
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
        ->middleware('throttle:15,1')
        ->name('documents.download');
});
```

### 3.3 Petugas Routes

```php
Route::middleware(['check.sso', 'role:petugas'])->group(function () {
    // PSE Management
    Route::resource('pse', PseController::class)->except(['store']);
    Route::post('/pse', [PseController::class, 'store'])->middleware('throttle:20,1')->name('pse.store');
    Route::patch('pse/{pse}/submit', [PseController::class, 'submit'])->middleware('throttle:20,1')->name('pse.submit');
    
    // Subdomain Request Management
    Route::resource('subdomain', SubdomainRequestController::class)->except(['store']);
    Route::post('/subdomain', [SubdomainRequestController::class, 'store'])->middleware('throttle:20,1')->name('subdomain.store');
    Route::patch('subdomain/{subdomain}/submit', [SubdomainRequestController::class, 'submit'])->middleware('throttle:20,1')->name('subdomain.submit');
    
    // Hosting Request Management
    Route::resource('hosting', HostingRequestController::class)->except(['store']);
    Route::post('/hosting', [HostingRequestController::class, 'store'])->middleware('throttle:20,1')->name('hosting.store');
    Route::patch('hosting/{hosting}/submit', [HostingRequestController::class, 'submit'])->middleware('throttle:20,1')->name('hosting.submit');
});
```

### 3.4 Verification Level 1 (Verifikator 1)

```php
Route::middleware(['check.sso', 'role:verifikator_1'])->group(function () {
    // PSE Verification
    Route::prefix('pse-verification')->name('pse-verification.')->group(function () {
        Route::get('/', [PseVerificationController::class, 'index'])->name('index');
        Route::get('{pse}', [PseVerificationController::class, 'show'])->name('show');
        Route::patch('{pse}/approve', [PseVerificationController::class, 'approve'])->name('approve');
        Route::patch('{pse}/reject', [PseVerificationController::class, 'reject'])->name('reject');
    });
    
    // Subdomain Verification
    Route::prefix('subdomain-verification')->name('subdomain-verification.')->group(function () {
        Route::get('/', [SubdomainVerificationController::class, 'index'])->name('index');
        Route::get('{subdomain}', [SubdomainVerificationController::class, 'show'])->name('show');
        Route::patch('{subdomain}/approve', [SubdomainVerificationController::class, 'approve'])->name('approve');
        Route::patch('{subdomain}/reject', [SubdomainVerificationController::class, 'reject'])->name('reject');
    });

    // Hosting Verification
    Route::prefix('hosting-verification')->name('hosting-verification.')->group(function () {
        Route::get('/', [HostingVerificationController::class, 'index'])->name('index');
        Route::get('{hosting}', [HostingVerificationController::class, 'show'])->name('show');
        Route::patch('{hosting}/approve', [HostingVerificationController::class, 'approve'])->name('approve');
        Route::patch('{hosting}/reject', [HostingVerificationController::class, 'reject'])->name('reject');
    });
});
```

### 3.5 Verification Level 2 (Verifikator 2 - Final)

```php
Route::middleware(['check.sso', 'role:verifikator_2'])->group(function () {
    // PSE Verification Final
    Route::prefix('pse-verification2')->name('pse-verification2.')->group(function () {
        Route::get('/', [PseVerification2Controller::class, 'index'])->name('index');
        Route::get('{pse}', [PseVerification2Controller::class, 'show'])->name('show');
        Route::patch('{pse}/approve', [PseVerification2Controller::class, 'approve'])->name('approve');
        Route::patch('{pse}/reject', [PseVerification2Controller::class, 'reject'])->name('reject');
    });

    // Subdomain Verification Final
    Route::prefix('subdomain-verification2')->name('subdomain-verification2.')->group(function () {
        Route::get('/', [SubdomainVerification2Controller::class, 'index'])->name('index');
        Route::get('{subdomain}', [SubdomainVerification2Controller::class, 'show'])->name('show');
        Route::patch('{subdomain}/approve', [SubdomainVerification2Controller::class, 'approve'])->name('approve');
        Route::patch('{subdomain}/reject', [SubdomainVerification2Controller::class, 'reject'])->name('reject');
    });

    // Hosting Verification Final
    Route::prefix('hosting-verification2')->name('hosting-verification2.')->group(function () {
        Route::get('/', [HostingVerification2Controller::class, 'index'])->name('index');
        Route::get('{hosting}', [HostingVerification2Controller::class, 'show'])->name('show');
        Route::patch('{hosting}/approve', [HostingVerification2Controller::class, 'approve'])->name('approve');
        Route::patch('{hosting}/reject', [HostingVerification2Controller::class, 'reject'])->name('reject');
    });

    // Modul Penerbitan Final Update
    Route::prefix('issuance')->name('issuance.')->group(function () {
        Route::put('/pse/{pse}', [IssuanceController::class, 'updatePse'])->name('pse.update');
    });
});
```

### 3.6 Reports & Recap (Shared)

```php
Route::middleware(['check.sso', 'role:verifikator_1,verifikator_2,admin,eksekutif'])->group(function () {
    Route::prefix('issuance')->name('issuance.')->group(function () {
        Route::get('/', [IssuanceController::class, 'index'])->name('index');
        Route::get('/print-recap', [IssuanceController::class, 'printRecap'])->name('print.recap');
        Route::get('/pse/{pse}/print', [IssuanceController::class, 'printPse'])->name('pse.print');
        Route::get('/hosting/{hosting}/print', [IssuanceController::class, 'printHosting'])->name('hosting.print');
        Route::get('/subdomain/{subdomain}/print', [IssuanceController::class, 'printSubdomain'])->name('subdomain.print');
    });
});
```

### 3.7 Admin & Management Routes

```php
Route::middleware(['check.sso', 'role:petugas,verifikator_1,verifikator_2,admin,eksekutif'])->group(function () {
    
    // Admin Only
    Route::middleware('role:admin')->group(function () {
        // Management OPD
        Route::patch('opd/{opd}/restore', [OpdController::class, 'restore'])->name('opd.restore');
        Route::resource('opd', OpdController::class)->except(['show']);

        // Management User (Critical actions)
        Route::patch('users/{user}/restore', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::resource('users', UserController::class)->except(['index', 'show', 'destroy'])->names('user');
    });

    // User Management (Read-only for shared access)
    Route::resource('users', UserController::class)->only(['index', 'show'])->names('user');
});
```

> [!IMPORTANT]
> **Kebijakan Akses Pengguna (User Access Policy):**
> - Seluruh rute manajemen pengguna yang memodifikasi data (`store`, `edit`, `update`, `destroy`, `restore`) diproteksi menggunakan `UserPolicy` dan hanya diperbolehkan apabila target akun yang dimanipulasi memiliki peran **`petugas`**.
> - Akun internal dengan hak istimewa tinggi (`admin`, `verifikator_1`, `verifikator_2`, `eksekutif`) dilindungi sepenuhnya dari manipulasi antarmuka web dan hanya dapat dibaca detailnya (`show`) oleh pihak berwenang.

---

## 4. Middleware & Authorization

### 4.1 Global Middlewares
- `check.sso`: Memastikan pengguna telah terautentikasi melalui sistem SSO eksternal.
- `role:{role_name}`: Membatasi akses berdasarkan peran pengguna (`petugas`, `verifikator_1`, `verifikator_2`, `admin`, `eksekutif`).
- `throttle:{limit},{minutes}`: Rate limiting untuk mencegah penyalahgunaan API/Rute.

### 4.2 Route Model Binding
Semua rute menggunakan **Route Model Binding**, otomatis memetakan parameter `{resource}` (seperti `{pse}`, `{user}`) ke instance model database. Jika tidak ditemukan, Laravel akan mengembalikan respons 404 secara otomatis.

---

**Last Updated:** 2026-04-10
