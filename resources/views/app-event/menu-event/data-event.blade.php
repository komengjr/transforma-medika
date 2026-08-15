@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Hero Banner Modern */
    .event-hero-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #2563eb 100%);
        border: none;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
    }

    /* Card Data Table Styling */
    .data-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Custom Table Styling */
    .table-modern {
        vertical-align: middle;
    }

    .table-modern thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        padding: 14px 16px;
    }

    .table-modern tbody td {
        padding: 14px 16px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Cover Image Thumbnail */
    .event-thumb-container {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-thumb-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Sub Event Badges */
    .sub-event-list {
        padding-left: 0;
        list-style: none;
        margin-bottom: 0;
    }

    .sub-event-item {
        font-size: 0.78rem;
        background-color: #f1f5f9;
        color: #334155;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 4px;
        border: 1px solid #e2e8f0;
        font-weight: 500;
    }

    /* Dropdown Styling */
    .dropdown-menu-modern {
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 8px;
    }

    .dropdown-menu-modern .dropdown-item {
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-menu-modern .dropdown-item:hover {
        background-color: #eff6ff;
        color: #2563eb;
    }
</style>
@endsection

@section('content')
<!-- 1. HERO HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card event-hero-card text-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3 d-none d-sm-block">
                            <img src="{{ asset('img/brodcast.png') }}" alt="Broadcast Icon" width="48" height="48" class="img-fluid" />
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-dark rounded-pill px-3 py-1 fs--2 mb-2">
                                <i class="fas fa-calendar-alt me-1"></i> System Data Center
                            </span>
                            <h3 class="text-white fw-bold mb-1">
                                {{ Env('APP_LABEL') }} <span class="fw-normal opacity-75">Management System</span>
                            </h3>
                            <p class="mb-0 fs--1 text-white-50">Kelola daftar acara, sub-event, peserta, dan konfigurasi pendaftaran dalam satu tempat.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0 border-start border-white border-opacity-10 ps-md-4">
                        <span class="text-white-50 fs--2 text-uppercase fw-semibold d-block">Menu Navigasi</span>
                        <h4 class="text-white fw-bold mb-0">Event <span class="fw-normal">Data</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. DATA TABLE CARD CONTAINER -->
<div class="card data-card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-auto d-flex align-items-center">
                <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-2">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h5 class="mb-0 text-900 fw-bold">Management Data Event</h5>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <button class="btn btn-primary btn-sm rounded-pill dropdown-toggle shadow-sm px-3" id="btnGroupVerticalDrop2"
                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                            id="button-add-event" data-code="123">
                            <i class="far fa-edit me-2 text-primary"></i> Add Event Broadcast
                        </button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                            id="button-add-123" data-code="123">
                            <i class="far fa-folder-open me-2 text-info"></i> Add Sub Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0 p-md-4">

        <table id="example" class="table table-modern align-middle" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th class="text-center" style="width: 90px;">Gambar</th>
                    <th>Nama Event</th>
                    <th>Lokasi Event</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Berakhir</th>
                    <th>Sub Event</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td class="text-center fw-semibold text-600">{{ $no++ }}</td>
                    <td class="text-center">
                        <div class="event-thumb-container mx-auto">
                            @if ($datas->event_data_cover == '')
                            <img src="{{ asset('img/cover.png') }}" alt="Default Cover" id="videoPreview">
                            @else
                            <img src="{{ Storage::url($datas->event_data_cover) }}" alt="Event Cover" />
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark d-block mb-0 fs-0">{{ $datas->event_data_tittle }}</span>
                        <span class="fs--2 text-muted">Code: {{ $datas->event_data_code }}</span>
                    </td>
                    <td>
                        <span class="fs--1 text-800 fw-medium"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $datas->event_data_venue }}</span>
                    </td>
                    <td>
                        <span class="badge bg-soft-success text-success fs--2 rounded-pill"><i class="far fa-clock me-1"></i>{{ $datas->event_data_start_date }}</span>
                    </td>
                    <td>
                        <span class="badge bg-soft-secondary text-secondary fs--2 rounded-pill"><i class="far fa-clock me-1"></i>{{ $datas->event_data_end_date }}</span>
                    </td>
                    <td>
                        @php
                        $sub = App\Models\Event\SubEventModel::where('event_data_code',$datas->event_data_code)->get();
                        @endphp
                        <ul class="sub-event-list">
                            @forelse ($sub as $subs)
                            <li class="sub-event-item"><i class="fas fa-chevron-right me-1 text-primary"></i>{{ $subs->event_data_sub_name }}</li>
                            @empty
                            <span class="fs--2 text-muted italic">Belum ada sub-event</span>
                            @endforelse
                        </ul>
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-soft-info text-info">Aktif (0)</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3 fs--1" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> Opsi
                            </button>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-event-full"
                                    id="button-detail-event" data-code="{{$datas->event_data_code}}">
                                    <i class="far fa-edit me-2 text-warning"></i> Setup Event
                                </button>
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                    id="button-add-event" data-code="{{$datas->event_data_code}}">
                                    <i class="fas fa-book-reader me-2 text-info"></i> Peserta Event
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-event-full"
                                    id="button-form-registrasi-peserta" data-code="{{$datas->event_data_code}}">
                                    <i class="fab fa-wpforms me-2 text-success"></i> Form Registrasi Peserta
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-event"
                                    id="button-add-sub-event" data-code="{{$datas->event_data_code}}">
                                    <i class="fas fa-calendar-plus me-2 text-primary"></i> Add Sub Event
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item d-flex align-items-center" onclick='window.open(`{{ route("menu_event_data_form_self_registrasi",["kode"=>$datas->event_data_code]) }}`, "_blank");'>
                                    <i class="fas fa-external-link-alt me-2 text-secondary"></i> Self Register
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
<!-- MODAL OVERLAY STYLING -->
<div class="modal fade" id="modal-event" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
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
        <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
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
            '<div class="spinner-border text-primary my-4" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-event-full').html('<div class="p-4 text-center text-danger fw-bold">Gagal memuat data event.</div>');
        });
    });

    $(document).on("click", "#button-add-type-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-type-peserta').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-type-peserta').html('<div class="p-3 text-center text-danger">Gagal memuat tipe peserta.</div>');
        });
    });

    $(document).on("click", "#button-add-sub-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-event').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-event').html('<div class="p-3 text-center text-danger">Gagal memuat sub event.</div>');
        });
    });

    $(document).on("click", "#button-simpan-data-sub-event", function(e) {
        e.preventDefault();
        var data = $("#form-input-sub-event").serialize();
        $('#menu-add-data-sub-event').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-add-data-sub-event').html('<div class="p-2 text-danger">Gagal menyimpan sub-event</div>');
        });
    });

    $(document).on("click", "#button-form-registrasi-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-event-full').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-event-full').html('<div class="p-3 text-center text-danger">Gagal memuat form registrasi.</div>');
        });
    });

    $(document).on("click", "#button-add-event-class", function(e) {
        e.preventDefault();
        var data = $("#form-sub-event-class").serialize();
        $('#button-save-event-detail').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#data-table-event-class').html('<div class="p-2 text-danger">Gagal menambah kelas</div>');
        });
    });

    $(document).on("click", "#button-add-event-session", function(e) {
        e.preventDefault();
        var data = $("#form-sub-event-session").serialize();
        $('#button-save-event-session').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#data-table-event-session').html('<div class="p-2 text-danger">Gagal menambah sesi</div>');
        });
    });
</script>

<script>
    $(document).on("click", "#button-detail-sub-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-detail-seub-event').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#menu-detail-seub-event').html('<div class="p-3 text-center text-danger">Gagal memuat detail sub event.</div>');
        });
    });

    $(document).on("click", "#button-add-peserta-event", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#show-data-event-all').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
            $('#show-data-event-all').html('<div class="p-3 text-center text-danger">Gagal menambah peserta event.</div>');
        });
    });
</script>
@endsection
