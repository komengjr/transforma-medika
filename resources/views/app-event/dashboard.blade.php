@extends('layouts.layouts')

@section('content')
<style>
    .event-hero {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(29, 78, 216, 0.2);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }

    .step-icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
    }

    .workflow-connector {
        border-top: 2px dashed #cbd5e1;
        position: relative;
        top: 25px;
    }
</style>

<!-- 1. HERO HEADER INFORMATION -->
<div class="card event-hero text-white mb-4 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <span class="badge bg-soft-light text-warning mb-2 px-3 py-1 rounded-pill fs--1">
                    <i class="fas fa-info-circle me-1"></i> Sistem Manajemen Event & Presensi
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Alur Kerja Pengelolaan Event 🎪</h2>
                <p class="lead opacity-85 mb-0 fs-0">
                    Panduan operasional pembuatan event, penataan detail kelas & sesi, pengisian informasi kontak & pembayaran, hingga rekapitulasi kehadiran partisipan.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 2. DIAGRAM ALUR PROSES (WORKFLOW OVERVIEW) -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold text-800"><i class="fas fa-project-diagram text-primary me-2"></i>Tahapan Operasional Sistem</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-3 text-center position-relative">
            <!-- Langkah 1 -->
            <div class="col-md-4">
                <div class="p-3 rounded-3 bg-light border h-100">
                    <div class="step-icon-box bg-primary text-white mx-auto mb-3 shadow-sm">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <span class="badge bg-soft-primary text-primary mb-2">Langkah 1</span>
                    <h6 class="fw-bold text-dark mb-1">Create Event</h6>
                    <p class="text-600 fs--2 mb-0">Membuat master data event & mengunggah template logo acara.</p>
                </div>
            </div>

            <!-- Langkah 2 -->
            <div class="col-md-4">
                <div class="p-3 rounded-3 bg-light border h-100">
                    <div class="step-icon-box bg-info text-white mx-auto mb-3 shadow-sm">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <span class="badge bg-soft-info text-info mb-2">Langkah 2</span>
                    <h6 class="fw-bold text-dark mb-1">Setup Data Event</h6>
                    <p class="text-600 fs--2 mb-0">Konfigurasi sub event, kelas, sesi, contact person, & rekening bank.</p>
                </div>
            </div>

            <!-- Langkah 3 -->
            <div class="col-md-4">
                <div class="p-3 rounded-3 bg-light border h-100">
                    <div class="step-icon-box bg-success text-white mx-auto mb-3 shadow-sm">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <span class="badge bg-soft-success text-success mb-2">Langkah 3</span>
                    <h6 class="fw-bold text-dark mb-1">Laporan Kehadiran</h6>
                    <p class="text-600 fs--2 mb-0">Monitoring status presensi peserta & export data per kelas/sub event.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. DETAIL MODUL APLIKASI -->
<div class="row g-3 mb-4">
    <!-- Menu 1: Create Event -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="step-icon-box bg-soft-primary text-primary me-3">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">1. Menu Create Event</h5>
                        <small class="text-muted">Master Data & Logo</small>
                    </div>
                </div>
                <p class="text-600 fs--1 flex-grow-1">
                    Modul awal untuk mendaftarkan identitas dasar acara baru serta mengunggah aset visual seperti logo event yang nantinya akan digunakan pada e-ticket atau sertifikat.
                </p>
                <ul class="list-unstyled fs--1 text-700 mb-4">
                    <li class="mb-1"><i class="fas fa-check-circle text-primary me-2"></i>Registrasi Nama & Judul Event</li>
                    <li class="mb-1"><i class="fas fa-check-circle text-primary me-2"></i>Upload Asset / Template Logo</li>
                    <li><i class="fas fa-check-circle text-primary me-2"></i>Pengaturan Informasi Umum</li>
                </ul>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-auto">
                    Akses Create Event <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Menu 2: Data Event / Setup -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="step-icon-box bg-soft-info text-info me-3">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">2. Menu Data Event</h5>
                        <small class="text-muted">Konfigurasi & Detail Event</small>
                    </div>
                </div>
                <p class="text-600 fs--1 flex-grow-1">
                    Pusat pengaturan rinci acara untuk mendefinisikan struktur pelaksanaan, pembagian kelompok/kelas, hingga informasi transaksi pembayaran.
                </p>
                <ul class="list-unstyled fs--1 text-700 mb-4">
                    <li class="mb-1"><i class="fas fa-check-circle text-info me-2"></i>Setup Sub Event, Class, & Session</li>
                    <li class="mb-1"><i class="fas fa-check-circle text-info me-2"></i>Pengaturan Contact Person (CP)</li>
                    <li><i class="fas fa-check-circle text-info me-2"></i>Konfigurasi No. Rekening Event</li>
                </ul>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold mt-auto">
                    Kelola Data Event <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Menu 3: Laporan Kehadiran -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="step-icon-box bg-soft-success text-success me-3">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">3. Laporan Kehadiran</h5>
                        <small class="text-muted">Absensi & Rekapitulasi</small>
                    </div>
                </div>
                <p class="text-600 fs--1 flex-grow-1">
                    Modul monitoring partisipasi peserta untuk melihat status absensi secara real-time serta melakukan penarikan/export data rekapitulasi.
                </p>
                <ul class="list-unstyled fs--1 text-700 mb-4">
                    <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i>Monitoring Status Kehadiran</li>
                    <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i>Filter per Sub Event & Class</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Export Rekap Data (Excel/PDF)</li>
                </ul>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold mt-auto">
                    Buka Laporan Kehadiran <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. PANDUAN PENGGUNAAN SINGKAT -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <h5 class="mb-0 fw-bold text-800"><i class="fas fa-book-reader text-warning me-2"></i>Panduan Ringkas Pengoperasian</h5>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionGuide">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="guideHeading1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#guideCollapse1">
                        <i class="fas fa-plus me-2 text-primary"></i> Bagaimana cara memulai pendaftaran event baru?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="guideCollapse1" data-bs-parent="#accordionGuide">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Akses menu <strong>Create Event</strong> untuk mengisi data dasar acara dan mengunggah gambar/template logo event. Setelah disimpan, sistem akan menghasilkan ID Master Event yang siap dikonfigurasi lebih lanjut.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="guideHeading2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#guideCollapse2">
                        <i class="fas fa-cog me-2 text-info"></i> Kapan saya harus mengatur Contact Person & No. Rekening?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="guideCollapse2" data-bs-parent="#accordionGuide">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Pengaturan Contact Person dan Nomor Rekening dilakukan pada menu <strong>Data Event</strong> setelah master event dibuat. Di menu ini Anda juga dapat membagi event menjadi beberapa <em>Sub Event</em>, <em>Class</em>, dan <em>Session</em>.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="guideHeading3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#guideCollapse3">
                        <i class="fas fa-download me-2 text-success"></i> Bagaimana cara mengunduh laporan kehadiran partisipan?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="guideCollapse3" data-bs-parent="#accordionGuide">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Buka menu <strong>Laporan Kehadiran</strong>, pilih filter <em>Sub Event</em> dan <em>Class</em> yang diinginkan, kemudian tekan tombol <strong>Export</strong> untuk mengunduh rekapitulasi data partisipan beserta status keikutsertaannya.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
