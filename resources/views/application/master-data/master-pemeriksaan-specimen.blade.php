@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
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
        --ent-subtle-surface: #f8fafc;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-subtle-surface: #1e293b;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Header Banner */
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
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Cards */
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
        padding: 14px 20px;
    }

    /* Badges & Code Chips */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.78rem;
        cursor: pointer;
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
        color: #ffffff;
    }

    .ent-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.22);
    }

    .ent-btn-warning:hover {
        color: #ffffff;
    }

    /* Table Styling */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.83rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom tbody tr.row-selected,
    .table-custom tbody tr.row-selected td {
        background-color: rgba(79, 70, 229, 0.12) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* DataTables Search & Length Styling */
    .dt-container .dt-search input,
    .dt-container .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 9px !important;
        padding: 5px 10px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
    }

    .dt-container .dt-search input:focus,
    .dt-container .dt-length select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
        outline: none;
    }

    /* Choices.js Customization */
    .choices__inner {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 40px !important;
        padding: 4px 10px !important;
    }

    .choices__list--dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15) !important;
        z-index: 1050;
    }

    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    /* Specimen Panel Helpers */
    #menu-master-specimen .form-control,
    #menu-master-specimen .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
    }

    #menu-master-specimen .btn {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 58px; height: 58px;">
                            <img src="{{ asset('img/kategori.png') }}" alt="Spesimen Pemeriksaan" width="36" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-vials"></i> MANAJEMEN LABORATORIUM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Pre-Analitik &amp; Sampel</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Spesimen Pemeriksaan
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pemetaan jenis spesimen (darah, urine, serum, swab, dll.) untuk setiap item pemeriksaan.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Total Pemeriksaan</span>
                            <span class="fw-bold" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">{{ $data->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- TABEL PEMERIKSAAN (KIRI) -->
    <div class="col-lg-8">
        <div class="ent-card mb-3 mb-lg-0">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold"><i class="fas fa-microscope me-2 text-primary"></i>Data Master Pemeriksaan</h6>
                    <small class="opacity-75">Klik tombol Pilih untuk memuat dan mengatur daftar spesimen pemeriksaan.</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table id="example" class="table table-custom align-middle nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 48px;">No</th>
                                <th>Kode</th>
                                <th>Tipe Layanan</th>
                                <th>Nama Pemeriksaan</th>
                                <th class="text-center" style="width: 105px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data as $datas)
                            <tr>
                                <td class="text-center fw-semibold">{{ $no++ }}</td>
                                <td><span class="code-chip">{{ $datas->kode_layanan }}</span></td>
                                <td>
                                    <span class="ent-badge" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.3);">
                                        {{ $datas->nama_tipe }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $datas->nama_layanan }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm ent-btn ent-btn-warning btn-pilih-specimen px-3 py-1" data-code="{{ $datas->id }}">
                                        <i class="fas fa-flask me-1"></i> Pilih
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
        <div class="ent-card sticky-top" style="top: 20px; z-index: 10;">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-vial me-2 text-primary"></i>Data Spesimen</h6>
                <small class="opacity-75">Kelola spesimen yang terhubung dengan pemeriksaan terpilih.</small>
            </div>
            <div class="card-body p-3 p-md-4">
                <div id="menu-master-specimen">
                    <div class="text-center py-5 opacity-75">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 56px; height: 56px; background: rgba(79, 70, 229, 0.1); color: var(--ent-indigo);">
                            <i class="fas fa-arrow-left fs-5"></i>
                        </div>
                        <div class="fw-semibold small">
                            Silakan klik tombol <strong>Pilih</strong> pada salah satu pemeriksaan di sebelah kiri untuk mengatur spesimen.
                        </div>
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
        let specimenChoices = null;

        function initSpecimenSelect() {
            const selectEl = document.getElementById('data_specimen');
            if (!selectEl || typeof Choices === 'undefined') return;

            if (specimenChoices && typeof specimenChoices.destroy === 'function') {
                specimenChoices.destroy();
                specimenChoices = null;
            }

            specimenChoices = new Choices(selectEl, {
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: '',
                placeholderValue: 'Ketik atau pilih spesimen...',
                searchPlaceholderValue: 'Cari nama spesimen...'
            });
        }

        new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari data:",
                lengthMenu: "Tampil _MENU_ data",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ pemeriksaan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "❯",
                    previous: "❮"
                }
            }
        });

        // AJAX Load Detail / Form Specimen Berdasarkan ID Pemeriksaan
        $(document).on("click", ".btn-pilih-specimen", function(e) {
            e.preventDefault();
            const code = $(this).data("code");

            $('#example tbody tr').removeClass('row-selected');
            $(this).closest('tr').addClass('row-selected');

            $('#menu-master-specimen').html(
                '<div class="text-center p-5">' +
                    '<div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status"></div>' +
                    '<p class="mt-3 fw-semibold small opacity-75">Memuat data spesimen...</p>' +
                '</div>'
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
                initSpecimenSelect();
            }).fail(function() {
                $('#menu-master-specimen').html(
                    '<div class="alert alert-danger fw-semibold small">Gagal memuat data spesimen dari server.</div>'
                );
            });
        });

        // AJAX Simpan Specimen ke Pemeriksaan
        $(document).on("click", "#button-simpan-data-specimen-pemeriksaan", function(e) {
            e.preventDefault();
            const code = $(this).data("code");
            const specimen = $('#data_specimen').val();

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
                    initSpecimenSelect();
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
