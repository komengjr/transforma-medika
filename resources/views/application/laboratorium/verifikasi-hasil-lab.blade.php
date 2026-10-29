@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Styling Hover Baris Tabel */
    .table-hover-clickable tbody tr {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .table-hover-clickable tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
        transform: translateY(-1px);
    }

    /* Floating Field Filter Style */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 3px;
        left: 10px;
        font-size: 0.68rem;
        color: #6c757d;
        pointer-events: none;
        z-index: 5 !important;
        background: transparent !important;
    }

    .form-floating-custom .form-control {
        padding-top: 16px;
        padding-bottom: 4px;
        padding-left: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        height: 42px;
        border-color: #ced4da;
        border-radius: 6px;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">
            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-1 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1 text-info"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <h6 class="text-primary fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-file-signature me-1"></i> Verifikasi Hasil
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MAIN CARD DATA TABLE -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
    <!-- TOOLBAR HEADER & FILTER -->
    <div class="card-header bg-white border-bottom border-light py-3 px-3">
        <div class="row align-items-center g-2">
            <!-- Action Button -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-primary rounded-3 px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    onclick="location.reload()" data-bs-toggle="tooltip" title="Refresh Data">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold ms-1">Refresh Data</span>
                </button>
            </div>

            <!-- FILTER KUSTOM -->
            <div class="col-12 col-md">
                <div class="row g-2 align-items-center">
                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_awal" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_akhir" value="" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-4 col-md">
                        <div class="form-floating-custom">
                            <label>Cari Nama / No Reg</label>
                            <input type="text" class="form-control" id="filter_search" placeholder="Ketik kata kunci...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE BODY -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-hover table-striped table-hover-clickable align-middle w-100 mb-0 fs--1">
                <thead class="bg-200 text-800" style="background-color: #0f5aa4 !important; color: #ffffff !important;">
                    <tr>
                        <th class="py-2 px-3 text-center" style="width: 50px;">No</th>
                        <th class="py-2 px-3">No. Registrasi</th>
                        <th class="py-2 px-3">Nama Pasien</th>
                        <th class="py-2 px-3 text-nowrap">Tanggal Reg</th>
                        <th class="py-2 px-3">Dokter Rujukan</th>
                        <th class="py-2 px-3">Daftar Pemeriksaan</th>
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

                        <td class="text-center fw-semibold text-600 py-3">{{ $no++ }}</td>

                        <td class="py-3">
                            <span class="badge bg-primary bg-opacity-10 text-white px-2 py-1 fw-bold fs--2">
                                <i class="fas fa-hashtag me-1"></i>{{ $datas->no_registrasi }}
                            </span>
                        </td>

                        <td class="py-3">
                            <div class="fw-bold text-dark fs-0">{{ $datas->master_patient_name }}</div>
                            <span class="text-muted fs--2">RM: {{ $datas->master_patient_rm }}</span>
                        </td>

                        <td class="py-3 text-nowrap text-secondary">
                            <i class="far fa-clock me-1 text-400"></i>{{ date('d-m-Y H:i', strtotime($datas->d_reg_order_date)) }}
                        </td>

                        <td class="py-3">
                            <div class="d-flex align-items-center gap-1 text-800">
                                <i class="fas fa-user-md text-info me-1"></i>
                                <span>{{ $datas->master_doctor_name ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="py-3">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($datas->items as $item)
                                <span class="badge bg-100 text-700 border border-300 rounded-pill fw-normal fs--2">
                                    {{ $item->nama_layanan }}
                                </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="py-3 text-center">
                            @if ($datas->status == 'SELESAI')
                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-white border border-warning-subtle px-3 py-1">
                                <i class="fas fa-user-shield me-1"></i>Menunggu Verifikasi
                            </span>
                            @else
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-white border border-success-subtle px-3 py-1">
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
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
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
        // Inisialisasi DataTable client-side karena data didapat dari controller view langsung
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

        // 1. Konek Custom Input Search dengan DataTable Search
        $('#filter_search').on('keyup', function() {
            labTable.search(this.value).draw();
        });

        // 2. Konek Custom Date Filter
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex, rowData, counter) {
                var tglAwal = $('#filter_tgl_awal').val();
                var tglAkhir = $('#filter_tgl_akhir').val();

                // Ambil tanggal row dari atribut data-tgl
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

        // Re-draw tabel ketika input tanggal berubah
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
            '<div class="text-center py-5"><div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p class="text-muted fs--1">Memuat rincian verifikasi hasil pemeriksaan...</p></div>'
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
            $('#menu-lab-full').html('<div class="alert alert-danger m-3" role="alert">Gagal memuat detail hasil pemeriksaan.</div>');
        });
    });

    // Skrip Action (Verifikasi/Report Preview) dipertahankan sesuai kebutuhan yang akan diupdate nanti
</script>
@endsection
