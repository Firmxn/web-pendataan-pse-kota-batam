/**
|--------------------------------------------------------------------------
| MAIN JS ENTRYPOINT (VITE BUNDLER)
|--------------------------------------------------------------------------
| Berkas ini merupakan titik masuk utama (entrypoint) untuk aset JavaScript
| aplikasi. Berfungsi mengimpor pustaka pihak ketiga, modul internal, serta
| menginisialisasi utilitas global yang digunakan di seluruh aplikasi.
|
| MITIGASI KEAMANAN:
| 1. Berkas ini dikompilasi oleh Vite menjadi modul JS eksternal, sehingga
|    tidak memerlukan eksekusi inline script di halaman HTML/Blade. Ini mematuhi
|    aturan Content Security Policy (CSP) yang melarang arahan 'unsafe-inline'.
| 2. Pustaka global yang diekspos (seperti ApexCharts) dibatasi cakupannya
|    dan dikonfigurasi secara aman untuk menghindari potensi kerentanan purwarupa
|    (prototype pollution) atau kebocoran data sensitif.
*/

import './bootstrap';

// Import theme management
import './theme';

// Import chart loader (ApexCharts)
import './chart-loader';

// Import modal utilities
import './modal-utils';

// Import chips input loader
import './chips-loader';

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

/**
 * Inisialisasi Toggle Form Hosting PSE berbasis pilihan lokasi penyimpanan
 */
function initPseFormHostingToggle() {
    const radios = document.querySelectorAll('input[name="storage_location"]');
    if (radios.length === 0) return;

    function toggleHostingSection(value) {
        const section = document.getElementById('hosting-section');
        const btnMain = document.getElementById('btn-section-main');
        const btnHosting = document.getElementById('btn-section-hosting');

        if (value === 'aplikasi') {
            // Tampilkan area hosting dengan menghapus kelas 'hidden'
            if (section) section.classList.remove('hidden');
            // Sembunyikan tombol simpan utama (ubah 'flex' menjadi 'hidden')
            if (btnMain) {
                btnMain.classList.remove('flex');
                btnMain.classList.add('hidden');
            }
            // Tampilkan tombol simpan hosting (ubah 'hidden' menjadi 'flex')
            if (btnHosting) {
                btnHosting.classList.remove('hidden');
                btnHosting.classList.add('flex');
            }
        } else {
            // Sembunyikan area hosting dengan menambahkan kelas 'hidden'
            if (section) section.classList.add('hidden');
            // Tampilkan tombol simpan utama (ubah 'hidden' menjadi 'flex')
            if (btnMain) {
                btnMain.classList.remove('hidden');
                btnMain.classList.add('flex');
            }
            // Sembunyikan tombol simpan hosting (ubah 'flex' menjadi 'hidden')
            if (btnHosting) {
                btnHosting.classList.remove('flex');
                btnHosting.classList.add('hidden');
            }
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', (e) => toggleHostingSection(e.target.value));
        // Inisialisasi status saat halaman dimuat (untuk handle old / existing data)
        if (radio.checked) {
            toggleHostingSection(radio.value);
        }
    });
}

if (typeof window !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPseFormHostingToggle);
    } else {
        initPseFormHostingToggle();
    }

    // Auto-submit form untuk elemen dengan atribut data-auto-submit (Solusi kepatuhan CSP)
    document.addEventListener('change', function(e) {
        if (e.target && e.target.hasAttribute('data-auto-submit')) {
            if (e.target.form) {
                e.target.form.submit();
            }
        }
    });

    // Konfirmasi submit form secara global (Solusi kepatuhan CSP)
    document.addEventListener('submit', function(e) {
        const confirmMessage = e.target.getAttribute('data-confirm');
        if (confirmMessage) {
            if (!confirm(confirmMessage)) {
                e.preventDefault(); // Batalkan pengiriman form jika user menolak (Cancel)
            }
        }
    });

    // Delegasi event untuk membuka modal secara global (Solusi kepatuhan CSP)
    document.addEventListener('click', function(e) {
        const showBtn = e.target.closest('[data-modal-show]');
        if (showBtn) {
            const modalId = showBtn.getAttribute('data-modal-show');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.showModal();
            }
        }
    });

    // Delegasi event untuk menutup dan me-reset modal secara global (Solusi kepatuhan CSP)
    document.addEventListener('click', function(e) {
        const closeBtn = e.target.closest('[data-modal-close]');
        if (closeBtn) {
            const modalId = closeBtn.getAttribute('data-modal-close');
            if (typeof window.closeAndResetModal === 'function') {
                window.closeAndResetModal(modalId);
            } else {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.close();
                }
            }
        }
    });

    // Delegasi event untuk menutup/menghapus alert secara global (Solusi kepatuhan CSP)
    document.addEventListener('click', function(e) {
        const dismissBtn = e.target.closest('[data-dismiss="alert"]');
        if (dismissBtn) {
            const alert = dismissBtn.closest('[role="alert"]');
            if (alert) {
                alert.remove();
            }
        }
    });
}

