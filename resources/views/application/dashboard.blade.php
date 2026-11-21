@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 15px 20px;
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.84rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
    }

    .ent-btn-light:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    /* Icon Box */
    .icon-shape-md {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    /* Feature Card Hover */
    .card-feature-hover {
        transition: all 0.2s ease;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 16px -4px rgba(15, 23, 42, 0.06);
    }

    .card-feature-hover:hover {
        transform: translateY(-3px);
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.16);
    }

    /* Pulse Badge */
    .pulse-badge {
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
        }

        70% {
            transform: scale(1.12);
        }

        100% {
            transform: scale(0.95);
        }
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* Accordion Styling */
    .ent-accordion .accordion-item {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px !important;
        overflow: hidden;
        margin-bottom: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .ent-accordion .accordion-button {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--bs-body-color);
        background-color: rgba(79, 70, 229, 0.06);
        box-shadow: none !important;
    }

    .ent-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.12);
        color: #6366f1;
    }
</style>
@endsection

@section('content')
<!-- Hero / Welcome Banner Rumah Sakit -->
<div class="card mb-3 ent-header-banner p-1">
    <div class="card-body position-relative p-4 p-lg-5" style="z-index: 2;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-9">
                <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1 mb-3">
                    <span class="pulse-badge me-2"></span>
                    <small class="fw-semibold" style="font-size: 0.78rem; color: #cbd5e1;">Innoventra Hospital &amp; Health Care</small>
                </div>

                <h2 class="fw-bold mb-2" style="letter-spacing: -0.02em; color: white;">
                    Sistem Informasi Manajemen Rumah Sakit
                </h2>
                <p class="mb-3 me-lg-5" style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.65;">
                    Selamat datang di portal pelayanan medis terpadu. Platform digital terintegrasi untuk mempercepat pelayanan pasien, rekam medis elektronik, serta tata kelola klinis yang presisi.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#modul-layanan" class="btn ent-btn ent-btn-light px-4 py-2">
                        <i class="fas fa-stethoscope me-2 text-primary"></i> Akses Modul Medis
                    </a>
                    <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalPanduan">
                        <i class="fas fa-play-circle me-2"></i> Panduan Alur Pelayanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Berwarna (Pilar Layanan Medis) -->
<div class="row g-3 g-md-4 mb-3">
    <!-- Card 1: Pendaftaran & Pasien -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-sky) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                    <i class="fas fa-hospital-user fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Pendaftaran</span>
                    <h6 class="fw-bold mb-0" style="font-size: 0.92rem;">Loket &amp; Antrean Pasien</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Rekam Medis (EMR) -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-emerald) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                    <i class="fas fa-notes-medical fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Rekam Medis</span>
                    <h6 class="fw-bold mb-0" style="font-size: 0.92rem;">EMR &amp; Diagnosa ICD-10</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Farmasi / Apotek -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-amber) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">
                    <i class="fas fa-pills fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Farmasi</span>
                    <h6 class="fw-bold mb-0" style="font-size: 0.92rem;">Resep &amp; Stok Obat</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Kasir & Pembayaran -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-indigo) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                    <i class="fas fa-file-invoice-dollar fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Kasir &amp; Billing</span>
                    <h6 class="fw-bold mb-0" style="font-size: 0.92rem;">Kasir / BPJS / Umum</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Modul Utama RS (Cards Grid) -->
<div class="ent-card mb-3" id="modul-layanan">
    <div class="ent-card-header d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                <i class="fas fa-clinic-medical"></i>
            </span>
            Modul Pelayanan Medis
        </h6>
        <span class="ent-badge" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);">Versi 2.0</span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="row g-3 g-md-4">
            <!-- Modul 1: Poliklinik & Rawat Jalan -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 4px solid var(--ent-sky) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                            <i class="fas fa-user-md fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Poli &amp; Rawat Jalan</h6>
                    </div>
                    <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                        Pemeriksaan dokter spesialis, input anamnesis, order laboratorium, radiologi, dan pembuatan resep elektronik (e-Prescription).
                    </p>
                    <span class="fw-semibold text-primary" style="font-size: 0.8rem;"><i class="fas fa-check-circle me-1"></i> Terhubung ke Poliklinik</span>
                </div>
            </div>

            <!-- Modul 2: Rawat Inap (Inpatient) -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 4px solid var(--ent-emerald) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                            <i class="fas fa-procedures fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Rawat Inap &amp; Bed</h6>
                    </div>
                    <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                        Manajemen alokasi tempat tidur (bed management), visi dokter, catatan perkembangan pasien terintegrasi (CPPT), serta perawat.
                    </p>
                    <span class="fw-semibold text-success" style="font-size: 0.8rem;"><i class="fas fa-check-circle me-1"></i> Realtime Bed Availability</span>
                </div>
            </div>

            <!-- Modul 3: Laboratorium & Radiologi -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100" style="border-top: 4px solid var(--ent-amber) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md me-3" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">
                            <i class="fas fa-microscope fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Penunjang Medis</h6>
                    </div>
                    <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                        Pengelolaan sampel laboratorium, integrasi hasil pemeriksaan radiologi (X-Ray, USG, CT-Scan) secara otomatis ke rekam medis.
                    </p>
                    <span class="fw-semibold text-warning" style="font-size: 0.8rem;"><i class="fas fa-check-circle me-1"></i> Integrasi LIS &amp; PACS</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accordion Informasi & Help Center Rumah Sakit -->
<div class="ent-card mb-3">
    <div class="ent-card-header">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-question-circle text-primary"></i> Informasi Panduan Operasional RS
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="accordion border-0 ent-accordion" id="accordionHospital">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1">
                        <i class="fas fa-laptop-medical me-2 text-primary"></i> Bagaimana cara melakukan registrasi pasien baru?
                    </button>
                </h2>
                <div id="collapseFaq1" class="accordion-collapse collapse show" data-bs-parent="#accordionHospital">
                    <div class="accordion-body opacity-75" style="font-size: 0.85rem; line-height: 1.65;">
                        Akses menu <strong>Menu Utama &gt; Loket Pendaftaran</strong>, lalu tekan tombol <em>+ Pasien Baru</em>. Isikan data identitas pasien (KTP/BPJS) secara lengkap untuk mendapatkan Nomor Rekam Medis (RM) otomatis.
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-0">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2">
                        <i class="fas fa-shield-alt me-2 text-success"></i> Bagaimana proses bridging klaim BPJS Kesehatan?
                    </button>
                </h2>
                <div id="collapseFaq2" class="accordion-collapse collapse" data-bs-parent="#accordionHospital">
                    <div class="accordion-body opacity-75" style="font-size: 0.85rem; line-height: 1.65;">
                        Sistem telah terintegrasi dengan V-Claim BPJS. Petugas loket dapat menerbitkan Surat Elegibilitas Peserta (SEP) secara langsung saat proses pendaftaran pasien rawat jalan maupun rawat inap.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
