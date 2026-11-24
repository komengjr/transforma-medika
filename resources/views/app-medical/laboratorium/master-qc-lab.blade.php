@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
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
        --ent-subtle-surface: #f8fafc;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-subtle-surface: #1e293b;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 20px;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    .ent-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .kpi-mini-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
        background-color: var(--ent-subtle-surface);
    }

    .lj-chart-wrapper {
        position: relative;
        height: 360px;
        width: 100%;
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS (MATCHING REGISTER POLI)
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.83rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .dt-container .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    .dt-container .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    .dt-container .dt-layout-table {
        margin: 0 !important;
    }

    .dt-container .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .dt-container .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .dt-container .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 28px 4px 10px !important;
        height: 34px !important;
        font-size: 0.82rem !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .page-item.active .page-link {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    .page-link {
        color: var(--bs-body-color);
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
    }

    .nav-pills .nav-link {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--bs-body-color);
        border: 1px solid transparent;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff;
    }

    .ent-modal-footer {
        background-color: var(--ent-subtle-surface);
        border-top: 1px solid var(--ent-grid-border);
    }

    @media print {
        .d-flex.flex-wrap.justify-content-between,
        #qcTabs,
        .btn-review-qc,
        .no-print {
            display: none !important;
        }
        .ent-card {
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
        }
    }
</style>
@endsection

@section('content')
@php
$totalLog = $logs->count();
$inControlCount = $logs->where('status_qc', 'IN_CONTROL')->count();
$warningCount = $logs->where('status_qc', 'WARNING_2SD')->count();
$outOfControlCount = $logs->where('status_qc', 'OUT_OF_CONTROL')->count();
@endphp

<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 58px; height: 58px;">
                            <i class="fas fa-shield-halved fs-4" style="color: #38bdf8;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-flask"></i> {{ env('APP_LABEL', 'HIS') }} LAB QC
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Quality Control Laboratorium</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Quality Control (QC) Laboratorium
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pemantauan bahan kontrol, target Mean &amp; SD, evaluasi Z-Score / Westgard, laporan dan grafik QC harian.</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">In Control</span>
                            <span class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">{{ $inControlCount }}</span>
                        </div>
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Warning 2SD</span>
                            <span class="fw-bold text-warning" style="font-family: 'JetBrains Mono', monospace;">{{ $warningCount }}</span>
                        </div>
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Out of Control</span>
                            <span class="fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">{{ $outOfControlCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NAV TABS & ACTION BUTTONS -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <ul class="nav nav-pills gap-2" id="qcTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-log-qc" data-bs-toggle="pill" data-bs-target="#pane-log-qc" type="button" role="tab">
                <i class="fas fa-clipboard-list me-1"></i> Log Hasil QC Harian ({{ $totalLog }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-laporan-qc" data-bs-toggle="pill" data-bs-target="#pane-laporan-qc" type="button" role="tab">
                <i class="fas fa-chart-line me-1"></i> Laporan &amp; Grafik QC
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-param-qc" data-bs-toggle="pill" data-bs-target="#pane-param-qc" type="button" role="tab">
                <i class="fas fa-sliders me-1"></i> Parameter &amp; Target Mean/SD ({{ $parameters->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-material-qc" data-bs-toggle="pill" data-bs-target="#pane-material-qc" type="button" role="tab">
                <i class="fas fa-vial me-1"></i> Bahan &amp; Lot Kontrol ({{ $materials->count() }})
            </button>
        </li>
    </ul>

    <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalMaterial" id="btnOpenMaterialModal">
            <i class="fas fa-vial me-1 text-primary"></i> + Bahan QC
        </button>
        <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalParameterQc" id="btnOpenParameterModal">
            <i class="fas fa-sliders-h me-1 text-primary"></i> + Parameter QC
        </button>
        <button type="button" class="btn ent-btn ent-btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalInputQc" id="btnOpenInputQcModal">
            <i class="fas fa-plus me-1"></i> Input Hasil QC
        </button>
        <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" id="btnProsesHasilQc">
            <i class="fas fa-satellite-dish me-1 text-success"></i> Proses Hasil QC
        </button>
    </div>
</div>

<!-- TAB CONTENT -->
<div class="tab-content" id="qcTabsContent">
    <!-- TAB 1: LOG QC HARIAN -->
    <div class="tab-pane fade show active" id="pane-log-qc" role="tabpanel">
        <div class="ent-card mb-4">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold">Riwayat Hasil Quality Control Harian</h6>
                    <small class="opacity-75">Evaluasi otomatis Z-Score dan aturan Westgard.</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive pb-3">
                    <table class="table table-custom align-middle mb-0 w-100" id="tableQcLogs">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 45px;">NO</th>
                                <th style="width: 130px;">Tanggal / Jam</th>
                                <th>Bahan / Lot</th>
                                <th>Parameter</th>
                                <th class="text-end">Hasil</th>
                                <th class="text-end">Mean / SD</th>
                                <th class="text-center">Z-Score</th>
                                <th class="text-center">Status QC</th>
                                <th>Aturan / Tindakan</th>
                                <th class="text-center">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $index => $log)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                    <div class="fw-bold">{{ $log->tanggal_qc }}</div>
                                    <small class="opacity-75">{{ substr($log->jam_qc, 0, 5) }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $log->nama_material }}</div>
                                    <span class="code-chip mt-1">LOT: {{ $log->lot_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $log->label ?? $log->nama_parameter }}</div>
                                    @if(!empty($log->label) && $log->label !== $log->nama_parameter)
                                    <span class="code-chip mt-1">{{ $log->nama_parameter }}</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.88rem;">
                                    {{ number_format((float) $log->nilai_hasil, 2) }} <small class="opacity-75">{{ $log->satuan }}</small>
                                </td>
                                <td class="text-end" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                    {{ number_format((float) $log->target_mean, 2) }} ± {{ number_format((float) $log->target_sd, 2) }}
                                </td>
                                <td class="text-center">
                                    <span class="code-chip">{{ number_format((float) $log->z_score, 2) }} SD</span>
                                </td>
                                <td class="text-center">
                                    @if($log->status_qc === 'IN_CONTROL')
                                    <span class="ent-badge" style="background: rgba(5, 150, 105, 0.15); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.35);">
                                        <i class="fas fa-check-circle me-1"></i> In Control
                                    </span>
                                    @elseif($log->status_qc === 'WARNING_2SD')
                                    <span class="ent-badge" style="background: rgba(217, 119, 6, 0.15); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.35);">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Warning 2SD
                                    </span>
                                    @else
                                    <span class="ent-badge" style="background: rgba(225, 29, 72, 0.15); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.35);">
                                        <i class="fas fa-times-circle me-1"></i> Out of Control
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold" style="font-size: 0.78rem;">{{ $log->rule_triggered ?? '-' }}</div>
                                    <small class="opacity-75 d-block">{{ $log->catatan_tindakan ?? '-' }}</small>
                                </td>
                                <td class="text-center">
                                    @if($log->status_review === 'MENUNGGU')
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-success py-1 px-2 btn-review-qc" data-id="{{ $log->id }}" data-status="DISETUJUI" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-review-qc" data-id="{{ $log->id }}" data-status="DITOLAK" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    @else
                                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                                        {{ $log->status_review }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 opacity-75">Belum ada data log QC harian.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: LAPORAN & GRAFIK QC -->
    <div class="tab-pane fade" id="pane-laporan-qc" role="tabpanel">
        <!-- FILTER LAPORAN -->
        <div class="ent-card mb-3">
            <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h6 class="mb-0 fw-bold">Filter Laporan &amp; Grafik Levey-Jennings QC</h6>
                    <small class="opacity-75">Saring data berdasarkan bahan kontrol, parameter, rentang tanggal, atau status review.</small>
                </div>
                <div class="d-flex gap-2 no-print">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-1" id="btnExportQcCsv">
                        <i class="fas fa-file-csv me-1 text-success"></i> Export CSV
                    </button>
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-1" id="btnPrintQcReport">
                        <i class="fas fa-print me-1 text-primary"></i> Cetak Laporan
                    </button>
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="ent-label">Bahan Kontrol</label>
                        <select class="form-select ent-input" id="report_material_id">
                            <option value="">-- Semua Bahan Kontrol --</option>
                            @foreach($materials as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->nama_material }} ({{ $mat->lot_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="ent-label">Parameter QC</label>
                        <select class="form-select ent-input" id="report_parameter_id">
                            <option value="">-- Semua Parameter --</option>
                            @foreach($parameters as $param)
                            <option value="{{ $param->id }}" data-material="{{ $param->qc_material_id }}">
                                {{ $param->label ?? $param->nama_parameter }} ({{ $param->nama_parameter }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="ent-label">Dari Tanggal</label>
                        <input type="date" class="form-control ent-input" id="report_date_from">
                    </div>
                    <div class="col-md-2">
                        <label class="ent-label">Sampai Tanggal</label>
                        <input type="date" class="form-control ent-input" id="report_date_to">
                    </div>
                    <div class="col-md-2">
                        <label class="ent-label">Status Review</label>
                        <select class="form-select ent-input" id="report_review_status">
                            <option value="">Semua</option>
                            <option value="DISETUJUI">DISETUJUI</option>
                            <option value="MENUNGGU">MENUNGGU</option>
                            <option value="DITOLAK">DITOLAK</option>
                        </select>
                    </div>
                </div>

                <!-- RINGKASAN METRIK LAPORAN -->
                <div class="row g-3 mt-2">
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase opacity-75" style="font-size: 0.65rem; font-weight: 700;">Total Run</div>
                            <div class="fw-bold fs-5 mt-1" id="repTotalRun" style="font-family: 'JetBrains Mono', monospace;">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase text-success" style="font-size: 0.65rem; font-weight: 700;">In Control</div>
                            <div class="fw-bold fs-5 mt-1 text-success" id="repInControl" style="font-family: 'JetBrains Mono', monospace;">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase text-warning" style="font-size: 0.65rem; font-weight: 700;">Warning 2SD</div>
                            <div class="fw-bold fs-5 mt-1 text-warning" id="repWarning" style="font-family: 'JetBrains Mono', monospace;">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase text-danger" style="font-size: 0.65rem; font-weight: 700;">Out Of Control</div>
                            <div class="fw-bold fs-5 mt-1 text-danger" id="repOutControl" style="font-family: 'JetBrains Mono', monospace;">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase opacity-75" style="font-size: 0.65rem; font-weight: 700;">Rata-Rata Z</div>
                            <div class="fw-bold fs-5 mt-1" id="repAvgZ" style="font-family: 'JetBrains Mono', monospace;">0.00</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="kpi-mini-card">
                            <div class="text-uppercase text-primary" style="font-size: 0.65rem; font-weight: 700;">Disetujui</div>
                            <div class="fw-bold fs-5 mt-1 text-primary" id="repApproved" style="font-family: 'JetBrains Mono', monospace;">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRAFIK LEVEY-JENNINGS & DISTRIBUSI STATUS -->
        <div class="row g-3 mb-3">
            <div class="col-lg-8">
                <div class="ent-card h-100">
                    <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold" id="ljChartTitle">Grafik Levey-Jennings (Z-Score)</h6>
                            <small class="opacity-75" id="ljChartSubtitle">Pilih 1 parameter spesifik untuk melihat garis batas Mean, ±1 SD, ±2 SD, dan ±3 SD.</small>
                        </div>
                        <span class="code-chip" id="ljTargetInfo">Target: -</span>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="lj-chart-wrapper">
                            <canvas id="leveyJenningsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ent-card h-100">
                    <div class="ent-card-header">
                        <h6 class="mb-0 fw-bold">Komposisi Status QC</h6>
                        <small class="opacity-75">Persentase hasil sesuai filter aktif.</small>
                    </div>
                    <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center">
                        <div style="position: relative; height: 260px; width: 100%;">
                            <canvas id="qcStatusDoughnutChart"></canvas>
                        </div>
                        <div class="mt-3 small opacity-75 text-center" id="qcPassRateText">Pass Rate (In Control): 0%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL REKAP LAPORAN QC -->
        <div class="ent-card mb-4">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold">Rekapitulasi Laporan Hasil QC</h6>
                <small class="opacity-75">Rincian hasil kontrol, target statistik, Z-Score, aturan Westgard, dan status validasi.</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100" id="tableQcReport">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 45px;">NO</th>
                                <th>Tanggal / Jam</th>
                                <th>Bahan Kontrol &amp; Lot</th>
                                <th>Parameter</th>
                                <th class="text-end">Nilai Hasil</th>
                                <th class="text-end">Mean / SD</th>
                                <th class="text-center">Z-Score</th>
                                <th class="text-center">Status QC</th>
                                <th>Aturan &amp; Tindakan</th>
                                <th class="text-center">Review</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyQcReport">
                            <tr>
                                <td colspan="10" class="text-center py-4 opacity-75">Memuat rekap laporan QC...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: PARAMETER QC -->
    <div class="tab-pane fade" id="pane-param-qc" role="tabpanel">
        <div class="ent-card mb-4">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold">Master Parameter &amp; Target Statistik QC</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive pb-3">
                    <table class="table table-custom align-middle mb-0 w-100" id="tableQcParams">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px;">Urutan</th>
                                <th>Bahan Kontrol</th>
                                <th>Parameter / Pemeriksaan</th>
                                <th>Satuan</th>
                                <th class="text-end">Mean</th>
                                <th class="text-end">SD</th>
                                <th class="text-end">Batas Bawah - Atas</th>
                                <th class="text-center" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parameters as $param)
                            <tr>
                                <td class="text-center"><span class="code-chip">{{ $param->urutan }}</span></td>
                                <td>
                                    <div class="fw-bold">{{ $param->nama_material }}</div>
                                    <small class="opacity-75">{{ $param->lot_number }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">
                                        <span class="code-chip me-1">{{ $param->nama_parameter }}</span>
                                        <span>{{ $param->label ?? $param->nama_parameter }}</span>
                                    </div>
                                    @if(!empty($param->nama_layanan))
                                    <small class="opacity-75 d-block mt-1"><span class="code-chip">{{ $param->kode_layanan }}</span> {{ $param->nama_layanan }}</small>
                                    @endif
                                </td>
                                <td>{{ $param->satuan ?? '-' }}</td>
                                <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ number_format((float) $param->target_mean, 2) }}</td>
                                <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ number_format((float) $param->target_sd, 2) }}</td>
                                <td class="text-end" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                    {{ number_format((float) $param->batas_bawah, 2) }} s/d {{ number_format((float) $param->batas_atas, 2) }}
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 btn-edit-param-qc"
                                            data-id="{{ $param->id }}"
                                            data-material="{{ $param->qc_material_id }}"
                                            data-pemeriksaan="{{ $param->master_pemeriksaan_id }}"
                                            data-master-param="{{ $param->master_parameter_id ?? '' }}"
                                            data-nama="{{ $param->nama_parameter }}"
                                            data-label="{{ $param->label ?? $param->nama_parameter }}"
                                            data-satuan="{{ $param->satuan }}"
                                            data-metode="{{ $param->metode }}"
                                            data-mean="{{ $param->target_mean }}"
                                            data-sd="{{ $param->target_sd }}"
                                            data-low="{{ $param->batas_bawah }}"
                                            data-high="{{ $param->batas_atas }}"
                                            data-urutan="{{ $param->urutan }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-delete-param-qc" data-id="{{ $param->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 opacity-75">Belum ada parameter QC terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: BAHAN KONTROL -->
    <div class="tab-pane fade" id="pane-material-qc" role="tabpanel">
        <div class="ent-card mb-4">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold">Daftar Bahan &amp; Lot Kontrol Laboratorium</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive pb-3">
                    <table class="table table-custom align-middle mb-0 w-100" id="tableQcMaterials">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Bahan Kontrol</th>
                                <th>Lot Number</th>
                                <th>Alat / Analyzer</th>
                                <th>Expired</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $mat)
                            <tr>
                                <td><span class="code-chip">{{ $mat->kode_material }}</span></td>
                                <td class="fw-bold">{{ $mat->nama_material }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace;">{{ $mat->lot_number }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $mat->nama_alat_tampil ?? $mat->nama_alat ?? '-' }}</div>
                                    @if(!empty($mat->kode_alat))
                                    <small class="opacity-75"><span class="code-chip">{{ $mat->kode_alat }}</span></small>
                                    @endif
                                </td>
                                <td style="font-family: 'JetBrains Mono', monospace;">{{ $mat->tanggal_expired ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">{{ $mat->status }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 btn-edit-material"
                                            data-id="{{ $mat->id }}"
                                            data-kode="{{ $mat->kode_material }}"
                                            data-nama="{{ $mat->nama_material }}"
                                            data-lot="{{ $mat->lot_number }}"
                                            data-instrument="{{ $mat->instrument_id }}"
                                            data-alat="{{ $mat->nama_alat }}"
                                            data-expired="{{ $mat->tanggal_expired }}"
                                            data-status="{{ $mat->status }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-delete-material" data-id="{{ $mat->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 opacity-75">Belum ada bahan kontrol QC.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BAHAN QC -->
<div class="modal fade" id="modalMaterial" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" id="titleModalMaterial" style="color: white;">Tambah Bahan Kontrol QC</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMaterialQc">
                @csrf
                <input type="hidden" name="material_id" id="material_id">
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="ent-label">Kode Bahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" name="kode_material" id="kode_material" required>
                        </div>
                        <div class="col-md-8">
                            <label class="ent-label">Nama Bahan Kontrol <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" name="nama_material" id="nama_material" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="ent-label">Lot Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" name="lot_number" id="lot_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-label">Alat / Analyzer (Master Alat)</label>
                            <select class="form-select ent-input" name="instrument_id" id="instrument_id">
                                <option value="">-- Pilih Alat / Manual --</option>
                                @foreach($alatList as $alat)
                                <option value="{{ $alat->instrument_id }}" data-nama="{{ $alat->nama_alat }}">
                                    {{ $alat->nama_alat }} ({{ $alat->kode_alat }})
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="nama_alat" id="nama_alat">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="ent-label">Tanggal Expired</label>
                            <input type="date" class="form-control ent-input" name="tanggal_expired" id="tanggal_expired">
                        </div>
                        <div class="col-md-6">
                            <label class="ent-label">Status</label>
                            <select class="form-select ent-input" name="status" id="material_status">
                                <option value="AKTIF">AKTIF</option>
                                <option value="NONAKTIF">NONAKTIF</option>
                                <option value="EXPIRED">EXPIRED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Bahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARAMETER QC -->
<div class="modal fade" id="modalParameterQc" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" id="titleModalParameterQc" style="color: white;">Tambah Parameter QC</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formParameterQc">
                @csrf
                <input type="hidden" name="parameter_id" id="qc_parameter_id">
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="ent-label">Bahan Kontrol <span class="text-danger">*</span></label>
                            <select class="form-select ent-input" name="qc_material_id" id="param_qc_material_id" required>
                                <option value="">-- Pilih Bahan Kontrol --</option>
                                @foreach($materials as $mat)
                                <option value="{{ $mat->id }}">{{ $mat->nama_material }} ({{ $mat->lot_number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-label">Pemeriksaan Lab <span class="text-danger">*</span></label>
                            <select class="form-select ent-input" name="master_pemeriksaan_id" id="param_master_pemeriksaan_id" required>
                                <option value="">-- Pilih Pemeriksaan Lab --</option>
                                @foreach($pemeriksaanLabList as $pem)
                                <option value="{{ $pem->id }}" data-nama="{{ $pem->nama_layanan }}">
                                    {{ $pem->nama_layanan }} ({{ $pem->kode_layanan }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <label class="ent-label">Parameter Pemeriksaan (Master Parameter) <span class="text-danger">*</span></label>
                            <select class="form-select ent-input" name="master_parameter_id" id="param_master_parameter_id" required>
                                <option value="">-- Pilih Pemeriksaan Lab Terlebih Dahulu --</option>
                                @foreach($masterParameterList ?? [] as $mp)
                                <option value="{{ $mp->id }}"
                                    data-pemeriksaan="{{ $mp->master_pemeriksaan_id }}"
                                    data-nama="{{ $mp->nama_parameter }}"
                                    data-label="{{ $mp->label ?: $mp->nama_parameter }}"
                                    data-satuan="{{ $mp->satuan }}"
                                    data-metode="{{ $mp->metode }}"
                                    data-urutan="{{ $mp->urutan }}">
                                    {{ $mp->label ?: $mp->nama_parameter }} ({{ $mp->nama_parameter }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="ent-label">Kode Parameter (Otomatis)</label>
                            <input type="text" class="form-control ent-input" name="nama_parameter" id="param_nama_parameter" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-label">Label Keterangan (Otomatis)</label>
                            <input type="text" class="form-control ent-input" name="label" id="param_label" readonly>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="ent-label">Satuan (Otomatis)</label>
                            <input type="text" class="form-control ent-input" name="satuan" id="param_satuan" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="ent-label">Metode (Otomatis)</label>
                            <input type="text" class="form-control ent-input" name="metode" id="param_metode" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="ent-label">Urutan (Otomatis)</label>
                            <input type="number" class="form-control ent-input" name="urutan" id="param_urutan" value="0" readonly>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="ent-label">Target Mean <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control ent-input" name="target_mean" id="param_target_mean" required>
                        </div>
                        <div class="col-md-3">
                            <label class="ent-label">Target SD <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control ent-input" name="target_sd" id="param_target_sd" required>
                        </div>
                        <div class="col-md-3">
                            <label class="ent-label">Batas Bawah</label>
                            <input type="number" step="any" class="form-control ent-input" name="batas_bawah" id="param_batas_bawah">
                        </div>
                        <div class="col-md-3">
                            <label class="ent-label">Batas Atas</label>
                            <input type="number" step="any" class="form-control ent-input" name="batas_atas" id="param_batas_atas">
                        </div>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Parameter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL INPUT HASIL QC HARIAN -->
<div class="modal fade" id="modalInputQc" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">Input Hasil Quality Control Harian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formInputQc">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="ent-label">Bahan Kontrol <span class="text-danger">*</span></label>
                            <select class="form-select ent-input" name="qc_material_id" id="log_qc_material_id" required>
                                <option value="">-- Pilih Bahan Kontrol --</option>
                                @foreach($materials as $mat)
                                <option value="{{ $mat->id }}">{{ $mat->nama_material }} ({{ $mat->lot_number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-label">Parameter QC <span class="text-danger">*</span></label>
                            <select class="form-select ent-input" name="qc_parameter_id" id="log_qc_parameter_id" required>
                                <option value="">-- Pilih Parameter QC --</option>
                                @foreach($parameters as $param)
                                <option value="{{ $param->id }}" data-material="{{ $param->qc_material_id }}">
                                    {{ $param->label ?? $param->nama_parameter }} ({{ $param->nama_parameter }}) - Mean: {{ $param->target_mean }}, SD: {{ $param->target_sd }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="ent-label">Tanggal QC <span class="text-danger">*</span></label>
                            <input type="date" class="form-control ent-input" name="tanggal_qc" id="log_tanggal_qc" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="ent-label">Jam QC <span class="text-danger">*</span></label>
                            <input type="time" class="form-control ent-input" name="jam_qc" id="log_jam_qc" value="{{ date('H:i') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="ent-label">Nilai Hasil <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control ent-input" name="nilai_hasil" id="log_nilai_hasil" required>
                        </div>
                    </div>

                    <div id="qcLogStatusAlert" class="alert alert-info py-2 px-3 mb-3 d-none" style="font-size: 0.78rem; border-radius: 10px;"></div>

                    <div>
                        <label class="ent-label">Catatan / Tindakan Korektif</label>
                        <textarea class="form-control" name="catatan_tindakan" id="log_catatan_tindakan" rows="2" placeholder="Isi tindakan korektif jika hasil di luar batas kontrol..."></textarea>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnSubmitInputQc">Simpan Hasil QC</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TUNGGU & PROSES HASIL QC DARI ALAT -->
<div class="modal fade" id="modalTungguAlatQc" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-microchip me-2"></i> Proses Hasil QC Otomatis dari Alat
                </h5>
                <button type="button" class="btn-close btn-close-white" id="btnCloseModalTungguAlat" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="ent-label">Filter Alat / Analyzer</label>
                    <select class="form-select ent-input" id="poll_instrument_id">
                        <option value="">-- Semua Alat Aktif --</option>
                        @foreach($alatList as $alat)
                        <option value="{{ $alat->instrument_id }}" {{ $alat->instrument_id == 100 ? 'selected' : '' }}>
                            {{ $alat->nama_alat }} ({{ $alat->kode_alat }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="ent-label">Bahan Kontrol QC Tujuan <span class="text-danger">*</span></label>
                    <select class="form-select ent-input" id="poll_qc_material_id" required>
                        @foreach($materials as $mat)
                        <option value="{{ $mat->id }}">{{ $mat->nama_material }} ({{ $mat->lot_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div id="stateMenungguAlat" class="text-center py-4 border rounded-3" style="border-color: var(--ent-grid-border) !important;">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <div class="fw-bold mb-1">Menunggu alat mengirim hasil QC...</div>
                    <small class="opacity-75 d-block">Silakan jalankan sampel kontrol di analyzer (misal Sysmex XN-550/XN-500).</small>
                </div>

                <div id="stateDataAlatDitemukan" class="d-none p-3 border rounded-3" style="border-color: rgba(5, 150, 105, 0.45) !important; background: rgba(5, 150, 105, 0.06);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="ent-badge" style="background: rgba(5, 150, 105, 0.16); color: #059669;">
                            <i class="fas fa-check-circle"></i> Data Diterima dari Alat
                        </span>
                        <small class="font-monospace" id="infoAlatTanggal"></small>
                    </div>
                    <div class="small mb-1"><strong>Alat:</strong> <span id="infoAlatNama">-</span></div>
                    <div class="small mb-1"><strong>No. Lab / ID:</strong> <span id="infoAlatNolab">-</span></div>
                    <div class="small mb-0"><strong>Jumlah Item Parameter:</strong> <span id="infoAlatTotal">0</span> item</div>
                </div>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" id="btnBatalTungguAlat">Tutup</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2 d-none" id="btnSimpanHasilAlatQc">
                    <i class="fas fa-bolt me-1"></i> Proses &amp; Simpan Hasil QC
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
    let qcPollTimer = null;
    let currentIncomingId = null;
    const modalTungguEl = document.getElementById('modalTungguAlatQc');
    const modalTungguBs = modalTungguEl ? new bootstrap.Modal(modalTungguEl) : null;

    function stopQcPolling() {
        if (qcPollTimer) {
            clearInterval(qcPollTimer);
            qcPollTimer = null;
        }
    }

    function checkIncomingQc() {
        $.get("{{ route('lab_qc.incoming.poll') }}", {
            instrument_id: $('#poll_instrument_id').val()
        }, function(res) {
            if (res.found && res.incoming_id) {
                stopQcPolling();
                currentIncomingId = res.incoming_id;
                $('#infoAlatNama').text(res.nama_alat + ' (ID: ' + (res.instrument_id ?? '-') + ')');
                $('#infoAlatNolab').text(res.nolab || '-');
                $('#infoAlatTanggal').text(res.tanggal_alat || '-');
                $('#infoAlatTotal').text(res.total_item || 0);

                $('#stateMenungguAlat').addClass('d-none');
                $('#stateDataAlatDitemukan').removeClass('d-none');
                $('#btnSimpanHasilAlatQc').removeClass('d-none');
            }
        });
    }

    function startQcPolling() {
        stopQcPolling();
        currentIncomingId = null;
        $('#stateDataAlatDitemukan').addClass('d-none');
        $('#btnSimpanHasilAlatQc').addClass('d-none');
        $('#stateMenungguAlat').removeClass('d-none');

        checkIncomingQc();
        qcPollTimer = setInterval(checkIncomingQc, 2000);
    }

    $('#btnProsesHasilQc').on('click', function() {
        if (!modalTungguBs) return;
        modalTungguBs.show();
        startQcPolling();
    });

    $('#poll_instrument_id').on('change', function() {
        startQcPolling();
    });

    $('#btnCloseModalTungguAlat, #btnBatalTungguAlat').on('click', function() {
        stopQcPolling();
        if (modalTungguBs) modalTungguBs.hide();
    });

    $('#btnSimpanHasilAlatQc').on('click', function() {
        if (!currentIncomingId) return;
        const btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url: "{{ route('lab_qc.incoming.process') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                incoming_id: currentIncomingId,
                qc_material_id: $('#poll_qc_material_id').val()
            },
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Diproses',
                    text: res.message
                }).then(() => location.reload());
            },
            error: function(xhr) {
                btn.prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Gagal memproses hasil QC dari alat.'
                });
            }
        });
    });

    $(document).ready(function() {
        ['#tableQcLogs', '#tableQcParams', '#tableQcMaterials'].forEach(function(selector) {
            if ($(selector).length && $(selector).find('tbody tr').length > 0 && !$(selector).find('tbody tr td[colspan]').length) {
                new DataTable(selector, {
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari data...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "<i class='fas fa-angle-right'></i>",
                            previous: "<i class='fas fa-angle-left'></i>"
                        }
                    }
                });
            }
        });

        $('#instrument_id').on('change', function() {
            const selectedNama = $(this).find('option:selected').data('nama') || '';
            $('#nama_alat').val(selectedNama);
        });

        $('#btnOpenMaterialModal').on('click', function() {
            $('#formMaterialQc')[0].reset();
            $('#material_id').val('');
            $('#nama_alat').val('');
            $('#titleModalMaterial').text('Tambah Bahan Kontrol QC');
        });

        $(document).on('click', '.btn-edit-material', function() {
            $('#material_id').val($(this).data('id'));
            $('#kode_material').val($(this).data('kode'));
            $('#nama_material').val($(this).data('nama'));
            $('#lot_number').val($(this).data('lot'));
            $('#instrument_id').val($(this).data('instrument') || '');
            $('#nama_alat').val($(this).data('alat') || '');
            $('#tanggal_expired').val($(this).data('expired'));
            $('#material_status').val($(this).data('status'));
            $('#titleModalMaterial').text('Edit Bahan Kontrol QC');
            new bootstrap.Modal(document.getElementById('modalMaterial')).show();
        });

        $('#formMaterialQc').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('lab_qc.material.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1400,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Gagal menyimpan bahan QC.'
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete-material', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Bahan QC?',
                text: 'Parameter dan log terkait juga akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('lab_qc.material.delete') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: res.message,
                                timer: 1300,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    });
                }
            });
        });

        function filterMasterParameterByPemeriksaan(pemeriksaanId, selectedMasterParamId = '') {
            const selectParam = $('#param_master_parameter_id');
            selectParam.find('option').each(function() {
                const val = $(this).val();
                if (!val) {
                    $(this).text(pemeriksaanId ? '-- Pilih Parameter Pemeriksaan --' : '-- Pilih Pemeriksaan Lab Terlebih Dahulu --');
                    $(this).prop('disabled', false).show();
                    return;
                }
                const optPem = String($(this).data('pemeriksaan') || '');
                if (pemeriksaanId && optPem === String(pemeriksaanId)) {
                    $(this).prop('disabled', false).show();
                } else {
                    $(this).prop('disabled', true).hide();
                }
            });
            selectParam.val(selectedMasterParamId || '');
        }

        function fillMasterParamFields() {
            const opt = $('#param_master_parameter_id').find('option:selected');
            if (!$('#param_master_parameter_id').val() && !opt.val()) {
                $('#param_nama_parameter').val('');
                $('#param_label').val('');
                $('#param_satuan').val('');
                $('#param_metode').val('');
                $('#param_urutan').val(0);
                return;
            }
            $('#param_nama_parameter').val(opt.data('nama') || '');
            $('#param_label').val(opt.data('label') || opt.data('nama') || '');
            $('#param_satuan').val(opt.data('satuan') || '');
            $('#param_metode').val(opt.data('metode') || '');
            $('#param_urutan').val(opt.data('urutan') ?? 0);
        }

        $('#param_master_pemeriksaan_id').on('change', function() {
            filterMasterParameterByPemeriksaan($(this).val(), '');
            $('#param_nama_parameter, #param_label, #param_satuan, #param_metode').val('');
            $('#param_urutan').val(0);
        });

        $('#param_master_parameter_id').on('change', fillMasterParamFields);

        $('#btnOpenParameterModal').on('click', function() {
            $('#formParameterQc')[0].reset();
            $('#qc_parameter_id').val('');
            filterMasterParameterByPemeriksaan('', '');
            $('#titleModalParameterQc').text('Tambah Parameter QC');
        });

        $(document).on('click', '.btn-edit-param-qc', function() {
            const pemeriksaanId = $(this).data('pemeriksaan') || '';
            const masterParamId = $(this).data('master-param') || '';

            $('#qc_parameter_id').val($(this).data('id'));
            $('#param_qc_material_id').val($(this).data('material'));
            $('#param_master_pemeriksaan_id').val(pemeriksaanId);
            filterMasterParameterByPemeriksaan(pemeriksaanId, masterParamId);

            $('#param_nama_parameter').val($(this).data('nama'));
            $('#param_label').val($(this).data('label') || $(this).data('nama'));
            $('#param_satuan').val($(this).data('satuan'));
            $('#param_metode').val($(this).data('metode'));
            $('#param_target_mean').val($(this).data('mean'));
            $('#param_target_sd').val($(this).data('sd'));
            $('#param_batas_bawah').val($(this).data('low'));
            $('#param_batas_atas').val($(this).data('high'));
            $('#param_urutan').val($(this).data('urutan'));
            $('#titleModalParameterQc').text('Edit Parameter QC');
            new bootstrap.Modal(document.getElementById('modalParameterQc')).show();
        });

        $('#formParameterQc').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('lab_qc.parameter.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1400,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Gagal menyimpan parameter QC.'
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete-param-qc', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Parameter QC?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('lab_qc.parameter.delete') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: res.message,
                                timer: 1300,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    });
                }
            });
        });

        const existingQcLogs = @json($logs);
        const qcParametersList = @json($parameters);

        function evaluateQcLogSelection() {
            const matId = $('#log_qc_material_id').val();
            const paramId = $('#log_qc_parameter_id').val();
            const tglQc = $('#log_tanggal_qc').val();
            const alertBox = $('#qcLogStatusAlert');
            const submitBtn = $('#btnSubmitInputQc');

            alertBox.addClass('d-none').removeClass('alert-info alert-warning alert-success alert-danger').html('');
            submitBtn.prop('disabled', false).text('Simpan Hasil QC');

            if (!matId || !paramId || !tglQc) {
                return;
            }

            const matched = existingQcLogs.find(item =>
                String(item.qc_material_id) === String(matId) &&
                String(item.qc_parameter_id) === String(paramId) &&
                String(item.tanggal_qc) === String(tglQc)
            );

            if (!matched) {
                return;
            }

            if (matched.status_review === 'DISETUJUI') {
                alertBox
                    .removeClass('d-none')
                    .addClass('alert-success')
                    .html('<i class="fas fa-check-circle me-1"></i> Hasil QC untuk bahan kontrol &amp; parameter ini pada tanggal tersebut <strong>sudah DISETUJUI</strong>. Tidak perlu diisi lagi.');
                submitBtn.prop('disabled', true).text('Sudah Disetujui');
            } else if (matched.status_review === 'MENUNGGU') {
                $('#log_nilai_hasil').val(matched.nilai_hasil);
                if (matched.jam_qc) {
                    $('#log_jam_qc').val(String(matched.jam_qc).substring(0, 5));
                }
                $('#log_catatan_tindakan').val(matched.catatan_tindakan || '');

                alertBox
                    .removeClass('d-none')
                    .addClass('alert-warning')
                    .html('<i class="fas fa-edit me-1"></i> Sudah ada hasil QC berstatus <strong>MENUNGGU</strong> validasi. Menyimpan akan <strong>langsung meng-update</strong> data tersebut.');
                submitBtn.prop('disabled', false).text('Update Hasil QC');
            } else if (matched.status_review === 'DITOLAK') {
                alertBox
                    .removeClass('d-none')
                    .addClass('alert-danger')
                    .html('<i class="fas fa-redo me-1"></i> Hasil QC sebelumnya <strong>DITOLAK</strong>. Silakan isi dan simpan hasil QC yang baru.');
                submitBtn.prop('disabled', false).text('Simpan Hasil QC Baru');
            }
        }

        $('#log_qc_material_id').on('change', function() {
            const matId = $(this).val();
            $('#log_qc_parameter_id option').each(function() {
                const optMat = $(this).data('material');
                if (!optMat || !matId || optMat == matId) {
                    $(this).prop('disabled', false).show();
                } else {
                    $(this).prop('disabled', true).hide();
                }
            });
            $('#log_qc_parameter_id').val('');
            evaluateQcLogSelection();
        });

        $('#log_qc_parameter_id, #log_tanggal_qc').on('change', function() {
            evaluateQcLogSelection();
        });

        $('#btnOpenInputQcModal').on('click', function() {
            $('#formInputQc')[0].reset();
            $('#log_tanggal_qc').val("{{ date('Y-m-d') }}");
            $('#log_jam_qc').val("{{ date('H:i') }}");
            evaluateQcLogSelection();
        });

        $('#formInputQc').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('lab_qc.log.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: res.status_qc === 'OUT_OF_CONTROL' ? 'warning' : 'success',
                        title: res.rule_triggered || 'Tersimpan',
                        text: `${res.message} (Z-Score: ${res.z_score} SD)`
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Gagal menyimpan hasil QC.'
                    });
                }
            });
        });

        $(document).on('click', '.btn-review-qc', function() {
            const id = $(this).data('id');
            const statusReview = $(this).data('status');
            $.ajax({
                url: "{{ route('lab_qc.log.review') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status_review: statusReview
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }
            });
        });

        // =========================================================
        // LAPORAN & GRAFIK LEVEY-JENNINGS QC
        // =========================================================
        let ljChartInstance = null;
        let statusDoughnutInstance = null;
        let currentFilteredLogs = [];

        function getFilteredQcLogs() {
            const matId = $('#report_material_id').val();
            const paramId = $('#report_parameter_id').val();
            const dateFrom = $('#report_date_from').val();
            const dateTo = $('#report_date_to').val();
            const reviewStat = $('#report_review_status').val();

            return existingQcLogs.filter(item => {
                if (matId && String(item.qc_material_id) !== String(matId)) return false;
                if (paramId && String(item.qc_parameter_id) !== String(paramId)) return false;
                if (dateFrom && String(item.tanggal_qc) < dateFrom) return false;
                if (dateTo && String(item.tanggal_qc) > dateTo) return false;
                if (reviewStat && String(item.status_review) !== reviewStat) return false;
                return true;
            }).sort((a, b) => {
                const dA = `${a.tanggal_qc || ''} ${a.jam_qc || ''}`;
                const dB = `${b.tanggal_qc || ''} ${b.jam_qc || ''}`;
                return dA.localeCompare(dB) || Number(a.id) - Number(b.id);
            });
        }

        function renderQcReportSummary(rows) {
            const total = rows.length;
            const inCtrl = rows.filter(r => r.status_qc === 'IN_CONTROL').length;
            const warn = rows.filter(r => r.status_qc === 'WARNING_2SD').length;
            const outCtrl = rows.filter(r => r.status_qc === 'OUT_OF_CONTROL').length;
            const approved = rows.filter(r => r.status_review === 'DISETUJUI').length;

            const avgZ = total > 0
                ? (rows.reduce((acc, r) => acc + (parseFloat(r.z_score) || 0), 0) / total).toFixed(2)
                : '0.00';

            const passRate = total > 0 ? Math.round((inCtrl / total) * 100) : 0;

            $('#repTotalRun').text(total);
            $('#repInControl').text(inCtrl);
            $('#repWarning').text(warn);
            $('#repOutControl').text(outCtrl);
            $('#repAvgZ').text(`${avgZ} SD`);
            $('#repApproved').text(approved);
            $('#qcPassRateText').text(`Pass Rate (In Control): ${passRate}% dari ${total} run`);

            const doughnutCtx = document.getElementById('qcStatusDoughnutChart');
            if (doughnutCtx && typeof Chart !== 'undefined') {
                if (statusDoughnutInstance) {
                    statusDoughnutInstance.destroy();
                }
                statusDoughnutInstance = new Chart(doughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['In Control', 'Warning 2SD', 'Out of Control'],
                        datasets: [{
                            data: [inCtrl, warn, outCtrl],
                            backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        function renderLeveyJenningsChart(rows) {
            const canvas = document.getElementById('leveyJenningsChart');
            if (!canvas || typeof Chart === 'undefined') return;

            const selectedParamId = $('#report_parameter_id').val();
            const paramMeta = qcParametersList.find(p => String(p.id) === String(selectedParamId));

            if (paramMeta) {
                const paramLabel = paramMeta.label || paramMeta.nama_parameter;
                $('#ljChartTitle').text(`Grafik Levey-Jennings — ${paramLabel} (${paramMeta.nama_parameter})`);
                $('#ljChartSubtitle').text(`Bahan: ${paramMeta.nama_material} (Lot: ${paramMeta.lot_number})`);
                $('#ljTargetInfo').text(`Mean: ${Number(paramMeta.target_mean).toFixed(2)} | SD: ${Number(paramMeta.target_sd).toFixed(2)} ${paramMeta.satuan || ''}`);
            } else {
                $('#ljChartTitle').text('Grafik Tren Z-Score QC (Semua Parameter Terfilter)');
                $('#ljChartSubtitle').text('Pilih 1 Parameter QC tertentu pada filter di atas untuk menampilkan garis Mean & ±1/±2/±3 SD secara spesifik.');
                $('#ljTargetInfo').text('Skala: Z-Score (SD)');
            }

            const labels = rows.map(r => `${r.tanggal_qc} ${String(r.jam_qc || '').substring(0, 5)}`.trim());
            const zValues = rows.map(r => parseFloat(r.z_score) || 0);
            const pointColors = rows.map(r => {
                if (r.status_qc === 'IN_CONTROL') return '#10b981';
                if (r.status_qc === 'WARNING_2SD') return '#f59e0b';
                return '#f43f5e';
            });

            const makeConstantLine = (val) => labels.map(() => val);

            if (ljChartInstance) {
                ljChartInstance.destroy();
            }

            ljChartInstance = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Z-Score Hasil QC',
                            data: zValues,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.14)',
                            pointBackgroundColor: pointColors,
                            pointBorderColor: pointColors,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            borderWidth: 2.5,
                            tension: 0.2,
                            fill: false
                        },
                        {
                            label: '+3 SD (Upper Limit)',
                            data: makeConstantLine(3),
                            borderColor: '#e11d48',
                            borderDash: [6, 4],
                            borderWidth: 1.5,
                            pointRadius: 0,
                            fill: false
                        },
                        {
                            label: '+2 SD (Warning)',
                            data: makeConstantLine(2),
                            borderColor: '#d97706',
                            borderDash: [4, 4],
                            borderWidth: 1.25,
                            pointRadius: 0,
                            fill: false
                        },
                        {
                            label: 'Mean (0 SD)',
                            data: makeConstantLine(0),
                            borderColor: '#059669',
                            borderWidth: 1.75,
                            pointRadius: 0,
                            fill: false
                        },
                        {
                            label: '-2 SD (Warning)',
                            data: makeConstantLine(-2),
                            borderColor: '#d97706',
                            borderDash: [4, 4],
                            borderWidth: 1.25,
                            pointRadius: 0,
                            fill: false
                        },
                        {
                            label: '-3 SD (Lower Limit)',
                            data: makeConstantLine(-3),
                            borderColor: '#e11d48',
                            borderDash: [6, 4],
                            borderWidth: 1.5,
                            pointRadius: 0,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                afterBody: function(items) {
                                    if (!items.length) return '';
                                    const row = rows[items[0].dataIndex];
                                    if (!row) return '';
                                    return [
                                        `Parameter: ${row.label || row.nama_parameter}`,
                                        `Nilai Hasil: ${Number(row.nilai_hasil).toFixed(2)} ${row.satuan || ''}`,
                                        `Status: ${row.status_qc} (${row.rule_triggered || '-'})`,
                                        `Review: ${row.status_review}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            suggestedMin: -3.5,
                            suggestedMax: 3.5,
                            title: {
                                display: true,
                                text: 'Standar Deviasi (Z-Score)'
                            }
                        }
                    }
                }
            });
        }

        function renderQcReportTable(rows) {
            const tbody = $('#tbodyQcReport');
            if (!rows.length) {
                tbody.html('<tr><td colspan="10" class="text-center py-4 opacity-75">Tidak ada data hasil QC yang sesuai dengan filter.</td></tr>');
                return;
            }

            let html = '';
            rows.forEach((log, idx) => {
                let statusBadge = '';
                if (log.status_qc === 'IN_CONTROL') {
                    statusBadge = `<span class="ent-badge" style="background: rgba(5, 150, 105, 0.15); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.35);"><i class="fas fa-check-circle me-1"></i> In Control</span>`;
                } else if (log.status_qc === 'WARNING_2SD') {
                    statusBadge = `<span class="ent-badge" style="background: rgba(217, 119, 6, 0.15); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.35);"><i class="fas fa-exclamation-triangle me-1"></i> Warning 2SD</span>`;
                } else {
                    statusBadge = `<span class="ent-badge" style="background: rgba(225, 29, 72, 0.15); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.35);"><i class="fas fa-times-circle me-1"></i> Out of Control</span>`;
                }

                const paramDisplay = log.label && log.label !== log.nama_parameter
                    ? `<div class="fw-bold">${log.label}</div><span class="code-chip mt-1">${log.nama_parameter}</span>`
                    : `<div class="fw-bold">${log.nama_parameter}</div>`;

                html += `
                    <tr>
                        <td class="text-center fw-semibold">${idx + 1}</td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <div class="fw-bold">${log.tanggal_qc || '-'}</div>
                            <small class="opacity-75">${String(log.jam_qc || '').substring(0, 5)}</small>
                        </td>
                        <td>
                            <div class="fw-bold">${log.nama_material || '-'}</div>
                            <span class="code-chip mt-1">LOT: ${log.lot_number || '-'}</span>
                        </td>
                        <td>${paramDisplay}</td>
                        <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">
                            ${Number(log.nilai_hasil || 0).toFixed(2)} <small class="opacity-75">${log.satuan || ''}</small>
                        </td>
                        <td class="text-end" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            ${Number(log.target_mean || 0).toFixed(2)} ± ${Number(log.target_sd || 0).toFixed(2)}
                        </td>
                        <td class="text-center">
                            <span class="code-chip">${Number(log.z_score || 0).toFixed(2)} SD</span>
                        </td>
                        <td class="text-center">${statusBadge}</td>
                        <td>
                            <div class="fw-semibold" style="font-size: 0.78rem;">${log.rule_triggered || '-'}</div>
                            <small class="opacity-75 d-block">${log.catatan_tindakan || '-'}</small>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                                ${log.status_review || '-'}
                            </span>
                        </td>
                    </tr>
                `;
            });

            tbody.html(html);
        }

        function refreshQcReportAndCharts() {
            currentFilteredLogs = getFilteredQcLogs();
            renderQcReportSummary(currentFilteredLogs);
            renderLeveyJenningsChart(currentFilteredLogs);
            renderQcReportTable(currentFilteredLogs);
        }

        $('#report_material_id').on('change', function() {
            const matId = $(this).val();
            $('#report_parameter_id option').each(function() {
                const optMat = $(this).data('material');
                if (!optMat || !matId || String(optMat) === String(matId)) {
                    $(this).prop('disabled', false).show();
                } else {
                    $(this).prop('disabled', true).hide();
                }
            });
            $('#report_parameter_id').val('');
            refreshQcReportAndCharts();
        });

        $('#report_parameter_id, #report_date_from, #report_date_to, #report_review_status').on('change', function() {
            refreshQcReportAndCharts();
        });

        $('#tab-laporan-qc').on('shown.bs.tab', function() {
            refreshQcReportAndCharts();
        });

        $('#btnPrintQcReport').on('click', function() {
            window.print();
        });

        $('#btnExportQcCsv').on('click', function() {
            if (!currentFilteredLogs.length) {
                Swal.fire({
                    icon: 'info',
                    title: 'Data Kosong',
                    text: 'Tidak ada data laporan QC untuk di-export.'
                });
                return;
            }

            const headers = [
                'Tanggal', 'Jam', 'Bahan Kontrol', 'Lot Number',
                'Kode Parameter', 'Label Parameter', 'Nilai Hasil', 'Satuan',
                'Target Mean', 'Target SD', 'Z-Score', 'Status QC',
                'Aturan Westgard', 'Catatan Tindakan', 'Status Review'
            ];

            const csvRows = [headers.join(',')];
            currentFilteredLogs.forEach(r => {
                const row = [
                    r.tanggal_qc || '',
                    String(r.jam_qc || '').substring(0, 5),
                    r.nama_material || '',
                    r.lot_number || '',
                    r.nama_parameter || '',
                    r.label || r.nama_parameter || '',
                    r.nilai_hasil ?? '',
                    r.satuan || '',
                    r.target_mean ?? '',
                    r.target_sd ?? '',
                    r.z_score ?? '',
                    r.status_qc || '',
                    r.rule_triggered || '',
                    r.catatan_tindakan || '',
                    r.status_review || ''
                ].map(val => `"${String(val).replace(/"/g, '""')}"`);
                csvRows.push(row.join(','));
            });

            const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `laporan-qc-lab-{{ date('Y-m-d') }}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });

        refreshQcReportAndCharts();
    });
</script>
@endsection
