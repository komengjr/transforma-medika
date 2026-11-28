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
        --ent-grid-border: rgba(99, 102, 241, 0.22);
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.2);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .mono-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.76rem;
        font-weight: 700;
    }

    /* Hero Header */
    .ent-header-banner {
        background: linear-gradient(135deg, #090d16 0%, #1e1b4b 52%, #0369a1 100%);
        border: 1px solid rgba(129, 140, 248, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.28);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.24) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(10px);
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

    /* Main Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 6px 24px -4px rgba(15, 23, 42, 0.08);
        overflow: visible !important;
    }

    .ent-card-top-bar {
        background: linear-gradient(90deg, #0f172a 0%, #1e1b4b 100%);
        border-bottom: 1px solid var(--ent-grid-border);
        border-radius: 16px 16px 0 0;
        padding: 13px 18px;
    }

    /* Filter Box */
    .ent-filter-wrapper {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        box-shadow: 0 4px 18px -4px rgba(15, 23, 42, 0.06);
        padding: 14px 16px;
        border-radius: 14px;
    }

    .ent-input-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 11px;
        padding: 20px 12px 6px 12px;
        position: relative;
        background-color: rgba(79, 70, 229, 0.025);
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .ent-input-box:focus-within {
        border-color: var(--ent-indigo);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .ent-input-box label {
        position: absolute;
        top: 5px;
        left: 12px;
        font-size: 0.64rem;
        color: var(--bs-secondary-color, #64748b);
        font-weight: 700;
        pointer-events: none;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .ent-input-box input {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--bs-body-color, var(--ent-solid-text));
        padding: 0;
    }

    .btn-search-ent {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        border-radius: 11px;
        padding: 0 20px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .btn-search-ent:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.38);
        color: #ffffff;
    }

    .btn-refresh-ent {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.35);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.18s ease;
        cursor: pointer;
    }

    .btn-refresh-ent:hover {
        background: #f59e0b;
        color: #ffffff;
        transform: rotate(-30deg);
    }

    /* Table Custom Styling */
    .table-ent {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.84rem;
    }

    .table-ent thead th {
        background-color: rgba(79, 70, 229, 0.06);
        color: var(--bs-secondary-color, #475569);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.69rem;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--ent-grid-border);
        padding: 11px 12px;
        white-space: nowrap;
    }

    .table-ent tbody tr td {
        border-bottom: 1px solid var(--ent-grid-border);
        padding: 11px 12px;
        font-weight: 600;
        vertical-align: middle;
        transition: background-color 0.15s ease;
    }

    .table-ent tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .code-chip {
        padding: 4px 9px;
        border-radius: 8px;
        background-color: rgba(2, 132, 199, 0.1);
        border: 1px solid rgba(2, 132, 199, 0.28);
        display: inline-block;
        color: #0284c7;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        color: #38bdf8;
        background-color: rgba(56, 189, 248, 0.12);
        border-color: rgba(56, 189, 248, 0.3);
    }

    .btn-option-ent {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        border: none;
        border-radius: 9px;
        font-weight: 600;
        font-size: 0.78rem;
        box-shadow: 0 3px 10px rgba(79, 70, 229, 0.22);
    }

    .btn-option-ent:hover,
    .btn-option-ent:focus {
        color: #ffffff;
        background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    }

    /* Modals */
    .modal-content.ent-modal {
        border: 1px solid var(--ent-grid-border);
        border-radius: 18px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
        overflow-y: visible !important;
    }

    .dropdown-menu {
        z-index: 1050 !important;
        border-radius: 12px;
        border: 1px solid var(--ent-grid-border);
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 62px; height: 62px;">
                            <img src="{{ asset('img/keuangan.png') }}" alt="Keuangan" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(251, 191, 36, 0.2); border: 1px solid rgba(251, 191, 36, 0.45); color: #fde68a;">
                                    <i class="fas fa-wallet me-1"></i> FINANCE SUITE v2.4
                                </span>
                                <span style="color: #cbd5e1; font-size: 0.74rem; font-weight: 600;">Modul Keuangan</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Welcome to {{ env('APP_LABEL') }} <span style="color: #7dd3fc;">Management System</span>
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pengolahan Transaksi, Setoran Kasir &amp; Verifikasi Keuangan</p>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <span class="fw-bold text-warning" style="font-size: 0.88rem;">
                                <i class="fas fa-file-invoice-dollar me-1.5"></i> Menu : Transaksi Penerimaan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR PENCARIAN -->
<form id="form-filter-keuangan" class="ent-filter-wrapper mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>Tanggal Awal</label>
                <input type="text" class="datetimepicker" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>Tanggal Akhir</label>
                <input type="text" class="datetimepicker" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-3">
            <div class="ent-input-box">
                <label>No Laporan</label>
                <input type="text" name="no_laporan" placeholder="Cth: LAP-KSR...">
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-3">
            <div class="ent-input-box">
                <label>Nama Penyetor</label>
                <input type="text" name="nama_penyetor" placeholder="Nama user...">
            </div>
        </div>
        <div class="col-12 col-lg-2 d-grid">
            <button type="submit" class="btn-search-ent" title="Cari Data">
                <i class="fas fa-search me-2"></i>
                <span>Cari Data</span>
            </button>
        </div>
    </div>
</form>

<!-- MAIN TABLE CARD -->
<div class="card ent-card mb-4">
    <div class="ent-card-top-bar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button"
                class="btn-refresh-ent"
                onclick="loadDataKeuangan();"
                data-bs-toggle="tooltip"
                title="Refresh Data">
                <span class="fas fa-undo"></span>
            </button>
            <span class="text-white-50">|</span>
            <span class="fw-bold text-white" style="font-size: 0.88rem;">
                <i class="fas fa-list-alt me-1.5 text-info"></i> Daftar Laporan &amp; Transaksi Penerimaan
            </span>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="table-keuangan" class="table table-ent table-hover align-middle mb-0" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 54px;">No</th>
                        <th>No Laporan</th>
                        <th>User ID (Penyetor)</th>
                        <th>Total Setoran</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th>Verifikasi Keuangan</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center" style="width: 125px;">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody-keuangan">
                    <tr>
                        <td colspan="8" class="text-center py-4 fw-semibold opacity-75">
                            <i class="fas fa-spinner fa-spin me-2"></i> Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS SECTION -->
<div class="modal fade" id="modal-keuangan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content ent-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex align-items-center justify-content-center shadow-sm"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-keuangan-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-keuangan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ent-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;"></div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var currentLaporanId = null;

    function loadDataKeuangan() {
        var formData = $('#form-filter-keuangan').serialize();

        $('#tbody-keuangan').html(`
            <tr>
                <td colspan="8" class="text-center py-4 fw-semibold">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
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
                            statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-bold"><i class="fas fa-check-circle me-1"></i> DISETUJUI</span>';
                        } else if (val.status_verifikasi === 'PENDING') {
                            statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2.5 py-1 fw-bold"><i class="fas fa-hourglass-half me-1"></i> PENDING</span>';
                        } else {
                            statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1 fw-bold"><i class="fas fa-times-circle me-1"></i> DITOLAK</span>';
                        }

                        var formattedSetoran = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(val.total_setoran);

                        var diperiksaOleh = val.diperiksa_oleh
                            ? `<span class="fw-bold"><i class="fas fa-user-check text-success me-1"></i> ${val.diperiksa_oleh}</span>`
                            : `<span class="opacity-50 fst-italic">Belum diperiksa</span>`;
                        var waktuDiperiksa = val.waktu_diperiksa
                            ? `<div class="opacity-75 small mt-1"><i class="far fa-clock me-1"></i> ${val.waktu_diperiksa}</div>`
                            : '';
                        var catatanVerif = val.catatan
                            ? `<div class="small mt-1 p-1.5 rounded" style="background: rgba(79, 70, 229, 0.06); border: 1px solid var(--ent-grid-border);"><strong>Catatan:</strong> ${val.catatan}</div>`
                            : '';

                        var prosesBtnClass = isDisetujui
                            ? 'dropdown-item py-2 fw-semibold text-muted disabled'
                            : 'dropdown-item py-2 fw-semibold d-flex align-items-center gap-2';
                        var prosesAttr = isDisetujui
                            ? 'aria-disabled="true" style="pointer-events: none; opacity: 0.6;"'
                            : 'data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi"';

                        html += `
                            <tr>
                                <td class="text-center mono-code">${index + 1}</td>
                                <td><span class="code-chip mono-code">${val.no_laporan}</span></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2.5 py-1 rounded-pill">
                                        <i class="fas fa-user me-1"></i> ${val.user_id}
                                    </span>
                                </td>
                                <td><span class="fw-bold text-success mono-code">${formattedSetoran}</span></td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info border border-info-subtle fw-semibold px-2.5 py-1 rounded-pill">
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
                                        <button class="btn btn-sm dropdown-toggle btn-option-ent px-3 py-1.5"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fas fa-align-left me-1"></span>Option
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg py-1">
                                            <button class="${prosesBtnClass}" ${prosesAttr} data-code="${val.id}">
                                                <span class="fab fa-amazon-pay text-warning"></span> ${isDisetujui ? 'Sudah Disetujui' : 'Proses Transaksi'}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="8" class="text-center py-4 fw-semibold opacity-75">Tidak ada data laporan keuangan.</td></tr>`;
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

    $(document).on("click", "#button-proses-transaksi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        currentLaporanId = code;

        $('#menu-keuangan').html(
            '<div class="text-center py-5"><div class="spinner-border text-primary mb-2" role="status"></div><br><span class="fw-semibold">Memuat data proses transaksi...</span></div>'
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
            $('#menu-keuangan').html('<div class="alert alert-danger m-3 fw-semibold text-center rounded-3">Gagal memuat data dari server.</div>');
        });
    });

    $(document).on('click', '#button-simpan-proses-transaksi', function(e) {
        e.preventDefault();
        let laporanId = $('#form-proses-transaksi').attr('data-laporan-id') || currentLaporanId;
        let catatanVerifikasi = $('#catatan_verifikasi').val() || 'Disetujui oleh bagian keuangan.';

        if (!laporanId) {
            return Swal.fire('Perhatian', 'ID Laporan tidak valid atau tidak ditemukan!', 'warning');
        }

        Swal.fire({
            title: 'Konfirmasi Verifikasi',
            text: 'Apakah Anda yakin ingin menyetujui dan memverifikasi setoran laporan keuangan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
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
                                $('#modal-keuangan').modal('hide');
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');
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
