<!DOCTYPE html>
<html lang="id" x-data="app()" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kumpulan informasi, berita, dan artikel terbaru dari PT Innoventra Solusi Digital.">
    <title>Blog & Informasi - PT Innoventra Solusi Digital</title>

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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232" crossorigin="anonymous"></script>
    <!-- Copy semua style dari index utama Anda agar animasi dan layout konsisten -->
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

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            opacity: .35;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.05'/%3E%3C/svg%3E")
        }

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

        .nl:hover::after {
            width: 100%
        }

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

        .pf img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block
        }

        .card-h {
            transition: transform .28s cubic-bezier(.4, 0, .2, 1), border-color .18s
        }

        .card-h:hover {
            transform: translateY(-4px)
        }

        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased pt-24">

    <!-- ═══ NAV (Disesuaikan agar link mengarah ke Beranda) ═══ -->
    <header class="fixed inset-x-0 top-0 z-50 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md shadow-sm shadow-black/5 transition-all duration-300">
        <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Main navigation">
            <a href="/" class="font-display font-bold text-xl tracking-tight relative z-10 flex items-center gap-1">
                <span class="text-zinc-900 dark:text-white">INNOVENTRA</span><span class="text-accent">DIGITAL</span>
            </a>

            <ul class="hidden md:flex items-center gap-8 text-sm" role="list">
                <li><a href="/" class="nl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Beranda Utama</a></li>
                <li><a href="{{ route('blog.index') }}" class="nl font-medium text-zinc-900 dark:text-white">Pusat Informasi</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <button @click="dark=!dark" class="w-9 h-9 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors" :aria-label="dark?'Light mode':'Dark mode'">
                    <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <main class="min-h-screen">
        <!-- ═══ HEADER BLOG ═══ -->
        <section class="max-w-6xl mx-auto px-6 pt-12 pb-16">
            <div class="text-center max-w-2xl mx-auto">
                <p class="reveal text-xs font-medium text-sky-600 dark:text-sky-400 tracking-widest uppercase mb-3">Pusat Pengetahuan</p>
                <h1 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white mb-4">Informasi & Artikel Terbaru</h1>
                <p class="reveal d1 text-zinc-600 dark:text-zinc-400 text-sm md:text-base">Temukan wawasan terbaru seputar teknologi medis, integrasi alat kesehatan, hingga tips transformasi digital untuk bisnis Anda.</p>
            </div>
        </section>

        <!-- ═══ GRID BLOG ═══ -->
        <section class="max-w-6xl mx-auto px-6 pb-24">

            @if($blogs->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                <article class="reveal card-h flex flex-col group cursor-pointer rounded-2xl overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-sky-400 dark:hover:border-sky-500 shadow-sm relative transition-all duration-300">
                    <!-- Thumbnail -->
                    <a href="{{ route('blog.show', $blog->slug) }}" class="pf w-full h-52 relative overflow-hidden block">
                        @if($blog->thumbnail)
                        <!-- PEMBARUAN: Memanggil gambar menggunakan route blog.image -->
                        <img src="{{ route('blog.image', basename($blog->thumbnail)) }}" alt="{{ $blog->title }}" class="group-hover:scale-105 transition-transform duration-500">
                        @else
                        <!-- Gambar Default jika Admin tidak upload thumbnail -->
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80" alt="{{ $blog->title }}" class="group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </a>

                    <!-- Konten Card -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-sky-600 dark:text-sky-400">Pembaruan Sistem</span>
                            <div class="flex items-center text-xs text-zinc-500 gap-1" title="Jumlah Tayangan">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($blog->views) }}
                            </div>
                        </div>

                        <a href="{{ route('blog.show', $blog->slug) }}" class="block mb-2">
                            <h2 class="font-display font-bold text-xl text-zinc-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors line-clamp-2">
                                {{ $blog->title }}
                            </h2>
                        </a>

                        <!-- Cuplikan Konten (Hilangkan Tag HTML & Batasi 100 Karakter) -->
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($blog->content), 120, '...') }}
                        </p>

                        <div class="mt-auto flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <!-- Tanggal Pembuatan -->
                            <span>{{ $blog->created_at->translatedFormat('d F Y') }}</span>

                            <a href="{{ route('blog.show', $blog->slug) }}" class="font-medium text-sky-600 dark:text-sky-400 hover:text-sky-700 transition-colors flex items-center gap-1">
                                Baca <span class="hidden sm:inline">Selengkapnya</span> &rarr;
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- ═══ PAGINATION ═══ -->
            <div class="mt-12 flex justify-center">
                <!-- Tailwind Style Pagination Default Laravel -->
                {{ $blogs->links() }}
            </div>
            @else
            <!-- Jika belum ada artikel sama sekali -->
            <div class="text-center py-20 bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 6M13 6v4h4" />
                </svg>
                <h3 class="font-display font-bold text-xl text-zinc-900 dark:text-white mb-2">Belum ada informasi</h3>
                <p class="text-zinc-500 text-sm">Informasi dan artikel terbaru akan segera hadir di sini.</p>
            </div>
            @endif

        </section>
    </main>

    <!-- ═══ FOOTER ═══ -->
    <footer class="bg-slate-950 text-white border-t border-sky-950 relative z-10">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-sky-200/70">© <span id="yr"></span> PT INNOVENTRA SOLUSI DIGITAL. All rights reserved.</p>
            <p class="text-xs text-sky-400">Kubu Raya, Kalimantan Barat — Indonesia</p>
        </div>
    </footer>

    <script>
        function app() {
            return {
                dark: false,
                init() {
                    // Logic Dark Mode
                    this.dark = localStorage.getItem('theme') === 'dark' ||
                        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));

                    // Logic Animasi Scroll (Reveal)
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

                    // Set Tahun Footer
                    document.getElementById('yr').textContent = new Date().getFullYear();
                }
            }
        }
    </script>
</body>

</html>
