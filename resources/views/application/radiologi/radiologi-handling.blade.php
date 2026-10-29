@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Hero Header Radiologi */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 8px;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
        position: relative;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, transparent 70%);
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
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .custom-input-box {
        border: 1px solid #9ca3af;
        border-radius: 3px;
        padding: 18px 10px 4px 10px;
        position: relative;
        background: #fff;
        flex: 1;
    }

    .custom-input-box label {
        position: absolute;
        top: 2px;
        left: 8px;
        font-size: 10px;
        color: #6b7280;
        pointer-events: none;
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
    }

    .btn-search-green {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 3px;
        padding: 0 20px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-search-green:hover {
        background-color: #43a047;
    }

    /* Layout Panel Kiri & Kanan */
    .layout-container {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .panel-kiri {
        flex: 0 0 45%;
        background: #ffffff;
        border: 1px solid #d1d5db;
        padding: 5px;
    }

    .panel-kanan {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Tabel Kiri */
    .table-pasien {
        width: 100%;
        border-collapse: collapse;
    }

    .table-pasien th {
        background-color: #85c1e9;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 12px 10px;
        text-align: left;
    }

    .table-pasien td {
        border-bottom: 1px solid #e5e7eb;
        padding: 10px;
        font-size: 12px;
        color: #374151;
        cursor: pointer;
    }

    .table-pasien tr:hover td {
        background-color: #f3f4f6;
    }

    .table-pasien tr.active-row td {
        background-color: #e0f2fe;
        border-right: 5px solid #0284c7;
    }

    /* Panel Kanan (Biru & Hijau) */
    .box-biru {
        background-color: #03a9f4;
        padding: 15px 20px;
        border: 1px solid #0288d1;
    }

    .box-hijau {
        background-color: #e8f5e9;
        border: 1px solid #c8e6c9;
        border-right: 6px solid #1976d2;
        padding: 15px 20px;
        min-height: 150px;
    }

    .box-hijau h6 {
        color: #1b5e20;
        font-weight: bold;
        font-family: monospace;
        font-size: 14px;
        margin: 0;
    }

    .input-group-biru {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .input-group-biru label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 2px;
    }

    .input-underline {
        border: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        background: transparent;
        color: #ffffff;
        font-size: 13px;
        padding-bottom: 4px;
        width: 100%;
        outline: none;
    }

    .row-form {
        display: flex;
        gap: 20px;
    }

    .col-form {
        flex: 1;
    }
</style>
@endsection

@section('content')

<!-- HERO HEADER -->
<div class="row mb-0">
    <div class="col-12">
        <div class="rad-hero-header p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3 border border-white-50 d-flex align-items-center justify-content-center"
                        style="width: 55px; height: 55px; backdrop-filter: blur(8px);">
                        <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="35" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.65rem; color: #fffdfc;">
                                <i class="fas fa-radiation me-1"></i> MEDICAL SUITE v2.4
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.2rem;">
                            Proses <span style="color: #38bdf8;">Handling Radiologi</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR ATAS (AJAX Form) -->
<form id="form-filter-handling" class="filter-wrapper">
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
        <input type="text" name="cari" placeholder="No Reg / Nama">
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

    <!-- Pemeriksaan (Dahulu Station) -->
    <div class="custom-input-box" style="flex: 1;">
        <label>Pemeriksaan</label>
        <select name="pemeriksaan">
            <option value="Semua">Semua Pemeriksaan</option>
            <option value="X-RAY">X-RAY / Rontgen</option>
            <option value="USG">USG (Ultrasonografi)</option>
            <option value="CT-SCAN">CT-SCAN</option>
            <option value="MRI">MRI</option>
        </select>
    </div>

    <!-- Tombol Submit Form -->
    <button type="submit" class="btn-search-green">
        <i class="fas fa-search"></i>
    </button>
</form>

<!-- KONTEN UTAMA (Kiri & Kanan) -->
<div class="layout-container">
    <!-- PANEL KIRI (Tabel Pasien) -->
    <div class="panel-kiri">
        <div style="max-height: 55vh; overflow-y: auto;">
            <table class="table-pasien">
                <thead>
                    <tr>
                        <th>TGL. TRANSAKSI</th>
                        <th>NO REG</th>
                        <th>KEL. PELANGGAN</th>
                        <th>NAMA</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <!-- ID tbody untuk me-render data via AJAX -->
                <tbody id="tbody-pasien">
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i> Memuat data pasien...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PANEL KANAN (Detail / Proses Handling) -->
    <div class="panel-kanan" id="menu-detail-handling">

        <!-- DEFAULT TAMPILAN KOSONG -->
        <div class="box-biru">
            <div class="row-form">
                <div class="col-form">
                    <div class="input-group-biru">
                        <label>PID</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form">
                    <div class="input-group-biru">
                        <label>Umur</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form">
                    <div class="input-group-biru">
                        <label>TANGGAL LAHIR</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
            </div>
            <div class="row-form">
                <div class="col-form" style="flex: 2;">
                    <div class="input-group-biru">
                        <label>Nama</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form" style="flex: 1.5;">
                    <div class="input-group-biru">
                        <label>Pengirim</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-hijau">
            <h6>Daftar Pemeriksaan</h6>
            <div class="text-center mt-5 text-muted opacity-50">
                <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                <p class="small">Silakan pilih data pasien pada tabel di sebelah kiri</p>
            </div>
        </div>

    </div>
</div>
@endsection

@section('base.js')
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>

<script>
    $(document).ready(function() {

        // 1. Fungsi AJAX untuk mengambil list pasien dari Controller
        function loadDataPasien() {
            var formData = $('#form-filter-handling').serialize();

            // Set loading text
            $('#tbody-pasien').html(`
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-spinner fa-spin me-2"></i> Mencari data...
                    </td>
                </tr>
            `);

            // Hit route get data
            $.ajax({
                url: "{{ route('radiologi.get_data_handling') }}",
                type: "GET",
                data: formData,
                success: function(response) {
                    var html = '';
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function(index, val) {
                            var statusBadge = '';
                            if (val.status_pemeriksaan == 'MENUNGGU') {
                                statusBadge = '<span class="badge bg-danger rounded-0" style="font-size: 0.6rem;">Antrean</span>';
                            } else {
                                statusBadge = '<span class="badge bg-warning text-dark rounded-0" style="font-size: 0.6rem;">' + val.status_pemeriksaan + '</span>';
                            }

                            html += `
                                <tr class="row-patient" data-code="${val.registrasi_id}">
                                    <td>${val.tanggal_registrasi}</td>
                                    <td class="fw-bold">${val.no_registrasi}</td>
                                    <td>${val.penjamin}</td>
                                    <td>${val.master_patient_name}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `
                            <tr>
                                <td colspan="5" style="text-align: center; color: #6b7280; padding: 25px;">
                                    <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i><br>
                                    Data antrean tidak ditemukan.
                                </td>
                            </tr>
                        `;
                    }
                    $('#tbody-pasien').html(html);
                },
                error: function() {
                    $('#tbody-pasien').html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
                }
            });
        }

        // 2. Load otomatis saat halaman pertama dibuka
        loadDataPasien();

        // 3. Trigger ajax pencarian ketika form disubmit (Tombol Kaca Pembesar)
        $('#form-filter-handling').on('submit', function(e) {
            e.preventDefault(); // Cegah reload halaman penuh
            loadDataPasien();
        });

        // 4. Klik Baris Pasien di Kiri untuk buka form handling di Kanan
        $(document).on("click", ".row-patient", function(e) {
            e.preventDefault();
            var code = $(this).data("code"); // registrasi_id

            // Highlight baris yang dipilih
            $(".row-patient").removeClass("active-row");
            $(this).addClass("active-row");

            // Tampilkan Loading di Panel Kanan
            $('#menu-detail-handling').html(`
                <div class="text-center py-5" style="background: white; border: 1px solid #ddd; flex: 1;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted small">Memuat data pemeriksaan...</p>
                </div>
            `);

            // Panggil form detail handling
            $.ajax({
                url: "{{ route('menu_radiologi_handling_pasien') }}",
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
                $('#menu-detail-handling').html(`
                    <div class="alert alert-danger m-0 border-0 rounded-0">
                        Gagal memuat data. Periksa koneksi internet.
                    </div>
                `);
            });
        });
    });
</script>
@endsection
