@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        /* background-color: #ffffff; */
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
        color: var(--retro-dark);
    }

    .retro-btn-light {
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .retro-btn-light:hover {
        background-color: #f1f1f1;
        color: var(--retro-dark);
    }

    /* Icon Shape Retro */
    .icon-shape-md {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 2px solid var(--retro-dark);
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    /* Card Feature Hover Retro */
    .card-feature-hover {
        transition: all 0.1s ease-in-out;
        border: 2px solid var(--retro-dark) !important;
        border-radius: 10px !important;
        box-shadow: 3px 3px 0px var(--retro-dark) !important;
        background-color: #ffffff;
    }

    .card-feature-hover:hover {
        transform: translate(-2px, -2px);
        box-shadow: 5px 5px 0px var(--retro-dark) !important;
        background-color: #ffffff;
    }

    /* Pulse Badge */
    .pulse-badge {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--retro-green);
        border: 2px solid var(--retro-dark);
        box-shadow: 2px 2px 0px var(--retro-dark);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
        }

        70% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(0.95);
        }
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- Hero / Welcome Banner Rumah Sakit -->
<div class="card mb-4 retro-header-banner p-1">
    <div class="card-body position-relative p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-1 mb-3" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                    <span class="pulse-badge me-2"></span>
                    <small class="fw-bolder text-dark tracking-wide">Innoventra Hospital & Health Care</small>
                </div>

                <h1 class="fw-bolder text-dark mb-2 display-6" style="text-shadow: 1px 1px 0px white;">
                    Sistem Informasi Manajemen Rumah Sakit
                </h1>
                <p class="text-dark fs-0 mb-4 me-lg-5 fw-bold opacity-75">
                    Selamat datang di portal pelayanan medis terpadu. Platform digital terintegrasi untuk mempercepat pelayanan pasien, rekam medis elektronik, serta tata kelola klinis yang presisi.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#modul-layanan" class="btn retro-btn retro-btn-light px-4 py-2">
                        <i class="fas fa-stethoscope me-2 text-dark"></i> Akses Modul Medis
                    </a>
                    <button class="btn retro-btn retro-btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalPanduan">
                        <i class="fas fa-play-circle me-2"></i> Panduan Alur Pelayanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Berwarna (Pilar Layanan Medis) -->
<div class="row g-4 mb-4">
    <!-- Card 1: Pendaftaran & Pasien -->
    <div class="col-sm-6 col-md-3">
        <div class="retro-card h-100 bg-white p-3" style="border-left: 6px solid var(--retro-cyan) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                    <i class="fas fa-hospital-user fs-2"></i>
                </div>
                <div>
                    <span class="text-dark fw-bold fs--1 d-block">Pendaftaran</span>
                    <h6 class="fw-bolder text-dark mb-0">Loket & Antrean Pasien</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Rekam Medis (EMR) -->
    <div class="col-sm-6 col-md-3">
        <div class="retro-card h-100 bg-white p-3" style="border-left: 6px solid var(--retro-green) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: var(--retro-green); color: var(--retro-dark);">
                    <i class="fas fa-notes-medical fs-2"></i>
                </div>
                <div>
                    <span class="text-dark fw-bold fs--1 d-block">Rekam Medis</span>
                    <h6 class="fw-bolder text-dark mb-0">EMR & Diagnosa ICD-10</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Farmasi / Apotek -->
    <div class="col-sm-6 col-md-3">
        <div class="retro-card h-100 bg-white p-3" style="border-left: 6px solid var(--retro-yellow) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                    <i class="fas fa-pills fs-2"></i>
                </div>
                <div>
                    <span class="text-dark fw-bold fs--1 d-block">Farmasi</span>
                    <h6 class="fw-bolder text-dark mb-0">Resep & Stok Obat</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Kasir & Pembayaran -->
    <div class="col-sm-6 col-md-3">
        <div class="retro-card h-100 bg-white p-3" style="border-left: 6px solid var(--retro-purple) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: var(--retro-purple); color: var(--retro-dark);">
                    <i class="fas fa-file-invoice-dollar fs-2"></i>
                </div>
                <div>
                    <span class="text-dark fw-bold fs--1 d-block">Kasir & Billing</span>
                    <h6 class="fw-bolder text-dark mb-0">Kasir / BPJS / Umum</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Modul Utama RS (Colorful Cards Grid) -->
<div class="retro-card mb-4" id="modul-layanan">
    <div class="card-header bg-white border-bottom border-dark py-3 px-4 d-flex align-items-center justify-content-between">
        <h5 class="fw-bolder mb-0 text-dark d-flex align-items-center">
            <span class="p-2 rounded-3 me-2" style="background-color: var(--retro-yellow); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark); color: var(--retro-dark);">
                <i class="fas fa-clinic-medical"></i>
            </span>
            Modul Pelayanan Medis
        </h5>
        <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">Versi 2.0</span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4">
            <!-- Modul 1: Poliklinik & Rawat Jalan -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 6px solid var(--retro-cyan) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                            <i class="fas fa-user-md fs-3"></i>
                        </div>
                        <h6 class="fw-bolder mb-0 text-dark fs-0">Poli & Rawat Jalan</h6>
                    </div>
                    <p class="text-dark fs--1 mb-3 fw-bold opacity-75">
                        Pemeriksaan dokter spesialis, input anamnesis, order laboratorium, radiologi, dan pembuatan resep elektronik (e-Prescription).
                    </p>
                    <span class="text-dark fw-bolder fs--1"><i class="fas fa-check-circle me-1 text-primary"></i> Terhubung ke Poliklinik</span>
                </div>
            </div>

            <!-- Modul 2: Rawat Inap (Inpatient) -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 6px solid var(--retro-green) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: var(--retro-green); color: var(--retro-dark);">
                            <i class="fas fa-procedures fs-3"></i>
                        </div>
                        <h6 class="fw-bolder mb-0 text-dark fs-0">Rawat Inap & Bed</h6>
                    </div>
                    <p class="text-dark fs--1 mb-3 fw-bold opacity-75">
                        Manajemen alokasi tempat tidur (bed management), visi dokter, catatan perkembangan pasien terintegrasi (CPPT), serta perawat.
                    </p>
                    <span class="text-dark fw-bolder fs--1"><i class="fas fa-check-circle me-1 text-success"></i> Realtime Bed Availability</span>
                </div>
            </div>

            <!-- Modul 3: Laboratorium & Radiologi -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 6px solid var(--retro-yellow) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                            <i class="fas fa-microscope fs-3"></i>
                        </div>
                        <h6 class="fw-bolder mb-0 text-dark fs-0">Penunjang Medis</h6>
                    </div>
                    <p class="text-dark fs--1 mb-3 fw-bold opacity-75">
                        Pengelolaan sampel laboratorium, integrasi hasil pemeriksaan radiologi (X-Ray, USG, CT-Scan) secara otomatis ke rekam medis.
                    </p>
                    <span class="text-dark fw-bolder fs--1"><i class="fas fa-check-circle me-1 text-warning"></i> Integrasi LIS & PACS</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accordion Informasi & Help Center Rumah Sakit -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark py-3 px-4">
        <h5 class="fw-bolder mb-0 text-dark d-flex align-items-center">
            <i class="fas fa-question-circle text-primary me-2"></i> Informasi Panduan Operasional RS
        </h5>
    </div>
    <div class="card-body p-4 bg-white">
        <div class="accordion border-0" id="accordionHospital">
            <div class="accordion-item mb-3 overflow-hidden" style="border: 2px solid var(--retro-dark); border-radius: 8px; box-shadow: 2px 2px 0px var(--retro-dark);">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button fw-bolder text-dark bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1" style="background-color: var(--retro-cyan) !important;">
                        <i class="fas fa-laptop-medical me-2 text-dark"></i> Bagaimana cara melakukan registrasi pasien baru?
                    </button>
                </h2>
                <div id="collapseFaq1" class="accordion-collapse collapse show" data-bs-parent="#accordionHospital">
                    <div class="accordion-body text-dark fs--1 bg-white fw-bold">
                        Akses menu <strong>Menu Utama &gt; Loket Pendaftaran</strong>, lalu tekan tombol <em>+ Pasien Baru</em>. Isikan data identitas pasien (KTP/BPJS) secara lengkap untuk mendapatkan Nomor Rekam Medis (RM) otomatis.
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-2 overflow-hidden" style="border: 2px solid var(--retro-dark); border-radius: 8px; box-shadow: 2px 2px 0px var(--retro-dark);">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button fw-bolder text-dark bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2" style="background-color: var(--retro-green) !important;">
                        <i class="fas fa-shield-alt me-2 text-dark"></i> Bagaimana proses bridging klaim BPJS Kesehatan?
                    </button>
                </h2>
                <div id="collapseFaq2" class="accordion-collapse collapse" data-bs-parent="#accordionHospital">
                    <div class="accordion-body text-dark fs--1 bg-white fw-bold">
                        Sistem telah terintegrasi dengan V-Claim BPJS. Petugas loket dapat menerbitkan Surat Elegibilitas Peserta (SEP) secara langsung saat proses pendaftaran pasien rawat jalan maupun rawat inap.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
