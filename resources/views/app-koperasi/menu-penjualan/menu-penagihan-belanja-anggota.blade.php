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

    <style>
        body {
            background-color: #f6f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
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
                        <table class="table table-bordered table-striped align-middle" id="table-penagihan">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">NIP</th>
                                    <th>Nama Anggota</th>
                                    <th style="width: 20%">Jumlah Transaksi</th>
                                    <th style="width: 25%">Total Tagihan Potong Gaji</th>
                                </tr>
                            </thead>
                            <tbody id="container-rows-tagihan">
                                <!-- Data di-render lewat jQuery AJAX -->
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="3" class="text-end py-3">GRAND TOTAL TAGIHAN CABANG :</td>
                                    <td class="text-center py-3" id="total-semua-trx">0</td>
                                    <td class="text-end text-danger py-3" id="total-semua-tagihan">Rp 0</td>
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

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            function formatRupiah(number) {
                return 'Rp ' + parseFloat(number).toLocaleString('id-ID');
            }

            // Aksi memproses data tagihan per cabang
            $('#btn-proses-tagihan').on('click', function() {
                let cabang = $('#select-cabang').val();

                if (!cabang) {
                    alert('Silakan pilih cabang terlebih dahulu!');
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

                            // Isi Informasi Meta Header Lap.
                            $('#text-cabang-report').text(res.cabang);

                            // Bersihkan isi tabel lama
                            $('#container-rows-tagihan').empty();

                            let grandTotalTagihan = 0;
                            let grandTotalTrx = 0;

                            if (res.data.length > 0) {
                                res.data.forEach(function(item, index) {
                                    grandTotalTagihan += parseFloat(item.total_tagihan);
                                    grandTotalTrx += parseInt(item.total_transaksi);

                                    let row = `
                                        <tr>
                                            <td class="text-center">${index + 1}</td>
                                            <td class="font-monospace text-center">${item.nip}</td>
                                            <td><strong>${item.nama_anggota}</strong></td>
                                            <td class="text-center">${item.total_transaksi} Kali Belanja</td>
                                            <td class="text-end fw-bold">${formatRupiah(item.total_tagihan)}</td>
                                        </tr>
                                    `;
                                    $('#container-rows-tagihan').append(row);
                                });
                            } else {
                                $('#container-rows-tagihan').append(`
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Tidak ada tagihan aktif dengan metode 'MASUK_TAGIHAN' di cabang ini.
                                        </td>
                                    </tr>
                                `);
                            }

                            // Update nilai Grand Total kaki tabel
                            $('#total-semua-trx').text(grandTotalTrx + ' Transaksi');
                            $('#total-semua-tagihan').text(formatRupiah(grandTotalTagihan));
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal memproses data tagihan.');
                    }
                });
            });

            // Aksi Cetak Browser bawaan
            $('#btn-cetak').on('click', function() {
                window.print();
            });
        });
    </script>
</body>

</html>
