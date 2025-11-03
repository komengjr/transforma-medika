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
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/list-pasien.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-primary fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-primary fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                        <h4 class="text-primary fw-bold mb-0">Verifikasi <span class="text-primary fw-medium">Data
                                Registrasi</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="d-flex justify-content-between">
                <div>
                    <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="" data-bs-original-title="Refresh" aria-label="Back to inbox" onclick="location.reload()">
                        <span class="fas fa-undo"></span>
                    </a>
                    <span class="mx-1 mx-sm-2 text-300">|</span>

                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="" data-bs-original-title="Mark as unread"
                        aria-label="Mark as unread"><svg class="svg-inline--fa fa-envelope fa-w-16" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="envelope" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                            </path>
                        </svg><!-- <span class="fas fa-envelope"></span> Font Awesome fontawesome.com --></button>

                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2 d-none d-sm-inline-block" type="button"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Print"
                        aria-label="Print"><svg class="svg-inline--fa fa-print fa-w-16" aria-hidden="true" focusable="false"
                            data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                            </path>
                        </svg><!-- <span class="fas fa-print"></span> Font Awesome fontawesome.com --></button>
                </div>
                <div class="d-flex">
                    <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="d/m/y to d/m/y"
                        data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>No. Reg</th>
                        <th>Nama Pasien</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Kategori Pasien</th>
                        <th>Layanan</th>
                        <th>Tanggal Registrasi</th>
                        <th>Status Verifikasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        @php
                            $user = DB::table('user_mains')->select('fullname')->where('userid', $datas->d_reg_order_user)->first();
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                {{ $datas->d_reg_order_code }} <br>
                                @if ($user)
                                    <span class="badge bg-primary">{{$user->fullname}}</span>
                                @else
                                    <span class="badge bg-danger">Unknown</span>
                                @endif
                            </td>
                            <td>{{ $datas->master_patient_name }}</td>
                            <td>{{ $datas->master_patient_tempat_lahir }}, {{ $datas->master_patient_tgl_lahir }}</td>
                            <td class="text-info">{{ $datas->t_pasien_cat_name }}</td>
                            <td>
                                @php
                                    $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)
                                        ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                                        ->get();
                                @endphp
                                @foreach ($layanan as $layanans)
                                    <li><strong>{{$layanans->d_reg_order_list_code }}</strong> <br> <span
                                            class="text-warning">{{$layanans->t_layanan_cat_name}}</span></li>
                                @endforeach
                            </td>
                            <td>{{ $datas->d_reg_order_date }}</td>
                            <td>
                                @if ($datas->d_reg_order_status == 0)
                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                @elseif ($datas->d_reg_order_status == 1)
                                    <span class="badge bg-primary">Sudah Verifikasi</span>
                                @elseif ($datas->d_reg_order_status == -1)
                                    <span class="badge bg-danger">Verifikasi Reject</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-registrasi" id="button-verifikasi-data-registrasi"
                                            data-code="{{$datas->d_reg_order_code}}">
                                            <span class="fas fa-user-shield me-2"></span>
                                            Verifikasi Data Registrasi
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-warning" id="button-data-pembatalan-registrasi"
                                            data-code="{{$datas->d_reg_order_code}}">
                                            <span class="fas fa-recycle me-2"></span>
                                            Pembatalan Data Registrasi
                                        </button>
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
    <div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-registrasi"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-company" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-verifikasi-data-registrasi", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-registrasi').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_pelayanan_verifikasi_registrasi_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-registrasi').html(data);
            }).fail(function () {
                $('#menu-registrasi').html('eror');
            });
        });
        $(document).on("click", "#button-data-verifikasi", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-data-verifikasi').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_pelayanan_verifikasi_registrasi_data_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-data-verifikasi').html(data);
            }).fail(function () {
                $('#menu-data-verifikasi').html('eror');
            });
        });

        $(document).on("click", "#button-data-pembatalan-registrasi", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Reject it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('menu_pelayanan_verifikasi_pembatalan_registrasi') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "Info!",
                            text: data,
                            icon: "success"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }).fail(function () {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });

        });
        $(document).on("click", "#button-save-data-verifikasi-registrasi", function (e) {
            e.preventDefault();
            var code = document.getElementById('no_reg').value;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Verif it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#menu-loading-verifikasi').html(
                        '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $.ajax({
                        url: "{{ route('menu_pelayanan_verifikasi_registrasi_data_save') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        $('#menu-loading-verifikasi').html(
                            'Wait 3 sec..'
                        );
                        location.reload();
                    }).fail(function () {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                        $('#menu-loading-verifikasi').html(
                            '<button class="btn btn-falcon-primary" id="button-save-data-verifikasi-registrasi">Verifikasi Data</button>'
                        );
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                    $('#menu-loading-verifikasi').html(
                        '<button class="btn btn-falcon-primary" id="button-save-data-verifikasi-registrasi">Verifikasi Data</button>'
                    );
                }
            });

        });
    </script>
@endsection
