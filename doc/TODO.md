# LAPORAN PERENCANAAN PENGEMBANGAN SISTEM TAHAP LANJUT

## Web Pendataan PSE Kota Batam - April 2026

### 11 Poin Utama
1. Restriksi Profil Petugas: Petugas tidak memiliki hak untuk mengubah data profil akun. Petugas hanya dapat melihat data profil akunnya tanpa akses untuk mengedit.
2. Manajemen Akun Admin: Admin memiliki menu untuk pendaftaran dan pengelolaan akun petugas. Ini mencakup penambahan role admin serta pengelolaan data profil petugas.
3. Akses Terbatas Profil: Petugas hanya dapat melihat profil miliknya sendiri. Akses petugas dibatasi pada tampilan profil pribadi dan instansi terkait.
4. Standarisasi Sektor: Field sektor pada pendataan PSE menggunakan pilihan terstruktur. Input sektor tidak lagi menggunakan teks bebas, melainkan menggunakan select/dropdown.
5. Form Create PSE Adaptif: Field pada form Create PSE disesuaikan dengan kebutuhan sistem. Struktur field bersifat adaptif mengikuti ketentuan teknis dan administratif yang berlaku.
6. Integrasi Domain PSE: Pendataan domain digabungkan ke dalam pendataan PSE. Satu data PSE dapat memiliki lebih dari satu domain atau subdomain.
7. Lokasi Penyimpanan dan Hosting: Lokasi penyimpanan data dibagi menjadi tiga kategori utama, yaitu Aplikasi, Colocation, dan Eksternal. Apabila pengguna memilih Aplikasi, sistem akan menampilkan form hosting.
8. Penerapan Role Eksekutif: Ditambahkan role Eksekutif dengan akses baca laporan. Role ini hanya berfungsi untuk melihat laporan dan rekap data tanpa hak ubah.
9. Spesialisasi Dashboard Petugas: Dashboard petugas hanya menampilkan data hosting aplikasi. Data selain kategori aplikasi, seperti Colocation dan Eksternal, tidak ditampilkan pada dashboard petugas.
10. Akses Rekapitulasi Data: Admin, verifikator, dan eksekutif dapat melihat seluruh data rekapitulasi untuk kebutuhan monitoring, verifikasi, dan pelaporan.
11. Dokumentasi Rilis melalui /published: Routing /published dibuat untuk menampilkan dokumentasi rilis pertama, dengan file version.txt yang disimpan di dalam folder public dan berisi identitas rilis awal sistem.

---

### 1. PENDAHULUAN

Laporan ini disusun untuk merinci rencana pengembangan strategis dan teknis bagi sistem "Web Pendataan PSE Kota Batam". Fokus utama pengembangan tahap ini adalah penyempurnaan relatifitas data, pengetatan keamanan berbasis peran (RBAC), dan standarisasi antarmuka pengguna. Berdasarkan hasil diskusi, terdapat 11 poin utama yang akan diimplementasikan sebagai fondasi sistem PSE rilis pertama.

---

### 2. ANALISIS DATA & RELASI STRUKTURAL

Perubahan fundamental pada skema database dilakukan untuk mendukung fleksibilitas pendataan di lapangan.

- **[x] Penyatuan Alur PSE & Subdomain (Point 6):** Sistem akan mengintegrasikan pendataan PSE dan pengajuan Subdomain yang sebelumnya terpisah menjadi satu alur pengajuan terpadu (_Single Flow_).
- **[x] Standarisasi Lokasi Penyimpanan Data (Point 7):** Penambahan klasifikasi infrastruktur penyimpanan pada formulir PSE (Aplikasi, Colocation, Eksternal) dan integrasi draf Hosting otomatis.

---

### 3. KEAMANAN & AKSES KONTROL (RBAC) - ✅ SELESAI

Peningkatan integritas data melalui pembatasan akses yang lebih ketat berdasarkan hirarki pengguna.

- **[x] Wewenang Operasional Petugas (Point 6, 7):** Petugas dikukuhkan sebagai penginput data utama.
- **[x] Restriksi Profil Akun (Point 1 & 3):** Petugas dilarang edit profil sendiri; dikelola oleh Admin.
- **[x] Implementasi Peran Admin Baru (Point 2):** Admin sebagai pengelola akun petugas.
- **[x] Peran Eksekutif (Point 8 & 10):** Eksekutif sebagai peninjau murni (Viewer-only).

---

### 4. ANALISIS KEBUTUHAN FUNGSIONAL & MANAGEMENT

- **[x] Manajemen Akun Petugas oleh Admin (Point 2):** Menu khusus Admin sudah tersedia.
- **[x] Standarisasi Variabel Sektor (Point 4):** Mengubah input teks ke Select (Dropdown).
- **[x] Penyaringan Dashboard Petugas (Point 9):** Hanya menampilkan data Hosting bertipe "Aplikasi" untuk petugas.
- **[x] Inklusivitas Fitur Rekapitulasi (Point 10):** Akses rekap untuk Admin, Verifikator, dan Eksekutif sudah terbuka.

---

### 5. ANTARMUKA PENGGUNA (UI/UX) - ✅ SELESAI

- [x] Logika Kondisional Hosting (Point 7): Implementasi JS untuk mendeteksi pilihan Lokasi Penyimpanan di form PSE.
- [x] Form Pendaftaran Terpadu (Point 5 & 6): Penyesuaian form untuk Multiple Subdomains (1-N).
- [x] Fleksibilitas Field (Point 5): Penyesuaian atribut field secara adaptif.

---

### 6. ADMINISTRASI RILIS - ✅ SELESAI

- **[x] Penerbitan Kredit Pengembang (Point 11):** Routing `/published` dan berkas `version.txt` sudah aktif.

---

### 7. ACUAN 11 POIN UTAMA (STATUS UPDATE)

1.  **[x] Restriksi Profil Petugas:** Selesai (Task #61).
2.  **[x] Manajemen Akun Admin:** Selesai (Task #61).
3.  **[x] Akses Terbatas Profil:** Selesai (Task #61).
4.  **[x] Standarisasi Sektor:** Selesai.
5.  **[x] Form Create PSE Adaptif:** Selesai (Task #65).
6.  **[x] Integrasi Domain PSE (1-N):** Selesai (Task #65).
7.  **[x] Lokasi Penyimpanan & Hosting:** Selesai (Terintegrasi ke form PSE).
8.  **[x] Penerapan Role Eksekutif:** Selesai.
9.  **[x] Spesialisasi Dashboard Petugas:** Selesai (Task #66).
10. **[x] Demokratisasi Rekap Data:** Selesai.
11. **[x] Dokumentasi Kredit /published:** Selesai.

---

### 8. KESIMPULAN

Sistem telah berhasil menyelesaikan seluruh perencanaan strategis dan operasional yang tertuang dalam 11 poin utama rilis pertama (11/11 poin). Fokus pengerjaan selanjutnya akan beralih ke masa pemeliharaan (maintenance) dan pengembangan fitur sekunder (Fase 2) seperti Notifikasi dan Audit Log mendalam.

_Terakhir diperbarui: 4 April 2026_
