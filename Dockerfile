# ==============================================================================
# DOCKERFILE — Web Pendataan PSE Kota Batam
# Berbasis PHP 8.2 FPM + Node.js 20 (untuk build aset Vite/Tailwind)
# ==============================================================================

# Tahap 1: Node.js Builder (Build aset frontend)
# Menggunakan multi-stage build agar image akhir lebih kecil dan bersih
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy file package manager terlebih dahulu (manfaatkan Docker layer cache)
COPY package.json package-lock.json ./

# Install dependensi JavaScript
RUN npm ci --ignore-scripts

# Copy seluruh source code
COPY . .

# Build aset frontend (Tailwind CSS v4 + Vite)
RUN npm run build

# ==============================================================================
# Tahap 2: PHP Application
# ==============================================================================
FROM php:8.2-cli

# Metadata image
LABEL maintainer="Web Pendataan PSE Kota Batam"
LABEL description="Aplikasi web pendataan PSE berbasis Laravel 10"

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
    # Alat bantu dasar
    curl \
    unzip \
    git \
    # Dependensi untuk ekstensi PHP
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    # Dependensi dompdf (PDF generation)
    libfontconfig1 \
    libxrender1 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        xml \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (Package manager PHP)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Tetapkan direktori kerja
WORKDIR /var/www/html

# Copy file composer terlebih dahulu untuk memanfaatkan Docker layer cache
COPY composer.json composer.lock ./

# Install PHP dependencies (tanpa dev dependencies dan tanpa run scripts dulu)
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# Copy seluruh source code ke dalam container
COPY . .

# Ambil hasil build aset frontend dari tahap node-builder
COPY --from=node-builder /app/public/build ./public/build

# Buat autoloader yang dioptimasi setelah semua file tersedia
RUN composer dump-autoload --optimize

# Buat direktori yang dibutuhkan Laravel dengan permission yang benar
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Salin dan atur permission untuk entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Ekspos port yang digunakan php artisan serve
EXPOSE 8000

# Entrypoint untuk setup otomatis sebelum aplikasi dijalankan
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
