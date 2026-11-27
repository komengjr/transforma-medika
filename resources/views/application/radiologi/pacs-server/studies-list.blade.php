@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* ==========================================
     * MODERN ENTERPRISE PACS & RADIOLOGY UI
     * (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
     * ========================================== */
    :root {
        --pacs-accent: #0284c7;
        --pacs-accent-deep: #0369a1;
        --pacs-indigo: #4f46e5;
        --pacs-grid-border: rgba(2, 132, 199, 0.25);
        --pacs-solid-bg: #ffffff;
        --pacs-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --pacs-solid-bg: #0f172a;
        --pacs-solid-text: #f8fafc;
        --pacs-grid-border: rgba(56, 189, 248, 0.25);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Hero Header Radiologi PACS */
    .pacs-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 52%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.24);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .pacs-hero-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.28) 0%, transparent 72%);
        pointer-events: none;
    }

    .pacs-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .pacs-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* Main Container Card */
    .pacs-card {
        background-color: var(--bs-body-bg, var(--pacs-solid-bg));
        border-radius: 16px;
        border: 1px solid var(--pacs-grid-border);
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    /* Filter Header Styling */
    .pacs-filter-box {
        background-color: rgba(2, 132, 199, 0.04);
        border: 1px solid var(--pacs-grid-border);
        border-radius: 12px;
        padding: 12px;
    }

    .pacs-filter-label {
        font-weight: 700;
        font-size: 0.68rem;
        color: var(--bs-secondary-color, #64748b);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
        display: block;
    }

    .pacs-filter-input .form-control,
    .pacs-filter-input .form-select {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        border: 1px solid var(--pacs-grid-border) !important;
        background-color: var(--bs-body-bg, var(--pacs-solid-bg)) !important;
        color: var(--bs-body-color, var(--pacs-solid-text)) !important;
        min-height: 35px;
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .pacs-filter-input .form-control:focus,
    .pacs-filter-input .form-select:focus {
        border-color: var(--pacs-accent) !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.16) !important;
        outline: none;
    }

    /* PACS Action Toolbar */
    .pacs-toolbar {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-left: 4px solid #38bdf8;
    }

    .pacs-btn-icon {
        background-color: rgba(255, 255, 255, 0.08);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
        border-radius: 9px;
        padding: 6px 11px;
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.18s ease;
        cursor: pointer;
    }

    .pacs-btn-icon:hover {
        background-color: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
    }

    .pacs-btn-reset {
        border-radius: 10px;
        min-height: 35px;
        font-weight: 600;
    }

    /* Table Styling */
    .pacs-table {
        font-size: 0.84rem;
    }

    .pacs-table thead th {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--bs-secondary-color, #64748b);
        background-color: rgba(2, 132, 199, 0.06);
        border-bottom: 1px solid var(--pacs-grid-border) !important;
        padding: 10px 8px;
        white-space: nowrap;
    }

    .pacs-table tbody tr {
        transition: background-color 0.15s ease-in-out;
    }

    .pacs-table tbody tr:hover {
        background-color: rgba(56, 189, 248, 0.08) !important;
    }

    .pacs-table td {
        vertical-align: middle;
        padding: 10px 8px;
        border-color: var(--pacs-grid-border);
    }

    .mono-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.76rem;
        font-weight: 600;
    }

    /* Modality Badge */
    .modality-badge {
        background-color: rgba(2, 132, 199, 0.12);
        color: #0284c7;
        border: 1px solid rgba(2, 132, 199, 0.3);
        border-radius: 9999px;
        padding: 3px 10px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.03em;
        display: inline-block;
    }

    [data-bs-theme="dark"] .modality-badge,
    .dark .modality-badge {
        color: #38bdf8;
        background-color: rgba(56, 189, 248, 0.14);
        border-color: rgba(56, 189, 248, 0.35);
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI PACS -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card pacs-hero-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="pacs-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/verif.png') }}" alt="Radiology PACS Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="pacs-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.45); color: #7dd3fc;">
                                    <i class="fas fa-radiation me-1"></i> TRANS MANAGEMENT SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Instalasi Radiologi</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color:white;">
                                Modul <span style="color: #38bdf8; text-decoration: underline;">PACS Server &amp; DICOM Viewer</span>
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Integrasi Server PACS Orthanc, Pencarian Studi, Arsip DICOM &amp; Tag Metadata</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="pacs-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-server text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">Radiologi : PACS Server</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN PACS CARD CONTAINER -->
<div class="pacs-card p-3 p-md-4 mb-4">
    <!-- FILTER HEADER FORM -->
    <div class="pacs-filter-box mb-3">
        <div class="row g-2 align-items-end pacs-filter-input">
            <div class="col-auto">
                <span class="pacs-filter-label text-center">Reset</span>
                <button type="button" class="btn btn-sm btn-outline-danger pacs-btn-reset d-flex align-items-center justify-content-center" id="clear-filter-btn" title="Bersihkan Semua Filter">
                    <i class="fa fa-xmark fs-2"></i>
                </button>
            </div>
            <div class="col-6 col-md-2 col-lg-1">
                <label class="pacs-filter-label">Birth Date</label>
                <input type="text" class="form-control filter-col" data-col="1" placeholder="YYYYMMDD...">
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <label class="pacs-filter-label">Patient Name</label>
                <input type="text" class="form-control filter-col" data-col="2" placeholder="Nama Pasien...">
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <label class="pacs-filter-label">Patient ID</label>
                <input type="text" class="form-control filter-col" data-col="3" placeholder="No. RM / ID...">
            </div>
            <div class="col-6 col-md-5 col-lg-2">
                <label class="pacs-filter-label">Study Description</label>
                <input type="text" class="form-control filter-col" data-col="4" placeholder="Deskripsi Studi...">
            </div>
            <div class="col-6 col-md-3 col-lg-1">
                <label class="pacs-filter-label">Study Date</label>
                <input type="text" class="form-control filter-col" data-col="5" placeholder="YYYYMMDD...">
            </div>
            <div class="col-6 col-md-3 col-lg-1">
                <label class="pacs-filter-label">Modalities</label>
                <select class="form-select filter-col" data-col="6">
                    <option value="">Semua</option>
                    <option value="CR">CR</option>
                    <option value="DX">DX</option>
                    <option value="CT">CT</option>
                    <option value="MR">MR</option>
                    <option value="US">US</option>
                </select>
            </div>
            <div class="col-12 col-md-4 col-lg-2">
                <label class="pacs-filter-label">Accession No.</label>
                <input type="text" class="form-control filter-col" data-col="7" placeholder="Accession Number...">
            </div>
        </div>
    </div>

    <!-- PACS ACTION BAR / TOOLBAR -->
    <div class="pacs-toolbar d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div class="d-flex align-items-center gap-1 flex-wrap">
            <div class="form-check my-0 me-1 ms-1">
                <input class="form-check-input" type="checkbox" id="check-all-pacs" style="cursor: pointer;">
            </div>
            <button type="button" class="pacs-btn-icon btn-toolbar-view" data-layout="1x1" title="Buka DICOM Viewer"><i class="fas fa-eye"></i></button>
            <button type="button" class="pacs-btn-icon btn-toolbar-view" data-layout="2x2" title="Grid 2x2"><i class="fas fa-table-cells-large"></i></button>
            <button type="button" class="pacs-btn-icon btn-toolbar-view" data-layout="1x2" title="Layout 2 Columns"><i class="fas fa-columns"></i></button>
            <button type="button" class="pacs-btn-icon btn-toolbar-view" data-layout="3x3" title="Grid 3x3"><i class="fas fa-border-all"></i></button>
            <button type="button" class="pacs-btn-icon" id="btn-toolbar-download" title="Download DICOM Archive (.zip)"><i class="fas fa-download"></i></button>
            <button type="button" class="pacs-btn-icon" id="btn-toolbar-tags" title="Lihat Metadata DICOM"><i class="fas fa-tag"></i></button>
            <span class="ms-2 small fw-semibold" id="selected-pacs-counter" style="color: #94a3b8;">0 dipilih</span>
        </div>
        <div>
            <span class="pacs-badge" style="background: rgba(56, 189, 248, 0.16); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); padding: 6px 12px;">
                <i class="fa-solid fa-circle-info me-1"></i> Displaying {{ count($studiesList) }} PACS studies
            </span>
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="table-responsive">
        <table class="table table-hover pacs-table align-middle mb-0" id="pacsTable">
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">Pilih</th>
                    <th style="width: 11%;">Birth Date</th>
                    <th style="width: 19%;">Patient Name</th>
                    <th style="width: 13%;">Patient ID</th>
                    <th style="width: 19%;">Study Description</th>
                    <th style="width: 10%;">Study Date</th>
                    <th style="width: 8%;">Modality</th>
                    <th style="width: 12%;">Accession No.</th>
                    <th class="text-center" style="width: 7%;">Ser/Inst</th>
                    <th class="text-center" style="width: 7%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studiesList as $index => $study)
                <tr>
                    <td class="text-center">
                        <input class="form-check-input item-check" type="checkbox"
                            data-uid="{{ $study['study_instance_uid'] ?? '' }}"
                            data-orthanc-id="{{ $study['orthanc_study_id'] }}"
                            data-viewer-url="{{ $study['viewer_url'] }}"
                            style="cursor: pointer;">
                    </td>
                    <td>
                        <a href="{{ $study['viewer_url'] }}" class="text-info me-1" title="Buka DICOM Viewer">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <span class="mono-code opacity-75">{{ $study['patient_birth_date'] ?? '-' }}</span>
                    </td>
                    <td class="fw-bold">
                        <a href="{{ $study['viewer_url'] }}" class="text-decoration-none">
                            {{ $study['patient_name'] ?? 'Anonim' }}
                        </a>
                    </td>
                    <td class="mono-code opacity-75">
                        {{ $study['patient_id'] }}
                    </td>
                    <td>
                        {{ $study['study_description'] ?? '-' }}
                    </td>
                    <td class="mono-code opacity-75">
                        {{ $study['study_date'] ?? '-' }}
                    </td>
                    <td>
                        <span class="modality-badge">{{ $study['modality'] ?? '-' }}</span>
                    </td>
                    <td class="mono-code opacity-75">
                        {{ $study['accession_number'] ?? '-' }}
                    </td>
                    <td class="text-center fw-semibold">
                        <span class="badge rounded-pill px-2 py-1" style="background: rgba(79, 70, 229, 0.1); color: inherit; border: 1px solid var(--pacs-grid-border);">
                            {{ $study['series_count'] ?? '1' }}/{{ $study['instances_count'] ?? '1' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ $study['viewer_url'] }}"
                                class="btn btn-sm btn-outline-info rounded-3 px-2 py-1"
                                title="Buka DICOM Viewer">
                                <i class="fas fa-x-ray"></i>
                            </a>
                            <a href="{{ url('/pacs-proxy/studies/' . $study['orthanc_study_id'] . '/archive') }}"
                                class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1"
                                title="Download ZIP DICOM">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col-lg-8 ps-lg-2">
    <span id="menu-detail-handling"></span>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $('#pacsTable').DataTable({
            responsive: true,
            dom: 'rtip',
            pageLength: 10,
            ordering: false,
            language: {
                emptyTable: `
                    <div class="text-center py-5 opacity-75">
                        <i class="fa-solid fa-folder-open fa-3x mb-3"></i>
                        <h6 class="fw-bold mb-1">Tidak ada data ditemukan</h6>
                        <p class="mb-0 small">Pemeriksaan belum tersedia pada server PACS Orthanc.</p>
                    </div>
                `,
                zeroRecords: "Tidak ada data pemeriksaan yang cocok dengan filter pencarian."
            }
        });

        function updateSelectedCounter() {
            var count = $('.item-check:checked').length;
            $('#selected-pacs-counter').text(count + ' dipilih');
        }

        // Event listener pencarian per kolom
        $('.filter-col').on('keyup change', function() {
            var colIndex = $(this).data('col');
            table.column(colIndex).search(this.value).draw();
        });

        // Clear Filter Button
        $('#clear-filter-btn').on('click', function() {
            $('.filter-col').val('');
            table.columns().search('').draw();
        });

        // Check All Checkbox
        $('#check-all-pacs').on('click', function() {
            $('.item-check').prop('checked', this.checked);
            updateSelectedCounter();
        });

        $(document).on('change', '.item-check', function() {
            var total = $('.item-check').length;
            var checkedCount = $('.item-check:checked').length;
            $('#check-all-pacs').prop('checked', total > 0 && total === checkedCount);
            updateSelectedCounter();
        });

        // Toolbar: Buka Viewer dari item yang dicentang
        $('.btn-toolbar-view').on('click', function() {
            var checked = $('.item-check:checked');
            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Pemeriksaan',
                    text: 'Centang minimal satu studi pasien terlebih dahulu untuk membuka viewer.'
                });
                return;
            }
            var layout = $(this).data('layout');
            var targetUrl = checked.first().data('viewer-url') + '?layout=' + layout;
            window.location.href = targetUrl;
        });

        // Toolbar: Download ZIP DICOM dari item yang dicentang
        $('#btn-toolbar-download').on('click', function() {
            var checked = $('.item-check:checked');
            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Pemeriksaan',
                    text: 'Centang studi yang ingin diunduh arsip DICOM-nya.'
                });
                return;
            }
            var orthancId = checked.first().data('orthanc-id');
            window.location.href = "{{ url('/pacs-proxy/studies') }}/" + orthancId + "/archive";
        });

        // Toolbar: Lihat JSON Tags DICOM dari Orthanc Proxy
        $('#btn-toolbar-tags').on('click', function() {
            var checked = $('.item-check:checked');
            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Pemeriksaan',
                    text: 'Centang satu studi untuk melihat tag metadata DICOM.'
                });
                return;
            }
            var orthancId = checked.first().data('orthanc-id');
            window.open("{{ url('/pacs-proxy/studies') }}/" + orthancId + "/shared-tags?simplify", "_blank");
        });
    });
</script>
@endsection
