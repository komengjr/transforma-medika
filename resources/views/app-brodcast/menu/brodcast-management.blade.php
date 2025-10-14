@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/brodcast.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ Env('APP_LABEL') }}
                                <span class="text-white fw-medium" style="color: white !important;">Management
                                    System</span>
                            </h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Brodcast <span
                                class="text-white fw-medium" style="color: white !important;">Management</span>
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
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                id="button-add-event" data-code="123"><span class="far fa-edit"></span>
                                Add Event Brodcast</button>
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
                        <th>Nama Event</th>
                        <th>Lokasi Event</th>
                        <th>Class Event</th>
                        <th>Tanggal Event</th>
                        <th>Total Peserta</th>
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
                            <td>{{ $datas->b_event_name }}</td>
                            <td>{{ $datas->b_event_location }}</td>
                            <td>{{ $datas->b_event_class }}</td>
                            <td>{{ $datas->b_event_date }}</td>
                            <td>
                                @php
                                    $total = DB::table('b_event_peserta')->where('b_event_code', $datas->b_event_code)->count();
                                @endphp
                                {{ $total }} Peserta
                            </td>
                            <td>
                                @if ($datas->b_event_status == 1)
                                    <span class="badge bg-primary">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak AKtif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                            id="button-add-peserta" data-code="{{$datas->b_event_code}}"><span
                                                class="far fa-edit"></span>
                                            Input Peserta Event</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                            id="button-add-as" data-code="{{$datas->b_event_code}}"><span
                                                class="far fa-folder-open"></span>
                                            Import Excel</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                            id="button-brodcast-whatsapp" data-code="{{$datas->b_event_code}}"><span
                                                class="fab fa-whatsapp"></span>
                                            Brodcast Whatsapp</button>
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
    <div class="modal fade" id="modal-brodcast" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-brodcast"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-add-event", function (e) {
            e.preventDefault();
            $('#menu-brodcast').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 0
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-brodcast').html(data);
            }).fail(function () {
                $('#menu-brodcast').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-event", function (e) {
            e.preventDefault();
            var data = $("#form-input-event").serialize();
            $('#menu-add-data-event').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_save') }}",
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
                    $('#menu-add-data-event').html('<button class="btn btn-success float-end" id="button-simpan-data-event" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-event').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-event').html('eror');
            });
        });

        $(document).on("click", "#button-add-peserta", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-brodcast').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_add_peserta') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-brodcast').html(data);
            }).fail(function () {
                $('#menu-brodcast').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-peserta", function (e) {
            e.preventDefault();
            var data = $("#form-input-peserta").serialize();
            $('#menu-add-data-peserta').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_save_peserta') }}",
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
                    $('#menu-add-data-peserta').html('<button class="btn btn-success float-end" id="button-simpan-data-peserta" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-peserta').html(data);
                    location.reload();
                }
            }).fail(function () {
                $('#menu-add-data-peserta').html('eror');
            });
        });

        // BRODCATS WHATSAPP
        $(document).on("click", "#button-brodcast-whatsapp", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-brodcast').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_brodcast_whatsapp') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-brodcast').html(data);
            }).fail(function () {
                $('#menu-brodcast').html('eror');
            });
        });
        $(document).on("click", "#button-kirim-semua", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-table-peserta').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_brodcast_management_brodcast_whatsapp_send') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-table-peserta').html(data);
            }).fail(function () {
                $('#menu-table-peserta').html('eror');
            });
        });
    </script>
@endsection
