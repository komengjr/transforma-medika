@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Styling khusus menyerupai Orthanc UI */
    .pacs-container {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 4px;
        font-family: Arial, sans-serif;
    }

    .pacs-filter-row th {
        font-weight: 700;
        font-size: 0.85rem;
        color: #000;
        background-color: #f8f9fa !important;
        border-bottom: none !important;
        padding-bottom: 2px !important;
    }

    .pacs-filter-input input,
    .pacs-filter-input select {
        font-size: 0.85rem;
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 4px 8px;
        height: 32px;
    }

    .pacs-toolbar {
        background-color: #d8dcde;
        padding: 6px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .pacs-btn-icon {
        background-color: #868e96;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    .pacs-btn-icon:hover {
        background-color: #6c757d;
        color: #fff;
    }

    .pacs-table {
        background-color: #fff;
        font-size: 0.9rem;
    }

    .pacs-table td {
        vertical-align: middle;
        padding: 8px;
    }
</style>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/verif.png') }}" alt="" width="80" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-primary fw-bold mb-1">Trans <span class="text-primary fw-medium">Management System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block " src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                    <h4 class="text-primary fw-bold mb-0">Radiologi <span class="text-primary fw-medium">PACS Server</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main PACS Card -->
<div class="card  border-1 pacs-container">
    <div class="card-body p-2">

        <!-- Filter Header Form -->
        <div class="table-responsive">
            <table class="table table-borderless mb-2">
                <thead>
                    <tr class="pacs-filter-row">
                        <th style="width: 40px;"></th>
                        <th style="width: 12%;">Patient Birth Date</th>
                        <th style="width: 18%;">Patient Name</th>
                        <th style="width: 14%;">Patient ID</th>
                        <th style="width: 20%;">Study Description</th>
                        <th style="width: 10%;">Study Date</th>
                        <th style="width: 10%;">Modalities in Study</th>
                        <th style="width: 12%;">Accession Number</th>
                    </tr>
                    <tr class="pacs-filter-input">
                        <td class="align-middle text-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary p-0 px-1" id="clear-filter-btn" title="Clear Filters">
                                <i class="fa-regular fa-circle-xmark fs-5"></i>
                            </button>
                        </td>
                        <td><input type="text" class="form-control filter-col" data-col="1" placeholder=""></td>
                        <td><input type="text" class="form-control filter-col" data-col="2" placeholder="John^Doe"></td>
                        <td><input type="text" class="form-control filter-col" data-col="3" placeholder="1234"></td>
                        <td><input type="text" class="form-control filter-col" data-col="4" placeholder="Chest"></td>
                        <td><input type="text" class="form-control filter-col" data-col="5" placeholder=""></td>
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
                        <td><input type="text" class="form-control filter-col" data-col="7" placeholder="1234"></td>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- PACS Action Bar / Toolbar -->
        <div class="pacs-toolbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-1">
                <input class="form-check-input mt-0 me-2" type="checkbox" id="check-all-pacs">
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
                <span class="badge bg-warning text-dark px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Displaying most recent studies
                </span>
            </div>
        </div>

        <!-- Data Table -->
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studiesList as $index => $study)
                    <tr>
                        <td class="text-center" style="width: 40px;">
                            <input class="form-check-input item-check" type="checkbox">
                        </td>
                        <td style="width: 10%;">
                            <a href="{{ route('pacs_server_studies_show', $study['orthanc_study_id']) }}" target="_blank" class="text-dark me-1">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            {{ $study['patient_birth_date'] ?? '-' }}
                        </td>
                        <td style="width: 20%;" class="fw-semibold">
                            {{ $study['patient_name'] ?? 'anon' }}
                        </td>
                        <td style="width: 14%;">
                            {{ $study['patient_id'] }}
                        </td>
                        <td style="width: 20%;">
                            {{ $study['study_description'] ?? '-' }}
                        </td>
                        <td style="width: 10%;">
                            @if(isset($study['study_date']) && $study['study_date'] !== 'N/A' && strlen($study['study_date']) === 8)
                            {{ $study['study_date'] }}
                            @else
                            {{ $study['study_date'] ?? '-' }}
                            @endif
                        </td>
                        <td style="width: 8%;">
                            <span class="fw-bold text-uppercase">{{ $study['modality'] ?? '-' }}</span>
                        </td>
                        <td style="width: 12%;">
                            {{ $study['accession_number'] ?? '-' }}
                        </td>
                        <td style="width: 6%;" class="text-center fw-semibold">
                            {{ $study['series_count'] ?? '1' }}/{{ $study['instances_count'] ?? '1' }}
                        </td>
                        <td>
                            <a href="{{ route('pacs_server_studies_show', $study['orthanc_study_id']) }}"
                                target="_blank"
                                class="pacs-btn-icon text-decoration-none d-inline-block"
                                title="Buka Preview DICOM">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-folder-open fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada data pemeriksaan ditemukan di server PACS Orthanc.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
            dom: 'rtip', // Hilangkan search bar bawaan DataTables karena kita sudah punya custom filter di atas
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
