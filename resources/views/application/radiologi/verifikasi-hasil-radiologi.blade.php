@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* ==========================================
     * RADIOLOGY & X-RAY THEME CUSTOM CSS
     * ========================================== */
    :root {
        --rad-dark-bg: #0f172a;
        --rad-card-bg: #1e293b;
        --rad-accent-cyan: #38bdf8;
        --rad-glow-cyan: rgba(56, 189, 248, 0.35);
    }

    /* Hero Header Radiologi */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-radius: 14px;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.35);
        position: relative;
        overflow: hidden;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -30px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, var(--rad-glow-cyan) 0%, transparent 75%);
        pointer-events: none;
    }

    /* Filter Bar Atas */
    .filter-wrapper {
        background: #ffffff;
        border: 1px solid #d1d5db;
        padding: 10px;
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }

    .custom-input-box {
        border: 1px solid #9ca3af;
        border-radius: 6px;
        padding: 18px 10px 4px 10px;
        position: relative;
        background: #fff;
        flex: 1;
    }

    .custom-input-box label {
        position: absolute;
        top: 4px;
        left: 8px;
        font-size: 10px;
        color: #6b7280;
        pointer-events: none;
        font-weight: 600;
    }

    .custom-input-box input,
    .custom-input-box select {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 13px;
        color: #374151;
        padding: 0;
        font-weight: 500;
    }

    .btn-search-blue {
        background-color: #0284c7;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0 20px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-search-blue:hover {
        background-color: #0369a1;
    }

    /* Card Table Frame */
    .rad-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .rad-card-header {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-bottom: 2px solid #0284c7;
        padding: 14px 20px;
    }

    /* Table Radiology Custom Styling */
    .table-radiologi thead th {
        background-color: #f8fafc !important;
        color: #334155 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.6px;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 10px;
    }

    .table-radiologi tbody tr {
        transition: all 0.2s ease;
    }

    .table-radiologi tbody tr.row-clickable {
        cursor: pointer;
    }

    .table-radiologi tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .table-radiologi tbody tr:hover td .patient-name {
        color: #0284c7 !important;
    }

    /* Code Chips */
    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: inline-block;
    }

    .code-chip-cyan {
        background-color: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }

    /* Modals Custom Styling */
    .modal-content.rad-modal {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(56, 189, 248, 0.3);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.5);
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-3">
    <div class="col-12">
        <div class="rad-hero-header p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3 border border-white-50 d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px; backdrop-filter: blur(8px);">
                        <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="40" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem;">
                                <i class="fas fa-radiation me-1"></i> MEDICAL SUITE v2.4
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.3rem;">
                            Dokter: <span style="color: #38bdf8;">Pengisian & Verifikasi Ekspertise</span>
                        </h4>
                        <p class="text-white-50 mb-0 small" style="font-size: 0.75rem;">Modul Verifikasi & Processing Hasil Pemeriksaan Radiologi</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 border border-info border-opacity-30 px-3 py-2 rounded-pill backdrop-blur">
                        <span class="text-info fw-bold mb-0" style="font-size: 0.9rem; color: #38bdf8 !important;">
                            <i class="fas fa-notes-medical me-2"></i>Radiologi : Ekspertise
                        </span>
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
    <button type="submit" class="btn-search-blue">
        <i class="fas fa-search"></i>
    </button>
</form>

<!-- MAIN TABLE CARD -->
<div class="rad-card mb-4">
    <div class="rad-card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                    onclick="loadDataVerifikasi();"
                    data-bs-toggle="tooltip"
                    title="Refresh Data"
                    style="width: 32px; height: 32px;">
                    <i class="fas fa-redo-alt text-info"></i>
                </button>
                <span class="text-white-50">|</span>
                <span class="fw-bold fs--1 text-white">
                    <i class="fas fa-list-alt me-1 text-info"></i> Data Antrean & Verifikasi Hasil Radiologi
                </span>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <!-- Menghapus instansiasi bawaan DataTables untuk mencegah konflik saat inject HTML via AJAX -->
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
                <!-- ID tbody untuk render AJAX -->
                <tbody id="tbody-verifikasi" class="fs--1">
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
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
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <td colspan="8" class="text-center py-5 text-muted">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
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
                            paymentBadge = '<span class="badge rounded-pill bg-soft-success text-success px-2 py-1"><i class="fas fa-check-circle me-1"></i>Lunas</span>';
                        } else {
                            paymentBadge = '<span class="badge rounded-pill bg-soft-danger text-danger px-2 py-1"><i class="fas fa-times-circle me-1"></i>Belum Lunas</span>';
                        }

                        // Badge Status Pemeriksaan
                        var statusBadge = '';
                        if (val.status_pemeriksaan === 'SELESAI') {
                            statusBadge = '<span class="badge rounded-pill bg-soft-success text-success px-2 py-1"><i class="fas fa-check-double me-1"></i>Selesai / Menunggu Verif</span>';
                        } else if (val.status_pemeriksaan === 'PROSES') {
                            statusBadge = '<span class="badge rounded-pill bg-soft-warning text-warning px-2 py-1"><i class="fas fa-spinner fa-spin me-1"></i>Diproses Petugas</span>';
                        } else {
                            statusBadge = '<span class="badge rounded-pill bg-soft-danger text-danger px-2 py-1"><i class="fas fa-hourglass-half me-1"></i>Antrean</span>';
                        }

                        html += `
                            <tr class="row-clickable" id="button-verifikasi-hasil" data-code="${val.registrasi_id}" data-reg="${val.order_rad_code}" data-bs-toggle="modal" data-bs-target="#modal-radiologi-full">
                                <td class="text-center fw-bold text-secondary">${index + 1}</td>
                                <td>
                                    <div class="fw-bold text-dark patient-name transition-base">${val.master_patient_name}</div>
                                    <div class="mt-1 d-flex gap-1">
                                        <span class="code-chip text-dark fs--2" title="No Registrasi">${val.no_registrasi}</span>
                                        <span class="code-chip code-chip-cyan fs--2" title="Order Code">${val.order_rad_code}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info text-info fw-bold">${val.nama_penjamin}</span>
                                </td>
                                <td>
                                    <span class="text-secondary"><i class="far fa-clock me-1 text-info"></i>${val.tanggal_registrasi_formatted}</span>
                                </td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary fs--2">
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
                                    <button class="btn btn-sm btn-info rounded-pill px-3 fw-bold shadow-sm" type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-radiologi-full"
                                            id="button-verifikasi-hasil"
                                            data-code="${val.registrasi_id}"
                                            data-reg="${val.order_rad_code}">
                                        <i class="fas fa-pen-alt me-1"></i>Isi Ekspertise
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-box-open fa-2x mb-2 opacity-50"></i><br>
                                Tidak ada data verifikasi hasil radiologi.
                            </td>
                        </tr>
                    `;
                }
                $('#tbody-verifikasi').html(html);
            },
            error: function() {
                $('#tbody-verifikasi').html('<tr><td colspan="8" class="text-center text-danger py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
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
                <div class="spinner-border text-info" role="status" style="width: 3.5rem; height: 3.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="mt-3 fw-bold text-dark">Memuat Detail Verifikasi Ekspertise Radiologi...</h6>
                <p class="text-muted small mb-0">Mohon tunggu sebentar, data pemeriksaan sedang disiapkan.</p>
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
                <div class="alert alert-danger border-0 rounded-3 text-center my-4 p-4" role="alert">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6>Gagal Memuat Form Ekspertise</h6>
                    <p class="mb-0 small">Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.</p>
                </div>
            `);
        });
    });
</script>
@endsection
