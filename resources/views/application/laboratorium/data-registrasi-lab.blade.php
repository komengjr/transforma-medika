@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    /* Custom Styling for Modern Lab UI */
    .page-header-card {
        background: linear-gradient(135deg, #1a5bb8 0%, #0d3b7a 100%);
        border: none;
        color: #ffffff;
    }

    .table-custom thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        background-color: #0f5aa4 !important;
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
</style>
@endsection

@section('content')
<!-- BREADCRUMB & HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <!-- Hiasan Blur Glowing Circle -->
            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-10 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1 text-info"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <!-- <span class="text-white-50 text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Module Aktif</span> -->
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <!-- <span class="p-1 bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></span> -->
                            <h6 class="text-primary fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-file-alt me-1"></i> Data Registrasi Laboratorium
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
    <!-- CARD HEADER TOOLBAR -->
    <div class="card-header bg-dark py-3 border-bottom border-100">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-auto d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-light rounded-pill" onclick="location.reload()" data-bs-toggle="tooltip" title="Refresh Data">
                    <span class="fas fa-sync-alt me-1"></span> Refresh
                </button>
                <div class="vr h-100 mx-1 opacity-25"></div>
                <span class="text-light fs--1 fw-semi-bold">Filter Tanggal:</span>
            </div>
            <div class="col-auto d-flex align-items-center gap-2">
                <div class="position-relative" style="min-width: 230px;">
                    <input class="form-control form-control-sm datetimepicker ps-4" id="timepicker3" type="text" placeholder="Pilih Rentang Tanggal..."
                        data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                    <span class="fas fa-calendar-alt position-absolute top-50 start-0 translate-middle-y ms-2 text-400 fs--1"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD BODY / TABLE -->
    <div class="card-body p-0">
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
                <tbody class="fs--1">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td class="text-center fw-bold text-secondary">{{ $no++ }}</td>

                        <!-- No Reg & Lab Code -->
                        <td>
                            <div class="d-flex flex-column">
                                <span class="code-block text-primary">{{ $datas->d_reg_order_code }}</span>
                                <span class="code-block text-muted fs--2"><i class="fas fa-barcode me-1"></i>{{ $datas->d_reg_order_lab_code }}</span>
                            </div>
                        </td>

                        <!-- Pasien Name -->
                        <td>
                            <div class="fw-bold text-dark">{{ $datas->master_patient_name }}</div>
                        </td>

                        <!-- Tanggal -->
                        <td class="text-nowrap text-secondary">
                            <i class="far fa-clock me-1 opacity-50"></i>{{ $datas->d_reg_order_date }}
                        </td>

                        <!-- Rujukan -->
                        <td>
                            <span class="text-dark fw-medium">{{ $datas->master_doctor_name ?? '-' }}</span>
                        </td>

                        <!-- Items Pemeriksaan -->
                        <td>
                            @php
                            $pem = DB::table('d_reg_order_lab_list')
                            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
                            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                            ->where('d_reg_order_lab_code', $datas->d_reg_order_lab_code)->get();
                            @endphp
                            <div class="d-flex flex-wrap gap-1">
                                @forelse ($pem as $pems)
                                <span class="list-pemeriksaan-tag">
                                    <i class="fas fa-flask me-1 text-primary fs--2"></i>{{ $pems->t_pemeriksaan_list_name }}
                                </span>
                                @empty
                                <span class="text-muted fst-italic fs--2">Tidak ada data</span>
                                @endforelse
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td class="text-center">
                            @if ($datas->d_reg_order_lab_status == 0)
                            <span class="badge badge-soft-danger px-2 py-1 rounded-pill"><i class="fas fa-exclamation-circle me-1"></i>Belum</span>
                            @elseif ($datas->d_reg_order_lab_status == 1)
                            <span class="badge badge-soft-warning px-2 py-1 rounded-pill"><i class="fas fa-spinner fa-spin me-1"></i>Proses</span>
                            @elseif ($datas->d_reg_order_lab_status == 2)
                            <span class="badge badge-soft-info px-2 py-1 rounded-pill"><i class="fas fa-hand-holding-medical me-1"></i>Handling</span>
                            @elseif ($datas->d_reg_order_lab_status == 3)
                            <span class="badge badge-soft-success px-2 py-1 rounded-pill"><i class="fas fa-check-circle me-1"></i>Verifikasi</span>
                            @elseif ($datas->d_reg_order_lab_status == 4)
                            <span class="badge badge-soft-primary px-2 py-1 rounded-pill"><i class="fas fa-award me-1"></i>Selesai</span>
                            @endif
                        </td>

                        <!-- Action Dropdown -->
                        <td class="text-center">
                            <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-{{ $datas->d_reg_order_lab_code }}" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-ellipsis-h fs--1"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="order-dropdown-{{ $datas->d_reg_order_lab_code }}">
                                    @if ($datas->d_reg_order_lab_status == 0)
                                    <a class="dropdown-item text-warning fw-medium" href="#" data-bs-toggle="modal" data-bs-target="#modal-lab" id="button-proses-handling-lab" data-code="{{ $datas->d_reg_order_lab_code }}">
                                        <i class="fas fa-dna me-2"></i>Proses Handling Pasien
                                    </a>
                                    @elseif ($datas->d_reg_order_lab_status == 1)
                                    <a class="dropdown-item text-secondary fw-medium" href="#" data-bs-toggle="modal" data-bs-target="#modal-cabang" id="button-data-barang-cabang" data-code="123">
                                        <i class="far fa-folder-open me-2"></i>Riwayat / History
                                    </a>
                                    @else
                                    <span class="dropdown-item text-muted disabled"><i class="fas fa-lock me-2"></i>Tidak ada aksi</span>
                                    @endif
                                </div>
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
<!-- MODALS -->
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-lab-full" class="p-3"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lab" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
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

<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data pasien / registrasi..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

    // LOADING SPINNER HTML HELPER
    const loadingSpinner = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-3 mb-0 fw-medium">Memuat data pemeriksaan...</p>
            </div>
        `;

    $(document).on("click", "#button-proses-handling-lab", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-lab').html(loadingSpinner);

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
            $('#menu-lab').html('<div class="alert alert-danger m-4" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data. Silakan coba lagi.</div>');
        });
    });

    $(document).on("click", "#button-handling-pasien-lab", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-handling-pasien-lab').html(loadingSpinner);

        $.ajax({
            url: "{{ route('data_registrasi_lab_handling_proses') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-pasien-lab').html(data);
            setTimeout(() => {
                location.reload();
            }, 300);
        }).fail(function() {
            $('#menu-handling-pasien-lab').html('<div class="alert alert-danger m-4" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan sistem.</div>');
        });
    });
</script>
@endsection
