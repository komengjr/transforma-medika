@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-danger">
            <div class="row gx-2 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/rad.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-danger fw-bold mb-1">Trans <span class="text-warning fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                    <h4 class="text-danger fw-bold mb-0">Radiologi <span class="text-danger fw-medium">Data
                            Registrasi</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn btn-falcon-default btn-sm mb-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Refresh" aria-label="Back to inbox">
                    <span class="fas fa-undo"></span>
                </a>
                <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm mb-1" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Archive" aria-label="Archive">
                    <svg class="svg-inline--fa fa-archive fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="archive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z"></path>
                    </svg><!-- <span class="fas fa-archive"></span> Font Awesome fontawesome.com -->
                </button>

            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="d/m/y to d/m/y" data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-bordered table-striped" style="width:100%">
            <thead class="bg-800 text-200 fs--2">
                <tr>
                    <th class="sort" data-sort="no">No</th>
                    <th class="sort" data-sort="reg">No Registrasi</th>
                    <th class="sort" data-sort="name">Nama Pasien</th>
                    <th class="sort" data-sort="name">Pasien</th>
                    <th class="sort" data-sort="tgl">Tanggal Reg</th>
                    <th class="sort" data-sort="doc">Dokter Rujukan</th>
                    <th class="sort" data-sort="status">Status Pembayaran</th>
                    <th class="sort" data-sort="status">Status Reg</th>
                    <th class="sort" data-sort="act">Action</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                @php
                $user = DB::table('user_mains')
                ->select('fullname')
                ->where('userid', $datas->d_reg_order_rad_user)
                ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->d_reg_order_code }} <br> <strong class="text-danger">{{ $datas->d_reg_order_rad_code }}</strong>
                        <br>
                        @if ($user)
                        <span class="badge bg-primary">{{ $user->fullname }}</span>
                        @else
                        <span class="badge bg-danger">Unknown</span>
                        @endif
                    </td>
                    <td>{{ $datas->master_patient_name }}</td>
                    <td>
                        @php
                        $pasien = DB::table('t_pasien_cat')
                        ->where('t_pasien_cat_code', $datas->t_pasien_cat_code)
                        ->first();
                        @endphp
                        @if ($pasien)
                        <strong class="text-primary">{{ $pasien->t_pasien_cat_name }}</strong>
                        @endif
                    </td>
                    <td>{{ $datas->d_reg_order_rad_date }}</td>
                    <td>
                        @php
                        $dokter = DB::table('master_doctor')
                        ->where('master_doctor_code', $datas->d_reg_order_rad_dr_rujukan)
                        ->first();
                        @endphp
                        @if ($dokter)
                        {{ $dokter->master_doctor_title_f }} {{ $dokter->master_doctor_name }}
                        {{ $dokter->master_doctor_title_e }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                        $payment = DB::table('d_reg_order_payment')
                        ->where('d_reg_order_list_code', $datas->d_reg_order_rad_code)
                        ->first();
                        @endphp
                        @if ($payment)
                        <span class="badge bg-primary">Lunas</span>
                        @else
                        <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($datas->d_reg_order_rad_status == 0)
                        <span class="badge bg-danger">Belum</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><span class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-radiologi" id="button-proses-handling"
                                    data-code="{{ $datas->d_reg_order_rad_code }}"><span
                                        class="fas fa-dna"></span>
                                    Proses Handling Pasien</button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-proses-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-radiologi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-radiologi').html('eror');
        });
    });
    $(document).on("click", "#button-handling-pasien-poliklinik", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-handling-pasien-poliklinik').html(
            '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto; float:right;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            }, 300);
        }).fail(function() {
            $('#menu-handling-pasien-poliklinik').html('eror');
        });
    });
</script>
@endsection
