<!DOCTYPE html>
<html lang="id" x-data="app()" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT Innoventra Solusi Digital — Solusi Transformasi Digital & Interoperabilitas Sistem Perangkat Kesehatan.">
    <meta name="keywords" content="Innoventra, Transformasi Digital, Integrasi Alat Kesehatan, SIMRS, PACS, LIS, Web Developer, Custom App">
    <meta name="author" content="PT Innoventra Solusi Digital">
    <meta property="og:title" content="PT Innoventra Solusi Digital">
    <meta property="og:description" content="Solusi Transformasi Digital & Interoperabilitas Sistem Perangkat Kesehatan Terintegrasi.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.innoventra.my.id">
    <title>PT Innoventra Solusi Digital — Solusi Transformasi Digital &amp; Integrasi Perangkat Kesehatan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        display: ['PT Sans', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    },
                    colors: {
                        accent: '#0284c7',
                        'accent-light': '#38bdf8',
                        'beach-sand': '#f0fdfa'
                    }
                }
            }
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box
        }

        html,
        body {
            font-family: 'DM Sans', sans-serif
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'PT Sans', sans-serif
        }

        body {
            transition: background-color .3s, color .3s
        }

        /* noise overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            opacity: .35;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.05'/%3E%3C/svg%3E")
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 5px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: #0284c7;
            border-radius: 99px
        }

        /* reveal on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity .6s cubic-bezier(.4, 0, .2, 1), transform .6s cubic-bezier(.4, 0, .2, 1)
        }

        .reveal.in {
            opacity: 1;
            transform: none
        }

        .d1 {
            transition-delay: .08s
        }

        .d2 {
            transition-delay: .16s
        }

        .d3 {
            transition-delay: .24s
        }

        .d4 {
            transition-delay: .32s
        }

        /* nav underline animation */
        .nl {
            position: relative
        }

        .nl::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: currentColor;
            transition: width .22s cubic-bezier(.4, 0, .2, 1)
        }

        .nl:hover::after,
        .nl.on::after {
            width: 100%
        }

        .nl.on {
            font-weight: 500
        }

        /* shimmer button */
        .shimmer {
            position: relative;
            overflow: hidden
        }

        .shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: rgba(255, 255, 255, .18);
            transform: skewX(-20deg);
            transition: left .4s cubic-bezier(.4, 0, .2, 1)
        }

        .shimmer:hover::after {
            left: 160%
        }

        /* photo frames */
        .pf {
            overflow: hidden;
            background: #d4d4d8
        }

        .pf img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block
        }

        /* card hover */
        .card-h {
            transition: transform .28s cubic-bezier(.4, 0, .2, 1), border-color .18s
        }

        .card-h:hover {
            transform: translateY(-4px)
        }

        /* skill tag */
        .stag {
            transition: border-color .18s
        }

        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">

    <!-- ═══ NAV ═══ -->
    <header class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="sc?'bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md shadow-sm shadow-black/5':''">
        <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Main navigation">

            <a href="#hero" class="font-display font-bold text-xl tracking-tight relative z-10 flex items-center gap-1">
                <span class="text-zinc-900 dark:text-white">INNOVENTRA</span><span class="text-accent">DIGITAL</span>
            </a>

            <ul class="hidden md:flex items-center gap-8 text-sm" role="list">
                <li><a href="#services" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s==='services'?'on !text-zinc-900 dark:!text-white':''">Layanan</a></li>
                <li><a href="#work" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s==='work'?'on !text-zinc-900 dark:!text-white':''">Portofolio</a></li>
                <li><a href="#about" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s==='about'?'on !text-zinc-900 dark:!text-white':''">Tentang Kami</a></li>
                <li><a href="#process" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s==='process'?'on !text-zinc-900 dark:!text-white':''">Alur Kerja</a></li>
                <li><a href="#contact" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s==='contact'?'on !text-zinc-900 dark:!text-white':''">Kontak</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <!-- dark toggle -->
                <button @click="dark=!dark" class="w-9 h-9 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors" :aria-label="dark?'Light mode':'Dark mode'">
                    <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>

                <!-- Tombol Login Langsung ke /login -->
                <a href="/login" class="hidden md:inline-flex items-center gap-2 border border-accent text-accent dark:text-accent-light text-sm font-medium px-4 py-2 rounded-full hover:bg-accent/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>

                <!-- hubungi kami -->
                <a href="#contact" class="hidden md:inline-flex items-center gap-2 shimmer bg-gradient-to-r from-sky-500 via-cyan-500 to-blue-600 text-white text-sm font-medium px-5 py-2 rounded-full hover:opacity-90 transition-opacity shadow-md">
                    Konsultasi Gratis <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>

                <!-- hamburger -->
                <button @click="mm=!mm" class="md:hidden w-9 h-9 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800" :aria-expanded="mm" aria-label="Toggle menu">
                    <svg x-show="!mm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- mobile menu -->
        <div x-show="mm" x-cloak
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-900">
            <ul class="flex flex-col px-6 py-5 gap-4 text-sm font-medium" role="list">
                <li><a href="#services" @click="mm=false" class="block text-zinc-700 dark:text-zinc-300 hover:text-accent transition-colors">Layanan</a></li>
                <li><a href="#work" @click="mm=false" class="block text-zinc-700 dark:text-zinc-300 hover:text-accent transition-colors">Portofolio</a></li>
                <li><a href="#about" @click="mm=false" class="block text-zinc-700 dark:text-zinc-300 hover:text-accent transition-colors">Tentang Kami</a></li>
                <li><a href="#process" @click="mm=false" class="block text-zinc-700 dark:text-zinc-300 hover:text-accent transition-colors">Alur Kerja</a></li>
                <li><a href="#contact" @click="mm=false" class="block text-zinc-700 dark:text-zinc-300 hover:text-accent transition-colors">Kontak</a></li>
                <li class="pt-2 border-t border-zinc-100 dark:border-zinc-900 flex flex-col gap-2">
                    <a href="/login" class="inline-flex items-center justify-center gap-2 border border-accent text-accent font-medium text-sm px-5 py-2.5 rounded-full">Login Sistem</a>
                    <a href="#contact" @click="mm=false" class="inline-flex items-center justify-center shimmer bg-gradient-to-r from-sky-500 to-blue-600 text-white font-medium text-sm px-5 py-2.5 rounded-full">Konsultasi Gratis →</a>
                </li>
            </ul>
        </div>
    </header>

    <main>

        <!-- ═══ HERO ═══ -->
        <section id="hero" class="relative min-h-screen flex items-center pt-16 overflow-hidden bg-gradient-to-b from-sky-50/60 via-teal-50/30 to-white dark:from-zinc-950 dark:via-zinc-900/40 dark:to-zinc-950">
            <div class="absolute top-1/4 right-0 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
            <div class="absolute bottom-1/4 left-0 w-64 h-64 bg-teal-400/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

            <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 w-full">
                <div class="grid md:grid-cols-2 gap-12 items-center">

                    <div>
                        <p class="reveal text-sm font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-4">Mitra Digital &amp; Kesehatan Terpercaya</p>
                        <h1 class="reveal d1 font-display font-bold text-4xl md:text-5xl lg:text-6xl leading-[1.1] tracking-tight text-zinc-900 dark:text-white mb-6">
                            PT INNOVENTRA <span class="bg-gradient-to-r from-sky-500 via-teal-500 to-blue-600 bg-clip-text text-transparent">SOLUSI DIGITAL</span>
                        </h1>
                        <p class="reveal d2 text-lg md:text-xl text-zinc-600 dark:text-zinc-300 font-light leading-relaxed max-w-md mb-10">
                            Akselerasi <strong class="font-medium text-zinc-800 dark:text-zinc-100">Transformasi Digital</strong> &amp; <strong class="font-medium text-zinc-800 dark:text-zinc-100">Interoperabilitas Alat Kesehatan</strong> melalui aplikasi modern, web enterprise, dan integrasi medis terstandar.
                        </p>
                        <div class="reveal d3 flex flex-wrap gap-4">
                            <a href="#work" class="shimmer inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-blue-600 text-white font-medium px-7 py-3.5 rounded-full hover:opacity-90 transition-opacity text-sm shadow-md">
                                Lihat Portofolio
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                            <a href="#contact" class="inline-flex items-center gap-2 border border-sky-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium px-7 py-3.5 rounded-full hover:bg-sky-50 dark:hover:bg-zinc-900 transition-colors text-sm">Hubungi Kami</a>
                        </div>
                        <div class="reveal d4 flex gap-8 mt-14 pt-8 border-t border-sky-100 dark:border-zinc-800">
                            <div>
                                <p class="font-display font-bold text-3xl bg-gradient-to-r from-sky-600 to-teal-600 bg-clip-text text-transparent">&lt; 2s</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Kecepatan Loading</p>
                            </div>
                            <div>
                                <p class="font-display font-bold text-3xl bg-gradient-to-r from-sky-600 to-teal-600 bg-clip-text text-transparent">100%</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Integrasi Terstandar</p>
                            </div>
                            <div>
                                <p class="font-display font-bold text-3xl bg-gradient-to-r from-sky-600 to-teal-600 bg-clip-text text-transparent">SSL</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Enkripsi Berstandar Medis</p>
                            </div>
                        </div>
                    </div>

                    <div class="reveal d2 flex justify-center md:justify-end">
                        <div class="relative w-72 h-72 md:w-80 md:h-80 lg:w-96 lg:h-96">
                            <div class="pf w-full h-full rounded-3xl shadow-2xl ring-4 ring-sky-100 dark:ring-zinc-800">
                                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80" alt="InnoHealth Integration & Solusi Digital" loading="eager">
                            </div>
                            <div class="absolute -bottom-4 -left-4 bg-gradient-to-r from-sky-500 to-teal-500 text-white font-display font-bold text-sm px-4 py-2.5 rounded-2xl shadow-lg">InnoHealth Gateway Ready</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ═══ SERVICES ═══ -->
        <section id="services" class="py-24 bg-gradient-to-b from-white via-sky-50/40 to-teal-50/30 dark:from-zinc-950 dark:via-zinc-900/50 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="mb-14">
                    <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Layanan Spesialis Kami</p>
                    <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Solusi Digital Terintegrasi</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-6">

                    <article class="reveal d1 card-h group bg-gradient-to-br from-white via-sky-50/50 to-cyan-50/30 dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-800 rounded-2xl p-8 border border-sky-100 dark:border-zinc-800 hover:border-sky-400 shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center bg-sky-100 dark:bg-zinc-800 rounded-xl mb-6 group-hover:bg-sky-500 group-hover:text-white transition-all text-sky-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.183-1.636V8a2 2 0 011.183-1.636l2.387-.477a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477A2 2 0 0120 7.318v6.11a2 2 0 01-.572 1.428z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m0 0l-3-3m3 3l3-3" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-3">Integrasi Alat Kesehatan (UTAMA)</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Interkoneksi alat medis dengan SIMRS/LIS/PACS/EMR meliputi Radiologi (DICOM), Laboratorium (HL7/Serial), dan Elektromedis Bedside Monitor/EKG.</p>
                    </article>

                    <article class="reveal d2 card-h group bg-gradient-to-br from-slate-900 via-sky-950 to-teal-950 text-white rounded-2xl p-8 border border-sky-800/50 hover:border-sky-400 shadow-md">
                        <div class="w-12 h-12 flex items-center justify-center bg-sky-900/80 rounded-xl mb-6 group-hover:bg-sky-500 transition-colors">
                            <svg class="w-6 h-6 text-sky-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-white mb-3">Custom Web &amp; Enterprise App</h3>
                        <p class="text-sm text-sky-100/80 leading-relaxed">Pengembangan aplikasi khusus sesuai alur kerja internal bisnis Anda (SaaS, ERP, CRM, Dashboard Analitik, HRM, dan Keuangan).</p>
                    </article>

                    <article class="reveal d3 card-h group bg-gradient-to-br from-white via-teal-50/50 to-sky-50/30 dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-800 rounded-2xl p-8 border border-teal-100 dark:border-zinc-800 hover:border-teal-400 shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center bg-teal-100 dark:bg-zinc-800 rounded-xl mb-6 group-hover:bg-teal-500 group-hover:text-white transition-all text-teal-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-3">E-Commerce &amp; Company Profile</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Website profil bisnis elegan dan toko online modern dengan integrasi payment gateway otomatis, kalkulasi ongkir, dan manajemen stok.</p>
                    </article>

                </div>
            </div>
        </section>

        <!-- ═══ WORK (PORTOFOLIO UNGGULAN) ═══ -->
        <section id="work" class="py-24 bg-gradient-to-b from-teal-50/30 via-sky-50/20 to-white dark:from-zinc-950 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-14">
                    <div>
                        <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Hasil Karya Kami</p>
                        <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Portofolio Unggulan</h2>
                    </div>
                    <a href="https://www.innoventra.my.id" target="_blank" class="reveal d1 text-sm font-medium text-sky-600 dark:text-sky-400 hover:text-sky-700 transition-colors self-start sm:self-auto nl">Kunjungi Portal Utama →</a>
                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Fitur 1: InnoHealth Gateway -->
                    <article @click="openModal('innohealth')" class="card-h reveal d1 group cursor-pointer rounded-2xl overflow-hidden bg-gradient-to-br from-sky-50/80 via-white to-teal-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-sky-100 dark:border-zinc-800 hover:border-sky-400 md:row-span-2 shadow-sm relative">
                        <div class="pf w-full h-64 md:h-80 relative">
                            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?w=900&q=80" alt="InnoHealth Integration Gateway" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-sky-900/20 group-hover:bg-sky-900/10 transition-colors flex items-center justify-center">
                                <span class="bg-white/90 dark:bg-zinc-900/90 text-sky-600 dark:text-sky-400 text-xs font-semibold px-4 py-2 rounded-full shadow-lg border border-sky-200 dark:border-zinc-700 group-hover:scale-110 transition-transform flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Pratinjau Orthanc & OHIF Viewer
                                </span>
                            </div>
                        </div>
                        <div class="p-7">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-zinc-700 px-3 py-1 rounded-full">Medis</span>
                                <span class="text-xs bg-cyan-100 dark:bg-zinc-800 text-cyan-700 dark:text-cyan-300 px-3 py-1 rounded-full">Orthanc PACS</span>
                                <span class="text-xs bg-teal-100 dark:bg-zinc-800 text-teal-700 dark:text-teal-300 px-3 py-1 rounded-full">OHIF Viewer</span>
                                <span class="text-xs bg-blue-100 dark:bg-zinc-800 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full">DICOM</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-zinc-900 dark:text-white mb-2 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">InnoHealth Integration Gateway</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-5">
                                Central Monitoring &amp; Interoperability Hub yang menghubungkan perangkat medis terpusat:<br><br>
                                • <strong>Radiologi (PACS/DICOM):</strong> CT-Scan, MRI, Digital X-Ray, USG 3D/4D.<br>
                                • <strong>Laboratorium (LIS/Analyzer):</strong> Hematology, Clinical Chemistry, Urine Analyzer.<br>
                                • <strong>Elektromedis &amp; Vital Sign:</strong> Bedside Patient Monitor, EKG 12-Lead, Spirometri &amp; Infuse Pump.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 dark:text-sky-400">
                                Buka Simulasi Web Viewer Medis &rarr;
                            </span>
                        </div>
                    </article>

                    <!-- Fitur 2: WHOVENTRA Dashboard -->
                    <article @click="openModal('whoventra')" class="card-h reveal d2 group cursor-pointer rounded-2xl overflow-hidden bg-gradient-to-br from-white via-cyan-50/30 to-sky-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-cyan-100 dark:border-zinc-800 hover:border-cyan-400 shadow-sm relative">
                        <div class="pf w-full h-48 relative">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80" alt="WHOVENTRA System Management" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-cyan-900/20 group-hover:bg-cyan-900/10 transition-colors flex items-center justify-center">
                                <span class="bg-white/90 dark:bg-zinc-900/90 text-cyan-600 dark:text-cyan-400 text-xs font-semibold px-3 py-1.5 rounded-full shadow-lg border border-cyan-200 dark:border-zinc-700 group-hover:scale-110 transition-transform flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Dashboard
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs bg-cyan-100 dark:bg-zinc-800 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-zinc-700 px-3 py-1 rounded-full">Enterprise</span>
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 px-3 py-1 rounded-full">SaaS Dashboard</span>
                            </div>
                            <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-1.5 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">WHOVENTRA Dashboard Ver.3</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">Sistem Manajemen Terlengkap yang mencakup modul HRM, Medika Health, Keuangan, Inventaris, Logistik, hingga Koperasi.</p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-600 dark:text-cyan-400">
                                Eksplorasi Fitur Enterprise &rarr;
                            </span>
                        </div>
                    </article>

                    <!-- Fitur 3: Company Profile Corporate -->
                    <article @click="openModal('company')" class="card-h reveal d3 group cursor-pointer rounded-2xl overflow-hidden bg-gradient-to-br from-white via-teal-50/30 to-sky-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-teal-100 dark:border-zinc-800 hover:border-teal-400 shadow-sm relative">
                        <div class="pf w-full h-48 relative">
                            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" alt="Company Profile Innoventra" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-teal-900/20 group-hover:bg-teal-900/10 transition-colors flex items-center justify-center">
                                <span class="bg-white/90 dark:bg-zinc-900/90 text-teal-600 dark:text-teal-400 text-xs font-semibold px-3 py-1.5 rounded-full shadow-lg border border-teal-200 dark:border-zinc-700 group-hover:scale-110 transition-transform flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Pratinjau Layout
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs bg-teal-100 dark:bg-zinc-800 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-zinc-700 px-3 py-1 rounded-full">Web Profile</span>
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 px-3 py-1 rounded-full">Responsive</span>
                            </div>
                            <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-1.5 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">Company Profile Corporate</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">Pengembangan website profil bisnis konstruksi, manufaktur, dan korporasi dengan tampilan profesional, clean, serta responsif.</p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 dark:text-teal-400">
                                Lihat Animasi UI &rarr;
                            </span>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- ═══ ABOUT ═══ -->
        <section id="about" class="py-24 bg-gradient-to-b from-white via-sky-50/30 to-teal-50/40 dark:from-zinc-950 dark:via-zinc-900/40 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-16 items-center">

                    <div class="reveal order-2 md:order-1">
                        <div class="pf w-full aspect-square max-w-sm mx-auto rounded-3xl shadow-xl ring-4 ring-cyan-100 dark:ring-zinc-800">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=700&q=80" alt="Tim PT Innoventra Solusi Digital" loading="lazy">
                        </div>
                    </div>

                    <div class="order-1 md:order-2">
                        <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Tentang Kami</p>
                        <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white leading-tight mb-6">Mitra Akselerasi<br>Bisnis &amp; Kesehatan</h2>
                        <p class="reveal d2 text-zinc-600 dark:text-zinc-300 leading-relaxed mb-4">
                            <strong>PT INNOVENTRA SOLUSI DIGITAL</strong> adalah perusahaan TIK inovatif yang berfokus pada penyediaan solusi digital terintegrasi. Kami hadir membantu UMKM, startup, korporasi besar, hingga fasilitas kesehatan (Faskes, Rumah Sakit, Klinik) melakukan transformasi digital.
                        </p>
                        <p class="reveal d3 text-zinc-600 dark:text-zinc-300 leading-relaxed mb-6">
                            <strong>Visi:</strong> Menjadi mitra solusi digital &amp; integrasi teknologi terdepan di Indonesia yang dipercaya dalam menghadirkan inovasi terapan yang kreatif, adaptif, dan berdampak nyata.
                        </p>
                        <div class="reveal d4">
                            <p class="text-xs font-medium text-sky-600 dark:text-sky-400 uppercase tracking-widest mb-3">Nilai Utama Kami (Core Values)</p>
                            <div class="flex flex-wrap gap-2" role="list" aria-label="Core Values">
                                <span role="listitem" class="stag text-sm bg-gradient-to-r from-sky-50 to-teal-50 dark:bg-zinc-800 border border-sky-200 dark:border-zinc-700 text-sky-800 dark:text-sky-200 px-3.5 py-1.5 rounded-full hover:border-sky-500">Inovasi Tanpa Batas</span>
                                <span role="listitem" class="stag text-sm bg-gradient-to-r from-sky-50 to-teal-50 dark:bg-zinc-800 border border-sky-200 dark:border-zinc-700 text-sky-800 dark:text-sky-200 px-3.5 py-1.5 rounded-full hover:border-sky-500">Kualitas Unggul</span>
                                <span role="listitem" class="stag text-sm bg-gradient-to-r from-sky-50 to-teal-50 dark:bg-zinc-800 border border-sky-200 dark:border-zinc-700 text-sky-800 dark:text-sky-200 px-3.5 py-1.5 rounded-full hover:border-sky-500">Fokus pada Pengguna</span>
                                <span role="listitem" class="stag text-sm bg-gradient-to-r from-sky-50 to-teal-50 dark:bg-zinc-800 border border-sky-200 dark:border-zinc-700 text-sky-800 dark:text-sky-200 px-3.5 py-1.5 rounded-full hover:border-sky-500">Integritas &amp; Kemitraan</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ═══ WHY CHOOSE US ═══ -->
        <section id="why" class="py-24 bg-gradient-to-b from-teal-50/40 via-sky-50/20 to-white dark:from-zinc-950 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="mb-14">
                    <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Keunggulan</p>
                    <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Mengapa Memilih Kami?</h2>
                </div>

                <div class="grid md:grid-cols-4 gap-6">

                    <div class="reveal d1 bg-gradient-to-br from-sky-50/60 via-white to-cyan-50/40 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-sky-100 dark:border-zinc-800 shadow-sm">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-sky-500 to-cyan-500 text-white rounded-lg font-bold mb-4 shadow-sm">01</div>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Desain Responsif &amp; Cepat</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Loading cepat (&lt; 2 detik) dan sempurna di semua perangkat.</p>
                    </div>

                    <div class="reveal d2 bg-gradient-to-br from-cyan-50/60 via-white to-teal-50/40 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-cyan-100 dark:border-zinc-800 shadow-sm">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-cyan-500 to-teal-500 text-white rounded-lg font-bold mb-4 shadow-sm">02</div>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Interoperabilitas Medis</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Mendukung protokol HL7, DICOM, RS232 Serial, TCP/IP, &amp; IoT.</p>
                    </div>

                    <div class="reveal d3 bg-gradient-to-br from-teal-50/60 via-white to-sky-50/40 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-teal-100 dark:border-zinc-800 shadow-sm">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-teal-500 to-sky-500 text-white rounded-lg font-bold mb-4 shadow-sm">03</div>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">SEO-Friendly</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Struktur kode dirancang optimal agar mudah ditemukan di mesin pencari.</p>
                    </div>

                    <div class="reveal d4 bg-gradient-to-br from-sky-50/60 via-white to-blue-50/40 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-blue-100 dark:border-zinc-800 shadow-sm">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-lg font-bold mb-4 shadow-sm">04</div>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Keamanan Standar Medis</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Enkripsi SSL industri serta proteksi ekstra data kesehatan pasien.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ═══ PROCESS ═══ -->
        <section id="process" class="py-24 bg-gradient-to-b from-white via-sky-50/40 to-teal-50/30 dark:from-zinc-950 dark:via-zinc-900/40 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-14">
                    <div>
                        <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Metodologi Pengerjaan</p>
                        <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Tahapan &amp; Alur Kerja</h2>
                    </div>
                </div>

                <div class="grid md:grid-cols-4 gap-6">

                    <article class="reveal d1 bg-gradient-to-br from-white via-sky-50/30 to-cyan-50/20 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-sky-100 dark:border-zinc-800 shadow-sm">
                        <span class="text-3xl font-bold font-display bg-gradient-to-r from-sky-600 to-cyan-600 bg-clip-text text-transparent mb-2 block">01</span>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Konsultasi &amp; Perencanaan</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Analisis kebutuhan bisnis/sistem faskes &amp; penyesuaian spesifikasi.</p>
                    </article>

                    <article class="reveal d2 bg-gradient-to-br from-white via-cyan-50/30 to-teal-50/20 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-cyan-100 dark:border-zinc-800 shadow-sm">
                        <span class="text-3xl font-bold font-display bg-gradient-to-r from-cyan-600 to-teal-600 bg-clip-text text-transparent mb-2 block">02</span>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Desain &amp; Spesifikasi</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Perancangan mock-up UI/UX antarmuka &amp; pemetaan protokol data.</p>
                    </article>

                    <article class="reveal d3 bg-gradient-to-br from-white via-teal-50/30 to-sky-50/20 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-teal-100 dark:border-zinc-800 shadow-sm">
                        <span class="text-3xl font-bold font-display bg-gradient-to-r from-teal-600 to-sky-600 bg-clip-text text-transparent mb-2 block">03</span>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Pengodean &amp; Integrasi</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Coding backend/frontend &amp; driver bridging interkoneksi medis.</p>
                    </article>

                    <article class="reveal d4 bg-gradient-to-br from-white via-sky-50/30 to-blue-50/20 dark:from-zinc-900 dark:to-zinc-900 rounded-2xl p-6 border border-blue-100 dark:border-zinc-800 shadow-sm">
                        <span class="text-3xl font-bold font-display bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent mb-2 block">04</span>
                        <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white mb-2">Pengujian &amp; Launching</h3>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">Uji akurasi data alat medis, QA komprehensif, hingga Go-Live.</p>
                    </article>

                </div>
            </div>
        </section>

        <!-- ═══ CONTACT ═══ -->
        <section id="contact" class="py-24 bg-gradient-to-b from-white to-sky-950 dark:from-zinc-950 dark:to-zinc-950">
            <div class="max-w-6xl mx-auto px-6">
                <div class="bg-gradient-to-br from-slate-900 via-sky-950 to-teal-950 rounded-3xl p-10 md:p-16 relative overflow-hidden shadow-2xl border border-sky-800/40">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-teal-500/10 rounded-full blur-2xl pointer-events-none" aria-hidden="true"></div>

                    <div class="relative z-10 grid md:grid-cols-2 gap-12 items-start">

                        <div>
                            <p class="reveal text-xs font-medium text-sky-400 tracking-widest uppercase mb-3">Konsultasi Gratis</p>
                            <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-white leading-tight mb-5">Mari Wujudkan<br>Solusi Digital Anda</h2>
                            <p class="reveal d2 text-sky-100/80 leading-relaxed mb-8">Hubungi tim spesialis kami hari ini mengenai kebutuhan pembuatan website, aplikasi custom, maupun integrasi peralatan kesehatan.</p>

                            <div class="reveal d3 flex flex-col gap-4">
                                <div class="flex items-start gap-3 text-sky-100/80">
                                    <span class="w-9 h-9 flex items-center justify-center bg-sky-900/80 rounded-lg shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">Pal Sembilan, Kec. Sungai Kakap, Kab. Kubu Raya, Kalimantan Barat</span>
                                </div>
                                <a href="tel:+6285756100160" class="group flex items-center gap-3 text-sky-100/80 hover:text-white transition-colors">
                                    <span class="w-9 h-9 flex items-center justify-center bg-sky-900/80 rounded-lg group-hover:bg-sky-700 transition-colors shrink-0">
                                        <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">+62 857-5610-0160 (Telepon / WA)</span>
                                </a>
                                <a href="mailto:info@innoventra.my.id" class="group flex items-center gap-3 text-sky-100/80 hover:text-white transition-colors">
                                    <span class="w-9 h-9 flex items-center justify-center bg-sky-900/80 rounded-lg group-hover:bg-sky-700 transition-colors shrink-0">
                                        <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">info@innoventra.my.id</span>
                                </a>
                            </div>
                        </div>

                        <div class="reveal d2">
                            <form action="#" method="POST" novalidate>
                                <div class="flex flex-col gap-4">
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="fname" class="block text-xs font-medium text-sky-200 mb-1.5">Nama Lengkap <span aria-hidden="true">*</span></label>
                                            <input type="text" id="fname" name="name" placeholder="Nama Anda" required autocomplete="name"
                                                class="w-full bg-slate-900/80 border border-sky-800 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-sky-400 transition-colors">
                                        </div>
                                        <div>
                                            <label for="femail" class="block text-xs font-medium text-sky-200 mb-1.5">Email / No. WA <span aria-hidden="true">*</span></label>
                                            <input type="text" id="femail" name="contact" placeholder="Email atau nomor WA" required
                                                class="w-full bg-slate-900/80 border border-sky-800 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-sky-400 transition-colors">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="fsubject" class="block text-xs font-medium text-sky-200 mb-1.5">Kategori Layanan</label>
                                        <select id="fsubject" name="subject" class="w-full bg-slate-900/80 border border-sky-800 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-400 transition-colors">
                                            <option value="medis">Integrasi Alat Kesehatan / SIMRS</option>
                                            <option value="web">Custom Web &amp; Enterprise App</option>
                                            <option value="ecommerce">E-Commerce &amp; Online Store</option>
                                            <option value="profile">Company Profile</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="fmessage" class="block text-xs font-medium text-sky-200 mb-1.5">Pesan / Detail Kebutuhan <span aria-hidden="true">*</span></label>
                                        <textarea id="fmessage" name="message" rows="4" placeholder="Jelaskan kebutuhan proyek atau integrasi Anda..." required
                                            class="w-full bg-slate-900/80 border border-sky-800 text-white text-sm rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-sky-400 transition-colors resize-none"></textarea>
                                    </div>
                                    <button type="submit" class="shimmer w-full bg-gradient-to-r from-sky-500 via-cyan-500 to-blue-600 text-white font-display font-bold text-sm py-3.5 rounded-xl hover:opacity-90 transition-opacity shadow-lg">
                                        Kirim Pesan Konsultasi →
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ═══ ANIMATED MODAL COMPONENT (DENGAN ORTHANC & OHIF VIEWER SIMULATOR) ═══ -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop blur & Overlay -->
        <div x-show="modalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeModal()"
            class="fixed inset-0 bg-zinc-950/85 backdrop-blur-md transition-opacity"></div>

        <div class="flex min-h-screen items-center justify-center p-2 sm:p-4 text-center">
            <!-- Modal Content Panel -->
            <div x-show="modalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-sky-500/30 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">

                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-white z-30 w-8 h-8 flex items-center justify-center rounded-full bg-zinc-800/80 hover:bg-zinc-700 transition-colors border border-zinc-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <template x-if="activeFeature">
                    <div>
                        <!-- Header & Simulasi Viewer Orthanc / OHIF -->
                        <div class="p-5 md:p-6 bg-gradient-to-br from-slate-950 via-sky-950 to-zinc-900 text-white relative overflow-hidden">
                            <!-- Background Grid Pattern -->
                            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>

                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30" x-text="activeFeature.badge"></span>
                                <template x-if="activeModal === 'innohealth'">
                                    <div class="flex items-center gap-2 bg-slate-900/90 px-3 py-1 rounded-lg border border-sky-500/30 text-[11px] font-mono text-cyan-300">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Orthanc PACS &amp; OHIF Web Viewer Connected
                                    </div>
                                </template>
                            </div>
                            <h3 class="font-display font-bold text-2xl md:text-3xl text-white mb-1" x-text="activeFeature.title"></h3>
                            <p class="text-xs md:text-sm text-sky-200/80 leading-relaxed mb-4" x-text="activeFeature.subtitle"></p>

                            <!-- AREA UTAMA SIMULASI ORTHANC / OHIF VIEWER -->
                            <template x-if="activeModal === 'innohealth'">
                                <div class="bg-slate-950 rounded-2xl border border-sky-500/40 overflow-hidden shadow-2xl">
                                    <!-- OHIF Toolbar Simulator -->
                                    <div class="bg-slate-900 px-4 py-2 border-b border-zinc-800 flex flex-wrap items-center justify-between gap-2 text-xs text-zinc-300 font-mono">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sky-400 font-bold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                OHIF v3.8 Web Viewer
                                            </span>
                                            <span class="text-zinc-500">|</span>
                                            <span class="text-emerald-400">Series: CT Thorax Contrast (1/42)</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <button @click="viewerTool = 'zoom'" :class="viewerTool === 'zoom' ? 'bg-sky-600 text-white' : 'bg-slate-800 text-zinc-300 hover:bg-slate-700'" class="px-2.5 py-1 rounded transition-colors text-[10px]">Zoom</button>
                                            <button @click="viewerTool = 'ww/wc'" :class="viewerTool === 'ww/wc' ? 'bg-sky-600 text-white' : 'bg-slate-800 text-zinc-300 hover:bg-slate-700'" class="px-2.5 py-1 rounded transition-colors text-[10px]">WW/WC</button>
                                            <button @click="viewerTool = 'pan'" :class="viewerTool === 'pan' ? 'bg-sky-600 text-white' : 'bg-slate-800 text-zinc-300 hover:bg-slate-700'" class="px-2.5 py-1 rounded transition-colors text-[10px]">Pan</button>
                                            <button @click="viewerTool = 'measure'" :class="viewerTool === 'measure' ? 'bg-sky-600 text-white' : 'bg-slate-800 text-zinc-300 hover:bg-slate-700'" class="px-2.5 py-1 rounded transition-colors text-[10px]">Measure</button>
                                        </div>
                                    </div>

                                    <!-- DICOM Viewport Screen -->
                                    <div class="grid md:grid-cols-4 min-h-[260px] bg-black relative">
                                        <!-- Left Patient Info Overlay -->
                                        <div class="absolute top-3 left-3 z-10 text-[10px] font-mono text-cyan-300/90 pointer-events-none space-y-0.5 bg-black/40 p-2 rounded backdrop-blur-sm border border-cyan-500/20">
                                            <p><strong class="text-white">ID:</strong> MED-2026-9081</p>
                                            <p><strong class="text-white">Nama:</strong> Ny. Siti Aminah (45 Th)</p>
                                            <p><strong class="text-white">Modality:</strong> CT (Computed Tomography)</p>
                                            <p><strong class="text-white">Institusi:</strong> RSUD / Klinik Mitra</p>
                                        </div>

                                        <!-- Right Technical Parameters Overlay -->
                                        <div class="absolute top-3 right-3 z-10 text-[10px] font-mono text-zinc-400 pointer-events-none text-right space-y-0.5 bg-black/40 p-2 rounded backdrop-blur-sm border border-zinc-700/40">
                                            <p>KV: 120 | mA: 240</p>
                                            <p>Slice Thickness: 1.25 mm</p>
                                            <p>WW: 400 | WC: 40 (Lung Window)</p>
                                            <p class="text-emerald-400 font-bold">Orthanc Storage: OK</p>
                                        </div>

                                        <!-- Center Simulated DICOM Image Viewport -->
                                        <div class="col-span-3 flex items-center justify-center p-6 relative overflow-hidden">
                                            <!-- Simulated Medical Scan Graphics -->
                                            <div class="w-48 h-48 sm:w-56 sm:h-56 rounded-full border-4 border-dashed border-sky-500/30 flex items-center justify-center relative animate-pulse-wave">
                                                <div class="absolute inset-4 rounded-full border-2 border-cyan-400/50 flex items-center justify-center bg-gradient-to-tr from-slate-900 via-sky-950 to-black">
                                                    <!-- Lung / Organ Outline Graphic Simulator -->
                                                    <div class="w-28 h-28 rounded-2xl bg-zinc-900 border border-sky-400/40 flex items-center justify-center shadow-inner relative overflow-hidden">
                                                        <div class="absolute inset-0 bg-[radial-gradient(#0ea5e9_1px,transparent_1px)] [background-size:8px_8px] opacity-30"></div>
                                                        <div class="text-center">
                                                            <svg class="w-10 h-10 text-sky-400 mx-auto mb-1 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                            </svg>
                                                            <span class="text-[9px] font-mono text-cyan-300 font-bold">DICOM SLICE #24</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Orthanc Series Selector Sidebar -->
                                        <div class="bg-slate-900/90 border-t md:border-t-0 md:border-l border-zinc-800 p-3 flex flex-col justify-between text-xs font-mono">
                                            <div>
                                                <p class="text-[10px] uppercase text-zinc-400 font-bold mb-2">Orthanc Series List</p>
                                                <div class="space-y-1.5">
                                                    <div class="bg-sky-950/80 border border-sky-500/50 rounded p-1.5 text-sky-300 text-[10px] cursor-pointer">
                                                        <p class="font-bold">1. Axial Lung (42 img)</p>
                                                        <p class="text-[9px] text-zinc-400">DICOM Transfer: 100%</p>
                                                    </div>
                                                    <div class="bg-slate-800/60 hover:bg-slate-800 border border-zinc-700/60 rounded p-1.5 text-zinc-300 text-[10px] cursor-pointer">
                                                        <p class="font-bold">2. Coronal Bone (30 img)</p>
                                                        <p class="text-[9px] text-zinc-500">DICOM Transfer: 100%</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 pt-2 border-t border-zinc-800 text-[10px] text-emerald-400 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400">From Modality: Direct DICOM Store</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Fallback/Default untuk modul lain -->
                            <template x-if="activeModal !== 'innohealth'">
                                <div class="mt-4 p-6 bg-slate-950/80 rounded-2xl border border-sky-500/30 text-center">
                                    <p class="text-sm text-sky-200" x-text="activeFeature.subtitle"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Body & Penjelasan Detail Fitur -->
                        <div class="p-6 md:p-8 space-y-4 text-zinc-700 dark:text-zinc-300 text-sm leading-relaxed">
                            <h4 class="font-display font-bold text-base text-zinc-900 dark:text-white uppercase tracking-wider text-xs">Penjelasan Detail Modul:</h4>
                            <p x-text="activeFeature.description"></p>

                            <div class="bg-sky-50 dark:bg-zinc-800/60 p-4 rounded-xl border border-sky-100 dark:border-zinc-700">
                                <h5 class="font-bold text-xs uppercase text-sky-700 dark:text-sky-300 mb-2">Keunggulan Utama:</h5>
                                <ul class="list-disc list-inside space-y-1 text-xs text-zinc-600 dark:text-zinc-400">
                                    <template x-for="item in activeFeature.highlights" :key="item">
                                        <li x-text="item"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Footer Modal -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">PT Innoventra Solusi Digital</span>
                            <button @click="closeModal()" class="px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-medium rounded-full transition-colors shadow-sm">
                                Tutup Pratinjau
                            </button>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>

    <footer class="bg-slate-950 text-white border-t border-sky-950">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-sky-200/70">© <span id="yr"></span> PT INNOVENTRA SOLUSI DIGITAL. All rights reserved.</p>
            <p class="text-xs text-sky-400">Kubu Raya, Kalimantan Barat — Indonesia</p>
        </div>
    </footer>

    <script>
        function app() {
            return {
                dark: false,
                mm: false,
                sc: false,
                s: 'hero',

                // State Modal
                modalOpen: false,
                activeModal: null,
                activeFeature: null,
                viewerTool: 'zoom',

                // Data Fitur Portofolio
                featuresData: {
                    innohealth: {
                        badge: 'Solusi Medis & Interoperabilitas',
                        title: 'InnoHealth Integration Gateway',
                        subtitle: 'Pusat bridging dan otomatisasi data rekam medis pasien dari alat kesehatan langsung ke SIMRS/EMR.',
                        description: 'Modul ini dilengkapi dengan integrasi server Orthanc PACS berkecepatan tinggi dan OHIF Web Viewer berbasis web, memungkinkan dokter spesialis radiologi dan tenaga medis membuka, memanipulasi (Zoom, Pan, Window/Level), serta menganalisis citra DICOM (CT-Scan, MRI, X-Ray) secara real-time langsung melalui browser tanpa memerlukan instalasi aplikasi tambahan.',
                        highlights: [
                            'Integrasi langsung server Orthanc PACS dengan protokol DICOM standard',
                            'OHIF Web Viewer responsif untuk manipulasi citra (Zoom, Window/Level, Measurement)',
                            'Dukungan otomatisasi alat Laboratorium (HL7 / ASTM Serial & TCP/IP)',
                            'Kompatibel penuh dengan Rekam Medis Elektronik (RME) Rumah Sakit / Klinik'
                        ]
                    },
                    whoventra: {
                        badge: 'SaaS Enterprise Suite',
                        title: 'WHOVENTRA Dashboard Ver.3',
                        subtitle: 'Platfrom manajemen bisnis serbaguna dengan arsitektur modern.',
                        description: 'Sistem ERP/CRM terpadu yang memadukan pengelolaan SDM (HRM), pelaporan keuangan real-time, manajemen inventaris logistik, hingga pengelolaan unit usaha kesehatan dan koperasi dalam satu dashboard terpusat.',
                        highlights: [
                            'Manajemen Absensi & KPI Karyawan berbasis AI/Geofencing',
                            'Jurnal Keuangan Otomatis & Laporan Arus Kas Multi-Cabang',
                            'Sistem Kasir (POS) & Pelacakan Inventaris Otomatis',
                            'Aksesibilitas Multi-Platform dengan tingkat keamanan granular'
                        ]
                    },
                    company: {
                        badge: 'Web Enterprise & Branding',
                        title: 'Company Profile Corporate',
                        subtitle: 'Website bisnis berkinerja tinggi dengan optimasi SEO & UX modern.',
                        description: 'Layanan pembuatan platform web profil usaha profesional yang didesain interaktif untuk membangun reputasi merek, menarik calon mitra bisnis, dan dioptimalkan agar selalu berada di peringkat atas mesin pencari.',
                        highlights: [
                            'Kecepatan muat halaman super cepat (< 2 detik)',
                            'Desain UX/UI responsif sempurna di perangkat mobile & desktop',
                            'Struktur SEO-friendly teroptimasi untuk Google',
                            'Dukungan multi-bahasa & integrasi formulir kontak cepat'
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
                    const ids = ['contact', 'process', 'about', 'work', 'services', 'hero'];
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
