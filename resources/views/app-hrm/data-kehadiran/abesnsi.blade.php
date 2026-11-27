@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        overflow: visible;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px 14px 0 0;
        padding: 14px 20px;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-label {
        font-weight: 700;
        margin-bottom: 6px;
        display: inline-block;
        color: var(--bs-body-color, var(--ent-text));
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        cursor: pointer;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    /* Choices.js Searchable Dropdown Styling */
    .choices {
        margin-bottom: 0 !important;
    }

    .choices__inner {
        min-height: 42px !important;
        padding: 5px 10px !important;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        font-size: 1rem !important;
    }

    .choices__input {
        background-color: transparent !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-size: 0.875rem !important;
        margin-bottom: 0 !important;
        padding: 2px 4px !important;
    }

    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.16) !important;
        z-index: 1060 !important;
    }

    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: #4f46e5 !important;
    }

    .choices__list--dropdown .choices__item {
        font-size: 0.875rem;
        padding: 7px 12px;
    }

    .ent-select-input {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 7px 12px !important;
    }

    .ent-select-input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/app.png') }}" alt="Absensi Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-fingerprint"></i> {{ Env('APP_LABEL', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Data Absensi Staff</span>
                        </div>
                        <h4 class="fw-bold mb-0 fs-1" style="letter-spacing: -0.02em; color: white;">
                            Rekapitulasi Kehadiran &amp; Presensi Staff
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Menampilkan log presensi harian, ketepatan waktu, dan rekap kehadiran bulanan berdasarkan Nama Staff dan periode.</p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Cakupan Data</span>
                        <span class="fw-bold fs--1" style="color: #7dd3fc;">
                            <i class="fas fa-user-clock me-1"></i> Seluruh Staff Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- FILTER CARD -->
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold fs-1">
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Pencarian Data Absensi
                </h6>
                <span class="opacity-75 fs--1">Pilih Nama Staff (ketik untuk mencari), Bulan, dan Tahun periode absensi.</span>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form class="row g-3 align-items-end needs-validation" novalidate="" id="form-absensi-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="data_nama" class="ent-label fs--1">Nama Staff</label>
                <select class="form-select js-searchable-select fs-2" id="data_nama" name="data_nama">
                    <option value="">Semua Staff...</option>
                    @if(isset($staffs))
                    @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                    @else
                    <option value="1">Massachusetts Institute</option>
                    <option value="2">University of Chicago</option>
                    @endif
                </select>
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="data_bulan" class="ent-label fs--1">Bulan</label>
                <select class="form-select ent-select-input fs-2" id="data_bulan" name="data_bulan">
                    <option value="">Pilih Bulan...</option>
                    @php
                    $bulanList = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ];
                    $currentMonth = date('m');
                    @endphp
                    @foreach($bulanList as $key => $val)
                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="data_tahun" class="ent-label fs--1">Tahun</label>
                <select class="form-select ent-select-input ent-mono fs-2" id="data_tahun" name="data_tahun">
                    <option value="">Pilih Tahun...</option>
                    @php
                    $currentYear = date('Y');
                    $startYear = $currentYear - 3;
                    $endYear = $currentYear + 1;
                    @endphp
                    @for($y = $endYear; $y >= $startYear; $y--)
                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2 fs-2" type="button" id="button-search-data">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RESULT CONTAINER -->
<div class="card ent-card fs-2" id="menu-general-ledger"></div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".js-searchable-select").forEach(function(selectEl) {
            if (!selectEl.dataset.choicesInitialized) {
                new Choices(selectEl, {
                    searchEnabled: true,
                    shouldSort: false,
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: selectEl.options[0] ? selectEl.options[0].text : "Semua Staff...",
                    searchPlaceholderValue: "Ketik nama staff untuk mencari...",
                    noResultsText: "Nama staff tidak ditemukan",
                    noChoicesText: "Tidak ada data staff tersedia",
                    itemSelectText: "Tekan untuk pilih"
                });
                selectEl.dataset.choicesInitialized = "true";
            }
        });
    });

    $(document).on("click", "#button-search-data", function(e) {
        e.preventDefault();
        var nama = document.getElementById("data_nama").value;
        var bulan = document.getElementById("data_bulan").value;
        var tahun = document.getElementById("data_tahun").value;

        if (bulan === "" || tahun === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Silakan pilih Bulan dan Tahun terlebih dahulu!",
                confirmButtonColor: "#4f46e5"
            });
            $('#menu-general-ledger').html('');
            return;
        }

        $('#menu-general-ledger').html(
            '<div class="py-5 text-center">' +
            '<div class="spinner-border text-primary mb-2" role="status"><span class="visually-hidden">Loading...</span></div>' +
            '<div class="fs--1 fw-semibold opacity-75">Memuat data Absensi Staff...</div>' +
            '</div>'
        );

        $.ajax({
            url: "{{ route('data_kehadiran_search') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "nama": nama,
                "bulan": bulan,
                "tahun": tahun
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-general-ledger').html(data);
        }).fail(function() {
            $('#menu-general-ledger').html(
                '<div class="p-4 text-center text-danger fw-bold fs-2">' +
                '<i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat data Absensi Staff.' +
                '</div>'
            );
        });
    });
</script>
@endsection
