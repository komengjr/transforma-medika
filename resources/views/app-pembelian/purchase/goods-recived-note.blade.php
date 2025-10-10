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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/grn.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Good <span
                                class="text-white fw-medium" style="color: white !important;">Recived Note</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Goods Recived Note</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped border" style="width:100%">
                <thead class="bg-300 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>No Purchase Order</th>
                        <th>No Goods Recived Note</th>
                        <th>Suplier DO</th>
                        <th>Supplier</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->pem_pr_order_no }}</td>
                            <td>{{ $datas->pem_grn_token_number }}</td>
                            <td>{{ $datas->pem_grn_token_do }}</td>
                            <td>{{ $datas->master_supplier_name }}</td>
                            <td> <small>{{ $datas->m_pay_name . ' - ' . $datas->m_pay_detail_name }}</small> <br>
                                {{ $datas->pem_pr_order_payment_no_rek }}</td>
                            <td>
                                @if ($datas->pem_grn_token_metode == 'paylater')
                                    <span class="badge bg-warning">Purchase Invoice</span>
                                @elseif ($datas->pem_grn_token_metode == 'paynow')
                                    <span class="badge bg-primary">Cash Purchase</span>
                                @endif
                            </td>
                            <td>
                                @if ($datas->pem_grn_token_status == 0)
                                    <button class="btn btn-falcon-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-pr-xl" id="button-prosess-payment"
                                        data-code="{{ $datas->pem_grn_token_code }}">
                                        <span class="fas fa-credit-card"></span>
                                        Proses
                                    </button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-pr-xl"
                                        id="button-preview-grn" data-code="{{ $datas->pem_grn_token_code }}">Print</button>
                                @endif
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
    <div class="modal fade" id="modal-pr-lg" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr-lg"></div>
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
        $(document).on("click", "#button-prosess-payment", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pr-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('goods_recived_note_detail') }}",
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
        $(document).on("click", "#button-preview-grn", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $.ajax({
                url: "{{ route('goods_recived_note_preview') }}",
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
        $(document).on("click", "#button-bayar", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            var name = $(this).data("name");
            var no_invoice = document.getElementById("no_invoice").value;
            if (no_invoice == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Isi Dulu No Invoice!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: true
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure? " + name + "",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "No, cancel!",
                    confirmButtonText: "Yes, Sure it!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('goods_recived_note_pay') }}",
                            type: "POST",
                            cache: false,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "code": code,
                                "name": name,
                                "no_invoice": no_invoice
                            },
                            dataType: 'html',
                        }).done(function (data) {
                            $('#menu-bayar-grn').html(
                                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                            );
                            swalWithBootstrapButtons.fire({
                                title: "Success!",
                                text: "your Prosess GRN is Successfull.",
                                icon: "success"
                            });
                            $('#menu-bayar-grn').html(data);
                            location.reload();
                        }).fail(function () {
                            swalWithBootstrapButtons.fire({
                                title: "Failed",
                                text: "Your Prosess GRN is Failed :)",
                                icon: "error"
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your Prosess GRN is cancel :)",
                            icon: "error"
                        });
                    }
                });
            }
        });
    </script>
@endsection
