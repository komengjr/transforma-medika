@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.22);
        --ent-emerald: #059669;
        --ent-solid-bg: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-grid-border: rgba(148, 163, 184, 0.2);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 6px 24px -4px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.07) 0%, rgba(79, 70, 229, 0.02) 100%) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #090d16 0%, #1e1b4b 52%, #312e81 100%);
        border: 1px solid rgba(129, 140, 248, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.28);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .handling-card {
        transition: all 0.16s ease-in-out;
        cursor: pointer;
        border: 1px solid var(--ent-grid-border) !important;
        border-left: 4px solid var(--ent-indigo) !important;
        border-radius: 12px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .handling-card:not(.active-handling):hover {
        transform: translateY(-1px);
        border-color: rgba(79, 70, 229, 0.45) !important;
        box-shadow: 0 6px 16px -6px rgba(79, 70, 229, 0.25);
        background-color: rgba(79, 70, 229, 0.04);
    }

    .handling-card.active-handling {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.14) 0%, rgba(56, 189, 248, 0.08) 100%) !important;
        border-color: var(--ent-indigo) !important;
        border-left: 4px solid var(--ent-emerald) !important;
        box-shadow: 0 8px 18px -6px rgba(79, 70, 229, 0.28);
    }

    .handling-card.active-handling .patient-name {
        color: var(--ent-indigo) !important;
        font-weight: 800;
    }

    .ent-input-group .input-group-text {
        background-color: rgba(79, 70, 229, 0.07);
        border: 1px solid var(--ent-grid-border);
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--ent-indigo);
    }

    .ent-input-group .form-control {
        border: 1px solid var(--ent-grid-border);
        border-left: none;
        border-radius: 0 10px 10px 0;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        font-size: 0.82rem;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        font-size: 0.8rem;
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
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

    .ent-empty-state {
        border: 1px dashed var(--ent-grid-border);
        border-radius: 14px;
        background-color: rgba(79, 70, 229, 0.025);
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }

    @media (min-width: 992px) {
        .sticky-sidebar {
            position: sticky;
            top: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/verif.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-flask me-1"></i> LAB DOCUMENTATION
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">v2.4 Medical Suite</span>
                            </div>
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: -0.02em;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="text-warning fw-bold mb-0" style="font-size: 0.92rem;">
                                <i class="fas fa-file-signature me-1"></i> Dokumentasi Hasil Laboratorium
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Sidebar Kiri: Filter & Daftar Handling Pasien -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card ent-card">
                <div class="ent-card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 34px; height: 34px; background-color: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold" style="font-size: 0.92rem;">Daftar Handling Hari Ini</h6>
                            <small class="opacity-75" style="font-size: 0.7rem;" id="handlingFilterInfo">
                                Tanggal: {{ $default_today ?? date('d/m/Y') }} ({{ count($data) }} pasien)
                            </small>
                        </div>
                    </div>
                    <span class="ent-badge" id="handlingTotalBadge" style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);">
                        {{ count($data) }} Pasien
                    </span>
                </div>

                <div class="card-body p-3">
                    <!-- Form Pencarian: Ketik No. Reg & Range Tanggal -> Klik Cari -->
                    <form id="formSearchDokumentasiLab" class="row g-2 mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold mb-1" style="font-size: 0.75rem;">No. Registrasi</label>
                            <div class="input-group input-group-sm ent-input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-barcode"></i>
                                </span>
                                <input type="text"
                                    name="no_registrasi"
                                    class="form-control"
                                    id="searchNoReg"
                                    placeholder="Ketik / Scan No. Registrasi..."
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold mb-1" style="font-size: 0.75rem;">Range Tanggal</label>
                            <div class="input-group input-group-sm ent-input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input class="form-control datetimepicker"
                                    name="range_tanggal"
                                    id="searchDateRange"
                                    type="text"
                                    placeholder="Pilih Rentang Tanggal..."
                                    data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                            </div>
                        </div>

                        <div class="col-8 pt-1">
                            <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2" id="btnSearchHandling">
                                <i class="fas fa-search me-1"></i> Cari Data
                            </button>
                        </div>
                        <div class="col-4 pt-1">
                            <button type="button" class="btn ent-btn btn-outline-secondary w-100 py-2" id="btnResetToday" title="Kembali ke Data Hari Ini">
                                <i class="fas fa-calendar-day me-1"></i> Hari Ini
                            </button>
                        </div>
                    </form>

                    <hr class="my-3" style="border-color: var(--ent-grid-border);" />

                    <!-- Daftar Item Pasien -->
                    <div class="d-flex flex-column gap-2 overflow-auto patient-list-container pe-1" style="max-height: 550px;" id="handlingPatientList">
                        @include('application.laboratorium.dokumentasi-hasil.dokumentasi-hasil-list', ['data' => $data])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Kanan: Detail Handling Pasien -->
    <div class="col-lg-8">
        <div id="menu-detail-handling" class="h-100">
            <div class="ent-card h-100 d-flex align-items-center justify-content-center p-5 text-center" style="min-height: 460px;">
                <div>
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-4"
                        style="width: 78px; height: 78px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.14) 0%, rgba(56, 189, 248, 0.14) 100%); border: 1px solid var(--ent-grid-border); color: #6366f1;">
                        <i class="fas fa-notes-medical fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Pilih Pasien Dari Daftar Handling</h5>
                    <p class="opacity-75 mb-0 mx-auto" style="max-width: 420px; font-size: 0.84rem;">
                        Klik salah satu antrean pasien di sebelah kiri untuk melihat rincian dokumentasi dan file hasil laboratorium.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
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
    $(document).ready(function() {
        function jalankanPencarian(resetHariIni = false) {
            const noReg = resetHariIni ? '' : ($('#searchNoReg').val() || '').trim();
            const rangeTgl = resetHariIni ? '' : ($('#searchDateRange').val() || '').trim();

            $('#handlingPatientList').html(
                '<div class="text-center py-4">' +
                '<div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>' +
                '<span class="fw-semibold" style="font-size: 0.82rem;">Mencari data dokumentasi lab...</span>' +
                '</div>'
            );

            $.ajax({
                url: "{{ route('dokumentasi_hasil_laboratorium_search') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "no_registrasi": noReg,
                    "range_tanggal": rangeTgl
                },
                dataType: 'json'
            }).done(function(res) {
                if (res && res.status) {
                    $('#handlingPatientList').html(res.html);
                    $('#handlingTotalBadge').text(`${res.total} Pasien`);

                    if (resetHariIni || (!noReg && !rangeTgl)) {
                        $('#handlingFilterInfo').text(`Tanggal: {{ $default_today ?? date('d/m/Y') }} (${res.total} pasien)`);
                    } else {
                        const ket = [noReg ? `Reg: ${noReg}` : '', rangeTgl ? `Tgl: ${rangeTgl}` : ''].filter(Boolean).join(' • ');
                        $('#handlingFilterInfo').text(`${ket} (${res.total} pasien)`);
                    }
                }
            }).fail(function() {
                $('#handlingPatientList').html(
                    '<div class="alert alert-danger border-0 text-center py-3 mb-0" style="font-size: 0.8rem; border-radius: 12px;">' +
                    '<i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat hasil pencarian.' +
                    '</div>'
                );
            });
        }

        // Pencarian hanya dijalankan saat form disubmit / tombol "Cari Data" diklik
        $('#formSearchDokumentasiLab').on('submit', function(e) {
            e.preventDefault();
            jalankanPencarian(false);
        });

        // Kembali ke data hari ini saja
        $('#btnResetToday').on('click', function() {
            $('#searchNoReg').val('');
            const fpInstance = document.getElementById('searchDateRange')?._flatpickr;
            if (fpInstance) {
                fpInstance.clear();
            } else {
                $('#searchDateRange').val('');
            }
            jalankanPencarian(true);
        });

        // Event Klik Item Handling Pasien
        $(document).on("click", ".button-dokumentasi-hasil-lab", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            $(".handling-card").removeClass("active-handling");
            $(this).addClass("active-handling");

            $('#menu-detail-handling').html(
                '<div class="ent-card py-5 text-center" style="min-height: 460px;">' +
                '<div class="card-body d-flex flex-column align-items-center justify-content-center">' +
                '<div class="spinner-border text-primary my-3" role="status" style="width: 2.5rem; height: 2.5rem;"><span class="visually-hidden">Loading...</span></div>' +
                '<p class="opacity-75 fw-semibold mb-0" style="font-size: 0.85rem;">Memuat rincian dokumentasi hasil lab pasien...</p>' +
                '</div>' +
                '</div>'
            );

            $.ajax({
                url: "{{ route('dokumentasi_hasil_laboratorium_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-detail-handling').html(data);
            }).fail(function() {
                $('#menu-detail-handling').html(
                    '<div class="alert alert-danger border-0 shadow-sm text-center my-3 fw-semibold" role="alert" style="border-radius: 12px;">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan sistem saat memuat data.' +
                    '</div>'
                );
            });
        });
    });
</script>
@endsection
