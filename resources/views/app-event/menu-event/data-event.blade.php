@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Hero Banner Modern */
    .event-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 40%, #3b82f6 100%);
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(30, 58, 138, 0.25);
    }

    /* Card Data Table Styling */
    .data-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        /* background: #ffffff; */
        /* Memastikan child element seperti dropdown tidak terpotong */
        overflow: visible !important;
    }

    /* Header Card Custom */
    .data-card .card-header {
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    /* Custom Table Styling Full-Width */
    .table-modern {
        vertical-align: middle;
        margin-bottom: 0 !important;
        width: 100% !important;
    }

    .table-modern thead th {
        background: linear-gradient(90deg, #1e293b 0%, #334155 100%);
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        border: none;
        padding: 16px 20px;
    }

    /* Padding pertama dan terakhir disesuaikan agar menyentuh pinggir card */
    .table-modern thead th:first-child,
    .table-modern tbody td:first-child {
        padding-left: 24px;
    }

    .table-modern thead th:last-child,
    .table-modern tbody td:last-child {
        padding-right: 24px;
    }

    .table-modern tbody td {
        padding: 16px 20px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        /* background-color: #f8fafc !important; */
    }

    /* Cover Image Thumbnail */
    .event-thumb-container {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }

    .event-thumb-container:hover {
        transform: scale(1.05);
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
        font-size: 0.75rem;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #1e293b;
        padding: 4px 10px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 4px;
        border: 1px solid #cbd5e1;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    /* Dropdown Styling Z-Index Fixed */
    .dropdown-menu-modern {
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 8px;
        background-color: #ffffff;
        z-index: 9999 !important;
        position: absolute !important;
    }

    .dropdown-menu-modern .dropdown-item {
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #334155;
        transition: all 0.2s ease;
    }

    .dropdown-menu-modern .dropdown-item:hover {
        background-color: #3b82f6;
        color: #ffffff !important;
    }

    .dropdown-menu-modern .dropdown-item:hover i {
        color: #ffffff !important;
    }

    /* Wrapper DataTables Controls Padding */
    .dataTables_wrapper .row:first-child,
    .dataTables_wrapper .row:last-child {
        padding: 16px 24px;
    }

    /* Custom Badges */
    .badge-soft-primary {
        background-color: #e0e7ff;
        color: #3730a3;
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
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3 d-none d-sm-block backdrop-blur">
                            <img src="{{ asset('img/brodcast.png') }}" alt="Broadcast Icon" width="48" height="48" class="img-fluid" />
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 fs--2 mb-2">
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
    <div class="card-header bg-white border-bottom py-3 px-4">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-auto d-flex align-items-center">
                <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-layer-group fs-0"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-900 fw-bold">Management Data Event</h5>
                    <small class="text-muted fs--2">Daftar seluruh event aktif dan pengaturannya</small>
                </div>
            </div>
            <div class="col-auto">
                <div class="btn-group position-relative" role="group">
                    <button class="btn btn-primary btn-sm rounded-pill dropdown-toggle shadow-sm px-3 fw-semibold" id="btnGroupVerticalDrop2"
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

    <!-- p-0 memastikan tabel membentang full hingga ujung card kanan & kiri -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-modern table-hover align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th class="text-center" style="width: 80px;">Gambar</th>
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
                        <td class="text-center fw-bold text-600">{{ $no++ }}</td>
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
                            <span class="badge bg-soft-secondary text-secondary fs--2 mt-1"><i class="fas fa-barcode me-1"></i>{{ $datas->event_data_code }}</span>
                        </td>
                        <td>
                            <span class="fs--1 text-800 fw-medium d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-danger me-2 fs-0"></i>{{ $datas->event_data_venue }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-soft-success text-success fs--2 rounded-pill px-2 py-1">
                                <i class="far fa-clock me-1"></i>{{ $datas->event_data_start_date }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-soft-danger text-danger fs--2 rounded-pill px-2 py-1">
                                <i class="far fa-clock me-1"></i>{{ $datas->event_data_end_date }}
                            </span>
                        </td>
                        <td>
                            @php
                            $sub = App\Models\Event\SubEventModel::where('event_data_code',$datas->event_data_code)->get();
                            @endphp
                            <ul class="sub-event-list">
                                @forelse ($sub as $subs)
                                <li class="sub-event-item">
                                    <i class="fas fa-angle-right me-1 text-primary"></i>{{ $subs->event_data_sub_name }}
                                </li>
                                @empty
                                <span class="fs--2 text-muted italic"><i class="fas fa-info-circle me-1"></i>Belum ada sub-event</span>
                                @endforelse
                            </ul>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-soft-info text-info px-3 py-1 fw-bold">
                                <i class="fas fa-check-circle me-1"></i>Aktif (0)
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group position-relative" role="group">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle rounded-pill px-3 fs--1 fw-semibold shadow-sm" id="btnGroupVerticalDrop2"
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
                                        <i class="fas fa-users me-2 text-info"></i> Peserta Event
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
