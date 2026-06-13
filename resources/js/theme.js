/**
|--------------------------------------------------------------------------
| MANAJEMEN TEMA (LIGHT & DARK MODE)
|--------------------------------------------------------------------------
| Berkas ini digunakan untuk mengatur transisi tema global antara mode terang
| (light/main) dan mode gelap (dark) menggunakan penyimpanan lokal (localStorage).
| Berfungsi mencegah kedipan layar putih (Flash of Unstyled Content/FOUC)
| dan menyelaraskan status tombol toggler tema yang ada di antarmuka pengguna.
|
| MITIGASI KEAMANAN:
| 1. Pemasangan tema dilindungi dari serangan *DOM-based XSS* dan manipulasi
|    skrip liar dengan melakukan validasi ketat. Hanya nilai tema yang terdaftar
|    dalam whitelist 'ThemeConfig' ('main' dan 'dark') yang akan diterapkan ke DOM.
| 2. Menghindari penggunaan inline script langsung di dalam berkas HTML/Blade
|    untuk mematuhi standar pengerasan keamanan (*security hardening*) dan
|    mempermudah implementasi Content Security Policy (CSP) tanpa unsafe-inline.
*/

/**
 * Konfigurasi Tema Global
 * Pastikan nama tema di sini SAMA PERSIS dengan nama di app.css atau setelan DaisyUI.
 */
const ThemeConfig = {
    light: 'main', // Sesuai @plugin "daisyui/theme" { name: "main" }
    dark: 'dark' // Sesuai @plugin "daisyui/theme" { name: "dark" }
};

// Pastikan konfigurasi ini dapat diakses secara global jika dibutuhkan oleh bagian aplikasi lain
window.ThemeConfig = ThemeConfig;

/**
 * Fungsi Inisialisasi Tema
 * Menentukan dan menerapkan tema yang tersimpan di localStorage atau tema default ke elemen <html>.
 */
function initTheme() {
    let savedTheme = localStorage.getItem('theme') || ThemeConfig.light;

    // Validasi: Hanya izinkan tema yang terdaftar di konfigurasi
    if (savedTheme !== ThemeConfig.light && savedTheme !== ThemeConfig.dark) {
        savedTheme = ThemeConfig.light;
        localStorage.setItem('theme', savedTheme);
    }

    // Terapkan atribut tema
    document.documentElement.setAttribute('data-theme', savedTheme);

    // Toggle class dark mode untuk mendukung varian dark Tailwind jika digunakan
    if (savedTheme === ThemeConfig.dark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

// Jalankan inisialisasi tema sesegera mungkin saat script dimuat
initTheme();

/**
 * Fungsi Handler Pengendali Toggle Tema
 * Menghubungkan elemen checkbox toggle dengan fungsionalitas pergantian tema.
 */
function initThemeToggle() {
    const themeController = document.querySelector('.theme-controller');
    if (!themeController) return;

    const currentTheme = localStorage.getItem('theme') || ThemeConfig.light;

    // Sinkronkan status awal checkbox dengan tema saat ini
    if (currentTheme === ThemeConfig.dark) {
        themeController.checked = true;
    }

    // Dengarkan event perubahan (change) pada toggle
    themeController.addEventListener('change', (e) => {
        const isDark = e.target.checked;
        const newTheme = isDark ? ThemeConfig.dark : ThemeConfig.light;

        // Terapkan atribut tema ke elemen HTML
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        // Toggle class dark mode
        if (newTheme === ThemeConfig.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
}

// Tunggu hingga DOM siap sebelum menginisialisasi pengendali toggle
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initThemeToggle);
} else {
    initThemeToggle();
}
