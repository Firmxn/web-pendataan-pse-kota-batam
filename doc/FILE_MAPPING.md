# File Mapping - Web Pendataan PSE Kota Batam

Dokumen ini mengelompokkan file-file berdasarkan fitur untuk memudahkan navigasi dan maintenance.

---

## 1. Authentication (SSO Custom)

### Backend
**Middleware:**
- `app/Http/Middleware/CheckSsoMiddleware.php` - Autentikasi utama via sistem SSO eksternal (header-based)
- `app/Http/Middleware/CheckSsoOptionalMiddleware.php` - Pelengkap untuk rute publik/guest

**Controllers:**
- Autentikasi ditangani di layer Middleware; Login dialihkan ke portal SSO dan Logout ditangani via session flush di `routes/web.php`.

**Models:**
- `app/Models/User.php` - Mapping data pengguna dari SSO ke database lokal (UUID based)

**Config:**
- `config/auth.php` - Konfigurasi Guard dan SSO Header mapping

### Routes
- `routes/web.php` - Definisi rute `/` (optional) dan `/dashboard` (required auth)
- `routes/auth.php` - **DIHAPUS** (Sistem tidak lagi menggunakan rute bawaan Laravel Breeze)

---

## 2. Profile Management

### Backend
**Controllers:**
- `app/Http/Controllers/ProfileController.php` - Update profile, OPD, password, delete account

**Requests:**
- `app/Http/Requests/ProfileUpdateRequest.php` - Validation update profile

**Models:**
- `app/Models/User.php` - User model
- `app/Models/Opd.php` - OPD model untuk dropdown

### Frontend
**Views:**
- `resources/views/profile/edit.blade.php` - Main profile page
- `resources/views/profile/partials/update-profile-information-form.blade.php` - Form update profile
- `resources/views/profile/partials/update-opd-information-form.blade.php` - Form update OPD
- `resources/views/profile/partials/update-password-form.blade.php` - Form change password
- `resources/views/profile/partials/delete-user-form.blade.php` - Form delete account

**Components:**
- `resources/views/components/text-input.blade.php` - Input text
- `resources/views/components/input-label.blade.php` - Label input
- `resources/views/components/input-error.blade.php` - Error message
- `resources/views/components/primary-button.blade.php` - Primary button
- `resources/views/components/danger-button.blade.php` - Danger button
- `resources/views/components/secondary-button.blade.php` - Secondary button

### Routes
- `routes/web.php` - Route `/profile` (GET, PATCH, DELETE)

---

## 3. PSE Management (CRUD)

### Backend
**Controllers:**
- `app/Http/Controllers/PseController.php` - CRUD PSE (index, create, store, show, edit, update, destroy, submit)

**Models:**
- `app/Models/Pse.php` - PSE model dengan relasi ke User, Opd, VerificationHistory

**Policies:**
- `app/Policies/PsePolicy.php` - Authorization rules (viewAny, view, create, update, delete)

**Migrations:**
- `database/migrations/xxxx_create_pses_table.php` - Tabel pses

**Seeders:**
- (Belum ada seeder untuk PSE)

### Frontend
**Views:**
- `resources/views/pse/index.blade.php` - List PSE dengan pagination
- `resources/views/pse/create.blade.php` - Form create PSE
- `resources/views/pse/edit.blade.php` - Form edit PSE
- `resources/views/pse/show.blade.php` - Detail PSE

**Components:**
- `resources/views/components/button.blade.php` - Button universal (link/submit)
- `resources/views/components/fieldset.blade.php` - Fieldset wrapper
- `resources/views/components/text-input.blade.php` - Input text
- `resources/views/components/textarea.blade.php` - Textarea
- `resources/views/components/select.blade.php` - Select dropdown
- `resources/views/components/input-error.blade.php` - Error message
- `resources/views/components/input-description.blade.php` - Description/helper text
- `resources/views/components/text-label.blade.php` - Label untuk display (bukan input)
- `resources/views/components/primary-button.blade.php` - Primary button

### Routes
- `routes/web.php` - Resource route `/pse` + custom route `/pse/{pse}/submit`

**Route List:**
```php
GET    /pse              - PseController@index
GET    /pse/create       - PseController@create
POST   /pse              - PseController@store
GET    /pse/{pse}        - PseController@show
GET    /pse/{pse}/edit   - PseController@edit
PATCH  /pse/{pse}        - PseController@update
DELETE /pse/{pse}        - PseController@destroy
PATCH  /pse/{pse}/submit - PseController@submit
```

---

## 4. Verifikasi PSE - Tingkat 1

### Backend
**Controllers:**
- `app/Http/Controllers/PseVerificationController.php` - List PSE pending_1, show detail, approve, reject

**Models:**
- `app/Models/Pse.php` - PSE model
- `app/Models/VerificationHistory.php` - Model untuk riwayat verifikasi (polymorphic)

**Policies:**
- `app/Policies/PsePolicy.php` - Authorization dengan method `verify()` dan `view()`

**Migrations:**
- `database/migrations/xxxx_create_verification_histories_table.php` - Tabel verification_histories

**Middleware:**
- `app/Http/Middleware/CheckRole.php` - Role-based authorization middleware

### Frontend
**Views:**
- `resources/views/pse-verification/index.blade.php` - List PSE pending verifikasi tingkat 1
- `resources/views/pse-verification/show.blade.php` - Detail PSE + form approve/reject

**Components:**
- `resources/views/components/card.blade.php` - Card wrapper
- `resources/views/components/button.blade.php` - Button
- `resources/views/components/fieldset.blade.php` - Fieldset
- `resources/views/components/textarea.blade.php` - Textarea untuk notes
- `resources/views/components/text-label.blade.php` - Label display
- `resources/views/components/input-error.blade.php` - Error message
- `resources/views/components/input-description.blade.php` - Description

### Routes
- `routes/web.php` - Route `/pse-verification` dengan middleware `role:verifikator_1`

**Route List:**
```php
GET   /pse-verification              - PseVerificationController@index
GET   /pse-verification/{pse}        - PseVerificationController@show
PATCH /pse-verification/{pse}/approve - PseVerificationController@approve
PATCH /pse-verification/{pse}/reject  - PseVerificationController@reject
```

---

## 5. Verifikasi PSE - Tingkat 2 (Final)

### Backend
**Controllers:**
- `app/Http/Controllers/PseVerification2Controller.php` - List PSE pending_2, show detail, approve final, reject

**Models:**
- `app/Models/Pse.php` - PSE model
- `app/Models/VerificationHistory.php` - Model untuk riwayat verifikasi

**Policies:**
- `app/Policies/PsePolicy.php` - Authorization dengan method `verifyFinal()` dan `view()`

**Middleware:**
- `app/Http/Middleware/CheckRole.php` - Role-based authorization middleware

### Frontend
**Views:**
- `resources/views/pse-verification2/index.blade.php` - List PSE pending verifikasi tingkat 2
- `resources/views/pse-verification2/show.blade.php` - Detail PSE + form approve final/reject

**Components:**
- `resources/views/components/card.blade.php` - Card wrapper
- `resources/views/components/button.blade.php` - Button
- `resources/views/components/fieldset.blade.php` - Fieldset
- `resources/views/components/text-input.blade.php` - Input untuk registration_number
- `resources/views/components/textarea.blade.php` - Textarea untuk notes
- `resources/views/components/text-label.blade.php` - Label display
- `resources/views/components/input-error.blade.php` - Error message
- `resources/views/components/input-description.blade.php` - Description

### Routes
- `routes/web.php` - Route `/pse-verification2` dengan middleware `role:verifikator_2`

**Route List:**
```php
GET   /pse-verification2              - PseVerification2Controller@index
GET   /pse-verification2/{pse}        - PseVerification2Controller@show
PATCH /pse-verification2/{pse}/approve - PseVerification2Controller@approve
PATCH /pse-verification2/{pse}/reject  - PseVerification2Controller@reject
```

---

## 6. Subdomain Management (CRUD)

### Backend
**Controllers:**
- `app/Http/Controllers/SubdomainRequestController.php` - CRUD Subdomain (index, create, store, show, edit, update, destroy, submit)

**Models:**
- `app/Models/SubdomainRequest.php` - SubdomainRequest model dengan relasi ke User, Pse, VerificationHistory

**Policies:**
- `app/Policies/SubdomainRequestPolicy.php` - Authorization rules (viewAny, view, create, update, delete, submit, verify, verifyFinal)

**Migrations:**
- `database/migrations/xxxx_create_subdomain_requests_table.php` - Tabel subdomain_requests

### Frontend
**Views:**
- `resources/views/subdomain/index.blade.php` - List subdomain dengan pagination
- `resources/views/subdomain/create.blade.php` - Form create subdomain
- `resources/views/subdomain/edit.blade.php` - Form edit subdomain
- `resources/views/subdomain/show.blade.php` - Detail subdomain

**Components:**
- `resources/views/components/card.blade.php` - Card wrapper
- `resources/views/components/button.blade.php` - Button universal
- `resources/views/components/fieldset.blade.php` - Fieldset wrapper
- `resources/views/components/text-input.blade.php` - Input text
- `resources/views/components/select.blade.php` - Select dropdown
- `resources/views/components/input-error.blade.php` - Error message
- `resources/views/components/input-description.blade.php` - Description
- `resources/views/components/status-badge.blade.php` - Status badge
- `resources/views/components/request-type-badge.blade.php` - Request type badge

### Routes
- `routes/web.php` - Resource route `/subdomain` + custom route `/subdomain/{subdomain}/submit`

**Route List:**
```php
GET    /subdomain              - SubdomainRequestController@index
GET    /subdomain/create       - SubdomainRequestController@create
POST   /subdomain              - SubdomainRequestController@store
GET    /subdomain/{subdomain}  - SubdomainRequestController@show
GET    /subdomain/{subdomain}/edit - SubdomainRequestController@edit
PATCH  /subdomain/{subdomain}  - SubdomainRequestController@update
DELETE /subdomain/{subdomain}  - SubdomainRequestController@destroy
PATCH  /subdomain/{subdomain}/submit - SubdomainRequestController@submit
```

---

## 7. Verifikasi Subdomain - Tingkat 1

### Backend
**Controllers:**
- `app/Http/Controllers/SubdomainVerificationController.php` - List subdomain pending_1, show detail, approve, reject

**Models:**
- `app/Models/SubdomainRequest.php` - SubdomainRequest model
- `app/Models/VerificationHistory.php` - Model untuk riwayat verifikasi (polymorphic)

**Policies:**
- `app/Policies/SubdomainRequestPolicy.php` - Authorization dengan method `verify()` dan `view()`

**Middleware:**
- `app/Http/Middleware/CheckRole.php` - Role-based authorization middleware

### Frontend
**Views:**
- `resources/views/subdomain-verification/index.blade.php` - List subdomain pending verifikasi tingkat 1
- `resources/views/subdomain-verification/show.blade.php` - Detail subdomain + form approve/reject

**Components:**
- `resources/views/components/card.blade.php` - Card wrapper
- `resources/views/components/button.blade.php` - Button
- `resources/views/components/fieldset.blade.php` - Fieldset
- `resources/views/components/textarea.blade.php` - Textarea untuk notes
- `resources/views/components/text-label.blade.php` - Label display
- `resources/views/components/status-badge.blade.php` - Status badge
- `resources/views/components/request-type-badge.blade.php` - Request type badge

### Routes
- `routes/web.php` - Route `/subdomain-verification` dengan middleware `role:verifikator_1`

**Route List:**
```php
GET   /subdomain-verification              - SubdomainVerificationController@index
GET   /subdomain-verification/{subdomain}  - SubdomainVerificationController@show
PATCH /subdomain-verification/{subdomain}/approve - SubdomainVerificationController@approve
PATCH /subdomain-verification/{subdomain}/reject  - SubdomainVerificationController@reject
```

---

## 8. Verifikasi Subdomain - Tingkat 2 (Final)

### Backend
**Controllers:**
- `app/Http/Controllers/SubdomainVerification2Controller.php` - List subdomain pending_2, show detail, approve final, reject

**Models:**
- `app/Models/SubdomainRequest.php` - SubdomainRequest model
- `app/Models/VerificationHistory.php` - Model untuk riwayat verifikasi

**Policies:**
- `app/Policies/SubdomainRequestPolicy.php` - Authorization dengan method `verifyFinal()` dan `view()`

**Middleware:**
- `app/Http/Middleware/CheckRole.php` - Role-based authorization middleware

### Frontend
**Views:**
- `resources/views/subdomain-verification2/index.blade.php` - List subdomain pending verifikasi tingkat 2
- `resources/views/subdomain-verification2/show.blade.php` - Detail subdomain + form approve final/reject

**Components:**
- `resources/views/components/card.blade.php` - Card wrapper
- `resources/views/components/button.blade.php` - Button
- `resources/views/components/fieldset.blade.php` - Fieldset
- `resources/views/components/textarea.blade.php` - Textarea untuk notes
- `resources/views/components/text-label.blade.php` - Label display
- `resources/views/components/status-badge.blade.php` - Status badge
- `resources/views/components/request-type-badge.blade.php` - Request type badge

### Routes
- `routes/web.php` - Route `/subdomain-verification2` dengan middleware `role:verifikator_2`

**Route List:**
```php
GET   /subdomain-verification2              - SubdomainVerification2Controller@index
GET   /subdomain-verification2/{subdomain}  - SubdomainVerification2Controller@show
PATCH /subdomain-verification2/{subdomain}/approve - SubdomainVerification2Controller@approve
PATCH /subdomain-verification2/{subdomain}/reject  - SubdomainVerification2Controller@reject
```

---

## 9. Hosting Management (CRUD)

### Backend
**Controllers:**
- `app/Http/Controllers/HostingRequestController.php` - CRUD Hosting

**Models:**
- `app/Models/HostingRequest.php` - HostingRequest model

**Migrations:**
- `database/migrations/xxxx_create_hosting_requests_table.php`

### Frontend
**Views:**
- `resources/views/hosting/index.blade.php`
- `resources/views/hosting/create.blade.php`
- `resources/views/hosting/edit.blade.php`
- `resources/views/hosting/show.blade.php`

---

## 10. Verifikasi Hosting - Tingkat 1

### Backend
**Controllers:**
- `app/Http/Controllers/HostingVerificationController.php`

### Frontend
**Views:**
- `resources/views/hosting-verification/index.blade.php`
- `resources/views/hosting-verification/show.blade.php`

---

## 11. Verifikasi Hosting - Tingkat 2 (Final)

### Backend
**Controllers:**
- `app/Http/Controllers/HostingVerification2Controller.php`

### Frontend
**Views:**
- `resources/views/hosting-verification2/index.blade.php`
- `resources/views/hosting-verification2/show.blade.php`

---

## 12. Verification History (General)

### Backend
**Controllers:**
- `app/Http/Controllers/VerificationHistoryController.php`

**Models:**
- `app/Models/VerificationHistory.php`

### Frontend
**Views:**
- `resources/views/verification-history/index.blade.php`

---

## 13. Dashboard

### Backend
**Controllers:**
- `app/Http/Controllers/DashboardController.php` - (Belum ada, masih default route)

**Models:**
- (Menggunakan model yang sudah ada untuk statistik)

### Frontend
**Views:**
- `resources/views/dashboard.blade.php` - Dashboard page (masih default)

### Routes
- `routes/web.php` - Route `/dashboard`

---

## 14. Document Management

### Backend
**Controllers:**
- `app/Http/Controllers/DocumentController.php` - Secure document download dengan authorization

**Models:**
- `app/Models/Document.php` - Document model (polymorphic)

**Policies:**
- `app/Policies/UserPolicy.php` - Authorization untuk User documents
- `app/Policies/PsePolicy.php` - Authorization untuk PSE documents
- `app/Policies/SubdomainRequestPolicy.php` - Authorization untuk Subdomain documents
- `app/Policies/HostingRequestPolicy.php` - Authorization untuk Hosting documents

### Routes
- `routes/web.php` - Route `/documents/{document}/download`

**Route List:**
```php
GET /documents/{document}/download - DocumentController@download
```

**Features:**
- ✅ UUID-based storage filename (security)
- ✅ Descriptive download filename (UX)
- ✅ Private storage (no direct URL access)
- ✅ Authorization check via policy
- ✅ Double MIME validation (mimes + mimetypes)

---

## 15. Navigation & Layout

### Frontend
**Layouts:**
- `resources/views/layouts/app.blade.php` - Main layout untuk authenticated pages
- `resources/views/layouts/guest.blade.php` - Layout untuk guest pages


**Components:**
- `resources/views/components/application-logo.blade.php` - Logo aplikasi

- `resources/views/components/dropdown.blade.php` - Dropdown menu
- `resources/views/components/dropdown-link.blade.php` - Dropdown link item

**Navigation Menu:**
- Petugas: PSE, Subdomain
- Verifikator 1: Verifikasi PSE, Verifikasi Subdomain
- Verifikator 2: Verifikasi PSE (Final), Verifikasi Subdomain (Final)

---

## 16. Shared Components

### Frontend Components
**Display Components (resources/views/components/display/):**
- `x-display.text-label` - Display label
- `x-display.status-badge` - Status Badge
- `x-display.request-type-badge` - Request Type Badge
- `x-display.auth-session-status` - Auth Status
- `x-display.empty-state` - Empty state display

**Icons (resources/views/components/icons/):**
- `x-icons.user` - Generic User Icon
- `x-icons.search` - Search Icon
- `x-icons.plus` - Plus/Add Icon
- `x-icons.check` - Check/Success Icon
- `x-icons.x` - Close/Danger Icon

---

## 17. User Management (Admin)

### Backend
**Controllers:**
- `app/Http/Controllers/UserController.php` - CRUD User (index, show, toggle active, restore)

**Models:**
- `app/Models/User.php` - User model dengan `SoftDeletes`

**Policies:**
- `app/Policies/UserPolicy.php` - Authorization untuk manajemen user (viewAny, view, update, delete, restore)

### Frontend
**Views:**
- `resources/views/user/index.blade.php` - Daftar pengguna dengan filter dan tabs (Semua, Aktif, Dihapus)
- `resources/views/user/show.blade.php` - Detail profil pengguna, unit kerja, dan dokumen pendukung

### Routes
**Route List:**
```php
GET    /users              - UserController@index
GET    /users/{user}       - UserController@show
PATCH  /users/{user}/toggle - UserController@toggleActive
PATCH  /users/{user}/restore- UserController@restore
```

---

### OPD Management (Admin)
```
Backend:
- app/Http/Controllers/OpdController.php
- app/Models/Opd.php (SoftDeletes)

Frontend:
- resources/views/opd/index.blade.php
- resources/views/opd/create.blade.php
- resources/views/opd/edit.blade.php

Routes:
- routes/web.php (Admin only)
```

---

## 28. Localization (i18n)

### Configuration
- `lang/en.json` - Kamus terjemahan utama (Bahasa Indonesia ke Bahasa Inggris)
- `lang/id/` - Folder terjemahan default Laravel (Indonesian)

### Features
- **Dwibahasa:** Seluruh UI menggunakan helper `__()` untuk mendukung Bahasa Indonesia dan Inggris.
- **Dinamis:** Data dinamis (status, bulan, tipe) dilokalisasi menggunakan kunci JSON yang sinkron.
- **Theme Support:** Integrasi dengan sistem tema (Light/Dark mode).

---

## 19. Helper Functions

### Backend Helpers
**Date Helpers:**
- `app/Helpers/DateHelper.php` - Format date functions
  - `format_date($date)` - Format: `21 November 2025, 14:30`
  - `format_date_short($date)` - Format: `21/11/2025`
  - `format_filename_timestamp($date)` - Format: `10022026_142300` (untuk filename)

**Status Helpers:**
- `app/Helpers/StatusHelper.php` - Status color & variant functions
  - `status_border_color($status)` - Border color class (border-warning, border-success, dll)
  - `status_bg_color($status)` - Background color class (bg-warning, bg-success, dll)
  - `status_text_color($status)` - Text color class (text-warning, text-success, dll)
  - `status_badge_variant($status)` - Badge variant (warning, success, dll)

**Autoload Configuration:**
- `composer.json` - Helper files registered di `autoload.files`

---

## 20. Code Formatting & Quality

### Configuration
**Laravel Pint:**
- `pint.json` - PSR-12 code style configuration dengan custom rules
  - `no_unused_imports: true` - Auto-remove unused imports
  - `ordered_imports: alpha` - Sort imports alphabetically

**VS Code Settings:**
- `.vscode/settings.json` (user level) - Editor configuration
  - Laravel Pint formatter untuk PHP
  - Blade Formatter untuk Blade
  - Highlight Matching Tag (biru cerah)
  - Indent guides & bracket pairs

---

## 21. Database

### Migrations
**Core Tables:**
- `2014_10_12_000000_create_users_table.php` - Users
- `2014_10_12_100000_create_password_reset_tokens_table.php` - Password reset
- `xxxx_create_roles_table.php` - Roles (petugas, verifikator_1, verifikator_2)
- `xxxx_create_opds_table.php` - OPDs (37 OPD Kota Batam)

**Feature Tables:**
- `xxxx_create_pses_table.php` - PSE registrations
- `xxxx_create_verification_histories_table.php` - Verification history (polymorphic)
- `xxxx_create_documents_table.php` - Documents (polymorphic)
- `xxxx_create_subdomain_requests_table.php` - Subdomain requests (belum digunakan)
- `xxxx_create_hosting_requests_table.php` - Hosting requests (belum digunakan)

### Seeders
- `database/seeders/DatabaseSeeder.php` - Main seeder
- `database/seeders/RoleSeeder.php` - Seed 3 roles
- `database/seeders/OpdSeeder.php` - Seed 37 OPDs Kota Batam
- `database/seeders/UserSeeder.php` - (Opsional) Seed test users

---

## 22. Configuration & Assets

### Configuration
- `config/app.php` - App configuration
- `config/database.php` - Database configuration
- `config/auth.php` - Authentication configuration
- `.env` - Environment variables

### Assets
**CSS:**
- `resources/css/app.css` - Main CSS (Tailwind v4 + DaisyUI)

**JavaScript:**
- `resources/js/app.js` - Main JS (ApexCharts & Core Utils)

**Build:**
- `vite.config.js` - Vite configuration
- `tailwind.config.js` - Tailwind configuration
- `package.json` - NPM dependencies

---

## 23. Policies & Authorization

### Policies
- `app/Policies/PsePolicy.php` - Authorization untuk PSE (viewAny, view, create, update, delete, submit, verify, verifyFinal)
- `app/Policies/SubdomainRequestPolicy.php` - Authorization untuk Subdomain (viewAny, view, create, update, delete, submit, verify, verifyFinal)
- `app/Policies/HostingRequestPolicy.php` - Authorization untuk Hosting (viewAny, view, create, update, delete, submit, verify, verifyFinal)
- `app/Policies/UserPolicy.php` - Authorization untuk User (view, update, delete) - untuk document download

**Policy Registration:**
- `app/Providers/AuthServiceProvider.php` - Register policies

---

## 24. Models & Relationships

### Models
**Core Models:**
- `app/Models/User.php` - User dengan relasi ke Role, Opd, Pse. Mendukung `SoftDeletes`.
- `app/Models/Role.php` - Role (petugas, verifikator_1, verifikator_2)
- `app/Models/Opd.php` - OPD (37 OPD Kota Batam)

**Feature Models:**
- `app/Models/Pse.php` - PSE dengan relasi ke User, Opd, VerificationHistory
- `app/Models/SubdomainRequest.php` - Subdomain request dengan relasi ke User, Pse, VerificationHistory
- `app/Models/VerificationHistory.php` - Verification history (polymorphic)
- `app/Models/Document.php` - Document (polymorphic)
- `app/Models/HostingRequest.php` - Hosting request (belum digunakan)

**Relationships:**
```
User
├── belongsTo: Role
├── belongsTo: Opd (nullable)
├── hasMany: Pse
├── hasMany: SubdomainRequest
├── hasMany: VerificationHistory
└── morphMany: Document

Pse
├── belongsTo: User
├── belongsTo: Opd (nullable)
├── hasMany: SubdomainRequest
├── morphMany: VerificationHistory
└── morphMany: Document

SubdomainRequest
├── belongsTo: User
├── belongsTo: Pse
├── morphMany: VerificationHistory
└── morphMany: Document

VerificationHistory
├── belongsTo: User (verifikator)
└── morphTo: verifiable (Pse, SubdomainRequest, HostingRequest)

Document
└── morphTo: documentable (User, Pse, SubdomainRequest, HostingRequest)
```

---

## 25. Routes Summary

### Web Routes (`routes/web.php`)
```php
// Public
GET  /                    - welcome page

// Auth (routes/auth.php) -- TIDAK DIGUNAKAN (saat ini pakai SSO)
// GET  /register            - RegisteredUserController@create
// POST /register            - RegisteredUserController@store
// GET  /login               - AuthenticatedSessionController@create
// POST /login               - AuthenticatedSessionController@store
// POST /logout              - AuthenticatedSessionController@destroy
// ... (forgot password, reset password, email verification)

// Authenticated
GET  /dashboard           - dashboard view

// Profile
GET    /profile           - ProfileController@edit
PATCH  /profile           - ProfileController@update
PATCH  /profile/opd       - ProfileController@updateOpd
DELETE /profile           - ProfileController@destroy

// Document Download
GET    /documents/{document}/download - DocumentController@download

// PSE (Resource + Custom)
GET    /pse               - PseController@index
GET    /pse/create        - PseController@create
POST   /pse               - PseController@store
GET    /pse/{pse}         - PseController@show
GET    /pse/{pse}/edit    - PseController@edit
PATCH  /pse/{pse}         - PseController@update
DELETE /pse/{pse}         - PseController@destroy
PATCH  /pse/{pse}/submit  - PseController@submit

// PSE Verification Level 1 (middleware: role:verifikator_1)
GET   /pse-verification              - PseVerificationController@index
GET   /pse-verification/{pse}        - PseVerificationController@show
PATCH /pse-verification/{pse}/approve - PseVerificationController@approve
PATCH /pse-verification/{pse}/reject  - PseVerificationController@reject

// PSE Verification Level 2 (middleware: role:verifikator_2)
GET   /pse-verification2              - PseVerification2Controller@index
GET   /pse-verification2/{pse}        - PseVerification2Controller@show
PATCH /pse-verification2/{pse}/approve - PseVerification2Controller@approve
PATCH /pse-verification2/{pse}/reject  - PseVerification2Controller@reject

// Subdomain (Resource + Custom)
GET    /subdomain               - SubdomainRequestController@index
GET    /subdomain/create        - SubdomainRequestController@create
POST   /subdomain               - SubdomainRequestController@store
GET    /subdomain/{subdomain}   - SubdomainRequestController@show
GET    /subdomain/{subdomain}/edit - SubdomainRequestController@edit
PATCH  /subdomain/{subdomain}   - SubdomainRequestController@update
DELETE /subdomain/{subdomain}   - SubdomainRequestController@destroy
PATCH  /subdomain/{subdomain}/submit - SubdomainRequestController@submit

// Subdomain Verification Level 1 (middleware: role:verifikator_1)
GET   /subdomain-verification              - SubdomainVerificationController@index
GET   /subdomain-verification/{subdomain}  - SubdomainVerificationController@show
PATCH /subdomain-verification/{subdomain}/approve - SubdomainVerificationController@approve
PATCH /subdomain-verification/{subdomain}/reject  - SubdomainVerificationController@reject

// Subdomain Verification Level 2 (middleware: role:verifikator_2)
GET   /subdomain-verification2              - SubdomainVerification2Controller@index
GET   /subdomain-verification2/{subdomain}  - SubdomainVerification2Controller@show
PATCH /subdomain-verification2/{subdomain}/approve - SubdomainVerification2Controller@approve
PATCH /subdomain-verification2/{subdomain}/reject  - SubdomainVerification2Controller@reject

// User Management (Admin)
GET    /users              - UserController@index
GET    /users/{user}       - UserController@show
PATCH  /users/{user}/toggle - UserController@toggleActive
PATCH  /users/{user}/restore- UserController@restore
```

---

## 26. Middleware & Core Infrastructure

### Middleware Stack (Kernel.php)
**Middleware Groups:**
- `web`: Session, Cookies, CSRF, `SetLocale`, `SubstituteBindings`.
- `api`: Throttle, `SubstituteBindings`.

**Middleware Aliases:**
- `check.sso` -> `CheckSsoMiddleware`
- `role` -> `CheckRoleMiddleware`
- `auth` -> `Authenticate` (custom redirect)

### Custom Middleware Definitions
- `app/Http/Middleware/CheckRoleMiddleware.php` - Role validation
- `app/Http/Middleware/CheckSsoMiddleware.php` - SSO Header authentication
- `app/Http/Middleware/CheckSsoOptionalMiddleware.php` - SSO Optional for guest
- `app/Http/Middleware/SetLocale.php` - Session-based localization
- `app/Http/Middleware/SecurityHeadersMiddleware.php` - Security headers (CSP, HSTS, etc)

---

## 27. Service Providers

### Providers
- `app/Providers/AppServiceProvider.php` - Global bootstrapping, Helpers loader, HTTPS forcing, Pagination setup
- `app/Providers/AuthServiceProvider.php` - Registrasi Policy untuk seluruh model
- `app/Providers/RouteServiceProvider.php` - Konfigurasi routing core
- `app/Providers/EventServiceProvider.php` - Event listeners registration

---

## Quick Reference: File per Fitur

### PSE CRUD
```
Backend:
- app/Http/Controllers/PseController.php
- app/Models/Pse.php
- app/Policies/PsePolicy.php
- database/migrations/xxxx_create_pses_table.php

Frontend:
- resources/views/pse/index.blade.php
- resources/views/pse/create.blade.php
- resources/views/pse/edit.blade.php
- resources/views/pse/show.blade.php

Routes:
- routes/web.php (resource + custom submit)
```

### PSE Verifikasi Tingkat 1
```
Backend:
- app/Http/Controllers/PseVerificationController.php
- app/Models/VerificationHistory.php
- app/Policies/PsePolicy.php (verify, view)
- app/Http/Middleware/CheckRole.php
- database/migrations/xxxx_create_verification_histories_table.php

Frontend:
- resources/views/pse-verification/index.blade.php
- resources/views/pse-verification/show.blade.php

Routes:
- routes/web.php (middleware: role:verifikator_1)
```

### PSE Verifikasi Tingkat 2
```
Backend:
- app/Http/Controllers/PseVerification2Controller.php
- app/Models/VerificationHistory.php
- app/Policies/PsePolicy.php (verifyFinal, view)
- app/Http/Middleware/CheckRole.php

Frontend:
- resources/views/pse-verification2/index.blade.php
- resources/views/pse-verification2/show.blade.php

Routes:
- routes/web.php (middleware: role:verifikator_2)
```

### Subdomain CRUD
```
Backend:
- app/Http/Controllers/SubdomainRequestController.php
- app/Models/SubdomainRequest.php
- app/Policies/SubdomainRequestPolicy.php
- database/migrations/xxxx_create_subdomain_requests_table.php

Frontend:
- resources/views/subdomain/index.blade.php
- resources/views/subdomain/create.blade.php
- resources/views/subdomain/edit.blade.php
- resources/views/subdomain/show.blade.php

Routes:
- routes/web.php (resource + custom submit)
```

### Subdomain Verifikasi Tingkat 1
```
Backend:
- app/Http/Controllers/SubdomainVerificationController.php
- app/Models/VerificationHistory.php
- app/Policies/SubdomainRequestPolicy.php (verify, view)
- app/Http/Middleware/CheckRole.php

Frontend:
- resources/views/subdomain-verification/index.blade.php
- resources/views/subdomain-verification/show.blade.php

Routes:
- routes/web.php (middleware: role:verifikator_1)
```

### Subdomain Verifikasi Tingkat 2
```
Backend:
- app/Http/Controllers/SubdomainVerification2Controller.php
- app/Models/VerificationHistory.php
- app/Policies/SubdomainRequestPolicy.php (verifyFinal, view)
- app/Http/Middleware/CheckRole.php

Frontend:
- resources/views/subdomain-verification2/index.blade.php
- resources/views/subdomain-verification2/show.blade.php

Routes:
- routes/web.php (middleware: role:verifikator_2)
```

### Hosting CRUD
```
Backend:
- app/Http/Controllers/HostingRequestController.php
- app/Models/HostingRequest.php
- database/migrations/xxxx_create_hosting_requests_table.php

Frontend:
- resources/views/hosting/index.blade.php
- resources/views/hosting/create.blade.php
- resources/views/hosting/edit.blade.php
- resources/views/hosting/show.blade.php
```

### Hosting Verifikasi
```
Backend:
- app/Http/Controllers/HostingVerificationController.php (Level 1)
- app/Http/Controllers/HostingVerification2Controller.php (Level 2)

Frontend:
- resources/views/hosting-verification/index.blade.php
- resources/views/hosting-verification/show.blade.php
- resources/views/hosting-verification2/index.blade.php
- resources/views/hosting-verification2/show.blade.php
```

### Verification History
```
Backend:
- app/Http/Controllers/VerificationHistoryController.php
- app/Models/VerificationHistory.php

Frontend:
- resources/views/verification-history/index.blade.php
```

### Issuance (Penerbitan)
```
Backend:
- app/Http/Controllers/IssuanceController.php

Frontend:
- resources/views/issuance/index.blade.php

PDF Templates:
- resources/views/reports/pse_registration.blade.php
- resources/views/reports/subdomain_approval.blade.php
- resources/views/reports/hosting_approval.blade.php

Routes:
- routes/web.php (middleware: role:verifikator_1,verifikator_2,admin,eksekutif)
```

### Theme System
```
Frontend:
- resources/views/layouts/partials/theme-init.blade.php
- resources/css/app.css (theme configuration)

JavaScript:
- Theme toggle script in layouts/app.blade.php
- LocalStorage persistence
```

### User Management
```
Backend:
- app/Http/Controllers/UserController.php
- app/Models/User.php (SoftDeletes, UUID)
- app/Policies/UserPolicy.php

Frontend:
- resources/views/user/index.blade.php
- resources/views/user/show.blade.php
- resources/views/user/create.blade.php
- resources/views/user/edit.blade.php

Routes:
- routes/web.php (Admin has full access, others read-only)
```

### Localization (i18n)
```
Dictionary:
- lang/en.json
- lang/id/

Logic:
- Laravel __() Helper in Views
- Dynamic switch via session
```

---

**Last Updated:** 2026-04-10
