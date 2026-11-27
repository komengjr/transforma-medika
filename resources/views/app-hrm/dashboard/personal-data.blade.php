@extends('layouts.layouts')

@section('base.css')
<link href="{{ asset('vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (HRM PROFILE)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-purple: #7c3aed;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        overflow: hidden;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .ent-card > .card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px 14px 0 0;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 9999px;
        color: #f8fafc;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        letter-spacing: 0.03em;
    }

    .profile-avatar-vibrant {
        width: 102px;
        height: 102px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.75);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.28);
        object-fit: cover;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-stat-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
        height: 100%;
    }

    .ent-sub-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.025);
    }

    .ent-section-head {
        background-color: rgba(79, 70, 229, 0.04);
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .icon-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        color: #ffffff;
    }

    .icon-indigo { background: linear-gradient(135deg, #4f46e5, #4338ca); }
    .icon-emerald { background: linear-gradient(135deg, #059669, #047857); }
    .icon-sky { background: linear-gradient(135deg, #0284c7, #0369a1); }
    .icon-amber { background: linear-gradient(135deg, #d97706, #b45309); }
    .icon-rose { background: linear-gradient(135deg, #e11d48, #be123c); }
    .icon-purple { background: linear-gradient(135deg, #7c3aed, #5b21b6); }

    .progress-bar-indigo { background: linear-gradient(90deg, #4f46e5, #6366f1); }
    .progress-bar-emerald { background: linear-gradient(90deg, #059669, #10b981); }
    .progress-bar-amber { background: linear-gradient(90deg, #d97706, #f59e0b); }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        padding: 10px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .gallery-img-vibrant {
        width: 100%;
        height: 88px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--ent-grid-border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .gallery-img-vibrant:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.16);
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<!-- Header Card Profile -->
<div class="ent-card mb-4 fs-2">
    <div class="ent-hero-banner p-4 p-md-5">
        <div class="row align-items-center g-3 position-relative" style="z-index: 2;">
            <div class="col-auto text-center text-sm-start mx-auto mx-sm-0">
                <img class="profile-avatar-vibrant" src="{{ asset('asset/img/team/4.jpg') }}" alt="Profile" />
            </div>
            <div class="col-sm text-center text-sm-start">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-2 mb-1">
                    <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">{{ Auth::user()->fullname }}</h4>
                    <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.35); color: #6ee7b7;">
                        <i class="fas fa-check-circle me-1"></i>Verified Staff
                    </span>
                </div>
                <p class="fw-medium fs--1 mb-2" style="color: #cbd5e1;">Senior Software Engineer &bull; Divisi Teknologi Informasi</p>
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-2 fs--2">
                    <span class="ent-glass-pill px-3 py-1 ent-mono">
                        <i class="fas fa-id-card me-1 text-info"></i> {{ Auth::user()->access_code ?? 'EMP-2025-001' }}
                    </span>
                    <span class="ent-glass-pill px-3 py-1">
                        <i class="fas fa-map-marker-alt me-1 text-warning"></i> Jakarta, Indonesia
                    </span>
                    <span class="ent-glass-pill px-3 py-1">
                        <i class="fas fa-envelope me-1 text-info"></i> {{ Auth::user()->email ?? 'user@company.com' }}
                    </span>
                </div>
            </div>
            <div class="col-12 col-md-auto text-center text-md-end pt-2 pt-md-0">
                <button class="btn ent-btn btn-light text-primary px-3 py-2 shadow-sm border-0 fs-2" type="button" data-bs-toggle="modal" data-bs-target="#modal-hrm" id="button-update-desc-pegawai">
                    <i class="fas fa-edit me-1"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="ent-stat-box border-start border-2 border-primary">
                    <div class="fw-bold text-uppercase text-primary fs--2" style="letter-spacing: 0.04em;">Skor KPI (Q2)</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-bold text-primary ent-mono">92.5<span class="fs--2 opacity-75 fw-normal">/100</span></span>
                        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">Sangat Baik</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="ent-stat-box border-start border-2 border-success">
                    <div class="fw-bold text-uppercase text-success fs--2" style="letter-spacing: 0.04em;">Kehadiran (Bulan Ini)</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-bold text-success ent-mono">98%</span>
                        <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">21/22 Hari</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="ent-stat-box border-start border-2 border-info">
                    <div class="fw-bold text-uppercase text-info fs--2" style="letter-spacing: 0.04em;">Keterlambatan</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-bold text-info ent-mono">0 <span class="fs--2 opacity-75 fw-normal">Kali</span></span>
                        <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);">Tepat Waktu</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="ent-stat-box border-start border-2 border-warning">
                    <div class="fw-bold text-uppercase text-warning fs--2" style="letter-spacing: 0.04em;">Sisa Cuti Annual</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-bold text-warning ent-mono">8 <span class="fs--2 opacity-75 fw-normal">Hari</span></span>
                        <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.25);">dari 12</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3 fs-2">
    <!-- Kolom Utama -->
    <div class="col-lg-8">

        <!-- Card Penilaian KPI -->
        <div class="ent-card mb-3">
            <div class="p-3 px-4 ent-section-head d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge icon-indigo">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h6 class="mb-0 fw-bold fs-1">Penilaian Kinerja KPI</h6>
                </div>
                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">Evaluasi Q2</span>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="p-3 mb-3 ent-sub-box border-start border-2 border-primary">
                        <div class="d-flex justify-content-between fs-2 mb-2">
                            <span class="fw-bold"><i class="fas fa-tasks text-primary me-2"></i>Penyelesaian Proyek &amp; Target System (Bobot 40%)</span>
                            <span class="fw-bold text-primary ent-mono fs-1">95%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px; background-color: rgba(79, 70, 229, 0.12);">
                            <div class="progress-bar progress-bar-indigo rounded-pill" style="width: 95%" role="progressbar"></div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 ent-sub-box border-start border-2 border-success">
                        <div class="d-flex justify-content-between fs-2 mb-2">
                            <span class="fw-bold"><i class="fas fa-code text-success me-2"></i>Kualitas Kode &amp; Standar Arsitektur (Bobot 30%)</span>
                            <span class="fw-bold text-success ent-mono fs-1">90%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px; background-color: rgba(16, 185, 129, 0.12);">
                            <div class="progress-bar progress-bar-emerald rounded-pill" style="width: 90%" role="progressbar"></div>
                        </div>
                    </div>

                    <div class="p-3 ent-sub-box border-start border-2 border-warning">
                        <div class="d-flex justify-content-between fs-2 mb-2">
                            <span class="fw-bold"><i class="fas fa-users text-warning me-2"></i>Kerjasama Tim &amp; Kedisiplinan Kerja (Bobot 30%)</span>
                            <span class="fw-bold text-warning ent-mono fs-1">92%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px; background-color: rgba(245, 158, 11, 0.12);">
                            <div class="progress-bar progress-bar-amber rounded-pill" style="width: 92%" role="progressbar"></div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Atasan -->
                <div class="p-3 rounded-3" style="background: rgba(2, 132, 199, 0.06); border: 1px solid rgba(2, 132, 199, 0.18);">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">Catatan Kinerja Atasan</span>
                        <span class="opacity-75 fs--2">&bull; Oleh Manager IT</span>
                    </div>
                    <p class="fs--1 opacity-75 mb-0" style="line-height: 1.6;">
                        "Kinerja pegawai sangat memuaskan pada kuartal ini. Berhasil memimpin integrasi arsitektur sistem baru secara tepat waktu tanpa hambatan (<em>zero downtime</em>)."
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Rekap Kehadiran -->
        <div class="ent-card mb-3">
            <div class="p-3 px-4 ent-section-head d-flex align-items-center gap-2">
                <div class="icon-badge icon-emerald">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h6 class="mb-0 fw-bold fs-1">Rekapitulasi Kehadiran &amp; Presensi</h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom">
                        <thead>
                            <tr class="fs--2">
                                <th>Status Kehadiran</th>
                                <th class="text-center">Jumlah Hari</th>
                                <th class="text-center">Persentase</th>
                                <th class="text-end">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="fs-2">
                            <tr>
                                <td><span class="ent-badge fs--2 me-2" style="background: rgba(16, 185, 129, 0.12); color: #10b981;"><i class="fas fa-check"></i></span><strong>Hadir Tepat Waktu</strong></td>
                                <td class="text-center fw-bold ent-mono">21 Hari</td>
                                <td class="text-center text-success fw-bold ent-mono">95.4%</td>
                                <td class="text-end"><span class="badge bg-success text-white fs--2">Sesuai Jam Kerja</span></td>
                            </tr>
                            <tr>
                                <td><span class="ent-badge fs--2 me-2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;"><i class="fas fa-clock"></i></span><strong>Terlambat Masuk</strong></td>
                                <td class="text-center fw-bold ent-mono">0 Hari</td>
                                <td class="text-center opacity-75 ent-mono">0%</td>
                                <td class="text-end"><span class="badge bg-info text-white fs--2">Nihil</span></td>
                            </tr>
                            <tr>
                                <td><span class="ent-badge fs--2 me-2" style="background: rgba(245, 158, 11, 0.12); color: #d97706;"><i class="fas fa-umbrella-beach"></i></span><strong>Izin / Cuti Resmi</strong></td>
                                <td class="text-center fw-bold ent-mono">1 Hari</td>
                                <td class="text-center text-warning fw-bold ent-mono">4.6%</td>
                                <td class="text-end"><span class="badge bg-warning text-dark fs--2">Cuti Tahunan</span></td>
                            </tr>
                            <tr>
                                <td><span class="ent-badge fs--2 me-2" style="background: rgba(225, 29, 72, 0.12); color: #e11d48;"><i class="fas fa-times"></i></span><strong>Tanpa Keterangan</strong></td>
                                <td class="text-center fw-bold ent-mono">0 Hari</td>
                                <td class="text-center opacity-75 ent-mono">0%</td>
                                <td class="text-end"><span class="badge bg-secondary text-white fs--2">Nihil</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Deskripsi Pegawai Card -->
        <div class="ent-card mb-3">
            <div class="p-3 px-4 ent-section-head d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge icon-sky">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <h6 class="mb-0 fw-bold fs-1">Deskripsi &amp; Profil Singkat</h6>
                </div>
            </div>
            <div class="card-body p-4">
                <p class="fs-2 opacity-75 mb-0" style="line-height: 1.65;">
                    Dedicated Full Stack Developer dengan pengalaman lebih dari 9 tahun dalam pengelolaan infrastruktur cloud, pengolahan aplikasi web skala besar, serta integrasi sistem enterprise. Memiliki komitmen tinggi terhadap kualitas kode dan hasil kerja.
                </p>
            </div>
        </div>

        <!-- Galeri Foto Card -->
        <div class="ent-card">
            <div class="p-3 px-4 ent-section-head d-flex align-items-center gap-2">
                <div class="icon-badge icon-rose">
                    <i class="fas fa-images"></i>
                </div>
                <h6 class="mb-0 fw-bold fs-1">Dokumentasi &amp; Galeri Kegiatan</h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="row g-2">
                    <div class="col-6 col-sm-3">
                        <a class="glightbox" href="{{ asset('asset/img/generic/4.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/generic/4.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a class="glightbox" href="{{ asset('asset/img/generic/5.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/generic/5.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a class="glightbox" href="{{ asset('asset/img/gallery/4.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/gallery/4.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a class="glightbox" href="{{ asset('asset/img/gallery/5.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/gallery/5.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Kolom Kanan / Sidebar -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">

            <!-- Pengalaman Kerja Card -->
            <div class="ent-card mb-3">
                <div class="p-3 px-4 ent-section-head d-flex align-items-center gap-2">
                    <div class="icon-badge icon-purple">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h6 class="mb-0 fw-bold fs-1">Pengalaman Kerja</h6>
                </div>
                <div class="card-body p-3 fs-2">
                    <div class="p-3 mb-2 ent-sub-box border-start border-2 border-primary">
                        <div class="fw-bold">Big Data Engineer</div>
                        <div class="text-primary fw-semibold fs--1">Google Inc.</div>
                        <span class="opacity-75 ent-mono fs--2 d-block mt-1"><i class="far fa-clock me-1"></i>2018 - Sekarang</span>
                    </div>
                    <div class="p-3 mb-2 ent-sub-box border-start border-2 border-info">
                        <div class="fw-bold">Software Engineer</div>
                        <div class="text-info fw-semibold fs--1">Apple Inc.</div>
                        <span class="opacity-75 ent-mono fs--2 d-block mt-1"><i class="far fa-clock me-1"></i>2015 - 2018</span>
                    </div>
                    <div class="p-3 ent-sub-box border-start border-2 border-warning">
                        <div class="fw-bold">Mobile Developer</div>
                        <div class="text-warning fw-semibold fs--1">Nike Tech</div>
                        <span class="opacity-75 ent-mono fs--2 d-block mt-1"><i class="far fa-clock me-1"></i>2013 - 2015</span>
                    </div>
                </div>
            </div>

            <!-- Pendidikan Card -->
            <div class="ent-card mb-3">
                <div class="p-3 px-4 ent-section-head d-flex align-items-center gap-2">
                    <div class="icon-badge icon-amber">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h6 class="mb-0 fw-bold fs-1">Riwayat Pendidikan</h6>
                </div>
                <div class="card-body p-3 fs-2">
                    <div class="p-3 mb-2 ent-sub-box border-start border-2 border-warning">
                        <div class="fw-bold">Stanford University</div>
                        <div class="opacity-75 fs--1">S1 Computer Science</div>
                        <span class="text-warning fw-bold ent-mono fs--2 d-block mt-1">2009 - 2013</span>
                    </div>
                    <div class="p-3 ent-sub-box border-start border-2 border-secondary">
                        <div class="fw-bold">Staten Island High</div>
                        <div class="opacity-75 fs--1">IPA / Science</div>
                        <span class="opacity-75 fw-bold ent-mono fs--2 d-block mt-1">2006 - 2009</span>
                    </div>
                </div>
            </div>

            <!-- Log Aktivitas Card -->
            <div class="ent-card">
                <div class="p-3 px-4 ent-section-head d-flex align-items-center gap-2">
                    <div class="icon-badge icon-sky">
                        <i class="fas fa-history"></i>
                    </div>
                    <h6 class="mb-0 fw-bold fs-1">Log Aktivitas Terbaru</h6>
                </div>
                <div class="card-body p-3 fs-2">
                    <div class="d-flex align-items-start gap-2 mb-2 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <span class="ent-badge fs--2 mt-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1;"><i class="fas fa-award"></i></span>
                        <div class="opacity-75 fs--1">
                            <strong class="ent-mono">13 Nov:</strong> Penilaian KPI Q2 berhasil dikirim oleh atasan.
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2 mb-2 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <span class="ent-badge fs--2 mt-1" style="background: rgba(245, 158, 11, 0.12); color: #d97706;"><i class="fas fa-plane"></i></span>
                        <div class="opacity-75 fs--1">
                            <strong class="ent-mono">08 Nov:</strong> Pengajuan cuti tahunan disetujui (1 hari).
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="ent-badge fs--2 mt-1" style="background: rgba(16, 185, 129, 0.12); color: #10b981;"><i class="fas fa-file-alt"></i></span>
                        <div class="opacity-75 fs--1">
                            <strong class="ent-mono">01 Nov:</strong> Pembaruan dokumen sertifikasi pegawai.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-hrm" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ent-card border-0 shadow-lg overflow-hidden position-relative fs-2">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button type="button" class="btn-close btn-close-white bg-dark bg-opacity-50 p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-hrm"></div>
        </div>
    </div>
</div>

<script src="{{ asset('vendors/glightbox/glightbox.min.js') }}"></script>
<script>
    $(document).ready(function() {
        if (typeof GLightbox !== 'undefined') {
            GLightbox({
                selector: '.glightbox'
            });
        }
    });

    $(document).on("click", "#button-update-desc-pegawai", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-hrm').html(
            '<div class="p-5 text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 opacity-75 fs--1 mb-0">Memuat data pegawai...</p></div>'
        );
        $.ajax({
            url: "{{ route('personal_data_update_desc') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-hrm').html(data);
        }).fail(function() {
            $('#menu-hrm').html('<div class="p-4 text-center text-danger fs--1">Gagal memuat data.</div>');
        });
    });
</script>
@endsection
