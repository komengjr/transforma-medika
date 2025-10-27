@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table th {
            background-color: #f0f2f7;
        }

        .btn-modern {
            background: linear-gradient(135deg, #007bff, #00c4ff);
            border: none;
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            background: linear-gradient(135deg, #0062cc, #00a6d6);
            transform: scale(1.05);
        }

        .search-bar input {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding-left: 35px;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #888;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-warning">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-warning fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-warning fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-warning fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-warning fs--1 mb-0">Menu : </h6>
                        <h4 class="text-warning fw-bold mb-0">Manajemen <span class="text-warning fw-medium">Data
                                Obat</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-300">
            <h4 class="fw-semibold mb-2">💊 Master Data Obat</h4>
            <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modal-obat" id="button-add-obat">+ Tambah
                Obat</button>
        </div>
        <div class="table-responsive" id="data-table-obat">
            <table id="example" class="table table-striped border" style="width:100%">
                <thead class="bg-warning text-100">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th class="text-center">Stok Minimum</th>
                        <th class="text-center">Batch</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td data-label="Kode">{{$no++}}</td>
                            <td data-label="Nama">{{ $datas->farm_data_obat_name }}</td>
                            <td data-label="Satuan">{{ $datas->farm_data_obat_satuan }}</td>
                            <td data-label="Kategori">{{ $datas->farm_data_obat_cat }}</td>
                            <td data-label="Pabrikan">{{ $datas->farm_data_obat_jenis }}</td>
                            <td class="text-center">{{ $datas->farm_data_obat_stok_minimum }}</td>
                            <td class="text-center">
                                @php
                                    $total = DB::table('farm_data_obat_exp')->where('farm_data_obat_code',$datas->farm_data_obat_code)->count();
                                @endphp
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal-obat" id="button-bacth-detail" data-code="{{ $datas->farm_data_obat_code }}">{{ $total }}</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#modal-obat" id="button-update-data-obat"
                                    data-code="{{ $datas->farm_data_obat_code }}">✏️</button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-obat" id="button-add-batch-obat"
                                    data-code="{{ $datas->farm_data_obat_code }}"><i class="fab fa-ioxhost"></i></button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-obat" id="button-detail-data-obat"
                                    data-code="{{ $datas->farm_data_obat_code }}"><i class="fab fa-sistrix"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
        </nav>

    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
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
    <div class="modal fade" id="modal-obat" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-obat"></div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="modalObat" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Obat Baru</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formObat">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Kode Obat</label>
                                <input type="text" id="kodeObat" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Obat</label>
                                <input type="text" id="namaObat" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Satuan</label>
                                <input type="text" id="satuan" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <input type="text" id="kategori" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis</label>
                                <input type="text" id="pabrikan" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary">Batch & Harga</h6>
                        <div id="batchContainer"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addBatch">+ Tambah
                            Batch</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-modern">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Update Batch -->
    <div class="modal fade" id="modalBatch" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Update Batch & Harga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formUpdateBatch">
                    <div class="modal-body">
                        <div id="batchUpdateContainer"></div>
                        <button type="button" class="btn btn-outline-warning btn-sm mt-2" id="addBatchUpdate">+ Tambah
                            Batch</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-modern">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-add-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 123
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-obat", function (e) {
            e.preventDefault();
            var data = $("#form-input-obat").serialize();
            $('#menu-add-data-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_save') }}",
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
                    $('#menu-add-data-obat').html('<button class="btn btn-success float-end" id="button-simpan-data-obat">Simpan Data</button > ');
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil Simpan Data"
                    });
                    $('#modal-obat').modal('hide');
                    $('#data-table-obat').html(data);
                }
            }).fail(function () {
                $('#data-table-obat').html('eror');
            });
        });

        $(document).on("click", "#button-update-data-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_update') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });
        $(document).on("click", "#button-save-update-data-obat", function (e) {
            e.preventDefault();
            var data = $("#form-update-obat").serialize();
            $('#menu-add-data-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_update_save') }}",
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
                    $('#menu-add-data-obat').html('<button class="btn btn-success float-end" id="button-save-update-data-obat">Simpan Data</button > ');
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil Update Data"
                    });
                    $('#modal-obat').modal('hide');
                    $('#data-table-obat').html(data);
                }
            }).fail(function () {
                $('#data-table-obat').html('eror');
            });
        });

        $(document).on("click", "#button-add-batch-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_add_batch') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-batch-obat", function (e) {
            e.preventDefault();
            var data = $("#form-save-batch").serialize();
            $('#menu-add-data-batch').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_save_batch') }}",
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
                    $('#menu-add-data-batch').html('<button class="btn btn-success float-end" id="button-simpan-batch-obat">Simpan Data</button > ');
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil Update Data"
                    });
                    $('#modal-obat').modal('hide');
                    $('#data-table-obat').html(data);
                }
            }).fail(function () {
                $('#data-table-obat').html('eror');
            });
        });

        $(document).on("click", "#button-bacth-detail", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_batch_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });

        $(document).on("click", "#button-detail-data-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_obat_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });
    </script>

@endsection
