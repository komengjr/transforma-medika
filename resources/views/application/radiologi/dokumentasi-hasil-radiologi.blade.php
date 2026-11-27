@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
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

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
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
        background: radial-gradient(circle, rgba(244, 63, 94, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Badges */
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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-reset {
        background-color: rgba(100, 116, 139, 0.12);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-reset:hover {
        background-color: rgba(100, 116, 139, 0.22);
        color: var(--bs-body-color);
    }

    /* Form Controls & Input Groups */
    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 4px;
        display: block;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.8rem !important;
        min-height: 36px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-input-group .input-group-text {
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: var(--ent-indigo) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        padding: 0 12px;
    }

    .ent-input-group .form-control {
        border-left: none !important;
        border-radius: 0 10px 10px 0 !important;
    }

    .ent-input-group .btn {
        border-radius: 10px !important;
        margin-left: 6px;
    }

    /* Interactive Handling Item Card */
    .handling-item-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        transition: all 0.16s ease;
        cursor: pointer;
        position: relative;
    }

    .handling-item-card:hover {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-color: var(--ent-indigo);
        transform: translateY(-1px);
    }

    .handling-item-card.active-rad-item {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.14) 0%, rgba(2, 132, 199, 0.12) 100%) !important;
        border: 1.5px solid var(--ent-indigo) !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.16);
    }

    .handling-item-card.active-rad-item .patient-title {
        color: var(--ent-indigo) !important;
    }

    [data-bs-theme="dark"] .handling-item-card.active-rad-item .patient-title,
    .dark .handling-item-card.active-rad-item .patient-title {
        color: #a5b4fc !important;
    }

    .handling-item-card.active-rad-item .reg-code-badge {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-color: var(--ent-indigo) !important;
    }

    /* Code Chips */
    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 2px 8px;
        border-radius: 6px;
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid var(--ent-grid-border);
        display: inline-block;
        color: var(--bs-body-color);
    }

    /* Modals Custom Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
@php
$todayIso = date('Y-m-d');
$activeTglAwal = $tglAwal ?? $todayIso;
$activeTglAkhir = $tglAkhir ?? $todayIso;
$activeNoReg = $noRegFilter ?? '';
$activeDisplayRange = $displayRange ?? date('d/m/Y');
$isCustomFilter = ($activeNoReg !== '') || ($activeTglAwal !== $todayIso) || ($activeTglAkhir !== $todayIso);
@endphp

<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/verif.png') }}" alt="Radiology Dokumentasi Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-radiation me-1"></i> v2.4 Medical Suite
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Instalasi Radiologi</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">
                                Modul <span style="text-decoration: underline;">Dokumentasi Hasil Radiologi</span>
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pengolahan, Verifikasi &amp; Pengiriman Dokumentasi Pemeriksaan Radiologi</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-file-medical-alt text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">Radiologi : Dokumentasi Hasil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT SECTION -->
<div class="row g-3">
    <!-- LEFT SIDEBAR: DAFTAR HANDLING -->
    <div class="col-lg-4">
        <div class="sticky-sidebar" style="top: 20px;">
            <div class="ent-card">
                <div class="ent-card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold fs--1">
                        <i class="fas fa-tasks me-2 text-primary"></i>Daftar Handling
                    </h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.35);">
                        {{ count($data) }} Pasien
                    </span>
                </div>
                <div class="card-body ent-table-surface p-3">
                    <!-- FILTER CONTROLS -->
                    <div class="col-12 mb-3">
                        <label class="ent-field-label">Rentang Tanggal (Default: Hari Ini)</label>
                        <div class="input-group input-group-sm ent-input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker"
                                id="timepicker3"
                                type="text"
                                value="{{ $activeDisplayRange }}"
                                data-tgl-awal="{{ $activeTglAwal }}"
                                data-tgl-akhir="{{ $activeTglAkhir }}"
                                placeholder="Filter Rentang Tanggal..."
                                data-options='{"mode":"range","dateFormat":"d/m/Y","disableMobile":true,"locale":"en"}' />
                            <button type="button" id="btn-filter-tanggal" class="btn btn-sm ent-btn ent-btn-primary px-2.5" title="Terapkan Rentang Tanggal">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <label class="ent-field-label">Pencarian No. Reg / Nama / NIK</label>
                        <div class="input-group input-group-sm ent-input-group">
                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                            <input type="text"
                                name="nik"
                                class="form-control"
                                id="nik"
                                value="{{ $activeNoReg }}"
                                placeholder="Scan QR / No. Reg / Nama...">
                            @if($isCustomFilter)
                            <button type="button" id="btn-reset-filter" class="btn btn-sm ent-btn ent-btn-reset px-2.5" title="Reset ke Hari Ini">
                                <i class="fas fa-undo"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <hr class="my-3" style="border-top: 1px dashed var(--ent-grid-border); opacity: 1;" />

                    <!-- HANDLING ITEMS SCROLL CONTAINER -->
                    <div class="handling-list-wrapper pe-1" id="handling-list-container" style="max-height: 580px; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="handling-item-card remove-class p-3 mb-2 button-dokumentasi-hasil-rad"
                            data-code="{{ $datas->d_reg_order_rad_code }}"
                            data-search="{{ strtolower(($datas->master_patient_name ?? '') . ' ' . ($datas->d_reg_order_rad_code ?? '') . ' ' . ($datas->d_reg_order_code ?? '') . ' ' . ($datas->master_patient_nik ?? '')) }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold patient-title mb-0" style="font-size: 0.88rem;">
                                    {{ $datas->master_patient_name }}
                                </h6>
                                <i class="fas fa-chevron-right opacity-50 fs--2 mt-1"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <span class="fw-semibold small fs--2 opacity-75">No. Registrasi:</span>
                                <span class="code-chip reg-code-badge fs--2">{{ $datas->d_reg_order_rad_code }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 px-2 rounded-3" style="border: 1px dashed var(--ent-grid-border); background: rgba(79, 70, 229, 0.04);">
                            <i class="fas fa-inbox text-primary opacity-75 fa-2x mb-2"></i>
                            <p class="fw-semibold small mb-0 opacity-75">Tidak ada daftar handling pemeriksaan pada tanggal ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION: DETAIL DOKUMENTASI HASIL -->
    <div class="col-lg-8">
        <div id="menu-detail-handling">
            <div class="ent-card p-5 text-center ent-table-surface">
                <div class="py-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px; background: rgba(79, 70, 229, 0.12); border: 1px solid var(--ent-grid-border);">
                        <i class="fas fa-file-medical fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Pilih Pasien Dari Daftar Handling</h5>
                    <p class="fw-semibold small mx-auto mb-0 opacity-75" style="max-width: 420px;">
                        Silakan klik salah satu pasien pada panel sebelah kiri untuk menampilkan detail pemeriksaan dan mengunggah dokumentasi hasil radiologi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modals Section -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm ent-btn ent-btn-reset d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; border-radius: 50%; padding: 0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-poliklinik-full" class="p-3 p-md-4"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm ent-btn ent-btn-reset d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; border-radius: 50%; padding: 0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-poliklinik" class="p-3 p-md-4"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let activeDokDetailAjax = null;

    function toIsoDateFromDmy(dmy) {
        var seg = (dmy || '').trim().split('/');
        if (seg.length !== 3) return '';
        return seg[2] + '-' + seg[1].padStart(2, '0') + '-' + seg[0].padStart(2, '0');
    }

    function applyRadiologiDateFilter(rangeStr) {
        var parts = (rangeStr || '').split(/\s*(?:to|-)\s*/i).map(function(s) {
            return s.trim();
        }).filter(Boolean);

        var startIso = parts[0] ? toIsoDateFromDmy(parts[0]) : ($('#timepicker3').data('tgl-awal') || '');
        var endIso = parts[1] ? toIsoDateFromDmy(parts[1]) : (startIso || ($('#timepicker3').data('tgl-akhir') || ''));

        var noRegVal = ($('#nik').val() || '').trim();
        var url = new URL(window.location.href);

        if (startIso) {
            url.searchParams.set('tgl_awal', startIso);
        }
        if (endIso) {
            url.searchParams.set('tgl_akhir', endIso);
        }
        if (noRegVal !== '') {
            url.searchParams.set('no_reg', noRegVal);
        } else {
            url.searchParams.delete('no_reg');
        }

        window.location.href = url.toString();
    }

    $(document).ready(function() {
        if ($('#example').length) {
            new DataTable('#example', {
                responsive: true
            });
        }

        function filterHandlingList() {
            const keyword = ($('#nik').val() || '').toLowerCase().trim();
            $('.button-dokumentasi-hasil-rad').each(function() {
                const searchable = $(this).data('search') || '';
                $(this).toggle(searchable.indexOf(keyword) !== -1);
            });
        }

        $('#nik').on('input', filterHandlingList);
        if (($('#nik').val() || '').trim() !== '') {
            filterHandlingList();
        }

        $('#btn-filter-tanggal').on('click', function() {
            applyRadiologiDateFilter($('#timepicker3').val());
        });

        $('#nik').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                applyRadiologiDateFilter($('#timepicker3').val());
            }
        });

        $('#btn-reset-filter').on('click', function() {
            var baseUrl = window.location.origin + window.location.pathname;
            window.location.href = baseUrl;
        });

        var fpInput = document.getElementById('timepicker3');
        if (fpInput && fpInput._flatpickr) {
            fpInput._flatpickr.config.onClose.push(function(selectedDates, dateStr) {
                if (selectedDates.length >= 1) {
                    applyRadiologiDateFilter(dateStr);
                }
            });
        }
    });

    // Event Handler: Klik Item Antrean Handling Radiologi
    $(document).on("click", ".button-dokumentasi-hasil-rad", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $(".remove-class").removeClass("active-rad-item");
        $(this).addClass("active-rad-item");

        if (activeDokDetailAjax && activeDokDetailAjax.readyState !== 4) {
            activeDokDetailAjax.abort();
        }

        $('#menu-detail-handling').html(`
            <div class="ent-card p-5 text-center ent-table-surface">
                <div class="py-5">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="fw-bold mb-1">Memuat Dokumentasi Hasil Radiologi...</h6>
                    <p class="small mb-0 fw-semibold opacity-75">Sedang mengambil data pemeriksaan pasien.</p>
                </div>
            </div>
        `);

        activeDokDetailAjax = $.ajax({
            url: "{{ route('dokumentasi_hasil_radiologi_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-handling').html(data);
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            $('#menu-detail-handling').html(`
                <div class="alert alert-danger rounded-3 p-4 text-center fw-semibold" role="alert" style="border: 1px solid rgba(225, 29, 72, 0.35);">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6 class="fw-bold">Gagal Memuat Detail Handling</h6>
                    <p class="small mb-0">Terjadi kesalahan pada jaringan atau server. Silakan coba lagi.</p>
                </div>
            `);
        }).always(function() {
            activeDokDetailAjax = null;
        });
    });

    // Event Handler: Kirim Dokumentasi Hasil Radiologi
    $(document).on("click", "#button-kirim-dokumentasi-hasil", function(e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.prop('disabled')) return;

        var code = $btn.data("code");

        Swal.fire({
            title: "Konfirmasi Pengiriman Hasil?",
            text: "Pastikan berkas dokumentasi hasil pemeriksaan sudah lengkap dan sesuai.",
            icon: "question",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#4f46e5",
            cancelButtonColor: "#e11d48",
            confirmButtonText: "<i class='fas fa-paper-plane me-1'></i> Ya, Kirim Hasil!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Mengirimkan...
                `);

                $.ajax({
                    url: "{{ route('dokumentasi_hasil_radiologi_detail_kirim_hasil') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                    },
                    dataType: 'html',
                }).done(function() {
                    Swal.fire({
                        title: "Berhasil Dikirim!",
                        text: "Dokumentasi hasil radiologi telah berhasil dikirim.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }).fail(function() {
                    $btn.prop('disabled', false).html(`
                        <i class="fas fa-paper-plane me-1"></i> Kirim Hasil
                    `);

                    Swal.fire({
                        title: "Gagal Mengirim",
                        text: "Terjadi kesalahan saat proses pengiriman hasil radiologi.",
                        icon: "error",
                        confirmButtonColor: "#4f46e5"
                    });
                });
            }
        });
    });
</script>
@endsection
