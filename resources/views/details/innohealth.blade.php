<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InnoHealth Integration Gateway — PT Innoventra Solusi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['PT Sans', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    },
                    colors: {
                        accent: '#0284c7'
                    }
                }
            }
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
</head>

<body class="bg-zinc-950 text-zinc-100 font-body antialiased">

    <!-- Navbar Sederhana -->
    <header class="fixed inset-x-0 top-0 z-50 bg-zinc-950/80 backdrop-blur-md border-b border-zinc-800">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="font-display font-bold text-lg tracking-tight flex items-center gap-1">
                <span>INNOVENTRA</span><span class="text-accent">DIGITAL</span>
            </a>
            <a href="/#work" class="text-xs font-medium text-zinc-400 hover:text-white transition-colors">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Konten Detail Utama -->
    <main class="pt-32 pb-24 max-w-4xl mx-auto px-6">
        <div class="mb-8">
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30">
                Solusi Medis & Interoperabilitas
            </span>
            <h1 class="font-display font-bold text-3xl md:text-5xl text-white mt-4 mb-3">
                InnoHealth Integration Gateway
            </h1>
            <p class="text-zinc-400 text-base md:text-lg leading-relaxed">
                Pusat bridging dan otomatisasi data rekam medis pasien dari alat kesehatan langsung ke SIMRS/EMR secara real-time dan terstandar.
            </p>
        </div>

        <!-- Gambar / Mockup Ilustrasi -->
        <div class="rounded-3xl overflow-hidden border border-zinc-800 mb-12 shadow-2xl bg-zinc-900">
            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?w=1200&q=80" alt="InnoHealth Gateway" class="w-full h-72 md:h-96 object-cover opacity-90">
        </div>

        <!-- Penjelasan Mendalam -->
        <div class="space-y-8 text-zinc-300 leading-relaxed text-sm md:text-base">
            <section class="bg-zinc-900/60 border border-zinc-800/80 p-8 rounded-3xl">
                <h2 class="font-display font-bold text-xl text-white mb-4">Tentang Sistem InnoHealth</h2>
                <p class="mb-4">
                    InnoHealth Integration Gateway dikembangkan khusus untuk menjawab tantangan fragmentasi data di fasilitas kesehatan modern seperti Rumah Sakit dan Klinik. Sistem ini menjembatani berbagai perangkat medis dari berbagai merk dan vendor agar dapat terintegrasi mulus ke dalam Sistem Informasi Manajemen Rumah Sakit (SIMRS) atau Rekam Medis Elektronik (RME).
                </p>
                <p>
                    Didukung dengan server <strong>Orthanc PACS</strong> berkinerja tinggi serta integrasi <strong>OHIF Web Viewer</strong>, dokter spesialis radiologi kini dapat membuka, menganalisis, hingga melakukan manipulasi citra medis (seperti CT-Scan, MRI, dan X-Ray) langsung melalui browser web tanpa hambatan latensi.
                </p>
            </section>

            <!-- FLOW DIAGRAM ALUR PELAYANAN PASIEN -->
            <section class="bg-gradient-to-br from-sky-950/30 via-zinc-900 to-zinc-900 border border-sky-900/40 p-8 rounded-3xl">
                <h2 class="font-display font-bold text-2xl text-white mb-2">Flow Diagram Alur Layanan & Integrasi Alat Medis</h2>
                <p class="text-xs text-zinc-400 mb-8">Berikut adalah tahapan alur operasional pasien dari pendaftaran hingga pengiriman hasil pemeriksaan otomatis.</p>

                <div class="relative border-l border-sky-500/30 ml-4 space-y-8 pl-6">

                    <!-- Step 1 -->
                    <div class="relative">
                        <span class="absolute -left-[37px] top-0 w-8 h-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-xs shadow-md">01</span>
                        <div class="bg-zinc-900/80 border border-zinc-800 p-5 rounded-2xl">
                            <h3 class="font-display font-bold text-white text-base mb-1">Pendaftaran Bagian Depan (Front Office)</h3>
                            <p class="text-xs text-zinc-400">Pasien baru atau lama mendaftarkan diri di bagian pendaftaran depan untuk memasukkan data demografi dan memilih jenis layanan/poli.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <span class="absolute -left-[37px] top-0 w-8 h-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-xs shadow-md">02</span>
                        <div class="bg-zinc-900/80 border border-zinc-800 p-5 rounded-2xl">
                            <h3 class="font-display font-bold text-white text-base mb-1">Pelunasan di Bagian Kasir</h3>
                            <p class="text-xs text-zinc-400">Pasien melakukan pembayaran atau pelunasan administrasi biaya pemeriksaan di bagian kasir sebelum diarahkan ke stage pemeriksaan medis.</p>
                        </div>
                    </div>

                    <!-- Step 3: Percabangan Stage Pemeriksaan -->
                    <div class="relative">
                        <span class="absolute -left-[37px] top-0 w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-xs shadow-md">03</span>
                        <div class="bg-zinc-900/80 border border-zinc-800 p-5 rounded-2xl space-y-4">
                            <h3 class="font-display font-bold text-white text-base">Stage Sesuai Jenis Pemeriksaan (Percabangan Alur)</h3>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Cabang Radiologi -->
                                <div class="bg-zinc-950/60 border border-sky-900/50 p-4 rounded-xl">
                                    <span class="text-[10px] uppercase font-semibold text-sky-400 tracking-wider">Jalur Radiologi (Contoh: Thorax)</span>
                                    <p class="text-xs text-zinc-300 mt-1 font-medium">Alat Radiologi ➔ Mengirim data DICOM ke Server Orthanc ➔ Ditampilkan ke SIMRS.</p>
                                </div>
                                <!-- Cabang Laboratorium -->
                                <div class="bg-zinc-950/60 border border-teal-900/50 p-4 rounded-xl">
                                    <span class="text-[10px] uppercase font-semibold text-teal-400 tracking-wider">Jalur Laboratorium (Contoh: Hema, dll)</span>
                                    <p class="text-xs text-zinc-300 mt-1 font-medium">Alat Analyzer Lab ➔ Bantuan Gateway (Kabel RS-232 ke LAN) ➔ Mengirim data langsung ke SIMRS ➔ Mendapatkan nilai hasil pemeriksaan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative">
                        <span class="absolute -left-[37px] top-0 w-8 h-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-xs shadow-md">04</span>
                        <div class="bg-zinc-900/80 border border-zinc-800 p-5 rounded-2xl">
                            <h3 class="font-display font-bold text-white text-base mb-1">Verifikasi Hasil Pemeriksaan</h3>
                            <p class="text-xs text-zinc-400">Setelah seluruh rangkaian pemeriksaan (Radiologi & Laboratorium) selesai, hasil diverifikasi oleh penanggung jawab / dokter spesialis di bagiannya masing-masing.</p>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative">
                        <span class="absolute -left-[37px] top-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-md">05</span>
                        <div class="bg-zinc-900/80 border border-zinc-800 p-5 rounded-2xl">
                            <h3 class="font-display font-bold text-white text-base mb-1">Pengiriman Hasil ke Pasien</h3>
                            <p class="text-xs text-zinc-400">Hasil pemeriksaan yang telah diverifikasi secara otomatis dikirimkan langsung ke pasien melalui <strong class="text-white">Email</strong> dan <strong class="text-white">WhatsApp</strong>.</p>
                        </div>
                    </div>

                </div>
            </section>

            <section class="grid md:grid-cols-2 gap-6">
                <div class="bg-zinc-900/40 border border-zinc-800 p-6 rounded-2xl">
                    <h3 class="font-display font-bold text-lg text-white mb-3 text-accent">Modul Radiologi (PACS / DICOM)</h3>
                    <p class="text-xs md:text-sm text-zinc-400">
                        Menangkap dan menyimpan data citra medis dari modality (CT-Scan, USG, MRI, CR/DR) menggunakan standar protokol DICOM internasional, lengkap dengan fitur pengukuran dan windowing instan.
                    </p>
                </div>
                <div class="bg-zinc-900/40 border border-zinc-800 p-6 rounded-2xl">
                    <h3 class="font-display font-bold text-lg text-white mb-3 text-accent">Modul Laboratorium (LIS / Analyzer)</h3>
                    <p class="text-xs md:text-sm text-zinc-400">
                        Otomatisasi pengiriman hasil uji darah, hematologi, dan clinical chemistry dari mesin analyzer langsung ke database pasien tanpa risiko kesalahan input manual (human error).
                    </p>
                </div>
            </section>

            <section class="bg-gradient-to-br from-sky-950/40 via-zinc-900 to-zinc-900 border border-sky-900/40 p-8 rounded-3xl">
                <h2 class="font-display font-bold text-xl text-white mb-4">Fitur & Keunggulan Utama</h2>
                <ul class="space-y-3 text-sm text-zinc-300">
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">✓</span> Integrasi langsung dengan standar protokol HL7 dan DICOM.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">✓</span> OHIF Web Viewer responsif untuk kemudahan akses dokter dari ruang kerja maupun mobile.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">✓</span> Keamanan data terenkripsi tinggi sesuai standar regulasi rekam medis.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-accent font-bold">✓</span> Mengurangi waktu tunggu pelayanan pasien secara signifikan.
                    </li>
                </ul>
            </section>
        </div>

        <!-- Tombol Aksi Bawah -->
        <div class="mt-12 pt-8 border-t border-zinc-800 flex flex-wrap items-center justify-between gap-4">
            <a href="/#contact" class="bg-accent hover:bg-sky-600 text-white text-sm font-medium px-6 py-3 rounded-full transition-colors shadow-lg">
                Konsultasi Implementasi Sistem &rarr;
            </a>
            <a href="/" class="text-xs text-zinc-400 hover:text-white transition-colors">
                Kembali ke Beranda Utama
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-zinc-900 border-t border-zinc-800 py-8 text-center text-xs text-zinc-500">
        <p>© <span id="yr"></span> PT INNOVENTRA SOLUSI DIGITAL. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById('yr').textContent = new Date().getFullYear();
    </script>
</body>

</html>
