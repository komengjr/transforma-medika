@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

    .ent-select {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-weight: 600;
        padding: 8px 12px !important;
    }

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
                        <img src="{{ asset('img/gl.png') }}" alt="KPI Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-bullseye"></i> {{ env('APP_LABEL', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Master KPI</span>
                        </div>
                        <h4 class="fw-bold mb-0 fs-1" style="letter-spacing: -0.02em; color: #ffffff;">
                            Master Data Indikator KPI
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Kelola indikator penilaian kinerja, bobot, target, tipe penilaian, dan formula sistem per departemen.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Total Master KPI</span>
                        <span class="fw-bold fs-1 ent-mono" style="color: #7dd3fc;">
                            <i class="fas fa-chart-pie me-1 fs--1"></i> <span id="kpi-visible-count">{{ count($data ?? []) }}</span> Indikator
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- FILTER DEPARTEMEN CARD -->
@php
$departemenList = collect($data ?? [])
->map(function ($item) {
return trim($item->hrm_departemen_name ?? '');
})
->filter(function ($name) {
return $name !== '';
})
->unique()
->sort()
->values();
@endphp

<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-7 col-lg-8">
                <label for="filter_departemen" class="form-label fw-bold fs--1 mb-2">
                    <i class="fas fa-building text-primary me-1"></i> Filter Departemen
                </label>
                <select class="form-select ent-select fs-2" id="filter_departemen" name="filter_departemen">
                    <option value="">Semua Departemen</option>
                    @foreach($departemenList as $deptName)
                    <option value="{{ $deptName }}">{{ $deptName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 col-lg-4 d-flex gap-2">
                <button type="button" class="btn ent-btn btn-light border flex-fill py-2 fs-2" id="button-reset-filter-dept">
                    <i class="fas fa-times me-1"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- TABLE CARD -->
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold fs-1">
                    <i class="fas fa-table me-2 text-primary"></i>Daftar Master KPI
                </h6>
                <span class="opacity-75 fs--1">Menampilkan indikator KPI sesuai filter departemen yang dipilih.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a class="btn ent-btn btn-light border py-1 px-3 fs--1" href="javascript:void(0)" onclick="location.reload();" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh">
                    <span class="fas fa-sync-alt me-1"></span> Refresh
                </a>
                <button class="btn ent-btn btn-primary py-1 px-3 fs--1" type="button" data-bs-toggle="modal"
                    data-bs-target="#modal-kpi" aria-label="Add KPI" id="button-add-master-kpi">
                    <span class="fas fa-plus me-1"></span> Tambah Master KPI
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4" id="hasil-pencarian-list">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="example" class="table table-hover align-middle mb-0 table-custom fs-2" style="width:100%">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" width="5%">No</th>
                        <th>Kode KPI</th>
                        <th>Nama KPI</th>
                        <th>Departemen</th>
                        <th class="text-center">Bobot</th>
                        <th class="text-center">Target</th>
                        <th class="text-center">Tipe Penilaian</th>
                        <th>Formula Sistem</th>
                        <th class="text-center" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    @php $deptVal = trim($datas->hrm_departemen_name ?? ''); @endphp
                    <tr data-departemen="{{ $deptVal }}">
                        <td class="text-center ent-mono fw-semibold">{{ $no++ }}</td>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                {{ $datas->hrm_kpi_master_code }}
                            </span>
                        </td>
                        <td class="fw-bold">{{ $datas->hrm_kpi_master_name }}</td>
                        <td data-dept-cell="{{ $deptVal }}">
                            @if($deptVal !== '')
                            <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.22);">
                                {{ $deptVal }}
                            </span>
                            @else
                            <span class="opacity-50">-</span>
                            @endif
                        </td>
                        <td class="text-center ent-mono">
                            <span class="fw-bold text-success">{{ $datas->hrm_kpi_master_bobot }}%</span>
                        </td>
                        <td class="text-center ent-mono fw-semibold">{{ $datas->hrm_kpi_master_target }}</td>
                        <td class="text-center">
                            @php
                            $type = $datas->hrm_kpi_master_type ?? 'manual';
                            @endphp
                            @if($type === 'manual')
                            <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">Manual</span>
                            @elseif($type === 'kehadiran')
                            <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);">Kehadiran</span>
                            @elseif($type === 'sistem')
                            <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">Sistem</span>
                            @else
                            <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">{{ ucfirst($type) }}</span>
                            @endif
                        </td>
                        <td class="ent-mono">
                            @if(($datas->hrm_kpi_master_type ?? '') === 'sistem')
                            <code class="fs--2">{{ $datas->hrm_kpi_master_formula ?? '-' }}</code>
                            @else
                            <span class="opacity-50 fs--2">-</span>
                            @endif
                        </td>
                        <td class="text-center text-nowrap">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-sm ent-btn btn-outline-warning btn-edit-kpi me-1" data-code="{{ $datas->hrm_kpi_master_code }}" data-bs-toggle="tooltip" title="Edit">
                                    <span class="fas fa-edit"></span>
                                </button>
                                <button type="button" class="btn btn-sm ent-btn btn-outline-danger btn-delete-kpi" data-code="{{ $datas->hrm_kpi_master_code }}" data-bs-toggle="tooltip" title="Hapus">
                                    <span class="fas fa-trash-alt"></span>
                                </button>
                            </div>
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
<div class="modal fade" id="modal-kpi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content ent-card border-0 fs-2">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-kpi-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-kpi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ent-card border-0 fs-2">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <!-- <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div id="menu-kpi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let kpiDataTable = null;

    function getSelectedDepartment() {
        const el = document.getElementById('filter_departemen');
        return (el ? el.value : '').trim().toLowerCase();
    }

    function updateKpiCounter(count) {
        const counterEl = document.getElementById('kpi-visible-count');
        if (counterEl) {
            counterEl.textContent = count;
        }
    }

    function applyDepartmentFilter() {
        const selectedDept = getSelectedDepartment();

        if (kpiDataTable) {
            kpiDataTable.draw();
            const info = kpiDataTable.page.info();
            if (info) {
                updateKpiCounter(info.recordsDisplay);
            }
        } else {
            const rows = document.querySelectorAll('#example tbody tr');
            let visibleCount = 0;

            rows.forEach(function(row) {
                const rowDept = (row.getAttribute('data-departemen') || '').trim().toLowerCase();
                const isMatch = !selectedDept || rowDept === selectedDept;
                row.style.display = isMatch ? '' : 'none';
                if (isMatch) visibleCount++;
            });

            updateKpiCounter(visibleCount);
        }
    }

    // Custom search DataTables berdasarkan atribut data-departemen pada <tr>
    if ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.search) {
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (!settings.nTable || settings.nTable.id !== 'example') {
                return true;
            }

            const selectedDept = getSelectedDepartment();
            if (!selectedDept) {
                return true;
            }

            const rowNode = settings.aoData && settings.aoData[dataIndex] ? settings.aoData[dataIndex].nTr : null;
            const rowDept = rowNode ?
                String(rowNode.getAttribute('data-departemen') || '').trim().toLowerCase() :
                String(data[3] || '').trim().toLowerCase();

            return rowDept === selectedDept;
        });
    }

    $(document).ready(function() {
        kpiDataTable = new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                zeroRecords: "Tidak ada data KPI yang sesuai dengan filter departemen.",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });

        kpiDataTable.on('draw', function() {
            const info = kpiDataTable.page.info();
            if (info) {
                updateKpiCounter(info.recordsDisplay);
            }
        });

        $('#filter_departemen').on('change', function() {
            applyDepartmentFilter();
        });

        $('#button-reset-filter-dept').on('click', function() {
            $('#filter_departemen').val('');
            applyDepartmentFilter();
        });
    });

    // Handle Tampil Modal Tambah Data
    $(document).on("click", "#button-add-master-kpi", function(e) {
        e.preventDefault();
        $('#menu-kpi').html(
            '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
        );
        $.ajax({
            url: "{{ route('master_data_kpi_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": "{{ Auth::user()->userid }}"
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-kpi').html(data);
        }).fail(function() {
            $('#menu-kpi').html('<div class="alert alert-danger m-3 fs--1">Gagal memuat form modal. Silakan coba lagi.</div>');
        });
    });

    // Handle Simpan Data Master KPI
    $(document).on("click", "#button-simpan-data-master-kpi", function(e) {
        e.preventDefault();

        var form = $("#form-master-kpi");
        var data = form.serialize();

        var defaultBtnHtml = '<button class="btn btn-success float-end" id="button-simpan-data-master-kpi" data-code="">Simpan Data</button>';
        $('#menu-add-data-master-kpi').html(
            '<div class="spinner-border text-primary my-1 float-end" role="status"><span class="visually-hidden">Loading...</span></div>'
        );

        $.ajax({
            url: "{{ route('master_data_kpi_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Master KPI berhasil disimpan.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Menyimpan",
                    text: response.message || "Terjadi kesalahan saat menyimpan data."
                });
                $('#menu-add-data-master-kpi').html(defaultBtnHtml);
            }
        }).fail(function(xhr) {
            let errorMsg = "Terjadi kesalahan pada server.";

            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let firstKey = Object.keys(errors)[0];
                errorMsg = errors[firstKey][0];
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: errorMsg
            });

            $('#menu-add-data-master-kpi').html(defaultBtnHtml);
        });
    });

    // Toggle Input Formula berdasarkan tipe penilaian
    function toggleFormulaInput(type) {
        const containerFormula = document.getElementById('container_formula');
        const inputFormula = document.getElementById('hrm_kpi_master_formula');

        if (containerFormula && inputFormula) {
            if (type === 'sistem') {
                containerFormula.style.display = 'block';
                inputFormula.setAttribute('required', 'required');
            } else {
                containerFormula.style.display = 'none';
                inputFormula.removeAttribute('required');
                inputFormula.value = '';
            }
        }
    }
</script>
@endsection
