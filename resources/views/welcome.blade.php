<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="main">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', __('Pendataan PSE Batam')) }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased min-h-screen flex flex-col bg-base-100 text-base-content relative overflow-x-hidden welcome-body-bg">

    {{-- Ambient Decoration --}}
    <div
        class="fixed top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-primary/5 blur-[120px] rounded-full pointer-events-none -z-10">
    </div>

    {{-- Navbar --}}
    <nav class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center z-10">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-lg bg-base-100 border border-base-200 shadow-sm flex items-center justify-center text-primary">
                <x-ui.application-logo class="w-6 h-6 fill-current" />
            </div>
            <span
                class="font-bold text-lg tracking-tight bg-clip-text text-transparent bg-linear-to-r from-primary to-secondary dark:from-primary dark:to-accent">
                {{ config('app.name') }}
            </span>
        </div>

        <div class="flex items-center gap-4">
            {{-- Theme Toggle --}}
            <label class="swap swap-rotate btn btn-sm btn-ghost btn-circle">
                <input type="checkbox" class="theme-controller" value="synthwave" />
                {{-- Sun icon --}}
                <svg class="swap-off h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>
                {{-- Moon icon --}}
                <svg class="swap-on h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>
            </label>

            @auth
                {{-- User authenticated via SSO dengan role internal --}}
                <a href="{{ url('/dashboard') }}"
                    class="btn btn-sm btn-ghost font-medium px-6 rounded-lg">{{ __('Dashboard') }}</a>
            @else
                <a href="#" class="btn btn-sm btn-ghost font-medium px-6 rounded-lg">{{ __('Daftar') }}</a>
                <a href="#"
                    class="btn btn-sm bg-primary text-white border border-primary px-6 rounded-lg shadow-lg shadow-primary/20">
                    {{ __('Masuk') }}
                </a>
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <main class="grow flex flex-col items-center justify-center px-6 pt-10 pb-20 text-center max-w-5xl mx-auto z-10">
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-base-100/50 border border-base-200 text-xs font-medium text-primary mb-8 animate-fade-in-up">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            {{ __('Implementasi Permenkomdigi No. 5 Tahun 2025') }}
        </div>

        <h1 class="text-4xl md:text-6xl font-bold tracking-tight text-base-content mb-6 leading-tight">
            {{ __('Pendataan Terpadu') }} <br class="hidden md:block" />
            <span
                class="text-transparent bg-clip-text bg-linear-to-r from-primary to-secondary dark:from-primary dark:to-accent">{{ __('Penyelenggara Sistem Elektronik') }}</span>
        </h1>

        <p class="text-lg md:text-xl text-base-content/70 max-w-2xl mx-auto mb-10 leading-relaxed">
            {{ __('Platform resmi pendataan awal PSE di lingkungan Pemerintah Kota Batam sebagai langkah strategis menuju pendaftaran PSE Nasional.') }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
            <a href="{{ route('dashboard')}}"
                class="btn bg-primary text-white border border-primary h-12 px-8 text-base shadow-xl shadow-primary/20 hover:bg-primary hover:border-primary hover:text-white hover:scale-105 transition-transform">
                {{ __('Mulai Pendataan') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
            <a href="#info" {{-- class="btn btn-ghost border border-base-200 bg-base-100/50 h-12 px-8 text-base hover:bg-base-200"> --}} class="btn btn-outline btn-primary h-12 px-8 text-base">
                {{ __('Pelajari Lebih Lanjut') }}
            </a>
        </div>
    </main>

    {{-- Information Grid --}}
    <section id="info" class="w-full bg-base-100 border-t border-base-200 py-20 relative">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">

            {{-- Card 1: Apa itu PSE? --}}
            <div class="flex flex-col gap-4 group">
                <div
                    class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-base-content">{{ __('Apa itu PSE?') }}</h3>
                <p class="text-base-content/70 leading-relaxed">
                    <strong
                        class="text-transparent bg-clip-text bg-linear-to-r from-primary to-secondary dark:from-primary dark:to-accent ">{{ __('Penyelenggara Sistem Elektronik') }}</strong>
                    {{ __('adalah setiap pihak yang menyediakan, mengelola, atau mengoperasikan sistem elektronik. Di lingkup pemerintahan, setiap aplikasi dan layanan digital yang melayani publik wajib dikategorikan sebagai PSE.') }}
                </p>
            </div>

            {{-- Card 2: Permenkomdigi No 5/2025 --}}
            <div class="flex flex-col gap-4 group">
                <div
                    class="w-12 h-12 rounded-xl bg-accent/10 dark:bg-warning/10 text-accent dark:text-warning flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-base-content">{{ __('Permenkomdigi No. 5 2025') }}</h3>
                <p class="text-base-content/70 leading-relaxed">
                    {{ __('Aturan ini mewajibkan seluruh PSE Lingkup Publik untuk melakukan') }}
                    <strong>{{ __('pendaftaran resmi') }}</strong>.
                    {{ __('Tujuannya adalah menjamin standar keamanan informasi, pelindungan data pribadi, dan kedaulatan siber nasional yang terintegrasi.') }}
                </p>
            </div>

            {{-- Card 3: Fungsi Website --}}
            <div class="flex flex-col gap-4 group">
                <div
                    class="w-12 h-12 rounded-xl bg-secondary/10 dark:bg-accent/10 text-secondary dark:text-accent flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-base-content">{{ __('Pendataan & Pendaftaran') }}</h3>
                <p class="text-base-content/70 leading-relaxed">
                    {{ __('Sistem ini berfungsi sebagai') }} <strong>{{ __('Pusat Data Awal') }}</strong>
                    {{ __('(Inventory). OPD mendaftarkan sistemnya di sini, diverifikasi oleh tim Kota Batam, untuk kemudian didaftarkan secara kolektif dan resmi ke Pemerintah Pusat oleh Pemko Batam.') }}
                </p>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="w-full bg-base-100 py-24 border-t border-base-200 relative overflow-hidden">
        {{-- Decoration Gradient --}}
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 blur-[100px] rounded-full pointer-events-none -z-10 translate-x-1/2 -translate-y-1/2">
        </div>

        <div class="max-w-3xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-base-content mb-4 tracking-tight">{{ __('Pertanyaan Umum') }}</h2>
                <p class="text-lg text-base-content/60">
                    {{ __('Informasi penting seputar pendataan dan pendaftaran PSE.') }}
                </p>
            </div>

            <div class="flex flex-col gap-4">
                {{-- FAQ 1 --}}
                <div
                    class="group collapse collapse-plus bg-base-100/50 backdrop-blur-sm border border-base-100 rounded-2xl hover:border-primary/30 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <input type="radio" name="faq-accordion" checked="checked" />
                    <div class="collapse-title text-lg font-medium group-hover:text-primary transition-colors py-4">
                        {{ __('Siapa yang wajib mendaftar di sistem ini?') }}
                    </div>
                    <div class="collapse-content text-base-content/70 leading-relaxed">
                        <p>{{ __('Seluruh Perangkat Daerah (OPD) di Pemerintah Kota Batam yang memiliki, mengelola, atau memanfaatkan aplikasi/sistem elektronik untuk pelayanan publik maupun administrasi pemerintahan.') }}
                        </p>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div
                    class="group collapse collapse-plus bg-base-100/50 backdrop-blur-sm border border-base-100 rounded-2xl hover:border-primary/30 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <input type="radio" name="faq-accordion" />
                    <div class="collapse-title text-lg font-medium group-hover:text-primary transition-colors py-4">
                        {{ __('Apa dokumen yang perlu disiapkan?') }}
                    </div>
                    <div class="collapse-content text-base-content/70 leading-relaxed">
                        <p>{{ __('Dokumen utama yang wajib disiapkan adalah Surat Tugas dari Kepala OPD yang menyatakan bahwa petugas berwenang untuk melakukan pendataan PSE, pengajuan subdomain, dan hosting.') }}
                        </p>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div
                    class="group collapse collapse-plus bg-base-100/50 backdrop-blur-sm border border-base-100 rounded-2xl hover:border-primary/30 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <input type="radio" name="faq-accordion" />
                    <div class="collapse-title text-lg font-medium group-hover:text-primary transition-colors py-4">
                        {{ __('Bagaimana dengan subdomain dan hosting?') }}
                    </div>
                    <div class="collapse-content text-base-content/70 leading-relaxed">
                        <p>{{ __('Sistem ini juga memfasilitasi pengajuan subdomain resmi (batam.go.id) dan permintaan hosting/server yang dikelola oleh Diskominfo Kota Batam. Anda dapat mengajukannya setelah data PSE terdaftar.') }}
                        </p>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div
                    class="group collapse collapse-plus bg-base-100/50 backdrop-blur-sm border border-base-100 rounded-2xl hover:border-primary/30 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <input type="radio" name="faq-accordion" />
                    <div class="collapse-title text-lg font-medium group-hover:text-primary transition-colors py-4">
                        {{ __('Apakah ada batas waktu pendaftaran?') }}
                    </div>
                    <div class="collapse-content text-base-content/70 leading-relaxed">
                        <p>{{ __('Sesuai amanat Permenkomdigi, pendataan ini bersifat wajib dan harus diselesaikan segera guna pemetaan arsitektur SPBE Nasional. Mohon segera daftarkan sistem Anda secepatnya.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="w-full py-8 border-t border-base-200 bg-base-100 text-center">
        <p class="text-sm text-base-content/50">
            &copy; {{ date('Y') }} {{ __('Pemerintah Kota Batam. All rights reserved.') }}<br>
            <span class="text-xs">{{ __('Mendukung terwujudnya Batam Smart City.') }}</span>
        </p>
    </footer>

</body>

</html>
