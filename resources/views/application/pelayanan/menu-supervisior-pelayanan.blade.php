@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    /* Banner Header Gradient */
    .welcome-banner {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #4f46e5 100%);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.15);
    }

    /* Modern Filter Bar Card */
    .filter-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        /* background: #ffffff; */
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

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        padding-top: 16px;
        padding-bottom: 4px;
        padding-left: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        height: 42px;
        border-color: #ced4da;
        border-radius: 6px;
    }

    /* Penyesuaian Khusus Select2 Floating Label */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 42px !important;
        padding-top: 14px !important;
        padding-bottom: 2px !important;
        padding-left: 6px !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #212529 !important;
        padding-left: 4px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 6px !important;
    }

    /* Button Search */
    .btn-search-modern {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        border: none;
        border-radius: 6px;
        color: #fff;
        font-weight: 700;
        height: 42px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-search-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        color: #fff;
    }
</style>
@endsection

@section('content')
<!-- Header Welcome Banner -->
<div class="row mb-3">
    <div class="col-12">
        <div class="welcome-banner text-white p-3 p-lg-4">
            <div class="row align-items-center gy-3">
                <div class="col-md-7 d-flex align-items-center gap-3">
                    <div class="p-2 bg-white bg-opacity-20 rounded-3 backdrop-blur flex-shrink-0">
                        <img src="{{ asset('img/super.png') }}" alt="Icon" width="48" height="48" class="object-fit-contain" />
                    </div>
                    <div>
                        <span class="badge bg-white bg-opacity-20 text-dark rounded-pill px-3 py-1 fs--2 fw-semibold mb-1">
                            Akses Khusus
                        </span>
                        <h4 class="text-white fw-bold mb-0">
                            {{ Env('APP_LABEL') }} <span class="fw-normal text-white-50">Management System</span>
                        </h4>
                    </div>
                </div>
                <div class="col-md-5 text-md-end border-start border-white border-opacity-25 ps-md-4">
                    <span class="text-white-50 fs--2 fw-bold text-uppercase d-block">Modul Layanan</span>
                    <h5 class="text-white fw-bold mb-0">
                        Supervisor <span class="badge bg-warning text-dark rounded-pill ms-1 fs--2">Verifikasi & Koreksi</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Area -->
<div class="card filter-card mb-4">
    <div class="card-body p-3 p-lg-4">
        <!-- Form Pencarian Filter -->
        <div class="row g-2 align-items-end mb-3">

            <div class="col-12 col-md-3">
                <div class="form-floating-custom">
                    <label>Kelompok Pasien (Penjamin)</label>
                    <select class="form-select" id="kategori_pasien">
                        <option value="">Semua Kelompok</option>
                        @foreach ($kategori as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama_sub_penjamin }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="form-floating-custom">
                    <label>Jenis Pemeriksaan</label>
                    <select class="form-select" id="layanan_pasien">
                        <option value="all">Semua Layanan (All)</option>
                        @foreach ($layanan as $lay)
                        <option value="{{ $lay->id }}">{{ $lay->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-floating-custom">
                    <label>Rentang Tanggal Registrasi</label>
                    <input class="form-control datetimepicker" id="rentang_tanggal" type="text"
                        placeholder="Filter Tanggal (YYYY-MM-DD)"
                        data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"id"}' />
                </div>
            </div>

            <div class="col-12 col-md-2 d-grid">
                <button class="btn btn-search-modern d-flex align-items-center justify-content-center gap-2" id="button-pencarian-data-pasien">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Area Hasil Pencarian (Dynamic Ajax Content) -->
        <div class="border-top pt-4 mt-2" id="menu-pencarian-data-pasien">
            <div class="text-center py-5 text-muted">
                <div class="p-3 bg-light rounded-circle d-inline-block mb-3">
                    <i class="fas fa-clipboard-list fs-2 text-primary opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">Pusat Koreksi Data Registrasi</h6>
                <p class="fs--1 mb-0" style="max-width: 400px; margin: 0 auto;">Gunakan filter di atas untuk menampilkan, mengoreksi, menghapus (VOID), atau menambahkan pemeriksaan pasien.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Modal Ajax untuk Koreksi/Edit Supervisor -->
<div class="modal fade" id="modal-supervisior" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle bg-light d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-supervisior"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#kategori_pasien, #layanan_pasien').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });
    });

    // Event handler load data Ajax
    $(document).on("click", "#button-pencarian-data-pasien", function(e) {
        e.preventDefault();
        var kategori = $('#kategori_pasien').val();
        var layanan = $('#layanan_pasien').val();
        var tanggal = $('#rentang_tanggal').val();

        // Validasi opsional: pastikan setidaknya tanggal diisi
        if (!tanggal || tanggal.length < 20) {
            Swal.fire({
                title: "Tanggal Belum Dipilih",
                text: "Silakan pilih rentang tanggal pencarian terlebih dahulu.",
                icon: "warning",
                confirmButtonColor: "#2563eb"
            });
            return;
        }

        $('#menu-pencarian-data-pasien').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted fs--1 fw-semibold">Memuat Data Registrasi...</p></div>'
        );

        $.ajax({
            url: "{{ route('menu_pelayanan_supervisior_find') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "kategori": kategori,
                "layanan": layanan,
                "tanggal": tanggal
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pencarian-data-pasien').html(data);

            // Inisialisasi ulang Datatable jika table hasil dikembalikan sebagai HTML murni
            if ($.fn.DataTable.isDataTable('#table_hasil_supervisor')) {
                $('#table_hasil_supervisor').DataTable().destroy();
            }
            $('#table_hasil_supervisor').DataTable({
                responsive: true
            });

            Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 2000
            }).fire({
                icon: "success",
                title: "Data Ditemukan"
            });
        }).fail(function() {
            Swal.fire({
                title: "Gagal",
                text: "Gagal mengambil data dari server, silakan coba lagi.",
                icon: "error",
                confirmButtonColor: "#2563eb"
            });
            $('#menu-pencarian-data-pasien').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan memuat data.</div>');
        });
    });

    // Event handler klik detail pasien (Edit / Void / Koreksi)
    // Menggunakan class selector (.) bukan ID (#) untuk elemen dinamis DataTables
    $(document).on("click", ".button-data-detail-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        // Kosongkan modal dan tampilkan loading spinner
        $('#menu-supervisior').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted fs--1 fw-semibold">Membuka Panel Supervisi...</p></div>'
        );

        // Pastikan modal terbuka
        var modalEl = document.getElementById('modal-supervisior');
        var modalSup = bootstrap.Modal.getOrCreateInstance(modalEl);
        modalSup.show();

        $.ajax({
            url: "{{ route('menu_pelayanan_supervisior_detail_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-supervisior').html(data);
        }).fail(function() {
            $('#menu-supervisior').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle fs-3 mb-2"></i><br>Gagal memuat panel pengeditan registrasi.</div>');
        });
    });
</script>
@endsection
