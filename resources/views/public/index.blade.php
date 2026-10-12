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

        <!-- ═══ WORK ═══ -->
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

                    <article class="card-h reveal d1 group rounded-2xl overflow-hidden bg-gradient-to-br from-sky-50/80 via-white to-teal-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-sky-100 dark:border-zinc-800 hover:border-sky-400 md:row-span-2 shadow-sm">
                        <div class="pf w-full h-64 md:h-80">
                            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?w=900&q=80" alt="InnoHealth Integration Gateway" loading="lazy">
                        </div>
                        <div class="p-7">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-zinc-700 px-3 py-1 rounded-full">Medis</span>
                                <span class="text-xs bg-cyan-100 dark:bg-zinc-800 text-cyan-700 dark:text-cyan-300 px-3 py-1 rounded-full">DICOM / PACS</span>
                                <span class="text-xs bg-teal-100 dark:bg-zinc-800 text-teal-700 dark:text-teal-300 px-3 py-1 rounded-full">HL7 / ASTM</span>
                                <span class="text-xs bg-blue-100 dark:bg-zinc-800 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full">IoT</span>
                            </div>
                            <h3 class="font-display font-bold text-2xl text-zinc-900 dark:text-white mb-2">InnoHealth Integration Gateway</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-5">
                                Central Monitoring &amp; Interoperability Hub yang menghubungkan perangkat medis terpusat:<br><br>
                                • <strong>Radiologi (PACS/DICOM):</strong> CT-Scan, MRI, Digital X-Ray, USG 3D/4D.<br>
                                • <strong>Laboratorium (LIS/Analyzer):</strong> Hematology, Clinical Chemistry, Urine Analyzer.<br>
                                • <strong>Elektromedis &amp; Vital Sign:</strong> Bedside Patient Monitor, EKG 12-Lead, Spirometri &amp; Infuse Pump.
                            </p>
                        </div>
                    </article>

                    <article class="card-h reveal d2 group rounded-2xl overflow-hidden bg-gradient-to-br from-white via-cyan-50/30 to-sky-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-cyan-100 dark:border-zinc-800 hover:border-cyan-400 shadow-sm">
                        <div class="pf w-full h-48">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80" alt="WHOVENTRA System Management" loading="lazy">
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs bg-cyan-100 dark:bg-zinc-800 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-zinc-700 px-3 py-1 rounded-full">Enterprise</span>
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 px-3 py-1 rounded-full">SaaS Dashboard</span>
                            </div>
                            <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-1.5">WHOVENTRA Dashboard Ver.3</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">Sistem Manajemen Terlengkap yang mencakup modul HRM, Medika Health, Keuangan, Inventaris, Logistik, hingga Koperasi.</p>
                        </div>
                    </article>

                    <article class="card-h reveal d3 group rounded-2xl overflow-hidden bg-gradient-to-br from-white via-teal-50/30 to-sky-50/50 dark:from-zinc-900 dark:to-zinc-900 border border-teal-100 dark:border-zinc-800 hover:border-teal-400 shadow-sm">
                        <div class="pf w-full h-48">
                            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" alt="Company Profile Innoventra" loading="lazy">
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs bg-teal-100 dark:bg-zinc-800 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-zinc-700 px-3 py-1 rounded-full">Web Profile</span>
                                <span class="text-xs bg-sky-100 dark:bg-zinc-800 text-sky-700 dark:text-sky-300 px-3 py-1 rounded-full">Responsive</span>
                            </div>
                            <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-1.5">Company Profile Corporate</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">Pengembangan website profil bisnis konstruksi, manufaktur, dan korporasi dengan tampilan profesional, clean, serta responsif.</p>
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
                                    <span class="text-sm">
                                        <!-- Jl. Perintis Gg. Madrasah Komplek RBK 2, Kel.  -->
                                        Pal Sembilan, Kec. Sungai Kakap, Kab. Kubu Raya, Kalimantan Barat</span>
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
