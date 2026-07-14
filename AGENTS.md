# AGENTS.md — Panduan Operasional Coding Agent
# Web Pendataan PSE Kota Batam

> Dokumen ini adalah petunjuk operasional untuk coding agent yang bekerja di repository ini.
> Seluruh informasi diverifikasi langsung dari source code, konfigurasi, dan dokumentasi internal di `doc/`.
> Baca dokumen ini terlebih dahulu sebelum membuat perubahan apa pun.

---

## 1. Project Overview

**Web Pendataan PSE Kota Batam** adalah aplikasi web internal berbasis Laravel untuk mengelola, mendaftarkan, dan memverifikasi pengajuan **Penyelenggara Sistem Elektronik (PSE)**, Subdomain, dan Hosting Lingkup Publik di lingkungan Pemerintah Kota Batam.

Sistem ini dioperasikan oleh staf Dinas Komunikasi dan Informatika (Diskominfo) Kota Batam dan Petugas Pendata dari setiap OPD (Organisasi Perangkat Daerah).

**Ruang lingkup utama:**
- Pendataan PSE (Penyelenggara Sistem Elektronik) melalui single-flow submission
- Pengajuan Subdomain dan Hosting yang terhubung ke PSE induk
- Alur verifikasi berjenjang dua tingkat (Verifikator 1 → Verifikator 2)
- Penerbitan nomor pendataan dan cetak laporan/bukti dalam format PDF
- Manajemen pengguna (Admin) dan data master OPD
- Autentikasi berbasis SSO Kota Batam menggunakan HTTP header

**Pengguna sistem:** 5 peran — `petugas`, `verifikator_1`, `verifikator_2`, `eksekutif`, `admin`.

---

## 2. Technology Stack

| Lapisan | Teknologi | Versi |
|---|---|---|
| **Bahasa Backend** | PHP | `^8.1` |
| **Framework Backend** | Laravel | `^10.10` |
| **ORM** | Eloquent ORM (Laravel) | — |
| **Database** | MySQL (default) | Dikonfigurasi via `.env` |
| **PDF Generation** | barryvdh/laravel-dompdf | `^3.1` |
| **HTTP Client** | guzzlehttp/guzzle | `^7.2` |
| **REPL Dev** | laravel/tinker | `^2.8` |
| **Styling** | Tailwind CSS v4 | `^4.1.17` |
| **Komponen UI** | DaisyUI | `^5.4.7` |
| **Build Tool** | Vite | `^6.4.1` |
| **Vite Plugin Laravel** | laravel-vite-plugin | `^1.0.0` |
| **Vite Plugin Tailwind** | @tailwindcss/vite | `^4.1.17` |
| **Chart Library** | apexcharts | `^5.6.0` |
| **Font** | @fontsource/inter | `^5.2.8` |
| **HTTP Client JS** | axios | `^1.6.4` |
| **Package Manager PHP** | Composer | — |
| **Package Manager JS** | npm | — |
| **Node.js** | v20+ (requirement dari README) | — |
| **Linter PHP** | Laravel Pint | `^1.0` |
| **Testing PHP** | PHPUnit | `^10.1` |
| **Fake Data** | fakerphp/faker | `^1.9.1` |

**Dev-only dependencies:** `doctrine/dbal`, `laravel/sail`, `mockery/mockery`, `nunomaduro/collision`, `spatie/laravel-ignition`.

---

## 3. Repository Structure

```
pse/
├── app/
│   ├── Console/                    # Artisan commands
│   ├── Exceptions/                 # Exception handler
│   ├── Helpers/                    # Global helper functions (autoloaded via composer.json)
│   │   ├── DateHelper.php          # format_date(), format_date_short(), format_date_indo(), format_time(), format_filename_timestamp()
│   │   ├── StatusHelper.php        # status_border_color(), status_bg_color(), status_text_color(), status_badge_variant()
│   │   ├── SearchHelper.php        # Helper pencarian/filter
│   │   ├── PhoneHelper.php         # format_phone() dan normalisasi nomor
│   │   └── SubdomainHelper.php     # Helper subdomain
│   ├── Http/
│   │   ├── Controllers/            # 16 controller (lihat daftar di bawah)
│   │   ├── Middleware/             # 14 middleware (lihat daftar di bawah)
│   │   └── Kernel.php              # Registrasi middleware global dan alias
│   ├── Models/                     # 8 Eloquent model
│   │   ├── User.php                # SoftDeletes, HasUuid
│   │   ├── Pse.php                 # HasUuid, relasi ke SubdomainRequest, HostingRequest, VerificationHistory
│   │   ├── SubdomainRequest.php    # HasUuid, morphOne Document, morphMany VerificationHistory
│   │   ├── HostingRequest.php      # HasUuid, morphOne Document, morphMany VerificationHistory
│   │   ├── Document.php            # Polimorfik (morphTo documentable)
│   │   ├── VerificationHistory.php # Polimorfik (morphTo verifiable)
│   │   ├── Opd.php                 # SoftDeletes
│   │   └── Role.php
│   ├── Policies/                   # 5 Policy (PsePolicy, SubdomainRequestPolicy, HostingRequestPolicy, UserPolicy, OpdPolicy)
│   ├── Providers/                  # AppServiceProvider, AuthServiceProvider, dll.
│   ├── Traits/
│   │   └── HasUuid.php             # Auto-generate UUID saat creating; getRouteKeyName() => 'uuid'
│   └── View/                       # View composers (jika ada)
├── config/                         # Konfigurasi Laravel (app, auth, database, dll.)
├── database/
│   ├── factories/                  # Eloquent factories (untuk testing)
│   ├── migrations/                 # 21 file migration (kronologis, jangan diedit)
│   └── seeders/
│       ├── DatabaseSeeder.php      # Entry point; urutan: RoleSeeder -> OpdSeeder -> UserSeeder
│       ├── RoleSeeder.php          # Seed 3 roles: petugas, verifikator_1, verifikator_2
│       ├── OpdSeeder.php           # Seed 38 OPD Kota Batam
│       └── UserSeeder.php          # Seed 3 user default (2 verifikator + 1 petugas)
├── doc/                            # Dokumentasi internal (baca sebelum mengerjakan task)
│   ├── DATA_MODEL.md               # Skema tabel, enum/status values, relasi Eloquent
│   ├── FEATURES_FLOW.md            # Alur bisnis single-flow dan matriks status
│   ├── FILE_MAPPING.md             # Peta lengkap seluruh file codebase
│   ├── ROLES.md                    # Definisi 5 peran RBAC dan kewenangan masing-masing
│   ├── ROUTES.md                   # Daftar route dan otorisasi akses
│   ├── RULES.md                    # Aturan kerja dan konvensi commit
│   ├── SEEDER.md                   # Dokumentasi lengkap seeder
│   ├── TASKS.md                    # Log historis pengerjaan
│   └── TODO.md                     # Roadmap pengembangan
├── lang/
│   ├── en/ & id/                   # File terjemahan per bahasa
│   └── en.json                     # Kamus string bilingual utama
├── public/                         # Web root; index.php, storage link, public/build (hasil build)
├── resources/
│   ├── css/app.css                 # Entry point Tailwind CSS v4
│   ├── js/app.js                   # Entry point JavaScript
│   └── views/
│       ├── components/             # Blade components (button/, display/, form/, icons/, ui/)
│       ├── hosting/                # Views petugas untuk hosting
│       ├── hosting-verification/   # Views verifikasi hosting (tingkat 1 & 2)
│       ├── issuance/               # Views penerbitan & cetak PDF
│       ├── layouts/                # Layout utama, header, sidebar
│       ├── opd/                    # Views manajemen OPD (admin)
│       ├── profile/                # Views profil pengguna
│       ├── pse/                    # Views pendataan PSE (petugas)
│       ├── pse-verification/       # Views verifikasi PSE (tingkat 1 & 2)
│       ├── reports/                # Blade template untuk PDF
│       ├── subdomain/              # Views pengajuan subdomain (petugas)
│       ├── subdomain-verification/ # Views verifikasi subdomain (tingkat 1 & 2)
│       ├── user/                   # Views manajemen pengguna (admin)
│       ├── vendor/                 # Override pagination view
│       └── verification-history/   # Views riwayat verifikasi
├── routes/
│   └── web.php                     # Seluruh route HTTP (tidak ada routes/api.php yang aktif)
├── storage/                        # Logs, cache, file upload
├── tests/
│   ├── Feature/                    # Feature tests (ExampleTest, ProfileTest, Auth/)
│   └── Unit/                       # Unit tests (ExampleTest)
├── .env.example                    # Template konfigurasi environment
├── .gitignore                      # File/folder yang dikecualikan dari git
├── artisan                         # Laravel CLI entry point
├── composer.json                   # PHP dependencies
├── package.json                    # JS dependencies
├── phpunit.xml                     # Konfigurasi PHPUnit
├── pint.json                       # Konfigurasi Laravel Pint (linter/formatter)
├── vite.config.js                  # Konfigurasi Vite untuk development
└── vite.config.production.js       # Konfigurasi Vite untuk production build
```

**Daftar Controller** (`app/Http/Controllers/`):
`DashboardController`, `DocumentController`, `HostingRequestController`, `HostingVerification2Controller`,
`HostingVerificationController`, `IssuanceController`, `OpdController`, `PseController`,
`PseVerification2Controller`, `PseVerificationController`, `SubdomainRequestController`,
`SubdomainVerification2Controller`, `SubdomainVerificationController`, `UserController`, `VerificationHistoryController`

**Middleware alias yang relevan** (dari `Kernel.php`):
- `check.sso` → `CheckSsoMiddleware` — Wajib ada header SSO; auto-login user berdasarkan email dari header
- `check.sso.optional` → `CheckSsoOptionalMiddleware` — SSO opsional (halaman publik)
- `role` → `CheckRoleMiddleware` — Cek role user; mendukung multi-role (`role:verifikator_1,verifikator_2`)
- `SecurityHeadersMiddleware` — Dipasang secara global (CSP, HSTS, X-Frame-Options, dll.)
- `SetLocale` — Membaca `session('locale')` untuk bilingual

---

## 4. Setup and Development Commands

### Instalasi Awal

```bash
# 1. Clone repository
git clone <repo-url>
cd pse

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Salin dan konfigurasi environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Sesuaikan koneksi database di .env:
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Jalankan migrasi dan seeder
php artisan migrate --seed

# 8. Buat storage link (untuk file upload)
php artisan storage:link
```

### Menjalankan Server Development

Butuh **dua terminal** yang berjalan bersamaan:

```bash
# Terminal 1 — Frontend dev server (Vite HMR di 127.0.0.1:5173)
npm run dev

# Terminal 2 — Backend Laravel server
php artisan serve
```

### Perintah Artisan yang Sering Digunakan

```bash
# Migrasi fresh (drop semua tabel + migrate + seed) — HAPUS SEMUA DATA
php artisan migrate:fresh --seed

# Jalankan seeder tertentu
php artisan db:seed --class=RoleSeeder

# Cache clear (wajib setelah perubahan config/route)
php artisan optimize:clear

# Buat model baru (sekaligus buat migration)
php artisan make:model NamaModel -m

# Buat migration baru
php artisan make:migration nama_migration --table=nama_tabel

# Buat seeder baru
php artisan make:seeder NamaSeeder

# Composer dump autoload (setelah menambah file baru)
composer dump-autoload
```

### Login Development (SSO Simulation)

Login dilakukan dengan menyisipkan HTTP header ke setiap request (gunakan ModHeader, Postman, dll.):

| Header | Value (email) | Peran |
|---|---|---|
| `X-SSO-Exclusive` | `admin@example.go.id` | Admin |
| `X-SSO-Exclusive` | `eksekutif@example.go.id` | Eksekutif |
| `X-SSO-Exclusive` | `verifikator1@example.go.id` | Verifikator 1 |
| `X-SSO-Exclusive` | `verifikator2@example.go.id` | Verifikator 2 |
| `X-SSO-Exclusive` | `petugas@example.go.id` | Petugas |

> **Catatan:** Nama header dikonfigurasi melalui `BBS_SSO_EXC_HEADER` di `.env`. Default value: `X-SSO-Exclusive`.

---

## 5. Testing and Verification

### Quick Check (sebelum commit)

```bash
# Format kode dengan Pint (PSR-12, hapus unused imports, urutkan imports alphabetically)
./vendor/bin/pint

# Cek tanpa mengubah file (dry-run)
./vendor/bin/pint --test
```

### Full Check (sebelum pekerjaan dinyatakan selesai)

```bash
# Jalankan seluruh test suite
php artisan test

# Atau langsung via PHPUnit
./vendor/bin/phpunit

# Jalankan hanya Unit tests
./vendor/bin/phpunit --testsuite Unit

# Jalankan hanya Feature tests
./vendor/bin/phpunit --testsuite Feature

# Build frontend (validasi tidak ada error bundle)
npm run build
```

### Catatan Konfigurasi Testing

Dari `phpunit.xml`:
- `APP_ENV=testing`
- `CACHE_DRIVER=array`
- `MAIL_MAILER=array`
- `QUEUE_CONNECTION=sync`
- `SESSION_DRIVER=array`
- `BCRYPT_ROUNDS=4`
- Database testing: baris `DB_CONNECTION=sqlite` dan `DB_DATABASE=:memory:` dikomentari di `phpunit.xml` — perlu database aktual atau dikonfigurasi manual di `.env.testing` untuk menjalankan test yang membutuhkan database.

---

## 6. Architecture and Coding Conventions

### Pola Arsitektur

- **MVC Standard Laravel**: Routes → Controller → Model → View (Blade)
- **Policy-based Authorization**: Setiap resource utama (Pse, SubdomainRequest, HostingRequest, User, Opd) memiliki Policy di `app/Policies/`
- **Global Helpers**: Fungsi helper global di `app/Helpers/` di-autoload via `composer.json` bagian `autoload.files` (bukan Service Provider)
- **Polimorfik Relations**: `documents` dan `verification_histories` menggunakan `morphTo()` / `morphMany()` / `morphOne()`
- **Trait HasUuid**: Model yang memiliki UUID public identifier menggunakan `use HasUuid;` — UUID di-generate otomatis saat `creating`; `getRouteKeyName()` mengembalikan `'uuid'` sehingga route binding melalui UUID, bukan integer ID
- **Soft Deletes**: `User` dan `Opd` menggunakan `SoftDeletes`; data tidak benar-benar dihapus dari database
- **Bilingual**: Semua string UI menggunakan `__()` translation helper; kamus di `lang/en.json` dan `lang/id/` / `lang/en/`
- **SSO Authentication**: Autentikasi tidak menggunakan password standard Laravel. User diidentifikasi dari HTTP header (`X-SSO-Exclusive` untuk internal, `X-SSO-User` untuk publik)

### Konvensi Penamaan

| Jenis | Konvensi | Contoh |
|---|---|---|
| Model | `PascalCase`, singular | `Pse`, `SubdomainRequest`, `HostingRequest` |
| Controller | `PascalCase` + `Controller` | `PseController`, `HostingVerification2Controller` |
| Policy | `PascalCase` + `Policy` | `PsePolicy`, `OpdPolicy` |
| Migration | `snake_case` dengan timestamp | `2026_04_04_000246_refactor_pse_subdomain_structure.php` |
| Route name | `kebab-case` dengan titik | `pse.store`, `pse-verification.approve` |
| Tabel DB | `snake_case`, plural | `pses`, `subdomain_requests`, `verification_histories` |
| Helper function | `snake_case` global | `format_date()`, `status_bg_color()`, `format_phone()` |
| Blade component | `kebab-case` | `<x-ui.card>`, `<x-form.input>`, `<x-button.primary>` |
| Relasi Eloquent | `camelCase` | `verificationHistories()`, `hostingRequests()`, `primarySubdomain()` |
| Komentar kode | Bahasa Indonesia | `// Relasi ke tabel users` |

### Form Request Validation

- Direktori `app/Http/Requests/` ada namun kosong — validasi dilakukan langsung di Controller dengan `$request->validate([...])`.
- Aturan validasi server-side yang berlaku terdokumentasi di `doc/DATA_MODEL.md` (bagian "Aturan Validasi Input").
- Nomor telepon dinormalisasi ke format `62xxx` (kode negara Indonesia) sebelum disimpan — gunakan mutator di model atau pola serupa di controller.

### Lokasi Logika Bisnis

- **Status transition** (draft → pending_1 → pending_2 → approved/rejected): Dikelola di Controller
- **Authorization check**: Via `$this->authorize()` di Controller yang memanggil Policy terkait
- **Enum values**: Didefinisikan sebagai static method di Model (contoh: `Pse::getSectors()`, `Pse::getRiskCategories()`, `Pse::getStorageLocations()`)
- **PDF generation**: Melalui `barryvdh/laravel-dompdf` di `IssuanceController`, template Blade di `resources/views/reports/`

### Code Formatting

- **Preset**: PSR-12 (dikonfigurasi di `pint.json`)
- **Aturan tambahan**: `no_unused_imports: true`, `ordered_imports: alpha` (import diurutkan alphabetically)
- **Jalankan** `./vendor/bin/pint` sebelum commit

### Tailwind CSS v4 + DaisyUI

- Plugin Tailwind v4 **harus diletakkan PERTAMA** sebelum plugin Laravel di `vite.config.js` (`tailwindcss()` sebelum `laravel({...})`)
- Kelas DaisyUI dan Tailwind dimasukkan melalui `resources/css/app.css` sebagai entry point
- Dev server Vite berjalan di `127.0.0.1:5173` (konfigurasi `strictPort: true`)

---

## 7. Business Rules and Invariants

### Alur Status — Semua Entity (PSE, SubdomainRequest, HostingRequest)

```
draft → pending_1 → pending_2 → approved
                 ↘           ↘
                  rejected     rejected
rejected → (edit oleh petugas) → draft → pending_1 → ...
```

**Aturan yang tidak boleh rusak:**

1. **Hanya `verifikator_2` yang dapat memberikan `approved` final.** `verifikator_1` hanya bisa meneruskan ke `pending_2` atau menolak ke `rejected`.
2. **Petugas hanya bisa edit/hapus record miliknya sendiri** dan hanya ketika status `draft` (hapus) atau `draft`/`rejected` (edit & submit).
3. **PSE hanya bisa di-submit jika sudah ada minimal 1 subdomain** (validasi `subdomains: required|array|min:1`).
4. **Hosting wajib dilampirkan jika `storage_location = 'aplikasi'`** (aturan bisnis dari alur single-flow).
5. **Nomor pendataan (`registration_number`) hanya bisa diisi/diperbarui oleh `verifikator_2`** ketika status PSE sudah `approved` (via `IssuanceController`).
6. **Penolakan (reject) wajib menyertakan `notes`** — field `notes` bersifat `required` saat reject, `nullable` saat approve.
7. **Single-flow submission**: Satu klik "Ajukan" (submit) mengubah status PSE, seluruh SubdomainRequest, dan HostingRequest miliknya secara bersamaan menjadi `pending_1`. Data terkunci (tidak bisa diedit) selama proses verifikasi.
8. **Admin hanya bisa mengelola akun berperan `petugas` via UI.** Akun `verifikator_1`, `verifikator_2`, `eksekutif`, dan sesama `admin` tidak bisa dimanipulasi melalui antarmuka web.
9. **`users.role_id` adalah NOT NULL.** Setiap user wajib memiliki role.
10. **`users.opd_id` adalah nullable.** Verifikator dan Admin tidak terikat ke OPD manapun.

### Relasi Data Utama

- `PSE` → dimiliki oleh satu `User` (`petugas`), dapat terhubung ke satu `Opd`
- `SubdomainRequest` → harus terhubung ke satu `Pse` induk (FK: `pse_id`)
- `HostingRequest` → harus terhubung ke satu `Pse` induk (FK: `pse_id`)
- `Document` → polimorfik: milik `User` (Surat Tugas) atau `SubdomainRequest`/`HostingRequest` (Surat Permohonan)
- `VerificationHistory` → polimorfik: rekaman jejak verifikasi untuk `Pse`, `SubdomainRequest`, atau `HostingRequest`

### Nilai Enum yang Berlaku

**`status`** (berlaku untuk `pses`, `subdomain_requests`, `hosting_requests`):
`draft` | `pending_1` | `pending_2` | `approved` | `rejected`

**`role_name`** (tabel `roles`):
`petugas` | `verifikator_1` | `verifikator_2` | `eksekutif` | `admin`

**`user.status`:** `active` | `inactive` | `suspended`

**`pse.risk_category`:** `rendah` | `sedang` | `tinggi`

**`pse.data_classification`:** `publik` | `internal` | `rahasia` | `sangat rahasia`

**`pse.storage_location`:** `aplikasi` | `colocation` | `eksternal`

**`subdomain_request.request_type` / `hosting_request.request_type`:** `baru` | `perpanjangan` | `ubah` | `hapus`

**`hosting_request.hosting_type`:** `shared` | `vps` | `dedicated` | `cloud`

---

## 8. Database Rules

### Migration

- **Jangan pernah mengubah file migration yang sudah pernah dijalankan** (`database/migrations/`). Perubahan skema selalu dibuat sebagai migration baru.
- Gunakan `php artisan make:migration` untuk membuat migration baru.
- Sertakan method `down()` yang benar (reversible) untuk setiap migration.

### Foreign Key Conventions

Berdasarkan implementasi aktual di migration:

| Relasi | Behavior |
|---|---|
| `users.opd_id` → `opds.id` | `ON DELETE SET NULL` (nullable) |
| `users.role_id` → `roles.id` | `ON DELETE RESTRICT` (NOT NULL) |
| `pses.user_id` → `users.id` | `ON DELETE RESTRICT` |
| `subdomain_requests.user_id` → `users.id` | `ON DELETE RESTRICT` |
| `hosting_requests.user_id` → `users.id` | `ON DELETE RESTRICT` |
| `verification_histories.user_id` → `users.id` | `ON DELETE RESTRICT` |
| `subdomain_requests.pse_id` → `pses.id` | `ON DELETE CASCADE` |

### Seeder

- Urutan eksekusi wajib dipatuhi: **RoleSeeder → OpdSeeder → UserSeeder** (karena dependensi FK)
- Gunakan `updateOrCreate()` atau `firstOrCreate()` agar seeder idempotent (aman dijalankan ulang)
- Seeder untuk data produksi tidak boleh menyertakan password atau credential nyata
- Register seeder baru di `DatabaseSeeder.php` di urutan yang sesuai dependensinya

### Penghapusan Data

- `User` menggunakan `SoftDeletes` — jangan gunakan `forceDelete()` kecuali ada keperluan eksplisit
- `Opd` menggunakan `SoftDeletes` — Admin dapat melakukan restore
- `Pse`, `SubdomainRequest`, `HostingRequest` tidak menggunakan SoftDeletes — penghapusan permanen; hanya boleh dilakukan untuk record dengan status `draft`
- Hindari `ON DELETE CASCADE` berantai yang tidak disengaja — cek behavior FK sebelum membuat relasi baru

### Transaksi Database

- Operasi yang mengubah beberapa tabel sekaligus (misalnya single-flow submit yang memperbarui PSE + semua SubdomainRequest + HostingRequest) harus dibungkus dengan `DB::transaction()` untuk menjaga integritas data.

---

## 9. Security Requirements

### Autentikasi

- **Tidak ada login berbasis password** di production — semua autentikasi via SSO header dari sistem SSO Kota Batam.
- `CheckSsoMiddleware` membaca email dari header `X-SSO-Exclusive` (internal) atau `X-SSO-User` (publik), kemudian melakukan auto-login dengan `Auth::login($user)`.
- Nama header dikonfigurasi di `.env`: `BBS_SSO_EXC_HEADER` dan `BBS_SSO_PUB_HEADER`.
- Jika header tidak ada → abort 401. Jika user tidak ditemukan di database → abort 401.
- Jika role user berubah antara request → session di-flush dan user di-redirect ke dashboard.

### Otorisasi

- Gunakan **Laravel Policy** untuk otorisasi level resource — jangan melakukan cek role manual secara *ad hoc* di view atau controller tanpa melalui Policy.
- Route sudah dikelompokkan per role via middleware `role:nama_role` — jangan menambah route di group yang salah.
- Verifikator 1 tidak boleh mengakses route `verifikator_2` dan sebaliknya.

### Validasi Input

- Validasi server-side wajib untuk semua input pengguna — jangan percaya data dari client.
- Gunakan regex yang ketat untuk field nama, deskripsi, dll. (lihat `doc/DATA_MODEL.md` untuk aturan per field).
- Nomor telepon harus dinormalisasi ke format `62xxx` sebelum disimpan.
- Email selalu di-lowercase sebelum disimpan (mutator di `User` model).

### Upload Dokumen

- File upload dibatasi: **format PDF, maksimal 2MB** (assignment_letter sesuai validasi di controller).
- File disimpan di `storage/app/` (private) dan diakses melalui `DocumentController@download` — tidak diekspos langsung via URL publik.
- UUID digunakan sebagai identifier dokumen di route (`/documents/{document}/download`) untuk mencegah IDOR (Insecure Direct Object Reference).
- Throttle untuk download: `throttle:30,1` (30 request per menit).

### Security Headers (aktif secara global)

`SecurityHeadersMiddleware` diterapkan di semua request:
- `X-Content-Type-Options: nosniff`
- `X-XSS-Protection: 1; mode=block`
- `X-Frame-Options: SAMEORIGIN`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=(), vr=()`
- `Content-Security-Policy` — dikonfigurasi berbeda per environment (dev vs production)
- `Strict-Transport-Security` — hanya aktif di environment `production` (1 tahun, includeSubDomains)
- Header `X-Powered-By` dihapus

### Environment Variables dan Secrets

- **Jangan pernah commit nilai rahasia** (API key, password, APP_KEY, credential database) ke repository.
- `.env` sudah ada di `.gitignore` — pastikan tidak ter-commit.
- Selalu gunakan variabel dari `.env` melalui fungsi `config()` atau `env()`, bukan hardcode di source code.
- `APP_KEY` harus diisi via `php artisan key:generate`.
- Di production, `APP_DEBUG=false` dan `APP_ENV=production` wajib diset.
- `SESSION_SECURE_COOKIE=true` wajib di production.

### Perlindungan Data

- Hindari mengekspos integer ID di URL publik — gunakan UUID (sudah diimplementasikan via `HasUuid` trait).
- Jangan tampilkan sensitive fields pengguna lain di response/view tanpa explicit authorization.
- Gunakan Eloquent/Query Builder — jangan raw SQL yang rentan injection.
- CSRF protection aktif untuk semua route web (via `VerifyCsrfToken` middleware).

---

## 10. Change Boundaries

**File dan direktori berikut tidak boleh diedit langsung:**

| Path | Alasan |
|---|---|
| `vendor/` | Dependency PHP yang di-manage Composer; jalankan `composer install/update` |
| `node_modules/` | Dependency JS yang di-manage npm; jalankan `npm install` |
| `public/build/` | Output build Vite yang di-generate otomatis; jalankan `npm run build` |
| `storage/` | File runtime (logs, cache, upload); dikecualikan dari git |
| `bootstrap/cache/` | Cache generated; pakai `php artisan optimize:clear` |
| `composer.lock` | Jangan edit manual; di-update via `composer update` hanya jika ada alasan jelas |
| `package-lock.json` | Jangan edit manual; di-generate otomatis oleh npm |
| `database/migrations/*.php` (yang sudah dijalankan) | Buat migration baru untuk perubahan skema |
| `.env` | Konfigurasi lokal; jangan commit; sesuaikan secara manual |

**Perubahan yang membutuhkan pertimbangan ekstra:**
- Mengubah struktur tabel yang sudah ada — wajib via migration baru, bukan mengedit migration lama
- Mengubah urutan atau isi seeder yang berdampak ke data production
- Mengubah behavior autentikasi/SSO middleware
- Mengubah konfigurasi security headers
- Menghapus atau mengubah key di `lang/en.json` — berpotensi membreaking terjemahan yang sudah ada

---

## 11. Definition of Done

Pekerjaan dinyatakan **selesai** apabila seluruh syarat berikut terpenuhi:

- [ ] **Fungsionalitas bekerja**: Fitur yang dikerjakan berfungsi sesuai spesifikasi (alur bisnis, role, status transition).
- [ ] **Format kode benar**: `./vendor/bin/pint --test` tidak mengembalikan error (tidak ada pelanggaran PSR-12, unused imports, atau import tidak berurutan).
- [ ] **Tidak ada perubahan di luar ruang lingkup**: Hanya file yang relevan dengan task yang dimodifikasi.
- [ ] **Migration valid**: Jika ada perubahan skema, migration baru sudah dibuat (bukan mengedit migration lama) dan dapat dijalankan tanpa error.
- [ ] **Seeder tetap berfungsi**: Jika ada perubahan yang berdampak ke seeder, seeder masih dapat dijalankan dengan benar.
- [ ] **Otorisasi terjaga**: Tidak ada bypass policy atau role check yang tidak disengaja.
- [ ] **Test suite tidak rusak**: `php artisan test` berhasil (tidak ada test yang sebelumnya lulus menjadi gagal).
- [ ] **Tidak ada secret di kode**: Tidak ada credential, password, atau API key yang terekspos di source code.
- [ ] **Route terdaftar dengan benar**: Route baru ditempatkan di group middleware yang sesuai dengan role yang diizinkan.
- [ ] **Dokumentasi internal diperbarui jika relevan**: Jika perilaku sistem berubah (skema baru, route baru, role baru, dsb), dokumen terkait di `doc/` diperbarui.
- [ ] **Bilingual dijaga**: String baru di UI menggunakan `__()` dan sudah ditambahkan ke kamus bahasa yang relevan.

---

## 12. Git and Pull Request Rules

Berdasarkan `doc/RULES.md`, konvensi commit berikut berlaku di repository ini:

### Format Commit Message

```
<type>: <deskripsi singkat (imperative, lowercase, tanpa titik)>

<Kategori Perubahan 1>:
- <detail perubahan>

<Kategori Perubahan 2>:
- <detail perubahan>

Files Modified:
- <daftar file yang diubah>

Files Created:
- <daftar file baru> (jika ada)
```

### Tipe Commit yang Valid

| Tipe | Penggunaan |
|---|---|
| `feat` | Fitur baru |
| `fix` | Perbaikan bug |
| `refactor` | Refactoring tanpa mengubah fungsionalitas |
| `style` | Perubahan UI/CSS tanpa mengubah logika |
| `docs` | Perubahan dokumentasi saja |
| `security` | Perbaikan keamanan |
| `chore` | Konfigurasi, dependency, atau maintenance |

### Kategori Body Commit

- **Backend Changes** — Perubahan controller, model, middleware, dll.
- **Frontend Changes** — Perubahan view, Blade component, JS, CSS
- **Security Enhancements** — Perubahan terkait keamanan
- **Database Changes** — Migration, seeder, skema

### Aturan Commit

1. Subject line: imperative mood, lowercase, tanpa titik di akhir
2. Body dipisahkan dari subject dengan satu baris kosong
3. Selalu cantumkan `Files Modified` / `Files Created` di akhir body
4. Satu commit = satu task/fitur; hindari commit campuran

> **Catatan:** Tidak ditemukan bukti aturan branch naming, PR template, atau CI pipeline di repository ini.

---

## Referensi Dokumen Internal

Selalu baca dokumen relevan di `doc/` sebelum mengerjakan task:

- [`doc/DATA_MODEL.md`](doc/DATA_MODEL.md) — Skema tabel, nilai enum/status, relasi Eloquent, aturan FK
- [`doc/ROLES.md`](doc/ROLES.md) — Detail 5 peran RBAC dan batasan kewenangan
- [`doc/FEATURES_FLOW.md`](doc/FEATURES_FLOW.md) — Alur bisnis single-flow dan matriks status
- [`doc/SEEDER.md`](doc/SEEDER.md) — Urutan seeder dan cara menjalankannya
- [`doc/ROUTES.md`](doc/ROUTES.md) — Pemetaan route dan otorisasi
- [`doc/FILE_MAPPING.md`](doc/FILE_MAPPING.md) — Indeks lengkap seluruh file codebase
- [`doc/RULES.md`](doc/RULES.md) — Aturan kerja, konvensi commit, dan alur kerja agent
- [`doc/TASKS.md`](doc/TASKS.md) — Log historis pengerjaan
- [`doc/TODO.md`](doc/TODO.md) — Roadmap pengembangan
