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
        height: 100%;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
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

    /* Input & Select Styling Retro */
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

    .panel-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 400px;
        text-align: center;
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-pills text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Master Data Obat & Batch</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DUAL-PANEL LAYOUT -->
<div class="row g-4 mb-4">

    <!-- KOLOM KIRI: MASTER DATA OBAT -->
    <div class="col-lg-7">
        <div class="retro-card">
            <div class="card-header bg-white border-bottom border-dark d-flex flex-wrap justify-content-between align-items-center py-3 px-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-capsules text-warning me-2"></i> Daftar Master Obat</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3 py-2" data-bs-toggle="modal" data-bs-target="#modal-obat" id="button-add-obat">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Master Baru
                </button>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive" id="data-table-obat">
                    <table id="example" class="table table-custom align-middle w-100 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;">No</th>
                                <th>Nama Obat</th>
                                <th>Kategori & Satuan</th>
                                <th class="text-center">Stok Min</th>
                                <th class="text-center" style="width: 140px;">Pengaturan Batch</th>
                                <th class="text-center" style="width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataBody">
                            @php $no = 1; @endphp
                            @foreach ($data as $datas)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="fw-bolder text-dark">{{ $datas->farm_data_obat_name }}<br>
                                    <small class="text-muted fw-bold">{{ $datas->farm_data_jenis_name ?? '-' }}</small>
                                </td>
                                <td>
                                    {{ $datas->farm_data_obat_cat ?? '-' }}<br>
                                    <span class="retro-badge" style="background-color: var(--retro-cyan); font-size:0.65rem;">{{ $datas->farm_data_satuan_name ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger text-white px-2 py-1">{{ $datas->farm_data_obat_stok_minimum ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                    $totalBatch = DB::table('farm_data_obat_exp')->where('farm_data_obat_code', $datas->farm_data_obat_code)->count();
                                    @endphp
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm retro-btn retro-btn-primary px-2 py-1 fs--2" id="btn-load-batch" data-code="{{ $datas->farm_data_obat_code }}" title="Lihat List Batch">
                                            <i class="fas fa-list me-1"></i> {{ $totalBatch }} Batch
                                        </button>
                                        <button class="btn btn-sm retro-btn px-2 py-1 fs--2" id="btn-load-add-batch" data-code="{{ $datas->farm_data_obat_code }}" title="Tambah Batch Baru" style="background-color: var(--retro-pink);">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#modal-obat" id="button-update-data-obat" data-code="{{ $datas->farm_data_obat_code }}" title="Edit Master Obat">
                                        <i class="fas fa-edit"></i>
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

    <!-- KOLOM KANAN: PANEL PENGATURAN BATCH DINAMIS -->
    <div class="col-lg-5">
        <div class="retro-card" style="background-color: #fdfdfd;">
            <div class="card-header border-bottom border-dark py-3 px-3" style="background-color: var(--retro-dark); color: var(--retro-green);">
                <h6 class="fw-bolder mb-0"><i class="fas fa-boxes-packing text-warning me-2"></i> Pengaturan Batch Obat</h6>
            </div>
            <div class="card-body p-3" id="panel-kanan-batch">
                <div class="panel-placeholder">
                    <i class="fas fa-box-open fs-1 text-secondary mb-3"></i>
                    <h6 class="fw-bold text-dark">Pilih Obat di Tabel Samping</h6>
                    <small class="text-muted">Klik tombol "Batch" atau tombol tambah (+) pada salah satu obat untuk melihat atau menambahkan data batch di panel ini.</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('base.js')
<!-- MODAL CONTAINER (Hanya untuk Tambah/Edit Master Obat Utama) -->
<div class="modal fade" id="modal-obat" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-white border border-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-obat"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari master obat..."
            }
        });
    });
</script>

<script>
    // ================= AKSI MASTER DATA OBAT (Tampil di Modal) ================= //

    $(document).on("click", "#button-add-obat", function(e) {
        e.preventDefault();
        $('#menu-obat').html('<div class="spinner-border my-5 text-dark" style="display: block; margin-left: auto; margin-right: auto;" role="status"></div>');
        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_add') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-obat').html(data);
        });
    });

    $(document).on("click", "#button-update-data-obat", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-obat').html('<div class="spinner-border my-5 text-dark" style="display: block; margin-left: auto; margin-right: auto;" role="status"></div>');
        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_update') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-obat').html(data);
        });
    });

    $(document).on("click", "#button-simpan-data-obat", function(e) {
        e.preventDefault();
        var data = $("#form-input-obat").serialize();
        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_save') }}",
            type: "POST",
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Kesalahan menyimpan data!"
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Master obat disimpan!",
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#modal-obat').modal('hide');
                location.reload();
            }
        });
    });

    $(document).on("click", "#button-save-update-data-obat", function(e) {
        e.preventDefault();
        var data = $("#form-update-obat").serialize();
        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_update_save') }}",
            type: "POST",
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Gagal memperbarui data!"
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Master obat diperbarui!",
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#modal-obat').modal('hide');
                location.reload();
            }
        });
    });

    // ================= AKSI PENGATURAN BATCH (Tampil di Kolom Kanan) ================= //

    // 1. Tampilkan List Detail Batch di Panel Kanan
    $(document).on("click", "#btn-load-batch", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#panel-kanan-batch').html('<div class="py-5 text-center"><div class="spinner-border text-dark mb-2" role="status"></div><p class="fw-bold">Memuat data batch...</p></div>');

        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_batch_detail') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#panel-kanan-batch').html(data);
        }).fail(function() {
            $('#panel-kanan-batch').html('<div class="alert alert-danger fw-bold m-3">Gagal memuat detail batch.</div>');
        });
    });

    // 2. Tampilkan Form Tambah Batch di Panel Kanan
    $(document).on("click", "#btn-load-add-batch", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#panel-kanan-batch').html('<div class="py-5 text-center"><div class="spinner-border text-dark mb-2" role="status"></div><p class="fw-bold">Memuat form batch...</p></div>');

        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_add_batch') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#panel-kanan-batch').html(data);
        }).fail(function() {
            $('#panel-kanan-batch').html('<div class="alert alert-danger fw-bold m-3">Gagal memuat form tambah batch.</div>');
        });
    });

    // 3. Simpan Form Batch yang ada di dalam Panel Kanan
    $(document).on("click", "#button-simpan-batch-obat", function(e) {
        e.preventDefault();
        var form = $("#form-save-batch");
        if (form.length === 0) return Swal.fire('Error', 'Form batch tidak ditemukan', 'error');

        var btn = $(this);
        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ route('manajemen_farmasi_data_obat_save_batch') }}",
            type: "POST",
            data: form.serialize(),
            dataType: 'html',
        }).done(function(data) {
            btn.prop('disabled', false).text('Simpan Batch');
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Gagal menyimpan batch!"
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Batch obat berhasil ditambahkan!",
                    timer: 1500,
                    showConfirmButton: false
                });

                let obatCode = form.find('input[name="code"]').val();
                if (obatCode) {
                    $('#btn-load-batch[data-code="' + obatCode + '"]').click();
                } else {
                    location.reload();
                }
            }
        }).fail(function() {
            btn.prop('disabled', false).text('Simpan Batch');
            Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Gagal mengirim data."
            });
        });
    });
</script>
@endsection
