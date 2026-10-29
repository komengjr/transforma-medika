@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .table-custom thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        background-color: #0369a1 !important;
        color: #ffffff !important;
        border-bottom: 2px solid #dee2e6;
    }

    .badge-soft-danger {
        background-color: #fde8e8;
        color: #e02424;
    }

    .badge-soft-warning {
        background-color: #fef3c7;
        color: #d97706;
    }

    .badge-soft-info {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .badge-soft-success {
        background-color: #def7ec;
        color: #03543f;
    }

    .badge-soft-primary {
        background-color: #e1effe;
        color: #1e429f;
    }

    .list-pemeriksaan-tag {
        display: inline-block;
        background-color: #f1f5f9;
        color: #334155;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin: 1px;
        font-weight: 500;
    }

    .code-block {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .custom-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 0;
    }

    /* Floating Field Filter Style */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 3px;
        left: 10px;
        font-size: 0.68rem;
        color: #6c757d;
        pointer-events: none;
        z-index: 5 !important;
        background: transparent !important;
    }

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        padding-top: 16px;
        padding-bottom: 4px;
        padding-left: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        height: 42px;
        border-color: #ced4da;
        border-radius: 6px;
    }

    /* Penyesuaian Select2 Floating Label */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 42px !important;
        padding-top: 14px !important;
        padding-bottom: 2px !important;
        padding-left: 6px !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #212529 !important;
        padding-left: 4px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 6px !important;
    }
</style>
@endsection

@section('content')
<!-- BREADCRUMB & HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0369a1 100%);">

            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-10 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/rad.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-info text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-radiation me-1"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <h6 class="text-info fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-radiation me-1"></i> Data Registrasi Radiologi
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="card shadow-sm border-0 mb-4">
    <!-- CARD HEADER TOOLBAR & FILTER -->
    <div class="card-header bg-white border-bottom border-light py-3 px-3 rounded-top-4">
        <div class="row align-items-center g-2">

            <!-- TOMBOL UTAMA (Refresh & Mobile Toggle) -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm btn-info text-white rounded-3 px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" id="btn-refresh-rad" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold ms-1">Refresh Data</span>
                </button>

                <button class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter text-info"></i>
                    <span class="fw-semibold">Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER -->
            <div class="col-12 col-md collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center mt-2 mt-md-0 pt-2 pt-md-0 border-top border-md-0">

                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama</label>
                            <input type="text" class="form-control" id="filter_search" placeholder="Cari Reg/Nama...">
                        </div>
                    </div>

                    <!-- Filter Dokter -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter</label>
                            <select class="form-select" id="filter_dokter">
                                <option value="">Semua Dokter</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Kel. Pelanggan / Penjamin -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select" id="filter_penjamin">
                                <option value="">Semua Kelompok</option>
                                <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                                <option value="UMUM">UMUM / PRIBADI</option>
                                <option value="ASURANSI">ASURANSI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Pemeriksaan -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Pemeriksaan</label>
                            <select class="form-select" id="filter_pemeriksaan">
                                <option value="">Semua Pemeriksaan</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- CARD BODY / TABLE -->
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="example" class="table table-hover table-custom align-middle mb-0" style="width:100%">
                <thead>
                    <tr class="bg-400">
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 18%;">No Registrasi</th>
                        <th style="width: 20%;">Nama Pasien</th>
                        <th style="width: 12%;">Tanggal Reg</th>
                        <th style="width: 15%;">Rujukan</th>
                        <th style="width: 18%;">Pemeriksaan</th>
                        <th class="text-center" style="width: 10%;">Status</th>
                        <th class="text-center" style="width: 8%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi" class="p-3"></div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let radTable;

    $(document).ready(function() {
        // Inisialisasi Select2 untuk Filter
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Inisialisasi DataTable Server-Side
        radTable = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_radiologi_table') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.tgl1 = $('#filter_tgl_awal').val();
                    d.tgl2 = $('#filter_tgl_akhir').val();
                    d.search_custom = $('#filter_search').val();
                    d.dokter = $('#filter_dokter').val();
                    d.penjamin = $('#filter_penjamin').val();
                    d.pemeriksaan = $('#filter_pemeriksaan').val();
                }
            },
            columns: [{
                    data: 'no',
                    className: 'text-center fw-bold text-secondary',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_registrasi',
                    orderable: false
                },
                {
                    data: 'nama_pasien',
                    orderable: false
                },
                {
                    data: 'tanggal_reg',
                    orderable: false,
                    className: 'text-nowrap'
                },
                {
                    data: 'rujukan',
                    orderable: false
                },
                {
                    data: 'pemeriksaan',
                    orderable: false
                },
                {
                    data: 'status',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `
                    <div class="custom-loader">
                        <div class="spinner-border text-info mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-bold text-info small">Memuat data radiologi...</span>
                    </div>
                `
            },
            pageLength: 10
        });

        // Trigger pencarian ulang jika input filter diubah
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            radTable.ajax.reload();
        });

        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            radTable.ajax.reload();
        });

        $('#filter_search').on('keyup', function() {
            radTable.ajax.reload();
        });

        // Tombol Refresh Data
        $('#btn-refresh-rad').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');
            $('#filter_dokter').val('').trigger('change.select2');
            $('#filter_penjamin').val('').trigger('change.select2');
            $('#filter_pemeriksaan').val('').trigger('change.select2');
            radTable.ajax.reload();
        });
    });

    // LOADING SPINNER HTML HELPER
    const loadingSpinner = `
        <div class="text-center py-5">
            <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-3 mb-0 fw-medium">Memuat data pemeriksaan...</p>
        </div>
    `;

    // Event Handler untuk Button Proses Handling Radiologi
    $(document).on("click", ".button-proses-handling-rad", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-radiologi').html(loadingSpinner);

        $.ajax({
            url: "{{ route('data_registrasi_radiologi_handling') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-radiologi').html(data);
        }).fail(function() {
            $('#menu-radiologi').html('<div class="alert alert-danger m-4" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data. Silakan coba lagi.</div>');
        });
    });
</script>
@endsection
