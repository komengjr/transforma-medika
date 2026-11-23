<!DOCTYPE html>
<html lang="id" x-data="app()" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT Innoventra Solusi Digital — Ekosistem Solusi Digital Terpadu: Aplikasi Rumah Sakit & Integrasi Medis, Aplikasi Koperasi Digital, HRIS, serta Akuntansi & Keuangan.">
    <meta name="keywords" content="Innoventra, Aplikasi Rumah Sakit, SIMRS, Aplikasi Koperasi, HRIS, Aplikasi Akuntansi, Software Keuangan, ERP Indonesia, Web Developer">
    <meta name="author" content="PT Innoventra Solusi Digital">
    <meta property="og:title" content="PT Innoventra Solusi Digital — Ekosistem Aplikasi Bisnis & Kesehatan">
    <meta property="og:description" content="Transformasi digital menyeluruh untuk Rumah Sakit, Koperasi, Manajemen SDM (HRIS), dan Sistem Akuntansi Keuangan.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.innoventra.my.id">
    <title>PT Innoventra Solusi Digital — Ekosistem Aplikasi Bisnis, Koperasi, HRIS, Keuangan &amp; Kesehatan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232" crossorigin="anonymous"></script>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            transition: background-color .3s, color .3s;
        }

        /* Subtle grid pattern */
        .bg-grid {
            background-size: 40px 40px;
            background-image: radial-gradient(circle, rgba(99, 102, 241, 0.12) 1px, transparent 1px);
        }

        .dark .bg-grid {
            background-image: radial-gradient(circle, rgba(129, 140, 248, 0.1) 1px, transparent 1px);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #4f46e5;
            border-radius: 99px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s cubic-bezier(.4, 0, .2, 1), transform .6s cubic-bezier(.4, 0, .2, 1);
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        .d1 {
            transition-delay: .08s;
        }

        .d2 {
            transition-delay: .16s;
        }

        .d3 {
            transition-delay: .24s;
        }

        .d4 {
            transition-delay: .32s;
        }

        .nl {
            position: relative;
        }

        .nl::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: #4f46e5;
            transition: width .22s cubic-bezier(.4, 0, .2, 1);
        }

        .nl:hover::after,
        .nl.on::after {
            width: 100%;
        }

        .nl.on {
            font-weight: 600;
        }

        .shimmer {
            position: relative;
            overflow: hidden;
        }

        .shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: rgba(255, 255, 255, .2);
            transform: skewX(-20deg);
            transition: left .45s cubic-bezier(.4, 0, .2, 1);
        }

        .shimmer:hover::after {
            left: 160%;
        }

        .pf {
            overflow: hidden;
            background: #1e293b;
        }

        .pf img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card-h {
            transition: transform .3s cubic-bezier(.4, 0, .2, 1), box-shadow .3s, border-color .2s;
        }

        .card-h:hover {
            transform: translateY(-5px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- ═══ NAVBAR ═══ -->
    <header class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="sc ? 'bg-white/90 dark:bg-slate-950/90 backdrop-blur-md border-b border-slate-200/70 dark:border-slate-800/80 shadow-sm' : ''">
        <nav class="max-w-7xl mx-auto px-6 h-18 py-4 flex items-center justify-between" aria-label="Main navigation">

            <a href="#hero" class="font-display font-extrabold text-xl tracking-tight relative z-10 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-500/30">IN</span>
                <div>
                    <span class="text-slate-900 dark:text-white">INNOVENTRA</span><span class="text-indigo-600 dark:text-indigo-400">DIGITAL</span>
                </div>
            </a>

            <ul class="hidden lg:flex items-center gap-7 text-sm font-medium" role="list">
                <li><a href="#solutions" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors" :class="s==='solutions'?'on !text-indigo-600 dark:!text-indigo-400':''">Produk Aplikasi</a></li>
                <li><a href="#services" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors" :class="s==='services'?'on !text-indigo-600 dark:!text-indigo-400':''">Layanan</a></li>
                <li><a href="#about" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors" :class="s==='about'?'on !text-indigo-600 dark:!text-indigo-400':''">Tentang Kami</a></li>
                <li><a href="#process" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors" :class="s==='process'?'on !text-indigo-600 dark:!text-indigo-400':''">Alur Kerja</a></li>
                <li><a href="{{ route('blog.index') }}" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">Blog &amp; Info</a></li>
                <li><a href="#contact" class="nl text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors" :class="s==='contact'?'on !text-indigo-600 dark:!text-indigo-400':''">Kontak</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <button @click="dark=!dark" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" :aria-label="dark?'Light mode':'Dark mode'">
                    <svg x-show="!dark" class="w-4 h-4 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <svg x-show="dark" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>
                <a href="/login" class="hidden md:inline-flex items-center gap-2 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-sm font-medium px-4 py-2 rounded-xl hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    Portal Klien
                </a>
                <a href="#contact" class="hidden md:inline-flex items-center gap-2 shimmer bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-all shadow-md shadow-indigo-600/20">
                    Konsultasi Gratis
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <button @click="mm=!mm" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900" :aria-expanded="mm" aria-label="Toggle menu">
                    <svg x-show="!mm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mm" x-cloak
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 shadow-xl">
            <ul class="flex flex-col px-6 py-5 gap-4 text-sm font-medium" role="list">
                <li><a href="#solutions" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Produk Aplikasi</a></li>
                <li><a href="#services" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Layanan</a></li>
                <li><a href="#about" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Tentang Kami</a></li>
                <li><a href="#process" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Alur Kerja</a></li>
                <li><a href="{{ route('blog.index') }}" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Blog &amp; Info</a></li>
                <li><a href="#contact" @click="mm=false" class="block text-slate-700 dark:text-slate-300 hover:text-indigo-600">Kontak</a></li>
                <li class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2.5">
                    <a href="/login" class="inline-flex items-center justify-center border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-medium text-sm px-5 py-2.5 rounded-xl">Portal Klien</a>
                    <a href="#contact" @click="mm=false" class="inline-flex items-center justify-center shimmer bg-indigo-600 text-white font-medium text-sm px-5 py-2.5 rounded-xl">Konsultasi Gratis →</a>
                </li>
            </ul>
        </div>
    </header>

    <main>

        <!-- ═══ HERO SECTION ═══ -->
        <section id="hero" class="relative min-h-screen flex items-center pt-20 overflow-hidden bg-grid bg-gradient-to-b from-indigo-50/70 via-white to-slate-50 dark:from-slate-950 dark:via-slate-900/60 dark:to-slate-950">
            <div class="absolute top-20 right-10 w-[28rem] h-[28rem] bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 w-full">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7">
                        <div class="reveal inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-100/80 dark:bg-indigo-950/80 border border-indigo-200 dark:border-indigo-800/60 text-indigo-700 dark:text-indigo-300 text-xs font-semibold mb-6">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Enterprise Software &amp; Healthcare Interoperability
                        </div>
                        <h1 class="reveal d1 font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl leading-[1.12] tracking-tight text-slate-900 dark:text-white mb-6">
                            Satu Ekosistem Digital untuk <span class="bg-gradient-to-r from-indigo-600 via-blue-600 to-emerald-500 bg-clip-text text-transparent">Bisnis &amp; Kesehatan</span> Modern
                        </h1>
                        <p class="reveal d2 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl mb-8">
                            <strong>PT Innoventra Solusi Digital</strong> menghadirkan rangkaian perangkat lunak terintegrasi mulai dari <strong>Sistem Rumah Sakit (SIMRS &amp; Alat Medis)</strong>, <strong>Aplikasi Koperasi Digital</strong>, <strong>Manajemen SDM (HRIS)</strong>, hingga <strong>Akuntansi &amp; Keuangan</strong>.
                        </p>

                        <!-- Quick Pill Modules -->
                        <div class="reveal d2 flex flex-wrap gap-2 mb-9">
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> SIMRS &amp; Medis
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Koperasi Digital
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-violet-500"></span> Human Resource (HRIS)
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Akuntansi &amp; Keuangan
                            </span>
                        </div>

                        <div class="reveal d3 flex flex-wrap gap-4">
                            <a href="#solutions" class="shimmer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-7 py-3.5 rounded-xl transition-all text-sm shadow-lg shadow-indigo-600/25">
                                Eksplorasi Aplikasi
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <a href="#contact" class="inline-flex items-center gap-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 font-semibold px-7 py-3.5 rounded-xl hover:border-indigo-500 transition-colors text-sm">
                                Jadwalkan Demo
                            </a>
                        </div>
                    </div>

                    <!-- Hero Visual Card -->
                    <div class="lg:col-span-5 reveal d2">
                        <div class="relative rounded-3xl bg-slate-900 p-6 border border-slate-800 shadow-2xl text-white">
                            <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                </div>
                                <span class="text-[11px] font-mono text-slate-400">INNOVENTRA SUITE v4.0</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3.5 mb-5">
                                <div @click="openModal('innohealth')" class="cursor-pointer p-4 rounded-2xl bg-slate-800/80 hover:bg-sky-950/60 border border-slate-700/80 hover:border-sky-500/50 transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    <p class="font-display font-bold text-sm text-white">InnoHealth</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">SIMRS &amp; Alat Medis</p>
                                </div>

                                <div @click="openModal('innocoop')" class="cursor-pointer p-4 rounded-2xl bg-slate-800/80 hover:bg-emerald-950/60 border border-slate-700/80 hover:border-emerald-500/50 transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="font-display font-bold text-sm text-white">InnoCoop</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Koperasi Simpan Pinjam</p>
                                </div>

                                <div @click="openModal('innohr')" class="cursor-pointer p-4 rounded-2xl bg-slate-800/80 hover:bg-violet-950/60 border border-slate-700/80 hover:border-violet-500/50 transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-violet-500/20 text-violet-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                    </div>
                                    <p class="font-display font-bold text-sm text-white">InnoHR</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Payroll, Absensi &amp; KPI</p>
                                </div>

                                <div @click="openModal('innofinance')" class="cursor-pointer p-4 rounded-2xl bg-slate-800/80 hover:bg-amber-950/60 border border-slate-700/80 hover:border-amber-500/50 transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-display font-bold text-sm text-white">InnoFinance</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Akuntansi &amp; Laporan</p>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-xl bg-indigo-950/60 border border-indigo-500/30 flex items-center justify-between text-xs">
                                <span class="text-indigo-200">Klik modul di atas untuk melihat simulasi UI</span>
                                <span class="text-emerald-400 font-semibold">● Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ PRODUK APLIKASI UNGGULAN (4 PILAR UTAMA) ═══ -->
        <section id="solutions" class="py-24 bg-white dark:bg-slate-950 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div>
                        <p class="reveal text-xs font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Ekosistem Perangkat Lunak</p>
                        <h2 class="reveal d1 font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white">Produk Aplikasi Kami</h2>
                    </div>

                    <!-- Filter Kategori Interaktif -->
                    <div class="reveal d1 flex flex-wrap gap-2">
                        <button @click="filter='all'" :class="filter==='all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all">Semua Sistem</button>
                        <button @click="filter='medis'" :class="filter==='medis' ? 'bg-sky-600 text-white shadow-md shadow-sky-600/20' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all">Rumah Sakit</button>
                        <button @click="filter='koperasi'" :class="filter==='koperasi' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all">Koperasi</button>
                        <button @click="filter='hr'" :class="filter==='hr' ? 'bg-violet-600 text-white shadow-md shadow-violet-600/20' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all">Human Resource</button>
                        <button @click="filter='finance'" :class="filter==='finance' ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all">Akuntansi &amp; Keuangan</button>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    <!-- 1. APLIKASI RUMAH SAKIT & MEDIS -->
                    <article x-show="filter==='all' || filter==='medis'" x-transition @click="openModal('innohealth')" class="card-h group cursor-pointer rounded-3xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-sky-500 shadow-sm flex flex-col">
                        <div class="pf w-full h-56 relative">
                            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?w=900&q=80" alt="InnoHealth SIMRS & Medical Integration" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent flex items-end justify-between p-6">
                                <span class="bg-sky-500 text-white text-xs font-bold px-3 py-1 rounded-lg shadow">Healthcare &amp; SIMRS</span>
                                <span class="bg-white/95 dark:bg-slate-900/95 text-sky-600 dark:text-sky-400 text-xs font-semibold px-3.5 py-1.5 rounded-full shadow">Simulasi PACS Viewer →</span>
                            </div>
                        </div>
                        <div class="p-7 flex-grow flex flex-col">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-[11px] font-medium bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 px-2.5 py-1 rounded-md">SIMRS &amp; RME</span>
                                <span class="text-[11px] font-medium bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 px-2.5 py-1 rounded-md">Orthanc PACS / DICOM</span>
                                <span class="text-[11px] font-medium bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 px-2.5 py-1 rounded-md">Bridging LIS &amp; BPJS</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-slate-900 dark:text-white mb-2 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">InnoHealth — Sistem Rumah Sakit &amp; Integrasi Medis</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                                Solusi manajemen rumah sakit dan klinik terpadu lengkap dengan <strong>Interoperability Hub</strong> untuk menghubungkan alat Radiologi (CT-Scan, X-Ray, USG), Laboratorium (Analyzer HL7), dan Bedside Monitor langsung ke Rekam Medis Elektronik.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-semibold text-sky-600 dark:text-sky-400">
                                <span>Lihat Detail &amp; Simulasi Web Viewer</span>
                                <span>↗</span>
                            </div>
                        </div>
                    </article>

                    <!-- 2. APLIKASI KOPERASI DIGITAL -->
                    <article x-show="filter==='all' || filter==='koperasi'" x-transition @click="openModal('innocoop')" class="card-h group cursor-pointer rounded-3xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 shadow-sm flex flex-col">
                        <div class="pf w-full h-56 relative">
                            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=900&q=80" alt="InnoCoop Aplikasi Koperasi Digital" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent flex items-end justify-between p-6">
                                <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-lg shadow">Koperasi &amp; Microfinance</span>
                                <span class="bg-white/95 dark:bg-slate-900/95 text-emerald-600 dark:text-emerald-400 text-xs font-semibold px-3.5 py-1.5 rounded-full shadow">Simulasi Koperasi →</span>
                            </div>
                        </div>
                        <div class="p-7 flex-grow flex flex-col">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-[11px] font-medium bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 px-2.5 py-1 rounded-md">Simpan Pinjam</span>
                                <span class="text-[11px] font-medium bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 px-2.5 py-1 rounded-md">Hitung SHU Otomatis</span>
                                <span class="text-[11px] font-medium bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 px-2.5 py-1 rounded-md">Mobile Anggota &amp; PPOB</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-slate-900 dark:text-white mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">InnoCoop — Aplikasi Koperasi Modern &amp; Simpan Pinjam</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                                Digitalisasi operasional koperasi simpan pinjam, koperasi karyawan, hingga koperasi serba usaha. Dilengkapi manajemen simpanan pokok/wajib/sukarela, simulasi kredit &amp; angsuran, pembagian SHU otomatis, serta aplikasi mobile untuk anggota.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                <span>Lihat Detail &amp; Simulasi Dashboard</span>
                                <span>↗</span>
                            </div>
                        </div>
                    </article>

                    <!-- 3. APLIKASI HUMAN RESOURCE (HRIS) -->
                    <article x-show="filter==='all' || filter==='hr'" x-transition @click="openModal('innohr')" class="card-h group cursor-pointer rounded-3xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-violet-500 shadow-sm flex flex-col">
                        <div class="pf w-full h-56 relative">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&q=80" alt="InnoHR Sistem Human Resource" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent flex items-end justify-between p-6">
                                <span class="bg-violet-600 text-white text-xs font-bold px-3 py-1 rounded-lg shadow">HRIS &amp; Payroll</span>
                                <span class="bg-white/95 dark:bg-slate-900/95 text-violet-600 dark:text-violet-400 text-xs font-semibold px-3.5 py-1.5 rounded-full shadow">Simulasi HRIS →</span>
                            </div>
                        </div>
                        <div class="p-7 flex-grow flex flex-col">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-[11px] font-medium bg-violet-100 dark:bg-violet-950 text-violet-700 dark:text-violet-300 px-2.5 py-1 rounded-md">Absensi GPS &amp; Face</span>
                                <span class="text-[11px] font-medium bg-violet-100 dark:bg-violet-950 text-violet-700 dark:text-violet-300 px-2.5 py-1 rounded-md">Payroll &amp; PPh 21 / BPJS</span>
                                <span class="text-[11px] font-medium bg-violet-100 dark:bg-violet-950 text-violet-700 dark:text-violet-300 px-2.5 py-1 rounded-md">Manajemen Shift &amp; KPI</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-slate-900 dark:text-white mb-2 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">InnoHR — Sistem Manajemen SDM &amp; Penggajian</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                                Otomatisasi administrasi HR dari rekrutmen hingga penggajian. Mendukung presensi berbasis lokasi (Geofencing) &amp; wajah, pengajuan cuti/lembur online, pengaturan jadwal shift dinamis, kalkulasi PPh 21 &amp; BPJS, serta penilaian kinerja (KPI).
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-semibold text-violet-600 dark:text-violet-400">
                                <span>Lihat Detail &amp; Simulasi HRIS</span>
                                <span>↗</span>
                            </div>
                        </div>
                    </article>

                    <!-- 4. APLIKASI AKUNTANSI & KEUANGAN -->
                    <article x-show="filter==='all' || filter==='finance'" x-transition @click="openModal('innofinance')" class="card-h group cursor-pointer rounded-3xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-amber-500 shadow-sm flex flex-col">
                        <div class="pf w-full h-56 relative">
                            <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=900&q=80" alt="InnoFinance Aplikasi Akuntansi dan Keuangan" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent flex items-end justify-between p-6">
                                <span class="bg-amber-500 text-slate-950 text-xs font-bold px-3 py-1 rounded-lg shadow">Accounting &amp; Finance</span>
                                <span class="bg-white/95 dark:bg-slate-900/95 text-amber-600 dark:text-amber-400 text-xs font-semibold px-3.5 py-1.5 rounded-full shadow">Simulasi Keuangan →</span>
                            </div>
                        </div>
                        <div class="p-7 flex-grow flex flex-col">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-[11px] font-medium bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 px-2.5 py-1 rounded-md">Jurnal Umum Otomatis</span>
                                <span class="text-[11px] font-medium bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 px-2.5 py-1 rounded-md">Neraca &amp; Laba Rugi</span>
                                <span class="text-[11px] font-medium bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 px-2.5 py-1 rounded-md">Multi-Cabang &amp; Aset</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-slate-900 dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">InnoFinance — Aplikasi Akuntansi &amp; Keuangan Terpadu</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                                Pencatatan pembukuan bisnis sesuai standar akuntansi (PSAK). Mengelola faktur penjualan &amp; pembelian, utang-piutang (AP/AR), rekonsiliasi bank, penyusutan aset tetap, anggaran (budgeting), hingga laporan Laba Rugi dan Arus Kas real-time.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-semibold text-amber-600 dark:text-amber-400">
                                <span>Lihat Detail &amp; Simulasi Akuntansi</span>
                                <span>↗</span>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- ═══ LAYANAN SPESIALIS ═══ -->
        <section id="services" class="py-24 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="mb-14">
                    <p class="reveal text-xs font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Kapabilitas Teknologi</p>
                    <h2 class="reveal d1 font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white">Layanan Pengembangan &amp; Integrasi</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-6">

                    <article class="reveal d1 card-h group bg-white dark:bg-slate-900 rounded-2xl p-8 border border-slate-200 dark:border-slate-800 hover:border-indigo-500 shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-50 dark:bg-indigo-950 rounded-xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all text-indigo-600 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900 dark:text-white mb-3">Custom ERP &amp; Enterprise App</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Pengembangan sistem informasi khusus sesuai SOP perusahaan Anda: Koperasi, HRIS, Akuntansi, Manajemen Aset, POS, dan Gudang/Logistik.</p>
                    </article>

                    <article class="reveal d2 card-h group bg-slate-900 dark:bg-indigo-950/40 text-white rounded-2xl p-8 border border-slate-800 dark:border-indigo-800/60 hover:border-indigo-400 shadow-lg">
                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-600/30 rounded-xl mb-6 group-hover:bg-indigo-600 transition-colors text-indigo-300 group-hover:text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-white mb-3">Interoperabilitas Sistem &amp; Medis</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">Bridging API antar-platform (Payment Gateway, Perbankan, SatuSehat, BPJS) serta interkoneksi alat kesehatan (DICOM, HL7, LIS, PACS) ke SIMRS.</p>
                    </article>

                    <article class="reveal d3 card-h group bg-white dark:bg-slate-900 rounded-2xl p-8 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center bg-emerald-50 dark:bg-emerald-950 rounded-xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all text-emerald-600 dark:text-emerald-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900 dark:text-white mb-3">Web Portal &amp; Aplikasi Mobile</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Pembuatan portal korporasi, platform e-commerce, dan aplikasi pendamping berbasis Android/iOS untuk anggota koperasi, karyawan, maupun pasien.</p>
                    </article>

                </div>
            </div>
        </section>

        <!-- ═══ ABOUT ═══ -->
        <section id="about" class="py-24 bg-white dark:bg-slate-950 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="reveal order-2 lg:order-1">
                        <div class="relative max-w-md mx-auto">
                            <div class="pf w-full aspect-[4/3] rounded-3xl shadow-2xl ring-1 ring-slate-200 dark:ring-slate-800">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80" alt="Tim PT Innoventra Solusi Digital" loading="lazy">
                            </div>
                            <div class="absolute -bottom-6 -right-4 sm:-right-6 bg-white dark:bg-slate-900 p-5 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-display font-extrabold text-lg">100%</div>
                                    <div>
                                        <p class="font-display font-bold text-sm text-slate-900 dark:text-white">Arsitektur Modular</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Terintegrasi antar-divisi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <p class="reveal text-xs font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Tentang Perusahaan</p>
                        <h2 class="reveal d1 font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white leading-tight mb-6">Mitra Transformasi Digital Lintas Sektor</h2>
                        <p class="reveal d2 text-slate-600 dark:text-slate-300 leading-relaxed mb-4">
                            <strong>PT INNOVENTRA SOLUSI DIGITAL</strong> adalah perusahaan teknologi informasi yang merancang ekosistem perangkat lunak terpadu untuk berbagai sektor—mulai dari <strong>Koperasi &amp; Lembaga Keuangan Mikro</strong>, <strong>Perusahaan Korporasi (HRIS &amp; Akuntansi)</strong>, hingga <strong>Rumah Sakit &amp; Fasilitas Kesehatan</strong>.
                        </p>
                        <p class="reveal d3 text-slate-600 dark:text-slate-300 leading-relaxed mb-7">
                            Kami percaya setiap organisasi membutuhkan sistem yang saling terhubung: data absensi karyawan otomatis masuk ke penggajian, transaksi koperasi dan rumah sakit langsung tercatat ke jurnal akuntansi, tanpa input berulang.
                        </p>
                        <div class="reveal d4 grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-slate-200 dark:border-slate-800">
                            <div>
                                <p class="font-display font-extrabold text-2xl text-indigo-600 dark:text-indigo-400">&lt; 2s</p>
                                <p class="text-xs text-slate-500 mt-1">Respon Sistem</p>
                            </div>
                            <div>
                                <p class="font-display font-extrabold text-2xl text-emerald-600 dark:text-emerald-400">24/7</p>
                                <p class="text-xs text-slate-500 mt-1">Dukungan Teknis</p>
                            </div>
                            <div>
                                <p class="font-display font-extrabold text-2xl text-violet-600 dark:text-violet-400">API</p>
                                <p class="text-xs text-slate-500 mt-1">Siap Integrasi</p>
                            </div>
                            <div>
                                <p class="font-display font-extrabold text-2xl text-amber-600 dark:text-amber-400">SSL</p>
                                <p class="text-xs text-slate-500 mt-1">Enkripsi Berlapis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ PROCESS ═══ -->
        <section id="process" class="py-24 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="mb-14">
                    <p class="reveal text-xs font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Metodologi Implementasi</p>
                    <h2 class="reveal d1 font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white">Tahapan &amp; Alur Kerja</h2>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <article class="reveal d1 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                        <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-display font-bold text-sm flex items-center justify-center mb-4">01</span>
                        <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-2">Analisis Proses Bisnis</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pemetaan alur kerja koperasi, struktur penggajian HR, bagan akun keuangan, maupun alur pelayanan medis.</p>
                    </article>
                    <article class="reveal d2 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                        <span class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-display font-bold text-sm flex items-center justify-center mb-4">02</span>
                        <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-2">Desain &amp; Arsitektur</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Perancangan antarmuka intuitif (UI/UX) dan skema database terintegrasi antar-modul.</p>
                    </article>
                    <article class="reveal d3 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                        <span class="w-10 h-10 rounded-xl bg-violet-600 text-white font-display font-bold text-sm flex items-center justify-center mb-4">03</span>
                        <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-2">Pengembangan &amp; Bridging</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pengodean aplikasi, integrasi payment gateway/perbankan, serta bridging alat medis.</p>
                    </article>
                    <article class="reveal d4 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                        <span class="w-10 h-10 rounded-xl bg-amber-600 text-white font-display font-bold text-sm flex items-center justify-center mb-4">04</span>
                        <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white mb-2">Pelatihan &amp; Go-Live</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Migrasi data awal, pelatihan operator/admin, uji coba menyeluruh, dan pendampingan penuh.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ═══ BLOG & INFORMASI ═══ -->
        <section id="blog" class="py-24 bg-white dark:bg-slate-950 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-14">
                    <div>
                        <p class="reveal text-xs font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Wawasan &amp; Edukasi</p>
                        <h2 class="reveal d1 font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white">Artikel &amp; Informasi Terbaru</h2>
                    </div>
                    <a href="{{ route('blog.index') }}" class="reveal d1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors self-start sm:self-auto nl">
                        Lihat Semua Artikel →
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @if(isset($latest_blogs) && $latest_blogs->count() > 0)
                    @foreach($latest_blogs as $blog)
                    <article class="reveal card-h flex flex-col group cursor-pointer rounded-2xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-indigo-500 shadow-sm relative transition-all duration-300">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="pf w-full h-48 relative overflow-hidden block">
                            @if($blog->thumbnail)
                            <img src="{{ route('blog.image', ['filename' => basename($blog->thumbnail)]) }}" alt="{{ $blog->title }}" class="group-hover:scale-105 transition-transform duration-500">
                            @else
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80" alt="{{ $blog->title }}" class="group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-semibold bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-lg">Wawasan</span>
                                <div class="flex items-center text-xs text-slate-500 gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ number_format($blog->views) }} Views
                                </div>
                            </div>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="block mb-2">
                                <h3 class="font-display font-bold text-lg text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                            </a>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 120, '...') }}
                            </p>
                            <div class="mt-auto flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 pt-4 border-t border-slate-200 dark:border-slate-800">
                                <span>{{ $blog->created_at->translatedFormat('d M Y') }}</span>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                    @else
                    <div class="col-span-3 text-center py-12 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800">
                        <h3 class="font-display font-bold text-xl text-slate-900 dark:text-white mb-2">Belum ada artikel terbaru</h3>
                        <p class="text-slate-500 text-sm">Artikel seputar digitalisasi koperasi, HRIS, keuangan, dan kesehatan akan segera hadir.</p>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- ═══ CONTACT SECTION ═══ -->
        <section id="contact" class="py-24 bg-slate-50 dark:bg-slate-950 border-t border-slate-200/60 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-slate-900 rounded-3xl p-8 sm:p-12 lg:p-16 relative overflow-hidden shadow-2xl border border-slate-800">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 grid lg:grid-cols-2 gap-12 items-start">
                        <div>
                            <p class="reveal text-xs font-bold text-indigo-400 tracking-widest uppercase mb-3">Konsultasi &amp; Demo Gratis</p>
                            <h2 class="reveal d1 font-display font-extrabold text-3xl sm:text-5xl text-white leading-tight mb-5">Siap Mendigitalkan Operasional Anda?</h2>
                            <p class="reveal d2 text-slate-300 leading-relaxed mb-8">Diskusikan kebutuhan sistem Rumah Sakit, Koperasi Digital, Manajemen SDM (HRIS), maupun Akuntansi &amp; Keuangan bersama tim konsultan kami.</p>

                            <div class="reveal d3 flex flex-col gap-4">
                                <div class="flex items-start gap-3.5 text-slate-300">
                                    <span class="w-10 h-10 flex items-center justify-center bg-slate-800 border border-slate-700 rounded-xl shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm leading-relaxed">Pal Sembilan, Kec. Sungai Kakap, Kab. Kubu Raya, Kalimantan Barat</span>
                                </div>
                                <a href="tel:+6285756100160" class="group flex items-center gap-3.5 text-slate-300 hover:text-white transition-colors">
                                    <span class="w-10 h-10 flex items-center justify-center bg-slate-800 border border-slate-700 rounded-xl group-hover:border-indigo-500 transition-colors shrink-0">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">+62 857-5610-0160 (Telepon / WhatsApp)</span>
                                </a>
                                <a href="mailto:info@innoventra.my.id" class="group flex items-center gap-3.5 text-slate-300 hover:text-white transition-colors">
                                    <span class="w-10 h-10 flex items-center justify-center bg-slate-800 border border-slate-700 rounded-xl group-hover:border-indigo-500 transition-colors shrink-0">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">info@innoventra.my.id</span>
                                </a>
                            </div>
                        </div>

                        <div class="reveal d2 bg-slate-950/60 p-6 sm:p-8 rounded-2xl border border-slate-800">
                            <form action="{{ route('consultation.store') ?? '#' }}" method="POST">
                                @csrf
                                <div class="flex flex-col gap-4">
                                    @if(session('success'))
                                    <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 text-xs p-3.5 rounded-xl">
                                        {{ session('success') }}
                                    </div>
                                    @endif

                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="fname" class="block text-xs font-medium text-slate-300 mb-1.5">Nama Lengkap *</label>
                                            <input type="text" id="fname" name="name" placeholder="Nama Anda / Instansi" required autocomplete="name"
                                                class="w-full bg-slate-900 border border-slate-700 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <label for="femail" class="block text-xs font-medium text-slate-300 mb-1.5">Email / No. WhatsApp *</label>
                                            <input type="text" id="femail" name="contact" placeholder="08xx / email@domain.com" required
                                                class="w-full bg-slate-900 border border-slate-700 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="fsubject" class="block text-xs font-medium text-slate-300 mb-1.5">Aplikasi / Solusi yang Diminati</label>
                                        <select id="fsubject" name="subject" class="w-full bg-slate-900 border border-slate-700 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
                                            <option value="medis">Aplikasi Rumah Sakit (SIMRS &amp; Integrasi Alat Medis)</option>
                                            <option value="koperasi">Aplikasi Koperasi Digital &amp; Simpan Pinjam</option>
                                            <option value="hris">Aplikasi Human Resource (HRIS &amp; Payroll)</option>
                                            <option value="akuntansi">Aplikasi Akuntansi &amp; Keuangan</option>
                                            <option value="erp">Paket Bundling Enterprise / Custom App</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="fmessage" class="block text-xs font-medium text-slate-300 mb-1.5">Detail Kebutuhan *</label>
                                        <textarea id="fmessage" name="message" rows="4" placeholder="Ceritakan kebutuhan sistem, jumlah cabang/anggota/karyawan, atau rencana integrasi..." required
                                            class="w-full bg-slate-900 border border-slate-700 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors resize-none"></textarea>
                                    </div>
                                    <button type="submit" class="shimmer w-full bg-indigo-600 hover:bg-indigo-700 text-white font-display font-bold text-sm py-3.5 rounded-xl transition-all shadow-lg shadow-indigo-600/30">
                                        Kirim Permintaan Konsultasi →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ═══ INTERACTIVE MODAL SIMULATOR UNTUK MASING-MASING APLIKASI ═══ -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeModal()" class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity"></div>

        <div class="flex min-h-screen items-center justify-center p-3 sm:p-6 text-center">
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">

                <button @click="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white z-30 w-9 h-9 flex items-center justify-center rounded-full bg-slate-800/90 hover:bg-slate-700 transition-colors border border-slate-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <template x-if="activeFeature">
                    <div>
                        <!-- Header & Interactive Preview Screen -->
                        <div class="p-6 md:p-8 bg-slate-950 text-white relative overflow-hidden border-b border-slate-800">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                <span class="inline-block text-xs font-bold px-3 py-1 rounded-lg" :class="activeFeature.badgeClass" x-text="activeFeature.badge"></span>
                                <span class="text-[11px] font-mono text-emerald-400 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Live Interactive Preview
                                </span>
                            </div>
                            <h3 class="font-display font-extrabold text-2xl md:text-3xl text-white mb-1.5" x-text="activeFeature.title"></h3>
                            <p class="text-xs md:text-sm text-slate-400 leading-relaxed mb-6" x-text="activeFeature.subtitle"></p>

                            <!-- PREVIEW 1: RUMAH SAKIT (INNOHEALTH) -->
                            <template x-if="activeModal === 'innohealth'">
                                <div class="bg-slate-900 rounded-2xl border border-sky-500/30 overflow-hidden shadow-xl">
                                    <div class="bg-slate-950 px-4 py-2.5 border-b border-slate-800 flex items-center justify-between text-xs font-mono">
                                        <span class="text-sky-400 font-bold">OHIF DICOM Web Viewer &amp; SIMRS Bridge</span>
                                        <span class="text-emerald-400">HL7 / PACS Connected</span>
                                    </div>
                                    <div class="grid md:grid-cols-3 p-5 gap-4 items-center bg-black/60">
                                        <div class="md:col-span-2 flex items-center justify-center p-4 bg-slate-950 rounded-xl border border-slate-800 relative">
                                            <div class="text-left text-[10px] font-mono text-sky-300 space-y-1 mr-6">
                                                <p><span class="text-slate-500">NO. RM:</span> 00-48-92-11</p>
                                                <p><span class="text-slate-500">MODALITY:</span> CT-SCAN THORAX</p>
                                                <p><span class="text-slate-500">STATUS:</span> TERKIRIM KE EMR</p>
                                            </div>
                                            <div class="w-28 h-28 rounded-full border-2 border-dashed border-sky-500/50 flex items-center justify-center bg-sky-950/30">
                                                <span class="text-[10px] font-mono text-sky-300 font-bold animate-pulse">DICOM #24</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2 text-xs font-mono">
                                            <div class="p-2.5 rounded-lg bg-sky-950/60 border border-sky-500/40 text-sky-200">✓ Radiologi PACS Sync</div>
                                            <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300">✓ Lab Analyzer Auto-Result</div>
                                            <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300">✓ SatuSehat &amp; V-Claim</div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- PREVIEW 2: KOPERASI (INNOCOOP) -->
                            <template x-if="activeModal === 'innocoop'">
                                <div class="bg-slate-900 rounded-2xl border border-emerald-500/30 overflow-hidden shadow-xl p-5">
                                    <div class="grid grid-cols-3 gap-3 mb-4">
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Total Simpanan Anggota</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-emerald-400 mt-1">Rp 4.820.500.000</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Pinjaman Aktif</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-white mt-1">Rp 3.150.000.000</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Estimasi SHU Berjalan</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-amber-400 mt-1">Rp 412.800.000</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-[11px] font-mono">
                                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300">✓ Auto-Debet Angsuran</span>
                                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300">✓ Virtual Account Anggota</span>
                                        <span class="px-2.5 py-1 rounded bg-emerald-500/20 text-emerald-300">✓ Laporan RAT Otomatis</span>
                                    </div>
                                </div>
                            </template>

                            <!-- PREVIEW 3: HUMAN RESOURCE (INNOHR) -->
                            <template x-if="activeModal === 'innohr'">
                                <div class="bg-slate-900 rounded-2xl border border-violet-500/30 overflow-hidden shadow-xl p-5">
                                    <div class="grid grid-cols-3 gap-3 mb-4">
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Kehadiran Hari Ini</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-violet-400 mt-1">98.4% (246/250)</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Status Payroll Bulan Ini</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-emerald-400 mt-1">Siap Disburse</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Rata-rata Skor KPI</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-white mt-1">4.6 / 5.0</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-[11px] font-mono">
                                        <span class="px-2.5 py-1 rounded bg-violet-500/20 text-violet-300">✓ Selfie &amp; GPS Geofencing</span>
                                        <span class="px-2.5 py-1 rounded bg-violet-500/20 text-violet-300">✓ Hitung PPh 21 TER &amp; BPJS</span>
                                        <span class="px-2.5 py-1 rounded bg-violet-500/20 text-violet-300">✓ Slip Gaji Digital</span>
                                    </div>
                                </div>
                            </template>

                            <!-- PREVIEW 4: AKUNTANSI & KEUANGAN (INNOFINANCE) -->
                            <template x-if="activeModal === 'innofinance'">
                                <div class="bg-slate-900 rounded-2xl border border-amber-500/30 overflow-hidden shadow-xl p-5">
                                    <div class="grid grid-cols-3 gap-3 mb-4">
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Pendapatan (MTD)</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-emerald-400 mt-1">Rp 1.450.000.000</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Beban Operasional</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-rose-400 mt-1">Rp 620.300.000</p>
                                        </div>
                                        <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                                            <p class="text-[11px] text-slate-400">Laba Bersih</p>
                                            <p class="font-display font-bold text-base sm:text-lg text-amber-400 mt-1">Rp 829.700.000</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-[11px] font-mono">
                                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300">✓ Neraca &amp; Buku Besar</span>
                                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300">✓ Manajemen Invoice &amp; Faktur</span>
                                        <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-300">✓ Penyusutan Aset Otomatis</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Detail Deskripsi & Fitur -->
                        <div class="p-6 md:p-8 space-y-5 text-slate-700 dark:text-slate-300 text-sm leading-relaxed">
                            <div>
                                <h4 class="font-display font-bold text-xs text-slate-900 dark:text-white uppercase tracking-wider mb-2">Deskripsi Sistem:</h4>
                                <p x-text="activeFeature.description"></p>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-700">
                                <h5 class="font-display font-bold text-xs uppercase text-indigo-600 dark:text-indigo-400 mb-3">Modul &amp; Fitur Utama:</h5>
                                <ul class="grid sm:grid-cols-2 gap-2.5 text-xs text-slate-700 dark:text-slate-300">
                                    <template x-for="item in activeFeature.highlights" :key="item">
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-500 font-bold">✓</span>
                                            <span x-text="item"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Footer Modal -->
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 flex flex-wrap justify-between items-center gap-3">
                            <span class="text-xs text-slate-500">PT Innoventra Solusi Digital</span>
                            <div class="flex items-center gap-3">
                                <a href="#contact" @click="closeModal()" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                                    Minta Demo Aplikasi Ini →
                                </a>
                                <button @click="closeModal()" class="px-4 py-2.5 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-semibold rounded-xl transition-colors">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- ═══ FOOTER ═══ -->
    <footer class="bg-slate-950 text-white border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">IN</span>
                <p class="text-sm text-slate-400">© <span id="yr"></span> <strong class="text-white">PT INNOVENTRA SOLUSI DIGITAL</strong>. All rights reserved.</p>
            </div>
            <p class="text-xs text-slate-500">Kubu Raya, Kalimantan Barat — Indonesia</p>
        </div>
    </footer>

    <script>
        function app() {
            return {
                dark: false,
                mm: false,
                sc: false,
                s: 'hero',
                filter: 'all',
                modalOpen: false,
                activeModal: null,
                activeFeature: null,
                featuresData: {
                    innohealth: {
                        badge: 'Healthcare & Hospital System',
                        badgeClass: 'bg-sky-500/20 text-sky-300 border border-sky-400/30',
                        title: 'InnoHealth — SIMRS & Interoperabilitas Alat Medis',
                        subtitle: 'Sistem Informasi Manajemen Rumah Sakit terintegrasi dengan Orthanc PACS, OHIF Viewer, LIS, dan SatuSehat.',
                        description: 'Dirancang untuk Rumah Sakit, Klinik Utama, dan Laboratorium Diagnostik. Menghubungkan proses pendaftaran pasien, poli rawat jalan, rawat inap, farmasi, kasir, hingga bridging langsung dengan alat kesehatan (Radiologi DICOM, Laboratorium HL7/Serial, dan Bedside Monitor) ke dalam satu Rekam Medis Elektronik (RME).',
                        highlights: [
                            'Rekam Medis Elektronik (RME) terintegrasi SatuSehat & BPJS',
                            'Orthanc PACS & OHIF Web Viewer untuk citra CT-Scan, MRI & X-Ray',
                            'Bridging otomatis alat Laboratorium (LIS) & Elektromedis',
                            'Manajemen Farmasi, Gudang Obat, & Billing Pasien Real-Time'
                        ]
                    },
                    innocoop: {
                        badge: 'Digital Cooperative System',
                        badgeClass: 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30',
                        title: 'InnoCoop — Aplikasi Koperasi Digital Terpadu',
                        subtitle: 'Platform manajemen Koperasi Simpan Pinjam (KSP), Koperasi Karyawan, dan Koperasi Serba Usaha.',
                        description: 'Membantu pengurus koperasi mengelola database anggota, transaksi simpanan (pokok, wajib, sukarela, berjangka), pengajuan dan analisis kelayakan pinjaman, perhitungan bunga (flat/efektif/anuitas), serta pembagian Sisa Hasil Usaha (SHU) secara transparan dan otomatis.',
                        highlights: [
                            'Manajemen Simpanan & Pinjaman multi-akad/skema bunga',
                            'Perhitungan pembagian SHU anggota otomatis & akurat',
                            'Aplikasi Mobile Anggota untuk cek saldo, mutasi & bayar tagihan',
                            'Terintegrasi langsung dengan modul Akuntansi & Laporan RAT'
                        ]
                    },
                    innohr: {
                        badge: 'Human Resource Information System',
                        badgeClass: 'bg-violet-500/20 text-violet-300 border border-violet-400/30',
                        title: 'InnoHR — Aplikasi Human Resource & Payroll',
                        subtitle: 'Otomatisasi pengelolaan SDM, absensi mobile, shift kerja, penilaian KPI, hingga penggajian.',
                        description: 'Memudahkan tim HR mengelola ratusan hingga ribuan karyawan secara efisien. Karyawan dapat melakukan absensi melalui smartphone dengan validasi GPS & pengenalan wajah, mengajukan cuti atau lembur, serta mengunduh slip gaji secara mandiri.',
                        highlights: [
                            'Presensi Mobile dengan GPS Geofencing & Face Recognition',
                            'Pengaturan Jadwal Shift Fleksibel (Cocok untuk RS & Pabrik)',
                            'Kalkulasi Payroll otomatis termasuk PPh 21 (TER) & BPJS',
                            'Manajemen Cuti, Lembur, Klaim Reimbursement & KPI Karyawan'
                        ]
                    },
                    innofinance: {
                        badge: 'Enterprise Accounting & Finance',
                        badgeClass: 'bg-amber-500/20 text-amber-300 border border-amber-400/30',
                        title: 'InnoFinance — Aplikasi Akuntansi & Keuangan',
                        subtitle: 'Sistem pembukuan, manajemen arus kas, utang-piutang, dan pelaporan keuangan standar PSAK.',
                        description: 'Memberikan visibilitas penuh terhadap kesehatan finansial perusahaan. Setiap transaksi operasional dari penjualan, pembelian, kasir, maupun penggajian otomatis membentuk jurnal akuntansi sehingga laporan Neraca dan Laba Rugi dapat dipantau kapan saja.',
                        highlights: [
                            'Jurnal Umum Otomatis & Bagan Akun (COA) fleksibel',
                            'Laporan Keuangan Lengkap: Neraca, Laba Rugi, Arus Kas',
                            'Manajemen Utang-Piutang (AP/AR), Invoicing & Jatuh Tempo',
                            'Konsolidasi Laporan Multi-Cabang & Penyusutan Aset Tetap'
                        ]
                    }
                },

                init() {
                    this.dark = localStorage.getItem('theme') === 'dark' ||
                        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));

                    window.addEventListener('scroll', () => {
                        this.sc = window.scrollY > 20;
                        this.updateSection();
                    }, {
                        passive: true
                    });

                    const io = new IntersectionObserver(entries => {
                        entries.forEach(e => {
                            if (e.isIntersecting) {
                                e.target.classList.add('in');
                                io.unobserve(e.target);
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -40px 0px'
                    });
                    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

                    document.getElementById('yr').textContent = new Date().getFullYear();
                },

                openModal(key) {
                    this.activeModal = key;
                    this.activeFeature = this.featuresData[key];
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                },

                updateSection() {
                    const atBottom = (window.innerHeight + window.scrollY) >= document.body.scrollHeight - 60;
                    if (atBottom) {
                        this.s = 'contact';
                        return;
                    }
                    const ids = ['contact', 'process', 'about', 'services', 'solutions', 'hero'];
                    for (const id of ids) {
                        const el = document.getElementById(id);
                        if (el && window.scrollY >= el.offsetTop - 130) {
                            this.s = id;
                            return;
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>
