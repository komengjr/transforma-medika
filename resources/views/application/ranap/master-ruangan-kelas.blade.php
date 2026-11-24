@extends('layouts.layouts')

@section('base.css')
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
        z-index: 1080 !important;
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

    /* Bed Status Cards */
    .bed-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .bed-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.14);
    }

    .status-tersedia {
        border-left: 5px solid #059669;
        background-color: rgba(5, 150, 105, 0.04);
    }

    .status-terisi {
        border-left: 5px solid #d97706;
        background-color: rgba(217, 119, 6, 0.04);
    }

    .status-perbaikan {
        border-left: 5px solid #0284c7;
        background-color: rgba(2, 132, 199, 0.04);
    }

    .status-rusak {
        border-left: 5px solid #e11d48;
        background-color: rgba(225, 29, 72, 0.04);
    }

    /* Modal Styling */
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
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-door-open text-info fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-hospital me-1"></i> Manajemen Fasilitas
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Bangsal &amp; Tempat Tidur Ranap</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">Master Ruangan, Kelas &amp; Bed Rawat Inap</h4>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <button type="button" class="btn ent-btn ent-btn-success btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahRuangan">
                            <i class="fas fa-plus me-1"></i> Tambah Ruangan Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK RINGKAS BED -->
<div class="row g-3 mb-3">
    <div class="col-sm-6 col-md-3">
        <div class="ent-card p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center"
                    style="background: rgba(5, 150, 105, 0.12); color: #059669; border: 1px solid rgba(5, 150, 105, 0.3);">
                    <i class="fas fa-check-circle fs-4"></i>
                </div>
                <div>
                    <span class="ent-field-label mb-0">Bisa Digunakan</span>
                    <h4 class="fw-bold mb-0 text-success" style="font-family: 'JetBrains Mono', monospace;">{{ $statsTersedia ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="ent-card p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center"
                    style="background: rgba(217, 119, 6, 0.12); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.3);">
                    <i class="fas fa-procedures fs-4"></i>
                </div>
                <div>
                    <span class="ent-field-label mb-0">Sedang Digunakan</span>
                    <h4 class="fw-bold mb-0 text-warning" style="font-family: 'JetBrains Mono', monospace;">{{ $statsTerisi ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="ent-card p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center"
                    style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.3);">
                    <i class="fas fa-tools fs-4"></i>
                </div>
                <div>
                    <span class="ent-field-label mb-0">Dalam Perbaikan</span>
                    <h4 class="fw-bold mb-0 text-info" style="font-family: 'JetBrains Mono', monospace;">{{ $statsPerbaikan ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="ent-card p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-3 me-3 d-flex align-items-center justify-content-center"
                    style="background: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3);">
                    <i class="fas fa-ban fs-4"></i>
                </div>
                <div>
                    <span class="ent-field-label mb-0">Rusak / Non-Aktif</span>
                    <h4 class="fw-bold mb-0 text-danger" style="font-family: 'JetBrains Mono', monospace;">{{ $statsRusak ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR INTERAKTIF -->
<div class="ent-card mb-3 p-3 p-md-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="ent-field-label"><i class="fas fa-filter text-primary me-1"></i> Filter Berdasarkan Kelas</label>
            <select id="filter-kelas" class="form-select ent-input select2-master-bed" data-placeholder="-- Semua Kelas Perawatan --">
                <option value="">-- Semua Kelas Perawatan --</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="VIP">VIP</option>
                <option value="VVIP">VVIP</option>
                <option value="ICU">ICU</option>
            </select>
        </div>
        <div class="col-md-5">
            <label class="ent-field-label"><i class="fas fa-procedures text-success me-1"></i> Filter Berdasarkan Status Bed</label>
            <select id="filter-status" class="form-select ent-input select2-master-bed" data-placeholder="-- Semua Status Bed --">
                <option value="">-- Semua Status Bed --</option>
                <option value="TERSEDIA">Tersedia (Bisa Digunakan)</option>
                <option value="TERISI">Sedang Digunakan (Terisi)</option>
                <option value="PERBAIKAN">Dalam Perbaikan</option>
                <option value="RUSAK">Rusak</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" id="btn-reset-filter" class="btn ent-btn ent-btn-reset btn-sm w-100 fw-semibold" style="height: 38px;">
                <i class="fas fa-sync-alt me-1"></i> Reset
            </button>
        </div>
    </div>
</div>

<!-- DAFTAR RUANGAN DAN BED -->
<div class="row g-3" id="container-ruangan">
    @forelse($ruanganList as $ruangan)
    <div class="col-xl-6 room-item" data-kelas="{{ $ruangan->kelas }}">
        <div class="ent-card h-100">
            <div class="ent-card-header d-flex justify-content-between align-items-center gap-2">
                <div>
                    <h6 class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="fas fa-hospital text-primary"></i> {{ $ruangan->nama_ruangan }}
                    </h6>
                    <span class="ent-badge" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">
                        Kelas: {{ $ruangan->kelas }}
                    </span>
                </div>
                <button type="button" class="btn ent-btn ent-btn-primary btn-sm px-3 py-1" style="font-size: 0.75rem;" onclick="tambahBedModal('{{ $ruangan->id }}', '{{ $ruangan->nama_ruangan }}')">
                    <i class="fas fa-plus me-1"></i> Tambah Bed
                </button>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    @forelse($ruangan->beds as $bed)
                    @php
                    $statusClass = 'status-tersedia';
                    $badgeStyle = 'background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);';

                    if($bed->is_active == 0) {
                    $statusClass = 'opacity-75';
                    $badgeStyle = 'background: rgba(100, 116, 139, 0.16); color: #475569; border: 1px solid rgba(100, 116, 139, 0.35);';
                    } elseif($bed->status == 'TERISI') {
                    $statusClass = 'status-terisi';
                    $badgeStyle = 'background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.35);';
                    } elseif($bed->status == 'PERBAIKAN') {
                    $statusClass = 'status-perbaikan';
                    $badgeStyle = 'background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35);';
                    } elseif($bed->status == 'RUSAK') {
                    $statusClass = 'status-rusak';
                    $badgeStyle = 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);';
                    }
                    @endphp
                    <div class="col-sm-6 col-md-4 bed-item" data-status="{{ $bed->status }}">
                        <div class="bed-card p-2 {{ $statusClass }} d-flex flex-column justify-content-between h-100">
                            <div class="d-flex justify-content-between align-items-start gap-1 mb-1">
                                <span class="fw-bold" style="font-size: 0.82rem; font-family: 'JetBrains Mono', monospace;">{{ $bed->nomor_bed }}</span>
                                <span class="ent-badge" style="{{ $badgeStyle }}">
                                    {{ $bed->is_active == 0 ? 'NON-AKTIF' : $bed->status }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mt-2 pt-2" style="border-top: 1px solid var(--ent-grid-border);">
                                <button type="button" class="btn btn-sm ent-btn ent-btn-reset py-0 px-2" style="font-size: 0.7rem;" onclick="editBed('{{ $bed->id }}', '{{ $bed->nomor_bed }}', '{{ $bed->status }}')" title="Edit Bed">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm ent-btn {{ $bed->is_active == 1 ? 'btn-outline-warning' : 'btn-outline-success' }} py-0 px-2" style="font-size: 0.7rem;" onclick="toggleActiveBed('{{ $bed->id }}')" title="{{ $bed->is_active == 1 ? 'Non-aktifkan Bed' : 'Aktifkan Bed' }}">
                                    <i class="fas {{ $bed->is_active == 1 ? 'fa-ban' : 'fa-check' }}"></i> {{ $bed->is_active == 1 ? 'Non-Aktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center opacity-75 py-3 fw-semibold fs--1 no-bed-msg">
                        Belum ada tempat tidur (Bed) terdaftar di ruangan ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="ent-card p-5 text-center">
            <h6 class="opacity-75 fw-bold mb-3">Belum ada data ruangan atau bangsal rawat inap yang terdaftar.</h6>
            <button type="button" class="btn ent-btn ent-btn-success btn-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambahRuangan">
                <i class="fas fa-plus me-1"></i> Tambah Ruangan Pertama
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- MODAL TAMBAH RUANGAN -->
<div class="modal fade" id="modalTambahRuangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <form action="{{ route('master.ruangan.store') }}" method="POST">
                @csrf
                <div class="modal-header ent-modal-header py-3 px-4">
                    <h6 class="modal-title fw-bold text-white mb-0">
                        <i class="fas fa-door-open me-2 text-info"></i> Tambah Master Ruangan
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="ent-field-label">Nama Ruangan / Bangsal</label>
                        <input type="text" class="form-control ent-input" name="nama_ruangan" placeholder="Contoh: Melati, ICU, Anggrek..." required>
                    </div>
                    <div class="mb-2">
                        <label class="ent-field-label">Kelas Perawatan</label>
                        <select class="form-select ent-input select2-modal-ruangan" id="select-kelas-ruangan" name="kelas" data-placeholder="-- Pilih Kelas --" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                            <option value="VIP">VIP</option>
                            <option value="VVIP">VVIP</option>
                            <option value="ICU">ICU</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn ent-btn-reset btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success btn-sm px-4">Simpan Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH BED -->
<div class="modal fade" id="modalTambahBed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <form action="{{ route('master.bed.store') }}" method="POST">
                @csrf
                <input type="hidden" name="ruangan_id" id="input_ruangan_id">
                <div class="modal-header ent-modal-header py-3 px-4">
                    <h6 class="modal-title fw-bold text-white mb-0">
                        <i class="fas fa-bed me-2 text-info"></i> Tambah Bed ke Ruangan: <span id="label_nama_ruangan" class="text-warning"></span>
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="ent-field-label">Nomor / Kode Bed</label>
                        <input type="text" class="form-control ent-input" name="nomor_bed" placeholder="Contoh: Bed 01, Bed 02..." required>
                    </div>
                    <div class="mb-2">
                        <label class="ent-field-label">Status Awal Bed</label>
                        <select class="form-select ent-input select2-modal-bed" id="select-status-bed" name="status" data-placeholder="-- Pilih Status Awal --" required>
                            <option value="TERSEDIA">TERSEDIA (Bisa Digunakan)</option>
                            <option value="PERBAIKAN">DALAM PERBAIKAN</option>
                            <option value="RUSAK">RUSAK</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn ent-btn-reset btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary btn-sm px-4">Simpan Bed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function initSelect2MasterBed(selector, modalSelector) {
        if (!(window.jQuery && $.fn.select2)) return;
        const $parent = modalSelector && $(modalSelector).length ? $(modalSelector) : $(document.body);

        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $parent,
                placeholder: placeholderText,
                allowClear: hasEmptyOption,
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

    // Logika Filter Ruangan & Status Bed secara Interaktif
    function filterRuanganBed() {
        let selectedKelas = $('#filter-kelas').val();
        let selectedStatus = $('#filter-status').val();

        $('.room-item').each(function() {
            let roomCard = $(this);
            let roomKelas = roomCard.data('kelas');

            let matchKelas = !selectedKelas || roomKelas === selectedKelas;
            let visibleBedsInRoom = 0;

            roomCard.find('.bed-item').each(function() {
                let bedItem = $(this);
                let bedStatus = bedItem.data('status');

                let matchStatus = !selectedStatus || bedStatus === selectedStatus;

                if (matchStatus) {
                    bedItem.show();
                    visibleBedsInRoom++;
                } else {
                    bedItem.hide();
                }
            });

            if (matchKelas && (visibleBedsInRoom > 0 || !selectedStatus)) {
                roomCard.show();
            } else {
                roomCard.hide();
            }
        });
    }

    $(document).ready(function() {
        initSelect2MasterBed('.select2-master-bed');

        $('#modalTambahRuangan').on('shown.bs.modal', function() {
            initSelect2MasterBed('.select2-modal-ruangan', '#modalTambahRuangan');
        });

        $('#modalTambahBed').on('shown.bs.modal', function() {
            initSelect2MasterBed('.select2-modal-bed', '#modalTambahBed');
        });

        $('#filter-kelas, #filter-status').on('change', function() {
            filterRuanganBed();
        });

        $('#btn-reset-filter').on('click', function() {
            $('#filter-kelas').val('').trigger('change');
            $('#filter-status').val('').trigger('change');
            $('.room-item').show();
            $('.bed-item').show();
        });
    });

    function tambahBedModal(ruanganId, namaRuangan) {
        $('#input_ruangan_id').val(ruanganId);
        $('#label_nama_ruangan').text(namaRuangan);
        $('#select-status-bed').val('TERSEDIA').trigger('change');
        $('#modalTambahBed').modal('show');
    }

    function editBed(bedId, nomorBed, statusBed) {
        Swal.fire({
            title: 'Edit Status Bed',
            html: `
                <div class="text-start mb-2">
                    <label class="form-label fw-bold mb-1" style="font-size: 0.78rem;">Nomor Bed:</label>
                    <input type="text" id="swal_nomor_bed" class="form-control mb-3" value="${nomorBed}">
                    <label class="form-label fw-bold mb-1" style="font-size: 0.78rem;">Status Bed:</label>
                    <select id="swal_status_bed" class="form-select">
                        <option value="TERSEDIA" ${statusBed === 'TERSEDIA' ? 'selected' : ''}>TERSEDIA</option>
                        <option value="TERISI" ${statusBed === 'TERISI' ? 'selected' : ''}>TERISI</option>
                        <option value="PERBAIKAN" ${statusBed === 'PERBAIKAN' ? 'selected' : ''}>PERBAIKAN</option>
                        <option value="RUSAK" ${statusBed === 'RUSAK' ? 'selected' : ''}>RUSAK</option>
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#059669',
            preConfirm: () => {
                return {
                    nomor_bed: document.getElementById('swal_nomor_bed').value,
                    status: document.getElementById('swal_status_bed').value
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/update') }}/" + bedId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nomor_bed: result.value.nomor_bed,
                        status: result.value.status
                    },
                    success: function(res) {
                        Swal.fire('Berhasil!', 'Data bed berhasil diperbarui.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memperbarui data bed.', 'error');
                    }
                });
            }
        });
    }

    function hapusBed(bedId) {
        Swal.fire({
            title: 'Hapus Bed?',
            text: "Data tempat tidur ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/delete') }}/" + bedId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Terhapus!', 'Bed berhasil dihapus.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus bed.', 'error');
                    }
                });
            }
        });
    }

    function toggleActiveBed(bedId) {
        Swal.fire({
            title: 'Ubah Status Aktif Bed?',
            text: "Status keaktifan bed ini akan diubah.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d97706',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/toggle-active') }}/" + bedId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Berhasil!', res.message, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengubah status bed.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
