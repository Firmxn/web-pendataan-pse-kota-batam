import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        // Tailwind CSS v4 plugin - harus diletakkan PERTAMA sebelum Laravel plugin
        tailwindcss(),

        // Laravel Vite plugin untuk integrasi dengan Laravel
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true, // Auto-refresh browser saat file berubah
        }),
    ],

    // -----------------------------------------------------------------
    // Konfigurasi Development Server
    // -----------------------------------------------------------------
    // server: {
    //     // Host: domain yang digunakan untuk development
    //     host: "pse.fly",

    //     // Port: port untuk Vite dev server
    //     port: 7773,

    //     // HTTPS: menggunakan SSL certificate untuk HTTPS
    //     // Diperlukan agar tidak ada mixed content error (HTTPS → HTTP)
    //     https: {
    //         key: "C:/Code/Sertificate/WoZGu8.pse.fly.key",   // Path ke private key
    //         cert: "C:/Code/Sertificate/WoZGu8.pse.fly.crt",  // Path ke certificate
    //     },

    //     // HMR (Hot Module Replacement): untuk live reload saat development
    //     hmr: {
    //         host: "pse.fly", // Host untuk WebSocket HMR
    //     },

    //     // CORS: mengizinkan request dari origin lain
    //     cors: true,
    // },
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        origin: 'http://127.0.0.1:5173',
        hmr: {
            host: '127.0.0.1',
        },
        cors: true,
    },
});
