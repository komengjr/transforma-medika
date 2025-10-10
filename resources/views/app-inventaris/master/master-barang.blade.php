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
                <div class="row gx-0 flex-between-center">
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
                                class="text-white fw-medium" style="color: white !important;">Barang</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Master Barang</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-master-barang-xl"
                                id="button-add-barang" data-code="123"><span class="far fa-edit"></span>
                                Tambah Barang</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="fas fa-file-import"></span> -
                                Import Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>No Inventaris</th>
                        <th>Klasifikasi</th>
                        <th>Merk / Type</th>
                        <th>Tanggal Pembelian</th>
                        <th>Harga Perolehan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    <!-- @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $datas)
                            <tr>
                                <td>{{ $datas->inv_data_master_no }}</td>
                                <td>
                                    @if ($datas->inv_data_master_file == "")
                                        <div class="avatar avatar-3xl">
                                            <img src="{{ asset('img/app.png')}}" alt="" />
                                        </div>
                                    @else
                                        <div class="avatar avatar-3xl">
                                            <img src="{{ Storage::url($datas->inv_data_master_file)}}" alt="" />
                                        </div>
                                    @endif
                                </td>
                                <td><h6>{{ $datas->inv_data_master_name }}</h6></td>
                                <td><h6>{{ $datas->inv_data_master_code  }}</h6></td>
                                <td><h6>{{ $datas->id_inv_data_class_code  }}</h6></td>
                                <td><h6>{{ $datas->inv_data_location_code  }}</h6></td>
                                <td><h6>{{ $datas->inv_data_master_merk  }}</h6></td>
                                <td><h6>{{ $datas->inv_data_master_tgl_beli  }}</h6></td>
                                <td ><h6 class="text-warning">@currency($datas->inv_data_master_harga)</h6></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-Option="false"><span
                                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#modal-master-barang-xl" id="button-update-barang"
                                                data-code="123"><span class="far fa-edit"></span>
                                                Edit Barang</button>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                                id="button-data-barang-cabang" data-code="123"><span
                                                    class="fas fa-file-import"></span> -
                                                Import Excel</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-master-barang" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-master-barang"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-master-barang-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-master-barang-xl"></div>
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
        $(document).on("click", "#button-add-barang", function (e) {
            e.preventDefault();
            $('#menu-master-barang-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_barang_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 0
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-master-barang-xl').html(data);
            }).fail(function () {
                $('#menu-master-barang-xl').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data", function (e) {
            e.preventDefault();
            var data = $("#form-add-data-barang").serialize();
            var nama = document.getElementById("nama_barang").value;
            var klasifikasi = document.getElementById("klasifikasi").value;
            var tgl_beli = document.getElementById("tgl_beli").value;
            var harga_perolehan = document.getElementById("dengan-rupiah").value;
            var suplier = document.getElementById("suplier").value;
            var lokasi = document.getElementById("lokasi").value;
            // var merk = document.getElementById("merk").value;
            // var type = document.getElementById("type").value;
            // var seri = document.getElementById("seri").value;

            if (nama == "" || klasifikasi == "" || tgl_beli == "" || harga_perolehan == "" || suplier == "" || lokasi == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Mohon diisi Dengan Lengkap",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $('#menu-simpan-data').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('master_barang_add_save_data') }}",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content"),
                    },
                    type: "POST",
                    cache: false,
                    data: data,
                    dataType: 'html',
                }).done(function (data) {
                    $('#menu-simpan-data').html(data);
                    location.reload();
                }).fail(function () {
                    $('#menu-simpan-data').html('eror');
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#example').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('master_barang_show_data') }}",
                columns: [{
                    data: 'id',
                    "width": "4%"
                },
                {
                    data: 'gambar'
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'no_inventaris',
                    className: 'child'
                },
                {
                    data: 'kd_inventaris',
                    className: 'child'
                },
                {
                    data: 'merk',
                    className: 'child'
                },
                {
                    data: 'tglbeli',
                },
                {
                    data: 'harga_perolehan',
                    className: 'text-end'
                },
                {
                    data: 'kd_lokasi',
                    className: 'child'
                },
                {
                    data: 'status',
                    className: 'text-center'
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
@endsection
