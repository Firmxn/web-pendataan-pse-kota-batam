# Fitur & Alur Sistem (Single Flow) - Web Pendataan PSE Kota Batam

Dokumen ini menjelaskan alur operasional sistem mulai dari penginputan data oleh Petugas hingga proses verifikasi bertingkat dan penerbitan nomor pendataan.

---

## 1. Pemetaan Fitur Utama

### A. Pengelolaan Data Utama (CRUD)
*   **Manajemen PSE**: Pintu utama pendataan sistem elektronik.
*   **Manajemen Subdomain**: Pengajuan alamat URL (terintegrasi dalam form PSE).
*   **Manajemen Hosting**: Pengajuan sumber daya server Diskominfo (otomatis muncul jika lokasi penyimpanan di "Aplikasi").
*   **Manajemen Dokumen**: Pengunggahan surat permohonan (PDF) yang terintegrasi.

### B. Proses Bisnis (Workflow)
*   **Single Flow Submission**: Sekali klik "Ajukan" akan mengirimkan PSE, Subdomain, dan Hosting secara bersamaan.
*   **Verifikasi Berjenjang**:
    *   **Tingkat 1**: Pemeriksaan teknis dan kelengkapan berkas.
    *   **Tingkat 2 (Final)**: Persetujuan akhir dan pemberian Nomor Pendataan.
*   **Penerbitan (Issuance)**: Dashboard rekap data dan cetak bukti pendataan (PDF).

### C. Administrasi (Admin Only)
*   **Manajemen Pengguna**: Pengelolaan akun petugas (tambah, edit, nonaktifkan, restore).
*   **Manajemen OPD**: Pengelolaan data Organisasi Perangkat Daerah.

---

## 2. Alur Pengguna (User Flow)

### 🟢 Alur Petugas (Inputer)
1.  **Login SSO**: Masuk ke sistem menggunakan akun SSO Kota Batam.
2.  **Lengkapi Profil**: Memastikan data diri dan instansi (OPD) sudah benar.
3.  **Buat Pendataan PSE**:
    *   Isi identitas sistem (Nama, Sektor, Deskripsi).
    *   Masukkan daftar **Subdomain** (1 atau lebih).
    *   Unggah **Surat Permohonan Subdomain** (PDF).
    *   Isi data PIC penanggung jawab.
    *   Pilih **Lokasi Penyimpanan**:
        *   Jika pilih **"Aplikasi"**: Form **Hosting** akan muncul. Isi spesifikasi server (CPU, RAM, dll) dan unggah **Surat Permohonan Hosting**.
        *   Jika pilih "Colocation/Eksternal": Lanjut ke langkah berikutnya.
4.  **Simpan sebagai Draf**: Data tersimpan namun belum dapat dilihat verifikator.
5.  **Ajukan (Submit)**:
    *   Sistem memvalidasi kelengkapan berkas.
    *   Status PSE, Subdomain, dan Hosting berubah menjadi `pending_1`.
    *   Data terkunci (tidak bisa diedit kecuali ditolak/revisi).

### 🔵 Alur Verifikator 1 (Pemeriksa)
1.  **Review Pengajuan**: Masuk ke menu "Verifikasi PSE".
2.  **Cek Kelengkapan**: Memeriksa kesesuaian data input dengan dokumen PDF yang diunggah.
3.  **Keputusan**:
    *   **Setujui (Approve)**: Status naik menjadi `pending_2`.
    *   **Tolak (Reject)**: Status kembali menjadi `rejected` (Petugas dapat mengedit kembali). Wajib menyertakan catatan alasan penolakan.

### 🔴 Alur Verifikator 2 (Persetujuan Final)
1.  **Review Final**: Masuk ke menu "Verifikasi PSE (Final)".
2.  **Pemberian Nomor**: Jika data benar, Verifikator 2 menginput **Nomor Pendataan**.
3.  **Persetujuan Akhir**:
    *   **Setujui Final**: Status menjadi `approved`.
    *   **Tolak**: Kembali ke Petugas dengan catatan.

### 🟣 Alur Administrasi & Laporan (Admin & Eksekutif)
1.  **Monitoring**: Admin dan Eksekutif memantau statistik di Dashboard.
2.  **Rekapitulasi**: Mengunduh rekap data PSE, Subdomain, dan Hosting yang sudah disetujui.
3.  **Manajemen (Admin)**: Jika ada petugas baru, Admin mendaftarkan akun di menu "Manajemen Pengguna".

---

## 3. Matriks Status Data

| Status | Makna | Akses Edit (Petugas) | Akses Verifikasi |
| :--- | :--- | :---: | :---: |
| **Draft** | Data baru disimpan | Ya | Tidak |
| **Pending 1** | Menunggu Verifikator 1 | Tidak | Verifikator 1 |
| **Pending 2** | Menunggu Verifikator 2 | Tidak | Verifikator 2 |
| **Approved** | Selesai / Terdaftar | Tidak | Selesai |
| **Rejected** | Perlu revisi | Ya | Tidak |

---

## 4. Keamanan & Validasi
*   **Authorization**: Menggunakan Laravel Policy untuk memastikan Petugas hanya bisa mengedit data instansinya sendiri.
*   **Validation**: Seluruh file PDF divalidasi maksimal 5MB dan wajib diunggah sebelum pengajuan akhir (Single Flow).
*   **UUID**: Seluruh URL detail menggunakan UUID untuk mencegah manipulasi ID (*Insecure Direct Object Reference*).

---
**Terakhir Diperbarui:** 10 April 2026
