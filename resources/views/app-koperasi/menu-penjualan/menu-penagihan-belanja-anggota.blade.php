@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PENAGIHAN BELANJA)
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
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
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

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-card .form-control,
    .ent-card .form-select,
    .modal-ent-content .form-control,
    .modal-ent-content .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .ent-card .form-control:focus,
    .ent-card .form-select:focus,
    .modal-ent-content .form-control:focus,
    .modal-ent-content .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .item-list-box {
        font-size: 0.8rem;
        color: var(--bs-body-color);
        background-color: rgba(79, 70, 229, 0.05);
        padding: 7px 10px;
        border-radius: 8px;
        border: 1px solid var(--ent-grid-border);
        display: inline-block;
        width: 100%;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td,
    .table-custom tfoot td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tfoot td {
        background-color: rgba(79, 70, 229, 0.06) !important;
        font-weight: 700;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        body {
            background-color: #fff;
        }

        .ent-card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        .item-list-box {
            border: none;
            background-color: transparent;
            padding: 0;
        }
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3 no-print">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-file-invoice-dollar fa-2x text-warning"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-receipt me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} BILLING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Panel Akumulasi Tagihan Bulanan Anggota</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Penagihan Belanja Anggota Koperasi</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Rekapitulasi tagihan belanja anggota per cabang, pengiriman nota WhatsApp, dan pelunasan via COA.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="ent-badge px-3 py-2" style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <i class="fas fa-calendar-check me-1"></i> {{ date('d-m-Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BOX (KONTROL UTAMA) -->
<div class="ent-card p-4 mb-3 no-print">
    <h6 class="fw-bold mb-3">
        <i class="fas fa-filter me-2 text-primary"></i>Filter Penagihan Cabang
    </h6>
    <div class="row align-items-end g-3">
        <div class="col-md-6">
            <label class="form-label ent-label">Pilih Cabang Koperasi</label>
            <select class="form-select" id="select-cabang">
                <option value="" selected disabled>-- Pilih Cabang --</option>
                @foreach($daftarCabang as $cabang)
                <option value="{{ $cabang }}">{{ $cabang }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 d-flex flex-wrap gap-2">
            <button type="button" class="btn ent-btn ent-btn-primary px-4" id="btn-proses-tagihan" style="height: 40px;">
                <i class="fas fa-sync me-1"></i> Proses Data
            </button>
            <button type="button" class="btn ent-btn btn-outline-secondary px-4" id="btn-cetak" style="height: 40px;" disabled>
                <i class="fas fa-print me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>

<!-- LEMBAR LAPORAN HASIL PENAGIHAN -->
<div class="ent-card p-4 p-md-5 mb-4 d-none" id="report-card-wrapper">
    <!-- Header Dokumen Cetak -->
    <div class="text-center border-bottom pb-4 mb-4" style="border-color: var(--ent-grid-border) !important;">
        <h4 class="fw-bold text-uppercase mb-1">Koperasi Karyawan Kop-Mart</h4>
        <h6 class="opacity-75 mb-0">Laporan Rekapitulasi Tagihan Belanja Anggota</h6>
        <p class="mb-0 small opacity-75 mt-2">
            Cabang Penagihan: <strong id="text-cabang-report">-</strong> | Tanggal Cetak: {{ date('d-m-Y H:i') }}
        </p>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom" id="table-penagihan">
            <thead>
                <tr class="text-center">
                    <th style="width: 4%">No</th>
                    <th style="width: 11%">NIP</th>
                    <th style="width: 19%">Nama Anggota</th>
                    <th>Rincian Item Barang Dibeli</th>
                    <th style="width: 15%">Total Tagihan</th>
                    <th style="width: 15%" class="no-print">Aksi</th>
                </tr>
            </thead>
            <tbody id="container-rows-tagihan">
                <!-- Data di-render lewat jQuery AJAX -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end py-3">GRAND TOTAL TAGIHAN CABANG :</td>
                    <td class="text-end text-danger py-3" id="total-semua-tagihan" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                    <td class="no-print"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Tanda Tangan Dokumen -->
    <div class="row mt-5 pt-4 text-center justify-content-end">
        <div class="col-md-4">
            <p class="mb-5">Bendahara Koperasi,</p>
            <div class="border-top w-75 mx-auto mt-4"></div>
            <small class="opacity-75">Tim Keuangan Pusat</small>
        </div>
    </div>
</div>

<!-- Pesan Awal Sebelum Pilih Cabang -->
<div class="ent-card text-center py-5 px-3 opacity-75 no-print" id="empty-state-report">
    <div class="card-body">
        <i class="fas fa-file-invoice fa-3x mb-3 text-primary"></i>
        <h6 class="fw-bold mb-1">Silakan pilih cabang di atas untuk memproses data penagihan.</h6>
        <p class="mb-0 small">Data akumulasi tagihan belanja anggota akan tampil setelah tombol <strong>Proses Data</strong> ditekan.</p>
    </div>
</div>

<!-- MODAL PEMBAYARAN TAGIHAN ANGGOTA (COA SELECTION) -->
<div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <h5 class="modal-title fw-bold text-white mb-0">
                    <i class="fas fa-cash-register me-2 text-success"></i>Pembayaran Tagihan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-bayar-tagihan">
                    <input type="hidden" id="bayar-id-peserta">
                    <input type="hidden" id="bayar-jumlah-nominal">

                    <div class="mb-3">
                        <label class="form-label ent-label">Nama Anggota</label>
                        <input type="text" class="form-control fw-bold" id="bayar-nama-anggota" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label ent-label">Total Tagihan Yang Dibayar</label>
                        <input type="text" class="form-control fw-bold text-danger fs-5" id="bayar-display-nominal" style="font-family: 'JetBrains Mono', monospace;" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label ent-label"><i class="fas fa-book me-1 text-primary"></i> Pilih Akun Penerimaan (COA)</label>
                        <select class="form-select" id="select-coa-pembayaran" required>
                            <option value="" selected disabled>-- Pilih Akun Kas / Bank (COA) --</option>
                            @if(isset($daftarCoa) && count($daftarCoa) > 0)
                            @foreach($daftarCoa as $coa)
                            <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                            @endforeach
                            @else
                            <option value="101.01">101.01 - Kas Bendahara Koperasi</option>
                            <option value="102.01">102.01 - Bank Mandiri Operasional</option>
                            <option value="102.02">102.02 - Bank BCA Koperasi</option>
                            <option value="102.03">102.03 - Bank BRI Koperasi</option>
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="btn ent-btn ent-btn-success w-100 py-2">
                        <i class="fas fa-check-circle me-1"></i> Konfirmasi &amp; Simpan Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        function formatRupiah(number) {
            return 'Rp ' + (parseFloat(number) || 0).toLocaleString('id-ID');
        }

        // 1. Memproses data tagihan per cabang
        $('#btn-proses-tagihan').on('click', function() {
            let cabang = $('#select-cabang').val();

            if (!cabang) {
                Swal.fire('Peringatan', 'Silakan pilih cabang terlebih dahulu!', 'warning');
                return;
            }

            $.ajax({
                url: "{{ route('menu_koperasi_penagihan_belanja_koperasi_tagih') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cabang: cabang
                },
                success: function(res) {
                    if (res.status === 'success') {
                        $('#empty-state-report').addClass('d-none');
                        $('#report-card-wrapper').removeClass('d-none');
                        $('#btn-cetak').prop('disabled', false);

                        $('#text-cabang-report').text(res.cabang);
                        $('#container-rows-tagihan').empty();

                        let grandTotalTagihan = 0;

                        if (res.data.length > 0) {
                            res.data.forEach(function(item, index) {
                                grandTotalTagihan += parseFloat(item.total_tagihan) || 0;

                                let row = `
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${item.nip}</td>
                                        <td><strong>${item.nama_anggota}</strong></td>
                                        <td>
                                            <div class="item-list-box">
                                                <i class="fas fa-box-open me-1 text-primary"></i> ${item.rincian_barang}
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(item.total_tagihan)}</td>
                                        <td class="text-center no-print">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-success btn-send-wa"
                                                    data-nama="${item.nama_anggota}"
                                                    data-hp="${item.no_hp || ''}"
                                                    data-items="${item.rincian_barang}"
                                                    data-total="${formatRupiah(item.total_tagihan)}"
                                                    title="Kirim Nota WA">
                                                    <i class="fab fa-whatsapp"></i> WA
                                                </button>
                                                <button type="button" class="btn btn-success btn-open-pay"
                                                    data-id="${item.id_kop_master_peserta}"
                                                    data-nama="${item.nama_anggota}"
                                                    data-total="${item.total_tagihan}"
                                                    title="Bayar Tagihan">
                                                    <i class="fas fa-money-bill-wave me-1"></i> Bayar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                $('#container-rows-tagihan').append(row);
                            });
                        } else {
                            $('#container-rows-tagihan').append(`
                                <tr>
                                    <td colspan="6" class="text-center opacity-75 py-4">
                                        Tidak ada tagihan aktif dengan metode 'MASUK_TAGIHAN' di cabang ini.
                                    </td>
                                </tr>
                            `);
                        }

                        $('#total-semua-tagihan').text(formatRupiah(grandTotalTagihan));
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memproses data tagihan.', 'error');
                }
            });
        });

        // 2. Akses Kirim Pesan Whatsapp
        $(document).on('click', '.btn-send-wa', function() {
            let nama = $(this).data('nama');
            let hp = $(this).data('hp');
            let items = $(this).data('items');
            let total = $(this).data('total');

            if (!hp) {
                Swal.fire('Nomor Tidak Ada', 'Nomor HP/WA anggota ini belum tercatat di database.', 'warning');
                return;
            }

            let formattedHp = hp.toString().replace(/[^0-9]/g, '');
            if (formattedHp.startsWith('0')) {
                formattedHp = '62' + formattedHp.substring(1);
            }

            let pesan = `Halo Sdr/i *${nama}*,\n\nBerikut rincian tagihan belanja koperasi Anda:\n\n*Rincian Barang:* ${items}\n*Total Tagihan:* *${total}*\n\nMohon lakukan pelunasan tagihan melalui pengurus koperasi. Terima kasih!`;

            let waUrl = `https://api.whatsapp.com/send?phone=${formattedHp}&text=${encodeURIComponent(pesan)}`;
            window.open(waUrl, '_blank');
        });

        // 3. Buka Modal Pembayaran (Pilih COA)
        $(document).on('click', '.btn-open-pay', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let total = parseFloat($(this).data('total')) || 0;

            $('#bayar-id-peserta').val(id);
            $('#bayar-jumlah-nominal').val(total);
            $('#bayar-nama-anggota').val(nama);
            $('#bayar-display-nominal').val(formatRupiah(total));

            $('#modalBayar').modal('show');
        });

        // 4. Submit Form Pembayaran Tagihan
        $('#form-bayar-tagihan').on('submit', function(e) {
            e.preventDefault();

            let idPeserta = $('#bayar-id-peserta').val();
            let kodeCoa = $('#select-coa-pembayaran').val();
            let jumlahBayar = $('#bayar-jumlah-nominal').val();

            if (!kodeCoa) {
                Swal.fire('Peringatan', 'Silakan pilih Akun COA Penerimaan terlebih dahulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Apakah Anda yakin ingin memproses pelunasan ini ke COA [${kodeCoa}]?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Proses Pelunasan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('menu_koperasi_penagihan_belanja_koperasi_bayar') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_kop_master_peserta: idPeserta,
                            kode_coa: kodeCoa,
                            jumlah_bayar: jumlahBayar
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                $('#modalBayar').modal('hide');
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    $('#btn-proses-tagihan').click();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Terjadi kesalahan saat memproses pembayaran.', 'error');
                        }
                    });
                }
            });
        });

        // Cetak Report
        $('#btn-cetak').on('click', function() {
            window.print();
        });
    });
</script>
@endsection
