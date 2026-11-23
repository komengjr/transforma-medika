<!DOCTYPE html>
<html lang="id" x-data="bankSoalNetflixApp()" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal &amp; Tryout Public — PT Innoventra Solusi Digital</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    }
                }
            }
        }
    </script>
    <style>
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

        .exam-header-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
            border-bottom: 1px solid rgba(129, 140, 248, 0.28);
            box-shadow: 0 10px 28px -8px rgba(15, 23, 42, 0.35);
        }

        .exam-glass-pill {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        /* Background papan ujian, pensil & alat tulis (ATK) */
        .atk-exam-section {
            position: relative;
            background-color: #0f172a;
            background-image: url('https://images.unsplash.com/photo-1456735190827-d1262f71b8a3?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }

        .atk-exam-overlay {
            position: relative;
            z-index: 10;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(30, 27, 75, 0.82) 55%, rgba(15, 23, 42, 0.90) 100%);
            backdrop-filter: blur(3px);
        }

        /* Background karikatur buku, papan ujian & alat tulis pada card putih */
        .card-atk-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.72;
            transition: transform 0.35s ease, opacity 0.35s ease;
        }

        .group:hover .card-atk-bg {
            transform: scale(1.04);
            opacity: 0.9;
        }

        /* Animasi perpindahan halaman saat konfirmasi Yes */
        .page-transition-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: radial-gradient(circle at center, #1e1b4b 0%, #090d16 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.35s ease;
        }

        .page-transition-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .transition-card {
            transform: scale(0.92) translateY(12px);
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .page-transition-overlay.active .transition-card {
            transform: scale(1) translateY(0);
        }

        .netflix-row::-webkit-scrollbar {
            height: 6px;
        }

        .netflix-row::-webkit-scrollbar-track {
            background: transparent;
        }

        .netflix-row::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.45);
            border-radius: 9999px;
        }

        .netflix-row::-webkit-scrollbar-thumb:hover {
            background: #4f46e5;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased min-h-screen flex flex-col">

    <!-- ANIMASI PERPINDAHAN HALAMAN -->
    <div id="pageTransitionOverlay" class="page-transition-overlay" aria-hidden="true">
        <div class="transition-card text-center text-white px-6">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-indigo-600/25 border border-indigo-400/40 flex items-center justify-content-center relative">
                <div class="w-10 h-10 border-4 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-xs uppercase tracking-widest text-indigo-300 font-bold mb-1">Menyiapkan Lembar Ujian</p>
            <h3 id="transitionExamTitle" class="font-display font-extrabold text-xl sm:text-2xl text-white mb-1">Memulai Ujian...</h3>
            <p class="text-xs text-slate-400">Mohon tunggu, sedang mengalihkan ke halaman tes.</p>
        </div>
    </div>

    <!-- HEADER TEMA EXAM -->
    <header class="sticky top-0 z-40 exam-header-bg text-white">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <span class="hidden sm:inline-flex items-center gap-1.5 bg-white text-slate-900 px-3 py-1.5 rounded-lg text-xs font-extrabold shadow-sm shrink-0">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    EXAM CATALOG
                </span>

                <a href="{{ url('/') }}" class="font-display font-extrabold text-base sm:text-xl tracking-tight flex items-center gap-2 truncate">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-white font-bold text-xs shadow-md shrink-0">IN</span>
                    <div class="truncate">
                        <span class="text-white">INNOVENTRA</span><span class="text-indigo-300">DIGITAL</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <button @click="dark=!dark" class="w-9 h-9 flex items-center justify-center rounded-xl exam-glass-pill hover:bg-white/20 transition-colors" aria-label="Toggle Dark Mode">
                    <svg x-show="!dark" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <svg x-show="dark" class="w-4 h-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>

                <!-- Mode Mobile: hanya ikon saja; Mode Desktop: ikon + tulisan -->
                <a href="{{ url('/') }}" title="Kembali ke Beranda" aria-label="Kembali ke Beranda"
                    class="w-9 h-9 sm:w-auto sm:h-auto inline-flex items-center justify-center sm:gap-2 exam-glass-pill text-white text-xs sm:text-sm font-semibold sm:px-4 sm:py-2 rounded-xl hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden sm:inline">Kembali ke Beranda</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- BAGIAN ATAS: KLASIFIKASI & FILTER DENGAN BACKGROUND PAPAN UJIAN, PENSIL & ATK -->
    <section class="atk-exam-section border-b border-indigo-500/25 text-white">
        <div class="atk-exam-overlay">
            <div class="max-w-7xl mx-auto px-6 py-9">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 border border-white/25 text-indigo-200 text-xs font-bold mb-2 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Katalog Tes Per Klasifikasi
                        </span>
                        <h1 class="font-display font-extrabold text-2xl sm:text-4xl text-white tracking-tight">
                            Pilih Klasifikasi Tes
                        </h1>
                    </div>

                    <!-- Pencarian Nama Tes / Kategori -->
                    <div class="relative w-full md:w-80">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama tes atau kategori..."
                            class="w-full bg-slate-950/80 text-white placeholder-slate-400 border border-white/20 rounded-xl pl-10 pr-4 py-2.5 text-xs font-medium focus:outline-none focus:border-indigo-400 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Bar Klasifikasi -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <button type="button"
                        @click="selectedKlasifikasi = 'all'"
                        :class="selectedKlasifikasi === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/35 ring-2 ring-indigo-300/40' : 'bg-slate-950/75 text-slate-200 border border-white/20 hover:bg-slate-900'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all backdrop-blur-sm">
                        Semua Klasifikasi ({{ $klasifikasis->count() }})
                    </button>

                    @foreach($klasifikasis as $klas)
                    <button type="button"
                        @click="selectedKlasifikasi = '{{ $klas->id }}'"
                        :class="selectedKlasifikasi === '{{ $klas->id }}' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/35 ring-2 ring-indigo-300/40' : 'bg-slate-950/75 text-slate-200 border border-white/20 hover:bg-slate-900'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all backdrop-blur-sm">
                        {{ $klas->nama_klasifikasi }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- DAFTAR CARD ALA NETFLIX PER KLASIFIKASI (1 NAMA TES = 1 CARD + SEMUA KATEGORINYA) -->
    <main class="max-w-7xl mx-auto px-6 py-10 w-full flex-grow space-y-12">
        @forelse($klasifikasis as $klas)
        @php
            $paketsInKlas = $klas->pakets ?? collect();
            $rowRef = 'netflixRow_' . $klas->id;
        @endphp

        <section x-show="selectedKlasifikasi === 'all' || selectedKlasifikasi === '{{ $klas->id }}'" x-transition
            class="space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-7 rounded-full bg-rose-600"></span>
                    <div>
                        <h2 class="font-display font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white">
                            {{ $klas->nama_klasifikasi }}
                        </h2>
                        @if(!empty($klas->deskripsi))
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $klas->deskripsi }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-200/70 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                        {{ $paketsInKlas->count() }} Paket Tes
                    </span>
                    @if($paketsInKlas->count() > 0)
                    <button type="button" @click="scrollRow('{{ $rowRef }}', -420)"
                        class="w-8 h-8 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:border-indigo-500 transition-colors"
                        title="Geser Kiri">
                        ‹
                    </button>
                    <button type="button" @click="scrollRow('{{ $rowRef }}', 420)"
                        class="w-8 h-8 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:border-indigo-500 transition-colors"
                        title="Geser Kanan">
                        ›
                    </button>
                    @endif
                </div>
            </div>

            @if($paketsInKlas->count() > 0)
            <div id="{{ $rowRef }}" class="netflix-row flex gap-4 overflow-x-auto pb-4 pt-1 scroll-smooth">
                @foreach($paketsInKlas as $pIdx => $paket)
                @php
                    $kategoris = $paket->kategoris ?? collect();
                    $kategoriLabels = $kategoris->pluck('nama_kategori')->filter()->values();
                    $kategoriSummaryText = $kategoriLabels->isNotEmpty() ? $kategoriLabels->implode(', ') : '-';
                    $urutanCard = $kategoris->min('urutan') ?? ($paket->urutan ?? ($pIdx + 1));
                    $tesUrl = route('brain-test.tes.halaman', $paket->id);
                    $searchBlob = strtolower($paket->nama_test . ' ' . $kategoriSummaryText . ' ' . $klas->nama_klasifikasi);
                @endphp

                <a href="{{ $tesUrl }}"
                    @click.prevent="confirmMulaiUjian({{ json_encode($paket->nama_test) }}, {{ json_encode($kategoriSummaryText) }}, {{ json_encode($tesUrl) }})"
                    x-show="searchQuery.trim() === '' || {{ json_encode($searchBlob) }}.includes(searchQuery.toLowerCase().trim())"
                    class="group relative shrink-0 w-64 sm:w-72 min-h-[340px] rounded-2xl overflow-hidden bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl hover:border-indigo-500 hover:scale-[1.02] hover:z-10 transition-all duration-300 flex flex-col justify-between p-5 text-slate-900 dark:text-white cursor-pointer">

                    <!-- Background Buku, Papan Ujian & Alat Tulis -->
                    <svg class="card-atk-bg" viewBox="0 0 280 380" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <g transform="translate(24, 62) rotate(-5)">
                            <rect x="0" y="0" width="128" height="156" rx="10" fill="#e0e7ff" stroke="#4f46e5" stroke-width="3.5" />
                            <rect x="12" y="6" width="110" height="144" rx="6" fill="#ffffff" stroke="#94a3b8" stroke-width="2.5" />
                            <rect x="0" y="0" width="14" height="156" rx="5" fill="#6366f1" stroke="#4338ca" stroke-width="3" />
                            <rect x="26" y="24" width="76" height="8" rx="4" fill="#4f46e5" />
                            <rect x="26" y="42" width="68" height="6" rx="3" fill="#cbd5e1" />
                            <rect x="26" y="56" width="74" height="6" rx="3" fill="#cbd5e1" />
                            <rect x="26" y="70" width="56" height="6" rx="3" fill="#cbd5e1" />
                        </g>

                        <g transform="translate(166, 56) rotate(7)">
                            <rect x="0" y="10" width="90" height="122" rx="9" fill="#f59e0b" stroke="#b45309" stroke-width="3" />
                            <rect x="8" y="20" width="74" height="104" rx="5" fill="#ffffff" stroke="#d97706" stroke-width="2" />
                            <rect x="24" y="0" width="42" height="18" rx="5" fill="#94a3b8" stroke="#475569" stroke-width="2.5" />
                            <circle cx="45" cy="8" r="4" fill="#f8fafc" />
                            <line x1="18" y1="38" x2="70" y2="38" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" />
                            <line x1="18" y1="54" x2="64" y2="54" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                            <circle cx="22" cy="88" r="4" fill="#10b981" />
                            <line x1="32" y1="88" x2="66" y2="88" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        </g>

                        <g transform="translate(34, 232) rotate(-22)">
                            <rect x="0" y="14" width="18" height="78" rx="3" fill="#fde047" stroke="#ca8a04" stroke-width="2.5" />
                            <rect x="0" y="0" width="18" height="14" rx="4" fill="#fda4af" stroke="#e11d48" stroke-width="2.5" />
                            <polygon points="0,92 18,92 9,112" fill="#fef3c7" stroke="#ca8a04" stroke-width="2.5" stroke-linejoin="round" />
                        </g>

                        <g transform="translate(82, 238) rotate(12)">
                            <rect x="0" y="0" width="88" height="20" rx="4" fill="#bae6fd" stroke="#0284c7" stroke-width="2.5" />
                            <line x1="12" y1="0" x2="12" y2="8" stroke="#0369a1" stroke-width="1.8" />
                            <line x1="24" y1="0" x2="24" y2="6" stroke="#0369a1" stroke-width="1.8" />
                            <line x1="36" y1="0" x2="36" y2="8" stroke="#0369a1" stroke-width="1.8" />
                            <line x1="48" y1="0" x2="48" y2="6" stroke="#0369a1" stroke-width="1.8" />
                        </g>
                    </svg>

                    <div class="relative z-10 flex items-center justify-between gap-2">
                        <span class="px-2.5 py-1 rounded-md bg-rose-600 text-white text-[11px] font-extrabold tracking-wide shadow">
                            URUTAN #{{ $urutanCard }}
                        </span>
                        @if(!empty($paket->durasi_menit))
                        <span class="px-2.5 py-1 rounded-md bg-slate-900/80 text-white text-[11px] font-semibold">
                            {{ $paket->durasi_menit }} Menit
                        </span>
                        @endif
                    </div>

                    <div class="relative z-10 mt-auto space-y-3 bg-white/90 dark:bg-slate-900/90 backdrop-blur-[2px] p-3.5 rounded-xl border border-slate-200/90 dark:border-slate-700/90">
                        <h3 class="font-display font-extrabold text-lg leading-snug text-slate-900 dark:text-white">
                            {{ $paket->nama_test }}
                        </h3>

                        <!-- Daftar Seluruh Kategori pada Paket Tes Ini -->
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-300 mb-1.5">
                                Kategori ({{ $kategoris->count() }})
                            </div>
                            @if($kategoris->count() > 0)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($kategoris as $kat)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-700/60">
                                    {{ $kat->nama_kategori }}
                                    @if(isset($kat->soals_count))
                                    <span class="text-[10px] opacity-75">({{ $kat->soals_count }})</span>
                                    @endif
                                </span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum ada kategori</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-2.5 border-t border-slate-200 dark:border-slate-700 text-xs">
                            <span class="text-emerald-700 dark:text-emerald-300 font-bold">
                                PG: {{ $paket->passing_grade ?? 0 }}
                            </span>
                            <span class="font-bold text-indigo-600 dark:text-indigo-300 group-hover:text-indigo-800 dark:group-hover:text-indigo-200 transition-colors">
                                Mulai Tes →
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-800 p-8 text-center text-xs text-slate-500">
                Belum ada data tes pada klasifikasi <strong>{{ $klas->nama_klasifikasi }}</strong>.
            </div>
            @endif
        </section>
        @empty
        <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800">
            <h3 class="font-display font-bold text-xl mb-2">Belum Ada Klasifikasi Tes</h3>
            <p class="text-sm text-slate-500">Data akan tampil di sini setelah klasifikasi dan tes ditambahkan.</p>
        </div>
        @endforelse
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-white border-t border-slate-900 mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">IN</span>
                <p class="text-sm text-slate-400">© {{ date('Y') }} <strong class="text-white">PT INNOVENTRA SOLUSI DIGITAL</strong>. All rights reserved.</p>
            </div>
            <p class="text-xs text-slate-500">Bank Soal &amp; Simulasi Tes Publik</p>
        </div>
    </footer>

    <script>
        function bankSoalNetflixApp() {
            return {
                dark: false,
                selectedKlasifikasi: 'all',
                searchQuery: '',
                init() {
                    this.dark = localStorage.getItem('theme') === 'dark' ||
                        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));
                },
                scrollRow(rowId, offset) {
                    const el = document.getElementById(rowId);
                    if (el) {
                        el.scrollBy({
                            left: offset,
                            behavior: 'smooth'
                        });
                    }
                },
                confirmMulaiUjian(namaTest, kategoriSummary, targetUrl) {
                    Swal.fire({
                        title: 'Mulai Ujian?',
                        html: '<div class="text-sm text-slate-600">Apakah Anda ingin memulai ujian <strong>' + namaTest + '</strong>' + (kategoriSummary && kategoriSummary !== '-' ? '<br><span class="text-xs text-slate-500">Kategori: <strong>' + kategoriSummary + '</strong></span>' : '') + '?</div>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Mulai Ujian',
                        cancelButtonText: 'No',
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#64748b',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const overlay = document.getElementById('pageTransitionOverlay');
                            const titleEl = document.getElementById('transitionExamTitle');
                            if (titleEl) {
                                titleEl.textContent = namaTest;
                            }
                            if (overlay) {
                                overlay.classList.add('active');
                            }
                            setTimeout(() => {
                                window.location.href = targetUrl;
                            }, 550);
                        }
                    });
                }
            }
        }
    </script>
</body>

</html>
