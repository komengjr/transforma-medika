@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PORTAL HRIS)
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
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card > .card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
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

    .hover-lift {
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        border-color: rgba(79, 70, 229, 0.55) !important;
        box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.15) !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #059669, #047857);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #d97706, #b45309);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #0284c7, #0369a1);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #e11d48, #be123c);
    }

    .bg-gradient-purple {
        background: linear-gradient(135deg, #7c3aed, #5b21b6);
    }

    .module-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        flex-shrink: 0;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.16);
    }

    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background-color: rgba(79, 70, 229, 0.1);
        border: 1px solid var(--ent-grid-border);
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        font-size: 0.82rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-accordion-item {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: transparent !important;
        overflow: hidden;
    }

    .ent-accordion-button {
        background-color: rgba(79, 70, 229, 0.04) !important;
        color: var(--bs-body-color) !important;
        box-shadow: none !important;
    }

    .ent-accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.1) !important;
    }

    .ent-accordion-body {
        background-color: var(--bs-body-bg, var(--ent-surface));
        border-top: 1px solid var(--ent-grid-border);
    }
</style>
@endsection

@section('content')
<!-- 1. HERO BANNER MODERN -->
<div class="card ent-hero-banner text-white mb-4">
    <div class="card-body p-4 p-lg-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                        <i class="fas fa-sparkles me-1"></i> Portal Resmi HRIS Internal
                    </span>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Employee Self Service</span>
                </div>
                <h2 class="text-white fw-bold mb-2" style="letter-spacing: -0.02em;">Selamat Datang di Portal HR! 👋</h2>
                <p class="mb-4 small" style="color: #cbd5e1; max-width: 540px; line-height: 1.6;">
                    Pusat kendali mandiri untuk mengelola kebutuhan karir, absensi, cuti, serta slip gaji Anda dengan transparan dan efisien.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-hr" class="btn ent-btn btn-light text-primary px-4 py-2 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Jelajahi Modul
                    </a>
                    <a href="#faq-hr" class="btn ent-btn btn-outline-light px-4 py-2">
                        <i class="fas fa-question-circle me-2"></i>Pusat Bantuan
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80"
                    alt="Human Resource Team"
                    class="img-fluid rounded-4 shadow-lg"
                    style="max-height: 225px; width: 100%; object-fit: cover; border: 2px solid rgba(255, 255, 255, 0.22);">
            </div>
        </div>
    </div>
</div>

<!-- 2. QUICK STATS / INFORMATION CARDS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card hover-lift h-100 border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <div class="text-uppercase opacity-75 mb-1 fw-bold" style="font-size: 0.68rem; letter-spacing: 0.04em;">Sisa Cuti Tahunan</div>
                    <h4 class="mb-0 text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">
                        12 <span class="fs-2 opacity-75 fw-semibold">Hari</span>
                    </h4>
                </div>
                <div class="stat-icon-box text-primary">
                    <i class="fas fa-calendar-check fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ent-card hover-lift h-100 border-start border-4 border-success">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <div class="text-uppercase opacity-75 mb-1 fw-bold" style="font-size: 0.68rem; letter-spacing: 0.04em;">Status Kehadiran</div>
                    <h4 class="mb-0 text-success fw-bold" style="font-size: 1.15rem;">Tepat Waktu</h4>
                </div>
                <div class="stat-icon-box text-success">
                    <i class="fas fa-user-clock fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ent-card hover-lift h-100 border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <div class="text-uppercase opacity-75 mb-1 fw-bold" style="font-size: 0.68rem; letter-spacing: 0.04em;">Pengajuan Pending</div>
                    <h4 class="mb-0 text-warning fw-bold" style="font-family: 'JetBrains Mono', monospace;">
                        1 <span class="fs-2 opacity-75 fw-semibold">Dokumen</span>
                    </h4>
                </div>
                <div class="stat-icon-box text-warning">
                    <i class="fas fa-hourglass-half fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ent-card hover-lift h-100 border-start border-4 border-info">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <div class="text-uppercase opacity-75 mb-1 fw-bold" style="font-size: 0.68rem; letter-spacing: 0.04em;">Periode Gaji</div>
                    <h4 class="mb-0 text-info fw-bold" style="font-size: 1.15rem;">November 2026</h4>
                </div>
                <div class="stat-icon-box text-info">
                    <i class="fas fa-receipt fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL-MODUL PERKENALAN HR -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3" id="modul-hr">
    <div>
        <h5 class="mb-0 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Modul Layanan HR</h5>
        <p class="opacity-75 small mb-0">Pilih modul di bawah untuk mengakses layanan lengkap Human Resources.</p>
    </div>
    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.28);">
        6 Modul Aktif
    </span>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Profil & Data Karyawan -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-primary text-white me-3">
                        <i class="fas fa-id-card fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Profil &amp; Data Diri</h6>
                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">Employee Self Service</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Kelola biodata diri, riwayat pendidikan, keluarga, serta unggah dokumen resmi secara mandiri dan cepat.</p>
                <a href="#" class="btn ent-btn btn-outline-primary rounded-pill w-100 mt-auto">
                    Buka Profil <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Absensi & Presensi -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-success text-white me-3">
                        <i class="fas fa-fingerprint fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Presensi &amp; Jam Kerja</h6>
                        <span class="ent-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">Real-time Clock-in</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Catat jam masuk/keluar harian, pengajuan koreksi presensi, lembur, dan riwayat kehadiran bulanan Anda.</p>
                <a href="#" class="btn ent-btn btn-outline-success rounded-pill w-100 mt-auto">
                    Lihat Absensi <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Cuti & Perizinan -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-warning text-white me-3">
                        <i class="fas fa-plane-departure fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Manajemen Cuti</h6>
                        <span class="ent-badge" style="background: rgba(245, 158, 11, 0.16); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.38);">Sistem Persetujuan</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Pengajuan cuti tahunan, sakit, izin khusus, serta pantau alur persetujuan dari atasan secara langsung.</p>
                <a href="#" class="btn ent-btn btn-outline-warning rounded-pill w-100 mt-auto">
                    Ajukan Cuti <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Payroll & Slip Gaji -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-info text-white me-3">
                        <i class="fas fa-wallet fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Payroll &amp; Slip Gaji</h6>
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.15); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35);">Kerahasiaan Terjamin</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Unduh slip gaji digital bulanan, cek rincian tunjangan, insentif, potongan BPJS, dan PPh 21 secara rinci.</p>
                <a href="#" class="btn ent-btn btn-outline-info rounded-pill w-100 mt-auto">
                    Unduh Slip Gaji <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Penilaian Kinerja / KPI -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-purple text-white me-3">
                        <i class="fas fa-chart-line fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Performa &amp; KPI</h6>
                        <span class="ent-badge" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed; border: 1px solid rgba(124, 58, 237, 0.35);">Performance Review</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Pantau target kinerja semesteran, ikuti penilaian mandiri (self-assessment), dan lihat hasil ulasan kinerja.</p>
                <a href="#" class="btn ent-btn btn-outline-primary rounded-pill w-100 mt-auto">
                    Cek Kinerja <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Pelatihan & Development -->
    <div class="col-md-6 col-xl-4">
        <div class="ent-card hover-lift h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-danger text-white me-3">
                        <i class="fas fa-graduation-cap fs-2"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Pengembangan &amp; Pelatihan</h6>
                        <span class="ent-badge" style="background: rgba(225, 29, 72, 0.15); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">Skill Building</span>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Akses program pelatihan internal, sertifikasi, dan jadwalkan sesi workshop penunjang karir Anda.</p>
                <a href="#" class="btn ent-btn btn-outline-danger rounded-pill w-100 mt-auto">
                    Ikuti Pelatihan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. BANNER INFORMASI BUDAYA PERUSAHAAN -->
<div class="ent-card mb-4">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80"
                alt="Budaya Kerja Perusahaan"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; min-height: 210px;">
        </div>
        <div class="col-md-7 d-flex align-items-center">
            <div class="card-body p-4">
                <span class="ent-badge mb-2" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">
                    Budaya Kerja Kami
                </span>
                <h5 class="fw-bold mb-2">Tumbuh Bersama &amp; Menginspirasi</h5>
                <p class="opacity-75 small mb-3" style="line-height: 1.6;">
                    Kami percaya bahwa kesuksesan perusahaan berawal dari kebahagiaan dan produktivitas setiap individu di dalamnya. Pastikan dokumen dan performa Anda selalu terbarukan melalui sistem HRIS ini.
                </p>
                <a href="#" class="btn ent-btn btn-primary rounded-pill px-4">Lihat Kegiatan Tim</a>
            </div>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ INTERAKTIF -->
<div class="ent-card mb-3" id="faq-hr">
    <div class="card-header py-3 px-4" style="background-color: rgba(79, 70, 229, 0.06);">
        <div class="d-flex align-items-center">
            <div class="stat-icon-box text-info me-3" style="width: 38px; height: 38px;">
                <i class="fas fa-question-circle"></i>
            </div>
            <h6 class="mb-0 fw-bold">Pertanyaan yang Sering Diajukan (FAQ)</h6>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="accordion accordion-flush" id="accordionHRFAQS">

            <div class="accordion-item ent-accordion-item mb-2">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button ent-accordion-button collapsed fw-bold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <i class="fas fa-calendar-plus me-2 text-warning"></i> Bagaimana cara mengajukan cuti?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body ent-accordion-body opacity-75 small">
                        Masuk ke modul <strong>Manajemen Cuti</strong>, tentukan tanggal mulai dan selesai, pilih jenis cuti (Tahunan/Sakit/Izin Khusus), sertakan catatan untuk atasan, lalu klik <em>Kirim Pengajuan</em>.
                    </div>
                </div>
            </div>

            <div class="accordion-item ent-accordion-item mb-2">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button ent-accordion-button collapsed fw-bold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <i class="fas fa-shield-alt me-2 text-primary"></i> Apakah data slip gaji saya aman?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body ent-accordion-body opacity-75 small">
                        Ya, modul <strong>Payroll</strong> dilindungi oleh enkripsi keamanan tingkat tinggi. Slip gaji hanya dapat dibuka menggunakan password akun pribadi milik Anda.
                    </div>
                </div>
            </div>

            <div class="accordion-item ent-accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button ent-accordion-button collapsed fw-bold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        <i class="fas fa-clock me-2 text-danger"></i> Lupa melakukan Clock-In presensi harian?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body ent-accordion-body opacity-75 small">
                        Anda dapat memanfaatkan fitur <em>"Koreksi Presensi"</em> pada modul <strong>Presensi &amp; Jam Kerja</strong> maksimal 2x24 jam dari hari H untuk disetujui oleh Supervisor/Manager Anda.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
