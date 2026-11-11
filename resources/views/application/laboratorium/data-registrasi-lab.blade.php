@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        /* background-color: #ffffff; */
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Inputs, Selects & Floating Filters */
    .filter-bar-container {
        background-color: #ffffff;
        border: var(--retro-border);
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: var(--retro-shadow-sm);
    }

    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 2px;
        left: 8px;
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--retro-dark);
        pointer-events: none;
        z-index: 5;
        background: transparent;
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
        font-size: 0.8rem !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Tabel Custom Retro */
    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 3px solid var(--retro-dark);
        padding: 12px 10px;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        transition: background 0.2s;
    }

    .table-custom tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }

    /* Select2 Retro Styling */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 42px !important;
        padding-top: 14px !important;
        padding-bottom: 2px !important;
        padding-left: 6px !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        border: 2px solid var(--retro-dark) !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        padding-left: 4px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }

    /* Modal Styling */
    .retro-modal-content {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: #ffffff;
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER RETRO -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 shadow-sm me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-shield-alt me-1"></i> v2.4 Medical Suite
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-file-alt me-1 text-primary"></i> Data Registrasi Laboratorium
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="retro-card mb-4">
    <!-- CARD HEADER TOOLBAR & FILTER -->
    <div class="card-header bg-white border-bottom border-dark py-3 px-3">
        <div class="row align-items-center g-2">

            <!-- TOMBOL UTAMA (Refresh & Mobile Toggle) -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm retro-btn retro-btn-primary px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" id="btn-refresh-lab" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-bold ms-1">Refresh Data</span>
                </button>

                <button class="btn btn-sm retro-btn retro-btn-warning px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter"></i>
                    <span class="fw-bold">Filter</span>
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
                            <input type="text" class="form-control datetimepicker retro-input" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker retro-input" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama</label>
                            <input type="text" class="form-control retro-input" id="filter_search" placeholder="Cari Reg/Nama...">
                        </div>
                    </div>

                    <!-- Filter Dokter -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter</label>
                            <select class="form-select retro-input" id="filter_dokter">
                                <option value="">Semua Dokter</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Kel. Pelanggan / Penjamin -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select retro-input" id="filter_penjamin">
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
                            <select class="form-select retro-input" id="filter_pemeriksaan">
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
            <table id="example" class="table table-custom align-middle mb-0" style="width:100%; border: 2px solid var(--retro-dark);">
                <thead>
                    <tr>
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
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-lab" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content retro-modal-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle bg-light d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark);"></button>
            </div>
            <div id="menu-lab" class="p-3"></div>
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
    let labTable;

    $(document).ready(function() {
        // Inisialisasi Select2 untuk Filter dengan Tema Bootstrap 5
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Load opsi filter pertama kali
        loadFilterOptions();

        // Inisialisasi DataTable Server-Side
        labTable = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_lab_table') }}",
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
                    className: 'text-center align-middle',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_registrasi',
                    className: 'align-middle',
                    orderable: false
                },
                {
                    data: 'nama_pasien',
                    className: 'align-middle',
                    orderable: false
                },
                {
                    data: 'tanggal_reg',
                    className: 'align-middle text-nowrap',
                    orderable: false
                },
                {
                    data: 'rujukan',
                    className: 'align-middle',
                    orderable: false
                },
                {
                    data: 'pemeriksaan',
                    className: 'align-middle',
                    orderable: false
                },
                {
                    data: 'status',
                    className: 'text-center align-middle',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    className: 'text-center align-middle',
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
                    <div class="custom-loader py-3 text-center">
                        <div class="spinner-border text-dark mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-bold text-dark small d-block">Memuat data laboratorium...</span>
                    </div>
                `
            },
            pageLength: 10
        });

        // Trigger pencarian ulang jika input filter diubah
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            loadFilterOptions();
            labTable.ajax.reload();
        });

        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            labTable.ajax.reload();
        });

        $('#filter_search').on('keyup', function() {
            labTable.ajax.reload();
        });

        // Tombol Refresh Data
        $('#btn-refresh-lab').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');
            $('#filter_dokter').val('').trigger('change.select2');
            $('#filter_penjamin').val('').trigger('change.select2');
            $('#filter_pemeriksaan').val('').trigger('change.select2');
            loadFilterOptions();
            labTable.ajax.reload();
        });
    });

    // Fungsi Mengambil Opsi Filter Dinamis
    function loadFilterOptions() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();

        fetch(`/pelayanan/get-filter-options?tgl1=${tglAwal}&tgl2=${tglAkhir}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const $dokter = $('#filter_dokter'),
                        selectedDokter = $dokter.val();
                    $dokter.empty().append('<option value="">Semua Dokter</option>');
                    data.dokter.forEach(d => $dokter.append(new Option(d, d, false, d === selectedDokter)));
                    $dokter.trigger('change.select2');

                    const $penjamin = $('#filter_penjamin'),
                        selectedPenjamin = $penjamin.val();
                    $penjamin.empty().append('<option value="">Semua Kelompok</option>');
                    data.penjamin.forEach(p => $penjamin.append(new Option(p, p, false, p === selectedPenjamin)));
                    $penjamin.trigger('change.select2');

                    const $pemeriksaan = $('#filter_pemeriksaan'),
                        selectedPemeriksaan = $pemeriksaan.val();
                    $pemeriksaan.empty().append('<option value="">Semua Pemeriksaan</option>');
                    data.pemeriksaan.forEach(item => $pemeriksaan.append(new Option(item.nama_layanan, item.id, false, item.id == selectedPemeriksaan)));
                    $pemeriksaan.trigger('change.select2');
                }
            }).catch(err => console.error("Gagal memuat opsi filter:", err));
    }

    // Event Delegasi Handler untuk tombol aksi handling lab
    $(document).on("click", ".button-proses-handling-lab", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-lab').html(`
            <div class="custom-loader py-5 text-center">
                <div class="spinner-border text-dark mb-2" role="status" style="width: 3rem; height: 3rem; border-width: 4px;"></div>
                <p class="text-dark mt-3 mb-0 fw-bolder">Memuat data pemeriksaan...</p>
            </div>
        `);

        $.ajax({
            url: "{{ route('data_registrasi_lab_handling') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-lab').html(data);
        }).fail(function() {
            $('#menu-lab').html('<div class="alert alert-danger m-4 fw-bold border-dark shadow-sm" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data. Silakan coba lagi.</div>');
        });
    });
</script>
@endsection
