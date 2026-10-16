<!DOCTYPE html>
<html lang="id" x-data="{ dark: false }" :class="{'dark':dark}" class="scroll-smooth">

<head>
    <!-- Gunakan Header HTML yang sama dengan halaman utama (Meta, CSS, Tailwind config) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Blog - PT Innoventra Solusi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased pt-24">
    <!-- Header/Navigasi di sini (Sama dengan Halaman Utama) -->

    <main class="max-w-4xl mx-auto px-6 py-12">
        <!-- Breadcrumb & Views -->
        <div class="flex flex-wrap items-center justify-between text-sm text-zinc-500 mb-6">
            <a href="/" class="hover:text-sky-600">← Kembali ke Beranda</a>
            <div class="flex items-center gap-4">
                <span>12 Oktober 2026</span>
                <span class="flex items-center gap-1.5 bg-sky-50 dark:bg-zinc-800 text-sky-600 dark:text-sky-400 px-3 py-1 rounded-full font-medium text-xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    1,240 Kali Dilihat
                </span>
            </div>
        </div>

        <!-- Judul & Thumbnail -->
        <h1 class="font-display font-bold text-3xl md:text-5xl text-zinc-900 dark:text-white leading-tight mb-8">Pentingnya Integrasi SIMRS dengan Alat Kesehatan Modern</h1>
        <div class="w-full h-64 md:h-96 rounded-3xl overflow-hidden mb-10 shadow-lg">
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80" alt="Thumbnail Blog" class="w-full h-full object-cover">
        </div>

        <!-- Konten Artikel -->
        <article class="prose prose-zinc dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300 leading-relaxed mb-16">
            <p>Implementasi Sistem Informasi Manajemen Rumah Sakit (SIMRS) yang baik tidak hanya bergantung pada software, namun juga sejauh mana sistem tersebut dapat berkomunikasi langsung dengan mesin medis atau alat kesehatan (Alkes).</p>
            <p>Melalui protokol terstandarisasi seperti HL7 atau DICOM, hasil laboratorium pasien dan citra radiologi bisa secara otomatis ditarik oleh sistem tanpa harus diinput ulang secara manual oleh perawat atau dokter.</p>
        </article>

        <!-- Bagian Komentar -->
        <section class="border-t border-zinc-200 dark:border-zinc-800 pt-10 mt-10">
            <h3 class="font-display font-bold text-2xl mb-8 flex items-center gap-2">
                Komentar (2)
            </h3>

            <!-- List Komentar -->
            <div class="space-y-6 mb-12">
                <!-- Item Komentar 1 -->
                <div class="bg-zinc-50 dark:bg-zinc-900/50 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-sm text-zinc-900 dark:text-white">Dr. Budi Santoso</h4>
                            <span class="text-xs text-zinc-500">13 Okt 2026, 10:45 AM</span>
                        </div>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Artikel yang sangat informatif. Integrasi ini memang sangat kami butuhkan di klinik untuk mempercepat proses diagnosa.</p>
                </div>
            </div>

            <!-- Form Tambah Komentar -->
            <div class="bg-sky-50/50 dark:bg-zinc-900 rounded-3xl p-8 border border-sky-100 dark:border-zinc-800">
                <h4 class="font-display font-bold text-lg mb-6">Tinggalkan Komentar</h4>
                <form action="/submit-comment" method="POST" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nama <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Email (Tidak dipublikasikan) <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Pesan Komentar <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="4" required class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 resize-none"></textarea>
                    </div>
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm px-6 py-3 rounded-xl transition-colors">
                        Kirim Komentar
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer di sini (Sama dengan Halaman Utama) -->
</body>

</html>
