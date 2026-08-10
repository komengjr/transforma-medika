@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    .js-choice {
        width: 100%;
        border-radius: 8px;
    }

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
        background: #ffffff;
    }

    .filter-control {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        transition: all 0.2s ease;
    }

    .filter-control:focus {
        border-color: #3b82f6 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    .btn-search-modern {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 700;
        padding: 0 20px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-search-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        color: #fff;
    }

    .label-filter-mini {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
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
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 fs--2 fw-semibold mb-1">
                            Welcome Back
                        </span>
                        <h4 class="text-white fw-bold mb-0">
                            {{ Env('APP_LABEL') }} <span class="fw-normal text-white-50">Management System</span>
                        </h4>
                    </div>
                </div>
                <div class="col-md-5 text-md-end border-start border-white border-opacity-25 ps-md-4">
                    <span class="text-white-50 fs--2 fw-bold text-uppercase d-block">Modul Layanan</span>
                    <h5 class="text-white fw-bold mb-0">
                        Supervisor <span class="badge bg-warning text-dark rounded-pill ms-1 fs--2">Pelayanan</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Content Area -->
<div class="card filter-card mb-4">
    <div class="card-body p-3 p-lg-4">
        <!-- Form Pencarian Filter -->
        <div class="row g-3 align-items-end mb-3">
            <div class="col-md-4">
                <label class="label-filter-mini text-primary">
                    <i class="fas fa-layer-group text-primary"></i> Kategori Pasien
                </label>
                <select class="form-select filter-control" id="kategori_pasien" name="organizerSingle">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $cat)
                    <option value="{{ $cat->t_pasien_cat_code }}">{{ $cat->t_pasien_cat_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="label-filter-mini text-info">
                    <i class="fas fa-notes-medical text-info"></i> Jenis Layanan
                </label>
                <select class="form-select filter-control" id="layanan_pasien" name="organizerSingle">
                    <option value="">Pilih Layanan</option>
                    <option value="all">Semua Layanan (All)</option>
                    @foreach ($layanan as $lay)
                    <option value="{{ $lay->t_layanan_cat_code }}">{{ $lay->t_layanan_cat_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="label-filter-mini text-warning">
                    <i class="fas fa-calendar-alt text-warning"></i> Rentang Tanggal
                </label>
                <input class="form-control filter-control datetimepicker" id="timepicker3" type="text"
                    placeholder="d-m-y s/d d-m-y"
                    data-options='{"mode":"range","dateFormat":"d-m-y","disableMobile":true,"locale":"in"}' />
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-search-modern py-2 d-flex align-items-center justify-content-center" id="button-pencarian-data-pasien" title="Cari Data">
                    <i class="fas fa-search me-md-0 me-1"></i>
                    <span class="d-md-none fw-bold">Cari Data</span>
                </button>
            </div>
        </div>

        <!-- Area Hasil Pencarian (Dynamic Ajax Content) -->
        <div class="border-top pt-3" id="menu-pencarian-data-pasien">
            <div class="text-center py-5 text-muted">
                <div class="p-3 bg-light rounded-circle d-inline-block mb-3">
                    <i class="fas fa-search fs-2 text-primary opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">Siap Melakukan Pencarian</h6>
                <p class="fs--1 mb-0">Gunakan filter di atas untuk menampilkan data registrasi pasien.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Company Full -->
<div class="modal fade" id="modal-company-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div id="menu-company-full"></div>
        </div>
    </div>
</div>

<!-- Modal Supervisior Verifikasi Pasien -->
<div class="modal fade" id="modal-supervisior" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div id="menu-supervisior"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });

    // Event handler detail pasien
    $(document).on("click", "#button-data-detail-Pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-supervisior').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted fs--1 fw-semibold">Memuat Detail Pasien...</p></div>'
        );
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
            $('#menu-supervisior').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle me-1"></i> Gagal memuat data verifikasi.</div>');
        });
    });

    // Event handler pencarian data pasien
    $(document).on("click", "#button-pencarian-data-pasien", function(e) {
        e.preventDefault();
        var kategori = document.getElementById("kategori_pasien").value;
        var layanan = document.getElementById("layanan_pasien").value;

        if (kategori == "") {
            Swal.fire({
                title: "Kategori Belum Dipilih",
                text: "Silakan pilih Kategori Pasien terlebih dahulu.",
                icon: "warning",
                confirmButtonColor: "#2563eb"
            });
        } else if (layanan == "") {
            Swal.fire({
                title: "Layanan Belum Dipilih",
                text: "Silakan pilih Layanan Pasien terlebih dahulu.",
                icon: "warning",
                confirmButtonColor: "#2563eb"
            });
        } else {
            $('#menu-pencarian-data-pasien').html(
                '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted fs--1 fw-semibold">Mencari Data Pasien...</p></div>'
            );
            $.ajax({
                url: "{{ route('menu_pelayanan_supervisior_find') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kategori": kategori,
                    "layanan": layanan,
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pencarian-data-pasien').html(data);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Data Pasien Berhasil Dimuat"
                });
            }).fail(function() {
                Swal.fire({
                    title: "Koneksi Lambat?",
                    text: "Gagal mengambil data dari server, silakan coba lagi.",
                    icon: "error",
                    confirmButtonColor: "#2563eb"
                });
            });
        }
    });
</script>
@endsection
