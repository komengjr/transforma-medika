@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
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

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 14px 20px;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.1) !important;
    }

    .icon-shape {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-input,
    .ent-select {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 8px 12px !important;
    }

    .ent-input:focus,
    .ent-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 11px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-sub-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
{{-- Header Banner Modern --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/gl.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-sparkles"></i> KPI Dashboard
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">{{ env('APP_LABEL', 'INNOVENTRA') }} Management System</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Rekapitulasi Penilaian KPI Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Pantau ringkasan skor evaluasi, rata-rata performa, dan rincian indikator KPI seluruh departemen.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Module Menu</span>
                        <span class="fw-bold fs-1" style="color: #7dd3fc;">
                            <i class="fas fa-chart-bar me-1 fs--1"></i> Master KPI Rekap All
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Form Filter Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterForm" class="row g-3 align-items-end">
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Periode Bulan
                </label>
                <input type="month" name="periode" class="form-control ent-input ent-mono fs-2" value="{{ $selectedPeriode }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Filter Departemen
                </label>
                <select name="dept_code" class="form-select ent-select fs-2">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}">
                        {{ $d->hrm_departemen_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i> Cari Pegawai
                </label>
                <input type="text" name="search" class="form-control ent-input fs-2" placeholder="Masukkan Nama atau NIP...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" id="btnSearch" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-filter me-1"></i> Search
                </button>
                <button type="button" id="btnReset" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Container Utama Hasil --}}
<div id="resultContainer" class="fs-2">
    <div class="card ent-card text-center py-5">
        <div class="card-body py-4">
            <div class="mb-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                    style="width: 64px; height: 64px; background: rgba(79, 70, 229, 0.1); border: 1px solid rgba(79, 70, 229, 0.2); color: #6366f1;">
                    <i class="fas fa-search-plus fs-1"></i>
                </span>
            </div>
            <h5 class="fw-bold mb-1 fs-1">Silakan Pilih Filter Pencarian</h5>
            <p class="opacity-75 fs--1 mb-0 mx-auto" style="max-width: 520px;">
                Tentukan <strong>Periode Bulan</strong> dan/atau <strong>Departemen</strong> pada form di atas, lalu klik tombol <span class="text-primary fw-semibold">Search</span> untuk memuat data rekap KPI.
            </p>
        </div>
    </div>
</div>

{{-- Modal Detail KPI --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-award text-warning me-2"></i>Rincian Evaluasi KPI Pegawai
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal_kpi_body">
                {{-- Dynamic via JavaScript --}}
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const resultContainer = document.getElementById('resultContainer');
        const btnReset = document.getElementById('btnReset');
        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Default Content Awal
        const defaultInitialContent = `
        <div class="card ent-card text-center py-5">
            <div class="card-body py-4">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                        style="width: 64px; height: 64px; background: rgba(79, 70, 229, 0.1); border: 1px solid rgba(79, 70, 229, 0.2); color: #6366f1;">
                        <i class="fas fa-search-plus fs-1"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-1 fs-1">Silakan Pilih Filter Pencarian</h5>
                <p class="opacity-75 fs--1 mb-0 mx-auto" style="max-width: 520px;">
                    Tentukan <strong>Periode Bulan</strong> dan/atau <strong>Departemen</strong> pada form di atas, lalu klik tombol <span class="text-primary fw-semibold">Search</span> untuk memuat data rekap KPI.
                </p>
            </div>
        </div>
        `;

        // Handle Form Search
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            resultContainer.innerHTML = `
            <div class="card ent-card text-center py-5">
                <div class="card-body py-4">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <h6 class="fw-bold fs-1 mb-1">Sedang Memproses Data...</h6>
                    <p class="opacity-75 fs--1 mb-0">Mohon tunggu sebentar, sistem sedang memuat rekap KPI.</p>
                </div>
            </div>
            `;

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();

            fetch(`{{ route('master_data_kpi_rekap_get') }}?${params}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                    return response.json();
                })
                .then(data => {
                    renderResult(data);
                })
                .catch(error => {
                    resultContainer.innerHTML = `
                    <div class="card ent-card text-center py-4">
                        <div class="card-body text-danger">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                style="width: 52px; height: 52px; background: rgba(225, 29, 72, 0.12); color: #e11d48;">
                                <i class="fas fa-exclamation-circle fs-1"></i>
                            </span>
                            <h6 class="fw-bold fs-1 mb-1">Terjadi Kesalahan</h6>
                            <p class="mb-0 fs--1 fw-medium">${escapeHtml(error.message)}</p>
                        </div>
                    </div>
                    `;
                });
        });

        // Reset Event
        btnReset.addEventListener('click', function() {
            filterForm.reset();
            resultContainer.innerHTML = defaultInitialContent;
        });

        // Render Result UI
        function renderResult(data) {
            let tableRows = '';

            if (data.rekaps && data.rekaps.length > 0) {
                data.rekaps.forEach((row, index) => {
                    let score = parseFloat(row.total_score) || 0;
                    let badgeStyle = 'background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);';
                    let textClass = 'text-secondary';

                    if (score >= 90) {
                        badgeStyle = 'background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);';
                        textClass = 'text-success';
                    } else if (score >= 80) {
                        badgeStyle = 'background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);';
                        textClass = 'text-primary';
                    } else if (score >= 70) {
                        badgeStyle = 'background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);';
                        textClass = 'text-info';
                    } else if (score >= 60) {
                        badgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);';
                        textClass = 'text-warning';
                    } else {
                        badgeStyle = 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);';
                        textClass = 'text-danger';
                    }

                    tableRows += `
                    <tr>
                        <td class="text-center ent-mono fw-semibold">${index + 1}</td>
                        <td>
                            <div class="fw-bold fs-2">${escapeHtml(row.hrm_m_pegawai_name)}</div>
                            <div class="opacity-75 fs--2 ent-mono"><i class="far fa-id-card me-1 text-primary"></i>NIP: ${escapeHtml(row.hrm_m_pegawai_nip)}</div>
                        </td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                <i class="fas fa-building"></i> ${escapeHtml(row.hrm_departemen_name ?? '-')}
                            </span>
                        </td>
                        <td class="text-center ent-mono">
                            <span class="fw-semibold fs--1"><i class="far fa-calendar me-1 opacity-75"></i>${escapeHtml(row.periode)}</span>
                        </td>
                        <td class="text-center ent-mono">
                            <span class="fs-1 fw-bold ${textClass}">${score.toFixed(2)}</span>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="${badgeStyle}">
                                ${escapeHtml(row.kategori)}
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button"
                                    class="btn btn-sm ent-btn btn-outline-primary px-3 py-1 fs--2 btn-detail-modal"
                                    data-pegawai="${escapeHtml(row.hrm_m_pegawai_code)}"
                                    data-periode="${escapeHtml(row.periode)}">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                    `;
                });
            } else {
                tableRows = `
                <tr>
                    <td colspan="7" class="text-center py-5 opacity-75 fs--1">
                        <i class="fas fa-folder-open fs-1 mb-2 text-primary d-block"></i>
                        <div class="fw-bold fs-2">Data tidak ditemukan</div>
                        <p class="fs--1 mb-0">Coba ubah kata kunci atau periode pencarian Anda.</p>
                    </td>
                </tr>
                `;
            }

            // Stat Cards + Modern Table
            resultContainer.innerHTML = `
            <div class="row g-3 mb-3">
                <div class="col-md-3 col-6">
                    <div class="card ent-card kpi-card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Evaluasi</div>
                                <div class="fs-1 fw-bold text-primary ent-mono">${escapeHtml(data.totalEvaluasi)}</div>
                                <small class="opacity-75 fs--2">Pegawai Terdaftar</small>
                            </div>
                            <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card ent-card kpi-card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Rata-Rata Skor</div>
                                <div class="fs-1 fw-bold text-success ent-mono">${escapeHtml(data.avgSkor)}</div>
                                <small class="opacity-75 fs--2">Performa Keseluruhan</small>
                            </div>
                            <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i class="fas fa-star fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card ent-card kpi-card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">High Performer</div>
                                <div class="fs-1 fw-bold text-info ent-mono">${escapeHtml(data.totalHighPerformer)}</div>
                                <small class="opacity-75 fs--2">Skor Sangat Baik (A/B)</small>
                            </div>
                            <div class="icon-shape" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                                <i class="fas fa-trophy fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card ent-card kpi-card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Perlu Evaluasi</div>
                                <div class="fs-1 fw-bold text-warning ent-mono">${escapeHtml(data.totalUnderPerformer)}</div>
                                <small class="opacity-75 fs--2">Di Bawah Target Standar</small>
                            </div>
                            <div class="icon-shape" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2);">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card ent-card mb-3">
                <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-list-alt text-primary me-2"></i>Daftar Rekapitulasi KPI</h6>
                        <span class="opacity-75 fs--1">Hasil evaluasi KPI pegawai berdasarkan periode dan departemen terpilih.</span>
                    </div>
                    <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                        <i class="fas fa-check-circle"></i> Updated
                    </span>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table id="tableRekapKpi" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                            <thead>
                                <tr class="fs--2">
                                    <th class="text-center" style="width: 48px;">#</th>
                                    <th>Informasi Pegawai</th>
                                    <th>Departemen</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Total Skor</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fs--1">
                                ${tableRows}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `;

            if (data.rekaps && data.rekaps.length > 0) {
                new DataTable('#tableRekapKpi', {
                    responsive: true,
                    language: {
                        search: "Cari Cepat:",
                        lengthMenu: "Tampilkan _MENU_ Data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ Pegawai",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            previous: "<i class='fas fa-angle-left'></i>",
                            next: "<i class='fas fa-angle-right'></i>"
                        }
                    }
                });
            }

            bindDetailModalEvent();
        }

        // Modal Event
        function bindDetailModalEvent() {
            document.querySelectorAll('.btn-detail-modal').forEach(button => {
                button.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-pegawai');
                    let periode = this.getAttribute('data-periode');

                    modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <p class="mb-0 opacity-75 fs--1 fw-semibold">Mengambil Rincian KPI...</p>
                    </div>
                    `;
                    modalElement.show();

                    fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${pegawaiCode}/${periode}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Data rincian tidak ditemukan.');
                            return response.json();
                        })
                        .then(data => {
                            let p = data.pegawai;
                            let r = data.rekap;
                            let details = data.details || [];

                            let detailRows = '';
                            if (details.length > 0) {
                                details.forEach((item, idx) => {
                                    detailRows += `
                                    <tr>
                                        <td class="text-center ent-mono fw-semibold">${idx + 1}</td>
                                        <td>
                                            <div class="fw-bold fs--1">${escapeHtml(item.hrm_kpi_master_name)}</div>
                                            <span class="opacity-75 fs--2">${escapeHtml(item.hrm_kpi_master_desc ?? '-')}</span>
                                        </td>
                                        <td class="text-center ent-mono fw-semibold">${escapeHtml(item.hrm_kpi_master_bobot)}%</td>
                                        <td class="text-center ent-mono">${escapeHtml(item.hrm_kpi_master_target)}</td>
                                        <td class="text-center fw-bold ent-mono">${escapeHtml(item.hrm_kpi_pegawai_value)}</td>
                                        <td class="text-center fw-bold text-primary ent-mono">${escapeHtml(item.hrm_kpi_pegawai_score)}</td>
                                        <td><span class="opacity-75 fs--2">${escapeHtml(item.hrm_kpi_pegawai_catatan ?? '-')}</span></td>
                                    </tr>
                                    `;
                                });
                            } else {
                                detailRows = `
                                <tr>
                                    <td colspan="7" class="text-center py-4 opacity-75 fs--1">Belum ada rincian indikator KPI pada periode ini.</td>
                                </tr>
                                `;
                            }

                            modalBody.innerHTML = `
                            <div class="row g-3 mb-4">
                                <div class="col-md-7">
                                    <div class="p-3 ent-sub-box h-100">
                                        <h6 class="fw-bold mb-2 fs-1">${escapeHtml(p.hrm_m_pegawai_name)}</h6>
                                        <div class="opacity-75 fs--1 mb-1 ent-mono"><i class="far fa-id-card me-2 text-primary"></i>NIP: <strong>${escapeHtml(p.hrm_m_pegawai_nip)}</strong></div>
                                        <div class="opacity-75 fs--1 mb-2"><i class="fas fa-building me-2 text-primary"></i>Departemen: <strong>${escapeHtml(p.hrm_departemen_name ?? '-')}</strong></div>
                                        <div class="opacity-75 fs--1">
                                            <i class="far fa-calendar-alt me-2 text-primary"></i>Periode Evaluasi:
                                            <span class="ent-badge fs--2 ent-mono ms-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">${escapeHtml(data.periode)}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="p-3 rounded-3 text-center h-100 d-flex flex-column justify-content-center"
                                        style="background: rgba(79, 70, 229, 0.08); border: 1px solid rgba(79, 70, 229, 0.22);">
                                        <span class="text-uppercase fw-bold text-primary fs--2">Skor Akhir Performance</span>
                                        <div class="fs-1 fw-bold text-primary my-1 ent-mono" style="font-size: 1.5rem !important;">${r ? escapeHtml(r.hrm_kpi_rekap_total) : '0'}</div>
                                        <div>
                                            <span class="ent-badge fs--2" style="background: #4f46e5; color: #ffffff;">
                                                ${r ? escapeHtml(r.hrm_kpi_rekap_cat) : '-'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-2 fs-1"><i class="fas fa-tasks text-primary me-2"></i>Indikator Penilaian KPI</h6>
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-hover table-custom align-middle mb-0">
                                    <thead>
                                        <tr class="fs--2">
                                            <th class="text-center">No</th>
                                            <th>Indikator</th>
                                            <th class="text-center">Bobot</th>
                                            <th class="text-center">Target</th>
                                            <th class="text-center">Realisasi</th>
                                            <th class="text-center">Skor</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs--1">
                                        ${detailRows}
                                    </tbody>
                                </table>
                            </div>
                            `;
                        })
                        .catch(err => {
                            modalBody.innerHTML = `
                            <div class="text-center py-4 text-danger fs--1">
                                <i class="fas fa-exclamation-circle fs-1 mb-2 d-block"></i>
                                <p class="mb-0 fw-semibold">${escapeHtml(err.message)}</p>
                            </div>
                            `;
                        });
                });
            });
        }
    });
</script>
@endsection
