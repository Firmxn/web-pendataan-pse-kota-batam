# Dokumentasi Database Seeder - PSE Kota Batam

Dokumen ini menjelaskan struktur dan penggunaan database seeder untuk proyek Web Pendataan PSE Kota Batam.

## Overview

Database seeder digunakan untuk mengisi data awal (seed data) ke database, terutama untuk:

- Data master yang diperlukan aplikasi (roles)
- Data testing untuk development
- Data default untuk fresh installation

## Seeder Files

### 1. `DatabaseSeeder.php`

File utama yang mengatur urutan eksekusi seeder lainnya.

**Lokasi:** `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan seeder penting: Role -> OPD -> User
        $this->call(RoleSeeder::class);
        $this->call(OpdSeeder::class);
        $this->call(UserSeeder::class);
    }
}
```

**Urutan Penting:**

1. `RoleSeeder` - Harus pertama (karena user butuh role_id)
2. `OpdSeeder` - Kedua (karena user bisa punya opd_id)
3. `UserSeeder` - Ketiga (tergantung roles & opds)

---

### 2. `RoleSeeder.php`

Mengisi data master role untuk sistem RBAC.

**Lokasi:** `database/seeders/RoleSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['role_name' => 'petugas']);
        Role::create(['role_name' => 'verifikator_1']);
        Role::create(['role_name' => 'verifikator_2']);
    }
}
```

**Data yang Di-seed:**

| ID  | Role Name     | Deskripsi                              |
| --- | ------------- | -------------------------------------- |
| 1   | petugas       | Petugas OPD yang mendaftarkan PSE      |
| 2   | verifikator_1 | Verifikator tingkat 1 (administratif)  |
| 3   | verifikator_2 | Verifikator tingkat 2 (approval final) |

**Kenapa Perlu?**

- Role adalah data master yang **wajib ada** sebelum user bisa register
- Field `users.role_id` adalah `NOT NULL` (wajib diisi)
- Tanpa role, register akan error

---

### 3. `OpdSeeder.php` ✅

Mengisi data master OPD (Organisasi Perangkat Daerah) Kota Batam.

**Lokasi:** `database/seeders/OpdSeeder.php`

**Data yang Di-seed:** 38 OPD Kota Batam

**Kategori:**

- **Dinas** (16): Diskominfo, Disdik, Dinkes, PUPR, Dishub, Dinsos, Disnaker, Diskopukm, DPMPTSP, Dispar, Dispora, Dispusip, DLH, DP3A, Disdukcapil, Disperkimta
- **Badan** (6): Bappeda, BPKAD, BKPSDM, Bapenda, BPBD, Kesbangpol
- **Satuan** (1): Satpol PP
- **Sekretariat** (2): Setda, Setwan
- **Inspektorat** (1)
- **Kecamatan** (12): Batam Kota, Sekupang, Sagulung, Bengkong, Batu Aji, Nongsa, Lubuk Baja, Sei Beduk, Bulang, Galang, Belakang Padang, Batu Ampar

**Catatan:**

- Email hanya diisi untuk 3 OPD (Diskominfo, Disdik, Dinkes)
- Email lainnya nullable (bisa diisi manual nanti)
- Menggunakan `updateOrCreate()` untuk idempotency

---

### 4. `UserSeeder.php` ✅

Mengisi user default untuk testing dan development.

**Lokasi:** `database/seeders/UserSeeder.php`

**User Default yang Di-seed:**

| Nama                  | Email                    | UUID      | Role          | OPD        | NIP                |
| --------------------- | ------------------------ | --------- | ------------- | ---------- | ------------------ |
| Verifikator Tingkat 1 | verifikator1@example.go.id | `...0001` | verifikator_1 | -          | 198501012010011001 |
| Verifikator Tingkat 2 | verifikator2@example.go.id | `...0002` | verifikator_2 | -          | 198502022010012002 |
| Petugas Diskominfo    | petugas@example.go.id      | `...0003` | petugas       | Diskominfo | 198503032010013003 |

**Detail User:**

#### 1. Verifikator Tingkat 1

- **Email:** `verifikator1@example.go.id`
- **UUID:** `550e8400-e29b-41d4-a716-446655440001`
- **Password:** `sso-managed`
- **Role:** verifikator_1 (ID: 2)
- **OPD:** null (tidak terikat OPD)
- **Position:** Verifikator Tingkat 1
- **Work Unit:** Diskominfo Kota Batam
- **Status:** active

#### 2. Verifikator Tingkat 2

- **Email:** `verifikator2@example.go.id`
- **UUID:** `550e8400-e29b-41d4-a716-446655440002`
- **Password:** `sso-managed`
- **Role:** verifikator_2 (ID: 3)
- **OPD:** null (tidak terikat OPD)
- **Position:** Verifikator Tingkat 2
- **Work Unit:** Diskominfo Kota Batam
- **Status:** active

#### 3. Petugas Diskominfo

- **Email:** `petugas@example.go.id`
- **UUID:** `550e8400-e29b-41d4-a716-446655440003`
- **Password:** `sso-managed`
- **Role:** petugas (ID: 1)
- **OPD:** Dinas Komunikasi dan Informatika (ID: 1)
- **Position:** Staf IT
- **Work Unit:** Bidang Aplikasi dan Informatika
- **Status:** active

**Catatan Penting:**

- ⚠️ **SSO Simulation:** Akun-akun ini kini menggunakan simulasi SSO. Login di lingkungan _local/dev_ dipicu dengan mengirimkan header `X-SSO-Exclusive` bermuatan **Email** user yang bersangkutan.
- UUID tetap disediakan di seeder sebagai referensi identitas primer yang unik dan konsisten di seluruh lingkungan.
- Semua user menggunakan penomoran telepon standar internasional (`62...`).
- Menggunakan `updateOrCreate()` untuk idempotency (bisa dijalankan berkali-kali).

**Cara Menambah User Baru:**
Jika ingin menambah user testing lain, edit file `UserSeeder.php` dan tambahkan:

```php
// User Petugas - Dinas Pendidikan
User::updateOrCreate(
    ['email' => 'petugas.disdik@example.go.id'],
    [
        'name' => 'Petugas Dinas Pendidikan',
        'password' => Hash::make('password'),
        'role_id' => $rolePetugas->id,
        'opd_id' => $opdDisdik->id,
        'phone_number' => '081234567804',
        'nip' => '198504042010014004',
        'position' => 'Staf Administrasi',
        'status' => 'active',
    ]
);
```

Lalu jalankan:

```bash
php artisan db:seed --class=UserSeeder
```

---

## Cara Menjalankan Seeder

### 1. Run Semua Seeder

```bash
php artisan db:seed
```

Menjalankan `DatabaseSeeder.php` yang akan memanggil semua seeder terdaftar.

---

### 2. Run Seeder Spesifik

```bash
php artisan db:seed --class=RoleSeeder
```

Hanya menjalankan seeder tertentu.

---

### 3. Fresh Migration + Seed

```bash
php artisan migrate:fresh --seed
```

**Urutan:**

1. Drop semua tabel
2. Run semua migration
3. Run semua seeder

**⚠️ PERHATIAN:** Semua data akan hilang!

---

### 4. Refresh Migration + Seed

```bash
php artisan migrate:refresh --seed
```

**Urutan:**

1. Rollback semua migration
2. Run semua migration
3. Run semua seeder

---

## Best Practices

### 1. **Gunakan `firstOrCreate()` untuk Idempotency**

Agar seeder bisa dijalankan berkali-kali tanpa error duplicate:

```php
Role::firstOrCreate(
    ['role_name' => 'petugas'],
    ['role_name' => 'petugas']
);
```

### 2. **Pisahkan Seeder Berdasarkan Tipe Data**

- `RoleSeeder` - Data master role
- `OpdSeeder` - Data master OPD
- `UserSeeder` - User testing/default
- `PseSeeder` - PSE dummy untuk testing (optional)

### 3. **Gunakan Array untuk Data Banyak**

```php
$roles = ['petugas', 'verifikator_1', 'verifikator_2'];

foreach ($roles as $role) {
    Role::create(['role_name' => $role]);
}
```

### 4. **Jangan Seed Data Sensitif di Production**

- User default hanya untuk development/staging
- Production: admin dibuat manual via command khusus
- Jangan commit password production ke git

---

## Troubleshooting

### Error: "SQLSTATE[23000]: Integrity constraint violation"

**Penyebab:** Foreign key constraint gagal (misal: role_id tidak ada)

**Solusi:**

- Pastikan `RoleSeeder` dijalankan sebelum `UserSeeder`
- Cek urutan di `DatabaseSeeder.php`

---

### Error: "Class 'Database\Seeders\RoleSeeder' not found"

**Penyebab:** Seeder belum dibuat atau tidak ter-autoload

**Solusi:**

```bash
composer dump-autoload
php artisan optimize:clear
```

---

### Data Tidak Muncul Setelah Seed

**Solusi:**

1. Cek apakah seeder ter-register di `DatabaseSeeder.php`
2. Cek log error: `storage/logs/laravel.log`
3. Run dengan verbose: `php artisan db:seed -v`

---

## Membuat Seeder Baru

### Command:

```bash
php artisan make:seeder OpdSeeder
```

### Template:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;

class OpdSeeder extends Seeder
{
    public function run(): void
    {
        // Data seed di sini
    }
}
```

### Register di `DatabaseSeeder.php`:

```php
$this->call([
    RoleSeeder::class,
    OpdSeeder::class,  // ← Tambahkan di sini
]);
```

---

## Status Seeder Saat Ini

| Seeder           | Status   | Lokasi                                | Keterangan                                           |
| ---------------- | -------- | ------------------------------------- | ---------------------------------------------------- |
| `DatabaseSeeder` | ✅ Ada   | `database/seeders/DatabaseSeeder.php` | Main seeder, memanggil semua seeder                  |
| `RoleSeeder`     | ✅ Ada   | `database/seeders/RoleSeeder.php`     | Seed 3 roles (petugas, verifikator_1, verifikator_2) |
| `OpdSeeder`      | ✅ Ada   | `database/seeders/OpdSeeder.php`      | Seed 38 OPDs Kota Batam                              |
| `UserSeeder`     | ✅ Ada   | `database/seeders/UserSeeder.php`     | Seed 3 users default (2 verifikator + 1 petugas)     |
| `PseSeeder`      | ❌ Belum | -                                     | Optional (untuk testing data PSE dummy)              |

---

## Kredensial Login Default (SSO Simulation)

Setelah menjalankan seeder, gunakan header SSO berikut untuk mensimulasikan login secara lokal:

### Verifikator Tingkat 1

```
Header: X-SSO-Exclusive: verifikator1@example.go.id
```

### Verifikator Tingkat 2

```
Header: X-SSO-Exclusive: verifikator2@example.go.id
```

### Petugas OPD

```
Header: X-SSO-Exclusive: petugas@example.go.id
```

⚠️ **PENTING:** Autentikasi lokal via password telah dinonaktifkan. Sistem kini sepenuhnya bergantung pada header `X-SSO-Exclusive` (internal) atau `X-SSO-User` (publik) untuk identifikasi pengguna.

## Rekomendasi Next Steps

1. ✅ ~~Buat `OpdSeeder`~~ - Sudah dibuat (38 OPDs)
2. ✅ ~~Buat `UserSeeder`~~ - Sudah dibuat (3 users default)
3. **Update `.env.example`** - Tambahkan komentar untuk default credentials
4. **Testing** - Jalankan `migrate:fresh --seed` dan test login dengan kredensial di atas
5. **Buat `PseSeeder`** (Optional) - Untuk testing data PSE dummy

---

## Referensi

- [Laravel Seeding Documentation](https://laravel.com/docs/10.x/seeding)
- [doc/DATA_MODEL.md](DATA_MODEL.md) - Struktur database
- [doc/ROLES.md](ROLES.md) - Definisi role
