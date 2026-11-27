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
                                <i class="fas fa-chalkboard-teacher"></i> {{ env('APP_NAME', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Jadwal Pelatihan</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Jadwal Pelatihan Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Kelola agenda pengembangan kompetensi, jadwal pelaksanaan pelatihan, instruktur, serta lokasi kegiatan.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">HR Development Module</span>
                        <span class="fw-bold fs-1" style="color: #7dd3fc;">
                            <i class="far fa-calendar-check me-1 fs--1"></i> Training Schedule
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
        <form id="filterPelatihanForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i> Nama Pelatihan
                </label>
                <input type="text" id="filterNamaPelatihan" class="form-control ent-input fs-2" placeholder="Cari nama pelatihan...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Departemen
                </label>
                <select id="filterDeptPelatihan" class="form-select ent-select fs-2">
                    <option value="">Pilih Departemen</option>
                    <option value="SDM">SDM</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="IT">IT</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Periode Bulan
                </label>
                <input type="month" id="filterPeriodePelatihan" class="form-control ent-input ent-mono fs-2">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
                <button type="button" id="btnResetPelatihan" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-calendar-alt text-primary me-2"></i>Daftar Jadwal Pelatihan</h6>
            <span class="opacity-75 fs--1">Agenda pelatihan aktif, terjadwal, dan selesai beserta informasi instruktur &amp; lokasi.</span>
        </div>
        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
            <i class="fas fa-graduation-cap"></i> Agenda Pelatihan
        </span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="example" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">No</th>
                        <th>Nama Pelatihan &amp; Departemen</th>
                        <th>Jadwal Pelaksanaan</th>
                        <th>Instruktur</th>
                        <th>Lokasi</th>
                        <th class="text-center" style="width: 170px;">Status</th>
                        <th class="text-center" style="width: 90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="text-center ent-mono fw-semibold">1</td>
                        <td>
                            <div class="fw-bold fs-2">Leadership Development</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <i class="fas fa-building"></i> SDM
                                </span>
                            </div>
                        </td>
                        <td class="ent-mono fs--1">
                            <div><i class="far fa-calendar-plus text-success me-1"></i>05 Nov 2025</div>
                            <div class="opacity-75 fs--2"><i class="far fa-calendar-check text-primary me-1"></i>s/d 07 Nov 2025</div>
                        </td>
                        <td class="fw-semibold">Drs. Hendra Pratama</td>
                        <td>
                            <span class="opacity-85"><i class="fas fa-map-marker-alt text-danger me-1"></i>Ruang Meeting Lt. 3</span>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">
                                <i class="fas fa-spinner"></i> Sedang Berlangsung
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2" title="Detail Pelatihan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center ent-mono fw-semibold">2</td>
                        <td>
                            <div class="fw-bold fs-2">Pelatihan Sistem ERP</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">
                                    <i class="fas fa-building"></i> IT
                                </span>
                            </div>
                        </td>
                        <td class="ent-mono fs--1">
                            <div><i class="far fa-calendar-plus text-success me-1"></i>15 Nov 2025</div>
                            <div class="opacity-75 fs--2"><i class="far fa-calendar-check text-primary me-1"></i>s/d 17 Nov 2025</div>
                        </td>
                        <td class="fw-semibold">Ir. Agus Raharjo</td>
                        <td>
                            <span class="opacity-85"><i class="fas fa-map-marker-alt text-danger me-1"></i>Lab Komputer</span>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                <i class="fas fa-calendar-check"></i> Dijadwalkan
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2" title="Detail Pelatihan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center ent-mono fw-semibold">3</td>
                        <td>
                            <div class="fw-bold fs-2">Customer Service Excellence</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <i class="fas fa-building"></i> Marketing
                                </span>
                            </div>
                        </td>
                        <td class="ent-mono fs--1">
                            <div><i class="far fa-calendar-plus text-success me-1"></i>20 Okt 2025</div>
                            <div class="opacity-75 fs--2"><i class="far fa-calendar-check text-primary me-1"></i>s/d 22 Okt 2025</div>
                        </td>
                        <td class="fw-semibold">Rina Sari, S.Psi</td>
                        <td>
                            <span class="opacity-85"><i class="fas fa-map-marker-alt text-danger me-1"></i>Hotel Horizon</span>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2" title="Detail Pelatihan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 fs-2">
    <div class="col-md-4">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Pelatihan Bulan Ini</div>
                    <div class="fs-1 fw-bold text-primary ent-mono">12 Program</div>
                    <small class="opacity-75 fs--2">Agenda Pelatihan Aktif</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-chalkboard-teacher fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Peserta Terdaftar</div>
                    <div class="fs-1 fw-bold text-success ent-mono">86 Orang</div>
                    <small class="opacity-75 fs--2">Karyawan Mengikuti Pelatihan</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-user-graduate fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Pelatihan Selesai</div>
                    <div class="fs-1 fw-bold text-info ent-mono">7 Program</div>
                    <small class="opacity-75 fs--2">Telah Terlaksana &amp; Dievaluasi</small>
                </div>
                <div class="icon-shape" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                    <i class="fas fa-check-double fa-lg"></i>
                </div>
            </div>
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
        const table = new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari Cepat:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pelatihan",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });

        const namaBulanMap = {
            '01': 'Jan',
            '02': 'Feb',
            '03': 'Mar',
            '04': 'Apr',
            '05': 'Mei',
            '06': 'Jun',
            '07': 'Jul',
            '08': 'Agu',
            '09': 'Sep',
            '10': 'Okt',
            '11': 'Nov',
            '12': 'Des'
        };

        $('#filterPelatihanForm').on('submit', function(e) {
            e.preventDefault();
            const nama = $('#filterNamaPelatihan').val().trim();
            const dept = $('#filterDeptPelatihan').val().trim();
            const periodeRaw = $('#filterPeriodePelatihan').val().trim();

            let periodeKeyword = '';
            if (periodeRaw && periodeRaw.includes('-')) {
                const [tahun, bulan] = periodeRaw.split('-');
                periodeKeyword = `${namaBulanMap[bulan] || ''} ${tahun}`.trim();
            }

            const keyword = [nama, dept, periodeKeyword].filter(Boolean).join(' ');
            table.search(keyword).draw();
        });

        $('#btnResetPelatihan').on('click', function() {
            $('#filterPelatihanForm')[0].reset();
            table.search('').draw();
        });
    });
</script>
@endsection
