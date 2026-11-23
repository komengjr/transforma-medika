@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (APPROVAL PINJAMAN)
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card>.card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-surface));
    }

    /* Hero Banner */
    .ent-header-banner {
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

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
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
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-warning {
        background-color: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    /* Adaptive Floating Filters */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 5px;
        left: 11px;
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        pointer-events: none;
        z-index: 5;
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

    .ent-input:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Avatar Anggota */
    .peserta-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(2, 132, 199, 0.18));
        border: 1px solid rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.72rem;
        flex-shrink: 0;
    }

    /* Soft Badges */
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

    .badge-approved {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .badge-rejected {
        background-color: rgba(225, 29, 72, 0.15) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.35);
    }

    .badge-pending {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.38);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
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
        height: 1px;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td:not(.action-cell-full) {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* Collapsible Riwayat Row Styling */
    .ent-riwayat-toggle {
        cursor: pointer;
        user-select: none;
    }

    .ent-riwayat-toggle.is-open > td {
        background-color: rgba(79, 70, 229, 0.11) !important;
    }

    .ent-chevron {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background-color: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-size: 0.7rem;
        transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        margin-right: 6px;
        flex-shrink: 0;
    }

    .ent-riwayat-toggle.is-open .ent-chevron {
        transform: rotate(180deg);
        background-color: #4f46e5;
        color: #ffffff;
    }

    .ent-riwayat-detail-cell {
        background-color: rgba(79, 70, 229, 0.03) !important;
        border-top: none !important;
    }

    /* SOLID FULL-CELL ACTION BUTTON STYLING (NON-TRANSPARENT) */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
        background-color: var(--ent-action-bg) !important;
    }

    .table-custom td.action-cell-full>.dropdown,
    .table-custom td.action-cell-full>.btn-group {
        display: flex !important;
        width: 100% !important;
        height: 100% !important;
        background-color: var(--ent-action-bg);
    }

    .table-custom td.action-cell-full .dropdown>.btn,
    .table-custom td.action-cell-full .btn-group>.btn,
    .table-custom td.action-cell-full>.btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 50px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        opacity: 1 !important;
        box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.16);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .table-custom td.action-cell-full .dropdown>.btn:hover,
    .table-custom td.action-cell-full .dropdown>.btn:focus,
    .table-custom td.action-cell-full .dropdown>.btn.show,
    .table-custom td.action-cell-full .btn-group>.btn:hover,
    .table-custom td.action-cell-full>.btn:hover,
    .table-custom tbody tr:hover td.action-cell-full .dropdown>.btn {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    /* Zero horizontal padding/margin on flush card body & DataTables wrapper */
    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

    .ent-card-body-flush .table-responsive {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    [id$="_wrapper"]>.row:first-child,
    [id$="_wrapper"] .dt-layout-row:first-child {
        padding: 14px 20px 10px 20px;
        margin: 0 !important;
    }

    [id$="_wrapper"]>.row:last-child,
    [id$="_wrapper"] .dt-layout-row:last-child {
        padding: 12px 20px 16px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    [id$="_wrapper"] .dt-layout-table {
        margin: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    [id$="_wrapper"] .dt-layout-table > .dt-layout-cell {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    [id$="_wrapper"] .dataTables_filter input,
    [id$="_wrapper"] .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    [id$="_wrapper"] .dataTables_filter input:focus,
    [id$="_wrapper"] .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    [id$="_wrapper"] .dataTables_length select,
    [id$="_wrapper"] .dt-length select {
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

    /* Modal Enterprise Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-sub-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg);
        overflow: hidden;
    }

    .ent-sub-card-header {
        background-color: rgba(79, 70, 229, 0.08);
        border-bottom: 1px solid var(--ent-grid-border);
        padding: 10px 14px;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-check-double fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-user-check me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} APPROVAL
                                </span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: #ffffff;">Approval Peminjaman Uang</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Daftar pengajuan pinjaman anggota yang menunggu otorisasi persetujuan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1. Data Tables: Approval Utama -->
<div class="ent-card mb-4">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="row g-2 align-items-center justify-content-between">
            <div class="col-auto d-flex align-items-center gap-2">
                <i class="fas fa-clock text-warning"></i>
                <h6 class="fw-bold m-0">Daftar Menunggu Approval</h6>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-floating-custom">
                    <label>Cari Akad / Anggota</label>
                    <input type="text" id="filterApprovalKeyword" class="form-control ent-input" placeholder="Ketik No. Akad atau Nama...">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body ent-card-body-flush ent-table-surface">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100" id="tableApproval">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th style="width: 14%;">Tanggal</th>
                        <th style="width: 18%;">No. Akad</th>
                        <th style="width: 28%;">Anggota</th>
                        <th class="text-end" style="width: 18%;">Plafon</th>
                        <th class="text-center" style="width: 18%;">Tenor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $row)
                    @php
                    $initial = $row->kop_master_peserta_name ? strtoupper(substr($row->kop_master_peserta_name, 0, 2)) : 'AG';
                    @endphp
                    <tr data-search="{{ strtolower(($row->nota_nomor ?? '') . ' ' . ($row->kop_master_peserta_name ?? '') . ' ' . ($row->kop_master_peserta_code ?? '')) }}">
                        <td class="action-cell-full text-center align-middle">
                            <button type="button" class="btn btn-review" data-id="{{ $row->id }}" title="Review Pengajuan">
                                <i class="fas fa-search"></i>
                            </button>
                        </td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                            {{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d M Y') }}
                        </td>
                        <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">
                            {{ $row->nota_nomor }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="peserta-avatar">{{ $initial }}</div>
                                <div>
                                    <div class="fw-bold text-uppercase" style="font-size: 0.8rem;">{{ $row->kop_master_peserta_name }}</div>
                                    <span class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem;">ID: {{ $row->kop_master_peserta_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">
                            Rp {{ number_format($row->jumlah_pinjaman, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">
                                {{ $row->tenor_bulan }} Bln
                            </span>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. Data Tables: History / Riwayat Peminjaman Keseluruhan -->
<div class="ent-card">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="row g-2 align-items-center justify-content-between">
            <div class="col-auto d-flex align-items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                <h6 class="fw-bold m-0">Riwayat Peminjaman (Disetujui / Ditolak)</h6>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="form-floating-custom">
                    <label>Filter Status</label>
                    <select id="filterStatusHistory" class="form-select ent-input">
                        <option value="">Semua Status</option>
                        <option value="APPROVED">APPROVED</option>
                        <option value="REJECTED">REJECTED</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body ent-card-body-flush ent-table-surface">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100" id="tableHistoryGlobal">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th style="width: 14%;">Tanggal</th>
                        <th style="width: 18%;">No. Akad</th>
                        <th style="width: 28%;">Anggota</th>
                        <th class="text-end" style="width: 14%;">Plafon</th>
                        <th class="text-center" style="width: 10%;">Tenor</th>
                        <th class="text-center" style="width: 12%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history ?? [] as $hist)
                    @php
                    $histInitial = $hist->kop_master_peserta_name ? strtoupper(substr($hist->kop_master_peserta_name, 0, 2)) : 'AG';
                    $statusUpper = strtoupper(trim($hist->status_pinjaman));
                    @endphp
                    <tr data-status="{{ $statusUpper }}">
                        <td class="action-cell-full text-center align-middle">
                            <button type="button" class="btn btn-review" data-id="{{ $hist->id }}" title="Lihat Detail Akad">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                            {{ \Carbon\Carbon::parse($hist->tanggal_pinjaman)->format('d M Y') }}
                        </td>
                        <td class="fw-bold opacity-75" style="font-family: 'JetBrains Mono', monospace;">
                            {{ $hist->nota_nomor }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="peserta-avatar">{{ $histInitial }}</div>
                                <div>
                                    <div class="fw-bold text-uppercase" style="font-size: 0.8rem;">{{ $hist->kop_master_peserta_name }}</div>
                                    <span class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem;">ID: {{ $hist->kop_master_peserta_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">
                            Rp {{ number_format($hist->jumlah_pinjaman, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">
                                {{ $hist->tenor_bulan }} Bln
                            </span>
                        </td>
                        <td class="text-center">
                            @if($statusUpper === 'APPROVED')
                            <span class="ent-badge badge-approved">APPROVED</span>
                            @elseif($statusUpper === 'REJECTED')
                            <span class="ent-badge badge-rejected">REJECTED</span>
                            @else
                            <span class="ent-badge badge-pending">{{ $hist->status_pinjaman }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Review Pengajuan -->
<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-file-contract me-1"></i> OTORISASI AKAD
                    </span>
                    <h5 class="modal-title fw-bold mb-0" id="modalReviewLabel" style="color: white;">Review Pengajuan Pinjaman</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background-color: rgba(79, 70, 229, 0.03);">
                <input type="hidden" id="review_trx_id">
                <input type="hidden" id="review_nota_nomor">

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="ent-sub-card h-100">
                            <div class="ent-sub-card-header">
                                <i class="fas fa-file-invoice-dollar text-primary me-1"></i> Detail Pengajuan Baru
                            </div>
                            <div class="p-3 small">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="42%" class="opacity-75">No. Akad</td>
                                        <td class="fw-bold text-primary" id="det_nota" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Tgl Pinjam</td>
                                        <td class="fw-bold" id="det_tgl" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Tujuan</td>
                                        <td class="fw-bold" id="det_tujuan"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Plafon</td>
                                        <td class="fw-bold" id="det_plafon" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Admin + Bunga</td>
                                        <td class="fw-bold" id="det_biaya" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Pencairan Netto</td>
                                        <td class="fw-bold text-success" id="det_netto" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Tenor &amp; Cicilan</td>
                                        <td class="fw-bold" id="det_cicilan" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ent-sub-card h-100">
                            <div class="ent-sub-card-header">
                                <i class="fas fa-id-badge text-primary me-1"></i> Profil Anggota
                            </div>
                            <div class="p-3 small">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="34%" class="opacity-75">Nama</td>
                                        <td class="fw-bold text-uppercase" id="prof_nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">Kode / ID</td>
                                        <td class="fw-bold" id="prof_kode" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">NIP</td>
                                        <td class="fw-bold" id="prof_nip" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                    <tr>
                                        <td class="opacity-75">No HP (WA)</td>
                                        <td class="fw-bold" id="prof_hp" style="font-family: 'JetBrains Mono', monospace;"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="ent-sub-card">
                            <div class="ent-sub-card-header d-flex align-items-center justify-content-between">
                                <span><i class="fas fa-history text-primary me-1"></i> Riwayat Pinjaman Sebelumnya</span>
                                <span class="text-muted fw-normal" style="font-size: 0.68rem; text-transform: none;">Klik baris untuk buka/tutup rincian tenor</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom align-middle mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No. Akad</th>
                                            <th class="text-end">Plafon</th>
                                            <th class="text-center">Tenor</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableRiwayatBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer px-4 py-3 d-flex justify-content-between" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn ent-btn btn-danger btn-sm fw-bold px-3" id="btnRejectProcess">
                        <i class="fas fa-times me-1"></i> Tolak Pengajuan
                    </button>
                    <button type="button" class="btn ent-btn btn-success btn-sm fw-bold px-3" id="btnApproveProcess">
                        <i class="fas fa-check me-1"></i> Setujui Pengajuan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        let approvalDt = null;
        let historyDt = null;

        if ($.fn.DataTable) {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (settings.nTable.id === 'tableApproval') {
                    const rowNode = settings.aoData[dataIndex].nTr;
                    const kw = ($('#filterApprovalKeyword').val() || '').toString().trim().toLowerCase();
                    if (!kw) return true;
                    const hay = ($(rowNode).attr('data-search') || '').toString().toLowerCase();
                    return hay.includes(kw);
                }

                if (settings.nTable.id === 'tableHistoryGlobal') {
                    const rowNode = settings.aoData[dataIndex].nTr;
                    const st = ($('#filterStatusHistory').val() || '').toString().trim().toUpperCase();
                    if (!st) return true;
                    const rowSt = ($(rowNode).attr('data-status') || '').toString().trim().toUpperCase();
                    return rowSt === st;
                }

                return true;
            });

            approvalDt = $('#tableApproval').DataTable({
                order: [[1, 'asc']],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Pencarian tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            historyDt = $('#tableHistoryGlobal').DataTable({
                order: [[1, 'desc']],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Pencarian tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        }

        $('#filterApprovalKeyword').on('input keyup', function() {
            if (approvalDt) approvalDt.draw();
        });

        $('#filterStatusHistory').on('change', function() {
            if (historyDt) historyDt.draw();
        });

        function formatRp(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Toggle buka/tutup detail tenor pada Riwayat Pinjaman Sebelumnya
        $(document).on('click', '.ent-riwayat-toggle', function() {
            const targetId = $(this).data('target');
            const detailRow = $('#' + targetId);
            const isOpen = $(this).hasClass('is-open');

            if (isOpen) {
                $(this).removeClass('is-open');
                detailRow.stop(true, true).slideUp(180);
            } else {
                $(this).addClass('is-open');
                detailRow.stop(true, true).slideDown(180);
            }
        });

        $('#modalReview').on('hidden.bs.modal', function() {
            $('.ent-riwayat-toggle').removeClass('is-open');
            $('.ent-riwayat-detail-row').hide();
        });

        // 1. Event Klik Tombol Review di Tabel
        $(document).on('click', '.btn-review', function() {
            let trxId = $(this).data('id');
            let btn = $(this);
            let originalIcon = btn.html();

            btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: "{{ url('koperasi/menu-peminjaman/approval-peminjaman-uang-anggota/detail') }}/" + trxId,
                type: "GET",
                success: function(response) {
                    btn.html(originalIcon).prop('disabled', false);

                    let p = response.data.pinjaman;
                    let h = response.data.history;
                    let tenors = response.data.tenors || [];

                    $('#review_trx_id').val(p.id);
                    $('#review_nota_nomor').val(p.nota_nomor);

                    $('#det_nota').text(p.nota_nomor);
                    $('#det_tgl').text(p.tanggal_pinjaman);
                    $('#det_tujuan').text(p.tujuan_pinjaman || '-');
                    $('#det_plafon').text(formatRp(p.jumlah_pinjaman));
                    $('#det_biaya').text(formatRp(parseFloat(p.biaya_admin) + parseFloat(p.bunga_koperasi)));
                    $('#det_netto').text(formatRp(p.pencairan_netto));
                    $('#det_cicilan').text(p.tenor_bulan + ' Bulan @ ' + formatRp(p.cicilan_per_bulan));

                    let statusTagihan = p.status_tagihan || 'PENDING';
                    let badgeTagihanClass = statusTagihan === 'LUNAS' ? 'badge-approved' : 'badge-pending';
                    $('#det_status_tagihan').html(`<span class="ent-badge ${badgeTagihanClass}">${statusTagihan}</span>`);

                    $('#prof_nama').text(p.kop_master_peserta_name);
                    $('#prof_kode').text(p.kop_master_peserta_code);
                    $('#prof_nip').text(p.kop_master_peserta_nip || '-');
                    $('#prof_hp').text(p.kop_master_peserta_no_hp || '-');

                    // Render Riwayat Pinjaman dengan baris tenor collapsible (default tertutup)
                    let historyHtml = '';
                    if (h.length > 0) {
                        $.each(h, function(i, val) {
                            let badgeClass = val.status_pinjaman === 'APPROVED' ? 'badge-approved' : (val.status_pinjaman === 'REJECTED' ? 'badge-rejected' : 'badge-pending');
                            let statusTagihanRiwayat = val.status_tagihan || 'PENDING';
                            let badgeTagihanRwy = statusTagihanRiwayat === 'LUNAS' ? 'badge-approved' : 'badge-pending';
                            let collapseId = 'riwayatDetail_' + (val.id || i) + '_' + i;

                            historyHtml += `
                                <tr class="fw-bold ent-riwayat-toggle" data-target="${collapseId}" title="Klik untuk buka/tutup rincian tenor">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="ent-chevron"><i class="fas fa-chevron-down"></i></span>
                                            <span>${val.tanggal_pinjaman}</span>
                                        </div>
                                    </td>
                                    <td style="font-family: 'JetBrains Mono', monospace;">${val.nota_nomor}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${formatRp(val.jumlah_pinjaman)}</td>
                                    <td class="text-center">${val.tenor_bulan} Bln</td>
                                    <td class="text-center"><span class="ent-badge ${badgeClass}">${val.status_pinjaman}</span></td>
                                    <td class="text-center"><span class="ent-badge ${badgeTagihanRwy}">${statusTagihanRiwayat}</span></td>
                                </tr>
                            `;

                            if (val.tenors && val.tenors.length > 0) {
                                historyHtml += `
                                    <tr id="${collapseId}" class="ent-riwayat-detail-row" style="display: none;">
                                        <td colspan="6" class="p-3 ent-riwayat-detail-cell">
                                            <div class="small fw-bold opacity-75 mb-2">Rincian Angsuran / Tenor (${val.nota_nomor}):</div>
                                            <div class="table-responsive">
                                                <table class="table table-custom mb-0 align-middle" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Angsuran</th>
                                                            <th class="text-center">Jatuh Tempo</th>
                                                            <th class="text-end">Pokok + Bunga (Total)</th>
                                                            <th class="text-center">Status Bayar</th>
                                                            <th class="text-center">Tanggal Bayar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                `;

                                $.each(val.tenors, function(idx, t) {
                                    let isLunasRwy = (t.status_bayar === 'LUNAS');
                                    let badgeTenorRwy = isLunasRwy ? 'badge-approved' : 'badge-pending';
                                    let totalTagihanRwy = parseFloat(t.jumlah_tagihan ?? 0);

                                    historyHtml += `
                                        <tr>
                                            <td class="text-center fw-bold">Bulan Ke-${t.angsuran_ke}</td>
                                            <td class="text-center">${t.jatuh_tempo ?? '-'}</td>
                                            <td class="text-end fw-bold">${formatRp(totalTagihanRwy)}</td>
                                            <td class="text-center"><span class="ent-badge ${badgeTenorRwy}">${t.status_bayar}</span></td>
                                            <td class="text-center">${t.tanggal_bayar ?? '-'}</td>
                                        </tr>
                                    `;
                                });

                                historyHtml += `
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            } else {
                                historyHtml += `
                                    <tr id="${collapseId}" class="ent-riwayat-detail-row" style="display: none;">
                                        <td colspan="6" class="opacity-75 fst-italic ps-4 ent-riwayat-detail-cell">Tidak ada rincian tenor untuk riwayat ini.</td>
                                    </tr>
                                `;
                            }
                        });
                    } else {
                        historyHtml = `<tr><td colspan="6" class="text-center opacity-75 fst-italic">Belum ada riwayat pinjaman sebelumnya.</td></tr>`;
                    }
                    $('#tableRiwayatBody').html(historyHtml);

                    // Render Detail Tenor Angsuran (jika tabel tenor tersedia di modal)
                    let tenorHtml = '';
                    if (tenors.length > 0) {
                        $.each(tenors, function(i, t) {
                            let isLunas = (t.status_bayar === 'LUNAS');
                            let badgeTenorClass = isLunas ? 'badge-approved' : 'badge-pending';
                            let totalTagihan = parseFloat(t.jumlah_tagihan ?? 0);
                            let bunga = parseFloat(t.bunga_tagihan ?? 0);
                            let pokok = totalTagihan - bunga;

                            tenorHtml += `
                                <tr>
                                    <td class="text-center fw-bold">Bulan Ke-${t.angsuran_ke}</td>
                                    <td>${t.jatuh_tempo ?? '-'}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${formatRp(pokok)}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${formatRp(bunga)}</td>
                                    <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRp(totalTagihan)}</td>
                                    <td class="text-center"><span class="ent-badge ${badgeTenorClass}">${t.status_bayar}</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        tenorHtml = `<tr><td colspan="6" class="text-center opacity-75 fst-italic">Belum ada rincian jadwal tenor.</td></tr>`;
                    }
                    $('#tableTenorBody').html(tenorHtml);

                    $('#modalReview').modal('show');
                },
                error: function() {
                    btn.html(originalIcon).prop('disabled', false);
                    Swal.fire('Error', 'Gagal mengambil detail data.', 'error');
                }
            });
        });

        // 2. Proses Setujui
        $('#btnApproveProcess').on('click', function() {
            let trxId = $('#review_trx_id').val();
            let nota = $('#review_nota_nomor').val();

            Swal.fire({
                title: 'Setujui Pinjaman?',
                text: "Anda akan menyetujui pengajuan akad " + nota,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalReview').modal('hide');
                    $.ajax({
                        url: "{{ route('menu_koperasi_approval_peminjaman_uang_anggota_approve') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: trxId
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Disetujui!',
                                    text: res.message,
                                    showCancelButton: res.wa_url ? true : false,
                                    confirmButtonText: 'Tutup',
                                    cancelButtonText: '<i class="fab fa-whatsapp me-1"></i> Kabari WA',
                                    cancelButtonColor: '#25D366'
                                }).then((r) => {
                                    if (r.dismiss === Swal.DismissReason.cancel && res.wa_url) {
                                        window.open(res.wa_url, '_blank');
                                    }
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });

        // 3. Proses Tolak
        $('#btnRejectProcess').on('click', function() {
            let trxId = $('#review_trx_id').val();
            let nota = $('#review_nota_nomor').val();

            Swal.fire({
                title: 'Tolak Pinjaman?',
                text: "Anda yakin ingin menolak pengajuan akad " + nota + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalReview').modal('hide');
                    $.ajax({
                        url: "{{ route('menu_koperasi_approval_peminjaman_uang_anggota_reject') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: trxId
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Ditolak!', res.message, 'success').then(() => location.reload());
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
