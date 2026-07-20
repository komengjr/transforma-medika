@extends('layouts.layouts')

@section('content')
<!-- HEADER PAGE -->
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded me-3">
                    <i class="fas fa-university fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-dark">Mutasi Rekening Bank</h4>
                    <p class="text-muted mb-0 fs-2">Pencatatan mutasi koran bank dan sinkronisasi jurnal otomatis</p>
                </div>
            </div>
            <div>
                <span class="badge bg-secondary p-2">Periode: {{ date('F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="row g-3">
    <!-- FORM INPUT MUTASI -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Form Input Mutasi</h5>
            </div>
            <div class="card-body">
                <form id="form-mutasi-bank">
                    <!-- CSRF Token untuk Laravel -->
                    <input type="hidden" name="_token" value="{{ csrf_token() ?? '' }}">

                    <!-- Tanggal Transaksi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs--1">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="mutasi_tgl" id="mutasi_tgl" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Pilih Akun Bank (COA Asal/Tujuan) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rekening Bank (Kas/Bank) <span class="text-danger">*</span></label>
                        <select class="form-select" name="bank_coa_code" id="bank_coa_code" required>
                            <option value="">-- Pilih Bank --</option>
                            @foreach($bankCoa as $coa)
                            <option value="{{ $coa->coa_code }}" data-name="{{ $coa->coa_name }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Mutasi (Masuk / Keluar) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Mutasi <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mutasi_jenis" id="jenis_masuk" value="CR" checked>
                                <label class="form-check-label text-success fw-bold" for="jenis_masuk">
                                    <i class="fas fa-arrow-down me-1"></i> Uang Masuk (Debit Bank)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mutasi_jenis" id="jenis_keluar" value="DB">
                                <label class="form-check-label text-danger fw-bold" for="jenis_keluar">
                                    <i class="fas fa-arrow-up me-1"></i> Uang Keluar (Kredit Bank)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nominal Transaksi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nominal Transaksi (Rupiah) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">Rp</span>
                            <input type="number" class="form-control font-monospace fw-bold" name="mutasi_nominal" id="mutasi_nominal" placeholder="0" min="1" required>
                        </div>
                    </div>

                    <!-- Lawan Transaksi / Akun Penyeimbang Jurnal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Akun Lawan (Jurnal Kontra) <span class="text-danger">*</span></label>
                        <select class="form-select" name="lawan_coa_code" id="lawan_coa_code" required>
                            <option value="">-- Pilih Akun Alokasi --</option>
                            @foreach($allCoa as $coa)
                            <option value="{{ $coa->coa_code }}" data-name="{{ $coa->coa_name }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ ucfirst($coa->coa_type) }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Keterangan Mutasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan / Memo</label>
                        <textarea class="form-control" name="mutasi_keterangan" id="mutasi_keterangan" rows="3" placeholder="Contoh: Transfer bunga simpanan atau pembayaran biaya admin bank..."></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" id="btn-preview-mutasi">
                            <i class="fas fa-sync-alt me-2"></i>Generate & Validasi Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PRATINJAU BUKU REKENING & LIVE JURNAL INTERAKTIF -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-eye me-2"></i>Pratinjau Sinkronisasi</h5>
            </div>
            <div class="card-body">
                <!-- 1. Preview Buku Mutasi Rekening -->
                <div class="mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-book me-2 text-warning"></i>1. Log Buku Rekening Bank</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered bg-light fs--2 align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Rekening</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Debet (Masuk)</th>
                                    <th class="text-end">Kredit (Keluar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row-preview-mutasi-kosong">
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada data dimasukkan. Tekan 'Generate & Validasi Jurnal'</td>
                                </tr>
                                <tr id="row-preview-mutasi-data" class="d-none">
                                    <td id="pv-tgl">-</td>
                                    <td id="pv-bank" class="fw-bold">-</td>
                                    <td id="pv-ket">-</td>
                                    <td id="pv-masuk" class="text-success text-end font-monospace">Rp 0</td>
                                    <td id="pv-keluar" class="text-danger text-end font-monospace">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Preview Double Entry Jurnal Akuntansi -->
                <div>
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-balance-scale me-2 text-info"></i>2. Aturan Otomatis Jurnal Umum (Double Entry)</h6>
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--2 align-middle mb-0">
                                <thead>
                                    <tr class="border-bottom text-muted">
                                        <th>Kode Akun (COA)</th>
                                        <th>Nama Akun</th>
                                        <th class="text-end">Debit</th>
                                        <th class="text-end">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="jurnal-kosong">
                                        <td colspan="4" class="text-center text-muted py-3">Pratinjau jurnal akuntansi kosong</td>
                                    </tr>
                                    <tr id="jurnal-baris-1" class="d-none">
                                        <td id="j1-code" class="fw-bold"></td>
                                        <td id="j1-name"></td>
                                        <td id="j1-debit" class="text-end font-monospace">Rp 0</td>
                                        <td id="j1-kredit" class="text-end font-monospace">Rp 0</td>
                                    </tr>
                                    <tr id="jurnal-baris-2" class="d-none">
                                        <td id="j2-code" class="fw-bold ps-3"></td>
                                        <td id="j2-name" class="ps-3"></td>
                                        <td id="j2-debit" class="text-end font-monospace">Rp 0</td>
                                        <td id="j2-kredit" class="text-end font-monospace">Rp 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Submit Akhir Post Data Ke DB -->
                    <div class="text-end">
                        <button type="button" class="btn btn-success px-4 d-none" id="btn-simpan-mutasi-final">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Simpan Mutasi & Posting Jurnal
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- TAMBAHAN: TABEL RIWAYAT LOG MUTASI BANK -->
<!-- ========================================== -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-history me-2 text-primary"></i>Riwayat Mutasi Terkini
                </h5>
                <span class="badge bg-light text-dark border">Menampilkan 50 data terakhir</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 text-nowrap" style="font-size: 0.875rem;">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-3">No. Bukti</th>
                                <th>Tanggal</th>
                                <th>Rekening Bank</th>
                                <th>Keterangan / Memo</th>
                                <th class="text-end text-success">Debet (Masuk)</th>
                                <th class="text-end text-danger">Kredit (Keluar)</th>
                                <th class="text-center">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logMutasi as $log)
                            <tr>
                                <td class="ps-3 fw-bold text-primary font-monospace">{{ $log->mutasi_no_bukti }}</td>
                                <td>{{ date('d-m-Y', strtotime($log->mutasi_tgl)) }}</td>
                                <td>
                                    <small class="text-muted d-block font-monospace">{{ $log->coa_code }}</small>
                                    <strong>{{ $log->coa_name }}</strong>
                                </td>
                                <td style="max-width: 300px; white-space: normal;">{{ $log->mutasi_keterangan }}</td>
                                <td class="text-end font-monospace fw-semibold {{ $log->mutasi_debit > 0 ? 'text-success' : 'text-muted' }}">
                                    {{ $log->mutasi_debit > 0 ? 'Rp '.number_format($log->mutasi_debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-end font-monospace fw-semibold {{ $log->mutasi_kredit > 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ $log->mutasi_kredit > 0 ? 'Rp '.number_format($log->mutasi_kredit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-center text-secondary small">{{ $log->mutasi_user }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x d-block mb-2 text-light"></i>
                                    Belum ada transaksi mutasi yang tercatat bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        // Fungsi Helper format mata uang
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Aksi Klik Tombol Generate Preview
        $('#btn-preview-mutasi').on('click', function() {
            let tgl = $('#mutasi_tgl').val();
            let bankCoa = $('#bank_coa_code').val();
            let bankName = $('#bank_coa_code option:selected').data('name');
            let jenis = $('input[name="mutasi_jenis"]:checked').val();
            let nominal = $('#mutasi_nominal').val();
            let lawanCoa = $('#lawan_coa_code').val();
            let lawanName = $('#lawan_coa_code option:selected').data('name');
            let keterangan = $('#mutasi_keterangan').val() || 'Mutasi Bank Tanpa Keterangan';

            if (!tgl || !bankCoa || !nominal || !lawanCoa) {
                Swal.fire('Form Belum Lengkap', 'Harap isi semua kolom berlabel bintang (*) merah terlebih dahulu.', 'warning');
                return;
            }

            // Tampilkan Baris Preview Log Buku Rekening Bank
            $('#row-preview-mutasi-kosong').addClass('d-none');
            $('#row-preview-mutasi-data').removeClass('d-none');

            $('#pv-tgl').text(tgl);
            $('#pv-bank').text(bankName);
            $('#pv-ket').text(keterangan);

            if (jenis === 'CR') {
                $('#pv-masuk').text(formatRupiah(nominal));
                $('#pv-keluar').text('Rp 0');

                $('#j1-code').text(bankCoa);
                $('#j1-name').text(bankName);
                $('#j1-debit').text(formatRupiah(nominal));
                $('#j1-kredit').text('Rp 0');

                $('#j2-code').text(lawanCoa);
                $('#j2-name').text('↳ ' + lawanName);
                $('#j2-debit').text('Rp 0');
                $('#j2-kredit').text(formatRupiah(nominal));
            } else {
                $('#pv-masuk').text('Rp 0');
                $('#pv-keluar').text(formatRupiah(nominal));

                $('#j1-code').text(lawanCoa);
                $('#j1-name').text(lawanName);
                $('#j1-debit').text(formatRupiah(nominal));
                $('#j1-kredit').text('Rp 0');

                $('#j2-code').text(bankCoa);
                $('#j2-name').text('↳ ' + bankName);
                $('#j2-debit').text('Rp 0');
                $('#j2-kredit').text(formatRupiah(nominal));
            }

            $('#jurnal-kosong').addClass('d-none');
            $('#jurnal-baris-1, #jurnal-baris-2, #btn-simpan-mutasi-final').removeClass('d-none');

            $('html, body').animate({
                scrollTop: $("#row-preview-mutasi-data").offset().top - 100
            }, 300);
        });

        // Aksi Post Data Menggunakan AJAX
        $('#btn-simpan-mutasi-final').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kunci & Posting Jurnal?',
                text: "Data mutasi buku rekening akan disimpan dan posting jurnal umum tidak dapat dibatalkan secara sepihak.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Posting Sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sinkronisasi Database',
                        text: 'Sedang menulis ke buku mutasi dan tabel jurnal fin...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let postData = $('#form-mutasi-bank').serialize();

                    $.ajax({
                        url: `{{ route('menu_koperasi_mutasi_rekening_bank_save') }}`, // Memastikan route memanggil nama POST controller kita
                        type: "POST",
                        data: postData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal Pembukuan', response.message || 'Terjadi kesalahan internal data.', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire('Terjadi Error', 'Gagal menyambung ke server. Periksa kembali backend Anda.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
