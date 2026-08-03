@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* ==========================================
     * RADIOLOGY & PACS SERVER CUSTOM THEME
     * ========================================== */
    :root {
        --rad-dark-bg: #0f172a;
        --rad-card-bg: #1e293b;
        --rad-accent-cyan: #38bdf8;
        --rad-glow-cyan: rgba(56, 189, 248, 0.35);
    }

    /* Hero Header Radiologi PACS */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-radius: 14px;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.35);
        position: relative;
        overflow: hidden;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -30px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, var(--rad-glow-cyan) 0%, transparent 75%);
        pointer-events: none;
    }

    /* Main Container Card */
    .pacs-container-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    /* Filter Header Styling */
    .pacs-filter-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
    }

    .pacs-filter-row th {
        font-weight: 700;
        font-size: 0.78rem;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background-color: transparent !important;
        border-bottom: none !important;
        padding-bottom: 6px !important;
    }

    .pacs-filter-input input,
    .pacs-filter-input select {
        font-size: 0.85rem;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        padding: 4px 8px;
        height: 34px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .pacs-filter-input input:focus,
    .pacs-filter-input select:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 0.2rem rgba(2, 132, 199, 0.15);
    }

    /* PACS Action Toolbar */
    .pacs-toolbar {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        padding: 8px 14px;
        border-radius: 8px;
        border-left: 4px solid #38bdf8;
    }

    .pacs-btn-icon {
        background-color: rgba(255, 255, 255, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .pacs-btn-icon:hover {
        background-color: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 2px 8px rgba(56, 189, 248, 0.3);
    }

    /* Table Styling */
    .pacs-table {
        font-size: 0.875rem;
    }

    .pacs-table tbody tr {
        transition: background-color 0.15s ease-in-out;
    }

    .pacs-table tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .pacs-table td {
        vertical-align: middle;
        padding: 10px 8px;
        border-color: #f1f5f9;
    }

    /* Modality Badge */
    .modality-badge {
        background-color: rgba(2, 132, 199, 0.1);
        color: #0284c7;
        border: 1px solid rgba(2, 132, 199, 0.25);
        border-radius: 6px;
        padding: 3px 8px;
        font-weight: 700;
        font-size: 0.75rem;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI PACS -->
<div class="row mb-3">
    <div class="col-12">
        <div class="rad-hero-header p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3 border border-white-50 d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px; backdrop-filter: blur(8px);">
                        <img src="{{ asset('img/verif.png') }}" alt="Radiology PACS Logo" class="img-fluid" width="40" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem; color: #38bdf8;">
                                <i class="fas fa-radiation me-1"></i> TRANS MANAGEMENT SYSTEM
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.3rem;">
                            Welcome to <span style="color: #38bdf8;">Management System</span>
                        </h4>
                        <p class="text-white-50 mb-0 small" style="font-size: 0.75rem;">Modul Integrasi Server PACS Orthanc & DICOM Viewer</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 border border-info border-opacity-30 px-3 py-2 rounded-pill backdrop-blur">
                        <span class="text-info fw-bold mb-0" style="font-size: 0.9rem; color: #38bdf8 !important;">
                            <i class="fas fa-server me-2"></i>Radiologi : PACS Server
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN PACS CARD CONTAINER -->
<div class="pacs-container-card p-3 mb-4">
    <!-- FILTER HEADER FORM -->
    <div class="pacs-filter-box mb-3">
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr class="pacs-filter-row">
                        <th style="width: 40px;" class="text-center">Reset</th>
                        <th style="width: 12%;">Patient Birth Date</th>
                        <th style="width: 18%;">Patient Name</th>
                        <th style="width: 14%;">Patient ID</th>
                        <th style="width: 20%;">Study Description</th>
                        <th style="width: 10%;">Study Date</th>
                        <th style="width: 12%;">Modalities</th>
                        <th style="width: 14%;">Accession Number</th>
                    </tr>
                    <tr class="pacs-filter-input">
                        <td class="align-middle text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger p-0 px-2 h-100" id="clear-filter-btn" title="Clear Filters">
                                <i class="fa-regular fa-circle-xmark fs-6"></i>
                            </button>
                        </td>
                        <td><input type="text" class="form-control filter-col" data-col="1" placeholder="YYYYMMDD..."></td>
                        <td><input type="text" class="form-control filter-col" data-col="2" placeholder="Nama Pasien..."></td>
                        <td><input type="text" class="form-control filter-col" data-col="3" placeholder="No. RM / ID..."></td>
                        <td><input type="text" class="form-control filter-col" data-col="4" placeholder="Deskripsi Studi..."></td>
                        <td><input type="text" class="form-control filter-col" data-col="5" placeholder="YYYYMMDD..."></td>
                        <td>
                            <select class="form-select filter-col" data-col="6">
                                <option value="">Semua</option>
                                <option value="CR">CR</option>
                                <option value="DX">DX</option>
                                <option value="CT">CT</option>
                                <option value="MR">MR</option>
                                <option value="US">US</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control filter-col" data-col="7" placeholder="Accession No..."></td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- PACS ACTION BAR / TOOLBAR -->
    <div class="pacs-toolbar d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div class="d-flex align-items-center gap-1 flex-wrap">
            <div class="form-check my-0 me-2 ms-1">
                <input class="form-check-input" type="checkbox" id="check-all-pacs" style="cursor: pointer;">
            </div>
            <button class="pacs-btn-icon" title="View"><i class="fas fa-eye"></i></button>
            <button class="pacs-btn-icon" title="Grid 2x2"><i class="fas fa-table-cells-large"></i></button>
            <button class="pacs-btn-icon" title="Layout 2 Columns"><i class="fas fa-columns"></i></button>
            <button class="pacs-btn-icon" title="Grid 3x3"><i class="fas fa-border-all"></i></button>
            <button class="pacs-btn-icon" title="3D / Anonymize"><i class="fas fa-shapes"></i></button>
            <button class="pacs-btn-icon" title="Download DICOM"><i class="fas fa-download"></i></button>
            <button class="pacs-btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
            <button class="pacs-btn-icon" title="Tags"><i class="fas fa-tag"></i></button>
        </div>
        <div>
            <span class="badge bg-info bg-opacity-20 text-cyan border border-info border-opacity-25 px-3 py-2 fw-semibold" style="color: #38bdf8 !important;">
                <i class="fa-solid fa-circle-info me-1"></i> Displaying recent PACS studies
            </span>
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="table-responsive">
        <table class="table table-hover pacs-table align-middle mb-0" id="pacsTable">
            <thead class="d-none">
                <tr>
                    <th>Select</th>
                    <th>Birth Date</th>
                    <th>Patient Name</th>
                    <th>Patient ID</th>
                    <th>Study Description</th>
                    <th>Study Date</th>
                    <th>Modalities</th>
                    <th>Accession Number</th>
                    <th>Series/Inst</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($studiesList as $index => $study)
                <tr>
                    <td class="text-center" style="width: 40px;">
                        <input class="form-check-input item-check" type="checkbox">
                    </td>
                    <td style="width: 10%;">
                        <a href="{{ route('pacs_server_studies_show', $study['orthanc_study_id']) }}" target="_blank" class="text-info me-1" title="Lihat Studi">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <span class="text-muted small">{{ $study['patient_birth_date'] ?? '-' }}</span>
                    </td>
                    <td style="width: 20%;" class="fw-bold text-dark">
                        {{ $study['patient_name'] ?? 'Anonim' }}
                    </td>
                    <td style="width: 14%; font-family: monospace;" class="text-muted">
                        {{ $study['patient_id'] }}
                    </td>
                    <td style="width: 20%;">
                        {{ $study['study_description'] ?? '-' }}
                    </td>
                    <td style="width: 10%;" class="text-muted small">
                        @if(isset($study['study_date']) && $study['study_date'] !== 'N/A' && strlen($study['study_date']) === 8)
                        {{ $study['study_date'] }}
                        @else
                        {{ $study['study_date'] ?? '-' }}
                        @endif
                    </td>
                    <td style="width: 8%;">
                        <span class="modality-badge">{{ $study['modality'] ?? '-' }}</span>
                    </td>
                    <td style="width: 12%; font-family: monospace;" class="text-muted">
                        {{ $study['accession_number'] ?? '-' }}
                    </td>
                    <td style="width: 6%;" class="text-center fw-semibold text-secondary">
                        <span class="badge bg-light text-dark border">{{ $study['series_count'] ?? '1' }}/{{ $study['instances_count'] ?? '1' }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('pacs_server_studies_show', $study['orthanc_study_id']) }}"
                            target="_blank"
                            class="btn btn-xs btn-outline-info pacs-btn-icon d-inline-flex align-items-center justify-content-center"
                            title="Buka Preview DICOM">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-300"></i>
                        <h6 class="fw-bold text-dark mb-1">Tidak ada data ditemukan</h6>
                        <p class="mb-0 small">Pemeriksaan belum tersedia pada server PACS Orthanc.</p>
                    </td>
                </tr>
                @endforelse
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
        // Inisialisasi DataTables
        var table = $('#pacsTable').DataTable({
            responsive: true,
            dom: 'rtip', // Hilangkan search bar bawaan DataTables
            pageLength: 10,
            ordering: false
        });

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
        });
    });
</script>
@endsection
