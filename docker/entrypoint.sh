#!/bin/sh
# ==============================================================================
# ENTRYPOINT SCRIPT — Web Pendataan PSE Kota Batam
# Script ini dijalankan otomatis SETIAP KALI container dinyalakan.
# Tugasnya: menyiapkan Laravel agar siap digunakan sebelum server dinyalakan.
# ==============================================================================

set -e

echo "========================================"
echo "  PSE App: Menyiapkan Aplikasi..."
echo "========================================"

# Pindah ke direktori aplikasi
cd /var/www/html

# 1. Salin .env dari .env.example jika belum ada
if [ ! -f ".env" ]; then
    echo ">> Membuat file .env dari .env.example..."
    cp .env.example .env
fi

# 2. Generate application key jika belum ada
if grep -q "APP_KEY=$" .env; then
    echo ">> Membuat APP_KEY baru..."
    php artisan key:generate --force
fi

# 3. Tunggu database benar-benar siap menerima koneksi
echo ">> Menunggu koneksi ke database..."
until php artisan db:monitor 2>/dev/null; do
    echo "   Database belum siap, coba lagi dalam 3 detik..."
    sleep 3
done
echo "   Database terhubung!"

# 4. Jalankan migrasi database secara otomatis
echo ">> Menjalankan migrasi database..."
php artisan migrate --force --no-interaction

# 5. Jalankan seeder (hanya jika tabel roles masih kosong)
echo ">> Memeriksa data awal (seeder)..."
ROLE_COUNT=$(php artisan tinker --execute="echo \App\Models\Role::count();" 2>/dev/null | tail -1)
if [ "$ROLE_COUNT" = "0" ] || [ -z "$ROLE_COUNT" ]; then
    echo ">> Menjalankan seeder data awal..."
    php artisan db:seed --force --no-interaction
else
    echo ">> Data awal sudah ada, seeder dilewati."
fi

# 6. Bersihkan cache dan optimalkan
echo ">> Mengoptimalkan aplikasi..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Buat symbolic link untuk storage (akses file publik)
echo ">> Menyiapkan storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "========================================"
echo "  PSE App: Siap! Menjalankan server..."
echo "  Akses di: http://localhost:8000"
echo "========================================"

# Jalankan server Laravel
exec php artisan serve --host=0.0.0.0 --port=8000
