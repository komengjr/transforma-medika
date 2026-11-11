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

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        /* background-color: #ffffff; */
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

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Inputs, Selects & Filters */
    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
        font-size: 0.8rem !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Avatar Pasien */
    .patient-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: var(--retro-cyan);
        border: 2px solid var(--retro-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        color: var(--retro-dark);
        font-size: 0.75rem;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    /* Badge Pengiriman */
    .badge-wa {
        background-color: #25d366 !important;
        color: #fff !important;
        border: 1.5px solid var(--retro-dark);
    }

    .badge-email {
        background-color: #ea4335 !important;
        color: #fff !important;
        border: 1.5px solid var(--retro-dark);
    }

    .badge-ss {
        background-color: #00bcd4 !important;
        color: #fff !important;
        border: 1.5px solid var(--retro-dark);
    }

    .badge-print {
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1.5px solid var(--retro-dark);
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

    .table-custom tbody tr {
        transition: background 0.2s;
    }

    .table-custom tbody tr:hover td {
        background-color: var(--retro-yellow) !important;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Retro -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center">
                            <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                                style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                                <img src="{{ asset('img/poliklikink.png') }}" alt="Poli Logo" width="45" />
                            </div>
                            <div>
                                <span class="retro-badge mb-1" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-hospital-user me-1"></i> {{ env('APP_LABEL', 'HIS') }} System
                                </span>
                                <h4 class="mb-0 fw-bolder text-dark">Pendaftaran Poliklinik</h4>
                                <p class="text-dark fs--1 mb-0 fw-bold opacity-75">Kelola dan proses pendaftaran pasien poliklinik secara real-time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <button class="btn retro-btn retro-btn-primary btn-sm px-3 py-2" onclick="loadTableData();" data-bs-toggle="tooltip" title="Refresh Data">
                            <span class="fas fa-sync-alt me-1"></span> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar Atas -->
<div class="retro-card mb-4 p-3">
    <form id="form-filter" onsubmit="event.preventDefault(); loadTableData();">
        <div class="row g-2 align-items-center">
            <!-- Tombol Refresh -->
            <div class="col-auto">
                <button type="button" onclick="loadTableData()" class="btn retro-btn retro-btn-primary btn-sm px-3 fw-bold d-flex align-items-center gap-1" style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>

            <!-- Tanggal Awal -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ $startDate }}" />
            </div>

            <!-- Tanggal Akhir -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ $endDate }}" />
            </div>

            <!-- No Reg / Nama -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari Reg/Nama..." />
            </div>

            <!-- Poli -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="poli_id" name="poli_id">
                    <option value="">Semua Poli</option>
                    @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dokter -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="dokter" name="dokter">
                    <option value="">Semua Dokter</option>
                    @foreach ($doctors as $doc)
                    <option value="{{ $doc->master_doctor_name }}">{{ $doc->master_doctor_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kel. Pelanggan (Sub Penjamin) -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="sub_penjamin_id" name="sub_penjamin_id">
                    <option value="">Semua Kelompok</option>
                    @foreach ($subPenjamins as $sp)
                    <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Submit Filter -->
            <div class="col-auto">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm px-3" style="height: 38px;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Main Table Card -->
<div class="retro-card mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle fs--1 mb-0 w-100 table-bordered" style="border: 2px solid var(--retro-dark);">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">NO</th>
                        <th style="width: 18%;">NO. REGISTRASI & PETUGAS</th>
                        <th style="width: 15%;">NAMA PASIEN</th>
                        <th style="width: 12%;">PENJAMIN</th>
                        <th style="width: 13%;">DOKTER</th>
                        <th style="width: 10%;">JANJI HASIL</th>
                        <th style="width: 12%;">POLIKLINIK / LAYANAN</th>
                        <th style="width: 12%;">PENGIRIMAN</th>
                        <th class="text-end" style="width: 9%;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data dimuat dinamis via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Poliklinik -->
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    let dataTableInstance;

    $(document).ready(function() {
        dataTableInstance = $('#example').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                }
            },
            columns: [{
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        let btnHandling = '';
                        if (row.status_kunjungan === 'MENUNGGU') {
                            btnHandling = `<li><a class="dropdown-item fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#modal-poliklinik" id="button-proses-handling" data-code="${row.no_registrasi}"><i class="fas fa-stethoscope me-2 text-primary"></i> Proses Handling</a></li><li><hr class="dropdown-divider border-dark"></li>`;
                        }
                        return `<div class="dropdown">
                        <button class="btn retro-btn retro-btn-warning btn-sm p-1 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 30px; height: 30px;">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu shadow border-0 py-2" style="border: 2px solid var(--retro-dark) !important; border-radius: 8px !important; box-shadow: 4px 4px 0px var(--retro-dark) !important;">
                            ${btnHandling}
                            <li><a class="dropdown-item fw-bold text-dark" href="#" data-bs-toggle="modal" data-bs-target="#modal-cabang" data-code="${row.id}"><i class="fas fa-history me-2 text-info"></i> Riwayat Pasien</a></li>
                        </ul>
                    </div>`;
                    }
                },
                {
                    data: null,
                    className: 'text-center fw-bold',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let poliBadge = row.poli_nama ? ` - ${row.poli_nama}` : '';
                        return `<div class="fw-bold text-dark">${row.no_registrasi}</div>
                            <span class="badge bg-danger text-white fw-bold" style="font-size: 0.7rem; border: 1.5px solid var(--retro-dark);">${row.pasien_pid ?? ''}</span>
                            <div class="mt-1"><span class="badge bg-primary text-white fw-bold" style="font-size: 0.65rem; border: 1.5px solid var(--retro-dark);"><i class="fas fa-hospital me-1"></i> ${row.jenis_layanan}${poliBadge}</span></div>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let initial = row.pasien_nama ? row.pasien_nama.substring(0, 3).toUpperCase() : 'N/A';
                        let tglReg = row.tanggal_registrasi ? new Date(row.tanggal_registrasi).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace(/\./g, '-') : '-';
                        return `<div class="d-flex align-items-center gap-2">
                        <div class="patient-avatar shadow-sm">${initial}</div>
                        <div>
                            <div class="fw-bolder text-dark text-uppercase" style="font-size: 0.85rem;">${row.pasien_nama}</div>
                            <span class="badge bg-secondary text-white" style="font-size: 0.6rem; border: 1px solid var(--retro-dark);">${row.petugas_nama ?? 'system'}</span>
                            <div class="text-muted fw-bold" style="font-size: 0.7rem;">${tglReg}</div>
                        </div>
                    </div>`;
                    }
                },
                {
                    data: 'agreement',
                    render: function(data) {
                        return `<span class="fw-bolder text-primary" style="font-size: 0.85rem;">${data ?? '-'}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let htmlDokter = '';
                        if (row.dokter_poli_nama) {
                            htmlDokter += `<div class="fw-bold text-dark" style="font-size: 0.8rem;"><i class="fas fa-user-md text-primary me-1"></i> ${row.dokter_poli_nama}</div>`;
                        }
                        if (row.dokter_pengirim_nama) {
                            htmlDokter += `<div class="text-muted small mt-0.5 fw-bold">Pengirim: ${row.dokter_pengirim_nama}</div>`;
                        }
                        if (!row.dokter_poli_nama && !row.dokter_pengirim_nama) {
                            htmlDokter += '-';
                        }
                        return htmlDokter;
                    }
                },
                {
                    data: 'janji_hasil',
                    render: function(data) {
                        let formatTgl = data ? new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace(/\./g, '-') : '-';
                        return `<span class="text-dark fw-bold" style="font-size: 0.8rem;">${formatTgl}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="text-dark fw-bold" style="font-size: 0.8rem;">${row.poli_nama ?? row.jenis_layanan}</span>`;
                    }
                },
                {
                    data: 'metode_pengiriman',
                    render: function(data) {
                        let html = '<div class="d-flex flex-column gap-1">';
                        try {
                            let methods = JSON.parse(data) || [];
                            methods.forEach(m => {
                                let mLower = m.toLowerCase();
                                if (mLower === 'whatsapp') html += '<span class="badge badge-wa text-start py-1 px-2 fw-bold" style="font-size: 0.65rem;"><i class="fab fa-whatsapp me-1"></i> WHATSAPP</span>';
                                else if (mLower === 'email') html += '<span class="badge badge-email text-start py-1 px-2 fw-bold" style="font-size: 0.65rem;"><i class="fas fa-envelope me-1"></i> EMAIL</span>';
                                else if (mLower === 'satusehat') html += '<span class="badge badge-ss text-start py-1 px-2 fw-bold" style="font-size: 0.65rem;"><i class="fas fa-heartbeat me-1"></i> SATU SEHAT</span>';
                                else if (mLower === 'cetak_fisik') html += '<span class="badge badge-print text-start py-1 px-2 fw-bold" style="font-size: 0.65rem;"><i class="fas fa-print me-1"></i> CETAK FISIK</span>';
                            });
                        } catch (e) {}
                        html += '</div>';
                        return html;
                    }
                },
                {
                    data: null,
                    className: 'text-end',
                    render: function(data, type, row) {
                        let total = Number(row.total_tagihan || 0).toLocaleString('id-ID');
                        let badgeStatus = row.status_pembayaran === 'LUNAS' ?
                            '<span class="badge bg-success text-white px-2 py-1 fw-bold" style="font-size: 0.65rem; border: 1.5px solid var(--retro-dark);"><i class="fas fa-check-circle me-1"></i> LUNAS</span>' :
                            '<span class="badge bg-warning text-dark px-2 py-1 fw-bold" style="font-size: 0.65rem; border: 1.5px solid var(--retro-dark);"><i class="fas fa-clock me-1"></i> BELUM LUNAS</span>';
                        return `<div class="fw-bolder text-dark" style="font-size: 0.9rem;">${total}</div><div class="mt-1">${badgeStatus}</div>`;
                    }
                }
            ]
        });

        loadTableData();
    });

    function loadTableData() {
        let formData = $('#form-filter').serialize();

        $.ajax({
            url: "{{ route('poliklinik.data.json') }}",
            type: "GET",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    dataTableInstance.clear().rows.add(response.data).draw();
                }
            },
            error: function(xhr) {
                console.error("Gagal memuat data tabel.");
            }
        });
    }

    $(document).on("click", "#button-proses-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-poliklinik').html(
            '<div class="py-5 text-center"><div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-dark fw-bold fs--1">Memuat Data Pasien...</p></div>'
        );
        $.ajax({
            url: "{{ route('data_registrasi_poli_handling') ?? '#' }}",
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
</script>
@endsection
