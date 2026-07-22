@extends('layouts.layouts')

{{-- Load CSS Select2 & Theme Bootstrap 5 --}}
@section('base.css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<!-- HEADER PAGE -->
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-shopping-basket fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Pembelian Barang Anggota / Peserta</h4>
                    <p class="text-muted mb-0 fs-2">Sistem pengadaan barang inventaris/kebutuhan anggota dengan skema pembayaran tenor (cicilan)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<form id="form-pembelian-barang">
    <input type="hidden" name="_token" value="{{ csrf_token() ?? '' }}">

    <div class="row g-3">
        <!-- FORM INPUT PENGADAAN BARANG -->
        <div class="col-xl-5 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cart-plus text-success me-2 fs-2"></i>
                        <h5 class="card-title mb-0 fw-bold text-dark">Form Input Transaksi</h5>
                    </div>
                </div>
                <div class="card-body py-4">
                    <!-- Pilih Peserta (Select2 Searchable) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Pilih Peserta Koperasi <span class="text-danger">*</span></label>
                        <select class="form-select select2-peserta" name="anggota_id" id="anggota_id" required>
                            <option value=""></option>
                            @foreach($anggota as $peserta)
                            <option value="{{ $peserta->id_kop_master_peserta }}" data-no="{{ $peserta->kop_master_peserta_code }}">
                                {{ $peserta->kop_master_peserta_code }} - {{ $peserta->kop_master_peserta_name }} (NIP: {{ $peserta->kop_master_peserta_nip }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Detail Barang & Tanggal -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold text-secondary">Nama / Spesifikasi Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="barang_nama" id="barang_nama" placeholder="Contoh: Smartphone Samsung A55" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-secondary">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Parameter Keuangan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Harga Beli Lapangan (Modal Awal) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                            <input type="text" class="form-control fw-bold font-monospace fs-5 text-dark rupiah-input" name="harga_beli" id="harga_beli" placeholder="0" required>
                        </div>
                        <div class="form-text text-muted">Harga riil barang yang dibayarkan ke supplier.</div>
                    </div>

                    <!-- Skema Keuntungan: Admin (Depan) & Bunga (Cicilan) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Biaya Admin (Potong Awal)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                <input type="text" class="form-control font-monospace text-dark rupiah-input" name="biaya_admin" id="biaya_admin" value="0">
                            </div>
                            <div class="form-text text-muted">Dipotong langsung dari kas pencairan awal.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Total Bunga / Flat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                <input type="text" class="form-control font-monospace text-dark rupiah-input" name="bunga_koperasi" id="bunga_koperasi" value="0">
                            </div>
                            <div class="form-text text-muted">Dibebankan ke anggota & dicicil tiap bulan.</div>
                        </div>
                    </div>

                    <!-- Tenor -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Tenor / Jangka Waktu <span class="text-danger">*</span></label>
                        <select class="form-select fw-bold text-primary" name="tenor_bulan" id="tenor_bulan" required>
                            <option value="3">3 Bulan</option>
                            <option value="6" selected>6 Bulan</option>
                            <option value="12">12 Bulan</option>
                            <option value="18">18 Bulan</option>
                            <option value="24">24 Bulan</option>
                            <option value="36">36 Bulan</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-success py-2.5 fw-bold" id="btn-kalkulasi-simulasi">
                            <i class="fas fa-calculator me-2"></i>Kalkulasi & Simulasikan Cicilan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- LIVE SIMULASI DAN PRATINJAU JURNAL -->
        <div class="col-xl-7 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-invoice-dollar text-primary me-2 fs-2"></i>
                        <h5 class="card-title mb-0 fw-bold text-dark">Lembar Simulasi & Proyeksi Jurnal</h5>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info Box Kanan -->
                    <div class="row g-3 text-center mb-4">
                        <div class="col-sm-4">
                            <div class="p-3 border rounded-3 bg-light">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Total Piutang Anggota</small>
                                <span class="fw-bold text-dark font-monospace fs-2" id="lbl-total-piutang">Rp 0</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 border rounded-3 bg-light">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Tenor Terpilih</small>
                                <span class="fw-bold text-primary fs-2" id="lbl-tenor">6 Bln</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 border border-success rounded-3 bg-success bg-opacity-10">
                                <small class="text-white fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Tagihan / Bulan</small>
                                <span class="fw-bold text-white font-monospace fs-2" id="lbl-cicilan-bulanan">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Jurnal Akuntansi Dinamis -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                            <i class="fas fa-balance-scale me-2 text-info"></i>1. Draft Otomatis Jurnal Pencairan Pengadaan
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0" style="font-size: 0.85rem;">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50%">Pilih Akun / Rekening COA</th>
                                        <th width="25%" class="text-end">Debit</th>
                                        <th width="25%" class="text-end">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris Debit: Piutang -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 text-muted small fw-bold">Akun Piutang Anggota (Debet)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_piutang" id="coa_piutang" required>
                                                <option value="">-- Pilih COA Piutang --</option>
                                                @foreach($bankCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end font-monospace text-success fw-bold align-middle" id="j-debit-piutang">Rp 0</td>
                                        <td class="text-end font-monospace text-muted align-middle">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 1: Kas / Bank Netto -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 text-muted small fw-bold">↳ Akun Kas/Bank Netto (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="sumber_dana_coa" id="sumber_dana_coa" required>
                                                <option value="">-- Pilih COA Kas/Bank --</option>
                                                @foreach($bankCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end font-monospace text-muted align-middle">Rp 0</td>
                                        <td class="text-end font-monospace text-danger fw-bold align-middle" id="j-kredit-kas">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 2: Pendapatan Admin (Potong Awal) -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 text-muted small fw-bold">↳ Akun Pendapatan Biaya Admin (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_pendapatan_admin" id="coa_pendapatan_admin" required>
                                                <option value="">-- Pilih COA Admin --</option>
                                                @foreach($PenCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end font-monospace text-muted align-middle">Rp 0</td>
                                        <td class="text-end font-monospace text-danger fw-bold align-middle" id="j-kredit-admin">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 3: Pendapatan Bunga -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 text-muted small fw-bold">↳ Akun Pendapatan Bunga (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_pendapatan_bunga" id="coa_pendapatan_bunga" required>
                                                <option value="">-- Pilih COA Bunga --</option>
                                                @foreach($PenCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end font-monospace text-muted align-middle">Rp 0</td>
                                        <td class="text-end font-monospace text-danger fw-bold align-middle" id="j-kredit-margin">Rp 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Timeline Jadwal Angsuran -->
                    <div>
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-calendar-alt me-2 text-warning"></i>2. Proyeksi Jadwal Angsuran Bulanan</h6>
                        <div class="table-responsive border rounded" style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-sm table-striped table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                <thead class="table-light sticky-top shadow-sm">
                                    <tr>
                                        <th class="ps-3">Angsuran Ke-</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end pe-3">Total Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody id="simulasi-tenor-tbody">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle d-block mb-1 fs-5"></i> Harap isi form kiri dan klik kalkulasi.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold d-none shadow" id="btn-submit-final-pembelian">
                            <i class="fas fa-save me-2"></i>Kunci Kontrak & Terbitkan Tagihan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- DATA TABEL RIWAYAT TRANSAKSI -->
<!-- DATA TABEL RIWAYAT TRANSAKSI -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-list text-secondary me-2 fs-2"></i>
                        <h5 class="card-title mb-0 fw-bold text-dark">Log Kontrak Pembelian Barang & Status Tenor</h5>
                    </div>
                    <!-- Filter Status -->
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-status" class="form-label mb-0 fw-bold text-secondary small">Filter Status:</label>
                        <select id="filter-status" class="form-select form-select-sm" style="width: 160px;">
                            <option value="">Semua Status</option>
                            <option value="LUNAS">LUNAS</option>
                            <option value="BELUM LUNAS">BELUM LUNAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="table-log-kontrak" class="table table-hover align-middle mb-0 w-100" style="font-size: 0.875rem;">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">No. Nota</th>
                                <th>Peserta Koperasi</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga Modal</th>
                                <th class="text-end">Biaya Admin</th>
                                <th class="text-end">Total Bunga</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-end">Cicilan / Bln</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $row)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold text-success">{{ $row->nota_nomor }}</td>
                                <td>
                                    <small class="text-muted d-block font-monospace">{{ $row->kop_master_peserta_code }}</small>
                                    <strong>{{ $row->kop_master_peserta_name }}</strong>
                                </td>
                                <td>{{ $row->barang_nama }}</td>
                                <td class="text-end font-monospace">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace text-muted">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace text-muted">Rp {{ number_format($row->bunga_koperasi ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace fw-semibold text-primary">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $row->tenor_bulan }} Bulan</span></td>
                                <td class="text-end font-monospace fw-bold text-success">Rp {{ number_format($row->cicilan_per_bulan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if(strtoupper(trim($row->status_tagihan)) == 'DRAFT')
                                    @php
                                    // Format nomor telepon (mengubah 08xx menjadi 628xx)
                                    $phone = preg_replace('/[^0-9]/', '', $row->kop_master_peserta_no_hp ?? '');
                                    if (str_starts_with($phone, '0')) {
                                    $phone = '62' . substr($phone, 1);
                                    }

                                    // Pesan WhatsApp Otomatis
                                    $pesanWA = "Halo Sir ada Pengajuan Pembelian Barang \nAtas Nama*" . $row->kop_master_peserta_name . "*,\n\n"
                                    . "Berikut draf pengajuan kontrak pembelian barang Anda di Koperasi:\n"
                                    . "- *No. Nota:* " . $row->nota_nomor . "\n"
                                    . "- *Barang:* " . $row->barang_nama . "\n"
                                    . "- *Total Piutang:* Rp " . number_format($row->total_piutang, 0, ',', '.') . "\n"
                                    . "- *Tenor:* " . $row->tenor_bulan . " Bulan\n"
                                    . "- *Cicilan/Bln:* Rp " . number_format($row->cicilan_per_bulan, 0, ',', '.') . "\n\n"
                                    . "Mohon konfirmasi jika data sudah sesuai. Terima kasih!";
                                    @endphp

                                    <a href="https://wa.me/{{ $phone }}?text={{ urlencode($pesanWA) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-success shadow-sm">
                                        <i class="fab fa-whatsapp fs-2"></i>
                                        <!-- <span>Kirim WA</span> -->
                                    </a>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'BELUM_LUNAS')
                                    <span class="badge bg-primary small">DISETUJUI</span>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'LUNAS')
                                    <span class="badge bg-success small">SELESAI</span>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'BATAL')
                                    <span class="badge bg-danger small">DIBATALKAN</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {

        // Inisialisasi Select2
        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Cari NIP, Code, atau Nama Peserta...',
                allowClear: true
            });

            $('.select2-coa').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Format angka ke Rupiah dengan prefix
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Format string angka biasa ke format ribuan
        function formatNumberThousand(value) {
            let numberString = value.replace(/[^,\d]/g, '').toString();
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // Clean string ribuan balik ke Float
        function cleanNumber(value) {
            if (!value) return 0;
            return parseFloat(value.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }

        // Masking realtime saat mengetik
        $(document).on('keyup input', '.rupiah-input', function() {
            let formatted = formatNumberThousand($(this).val());
            $(this).val(formatted);
        });

        // Event Handler saat klik kalkulasi
        // Event Handler saat klik kalkulasi
        $('#btn-kalkulasi-simulasi').on('click', function() {
            let anggota = $('#anggota_id').val();
            let barang = $('#barang_nama').val();
            let tgl = $('#tanggal_transaksi').val();

            let hargaBeli = cleanNumber($('#harga_beli').val()); // Harga Real Barang
            let biayaAdmin = cleanNumber($('#biaya_admin').val());
            let bungaKoperasi = cleanNumber($('#bunga_koperasi').val());
            let tenor = parseInt($('#tenor_bulan').val()) || 1;

            let coaPiutang = $('#coa_piutang').val();
            let bankCoa = $('#sumber_dana_coa').val();
            let coaAdmin = $('#coa_pendapatan_admin').val();
            let coaBunga = $('#coa_pendapatan_bunga').val();

            if (!anggota || !barang || hargaBeli <= 0) {
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Pastikan Anda telah memilih peserta, menginput barang, dan harga real barang.',
                    icon: 'warning'
                });
                return;
            }

            if (!coaPiutang || !bankCoa || !coaAdmin || !coaBunga) {
                Swal.fire({
                    title: 'COA Jurnal Belum Dipilih',
                    text: 'Silahkan tentukan Akun Piutang, Kas/Bank, Admin, dan Bunga pada tabel Draft Jurnal Akuntansi.',
                    icon: 'warning'
                });
                return;
            }

            // ==========================================
            // LOGIKA PERHITUNGAN BARU
            // ==========================================

            // 1. Akun Kas/Bank Netto (Kredit) = Harga Real Barang
            let kasKeluarNetto = hargaBeli;

            // 2. Akun Piutang Anggota (Debet) = Kas + Admin (Harga Real + Admin)
            let piutangAwalJurnal = hargaBeli + biayaAdmin;

            // 3. Total Keseluruhan yang dibayar Anggota (Termasuk Bunga)
            let totalKewajibanAnggota = hargaBeli + biayaAdmin + bungaKoperasi;

            // Cicilan bulanan yang ditagihkan ke anggota (Pokok + Admin/Tenor + Bunga/Tenor)
            let cicilanPerBulan = Math.round(totalKewajibanAnggota / tenor);

            // Pembagian Porsi Pokok & Bunga Bulanan
            let pokokDanAdminPerBulan = Math.floor(piutangAwalJurnal / tenor);
            let sisaPokokAkhir = piutangAwalJurnal - (pokokDanAdminPerBulan * tenor);

            let bungaPerBulan = Math.floor(bungaKoperasi / tenor);
            let sisaBungaAkhir = bungaKoperasi - (bungaPerBulan * tenor);

            // ==========================================
            // TAMPILAN RINGKASAN & JURNAL
            // ==========================================

            // Summary Top Box
            $('#lbl-total-piutang').text(formatRupiah(totalKewajibanAnggota));
            $('#lbl-tenor').text(tenor + ' Bln');
            $('#lbl-cicilan-bulanan').text(formatRupiah(cicilanPerBulan));

            // Draft Jurnal Pencairan Awal (Balance: Debet = Kredit)
            $('#j-debit-piutang').text(formatRupiah(piutangAwalJurnal)); // Debet: Piutang (Harga Real + Admin)
            $('#j-kredit-kas').text(formatRupiah(kasKeluarNetto)); // Kredit: Kas (Harga Real)
            $('#j-kredit-admin').text(formatRupiah(biayaAdmin)); // Kredit: Pendapatan Admin
            $('#j-kredit-margin').text(formatRupiah(bungaKoperasi)); // Bunga tidak masuk jurnal awal pencairan

            // ==========================================
            // PROYEKSI JADWAL ANGSURAN BULANAN
            // ==========================================
            let htmlTimeline = '';
            let startDate = new Date(tgl);

            for (let i = 1; i <= tenor; i++) {
                let dueDate = new Date(startDate.getTime());
                dueDate.setMonth(startDate.getMonth() + i);

                let day = dueDate.getDate().toString().padStart(2, '0');
                let month = (dueDate.getMonth() + 1).toString().padStart(2, '0');
                let year = dueDate.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                // Handling sisa pembulatan rupiah di bulan terakhir
                let currentPokok = (i === tenor) ? (pokokDanAdminPerBulan + sisaPokokAkhir) : pokokDanAdminPerBulan;
                let currentBunga = (i === tenor) ? (bungaPerBulan + sisaBungaAkhir) : bungaPerBulan;
                let currentTotal = currentPokok + currentBunga;

                htmlTimeline += `
            <tr>
                <td class="fw-semibold text-secondary ps-3">Angsuran Ke-${i}</td>
                <td><i class="far fa-calendar-check me-2 text-muted"></i> ${formattedDate}</td>
                <td class="text-end font-monospace text-muted">${formatRupiah(currentPokok)}</td>
                <td class="text-end font-monospace text-muted">${formatRupiah(currentBunga)}</td>
                <td class="text-end font-monospace fw-bold text-dark pe-3">${formatRupiah(currentTotal)}</td>
            </tr>
        `;
            }

            $('#simulasi-tenor-tbody').html(htmlTimeline);
            $('#btn-submit-final-pembelian').removeClass('d-none');
        });
        // Simpan Data Melalui AJAX
        $('#btn-submit-final-pembelian').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Kontrak',
                text: "Dokumen pembelian barang ini akan dikonfirmasi. Jadwal tagihan bulanan peserta akan langsung diaktifkan otomatis.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Terbitkan Kontrak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Kontrak',
                        text: 'Silahkan tunggu, sistem sedang menjadwalkan piutang...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Construct Payload Data
                    let payloadData = {};
                    let rawArray = $('#form-pembelian-barang').serializeArray();

                    $.each(rawArray, function(_, field) {
                        if (field.name === 'harga_beli' || field.name === 'biaya_admin' || field.name === 'bunga_koperasi') {
                            payloadData[field.name] = cleanNumber(field.value);
                        } else {
                            payloadData[field.name] = field.value;
                        }
                    });

                    $.ajax({
                        url: `{{ route('menu_koperasi_pembelian_barang_anggota_save') }}`,
                        type: "POST",
                        data: payloadData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal Menyimpan', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMsg = 'Terjadi masalah interkoneksi ke database server.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error Transaksi', errorMsg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {

        // Inisialisasi DataTables
        let logTable = $('#table-log-kontrak').DataTable({
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(disaring dari total _MAX_ data)",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            pageLength: 10,
            order: [], // Mempertahankan urutan default dari server/blade
            columnDefs: [{
                    orderable: false,
                    targets: [9]
                } // Matikan sorting untuk kolom Status jika tidak diperlukan
            ]
        });

        // Filter Spesifik Berdasarkan Status (Kolom Indeks ke-9)
        $('#filter-status').on('change', function() {
            let selectedStatus = $(this).val();
            // Menggunakan regex exact match (^val$) agar kata "LUNAS" tidak mencocokkan sebagian string lain
            if (selectedStatus) {
                logTable.column(9).search('^' + selectedStatus + '$', true, false).draw();
            } else {
                logTable.column(9).search('').draw();
            }
        });

        // --- KODE JAVASCRIPT LAINNYA TETAP SAMA (Select2, Format Rupiah, AJAX, dll.) ---

        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Cari NIP, Code, atau Nama Peserta...',
                allowClear: true
            });

            $('.select2-coa').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // ... Sisa script Anda lanjutan ...
    });
</script>
@endsection
