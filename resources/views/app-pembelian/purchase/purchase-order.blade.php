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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/po.png') }}" alt="" width="50" />
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
                                class="text-white fw-medium" style="color: white !important;">Order</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Purchase Order</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                id="button-add-pr-order" data-code="123"><span class="far fa-edit"></span>
                                Add Purchase Order</button>
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
                        <th>No Purchase Order</th>
                        <th>Order Date</th>
                        <th>Req By</th>
                        <th>Supplier</th>
                        <th>Payment Method</th>
                        <th>Status PO</th>
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
                            <td>{{ $datas->pem_pr_order_no }}</td>
                            <td>{{ $datas->pem_pr_order_date }}</td>
                            <td>{{ $datas->pem_pr_req_code }}</td>
                            <td>{{ $datas->master_supplier_name }}</td>
                            <td>
                                @php
                                    $payment = DB::table('pem_pr_order_payment')
                                        ->join('m_pay_detail', 'm_pay_detail.m_pay_detail_code', '=', 'pem_pr_order_payment.m_pay_detail_code')
                                        ->join('m_pay', 'm_pay.m_pay_code', '=', 'm_pay_detail.m_pay_code')
                                        ->where('pem_pr_order_code', $datas->pem_pr_order_code)->first();
                                @endphp
                                @if ($payment)
                                    <small>{{ $payment->m_pay_name . ' - ' . $payment->m_pay_detail_name }}</small> <br>
                                    {{ $payment->pem_pr_order_payment_no_rek }} <br>
                                @else
                                    -----------------------------
                                @endif
                            </td>
                            <td>
                                @if ($datas->pem_pr_order_status == 0)
                                    <span class="badge bg-danger">Prosess</span>
                                @elseif($datas->pem_pr_order_status == 1)
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($datas->pem_pr_order_status == 2)
                                    <span class="badge bg-primary">Supplier Menerima</span>
                                @elseif($datas->pem_pr_order_status == 3)
                                    <span class="badge bg-youtube">Menunggu Barang datang</span>
                                @elseif($datas->pem_pr_order_status == 4)
                                    <span class="badge bg-dark text-white">Created GRN</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        @if ($datas->pem_pr_order_status == 0)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr"
                                                id="button-add-item-order" data-code="{{$datas->pem_pr_order_code}}"><span
                                                    class="fas fa-wallet"></span>
                                                Input Item Order</button>
                                        @elseif($datas->pem_pr_order_status == 1)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-preview-send-order" data-code="{{$datas->pem_pr_order_code}}"><span
                                                    class="fas fa-file-signature"></span>
                                                Preview & Send</button>
                                        @elseif($datas->pem_pr_order_status == 2)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-evaluasi-purchase-order" data-code="{{$datas->pem_pr_order_code}}"><span
                                                    class="fas fa-file-signature"></span>
                                                Evaluasi Purchase Order</button>
                                        @elseif($datas->pem_pr_order_status == 3)
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                                id="button-terima-barang-order" data-code="{{$datas->pem_pr_order_code}}"><span
                                                    class="fas fa-file-signature"></span>
                                                Terima Barang & Generate GRN</button>
                                        @elseif($datas->pem_pr_order_status == 4)
                                            <button class="dropdown-item" data-code=" {{$datas->pem_pr_order_code}}"><span
                                                    class="fas fa-file-signature"></span>
                                                Report</button>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-info" data-bs-toggle="modal"
                                            data-bs-target="#modal-cabang" id="button-data-barang-cabang" data-code="123"><span
                                                class="fas fa-project-diagram"></span>
                                            Status Purchase Order</button>
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
        $(document).on("click", "#button-add-pr-order", function (e) {
            e.preventDefault();
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_add') }}",
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
        $(document).on("click", "#button-simpan-data-pr-order", function (e) {
            e.preventDefault();
            var data = $("#form-input-pr-order").serialize();
            $('#menu-add-data-pr-order').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_save') }}",
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
                    $('#menu-add-data-pr-order').html('<button class="btn btn-success float-end" id="button-simpan-data-pr-order" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-pr-order').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-pr-order').html('eror');
            });
        });
        $(document).on("click", "#button-add-item-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_add_item') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pr').html(data);
            }).fail(function () {
                $('#menu-pr').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-item-order", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#menu-data-order').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_pilih_item') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-data-order').html(data);
            }).fail(function () {
                $('#menu-data-order').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-item-purchase-order", function (e) {
            e.preventDefault();
            var data = $("#form-fix-data-order").serialize();
            $.ajax({
                url: "{{ route('purchase_order_order_item') }}",
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
                    $('#table-barang-request-order').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-data-order').html('');
                    $('#table-barang-request-order').html(data);
                }
            }).fail(function () {
                $('#table-barang-request-order').html('eror');
            });
        });
        $(document).on("click", "#button-remove-item-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            var id = $(this).data("id");
            $.ajax({
                url: "{{ route('purchase_order_remove_item_order') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
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
                    $('#table-barang-request-order').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-data-order').html('');
                    $('#table-barang-request-order').html(data);
                }
            }).fail(function () {
                $('#table-barang-request-order').html('eror');
            });
        });

        $(document).on("click", "#button-simpan-proses-purchase-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $.ajax({
                url: "{{ route('purchase_order_save_proses_order') }}",
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
                        text: "Tidak ada Barang Yang di Order!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#menu-proses-data-order').html(
                        '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-proses-data-order').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-proses-data-order').html('eror');
            });
        });
        $(document).on("click", "#button-preview-send-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_preview_send') }}",
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
        $(document).on("click", "#button-preview-report-purchase-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-preview-report-purchase-order').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_preview_report') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-preview-report-purchase-order').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function () {
                $('#menu-preview-report-purchase-order').html('eror');
            });
        });
        $(document).on("click", "#button-evaluasi-purchase-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_veluasi_purchase_order') }}",
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
        $(document).on("click", "#button-checklist-purchase-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-evaluasi-purchase-order').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_checklist_purchase_order') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-evaluasi-purchase-order').html(data);
            }).fail(function () {
                $('#menu-evaluasi-purchase-order').html('eror');
            });
        });
        $(document).on("click", "#button-accept-evaluasi-purchase-order", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#table-evaluasi-purchase-order').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_accept_purchase_order') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-evaluasi-purchase-order').html("");
                $('#table-evaluasi-purchase-order').html(data);
            }).fail(function () {
                $('#table-evaluasi-purchase-order').html('eror');
            });
        });
        $(document).on("click", "#button-save-send-purchase-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $.ajax({
                url: "{{ route('purchase_order_save_send_purchase_order') }}",
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
                        text: "Pastikan Barang Sudah dalam Proses Pengiriman!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#fotter-menu-evaluasi').html(
                        '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div><strong>Mohon Menunggu..</strong>'
                    );
                    setTimeout(() => {
                        $('#fotter-menu-evaluasi').html(data);
                        location.reload();
                    }, 2000);
                }
            }).fail(function () {
                $('#fotter-menu-evaluasi').html('eror');
            });
        });
        $(document).on("click", "#button-terima-barang-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('purchase_order_terima_barang') }}",
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
        $(document).on("click", "#button-terima-barang-purchase-order", function (e) {
            e.preventDefault();
            const id = $(this).data("id");
            const code = $(this).data("code");
            $.ajax({
                url: "{{ route('purchase_order_terima_barang_order') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#table-purchase-order').html(data);
            }).fail(function () {
                $('#table-purchase-order').html('eror');
            });
        });
        $(document).on("click", "#button-save-generate-grn", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $.ajax({
                url: "{{ route('purchase_order_save_and_generate_grn') }}",
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
                        text: "Barang Ada yang belum diterima!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else if (data == 1) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "GRN Gagal di Buat!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#fotter-menu-purchase-order').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#fotter-menu-purchase-order').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#fotter-menu-purchase-order').html('eror');
            });
        });
    </script>
@endsection
