@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 18px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* Floating Field Filter Style */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 5px;
        left: 11px;
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        pointer-events: none;
        z-index: 5 !important;
        background: transparent !important;
    }

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        padding-top: 18px;
        padding-bottom: 5px;
        padding-left: 11px;
        font-size: 0.8rem;
        font-weight: 600;
        height: 44px;
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        background-color: var(--ent-solid-bg);
        color: var(--ent-solid-text);
        transition: all 0.2s ease;
    }

    .form-floating-custom .form-control:focus,
    .form-floating-custom .form-select:focus {
        border-color: var(--ent-indigo);
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15);
        outline: none;
    }

    /* Solid / Absolut Select2 Styling */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 44px !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
        padding-left: 8px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .form-floating-custom .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .form-floating-custom .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 3px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        opacity: 1 !important;
        font-size: 0.8rem;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.24) !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown,
    .select2-container--bootstrap-5 .select2-results__options,
    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        font-size: 0.8rem !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted,
    .select2-container--bootstrap-5 .select2-results__option--selected {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    /* Button Search */
    .btn-search-modern {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.82rem;
        height: 44px;
        transition: all 0.18s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .btn-search-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    /* Empty State & Result Area */
    .ent-empty-icon {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.14), rgba(14, 165, 233, 0.14));
        border: 1px solid var(--ent-grid-border);
        color: #6366f1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal Adaptive Enterprise */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- Header Welcome Banner -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-lg-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-md-7 d-flex align-items-center gap-3">
                        <div class="ent-glass-pill p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/super.png') }}" alt="Icon" width="42" height="42" class="object-fit-contain" />
                        </div>
                        <div>
                            <span class="ent-badge mb-1" style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.45); color: #fcd34d;">
                                <i class="fas fa-shield-alt me-1"></i> Akses Khusus
                            </span>
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: -0.02em;">
                                {{ Env('APP_LABEL') }} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-block text-start text-md-end">
                            <span class="fw-semibold text-uppercase d-block" style="font-size: 0.68rem; color: #94a3b8;">Modul Layanan</span>
                            <h6 class="text-white fw-bold mb-0 mt-0.5">
                                Supervisor <span class="ent-badge ms-1" style="background: rgba(245, 158, 11, 0.22); border: 1px solid rgba(245, 158, 11, 0.45); color: #fcd34d;">Verifikasi &amp; Koreksi</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Area -->
<div class="card ent-card mb-4">
    <div class="card-body p-3 p-lg-4">
        <!-- Form Pencarian Filter -->
        <div class="row g-2.5 align-items-end mb-3">

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
                <button type="button" class="btn btn-search-modern d-flex align-items-center justify-content-center gap-2" id="button-pencarian-data-pasien">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Area Hasil Pencarian (Dynamic Ajax Content) -->
        <div class="pt-4 mt-3" id="menu-pencarian-data-pasien" style="border-top: 1px solid var(--ent-grid-border);">
            <div class="text-center py-5">
                <div class="ent-empty-icon mb-3">
                    <i class="fas fa-clipboard-list fs-2"></i>
                </div>
                <h6 class="fw-bold mb-1">Pusat Koreksi Data Registrasi</h6>
                <p class="opacity-75 mb-0 small" style="max-width: 420px; margin: 0 auto;">
                    Gunakan filter di atas untuk menampilkan, mengoreksi, menghapus (VOID), atau menambahkan pemeriksaan pasien.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Modal Ajax untuk Koreksi/Edit Supervisor -->
<div class="modal fade" id="modal-supervisior" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close shadow-sm rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
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
        $('#kategori_pasien, #layanan_pasien').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });
    });

    $(document).on("click", "#button-pencarian-data-pasien", function(e) {
        e.preventDefault();
        var kategori = $('#kategori_pasien').val();
        var layanan = $('#layanan_pasien').val();
        var tanggal = $('#rentang_tanggal').val();

        if (!tanggal || tanggal.length < 20) {
            Swal.fire({
                title: "Tanggal Belum Dipilih",
                text: "Silakan pilih rentang tanggal pencarian terlebih dahulu.",
                icon: "warning",
                confirmButtonColor: "#4f46e5"
            });
            return;
        }

        $('#menu-pencarian-data-pasien').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 opacity-75 small fw-semibold">Memuat Data Registrasi...</p></div>'
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
                confirmButtonColor: "#4f46e5"
            });
            $('#menu-pencarian-data-pasien').html('<div class="p-4 text-center text-danger fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i> Terjadi kesalahan memuat data.</div>');
        });
    });

    $(document).on("click", ".button-data-detail-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-supervisior').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 opacity-75 small fw-semibold">Membuka Panel Supervisi...</p></div>'
        );

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
            $('#menu-supervisior').html('<div class="p-4 text-center text-danger fw-semibold"><i class="fas fa-exclamation-circle fs-3 mb-2"></i><br>Gagal memuat panel pengeditan registrasi.</div>');
        });
    });
</script>
@endsection
