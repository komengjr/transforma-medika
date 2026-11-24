@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
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

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        pointer-events: none;
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
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling */
    .form-floating-custom .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 44px !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
        padding-left: 8px !important;
        padding-right: 28px !important;
        border-radius: 10px !important;
        background-color: var(--ent-surface) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .form-floating-custom .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .form-floating-custom .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-surface) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        padding-left: 3px !important;
        line-height: 1.4 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.22) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1080 !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-surface) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__options {
        background-color: var(--ent-surface) !important;
        max-height: 240px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        font-size: 0.8rem !important;
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

    /* Avatar Pasien */
    .patient-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(2, 132, 199, 0.18));
        border: 1px solid rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.75rem;
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

    .badge-wa {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .badge-email {
        background-color: rgba(244, 63, 94, 0.15) !important;
        color: #f43f5e !important;
        border: 1px solid rgba(244, 63, 94, 0.35);
    }

    .badge-ss {
        background-color: rgba(14, 165, 233, 0.15) !important;
        color: #0ea5e9 !important;
        border: 1px solid rgba(14, 165, 233, 0.35);
    }

    .badge-print {
        background-color: rgba(100, 116, 139, 0.15) !important;
        color: var(--bs-secondary-color, #94a3b8) !important;
        border: 1px solid rgba(100, 116, 139, 0.35);
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
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
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
    #example_wrapper>.row:first-child,
    #example_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #example_wrapper>.row:last-child,
    #example_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #example_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #example_wrapper .dataTables_filter input,
    #example_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #example_wrapper .dataTables_filter input:focus,
    #example_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dt-length select {
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
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Enterprise -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/poliklikink.png') }}" alt="Poli Logo" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-hospital-user me-1"></i> {{ env('APP_LABEL', 'HIS') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Poliklinik Rawat Jalan</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Pendaftaran Poliklinik</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola dan proses pendaftaran pasien poliklinik secara real-time.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <button class="btn ent-btn ent-btn-primary px-3.5 py-2" onclick="loadTableData();" data-bs-toggle="tooltip" title="Refresh Data">
                            <span class="fas fa-sync-alt me-1"></span> Refresh Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card with Integrated Filter Bar -->
<div class="ent-card mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <form id="form-filter" onsubmit="event.preventDefault(); loadTableData();">
            <div class="row g-2 align-items-center">
                <!-- Tombol Refresh -->
                <div class="col-auto">
                    <button type="button" onclick="loadTableData()" class="btn ent-btn ent-btn-primary px-3 fw-semibold d-flex align-items-center gap-2" style="height: 44px;">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>

                <!-- Tanggal Awal -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Tanggal Awal</label>
                        <input class="form-control ent-input" type="date" id="start_date" name="start_date" value="{{ $startDate }}" />
                    </div>
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Tanggal Akhir</label>
                        <input class="form-control ent-input" type="date" id="end_date" name="end_date" value="{{ $endDate }}" />
                    </div>
                </div>

                <!-- No Reg / Nama -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>No Reg / Nama</label>
                        <input class="form-control ent-input" type="text" id="keyword" name="keyword" placeholder="Cari Reg / Nama..." />
                    </div>
                </div>

                <!-- Poli -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Poliklinik</label>
                        <select class="form-select ent-input select2-filter-poli" id="poli_id" name="poli_id" data-placeholder="Semua Poli">
                            <option value="">Semua Poli</option>
                            @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Dokter -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Dokter</label>
                        <select class="form-select ent-input select2-filter-poli" id="dokter" name="dokter" data-placeholder="Semua Dokter">
                            <option value="">Semua Dokter</option>
                            @foreach ($doctors as $doc)
                            <option value="{{ $doc->master_doctor_name }}">{{ $doc->master_doctor_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kel. Pelanggan (Sub Penjamin) -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Kel. Pelanggan</label>
                        <select class="form-select ent-input select2-filter-poli" id="sub_penjamin_id" name="sub_penjamin_id" data-placeholder="Semua Kelompok">
                            <option value="">Semua Kelompok</option>
                            @foreach ($subPenjamins as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tombol Submit Filter -->
                <div class="col-auto">
                    <button type="submit" class="btn ent-btn ent-btn-warning px-3 d-flex align-items-center justify-content-center" style="height: 44px;" title="Terapkan Filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">NO</th>
                        <th style="width: 17%;">NO. REGISTRASI & PETUGAS</th>
                        <th style="width: 16%;">NAMA PASIEN</th>
                        <th style="width: 11%;">PENJAMIN</th>
                        <th style="width: 14%;">DOKTER</th>
                        <th style="width: 10%;">JANJI HASIL</th>
                        <th style="width: 12%;">POLIKLINIK / LAYANAN</th>
                        <th style="width: 11%;">PENGIRIMAN</th>
                        <th class="text-end" style="width: 10%;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data dimuat dinamis via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Poliklinik -->
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <!-- <button class="btn-close shadow-sm rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let dataTableInstance;

    function initSelect2Poli(selector) {
        if (!(window.jQuery && $.fn.select2)) return;
        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: placeholderText,
                allowClear: true,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });
    }

    $(document).ready(function() {
        initSelect2Poli('.select2-filter-poli');

        dataTableInstance = $('#example').DataTable({
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
            columns: [{
                    data: null,
                    className: 'action-cell-full text-center align-middle',
                    render: function(data, type, row, meta) {
                        let btnHandling = '';
                        if (row.status_kunjungan === 'MENUNGGU') {
                            btnHandling = `<li><a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-poliklinik" id="button-proses-handling" data-code="${row.no_registrasi}"><i class="fas fa-stethoscope me-2 text-primary"></i> Proses Handling</a></li><li><hr class="dropdown-divider"></li>`;
                        }
                        return `<div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu ent-dropdown-menu py-2">
                            ${btnHandling}
                            <li><a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-cabang" data-code="${row.id}"><i class="fas fa-history me-2 text-info"></i> Riwayat Pasien</a></li>
                        </ul>
                    </div>`;
                    }
                },
                {
                    data: null,
                    className: 'text-center fw-semibold',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let poliBadge = row.poli_nama ? ` - ${row.poli_nama}` : '';
                        return `<div class="fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">${row.no_registrasi}</div>
                            <span class="ent-badge mt-1" style="background: rgba(225, 29, 72, 0.14); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.3); font-size: 0.65rem;">${row.pasien_pid ?? ''}</span>
                            <div class="mt-1"><span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3); font-size: 0.63rem;"><i class="fas fa-hospital me-1"></i> ${row.jenis_layanan}${poliBadge}</span></div>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let initial = row.pasien_nama ? row.pasien_nama.substring(0, 3).toUpperCase() : 'N/A';
                        let tglReg = row.tanggal_registrasi ? new Date(row.tanggal_registrasi).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace(/\./g, '-') : '-';
                        return `<div class="d-flex align-items-center gap-2">
                        <div class="patient-avatar">${initial}</div>
                        <div>
                            <div class="fw-bold text-uppercase" style="font-size: 0.84rem;">${row.pasien_nama}</div>
                            <span class="ent-badge" style="background: rgba(100, 116, 139, 0.15); color: var(--bs-secondary-color, #94a3b8); border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.6rem; padding: 2px 7px;">${row.petugas_nama ?? 'system'}</span>
                            <div class="opacity-75 fw-medium mt-0.5" style="font-size: 0.72rem;">${tglReg}</div>
                        </div>
                    </div>`;
                    }
                },
                {
                    data: 'agreement',
                    render: function(data) {
                        return `<span class="fw-bold" style="color: #6366f1; font-size: 0.83rem;">${data ?? '-'}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let htmlDokter = '';
                        if (row.dokter_poli_nama) {
                            htmlDokter += `<div class="fw-semibold" style="font-size: 0.8rem;"><i class="fas fa-user-md text-primary me-1"></i> ${row.dokter_poli_nama}</div>`;
                        }
                        if (row.dokter_pengirim_nama) {
                            htmlDokter += `<div class="opacity-75 small mt-0.5">Pengirim: ${row.dokter_pengirim_nama}</div>`;
                        }
                        if (!row.dokter_poli_nama && !row.dokter_pengirim_nama) {
                            htmlDokter += '-';
                        }
                        return htmlDokter;
                    }
                },
                {
                    data: 'janji_hasil',
                    render: function(data) {
                        let formatTgl = data ? new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace(/\./g, '-') : '-';
                        return `<span class="fw-semibold" style="font-size: 0.8rem;">${formatTgl}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-semibold" style="font-size: 0.8rem;">${row.poli_nama ?? row.jenis_layanan}</span>`;
                    }
                },
                {
                    data: 'metode_pengiriman',
                    render: function(data) {
                        let html = '<div class="d-flex flex-column gap-1">';
                        try {
                            let methods = JSON.parse(data) || [];
                            methods.forEach(m => {
                                let mLower = m.toLowerCase();
                                if (mLower === 'whatsapp') html += '<span class="ent-badge badge-wa text-start py-1 px-2" style="font-size: 0.64rem;"><i class="fab fa-whatsapp me-1"></i> WHATSAPP</span>';
                                else if (mLower === 'email') html += '<span class="ent-badge badge-email text-start py-1 px-2" style="font-size: 0.64rem;"><i class="fas fa-envelope me-1"></i> EMAIL</span>';
                                else if (mLower === 'satusehat') html += '<span class="ent-badge badge-ss text-start py-1 px-2" style="font-size: 0.64rem;"><i class="fas fa-heartbeat me-1"></i> SATU SEHAT</span>';
                                else if (mLower === 'cetak_fisik') html += '<span class="ent-badge badge-print text-start py-1 px-2" style="font-size: 0.64rem;"><i class="fas fa-print me-1"></i> CETAK FISIK</span>';
                            });
                        } catch (e) {}
                        html += '</div>';
                        return html;
                    }
                },
                {
                    data: null,
                    className: 'text-end',
                    render: function(data, type, row) {
                        let total = Number(row.total_tagihan || 0).toLocaleString('id-ID');
                        let badgeStatus = row.status_pembayaran === 'LUNAS' ?
                            '<span class="ent-badge px-2 py-1" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.64rem;"><i class="fas fa-check-circle me-1"></i> LUNAS</span>' :
                            '<span class="ent-badge px-2 py-1" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.35); font-size: 0.64rem;"><i class="fas fa-clock me-1"></i> BELUM LUNAS</span>';
                        return `<div class="fw-bold" style="font-size: 0.9rem;">${total}</div><div class="mt-1">${badgeStatus}</div>`;
                    }
                }
            ]
        });

        loadTableData();
    });

    function loadTableData() {
        let formData = $('#form-filter').serialize();

        $.ajax({
            url: "{{ route('poliklinik.data.json') }}",
            type: "GET",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    dataTableInstance.clear().rows.add(response.data).draw();
                }
            },
            error: function(xhr) {
                console.error("Gagal memuat data tabel.");
            }
        });
    }

    $(document).on("click", "#button-proses-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-poliklinik').html(
            '<div class="py-5 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 fw-semibold small">Memuat Data Pasien...</p></div>'
        );
        $.ajax({
            url: "{{ route('data_registrasi_poli_handling') ?? '#' }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-poliklinik').html(data);
        }).fail(function() {
            $('#menu-poliklinik').html('<div class="alert alert-danger m-3 rounded-3">Gagal memuat data. Silakan coba lagi.</div>');
        });
    });
</script>
@endsection
