@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    /* Inputs, Selects & Filters */
    .retro-input,
    .form-control {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
    }

    .retro-input:focus,
    .form-control:focus {
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Styling Hover Baris Tabel */
    .table-hover-clickable tbody tr {
        cursor: pointer;
        transition: background 0.1s;
    }

    .table-hover-clickable tbody tr:hover td {
        background-color: var(--retro-yellow) !important;
    }

    /* ========================================================= */
    /* TABEL DENGAN GARIS TEGAS PADA SETIAP KOLOM & BARIS         */
    /* ========================================================= */
    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        letter-spacing: 0.5px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-shield-alt me-1"></i> v2.4 Medical Suite
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-file-signature me-1 text-warning"></i> Verifikasi Hasil Laboratorium
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CARD DATA TABLE -->
<div class="retro-card mb-4">
    <!-- TOOLBAR HEADER & FILTER -->
    <div class="card-header bg-white border-bottom border-dark py-3 px-3">
        <div class="row align-items-center g-2">
            <!-- Action Button -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button class="btn btn-sm retro-btn retro-btn-primary px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    onclick="location.reload()" data-bs-toggle="tooltip" title="Refresh Data">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-bold ms-1">Refresh Data</span>
                </button>
            </div>

            <!-- FILTER KUSTOM -->
            <div class="col-12 col-md">
                <div class="row g-2 align-items-center">
                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label class="fw-bold text-dark fs--2 mb-1 d-block">Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker retro-input" id="filter_tgl_awal" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label class="fw-bold text-dark fs--2 mb-1 d-block">Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker retro-input" id="filter_tgl_akhir" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label class="fw-bold text-dark fs--2 mb-1 d-block">Cari Nama / No Reg</label>
                            <input type="text" class="form-control retro-input" id="filter_search" placeholder="Ketik kata kunci...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE BODY -->
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="example" class="table table-custom table-hover-clickable align-middle w-100 mb-0 fs--1 table-bordered" style="border: 2px solid var(--retro-dark);">
                <thead>
                    <tr>
                        <th class="py-2 px-3 text-center" style="width: 50px;">No</th>
                        <th class="py-2 px-3">No. Registrasi</th>
                        <th class="py-2 px-3">Nama Pasien</th>
                        <th class="py-2 px-3 text-nowrap">Tanggal Reg</th>
                        <th class="py-2 px-3">Dokter Rujukan</th>
                        <th class="py-2 px-3">Daftar Pemeriksaan Lab</th>
                        <th class="py-2 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr class="btn-verifikasi-row"
                        data-code="{{ $datas->registrasi_id }}"
                        data-reg="{{ $datas->no_registrasi }}"
                        data-tgl="{{ date('Y-m-d', strtotime($datas->d_reg_order_date)) }}"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-lab-full">

                        <td class="text-center fw-bolder py-3" style="border: 2px solid var(--retro-dark);">{{ $no++ }}</td>

                        <td class="py-3" style="border: 2px solid var(--retro-dark);">
                            <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                <i class="fas fa-hashtag me-1"></i>{{ $datas->no_registrasi }}
                            </span>
                        </td>

                        <td class="py-3" style="border: 2px solid var(--retro-dark);">
                            <div class="fw-bolder text-dark fs-0 text-uppercase">{{ $datas->master_patient_name }}</div>
                            <span class="text-dark fw-bold fs--2">RM: {{ $datas->master_patient_rm }}</span>
                        </td>

                        <td class="py-3 text-nowrap text-dark fw-bold" style="border: 2px solid var(--retro-dark);">
                            <i class="far fa-clock me-1 text-primary"></i>{{ date('d-m-Y H:i', strtotime($datas->d_reg_order_date)) }}
                        </td>

                        <td class="py-3" style="border: 2px solid var(--retro-dark);">
                            <div class="d-flex align-items-center gap-1 text-dark fw-bold">
                                <i class="fas fa-user-md text-primary me-1"></i>
                                <span>{{ $datas->master_doctor_name ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="py-3" style="border: 2px solid var(--retro-dark);">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($datas->items as $item)
                                <span class="badge fw-bold" style="background-color: var(--retro-bg); color: var(--retro-dark); border: 1.5px solid var(--retro-dark); font-size: 0.65rem;">
                                    <i class="fas fa-flask text-primary me-1"></i>{{ $item->nama_layanan }}
                                </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="py-3 text-center" style="border: 2px solid var(--retro-dark);">
                            @if ($datas->status == 'SELESAI')
                            <span class="badge rounded-pill px-3 py-1 fw-bolder" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 1.5px solid var(--retro-dark);">
                                <i class="fas fa-user-shield me-1"></i>Menunggu Verifikasi
                            </span>
                            @else
                            <span class="badge rounded-pill px-3 py-1 fw-bolder" style="background-color: var(--retro-green); color: var(--retro-dark); border: 1.5px solid var(--retro-dark);">
                                <i class="fas fa-check-circle me-1"></i>{{ $datas->status }}
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
<!-- MODAL DETAIL LAB FULL -->
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-lab-full"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let labTable;

    $(document).ready(function() {
        labTable = $('#example').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari data verifikasi..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-none'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });

        $('#filter_search').on('keyup', function() {
            labTable.search(this.value).draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex, rowData, counter) {
                var tglAwal = $('#filter_tgl_awal').val();
                var tglAkhir = $('#filter_tgl_akhir').val();

                var rowNode = labTable.row(dataIndex).node();
                var tglRow = $(rowNode).data('tgl');

                if ((tglAwal === "" && tglAkhir === "") ||
                    (tglAwal === "" && tglRow <= tglAkhir) ||
                    (tglAwal <= tglRow && tglAkhir === "") ||
                    (tglAwal <= tglRow && tglRow <= tglAkhir)) {
                    return true;
                }
                return false;
            }
        );

        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            labTable.draw();
        });
    });

    // OPEN DETAIL MODAL VERIFIKASI HASIL
    $(document).on("click", ".btn-verifikasi-row", function(e) {
        e.preventDefault();
        var code = $(this).data("code"); // registrasi_id
        var reg = $(this).data("reg"); // no_registrasi

        $('#menu-lab-full').html(
            '<div class="text-center py-5"><div class="spinner-border text-dark my-3" role="status" style="width: 2.5rem; height: 2.5rem;"><span class="visually-hidden">Loading...</span></div><p class="text-dark fw-bold fs--1">Memuat rincian verifikasi hasil pemeriksaan...</p></div>'
        );

        $.ajax({
            url: "{{ route('verifikasi_laboratorium_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-lab-full').html(data);
        }).fail(function() {
            $('#menu-lab-full').html('<div class="alert alert-danger m-3 border-2 border-dark fw-bold" role="alert" style="border-radius: 8px;">Gagal memuat detail hasil pemeriksaan.</div>');
        });
    });
</script>
@endsection
