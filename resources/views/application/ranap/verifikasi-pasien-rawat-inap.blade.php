@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
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
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
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

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(244, 63, 94, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Badges */
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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
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
        background-color: rgba(245, 158, 11, 0.16);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-btn-reset {
        background-color: rgba(100, 116, 139, 0.12);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-reset:hover {
        background-color: rgba(100, 116, 139, 0.22);
        color: var(--bs-body-color);
    }

    /* Form Controls */
    .ent-field-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
        display: block;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 11px !important;
        padding-right: 30px !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5 .form-select-sm.select2-selection,
    .select2-container--bootstrap-5 .select2-selection--single.select2-selection-sm {
        min-height: 33px !important;
        border-radius: 8px !important;
        padding-left: 9px !important;
        padding-right: 26px !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.4 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.26) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1095 !important;
        font-size: 0.82rem;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-solid-bg) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__options {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        max-height: 240px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 7px 12px !important;
        line-height: 1.35 !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Nav Tabs inside Modal */
    .ent-nav-tabs {
        background-color: rgba(79, 70, 229, 0.06);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 5px;
        gap: 6px;
        display: flex;
        flex-wrap: wrap;
    }

    .ent-nav-tabs .nav-link {
        border: none !important;
        border-radius: 9px !important;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--bs-body-color);
        padding: 9px 14px;
        transition: all 0.18s ease;
        background: transparent;
    }

    .ent-nav-tabs .nav-link:hover {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--ent-indigo);
    }

    .ent-nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.82rem;
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
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom td .btn,
    .table-custom td .btn-sm {
        opacity: 1 !important;
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
        min-height: 56px;
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

    /* DataTables Top & Bottom Controls Padding */
    #table-verifikasi-ranap_wrapper>.row:first-child,
    #table-verifikasi-ranap_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #table-verifikasi-ranap_wrapper>.row:last-child,
    #table-verifikasi-ranap_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-verifikasi-ranap_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #table-verifikasi-ranap_wrapper .dataTables_filter input,
    #table-verifikasi-ranap_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-verifikasi-ranap_wrapper .dataTables_filter input:focus,
    #table-verifikasi-ranap_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #table-verifikasi-ranap_wrapper .dataTables_length select,
    #table-verifikasi-ranap_wrapper .dt-length select {
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

    /* Dropdown & Modal Adaptive */
    .ent-dropdown-menu {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25) !important;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff;
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
    }

    .ent-info-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-clipboard-check text-info fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-procedures me-1"></i> Monitoring Rawat Inap
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Verifikasi Klinis &amp; Pemulangan</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">Verifikasi &amp; Monitoring Pasien Rawat Inap</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-calendar-check text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">{{ date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="ent-card mb-3 p-3 p-md-4">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-3 align-items-end">
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Dari Tanggal</label>
                <input class="form-control form-control-sm ent-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Sampai Tanggal</label>
                <input class="form-control form-control-sm ent-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-4">
                <label class="ent-field-label"><i class="fas fa-search text-primary me-1"></i> Kata Kunci Pencarian</label>
                <input class="form-control form-control-sm ent-input" type="text" id="keyword" name="keyword" placeholder="Cari No. Reg, Nama Pasien, atau No. RM..." />
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-warning btn-sm w-50 fw-semibold" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" onclick="reloadTable()" class="btn ent-btn ent-btn-primary btn-sm w-50 fw-semibold" style="height: 38px;" title="Refresh Tabel">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE MONITORING -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-list-alt text-primary"></i> Daftar Pasien Rawat Inap Aktif
        </h6>
        <span class="ent-badge" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">
            Total Aktif: {{ $totalAktif }} Pasien
        </span>
    </div>
    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="table-verifikasi-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th>No. Reg &amp; Tgl Masuk</th>
                        <th>Pasien &amp; RM</th>
                        <th>Ruangan &amp; Bed</th>
                        <th>Dokter DPJP</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail & Verifikasi Handling Rawat Inap (Tampilan Tabel Murni Verifikator) -->
<div class="modal fade" id="modalDetailHandling" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4">
                <h6 class="modal-title fw-bold text-white mb-0">
                    <i class="fas fa-clipboard-check me-2 text-info"></i> Verifikasi Data Handling Pasien: <span id="detail_nama_pasien" class="text-warning"></span>
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <!-- Tab Navigasi Verifikasi -->
                <ul class="nav ent-nav-tabs mb-4" id="verifRanapTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#verif-soap-pane" type="button">
                            <i class="fas fa-id-card me-1"></i> 1. SOAP &amp; Perkembangan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#verif-tindakan-pane" type="button">
                            <i class="fas fa-stethoscope me-1"></i> 2. Tindakan &amp; Visite
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#verif-resep-pane" type="button">
                            <i class="fas fa-pills me-1"></i> 3. Order Resep Obat
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- PANE 1: SOAP -->
                    <div class="tab-pane fade show active" id="verif-soap-pane" role="tabpanel">
                        <div class="ent-info-box mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <span class="ent-field-label">Subjektif</span>
                                    <p id="txt_subjektif" class="mb-0 fw-semibold">-</p>
                                </div>
                                <div class="col-md-6">
                                    <span class="ent-field-label">Objektif</span>
                                    <p id="txt_objektif" class="mb-0 fw-semibold">-</p>
                                </div>
                                <div class="col-md-6">
                                    <span class="ent-field-label">Asesmen</span>
                                    <p id="txt_asesmen" class="mb-0 fw-semibold">-</p>
                                </div>
                                <div class="col-md-6">
                                    <span class="ent-field-label">Planning</span>
                                    <p id="txt_planning" class="mb-0 fw-semibold">-</p>
                                </div>
                            </div>
                            <hr style="border-color: var(--ent-grid-border);">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" style="font-size: 0.8rem;">
                                <div>
                                    <strong>Penginput:</strong> <span id="soap_input_by" class="text-primary fw-semibold">-</span>
                                    <span class="mx-2 opacity-50">|</span>
                                    <strong>Verifikator:</strong> <span id="soap_verifikator" class="text-success fw-semibold">-</span>
                                </div>
                                <div>
                                    <strong>Status:</strong> <span id="soap_status" class="badge bg-warning text-dark">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn ent-btn ent-btn-success btn-sm px-3" onclick="prosesVerifikasi('soap', 'Verified')"><i class="fas fa-check me-1"></i> Setujui SOAP</button>
                            <button class="btn ent-btn btn-danger btn-sm px-3" onclick="prosesVerifikasi('soap', 'Rejected')"><i class="fas fa-times me-1"></i> Tolak</button>
                        </div>
                    </div>

                    <!-- PANE 2: TINDAKAN -->
                    <div class="tab-pane fade" id="verif-tindakan-pane" role="tabpanel">
                        <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                            <table class="table table-custom table-sm align-middle text-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start">Nama Layanan</th>
                                        <th>Jml</th>
                                        <th class="text-end">Tarif</th>
                                        <th>Penginput</th>
                                        <th>Verifikator</th>
                                        <th style="width: 170px;">Status / Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-detail-tindakan" class="ent-table-surface">
                                    <tr>
                                        <td colspan="6" class="text-center py-3">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button class="btn ent-btn ent-btn-primary btn-sm px-3" onclick="simpanVerifikasiGranular('tindakan')">
                                <i class="fas fa-save me-1"></i> Simpan Status Tindakan
                            </button>
                        </div>
                    </div>

                    <!-- PANE 3: RESEP OBAT -->
                    <div class="tab-pane fade" id="verif-resep-pane" role="tabpanel">
                        <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                            <table class="table table-custom table-sm align-middle text-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start">Nama Obat</th>
                                        <th>Qty</th>
                                        <th>Signa (Aturan Pakai)</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th>Penginput</th>
                                        <th>Verifikator</th>
                                        <th style="width: 170px;">Status / Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-detail-resep" class="ent-table-surface">
                                    <tr>
                                        <td colspan="7" class="text-center py-3">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button class="btn ent-btn ent-btn-primary btn-sm px-3" onclick="simpanVerifikasiGranular('resep')">
                                <i class="fas fa-save me-1"></i> Simpan Status Resep
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn ent-btn-reset btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VERIFIKASI & IZIN PULANG -->
<div class="modal fade" id="modalVerifikasiPulang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <form id="form-verifikasi-pulang">
                @csrf
                <input type="hidden" name="registrasi_id" id="val_registrasi_id">
                <input type="hidden" name="bed_id" id="val_bed_id">

                <div class="modal-header ent-modal-header py-3 px-4">
                    <h6 class="modal-title fw-bold text-white mb-0">
                        <i class="fas fa-clipboard-check me-2 text-warning"></i> Verifikasi &amp; Pemulangan Pasien
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="ent-info-box mb-3">
                        <span class="ent-field-label d-block mb-1">Pasien yang akan diproses</span>
                        <strong class="fs-6" id="label_nama_pasien"></strong><br>
                        <small class="text-success fw-bold d-inline-block mt-1">
                            <i class="fas fa-bed me-1"></i> Tempat Tidur yang akan dibuka: <span id="label_nomor_bed"></span>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="ent-field-label">Status / Kondisi Pulang</label>
                        <select class="form-select ent-input select2-ranap-pulang" id="select-status-pulang" name="status_pulang" data-placeholder="-- Pilih Kondisi Pulang --" required>
                            <option value="">-- Pilih Kondisi Pulang --</option>
                            <option value="SEBUH">Sembuh / Membaik</option>
                            <option value="RUJUK">Dirujuk ke Rumah Sakit Lain</option>
                            <option value="PULANG_PAKSA">Pulang Atas Permintaan Sendiri (Paksa)</option>
                            <option value="MENINGGAL">Meninggal Dunia</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="ent-field-label">Catatan Kepulangan / Instruksi Dokter</label>
                        <textarea class="form-control ent-input" name="catatan_pulang" rows="3" placeholder="Instruksi obat pulang, kontrol ulang, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn ent-btn-reset btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn ent-btn ent-btn-success btn-sm px-4" id="btn-submit-pulang">Izin Pulang &amp; Buka Bed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableVerifikasiRanap;
    let currentRegistrasiId = null;
    let activeDetailHandlingAjax = null;

    function initSelect2Ranap(selector, modalSelector) {
        if (!(window.jQuery && $.fn.select2)) return;
        const $parent = modalSelector && $(modalSelector).length ? $(modalSelector) : $(document.body);

        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;
            const isSmall = $el.hasClass('form-select-sm');

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $parent,
                placeholder: placeholderText,
                allowClear: hasEmptyOption,
                minimumResultsForSearch: isSmall ? Infinity : 0,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            if (isSmall) {
                $el.next('.select2-container').find('.select2-selection').addClass('select2-selection-sm');
            }
        });
    }

    $(document).ready(function() {
        initSelect2Ranap('.select2-ranap-pulang', '#modalVerifikasiPulang');

        tableVerifikasiRanap = $('#table-verifikasi-ranap').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
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
            },
            ajax: {
                url: "{{ route('ranap.verifikasi.datatable') }}",
                type: "GET",
                dataSrc: 'data',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: null,
                    className: 'action-cell-full text-center align-middle',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const safeNama = String(row.nama_pasien ?? '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                        const safeBed = String(row.nomor_bed ?? '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                        return `<div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu ent-dropdown-menu py-2">
                                <li>
                                    <a class="dropdown-item fw-semibold py-2" href="#" onclick="event.preventDefault(); lihatDetailHandling('${row.registrasi_id}', '${safeNama}')">
                                        <i class="fas fa-eye me-2 text-primary"></i> Verifikasi Detail
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item fw-semibold py-2" href="#" onclick="event.preventDefault(); bukaModalVerifikasi('${row.registrasi_id}', '${safeNama}', '${row.bed_id}', '${safeBed}')">
                                        <i class="fas fa-check-circle me-2 text-warning"></i> Verifikasi &amp; Pulang
                                    </a>
                                </li>
                            </ul>
                        </div>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center fw-semibold'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let tglMasuk = row.tgl_masuk ? new Date(row.tgl_masuk).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '-';
                        return `<span class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${row.no_registrasi ?? '-'}</span><br>
                                <small class="opacity-75"><i class="far fa-clock me-1"></i>${tglMasuk}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold">${row.nama_pasien ?? '-'}</span><br>
                                <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">RM: ${row.pid ?? '-'}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold">${row.nama_ruangan ?? '-'} (${row.kelas ?? '-'})</span><br>
                                <small class="text-success fw-semibold"><i class="fas fa-bed me-1"></i>Bed: ${row.nomor_bed ?? '-'}</small>`;
                    }
                },
                {
                    data: 'nama_dokter',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'total_tagihan',
                    render: function(data) {
                        let total = data ? parseFloat(data) : 0;
                        return `Rp ${total.toLocaleString('id-ID')}`;
                    },
                    className: 'text-end fw-bold text-danger',
                    orderable: false
                },
                {
                    data: 'status_pembayaran',
                    render: function(data) {
                        let status = data ? data : 'BELUM LUNAS';
                        let badgeStyle = (status === 'LUNAS') ?
                            'background: rgba(16, 185, 129, 0.14); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);' :
                            'background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);';
                        return `<span class="ent-badge" style="${badgeStyle}">${status}</span>`;
                    },
                    className: 'text-center',
                    orderable: false
                }
            ]
        });

        const modalDetailEl = document.getElementById('modalDetailHandling');
        if (modalDetailEl) {
            modalDetailEl.addEventListener('hidden.bs.modal', function() {
                if (activeDetailHandlingAjax && activeDetailHandlingAjax.readyState !== 4) {
                    activeDetailHandlingAjax.abort();
                    activeDetailHandlingAjax = null;
                }
                $('#modalDetailHandling select.select2-hidden-accessible').select2('destroy');
            });
        }
    });

    function reloadTable() {
        if (tableVerifikasiRanap) {
            tableVerifikasiRanap.ajax.reload(null, false);
        }
    }

    function lihatDetailHandling(registrasiId, namaPasien) {
        currentRegistrasiId = registrasiId;
        $('#detail_nama_pasien').text(namaPasien);
        $('#txt_subjektif').text('Memuat...');
        $('#txt_objektif').text('Memuat...');
        $('#txt_asesmen').text('Memuat...');
        $('#txt_planning').text('Memuat...');
        $('#soap_input_by').text('-');
        $('#soap_verifikator').text('-');
        $('#soap_status').text('-').attr('class', 'badge bg-warning text-dark');
        $('#tbody-detail-tindakan').html('<tr><td colspan="6" class="text-center py-3">Memuat data...</td></tr>');
        $('#tbody-detail-resep').html('<tr><td colspan="7" class="text-center py-3">Memuat data...</td></tr>');

        if (activeDetailHandlingAjax && activeDetailHandlingAjax.readyState !== 4) {
            activeDetailHandlingAjax.abort();
        }

        const modalDetailEl = document.getElementById('modalDetailHandling');
        if (modalDetailEl && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modalDetailEl).show();
        }

        activeDetailHandlingAjax = $.ajax({
            url: "{{ route('ranap.detail.handling') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    // 1. Render SOAP
                    let soap = res.soap;
                    $('#txt_subjektif').text(soap && soap.subjektif ? soap.subjektif : '-');
                    $('#txt_objektif').text(soap && soap.objektif ? soap.objektif : '-');
                    $('#txt_asesmen').text(soap && soap.asesmen ? soap.asesmen : '-');
                    $('#txt_planning').text(soap && soap.planning ? soap.planning : '-');
                    $('#soap_input_by').text(soap && soap.input_by ? soap.input_by : '-');
                    $('#soap_verifikator').text(soap && soap.dokter_verifikasi_kode ? soap.dokter_verifikasi_kode : 'Belum Diverifikasi');

                    let soapStatus = soap && soap.status_verifikasi ? soap.status_verifikasi : 'Pending';
                    $('#soap_status').text(soapStatus).attr('class', 'badge ' + (soapStatus === 'Verified' ? 'bg-success' : soapStatus === 'Rejected' ? 'bg-danger' : 'bg-warning text-dark'));

                    // 2. Render Tindakan (Dengan Select Opsi)
                    let tindakanRows = '';
                    if (res.tindakanList && res.tindakanList.length > 0) {
                        res.tindakanList.forEach(function(item) {
                            let isPending = item.status_verifikasi === 'Pending';
                            let selectHtml = '';

                            if (isPending) {
                                selectHtml = `
                                    <select class="form-select form-select-sm fw-bold sel-tindakan-verif" data-id="${item.id}">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Verified">Verified (ACC)</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                `;
                            } else {
                                let badgeColor = item.status_verifikasi === 'Verified' ? 'bg-success' : 'bg-danger';
                                selectHtml = `<span class="badge ${badgeColor}">${item.status_verifikasi}</span>`;
                            }

                            tindakanRows += `
                                <tr>
                                    <td class="fw-semibold text-start">${item.nama_layanan}</td>
                                    <td>${item.jumlah}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(item.tarif).toLocaleString('id-ID')}</td>
                                    <td>${item.input_by || '-'}</td>
                                    <td>${item.dokter_verifikasi_kode || '-'}</td>
                                    <td>${selectHtml}</td>
                                </tr>`;
                        });
                    } else {
                        tindakanRows = '<tr><td colspan="6" class="text-center opacity-75 py-3">Belum ada tindakan tercatat.</td></tr>';
                    }
                    $('#tbody-detail-tindakan').html(tindakanRows);

                    // 3. Render Resep Obat (Dengan Select Opsi)
                    let resepRows = '';
                    if (res.resepList && res.resepList.length > 0) {
                        res.resepList.forEach(function(item) {
                            let isPending = item.status_verifikasi === 'Pending';
                            let selectHtml = '';

                            if (isPending) {
                                selectHtml = `
                                    <select class="form-select form-select-sm fw-bold sel-resep-verif" data-id="${item.id}">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Verified">Verified (ACC)</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                `;
                            } else {
                                let badgeColor = item.status_verifikasi === 'Verified' ? 'bg-success' : 'bg-danger';
                                selectHtml = `<span class="badge ${badgeColor}">${item.status_verifikasi}</span>`;
                            }

                            resepRows += `
                                <tr>
                                    <td class="fw-semibold text-start">${item.farm_data_obat_name}</td>
                                    <td>${item.qty}</td>
                                    <td>${item.signa || '-'}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(item.harga).toLocaleString('id-ID')}</td>
                                    <td>${item.input_by || '-'}</td>
                                    <td>${item.dokter_verifikasi_kode || '-'}</td>
                                    <td>${selectHtml}</td>
                                </tr>`;
                        });
                    } else {
                        resepRows = '<tr><td colspan="7" class="text-center opacity-75 py-3">Belum ada order resep obat tercatat.</td></tr>';
                    }
                    $('#tbody-detail-resep').html(resepRows);

                    initSelect2Ranap('.sel-tindakan-verif, .sel-resep-verif', '#modalDetailHandling');
                }
            },
            error: function(xhr, status) {
                if (status === 'abort') return;
                Swal.fire('Error', 'Gagal memuat rincian verifikasi pasien.', 'error');
            },
            complete: function() {
                activeDetailHandlingAjax = null;
            }
        });
    }

    // Fungsi Untuk Mengirim Data (Status per Item) ke Controller
    function simpanVerifikasiGranular(kategori) {
        if (!currentRegistrasiId) return;

        let payloadTindakan = [];
        let payloadResep = [];
        let kodeDokter = "DR-AKTIF";

        if (kategori === 'tindakan') {
            $('.sel-tindakan-verif').each(function() {
                let id = $(this).data('id');
                let status = $(this).val();
                if (status !== 'Pending') {
                    payloadTindakan.push({
                        id: id,
                        status: status
                    });
                }
            });

            if (payloadTindakan.length === 0) {
                return Swal.fire('Info', 'Tidak ada tindakan baru yang diverifikasi/ditolak.', 'info');
            }
        }

        if (kategori === 'resep') {
            $('.sel-resep-verif').each(function() {
                let id = $(this).data('id');
                let status = $(this).val();
                if (status !== 'Pending') {
                    payloadResep.push({
                        id: id,
                        status: status
                    });
                }
            });

            if (payloadResep.length === 0) {
                return Swal.fire('Info', 'Tidak ada resep baru yang diverifikasi/ditolak.', 'info');
            }
        }

        Swal.fire({
            title: `Simpan Verifikasi ${kategori.toUpperCase()}?`,
            text: "Data yang telah di-ACC akan langsung diteruskan ke bagian Kasir/Farmasi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('ranap.proses.verifikasi.handling') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        registrasi_id: currentRegistrasiId,
                        dokter_kode: kodeDokter,
                        tindakan: payloadTindakan,
                        resep: payloadResep
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Disimpan',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            lihatDetailHandling(currentRegistrasiId, $('#detail_nama_pasien').text());
                            reloadTable();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memproses ke server.', 'error');
                    }
                });
            }
        });
    }

    // Fungsi khusus untuk menyetujui keseluruhan form SOAP
    function prosesVerifikasi(jenis, status) {
        if (!currentRegistrasiId || jenis !== 'soap') return;

        Swal.fire({
            title: 'Verifikasi SOAP',
            text: `Anda akan menetapkan status SOAP menjadi ${status}. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('ranap.verify.order') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        registrasi_id: currentRegistrasiId,
                        jenis: jenis,
                        status: status
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Sukses', 'Status SOAP diperbarui.', 'success');
                            lihatDetailHandling(currentRegistrasiId, $('#detail_nama_pasien').text());
                        }
                    }
                });
            }
        });
    }

    function bukaModalVerifikasi(registrasiId, namaPasien, bedId, nomorBed) {
        $('#val_registrasi_id').val(registrasiId);
        $('#val_bed_id').val(bedId);
        $('#label_nama_pasien').text(namaPasien);
        $('#label_nomor_bed').text(nomorBed);
        $('#select-status-pulang').val('').trigger('change');
        const modalPulangEl = document.getElementById('modalVerifikasiPulang');
        if (modalPulangEl && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modalPulangEl).show();
        }
        initSelect2Ranap('#select-status-pulang', '#modalVerifikasiPulang');
    }

    $('#btn-submit-pulang').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.prop('disabled')) return;

        Swal.fire({
            title: 'Konfirmasi Izin Pulang?',
            text: "Pasien akan dinyatakan pulang dan status bed akan otomatis dibuka kembali menjadi tersedia!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#e11d48',
            confirmButtonText: 'Ya, Proses Pulang!'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).text('Memproses...');

                $.ajax({
                    url: "{{ route('ranap.proses.pulang') }}",
                    type: "POST",
                    data: $('#form-verifikasi-pulang').serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).text('Izin Pulang & Buka Bed');
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                reloadTable();
                                const modalPulangEl = document.getElementById('modalVerifikasiPulang');
                                if (modalPulangEl && window.bootstrap) {
                                    const inst = bootstrap.Modal.getInstance(modalPulangEl);
                                    if (inst) inst.hide();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).text('Izin Pulang & Buka Bed');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
