@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
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

    .ent-card>.card-header,
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

    /* Badges & Chips */
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

    .verif-item-chip {
        background-color: rgba(79, 70, 229, 0.06);
        color: var(--bs-body-color);
        border: 1px solid var(--ent-grid-border);
        border-radius: 7px;
        padding: 3px 8px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Buttons */
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

    .ent-input {
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
    .form-control:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
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

    /* DataTables Top & Bottom Controls Padding & Alignment */
    #example_wrapper>.row:first-child,
    #example_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    #example_wrapper>.row:last-child,
    #example_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    #example_wrapper .dt-layout-cell.dt-layout-start,
    #example_wrapper .dt-layout-start,
    #example_wrapper .dataTables_info,
    #example_wrapper .dt-info {
        margin-right: auto !important;
        text-align: left !important;
        display: flex;
        align-items: center;
    }

    #example_wrapper .dt-layout-cell.dt-layout-end,
    #example_wrapper .dt-layout-end,
    #example_wrapper .dataTables_paginate,
    #example_wrapper .dt-paging {
        margin-left: auto !important;
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center;
    }

    #example_wrapper .dt-paging .pagination,
    #example_wrapper .dataTables_paginate .pagination {
        justify-content: flex-end !important;
        margin-bottom: 0 !important;
    }

    #example_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #example_wrapper .dataTables_filter,
    #example_wrapper .dt-search {
        margin-left: auto !important;
        text-align: right !important;
    }

    #example_wrapper .dataTables_filter label,
    #example_wrapper .dt-search label {
        margin-bottom: 0 !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-modal-header::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -5%;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-modal-header>* {
        position: relative;
        z-index: 2;
    }

    [data-bs-theme="dark"] .ent-modal-header,
    .dark .ent-modal-header {
        border-bottom-color: var(--ent-grid-border);
        box-shadow: inset 0 -1px 0 rgba(129, 140, 248, 0.14);
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER ENTERPRISE -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-flask me-1"></i> {{ env('APP_LABEL', 'HIS') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Laboratorium Klinis</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Verifikasi Hasil Laboratorium
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Tinjau dan validasi hasil pemeriksaan laboratorium pasien sebelum dipublikasikan.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <button type="button" class="btn ent-btn ent-btn-primary px-3.5 py-2"
                            id="btn-refresh-verifikasi" onclick="location.reload()" data-bs-toggle="tooltip" title="Refresh Data">
                            <i class="fas fa-sync-alt me-1"></i> Refresh Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD WITH INTEGRATED FILTER BAR -->
<div class="ent-card mb-4">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="row align-items-center g-2">
            <!-- Mobile Filter Toggle -->
            <div class="col-12 d-flex d-md-none justify-content-end">
                <button class="btn btn-sm ent-btn ent-btn-warning px-3 py-2 d-flex align-items-center gap-1"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter"></i>
                    <span class="fw-bold">Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- Container Deretan Filter -->
            <div class="col-12 collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center">
                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-floating-custom">
                            <label for="filter_tgl_awal">Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="filter_tgl_awal" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-floating-custom">
                            <label for="filter_tgl_akhir">Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="filter_tgl_akhir" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-md-4">
                        <div class="form-floating-custom">
                            <label for="filter_search">Cari Nama / No Reg</label>
                            <input type="text" class="form-control ent-input" id="filter_search" placeholder="Ketik kata kunci...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD BODY / TABLE -->
    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 15%;">No. Registrasi</th>
                        <th style="width: 19%;">Nama Pasien</th>
                        <th style="width: 13%;" class="text-nowrap">Tanggal Reg</th>
                        <th style="width: 15%;">Dokter Rujukan</th>
                        <th style="width: 19%;">Daftar Pemeriksaan Lab</th>
                        <th class="text-center" style="width: 10%;">Status</th>
                    </tr>
                </thead>
                <tbody class="ent-table-surface">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr data-tgl="{{ date('Y-m-d', strtotime($datas->d_reg_order_date)) }}">
                        <td class="action-cell-full text-center align-middle">
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu ent-dropdown-menu py-2">
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2 btn-verifikasi-action" href="#"
                                            data-code="{{ $datas->registrasi_id }}"
                                            data-reg="{{ $datas->no_registrasi }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-lab-full">
                                            <i class="fas fa-clipboard-check me-2 text-primary"></i> Verifikasi Hasil
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        <td class="text-center align-middle fw-semibold">{{ $no++ }}</td>

                        <td class="align-middle">
                            <span class="code-chip">
                                <i class="fas fa-hashtag me-1"></i>{{ $datas->no_registrasi }}
                            </span>
                        </td>

                        <td class="align-middle">
                            <div class="fw-bold text-uppercase">{{ $datas->master_patient_name }}</div>
                            <small class="opacity-75 fw-semibold" style="font-family: 'JetBrains Mono', monospace;">RM: {{ $datas->master_patient_rm }}</small>
                        </td>

                        <td class="align-middle text-nowrap fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                            <i class="far fa-clock me-1 text-primary"></i>{{ date('d-m-Y H:i', strtotime($datas->d_reg_order_date)) }}
                        </td>

                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-1.5 fw-semibold">
                                <i class="fas fa-user-md text-primary"></i>
                                <span>{{ $datas->master_doctor_name ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="align-middle">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($datas->items as $item)
                                <span class="verif-item-chip">
                                    <i class="fas fa-flask text-primary"></i>{{ $item->nama_layanan }}
                                </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="text-center align-middle">
                            @if ($datas->status == 'SELESAI')
                            <span class="ent-badge" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);">
                                <i class="fas fa-user-shield me-1"></i>Menunggu Verifikasi
                            </span>
                            @else
                            <span class="ent-badge" style="background: rgba(16, 185, 129, 0.14); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);">
                                <i class="fas fa-check-circle me-1"></i>{{ $datas->status }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL DETAIL LAB FULL -->
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; background-color: var(--ent-solid-bg); color: var(--ent-solid-text); border: 1px solid var(--ent-grid-border);">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-lab-full"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let labTable;
    let activeVerifikasiDetailAjax = null;

    $(document).ready(function() {
        labTable = $('#example').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                }
            },
            pageLength: 10,
            layout: {
                topStart: 'pageLength',
                topEnd: 'search',
                bottomStart: 'info',
                bottomEnd: 'paging'
            }
        });

        $('#filter_search').on('keyup', function() {
            labTable.search(this.value).draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if (settings.nTable.id !== 'example') return true;

                var tglAwal = $('#filter_tgl_awal').val();
                var tglAkhir = $('#filter_tgl_akhir').val();

                var rowNode = labTable.row(dataIndex).node();
                var tglRow = rowNode ? $(rowNode).data('tgl') : '';

                if ((tglAwal === "" && tglAkhir === "") ||
                    (tglAwal === "" && tglRow <= tglAkhir) ||
                    (tglAwal <= tglRow && tglAkhir === "") ||
                    (tglAwal <= tglRow && tglRow <= tglAkhir)) {
                    return true;
                }
                return false;
            }
        );

        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            labTable.draw();
        });

        const modalLabFullEl = document.getElementById('modal-lab-full');
        if (modalLabFullEl) {
            modalLabFullEl.addEventListener('hidden.bs.modal', function() {
                if (activeVerifikasiDetailAjax && activeVerifikasiDetailAjax.readyState !== 4) {
                    activeVerifikasiDetailAjax.abort();
                    activeVerifikasiDetailAjax = null;
                }
                $('#menu-lab-full').empty();
            });
        }
    });

    // OPEN DETAIL MODAL VERIFIKASI HASIL
    $(document).on("click", ".btn-verifikasi-action", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        if (activeVerifikasiDetailAjax && activeVerifikasiDetailAjax.readyState !== 4) {
            activeVerifikasiDetailAjax.abort();
        }

        $('#menu-lab-full').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary my-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="opacity-75 fw-semibold small mb-0">Memuat rincian verifikasi hasil pemeriksaan...</p>
            </div>
        `);

        activeVerifikasiDetailAjax = $.ajax({
            url: "{{ route('verifikasi_laboratorium_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-lab-full').html(data);
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            $('#menu-lab-full').html('<div class="alert alert-danger m-3 rounded-3 fw-semibold" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat detail hasil pemeriksaan.</div>');
        }).always(function() {
            activeVerifikasiDetailAjax = null;
        });
    });
</script>
@endsection
