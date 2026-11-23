@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES
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

    .font-mono-code {
        font-family: 'JetBrains Mono', monospace;
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

    .ent-table thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .ent-table tbody td {
        border-bottom-color: var(--ent-grid-border) !important;
        font-size: 0.84rem;
    }
</style>
@endsection

@section('content')
<!-- Hero / Welcome Banner Brain Test -->
<div class="card mb-3 ent-header-banner p-1">
    <div class="card-body position-relative p-4 p-lg-5" style="z-index: 2;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-9">
                <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1 mb-3">
                    <span class="pulse-badge me-2"></span>
                    <small class="fw-semibold" style="font-size: 0.78rem; color: #cbd5e1;">Brain Test &amp; Assessment Center</small>
                </div>

                <h2 class="fw-bold mb-2" style="letter-spacing: -0.02em; color: white;">
                    Selamat Datang di Brain Test!
                </h2>
                <p class="mb-3 me-lg-5" style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.65;">
                    Siapkan dirimu untuk menaklukkan Tes IQ, Psikotes, dan CAT BUMN hari ini. Pilih kategori tes di bawah untuk mulai berlatih dan memantau perkembangan skormu.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#kategori-tes" class="btn ent-btn ent-btn-light px-4 py-2">
                        <i class="fas fa-play-circle me-2 text-primary"></i> Mulai Tes Sekarang
                    </a>
                    <a href="#riwayat-tes" class="btn ent-btn ent-btn-primary px-4 py-2">
                        <i class="fas fa-history me-2"></i> Riwayat Tes Terakhir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Berwarna -->
<div class="row g-3 g-md-4 mb-3">
    <!-- Card 1: Total Tes Dikerjakan -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-sky) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                    <i class="fas fa-clipboard-check fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Total Tes Dikerjakan</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.05rem;">12</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Rata-Rata Skor IQ -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-emerald) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                    <i class="fas fa-chart-line fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Rata-Rata Skor IQ</span>
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.05rem;">115</h5>
                        <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">Superior</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Simulasi CAT BUMN -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-amber) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">
                    <i class="fas fa-building fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Simulasi CAT BUMN</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.05rem;">4 Selesai</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Peringkat Nasional -->
    <div class="col-sm-6 col-xl-3">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-indigo) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                    <i class="fas fa-trophy fs-4"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Peringkat Nasional</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.05rem;">#142</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Kategori Tes Utama -->
<div class="ent-card mb-3" id="kategori-tes">
    <div class="ent-card-header d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                <i class="fas fa-th-large"></i>
            </span>
            Pilih Kategori Tes
        </h6>
        <span class="ent-badge" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);">3 Modul Aktif</span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="row g-3 g-md-4">
            <!-- Tes IQ -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid var(--ent-sky) !important;">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape-md me-3" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                                <i class="fas fa-brain fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Tes IQ &amp; Kognitif</h6>
                        </div>
                        <p class="opacity-75 mb-4" style="font-size: 0.84rem; line-height: 1.6;">
                            Uji kemampuan logika, spasial, numerik, dan verbal untuk mengukur kapasitas intelektualmu secara akurat.
                        </p>
                    </div>
                    <a href="#" class="btn ent-btn ent-btn-primary w-100 py-2">
                        <i class="fas fa-arrow-right me-1"></i> Mulai Tes IQ
                    </a>
                </div>
            </div>

            <!-- Tes Psikotes Kerja -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid var(--ent-emerald) !important;">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape-md me-3" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                                <i class="fas fa-id-badge fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Psikotes &amp; Kepribadian</h6>
                        </div>
                        <p class="opacity-75 mb-4" style="font-size: 0.84rem; line-height: 1.6;">
                            Simulasi lengkap tes koran (Pauli/Kraepelin), tes kepribadian DISC, PAPI Kostick, dan ketelitian kerja.
                        </p>
                    </div>
                    <a href="#" class="btn ent-btn w-100 py-2" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.35);">
                        <i class="fas fa-arrow-right me-1"></i> Mulai Psikotes
                    </a>
                </div>
            </div>

            <!-- CAT BUMN & CPNS -->
            <div class="col-md-4">
                <div class="p-4 card-feature-hover h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid var(--ent-amber) !important;">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape-md me-3" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">
                                <i class="fas fa-building-columns fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">CAT BUMN &amp; CPNS</h6>
                        </div>
                        <p class="opacity-75 mb-4" style="font-size: 0.84rem; line-height: 1.6;">
                            Latihan soal TWK, TIU, TKP, dan Core Values AKHLAK BUMN dengan sistem waktu otomatis ala CAT resmi.
                        </p>
                    </div>
                    <a href="#" class="btn ent-btn w-100 py-2" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.35);">
                        <i class="fas fa-arrow-right me-1"></i> Mulai CAT BUMN
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat & Aktivitas Terakhir -->
<div class="ent-card mb-3" id="riwayat-tes">
    <div class="ent-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-history text-primary"></i> Riwayat Tes Terakhir
        </h6>
        <div class="d-flex align-items-center gap-2">
            <input type="text" id="riwayatSearchInput" class="form-control" style="max-width: 220px;" placeholder="Cari jenis tes...">
            <a href="#" class="btn ent-btn ent-btn-primary px-3 py-1">Lihat Semua</a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 ent-table" id="riwayatTesTable">
                <thead>
                    <tr>
                        <th class="py-3 ps-4">Jenis Tes</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Skor / Hasil</th>
                        <th class="py-3 pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold ps-4">Simulasi CAT BUMN Paket 1</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">CAT BUMN</span>
                        </td>
                        <td class="opacity-75 font-mono-code" style="font-size: 0.78rem;">05 Okt 2026</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">780 (Lulus Passing Grade)</span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="#" class="btn ent-btn px-3 py-1" style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-4">Tes IQ Standar Kognitif</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">Tes IQ</span>
                        </td>
                        <td class="opacity-75 font-mono-code" style="font-size: 0.78rem;">02 Okt 2026</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">118 (Superior)</span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="#" class="btn ent-btn px-3 py-1" style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-4">Simulasi Kraepelin &amp; Pauli</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">Psikotes</span>
                        </td>
                        <td class="opacity-75 font-mono-code" style="font-size: 0.78rem;">28 Sep 2026</td>
                        <td>
                            <span class="ent-badge" style="background-color: rgba(100, 116, 139, 0.15); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3);">Stabil (Grafik Baik)</span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="#" class="btn ent-btn px-3 py-1" style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("riwayatSearchInput");
        const tableRows = document.querySelectorAll("#riwayatTesTable tbody tr");

        if (searchInput) {
            searchInput.addEventListener("input", function () {
                const keyword = this.value.toLowerCase().trim();
                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? "" : "none";
                });
            });
        }
    });
</script>
@endsection
