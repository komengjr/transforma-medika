<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi & Persetujuan Ketua Koperasi</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 untuk Ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .search-container {
            max-width: 650px;
            width: 100%;
        }

        .detail-container {
            max-width: 850px;
            width: 100%;
        }

        .input-group-custom {
            border: 2px solid #0d6efd;
            border-radius: 50px;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .input-group-custom input {
            border: 0;
            background: transparent;
            padding-left: 20px;
        }

        .input-group-custom input:focus {
            box-shadow: none;
            outline: none;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }
    </style>
</head>

<body>

    <div class="container d-flex flex-column align-items-center justify-content-center py-5">

        <!-- 1. KOTAK PENCARIAN NOTA (Gaya Desain Gambar) -->
        <div class="card border-0 shadow-lg rounded-4 p-4 text-center mb-5 bg-white search-container">
            <div class="mb-3">
                <div class="bg-primary-subtle text-primary d-inline-block p-4 rounded-circle mb-2">
                    <i class="fas fa-search fa-3x"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark mb-1">Cek Tiket Pembelian</h3>
            <p class="text-muted small px-4">Masukkan nomor nota transaksi pembelian barang anggota untuk memulai laporan validasi persetujuan Ketua Koperasi</p>

            <div class="mt-4 px-3">
                <div class="input-group input-group-lg input-group-custom">
                    <input type="text" id="input-nota" class="form-control px-4 fs-6" placeholder="Contoh: PBI-20260720-XXXXXX" aria-label="Nomor Nota">
                    <button class="btn btn-primary rounded-pill px-4 fw-bold fs-6" type="button" id="btn-cari-nota">Cari</button>
                </div>
            </div>
        </div>

        <!-- 2. WRAPPER DETAIL DATA TRANSAKSI (Awalnya Tersembunyi) -->
        <div class="card border-0 shadow-lg rounded-3 d-none detail-container mb-5" id="wrapper-detail-nota">
            <div class="card-header bg-dark text-white fw-bold py-3 px-4 d-flex justify-content-between align-items-center rounded-top-3">
                <span class="fs-5"><i class="fas fa-file-invoice me-2 text-warning"></i> Rincian Pengajuan Kontrak</span>
                <span class="badge bg-warning text-dark px-3 py-2 fs-6 shadow-sm" id="badge-status-pemberitahuan">PENDING</span>
            </div>
            <div class="card-body p-4 bg-light">
                <div class="row g-4">
                    <!-- Kolom Kiri: Informasi Anggota & Barang -->
                    <div class="col-md-6 border-end-md border-bottom border-bottom-md-0 pb-3 pb-md-0">
                        <h6 class="text-secondary fw-bold text-uppercase tracking-wider small mb-3">
                            <i class="fas fa-user me-2"></i>Informasi Anggota
                        </h6>
                        <p class="mb-2"><strong>Kode Peserta:</strong> <br><span id="txt-kode-anggota" class="text-muted">-</span></p>
                        <p class="mb-4"><strong>Nama Lengkap:</strong> <br><span id="txt-nama-anggota" class="text-muted">-</span></p>

                        <h6 class="text-secondary fw-bold text-uppercase tracking-wider small mb-3">
                            <i class="fas fa-box open me-2"></i>Spesifikasi Barang
                        </h6>
                        <p class="mb-0"><strong>Nama Barang / Unit:</strong> <br><span id="txt-nama-barang" class="text-muted">-</span></p>
                    </div>

                    <!-- Kolom Kanan: Rincian Finansial -->
                    <div class="col-md-6 ps-md-4">
                        <h6 class="text-secondary fw-bold text-uppercase tracking-wider small mb-3">
                            <i class="fas fa-calculator me-2"></i>Rincian Finansial & Tenor
                        </h6>
                        <p class="mb-2"><strong>Harga Beli Pokok:</strong> <br><span id="txt-harga-beli" class="text-muted">-</span></p>
                        <p class="mb-2"><strong>Margin Keuntungan Koperasi:</strong> <br><span id="txt-margin" class="text-muted">-</span></p>
                        <p class="mb-2"><strong>Total Nilai Piutang:</strong> <br><span id="txt-total-piutang" class="fw-bold text-dark">-</span></p>
                        <p class="mb-3"><strong>Jangka Waktu Tenor:</strong> <br><span id="txt-tenor" class="badge bg-secondary mt-1 fs-6">-</span></p>
                        <div class="p-3 bg-success-subtle rounded-3 border border-success border-opacity-25 mt-2">
                            <p class="mb-0 text-success fw-bold fs-5">Angsuran: <span id="txt-cicilan">-</span> / bln</p>
                        </div>
                    </div>
                </div>

                <!-- Catatan Penolakan jika Status Ditolak Sebelumnya -->
                <div class="alert alert-danger d-none mt-4 mb-0 shadow-sm" id="block-alasan-ditolak">
                    <i class="fas fa-exclamation-circle me-2"></i><strong>Alasan Penolakan Ketua:</strong>
                    <p class="mb-0 mt-1 italic ps-4" id="txt-alasan-ditolak"></p>
                </div>
            </div>

            <!-- PANEL BUTTON TINDAKAN OTORISASI (Hanya Aktif Jika Status PENDING) -->
            <div class="card-footer bg-white text-end py-3 px-4 d-none rounded-bottom-3 border-top" id="panel-aksi-ketua">
                <input type="hidden" id="hidden-id-pembelian">
                <button class="btn btn-outline-danger fw-bold me-2 px-4 py-2 rounded-pill btn-proses-keputusan" data-status="DITOLAK">
                    <i class="fas fa-times-circle me-1"></i> Tolak Pengajuan
                </button>
                <button class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm btn-proses-keputusan" data-status="DISETUJUI">
                    <i class="fas fa-signature me-1"></i> Tanda Tangan & Setujui
                </button>
            </div>
        </div>

    </div>

    <!-- JavaScript Dependencies (jQuery, Bootstrap, SweetAlert2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // Formatter Rupiah Internasional Lokal Indonesia
            function formatRupiah(angka) {
                return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
            }

            // Aksi Trigger AJAX Pencarian Nota
            $('#btn-cari-nota').on('click', function() {
                let nota = $('#input-nota').val().trim();
                if (!nota) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Silakan ketik nomor nota pengajuan terlebih dahulu.',
                        icon: 'warning',
                        confirmButtonText: 'Oke'
                    });
                    return;
                }

                $.ajax({
                    url: `{{ url('v3/data-persetujuan-form/get-data') }}/${nota}`,
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'success') {
                            let data = response.data;

                            // Mapping data objek JSON ke dalam komponen HTML
                            $('#hidden-id-pembelian').val(data.id_pembelian);
                            $('#txt-kode-anggota').text(data.kop_master_peserta_code);
                            $('#txt-nama-anggota').text(data.kop_master_peserta_name);
                            $('#txt-nama-barang').text(data.barang_nama);
                            $('#txt-harga-beli').text(formatRupiah(data.harga_beli));
                            $('#txt-margin').text(formatRupiah(data.margin_koperasi));
                            $('#txt-total-piutang').text(formatRupiah(data.total_piutang));
                            $('#txt-tenor').text(data.tenor_bulan + ' Bulan');
                            $('#txt-cicilan').text(formatRupiah(data.cicilan_per_bulan));

                            // Pengkondisian Warna Desain Badge Berdasarkan Status Akhir Dokumen
                            $('#badge-status-pemberitahuan')
                                .text(data.status_persetujuan)
                                .removeClass('bg-warning bg-success bg-danger text-dark text-white')
                                .addClass(data.status_persetujuan === 'PENDING' ? 'bg-warning text-dark' : (data.status_persetujuan === 'DISETUJUI' ? 'bg-success text-white' : 'bg-danger text-white'));

                            // Evaluasi Tombol Panel Aksi Ketua
                            if (data.status_persetujuan === 'PENDING') {
                                $('#panel-aksi-ketua').removeClass('d-none');
                                $('#block-alasan-ditolak').addClass('d-none');
                            } else {
                                $('#panel-aksi-ketua').addClass('d-none');
                                if (data.status_persetujuan === 'DITOLAK') {
                                    $('#txt-alasan-ditolak').text(data.alasan_penolakan || 'Tidak ada catatan tertulis.');
                                    $('#block-alasan-ditolak').removeClass('d-none');
                                } else {
                                    $('#block-alasan-ditolak').addClass('d-none');
                                }
                            }

                            // Efek memunculkan container detail dokumen
                            $('#wrapper-detail-nota').removeClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Nota transaksi tidak valid atau gangguan server.';
                        Swal.fire({
                            title: 'Nota Tidak Ditemukan',
                            text: msg,
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                        $('#wrapper-detail-nota').addClass('d-none');
                    }
                });
            });

            // Event listener pendeteksi tombol "Enter" di keyboard
            $('#input-nota').on('keypress', function(e) {
                if (e.which == 13) {
                    $('#btn-cari-nota').click();
                }
            });

            // Aksi Proses Keputusan Akhir (Setuju / Tolak)
            $('.btn-proses-keputusan').on('click', function() {
                let id = $('#hidden-id-pembelian').val();
                let status = $(this).data('status');

                if (status === 'DISETUJUI') {
                    Swal.fire({
                        title: 'Setujui Dokumen Kontrak?',
                        text: "Menandatangani berkas ini akan menerbitkan tabel tenor cicilan bulanan anggota secara otomatis.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Otorisasi & Setujui',
                        cancelButtonText: 'Kembali'
                    }).then((r) => {
                        if (r.isConfirmed) {
                            eksekusiSimpanOtorisasi(id, 'DISETUJUI', null);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Tolak Berkas Pengajuan?',
                        text: 'Silakan lampirkan alasan penolakan peminjaman barang ini:',
                        input: 'textarea',
                        inputPlaceholder: 'Tulis argumen pembatalan di sini...',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Tolak Pengajuan',
                        cancelButtonText: 'Batal',
                        inputValidator: (v) => {
                            if (!v) return 'Alasan pembatalan wajib diisi!'
                        }
                    }).then((r) => {
                        if (r.isConfirmed) {
                            eksekusiSimpanOtorisasi(id, 'DITOLAK', r.value);
                        }
                    });
                }
            });

            // Fungsi AJAX Post Otorisasi Data ke Server Backend
            function eksekusiSimpanOtorisasi(id, status, alasanText) {
                $.ajax({
                    url: "{{ route('data_persetujuan_form_proses') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_pembelian: id,
                        keputusan: status,
                        alasan: alasanText
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: res.message,
                                icon: 'success'
                            }).then(() => {
                                // Muat ulang data terbaru tanpa perlu merefresh halaman browser
                                $('#btn-cari-nota').click();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Sistem gagal menyimpan status otorisasi ketua.', 'error');
                    }
                });
            }
        });
    </script>
</body>

</html>
