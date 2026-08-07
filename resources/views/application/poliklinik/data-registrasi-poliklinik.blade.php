@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(239, 242, 246, 0.5) !important;
    }

    .patient-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #2c7be5;
    }
</style>
@endsection

@section('content')
<!-- Banner Header -->
<div class="card mb-3 overflow-hidden">
    <div class="card-header position-relative bg-light">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="d-flex align-items-center">
                    <img class="me-3" src="{{ asset('img/poliklikink.png') }}" alt="Poli Logo" width="60" />
                    <div>
                        <span class="badge bg-soft-primary text-primary mb-1">
                            <i class="fas fa-hospital-user me-1"></i> {{ env('APP_LABEL', 'HIS') }} System
                        </span>
                        <h4 class="mb-0 text-primary fw-bold">Pendaftaran Poliklinik</h4>
                        <p class="text-500 fs--1 mb-0">Kelola dan proses pendaftaran pasien poliklinik secara real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <button class="btn btn-falcon-default btn-sm me-1" onclick="window.location.href='{{ url()->current() }}';" data-bs-toggle="tooltip" title="Refresh Data">
                    <span class="fas fa-sync-alt text-primary"></span> Refresh
                </button>
                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                    <span class="fas fa-filter me-1"></span> Filter Dokter & Tanggal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Panel Filter & Filter Jadwal Dokter -->
<div class="collapse mb-3 show" id="filterCollapse">
    <div class="card card-body bg-light">
        <form id="form-filter" method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fs--1 fw-semi-bold">Rentang Tanggal Registrasi</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input class="form-control form-control-sm" id="filter-date-range" name="date_range" type="text"
                            placeholder="Pilih Rentang Tanggal" value="{{ request('date_range', $startDate . ' to ' . $endDate) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs--1 fw-semi-bold">Filter Dokter (Jadwal Hari Ini)</label>
                    <select class="form-select form-select-sm js-choice" id="filter-dokter" name="doctor_code">
                        <option value="">-- Semua Dokter --</option>
                        @foreach ($doctors as $doc)
                        <option value="{{ $doc->master_doctor_code }}" {{ request('doctor_code') == $doc->master_doctor_code ? 'selected' : '' }}>
                            {{ $doc->master_doctor_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <span class="fas fa-search me-1"></span> Cari
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-soft-secondary btn-sm w-100">
                        <span class="fas fa-undo me-1"></span> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Table Card -->
<div class="card mb-3">
    <div class="card-body p-0">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-100">
            <h6 class="mb-0 text-700 fw-bold">
                <i class="fas fa-list me-1 text-primary"></i> Daftar Antrean Pasien
            </h6>
            <span class="badge bg-soft-info text-info rounded-pill fs--1">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            </span>
        </div>

        <div class="table-responsive p-3">
            <table id="example" class="table table-hover table-striped align-middle fs--1 w-100">
                <thead class="bg-200 text-800">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center" style="width: 10%">No Antrean</th>
                        <th style="width: 18%">Info Registrasi</th>
                        <th style="width: 22%">Data Pasien</th>
                        <th style="width: 15%">Layanan Poli</th>
                        <th style="width: 12%">Dokter</th>
                        <th class="text-center" style="width: 10%">Status</th>
                        <th class="text-center" style="width: 8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $datas)
                    @php
                    $user = DB::table('user_mains')
                    ->select('fullname')
                    ->where('userid', $datas->d_reg_order_poli_user)
                    ->first();
                    @endphp
                    <tr>
                        <td class="text-center fw-semi-bold">{{ $index + 1 }}</td>

                        <!-- No Antrean Pasien -->
                        <td class="text-center">
                            <span class="badge bg-soft-primary text-primary fs-0 px-3 py-2 border border-primary border-opacity-25">
                                <i class="fas fa-list-ol me-1"></i> {{ $datas->d_reg_order_poli_queue ?? '-' }}
                            </span>
                        </td>

                        <!-- Info Registrasi -->
                        <td>
                            <div class="fw-bold text-primary">{{ $datas->d_reg_order_code }}</div>
                            <div class="text-500 fs--2"><i class="fas fa-barcode me-1"></i>{{ $datas->d_reg_order_poli_code }}</div>
                            <div class="mt-1">
                                @if ($user)
                                <span class="badge bg-soft-secondary text-secondary fs--2">
                                    <i class="fas fa-user-edit me-1"></i>{{ $user->fullname }}
                                </span>
                                @else
                                <span class="badge bg-soft-danger text-danger fs--2">Unknown</span>
                                @endif
                            </div>
                        </td>

                        <!-- Data Pasien -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="patient-avatar me-2 fs--1">
                                    {{ strtoupper(substr($datas->master_patient_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $datas->master_patient_name }}</div>
                                    <div class="text-600 fs--2">
                                        <span class="badge bg-soft-primary text-primary">{{ $datas->master_patient_code }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Layanan & Tanggal -->
                        <td>
                            <div class="fw-semi-bold text-800">{{ $datas->t_layanan_data_name }}</div>
                            <div class="text-500 fs--2">
                                <i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($datas->d_reg_order_date)->format('d/m/Y H:i') }}
                            </div>
                        </td>

                        <!-- Dokter -->
                        <td>
                            <div class="fw-semi-bold text-900">
                                <i class="fas fa-user-md me-1 text-primary"></i>{{ $datas->master_doctor_name }}
                            </div>
                        </td>

                        <!-- Status Badge Modern -->
                        <td class="text-center">
                            @switch($datas->d_reg_order_poli_status)
                            @case(0)
                            <span class="badge bg-soft-danger text-danger"><i class="fas fa-clock me-1"></i>Belum</span>
                            @break
                            @case(1)
                            <span class="badge bg-soft-warning text-warning"><i class="fas fa-spinner fa-spin me-1"></i>Proses Handling</span>
                            @break
                            @case(2)
                            <span class="badge bg-soft-info text-info"><i class="fas fa-user-check me-1"></i>Verifikasi</span>
                            @break
                            @case(3)
                            <span class="badge bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Selesai</span>
                            @break
                            @case(4)
                            <span class="badge bg-soft-dark text-dark"><i class="fas fa-paper-plane me-1"></i>Terkirim</span>
                            @break
                            @default
                            <span class="badge bg-soft-secondary text-secondary">-</span>
                            @endswitch
                        </td>

                        <!-- Action Dropdown -->
                        <td class="text-center">
                            <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button"
                                    id="order-dropdown-{{ $index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-ellipsis-h fs--1"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-{{ $index }}">
                                    <div class="bg-white py-2">
                                        @if ($datas->d_reg_order_poli_status == 0)
                                        <a class="dropdown-item text-primary fw-semi-bold" href="#"
                                            data-bs-toggle="modal" data-bs-target="#modal-poliklinik"
                                            id="button-proses-handling" data-code="{{ $datas->d_reg_order_poli_code }}">
                                            <i class="fas fa-stethoscope me-2"></i>Proses Handling Pasien
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        @endif
                                        <a class="dropdown-item text-600" href="#"
                                            data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                            id="button-data-barang-cabang" data-code="{{ $datas->d_reg_order_poli_code }}">
                                            <i class="fas fa-history me-2"></i>Riwayat Pasien
                                        </a>
                                    </div>
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
<!-- Modals -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        var table = $('#example').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari No Reg, Pasien, atau Dokter...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                }
            },
            dom: "<'row mb-2'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });

        // Inisialisasi Flatpickr Range Mode
        flatpickr("#filter-date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            disableMobile: true
        });
    });

    // AJAX Request Handling Pasien
    $(document).on("click", "#button-proses-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-poliklinik').html(
            '<div class="py-5 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-600 fs--1">Memuat Data Pasien...</p></div>'
        );
        $.ajax({
            url: "{{ route('data_registrasi_poli_handling') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-poliklinik').html(data);
        }).fail(function() {
            $('#menu-poliklinik').html('<div class="alert alert-danger m-3">Gagal memuat data. Silakan coba lagi.</div>');
        });
    });

    // Submit Handling
    $(document).on("click", "#button-handling-pasien-poliklinik", function(e) {
        e.preventDefault();
        var data = $("#form-fisik-umum").serialize();
        $('#menu-handling-pasien-poliklinik').html(
            '<div class="spinner-border text-primary float-end" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('data_registrasi_poli_handling_pasien') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-pasien-poliklinik').html(data);
            setTimeout(() => {
                location.reload();
            }, 400);
        }).fail(function() {
            $('#menu-handling-pasien-poliklinik').html('<span class="text-danger">Terjadi kesalahan pada server.</span>');
        });
    });
</script>
@endsection
