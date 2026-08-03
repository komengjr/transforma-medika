@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* ==========================================
     * RADIOLOGY & X-RAY THEME CUSTOM CSS
     * ========================================== */
    :root {
        --rad-dark-bg: #0f172a;
        --rad-card-bg: #1e293b;
        --rad-accent-cyan: #38bdf8;
        --rad-glow-cyan: rgba(56, 189, 248, 0.35);
    }

    /* Hero Header Radiologi */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-radius: 14px;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.35);
        position: relative;
        overflow: hidden;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -30px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, var(--rad-glow-cyan) 0%, transparent 75%);
        pointer-events: none;
    }

    /* Card Table Frame */
    .rad-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .rad-card-header {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-bottom: 2px solid #0284c7;
        padding: 14px 20px;
    }

    /* Table Radiology Custom Styling */
    .table-radiologi thead th {
        background-color: #f8fafc !important;
        color: #334155 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.6px;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 10px;
    }

    .table-radiologi tbody tr {
        transition: all 0.2s ease;
    }

    .table-radiologi tbody tr.row-clickable {
        cursor: pointer;
    }

    .table-radiologi tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .table-radiologi tbody tr:hover td .patient-name {
        color: #0284c7 !important;
    }

    /* Code Chips */
    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: inline-block;
    }

    .code-chip-cyan {
        background-color: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }

    /* Modals Custom Styling */
    .modal-content.rad-modal {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(56, 189, 248, 0.3);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.5);
    }

    /* Flatpickr Input Custom */
    .rad-date-input {
        border-radius: 20px !important;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
    }

    .rad-date-input::placeholder {
        color: #cbd5e1 !important;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-3">
    <div class="col-12">
        <div class="rad-hero-header p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3 border border-white-50 d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px; backdrop-filter: blur(8px);">
                        <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="40" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem; color: #38bdf8;">
                                <i class="fas fa-radiation me-1"></i> TRANS MANAGEMENT SYSTEM
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.3rem;">
                            Welcome to <span style="color: #38bdf8;">Management System</span>
                        </h4>
                        <p class="text-white-50 mb-0 small" style="font-size: 0.75rem;">Modul Verifikasi & Processing Hasil Pemeriksaan Radiologi</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 border border-info border-opacity-30 px-3 py-2 rounded-pill backdrop-blur">
                        <span class="text-info fw-bold mb-0" style="font-size: 0.9rem; color: #38bdf8 !important;">
                            <i class="fas fa-notes-medical me-2"></i>Radiologi : Data Registrasi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="rad-card mb-4">
    <div class="rad-card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                    onclick="location.reload();"
                    data-bs-toggle="tooltip"
                    title="Refresh Data"
                    style="width: 32px; height: 32px;">
                    <i class="fas fa-redo-alt text-info"></i>
                </button>
                <span class="text-white-50">|</span>
                <span class="fw-bold fs--1 text-white">
                    <i class="fas fa-list-alt me-1 text-info"></i> Data Antrean & Verifikasi Hasil Radiologi
                </span>
            </div>

            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-dark border-secondary text-info"><i class="fas fa-calendar-alt"></i></span>
                    <input class="form-control datetimepicker ps-2 rad-date-input" id="timepicker3" type="text" placeholder="Filter Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/Y","disableMobile":true,"locale":"en"}' />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-hover align-middle table-radiologi w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">No</th>
                        <th>No Registrasi</th>
                        <th>Nama Pasien</th>
                        <th>Kategori Pasien</th>
                        <th>Tanggal Reg</th>
                        <th>Dokter Rujukan</th>
                        <th class="text-center">Status Pembayaran</th>
                        <th class="text-center">Status Reg</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    @php
                    $user = DB::table('user_mains')
                    ->select('fullname')
                    ->where('userid', $datas->d_reg_order_rad_user)
                    ->first();

                    $pasien = DB::table('t_pasien_cat')
                    ->where('t_pasien_cat_code', $datas->t_pasien_cat_code)
                    ->first();

                    $dokter = DB::table('master_doctor')
                    ->where('master_doctor_code', $datas->d_reg_order_rad_dr_rujukan)
                    ->first();

                    $payment = DB::table('d_reg_order_payment')
                    ->where('d_reg_order_list_code', $datas->d_reg_order_rad_code)
                    ->first();
                    @endphp
                    <tr class="row-clickable"
                        id="button-verifikasi-hasil"
                        data-code="{{ $datas->d_reg_order_code }}"
                        data-reg="{{ $datas->d_reg_order_rad_code }}"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-radiologi-full">

                        <td class="text-center fw-bold text-secondary">{{ $no++ }}</td>
                        <td>
                            <div class="mb-1">
                                <span class="code-chip text-dark fs--2">{{ $datas->d_reg_order_code }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="code-chip code-chip-cyan fs--2">{{ $datas->d_reg_order_rad_code }}</span>
                            </div>
                            <div>
                                @if ($user)
                                <span class="badge bg-soft-primary text-primary fs--2"><i class="fas fa-user me-1"></i>{{ $user->fullname }}</span>
                                @else
                                <span class="badge bg-soft-secondary text-secondary fs--2">Unknown</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark patient-name transition-base">{{ $datas->master_patient_name }}</div>
                        </td>
                        <td>
                            @if ($pasien)
                            <span class="badge bg-soft-info text-info fw-bold">{{ $pasien->t_pasien_cat_name }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-secondary"><i class="far fa-clock me-1 text-info"></i>{{ \Carbon\Carbon::parse($datas->d_reg_order_rad_date)->format('d/m/Y H:i') }}</span>
                        </td>
                        <td>
                            @if ($dokter)
                            <div class="fw-semibold text-dark">
                                {{ $dokter->master_doctor_title_f }} {{ $dokter->master_doctor_name }} {{ $dokter->master_doctor_title_e }}
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center" onclick="event.stopPropagation();">
                            @if ($payment)
                            <span class="badge rounded-pill bg-soft-success text-success px-2 py-1"><i class="fas fa-check-circle me-1"></i>Lunas</span>
                            @else
                            <span class="badge rounded-pill bg-soft-danger text-danger px-2 py-1"><i class="fas fa-times-circle me-1"></i>Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-center" onclick="event.stopPropagation();">
                            @if ($datas->d_reg_order_rad_status == 0)
                            <span class="badge rounded-pill bg-soft-warning text-warning px-2 py-1"><i class="fas fa-hourglass-half me-1"></i>Belum Diproses</span>
                            @else
                            <span class="badge rounded-pill bg-soft-success text-success px-2 py-1"><i class="fas fa-check me-1"></i>Selesai</span>
                            @endif
                        </td>
                        <td class="text-center" onclick="event.stopPropagation();">
                            <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-sm btn-outline-info rounded-pill dropdown-toggle px-3" type="button" id="dropdownMenuButton{{ $no }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog me-1"></i>Menu
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border shadow-sm py-2" aria-labelledby="dropdownMenuButton{{ $no }}">
                                    <a class="dropdown-item text-primary fw-semibold" href="javascript:void(0)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-radiologi"
                                        id="button-proses-handling"
                                        data-code="{{ $datas->d_reg_order_rad_code }}">
                                        <i class="fas fa-dna me-2 text-info"></i>Proses Verifikasi Pasien
                                    </a>
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
<!-- Modals Section -->
<div class="modal fade" id="modal-radiologi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalRadiologiFullLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi-full" class="p-3"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalRadiologiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi" class="p-3"></div>
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
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari No Reg / Nama Pasien...",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data registrasi radiologi",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Data kosong",
                infoFiltered: "(difilter dari total _MAX_ data)"
            },
            pageLength: 10,
            dom: "<'row p-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

    // Event Handler: Verifikasi Hasil Detail (Click Row)
    $(document).on("click", "#button-verifikasi-hasil", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        $('#menu-radiologi-full').html(`
            <div class="text-center my-5 py-4">
                <div class="spinner-border text-info" role="status" style="width: 3.5rem; height: 3.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="mt-3 fw-bold text-dark">Memuat Detail Verifikasi Hasil Radiologi...</h6>
                <p class="text-muted small mb-0">Mohon tunggu sebentar, data pemeriksaan sedang disiapkan.</p>
            </div>
        `);

        $.ajax({
            url: "{{ route('hasil_radiologi_verifikasi_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-radiologi-full').html(data);
        }).fail(function() {
            $('#menu-radiologi-full').html(`
                <div class="alert alert-danger border-0 rounded-3 text-center my-4 p-4" role="alert">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6>Gagal Memuat Detail Verifikasi</h6>
                    <p class="mb-0 small">Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.</p>
                </div>
            `);
        });
    });

    // Event Handler: Preview Report
    $(document).on("click", "#button-verifikasi-preview-report", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        $('#view-map').html(`
            <div class="text-center my-4 py-3">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted small mt-2 mb-0">Menyiapkan Preview Laporan Hasil...</p>
            </div>
        `);

        $.ajax({
            url: "{{ route('verifikasi_radiologi_preview_report') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#button-verifikasi-hasil-rad').show();
            $('#view-map').html(`
                <iframe src="data:application/pdf;base64, ${data}" style="width:100%; height:533px;" frameborder="0" class="rounded-3 shadow-sm"></iframe>
            `);
        }).fail(function() {
            $('#view-map').html(`
                <div class="alert alert-danger border-0 rounded-3 text-center my-3 p-3">
                    <i class="fas fa-exclamation-circle me-2"></i>Gagal memuat pratinjau dokumen PDF.
                </div>
            `);
        });
    });

    // Event Handler: Action Verifikasi Final (SweetAlert)
    $(document).on("click", "#button-verifikasi-hasil-rad", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        Swal.fire({
            title: "Konfirmasi Verifikasi?",
            text: "Apakah Anda yakin ingin memverifikasi hasil pemeriksaan radiologi ini?",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#0284c7",
            cancelButtonColor: "#dc2626",
            confirmButtonText: "<i class='fas fa-check me-1'></i> Ya, Verifikasi!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Dokumen laporan telah diverifikasi.",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#menu-verifikasi-hasil').html(`
                    <div class="text-center my-3 py-2">
                        <div class="spinner-border text-info" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('hasil_radiologi_verifikasi_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "reg": reg,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-verifikasi-hasil').html(data);
                    location.reload();
                }).fail(function() {
                    $('#menu-verifikasi-hasil').html(`
                        <div class="alert alert-danger text-center my-2">Gagal menyimpan verifikasi data.</div>
                    `);
                });
            }
        });
    });
</script>
@endsection
