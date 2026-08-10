@extends('layouts.layouts')

@section('base.css')
<link href="{{ asset('vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
<style>
    /* =========================================================
       CSS VARIABLES (MODE TERANG & MODE GELAP)
       ========================================================= */
    :root {
        --card-bg: #ffffff;
        --card-border: #e2e8f0;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #64748b;
        --item-bg-subtle: #f8fafc;

        /* Soft Accent Backgrounds */
        --bg-soft-indigo: #e0e7ff;
        --bg-soft-emerald: #d1fae5;
        --bg-soft-sky: #e0f2fe;
        --bg-soft-amber: #fef3c7;
        --bg-soft-rose: #ffe4e6;
        --bg-soft-purple: #f3e8ff;
    }

    /* Otomatis aktif saat Dark Mode (Mendukung Bootstrap 5 data-bs-theme & class .dark) */
    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --card-bg: #1e293b;
        --card-border: #334155;
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --item-bg-subtle: #0f172a;

        /* Dark Mode Soft Accent Backgrounds */
        --bg-soft-indigo: rgba(99, 102, 241, 0.15);
        --bg-soft-emerald: rgba(16, 185, 129, 0.15);
        --bg-soft-sky: rgba(2, 132, 199, 0.15);
        --bg-soft-amber: rgba(245, 158, 11, 0.15);
        --bg-soft-rose: rgba(244, 63, 94, 0.15);
        --bg-soft-purple: rgba(168, 85, 247, 0.15);
    }

    /* Base Card Theme-Aware */
    .card-vibrant {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--card-border) !important;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    /* Dynamic Text Colors */
    .adaptive-text-main {
        color: var(--text-primary) !important;
    }

    .adaptive-text-sub {
        color: var(--text-secondary) !important;
    }

    .adaptive-text-muted {
        color: var(--text-muted) !important;
    }

    .adaptive-bg-subtle {
        background-color: var(--item-bg-subtle) !important;
    }

    /* Gradient Header Profile */
    .profile-hero-vibrant {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 50%, #10b981 100%);
        padding: 2.5rem 2rem 1.5rem 2rem;
        position: relative;
    }

    .profile-avatar-vibrant {
        width: 105px;
        height: 105px;
        border-radius: 50%;
        border: 4px solid var(--card-bg);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        object-fit: cover;
    }

    /* Adaptive Color Coded Headers */
    .card-header-indigo {
        background: var(--bg-soft-indigo);
        border-bottom: 2px solid #6366f1;
    }

    .card-header-emerald {
        background: var(--bg-soft-emerald);
        border-bottom: 2px solid #10b981;
    }

    .card-header-sky {
        background: var(--bg-soft-sky);
        border-bottom: 2px solid #0284c7;
    }

    .card-header-amber {
        background: var(--bg-soft-amber);
        border-bottom: 2px solid #f59e0b;
    }

    .card-header-rose {
        background: var(--bg-soft-rose);
        border-bottom: 2px solid #f43f5e;
    }

    .card-header-purple {
        background: var(--bg-soft-purple);
        border-bottom: 2px solid #a855f7;
    }

    /* Icon Badges */
    .icon-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
    }

    .icon-indigo {
        background-color: #6366f1;
        color: #ffffff;
    }

    .icon-emerald {
        background-color: #10b981;
        color: #ffffff;
    }

    .icon-sky {
        background-color: #0284c7;
        color: #ffffff;
    }

    .icon-amber {
        background-color: #f59e0b;
        color: #ffffff;
    }

    .icon-rose {
        background-color: #f43f5e;
        color: #ffffff;
    }

    .icon-purple {
        background-color: #a855f7;
        color: #ffffff;
    }

    /* Progress Bar */
    .progress-bar-indigo {
        background: linear-gradient(90deg, #6366f1, #4f46e5);
    }

    .progress-bar-emerald {
        background: linear-gradient(90deg, #10b981, #059669);
    }

    .progress-bar-amber {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    /* Gallery Highlight */
    .gallery-img-vibrant {
        width: 100%;
        height: 85px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--card-border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .gallery-img-vibrant:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
<!-- Header Card Profile (Vibrant Gradient) -->
<div class="card card-vibrant mb-3">
    <div class="profile-hero-vibrant text-white">
        <div class="row align-items-center g-3 position-relative" style="z-index: 2;">
            <div class="col-auto text-center text-sm-start">
                <img class="profile-avatar-vibrant" src="{{ asset('asset/img/team/4.jpg') }}" alt="Profile" />
            </div>
            <div class="col-sm text-center text-sm-start">
                <div class="d-flex align-items-center justify-content-center justify-content-sm-start gap-2 mb-1">
                    <h3 class="mb-0 fw-bold text-white">{{ Auth::user()->fullname }}</h3>
                    <span class="badge bg-white text-success rounded-pill fw-bold fs--2 shadow-sm px-2 py-1">
                        <i class="fas fa-check-circle me-1"></i>Verified Staff
                    </span>
                </div>
                <p class="text-white-50 fw-medium fs--1 mb-2">Senior Software Engineer &bull; Divisi Teknologi Informasi</p>
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-2 fs--2">
                    <span class="bg-white bg-opacity-20 text-dark px-2 py-1 rounded-pill">
                        <i class="fas fa-id-card me-1"></i> {{ Auth::user()->access_code ?? 'EMP-2025-001' }}
                    </span>
                    <span class="bg-white bg-opacity-20 text-dark px-2 py-1 rounded-pill">
                        <i class="fas fa-map-marker-alt me-1 text-warning"></i> Jakarta, Indonesia
                    </span>
                    <span class="bg-white bg-opacity-20 text-dark px-2 py-1 rounded-pill">
                        <i class="fas fa-envelope me-1 text-info"></i> {{ Auth::user()->email ?? 'user@company.com' }}
                    </span>
                </div>
            </div>
            <div class="col-12 col-md-auto text-center text-md-end pt-2 pt-md-0">
                <button class="btn btn-light text-primary rounded-pill px-3 py-2 fw-bold shadow-sm border-0 fs--1" type="button" data-bs-toggle="modal" data-bs-target="#modal-hrm" id="button-update-desc-pegawai">
                    <i class="fas fa-edit me-1 text-primary"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Adaptive Theme) -->
    <div class="card-body p-3 p-md-3">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3" style="background: var(--bg-soft-purple); border-left: 4px solid #a855f7;">
                    <div class="fw-bold fs--2 text-uppercase tracking-wider text-purple">Skor KPI (Q2)</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-extrabold text-purple">92.5<small class="fs--2 adaptive-text-muted">/100</small></span>
                        <span class="badge bg-purple text-white fs--2">Sangat Baik</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3" style="background: var(--bg-soft-emerald); border-left: 4px solid #10b981;">
                    <div class="fw-bold fs--2 text-uppercase tracking-wider text-success">Kehadiran (Bulan Ini)</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-extrabold text-success">98%</span>
                        <span class="badge bg-success text-white fs--2">21/22 Hari</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3" style="background: var(--bg-soft-sky); border-left: 4px solid #0284c7;">
                    <div class="fw-bold fs--2 text-uppercase tracking-wider text-info">Keterlambatan</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-extrabold text-info">0 <small class="fs--2 adaptive-text-muted fw-normal">Kali</small></span>
                        <span class="badge bg-info text-white fs--2">Tepat Waktu</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3" style="background: var(--bg-soft-amber); border-left: 4px solid #f59e0b;">
                    <div class="fw-bold fs--2 text-uppercase tracking-wider text-warning">Sisa Cuti Annual</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fs-1 fw-extrabold text-warning">8 <small class="fs--2 adaptive-text-muted fw-normal">Hari</small></span>
                        <span class="badge bg-warning text-dark fs--2">dari 12</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Kolom Utama -->
    <div class="col-lg-8">

        <!-- Card Penilaian KPI -->
        <div class="card card-vibrant mb-3">
            <div class="p-3 card-header-indigo d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge icon-indigo">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Penilaian Kinerja KPI</h6>
                </div>
                <span class="badge bg-indigo text-dark rounded-pill px-3 py-1 fs--2">Evaluasi Q2</span>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="p-3 mb-3 adaptive-bg-subtle rounded-3 border-start border-4 border-indigo">
                        <div class="d-flex justify-content-between fs--1 mb-1">
                            <span class="fw-bold adaptive-text-main"><i class="fas fa-tasks text-indigo me-2"></i>Penyelesaian Proyek & Target System (Bobot 40%)</span>
                            <span class="fw-extrabold text-indigo fs-0">95%</span>
                        </div>
                        <div class="progress rounded-pill bg-200" style="height: 8px;">
                            <div class="progress-bar progress-bar-indigo rounded-pill" style="width: 95%" role="progressbar"></div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 adaptive-bg-subtle rounded-3 border-start border-4 border-emerald">
                        <div class="d-flex justify-content-between fs--1 mb-1">
                            <span class="fw-bold adaptive-text-main"><i class="fas fa-code text-success me-2"></i>Kualitas Kode & Standar Arsitektur (Bobot 30%)</span>
                            <span class="fw-extrabold text-success fs-0">90%</span>
                        </div>
                        <div class="progress rounded-pill bg-200" style="height: 8px;">
                            <div class="progress-bar progress-bar-emerald rounded-pill" style="width: 90%" role="progressbar"></div>
                        </div>
                    </div>

                    <div class="p-3 adaptive-bg-subtle rounded-3 border-start border-4 border-amber">
                        <div class="d-flex justify-content-between fs--1 mb-1">
                            <span class="fw-bold adaptive-text-main"><i class="fas fa-users text-warning me-2"></i>Kerjasama Tim & Kedisiplinan Kerja (Bobot 30%)</span>
                            <span class="fw-extrabold text-warning fs-0">92%</span>
                        </div>
                        <div class="progress rounded-pill bg-200" style="height: 8px;">
                            <div class="progress-bar progress-bar-amber rounded-pill" style="width: 92%" role="progressbar"></div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Atasan -->
                <div class="p-3 rounded-3" style="background: var(--bg-soft-sky); border: 1px solid rgba(2, 132, 199, 0.3);">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary text-white fs--2">Catatan Kinerja Atasan</span>
                        <small class="adaptive-text-muted">&bull; Oleh Manager IT</small>
                    </div>
                    <p class="fs--1 adaptive-text-sub mb-0 lh-base">
                        "Kinerja pegawai sangat memuaskan pada kuartal ini. Berhasil memimpin integrasi arsitektur sistem baru secara tepat waktu tanpa hambatan (*zero downtime*)."
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Rekap Kehadiran -->
        <div class="card card-vibrant mb-3">
            <div class="p-3 card-header-emerald d-flex align-items-center gap-2">
                <div class="icon-badge icon-emerald">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Rekapitulasi Kehadiran & Presensi</h6>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle fs--1 mb-0">
                        <thead class="adaptive-bg-subtle adaptive-text-main">
                            <tr>
                                <th class="py-2 border-0 rounded-start">Status Kehadiran</th>
                                <th class="py-2 border-0 text-center">Jumlah Hari</th>
                                <th class="py-2 border-0 text-center">Persentase</th>
                                <th class="py-2 border-0 text-end rounded-end">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="adaptive-text-sub">
                            <tr>
                                <td class="py-3"><span class="badge bg-soft-success text-success p-2 rounded-circle me-2"><i class="fas fa-check"></i></span><strong class="adaptive-text-main">Hadir Tepat Waktu</strong></td>
                                <td class="text-center fw-bold adaptive-text-main">21 Hari</td>
                                <td class="text-center text-success fw-bold">95.4%</td>
                                <td class="text-end"><span class="badge bg-success text-white">Sesuai Jam Kerja</span></td>
                            </tr>
                            <tr>
                                <td class="py-3"><span class="badge bg-soft-info text-info p-2 rounded-circle me-2"><i class="fas fa-clock"></i></span><strong class="adaptive-text-main">Terlambat Masuk</strong></td>
                                <td class="text-center fw-bold adaptive-text-main">0 Hari</td>
                                <td class="text-center adaptive-text-muted">0%</td>
                                <td class="text-end"><span class="badge bg-info text-white">Nihil</span></td>
                            </tr>
                            <tr>
                                <td class="py-3"><span class="badge bg-soft-warning text-warning p-2 rounded-circle me-2"><i class="fas fa-umbrella-beach"></i></span><strong class="adaptive-text-main">Izin / Cuti Resmi</strong></td>
                                <td class="text-center fw-bold adaptive-text-main">1 Hari</td>
                                <td class="text-center text-warning fw-bold">4.6%</td>
                                <td class="text-end"><span class="badge bg-warning text-dark">Cuti Tahunan</span></td>
                            </tr>
                            <tr>
                                <td class="py-3"><span class="badge bg-soft-danger text-danger p-2 rounded-circle me-2"><i class="fas fa-times"></i></span><strong class="adaptive-text-main">Tanpa Keterangan</strong></td>
                                <td class="text-center fw-bold adaptive-text-main">0 Hari</td>
                                <td class="text-center adaptive-text-muted">0%</td>
                                <td class="text-end"><span class="badge bg-secondary text-white">Nihil</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Deskripsi Pegawai Card -->
        <div class="card card-vibrant mb-3">
            <div class="p-3 card-header-sky d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge icon-sky">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Deskripsi & Profil Singkat</h6>
                </div>
            </div>
            <div class="card-body p-4">
                <p class="fs--1 adaptive-text-sub lh-base mb-0">
                    Dedicated Full Stack Developer dengan pengalaman lebih dari 9 tahun dalam pengelolaan infrastruktur cloud, pengolahan aplikasi web skala besar, serta integrasi sistem enterprise. Memiliki komitmen tinggi terhadap kualitas kode dan hasil kerja.
                </p>
            </div>
        </div>

        <!-- Galeri Foto Card -->
        <div class="card card-vibrant">
            <div class="p-3 card-header-rose d-flex align-items-center gap-2">
                <div class="icon-badge icon-rose">
                    <i class="fas fa-images"></i>
                </div>
                <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Dokumentasi & Galeri Kegiatan</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-3">
                        <a class="glightbox" href="{{ asset('asset/img/generic/4.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/generic/4.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="glightbox" href="{{ asset('asset/img/generic/5.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/generic/5.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="glightbox" href="{{ asset('asset/img/gallery/4.jpg') }}">
                            <img class="gallery-img-vibrant" src="{{ asset('asset/img/gallery/4.jpg') }}" alt="Gallery" />
                        </a>
                    </div>
                    <div class="col-3">
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
            <div class="card card-vibrant mb-3">
                <div class="p-3 card-header-purple d-flex align-items-center gap-2">
                    <div class="icon-badge icon-purple">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Pengalaman Kerja</h6>
                </div>
                <div class="card-body p-3 fs--1">
                    <div class="p-2 mb-2 adaptive-bg-subtle rounded-3 border-start border-3 border-purple">
                        <div class="fw-bold adaptive-text-main">Big Data Engineer</div>
                        <div class="text-purple fw-semibold">Google Inc.</div>
                        <small class="adaptive-text-muted"><i class="far fa-clock me-1"></i>2018 - Sekarang</small>
                    </div>
                    <div class="p-2 mb-2 adaptive-bg-subtle rounded-3 border-start border-3 border-info">
                        <div class="fw-bold adaptive-text-main">Software Engineer</div>
                        <div class="text-info fw-semibold">Apple Inc.</div>
                        <small class="adaptive-text-muted"><i class="far fa-clock me-1"></i>2015 - 2018</small>
                    </div>
                    <div class="p-2 adaptive-bg-subtle rounded-3 border-start border-3 border-warning">
                        <div class="fw-bold adaptive-text-main">Mobile Developer</div>
                        <div class="text-warning fw-semibold">Nike Tech</div>
                        <small class="adaptive-text-muted"><i class="far fa-clock me-1"></i>2013 - 2015</small>
                    </div>
                </div>
            </div>

            <!-- Pendidikan Card -->
            <div class="card card-vibrant mb-4">
                <div class="p-3 card-header-amber d-flex align-items-center gap-2">
                    <div class="icon-badge icon-amber">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Riwayat Pendidikan</h6>
                </div>
                <div class="card-body p-3 fs--1">
                    <div class="p-2 mb-2 adaptive-bg-subtle rounded-3 border-start border-3 border-amber">
                        <div class="fw-bold adaptive-text-main">Stanford University</div>
                        <div class="adaptive-text-sub">S1 Computer Science</div>
                        <small class="text-amber fw-bold">2009 - 2013</small>
                    </div>
                    <div class="p-2 adaptive-bg-subtle rounded-3 border-start border-3 border-secondary">
                        <div class="fw-bold adaptive-text-main">Staten Island High</div>
                        <div class="adaptive-text-sub">IPA / Science</div>
                        <small class="text-secondary fw-bold">2006 - 2009</small>
                    </div>
                </div>
            </div>

            <!-- Log Aktivitas Card -->
            <div class="card card-vibrant">
                <div class="p-3 card-header-sky d-flex align-items-center gap-2">
                    <div class="icon-badge icon-sky">
                        <i class="fas fa-history"></i>
                    </div>
                    <h6 class="mb-0 fw-bold adaptive-text-main fs-0">Log Aktivitas Terbaru</h6>
                </div>
                <div class="card-body p-3 fs--2">
                    <div class="d-flex align-items-start gap-2 mb-2 pb-2 border-bottom">
                        <span class="badge bg-soft-primary text-primary p-1 rounded"><i class="fas fa-award"></i></span>
                        <div class="adaptive-text-sub">
                            <strong class="adaptive-text-main">13 Nov:</strong> Penilaian KPI Q2 berhasil dikirim oleh atasan.
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2 mb-2 pb-2 border-bottom">
                        <span class="badge bg-soft-warning text-warning p-1 rounded"><i class="fas fa-plane"></i></span>
                        <div class="adaptive-text-sub">
                            <strong class="adaptive-text-main">08 Nov:</strong> Pengajuan cuti tahunan disetujui (1 hari).
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-soft-success text-success p-1 rounded"><i class="fas fa-file-alt"></i></span>
                        <div class="adaptive-text-sub">
                            <strong class="adaptive-text-main">01 Nov:</strong> Pembaruan dokumen sertifikasi pegawai.
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
        <div class="modal-content card-vibrant border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-hrm"></div>
        </div>
    </div>
</div>

<script src="{{ asset('vendors/glightbox/glightbox.min.js') }}"></script>
<script>
    $(document).ready(function() {
        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        }
    });

    $(document).on("click", "#button-update-desc-pegawai", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-hrm').html(
            '<div class="p-5 text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 adaptive-text-sub fs--1 mb-0">Memuat data pegawai...</p></div>'
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
