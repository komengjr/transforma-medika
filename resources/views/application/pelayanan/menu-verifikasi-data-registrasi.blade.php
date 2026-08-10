@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    /* Banner Header Dark Modern */
    .banner-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 12px;
    }

    .system-badge {
        background-color: #ff6b35;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 4px;
        letter-spacing: 0.5px;
    }

    /* Filter Area Light Blue-Gray Container */
    .filter-container {
        background-color: #c5d2e0;
        border-radius: 12px;
        padding: 16px;
    }

    /* Table Design Exact Match */
    .table-custom-blue {
        /* background-color: #ffffff; */
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table-custom-blue thead th {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        font-size: 0.7rem !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 10px !important;
        border: none !important;
        vertical-align: middle;
    }

    .table-custom-blue tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .table-custom-blue tbody tr:hover {
        background-color: #f8fafc;
    }

    .table-custom-blue tbody td {
        padding: 12px 10px !important;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.8rem;
    }

    /* Micro Components Match */
    .avatar-purple {
        width: 32px;
        height: 32px;
        background-color: #8b5cf6;
        color: #ffffff;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .badge-reg-code {
        color: #2563eb;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .badge-user-info {
        background-color: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
        margin-top: 2px;
    }

    .gender-tag-blue {
        color: #2563eb;
        font-weight: 700;
        font-size: 0.75rem;
        margin-left: 4px;
    }

    .gender-tag-red {
        color: #ef4444;
        font-weight: 700;
        font-size: 0.75rem;
        margin-left: 4px;
    }

    .badge-category-cyan {
        background-color: #0ea5e9;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .badge-layanan-outline {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-date-dark {
        background-color: #0f172a;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-more {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-action-more:hover {
        background-color: #f1f5f9;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Match -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 banner-header text-white p-3 shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-10">
                        <img src="{{ asset('img/list-pasien.png') }}" alt="Icon" width="40" height="40" class="img-fluid" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="system-badge"><i class="fas fa-bolt me-1"></i>LIVE SYSTEM</span>
                            <span class="text-white-50 fs--2">v2.4 Medical Suite</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0">
                            Welcome to Innoventra <span class="fw-normal text-info">Management System</span>
                        </h4>
                    </div>
                </div>
                <div>
                    <button class="btn btn-light text-primary fw-bold btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fas fa-list-ul me-1"></i> List Pasien
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Table Container -->

<!-- Action Buttons Top Bar -->


<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="card-header bg-primary">
        <div class="row align-items-center justify-content-between ">
            <div class="col-auto d-flex align-items-center gap-2">
                <button class="btn btn-dark btn-sm rounded-3 fw-semibold shadow-sm px-3" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh Data
                </button>
                <button class="btn btn-danger btn-sm rounded-3 fw-semibold border-0 shadow-sm px-3">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-0 text-primary"><i class="fas fa-calendar-alt"></i></span>
                    <input class="form-control datetimepicker border-0 bg-white shadow-sm" id="timepicker3" type="text" placeholder="Filter Rentang Tanggal..."
                        data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' style="width: 200px;" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-custom-blue align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">NO</th>
                        <th>NO. REGISTRASI & PETUGAS</th>
                        <th>NAMA PASIEN</th>
                        <th>TEMPAT, TGL LAHIR</th>
                        <th>KATEGORI PASIEN</th>
                        <th>LAYANAN</th>
                        <th>TANGGAL REG</th>
                        <th class="text-center" style="width: 50px;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="fw-medium text-secondary">
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    @php
                    $user = DB::table('user_mains')->select('fullname')->where('userid', $datas->d_reg_order_user)->first();
                    $initial = strtoupper(substr($datas->master_patient_name, 0, 1));
                    $gender = isset($datas->master_patient_gender) ? $datas->master_patient_gender : 'L'; // Fallback
                    @endphp
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $no++ }}</td>
                        <td>
                            <div class="badge-reg-code">{{ $datas->d_reg_order_code }}</div>
                            <div class="badge-user-info">
                                <i class="fas fa-user me-1"></i>{{ $user ? $user->fullname : 'Unknown' }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-purple">{{ $initial }}</div>
                                <div>
                                    <div class="fw-bold text-dark d-inline-block">{{ $datas->master_patient_name }}</div>
                                    <span class="{{ $gender == 'L' ? 'gender-tag-blue' : 'gender-tag-red' }}">
                                        {{ $gender }}
                                    </span>
                                    <div class="text-muted fs--2">
                                        RM: {{ $datas->master_patient_norm ?? 'MPP20250704020259' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fs--1">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $datas->master_patient_tempat_lahir }}
                            </div>
                            <div class="text-muted fs--2">{{ $datas->master_patient_tgl_lahir }}</div>
                        </td>
                        <td>
                            <span class="badge-category-cyan">
                                <i class="fas fa-id-card me-1"></i>{{ strtoupper($datas->t_pasien_cat_name) }}
                            </span>
                        </td>
                        <td>
                            @php
                            $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)
                            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                            ->get();
                            @endphp
                            <div class="d-flex flex-column gap-1">
                                @foreach ($layanan as $layanans)
                                <div>
                                    <span class="badge-layanan-outline">
                                        <i class="fas fa-stethoscope"></i> {{ strtoupper($layanans->t_layanan_cat_name) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <span class="badge-date-dark">
                                <i class="far fa-clock"></i> {{ $datas->d_reg_order_date }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn-action-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 py-2 fs--1">
                                    <li>
                                        <button class="dropdown-item text-primary py-2" data-bs-toggle="modal" data-bs-target="#modal-registrasi" id="button-verifikasi-data-registrasi" data-code="{{ $datas->d_reg_order_code }}">
                                            <i class="fas fa-user-shield me-2"></i> Verifikasi Data
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-1">
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger py-2" id="button-data-pembatalan-registrasi" data-code="{{ $datas->d_reg_order_code }}">
                                            <i class="fas fa-ban me-2"></i> Pembatalan Registrasi
                                        </button>
                                    </li>
                                </ul>
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
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" >
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <!-- <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true,
        language: {
            searchPlaceholder: "Cari nama, RM, atau No Reg...",
            search: "",
            lengthMenu: "Tampilkan _MENU_ data"
        }
    });
</script>
<script>
    $(document).on("click", "#button-verifikasi-data-registrasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-registrasi').html(
            '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted fs--1">Memuat data registrasi...</p></div>'
        );
        $.ajax({
            url: "{{ route('menu_pelayanan_verifikasi_registrasi_data') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi').html(data);
        }).fail(function() {
            $('#menu-registrasi').html('<div class="alert alert-danger m-3">Terjadi kesalahan saat memuat data.</div>');
        });
    });

    $(document).on("click", "#button-data-pembatalan-registrasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-danger px-4 rounded-pill ms-2",
                cancelButton: "btn btn-light px-4 rounded-pill"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Batalkan Registrasi?",
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Tolak!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('menu_pelayanan_verifikasi_pembatalan_registrasi') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: data,
                        icon: "success"
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }).fail(function() {
                    swalWithBootstrapButtons.fire({
                        title: "Gagal",
                        text: "Terjadi kesalahan sistem.",
                        icon: "error"
                    });
                });
            }
        });
    });
</script>
@endsection
