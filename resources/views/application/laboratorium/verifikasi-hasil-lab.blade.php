@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Styling Hover Baris Tabel */
    .table-hover-clickable tbody tr {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .table-hover-clickable tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
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
                        <div class="p-2 bg-opacity-1 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
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
                                <i class="fas fa-file-signature me-1"></i> Verifikasi Hasil
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- MAIN CARD DATA TABLE -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
    <!-- TOOLBAR HEADER -->
    <div class="card-header bg-dark py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light rounded-pill" onclick="location.reload()" data-bs-toggle="tooltip" title="Refresh Data">
                <span class="fas fa-sync-alt me-1"></span> Refresh
            </button>
            <div class="vr h-50 my-auto text-300"></div>
            <span class="fs--1 text-white fw-semibold">Daftar Pasien Verifikasi</span>
        </div>

        <!-- DATE RANGE FILTER -->
        <div class="d-flex align-items-center gap-2">
            <i class="far fa-calendar-alt text-primary fs-0"></i>
            <input class="form-control form-control-sm datetimepicker" id="timepicker3" type="text" placeholder="Filter Tanggal (d/m/y to d/m/y)" style="min-width: 230px;" data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
        </div>
    </div>

    <!-- TABLE BODY -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-hover table-striped table-hover-clickable align-middle w-100 mb-0 fs--1">
                <thead class="bg-200 text-800" style="background-color: #0f5aa4 !important;
        color: #ffffff !important;">
                    <tr>
                        <th class="py-2 px-3 text-center" style="width: 50px;">No</th>
                        <th class="py-2 px-3">No. Registrasi</th>
                        <th class="py-2 px-3">Nama Pasien</th>
                        <th class="py-2 px-3">Tanggal Reg</th>
                        <th class="py-2 px-3">Dokter Rujukan</th>
                        <th class="py-2 px-3">Daftar Pemeriksaan</th>
                        <th class="py-2 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr class="btn-verifikasi-row"
                        data-code="{{ $datas->d_reg_order_code }}"
                        data-reg="{{ $datas->d_reg_order_lab_code }}"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-lab-full">

                        <td class="text-center fw-semibold text-600 py-3">{{ $no++ }}</td>

                        <td class="py-3">
                            <span class="badge bg-primary bg-opacity-10 text-white px-2 py-1 fw-bold fs--2">
                                <i class="fas fa-hashtag me-1"></i>{{ $datas->d_reg_order_code }}
                            </span>
                        </td>

                        <td class="py-3">
                            <div class="fw-bold text-dark fs-0">{{ $datas->master_patient_name }}</div>
                        </td>

                        <td class="py-3 text-nowrap text-secondary">
                            <i class="far fa-clock me-1 text-400"></i>{{ date('d-m-Y H:i', strtotime($datas->d_reg_order_date)) }}
                        </td>

                        <td class="py-3">
                            <div class="d-flex align-items-center gap-1 text-800">
                                <i class="fas fa-user-md text-info me-1"></i>
                                <span>{{ $datas->master_doctor_name ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="py-3">
                            @php
                            $pem = DB::table('d_reg_order_lab_list')
                            ->join('p_sales_data','p_sales_data.p_sales_data_code','=','d_reg_order_lab_list.p_sales_data_code')
                            ->join('t_pemeriksaan_list','t_pemeriksaan_list.t_pemeriksaan_list_code','=','p_sales_data.t_pemeriksaan_list_code')
                            ->where('d_reg_order_lab_code',$datas->d_reg_order_lab_code)->get();
                            @endphp
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($pem as $pems)
                                <span class="badge bg-100 text-700 border border-300 rounded-pill fw-normal fs--2">
                                    {{ $pems->t_pemeriksaan_list_name }}
                                </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="py-3 text-center">
                            @if ($datas->d_reg_order_lab_status == 0)
                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-white border border-danger-subtle px-3 py-1">
                                <i class="fas fa-times-circle me-1"></i>Belum
                            </span>
                            @elseif ($datas->d_reg_order_lab_status == 1)
                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-white border border-warning-subtle px-3 py-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Proses
                            </span>
                            @elseif ($datas->d_reg_order_lab_status == 2)
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-white border border-success-subtle px-3 py-1">
                                <i class="fas fa-check-circle me-1"></i>Selesai
                            </span>
                            @endif
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
<!-- MODAL DETAIL LAB FULL -->
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-lab-full"></div>
        </div>
    </div>
</div>

<!-- MODAL POLIKLINIK -->
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari nomor reg, pasien, dll..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

    // OPEN DETAIL MODAL VERIFIKASI HASIL
    $(document).on("click", ".btn-verifikasi-row", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        $('#menu-lab-full').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p class="text-muted fs--1">Memuat data pemeriksaan...</p></div>'
        );

        $.ajax({
            url: "{{ route('verifikasi_laboratorium_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-lab-full').html(data);
        }).fail(function() {
            $('#menu-lab-full').html('<div class="alert alert-danger m-3" role="alert">Gagal memuat data spesimen/pemeriksaan.</div>');
        });
    });

    // ACTION VERIFIKASI HASIL LAB
    $(document).on("click", "#button-verifikasi-hasil-lab", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        Swal.fire({
            title: "Konfirmasi Verifikasi?",
            text: "Apakah Anda yakin ingin memverifikasi hasil laboratorium ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#22c55e",
            cancelButtonColor: "#ef4444",
            confirmButtonText: "Ya, Verifikasi!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#menu-verifikasi-hasil').html(
                    '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"></div></div>'
                );
                $.ajax({
                    url: "{{ route('verifikasi_laboratorium_verifikasi_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "reg": reg,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    Swal.fire({
                        title: "Terverifikasi!",
                        text: "Laporan hasil laboratorium telah berhasil diverifikasi.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#menu-verifikasi-hasil').html(data);
                    location.reload();
                }).fail(function() {
                    $('#menu-verifikasi-hasil').html('<div class="alert alert-danger m-2">Gagal melakukan verifikasi data.</div>');
                });
            }
        });
    });

    // PREVIEW REPORT PDF
    $(document).on("click", "#button-verifikasi-preview-report", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        $('#view-map').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="text-muted fs--1 mt-2">Menyiapkan pratinjau dokumen...</p></div>'
        );

        $.ajax({
            url: "{{ route('verifikasi_laboratorium_preview_report') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#button-verifikasi-hasil-lab').show();
            $('#view-map').html(
                '<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:550px;" frameborder="0" class="rounded-3 shadow-sm border"></iframe>'
            );
        }).fail(function() {
            $('#view-map').html('<div class="alert alert-danger m-3">Gagal memuat pratinjau laporan.</div>');
        });
    });
</script>
@endsection
