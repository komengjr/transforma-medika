@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    .table-radiologi th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        background-color: #f8f9fa;
        border: 1px solid #e3e6ed;
    }
</style>
@endsection

@section('content')
<!-- Header Card -->
 <div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #ae0303 0%, #623838 50%, #e70a0a 100%);">

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
                            <img src="{{ asset('img/rad.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1 text-info"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-warning fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <!-- <span class="text-white-50 text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Module Aktif</span> -->
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <!-- <span class="p-1 bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></span> -->
                            <h6 class="text-danger fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-file-alt me-1"></i> Data Registrasi Radiologi
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row mb-3">
    <div class="col-12">
        <div class="card bg-200 shadow-sm border border-danger">
            <div class="row gx-2 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center p-2">
                    <img class="ms-2 me-3" src="{{ asset('img/rad.png') }}" alt="Radiologi Logo" width="45" />
                    <div>
                        <h6 class="text-danger fs--1 mb-0">Welcome to </h6>
                        <h4 class="text-danger fw-bold mb-0">Trans <span class="text-warning fw-medium">Management System</span></h4>
                    </div>
                </div>
                <div class="col-xl-auto px-3 py-2 border-start-lg border-300">
                    <h6 class="text-danger fs--1 mb-0">Menu Utama:</h6>
                    <h4 class="text-danger fw-bold mb-0">Radiologi <span class="text-secondary fs-0 fw-normal">| Data Registrasi</span></h4>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Main Table Card -->
<div class="card mb-3 shadow-sm">
    <div class="card-header bg-danger text-white py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a class="btn btn-falcon-default btn-sm me-2" href="javascript:void(0)" onclick="location.reload();" data-bs-toggle="tooltip" title="Refresh Data">
                    <span class="fas fa-redo-alt text-primary"></span>
                </a>
                <span class="text-300 me-2">|</span>
                <span class="fw-semi-bold fs--1 text-white">List Antrean Registrasi Radiologi</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                    <input class="form-control datetimepicker ps-2" id="timepicker3" type="text" placeholder="Filter Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/Y","disableMobile":true,"locale":"en"}' />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-hover align-middle table-radiologi w-100">
                <thead class="bg-200 text-800">
                    <tr>
                        <th class="text-center" style="width: 40px;">No</th>
                        <th>Kode & User Reg</th>
                        <th>Nama Pasien</th>
                        <th>Kategori Pasien</th>
                        <th>Tanggal Reg</th>
                        <th>Dokter Rujukan</th>
                        <th class="text-center">Status Bayar</th>
                        <th class="text-center">Status Reg</th>
                        <th class="text-center" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    @php
                    // Catatan: Disarankan untuk memindahkan query ini ke Controller via JOIN
                    $user = DB::table('user_mains')
                    ->select('fullname')
                    ->where('userid', $datas->d_reg_order_rad_user)
                    ->first();

                    $pasien = DB::table('t_pasien_cat')
                    ->where('t_pasien_cat_code', $datas->t_pasien_cat_code)
                    ->first();

                    $dokter = DB::table('master_doctor')
                    ->where('master_doctor_code', $datas->d_reg_order_rad_dr_rujukan)
                    ->first();

                    $payment = DB::table('d_reg_order_payment')
                    ->where('d_reg_order_list_code', $datas->d_reg_order_rad_code)
                    ->first();
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $no++ }}</td>
                        <td>
                            <div class="mb-1">
                                <span class="code-chip text-dark fs--2">{{ $datas->d_reg_order_code }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="code-chip text-danger fs--2 fw-bold">{{ $datas->d_reg_order_rad_code }}</span>
                            </div>
                            <div>
                                @if ($user)
                                <span class="badge bg-soft-primary text-primary fs--2"><i class="fas fa-user me-1"></i>{{ $user->fullname }}</span>
                                @else
                                <span class="badge bg-soft-secondary text-secondary fs--2">Unknown</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-900">{{ $datas->master_patient_name }}</div>
                        </td>
                        <td>
                            @if ($pasien)
                            <span class="badge bg-soft-info text-info fw-bold">{{ $pasien->t_pasien_cat_name }}</span>
                            @else
                            <span class="text-400">-</span>
                            @endif
                        </td>
                        <td>
                            <i class="far fa-clock me-1 text-500"></i>{{ \Carbon\Carbon::parse($datas->d_reg_order_rad_date)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            @if ($dokter)
                            <div class="fw-semi-bold text-800">
                                {{ $dokter->master_doctor_title_f }} {{ $dokter->master_doctor_name }} {{ $dokter->master_doctor_title_e }}
                            </div>
                            @else
                            <span class="text-400">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($payment)
                            <span class="badge rounded-pill bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>
                            @else
                            <span class="badge rounded-pill bg-soft-danger text-danger"><i class="fas fa-times-circle me-1"></i>Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($datas->d_reg_order_rad_status == 0)
                            <span class="badge rounded-pill bg-soft-warning text-warning"><i class="fas fa-hourglass-half me-1"></i>Belum Diproses</span>
                            @else
                            <span class="badge rounded-pill bg-soft-success text-success"><i class="fas fa-check me-1"></i>Selesai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-sm btn-outline-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog me-1"></i>Aksi
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-primary" href="javascript:void(0)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-radiologi"
                                        id="button-proses-handling"
                                        data-code="{{ $datas->d_reg_order_rad_code }}">
                                        <i class="fas fa-user-check me-2"></i>Proses Handling Pasien
                                    </a>
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
<!-- Modal Section -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi" class="p-3"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Pasien / No Reg...",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data registrasi radiologi",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Data kosong",
                infoFiltered: "(difilter dari total _MAX_ data)"
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

    // Event Handler untuk Button Proses Handling Radiologi
    $(document).on("click", "#button-proses-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-radiologi').html(`
            <div class="text-center my-5 py-4">
                <div class="spinner-border text-danger" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-600 fw-semi-bold">Memuat Data Handling Radiologi...</p>
            </div>
        `);

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
        }).fail(function(xhr, status, error) {
            $('#menu-radiologi').html(`
                <div class="alert alert-danger text-center my-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> Gagal memuat data. Silakan coba beberapa saat lagi.
                </div>
            `);
        });
    });

    // Event Handler untuk Button Handling Pasien Poliklinik
    $(document).on("click", "#button-handling-pasien-poliklinik", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-handling-pasien-poliklinik').html(`
            <div class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

        $.ajax({
            url: "{{ route('data_registrasi_poli_handling_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-pasien-poliklinik').html(data);
            setTimeout(() => {
                location.reload();
            }, 500);
        }).fail(function() {
            $('#menu-handling-pasien-poliklinik').html(`
                <div class="alert alert-danger text-center my-2" role="alert">
                    Gagal memproses data.
                </div>
            `);
        });
    });
</script>
@endsection
