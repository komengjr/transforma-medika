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

    /* Filter Box Style */
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

    .custom-input-box input {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 13px;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 0;
    }

    .btn-search-retro {
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

    .btn-search-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
        background-color: #ffd230;
    }

    /* Table Custom Styling */
    .table-retro {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-retro thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.6px;
        border-bottom: 2px solid var(--retro-dark);
        padding: 12px 10px;
    }

    .table-retro tbody tr td {
        border-bottom: 2px solid var(--retro-dark);
        border-right: 2px solid var(--retro-dark);
        padding: 12px 10px;
        font-weight: 700;
        color: var(--retro-dark);
        background-color: #ffffff;
    }

    .table-retro tbody tr td:last-child {
        border-right: none;
    }

    .table-retro tbody tr:hover td {
        background-color: var(--retro-cyan) !important;
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

    /* Modals */
    .modal-content.retro-modal {
        border: 3px solid var(--retro-dark);
        border-radius: 14px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: var(--retro-bg);
        overflow: hidden;
    }

    /* Mengatasi agar dropdown menu tidak terpotong oleh card/tabel */
    .card.retro-card {
        overflow: visible !important;
    }

    .table-responsive {
        overflow-x: auto;
        overflow-y: visible !important;
    }

    .dropdown-menu {
        z-index: 1050 !important;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER -->
<div class="row mb-4">
    <div class="col">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/keuangan.png') }}" alt="" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                    <i class="fas fa-wallet me-1"></i> FINANCE SUITE v2.4
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.3rem;">
                                Welcome to <span style="text-decoration: underline;">Trans Management System</span>
                            </h3>
                            <p class="text-dark fw-bold mb-0 small opacity-75" style="font-size: 0.75rem;">Modul Pengolahan Transaksi & Laporan Keuangan</p>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-file-invoice-dollar me-1 text-success"></i> Menu : Transaksi Penerimaan
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR PENCARIAN -->
<form id="form-filter-keuangan" class="filter-wrapper">
    <!-- Tanggal Awal -->
    <div class="custom-input-box">
        <label>Tanggal Awal</label>
        <input type="text" class="datetimepicker" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
    </div>

    <!-- Tanggal Akhir -->
    <div class="custom-input-box">
        <label>Tanggal Akhir</label>
        <input type="text" class="datetimepicker" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
    </div>

    <!-- No Laporan -->
    <div class="custom-input-box">
        <label>No Laporan</label>
        <input type="text" name="no_laporan" placeholder="Cth: LAP-KSR...">
    </div>

    <!-- Nama Penyetor -->
    <div class="custom-input-box">
        <label>Nama Penyetor</label>
        <input type="text" name="nama_penyetor" placeholder="Nama user...">
    </div>

    <!-- Tombol Filter -->
    <button type="submit" class="btn-search-retro" title="Cari Data">
        <i class="fas fa-search"></i>
    </button>
</form>

<!-- MAIN TABLE CARD -->
<div class="card retro-card mb-4">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark); border-bottom: 3px solid var(--retro-dark);">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light border border-dark rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold shadow-sm"
                onclick="loadDataKeuangan();"
                data-bs-toggle="tooltip"
                title="Refresh Data"
                style="width: 32px; height: 32px; background-color: var(--retro-yellow); color: var(--retro-dark);">
                <span class="fas fa-undo"></span>
            </button>
            <span class="text-white-50">|</span>
            <span class="fw-bolder fs--1 text-white">
                <i class="fas fa-list-alt me-1 text-info"></i> Daftar Laporan & Transaksi Penerimaan
            </span>
        </div>
    </div>

    <div class="card-body p-0">

        <table id="table-keuangan" class="table table-retro table-hover align-middle mb-0" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>No Laporan</th>
                    <th>User ID (Penyetor)</th>
                    <th>Total Setoran</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <!-- Kolom Tambahan untuk Verifikasi Keuangan -->
                    <th>Verifikasi Keuangan</th>
                    <th class="text-center">Status Verifikasi</th>
                    <th class="text-center" style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody class="fs--1" id="tbody-keuangan">
                <tr>
                    <td colspan="7" class="text-center py-4 fw-bold text-muted">
                        <i class="fas fa-spinner fa-spin me-2"></i> Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS SECTION -->
<div class="modal fade" id="modal-keuangan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content retro-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-white border border-dark fw-bold shadow-sm"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-keuangan-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keuangan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content retro-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"></div>
            <div id="menu-keuangan"></div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Variabel Global untuk menyimpan ID Laporan yang sedang dibuka di modal
    var currentLaporanId = null;

    // Fungsi AJAX untuk memuat Data Table Keuangan berdasarkan filter
    function loadDataKeuangan() {
        var formData = $('#form-filter-keuangan').serialize();

        $('#tbody-keuangan').html(`
            <tr>
                <td colspan="8" class="text-center py-4 fw-bold text-dark">
                    <div class="spinner-border text-dark mb-2" role="status"></div>
                    <br>Mencari data laporan...
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('keuangan_penerimaan_get_data') }}",
            type: "POST",
            data: formData + "&_token={{ csrf_token() }}",
            success: function(response) {
                var html = '';
                if (response.data && response.data.length > 0) {
                    $.each(response.data, function(index, val) {
                        var statusBadge = '';
                        var isDisetujui = (val.status_verifikasi === 'DISETUJUI');

                        if (isDisetujui) {
                            statusBadge = '<span class="badge bg-white text-success border border-dark rounded-2 px-2 py-1 fw-bolder shadow-sm"><i class="fas fa-check-circle me-1"></i> DISETUJUI</span>';
                        } else if (val.status_verifikasi === 'PENDING') {
                            statusBadge = '<span class="badge bg-white text-warning border border-dark rounded-2 px-2 py-1 fw-bolder shadow-sm" style="color: #b38600 !important;"><i class="fas fa-hourglass-half me-1"></i> PENDING</span>';
                        } else {
                            statusBadge = '<span class="badge bg-white text-danger border border-dark rounded-2 px-2 py-1 fw-bolder shadow-sm"><i class="fas fa-times-circle me-1"></i> DITOLAK</span>';
                        }

                        var formattedSetoran = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(val.total_setoran);

                        // Informasi Bagian Keuangan (Verifikator, Waktu, dan Catatan)
                        var diperiksaOleh = val.diperiksa_oleh ? `<span class="fw-bold text-dark"><i class="fas fa-user-check text-success me-1"></i> ${val.diperiksa_oleh}</span>` : `<span class="text-muted fst-italic">Belum diperiksa</span>`;
                        var waktuDiperiksa = val.waktu_diperiksa ? `<div class="text-muted fs--2 mt-1"><i class="far fa-clock me-1"></i> ${val.waktu_diperiksa}</div>` : '';
                        var catatanVerif = val.catatan ? `<div class="text-dark fs--2 mt-1 bg-light p-1 rounded border border-dark border-opacity-25"><strong>Catatan:</strong> ${val.catatan}</div>` : '';

                        var prosesBtnClass = isDisetujui ? 'dropdown-item py-2 fw-bold text-muted disabled bg-light' : 'dropdown-item py-2 fw-bold text-dark d-flex align-items-center gap-2';
                        var prosesAttr = isDisetujui ? 'aria-disabled="true" style="pointer-events: none; opacity: 0.6;"' : 'data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi"';

                        html += `
                            <tr>
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td><span class="code-chip code-chip-cyan fs--2">${val.no_laporan}</span></td>
                                <td>
                                    <span class="badge bg-white text-dark border border-dark fw-bold px-2 py-1 shadow-sm">
                                        <i class="fas fa-user me-1"></i> ${val.user_id}
                                    </span>
                                </td>
                                <td><span class="fw-bolder text-success">${formattedSetoran}</span></td>
                                <td class="text-center">
                                    <span class="badge bg-white text-dark border border-dark fw-bold shadow-sm px-2 py-1">
                                        ${val.jumlah_transaksi} Transaksi
                                    </span>
                                </td>
                                <td>
                                    ${diperiksaOleh}
                                    ${waktuDiperiksa}
                                    ${catatanVerif}
                                </td>
                                <td class="text-center">${statusBadge}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm dropdown-toggle fw-bolder border border-dark rounded-2 shadow-sm px-3"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                            <span class="fas fa-align-left me-1"></span>Option
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end border-2 border-dark shadow-lg py-1 fs--1" style="border-radius: 8px;">
                                            <button class="${prosesBtnClass}" ${prosesAttr} data-code="${val.id}">
                                                <span class="fab fa-amazon-pay text-warning fs-0"></span> ${isDisetujui ? 'Sudah Disetujui' : 'Proses Transaksi'}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="8" class="text-center py-4 fw-bold text-muted">Tidak ada data laporan keuangan.</td></tr>`;
                }
                $('#tbody-keuangan').html(html);
            },
            error: function() {
                $('#tbody-keuangan').html('<tr><td colspan="8" class="text-center text-danger fw-bold py-4">Gagal mengambil data dari server.</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        loadDataKeuangan();

        $('#form-filter-keuangan').on('submit', function(e) {
            e.preventDefault();
            loadDataKeuangan();
        });
    });

    // 1. Saat tombol Proses Transaksi di tabel diklik, simpan ID Laporan ke variabel global
    $(document).on("click", "#button-proses-transaksi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        activeLaporanId = code; // Simpan ke variabel global

        $('#menu-keuangan').html(
            '<div class="text-center py-5"><div class="spinner-border text-dark mb-2" role="status"></div><br><span class="fw-bold text-dark">Memuat data proses transaksi...</span></div>'
        );

        $.ajax({
            url: "{{ route('keuangan_penerimaan_proses_transaksi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-keuangan').html(data);
        }).fail(function() {
            $('#menu-keuangan').html('<div class="alert alert-danger border-2 border-dark m-3 fw-bold text-center">Gagal memuat data dari server.</div>');
        });
    });
    $(document).on('click', '#button-simpan-proses-transaksi', function(e) {
        e.preventDefault();
        let laporanId = $('#form-proses-transaksi').attr('data-laporan-id') || activeLaporanId;
        let catatanVerifikasi = $('#catatan_verifikasi').val() || 'Disetujui oleh bagian keuangan.';

        if (!laporanId) {
            return Swal.fire('Perhatian', 'ID Laporan tidak valid atau tidak ditemukan!', 'warning');
        }

        Swal.fire({
            title: 'Konfirmasi Verifikasi',
            text: 'Apakah Anda yakin ingin menyetujui dan memverifikasi setoran laporan keuangan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Setujui Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('keuangan.verifikasi_laporan_setoran') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        laporan_id: laporanId,
                        catatan: catatanVerifikasi
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                            }).then(() => {
                                // Tutup modal Bootstrap menggunakan instance atau element selector
                                $('#modal-keuangan').modal('hide');
                                // Hapus backdrop modal jika tersisa
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');

                                // Refresh ulang data tabel utama
                                loadDataKeuangan();
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errMsg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal', errMsg, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
