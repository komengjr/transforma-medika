@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<!-- 2. Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- (Optional) Select2 Bootstrap 5 Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
<div class="row mb-3">
    <div class="col-12">
        <div class="card event-hero-card text-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3 d-none d-sm-block backdrop-blur">
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
        <!-- <div class="table-responsive"> -->
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
                                <button class="dropdown-item d-flex align-items-center btn-trigger-add-peserta"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-add-peserta"
                                    data-code="{{$datas->event_data_code}}">
                                    <i class="fas fa-users me-2 text-info"></i> Tambah Peserta Event
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-event-full"
                                    id="button-form-registrasi-peserta" data-code="{{$datas->event_data_code}}">
                                    <i class="fab fa-wpforms me-2 text-success"></i> Form Registrasi Peserta
                                </button>
                                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-event-full-data"
                                    id="button-form-survay-peserta" data-code="{{$datas->event_data_code}}">
                                    <i class="fab fa-wpforms me-2 text-success"></i> Form Survey Peserta
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
        <!-- </div> -->
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
<!-- Modal Tambah Peserta Event -->
<div class="modal fade" id="modal-add-peserta" tabindex="-1" aria-labelledby="modalAddPesertaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddPesertaLabel"><i class="fas fa-user-plus me-2 text-primary"></i>Tambah Peserta Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Step 1: Pilih Sub Event & Sub Event Class -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-dark border-bottom pb-2 mb-3">1. Pilih Kelas Target</h6>
                        <div class="row g-3">
                            <!-- Dropdown Pilih Sub Event -->
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Sub Event <span class="text-danger">*</span></label>
                                <select class="form-select select-sub-event-target" required>
                                    <option value="">-- Pilih Sub Event --</option>
                                </select>
                            </div>

                            <!-- Dropdown Pilih Sub Event Class -->
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Sub Event Class <span class="text-danger">*</span></label>
                                <select class="form-select select-sub-class-target" required disabled>
                                    <option value="">-- Pilih Sub Event Dahulu --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Tab Navigasi Pilih Metode Input -->
                <h6 class="fw-bold text-dark mb-2">2. Pilih Metode Input Peserta</h6>
                <ul class="nav nav-tabs nav-justified mb-3" id="pesertaTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="manual-tab" data-bs-toggle="tab" data-bs-target="#tab-manual" type="button" role="tab" aria-controls="tab-manual" aria-selected="true">
                            <i class="fas fa-user-edit me-2 text-info"></i>Input Manual / Pilih Peserta
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="excel-tab" data-bs-toggle="tab" data-bs-target="#tab-excel" type="button" role="tab" aria-controls="tab-excel" aria-selected="false">
                            <i class="fas fa-file-excel me-2 text-success"></i>Import Excel Massal
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pesertaTabContent">
                    <!-- Tab 1: Form Input Manual / Pilih Existing -->
                    <div class="tab-pane fade show active" id="tab-manual" role="tabpanel" aria-labelledby="manual-tab">
                        <form id="form-add-peserta-manual">
                            @csrf
                            <input type="hidden" name="event_data_code" class="input_event_data_code">
                            <input type="hidden" name="id_event_data_sub_class" class="hidden_id_event_data_sub_class">

                            <!-- Radio Selection Mode Peserta -->
                            <div class="card border mb-3">
                                <div class="card-body p-3 bg-light">
                                    <label class="form-label fw-bold mb-2">Sumber Data Peserta:</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="participant_mode" id="mode_existing" value="existing" checked>
                                            <label class="form-check-label fw-bold text-primary" for="mode_existing">
                                                <i class="fas fa-database me-1"></i> Pilih dari Database (Terdaftar)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="participant_mode" id="mode_new" value="new">
                                            <label class="form-check-label fw-bold text-success" for="mode_new">
                                                <i class="fas fa-user-plus me-1"></i> Input Peserta Baru
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION A: PILIH PESERTA DARI DATABASE (EXISTING) -->
                            <div id="wrapper-existing-participant" class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label font-weight-bold">Cari Data Peserta <span class="text-danger">*</span></label>
                                    <select class="form-select select2-existing-participant" name="id_participant" style="width: 100%;">
                                        <option value="">-- Cari Nama / Email / No. HP Peserta --</option>
                                    </select>
                                    <small class="text-muted">Ketikkan nama, email, atau nomor HP peserta yang sudah tersimpan di database.</small>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label font-weight-bold">Status Pembayaran <span class="text-danger">*</span></label>
                                    <select class="form-select" name="payment_status_existing" required>
                                        <option value="paid" selected>PAID (Lunas)</option>
                                        <option value="pending">PENDING (Menunggu Pembayaran)</option>
                                        <option value="cancelled">CANCELLED (Dibatalkan)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECTION B: INPUT PESERTA BARU (NEW) -->
                            <div id="wrapper-new-participant" class="row g-3 d-none">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="full_name" placeholder="Masukkan nama peserta">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="contoh@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone_number" placeholder="08123456789">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Jenis Kelamin</label>
                                    <select class="form-select" name="gender">
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">NIK / No. KTP / Paspor</label>
                                    <input type="text" class="form-control" name="identity_number" placeholder="Nomor Identitas">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Instansi / Perusahaan</label>
                                    <input type="text" class="form-control" name="institution" placeholder="Nama instansi">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Status Pembayaran <span class="text-danger">*</span></label>
                                    <select class="form-select" name="payment_status">
                                        <option value="paid" selected>PAID (Lunas)</option>
                                        <option value="pending">PENDING (Menunggu Pembayaran)</option>
                                        <option value="cancelled">CANCELLED (Dibatalkan)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Alamat</label>
                                    <input type="text" class="form-control" name="address" placeholder="Alamat singkat">
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="btn-save-manual">
                                    <i class="fas fa-save me-1"></i> Simpan Peserta Manual
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Form Import Excel -->
                    <div class="tab-pane fade" id="tab-excel" role="tabpanel" aria-labelledby="excel-tab">
                        <form id="form-import-excel" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="event_data_code" class="input_event_data_code">
                            <input type="hidden" name="id_event_data_sub_class" class="hidden_id_event_data_sub_class">

                            <div class="alert alert-info d-flex align-items-center mb-3">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <div>
                                    <strong>Petunjuk Import Excel:</strong><br>
                                    Unggah file spreadsheet `.xlsx` atau `.csv`. Pastikan menggunakan format template yang sesuai.
                                    <br>
                                    <a href="{{ route('admin.peserta.download-template') }}" class="fw-bold text-decoration-underline text-dark me-2">
                                        <i class="fas fa-download me-1"></i>Download Template Excel
                                    </a>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Pilih File Excel (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="file_excel" accept=".xlsx, .xls, .csv" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Default Status Pembayaran untuk Semua Peserta Import <span class="text-danger">*</span></label>
                                <select class="form-select" name="default_payment_status" required>
                                    <option value="paid" selected>PAID (Lunas)</option>
                                    <option value="pending">PENDING (Menunggu Pembayaran)</option>
                                </select>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" id="btn-save-excel">
                                    <i class="fas fa-file-upload me-1"></i> Import Peserta Excel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-event-full-data" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="adminSurveyModalTitle">Kelola Survey Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <!-- Box Copy Link Survey Peserta -->
                <div class="alert alert-primary d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <small class="fw-bold d-block text-uppercase">Link Form Survey Peserta:</small>
                        <span id="labelSurveyUrl" class="fw-mono text-break small"></span>
                    </div>
                    <button class="btn btn-sm btn-light border text-primary fw-bold px-3 ms-2" onclick="copySurveyLink()">
                        <i class="fas fa-copy me-1"></i> Copy Link
                    </button>
                </div>

                <!-- Form Tambah Pertanyaan Baru -->
                <form id="formAddQuestion" class="card card-body bg-light border-0 mb-4 shadow-sm">
                    @csrf
                    <input type="hidden" id="admin_id_event_data" name="id_event_data">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-plus-circle me-1 text-success"></i> Tambah Pertanyaan Custom</h6>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="text" name="question" class="form-control" placeholder="Tuliskan Pertanyaan..." required>
                        </div>
                        <div class="col-md-4">
                            <select name="type" class="form-select" required>
                                <option value="rating">Rating (1-5 Bintang)</option>
                                <option value="text">Isian Teks / Uraian</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success btn-sm px-3 rounded-2">
                            <i class="fas fa-save me-1"></i> Simpan Pertanyaan
                        </button>
                    </div>
                </form>

                <!-- List Pertanyaan Yang Ada -->
                <h6 class="fw-bold mb-2">Daftar Pertanyaan Survey</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark small">
                            <tr>
                                <th width="50">No</th>
                                <th>Pertanyaan</th>
                                <th width="120">Tipe Input</th>
                                <th width="80" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="surveyQuestionsList" class="small">
                            <!-- Injected by JS -->
                        </tbody>
                    </table>
                </div>

            </div>
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
<!-- 2. Select2 JS (WAJIB SETELAH JQUERY) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data pasien / registrasi..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
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
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Pencarian Peserta Existing via AJAX
        function initParticipantSelect2() {
            $('.select2-existing-participant').select2({
                dropdownParent: $('#modal-add-peserta'),
                placeholder: '-- Cari Nama / Email / No HP --',
                allowClear: true,
                ajax: {
                    url: "{{ url('peserta/search-json') }}", // Sesuaikan dengan route pencarian peserta kamu
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // keyword pencarian
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: `${item.full_name} (${item.email} - ${item.phone_number || 'No HP -'})`,
                                    id: item.id_participant
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        // Toggle tampilan antara Pilih Peserta Ada vs Peserta Baru
        $('input[name="participant_mode"]').on('change', function() {
            let mode = $(this).val();
            if (mode === 'existing') {
                $('#wrapper-existing-participant').removeClass('d-none');
                $('#wrapper-new-participant').addClass('d-none');
            } else {
                $('#wrapper-existing-participant').addClass('d-none');
                $('#wrapper-new-participant').removeClass('d-none');
            }
        });

        // 1. Saat tombol trigger diklik -> Load Sub Event & Reset Form
        $(document).on('click', '.btn-trigger-add-peserta', function() {
            let eventCode = $(this).data('code');
            $('.input_event_data_code').val(eventCode);
            $('.hidden_id_event_data_sub_class').val('');

            // Reset radio ke existing & reset form
            $('#mode_existing').prop('checked', true).trigger('change');
            $('#form-add-peserta-manual')[0].reset();
            $('.select2-existing-participant').val(null).trigger('change');

            // Init/Re-init Select2
            initParticipantSelect2();

            // Reset dropdown sub event
            $('.select-sub-class-target').html('<option value="">-- Pilih Sub Event Dahulu --</option>').prop('disabled', true);

            // Load Sub Event via AJAX
            $.ajax({
                url: "{{ url('event/sub-events') }}/" + eventCode,
                type: "GET",
                success: function(response) {
                    let options = '<option value="">-- Pilih Sub Event --</option>';
                    $.each(response.data, function(key, val) {
                        options += `<option value="${val.event_data_sub_code}">${val.event_data_sub_name}</option>`;
                    });
                    $('.select-sub-event-target').html(options);
                },
                error: function() {
                    alert('Gagal mengambil data Sub Event.');
                }
            });
        });

        // 2. Saat Sub Event dipilih -> Load Sub Event Class
        $('.select-sub-event-target').on('change', function() {
            let subCode = $(this).val();
            $('.hidden_id_event_data_sub_class').val('');

            if (!subCode) {
                $('.select-sub-class-target').html('<option value="">-- Pilih Sub Event Dahulu --</option>').prop('disabled', true);
                return;
            }

            $('.select-sub-class-target').html('<option value="">Loading...</option>').prop('disabled', true);

            $.ajax({
                url: "{{ url('event/sub-classes-by-sub') }}/" + subCode,
                type: "GET",
                success: function(response) {
                    let options = '<option value="">-- Pilih Sub Event Class --</option>';
                    $.each(response.data, function(key, val) {
                        options += `<option value="${val.id_event_data_sub_class}">${val.event_data_sub_class_name} (Rp ${parseInt(val.event_data_sub_class_price).toLocaleString('id-ID')})</option>`;
                    });
                    $('.select-sub-class-target').html(options).prop('disabled', false);
                },
                error: function() {
                    alert('Gagal mengambil data Sub Event Class.');
                    $('.select-sub-class-target').html('<option value="">-- Gagal memuat data --</option>');
                }
            });
        });

        // 3. Sync id_event_data_sub_class
        $('.select-sub-class-target').on('change', function() {
            let selectedClassId = $(this).val();
            $('.hidden_id_event_data_sub_class').val(selectedClassId);
        });

        // 4. Submit Form Manual
        $('#form-add-peserta-manual').on('submit', function(e) {
            e.preventDefault();

            let subClassId = $('.hidden_id_event_data_sub_class').val();
            if (!subClassId) {
                Swal.fire('Peringatan', 'Silakan pilih Sub Event dan Sub Event Class terlebih dahulu!', 'warning');
                return;
            }

            let mode = $('input[name="participant_mode"]:checked').val();
            if (mode === 'existing' && !$('.select2-existing-participant').val()) {
                Swal.fire('Peringatan', 'Silakan pilih peserta terdaftar terlebih dahulu!', 'warning');
                return;
            }

            let btnSave = $('#btn-save-manual');
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: "{{ route('admin.peserta.store-manual') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Peserta');
                    if (response.status === 'success') {
                        $('#modal-add-peserta').modal('hide');
                        $('#form-add-peserta-manual')[0].reset();
                        $('.select2-existing-participant').val(null).trigger('change');
                        Swal.fire('Berhasil!', response.message, 'success');
                        if (typeof table !== 'undefined') table.ajax.reload();
                        else location.reload();
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Peserta');
                    let res = xhr.responseJSON;
                    Swal.fire('Gagal Simpan', res && res.message ? res.message : 'Terjadi kesalahan sistem.', 'error');
                }
            });
        });

        // 5. Submit Form Import Excel
        $('#form-import-excel').on('submit', function(e) {
            e.preventDefault();

            let subClassId = $('.hidden_id_event_data_sub_class').val();
            if (!subClassId) {
                Swal.fire('Peringatan', 'Silakan pilih Sub Event dan Sub Event Class terlebih dahulu!', 'warning');
                return;
            }

            let formData = new FormData(this);
            let btnSave = $('#btn-save-excel');
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Mengimport Data...');

            $.ajax({
                url: "{{ route('admin.peserta.import-excel') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-file-upload me-1"></i> Import Peserta Excel');
                    if (response.status === 'success') {
                        $('#modal-add-peserta').modal('hide');
                        $('#form-import-excel')[0].reset();
                        Swal.fire('Berhasil!', response.message, 'success');
                        if (typeof table !== 'undefined') table.ajax.reload();
                        else location.reload();
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-file-upload me-1"></i> Import Peserta Excel');
                    let res = xhr.responseJSON;
                    Swal.fire('Gagal Import', res && res.message ? res.message : 'Terjadi kesalahan sistem.', 'error');
                }
            });
        });
    });
</script>
<script>
    var currentSurveyUrl = "";

    $(document).on('click', '#button-form-survay-peserta', function(e) {
        e.preventDefault();
        let eventCode = $(this).data('code');
        let fetchUrl = "{{ route('event.survey.manage', ':code') }}".replace(':code', eventCode);

        loadSurveyData(fetchUrl);
    });

    function loadSurveyData(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#adminSurveyModalTitle').text('Kelola Survey: ' + res.event.event_data_tittle);
                    $('#admin_id_event_data').val(res.event.id_event_data);

                    currentSurveyUrl = res.survey_url;
                    $('#labelSurveyUrl').text(res.survey_url);

                    let rows = '';
                    if (res.surveys.length > 0) {
                        $.each(res.surveys, function(i, item) {
                            rows += `<tr>
                            <td class="text-center">${i + 1}</td>
                            <td>${item.question}</td>
                            <td><span class="badge bg-info text-dark">${item.type.toUpperCase()}</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger py-0 px-2" onclick="deleteQuestion(${item.id_event_survey}, '${url}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="4" class="text-center text-muted py-3">Belum ada pertanyaan dibuat.</td></tr>`;
                    }
                    $('#surveyQuestionsList').html(rows);
                }
            }
        });
    }

    // Tambah Pertanyaan
    $('#formAddQuestion').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('event.survey.store_question') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                $('#formAddQuestion')[0].reset();
                let eventCode = $('#button-form-survay-peserta').data('code');
                loadSurveyData("{{ route('event.survey.manage', ':code') }}".replace(':code', eventCode));
            }
        });
    });

    // Hapus Pertanyaan
    function deleteQuestion(id, reloadUrl) {
        if (confirm('Hapus pertanyaan ini?')) {
            let deleteUrl = "{{ route('event.survey.delete_question', ':id') }}".replace(':id', id);
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    loadSurveyData(reloadUrl);
                }
            });
        }
    }

    // Copy Link Survey
    function copySurveyLink() {
        navigator.clipboard.writeText(currentSurveyUrl);
        alert('Link survey berhasil disalin!');
    }
</script>
@endsection
