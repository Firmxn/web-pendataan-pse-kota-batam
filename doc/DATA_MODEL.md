# Model Data Sistem - Web Pendataan PSE Kota Batam

Dokumen ini mendefinisikan skema database fisik dan relasi Eloquent untuk proyek "Web Pendataan PSE Kota Batam". Model ini didasarkan pada Skema Relasional (Gambar 3.2.6) dan ER Diagram (Gambar 3.2.5) dari proposal proyek.

## Entitas Utama (Aktor & Organisasi)

### `users`

Menyimpan data akun untuk semua peran yang dapat login, baik Petugas OPD maupun Verifikator Diskominfo.

| Field             | Tipe Data | Length | Constraint                       | Keterangan                              |
| ----------------- | --------- | ------ | -------------------------------- | --------------------------------------- |
| `id`              | Integer   | -      | PK, Auto Increment               | ID unik user                            |
| `uuid`            | Char      | 36     | UNIQUE, NOT NULL                | UUID untuk public identifier            |
| `opd_id`          | Integer   | -      | FK, Nullable, ON DELETE SET NULL | Relasi ke tabel OPD (untuk Petugas OPD) |
| `role_id`         | Integer   | -      | FK, ON DELETE RESTRICT           | Relasi ke tabel roles                   |
| `name`            | Varchar   | 150    | NOT NULL                         | Nama lengkap user                       |
| `email`           | Varchar   | 150    | Unique, NOT NULL                 | Email user (untuk login)                |
| `phone`           | Varchar   | 30     | Nullable                         | Telepon pribadi user                    |
| `nip`             | Varchar   | 50     | Nullable                         | Nomor Induk Pegawai                     |
| `position`        | Varchar   | 100    | Nullable                         | Jabatan                                 |
| `status`          | Varchar   | 30     | NOT NULL, DEFAULT 'active'       | Status user                             |
| `work_unit`       | Varchar   | 100    | Nullable                         | Unit kerja                              |
| `work_unit_phone` | Varchar   | 30     | Nullable                         | Telepon unit kerja                      |
| `created_at`      | Timestamp | -      | -                                | Waktu pembuatan record                  |
| `updated_at`      | Timestamp | -      | -                                | Waktu update terakhir                   |
| `deleted_at`      | Timestamp | -      | -                                | Waktu penghapusan (Soft Delete)         |

#### Nilai yang Diperbolehkan (status):

- `active` - User aktif (default)
- `inactive` - User tidak aktif
- `suspended` - User ditangguhkan

#### Relasi Eloquent:

- `belongsTo(Opd::class)` - User milik satu OPD
- `belongsTo(Role::class)` - User memiliki satu role
- `hasMany(Pse::class)` - User dapat mendaftarkan banyak PSE
- `hasMany(SubdomainRequest::class)` - User dapat mengajukan banyak permintaan subdomain
- `hasMany(HostingRequest::class)` - User dapat mengajukan banyak permintaan hosting
- `morphOne(Document::class, 'documentable')` - User memiliki satu dokumen (Surat Tugas)
- `hasMany(VerificationHistory::class)` - User (Verifikator) memiliki banyak riwayat verifikasi

---

### `roles`

Menyimpan peran/hak akses dalam sistem.

| Field        | Tipe Data | Length | Constraint         | Keterangan             |
| ------------ | --------- | ------ | ------------------ | ---------------------- |
| `id`         | Integer   | -      | PK, Auto Increment | ID unik role           |
| `role_name`  | Varchar   | 80     | NOT NULL           | Nama role              |
| `created_at` | Timestamp | -      | -                  | Waktu pembuatan record |
| `updated_at` | Timestamp | -      | -                  | Waktu update terakhir  |

#### Nilai yang Diperbolehkan (role_name):

- `petugas` - Petugas OPD
- `verifikator_1` - Verifikator Tingkat 1
- `verifikator_2` - Verifikator Tingkat 2
- `eksekutif` - Eksekutif (Pimpinan / Stakeholder)
- `admin` - Administrator (IT Admin Diskominfo)

#### Relasi Eloquent:

- `hasMany(User::class)` - Role dimiliki oleh banyak user

---

### `opds`

Menyimpan daftar Organisasi Perangkat Daerah (OPD).

| Field        | Tipe Data | Length | Constraint         | Keterangan                      |
| ------------ | --------- | ------ | ------------------ | ------------------------------- |
| `id`         | Integer   | -      | PK, Auto Increment | ID unik OPD                     |
| `name`       | Varchar   | 150    | Unique, Nullable   | Nama OPD                        |
| `type`       | Varchar   | 50     | Nullable           | Tipe OPD                        |
| `email`      | Varchar   | 150    | Unique, Nullable   | Email resmi OPD                 |
| `created_at` | Timestamp | -      | -                  | Waktu pembuatan record          |
| `updated_at` | Timestamp | -      | -                  | Waktu update terakhir           |
| `deleted_at` | Timestamp | -      | -                  | Waktu penghapusan (Soft Delete) |

#### Relasi Eloquent:

- `hasOne(User::class)` - OPD memiliki satu petugas (relasi 1-ke-1)

---

## Entitas Bisnis (PSE & Layanan)

### `pses`

Tabel inti yang menyimpan data Penyelenggara Sistem Elektronik (PSE) yang didaftarkan.

| Field                 | Tipe Data | Length | Constraint                      | Keterangan                                            |
| --------------------- | --------- | ------ | ------------------------------- | ----------------------------------------------------- |
| `id`                  | Integer   | -      | PK, Auto Increment              | ID unik PSE                                           |
| `uuid`                | Char      | 36     | UNIQUE, NOT NULL                | UUID untuk public identifier                          |
| `user_id`             | Integer   | -      | FK, ON DELETE CASCADE           | Relasi ke tabel users (Petugas OPD yang mendaftarkan) |
| `opd_id`              | Integer   | -      | FK, Nullable, ON DELETE CASCADE | Relasi ke tabel OPDs                                  |
| `system_name`         | Varchar   | 150    | Unique, NOT NULL                | Nama Sistem Elektronik                                |
| `sector`              | Varchar   | 100    | NOT NULL                        | Sektor sistem                                         |
| `pic_name`            | Varchar   | 150    | NOT NULL                        | Nama PIC (Penanggung Jawab)                           |
| `pic_phone`           | Varchar   | 30     | NOT NULL                        | Nomor telepon PIC                                     |
| `pic_email`           | Varchar   | 150    | NOT NULL                        | Email PIC                                             |
| `description`         | Text      | -      | Nullable                        | Deskripsi sistem                                      |
| `risk_category`       | Varchar   | 80     | NOT NULL                        | Kategori risiko                                       |
| `data_classification` | Varchar   | 80     | NOT NULL                        | Klasifikasi data                                      |
| `private_data_info`   | Text      | -      | Nullable                        | Informasi data pribadi                                |
| `storage_location`    | Text      | -      | NOT NULL                        | Lokasi penyimpanan data                               |
| `status`              | Varchar   | 30     | NOT NULL, DEFAULT 'draft'       | Status pendaftaran PSE                                |
| `registration_number` | Varchar   | 100    | Nullable                        | Nomor registrasi                                      |
| `created_at`          | Timestamp | -      | -                               | Waktu pembuatan record                                |
| `updated_at`          | Timestamp | -      | -                               | Waktu update terakhir                                 |

#### Nilai yang Diperbolehkan (status):

- `draft` - Draft/Belum diajukan
- `pending_1` - Menunggu verifikasi tingkat 1
- `pending_2` - Menunggu verifikasi tingkat 2
- `approved` - Disetujui
- `rejected` - Ditolak

#### Nilai yang Diperbolehkan (risk_category):

- `rendah` - Risiko rendah
- `sedang` - Risiko sedang
- `tinggi` - Risiko tinggi

#### Nilai yang Diperbolehkan (data_classification):

- `publik` - Data dapat diakses publik
- `internal` - Data hanya untuk internal
- `rahasia` - Data bersifat rahasia
- `sangat rahasia` - Data bersifat sangat rahasia

#### Relasi Eloquent:

- `belongsTo(User::class)` - PSE didaftarkan oleh satu user
- `belongsTo(Opd::class)` - PSE milik satu OPD
- `hasMany(SubdomainRequest::class)` - PSE dapat memiliki banyak permintaan subdomain
- `hasMany(HostingRequest::class)` - PSE dapat memiliki banyak permintaan hosting
- `morphMany(VerificationHistory::class, 'verifiable')` - PSE memiliki banyak riwayat verifikasi

---

### `subdomain_requests`

Mencatat semua pengajuan layanan terkait subdomain.

| Field            | Tipe Data | Length | Constraint                | Keterangan                                          |
| ---------------- | --------- | ------ | ------------------------- | --------------------------------------------------- |
| `id`             | Integer   | -      | PK, Auto Increment        | ID unik permintaan subdomain                        |
| `uuid`           | Char      | 36     | UNIQUE, NOT NULL          | UUID untuk public identifier                        |
| `pse_id`         | Integer   | -      | FK, ON DELETE CASCADE     | Relasi ke tabel pses (PSE induk)                    |
| `user_id`        | Integer   | -      | FK, ON DELETE CASCADE     | Relasi ke tabel users (Petugas OPD yang mengajukan) |
| `request_type`   | Varchar   | 30     | NOT NULL                  | Tipe permintaan subdomain                           |
| `subdomain_name` | Varchar   | 100    | NOT NULL                  | Nama subdomain yang diajukan                        |
| `is_primary`     | Boolean   | -      | NOT NULL, DEFAULT false   | Penanda subdomain utama untuk PSE                   |
| `status`         | Varchar   | 30     | NOT NULL, DEFAULT 'draft' | Status permintaan                                   |
| `created_at`     | Timestamp | -      | -                         | Waktu pembuatan record                              |
| `updated_at`     | Timestamp | -      | -                         | Waktu update terakhir                               |

#### Nilai yang Diperbolehkan (request_type):

- `baru` - Permintaan subdomain baru
- `perpanjangan` - Perpanjangan subdomain
- `ubah` - Perubahan subdomain
- `hapus` - Penghapusan subdomain

#### Nilai yang Diperbolehkan (status):

- `draft` - Draft/Belum diajukan
- `pending_1` - Menunggu verifikasi tingkat 1
- `pending_2` - Menunggu verifikasi tingkat 2
- `approved` - Disetujui
- `rejected` - Ditolak

#### Relasi Eloquent:

- `belongsTo(Pse::class)` - Permintaan milik satu PSE
- `belongsTo(User::class)` - Permintaan diajukan oleh satu user
- `morphMany(VerificationHistory::class, 'verifiable')` - Permintaan memiliki banyak riwayat verifikasi
- `morphOne(Document::class, 'documentable')` - Permintaan memiliki satu dokumen (Surat Permohonan)

---

### `hosting_requests`

Mencatat semua pengajuan layanan terkait hosting.

| Field                | Tipe Data | Length | Constraint                | Keterangan                                          |
| -------------------- | --------- | ------ | ------------------------- | --------------------------------------------------- |
| `id`                 | Integer   | -      | PK, Auto Increment        | ID unik permintaan hosting                          |
| `uuid`               | Char      | 36     | UNIQUE, NOT NULL          | UUID untuk public identifier                        |
| `pse_id`             | Integer   | -      | FK                        | Relasi ke tabel pses (PSE induk)                    |
| `user_id`            | Integer   | -      | FK                        | Relasi ke tabel users (Petugas OPD yang mengajukan) |
| `request_type`       | Varchar   | 30     | NOT NULL                  | Tipe permintaan hosting                             |
| `hosting_type`       | Varchar   | 30     | NOT NULL                  | Jenis hosting yang diminta                          |
| `cpu_cores`          | Integer   | -      | UNSIGNED, NOT NULL        | Jumlah core CPU yang diminta                        |
| `ram_capacity`       | Integer   | -      | UNSIGNED, NOT NULL        | Kapasitas RAM dalam GB                              |
| `storage_capacity`   | Integer   | -      | UNSIGNED, NOT NULL        | Kapasitas storage dalam GB                          |
| `bandwidth_capacity` | Integer   | -      | UNSIGNED, NOT NULL        | Kapasitas bandwidth dalam GB/bulan                  |
| `notes`              | Text      | -      | Nullable                  | Catatan tambahan dari petugas                       |
| `status`             | Varchar   | 30     | NOT NULL, DEFAULT 'draft' | Status permintaan                                   |
| `created_at`         | Timestamp | -      | -                         | Waktu pembuatan record                              |
| `updated_at`         | Timestamp | -      | -                         | Waktu update terakhir                               |

#### Nilai yang Diperbolehkan (request_type):

- `baru` - Permintaan hosting baru
- `perpanjangan` - Perpanjangan hosting
- `ubah` - Perubahan spesifikasi hosting
- `hapus` - Penghapusan hosting

#### Nilai yang Diperbolehkan (hosting_type):

- `shared` - Shared hosting
- `vps` - Virtual Private Server
- `dedicated` - Dedicated server
- `cloud` - Cloud hosting

#### Nilai yang Diperbolehkan (cpu_cores):

- `1`, `2`, `4`, `8`, `16`, `32` (dalam unit Core)

#### Nilai yang Diperbolehkan (ram_capacity):

- `1`, `2`, `4`, `8`, `16`, `32`, `64` (dalam unit GB)

#### Nilai yang Diperbolehkan (storage_capacity):

- `10`, `20`, `50`, `100`, `200`, `500`, `1000` (dalam unit GB)

#### Nilai yang Diperbolehkan (bandwidth_capacity):

- `100`, `500`, `1000`, `5000` (dalam unit GB/bulan)

#### Nilai yang Diperbolehkan (status):

- `draft` - Draft/Belum diajukan
- `pending_1` - Menunggu verifikasi tingkat 1
- `pending_2` - Menunggu verifikasi tingkat 2
- `approved` - Disetujui
- `rejected` - Ditolak

#### Relasi Eloquent:

- `belongsTo(Pse::class)` - Permintaan milik satu PSE
- `belongsTo(User::class)` - Permintaan diajukan oleh satu user
- `morphMany(VerificationHistory::class, 'verifiable')` - Permintaan memiliki banyak riwayat verifikasi
- `morphOne(Document::class, 'documentable')` - Permintaan memiliki satu dokumen (Surat Permohonan)

---

## Entitas Polimorfik (Helper)

### `documents`

Tabel polimorfik untuk menyimpan referensi semua file yang diunggah (Surat Tugas, Surat Permohonan, dll).

| Field               | Tipe Data | Length | Constraint         | Keterangan                              |
| ------------------- | --------- | ------ | ------------------ | --------------------------------------- |
| `id`                | Integer   | -      | PK, Auto Increment | ID unik dokumen                         |
| `uuid`              | Char      | 36     | UNIQUE, NOT NULL   | UUID untuk public identifier            |
| `documentable_id`   | Integer   | -      | NOT NULL           | ID dari entitas terkait (polimorfik)    |
| `documentable_type` | Varchar   | 255    | NOT NULL           | Tipe model entitas terkait (polimorfik) |
| `file_path`         | Varchar   | 255    | UNIQUE, NOT NULL   | Path penyimpanan file di server         |
| `original_name`     | Varchar   | 255    | NOT NULL           | Nama file asli dari user                |
| `created_at`        | Timestamp | -      | -                  | Waktu pembuatan record                  |
| `updated_at`        | Timestamp | -      | -                  | Waktu update terakhir                   |

#### Contoh Nilai (documentable_type):

- `App\Models\User` - Dokumen milik User (Surat Tugas)
- `App\Models\SubdomainRequest` - Dokumen milik Subdomain Request (Surat Permohonan)
- `App\Models\HostingRequest` - Dokumen milik Hosting Request (Surat Permohonan)

#### Relasi Eloquent:

- `morphTo()` - Relasi polimorfik ke entitas pemilik dokumen (`documentable`)

---

### `verification_histories`

Tabel polimorfik untuk mencatat semua jejak audit (log) dari proses verifikasi.

| Field             | Tipe Data | Length | Constraint            | Keterangan                                              |
| ----------------- | --------- | ------ | --------------------- | ------------------------------------------------------- |
| `id`              | Integer   | -      | PK, Auto Increment    | ID unik riwayat verifikasi                              |
| `user_id`         | Integer   | -      | FK, ON DELETE CASCADE | Relasi ke tabel users (Verifikator yang melakukan aksi) |
| `verifiable_id`   | Integer   | -      | NOT NULL              | ID dari entitas yang diverifikasi (polimorfik)          |
| `verifiable_type` | Varchar   | 255    | NOT NULL              | Tipe model entitas yang diverifikasi (polimorfik)       |
| `status`          | Varchar   | 30     | NOT NULL              | Status yang ditetapkan oleh verifikator                 |
| `notes`           | Text      | -      | Nullable              | Catatan/alasan dari verifikator                         |
| `created_at`      | Timestamp | -      | -                     | Waktu pembuatan record                                  |
| `updated_at`      | Timestamp | -      | -                     | Waktu update terakhir                                   |

#### Contoh Nilai (verifiable_type):

- `App\Models\Pse` - Verifikasi untuk PSE
- `App\Models\SubdomainRequest` - Verifikasi untuk Subdomain Request
- `App\Models\HostingRequest` - Verifikasi untuk Hosting Request

#### Nilai yang Diperbolehkan (status):

- `pending_1` - Diteruskan ke verifikator tingkat 1
- `pending_2` - Diteruskan ke verifikator tingkat 2
- `approved` - Disetujui
- `rejected` - Ditolak
- `revision` - Perlu revisi

#### Relasi Eloquent:

- `morphTo()` - Relasi polimorfik ke entitas yang diverifikasi (`verifiable`)
- `belongsTo(User::class)` - Riwayat milik satu user (Verifikator)

---

## Aturan Validasi Input (Server-Side)

Dokumen ini mencatat aturan validasi server-side yang diterapkan di controller dan form request, melengkapi constraint database di atas.

### `pses` — PseController

| Field                 | Validasi                                                             |
| --------------------- | -------------------------------------------------------------------- |
| `system_name`         | `required\|string\|max:150\|unique\|regex:^[\p{L}\p{N}\s\-.,\/()]+$` |
| `sector`              | `required\|string\|in:administrasi,pendidikan,kesehatan,sosial,infrastruktur,perhubungan,pangan,pariwisata,perdagangan,lingkungan,lainnya` |
| `pic_name`            | `required\|string\|max:150\|regex:^[\p{L}\p{N}\s\-.,\/()]+$`         |
| `pic_phone`           | `required\|string\|max:20\|regex:^62[0-9]{9,15}$` (Dinormalisasi ke format 62xxx sebelum disimpan) |
| `pic_email`           | `required\|email\|max:150`                                           |
| `subdomains`          | `required\|array\|min:1` (List of subdomain names)                   |
| `description`         | `nullable\|string\|max:3000\|regex:^[\p{L}\p{N}\s\-.,\/()\n\r:]+$`   |
| `risk_category`       | `required\|in:rendah,sedang,tinggi`                                  |
| `data_classification` | `required\|in:publik,internal,rahasia,sangat rahasia`                |
| `private_data_info`   | `nullable\|string\|max:2000\|regex:^[\p{L}\p{N}\s\-.,\/()\n\r:]+$`   |
| `storage_location`    | `required\|in:aplikasi,colocation,eksternal`                         |

### `hosting_requests` — HostingRequestController

| Field                | Validasi                                                          |
| -------------------- | ----------------------------------------------------------------- |
| `request_type`       | `required\|in:baru,ubah,perpanjangan,hapus`                       |
| `hosting_type`       | `required\|in:shared,vps,dedicated,cloud`                         |
| `cpu_cores`          | `required\|integer\|in:1,2,4,8,16,32`                             |
| `ram_capacity`       | `required\|integer\|in:1,2,4,8,16,32,64`                          |
| `storage_capacity`   | `required\|integer\|in:10,20,50,100,200,500,1000`                 |
| `bandwidth_capacity` | `required\|integer\|in:100,500,1000,5000`                         |
| `notes`              | `nullable\|string\|max:500\|regex:^[\p{L}\p{N}\s\-.,\/()\n\r:]+$` |

### `users` — ProfileUpdateRequest

| Field               | Validasi                                                  |
| ------------------- | --------------------------------------------------------- |
| `name`              | `required\|string\|max:150\|regex:^[\p{L}\p{N}\s\-.]+$`   |
| `email`             | `required\|email\|max:255\|unique`                        |
| `phone`             | `required\|string\|max:20\|regex:^62[0-9]{9,15}$` (Dinormalisasi ke format 62xxx sebelum disimpan) |
| `nip`               | `required\|digits:18` (Sesuai panjang standar NIP Indonesia) |
| `position`          | `required\|string\|max:255`                               |
| `status`            | `nullable\|string\|max:30\|regex:^[\p{L}\p{N}\s\-.]+$`    |
| `work_unit`         | `required\|string\|max:255`                               |
| `work_unit_phone`   | `required\|string\|max:20\|regex:^62[0-9]{9,15}$` (Dinormalisasi ke format 62xxx sebelum disimpan) |
| `assignment_letter` | `required\|file\|mimes:pdf\|max:2048` (Wajib saat registrasi, opsional saat update) |

### `verification_histories` — Semua Verification Controllers

| Field             | Validasi                                                          |
| ----------------- | ----------------------------------------------------------------- |
| `notes` (approve) | `nullable\|string\|max:500\|regex:^[\p{L}\p{N}\s\-.,\/()\n\r:]+$` |
| `notes` (reject)  | `required\|string\|max:500\|regex:^[\p{L}\p{N}\s\-.,\/()\n\r:]+$` |

### `pses` — IssuanceController

| Field                 | Validasi                                                          |
| --------------------- | ----------------------------------------------------------------- |
| `registration_number` | `required\|string\|max:100\|unique\|regex:^[\p{L}\p{N}\s\-.\/]+$` |
