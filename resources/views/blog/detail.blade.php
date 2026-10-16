<!DOCTYPE html>
<html lang="id" x-data="app()" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} - PT Innoventra Solusi Digital</title>
    <meta name="description" content="{{ Str::limit(strip_tags($blog->content), 150) }}">

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
                        'accent-light': '#38bdf8'
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
    </style>
</head>

<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased pt-24 relative">

    <!-- ═══ NAV ═══ -->
    <header class="fixed inset-x-0 top-0 z-50 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md shadow-sm shadow-black/5 transition-all duration-300">
        <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="font-display font-bold text-xl tracking-tight relative z-10 flex items-center gap-1">
                <span class="text-zinc-900 dark:text-white">INNOVENTRA</span><span class="text-accent">DIGITAL</span>
            </a>
            <ul class="hidden md:flex items-center gap-8 text-sm">
                <li><a href="/" class="nl text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Beranda Utama</a></li>
                <li><a href="{{ route('blog.index') }}" class="nl font-medium text-zinc-900 dark:text-white">Pusat Informasi</a></li>
            </ul>
            <button @click="dark=!dark" class="w-9 h-9 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-900">
                <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                </svg>
                <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
            </button>
        </nav>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12 relative z-10">
        <!-- Notifikasi Sukses Komentar -->
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <!-- Breadcrumb & Statistik -->
        <div class="flex flex-wrap items-center justify-between text-sm text-zinc-500 dark:text-zinc-400 mb-6 gap-4">
            <a href="{{ route('blog.index') }}" class="hover:text-sky-600 dark:hover:text-sky-400 font-medium">← Kembali ke Pusat Informasi</a>
            <div class="flex items-center gap-4">
                <span>{{ $blog->created_at->translatedFormat('d F Y') }}</span>
                <span class="flex items-center gap-1.5 bg-sky-50 dark:bg-zinc-800 text-sky-600 dark:text-sky-400 px-3 py-1 rounded-full font-medium text-xs border border-sky-100 dark:border-zinc-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ number_format($blog->views) }} Tayangan
                </span>
            </div>
        </div>

        <!-- Judul & Thumbnail -->
        <h1 class="font-display font-bold text-3xl md:text-5xl text-zinc-900 dark:text-white leading-tight mb-8">{{ $blog->title }}</h1>

        <div class="w-full h-64 md:h-[400px] rounded-3xl overflow-hidden mb-10 shadow-lg bg-zinc-200 dark:bg-zinc-800">
            @if($blog->thumbnail)
            <img src="{{ route('blog.image', basename($blog->thumbnail)) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @else
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @endif
        </div>

        <!-- Konten Artikel -->
        <article class="prose prose-zinc dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300 leading-relaxed mb-16">
            {!! $blog->content !!}
        </article>

        <!-- ═══ KOMENTAR ═══ -->
        <section class="border-t border-zinc-200 dark:border-zinc-800 pt-10 mt-10">
            <h3 class="font-display font-bold text-2xl mb-8 text-zinc-900 dark:text-white">
                Komentar ({{ $comments->count() }})
            </h3>

            <!-- List Komentar -->
            <div class="space-y-6 mb-12">
                @forelse($comments as $comment)
                <div class="bg-white dark:bg-zinc-900/50 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-sm text-zinc-900 dark:text-white">{{ $comment->name }}</h4>
                            <span class="text-xs text-zinc-500">{{ $comment->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $comment->message }}</p>
                </div>
                @empty
                <p class="text-zinc-500 text-sm italic">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @endforelse
            </div>

            <!-- Form Tambah Komentar -->
            <div class="bg-sky-50 dark:bg-zinc-900 rounded-3xl p-8 border border-sky-100 dark:border-zinc-800">
                <h4 class="font-display font-bold text-lg mb-6 text-zinc-900 dark:text-white">Tinggalkan Komentar</h4>

                <form action="{{ route('blog.comment', $blog->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nama <span class="text-sky-500">*</span></label>
                            <input type="text" name="name" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Email (Tidak dipublikasikan) <span class="text-sky-500">*</span></label>
                            <input type="email" name="email" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Pesan Komentar <span class="text-sky-500">*</span></label>
                        <textarea name="message" rows="4" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm px-8 py-3.5 rounded-xl transition-colors shadow-md">
                        Kirim Komentar
                    </button>
                </form>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 text-white border-t border-sky-950 relative z-10">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-sky-200/70">© <span id="yr"></span> PT INNOVENTRA SOLUSI DIGITAL.</p>
        </div>
    </footer>

    <script>
        function app() {
            return {
                dark: false,
                init() {
                    this.dark = localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));
                    document.getElementById('yr').textContent = new Date().getFullYear();
                }
            }
        }
    </script>
</body>

</html>
