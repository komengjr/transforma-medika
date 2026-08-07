@extends('layouts.layouts')

@section('content')
<!-- Styling Khusus Tema Medis Berwarna -->
<style>
    .bg-gradient-hospital {
        background: linear-gradient(135deg, #06a6ef 0%, #2563eb 50%, #4f46e5 100%);
    }

    .icon-shape-md {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
    }

    .card-feature-hover {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-feature-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(14, 165, 233, 0.15) !important;
    }

    .pulse-badge {
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% {
            box-shadow: 0 0 0 0px rgba(16, 185, 129, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }

        100% {
            box-shadow: 0 0 0 0px rgba(16, 185, 129, 0);
        }
    }
</style>

<!-- Hero / Welcome Banner Rumah Sakit -->
<div class="card mb-3 border-0 shadow-sm overflow-hidden text-white bg-gradient-hospital rounded-4">
    <div class="card-body position-relative p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center bg-white bg-opacity-20 backdrop-blur rounded-pill px-3 py-1 mb-3 border border-white border-opacity-25">
                    <span class="badge bg-emerald-500 text-white rounded-circle p-1 me-2 pulse-badge" style="background-color: #10b981;">
                        <i class="fas fa-plus fs--2"></i>
                    </span>
                    <small class="fw-bold text-dark tracking-wide">Innoventra Hospital & Health Care</small>
                </div>

                <h1 class="fw-extrabold text-white mb-2 display-6">
                    Sistem Informasi Manajemen Rumah Sakit
                </h1>
                <p class="text-white text-opacity-85 fs-0 mb-4 me-lg-5">
                    Selamat datang di portal pelayanan medis terpadu. Platform digital terintegrasi untuk mempercepat pelayanan pasien, rekam medis elektronik, serta tata kelola klinis yang presisi.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-layanan" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-stethoscope me-2 text-primary"></i> Akses Modul Medis
                    </a>
                    <button class="btn btn-outline-light rounded-pill px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalPanduan">
                        <i class="fas fa-play-circle me-2"></i> Panduan Alur Pelayanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Berwarna (Pilar Layanan Medis) -->
<div class="row g-3 mb-3">
    <!-- Card 1: Pendaftaran & Pasien -->
    <div class="col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border-start border-4 border-info">
            <div class="card-body d-flex align-items-center p-3">
                <div class="icon-shape-md bg-info bg-opacity-10 text-white me-3">
                    <i class="fas fa-hospital-user fs-2"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold fs--1 d-block">Pendaftaran</span>
                    <h6 class="fw-bold text-dark mb-0">Loket & Antrean Pasien</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Rekam Medis (EMR) -->
    <div class="col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border-start border-4 border-emerald" style="border-color: #10b981 !important;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="icon-shape-md text-emerald me-3" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-notes-medical fs-2"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold fs--1 d-block">Rekam Medis</span>
                    <h6 class="fw-bold text-dark mb-0">EMR & Diagnosa ICD-10</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Farmasi / Apotek -->
    <div class="col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center p-3">
                <div class="icon-shape-md bg-warning bg-opacity-10 text-white me-3">
                    <i class="fas fa-pills fs-2"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold fs--1 d-block">Farmasi</span>
                    <h6 class="fw-bold text-dark mb-0">Resep & Stok Obat</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Kasir & Pembayaran -->
    <div class="col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border-start border-4 border-purple" style="border-color: #a855f7 !important;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="icon-shape-md me-3" style="background-color: rgba(168, 85, 247, 0.1); color: #a855f7;">
                    <i class="fas fa-file-invoice-dollar fs-2"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold fs--1 d-block">Kasir & Billing</span>
                    <h6 class="fw-bold text-dark mb-0">Kasir / BPJS / Umum</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Modul Utama RS (Colorful Cards Grid) -->
<div class="card border-0 shadow-sm mb-3 rounded-4" id="modul-layanan">
    <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <span class="p-2 rounded-3 me-2" style="background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white;">
                <i class="fas fa-clinic-medical"></i>
            </span>
            Modul Pelayanan Medis
        </h5>
        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-1 fw-semibold">Versi 2.0</span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4">
            <!-- Modul 1: Poliklinik & Rawat Jalan -->
            <div class="col-md-4">
                <div class="p-4 rounded-4 card-feature-hover h-100" style="background: linear-gradient(180deg, rgba(14, 165, 233, 0.05) 0%, rgba(255, 255, 255, 0) 100%); border-top: 3px solid #0ea5e9;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md bg-info text-white me-3 shadow-sm" style="background: linear-gradient(135deg, #38bdf8, #0284c7) !important;">
                            <i class="fas fa-user-md fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark fs-0">Poli & Rawat Jalan</h6>
                    </div>
                    <p class="text-secondary fs--1 mb-3">
                        Pemeriksaan dokter spesialis, input anamnesis, order laboratorium, radiologi, dan pembuatan resep elektronik (e-Prescription).
                    </p>
                    <span class="text-info fw-bold fs--1"><i class="fas fa-check-circle me-1"></i> Terhubung ke Poliklinik</span>
                </div>
            </div>

            <!-- Modul 2: Rawat Inap (Inpatient) -->
            <div class="col-md-4">
                <div class="p-4 rounded-4 card-feature-hover h-100" style="background: linear-gradient(180deg, rgba(16, 185, 129, 0.05) 0%, rgba(255, 255, 255, 0) 100%); border-top: 3px solid #10b981;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md text-white me-3 shadow-sm" style="background: linear-gradient(135deg, #34d399, #059669) !important;">
                            <i class="fas fa-procedures fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark fs-0">Rawat Inap & Bed</h6>
                    </div>
                    <p class="text-secondary fs--1 mb-3">
                        Manajemen alokasi tempat tidur (bed management), visi dokter, catatan perkembangan pasien terintegrasi (CPPT), serta perawat.
                    </p>
                    <span class="text-success fw-bold fs--1"><i class="fas fa-check-circle me-1"></i> Realtime Bed Availability</span>
                </div>
            </div>

            <!-- Modul 3: Laboratorium & Radiologi -->
            <div class="col-md-4">
                <div class="p-4 rounded-4 card-feature-hover h-100" style="background: linear-gradient(180deg, rgba(245, 158, 11, 0.05) 0%, rgba(255, 255, 255, 0) 100%); border-top: 3px solid #f59e0b;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape-md text-white me-3 shadow-sm" style="background: linear-gradient(135deg, #fbbf24, #d97706) !important;">
                            <i class="fas fa-microscope fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark fs-0">Penunjang Medis</h6>
                    </div>
                    <p class="text-secondary fs--1 mb-3">
                        Pengelolaan sampel laboratorium, integrasi hasil pemeriksaan radiologi (X-Ray, USG, CT-Scan) secara otomatis ke rekam medis.
                    </p>
                    <span class="text-warning fw-bold fs--1"><i class="fas fa-check-circle me-1"></i> Integrasi LIS & PACS</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accordion Informasi & Help Center Rumah Sakit -->
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-transparent border-bottom py-3">
        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <i class="fas fa-question-circle text-primary me-2"></i> Informasi Panduan Operasional RS
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="accordion border-0" id="accordionHospital">
            <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button fw-bold text-dark collapsed bg-soft-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1">
                        <i class="fas fa-laptop-medical me-2 text-primary"></i> Bagaimana cara melakukan registrasi pasien baru?
                    </button>
                </h2>
                <div id="collapseFaq1" class="accordion-collapse collapse" data-bs-parent="#accordionHospital">
                    <div class="accordion-body text-secondary fs--1 bg-white">
                        Akses menu <strong>Menu Utama &gt; Loket Pendaftaran</strong>, lalu tekan tombol <em>+ Pasien Baru</em>. Isikan data identitas pasien (KTP/BPJS) secara lengkap untuk mendapatkan Nomor Rekam Medis (RM) otomatis.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-2 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button fw-bold text-dark collapsed bg-soft-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2">
                        <i class="fas fa-shield-alt me-2 text-success"></i> Bagaimana proses bridging klaim BPJS Kesehatan?
                    </button>
                </h2>
                <div id="collapseFaq2" class="accordion-collapse collapse" data-bs-parent="#accordionHospital">
                    <div class="accordion-body text-secondary fs--1 bg-white">
                        Sistem telah terintegrasi dengan V-Claim BPJS. Petugas loket dapat menerbitkan Surat Elegibilitas Peserta (SEP) secara langsung saat proses pendaftaran pasien rawat jalan maupun rawat inap.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
