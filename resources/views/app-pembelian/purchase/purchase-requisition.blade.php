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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/pr.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Purchase <span
                                class="text-white fw-medium" style="color: white !important;">Request</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Purchase Reguest</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                id="button-add-pr" data-code="123"><span class="far fa-edit"></span>
                                Add Purchase Request</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
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
                        <th>No Purchase Req</th>
                        <th>Req Date</th>
                        <th>Date Requaire</th>
                        <th>Req By</th>
                        <th>Approve By</th>
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
                            <td>{{ $datas->pem_pr_req_name }}<br><span
                                    class="text-warning">{{ $datas->pem_pr_req_nomor }}</span></td>
                            <td>{{ $datas->pem_pr_req_date }}</td>
                            <td>{{ $datas->pem_pr_req_date_require }}</td>
                            <td>
                                @php
                                $nama = DB::table('hrm_master_pegawai')->where('hrm_m_pegawai_code',$datas->pem_pr_req_by)->first();
                                @endphp
                                @if ($nama)
                                    {{ $nama->hrm_m_pegawai_name }}
                                @endif
                            </td>
                            <td>{{ $datas->pem_pr_req_app_by }}</td>
                            <td>
                                @if ($datas->pem_pr_req_status == 0)
                                    <span class="badge bg-warning">Proses</span>
                                @elseif($datas->pem_pr_req_status == 1)
                                    <span class="badge bg-facebook">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge bg-success">Verify</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        @if ($datas->pem_pr_req_status == 0)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-add-pr-item" data-code="{{$datas->pem_pr_req_code}}"><span
                                                    class="fas fa-share-alt-square"> </span> - Add Item Request</button>
                                        @elseif($datas->pem_pr_req_status == 1)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-add-verif-pr" data-code="{{$datas->pem_pr_req_code}}"><span
                                                    class="fas fa-check-circle"> </span> - Verify Request</button>
                                        @elseif($datas->pem_pr_req_status == 2)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-print-report-pr" data-code="{{$datas->pem_pr_req_code}}"><span
                                                    class="fas fa-file-pdf"> </span> - Print Purchase Request</button>
                                        @endif


                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                            id="button-data-time-line-pr" data-code="{{$datas->pem_pr_req_code}}"><span
                                                class="fas fa-project-diagram"></span>
                                            Time Line</button>
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
        $(document).on("click", "#button-add-pr", function (e) {
            e.preventDefault();
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_add') }}",
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
        $(document).on("click", "#button-simpan-data-pr", function (e) {
            e.preventDefault();
            var data = $("#form-input-pr").serialize();
            $('#menu-add-data-pr').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_save') }}",
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
                    $('#menu-add-data-pr').html('<button class="btn btn-success float-end" id="button-simpan-data-pr" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-pr').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-pr').html('eror');
            });
        });
        $(document).on("click", "#button-add-pr-item", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_add_item') }}",
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
        $(document).on("click", "#button-simpan-item-pr-data", function (e) {
            e.preventDefault();
            var data = $("#form-input-item-pr").serialize();
            $.ajax({
                url: "{{ route('purchase_req_add_item_data') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#table-barang-request').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#table-barang-request').html(data);
                    document.getElementById("item").value = "";
                    document.getElementById("type").value = "";
                    document.getElementById("qty").value = "";
                }
            }).fail(function () {
                $('#table-barang-request').html('eror');
            });
        });
        $(document).on("click", "#button-remove-item-pr", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $.ajax({
                url: "{{ route('purchase_req_remove_item_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#table-barang-request').html(data);
            }).fail(function () {
                $('#table-barang-request').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-item-pr", function (e) {
            e.preventDefault();
            var code = $(this).data("code");

            $.ajax({
                url: "{{ route('purchase_req_add_save_item') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Barang Masih Kosong Tolong Isi Kekosongan ini!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#menu-add-data-pr').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-add-data-pr').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-pr').html('eror');
            });
        });
        $(document).on("click", "#button-add-verif-pr", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_verify') }}",
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
        $(document).on("click", "#button-reject-purchase-req", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-verify-data-pr').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_verify_reject') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-verify-data-pr').html(data);
            }).fail(function () {
                $('#menu-verify-data-pr').html('eror');
            });
        });
        $(document).on("click", "#button-verify-purchase-req", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-verify-data-pr').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_verify_save') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-verify-data-pr').html(data);
            }).fail(function () {
                $('#menu-verify-data-pr').html('eror');
            });
        });
        $(document).on("click", "#button-print-report-pr", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_req_preview_pr') }}",
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
    </script>
@endsection
