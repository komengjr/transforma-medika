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
        background: linear-gradient(135deg, var(--retro-pink) 0%, var(--retro-orange) 100%);
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

    .retro-btn-light {
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .retro-btn-light:hover {
        background-color: #f0f0f0;
        color: var(--retro-dark);
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

    #example tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #example tbody tr:hover {
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
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col">
        <div class="card retro-header-banner p-1">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center p-3">
                    <div style="background: white; border: 2px solid #1e1e24; border-radius: 50%; padding: 8px; box-shadow: 3px 3px 0px #1e1e24;" class="me-3">
                        <img src="{{ asset('img/kategori.png') }}" alt="" width="45" />
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">MANAJEMEN LABORATORIUM</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">SPESIMEN <span class="fw-normal">PEMERIKSAAN</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- TABEL PEMERIKSAAN (KIRI) -->
    <div class="col-lg-8">
        <div class="retro-card mb-3 mb-lg-0">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
                <h5 class="mb-0 fw-bolder" style="color: var(--retro-cyan);">
                    <span class="fas fa-microscope me-2"></span> Data Master Pemeriksaan
                </h5>
            </div>
            <div class="card-body p-4" style="background-color: #ffffff;">
                <div class="table-responsive">
                    <table id="example" class="table align-middle nowrap fw-bold" style="width:100%; border: 2px solid var(--retro-dark);">
                        <thead class="retro-table-header">
                            <tr>
                                <th class="text-center py-3" style="width: 50px;">No</th>
                                <th class="py-3">Kode</th>
                                <th class="py-3">Tipe Layanan</th>
                                <th class="py-3">Nama Pemeriksaan</th>
                                <th class="text-center py-3" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--retro-dark);">
                            @php $no = 1; @endphp
                            @foreach ($data as $datas)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td><span class="retro-badge" style="background-color: var(--retro-bg);">{{ $datas->kode_layanan }}</span></td>
                                <td class="text-uppercase">{{ $datas->nama_tipe }}</td>
                                <td class="text-uppercase" style="font-size: 1.05rem;">{{ $datas->nama_layanan }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-warning" id="button-pilih-specimen" data-code="{{ $datas->id }}">
                                        <i class="fas fa-flask me-1"></i> PILIH
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL DETAIL SPESIMEN (KANAN) -->
    <div class="col-lg-4">
        <div class="retro-card mb-3 mb-lg-0">
            <div class="card-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
                <h5 class="mb-0 fw-bolder" style="color: var(--retro-dark);">
                    <i class="fas fa-vial me-2"></i> Data Specimen
                </h5>
            </div>
            <div class="card-body p-4" style="background-color: #ffffff;">
                <div id="menu-master-specimen">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-arrow-left fs-3 d-block mb-2 text-primary"></i>
                        <em class="fw-bold">Silakan klik tombol "Pilih" pada salah satu pemeriksaan di sebelah kiri untuk mengatur spesimen.</em>
                    </div>
                </div>
            </div>
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
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "CARI DATA:",
                lengthMenu: "TAMPIL _MENU_ DATA",
                info: "MENAMPILKAN _START_ S/D _END_ DARI _TOTAL_ PEMERIKSAAN",
                paginate: {
                    first: "AWAL",
                    last: "AKHIR",
                    next: "❯",
                    previous: "❮"
                }
            }
        });

        // AJAX Load Detail / Form Specimen Berdasarkan ID Pemeriksaan
        $(document).on("click", "#button-pilih-specimen", function(e) {
            e.preventDefault();
            var code = $(this).data("code"); // Mengambil ID master pemeriksaan

            $('#menu-master-specimen').html(
                '<div class="text-center p-5"><div class="spinner-border" style="color: var(--retro-pink); width: 3rem; height: 3rem;" role="status"></div><p class="mt-3 fw-bold" style="color: var(--retro-dark);">MEMUAT DATA SPESIMEN...</p></div>'
            );

            $.ajax({
                url: "{{ route('master_pemeriksaan_specimen_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-master-specimen').html(data);
            }).fail(function() {
                $('#menu-master-specimen').html('<div class="alert alert-danger fw-bold border-dark shadow-sm">Gagal memuat data spesimen dari server.</div>');
            });
        });

        // AJAX Simpan Specimen ke Pemeriksaan
        $(document).on("click", "#button-simpan-data-specimen-pemeriksaan", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            var specimen = $('#data_specimen').val();

            if (!specimen) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Silakan pilih spesimen terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            $.ajax({
                url: "{{ route('master_pemeriksaan_specimen_save') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "specimen": specimen
                },
                dataType: 'html',
            }).done(function(data) {
                if (data.trim() == "0") {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Spesimen tersebut sudah terdaftar pada pemeriksaan ini.',
                        icon: 'info',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    $('#menu-master-specimen').html(data);
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data spesimen berhasil disimpan.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            });
        });
    });
</script>
@endsection
