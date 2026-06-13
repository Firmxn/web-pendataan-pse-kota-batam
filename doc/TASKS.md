# Daftar Task Pengembangan

Dokumen ini berisi daftar task yang perlu dikerjakan untuk pengembangan sistem PSE selanjutnya.

## 📊 Progress Summary

**Total Task:** 87 (82 ✅ Done, 0 💡 Planned, 5 ℹ️ N/A)  
**Completion Rate:** 94.25% (82/87 task sudah selesai, 5 task tidak akan dikerjakan)

**Task Selesai:**

- ✅ #1 - Validasi Batas Draft
- ✅ #2 - Upload Dokumen Surat Permohonan
- ✅ #3 - Cetak Dokumen & PDF
- ✅ #4 - Edit Nomor Registrasi PSE
- ✅ #5 - Fitur Items Per Page
- ✅ #6 - UI/UX Improvements & Dark Mode
- ✅ #7 - Fix Theme Transition Flicker
- ✅ #8 - Update Domain PSE saat Subdomain Diapprove
- ✅ #9 - Rename Kolom PSE
- ✅ #10 - Penyelarasan UI Modal
- ✅ #11 - Validasi & Normalisasi Subdomain Name
- ✅ #13 - Refactor Code Duplication - Validasi Subdomain
- ✅ #14 - Missing Logging untuk Critical Actions
- ✅ #16 - Error Messages Hardcoded (Medium Priority)
- ✅ #18 - Soft Delete untuk User (Low Priority)
- ✅ #19 - Rate Limiting untuk Form Submissions (High Priority - Security)
- ✅ #20 - File Upload Security Validation (High Priority - Security)
- ✅ #21 - Security Headers Implementation (Medium Priority - Security)
- ✅ #23 - Migrasi ke Single Sign-On (SSO) Authentication (High Priority - Architecture Change)
- ✅ #24 - Validasi Profil Lengkap & Tampilkan Surat Tugas di Verifikasi (High Priority - Data Integrity)
- ✅ #25 - Validasi Enum Server-Side untuk Select Box Fields (Medium Priority - Security)
- ✅ #26 - Validasi Komprehensif Field (max, regex, in) - Security Hardening
- ✅ #27 - Standardisasi Enum PSE ke Lowercase (Low Priority - Code Consistency)
- ✅ #28 - Content Security Policy (CSP) Header (Medium Priority - Security)
- ✅ #29 - Session & Cookie Security Configuration (Low Priority - Security)
- ✅ #30 - Hapus Debug Info & Pastikan APP_DEBUG=false (Medium Priority - Security)
- ✅ #31 - Security Hardening: Verifikator 1 Remediation
- ✅ #32 - Security Hardening: Petugas Part 2 Remediation
- ✅ #33 - Refactor Subdomain Name Storage (Prefix Only)
- ✅ #34 - Fix 500 Error on PSE Creation (Nullable `opd_id`)
- ✅ #35 - Refactor Subdomain Logic (DRY Helper)
- ✅ #36 - Cleanup CDN & Standarisasi Font + ApexCharts via npm
- ✅ #37 - Lokalize Font Inter & Cleanup CSP (Zero External CDN)
- ✅ #38 - Standarisasi Komponen UI Document Viewer
- ✅ #39 - Tooltip pada Tabel Daftar Indeks (Truncate Text)
- ✅ #40 - Halaman Detail Profil Pengguna (ReadOnly untuk Verifikator)
- ✅ #41 - Penyelarasan Warna Chart dengan Tema Light/Dark
- ✅ #42 - Refactor UUID Generation ke Trait HasUuid
- ✅ #43 - Standardisasi Komponen Button (Low Priority - Refaktor UI)
- ✅ #45 - Validasi Surat Permohonan Wajib Saat Submit Subdomain & Hosting
- ✅ #46 - Filter Berdasarkan Status di Halaman Index
- ✅ #47 - Rekap Laporan Manual Per Bulan/Tahun (Integrated to Issuance)
- ✅ #48 - Fitur Pemulihan (Restore) Akun User yang Dihapus (Soft Deletes)
- ✅ #49 - Sorting Data di Halaman Index (Nama, Sektor, Status, tgl)
- ✅ #50 - Sorting Data di Halaman Verifikasi (Verifikator 1 & 2)
- ✅ #52 - Penguatan Rate Limiting pada Rute Kritis (Security Hardening)
- ✅ #53 - Implementasi DB Transactions pada Operasi Multi-Step (Data Integrity)
- ✅ #54 - Implementasi DB Transactions pada Form Submission (Data Consistency)
- ✅ #55 - Hardening Integritas Data (Foreign Key Cascade) (🔴 Critical)
- ✅ #56 - Pencegahan XSS pada Pesan Session (🔴 High)
- ✅ #57 - Proteksi ID Enumeration (Penerapan UUID User) (🔴 High)
- ✅ #58 - Language Switcher (Bilingual UI) (Medium Priority)
- ✅ #59 - Dokumentasi Kredit (Published Credits) (🟢 Low Priority)
- ✅ #60 - Implementasi Role Baru (Admin & Eksekutif) (🔴 High Priority)
- ✅ #61 - Konsolidasi Profil ke User Management (Admin Only) (🔴 High Priority)
- ✅ #62 - Standarisasi Sektor PSE (Point 4 TODO.md) (🟢 Low Priority)
- ✅ #63 - Sinkronisasi Alur Terpadu PSE & Hosting (Single Flow) (🟡 Medium Priority)
- ✅ #64 - Integrasi Verifikasi Terpadu PSE & Hosting (Single Flow Verification) (🔴 High Priority)
- ✅ #65 - Integrasi Subdomain PSE 1-N (Single Flow Subdomain) (🔴 High Priority)
- ✅ #66 - Spesialisasi Daftar Hosting Petugas (Point 9 TODO) (🟡 Medium Priority)
- ✅ #67 - Revitalisasi Modern Dasbor & Standarisasi UI Interaktif (🔴 High Priority)
- ✅ #68 - Manajemen OPD (CRUD) - Admin Only (High Priority - Admin Flexibility)
- ✅ #69 - Otomasi Pembersihan Data Hosting Terkait (Single Flow) (🟡 Medium Priority)
- ✅ #70 - Simplifikasi Validasi Pengajuan (Hapus Pengecekan Profil/Surat Tugas) (High Priority)
- ✅ #71 - Sinkronisasi Pengajuan Timbal Balik Modul Single Flow (Medium Priority)
- ✅ #72 - Pembersihan Data Subdomain Orphan & Relaksasi Validasi Dokumen (Single Flow) (Medium Priority)
- ✅ #73 - Proteksi Penghapusan Mandiri Data Single Flow (Medium Priority)
- ✅ #74 - Perbaikan Urutan Validasi Dokumen pada Submit Single Flow (High Priority - Bug Fix)
- ✅ #75 - Konsolidasi View Verifikasi PSE (Show Page) (🟡 Medium Priority)
- ✅ #76 - Standarisasi Link Dokumen & Komponen DRY (target="\_blank") (🟡 Medium Priority)
- ✅ #77 - Hapus Dependensi Alpine.js (🟡 Medium Priority - Cleanup)
- ✅ #78 - Refactor Halaman Edit User (Template Konsisten dengan Create) (🟡 Medium Priority - UI/UX)
- ✅ #79 - Proteksi ID Enumeration pada Route Dokumen (UUID Document) (🔴 High Priority - Security)
- ✅ #80 - Rekam Jejak Audit Entitas Turunan Single Flow (🟡 Medium Priority - Data Integrity)
- ✅ #81 - Batasi Akses Riwayat Verifikasi Sesuai Spesifikasi (🟡 Medium Priority - RBAC)
- ✅ #82 - Penyesuaian Seluruh Laporan PDF dengan Kondisi Single Flow (🟡 Medium Priority - Bug Fix)
- ✅ #83 - Perbaikan Priority Routing 404 Pada Pendaftaran Rute Ekstra User (🔴 High Priority - Bug Fix)
- ✅ #84 - Optimasi Kolom Auth SSO & Strict Type Validation (High Priority - Security/DB Cleansing)
- ✅ #85 - Standardisasi Document Viewer ke Komponen current-file (Medium Priority - UI Consistency)
- ✅ #86 - Standarisasi Alert Session UI (Medium Priority - UI Consistency)
- ✅ #87 - Pengetatan RBAC & Filter Akun Sensitif pada User Management (High Priority - Security/RBAC)
- ✅ #88 - Sinkronisasi Alur Verifikasi Single Flow (High Priority - Data Integrity)

**Task Baru:**


**Task N/A (Tidak Berminat Saat Ini):**

- ℹ️ #12 - Fix Relasi Opd Model (Implementasi sudah benar)
- ℹ️ #15 - Missing Tests (Low Priority)
- ℹ️ #17 - Database Indexes (Low Priority)
- ℹ️ #22 - Enhanced Audit Logging (Medium Priority - Security)
- ℹ️ #44 - In-App Notification (Medium Priority - UX)
- ℹ️ #51 - [Task Deleted / Skipped] (Terlewat saat penomoran)

**Task Planned (Belum Dikerjakan):**


---

## 1. Validasi Batas Draft

**Status:** ✅ Done
**Prioritas:** Medium

Implementasi validasi batas draft untuk mencegah user spamming draft di PSE, Subdomain, dan Hosting.

**Limit Draft (Konsisten):**

- **PSE:** Max 2 draft per user (global)
- **Subdomain:** Max 2 draft per PSE
- **Hosting:** Max 2 draft per user (global)

**Fitur Implementasi:**

- [x] Validasi draft count di `PseController::store` (limit 2)
- [x] Validasi draft count di `SubdomainRequestController::store` (limit 2 per PSE)
- [x] Validasi draft count di `HostingRequestController::store` (limit 2)
- [x] Error message yang jelas saat limit tercapai
- [x] Alert error di halaman create (PSE, Subdomain, Hosting)
- [x] Tooltip "Draft: X/2" di tombol "Tambah" (PSE & Hosting)
- [x] Pass `$draftCount` ke view untuk tooltip

**Files Modified:**

- `app/Http/Controllers/PseController.php` - Validasi & draft count
- `app/Http/Controllers/HostingRequestController.php` - Validasi & draft count
- `resources/views/pse/index.blade.php` - Tooltip
- `resources/views/pse/create.blade.php` - Alert error
- `resources/views/hosting/index.blade.php` - Tooltip

## 2. Fitur Upload Dokumen Pendukung (Surat Permohonan)

**Status:** ✅ Done (2026-02-08)
**Prioritas:** High

**✅ Sudah Selesai:**

- Upload Surat Tugas di halaman Profile (polymorphic ke tabel `documents`)
- File storage menggunakan `public` disk
- Replace file lama saat upload baru
- **Subdomain:**
    - [x] Tambahkan input file `surat_permohonan` pada Form Create/Edit.
    - [x] Gunakan relasi polymorphic `morphOne(Document::class, 'documentable')`.
    - [x] Implementasi File Storage di `subdomain_request_letters/`.
    - [x] Validasi wajib upload saat submit.
    - [x] Display dokumen di halaman show (petugas).
    - [x] Display dokumen di halaman verifikasi (verifikator 1 & 2).
- **Hosting:**
    - [x] Tambahkan input file `surat_permohonan` pada Form Create/Edit.
    - [x] Gunakan relasi polymorphic `morphOne(Document::class, 'documentable')`.
    - [x] Implementasi File Storage di `hosting_request_letters/`.
    - [x] Validasi wajib upload saat submit.
    - [x] Display dokumen di halaman show (petugas).
    - [x] Display dokumen di halaman verifikasi (verifikator 1 & 2).

**Files Modified:**

- Backend: `SubdomainRequestController.php`, `HostingRequestController.php`, `ProfileController.php`
- Frontend: 11 Blade views (create, edit, show untuk subdomain & hosting + 4 halaman verifikasi)

---

## 5. Fitur Items Per Page

**Status:** ✅ Done (2026-02-08)
**Prioritas:** Medium

**✅ Sudah Selesai:**

- Membuat 2 komponen Blade reusable:
    - `components/form/per-page-selector.blade.php` - Dropdown selector dengan auto-submit
    - `components/ui/list-controls.blade.php` - Container untuk search + per-page selector + action buttons
- Update 11 controllers untuk support dynamic pagination:
    - Semua controller index methods sekarang accept `per_page` parameter (default: 10, options: 10/25/50/100)
    - Pagination links preserve `search` dan `per_page` query parameters
- Update 11 views untuk integrate komponen:
    - 9 views menggunakan `<x-ui.list-controls>` component
    - 2 views (issuance, verification-history) menggunakan custom form untuk preserve tab parameter
- Fitur:
    - User dapat memilih jumlah items per page (10, 25, 50, 100)
    - Selection otomatis submit form
    - Query parameters (search, per_page, tab) preserved across pagination
    - UI konsisten di semua halaman list

**Files Modified:**

- **Backend (11 Controllers):**
    - `PseController.php`
    - `PseVerificationController.php`
    - `PseVerification2Controller.php`
    - `SubdomainRequestController.php`
    - `SubdomainVerificationController.php`
    - `SubdomainVerification2Controller.php`
    - `HostingRequestController.php`
    - `HostingVerificationController.php`
    - `HostingVerification2Controller.php`
    - `IssuanceController.php`
    - `VerificationHistoryController.php`
- **Frontend (11 Views):**
    - `pse/index.blade.php`
    - `pse-verification/index.blade.php`
    - `pse-verification2/index.blade.php`
    - `subdomain/index.blade.php`
    - `subdomain-verification/index.blade.php`
    - `subdomain-verification2/index.blade.php`
    - `hosting/index.blade.php`
    - `hosting-verification/index.blade.php`
    - `hosting-verification2/index.blade.php`
    - `issuance/index.blade.php`
    - `verification-history/index.blade.php`
- **Components (2 New):**
    - `components/form/per-page-selector.blade.php`
    - `components/ui/list-controls.blade.php`

## 3. Cetak Dokumen & PDF

**Status:** ✅ Done
**Prioritas:** Medium

Fitur untuk mencetak dokumen persetujuan dan rekapitulasi data.

- [x] Install library PDF (`barryvdh/laravel-dompdf`).
- [x] Buat Layout dasar PDF (`layouts/pdf.blade.php`).
- [x] Implementasi Cetak Dokumen Persetujuan PSE (Menu Penerbitan).
- [x] Implementasi Cetak Dokumen Persetujuan Subdomain (Menu Penerbitan).
- [x] Implementasi Cetak Dokumen Persetujuan Hosting (Menu Penerbitan).
- [x] Template PDF untuk PSE Registration.
- [x] Template PDF untuk Subdomain Approval.
- [x] Template PDF untuk Hosting Approval.

## 4. Edit Nomor Registrasi PSE (Verifikator 2)

**Status:** ✅ Done
**Prioritas:** High

Verifikator 2 membutuhkan akses untuk menginput atau memperbaiki Nomor Registrasi PSE (Tanda Daftar).

- [x] Tambahkan menu "Penerbitan" (Issuance) khusus Verifikator 2.
- [x] Implementasi Edit Nomor Registrasi via Modal di Tab PSE.
- [x] Implementasi Backend/Controller `update` & Validasi role Verifikator 2.
- [x] Route untuk update PSE registration number.
- [x] Policy authorization untuk issuance.

## 5. Fitur Items Per Page (Pagination Dinamis)

**Status:** ✅ Done (2026-02-08)
**Prioritas:** Low

Menambahkan fitur untuk mengubah jumlah data yang ditampilkan per halaman pada Table List data.

- [x] Buat komponen UI `Select` Items Per Page (10, 25, 50, 100) di view Index (PSE, Subdomain, Hosting).
- [x] Update Controller `index` method untuk menerima parameter `per_page`.
- [x] Pastikan pagination links (`$collection->links()`) tetap membawa parameter `per_page`.

**✅ Sudah Selesai:**

- Membuat 2 komponen Blade reusable:
    - `components/form/per-page-selector.blade.php` - Dropdown selector dengan auto-submit
    - `components/ui/list-controls.blade.php` - Container untuk search + per-page selector + action buttons
- Update 11 controllers untuk support dynamic pagination (default: 10, options: 10/25/50/100)
- Update 11 views untuk integrate komponen (9 views dengan `<x-ui.list-controls>`, 2 views dengan custom form)
- Query parameters (search, per_page, tab) preserved across pagination

**Files Modified:**

- **Backend (11 Controllers):** PseController, PseVerificationController, PseVerification2Controller, SubdomainRequestController, SubdomainVerificationController, SubdomainVerification2Controller, HostingRequestController, HostingVerificationController, HostingVerification2Controller, IssuanceController, VerificationHistoryController
- **Frontend (11 Views):** pse/index, pse-verification/index, pse-verification2/index, subdomain/index, subdomain-verification/index, subdomain-verification2/index, hosting/index, hosting-verification/index, hosting-verification2/index, issuance/index, verification-history/index
- **Components (2 New):** per-page-selector.blade.php, list-controls.blade.php

## 6. UI/UX Improvements & Dark Mode

**Status:** ✅ Done (Iterative)
**Prioritas:** Medium

Peningkatan antarmuka pengguna dan implementasi Dark Mode yang konsisten (Linear Style).

- [x] Implementasi Theme Config (Script Init & Toggle) tanpa flash.
- [x] Konfigurasi Warna Dark Mode (Linear/Zinc Palette).
- [x] Fix Tailwind v4 `dark:` variant dengan `@custom-variant`.
- [x] Custom Scrollbar styling untuk Dark/Light mode.
- [x] Custom Pagination View dengan styling responsif.

## 7. Fix Theme Transition Flicker

**Status:** ✅ Done
**Prioritas:** Medium

Beberapa komponen Blade mengalami kedipan (flicker) saat melakukan pergantian theme dark/light mode.

- [x] Identifikasi komponen yang mengalami flicker saat theme switch (Search Input, Form Inputs).
- [x] Analisa penyebab (Konflik `transition-all` custom dengan DaisyUI, dan `dark:shadow-none` yang instant).
- [x] Implementasi smooth transition untuk semua komponen:
    - Search Input: Gunakan `input-bordered` DaisyUI + z-index fix icon.
    - Form Inputs (Text, Select, Textarea): Hapus `dark:shadow-none`, gunakan `transition-shadow`, trust DaisyUI built-in transitions.
- [x] Pastikan tidak ada flash/kedip saat toggle theme.

## 8. Update Domain PSE saat Subdomain Diapprove

**Status:** ✅ Done (2026-02-04)
**Prioritas:** Medium

Saat pengajuan subdomain disetujui (approved), sistem harus otomatis memperbarui field `subdomain_name` pada data PSE terkait.

- [x] Modifikasi logic approve subdomain di Controller Verifikasi 2.
- [x] Update `subdomain_name` pada model PSE dengan subdomain yang disetujui.
- [x] Pastikan relasi PSE-Subdomain berjalan dengan benar.
- [x] Implementasi logic untuk handle multiple subdomain per PSE (subdomain utama vs subdomain tambahan).
- [x] Optimasi query untuk efisiensi (lazy load).

## 9. Rename Kolom PSE: domain_name → subdomain_name

**Status:** ✅ Done (2026-02-04)
**Prioritas:** High

Kolom `domain_name` pada tabel `pses` perlu di-rename menjadi `subdomain_name` agar sesuai dengan konteks aplikasi.

- [x] Buat migration baru untuk rename kolom (`RENAME COLUMN domain_name TO subdomain_name`).
- [x] Update Model `Pse` ($fillable).
- [x] Update semua View yang menggunakan `domain_name` (6 files).
- [x] Update Controller dan logic terkait (3 files).
- [x] Update dokumentasi `DATA_MODEL.md`.

## 10. Penyelarasan UI Modal Edit Tanda Daftar

**Status:** ✅ Done
**Prioritas:** Medium

Menyelaraskan styling dan behavior modal edit nomor registrasi PSE agar konsisten dengan desain modal hapus akun (Linear/Zinc style).

- [x] Identifikasi komponen modal edit tanda daftar di view `issuance`.
- [x] Update struktur HTML dan class Tailwind agar sesuai dengan modal hapus akun.
- [x] Implementasi logic agar modal otomatis terbuka kembali jika terdapat error validasi (`$errors->any()`).
- [x] Pastikan penggunaan backdrop, transisi, dan tombol aksi (cancel/save) konsisten secara visual.
- [x] Test responsivitas modal pada berbagai ukuran layar.
- [x] Implementasi error isolation per instance (errorContext) untuk mencegah cross-contamination.
- [x] Fix modal reset untuk mengembalikan input styling ke state normal.

## 11. Validasi & Normalisasi Subdomain Name dengan Suffix Otomatis

**Status:** ✅ Done (2026-02-06)
**Prioritas:** High

Memastikan setiap data subdomain yang disimpan (create/update) memiliki suffix `.batam.go.id` dan URL dengan format yang tepat.

**Scope:**

- **SubdomainRequest:** Saat create/update subdomain request
- **PSE:** Saat create/update PSE (jika subdomain_name diisi manual)

**Fitur Implementasi:**

- [x] Buat Accessor/Mutator di Model `SubdomainRequest` untuk auto-append suffix `.batam.go.id`
- [x] Buat Accessor/Mutator di Model `Pse` untuk auto-append suffix `.batam.go.id`
- [x] Validasi format subdomain (hanya lowercase, angka, dan hyphen)
- [x] Auto-generate URL dari subdomain_name (`https://{subdomain_name}`)
- [x] Update Controller untuk handle normalisasi sebelum save
- [x] Pastikan suffix tidak double (jika user input sudah ada suffix)
- [x] Update `subdomain_requests.subdomain_name` saat approval untuk konsistensi data
- [x] Tambah config `domain_suffix` di `config/app.php` dan `.env`
- [x] Fix empty state icon di `subdomain-verification2/index.blade.php`

**Contoh:**

- Input: `diskominfo` → Saved: `diskominfo.batam.go.id`
- Input: `diskominfo.batam.go.id` → Saved: `diskominfo.batam.go.id` (tidak double)
- URL: `https://diskominfo.batam.go.id`

**Files Modified:**

- `app/Models/SubdomainRequest.php` - Mutator `setSubdomainNameAttribute()` & Accessor `getSubdomainUrlAttribute()`
- `app/Models/Pse.php` - Mutator `setSubdomainNameAttribute()` & `setUrlAttribute()`
- `app/Http/Controllers/SubdomainVerification2Controller.php` - Normalisasi & update subdomain_requests
- `config/app.php` - Config `domain_suffix`
- `.env` & `.env.example` - `DOMAIN_SUFFIX=batam.go.id`
- `resources/views/subdomain-verification2/index.blade.php` - Fix empty state icon

---

## 🔍 Technical Debt & Warnings (Hasil Analisis Codebase)

**Tanggal Analisis:** 8 Februari 2026  
**Overall Codebase Rating:** 8.5/10

### 🔴 High Priority - Potensi Masalah

#### 12. ~~Fix Relasi Opd Model (Inkonsistensi)~~ - NOT A BUG ✅

**Status:** ✅ Implementasi Sudah Benar  
**Prioritas:** N/A  
**Severity:** ℹ️ Catatan untuk referensi masa depan

**Update (2026-02-06):**
Setelah verifikasi dengan dokumentasi, **implementasi saat ini SUDAH BENAR**. Relasi `Opd::user()` dengan `hasOne` sesuai dengan:

1. **Dokumentasi** [`DATA_MODEL.md:81`](file:///c:/Code/TA/Website/pse/doc/DATA_MODEL.md#L81) - "OPD memiliki satu petugas (relasi 1-ke-1)"
2. **Business Logic** - Satu OPD hanya memiliki satu petugas yang terdaftar di sistem
3. **Verifikator** tidak terikat ke OPD (`opd_id` = null)

**Catatan untuk Masa Depan:**
Jika business logic berubah dan satu OPD perlu memiliki **banyak petugas**, maka perlu:

**Lokasi:**

- `app/Models/Opd.php:23`

**Perubahan yang Diperlukan:**

```php
// app/Models/Opd.php
public function users() { // Ubah dari user() ke users()
    return $this->hasMany(User::class);
}
```

**Files to Modify (jika logic berubah):**

- [ ] `app/Models/Opd.php` - Ubah method `user()` → `users()` dan `hasOne` → `hasMany`
- [ ] `doc/DATA_MODEL.md:81` - Update dokumentasi relasi
- [ ] Cek semua Controller/View yang menggunakan `$opd->user` → ubah ke `$opd->users`

---

#### 13. Refactor Code Duplication - Validasi Subdomain

**Status:** ✅ Done (2026-02-08)
**Prioritas:** High  
**Severity:** ⚠️ Technical Debt - Maintenance burden

**Masalah:**
Validasi subdomain uniqueness di-duplicate di 3 method berbeda dalam `SubdomainRequestController`.

**Lokasi:**

- `app/Http/Controllers/SubdomainRequestController.php`

**Solusi:**
Refactor ke method reusable di Model `SubdomainRequest`.

**Implementasi Selesai:**

- [x] `app/Models/SubdomainRequest.php` - Tambah static method `normalizeSubdomainName()` & `checkAvailability()`
- [x] `app/Http/Controllers/SubdomainRequestController.php` - Refactor `store()`, `update()`, `submit()` untuk gunakan method baru.

---

#### 14. Missing Logging untuk Critical Actions

**Status:** ✅ Done (2026-02-08)
**Prioritas:** High  
**Severity:** ⚠️ Security/Audit Risk

**Masalah:**
Tidak ada logging untuk critical actions seperti:

- Approve/Reject PSE
- Approve/Reject Subdomain
- Approve/Reject Hosting
- Update Registration Number
- Delete PSE/Subdomain/Hosting

**Lokasi:**

- `app/Http/Controllers/PseVerificationController.php`
- `app/Http/Controllers/PseVerification2Controller.php`
- `app/Http/Controllers/SubdomainVerificationController.php`
- `app/Http/Controllers/SubdomainVerification2Controller.php`
- `app/Http/Controllers/HostingVerificationController.php`
- `app/Http/Controllers/HostingVerification2Controller.php`
- `app/Http/Controllers/IssuanceController.php`
- `app/Http/Controllers/PseController.php`
- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/HostingRequestController.php`

**Dampak:**

- Tidak ada audit trail untuk critical actions
- Sulit debugging jika ada masalah
- Tidak compliance dengan security best practices

**Solusi:**
Tambahkan logging di setiap critical action:

```php
use Illuminate\Support\Facades\Log;

// Contoh di approve action
Log::info('PSE approved by verifikator_2', [
    'action' => 'approve',
    'resource_type' => 'pse',
    'resource_id' => $pse->id,
    'resource_uuid' => $pse->uuid,
    'user_id' => Auth::id(),
    'user_email' => Auth::user()->email,
    'timestamp' => now()->toIso8601String(),
    'ip_address' => request()->ip(),
]);
```

**Implementasi Selesai:**

- [x] `PseVerificationController.php` - Add logging di `approve()` & `reject()`
- [x] `PseVerification2Controller.php` - Add logging di `approve()` & `reject()`
- [x] `SubdomainVerificationController.php` - Add logging di `approve()` & `reject()`
- [x] `SubdomainVerification2Controller.php` - Add logging di `approve()` & `reject()`
- [x] `HostingVerificationController.php` - Add logging di `approve()` & `reject()`
- [x] `HostingVerification2Controller.php` - Add logging di `approve()` & `reject()`
- [x] `IssuanceController.php` - Add logging di `updatePse()`
- [x] `PseController.php` - Add logging di `destroy()`
- [x] `SubdomainRequestController.php` - Add logging di `destroy()`
- [x] `HostingRequestController.php` - Add logging di `destroy()`

**Total:** 10 Controllers, 16 Log Points

**Log Location:** `storage/logs/laravel.log`

---

### 🟡 Medium Priority - Code Quality

#### 15. Missing Unit & Feature Tests

**Status:** ℹ️ N/A (Tidak berminat saat ini)  
**Prioritas:** Medium  
**Severity:** ⚠️ Quality Risk - No test coverage

**Masalah:**
Tidak ada unit tests atau feature tests yang terlihat di folder `tests/`.

**Dampak:**

- Tidak ada confidence saat refactoring
- Tidak ada regression prevention
- Sulit detect breaking changes

**Solusi:**
Buat tests untuk:

**Unit Tests:**

- [ ] Model mutators/accessors (User phone normalization, Pse subdomain normalization)
- [ ] Policy authorization logic (PsePolicy, SubdomainRequestPolicy, HostingRequestPolicy)
- [ ] Helper functions (DateHelper, StatusHelper)

**Feature Tests:**

- [ ] PSE CRUD flow (create, read, update, delete, submit)
- [ ] Subdomain request flow (create, submit, verify level 1, verify level 2)
- [ ] Hosting request flow (create, submit, verify level 1, verify level 2)
- [ ] Authorization (role-based access control)
- [ ] Validation (draft limits, subdomain uniqueness)

**Files to Create:**

- [ ] `tests/Unit/Models/UserTest.php`
- [ ] `tests/Unit/Models/PseTest.php`
- [ ] `tests/Unit/Models/SubdomainRequestTest.php`
- [ ] `tests/Unit/Policies/PsePolicyTest.php`
- [ ] `tests/Unit/Helpers/DateHelperTest.php`
- [ ] `tests/Unit/Helpers/StatusHelperTest.php`
- [ ] `tests/Feature/PseManagementTest.php`
- [ ] `tests/Feature/SubdomainRequestTest.php`
- [ ] `tests/Feature/HostingRequestTest.php`
- [ ] `tests/Feature/AuthorizationTest.php`

---

#### 16. Error Messages Hardcoded (Tidak Pakai Language Files)

**Status:** ✅ Done (2026-02-08)
**Prioritas:** Medium  
**Severity:** ⚠️ Maintenance burden

**Masalah:**
Error messages di-hardcode di Controllers, tidak menggunakan language files.

**Contoh:**

```php
return back()->with('error', 'Anda sudah memiliki 2 draft PSE. Ajukan atau hapus draft yang ada terlebih dahulu.');
```

**Dampak:**

- Sulit maintenance (harus cari di banyak file)
- Tidak support internationalization
- Inkonsistensi pesan error

**Solusi:**
Gunakan language files:

```php
// resources/lang/id/messages.php
'draft_limit_exceeded' => 'Anda sudah memiliki :count draft :resource. Ajukan atau hapus draft yang ada terlebih dahulu.',

// Controller
return back()->with('error', __('messages.draft_limit_exceeded', [
    'count' => 2,
    'resource' => 'PSE',
]));
```

**Implementasi Selesai:**

- [x] `lang/id/messages.php` - Buat file untuk error messages
- [x] Update semua Controllers untuk gunakan `__()` helper
- [x] Refactor 11 Controller & 1 Model

---

### 🟢 Low Priority - Optimization

#### 17. Missing Database Indexes untuk Performa

**Status:** ℹ️ N/A (Tidak berminat saat ini)  
**Prioritas:** Low  
**Severity:** ℹ️ Performance optimization

**Masalah:**
Tidak ada indexes untuk query yang sering digunakan.

**Query yang Sering Digunakan:**

- `WHERE status = ? AND user_id = ?` (PSE, Subdomain, Hosting)
- `WHERE subdomain_name = ? AND status = ?` (SubdomainRequest)
- `WHERE request_type = ? AND status = ?` (SubdomainRequest, HostingRequest)

**Solusi:**
Tambahkan indexes di migration baru:

```php
// Migration baru
$table->index(['status', 'user_id']);
$table->index(['subdomain_name', 'status']);
$table->index(['request_type', 'status']);
```

**Files to Create:**

- [ ] `database/migrations/YYYY_MM_DD_HHMMSS_add_indexes_for_performance.php`

---

#### 18. Soft Delete untuk User

**Status:** ✅ Done  
**Prioritas:** Low  
**Severity:** ℹ️ Feature enhancement

**Analisis:**

- `Pse`, `Subdomain`, `Hosting` **tidak perlu** soft delete — policy sudah membatasi delete hanya pada status `draft`, dan data `draft` tidak memiliki nilai audit. Status `pending_*`, `approved`, `rejected` sudah diproteksi di `PsePolicy::delete()`.
- **`User`** adalah satu-satunya model yang layak soft delete karena memiliki cascade impact ke banyak tabel referensi.

**Masalah:**
User yang dihapus (hard delete) menyebabkan kehilangan konteks audit di tabel-tabel yang mereferensikan `user_id`:

- `verification_histories.user_id` — siapa yang memverifikasi jadi `null`
- `pses.user_id`, `subdomain_requests.user_id`, `hosting_requests.user_id` — pemilik pengajuan jadi tidak terlacak

**Dampak:**

- Akun yang terhapus tidak bisa dipulihkan
- Audit trail verifikasi kehilangan informasi verifikator

**Solusi:**
Tambahkan soft delete hanya pada `User`:

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    use SoftDeletes;
}
```

**Files to Modify:**

- [x] `app/Models/User.php` — tambah trait `SoftDeletes`
- [x] Migration baru untuk menambah kolom `deleted_at` pada tabel `users`
- [x] Pastikan query yang melibatkan `user_id` tetap berfungsi dengan baik (relasi Eloquent otomatis exclude soft-deleted)

---

### 📊 Summary Temuan

| Priority          | Count | Status       |
| ----------------- | ----- | ------------ |
| 🔴 High           | 0     | ✅ Done      |
| 🟡 Medium         | 1     | ⏳ Pending   |
| 🟢 Low            | 3     | ⏳ Pending   |
| ℹ️ Reference      | 1     | ✅ Not a Bug |
| **Total Pending** | **4** |              |

**Rekomendasi Urutan Pengerjaan:**

1. Task #14 - Missing Logging (Security/Audit) - **HIGH PRIORITY**
2. Task #13 - Refactor Code Duplication (Maintenance) - **HIGH PRIORITY**
3. Task #15 - Missing Tests (Quality)
4. Task #16 - Error Messages (Maintenance)
5. Task #17 - Database Indexes (Performance)
6. Task #18 - Soft Deletes (Feature)

**Catatan:**

- Task #12 (Relasi Opd Model) - Implementasi sudah benar, dicatat untuk referensi jika business logic berubah

---

## 🔒 Security Enhancements (Berdasarkan doc/SECURITY.md)

#### 19. Rate Limiting untuk Form Submissions

**Status:** ✅ Done (2026-02-10)
**Prioritas:** High  
**Severity:** 🔴 Security Risk - Prevent abuse

**Masalah:**
Rate limiting hanya ada di login/auth routes. Form submissions (PSE, Subdomain, Hosting) tidak ada throttling.

**Referensi:** `doc/SECURITY.md:226-270`

**Dampak:**

- User bisa spam form submission
- Tidak ada protection dari DDoS attack
- Server resources bisa di-abuse

**Solusi:**
Tambahkan throttle middleware di routes:

```php
// routes/web.php
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    // Max 60 requests per minute untuk semua authenticated routes
});

// Specific throttling untuk form submissions
Route::post('/pse', [PseController::class, 'store'])
    ->middleware('throttle:10,1'); // Max 10 submissions per minute

Route::post('/subdomain', [SubdomainRequestController::class, 'store'])
    ->middleware('throttle:10,1');

Route::post('/hosting', [HostingRequestController::class, 'store'])
    ->middleware('throttle:10,1');
```

**Implementasi Selesai:**

- [x] `routes/web.php` - Add global throttle (60 req/min)
- [x] `routes/web.php` - Add specific throttle (10 req/min) untuk 6 form routes
- [x] Throttle by user ID (tidak saling mempengaruhi antar user)

**Catatan: Verifikator Tidak Perlu Throttle Khusus**

Verifikator hanya mendapat global throttle (60 req/min), tidak perlu throttle lebih ketat karena:

1. **Bukan Target Spam** - Verifikator hanya approve/reject data yang sudah ada, tidak bisa create data baru
2. **Natural Limit** - Jumlah data pending terbatas (tergantung submission petugas)
3. **Business Logic Protection** - Setelah approve/reject, status berubah dan tidak bisa di-approve lagi
4. **Policy Protection** - Hanya bisa approve jika status sesuai (pending_1/pending_2)

| Aspek               | Petugas                        | Verifikator                       |
| ------------------- | ------------------------------ | --------------------------------- |
| **Bisa spam?**      | ✅ Ya (create unlimited draft) | ❌ Tidak (hanya approve existing) |
| **Natural limit**   | ❌ Tidak ada                   | ✅ Ada (jumlah pending terbatas)  |
| **Throttle needed** | ✅ Ya (10 req/min)             | ✅ Cukup global (60 req/min)      |

---

#### 20. File Upload Security Validation

**Status:** ✅ Done (2026-02-10)  
**Prioritas:** High  
**Severity:** 🔴 Security Risk - Malicious file upload

**Masalah:**
File upload untuk dokumen surat permohonan sudah ada, tapi validasi security belum lengkap.

**Referensi:** `doc/SECURITY.md:881-900`

**Dampak:**

- User bisa upload file berbahaya (executable, script)
- File size tidak dibatasi (bisa DDoS via storage)
- Filename bisa di-exploit

**Solusi yang Diterapkan:**
✅ Double MIME validation (`mimes:pdf` + `mimetypes:application/pdf`)  
✅ UUID-based storage filename (unpredictable)  
✅ Descriptive download filename (user-friendly)  
✅ Private storage (tidak bisa direct URL access)  
✅ Authorization check via policy (DocumentController)  
✅ Helper function `format_filename_timestamp()` untuk konsistensi  
✅ UI Updates (Preview mode enabled di 9 views)
✅ DocumentController menggunakan `inline` disposition (Preview PDF)

**Files Modified:**

- ✅ `app/Helpers/DateHelper.php` - Added `format_filename_timestamp()` helper
- ✅ `SubdomainRequestController.php` - Enhanced validation (store & update)
- ✅ `HostingRequestController.php` - Enhanced validation (store & update)
- ✅ `ProfileUpdateRequest.php` - Enhanced validation for assignment_letter
- ✅ `ProfileController.php` - UUID storage & descriptive filename
- ✅ `config/filesystems.php` - Added private disk configuration
- ✅ `app/Http/Controllers/DocumentController.php` - Created for secure download/preview
- ✅ `app/Policies/UserPolicy.php` - Created for User authorization
- ✅ `app/Providers/AuthServiceProvider.php` - Registered UserPolicy
- ✅ `routes/web.php` - Added document download route
- ✅ `resources/views/**/*` - Updated 9 view files to use secure route

**Security Improvements:**

- 🔒 Prevent malicious file upload (double MIME check)
- 🔒 Prevent direct file access (private storage)
- 🔒 Prevent filename exploit (UUID random)
- 🔒 Authorization check (policy-based download)

---

#### 21. Security Headers Implementation

**Status:** ✅ Done (2026-02-10)
**Prioritas:** Medium  
**Severity:** ⚠️ Security Enhancement

**Masalah:**
Beberapa security headers belum diimplementasikan (X-Content-Type-Options, X-XSS-Protection, Referrer-Policy).

**Referensi:** `doc/SECURITY.md:759-789`

**Dampak:**

- Tidak ada protection dari MIME sniffing
- Browser XSS filter tidak aktif
- Referrer information tidak dikontrol

**Solusi:**
Buat middleware untuk security headers:

```php
// app/Http/Middleware/SecurityHeaders.php
namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        return $response;
    }
}
```

**Implementasi Selesai:**

- [x] `app/Http/Middleware/SecurityHeaders.php` - Create middleware
- [x] `app/Http/Kernel.php` - Register middleware di `web` group
- [x] 4 Security headers ditambahkan ke semua response

---

#### 22. Enhanced Audit Logging (Activity Log)

**Status:** ⏳ Pending  
**Prioritas:** Medium  
**Severity:** ⚠️ Compliance & Forensics

**Masalah:**
Audit logging hanya ada untuk critical actions (Task #14). Belum ada comprehensive activity log untuk semua user actions.

**Referensi:** `doc/SECURITY.md:273-329`

**Dampak:**

- Tidak ada track untuk login/logout
- Tidak ada track untuk failed login attempts
- Tidak ada track untuk data access (view)
- Sulit forensic analysis jika ada incident

**Solusi:**
Implementasi logging komprehensif menggunakan package **`spatie/laravel-activitylog`** untuk efisiensi dan fitur pelacakan perubahan data (Dirty Attributes/Before-After) yang handal.

**Fitur Utama:**

- Otomatis mencatat perubahan pada model (`Pse`, `User`, `SubdomainRequest`, `HostingRequest`)
- Menyimpan _snapshot_ data lama dan data baru dalam format JSON
- Mencatat IP Address, User Agent, dan metadata aktor

**Rencana Implementasi:**

```php
// Contoh penggunaan pada Model
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pse extends Model {
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly(['system_name', 'status', 'registration_number'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

**Files to Create/Modify:**

- [ ] Install via Composer: `spatie/laravel-activitylog`
- [ ] Publish & Run Migration (table `activity_log`)
- [ ] `app/Models/*.php` - Menambahkan trait `LogsActivity` pada model utama
- [ ] `app/Http/Middleware/CheckSsoMiddleware.php` - Tambah logging manual untuk Login/Logout SSO
- [ ] `app/Http/Controllers/ActivityLogController.php` & View Dashboard Log (Verifikator only)

---

#### 23. Migrasi ke Single Sign-On (SSO) Authentication

**Status:** ✅ Done (2026-02-11)  
**Prioritas:** High  
**Severity:** 🔴 Architecture Change - Breaking Change

**Masalah:**
Sistem saat ini menggunakan Laravel Breeze untuk autentikasi (login, register, password reset, email verification). Perlu migrasi ke SSO (Single Sign-On) menggunakan header-based authentication dari sistem eksternal.

**Referensi Middleware SSO:**

```php
// Header yang digunakan:
// - x-bb-sus: Email petugas (role: petugas)
// - x-bb-pub: Email publik (role: publik)
```

**Solusi yang Diterapkan:**

**1. Authentication Core:**

- ✅ Created `CheckSsoMiddleware.php` - Required SSO authentication
    - Validates SSO headers (`x-bb-sus` for internal users, `x-bb-pub` for public)
    - Auto-login via `Auth::login($user)`
    - Supports all internal roles (petugas, verifikator_1, verifikator_2)
    - Role change detection with dashboard redirect
    - Proper HTTP status codes (401 for auth errors, 403 for authorization errors)
    - Public access placeholder message
- ✅ Created `CheckSsoOptionalMiddleware.php` - Optional SSO for public pages
    - Clears stale sessions when no SSO header present
    - Auto-login if valid SSO header exists
    - Applied to welcome page route

**2. Middleware Refactoring:**

- ✅ Renamed `CheckRole.php` → `CheckRoleMiddleware.php` (Laravel convention)
- ✅ Renamed `SecurityHeaders.php` → `SecurityHeadersMiddleware.php` (Laravel convention)
- ✅ Registered all middleware in `app/Http/Kernel.php`

**3. Routes Configuration:**

- ✅ Updated `routes/web.php`:
    - Replaced `auth` middleware → `check.sso` for all authenticated routes
    - Added POST `/logout` route (session flush only)
    - Added `check.sso.optional` middleware to welcome page
    - Removed `require __DIR__.'/auth.php';`
- ✅ Deleted `routes/auth.php` (entire file)
- ✅ Deleted `routes/api.php` (entire file)

**4. Controllers Cleanup:**

- ✅ Deleted `app/Http/Controllers/Auth/` directory (9 files):
    - AuthenticatedSessionController, ConfirmablePasswordController
    - EmailVerificationNotificationController, EmailVerificationPromptController
    - NewPasswordController, PasswordController, PasswordResetLinkController
    - RegisteredUserController, VerifyEmailController
- ✅ Updated `ProfileController.php`:
    - Removed `Auth::logout()` from destroy method (SSO handles auth externally)
    - Kept profile update and OPD update logic
- ✅ Deleted `app/Http/Requests/Auth/LoginRequest.php`

**5. Providers Updates:**

- ✅ Updated `EventServiceProvider.php`:
    - Removed `Registered` event listener (user registration handled by SSO)
- ✅ Updated `RouteServiceProvider.php`:
    - Commented out API routes registration (api.php deleted)

**6. Package Cleanup:**

- ✅ Removed Laravel Sanctum:
    - Ran `composer remove laravel/sanctum`
    - Deleted `config/sanctum.php`
    - Removed `HasApiTokens` trait from User model
    - Updated `config/cors.php` (removed sanctum/csrf-cookie path)
- ✅ Removed Laravel Breeze:
    - Ran `composer remove laravel/breeze --dev`

**7. Views Cleanup:**

- ✅ Deleted `resources/views/auth/` directory (6 files):
    - login.blade.php, register.blade.php, forgot-password.blade.php
    - reset-password.blade.php, verify-email.blade.php, confirm-password.blade.php
- ✅ Deleted `resources/views/layouts/guest.blade.php`
- ✅ Deleted `resources/views/profile/partials/update-password-form.blade.php`
- ✅ Updated `resources/views/profile/edit.blade.php`:
    - Removed password update form include
- ✅ Updated `resources/views/welcome.blade.php`:
    - Removed `Route::has('login')` and `Route::has('register')` wrappers
    - Simplified to direct `@auth/@else` check
    - Fixed route('login') references → `#`
    - Dashboard link only for authenticated internal users
    - SSO-aware navigation (clears stale sessions via middleware)

**Files Created:**

- `app/Http/Middleware/CheckSsoMiddleware.php` (93 lines)
- `app/Http/Middleware/CheckSsoOptionalMiddleware.php` (93 lines)

**Files Modified:**

- `app/Http/Kernel.php` - Middleware registration
- `app/Http/Middleware/CheckRoleMiddleware.php` - Renamed from CheckRole
- `app/Http/Middleware/SecurityHeadersMiddleware.php` - Renamed from SecurityHeaders
- `routes/web.php` - SSO middleware, logout route, welcome page middleware
- `app/Http/Controllers/ProfileController.php` - Removed Auth::logout()
- `app/Providers/EventServiceProvider.php` - Removed Registered event
- `app/Providers/RouteServiceProvider.php` - Commented API routes
- `app/Models/User.php` - Removed HasApiTokens trait
- `config/cors.php` - Removed Sanctum path
- `resources/views/profile/edit.blade.php` - Removed password section
- `resources/views/welcome.blade.php` - SSO-aware navigation

**Files Deleted:**

- `routes/auth.php`
- `routes/api.php`
- `config/sanctum.php`
- `app/Http/Controllers/Auth/` (9 files)
- `app/Http/Requests/Auth/LoginRequest.php`
- `resources/views/auth/` (6 files)
- `resources/views/layouts/guest.blade.php`
- `resources/views/profile/partials/update-password-form.blade.php`

**Security Features:**

- 🔒 Header-based authentication (x-bb-sus / x-bb-pub)
- 🔒 Role validation (internal: petugas/verifikator_1/verifikator_2, public: publik)
- 🔒 Role change detection (auto-redirect to dashboard on role switch)
- 🔒 Stale session cleanup (via CheckSsoOptionalMiddleware)
- 🔒 Proper HTTP status codes (401 vs 403)
- 🔒 Public access placeholder (feature not yet available)

**Impact:**

- ✅ Centralized authentication via SSO
- ✅ No password management overhead
- ✅ Simplified user onboarding
- ✅ Profile management retained for data updates
- ✅ Role-based access control maintained
- ⚠️ Breaking change - users must authenticate via SSO
- ⚠️ Dependency on SSO provider (headers required)
- ⚠️ Local development requires mock SSO headers (ModHeader extension)

**Remaining Work:**

- [ ] Update documentation (AGENTS.md, ROLES.md, INSTALASI.md, README.md)
- [ ] Manual testing of all SSO scenarios
- [ ] Verify existing features still functional

---

#### 24. Validasi Profil Lengkap & Tampilkan Surat Tugas di Halaman Verifikasi

**Status:** ✅ Done (2026-02-11)  
**Prioritas:** High  
**Severity:** ⚠️ Data Integrity - Missing validation & verifikator visibility

**Masalah:**

1. **Missing Profile Validation:** Petugas dapat mengajukan PSE (submit) tanpa melengkapi seluruh data profil, terutama **surat tugas** (assignment letter)
2. **Missing Assignment Letter Display:** Surat tugas tidak ditampilkan di halaman detail/verifikasi PSE, sehingga verifikator tidak dapat meninjau dokumen sebelum approve/reject

**Dampak:**

- ⚠️ Data integrity issue - PSE diajukan tanpa dokumen pendukung yang valid
- ⚠️ Verifikator tidak dapat memvalidasi kelengkapan dokumen petugas
- ⚠️ Potensi approval tanpa verifikasi dokumen yang proper
- ⚠️ Tidak compliance dengan business rules (surat tugas wajib)

**Solusi yang Diterapkan:**

**1. Profile Completeness Validation:**

- ✅ Created `hasCompleteProfile()` method di `User.php` model
- ✅ Validasi 10 required fields untuk petugas:
    - Basic fields: `name`, `email`
    - Petugas-specific: `phone_number`, `nip`, `position`, `status`, `work_unit`, `work_unit_phone`, `opd_id`, `document` (surat tugas)
- ✅ Added validation di 3 controller submit methods:
    - `PseController::submit()`
    - `SubdomainRequestController::submit()`
    - `HostingRequestController::submit()`
- ✅ Redirect ke profile edit dengan error message jika profil tidak lengkap

**2. Assignment Letter Display - PSE Verification Only:**

- ✅ Added assignment letter section di `pse-verification/show.blade.php` (Verifikator 1)
- ✅ Added assignment letter section di `pse-verification2/show.blade.php` (Verifikator 2)
- ✅ Display dengan preview link menggunakan `DocumentController::show()`
- ✅ Show warning alert jika surat tugas tidak tersedia
- ❌ **NOT added** to Subdomain/Hosting verification pages (they show surat permohonan instead)

**3. User Model Enhancement:**

- ✅ Used existing `document()` polymorphic relation (no need for separate `assignmentLetter()`)
- ✅ Added `hasCompleteProfile()` method with comprehensive validation
- ✅ Validation logic separated: base fields for all users, additional fields for petugas only

**4. Language File Updates:**

- ✅ Added error message `messages.error.profile_incomplete_submit`
- ✅ Message includes OPD requirement: "Profil Anda belum lengkap. Harap lengkapi data profil, OPD, dan upload surat tugas terlebih dahulu sebelum mengajukan permohonan."

**5. Profile Page UI Enhancement:**

- ✅ Added success/error alert messages to `profile/edit.blade.php`
- ✅ Fixed "Route [verification.send] not defined" error (removed unused email verification code from Breeze)
- ✅ Cleaned up profile form by removing SSO-related verification UI

**Files Modified:**

- `app/Models/User.php` - Added `hasCompleteProfile()` method with 10 field validation
- `app/Http/Controllers/PseController.php` - Added profile validation in submit()
- `app/Http/Controllers/SubdomainRequestController.php` - Added profile validation in submit()
- `app/Http/Controllers/HostingRequestController.php` - Added profile validation in submit()
- `resources/views/pse-verification/show.blade.php` - Added assignment letter display section
- `resources/views/pse-verification2/show.blade.php` - Added assignment letter display section
- `resources/views/profile/edit.blade.php` - Added success/error message alerts
- `resources/views/profile/partials/update-profile-information-form.blade.php` - Removed email verification form
- `lang/id/messages.php` - Added `error.profile_incomplete_submit` message

**Implementation Details:**

**User Model (`app/Models/User.php`):**

```php
public function hasCompleteProfile(): bool
{
    // Required fields untuk semua user
    $required_fields = ['name', 'email'];

    foreach ($required_fields as $field) {
        if (empty($this->$field)) {
            return false;
        }
    }

    // Additional requirements untuk petugas
    if ($this->role->role_name === 'petugas') {
        // Field wajib untuk petugas
        $petugas_required_fields = ['phone_number', 'nip', 'position', 'status', 'work_unit', 'work_unit_phone'];

        foreach ($petugas_required_fields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        // Petugas harus memilih OPD dan upload surat tugas
        if (empty($this->opd_id) || !$this->document) {
            return false;
        }
    }

    return true;
}
```

**Controller Validation (Applied to PSE, Subdomain, Hosting):**

```php
// Check profile completeness (name, email, phone, OPD, assignment letter)
if (!Auth::user()->hasCompleteProfile()) {
    return redirect()
        ->route('profile.edit')
        ->with('error', __('messages.error.profile_incomplete_submit'));
}
```

**Assignment Letter Display (PSE Verification Views):**

```blade
{{-- Surat Tugas --}}
<div class="md:col-span-2">
    <div class="divider my-2"></div>
    <x-display.text-label light>{{ __('Surat Tugas') }}</x-display.text-label>
    @if($pse->user->document)
        <div class="mt-2">
            <a href="{{ route('documents.show', $pse->user->document->uuid) }}"
               target="_blank"
               class="btn btn-sm btn-outline btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ __('Lihat Surat Tugas') }}
            </a>
            <p class="text-xs text-base-content/50 mt-1">
                {{ __('Klik untuk melihat dokumen surat tugas petugas') }}
            </p>
        </div>
    @else
        <div class="alert alert-warning mt-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            <span>{{ __('Surat tugas tidak tersedia') }}</span>
        </div>
    @endif
</div>
```

**Expected Behavior:**

1. **Petugas submit tanpa profil lengkap:**
    - ❌ Submit gagal
    - 🔄 Redirect ke `/profile/edit`
    - ⚠️ Error message tampil di profile page: "Profil Anda belum lengkap. Harap lengkapi data profil, OPD, dan upload surat tugas terlebih dahulu sebelum mengajukan permohonan."

2. **Verifikator review PSE:**
    - ✅ Informasi petugas ditampilkan (nama, OPD, email, telepon)
    - ✅ Surat tugas ditampilkan dengan tombol "Lihat Surat Tugas"
    - ✅ Klik tombol → preview PDF surat tugas (inline preview)
    - ⚠️ Jika surat tugas tidak ada → warning alert "Surat tugas tidak tersedia"

**Design Decisions:**

- ✅ Used existing `document()` relation instead of creating separate `assignmentLetter()` (petugas only uploads one document type)
- ✅ Assignment letter displayed **only on PSE verification pages** (Subdomain/Hosting show surat permohonan)
- ✅ Comprehensive validation: 10 fields total for petugas (3 base + 7 petugas-specific)
- ✅ Centralized validation logic in User model for reusability

**Impact:**

- ✅ Data integrity enforced - no submissions without complete profile
- ✅ Verifikator can review assignment letter before approval
- ✅ Compliance with business rules (surat tugas mandatory)
- ✅ Better user experience with clear error messages
- ✅ Profile page now displays validation errors properly

---

#### 25. Validasi Enum Server-Side untuk Select Box Fields

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Medium  
**Severity:** ⚠️ Security - Input Validation Bypass

**Latar Belakang:**  
Temuan dari OWASP ZAP Security Scan (2026-02-18). ZAP mendeteksi bahwa field `risk_category` dan `data_classification` pada form PSE dapat diisi dengan nilai sembarang melalui POST request langsung (bypass select box di browser).

**Masalah:**  
Field yang ditampilkan sebagai `<select>` di UI tidak divalidasi dengan `in:` rule di server-side. Akibatnya, nilai seperti `Publik' OR "1"="1" --` dapat tersimpan ke database, menyebabkan **data pollution**.

**Validasi Saat Ini (Tidak Cukup):**

```php
// PseController::store() & update()
'risk_category'       => ['required', 'string', 'max:80'],   // ❌ Tidak ada enum
'data_classification' => ['required', 'string', 'max:80'],   // ❌ Tidak ada enum
```

**Solusi:**  
Tambahkan validasi `in:` sesuai nilai yang tersedia di select box form:

```php
// PseController::store() & update()
'risk_category'       => ['required', 'string', 'in:Rendah,Sedang,Tinggi'],
'data_classification' => ['required', 'string', 'in:Publik,Internal,Rahasia,Sangat Rahasia'],
```

**Catatan:**

- Field `sector` dan `storage_location` adalah free-text (textarea), tidak perlu validasi enum.
- Ini bukan SQL injection sesungguhnya (Eloquent ORM melindungi), namun perlu diperbaiki untuk mencegah data pollution dan mengurangi false positive pada security scan berikutnya.

**Files Modified:**

- [x] `app/Http/Controllers/PseController.php` - Update validasi di `store()` dan `update()`

---

#### 26. Validasi Komprehensif Field (max, regex, in) - Security Hardening

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Medium  
**Severity:** ⚠️ Security - Input Validation Hardening (Reduce OWASP ZAP False Positives)

**Latar Belakang:**  
Setelah OWASP ZAP Security Scan (2026-02-18), ditemukan bahwa field free-text tidak memiliki validasi `max:` dan `regex:` yang cukup ketat, sehingga payload SQL injection bisa tersimpan ke database (data pollution). Selain itu, beberapa field select box belum memiliki validasi `in:` di server-side (sudah diperbaiki untuk PSE di task #25).

**Tujuan:**  
Menambahkan validasi `max:`, `regex:`, dan `in:` secara komprehensif di **seluruh controller** untuk:

1. Mencegah data pollution dari karakter SQL injection (`'`, `"`, `--`)
2. Mengurangi false positive pada security scan berikutnya
3. Konsistensi validasi di seluruh aplikasi

**Catatan Regex:**  
Pattern berikut digunakan untuk field free-text (mengizinkan huruf termasuk aksara Indonesia, angka, spasi, dan karakter umum, namun **menolak** `'`, `"`, `;`, `--`):

```
/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u
```

---

### 📋 Audit Field per Controller

#### A. `PseController` — `store()` & `update()`

| Field                 | Tipe UI    | Validasi Saat Ini                           | Perubahan                  |
| --------------------- | ---------- | ------------------------------------------- | -------------------------- |
| `system_name`         | text input | `string\|max:150\|unique`                   | + `regex:`                 |
| `sector`              | text input | `string\|max:100`                           | + `regex:`                 |
| `pic_name`            | text input | `string\|max:150`                           | + `regex:`                 |
| `pic_phone`           | text input | `string\|max:30`                            | Sudah cukup                |
| `pic_email`           | text input | `email\|max:150`                            | Sudah cukup                |
| `url`                 | text input | `url\|max:255\|unique`                      | Sudah cukup                |
| `subdomain_name`      | text input | `string\|max:255\|unique`                   | Sudah ada regex di mutator |
| `description`         | textarea   | `string`                                    | + `max:2000` + `regex:`    |
| `risk_category`       | **select** | `in:Rendah,Sedang,Tinggi`                   | ✅ Sudah (task #25)        |
| `data_classification` | **select** | `in:Publik,Internal,Rahasia,Sangat Rahasia` | ✅ Sudah (task #25)        |
| `private_data_info`   | textarea   | `string`                                    | + `max:2000` + `regex:`    |
| `storage_location`    | textarea   | `string`                                    | + `max:1000` + `regex:`    |

**Files to Modify:**

- [x] `app/Http/Controllers/PseController.php`

---

#### B. `SubdomainRequestController` — `store()` & `update()`

| Field              | Tipe UI    | Validasi Saat Ini                 | Perubahan   |
| ------------------ | ---------- | --------------------------------- | ----------- |
| `pse_id`           | **select** | `exists:pses,id`                  | Sudah cukup |
| `request_type`     | **select** | `in:baru,perpanjangan,ubah,hapus` | ✅ Sudah    |
| `subdomain_name`   | text input | `max:100\|regex:/^[a-z0-9.-]+$/`  | ✅ Sudah    |
| `surat_permohonan` | file       | `mimes:pdf\|max:5120`             | ✅ Sudah    |

> ℹ️ SubdomainRequestController sudah **cukup baik** — validasi `in:` dan `regex:` sudah ada. Tidak ada perubahan diperlukan.

---

#### C. `HostingRequestController` — `store()` & `update()`

| Field                | Tipe UI                                       | Validasi Saat Ini                 | Perubahan                        |
| -------------------- | --------------------------------------------- | --------------------------------- | -------------------------------- |
| `pse_id`             | **select**                                    | `exists:pses,id`                  | Sudah cukup                      |
| `request_type`       | **select**                                    | `in:baru,ubah,perpanjangan,hapus` | ✅ Sudah                         |
| `hosting_type`       | **select**                                    | `in:shared,vps,dedicated,cloud`   | ✅ Sudah                         |
| `cpu_cores`          | **select** (nilai: 1,2,4,8,16,32)             | `integer\|min:1\|max:128`         | + `in:1,2,4,8,16,32`             |
| `ram_capacity`       | **select** (nilai: 1,2,4,8,16,32,64)          | `integer\|min:1\|max:512`         | + `in:1,2,4,8,16,32,64`          |
| `storage_capacity`   | **select** (nilai: 10,20,50,100,200,500,1000) | `integer\|min:1\|max:10000`       | + `in:10,20,50,100,200,500,1000` |
| `bandwidth_capacity` | **select** (nilai: 100,500,1000,5000)         | `integer\|min:1\|max:100000`      | + `in:100,500,1000,5000`         |
| `notes`              | textarea                                      | `string\|max:500`                 | + `regex:`                       |
| `surat_permohonan`   | file                                          | `mimes:pdf\|max:5120`             | ✅ Sudah                         |

**Files to Modify:**

- [x] `app/Http/Controllers/HostingRequestController.php`

---

#### D. `ProfileUpdateRequest` — `rules()`

| Field               | Tipe UI    | Validasi Saat Ini                                 | Perubahan   |
| ------------------- | ---------- | ------------------------------------------------- | ----------- |
| `name`              | text input | `string\|max:255`                                 | + `regex:`  |
| `email`             | text input | `email\|max:255\|unique`                          | Sudah cukup |
| `phone_number`      | text input | `numeric\|digits_between:10,30\|regex:/^[0-9]+$/` | ✅ Sudah    |
| `nip`               | text input | `numeric\|digits_between:10,30\|regex:/^[0-9]+$/` | ✅ Sudah    |
| `position`          | text input | `string\|max:100`                                 | + `regex:`  |
| `status`            | text input | `string\|max:30`                                  | + `regex:`  |
| `work_unit`         | text input | `string\|max:100`                                 | + `regex:`  |
| `work_unit_phone`   | text input | `numeric\|digits_between:10,30\|regex:/^[0-9]+$/` | ✅ Sudah    |
| `assignment_letter` | file       | `mimes:pdf\|max:5120`                             | ✅ Sudah    |
| `opd_id`            | **select** | `exists:opds,id`                                  | Sudah cukup |

**Files to Modify:**

- [x] `app/Http/Requests/ProfileUpdateRequest.php`

---

### ✅ Checklist Implementasi

**PseController:**

- [x] `system_name` — tambah `regex:`
- [x] `sector` — tambah `regex:`
- [x] `pic_name` — tambah `regex:`
- [x] `description` — tambah `max:2000` + `regex:`
- [x] `private_data_info` — tambah `max:2000` + `regex:`
- [x] `storage_location` — tambah `max:1000` + `regex:`

**HostingRequestController:**

- [x] `cpu_cores` — tambah `in:1,2,4,8,16,32`
- [x] `ram_capacity` — tambah `in:1,2,4,8,16,32,64`
- [x] `storage_capacity` — tambah `in:10,20,50,100,200,500,1000`
- [x] `bandwidth_capacity` — tambah `in:100,500,1000,5000`
- [x] `notes` — tambah `regex:`

**ProfileUpdateRequest:**

- [x] `name` — tambah `regex:`
- [x] `position` — tambah `regex:`
- [x] `status` — tambah `regex:`
- [x] `work_unit` — tambah `regex:`

---

#### 27. Standardisasi Enum PSE ke Lowercase

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Low  
**Severity:** 🔵 Code Consistency - Technical Debt

**Latar Belakang:**  
Field `risk_category` dan `data_classification` di tabel `pses` saat ini menyimpan nilai dengan kapitalisasi (`Rendah`, `Sedang`, `Tinggi` / `Publik`, `Internal`, dst). Ini inkonsisten dengan field enum lain di sistem (`request_type`, `hosting_type`, `status`) yang semuanya disimpan lowercase. Karena belum ada data produksi, standardisasi bisa dilakukan tanpa migrasi data.

**Tujuan:**  
Standardisasi nilai enum di DB agar semua field sejenis disimpan **lowercase**, transformasi ke display label ditangani di layer view dengan `ucfirst()` / `ucwords()`.

**Scope Perubahan:**

| Field                 | Sebelum                                           | Sesudah (DB)                                      | Tampilan    |
| --------------------- | ------------------------------------------------- | ------------------------------------------------- | ----------- |
| `risk_category`       | `Rendah`, `Sedang`, `Tinggi`                      | `rendah`, `sedang`, `tinggi`                      | `ucfirst()` |
| `data_classification` | `Publik`, `Internal`, `Rahasia`, `Sangat Rahasia` | `publik`, `internal`, `rahasia`, `sangat rahasia` | `ucwords()` |

**Checklist:**

- [x] Update validasi `in:` di `PseController::store()` — `risk_category` dan `data_classification`
- [x] Update validasi `in:` di `PseController::update()` — `risk_category` dan `data_classification`
- [x] Update `pse/create.blade.php` — option values lowercase, display `ucwords()`
- [x] Update `pse/edit.blade.php` — option values lowercase, selected comparison, display `ucwords()`
- [x] Update `pse/show.blade.php` — display `ucwords()`
- [x] Update `pse-verification/show.blade.php` — display `ucwords()`
- [x] Update `pse-verification2/show.blade.php` — display `ucwords()`
- [x] Update `reports/pse_registration.blade.php` — display `ucwords()`

**Files Modified:**

- [x] `app/Http/Controllers/PseController.php`
- [x] `resources/views/pse/create.blade.php`
- [x] `resources/views/pse/edit.blade.php`
- [x] `resources/views/pse/show.blade.php`
- [x] `resources/views/pse-verification/show.blade.php`
- [x] `resources/views/pse-verification2/show.blade.php`
- [x] `resources/views/reports/pse_registration.blade.php`

---

#### 28. Content Security Policy (CSP) Header

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Medium  
**Severity:** ⚠️ Security - OWASP ZAP Finding (17 instance)

**Latar Belakang:**  
OWASP ZAP Scan (2026-02-18) mendeteksi `Content-Security-Policy` header tidak di-set pada 17 halaman aplikasi. Task #21 sudah mengimplementasi beberapa security headers (`X-Frame-Options`, `X-Content-Type-Options`, dll), namun **CSP kini dapat dikonfigurasi lebih ketat** setelah penghapusan Alpine.js (Task #77) dan lokalisasi seluruh aset (Vite & ApexCharts).

**Temuan ZAP:**

- `CSP: Failure to Define Directive with No Fallback`
- `CSP: Wildcard Directive`
- `CSP: script-src unsafe-eval`
- `CSP: style-src unsafe-inline`
- `Content Security Policy (CSP) Header Not Set` (17 instance in-scope)

**Catatan:**  
Sebagian alert CSP berasal dari domain luar (Google, darkreader.org) yang ikut ter-scan lewat proxy. Fokus hanya pada `http://10.1.78.50:8000`.

**Solusi:**  
Tambahkan CSP header di middleware `SecurityHeaders.php` yang sudah ada (Task #21):

```php
$csp = implode('; ', [
    "default-src 'self'",
    "script-src 'self' 'unsafe-inline' cdn.jsdelivr.net",
    "style-src 'self' 'unsafe-inline' fonts.googleapis.com",
    "font-src 'self' fonts.gstatic.com",
    "img-src 'self' data:",
    "connect-src 'self'",
    "frame-ancestors 'self'",
]);
$response->headers->set('Content-Security-Policy', $csp);
```

**Checklist:**

- [x] Identifikasi semua sumber eksternal (CDN, font, dll) yang dipakai app
- [x] Update `SecurityHeadersMiddleware.php` — tambah CSP header
- [x] Test: pastikan UI tidak pecah (Vite + ApexCharts tetap berjalan tanpa Alpine.js)
- [ ] Test: cek CSP error di browser DevTools Console

**Files to Modify:**

- [x] `app/Http/Middleware/SecurityHeadersMiddleware.php`

---

#### 29. Session & Cookie Security Configuration

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Low  
**Severity:** 🟡 Security - OWASP ZAP Finding

**Latar Belakang:**  
OWASP ZAP mendeteksi cookie tidak memiliki flag keamanan yang proper:

- `Cookie No HttpOnly Flag` (22 instance)
- `Cookie Without Secure Flag` (8 instance)
- `Cookie with SameSite Attribute None` (16 instance)
- `Cookie without SameSite Attribute` (16 instance)
- `Loosely Scoped Cookie` (28 instance)

**Catatan:**  
Sebagian besar alert berasal dari cookie domain luar (Google, dll). Fokus perbaikan hanya pada **session cookie Laravel** (`laravel_session`, `XSRF-TOKEN`).

**Solusi:**  
Verifikasi dan update konfigurasi `config/session.php`:

```php
'secure'    => env('SESSION_SECURE_COOKIE', false), // true wajib di production HTTPS
'http_only' => true,   // sudah default true di Laravel
'same_site' => 'lax',  // pastikan bukan 'none'
```

**Checklist:**

- [x] Cek `config/session.php` — `http_only = true` ✅, `same_site = 'lax'` ✅ (sudah benar)
- [x] Dokumentasikan: `SESSION_SECURE_COOKIE=true` wajib di-set saat production HTTPS
- [x] Tambahkan `SESSION_SECURE_COOKIE=false` di `.env.example` sebagai placeholder

**Files to Modify:**

- [x] `config/session.php` (verifikasi — tidak perlu perubahan, sudah benar)
- [x] `.env.example`

---

#### 30. Hapus Debug Info & Pastikan APP_DEBUG=false di Production

**Status:** ✅ Done (2026-02-19)  
**Prioritas:** Medium  
**Severity:** ⚠️ Security - Info Disclosure (OWASP ZAP Informational)

**Latar Belakang:**  
OWASP ZAP (kategori Informational) menemukan:

1. **`Illuminate\Database\QueryException` + stack trace** muncul di salah satu response — terjadi karena `APP_DEBUG=true` saat scan dilakukan.
2. **HTML comment `<!-- User Info -->`** di beberapa halaman — ZAP menandai sebagai "Suspicious Comments" karena mengandung kata sensitif.

**Risiko:**

- Stack trace mengungkap struktur database, nama tabel, nama kolom kepada attacker
- Exception detail memudahkan pemetaan sistem

**Solusi:**

**1. APP_DEBUG** — Pastikan `APP_DEBUG=false` di `.env` production. Ini konfigurasi environment, bukan perubahan kode.

**2. HTML Comments** — Hapus atau ganti komentar `<!-- User Info -->` dari views. Komentar HTML tetap tampil di source page dan bisa dibaca attacker.

**Checklist:**

- [x] Audit semua views — cari `<!-- User Info -->` dan komentar HTML lain yang sensitif
- [x] Hapus/ganti komentar yang mengandung kata: `user`, `info`, `password`, `token`, `db`, `query`, `debug` (Done: sidebar.blade.php)
- [x] Konfirmasi `APP_DEBUG=false` dan `APP_ENV=production` di `.env` production server (Done: updated .env)
- [x] Tambahkan `APP_DEBUG=false` di `.env.example` sebagai default aman (Done: updated .env.example)

**Files to Modify:**

- [x] Views yang mengandung komentar HTML sensitif (Done: `resources/views/layouts/sidebar.blade.php`)
- [x] `.env.example`

---

## 31. Security Hardening: Verifikator 1 Remediation (False Positives & Headers)

**Status:** ✅ Done (2026-02-19)
**Prioritas:** Medium
**Severity:** ⚠️ Security Hardening

**Latar Belakang:**
Hasil scan OWASP ZAP untuk aktor Verifikator 1 menemukan potensi SQL Injection (High) dan beberapa masalah header/cookie (Medium). Analisis awal menunjukkan SQLi adalah false positive, namun perbaikan konfigurasi header dan cookie tetap diperlukan.

**Temuan:**

1.  **SQL Injection (Time Based)** pada endpoint `approve`: False Positive. Aplikasi menggunakan Eloquent ORM dan validasi regex yang ketat.
2.  **Missing Security Headers** pada beberapa halaman: Kemungkinan karena middleware `SecurityHeaders` hanya di group `web`, bukan global.
3.  **Cookie Security**: Flag `secure` absen di local development (wajar), perlu ditegaskan konfigurasinya untuk production.

**Rencana Perbaikan:**

- [x] Konfirmasi SQLi sebagai False Positive dengan analisis kode (Eloquent usage).
- [x] Pindahkan `SecurityHeadersMiddleware` ke Global Stack di `Kernel.php` agar mencakup semua response (termasuk error pages).
- [x] Dokumentasikan konfigurasi cookie aman di `.env.example`.
- [x] Re-test header presence (manual check).

**Files Modified:**

- `app/Http/Kernel.php`
- `.env.example`

---

## 32. Security Hardening: Petugas Remediation Part 2 (Path Traversal & CSP)

**Status:** ✅ Done (2026-02-19)
**Prioritas:** Medium
**Severity:** ⚠️ Security Hardening

**Latar Belakang:**
Hasil scan OWASP ZAP (Petugas Part 2) menemukan 1 High (Path Traversal), 3 Medium (CSP), dan beberapa Low findings. Analisis kode perlu dilakukan untuk memverifikasi temuan High dan memperbaiki temuan lain yang valid.

**Temuan:**

1.  **Path Traversal (High)** pada `POST /pse`: Indikasi **False Positive**. Endpoint hanya menyimpan data teks ke database via Eloquent, tidak ada operasi file system berdasarkan input user.
2.  **CSP unsafe-inline (Medium)**: Keharusan `unsafe-inline` kini berkurang setelah penghapusan Alpine.js. Perlu dievaluasi untuk memperketat (nonce/hash) pada aset Vite.
3.  **X-Powered-By Header (Low)**: Header ini membocorkan versi PHP. Perlu dihapus via Middleware atau Config.
4.  **Cookie HttpOnly (Low)**: `XSRF-TOKEN` memang didesain tidak HttpOnly agar bisa dibaca Axios/JS. `laravel_session` wajib HttpOnly (sudah verified di Task #29).

**Rencana Perbaikan:**

- [x] **Verifikasi Path Traversal:** Dokumentasikan analisis code `PseController::store` sebagai bukti False Positive.
- [x] **Hapus X-Powered-By:** Update `SecurityHeadersMiddleware` untuk remove header ini.
- [x] **Review CSP:** Peluang menghapus `unsafe-inline` kini terbuka lebar setelah Alpine.js dihapus (Task #77).
- [x] **Dokumentasi False Positives:** Buat file `doc/SECURITY_EXCEPTIONS.md` untuk mencatat temuan ZAP yang false positive/accepted risk agar audit berikutnya lebih cepat.

**Files Modified:**

- `app/Http/Middleware/SecurityHeadersMiddleware.php`
- `doc/SECURITY_EXCEPTIONS.md` (New)

---

## 33. Refactor Subdomain Name Storage (Prefix Only)

**Status:** ✅ Done (2026-02-20)
**Prioritas:** High

Refactor cara penyimpanan `subdomain_name` agar **HANYA** menyimpan prefix (contoh: `sistem1`), bukan FQDN lengkap (`sistem1.batam.go.id`). Suffix harus otomatis dibuang saat save, dan otomatis di-reconstruct saat access.

**Scope:**

- **Pse Model:** Update Mutator agar strip suffix, Accessor agar return full URL.
- **SubdomainRequest Model:** Update Mutator agar strip suffix, Accessor agar return full URL.
- **Controllers:** Input normalization sebelum validation (untuk allow FQDN input).
- **Tujuan:** Data di DB bersih (hanya prefix), validasi unik bekerja akurat terhadap input user.
- **Catatan:** Tidak ada data migration untuk data lama (hanya berlaku untuk data baru/update).

**Files Modified:**

- `app/Models/Pse.php`
- `app/Models/SubdomainRequest.php`
- `app/Http/Controllers/PseController.php`
- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/SubdomainVerification2Controller.php`

---

## 34. Fix 500 Error on PSE Creation (Nullable `opd_id`)

**Status:** ✅ Done (2026-02-20)
**Prioritas:** High
**Severity:** 💥 Critical Bug

**Latar Belakang:**
User mengalami 500 Server Error (`Integrity constraint violation: 1048 Column 'opd_id' cannot be null`) saat membuat PSE baru. Hal ini karena tabel `pses` mewajibkan `opd_id` (NOT NULL), sedangkan user saat ini (Verifikator/Petugas baru) mungkin belum memiliki OPD. Requirement baru menyatakan bahwa `opd_id` **tidak wajib** saat create (draft), tapi **wajib** saat submit.

**Rencana Perbaikan:**

- [x] **Database Migration:** Buat migration baru untuk mengubah kolom `pses.opd_id` menjadi `nullable`.
- [x] **Update Dokumentasi:** Sesuaikan `doc/DATA_MODEL.md`.
- [x] **Controller Logic (Store):** Update `PseController::store` untuk mengizinkan input tanpa `opd_id`.
- [x] **Controller Logic (Submit):** Update `PseController::submit` untuk melakukan _sync_ `opd_id` dari user ke PSE sebelum submit, dan memvalidasi keberadaannya.

**Files Modified:**

- `database/migrations/2026_02_20_144807_make_pses_opd_id_nullable.php` (New)
- `doc/DATA_MODEL.md`
- `app/Http/Controllers/PseController.php`

---

## 35. Refactor Subdomain Logic (DRY Helper)

**Status:** ✅ Done (2026-02-20)
**Prioritas:** Medium
**Severity:** 🧹 Code Quality

**Latar Belakang:**
Logic normalisasi subdomain (strip suffix) saat ini terduplikasi di `PseController`, `SubdomainRequestController`, dan `Pse/SubdomainRequest` models. Sebaiknya dibuatkan Helper terpusat agar DRY (_Don't Repeat Yourself_) dan mudah di-maintenance.

**Rencana Perbaikan:**

- [x] **Create Helper:** Buat class `App\Helpers\SubdomainHelper` dengan static method `normalize()` dan `generateUrl()`.
- [x] **Refactor Controllers:** Ganti inline logic di `PseController` dan `SubdomainRequestController` dengan panggilan ke Helper.
- [x] **Refactor Models:** Update Accessor/Mutator di `Pse` dan `SubdomainRequest` untuk menggunakan Helper yang sama.

**Files Modified:**

- `app/Helpers/SubdomainHelper.php` (New)
- `app/Http/Controllers/PseController.php`
- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Models/Pse.php`
- `app/Models/SubdomainRequest.php`

---

## 36. Cleanup CDN & Standarisasi Font + ApexCharts via npm

**Status:** ✅ Done (2026-02-23)
**Prioritas:** Medium
**Severity:** 🧹 Code Quality & Performance

**Latar Belakang:**
Hasil analisis codebase menunjukkan 3 masalah terkait CDN dan font:

1. Font **Figtree** dimuat dari `fonts.bunny.net` di `layouts/app.blade.php` padahal tidak dipakai (sisa boilerplate Laravel).
2. Font **Inter** di-load dua kali — sudah di-import di `app.css` via `@import url(...)`, namun dimuat lagi secara redundan di `<head>` `welcome.blade.php`.
3. **ApexCharts** dimuat via CDN (`cdn.jsdelivr.net`) tanpa ada di `package.json`, sehingga jika CDN down maka chart tidak berfungsi. Seharusnya di-install via npm agar bundled bersama Vite.
4. Warna chart di `chart.blade.php` menggunakan **hex hardcode** (`#422ad5`, dll), tidak menggunakan CSS variable DaisyUI sehingga tidak responsif terhadap perubahan tema.

**Checklist:**

**A. Cleanup Font CDN:**

- [x] Hapus baris `<link rel="preconnect" href="https://fonts.bunny.net">` di `layouts/app.blade.php`
- [x] Hapus baris `<link href="https://fonts.bunny.net/css?family=figtree:...">` di `layouts/app.blade.php`
- [x] Hapus baris `<link rel="preconnect" href="https://fonts.googleapis.com">` di `welcome.blade.php`
- [x] Hapus baris `<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>` di `welcome.blade.php`
- [x] Hapus baris `<link href="https://fonts.googleapis.com/css2?family=Inter:...">` di `welcome.blade.php`
- [x] Hapus inline `<style>` blok `font-family: 'Inter'` di `welcome.blade.php` (sudah dihandle oleh `--font-sans` di `app.css`)

**B. Migrasi ApexCharts ke npm:**

- [x] Install ApexCharts: `npm install apexcharts`
- [x] Import ApexCharts di `resources/js/app.js`: `import ApexCharts from 'apexcharts'; window.ApexCharts = ApexCharts;`
- [x] Hapus CDN `<script src="https://cdn.jsdelivr.net/npm/apexcharts">` di `layouts/app.blade.php`
- [x] Update CSP di `SecurityHeadersMiddleware.php` — hapus `cdn.jsdelivr.net` dari `script-src` (tidak diperlukan lagi)

**C. Ganti Hardcode Color dengan CSS Variable DaisyUI:**

- [x] Update `resources/views/components/ui/chart.blade.php`:
    - Ganti `colors: ['#422ad5', '#8f99dc', '#ff6200', '#10b981']` dengan membaca CSS variable DaisyUI di runtime
    - Ganti `fontFamily: 'Figtree, sans-serif'` → `'Inter, sans-serif'` (konsisten dengan `--font-sans` di `app.css`)
    - Contoh pendekatan CSS variable:
        ```javascript
        const style = getComputedStyle(document.documentElement);
        const colors = [
            style.getPropertyValue("--color-primary").trim(),
            style.getPropertyValue("--color-secondary").trim(),
            style.getPropertyValue("--color-accent").trim(),
            style.getPropertyValue("--color-success").trim(),
        ];
        ```

**Files to Modify:**

- [x] `resources/views/layouts/app.blade.php` — hapus Figtree CDN + hapus CDN ApexCharts script
- [x] `resources/views/welcome.blade.php` — hapus Inter CDN + hapus inline style
- [x] `resources/js/app.js` — import ApexCharts
- [x] `resources/views/components/ui/chart.blade.php` — ganti warna hardcode + font
- [x] `app/Http/Middleware/SecurityHeadersMiddleware.php` — update CSP (hapus cdn.jsdelivr.net)
- [x] `package.json` / `package-lock.json` — ditambah otomatis via npm install

---

## 37. Lokalize Font Inter & Cleanup CSP (Zero External CDN)

**Status:** ✅ Done (2026-02-23)
**Prioritas:** Medium
**Severity:** 🧹 Code Quality & Privacy

**Latar Belakang:**
Agar aplikasi dapat berjalan 100% offline dan memiliki privasi yang lebih baik (tidak ada data traffic yang masuk ke Google/Piwik external saat meload font), font Inter yang masih dipanggil dari Google Fonts (`app.css`) perlu dipindahkan ke environment lokal (via npm). Setelah seluruh referensi script dan font eksternal telah dilokalisasi (Task #36 dan Task #37 ini), maka file CSP bisa dibersihkan sepenuhnya.

**Checklist:**

**A. Install Font Lokal via npm:**

- [x] Jalankan perintah: `npm install @fontsource/inter`
- [x] Tambahkan baris impor font di `resources/css/app.css`: `@import "@fontsource/inter/index.css";` (dan hapus import Google Fonts)

**B. Cleanup Referensi CDN & CSP:**

- [x] Ubah rule SecurityHeadersMiddleware:
    - `style-src`: hapus `fonts.bunny.net` & `fonts.googleapis.com`
    - `font-src`: hapus `fonts.bunny.net` & `fonts.gstatic.com`

**Files to Modify:**

- [x] `resources/css/app.css` — Ganti import Google Fonts ke package npm
- [x] `app/Http/Middleware/SecurityHeadersMiddleware.php` — Bersihkan directives `style-src` dan `font-src`
- [x] `package.json` / `package-lock.json` — Ditambah otomatis via npm install

---

## 38. Standarisasi Komponen UI Document Viewer

**Status:** ✅ Done (2026-02-24)
**Prioritas:** Low
**Severity:** 💅 Refaktor & Standarisasi UI

**Latar Belakang:**
Agar komponen yang menampilkan referensi/tautan unduhan dokumen yang diunggah (seperti surat tugas, surat permohonan, dsb) seragam di semua bagian, elemen tersebut dipisahkan ke dalam sebuah komponen bawaan independen `<x-ui.document-viewer>`.

**Checklist:**

- [x] Pembuatan komponen `resources/views/components/ui/document-viewer.blade.php`
- [x] Penerapan di `update-profile-information-form.blade.php`
- [x] Penerapan di semua `show.blade.php` untuk `pse-verification`, `subdomain`, `hosting` dan halaman verifikator lainnya
- [x] Penerapan di formulir `edit.blade.php` untuk hosting dan subdomain

---

## 39. Tooltip pada Tabel Daftar Indeks (Truncate Text)

**Status:** ✅ Done (2026-02-24)
**Prioritas:** Low
**Severity:** 💅 Refaktor UI

**Latar Belakang:**
Nama sistem (PSE) dan instansi (OPD) yang panjang pada baris tabel membuat tampilan grid menjadi tidak proporsional terutama di layar sempit. Pemotongan teks dengan batas `25` karakter dilakukan, disusul fitur popover/tooltip apabila pointer diarahkan pada teks tersebut.

**Checklist:**

- [x] Modifikasi indeks Tabel Data: `pse`, `subdomain`, `hosting`
- [x] Modifikasi indeks Tabel Verifikasi (Verifikator 1): `pse-verification`, `subdomain-verification`, `hosting-verification`
- [x] Modifikasi indeks Tabel Verifikasi Akhir (Verifikator 2): `pse-verification2`, `subdomain-verification2`, `hosting-verification2`
- [x] Modifikasi indeks Tabel Riwayat Verifikasi: `verification-history`

---

## 40. Halaman Detail Profil Pengguna (ReadOnly untuk Verifikator)

**Status:** ✅ Done (2026-03-11)
**Prioritas:** Medium
**Severity:** ✨ Fitur Baru

**Latar Belakang:**
Agar verifikator dapat meninjau data mendetail dari pihak pengaju (petugas pemohon) seperti OPD, Kontak, Surat Tugas. Halaman profil khusus read-only dibuat yang dapat diakses oleh Verifikator 1 maupun Verifikator 2, ditautkan dari setiap show page pengajuan.

**Checklist:**

- [x] Buat Route `users.show` di `web.php` dan `UserController`
- [x] Buat `resources/views/profile/show.blade.php` (Read-Only) dengan document viewer pendukung
- [x] Pasang tautan ke `users.show` di `pse-verification/show.blade.php`
- [x] Pasang tautan ke `users.show` di `subdomain-verification/show.blade.php`
- [x] Pasang tautan ke `users.show` di `hosting-verification/show.blade.php`
- [x] Pasang tautan serupa di verifikator 2 (relevan)

---

## 41. Penyelarasan Warna Chart dengan Tema Light/Dark

**Status:** ✅ Done (2026-02-27)
**Prioritas:** Low
**Severity:** 💅 Refaktor UI

**Latar Belakang:**
Nama _series_ pada komponen chart ApexCharts (`x-ui.chart`) menggunakan warna yang di-hardcode, sehingga tidak berubah mengikuti tema _Light/Dark_. Perlu diselaraskan agar legend text memiliki warna yang sama dengan title card dan konten teks umum, serta agar otomatis update saat user men-toggle tema tanpa reload halaman.

**Checklist:**

- [x] Membaca warna `--color-base-content` via `getComputedStyle` saat render awal
- [x] Menambahkan `MutationObserver` pada elemen `<html>` untuk memantau perubahan atribut `data-theme`
- [x] Memanggil `chart.updateOptions()` secara real-time saat tema berubah

---

## 42. Refactor UUID Generation ke Trait HasUuid

**Status:** ✅ Done (2026-03-06)
**Prioritas:** Low
**Severity:** 🔧 Refaktor - Code DRY

**Latar Belakang:**
Saat ini, logika auto-generate UUID saat model dibuat (`creating` event) di-duplikasi secara identik di tiga model berbeda: `Pse`, `SubdomainRequest`, dan `HostingRequest`. Agar mengikuti prinsip DRY (Don't Repeat Yourself), logika tersebut dipindahkan ke sebuah PHP Trait `HasUuid` di folder `app/Traits/`.

**Kode Duplikasi yang Akan Dihapus (ada di 3 model):**

```php
protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = (string) Str::uuid();
        }
    });
}
```

**Solusi — Trait `HasUuid`:**

```php
// app/Traits/HasUuid.php
namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
```

> **Catatan:** Gunakan `bootHasUuid()` (konvensi Laravel) agar tidak
> menimpa `boot()` di model yang mungkin punya logika lain.
> `getRouteKeyName()` juga dipindahkan ke trait karena ketiga model pakai UUID sebagai route key.

**Checklist:**

- [x] Buat `app/Traits/HasUuid.php` dengan method `bootHasUuid()` dan `getRouteKeyName()`
- [x] Refactor `app/Models/Pse.php` — hapus `boot()` UUID + `getRouteKeyName()`, tambah `use HasUuid`
- [x] Refactor `app/Models/SubdomainRequest.php` — hapus `boot()` UUID + `getRouteKeyName()`, tambah `use HasUuid`
- [x] Refactor `app/Models/HostingRequest.php` — hapus `boot()` UUID + `getRouteKeyName()`, tambah `use HasUuid`

**Files to Create/Modify:**

- [x] `app/Traits/HasUuid.php` — Buat trait baru
- [x] `app/Models/Pse.php` — Gunakan trait, hapus duplikasi
- [x] `app/Models/SubdomainRequest.php` — Gunakan trait, hapus duplikasi
- [x] `app/Models/HostingRequest.php` — Gunakan trait, hapus duplikasi

---

## 43. Standardisasi Komponen Button (Semua Variant)

**Status:** ✅ Done (2026-03-06)
**Prioritas:** Low
**Severity:** 💥 Refaktor UI - Konsistensi Komponen

**Latar Belakang:**
Terdapat dua kelompok komponen button yang tidak konsisten:

1. **Komponen lama** (`x-button.primary`, `x-button.danger`, `x-button.secondary`, `x-button.ghost`) — sederhana, tidak support `size`, `icon`, atau render `<a>`
2. **Komponen baru** (`x-button`) — lengkap dengan `variant`, `size`, `icon`, dan auto-render `<a>` atau `<button>`

Semua variant di `x-button` perlu dibuatkan komponen mandiri masing-masing, agar bisa dipakai dengan sintaks shorthand `<x-button.primary>`, `<x-button.info>`, dst.

**Daftar Komponen (9 variant dari `x-button`):**

| Komponen File         | Variant         | Status                |
| --------------------- | --------------- | --------------------- |
| `primary.blade.php`   | `btn-primary`   | ♻️ Update (sudah ada) |
| `secondary.blade.php` | `btn-secondary` | ♻️ Update (sudah ada) |
| `danger.blade.php`    | `btn-error`     | ♻️ Update (sudah ada) |
| `ghost.blade.php`     | `btn-ghost`     | ♻️ Update (sudah ada) |
| `neutral.blade.php`   | `btn-neutral`   | 🆕 Buat baru          |
| `accent.blade.php`    | `btn-accent`    | 🆕 Buat baru          |
| `info.blade.php`      | `btn-info`      | 🆕 Buat baru          |
| `success.blade.php`   | `btn-success`   | 🆕 Buat baru          |
| `warning.blade.php`   | `btn-warning`   | 🆕 Buat baru          |
| `link.blade.php`      | `btn-link`      | 🆕 Buat baru          |

**Fitur yang harus ada di semua komponen:**

- `size` prop (`xs`, `sm`, `md`, `lg`) — default `md`
- Auto-render sebagai `<a>` jika ada `href`, `<button>` jika tidak
- `icon` prop — minimal `eye` untuk `primary`, opsional untuk lainnya

**Contoh penggunaan setelah refaktor:**

```blade
{{-- Tombol submit biasa (tidak berubah) --}}
<x-button.primary>Simpan</x-button.primary>

{{-- Tombol link dengan icon --}}
<x-button.primary href="{{ route('pse.show', $pse) }}" icon="eye">Lihat</x-button.primary>

{{-- Varian baru --}}
<x-button.success size="sm">Setujui</x-button.success>
<x-button.warning>Tunda</x-button.warning>
<x-button.info href="{{ route('report') }}">Laporan</x-button.info>
```

**Checklist:**

- [x] Update `primary.blade.php` — tambah `size`, `icon` (eye), render `<a>`/`<button>`
- [x] Update `danger.blade.php` — tambah `size`, render `<a>`/`<button>`
- [x] Update `secondary.blade.php` — tambah `size`, render `<a>`/`<button>`
- [x] Update `ghost.blade.php` — tambah `size`, render `<a>`/`<button>`
- [x] Buat `neutral.blade.php`
- [x] Buat `accent.blade.php`
- [x] Buat `info.blade.php`
- [x] Buat `success.blade.php`
- [x] Buat `warning.blade.php`
- [x] Buat `link.blade.php`
- [x] Pastikan semua 8 view pemakai `x-button.primary` masih berfungsi tanpa perubahan

**Files to Create/Modify:**

- [x] `resources/views/components/button/primary.blade.php` — Update
- [x] `resources/views/components/button/danger.blade.php` — Update
- [x] `resources/views/components/button/secondary.blade.php` — Update
- [x] `resources/views/components/button/ghost.blade.php` — Update
- [x] `resources/views/components/button/neutral.blade.php` — Baru
- [x] `resources/views/components/button/accent.blade.php` — Baru
- [x] `resources/views/components/button/info.blade.php` — Baru
- [x] `resources/views/components/button/success.blade.php` — Baru
- [x] `resources/views/components/button/warning.blade.php` — Baru
- [x] `resources/views/components/button/link.blade.php` — Baru

**Pemakai `x-button.primary` yang perlu diuji (8 file):**

- `pse/create.blade.php`, `pse/edit.blade.php`
- `subdomain/create.blade.php`, `subdomain/edit.blade.php`
- `hosting/create.blade.php`, `hosting/edit.blade.php`
- `profile/partials/update-profile-information-form.blade.php`
- `profile/partials/update-opd-information-form.blade.php`

**Migrasi `x-button.button variant="X"` → `x-button.{variant}` (hapus prop `variant`):**

- [x] `resources/views/pse/index.blade.php`
- [x] `resources/views/pse/show.blade.php`
- [x] `resources/views/subdomain/index.blade.php`
- [x] `resources/views/subdomain/show.blade.php`
- [x] `resources/views/hosting/index.blade.php`
- [x] `resources/views/hosting/show.blade.php`
- [x] `resources/views/pse-verification/index.blade.php`
- [x] `resources/views/pse-verification/show.blade.php`
- [x] `resources/views/pse-verification2/index.blade.php`
- [x] `resources/views/pse-verification2/show.blade.php`
- [x] `resources/views/subdomain-verification/index.blade.php`
- [x] `resources/views/subdomain-verification/show.blade.php`
- [x] `resources/views/subdomain-verification2/index.blade.php`
- [x] `resources/views/subdomain-verification2/show.blade.php`
- [x] `resources/views/hosting-verification/index.blade.php`
- [x] `resources/views/hosting-verification/show.blade.php`
- [x] `resources/views/hosting-verification2/index.blade.php`
- [x] `resources/views/hosting-verification2/show.blade.php`
- [x] `resources/views/verification-history/index.blade.php`
- [x] `resources/views/issuance/index.blade.php`

> **Catatan:** `variant="error"` → `x-button.error` (sesuai nama DaisyUI `btn-error`), bukan `x-button.danger`. File `danger.blade.php` sudah di-rename menjadi `error.blade.php` dan semua pemakai di-update.

> **Catatan:** `users/index.blade.php` dan `users/show.blade.php` ternyata tidak menggunakan `x-button.button` (sudah menggunakan komponen yang benar sebelumnya).

**Rename komponen:**

- [x] `danger.blade.php` → `error.blade.php` (sesuaikan dengan nama class DaisyUI `btn-error`)
- [x] Semua `x-button.danger` di views diganti menjadi `x-button.error`

**Status Task:** ✅ SELESAI — Tidak ada sisa `x-button.button` maupun `x-button.danger` di seluruh views.

---

## 44. In-App Notification

**Status:** 💡 Planned  
**Prioritas:** Medium

Implementasi notifikasi di dalam aplikasi agar Petugas OPD mendapat pemberitahuan real-time saat status pengajuan mereka berubah (disetujui/ditolak), tanpa bergantung pada email eksternal.

**Konsep:**

- Notifikasi disimpan di tabel `notifications` (Laravel database channel)
- Badge angka muncul di icon lonceng di header navigasi
- List notifikasi dapat dilihat saat icon diklik
- Notifikasi otomatis ditandai "sudah dibaca" saat diklik

**Trigger Notifikasi:**

- PSE disetujui / ditolak oleh Verifikator 1 atau 2
- Subdomain Request disetujui / ditolak
- Hosting Request disetujui / ditolak

**Scope Implementasi:**

- [ ] Buat migration untuk tabel `notifications` (Laravel default: `php artisan notifications:table`)
- [ ] Buat Notification class: `PseStatusChanged`, `SubdomainStatusChanged`, `HostingStatusChanged`
- [ ] Dispatch notification di controller setiap setelah approve/reject
- [ ] Tambah badge notifikasi di `sidebar.blade.php` / `header.blade.php`
- [ ] Buat halaman atau dropdown list notifikasi
- [ ] Implementasi mark-as-read

**Files to Create/Modify:**

- [ ] Migration `notifications` table
- [ ] `app/Notifications/PseStatusChanged.php`
- [ ] `app/Notifications/SubdomainStatusChanged.php`
- [ ] `app/Notifications/HostingStatusChanged.php`
- [ ] `app/Http/Controllers/PseVerificationController.php` — dispatch notification
- [ ] `app/Http/Controllers/PseVerification2Controller.php` — dispatch notification
- [ ] `app/Http/Controllers/SubdomainVerificationController.php` — dispatch notification
- [ ] `app/Http/Controllers/SubdomainVerification2Controller.php` — dispatch notification
- [ ] `app/Http/Controllers/HostingVerificationController.php` — dispatch notification
- [ ] `app/Http/Controllers/HostingVerification2Controller.php` — dispatch notification
- [ ] `resources/views/layouts/sidebar.blade.php` atau `header.blade.php` — badge notifikasi
- [ ] `resources/views/notifications/index.blade.php` — halaman list notifikasi
- [ ] `routes/web.php` — route untuk notifikasi

---

## 45. Validasi Surat Permohonan Wajib Saat Submit Subdomain & Hosting

**Status:** ✅ Done (Selesai pada: 11-03-2026)  
**Prioritas:** High

Saat ini submit PSE sudah memiliki pengecekan kelengkapan profil (termasuk surat tugas). Mekanisme serupa perlu diterapkan untuk submit subdomain dan hosting: jika surat permohonan belum diupload, sistem menolak submit dan mengarahkan user ke halaman **edit** dengan pesan error yang informatif.

**Referensi Mekanisme di PSE:**

```php
// PseController@submit
if (!auth()->user()->hasCompleteProfile()) {
    return redirect()->route('profile.edit')
        ->with('error', 'Profil Anda belum lengkap...');
}
```

**Perilaku yang Diinginkan:**

- Submit subdomain → cek `$subdomain->document` → jika null → redirect ke `subdomain.edit` dengan pesan error
- Submit hosting → cek `$hosting->document` → jika null → redirect ke `hosting.edit` dengan pesan error
- Pesan error ditampilkan di halaman **edit** (bukan index)

**Contoh Implementasi:**

```php
// SubdomainRequestController@submit
if (!$subdomain->document) {
    return redirect()->route('subdomain.edit', $subdomain)
        ->with('error', 'Surat permohonan belum diupload. Harap upload surat permohonan terlebih dahulu sebelum mengajukan.');
}

// HostingRequestController@submit
if (!$hosting->document) {
    return redirect()->route('hosting.edit', $hosting)
        ->with('error', 'Surat permohonan belum diupload. Harap upload surat permohonan terlebih dahulu sebelum mengajukan.');
}
```

**Scope Implementasi:**

- [ ] Tambah pengecekan `$subdomain->document` di `SubdomainRequestController@submit`
- [ ] Tambah pengecekan `$hosting->document` di `HostingRequestController@submit`
- [ ] Pastikan view `subdomain/edit.blade.php` menampilkan alert error dari session `error`
- [ ] Pastikan view `hosting/edit.blade.php` menampilkan alert error dari session `error`

**Files to Modify:**

- [ ] `app/Http/Controllers/SubdomainRequestController.php` — method `submit()`
- [ ] `app/Http/Controllers/HostingRequestController.php` — method `submit()`
- [ ] `resources/views/subdomain/edit.blade.php` — pastikan ada alert error
- [ ] `resources/views/hosting/edit.blade.php` — pastikan ada alert error

## 46. Filter Berdasarkan Status di Halaman Index

**Status:** ✅ Completed (2026-03-12)  
**Prioritas:** Medium

Tambahkan dropdown filter status di halaman daftar PSE, Subdomain, dan Hosting agar user/verifikator bisa memfilter data berdasarkan status tertentu (draft, pending, approved, rejected).

**Kondisi Saat Ini:**
Halaman index sudah memiliki fitur search dan filter status yang terintegrasi.

**Scope Implementasi:**

- [x] Tambah dropdown filter `status` di form search header tabel
- [x] Update controller `index()` untuk menerima dan menerapkan parameter `status`
- [x] Pastikan parameter `status` dipreserve saat pindah halaman (pagination) dan bersamaan dengan `search` & `per_page`

**Target Halaman:**

- [x] `pse/index.blade.php` + `PseController@index`
- [x] `subdomain/index.blade.php` + `SubdomainRequestController@index`
- [x] `hosting/index.blade.php` + `HostingRequestController@index`
- [ ] Halaman verifikasi (opsional, jika diperlukan verifikator)

**Files to Modify:**

- [x] `app/Http/Controllers/PseController.php`
- [x] `app/Http/Controllers/SubdomainRequestController.php`
- [x] `app/Http/Controllers/HostingRequestController.php`
- [x] `resources/views/pse/index.blade.php`
- [x] `resources/views/subdomain/index.blade.php`
- [x] `resources/views/hosting/index.blade.php`

---

## 47. Rekap Laporan Manual Per Bulan/Tahun (Integrated to Issuance)

**Status:** ✅ Done (2026-03-13)
**Prioritas:** Medium

Menyediakan fitur rekapitulasi data permohonan yang telah disetujui (Approved) dalam rentang waktu tertentu (Bulan/Tahun). Fitur ini diintegrasikan sebagai tab baru pada modul **Penerbitan (Issuance)** untuk memudahkan Verifikator 2 dalam membuat laporan bulanan tanpa perlu berpindah halaman.

**Scope Implementasi:**

- [x] Tambahkan tab "Rekap" pada halaman Issuance.
- [x] Implementasi filter periode (Bulan & Tahun) dan kategori (Semua/PSE/Subdomain/Hosting).
- [x] Tampilkan ringkasan jumlah (count) data pada dashboard tab Rekap.
- [x] Implementasi Cetak PDF Laporan Rekap dengan kop surat resmi dan tanda tangan.
- [x] Struktur PDF laporan disesuaikan dengan standar surat dinas (seperti laporan individu).

**Files Modified:**

- [x] `app/Http/Controllers/IssuanceController.php`
- [x] `resources/views/issuance/index.blade.php`
- [x] `resources/views/reports/recap.blade.php` (New)
- [x] `routes/web.php`

---

## 48. Fitur Pemulihan (Restore) Akun User yang Dihapus (Soft Deletes)

**Status:** ✅ Done (2026-03-11)
**Prioritas:** Medium

Melengkapi Task #41 (Soft Deletes pada User) dengan menyediakan mekanisme bagi Admin untuk melihat dan memulihkan data user yang telah di-soft delete.

**Kondisi Saat Ini:**
Data user dapat dihapus dan tetap tersimpan di database (`deleted_at`), namun belum ada UI atau logic untuk melihat atau memulihkan (restore) akun tersebut.

**Scope Implementasi:**

- [x] Tambahkan komponen `<x-form.search-input>` dan `<x-form.select>` filter di halaman `users/index` untuk melihat daftar user dengan status `Aktif`, `Dihapus`, atau `Semua` (`withTrashed()` atau `onlyTrashed()`).
- [x] Tampilkan komponen `<x-ui.badge>` status pada list tabel (e.g. `<x-ui.badge variant="error">` jika akun memiliki `deleted_at`).
- [x] Tampilkan `<x-button.accent icon="restore">` khusus pada baris akun yang berstatus terhapus.
- [x] Modifikasi `UserController` untuk logic filter data terhapus.
- [x] Tambahkan method `restore()` di `UserController` untuk mengeksekusi aksi restore akun pengguna.
- [x] Tambahkan route POST/PATCH untuk `users.restore`.

**Files to Modify:**

- [x] `app/Policies/UserPolicy.php` — Penambahan `viewAny` & `restore`
- [x] `app/Http/Controllers/UserController.php`
- [x] `resources/views/users/index.blade.php` (created)
- [x] `resources/views/layouts/sidebar.blade.php` — Penambahan menu
- [x] `routes/web.php`

---

## 49. Sorting Data di Halaman Index

**Status:** ✅ Completed (2026-03-12)  
**Prioritas:** Medium

Menambahkan fitur pengurutan data (Sorting ASC/DESC) pada kolom tabel di halaman Index PSE, Subdomain, dan Hosting untuk mempermudah navigasi data dalam jumlah besar.

**Scope Implementasi:**

- [x] Buat komponen kustom `<x-ui.table-sort>` dengan indikator panah kustom SVG (Solid Triangle, ukuran besar, dempet)
- [x] Implementasi sorting di `PseController@index` & `pse/index.blade.php`
- [x] Implementasi sorting di `SubdomainRequestController@index` & `subdomain/index.blade.php` (Termasuk logic `join` untuk Nama Sistem)
- [x] Implementasi sorting di `HostingRequestController@index` & `hosting/index.blade.php` (Termasuk logic `join` untuk Nama Sistem)
- [x] Pastikan parameter `sort_by` dan `sort_dir` dipreserve bersama filter `search` dan `status`
- [x] **Adjustment:** Menghapus fitur sorting pada kolom Status karena sudah tercover oleh filter status
- [x] **Fix:** Menambahkan prefix nama tabel pada query controller untuk menghindari error _Ambiguous Column_ saat menggunakan `join`

**Files to Modify:**

- [x] `resources/views/components/ui/table-sort.blade.php`
- [x] `app/Http/Controllers/PseController.php`
- [x] `resources/views/pse/index.blade.php`
- [x] `app/Http/Controllers/SubdomainRequestController.php`
- [x] `resources/views/subdomain/index.blade.php`
- [x] `app/Http/Controllers/HostingRequestController.php`
- [x] `resources/views/hosting/index.blade.php`

---

## 50. Sorting Data di Halaman Verifikasi (Verifikator 1 & 2)

**Status:** ✅ Completed (2026-03-12)  
**Prioritas:** Medium

Menerapkan fitur pengurutan data pada tabel daftar pengajuan yang perlu diverifikasi oleh Verifikator 1 dan Verifikator 2. Hal ini mencakup 6 halaman verifikasi (PSE, Subdomain, dan Hosting untuk kedua level verifikator).

**Scope Implementasi:**

- [x] Implementasi sorting di `PseVerificationController` & `PseVerification2Controller`
- [x] Implementasi sorting di `SubdomainVerificationController` & `SubdomainVerification2Controller`
- [x] Implementasi sorting di `HostingVerificationController` & `HostingVerification2Controller`
- [x] Implementasi sorting di `UserController` (User Index)
- [x] Implementasi sorting di `VerificationHistoryController` (History Verifikasi)
- [x] Implementasi sorting di `IssuanceController` (Penerbitan/Issuance)
- [x] Mendukung sorting berdasarkan:
    - Nama Sistem (Join ke `pses` jika perlu)
    - OPD (Join ke `opds`)
    - Sektor (Khusus PSE)
    - Tipe Pengajuan (Khusus Subdomain/Hosting)
    - Tanggal Pengajuan (`created_at`)
- [x] Pastikan parameter tetap terbawa saat filter pencarian aktif

**Files to Modify:**

- [x] `app/Http/Controllers/PseVerificationController.php` & `pse-verification/index`
- [x] `app/Http/Controllers/PseVerification2Controller.php` & `pse-verification2/index`
- [x] `app/Http/Controllers/SubdomainVerificationController.php` & `subdomain-verification/index`
- [x] `app/Http/Controllers/SubdomainVerification2Controller.php` & `subdomain-verification2/index`
- [x] `app/Http/Controllers/HostingVerificationController.php` & `hosting-verification/index`
- [x] `app/Http/Controllers/HostingVerification2Controller.php` & `hosting-verification2/index`
- [x] `app/Http/Controllers/UserController.php` & `resources/views/users/index.blade.php`
- [x] `app/Http/Controllers/VerificationHistoryController.php` & `resources/views/verification-history/index.blade.php`
- [x] `app/Http/Controllers/IssuanceController.php` & `resources/views/issuance/index.blade.php`

---

## 51. Manajemen Penghapusan User oleh Verifikator

**Status:** ✅ Done (2026-03-12)
**Prioritas:** Medium

Menyediakan fungsionalitas bagi Verifikator 1 dan Verifikator 2 untuk menghapus (soft delete) akun pengguna, khususnya peran Petugas, melalui halaman Manajemen User. Hal ini diperlukan untuk moderasi data dan keamanan akun.

**Scope Implementasi:**

- [x] Tambahkan method `destroy()` di `UserController` untuk proses penghapusan (soft delete).
- [x] Update `app/Policies/UserPolicy.php` untuk mengizinkan Verifikator menghapus akun Petugas (Cegah menghapus diri sendiri atau sesama verifikator jika diperlukan).
- [x] Tambahkan tombol "Hapus" (Variant Error/Merah) di `resources/views/users/index.blade.php`.
- [x] Tambahkan konfirmasi (confirm) sebelum menghapus untuk mencegah ketidaksengajaan.
- [x] Logging audit trail saat penghapusan dilakukan.

**Files to Modify:**

- [x] `app/Http/Controllers/UserController.php`
- [x] `app/Policies/UserPolicy.php`
- [x] `resources/views/users/index.blade.php`
- [x] `routes/web.php`

---

## 52. Penguatan Rate Limiting pada Rute Kritis (Security Hardening)

**Status:** ✅ Done (2026-03-12)
**Prioritas:** High
**Severity:** 🔴 Security Risk - Prevent resource abuse

**Masalah:**
Saat ini rute kritis Verifikator (Approve/Reject) dan rute administrasi (User Delete/Restore) masih menggunakan limit global (60 req/min). Aksi-aksi ini bersifat sensitif dan melakukan perubahan status/data penting di database.

**Saran Perbaikan:**
Menerapkan batasan (throttle) yang lebih ketat pada rute-rute spesifik tersebut untuk mencegah bot, race condition, dan penyalahgunaan sumber daya.

**Scope Implementasi:**

- [x] Terapkan `throttle:20,1` pada rute verifikasi (approve/reject) untuk PSE, Subdomain, dan Hosting (Verifikator 1 & 2).
- [x] Terapkan `throttle:15,1` pada rute download dokumen untuk mencegah scraping/abuse bandwidth.
- [x] Terapkan `throttle:5,1` pada rute sangat sensitif manajemen user (restore, destroy).

**Files to Modify:**

- [x] `routes/web.php`

---

## 53. Implementasi DB Transactions pada Operasi Multi-Step (Data Integrity)

**Status:** ✅ Done (2026-03-31)
**Prioritas:** High
**Severity:** 🔴 Critical - Data inconsistency risk

**Masalah:**
Operasi kritis seperti verifikasi (approve/reject) melibatkan beberapa penulisan database (update status + simpan histori verifikasi). Jika operasi kedua gagal di tengah jalan, data status akan berubah namun bukti/histori verifikasi tidak tercatat, menyebabkan inkonsistensi audit trail.

**Scope Implementasi:**

- [x] Terapkan `DB::transaction()` pada method `approve()` dan `reject()` di seluruh (6) Verification Controllers.
- [x] Pastikan alur `SubdomainVerification2Controller::approve()` yang mengupdate tabel `pses` juga terlindungi transaksi.
- [x] Implementasi `try-catch` yang tepat untuk memastikan rollback otomatis jika terjadi kegagalan sistem.

**Files to Modify:**

- [x] `app/Http/Controllers/PseVerificationController.php`
- [x] `app/Http/Controllers/PseVerification2Controller.php`
- [x] `app/Http/Controllers/SubdomainVerificationController.php`
- [x] `app/Http/Controllers/SubdomainVerification2Controller.php`
- [x] `app/Http/Controllers/HostingVerificationController.php`
- [x] `app/Http/Controllers/HostingVerification2Controller.php`

---

## 54. Implementasi DB Transactions pada Form Submission (Data Consistency)

**Status:** ✅ Done (2026-03-31)
**Prioritas:** High
**Severity:** 🔴 High - Risk of orphaned attachments

**Latar Belakang:**
Proses `store()` dan `update()` pada permohonan (Subdomain & Hosting) serta pembaruan Profil melibatkan penulisan ke beberapa tabel (Model Utama + Tabel `documents`). Kegagalan di tengah proses dapat menyebabkan data terfragmentasi (misal: pengajuan ada tapi lampiran surat permohonan tidak tercatat).

**Scope Implementasi:**

- [x] Terapkan `DB::transaction()` pada `SubdomainRequestController` (`store` & `update`).
- [x] Terapkan `DB::transaction()` pada `HostingRequestController` (`store` & `update`).
- [x] Terapkan `DB::transaction()` pada `ProfileController` (`update`).
- [x] Pastikan rollback otomatis jika terjadi kegagalan file storage record.

**Files to Modify:**

- [x] `app/Http/Controllers/SubdomainRequestController.php`
- [x] `app/Http/Controllers/HostingRequestController.php`
- [x] `app/Http/Controllers/ProfileController.php`

---

## 55. Hardening Integritas Data (Foreign Key Cascade)

**Status:** ✅ Done (2026-04-01)  
**Prioritas:** High
**Severity:** 🔴 Critical - Permanent data loss risk

**Masalah:**
Pada migrasi database saat ini, kolom `user_id` di tabel-tabel utama (`pses`, `subdomain_requests`, `hosting_requests`, `verification_histories`) menggunakan `onDelete('cascade')`. Hal ini berisiko menghapus seluruh data pendaftaran pemerintah secara permanen jika akun pengguna (Petugas/Verifikator) di-_force delete_.

**Scope Implementasi:**

- [x] Buat migrasi baru untuk mengubah perilaku `user_id` foreign key.
- [x] Ubah dari `onDelete('cascade')` menjadi `onDelete('restrict')` pada tabel:
    - `pses`
    - `subdomain_requests`
    - `hosting_requests`
- [x] Khusus untuk `verification_histories`, pertimbangkan `onDelete('restrict')` agar log audit tidak hilang.
- [x] Verifikasi bahwa sistem menolak penghapusan user jika masih memiliki data terkait (kecuali user tersebut di-soft delete).

**Files to Create/Modify:**

- [x] `database/migrations/2026_04_01_000001_change_user_id_foreign_on_critical_tables.php` (New Migration)

---

## 56. Pencegahan XSS pada Pesan Session (Security Hardening)

**Status:** ✅ Done (2026-04-01)  
**Prioritas:** High
**Severity:** 🔴 High - XSS vulnerability risk

**Masalah:**
Widespread use of `{!! session('error') !!}` and `{!! session('success') !!}` in Blade views to render session alerts. Because these do not escape content, any session message containing unescaped user input (e.g. `:name` in translations) could lead to XSS.

**Scope Implementasi:**

- [x] Bersihkan tag HTML (seperti `<strong>`) dari file bahasa `lang/id/messages.php`.
- [x] Migrasi seluruh alert di View dari `{!! session(...) !!}` ke `{{ session(...) }}` yang lebih aman.
- [x] Update komponen atau view yang menampilkan alert untuk menggunakan class CSS/DaisyUI guna memberikan penekanan gaya (seperti font-bold) secara konsisten tanpa HTML mentah di string.
- [x] Pastikan tidak ada variabel user-input yang di-passing ke session tanpa escaping jika masih terpaksa menggunakan raw output.

**Files to Modify:**

- [x] `lang/id/messages.php`
- [x] `resources/views/**/*.blade.php` (Semua file yang menampilkan alert session)
- [x] `app/Http/Controllers/*.php` (Opsional, jika ada pesan manual yang perlu disesuaikan)

---

## 57. Proteksi ID Enumeration (Penerapan UUID User)

**Status:** ✅ Done (2026-04-01)  
**Prioritas:** High
**Severity:** 🔴 High - ID Enumeration risk (Insecure Direct Object Reference)

**Masalah:**
Saat Verifikator melihat profil petugas via route `/users/{user}`, URL mengekspos ID numerik database (contoh: `/users/1`). Hal ini memungkinkan _attacker_/pengguna menebak pola _auto-increment_ untuk melihat ketersediaan pengguna lainnya secara tak terkontrol.

**Scope Implementasi:**

- [x] Buat file migrasi baru untuk menambah dan men-_generate_ `uuid` pada tabel `users`.
- [x] Tambahkan trait `HasUuid` pada model `User`.
- [x] Ubah pencarian manual berdasarkan `$id` di metode `show` dan `restore` pada `UserController.php`.
- [x] Perbarui tombol-tombol link di _blade views_ agar secara eksplisit memanfaatkan `$user->uuid` jika routing terhambat oleh manual identifier.

**Files to Modify:**

- [x] `database/migrations/xxxx_xx_xx_xxxxxx_add_uuid_to_users_table.php` (New)
- [x] `app/Models/User.php`
- [x] `app/Http/Controllers/UserController.php`
- [x] `resources/views/user/index.blade.php`
- [x] `resources/views/.../*-verification*/show.blade.php`

---

## 58. Language Switcher (Bilingual UI)

**Status:** ✅ Done (2026-04-01)  
**Prioritas:** Medium
**Severity:** 🟢 Low - Feature Addition

**Masalah:**
Diperlukan adanya sebuah toggle atau switch di Antarmuka Pengguna (UI) untuk mengganti bahasa aplikasi antara Bahasa Indonesia dan English secara _on the fly_, dengan mekanisme pilihan persisten yang memanfaatkan _session_. Tombol ini akan ditempatkan di dalam menu profil _dropdown_ di bagian _sidebar_.

**Scope Implementasi:**

- [x] Buat _middleware_ `SetLocale` untuk mendeteksi `session('locale')` dan mengatur bahasa global pada request `App::setLocale()`.
- [x] Daftarkan middleware tersebut ke dalam grup `web` di `Kernel.php`.
- [x] Buat file _Controller_ dan _route_ `GET /lang/{locale}` untuk mengubah status di _session_ dan mengarahkan pengguna kembali mendaur status _(redirect back)_.
- [x] Tambahkan elemen _User Interface_ berupa menu/opsi penggantian di daftar navigasi `layouts/sidebar.blade.php`, tepat di area profil.
- [x] Buat direktori bahasa `lang/en` yang berbasis dari file bahasa `lang/id`.

**Files to Modify:**

- [x] `app/Http/Middleware/SetLocale.php` (New)
- [x] `app/Http/Kernel.php`
- [x] `routes/web.php`
- [x] `resources/views/layouts/sidebar.blade.php`
- [x] `lang/en/` (New)

---

## 59. Penerbitan Kredit Pengembang (Fase Rilis Pertama)

**Status:** ✅ Done (2026-04-01)  
**Prioritas:** Low
**Severity:** 🟠 Administrative - Documentation & Credits

**Masalah:**
Perlu adanya ruang dokumentasi teknis yang bersifat permanen untuk mencatat riwayat pengerjaan sistem oleh pengembang pertama (April 2026). Hal ini bertujuan untuk transparansi, portfolio pengembang, serta panduan bagi pengembang generasi berikutnya.

**✅ Sudah Selesai (Berdasarkan doc/TODO.md Point 11):**

- [x] Pembuatan direktori `public/published/` pada _project root_.
- [x] Pembuatan file `version.txt` di dalam direktori tersebut.
- [x] Isi file mencakup: Log rilis pertama, identitas pengembang, linimasa April 2026, dan rujukan 11 fitur utama.
- [x] Verifikasi aksesibilitas publik via URL `/published/version.txt`.

**Files Created:**

- [x] `public/published/version.txt`

---

## 60. Implementasi Role Baru (Admin & Eksekutif)

**Status:** ✅ Done (2026-04-02)
**Prioritas:** High
**Severity:** 🔴 High - RBAC Expansion

Menambahkan dua role baru sesuai dengan Roadmap (Point 2 & 8) untuk mendukung manajemen user dan monitoring eksekutif.

**Scope Implementasi:**

- [x] Update `database/seeders/RoleSeeder.php` untuk memasukkan role `admin` (ID 5) dan `eksekutif` (ID 4).
- [x] Jalankan seeder dan verifikasi integritas ID di database.
- [x] Update `doc/ROLES.md` untuk mendefinisikan wewenang kedua role baru tersebut.
- [x] Tambahkan translasi role di `lang/en.json`.
- [x] Identifikasi rute dan menu yang perlu di-adjust untuk role baru ini (Dashboard & Reports).

**Files Modified:**

- [x] `database/seeders/RoleSeeder.php`
- [x] `doc/ROLES.md`
- [x] `lang/en.json`
- [x] `routes/web.php`
- [x] `resources/views/layouts/sidebar.blade.php`
- [x] `app/Http/Controllers/DashboardController.php`
- [x] `resources/views/dashboard.blade.php`
- [x] `doc/TASKS.md`

## 61. Konsolidasi Profil ke User Management (Admin Only)

**Status:** ✅ Done (2026-04-02)
**Prioritas:** High
**Severity:** 🔴 High - Architectural Refactor

Sesuai dengan kebijakan baru (Roadmap Point 2), petugas tidak lagi memiliki wewenang untuk mengubah informasi akun/profil mereka sendiri. Wewenang ini dipindahkan sepenuhnya ke Admin. Direktori `profile` akan dihapus dan fungsinya digabungkan ke `user`.

**Scope Implementasi:**

- [x] Ubah & Pindahkan `resources/views/profile/edit.blade.php` menjadi form **Registrasi (Create)** di `resources/views/user/create.blade.php`.
- [x] Tambahkan tombol/Link Register pada `resources/views/user/index.blade.php` untuk **Admin**.
- [x] Tambahkan tombol/formulir **Edit** pada `resources/views/user/show.blade.php` yang diproteksi hanya untuk **Admin**.
- [x] Refactor `ProfileController` ke `UserController` untuk penanganan update informasi oleh Admin.
- [x] Cabut rute profil dari akses user umum di `web.php`.
- [x] Perbarui `UserPolicy` untuk mencabut hak `update` dari pemilik akun asli (Petugas dilarang edit sendiri).
- [x] Hapus direktori `resources/views/profile`.
- [x] Perbarui `sidebar.blade.php` untuk mengarahkan rute profil ke rute user yang dikelola Admin.

**Files to Modify:**

- `app/Http/Controllers/ProfileController.php` (Refactor/Remove)
- `app/Http/Controllers/UserController.php` (Update logic)
- `routes/web.php` (Routes cleanup)
- `resources/views/profile/` (Move/Remove)
- `resources/views/user/` (Update UI)

## 62. Standarisasi Sektor PSE (Point 4 TODO.md)

**Status:** ✅ Done (2026-04-02)
**Prioritas:** Low
**Severity:** 🟢 Low - Formatting Data

**Deskripsi:**
Mengubah input `sector` pada pendataan PSE dari teks bebas menjadi pilihan baku (Dropdown) guna menjamin konsistensi data statistik sesuai rujukan sektor pemerintahan Kota Batam.

**Scope Implementasi:**

- [x] Buat array daftar sektor statis di `Pse` Model atau helper (Administrasi, Pendidikan, Kesehatan, dsb).
- [x] Ubah input `sector` menjadi `<x-form.select>` pada `resources/views/pse/create.blade.php`.
- [x] Ubah input `sector` menjadi `<x-form.select>` pada `resources/views/pse/edit.blade.php`.
- [x] Perbarui `store` dan `update` method pada `PseController` untuk memvalidasi input sektor agar sesuai dengan daftar pilihan (`in:A,B,C`).
- [x] Tambahkan helper pada model untuk menampilkan label sektor yang rapi di view `index` dan `show`.

**Files to Modify:**

- [x] `app/Models/Pse.php`
- [x] `app/Http/Controllers/PseController.php`
- [x] `resources/views/pse/create.blade.php`
- [x] `resources/views/pse/edit.blade.php`
- [x] `doc/TASKS.md`

## 63. Sinkronisasi Alur Terpadu PSE & Hosting (Single Flow)

**Status:** ✅ Done (2026-04-03)
**Prioritas:** Medium
**Severity:** 🟡 Medium - Functional Flow

**Deskripsi:**
Mengintegrasikan pendaftaran PSE dan pengajuan Hosting dalam satu alur kerja terpadu pada modul **Tambah & Ubah PSE**. Petugas kini tidak perlu lagi membuat draf hosting secara manual; sistem secara otomatis mendeteksi kebutuhan hosting berdasarkan pilihan lokasi penyimpanan data (khusus penyimpanan data di aplikasi).

**Scope Implementasi:**

- [x] **Standarisasi Input**: Mengubah `storage_location` dari teks bebas menjadi pilihan baku (Aplikasi, Colocation, Eksternal) menggunakan komponen Radio Button reusable.
- [x] **Logika Visibilitas Dinamis**: Implementasi **Vanilla JavaScript** pada draf kartu hosting untuk menjamin kartu muncul seketika (tanpa reload) hanya jika opsi "Aplikasi" dipilih.
- [x] **Data Pre-Filling (Modul Edit)**: Mengintegrasikan kueri `updateOrCreate` pada Controller dan penarikan data hosting otomatis ke dalam form pengeditan PSE.
- [x] **Refaktor Backend**: Pengaturan validasi kondisional (`required_if:storage_location,aplikasi`) di `PseController` untuk menjamin integritas data pengajuan hosting.
- [x] **Clean View Logic**: Menghilangkan seluruh pemanggilan Model langsung dari View dan menggantinya dengan pengiriman variabel metadata dari Controller.

**Files Modified:**

- [x] resources/views/components/form/radio.blade.php
- [x] resources/views/pse/create.blade.php
- [x] resources/views/pse/edit.blade.php
- [x] app/Http/Controllers/PseController.php
- [x] app/Models/Pse.php
- [x] app/Models/HostingRequest.php
- [x] doc/TASKS.md
- [x] doc/TODO.md

## 64. Integrasi Verifikasi Terpadu PSE & Hosting (Single Flow Verification)

**Status:** ✅ Done (2026-04-03)
**Prioritas:** High
**Severity:** 🟡 Medium - Functional Flow

**Deskripsi:**
Menyatukan antarmuka dan logika persetujuan untuk Verifikator 1 dan 2 agar dapat memeriksa, memberikan catatan, dan menyetujui (atau menolak) pengajuan PSE beserta Hosting terkait dalam satu tindakan tunggal (_Single Decision_). Ini menjamin keselarasan status antar entitas dan efisiensi waktu kerja verifikator.

**Scope Implementasi:**

- [x] **Unified Detail View**: Menggabungkan rincian data PSE dan spesifikasi Hosting dalam satu halaman detail (`show`) untuk memudahkan pemeriksa.
- [x] **Single Approval Action**: Implementasi tombol persetujuan otomatis untuk `pses` dan `hosting_requests` dalam satu transaksi.
- [x] **Linked Audit Trail**: Pencatatan riwayat verifikasi polimorfik yang terhubung bagi kedua entitas.
- [x] **Pemeriksaan Dokumen Terpusat**: Verifikator kini dapat langsung meninjau Surat Permohonan Hosting melalui `x-ui.document-viewer`.

**Files Modified:**

- [x] app/Http/Controllers/PseVerificationController.php
- [x] app/Http/Controllers/PseVerification2Controller.php
- [x] resources/views/pse-verification/show.blade.php
- [x] resources/views/pse-verification2/show.blade.php
- [x] doc/TASKS.md

## 65. Integrasi Subdomain PSE 1-N (Single Flow Subdomain)

**Status:** ✅ Done (2026-04-04)
**Prioritas:** High
**Severity:** 🔴 High - Breaking Database Changes

**Deskripsi:**
Melakukan normalisasi data dengan memindahkan seluruh pengelolaan subdomain dari tabel utama `pses` ke tabel relasi `subdomain_requests`. Pengguna dapat mendaftarkan banyak subdomain dalam satu pengajuan (1-N) menggunakan antarmuka pendaftaran bergaya Gmail-style (Chips/Tags Input) yang modern dan intuitif.

**Scope Implementasi:**

- [x] **Database Refactor**: Migrasi `refactor_pse_subdomain_structure` untuk menghapus kolom redundan di `pses`.
- [x] **Gmail-style Chips Input UI**: Komponen `chips-input.blade.php` berbasis Vanilla JS (Premium Design) dengan validasi _duplicate/invalid_.
- [x] **Model & Helper Sync**: Logika normalisasi via `SubdomainHelper` dan relasi 1-N di model `Pse`.
- [x] **Relational Safety Net**: Proteksi `pse_id` dan `request_type` pada pengeditan draf mandiri untuk mencegah _relational drift_.
- [x] **Unified Document Flow**: Penanganan unggah surat permohonan subdomain kolektif dalam form PSE yang terdistribusi ke seluruh request terkait.
- [x] **Controller Integration**: Sinkronisasi status serentak ke `pending_1` (Single Flow) di `PseController@submit`.
- [x] **Verification Interface**: Penampil daftar subdomain tabel-sm dan Document Viewer bagi verifikator.
- [x] **Index View Refactor**: Penyederhanaan tabel index PSE dengan menghapus kolom URL/Subdomain untuk kebersihan UI.

**Files Modified:**

- [x] `app/Models/Pse.php`
- [x] `app/Http/Controllers/PseController.php`
- [x] `app/Http/Controllers/SubdomainRequestController.php`
- [x] `app/Http/Controllers/HostingRequestController.php`
- [x] `resources/views/pse/create.blade.php` & `edit.blade.php`
- [x] `resources/views/subdomain/edit.blade.php` & `hosting/edit.blade.php`
- [x] `resources/views/pse-verification/show.blade.php`
- [x] `database/migrations/2026_04_04_000246_refactor_pse_subdomain_structure.php`

## 66. Spesialisasi Daftar Hosting Petugas (Point 9 TODO)

**Status:** ✅ Completed
**Prioritas:** Medium
**Severity:** 🟢 Low - UI/UX Improvement

**Deskripsi:**
Menyempurnakan dashboard/index pengajuan hosting bagi petugas dan verifikator agar hanya menampilkan data pengajuan yang berasal dari PSE dengan Lokasi Penyimpanan "Aplikasi". Data colocation atau eksternal yang tidak memerlukan pengelolaan hosting standard disembunyikan secara otomatis melalui filter di level Controller di seluruh tahapan (Entry, Verif 1, Verif 2).

**Scope Implementasi:**

- [x] **Controller Logic Filter**: Memperbarui `index` method pada `HostingRequestController`, `HostingVerificationController`, dan `HostingVerification2Controller`.
- [x] **Verification Consistency**: Memastikan verifikator 1 dan 2 memiliki pandangan yang sama dengan petugas mengenai daftar hosting yang valid (Aplikasi).
- [x] **TODO Update**: Memperbarui status poin 9 di `doc/TODO.md`.

**Files Modified:**

- [x] app/Http/Controllers/HostingRequestController.php
- [x] app/Http/Controllers/HostingVerificationController.php
- [x] app/Http/Controllers/HostingVerification2Controller.php
- [x] doc/TASKS.md
- [x] doc/TODO.md

## 67. Revitalisasi Modern Dasbor & Standarisasi UI Interaktif

**Status:** ✅ Done (2026-04-04)
**Prioritas:** High
**Severity:** 🟢 Low - Comprehensive UI/UX Overhaul

**Deskripsi:**
Transformasi menyeluruh antarmuka dasbor dan komponen kartu sistem dari desain standar menjadi desain premium yang dinamis. Tugas ini mencakup sinkronisasi metrik performa antar peran pengguna, standarisasi bahasa desain interaktif (shadow, scale, rounded), penanganan efek 'theme-blink', serta penambahan fitur filter hosting in-card yang mendukung data global.

**Scope Implementasi:**

- [x] **Universal Interactivity**: Standarisasi komponen `x-ui.card` dan `x-ui.stat-card` dengan efek `hover:scale-[1.01]`, `hover:shadow-2xl`, dan sudut lengkung `rounded-[2rem]`.
- [x] **Blink-Free Transitions**: Menghilangkan efek 'blink' saat pergantian tema pada komponen kartu dan menu pilihan (select) dengan spesifikasi transisi yang presisi.
- [x] **Role-Based Metric Sync**: Sinkronisasi rentang waktu tren bulanan (Submitted vs Approved) dan grafik 30-hari yang konsisten bagi seluruh peran (Petugas, Verifikator, Admin).
- [x] **Global Hosting Filter**: Implementasi opsi 'Semua' (All) pada filter hosting yang secara cerdas beralih antara statistik spesifik dan akumulasi data global di `DashboardController`.
- [x] **Multilingual Integration**: Menambahkan dukungan translasi penuh di `en.json` untuk seluruh metrik performa dan label dasbor yang baru.

**Files Modified:**

- [x] app/Http/Controllers/DashboardController.php
- [x] resources/views/dashboard.blade.php
- [x] resources/views/components/ui/stat-card.blade.php
- [x] resources/views/components/ui/card.blade.php
- [x] lang/en.json
- [x] doc/TASKS.md

## 69. Otomasi Pembersihan Data Hosting Terkait (Single Flow Cleanup)

**Status:** ✅ Completed (2026-04-07)
**Prioritas:** Medium (🟡)
**Severity:** 🟢 Fixed - Data Integrity

Menghapus data hosting otomatis jika `storage_location` pada PSE diubah dari 'Aplikasi' ke opsi lain guna menjaga integritas data dan mencegah data 'sampah' terkirim saat pengajuan.

**Scope Implementasi:**

- [x] **PseController@update**: Tambahkan logika deteksi perubahan lokasi penyimpanan (aplikasi -> non-aplikasi).
- [x] **Hosting Record Cleanup**: Hapus otomatis record `HostingRequest` terkait yang masih berstatus `draft` atau `rejected`.
- [x] **Physical File Removal**: Gunakan `Storage::disk('private')->delete()` untuk menghapus surat permohonan hosting yang sudah tidak relevan.
- [x] **Policy Validation**: Memastikan penghapusan hanya terjadi jika pengajuan belum dikunci oleh verifikator.
- [x] **Flash Message Sync**: Memberikan feedback kepada user bahwa draf hosting yang sebelumnya ada telah dibersihkan otomatis.

**Files Modified:**

- `app/Http/Controllers/PseController.php`
- `app/Models/HostingRequest.php`
- `doc/TASKS.md`

## 70. Simplifikasi Validasi Pengajuan (Hapus Pengecekan Profil/Surat Tugas)

**Status:** ✅ Done (2026-04-07)
**Prioritas:** High (🔴 Mencegah RouteNotFoundException)

Karena manajemen profil kini sepenuhnya dikelola oleh Admin, petugas tidak lagi memiliki akses ke `profile.edit`. Pengecekan `hasCompleteProfile()` pada setiap rute `submit` menjadi redundan dan menyebabkan error `Route [profile.edit] not defined`.

**Akar Masalah:**

- `app/Models/User.php` (L113-L148): Method `hasCompleteProfile()` mengecek kelengkapan NIP, Jabatan, OPD, dan Surat Tugas — field yang kini dikelola Admin, bukan petugas.

**Scope Implementasi:**

- [x] **PseController@submit** (L460): Hapus blok pengecekan `hasCompleteProfile()` dan redirect ke `profile.edit`.
- [x] **SubdomainRequestController@submit** (L338): Hapus blok pengecekan `hasCompleteProfile()` dan redirect ke `profile.edit`.
- [x] **HostingRequestController@submit** (L366): Hapus blok pengecekan `hasCompleteProfile()` dan redirect ke `profile.edit`.
- [x] **Cleanup Model User** (L113-L148): Hapus method `hasCompleteProfile()`.
- [x] **Cleanup Language Files**: Hapus key `error.profile_incomplete_submit` dari `lang/id/messages.php` dan `lang/en/messages.php`.

**Files Modified:**

- `app/Http/Controllers/PseController.php`
- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/HostingRequestController.php`
- `app/Models/User.php`
- `lang/id/messages.php`
- `lang/en/messages.php`

---

## 71. Sinkronisasi Pengajuan Timbal Balik Modul Single Flow

**Status:** ✅ Done (2026-04-07)
**Prioritas:** Medium (🟡)

Saat ini, pengajuan serentak hanya terjadi jika tombol "Ajukan" diklik dari halaman detail PSE (`PseController@submit`). Namun jika draf Subdomain atau Hosting yang berasal dari Single Flow diajukan secara terpisah melalui index/show masing-masing, pengajuan akan gagal karena:

1. **SubdomainRequestController@submit** mensyaratkan PSE induk sudah `approved` (L355), padahal dalam Single Flow PSE-nya masih `draft`.
2. **HostingRequestController@submit** tidak memiliki pengecekan status PSE, tapi tetap hanya mengajukan record hosting itu sendiri tanpa menyertakan PSE dan subdomain terkait.
3. Tombol "Ajukan" tetap muncul di halaman index/show subdomain dan hosting walaupun data berasal dari Single Flow (PSE masih draft).

**Opsi Solusi:**

- **Opsi A (Bilateral Submit):** Jika subdomain/hosting diajukan dan PSE induknya masih `draft` (atau `rejected`), pengajuan secara otomatis akan diteruskan (delegate) ke fungsi `PseController@submit` sehingga seluruh draf ikut diajukan secara paralel. Pengguna juga akan memberikan konfirmasi (alert) jika alur ini terpicu.

**Scope Implementasi:**

- [x] **SubdomainRequestController@submit**: Memforward proses submit ke `PseController@submit` jika status PSE terkait masih `draft` atau `rejected`.
- [x] **HostingRequestController@submit**: Memforward proses submit ke `PseController@submit` jika status PSE terkait masih `draft` atau `rejected`.
- [x] **UI/View**: Modifikasi konfirmasi via `onclick` di halaman show subdomain dan hosting; tampilkan pesan khusus jika data berasal dari Single Flow.

**Files Modified:**

- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/HostingRequestController.php`
- `resources/views/subdomain/show.blade.php`
- `resources/views/hosting/show.blade.php`
- `resources/views/subdomain/index.blade.php`
- `resources/views/hosting/index.blade.php`
- `lang/en.json`

---

## 72. Pembersihan Data Subdomain Orphan & Relaksasi Validasi Dokumen (Single Flow)

**Status:** ✅ Done (2026-04-07)
**Prioritas:** Medium (🟡)

### A. Pembersihan File Orphan Subdomain

Saat PSE berstatus `draft` atau `rejected` diedit dan daftar subdomain diubah (subdomain dihapus dari list), record `SubdomainRequest` yang tidak lagi ada di list baru akan dihapus. Namun, **file fisik surat permohonan** yang terkait dengan subdomain tersebut **tidak ikut dihapus**, sehingga meninggalkan file orphan di `storage/app/private/documents/subdomain/`.

Task ini menerapkan pola yang sama dengan Task #69 (Hosting Cleanup) untuk menjaga integritas data dan storage.

**Masalah Saat Ini (PseController@update L336-L338):**

```php
// Hanya hapus record DB, file fisik TIDAK dihapus
$pse->subdomainRequests()
    ->whereNotIn('subdomain_name', $newSubdomainNames)
    ->delete();
```

### B. Relaksasi Validasi Dokumen saat Create PSE

Saat ini, `PseController@store` (L115) mensyaratkan `surat_subdomain` sebagai **`required`**, yang berarti dokumen surat permohonan subdomain harus diunggah bersamaan dengan pembuatan PSE. Hal ini kurang fleksibel karena petugas mungkin belum memiliki surat permohonan saat pertama kali mendaftarkan PSE.

**Perubahan:** Dokumen subdomain (`surat_subdomain`) dan hosting (`surat_permohonan`) boleh kosong saat **create** (`store`), namun tetap **wajib ada saat submit** (`PseController@submit`). Validasi kelengkapan berkas di `PseController@submit` (L459-474) sudah menangani pengecekan ini — jadi hanya perlu merelaksasi rule validasi di `store`.

**Kondisi Saat Ini (PseController@store L115):**

```php
'surat_subdomain' => ['required', 'file', 'mimes:pdf', 'max:5120'],
```

**Target:**

```php
'surat_subdomain' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
```

**Scope Implementasi:**

- [x] **PseController@update**: Sebelum menghapus record subdomain yang tidak ada di list baru, iterasi dan hapus file fisik terkait via `Storage::disk('private')->delete()`.
- [x] **Document Cleanup**: Hapus record `documents` (polimorfik) yang terkait dengan subdomain yang dihapus.
- [x] **PseController@store**: Ubah validasi `surat_subdomain` dari `required` menjadi `nullable`. Validasi `surat_permohonan` (hosting) juga sudah `nullable` secara kondisional — pastikan konsisten.
- [x] **Flash Message**: Tambahkan notifikasi jika ada data subdomain yang dibersihkan otomatis.

**Files to Modify:**

- `app/Http/Controllers/PseController.php`
- `lang/en.json`

---

## 73. Proteksi Penghapusan Mandiri Data Single Flow

**Status:** ✅ Done (2026-04-07)
**Prioritas:** Medium (🟡)

Jika subdomain atau hosting dibuat melalui Single Flow PSE (PSE induk masih berstatus `draft` atau `rejected`), maka petugas **tidak boleh menghapusnya secara mandiri** melalui index/show subdomain atau hosting. Petugas harus diarahkan untuk mengelola (edit/hapus) data tersebut melalui halaman **Edit PSE** agar konsistensi data Single Flow tetap terjaga.

**Masalah Saat Ini:**

- `SubdomainRequestController@destroy` dan `HostingRequestController@destroy` tidak mengecek apakah data berasal dari Single Flow.
- Petugas bisa menghapus subdomain/hosting secara terpisah walaupun PSE induk masih draft, yang berpotensi menyebabkan PSE kehilangan subdomain wajib atau data hosting menjadi tidak sinkron.

**Deteksi Single Flow:**

Data dianggap berasal dari Single Flow jika PSE induknya (`$subdomain->pse` / `$hosting->pse`) masih berstatus `draft` atau `rejected` (belum pernah `approved`).

**Scope Implementasi:**

- [x] **SubdomainRequestController@destroy**: Cek status PSE induk; jika masih `draft/rejected`, tolak penghapusan dan redirect ke `pse.edit` dengan pesan error.
- [x] **HostingRequestController@destroy**: Cek status PSE induk; jika masih `draft/rejected`, tolak penghapusan dan redirect ke `pse.edit` dengan pesan error.
- [x] **UI/View**: Sembunyikan sepenuhnya aksi/tombol "Hapus" pada tabel index subdomain dan hosting jika PSE induk masih `draft/rejected` (bagian dari Single Flow).
- [x] **Flash Message (Server-side)**: Tangani bypass request penghapusan melalui controller dengan mengembalikan pesan error _"Data ini merupakan bagian dari pengajuan PSE (Single Flow). Silakan kelola melalui halaman Edit PSE."_

**Files to Modify:**

- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/HostingRequestController.php`
- `resources/views/subdomain/index.blade.php` (atau show)
- `resources/views/hosting/index.blade.php` (atau show)
- `lang/en.json` jika ada

---

## 74. Perbaikan Urutan Validasi Dokumen pada Submit Single Flow

**Status:** ✅ Done (2026-04-07)
**Prioritas:** High (🔴) — Bug Fix

Saat user melakukan submit dari halaman index/show subdomain atau hosting (melalui `SubdomainRequestController@submit` dan `HostingRequestController@submit`), validasi keberadaan dokumen berjalan **sebelum** pengecekan delegasi Single Flow. Akibatnya, jika data tersebut merupakan bagian dari Single Flow, validasi dokumen mengembalikan error ke halaman yang salah dan memblokir delegasi ke `PseController@submit` yang seharusnya menangani validasi secara terpusat.

**Inkonsistensi yang Terjadi:**

| Skenario                                                               | Saat Ini (Salah)            | Seharusnya                                         |
| ---------------------------------------------------------------------- | --------------------------- | -------------------------------------------------- |
| Submit subdomain **non-primary** (tanpa dokumen, by design) dari index | ❌ Gagal → `subdomain.edit` | ✅ Delegasi ke `PseController@submit`              |
| Submit subdomain **primary tanpa dokumen** dari index (Single Flow)    | ❌ Gagal → `subdomain.edit` | ✅ Gagal → `pse.edit` (via `PseController@submit`) |
| Submit hosting **tanpa dokumen** dari index (Single Flow)              | ❌ Gagal → `hosting.edit`   | ✅ Gagal → `pse.edit` (via `PseController@submit`) |

**Akar Masalah:**

Urutan validasi di kedua controller anak salah — pengecekan dokumen diletakkan **sebelum** pengecekan delegasi Single Flow.

**SubdomainRequestController@submit (L338-356) — Saat Ini:**

```php
// 1. Cek dokumen DULU (berjalan duluan) ← MASALAH
if (!$subdomain->document) {
    return redirect()->route('subdomain.edit', $subdomain) // salah arah
        ->with('error', ...);
}

// 2. Delegasi Single Flow (tidak pernah tercapai jika dokumen kosong)
if (in_array($subdomain->pse->status, ['draft', 'rejected'])) {
    return app(PseController::class)->submit($subdomain->pse);
}
```

**Target Perbaikan:**

```php
// 1. Delegasi Single Flow DULU
if (in_array($subdomain->pse->status, ['draft', 'rejected'])) {
    return app(PseController::class)->submit($subdomain->pse);
}

// 2. Cek dokumen hanya untuk alur mandiri (PSE sudah approved)
if (!$subdomain->document) {
    return redirect()->route('subdomain.edit', $subdomain)
        ->with('error', ...);
}
```

**Scope Implementasi:**

- [x] **SubdomainRequestController@submit**: Pindahkan blok pengecekan delegasi Single Flow (`in_array($subdomain->pse->status, ['draft', 'rejected'])`) ke **sebelum** validasi dokumen.
- [x] **HostingRequestController@submit**: Pindahkan blok pengecekan delegasi Single Flow ke **sebelum** validasi dokumen.

**Catatan:** Validasi dokumen secara terpusat sudah ditangani oleh `PseController@submit` (L499-515), jadi tidak perlu duplikasi di controller anak untuk alur Single Flow.

**Files to Modify:**

- `app/Http/Controllers/SubdomainRequestController.php`
- `app/Http/Controllers/HostingRequestController.php`

---

## 75. Konsolidasi View Verifikasi PSE (Show Page)

**Status:** ✅ Done
**Prioritas:** Medium

Penggabungan dua file verifikasi PSE (`pse-verification/show` dan `pse-verification2/show`) menjadi satu file tunggal yang dinamis untuk efisiensi pemeliharaan UI/UX premium.

**Fitur Implementasi:**

- [x] Identifikasi konteks verifikator via rute (`request()->routeIs(...)`).
- [x] Penyesuaian Header, Judul, dan Breadcrumb secara dinamis.
- [x] Kondisional field **Nomor Registrasi** (hanya muncul pada Verifikasi Final).
- [x] Kondisional rute aksi Form (Approve/Reject) sesuai tahapan.
- [x] Reorganisasi logika form verifikasi ke dalam satu file tunggal.
- [x] Penghapusan file redundan `pse-verification2/show.blade.php`.

**Files Modified:**

- `app/Http/Controllers/PseVerification2Controller.php` - Redirect view target
- `resources/views/pse-verification/show.blade.php` - Unified logic
- `resources/views/pse-verification2/show.blade.php` - DELETED

---

## 68. Manajemen OPD (CRUD) & Soft Delete - Admin Only

**Status:** ✅ Done  
**Prioritas:** High  
**Kategori:** Admin Flexibility & Data Management

Mengimplementasikan fitur CRUD sederhana untuk entitas OPD (Organisasi Perangkat Daerah), karena OPD sebelumnya tidak dapat dikelola melalui antarmuka web. Fitur ini dirancang khusus untuk administrator, dan OPD juga diberikan kapabilitas _Soft Delete_ agar penghapusan data instansi tetap aman tanpa merusak integritas _foreign key_ tabel lain.

**Fitur Implementasi:**

- [x] Otorisasi ketat (_strict auth_) via `OpdPolicy` yang didaftarkan pada `AuthServiceProvider` (Hanya _Admin_ yang berhak melakukan operasi apapun).
- [x] Rute _Resource_ pada grup _middleware_ admin di `routes/web.php`.
- [x] Antarmuka Tabel Index modern (dilengkapi fitur _sorting_, _pagination_, kolom pencarian, filter status "Aktif / Dihapus", serta _badge_ identifikasi status).
- [x] Form penambahan dan penyuntingan data OPD yang seragam dengan _UI kit/design system_ (menggunakan `<x-ui.card>` dan komponen Form bawaan).
- [x] Menerapkan migrasi Kolom `deleted_at`, menyematkan `SoftDeletes` _trait_ pada instans Model `Opd`, sekaligus menyuntikkan dukungan API _restore_.
- [x] Tombol "Edit", "Hapus (Nonaktifkan)" dan "Pulihkan" yang diatur reaktif berlandaskan status keberadaan objek data.

**Files to Modify/Created:**

- `app/Http/Controllers/OpdController.php` (Baru)
- `app/Policies/OpdPolicy.php` (Baru)
- `routes/web.php`
- `app/Providers/AuthServiceProvider.php`
- `app/Models/Opd.php`
- `[Migration] add_deleted_at_to_opds_table`
- `resources/views/opd/index.blade.php` (Baru)
- `resources/views/opd/create.blade.php` (Baru)
- `resources/views/opd/edit.blade.php` (Baru)
- `resources/views/layouts/sidebar.blade.php`

---

## 77. Hapus Dependensi Alpine.js (🟡 Medium Priority - Cleanup)

**Status:** ✅ Done (2026-04-08)
**Prioritas:** Medium  
**Kategori:** Cleanup / Frontend Architecture

Menghapus seluruh penggunaan Alpine.js dari codebase. Aplikasi sudah sebagian besar beralih ke DaisyUI native components (Drawer, Dropdown, Modal menggunakan `<dialog>`), sehingga Alpine.js hanya tersisa sebagai _dead weight_ dengan penggunaan minimal.

**Penggunaan Alpine.js Saat Ini:**

| File                                                      | Penggunaan                                   | Fungsi                                                |
| --------------------------------------------------------- | -------------------------------------------- | ----------------------------------------------------- |
| `resources/js/app.js`                                     | `import Alpine` + `Alpine.start()`           | Inisialisasi global                                   |
| `user/partials/update-profile-information-form.blade.php` | `x-data`, `x-show`, `x-transition`, `x-init` | Flash message "Berhasil disimpan" (auto-hide 2 detik) |
| `user/partials/update-opd-information-form.blade.php`     | `x-data`, `x-show`, `x-transition`, `x-init` | Flash message "Berhasil disimpan" (auto-hide 2 detik) |

**Scope Implementasi:**

- [x] Ganti flash message Alpine.js di `update-profile-information-form.blade.php` dengan CSS animation atau vanilla JS.
- [x] Ganti flash message Alpine.js di `update-opd-information-form.blade.php` dengan CSS animation atau vanilla JS.
- [x] Hapus import Alpine.js dari `resources/js/app.js` (`import Alpine`, `window.Alpine`, `Alpine.start()`).
- [x] Uninstall package Alpine.js dari `package.json` (`npm uninstall alpinejs`).
- [x] Verifikasi tidak ada penggunaan Alpine.js lain yang terlewat (`grep x-data, x-show, x-on, @click`).
- [x] Rebuild assets (`npm run build`) dan pastikan tidak ada error.

**Alternatif untuk Flash Message:**

```html
{{-- Opsi 1: CSS Animation (auto-hide tanpa JS) --}}
<p class="animate-fade-out text-sm text-success">
    {{ __('Berhasil disimpan.') }}
</p>

{{-- Opsi 2: Vanilla JS --}}
<p
    id="save-status"
    class="text-sm text-success transition-opacity duration-300"
>
    {{ __('Berhasil disimpan.') }}
</p>
<script>
    setTimeout(() => {
        document.getElementById("save-status")?.classList.add("opacity-0");
    }, 2000);
</script>
```

**Manfaat:**

- Mengurangi bundle size (~15KB gzipped dari Alpine.js).
- Menyederhanakan stack frontend (hanya DaisyUI + Vanilla JS).
- Menghilangkan dependensi yang hampir tidak digunakan.

**Files to Modify:**

- `resources/js/app.js`
- `resources/views/user/partials/update-profile-information-form.blade.php`
- `resources/views/user/partials/update-opd-information-form.blade.php`
- `package.json`

---

## 78. Refactor Halaman Edit User (Template Konsisten dengan Create) (🟡 Medium Priority)

**Status:** ✅ Done (2026-04-08)
**Prioritas:** Medium  
**Kategori:** UI/UX Consistency

Mengubah halaman Edit User agar menggunakan template dan layout yang sama dengan halaman Create User (formulir full-page dalam `x-ui.card`), menggantikan layout partials Breeze yang terpisah-pisah.

**Masalah Saat Ini:**

Halaman edit user (`user/edit.blade.php`) menggunakan pola **Laravel Breeze default** dengan 3 section terpisah:

1. `user/partials/update-profile-information-form.blade.php` — Form profil (termasuk Alpine.js)
2. `user/partials/update-opd-information-form.blade.php` — Form OPD (termasuk Alpine.js)
3. `user/partials/delete-user-form.blade.php` — Form hapus akun

Hal ini menyebabkan:

- Inkonsistensi visual dengan halaman Create User yang sudah menggunakan layout 2-kolom modern.
- Penggunaan Alpine.js yang tidak perlu (terkait Task #77).
- Tiga form terpisah dengan tiga tombol "Simpan" berbeda, membingungkan user.

**Target Desain:**

Menyerupai `user/create.blade.php`:

- Satu `x-ui.card` dengan judul "Edit Data Petugas".
- Layout 2-kolom: **Kolom Kiri** (Data Diri) dan **Kolom Kanan** (Informasi Instansi).
- Satu form tunggal dengan satu tombol "Simpan".
- Surat Tugas dengan preview dokumen yang sudah ada (menggunakan `x-ui.document-viewer`).
- Zona bahaya hapus akun tetap terpisah di bawah (jika diperlukan).

**Scope Implementasi:**

- [x] Refactor `user/edit.blade.php` menjadi single-form layout 2-kolom (mirip `create.blade.php`).
- [x] Pindahkan logika dari partials ke dalam `edit.blade.php` langsung.
- [x] Tambahkan `x-ui.document-viewer` untuk preview surat tugas yang sudah ada.
- [x] Konsolidasi form OPD dan Profil menjadi satu form dengan satu endpoint.
- [x] Pertahankan form hapus akun sebagai section terpisah di bawah (zona bahaya).
- [x] Hapus file partials yang tidak lagi digunakan setelah refactor (opsional, pastikan tidak dipakai di tempat lain).
- [x] Update controller `UserController@update` jika perlu menangani semua field dalam satu request.

**Dependensi:**

- Task #77 (Hapus Alpine.js) — Sebaiknya dikerjakan bersamaan karena partials yang menggunakan Alpine.js akan di-refactor.

**Files to Modify:**

- `resources/views/user/edit.blade.php` — Refactor total
- `resources/views/user/partials/update-profile-information-form.blade.php` — Akan di-deprecate atau dihapus
- `resources/views/user/partials/update-opd-information-form.blade.php` — Akan di-deprecate atau dihapus
- `app/Http/Controllers/UserController.php` — Update method `update()` jika perlu

---

## Task #79 — Proteksi ID Enumeration pada Route Dokumen (UUID Document)

**Status:** ✅ Done (2026-04-08)  
**Prioritas:** 🔴 High Priority  
**Kategori:** Security Hardening  
**Estimasi:** Medium (2–3 jam)

**Latar Belakang:**

Saat ini, model `Document` menggunakan `id` integer sebagai primary key. Hal ini menyebabkan URL unduhan dokumen mengekspos ID yang mudah ditebak dan di-_enumerate_, contoh:

```
GET /documents/1/download
GET /documents/2/download
```

Meskipun sudah ada _authorization check_ via Policy di `DocumentController@download`, URL berbasis integer Integer tetap membuka potensi **ID Enumeration Attack** — penyerang dapat secara sistematis mencoba angka `1, 2, 3, ...` untuk mengeksplorasi keberadaan dokumen.

Solusi yang direkomendasikan adalah menambahkan kolom `uuid` pada tabel `documents` dan menggunakannya sebagai identifikasi pada route, konsisten dengan standar yang sudah diterapkan pada model `User` (Task #57).

**Ruang Lingkup Perubahan:**

- [x] Buat migration baru untuk menambah kolom `uuid` pada tabel `documents`.
- [x] Tambahkan Trait `HasUuid` (sudah ada di project) ke model `Document`.
- [x] Ubah `getRouteKeyName()` pada model `Document` agar me-resolve berdasarkan `uuid`, bukan `id`.
- [x] Verifikasi seluruh penggunaan `route('documents.download', $document)` di view — tidak perlu diubah karena Laravel akan otomatis menggunakan `uuid` sebagai route key.
- [x] Pastikan tidak ada hardcoded `$document->id` pada URL atau query di view dan controller.

**Dependensi:**

- Trait `HasUuid` sudah tersedia di `app/Traits/HasUuid.php` — tinggal di-_attach_ ke model.
- Migration baru harus dibuat, **jangan edit migration lama** (sesuai `doc/AGENTS.md`).

**Files to Modify:**

- `app/Models/Document.php` — Tambah trait `HasUuid` dan override `getRouteKeyName()`
- `database/migrations/xxxx_add_uuid_to_documents_table.php` — Migration baru (buat)

**Files to Verify (tidak harus diubah):**

- `resources/views/components/ui/document-viewer.blade.php`
- `resources/views/components/form/current-file.blade.php`
- `resources/views/components/display/document-card.blade.php`
- `app/Http/Controllers/DocumentController.php`

---

## Task #80 — Rekam Jejak Audit Entitas Turunan Single Flow

**Status:** ✅ Done (2026-04-10)
**Prioritas:** 🟡 Medium Priority  
**Kategori:** Data Integrity / Audit Trail  
**Estimasi:** Medium (2–3 jam)

**Latar Belakang:**

Pada alur *Single Flow*, saat verifikator menyetujui atau menolak sebuah pengajuan PSE, perubahan status pada entitas turunannya (`SubdomainRequest` dan `HostingRequest`) dilakukan via *bulk update* (`update(['status' => '...'])`). Akibatnya, **tidak ada rekaman `VerificationHistory`** yang dibuat untuk entitas turunan tersebut.

Hal ini menyebabkan:
- Halaman detail Subdomain dan Hosting tidak memiliki *timeline* riwayat verifikasi.
- Tidak ada jejak audit yang jelas "siapa dan kapan" status subdomain/hosting berubah.
- Melanggar prinsip *best-practice* audit trail — setiap perubahan status pada record harus disertai log.

Skenario: Jika petugas membuka detail halaman Subdomain yang sudah `approved`, komponen *Riwayat Verifikasi* di sidebar akan kosong, meskipun status sudah berubah. Rekam jejak hanya bisa ditelusuri dari halaman PSE induknya.

**Ruang Lingkup Perubahan:**

Di dalam setiap `DB::transaction()` pada controller verifikasi, ganti *bulk update* untuk entitas turunan dengan iterasi *loop* yang sekaligus membuat entry `VerificationHistory` untuk masing-masing record.

- [x] Refactor `PseVerificationController@approve` — loop SubdomainRequest & HostingRequest, buat `VerificationHistory` per entitas
- [x] Refactor `PseVerificationController@reject` — loop SubdomainRequest & HostingRequest, buat `VerificationHistory` per entitas
- [x] Refactor `PseVerification2Controller@approve` — loop SubdomainRequest & HostingRequest, buat `VerificationHistory` per entitas
- [x] Refactor `PseVerification2Controller@reject` — loop SubdomainRequest & HostingRequest, buat `VerificationHistory` per entitas
- [x] Verifikasi view `subdomain-verification/show.blade.php` — pastikan komponen *Riwayat Verifikasi* sudah me-load relasi `verificationHistories`
- [x] Verifikasi view `hosting-verification/show.blade.php` — pastikan komponen *Riwayat Verifikasi* sudah me-load relasi `verificationHistories`

**Contoh Implementasi (di dalam `DB::transaction()`):**

```php
// Ganti bulk update:
$pse->subdomainRequests()->where('status', 'pending_1')->update(['status' => 'pending_2']);

// Dengan iterasi + buat riwayat:
foreach ($pse->subdomainRequests()->where('status', 'pending_1')->get() as $sub) {
    $sub->update(['status' => 'pending_2']);
    VerificationHistory::create([
        'user_id'          => Auth::id(),
        'verifiable_id'   => $sub->id,
        'verifiable_type' => SubdomainRequest::class,
        'status'          => 'pending_2',
        'notes'           => $notes, // Catatan dari verifikator
    ]);
}
```

**Dependensi:**

- Model `VerificationHistory` dengan relasi `morphTo('verifiable')` sudah tersedia.
- Trait `HasUuid` dan relasi `verificationHistories` sudah terdapat pada model `SubdomainRequest` dan `HostingRequest`.

**Files to Modify:**

- `app/Http/Controllers/PseVerificationController.php` — Refactor `approve()` dan `reject()`
- `app/Http/Controllers/PseVerification2Controller.php` — Refactor `approve()` dan `reject()`

**Files to Verify (tidak harus diubah, cek view sudah me-load relasi):**

- `resources/views/subdomain-verification/show.blade.php`
- `resources/views/hosting-verification/show.blade.php`

---

## Task #81 — Batasi Akses Riwayat Verifikasi Sesuai Spesifikasi

**Status:** ✅ Done (2026-04-09)
**Prioritas:** 🟡 Medium Priority  
**Kategori:** RBAC / Access Control  
**Estimasi:** Low (30–60 menit)

**Latar Belakang:**

Berdasarkan `doc/TODO.md` (11 Poin Utama), peran Eksekutif hanya memiliki akses ke **laporan dan rekap data** (Poin 8 & 10). Halaman *Riwayat Verifikasi* tidak termasuk dalam spesifikasi yang ditetapkan.

Saat ini, `routes/web.php` memberikan akses ke `verification.history` pada group middleware yang mencakup `admin` dan `eksekutif`:

```php
Route::middleware('role:verifikator_1,verifikator_2,admin,eksekutif')->group(function () {
    Route::get('verification/history', ...)->name('verification.history');
    ...
});
```

Begitu pula di sidebar, variabel `$canSeeReports` (yang mengontrol visibilitas menu Riwayat Verifikasi) mencakup peran `admin` dan `eksekutif`.

**Ruang Lingkup Perubahan:**

- [x] **`routes/web.php`**: Pisahkan route `verification.history` ke grup middleware tersendiri yang hanya mencakup `verifikator_1` dan `verifikator_2`.
- [x] **`resources/views/layouts/sidebar.blade.php`**: Update variabel `$canSeeReports` agar hanya bernilai `true` untuk `verifikator_1` dan `verifikator_2`.

**Files to Modify:**

- `routes/web.php` — Pisahkan route riwayat verifikasi ke middleware hanya untuk verifikator
- `resources/views/layouts/sidebar.blade.php` — Update kondisi `$canSeeReports`

---

## Task #82 — Penyesuaian Seluruh Laporan PDF dengan Kondisi Single Flow

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🟡 Medium Priority  
**Kategori:** Bug Fix / Data Accuracy  
**Estimasi:** Medium (1–2 jam)

**Latar Belakang:**

Setelah implementasi *Single Flow* (Task #63–#65), sistem PSE kini mendukung relasi **1-N subdomain** per PSE. Namun beberapa template laporan PDF belum disesuaikan dan masih menggunakan pola lama. Terdapat juga inkonsistensi dalam cara menampilkan nama subdomain (prefix saja vs nama lengkap dengan suffix domain).

**Desain Penyimpanan Subdomain di Database:**

- DB menyimpan hanya **prefix**: `puskesmas`
- Untuk tampil nama lengkap: `$item->subdomain_name . '.' . batam.go.id` → `puskesmas.batam.go.id`
- Untuk tampil URL: `$item->subdomain_url` (Accessor) → `https://puskesmas.batam.go.id`

**Masalah yang Ditemukan per Template:**

### 1. `pse_registration.blade.php` — ⚠️ Belum diperbaiki

- **`$pse->subdomain_name`**: Field ini **tidak ada di `$fillable` model `Pse`** dan tidak ada accessor-nya. Selalu tampil `'-'`. Merupakan sisa desain lama sebelum *Single Flow*.
- **`$pse->url`**: Sudah berupa Accessor dari `primarySubdomain->subdomain_url`, namun hanya mencerminkan 1 subdomain utama.
- **Dampak**: Bagian Subdomain di laporan Tanda Daftar PSE selalu kosong/tidak akurat.

### 2. `recap.blade.php` — ⚠️ Belum diperbaiki

- **Baris 62**: `{{ $item->subdomain_name }}` hanya menampilkan prefix `puskesmas`, bukan nama lengkap `puskesmas.batam.go.id`.
- **Dampak**: Laporan rekap subdomain menampilkan nama yang tidak lengkap dan tidak informatif.

### 3. `subdomain_approval.blade.php` — ✅ Sudah diperbaiki

- Sebelumnya: `{{ $subdomain->subdomain_name }}batam.go.id` → `puskesmasbatam.go.id` (salah, hilang titik)
- Sesudah: `{{ $subdomain->subdomain_name }}.batam.go.id` → `puskesmas.batam.go.id` (benar)

**Solusi yang Direkomendasikan:**

**Untuk `pse_registration.blade.php`:** Ganti baris "URL Sistem" & "Nama Subdomain" dengan daftar subdomain dari relasi `subdomainRequests`:

```php
{{-- Daftar Subdomain (1-N) --}}
<tr>
    <td valign="top">Daftar Subdomain</td>
    <td valign="top">:</td>
    <td>
        @forelse ($pse->subdomainRequests as $sub)
            <div>
                {{ $sub->subdomain_name }}.batam.go.id
                @if ($sub->is_primary)<em> [Utama]</em>@endif
            </div>
        @empty
            -
        @endforelse
    </td>
</tr>
```

**Untuk `recap.blade.php`:** Tambahkan suffix pada kolom Nama Subdomain:

```php
{{-- Sebelum: --}}
<td>{{ $item->subdomain_name }}</td>

{{-- Sesudah: --}}
<td>{{ $item->subdomain_name }}.batam.go.id</td>
```

**Ruang Lingkup Perubahan:**

- [x] `subdomain_approval.blade.php` — Perbaiki format nama subdomain (titik pemisah) ✅ Selesai
- [x] `pse_registration.blade.php` — Ganti field obsolete dengan daftar subdomain dari relasi 1-N
- [x] `recap.blade.php` — Tambahkan suffix domain pada kolom Nama Subdomain (baris 62)
- [x] Pastikan `IssuanceController@printPse` meng-*eager load* relasi `subdomainRequests`

**Files to Modify:**

- `resources/views/reports/pse_registration.blade.php`
- `resources/views/reports/recap.blade.php`
- `app/Http/Controllers/IssuanceController.php` (verifikasi eager load `subdomainRequests`)

---

## Task #83 — Perbaikan Priority Routing 404 Pada Pendaftaran Rute Ekstra User

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🔴 High Priority  
**Kategori:** Bug Fix / Routing  
**Estimasi:** Low (< 1 jam)

**Latar Belakang:**

Fungsionalitas form dari `http://127.0.0.1:8000/users/create` menghasilkan galat `404 Not Found` pada _local env_. Parameter routing metode `show()` dengan format `{user}` telah mencaplok *Request URI* dari URL statis tersebut berhubung inisialisasinya dideklarasikan terbalik dengan *resource except* pada peruntukan milik Administrator (Mutlak). 

**Ruang Lingkup Perubahan:**

- [x] **Re-order Rute:** Memindahkan konfigurasi rute Admin Mutlak (`except(['index', 'show', 'destroy'])`) posisinya dieksekusi di *atas eksklusif* rute Shared Read-Only.
- [x] Memastikan fungsionalitas formulir pendaftaran berhasil (_success intercept_) karena penampil ID tidak mencegat formulir *create*.
- [x] Pengecekan stabilitas rute akses admin (`web.php`).

**Files to Modify:**

- `routes/web.php` (*Change Route Parameter Order Mapping*)

---

## Task #84 — Optimasi Kolom Auth SSO & Strict Type Validation

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🔴 High Priority  
**Kategori:** Database Cleansing / Security  
**Estimasi:** Medium (1-2 jam)

**Latar Belakang:**

Karena sistem berevolusi dari *native auth* menuju murni berskema **Single Sign-On (SSO)**, elemen bawaan seperti _password_, _remember_token_, dan _email_verified_at_ secara logis kehilangan eksistensi fungsinya dan hanya menjadi *bloatware* skema tabel `users`. Di samping itu, validasi isian identitas (NIP, Telepon, Telepon Unit Kerja) dirasa kurang tangguh karena belum diproteksi wajib _numeric_ (angka). Sistem juga mewajibkan perubahan *field* `phone_number` menjadi `phone`.

**Ruang Lingkup Perubahan:**

- [x] **Migrations**: 
  - DROP kolom `email_verified_at`, `remember_token`, dan `password`.
  - RENAME kolom `phone_number` menjadi `phone`.
- [x] **Model**: 
  - Update `app/Models/User.php` dengan `$fillable` baru.
  - Override method `getAuthPassword()` (return empty string) demi stabilitas auth guard.
  - Implementasi `format_phone` via **PhoneHelper** (Accessor) & pembersihan atribut `$hidden`.
- [x] **Seeders**: Sinkronisasi `UserSeeder.php` (menghapus injeksi password & rename phone).
- [x] **Controllers & Validations**: 
  - Penerapan _strict validation_ `digits:18` (NIP) dan `digits_between` (Phone) pada `UserController`.
  - Pembersihan inisialisasi password pada logic `store`.
- [x] **Views (UI)**: Update input type menjadi `number` dan penyesuaian `name="phone"` pada form profil petugas.
- [x] **Refactoring**: Standardisasi seluruh viewer dokumen menggunakan komponen `current-file`.

**Files to Modify:**
- `database/migrations/*_update_users_table_sso.php`
- `app/Models/User.php`
- `database/seeders/UserSeeder.php`
- `app/Http/Controllers/UserController.php`
- `resources/views/user/edit.blade.php`
- `resources/views/user/create.blade.php`

---

## Task #85 — Standardisasi Document Viewer ke Komponen current-file

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🟡 Medium Priority  
**Kategori:** UI Consistency / Refactoring

**Latar Belakang:**

Ditemukan ketidakkonsistenan penggunaan komponen untuk menampilkan berkas yang sudah diunggah pada halaman sunting (*edit*). Sebagian menggunakan `x-ui.document-viewer` yang memakan banyak ruang, sementara tersedia komponen `x-form.current-file` yang lebih ringkas dan sesuai dengan standar desain *form* saat ini.

**Ruang Lingkup Perubahan:**

- [x] Mengganti seluruh penggunaan `x-ui.document-viewer` dengan `x-form.current-file` pada halaman edit/form.
- [x] Memastikan label dan styling tetap terjaga dan konsisten.
- [x] Memastikan standardisasi di seluruh formulir (`PSE`, `Subdomain`, `Hosting`, `User`).

**Files to Modify:**
- `resources/views/user/edit.blade.php`
- `resources/views/subdomain/edit.blade.php`
- `resources/views/hosting/edit.blade.php`
- `doc/TASKS.md`

---

## Task #86 — Standarisasi Alert Session UI

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🟡 Medium Priority  
**Kategori:** UI Consistency / Refactoring

**Deskripsi:**
Menyelaraskan tampilan pesan sukses/error (flash session) di seluruh aplikasi agar konsisten dengan gaya desain baru (rounded-2xl, shadow-sm, custom icons, dan inline markdown support).

**Ruang Lingkup Perubahan:**

- [x] **Components**: Buat komponen Blade baru (misal: \`x-ui.alert-session\`) untuk menghandle logika pengecekan session dan styling terpusat.
- [x] **Views**: Ganti blok \`@if (session('success'))\` manual di seluruh view dengan komponen baru tersebut.
- [x] **Logic**: Pastikan parsing bold \`**\` pada pesan error didukung secara global melalui komponen tersebut.

**Files to Modify:**
- \`resources/views/components/ui/alert-session.blade.php\` (Created)
- Seluruh file di \`resources/views/**/*\` yang menggunakan session alert.

---

## Task #87 — Pengetatan RBAC & Filter Akun Sensitif pada User Management

**Status:** ✅ Done (2026-04-10)  
**Prioritas:** 🔴 High Priority  
**Kategori:** Security / RBAC / Privacy

**Deskripsi:**
Memastikan manajemen pengguna mematuhi batasan hak akses yang ketat sesuai hirarki. Admin memiliki kendali penuh (termasuk hapus), sementara Verifikator dibatasi haknya dan dilarang melihat akun dengan level otoritas lebih tinggi (Admin & Eksekutif).

**Ruang Lingkup Perubahan:**

- [x] **Policy/Authorization**: Update `UserPolicy` agar hanya Admin yang diizinkan melakukan `delete`.
- [x] **Data Filtering (Index)**: Update `UserController@index` agar Verifikator tidak bisa melihat akun dengan otoritas lebih tinggi (Verifikator 1 dilarang melihat Verifikator 2, Admin, & Eksekutif).
- [x] **Data Filtering (Show)**: Pastikan Verifikator tidak bisa mengakses halaman `show` akun otoritas tinggi via URL langsung (403 Forbidden).
- [x] **UI Logic**: Sembunyikan tombol Edit/Delete di view `user/index.blade.php` dan `user/show.blade.php` untuk peran non-admin.

**Files to Modify:**
- `app/Http/Controllers/UserController.php`
- `app/Policies/UserPolicy.php`
- `resources/views/user/index.blade.php`
- `resources/views/user/show.blade.php`

---

## 88. Sinkronisasi Alur Verifikasi Single Flow (Bubble-Up & Lateral)

**Status:** ✅ Completed (2026-04-10)
**Prioritas:** High (Data Integrity)

Mengatasi masalah ketidaksinkronan status pada paket pengajuan Single Flow ketika Verifikator melakukan verifikasi melalui menu terpisah (Hosting atau Subdomain).

**Masalah:**
- Saat ini, jika Hosting/Subdomain disetujui melalui menu verifikasi masing-masing, Induk PSE dan rekan satu paket lainnya tidak ikut ter-update statusnya.
- Seharusnya pada mode Single Flow, PSE dan turunannya (Hosting/Subdomain) bergerak sebagai satu unit status (Atomic Package).

**Fitur Implementasi:**
- [x] Implementasi logika "Bubble-Up" secara eksplisit (non-trait) di `HostingVerificationController` & `SubdomainVerificationController` (Level 1).
- [x] Implementasi sinkronisasi "Paket Atomic" saat Reject di Verifikator 2 (Hosting & Subdomain).
- [x] Implementasi logic Redirect untuk Verificator 2: Jika "Approve" pada Single Flow via menu anak, arahkan ke menu PSE untuk input Nomor Registrasi.
- [x] Sinkronisasi `VerificationHistory` untuk seluruh entitas dalam satu paket agar audit trail tetap konsisten.
- [x] Tambahkan notifikasi/alert di halaman verifikasi anak (Hosting/Subdomain) jika item tersebut adalah bagian dari Single Flow.
