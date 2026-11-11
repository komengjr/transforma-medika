@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

    .btn-search-green {
        background-color: var(--retro-green);
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

    .btn-search-green:hover,
    .btn-search-green:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
        background-color: #b0f55b;
    }

    /* Layout Panel Kiri & Kanan */
    .layout-container {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .panel-kiri {
        flex: 0 0 45%;
        background: #ffffff;
        border: var(--retro-border);
        box-shadow: var(--retro-shadow);
        border-radius: 12px;
        padding: 8px;
        overflow: hidden;
    }

    .panel-kanan {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Tabel Kiri */
    .table-pasien {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-pasien th {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 12px 10px;
        text-align: left;
        border: 2px solid var(--retro-dark);
    }

    .table-pasien td {
        border: 2px solid var(--retro-dark);
        border-top: none;
        padding: 12px 10px;
        font-size: 12px;
        font-weight: 700;
        color: var(--retro-dark);
        background-color: #ffffff;
        cursor: pointer;
    }

    .table-pasien tr:hover td {
        background-color: var(--retro-cyan);
    }

    .table-pasien tr.active-row td {
        background-color: var(--retro-yellow);
        border-left: 5px solid var(--retro-dark);
    }

    /* Panel Kanan (Biru & Hijau Retro) */
    .box-biru {
        background-color: var(--retro-cyan);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        padding: 20px;
    }

    .box-hijau {
        background-color: #ffffff;
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        padding: 20px;
        min-height: 180px;
    }

    .box-hijau h6 {
        color: var(--retro-dark);
        font-weight: 800;
        font-size: 15px;
        margin: 0 0 15px 0;
        text-transform: uppercase;
    }

    .input-group-biru {
        display: flex;
        flex-direction: column;
        margin-bottom: 12px;
    }

    .input-group-biru label {
        font-size: 11px;
        color: var(--retro-dark);
        font-weight: 800;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .input-underline {
        border: none;
        border-bottom: 2px solid var(--retro-dark);
        background: transparent;
        color: var(--retro-dark);
        font-size: 13px;
        font-weight: 800;
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

<!-- HERO HEADER (Gaya Retro Konsisten) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/rad.png') }}" alt="Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                    <i class="fas fa-radiation me-1"></i> v2.4 Medical Suite
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-radiation me-1 text-danger"></i> Proses Handling Radiologi
                            </h6>
                        </div>
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

    <!-- Pemeriksaan -->
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
    <button type="submit" class="btn-search-green" title="Cari Data">
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
                <tbody id="tbody-pasien">
                    <tr>
                        <td colspan="5" class="text-center py-4 fw-bold text-dark">
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
            <div class="text-center mt-5 text-dark fw-bold opacity-50">
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

            $('#tbody-pasien').html(`
                <tr>
                    <td colspan="5" class="text-center py-4 fw-bold text-dark">
                        <i class="fas fa-spinner fa-spin me-2"></i> Mencari data...
                    </td>
                </tr>
            `);

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
                                statusBadge = '<span class="badge bg-danger border border-dark rounded-2" style="font-size: 0.65rem;">Antrean</span>';
                            } else {
                                statusBadge = '<span class="badge bg-warning text-dark border border-dark rounded-2" style="font-size: 0.65rem;">' + val.status_pemeriksaan + '</span>';
                            }

                            html += `
                                <tr class="row-patient" data-code="${val.registrasi_id}">
                                    <td>${val.tanggal_registrasi}</td>
                                    <td class="fw-bolder">${val.no_registrasi}</td>
                                    <td>${val.penjamin}</td>
                                    <td>${val.master_patient_name}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--retro-dark); padding: 25px; font-weight: bold;">
                                    <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i><br>
                                    Data antrean tidak ditemukan.
                                </td>
                            </tr>
                        `;
                    }
                    $('#tbody-pasien').html(html);
                },
                error: function() {
                    $('#tbody-pasien').html('<tr><td colspan="5" class="text-center text-danger fw-bold py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
                }
            });
        }

        // 2. Load otomatis saat halaman pertama dibuka
        loadDataPasien();

        // 3. Trigger ajax pencarian ketika form disubmit
        $('#form-filter-handling').on('submit', function(e) {
            e.preventDefault();
            loadDataPasien();
        });

        // 4. Klik Baris Pasien di Kiri untuk buka form handling di Kanan
        $(document).on("click", ".row-patient", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            $(".row-patient").removeClass("active-row");
            $(this).addClass("active-row");

            $('#menu-detail-handling').html(`
                <div class="text-center py-5" style="background: white; border: 2px solid var(--retro-dark); box-shadow: var(--retro-shadow-sm); border-radius: 12px; flex: 1;">
                    <div class="spinner-border text-dark" role="status"></div>
                    <p class="mt-2 text-dark fw-bold small">Memuat data pemeriksaan...</p>
                </div>
            `);

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
                    <div class="alert alert-danger m-0 fw-bold border-2 border-dark rounded-3">
                        Gagal memuat data. Periksa koneksi internet.
                    </div>
                `);
            });
        });
    });
</script>
@endsection
