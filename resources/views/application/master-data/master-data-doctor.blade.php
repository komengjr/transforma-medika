@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

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
        background-color: var(--retro-bg);
    }

    /* Retro Cards */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    /* Retro Header Banner */
    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-cyan) 0%, var(--retro-yellow) 100%);
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

    .retro-btn-light {
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .retro-btn-light:hover {
        background-color: #f0f0f0;
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Inputs & Selects */
    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Table Styling */
    .retro-table-header {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        border-bottom: 3px solid var(--retro-dark);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #tableDoctor tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #tableDoctor tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
    }

    /* Modal Styling */
    .retro-modal-content {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: #ffffff;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        box-shadow: 2px 2px 0px var(--retro-dark);
        padding: 4px 10px;
        font-weight: 600;
        outline: none;
    }
</style>
@endsection

@section('content')
<!-- HEADER / INFORMASI MENU -->
<div class="row mb-4">
    <div class="col">
        <div class="card retro-header-banner p-1">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center p-3">
                    <div style="background: white; border: 2px solid #1e1e24; border-radius: 50%; padding: 8px; box-shadow: 3px 3px 0px #1e1e24;" class="me-3">
                        <img src="{{ asset('img/doctor.png') }}" alt="Doctor Icon" width="45" />
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">MANAGEMENT SYSTEM</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">MASTER <span class="fw-normal">DATA DOKTER</span></h3>
                    </div>
                </div>
                <div class="col-xl-auto px-4 py-2 text-end d-none d-md-block">
                    <span class="retro-badge" style="background-color: var(--retro-pink);">TRANSFORMA MEDIKA</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BOX FILTER PENCARIAN -->
<div class="retro-card mb-4" style="background-color: var(--retro-cyan);">
    <div class="card-header py-2 px-3 border-bottom border-dark" style="background-color: var(--retro-dark); color: var(--retro-yellow);">
        <h6 class="mb-0 fw-bolder"><span class="fas fa-filter me-2"></span>FILTER DATA DOKTER</h6>
    </div>
    <div class="card-body py-3 px-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fs--1 fw-bolder text-dark mb-1">PENCARIAN CEPAT / KEYWORD</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text fw-bold" style="border: 2px solid var(--retro-dark); border-right: none; background-color: var(--retro-bg);"><span class="fas fa-search"></span></span>
                    <input type="text" class="form-control" id="customSearchBox" placeholder="Cari nama, kode, atau NIK...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bolder text-dark mb-1">FILTER SPESIALISASI</label>
                <select class="form-select form-select-sm retro-input" id="filterSpesialis">
                    <option value="">-- Semua Spesialisasi --</option>
                    @if(isset($listSpesialis))
                    @foreach($listSpesialis as $sp)
                    <option value="{{ $sp->kode_spesialis }}">{{ $sp->nama_spesialis }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bolder text-dark mb-1">STATUS KEAKTIFAN</label>
                <select class="form-select form-select-sm retro-input" id="filterStatus">
                    <option value="">-- Semua Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm retro-btn retro-btn-danger w-100 fw-bold" id="btnResetFilter">
                    <span class="fas fa-sync-alt me-1"></span> RESET
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CARD TABLE -->
<div class="retro-card mb-4">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
        <h5 class="mb-0 fw-bolder" style="color: var(--retro-green);">
            <span class="fas fa-user-md me-2"></span> DIREKTORI DOKTER
        </h5>
        <div>
            <button class="btn btn-sm retro-btn retro-btn-light me-2" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-add-doctor" data-code="0">
                <span class="fas fa-plus me-1"></span> TAMBAH DOKTER
            </button>
            <button class="btn btn-sm retro-btn retro-btn-success" data-bs-toggle="modal" data-bs-target="#modal-import-excel">
                <span class="fas fa-file-excel me-1"></span> IMPORT
            </button>
        </div>
    </div>

    <div class="card-body p-4" style="background-color: #ffffff;">
        <div class="table-responsive">
            <table id="tableDoctor" class="table align-middle nowrap fw-bold fs--1" style="width:100%; border: 2px solid var(--retro-dark);">
                <thead class="retro-table-header">
                    <tr>
                        <th class="text-center py-3" style="width: 50px;">NO</th>
                        <th class="py-3">KODE DOKTER</th>
                        <th class="py-3">NAMA LENGKAP & GELAR</th>
                        <th class="py-3">SPESIALISASI</th>
                        <th class="py-3">SIP</th>
                        <th class="py-3">NO HANDPHONE</th>
                        <th class="py-3">STATUS</th>
                        <th class="text-center py-3" style="width: 90px;">AKSI</th>
                    </tr>
                </thead>
                <tbody style="color: var(--retro-dark);">
                    <!-- Dirender via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL FORM DOKTER -->
<div class="modal fade" id="modal-doctor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content retro-modal-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>
            <div id="menu-doctor"></div>
        </div>
    </div>
</div>

<!-- MODAL IMPORT EXCEL -->
<div class="modal fade" id="modal-import-excel" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content retro-modal-content">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-green); border-bottom: 3px solid var(--retro-dark); color: var(--retro-dark);">
                <h5 class="modal-title fw-bolder"><span class="fas fa-file-excel me-2"></span> Import Data Dokter dari Excel</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>

            <form id="form-import-doctor" action="{{ route('master_doctor_data_doctor_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <div class="mb-3">
                        <label class="form-label fw-bolder text-dark">Pilih File Excel (.xlsx / .xls)</label>
                        <input class="form-control retro-input py-2" type="file" name="file_excel" accept=".xlsx, .xls, .csv" required />
                        <small class="text-muted fw-bold mt-2 d-block">Pastikan format kolom (baris pertama) sesuai: nama_lengkap, spesialisasi, jenis_kelamin (L/P), nik, sip, email, no_telp, alamat.</small>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark">
                    <button class="btn retro-btn retro-btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn retro-btn retro-btn-primary" type="submit" id="btn-submit-import">
                        <span class="fas fa-upload me-1"></span> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // 1. SETUP DATATABLES
        var table = $('#tableDoctor').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('master_doctor_get_data') }}",
                type: 'GET',
                data: function(d) {
                    d.status = $('#filterStatus').val();
                    d.spesialis = $('#filterSpesialis').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center fw-bold align-middle'
                },
                {
                    data: 'kode_dokter',
                    name: 'kode_dokter',
                    className: 'align-middle',
                    render: function(data) {
                        return `<span class="retro-badge" style="background-color: var(--retro-bg);">${data}</span>`;
                    }
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                    className: 'align-middle',
                    render: function(data, type, row) {
                        let baseUrl = "{{ asset('storage/doctors') }}";
                        let defaultImg = "{{ asset('img/doctor.png') }}";
                        let fotoUrl = row.foto ? `${baseUrl}/${row.foto}` : defaultImg;

                        let statusColor = (row.is_active && row.is_active.includes('bg-success')) ? 'var(--retro-green)' : 'var(--retro-pink)';

                        return `
                          <div class="d-flex align-items-center">
                              <div class="position-relative me-3">
                                  <div class="rounded-circle p-1" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border: 2px solid var(--retro-dark); background-color: white; box-shadow: 2px 2px 0px var(--retro-dark);">
                                      <img class="rounded-circle" src="${fotoUrl}" alt="Foto ${data}" style="object-fit: cover; width: 38px; height: 38px;" />
                                  </div>
                                  <span class="position-absolute bottom-0 end-0 p-1 border border-2 border-dark rounded-circle" style="background-color: ${statusColor}; width: 14px; height: 14px; transform: translate(-10%, -10%);"></span>
                              </div>

                              <div class="flex-1">
                                  <h6 class="mb-0 fw-bolder text-dark text-nowrap">${data}</h6>
                                  <div class="fs--2 text-muted fw-bold mt-1 d-flex align-items-center">
                                      <span class="fas fa-stethoscope text-dark me-1"></span> Profesional Medis
                                  </div>
                              </div>
                          </div>`;
                    }
                },
                {
                    data: 'spesialisasi',
                    name: 'spesialisasi',
                    className: 'align-middle'
                },
                {
                    data: 'sip',
                    name: 'sip',
                    className: 'align-middle'
                },
                {
                    data: 'no_telp',
                    name: 'no_telp',
                    className: 'align-middle'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: false,
                    searchable: false,
                    className: 'align-middle'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle'
                }
            ],
            language: {
                search: "CARI DATA:",
                lengthMenu: "TAMPIL _MENU_ DATA",
                info: "MENAMPILKAN _START_ S/D _END_ DARI _TOTAL_ DOKTER",
                paginate: {
                    first: "AWAL",
                    last: "AKHIR",
                    next: "❯",
                    previous: "❮"
                }
            },
            dom: '<"top"f>rt<"bottom"ip><"clear">'
        });

        // 2. Event Kotak Pencarian
        $('#customSearchBox').on('keyup', function() {
            table.search(this.value).draw();
        });

        // 3. Event Filter Spesialis & Status
        $('#filterStatus, #filterSpesialis').on('change', function() {
            table.draw();
        });

        // 4. Tombol Reset Filter
        $('#btnResetFilter').on('click', function() {
            $('#customSearchBox').val('');
            $('#filterStatus').val('');
            $('#filterSpesialis').val('');
            table.search('').draw();
        });
    });

    // Event handler Tambah Dokter
    $(document).on("click", "#button-add-doctor", function(e) {
        e.preventDefault();
        bukaFormModal(0);
    });

    // Event handler Edit Dokter
    $(document).on("click", "#button-edit-doctor", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        bukaFormModal(code);
    });

    function bukaFormModal(code) {
        $('#menu-doctor').html('<div class="text-center p-5"><div class="spinner-border" style="color: var(--retro-pink); width: 3rem; height: 3rem;" role="status"></div><p class="mt-3 fw-bold" style="color: var(--retro-dark);">MEMUAT FORM...</p></div>');
        $.ajax({
            url: "{{ route('master_doctor_data_doctor_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-doctor').html(data);
        }).fail(function() {
            $('#menu-doctor').html('<div class="alert alert-danger m-3 fw-bold border-dark shadow-sm">Gagal memuat form dari server.</div>');
        });
    }

    // Submit Form AJAX
    $(document).on('submit', '#form-save-doctor', function(e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find('button[type="submit"]');
        let originalBtnText = btnSubmit.html();

        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> MENYIMPAN...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                btnSubmit.prop('disabled', false).html(originalBtnText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#modal-doctor').modal('hide');
                    $('#tableDoctor').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function() {
                btnSubmit.prop('disabled', false).html(originalBtnText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: 'Gagal mengirim data.'
                });
            }
        });
    });

    // Import Excel AJAX
    $(document).on('submit', '#form-import-doctor', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(this);
        let btnSubmit = $('#btn-submit-import');
        let originalBtnText = btnSubmit.html();

        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> MENGIMPORT...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                btnSubmit.prop('disabled', false).html(originalBtnText);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    form[0].reset();
                    $('#modal-import-excel').modal('hide');
                    $('#tableDoctor').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Import Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                btnSubmit.prop('disabled', false).html(originalBtnText);

                let errorMsg = 'Gagal mengirim file ke server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: errorMsg
                });
            }
        });
    });
</script>
@endsection
