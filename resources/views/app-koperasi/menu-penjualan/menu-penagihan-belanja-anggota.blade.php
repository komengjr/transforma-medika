<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penagihan Belanja Anggota Koperasi</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f6f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .item-list-box {
            font-size: 0.85rem;
            color: #495057;
            background-color: #f8f9fa;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            display: inline-block;
            width: 100%;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: #fff;
            }

            .card {
                box-shadow: none !important;
            }

            .item-list-box {
                border: none;
                background-color: transparent;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 mb-4 no-print">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-file-invoice-dollar me-2 text-warning"></i>KOP-MART PENAGIHAN</a>
            <span class="navbar-text text-white-50 d-none d-sm-inline">Panel Akumulasi Tagihan Bulanan Anggota</span>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row">
            <div class="col-12">

                <!-- FILTER BOX (KONTROL UTAMA) -->
                <div class="card shadow-sm p-4 bg-white rounded-3 mb-4 no-print">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter me-2 text-primary"></i>Filter Penagihan Cabang</h5>
                    <div class="row align-items-end g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Pilih Cabang Koperasi</label>
                            <select class="form-select text-dark" id="select-cabang">
                                <option value="" selected disabled>-- Pilih Cabang --</option>
                                @foreach($daftarCabang as $cabang)
                                <option value="{{ $cabang }}">{{ $cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary fw-bold px-4" id="btn-proses-tagihan">
                                <i class="fas fa-sync me-1"></i> Proses Data
                            </button>
                            <button class="btn btn-outline-secondary fw-bold px-4 ms-2" id="btn-cetak" disabled>
                                <i class="fas fa-print me-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- LEMBAR LAPORAN HASIL PENAGIHAN -->
                <div class="card shadow-sm p-5 bg-white rounded-3 d-none" id="report-card-wrapper">
                    <!-- Header Dokumen Cetak -->
                    <div class="text-center border-bottom pb-4 mb-4">
                        <h3 class="fw-bold text-uppercase mb-1">Koperasi Karyawan Kop-Mart</h3>
                        <h5 class="text-secondary mb-0">Laporan Rekapitulasi Tagihan Belanja Anggota</h5>
                        <p class="mb-0 small text-muted mt-2">Cabang Penagihan: <strong id="text-cabang-report">-</strong> | Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
                    </div>

                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="table-penagihan">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="width: 4%">No</th>
                                    <th style="width: 10%">NIP</th>
                                    <th style="width: 18%">Nama Anggota</th>
                                    <th>Rincian Item Barang Dibeli</th>
                                    <th style="width: 15%">Total Tagihan</th>
                                    <th style="width: 15%" class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="container-rows-tagihan">
                                <!-- Data di-render lewat jQuery AJAX -->
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="4" class="text-end py-3">GRAND TOTAL TAGIHAN CABANG :</td>
                                    <td class="text-end text-danger py-3" id="total-semua-tagihan">Rp 0</td>
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
                            <small class="text-muted">Tim Keuangan Pusat</small>
                        </div>
                    </div>

                </div>

                <!-- Pesan Awal Sebelum Pilih Cabang -->
                <div class="text-center py-5 text-muted no-print" id="empty-state-report">
                    <i class="fas fa-file-invoice fa-4x mb-3 text-body-tertiary"></i>
                    <h5>Silakan pilih cabang di atas untuk memproses data penagihan.</h5>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL PEMBAYARAN TAGIHAN ANGGOTA (COA SELECTION) -->
    <div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-cash-register me-2"></i>Pembayaran Tagihan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-bayar-tagihan">
                        <input type="hidden" id="bayar-id-peserta">
                        <input type="hidden" id="bayar-jumlah-nominal">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Anggota</label>
                            <input type="text" class="form-control bg-light fw-bold" id="bayar-nama-anggota" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Total Tagihan Yang Dibayar</label>
                            <input type="text" class="form-control bg-light fw-bold text-danger fs-5" id="bayar-display-nominal" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark"><i class="fas fa-book me-1 text-primary"></i> Pilih Akun Penerimaan (COA)</label>
                            <select class="form-select" id="select-coa-pembayaran" required>
                                <option value="" selected disabled>-- Pilih Akun Kas / Bank (COA) --</option>
                                @if(isset($daftarCoa) && count($daftarCoa) > 0)
                                @foreach($daftarCoa as $coa)
                                <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                @endforeach
                                @else
                                <!-- Options Fallback Default Jika Belum Ada DB COA -->
                                <option value="101.01">101.01 - Kas Bendahara Koperasi</option>
                                <option value="102.01">102.01 - Bank Mandiri Operasional</option>
                                <option value="102.02">102.02 - Bank BCA Koperasi</option>
                                <option value="102.03">102.03 - Bank BRI Koperasi</option>
                                @endif
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Konfirmasi & Simpan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            function formatRupiah(number) {
                return 'Rp ' + parseFloat(number).toLocaleString('id-ID');
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
                                    grandTotalTagihan += parseFloat(item.total_tagihan);

                                    let row = `
                                        <tr>
                                            <td class="text-center">${index + 1}</td>
                                            <td class="font-monospace text-center">${item.nip}</td>
                                            <td><strong>${item.nama_anggota}</strong></td>
                                            <td>
                                                <div class="item-list-box">
                                                    <i class="fas fa-box-open me-1 text-primary"></i> ${item.rincian_barang}
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold text-danger">${formatRupiah(item.total_tagihan)}</td>
                                            <td class="text-center no-print">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-outline-success btn-send-wa"
                                                        data-nama="${item.nama_anggota}"
                                                        data-hp="${item.no_hp || ''}"
                                                        data-items="${item.rincian_barang}"
                                                        data-total="${formatRupiah(item.total_tagihan)}"
                                                        title="Kirim Nota WA">
                                                        <i class="fab fa-whatsapp fw-bold"></i> WA
                                                    </button>
                                                    <button class="btn btn-success btn-open-pay"
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
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Tidak ada tagihan aktif dengan metode 'MASUK_TAGIHAN' di cabang ini.
                                        </td>
                                    </tr>
                                `);
                            }

                            $('#total-semua-tagihan').text(formatRupiah(grandTotalTagihan));
                        }
                    },
                    error: function(xhr) {
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

                // Format nomor HP Indonesia (+62)
                let formattedHp = hp.toString().replace(/[^0-9]/g, '');
                if (formattedHp.startsWith('0')) {
                    formattedHp = '62' + formattedHp.substring(1);
                }

                // Susun Pesan WhatsApp
                let pesan = `Halo Sdr/i *${nama}*,\n\nBerikut rincian tagihan belanja koperasi Anda:\n\n*Rincian Barang:* ${items}\n*Total Tagihan:* *${total}*\n\nMohon lakukan pelunasan tagihan melalui pengurus koperasi. Terima kasih!`;

                let waUrl = `https://api.whatsapp.com/send?phone=${formattedHp}&text=${encodeURIComponent(pesan)}`;
                window.open(waUrl, '_blank');
            });

            // 3. Buka Modal Pembayaran (Pilih COA)
            $(document).on('click', '.btn-open-pay', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let total = parseFloat($(this).data('total'));

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
                                        $('#btn-proses-tagihan').click(); // Reload tabel tagihan
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal', xhr.responseJSON.message || 'Terjadi kesalahan saat memproses pembayaran.', 'error');
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
</body>

</html>
