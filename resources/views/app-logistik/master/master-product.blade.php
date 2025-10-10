@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Master <span
                                class="text-white fw-medium" style="color: white !important;">Product</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Data Product</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                id="button-add-product" data-code="123"><span class="far fa-edit"></span>
                                Add New Product</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                id="button-upload-data-product" data-code="123"><span class="fas fa-upload"></span>
                                Import Excel</button>
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
                        <th>Gambar</th>
                        <th>ID Product</th>
                        <th>Nama Product</th>
                        <th>Klasifikasi Product</th>
                        <th>Type Product</th>
                        <th>Status Product</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-product" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-product"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-product-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <!-- <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                                                                data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div id="menu-product-xl"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#example').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('master_logistik_data_product') }}",
                columns: [{
                    data: 'id',
                    "width": "4%"
                },
                {
                    data: 'gambar'
                },
                {
                    data: 'id_product'
                },
                {
                    data: 'nama_product'
                },
                {
                    data: 'class',
                    className: 'child'
                },

                {
                    data: 'type',
                    className: 'child'
                },
                {
                    data: 'status',
                },
                {
                    data: 'btn',
                    className: 'text-center',
                    "width": "1%"
                }
                ]

            });
        });
    </script>
    <script>
        $(document).on("click", "#button-add-product", function (e) {
            e.preventDefault();
            $('#menu-product-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_logistik_add_product') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 0
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-product-xl').html(data);
            }).fail(function () {
                $('#menu-product-xl').html('eror');
            });
        });
        $(document).on("click", "#button-clear-data", function (e) {
            e.preventDefault();
            var link = document.getElementById("link").value;
            $('#menu-product-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_logistik_add_product_clear_file') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "link": link
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-product-xl').html(data);
                location.reload();
            }).fail(function () {
                $('#menu-product-xl').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data", function (e) {
            e.preventDefault();
            var data = $("#form-add-data-product").serialize();
            $('#menu-simpan-data').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_logistik_save_product') }}",
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
                    $('#menu-simpan-data').html(
                        '<button type="button" class="btn btn-outline-success" id="button-simpan-data"><i class="fa fa-save"></i> Simpan Data</button>'
                    );
                } else {
                    $('#menu-simpan-data').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-simpan-data').html('eror');
            });
        });
        $(document).on("click", "#button-upload-data-product", function (e) {
            e.preventDefault();
            $('#menu-product-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_logistik_upload_file_product') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": 0
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-product-xl').html(data);

            }).fail(function () {
                $('#menu-product-xl').html('eror');
            });
        });
    </script>
    <script>

        $(document).ready(function () {
            $('#form-input-upload').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('master_logistik_proses_product_upload_file') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert('Your form has been sent successfully.');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Your form was not sent successfully.');
                    }
                });
            });
        });
    </script>
@endsection
