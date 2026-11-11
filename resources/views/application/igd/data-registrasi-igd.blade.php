@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
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
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
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
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
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

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
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
                            <i class="fas fa-ambulance text-danger fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Unit Gawat Darurat</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">List Registrasi & Penanganan IGD</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR ATAS -->
<div class="retro-card mb-4 p-3">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-2 align-items-center">
            <!-- Tombol Refresh -->
            <div class="col-auto">
                <button type="button" onclick="reloadTable()" class="btn retro-btn retro-btn-primary btn-sm px-3 fw-bold d-flex align-items-center gap-1" style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>

            <!-- Tanggal Awal -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ $startDate ?? date('Y-m-d') }}" />
            </div>

            <!-- Tanggal Akhir -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ $endDate ?? date('Y-m-d') }}" />
            </div>

            <!-- No Reg / Nama -->
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari Reg/Nama/RM..." />
            </div>

            <!-- Poli / Ruangan IGD -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="poli_id" name="poli_id">
                    <option value="">Semua Poli/Ruangan</option>
                    @if(isset($polis))
                    @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <!-- Dokter -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="dokter" name="dokter">
                    <option value="">Semua Dokter</option>
                    @if(isset($doctors))
                    @foreach ($doctors as $doc)
                    <option value="{{ $doc->master_doctor_name ?? $doc->nama_lengkap }}">{{ $doc->master_doctor_name ?? $doc->nama_lengkap }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <!-- Kel. Pelanggan (Sub Penjamin) -->
            <div class="col-md">
                <select class="form-select form-select-sm retro-input" id="sub_penjamin_id" name="sub_penjamin_id">
                    <option value="">Semua Kelompok</option>
                    @if(isset($subPenjamins))
                    @foreach ($subPenjamins as $sp)
                    <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <!-- Tombol Submit Filter -->
            <div class="col-auto">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm px-3" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN CARD TABLE -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex flex-wrap justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-danger me-2"></i> Data Kunjungan Pasien IGD</h5>
    </div>

    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-registrasi-igd" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Registrasi</th>
                        <th>Pasien & RM</th>
                        <th>Tanggal Masuk</th>
                        <th>Dokter Pemeriksa</th>
                        <th>Ruangan / Poli IGD</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data dimuat dinamis via DataTables Server-side / AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL CONTAINER UNTUK HANDLING IGD -->
<div class="modal fade" id="modal-handling-igd" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content retro-card border-0">
            <div id="menu-handling-igd"></div>
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
    let tableIgd;
    $(document).ready(function() {
        tableIgd = $('#table-registrasi-igd').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_igd_table') }}",
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                    d.poli_id = $('#poli_id').val();
                    d.dokter = $('#dokter').val();
                    d.sub_penjamin_id = $('#sub_penjamin_id').val();
                }
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_registrasi',
                    name: 'reg.no_registrasi'
                },
                {
                    data: 'nama_pasien',
                    name: 'p.nama'
                },
                {
                    data: 'tanggal_reg',
                    name: 'reg.tanggal_registrasi'
                },
                {
                    data: 'dokter',
                    name: 'doc_poli.nama_lengkap'
                },
                {
                    data: 'poli',
                    name: 'poli.nama_poli',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'reg.status_kunjungan',
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari data pasien IGD..."
            }
        });
    });

    function reloadTable() {
        tableIgd.ajax.reload(null, false);
    }

    // Event handler klik tombol handling pada tabel
    $(document).on("click", "#table-registrasi-igd .retro-btn-primary", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-handling-igd').html('<div class="py-5 text-center"><div class="spinner-border text-dark" role="status"></div><p class="mt-2 fw-bold">Memuat Form Handling IGD...</p></div>');
        $('#modal-handling-igd').modal('show');

        $.ajax({
            url: "{{ route('igd.handling.form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-igd').html(data);
        }).fail(function() {
            $('#menu-handling-igd').html('<div class="alert alert-danger m-3">Gagal memuat form handling IGD.</div>');
        });
    });


</script>

@endsection
