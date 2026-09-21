@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    .gradient-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 12px;
    }

    .stat-card {
        border: none;
        border-radius: 10px;
        transition: transform 0.2s ease, shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-custom thead {
        background: #f8f9fa;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Modern -->
<div class="card mb-4 gradient-header text-white shadow-sm border-0">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-7 d-flex align-items-center">
                <div class="icon-shape me-3 text-white">
                    <i class="fas fa-boxes fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1 fs--1">Trans Management System</h6>
                    <h3 class="text-white fw-extrabold mb-0">Master Barang Inventaris</h3>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light text-primary fw-bold shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#modal-master-barang-xl" id="button-add-barang">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                </button>
                <button class="btn btn-outline-light fw-bold" data-bs-toggle="modal" data-bs-target="#modal-cabang" id="button-data-barang-cabang">
                    <i class="fas fa-file-excel me-1"></i> Import Excel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Data Table Card -->
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span class="badge bg-soft-primary text-primary fs--1 me-2 px-3 py-2 rounded-pill">
                <i class="fas fa-list me-1"></i> Daftar Inventaris
            </span>
        </div>
        <div class="text-muted fs--1">
            <i class="fas fa-info-circle me-1"></i> Kelola data aset & barang perusahaan secara terpusat
        </div>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="example" class="table table-hover table-custom align-middle nowrap w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>No Inventaris</th>
                        <th>Klasifikasi</th>
                        <th>Merk / Type</th>
                        <th>Tgl Pembelian</th>
                        <th>Harga Perolehan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-master-barang" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-master-barang"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-master-barang-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-master-barang-xl"></div>
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
    $(document).on("click", "#button-add-barang", function(e) {
        e.preventDefault();
        $('#menu-master-barang-xl').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
        );
        $.ajax({
            url: "{{ route('master_barang_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-master-barang-xl').html(data);
        }).fail(function() {
            $('#menu-master-barang-xl').html('<div class="alert alert-danger m-3">Gagal memuat form data.</div>');
        });
    });

    $(document).on("click", "#button-simpan-data", function(e) {
        e.preventDefault();
        var data = $("#form-add-data-barang").serialize();
        var nama = $("#nama_barang").val();
        var klasifikasi = $("#klasifikasi").val();
        var tgl_beli = $("#tgl_beli").val();
        var harga_perolehan = $("#dengan-rupiah").val();
        var suplier = $("#suplier").val();
        var lokasi = $("#lokasi").val();

        if (!nama || !klasifikasi || !tgl_beli || !harga_perolehan || !suplier || !lokasi) {
            Swal.fire({
                icon: "error",
                title: "Data Belum Lengkap",
                text: "Mohon lengkapi seluruh field yang wajib diisi!",
                confirmButtonColor: '#3085d6'
            });
        } else {
            $('#menu-simpan-data').html(
                '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
            $.ajax({
                url: "{{ route('master_barang_add_save_data') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content"),
                },
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function(data) {
                $('#menu-simpan-data').html(data);
                location.reload();
            }).fail(function() {
                $('#menu-simpan-data').html('<div class="alert alert-danger">Gagal menyimpan data.</div>');
            });
        }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('master_barang_show_data') }}",
            columns: [{
                    data: 'id',
                    width: "4%"
                },
                {
                    data: 'gambar'
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'no_inventaris',
                    className: 'child'
                },
                {
                    data: 'kd_inventaris',
                    className: 'child'
                },
                {
                    data: 'merk',
                    className: 'child'
                },
                {
                    data: 'tglbeli'
                },
                {
                    data: 'harga_perolehan',
                    className: 'text-end'
                },
                {
                    data: 'kd_lokasi',
                    className: 'child'
                },
                {
                    data: 'status',
                    className: 'text-center'
                },
                {
                    data: 'btn',
                    className: 'text-center',
                    width: "8%"
                }
            ]
        });
    });
</script>
@endsection
