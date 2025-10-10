@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        #button-pick-request {
            cursor: pointer;
        }

        #button-pick-request:hover {
            background: rgb(223, 217, 25);
        }

        #button-terima-order-barang-peminjaman:hover {
            background: rgb(223, 217, 25);
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center" style="color: white !important;">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Transaction <span
                                class="text-white fw-medium" style="color: white !important;">Product In</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Product In</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                id="button-add-schedule" data-code="123"><span class="far fa-edit"></span>
                                Add Schedule Product In</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-add-as" data-code="123"><span class="far fa-folder-open"></span>
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>No Schedule Product In</th>
                        <th>Schedule Product Date</th>
                        <th>Create By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->schedule_product_code }}</td>
                            <td>{{ $datas->schedule_product_date }}</td>
                            <td>{{ $datas->schedule_product_by }}</td>
                            <td>
                                @if ($datas->schedule_product_status == 0)
                                    <span class="badge bg-warning">Proses</span>
                                @elseif ($datas->schedule_product_status == 1)
                                    <span class="badge bg-primary">Done</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        @if ($datas->schedule_product_status == 0)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-barang-masuk" data-code="{{ $datas->schedule_product_code }}"><span
                                                    class="far fa-edit"></span>
                                                Proses Barang Masuk</button>
                                        @elseif ($datas->schedule_product_status == 1)
                                             <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                            id="button-preview-schedule" data-code="{{ $datas->schedule_product_code }}"><span class="fas fa-file-pdf"></span>
                                            Preview</button>
                                        @endif

                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                            id="button-add-as" data-code="123"><span class="far fa-folder-open"></span>
                                            History</button>
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
    <div class="modal fade" id="modal-pr" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-pr-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr-xl"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-add-schedule", function (e) {
            e.preventDefault();
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_add_schedule') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 0
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pr-xl').html(data);
            }).fail(function () {
                $('#menu-pr-xl').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-schedule", function (e) {
            e.preventDefault();
            var data = $("#form-input-schedule").serialize();
            $('#menu-add-data-schedule').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_save_schedule') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Tolong lah Isi dengan Bener!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                    $('#menu-add-data-schedule').html('<button class="btn btn-success float-end" id="button-simpan-data-pr" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-schedule').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-schedule').html('eror');
            });
        });
        $(document).on("click", "#button-barang-masuk", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_incoming') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pr-xl').html(data);
            }).fail(function () {
                $('#menu-pr-xl').html('eror');
            });
        });
        $(document).on("click", "#button-submit-barang", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-setup-in').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_pilih_barang') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-setup-in').html(data);
            }).fail(function () {
                $('#menu-setup-in').html('eror');
            });
        });
        $(document).on("click", "#button-input-product-in", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#menu-setup-in').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_incoming_check') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "id": id
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-setup-in').html(data);
            }).fail(function () {
                $('#menu-setup-in').html('eror');
            });
        });
        $(document).on("click", "#button-preview-schedule", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('transaction_product_in_preview_schedule') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pr-xl').html(data);
            }).fail(function () {
                $('#menu-pr-xl').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-product-in", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-add-data-schedule').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won Product In!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Verif it!",
                cancelButtonText: "No, cancel!",
                allowOutsideClick: false, // Prevents closing by clicking outside the alert
                allowEscapeKey: false,   // Prevents closing by pressing the Escape key
                allowEnterKey: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('transaction_product_in_save_incoming') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "Verified!",
                            text: "Your Product Has Been to.",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });

                    }).fail(function () {
                        $('#menu-add-data-schedule').html('eror');
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                    $('#menu-add-data-schedule').html(
                        '<button class="btn btn-success float-end" id="button-simpan-data-product-in" data-code="' + code + '"> Simpan Data </button>'
                    );
                }
            });

        });
    </script>
@endsection
