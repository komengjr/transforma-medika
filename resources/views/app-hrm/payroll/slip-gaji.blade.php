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

    .cardreader:hover {
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

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
{{-- Hero Banner Header --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/app.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-file-invoice-dollar"></i> {{ env('APP_NAME', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Slip Gaji Pegawai</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Slip Gaji Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Ringkasan distribusi gaji bulanan, rincian komponen pendapatan, potongan, serta cetak slip gaji pegawai.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Payroll Module</span>
                        <span class="fw-bold fs-1" style="color: #7dd3fc;">
                            <i class="fas fa-receipt me-1 fs--1"></i> Daftar Slip Gaji
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Filter Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Divisi
                </label>
                <select class="form-select ent-select fs-2" id="filterDivisi">
                    <option value="">Semua Divisi</option>
                    <option value="Finance">Finance</option>
                    <option value="HRD">HRD</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Produksi">Produksi</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Periode
                </label>
                <input type="month" class="form-control ent-input ent-mono fs-2" id="filterPeriode" value="2025-10">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="button" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2" id="btnTampilkanSlip">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
                <button type="button" class="btn ent-btn btn-light border px-3 py-2 fs-2" id="btnResetSlip" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-3 fs-2">
    <div class="col-md-3 col-6">
        <div class="card ent-card summary-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Karyawan</div>
                    <div class="fs-1 fw-bold text-primary ent-mono">45 Orang</div>
                    <small class="opacity-75 fs--2">Penerima Slip Gaji</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card summary-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Gaji Bulan Ini</div>
                    <div class="fs-1 fw-bold text-success ent-mono">Rp 285.000.000</div>
                    <small class="opacity-75 fs--2">Total Bersih Diterima</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card summary-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Periode Gaji</div>
                    <div class="fs-1 fw-bold text-info">Oktober 2025</div>
                    <small class="opacity-75 fs--2">Siklus Penggajian</small>
                </div>
                <div class="icon-shape" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                    <i class="far fa-calendar-check fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card summary-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Status Pembayaran</div>
                    <div class="fs-1 fw-bold text-success">Selesai</div>
                    <small class="opacity-75 fs--2">Seluruh Slip Terbit</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-check-circle fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Data Gaji --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-list-alt text-primary me-2"></i>Daftar Gaji Karyawan</h6>
            <span class="opacity-75 fs--1">Rincian gaji pokok, tunjangan, lembur, potongan, dan total diterima setiap karyawan.</span>
        </div>
        <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
            <i class="fas fa-check-circle"></i> Selesai
        </span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="example" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">No</th>
                        <th>Nama Karyawan &amp; Jabatan</th>
                        <th class="text-end">Gaji Pokok</th>
                        <th class="text-end">Tunjangan</th>
                        <th class="text-end">Lembur</th>
                        <th class="text-end">Potongan</th>
                        <th class="text-end">Total Diterima</th>
                        <th class="text-center" style="width: 145px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="text-center ent-mono fw-semibold">1</td>
                        <td>
                            <div class="fw-bold fs-2">Agus Raharjo</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <i class="fas fa-briefcase"></i> HR Manager
                                </span>
                            </div>
                        </td>
                        <td class="text-end ent-mono">Rp 12.000.000</td>
                        <td class="text-end ent-mono text-success">Rp 2.000.000</td>
                        <td class="text-end ent-mono text-info">Rp 500.000</td>
                        <td class="text-end ent-mono text-danger">Rp 300.000</td>
                        <td class="text-end ent-mono fw-bold text-primary">Rp 14.200.000</td>
                        <td class="text-center text-nowrap">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2 btn-action">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </button>
                                <button type="button" class="btn btn-sm ent-btn btn-outline-success px-2 py-1 fs--2 btn-action" title="Download Slip">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center ent-mono fw-semibold">2</td>
                        <td>
                            <div class="fw-bold fs-2">Rina Marlina</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <i class="fas fa-briefcase"></i> Staf Finance
                                </span>
                            </div>
                        </td>
                        <td class="text-end ent-mono">Rp 7.000.000</td>
                        <td class="text-end ent-mono text-success">Rp 1.000.000</td>
                        <td class="text-end ent-mono text-info">Rp 300.000</td>
                        <td class="text-end ent-mono text-danger">Rp 100.000</td>
                        <td class="text-end ent-mono fw-bold text-primary">Rp 8.200.000</td>
                        <td class="text-center text-nowrap">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2 btn-action">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </button>
                                <button type="button" class="btn btn-sm ent-btn btn-outline-success px-2 py-1 fs--2 btn-action" title="Download Slip">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center ent-mono fw-semibold">3</td>
                        <td>
                            <div class="fw-bold fs-2">Dewi Putri</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <i class="fas fa-briefcase"></i> Marketing
                                </span>
                            </div>
                        </td>
                        <td class="text-end ent-mono">Rp 6.500.000</td>
                        <td class="text-end ent-mono text-success">Rp 800.000</td>
                        <td class="text-end ent-mono text-info">Rp 200.000</td>
                        <td class="text-end ent-mono text-danger">Rp 150.000</td>
                        <td class="text-end ent-mono fw-bold text-primary">Rp 7.350.000</td>
                        <td class="text-center text-nowrap">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2 btn-action">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </button>
                                <button type="button" class="btn btn-sm ent-btn btn-outline-success px-2 py-1 fs--2 btn-action" title="Download Slip">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn-close-white btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-pegawai-xl"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari Cepat:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ karyawan",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });
    });
</script>
@endsection
