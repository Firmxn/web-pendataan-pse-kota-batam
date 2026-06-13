# Peran (Aktor) Sistem - Web Pendataan PSE Kota Batam

Dokumen ini mendefinisikan peran (*roles*) dan tanggung jawab dari setiap peran (aktor) yang berinteraksi dengan "Web Pendataan PSE Kota Batam". Desain sistem ini didasarkan pada **Role-Based Access Control (RBAC)** untuk memisahkan hak akses secara jelas.

Berdasarkan desain sistem, terdapat lima (5) peran utama yang teridentifikasi untuk mencakup seluruh aspek operasional dan manajerial.

## 1. Petugas Pendata PSE (Perwakilan OPD)

Peran ini adalah perwakilan resmi dari Organisasi Perangkat Daerah (OPD) di lingkungan Pemerintah Kota Batam. Mereka adalah pengguna utama yang mengajukan dan mengelola data sistem elektronik.

**Tugas & Kewenangan:**

* **Manajemen Akun:**
    * Melengkapi data profil pribadi dan mengunggah Surat Tugas.
    * Autentikasi dikelola secara terpusat melalui sistem SSO Kota Batam (Header-based).
* **Manajemen PSE:**
    * Mengelola (Tambah, Lihat, Ubah, Hapus Draft) Data PSE.
    * Melihat status dan riwayat verifikasi Data PSE yang diajukan.
    * Mengunduh Dokumen Tanda Bukti Terdata (internal) untuk Data PSE yang telah disetujui.
* **Manajemen Layanan:**
    * Mengajukan permintaan Subdomain (Baru, Perpanjangan, Ubah, Hapus).
    * Mengajukan permintaan Hosting (Baru, Ubah Spesifikasi, Hapus).
    * Melihat status dan riwayat verifikasi untuk permintaan Subdomain dan Hosting.

## 2. Verifikator 1 (Admin Diskominfo - Lapis 1)

Peran ini adalah staf internal Dinas Komunikasi dan Informatika (Diskominfo) Kota Batam. Peran utamanya adalah sebagai pemeriksa kelengkapan administratif (Lapis 1).

**Tugas & Kewenangan:**

* **Fokus Utama:** Melakukan pemeriksaan awal terhadap kelengkapan dan validitas data serta dokumen pendukung yang diajukan oleh Petugas Pendata PSE.
* **Verifikasi:**
    * Memverifikasi (Menyetujui/Menolak) pengajuan **Data PSE**.
    * Memverifikasi (Menyetujui/Menolak) pengajuan **Permintaan Subdomain**.
    * Memverifikasi (Menyetujui/Menolak) pengajuan **Permintaan Hosting**.
* **Proses:**
    * Memeriksa kesesuaian dokumen pendukung (misalnya, Surat Tugas Petugas, Surat Permohonan Layanan).
    * Memiliki wewenang untuk meneruskan pengajuan yang sudah lengkap dan valid ke Verifikator 2.
* **Batasan:**
    * Tidak memiliki wewenang untuk memberikan persetujuan final (status `Approved`).
    * Tidak memiliki wewenang untuk menghasilkan (*generate*) dokumen atau laporan resmi.

## 3. Verifikator 2 (Admin Diskominfo - Lapis 2 / Approval)

Peran ini adalah staf internal Diskominfo Kota Batam yang memiliki wewenang penuh untuk melakukan pemeriksaan substantif dan memberikan persetujuan akhir (Lapis 2).

**Tugas & Kewenangan:**

* **Fokus Utama:** Melakukan pemeriksaan substantif terhadap data, memastikan kesesuaian dengan kebijakan internal Diskominfo, regulasi (Permenkomdigi), dan ketersediaan sumber daya.
* **Verifikasi & Approval:**
    * Melakukan validasi akhir dan memberikan persetujuan final (Menyetujui/Menolak) untuk **Data PSE**.
    * Melakukan validasi akhir dan memberikan persetujuan final (Menyetujui/Menolak) untuk **Permintaan Subdomain**.
    * Melakukan validasi akhir dan memberikan persetujuan final (Menyetujui/Menolak) untuk **Permintaan Hosting**.
* **Penerbitan Dokumen/Laporan:**
    * Bertanggung jawab untuk menghasilkan (*generate*) Dokumen Tanda Bukti Terdata PSE yang telah disetujui.
    * Menghasilkan (*generate*) Laporan/Rekapitulasi Data Subdomain.
    * Menghasilkan (*generate*) Laporan/Rekapitulasi Data Hosting.

---

## 4. Administrator (IT Admin Diskominfo)

Peran ini memiliki kendali penuh atas konfigurasi sistem dan manajemen data master yang tidak terkait langsung dengan proses verifikasi bisnis.

**Tugas & Kewenangan:**

*   **Manajemen Master Data:** Mengelola data Organisasi Perangkat Daerah (OPD), termasuk menambah, mengubah, dan memulihkan data OPD yang dihapus.
*   **Manajemen Pengguna:** Mengelola akun pengguna di seluruh sistem, mengatur peran, serta memulihkan (*restore*) akun yang dinonaktifkan.
    *   *Batasan Otorisasi UI*: Melalui antarmuka web, Admin hanya diperbolehkan meregistrasikan, mengedit, atau menghapus akun dengan peran **`petugas`**. Akun-akun berhak tinggi lainnya seperti Verifikator, Eksekutif, atau sesama Admin dilindungi dan tidak dapat dimanipulasi melalui antarmuka web (hanya dikelola via database/SSO).
*   **Pemeliharaan Sistem:** Memiliki akses ke seluruh fitur manajerial untuk memastikan kelancaran operasional sistem.

---

## 5. Eksekutif (Pimpinan / Stakeholder)

Peran ini memiliki akses terbatas yang bersifat memantau ( *monitoring*) untuk kebutuhan pengambilan keputusan.

**Tugas & Kewenangan:**

*   **Pemantauan Data:** Melihat daftar seluruh PSE, Subdomain, dan Hosting yang terdaftar maupun dalam proses.
*   **Akses Laporan:** Mengunduh laporan rekapitulasi dan ringkasan data untuk kebutuhan manajerial.
*   **Read-Only:** Tidak memiliki wewenang untuk menambah, mengubah, atau melakukan verifikasi terhadap data.

---

### Fungsi Bersama (Common Use Cases)

Semua peran (Petugas, Verifikator, Admin, dan Eksekutif) memiliki kemampuan untuk:

*   Melakukan **Login** ke sistem (via SSO Header).
*   Melakukan **Pencarian & Filter** data sesuai dengan hak akses masing-masing.
*   Mengunduh **Dokumen Publik/Hasil Verifikasi** yang telah diterbitkan.
*   Melakukan **Logout** dari sistem (Clear Session).