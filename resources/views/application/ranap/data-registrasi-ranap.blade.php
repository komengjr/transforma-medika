@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: white;
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        font-size: 0.8rem !important;
    }

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
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-hospital-user text-success fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Rawat Inap (Ranap)</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">List Registrasi & Penanganan Rawat Inap</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="retro-card mb-4 p-3">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <button type="button" onclick="reloadTable()" class="btn retro-btn retro-btn-primary btn-sm px-3 fw-bold d-flex align-items-center gap-1" style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ $startDate }}" />
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ $endDate }}" />
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari Reg/Nama/RM..." />
            </div>
            <div class="col-auto">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm px-3" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Data Kunjungan Pasien Rawat Inap</h5>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-registrasi-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Registrasi</th>
                        <th>Pasien & RM</th>
                        <th>Tanggal Masuk</th>
                        <th>Dokter DPJP</th>
                        <th>Bangsal / Ruangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL HANDLING RANAP -->
<div class="modal fade" id="modal-handling-ranap" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content retro-card border-0">
            <div id="menu-handling-ranap"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableRanap;
    $(document).ready(function() {
        tableRanap = $('#table-registrasi-ranap').DataTable({
            processing: true,
            serverSide: false, // Ubah ke false karena menggunakan ->get() / query builder murni
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_ranap_table') }}",
                type: "GET",
                dataSrc: 'data', // Mengambil array dari key 'data' pada json response controller
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Nomor urut otomatis
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_registrasi',
                    render: function(data) {
                        return `<span class="fw-bold text-success">${data}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `${row.nama}<br><small class="text-muted">RM: ${row.pid}</small>`;
                    }
                },
                {
                    data: 'tgl_masuk',
                    render: function(data) {
                        if (!data) return '-';
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }) + ' ' + date.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: 'nama_lengkap',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-dark">${row.nama_ruangan} (${row.kelas})</span><br>
                                <small class="text-success fw-bold"><i class="fas fa-bed"></i> Bed: ${row.nomor_bed}</small>`;
                    },
                    orderable: false
                },
                {
                    data: 'status_inap',
                    render: function(data) {
                        let statusText = data ? data : 'DIRAWAT';
                        let badgeColor = (statusText === 'DIRAWAT') ? 'bg-success text-white' : 'bg-warning text-dark';
                        return `<span class="retro-badge ${badgeColor}">${statusText}</span>`;
                    },
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `<button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1" data-code="${data}"><i class="fas fa-bed"></i> Handling</button>`;
                    },
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function reloadTable() {
        tableRanap.ajax.reload(null, false);
    }

    // Klik Tombol Handling Ranap
    $(document).on("click", "#table-registrasi-ranap .retro-btn-primary", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-handling-ranap').html('<div class="py-5 text-center"><div class="spinner-border text-dark" role="status"></div><p class="mt-2 fw-bold">Memuat Form Handling Rawat Inap...</p></div>');
        $('#modal-handling-ranap').modal('show');

        $.ajax({
            url: "{{ route('ranap.handling.form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-ranap').html(data);
        }).fail(function() {
            $('#menu-handling-ranap').html('<div class="alert alert-danger m-3">Gagal memuat form handling rawat inap.</div>');
        });
    });
</script>
@endsection
