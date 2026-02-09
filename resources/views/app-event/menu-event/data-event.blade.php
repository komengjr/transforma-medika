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
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Event <span
                            class="text-white fw-medium" style="color: white !important;">Data</span>
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
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Management Data Event</span></h3>
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
                            id="button-add-123" data-code="123"><span class="far fa-folder-open"></span>
                            Add Sub Event</button>
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
                    <th>Gambar Event</th>
                    <th>Nama Event</th>
                    <th>Lokasi Event</th>
                    <th>Mulai Event</th>
                    <th>Berakhir Event</th>
                    <th>Sub Event</th>
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
                    <td>
                        @if ($datas->event_data_cover == '')
                        <img src="{{ asset('img/cover.png') }}" alt="lightbox" class="img-thumbnail"
                            id="videoPreview" width="70" height="70">
                        @else
                        <img src="{{ Storage::url($datas->event_data_cover) }}" alt=""
                            width="80" />
                        @endif
                    </td>
                    <td>{{ $datas->event_data_tittle }}</td>
                    <td>{{ $datas->event_data_venue }}</td>
                    <td>{{ $datas->event_data_start_date }}</td>
                    <td>{{ $datas->event_data_end_date }}</td>
                    <td>
                        @php
                        $sub = App\Models\Event\SubEventModel::where('event_data_code',$datas->event_data_code)->get();
                        @endphp
                        @foreach ($sub as $subs)
                        <li class="ms-3">{{ $subs->event_data_sub_name }}</li>
                        @endforeach
                    </td>
                    <td>0</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-event-full"
                                    id="button-detail-event" data-code="{{$datas->event_data_code}}"><span class="far fa-edit"></span>
                                    Setup Event</button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                    id="button-add-event" data-code="{{$datas->event_data_code}}"><span class="fas fa-book-reader"></span>
                                    Peserta Event</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-event-full"
                                    id="button-form-registrasi-peserta" data-code="{{$datas->event_data_code}}"><span class="fab fa-wpforms"></span>
                                    Form Registrasi Peserta</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-event"
                                    id="button-add-sub-event" data-code="{{$datas->event_data_code}}"><span class="fas fa-calendar-plus"></span>
                                    Add Sub Event</button>
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
<div class="modal fade" id="modal-event" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-event"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-event-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-event-full"></div>
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
    $(document).on("click", "#button-detail-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-event-full').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_detail_event') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-event-full').html(data);
        }).fail(function() {
            $('#menu-event-full').html('eror');
        });
    });
    $(document).on("click", "#button-add-type-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-type-peserta').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_detail_event_add_type') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-type-peserta').html(data);
        }).fail(function() {
            $('#menu-type-peserta').html('eror');
        });
    });
    $(document).on("click", "#button-add-sub-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-event').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_add_sub_event') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-event').html(data);
        }).fail(function() {
            $('#menu-event').html('eror');
        });
    });

    $(document).on("click", "#button-simpan-data-sub-event", function(e) {
        e.preventDefault();
        var data = $("#form-input-sub-event").serialize();
        $('#menu-add-data-sub-event').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_save_sub_event') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Tolong lah Isi dengan Bener!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-sub-event').html('<button class="btn btn-success float-end" id="button-simpan-data-sub-event" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-sub-event').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-sub-event').html('eror');
        });
    });
    $(document).on("click", "#button-form-registrasi-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-event-full').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_form_registrasi_event') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-event-full').html(data);
        }).fail(function() {
            $('#menu-event-full').html('eror');
        });
    });
    $(document).on("click", "#button-add-event-class", function(e) {
        e.preventDefault();
        var data = $("#form-sub-event-class").serialize();
        $('#button-save-event-detail').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_detail_event_save_class') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Tolong lah Isi dengan Bener!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#button-save-event-detail').html(
                    '<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class"> <span class="fas fa-plus"></span> Add </button>'
                );
            } else {
                $('#data-table-event-class').html(data);
                document.getElementById('nama_class').value = "";
                document.getElementById('nama_room').value = "";
                document.getElementById('class_price').value = "";
                $('#button-save-event-detail').html(
                    '<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class"> <span class="fas fa-plus"></span> Add </button>'
                );
            }
        }).fail(function() {
            $('#data-table-event-class').html('eror');
        });
    });
    $(document).on("click", "#button-add-event-session", function(e) {
        e.preventDefault();
        var data = $("#form-sub-event-session").serialize();
        $('#button-save-event-session').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_detail_event_save_session') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Tolong lah Isi dengan Bener!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#button-save-event-session').html(
                    '<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-session"> <span class="fas fa-plus"></span> Add </button>'
                );
            } else {
                $('#data-table-event-session').html(data);
                document.getElementById('nama_session').value = "";
                $('#button-save-event-session').html(
                    '<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-session"> <span class="fas fa-plus"></span> Add </button>'
                );
            }
        }).fail(function() {
            $('#data-table-event-session').html('eror');
        });
    });
</script>
<script>
    $(document).on("click", "#button-detail-sub-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-detail-seub-event').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_form_registrasi_event_detail_sub_event') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-seub-event').html(data);
        }).fail(function() {
            $('#menu-detail-seub-event').html('eror');
        });
    });
    $(document).on("click", "#button-add-peserta-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#show-data-event-all').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_data_form_registrasi_event_detail_sub_event_add_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#show-data-event-all').html(data);
        }).fail(function() {
            $('#show-data-event-all').html('eror');
        });
    });
</script>
@endsection
