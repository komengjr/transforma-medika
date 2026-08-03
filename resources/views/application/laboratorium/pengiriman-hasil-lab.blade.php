@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Styling Banner Header */
    .welcome-banner {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 0.75rem;
    }

    /* Custom Table Row Hover Effect */
    .table-shipping tbody tr {
        transition: background-color 0.15s ease-in-out;
    }

    .table-shipping tbody tr:hover {
        background-color: rgba(44, 123, 229, 0.03) !important;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Modern -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card welcome-banner border-0 shadow-sm text-white overflow-hidden">
            <div class="card-body p-3 p-md-4">
                <div class="row align-items-center gy-3">
                    <div class="col-md-7 col-lg-8 d-flex align-items-center">
                        <div class="avatar avatar-3xl bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                            <i class="fab fa-whatsapp text-success fs-2"></i>
                        </div>
                        <div>
                            <span class="badge bg-success bg-opacity-20 text-white border border-success border-opacity-25 rounded-pill px-3 py-1 fs--2 mb-1">
                                Trans Management System
                            </span>
                            <h4 class="text-white fw-extrabold mb-0">Laboratorium <span class="fw-normal text-300">| Pengiriman Hasil Pasien</span></h4>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 text-md-end">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur px-3 py-2 rounded-3 border border-white border-opacity-10">
                            <i class="fas fa-paper-plane text-info fs-1 me-3"></i>
                            <div class="text-start">
                                <div class="fs--2 text-success text-uppercase fw-semi-bold">WhatsApp Gateway</div>
                                <div class="fw-bold fs--1 text-dark"><i class="fas fa-circle text-success fs--2 me-1"></i> System Active</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card Container -->
<div class="card shadow-sm border-0 rounded-3 mb-3">
    <!-- Toolbar Header -->
    <div class="card-header border-bottom py-3 px-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <!-- Left Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-falcon-default" type="button" onclick="location.reload();" data-bs-toggle="tooltip" title="Refresh Data">
                    <i class="fas fa-redo-alt text-primary me-1"></i> <span class="d-none d-sm-inline-block">Refresh</span>
                </button>

                <button class="btn btn-sm btn-success shadow-sm" type="button" id="button-add-pengiriman" data-bs-toggle="modal" data-bs-target="#modal-whatsapp">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Pengiriman
                </button>
            </div>

            <!-- Right Date Filter -->
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-primary">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <input class="form-control datetimepicker bg-white border-start-0" id="timepicker3" type="text" placeholder="Filter Tanggal Kirim..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                </div>
            </div>
        </div>
    </div>

    <!-- Card Body & Data Table -->
    <div class="card-body p-3">
        <div class="table-responsive scrollbar">
            <table id="example" class="table table-striped table-bordered align-middle table-shipping fs--1 mb-0 w-100">
                <thead class="bg-200 text-800">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 15%;">No. Registrasi</th>
                        <th style="width: 25%;">Nama Pasien</th>
                        <th style="width: 20%;">No. WhatsApp</th>
                        <th style="width: 20%;">Tanggal Kirim</th>
                        <th class="text-center" style="width: 15%;">Status Kirim</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td class="text-center fw-bold text-600">{{ $no++ }}</td>
                        <td>
                            <span class="badge bg-soft-primary text-primary fw-semi-bold">
                                <i class="fas fa-hashtag me-1"></i>{{ $datas->d_reg_order_lab_code }}
                            </span>
                        </td>
                        <td class="fw-bold text-800">
                            <i class="fas fa-user-circle me-2 text-secondary"></i>{{ $datas->v_log_whatsapp_name }}
                        </td>
                        <td>
                            <span class="badge bg-soft-success text-success fw-semi-bold fs--2">
                                <i class="fab fa-whatsapp me-1 fs-0"></i>{{ $datas->v_log_whatsapp_number }}
                            </span>
                        </td>
                        <td class="text-700 fs--2">
                            <i class="fas fa-clock text-400 me-1"></i>{{ $datas->v_log_whatsapp_date }}
                        </td>
                        <td class="text-center">
                            @if ($datas->v_log_whatsapp_status == 0)
                            <span class="badge rounded-pill bg-soft-danger text-danger border border-danger border-opacity-25 px-2.5 py-1">
                                <i class="fas fa-times-circle me-1"></i>Belum Terkirim
                            </span>
                            @else
                            <span class="badge rounded-pill bg-soft-success text-success border border-success border-opacity-25 px-2.5 py-1">
                                <i class="fas fa-check-circle me-1"></i>Terkirim
                            </span>
                            @endif
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
<!-- Modal Containers -->
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-lab-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-whatsapp" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-whatsapp"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).ready(function() {

        // Modal Event Tambah Pengiriman
        $(document).on("click", "#button-add-pengiriman", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            $('#menu-whatsapp').html(
                '<div class="card shadow-sm border-0 py-5 text-center">' +
                '<div class="card-body">' +
                '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div>' +
                '<p class="fs--1 text-600 mb-0">Memuat form pengiriman WhatsApp...</p>' +
                '</div>' +
                '</div>'
            );

            $.ajax({
                url: "{{ route('pengiriman_hasil_laboratorium_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-whatsapp').html(data);
            }).fail(function() {
                $('#menu-whatsapp').html(
                    '<div class="alert alert-danger shadow-sm border-0 text-center m-3" role="alert">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan sistem saat memuat form.' +
                    '</div>'
                );
            });
        });

    });
</script>
@endsection
