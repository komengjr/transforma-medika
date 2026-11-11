@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

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
        /* background-color: var(--retro-bg); */
        color: var(--retro-dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-cyan) 0%, var(--retro-purple) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }

    /* Filter Bar Atas Retro */
    .filter-wrapper {
        background: #ffffff;
        border: var(--retro-border);
        box-shadow: var(--retro-shadow-sm);
        padding: 15px;
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .custom-input-box {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 18px 10px 4px 10px;
        position: relative;
        background: #fff;
        flex: 1;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    .custom-input-box label {
        position: absolute;
        top: 2px;
        left: 8px;
        font-size: 10px;
        color: var(--retro-dark);
        font-weight: 800;
        pointer-events: none;
        text-transform: uppercase;
    }

    .custom-input-box input,
    .custom-input-box select {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 13px;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 0;
    }

    .btn-search-blue {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
        font-weight: 800;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        padding: 0 22px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.1s;
    }

    .btn-search-blue:hover,
    .btn-search-blue:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
        background-color: #ffd230;
    }

    /* Card Table Frame */
    .rad-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .rad-card-header {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        border-bottom: 3px solid var(--retro-dark);
        padding: 14px 20px;
    }

    /* Table Radiology Custom Styling */
    .table-radiologi {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-radiologi thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.6px;
        border-bottom: 2px solid var(--retro-dark);
        padding: 12px 10px;
    }

    .table-radiologi tbody tr {
        transition: all 0.1s ease;
    }

    .table-radiologi tbody tr.row-clickable {
        cursor: pointer;
    }

    .table-radiologi tbody tr td {
        border-bottom: 2px solid var(--retro-dark);
        border-right: 2px solid var(--retro-dark);
        padding: 12px 10px;
        font-weight: 700;
        color: var(--retro-dark);
    }

    .table-radiologi tbody tr td:last-child {
        border-right: none;
    }

    .table-radiologi tbody tr:hover td {
        background-color: var(--retro-cyan) !important;
    }

    .table-radiologi tbody tr:hover td .patient-name {
        color: var(--retro-dark) !important;
    }

    /* Code Chips */
    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        background-color: #ffffff;
        border: 2px solid var(--retro-dark);
        box-shadow: 2px 2px 0px var(--retro-dark);
        display: inline-block;
        color: var(--retro-dark);
    }

    .code-chip-cyan {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    /* Modals Custom Styling */
    .modal-content.rad-modal {
        border: 3px solid var(--retro-dark);
        border-radius: 14px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: var(--retro-bg);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                    <i class="fas fa-radiation me-1"></i> MEDICAL SUITE v2.4
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.3rem; text-shadow: 1px 1px 0px white;">
                                Dokter: <span style="text-decoration: underline;">Pengisian & Verifikasi Ekspertise</span>
                            </h3>
                            <p class="text-dark fw-bold mb-0 small opacity-75" style="font-size: 0.75rem;">Modul Verifikasi & Processing Hasil Pemeriksaan Radiologi</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-notes-medical me-1 text-danger"></i> Radiologi : Ekspertise
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR ATAS (AJAX Form) -->
<form id="form-filter-verifikasi" class="filter-wrapper">
    <!-- Tanggal Awal -->
    <div class="custom-input-box" style="flex: 0.8;">
        <label>Tanggal Awal</label>
        <input type="text" class="datetimepicker" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
    </div>

    <!-- Tanggal Akhir -->
    <div class="custom-input-box" style="flex: 0.8;">
        <label>Tanggal Akhir</label>
        <input type="text" class="datetimepicker" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
    </div>

    <!-- Cari -->
    <div class="custom-input-box" style="flex: 1.2;">
        <label>Cari...</label>
        <input type="text" name="cari" placeholder="No Reg / Nama / RM">
    </div>

    <!-- Kel. Pelanggan -->
    <div class="custom-input-box" style="flex: 1;">
        <label>Kel. Pelanggan</label>
        <select name="penjamin">
            <option value="Semua">Semua</option>
            <option value="UMUM">UMUM</option>
            <option value="PASIEN KLINIS">PASIEN KLINIS</option>
            <option value="ASURANSI">ASURANSI</option>
        </select>
    </div>

    <!-- Pemeriksaan (X-Ray, USG, dll) -->
    <div class="custom-input-box" style="flex: 1;">
        <label>Pemeriksaan</label>
        <select name="pemeriksaan">
            <option value="Semua">Semua Pemeriksaan</option>
            <option value="X-RAY">X-RAY / Rontgen</option>
            <option value="USG">USG</option>
            <option value="CT-SCAN">CT-SCAN</option>
            <option value="MRI">MRI</option>
        </select>
    </div>

    <!-- Tombol Submit Form -->
    <button type="submit" class="btn-search-blue" title="Cari Data">
        <i class="fas fa-search"></i>
    </button>
</form>

<!-- MAIN TABLE CARD -->
<div class="rad-card mb-4">
    <div class="rad-card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-light border border-dark rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold shadow-sm"
                    onclick="loadDataVerifikasi();"
                    data-bs-toggle="tooltip"
                    title="Refresh Data"
                    style="width: 32px; height: 32px; background-color: var(--retro-yellow); color: var(--retro-dark);">
                    <i class="fas fa-redo-alt"></i>
                </button>
                <span class="text-white-50">|</span>
                <span class="fw-bolder fs--1 text-white">
                    <i class="fas fa-list-alt me-1 text-info"></i> Data Antrean & Verifikasi Hasil Radiologi
                </span>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-radiologi w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">No</th>
                        <th>Identitas Pasien</th>
                        <th>Kategori</th>
                        <th>Tanggal Reg</th>
                        <th>Dokter / Petugas</th>
                        <th class="text-center">Status Pembayaran</th>
                        <th class="text-center">Status Pem.</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-verifikasi" class="fs--1">
                    <tr>
                        <td colspan="8" class="text-center py-4 text-dark fw-bold">
                            <i class="fas fa-spinner fa-spin me-2"></i> Memuat data verifikasi...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modals Section -->
<div class="modal fade" id="modal-radiologi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalRadiologiFullLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-white border border-dark fw-bold shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi-full" class="p-3"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    // Fungsi Global Load Data Table
    function loadDataVerifikasi() {
        var formData = $('#form-filter-verifikasi').serialize();

        $('#tbody-verifikasi').html(`
            <tr>
                <td colspan="8" class="text-center py-5 text-dark fw-bold">
                    <div class="spinner-border text-dark mb-2" role="status"></div>
                    <br>Mencari data...
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('radiologi.get_data_verifikasi') }}",
            type: "GET",
            data: formData,
            success: function(response) {
                var html = '';
                if (response.data && response.data.length > 0) {
                    $.each(response.data, function(index, val) {

                        // Badge Status Pembayaran
                        var paymentBadge = '';
                        if (val.status_pembayaran === 'LUNAS' || val.status_pembayaran === 'SEBAGIAN' || val.status_pembayaran === 'ASURANSI') {
                            paymentBadge = '<span class="badge bg-white text-success border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm"><i class="fas fa-check-circle me-1"></i>Lunas</span>';
                        } else {
                            paymentBadge = '<span class="badge bg-white text-danger border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm"><i class="fas fa-times-circle me-1"></i>Belum Lunas</span>';
                        }

                        // Badge Status Pemeriksaan
                        var statusBadge = '';
                        if (val.status_pemeriksaan === 'SELESAI') {
                            statusBadge = '<span class="badge bg-white text-success border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm"><i class="fas fa-check-double me-1"></i>Selesai / Menunggu Verif</span>';
                        } else if (val.status_pemeriksaan === 'PROSES') {
                            statusBadge = '<span class="badge bg-white text-warning border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm"><i class="fas fa-spinner fa-spin me-1"></i>Diproses Petugas</span>';
                        } else {
                            statusBadge = '<span class="badge bg-white text-danger border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm"><i class="fas fa-hourglass-half me-1"></i>Antrean</span>';
                        }

                        html += `
                            <tr class="row-clickable" id="button-verifikasi-hasil" data-code="${val.registrasi_id}" data-reg="${val.order_rad_code}" data-bs-toggle="modal" data-bs-target="#modal-radiologi-full">
                                <td class="text-center fw-bold text-dark">${index + 1}</td>
                                <td>
                                    <div class="fw-bolder text-dark patient-name transition-base">${val.master_patient_name}</div>
                                    <div class="mt-1 d-flex gap-1">
                                        <span class="code-chip text-dark fs--2" title="No Registrasi">${val.no_registrasi}</span>
                                        <span class="code-chip code-chip-cyan fs--2" title="Order Code">${val.order_rad_code}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-white text-dark border border-dark fw-bold shadow-sm">${val.nama_penjamin}</span>
                                </td>
                                <td>
                                    <span class="text-dark fw-bold"><i class="far fa-clock me-1 text-dark"></i>${val.tanggal_registrasi_formatted}</span>
                                </td>
                                <td>
                                    <span class="badge bg-white text-dark border border-dark fs--2 fw-bold shadow-sm">
                                        <i class="fas fa-user-md me-1"></i>${val.nama_dokter_petugas}
                                    </span>
                                </td>
                                <td class="text-center" onclick="event.stopPropagation();">
                                    ${paymentBadge}
                                </td>
                                <td class="text-center" onclick="event.stopPropagation();">
                                    ${statusBadge}
                                </td>
                                <td class="text-center" onclick="event.stopPropagation();">
                                    <button class="btn btn-sm border border-dark rounded-2 px-3 fw-bolder shadow-sm" type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-radiologi-full"
                                            id="button-verifikasi-hasil"
                                            data-code="${val.registrasi_id}"
                                            data-reg="${val.order_rad_code}"
                                            style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                        <i class="fas fa-pen-alt me-1"></i>Isi Ekspertise
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `
                        <tr>
                            <td colspan="8" class="text-center py-4 text-dark fw-bold">
                                <i class="fas fa-box-open fa-2x mb-2 opacity-50"></i><br>
                                Tidak ada data verifikasi hasil radiologi.
                            </td>
                        </tr>
                    `;
                }
                $('#tbody-verifikasi').html(html);
            },
            error: function() {
                $('#tbody-verifikasi').html('<tr><td colspan="8" class="text-center text-danger fw-bold py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        // Load data otomatis saat pertama kali dibuka
        loadDataVerifikasi();

        // Trigger load data saat form di-submit
        $('#form-filter-verifikasi').on('submit', function(e) {
            e.preventDefault();
            loadDataVerifikasi();
        });
    });

    // Event Handler: Klik Row atau Tombol Isi Ekspertise
    $(document).on("click", "#button-verifikasi-hasil", function(e) {
        e.preventDefault();
        var code = $(this).data("code"); // registrasi_id
        var reg = $(this).data("reg"); // order_rad_code

        $('#menu-radiologi-full').html(`
            <div class="text-center my-5 py-4">
                <div class="spinner-border text-dark" role="status" style="width: 3.5rem; height: 3.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="mt-3 fw-bolder text-dark">Memuat Detail Verifikasi Ekspertise Radiologi...</h6>
                <p class="text-dark small mb-0 fw-bold opacity-75">Mohon tunggu sebentar, data pemeriksaan sedang disiapkan.</p>
            </div>
        `);

        $.ajax({
            url: "{{ route('menu_radiologi_verifikasi_handling_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-radiologi-full').html(data);
        }).fail(function() {
            $('#menu-radiologi-full').html(`
                <div class="alert alert-danger border-2 border-dark rounded-3 text-center my-4 p-4 fw-bold" role="alert" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6>Gagal Memuat Form Ekspertise</h6>
                    <p class="mb-0 small">Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.</p>
                </div>
            `);
        });
    });
</script>
@endsection
