@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
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

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
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

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/gl.png') }}" alt="Departemen Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-sitemap"></i> {{ Env('APP_LABEL', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Master Departemen</span>
                        </div>
                        <h4 class="fw-bold mb-0 fs-1" style="letter-spacing: -0.02em; color: #ffffff;">
                            Master Data Departemen &amp; Unit Kerja
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Kelola struktur departemen, kode unit, lokasi kerja, dan kepala departemen (Head).</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Total Departemen</span>
                        <span class="fw-bold fs-1 ent-mono" style="color: #7dd3fc;">
                            <i class="fas fa-building me-1 fs--1"></i> {{ count($data ?? []) }} Unit
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- TABLE CARD -->
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold fs-1">
                    <i class="fas fa-table me-2 text-primary"></i>Daftar Departemen
                </h6>
                <span class="opacity-75 fs--1">Informasi kode, nama departemen, lokasi, serta penanggung jawab unit.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a class="btn ent-btn btn-light border py-1 px-3 fs--1" href="#" onclick="location.reload(); return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh" id="button-data-today-pasien">
                    <span class="fas fa-undo me-1"></span> Refresh
                </a>
                <button class="btn ent-btn btn-primary py-1 px-3 fs--1" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Departemen">
                    <span class="fas fa-plus me-1"></span> Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4" id="hasil-pencarian-list">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="example" class="table table-hover align-middle mb-0 table-custom fs-2" style="width:100%">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center">No</th>
                        <th>Kode Departemen</th>
                        <th>Nama Departemen</th>
                        <th>Lokasi Departemen</th>
                        <th>Head</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td class="text-center ent-mono fw-semibold">{{ $no++ }}</td>
                            <td class="ent-mono">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    {{ $datas->hrm_departemen_code }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $datas->hrm_departemen_name }}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger me-1 fs--2"></i>
                                {{ $datas->hrm_departemen_lokasi }}
                            </td>
                            <td>
                                <i class="fas fa-user-tie text-primary me-1 fs--2"></i>
                                {{ $datas->hrm_departemen_kepala }}
                            </td>
                            <td class="text-center text-nowrap">
                                <button type="button" class="btn btn-sm ent-btn btn-outline-warning py-1 px-3 fs--2">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
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
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>
<script>
    new DataTable('#example', {
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari departemen...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        }
    });

    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
            new bootstrap.Tooltip(el);
        });
    }
</script>
@endsection
