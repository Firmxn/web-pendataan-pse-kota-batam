# Sistem Pendataan & Verifikasi PSE (Penyelenggara Sistem Elektronik)

Aplikasi web pendataan terpadu berbasis **Laravel** untuk mengelola, mendaftarkan, dan memverifikasi pengajuan Penyelenggara Sistem Elektronik (PSE), Subdomain, dan Hosting Lingkup Publik. Sistem ini dilengkapi dengan alur verifikasi dua tingkat (berjenjang) yang ketat dan antarmuka pengguna dwibahasa (Bilingual).

## Fitur Utama

- **Role-Based Access Control (RBAC)**: Terdapat 5 level hak akses yang mengontrol kewenangan pengguna secara aman:
    - **Petugas**: Menginput dan mengajukan data sistem/aplikasi, subdomain, maupun hosting melalui satu pintu pendaftaran (_Single Flow_).
    - **Verifikator 1**: Melakukan verifikasi kelengkapan dan keabsahan data tingkat awal.
    - **Verifikator 2 (Final)**: Mengambil keputusan final (Approve/Reject) dan menerbitkan nomor pendataan.
    - **Eksekutif**: Memiliki akses baca rekapitulasi data untuk kebutuhan monitoring (Viewer-only).
    - **Admin**: Pemegang otoritas tertinggi untuk manajemen OPD, pengelolaan akun petugas (registrasi, pembaruan, dan penonaktifan khusus akun petugas via UI), dan pemeliharaan sistem.
- **Sistem _Draft_ (Simpan Draf)**: Pengajuan tidak harus langsung dikirim (`Submit`); Petugas dapat menyimpan pengajuan dalam status _Draft_ saat dokumen (seperti Surat Permohonan) atau ketersediaan referensi data instansi belum lengkap.
- **Workflow Verifikasi Berjenjang**: Setiap pengajuan (PSE, Subdomain, Hosting) harus melewati proses _Pending 1_ dan _Pending 2_ sebelum dinyatakan disetujui, mencakup rekam jejak (_Verification History_) dengan catatan penolakan/persetujuan yang mendetail.
- **Dukungan Multibahasa (Bilingual)**: Antarmuka aplikasi mendukung peralihan bahasa (Indonesia dan Inggris) secara mulus memanfaatkan Laravel Translation Helper `__()` dan berkas kamus pusat (`lang/en.json`).
- **Laporan & Ekspor Berkas**: Pembuatan rekapan laporan data verifikasi dalam bentuk cetak dokumen berformat PDF.
- **Dokumen Keamanan (Surat Permohonan)**: Sistem memfasilitasi unggahan dokumen formal/surat kuasa secara aman untuk ditinjau tanpa perlu mengunduhnya langsung (In-App Document Viewer).
- **Soft Deletes**: Data krusial seperti Pengguna dilindungi secara aman melalui penghapusan lunak (_Soft Deletion_).

## Tech Stack

Sistem dibangun menggunakan susunan teknologi modern:

- **Framework Utama**: Laravel (PHP)
- **Database**: Relasional (MySQL/PostgreSQL) menggunakan implementasi Eloquent ORM.
- **Frontend / Styling**:
    - Blade Components (Reusable UI)
    - Tailwind CSS v4
    - DaisyUI (Komponen siap guna)
- **Build Tool**: Vite (untuk _hot-module replacement_ dan _bundling_)

## Panduan Instalasi (Development)

Pastikan server Anda memenuhi persyaratan ekosistem Laravel (PHP 8.1+, Node.js 20+, Composer, dll).

1. **Kloning atau Unduh Repositori**

    ```bash
    git clone <repo-url>
    cd pse
    ```

2. **Instalasi Dependencies Backend**

    ```bash
    composer install
    ```

3. **Instalasi Dependencies Frontend**

    ```bash
    npm install
    ```

4. **Konfigurasi Lingkungan Lingkungan (Environment)**
   Salin `.env.example` ke `.env` kemudian sesuaikan konfigurasi _Database_ Anda.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Migrasi dan Database Seeding**
   _Repository_ ini memiliki sistem _Seeder_ untuk membuat peran-peran dasar secara otomatis.

    ```bash
    php artisan migrate --seed
    ```

6. **Tautan Penyimpanan (_Storage Link_)**
   Pastikan folder penyimpanan berkas unggahan publik telah tertaut.

    ```bash
    php artisan storage:link
    ```

7. **Jalankan Aplikasi Server**
   Anda membutuhkan 2 buah terminal (satu untuk frontend (Vite), satu untuk backend Laravel).

    ```bash
    # Terminal 1 (Kompilasi Aset)
    npm run dev

    # Terminal 2 (Local Server)
    php artisan serve
    ```

## Kredensial Default (Development & SSO Simulation)

Setelah Anda menjalankan _seeder_ (`php artisan migrate --seed`), gunakan akun berikut. Karena sistem menggunakan **SSO Custom**, login di lingkungan _development_ disimulasikan dengan mengirimkan header `X-SSO-Exclusive` bermuatan **Email** berikut:

| Peran                     | Email (SSO Header Value)   | UUID (Reference)                       |
| :------------------------ | :------------------------- | :------------------------------------- |
| **Admin**                 | `admin@example.go.id`      | `550e8400-e29b-41d4-a716-446655440005` |
| **Eksekutif**             | `eksekutif@example.go.id`  | `550e8400-e29b-41d4-a716-446655440004` |
| **Verifikator Tingkat 1** | `verifikator1@example.go.id` | `550e8400-e29b-41d4-a716-446655440001` |
| **Verifikator Tingkat 2** | `verifikator2@example.go.id` | `550e8400-e29b-41d4-a716-446655440002` |
| **Petugas (Diskominfo)**  | `petugas@example.go.id`    | `550e8400-e29b-41d4-a716-446655440003` |

> [!TIP]
> Anda dapat menggunakan ekstensi browser (seperti ModHeader) atau tool seperti Postman untuk menyisipkan header `X-SSO-Exclusive` saat mengakses aplikasi secara lokal.

> [!WARNING]
> Kredensial di atas digunakan murni untuk keperluan _testing environment_. Seluruh mekanisme autentikasi di _Production_ akan ditangani secara terpusat oleh sistem SSO Kota Batam menggunakan header tersebut.

## Struktur Direktori Utama

Berikut adalah struktur inti sistem, yang memudahkan _developer_ untuk memahami cakupan kode tanpa perlu membedah dari nol:

```text
├── app/
│   ├── Helpers/            # Fungsi bantuan global custom
│   ├── Http/Controllers/   # Pusat pengendali alur logika *backend* aplikasi
│   ├── Models/             # Representasi struktur tabel *database* (Eloquent ORM)
│   ├── Policies/           # Kebijakan otorisasi akses tingkat *resource*
│   ├── Providers/          # Pendaftaran *service* dan dependensi sistem (Service Providers)
│   └── Traits/             # Logika yang dapat dipindah-tangankan (reusable logic)
├── config/                 # Kumpulan file konfigurasi sistem (App, Database, Mail, dsb)
├── database/
│   ├── migrations/         # Skema versi struktur *database* aplikasi
│   └── seeders/            # Penyemaian data/akses bawaan sistem (Seeder)
├── doc/                    # Seluruh aturan internal dan konvensi *developer*
├── lang/                   # Manajemen terjemahan/dwibahasa antarmuka pengguna
│   ├── en/                 # Bahasa Inggris
│   ├── id/                 # Bahasa Indonesia
│   └── en.json             # Tempat tersimpannya seluruh ekstrak string kamus aplikasi
├── public/                 # Titik masuk aplikasi (*index.php*), aset statis publik, & *storage link*
├── resources/
│   ├── css/ & js/          # Tempat inisialisasi *Tailwind v4* dan aset statis lainnya
│   └── views/              # Rangka halaman antar-muka (*Blade Templates*)
│       ├── components/     # Komponen UI terfragmentasi (Blade Components)
│       │   ├── button/     # Varian tombol (Primary, Secondary, Error, dll)
│       │   ├── display/    # Penampil data (Badge, Status, Label, Empty State)
│       │   ├── form/       # Input, Select, Textarea, & Validasi Error
│       │   ├── icons/      # Kumpulan Ikon SVG sistem (Bilingual)
│       │   └── ui/         # Struktur UI (Card, Modal, Table, Dropdown, dll)
│       ├── hosting/        # Pengajuan & detail hosting (Sisi Petugas)
│       ├── hosting-verification/ # Alur verifikasi hosting (Tingkat 1 & Tingkat 2)
│       ├── issuance/       # Panel penerbitan & cetak surat/sertifikat (PDF)
│       ├── layouts/        # Kerangka layout utama, header, sidebar, & navigasi
│       ├── profile/        # Portal manajemen profil & keamanan akun
│       ├── opd/            # Manajemen data OPD oleh Admin
│       ├── pse/            # Registrasi & manajemen detail sistem PSE (Petugas)
│       ├── pse-verification/ # Alur verifikasi PSE (Tingkat 1 & Tingkat 2)
│       ├── reports/        # Kumpulan *Blade Template* untuk *PDF Reports*
│       ├── subdomain/      # Pengajuan & manajemen registrasi subdomain (Petugas)
│       ├── subdomain-verification/ # Alur verifikasi subdomain (Tingkat 1 & Tingkat 2)
│       ├── user/           # Manajemen hak akses & data pengguna (*Admin Only*)
│       ├── vendor/         # Customisasi tampilan pihak ketiga (Pagination, dll)
│       └── verification-history/ # Riwayat peninjauan seluruh modul verifikasi
├── routes/
│   └── web.php             # Registrasi URL/Jalur perpesanan sistem HTTP
├── storage/                # Penyimpanan berkas unggahan, *logs*, dan berkas *cache* aplikasi
└── tests/                  # Skenario pengujian sistem (Unit & Feature Tests)
```

## Struktur Dokumen & Konvensi

Harap membaca panduan internal (_guidelines_) pada direktori `doc/` sebelum melakukan pengembangan atau perbaikan fitur untuk mempertahankan standar arsitektur dan keamanan:

- `doc/DATA_MODEL.md`: Rancangan dan ketentuan Skema Database/Tabel aplikasi.
- `doc/ROLES.md`: Detail kebijakan Otorisasi RBAC dan batasan setiap Peran.
- `doc/FEATURES_FLOW.md`: Dokumentasi alur bisnis (_Single Flow_) dan proses operasional.
- `doc/SEEDER.md`: Mekanisme penyemaian (_seeding_) basis data untuk skenario testing.
- `doc/FILE_MAPPING.md`: Indeks pemetaan struktur seluruh komponen arsip aplikasi _(Codebase Map)_.
- `doc/ROUTES.md`: Definisi dan pemetaan seluruh jalur (_routes_) serta otorisasi akses dalam aplikasi.
- `doc/TASKS.md`: Log historis pengerjaan dan status pengembangan fitur.
- `doc/TODO.md`: Roadmap poin pengembangan dan laporan perencanaan tahap lanjut.

## Lisensi

[Aplikasi Internal] Hak Cipta dilindungi.
