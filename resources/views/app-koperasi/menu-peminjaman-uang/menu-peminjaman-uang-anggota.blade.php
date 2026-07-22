@extends('layouts.layouts') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('base.css')
<!-- Select2 CSS & Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')

<!-- HEADER MENU -->
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-hand-holding-usd  fa-2x"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-dark">
                        Transaksi Peminjaman Uang Anggota
                    </h4>
                    <p class="text-muted small mb-0">Kelola akad pengajuan pinjaman, kalkulasi simulasi angsuran, dan pembuatan piutang pinjaman.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM INPUT & SIMULASI PINJAMAN -->
<div class="row g-3">
    <!-- FORM PENGATURAN KONTRAK PINJAMAN -->
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-file-signature text-primary me-2"></i>Form Pengajuan Pinjaman Uang
                </h6>
            </div>
            <div class="card-body p-4">
                <form id="form-peminjaman-uang">
                    @csrf

                    <!-- Dropdown Anggota / Peserta -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Anggota <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-peserta" id="pinjam_anggota_id" name="anggota_id" required>
                            <option value=""></option>
                            @foreach($peserta as $p)
                            <option value="{{ $p->id_kop_master_peserta }}"
                                data-code="{{ $p->kop_master_peserta_code }}"
                                data-nip="{{ $p->kop_master_peserta_nip }}">
                                [{{ $p->kop_master_peserta_code }}] {{ $p->kop_master_peserta_name }} - NIP: {{ $p->kop_master_peserta_nip ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tujuan & Tanggal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjaman" class="form-label fw-bold small">Tgl. Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_pinjaman" name="tanggal_pinjaman" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tujuan_pinjaman" class="form-label fw-bold small">Tujuan Pinjaman</label>
                            <input type="text" class="form-control form-control-sm" id="tujuan_pinjaman" name="tujuan_pinjaman" placeholder="Misal: Biaya Pendidikan, Renovasi">
                        </div>
                    </div>

                    <hr class="text-muted my-3">

                    <!-- Komponen Finansial Pinjaman -->
                    <div class="mb-3">
                        <label for="jumlah_pinjaman" class="form-label fw-bold small">Jumlah Pinjaman (Pokok) <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" class="form-control rupiah-input fw-bold text-primary" id="jumlah_pinjaman" name="jumlah_pinjaman" placeholder="0" required>
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Nominal plafon pinjaman yang disetujui.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pinjam_biaya_admin" class="form-label fw-bold small">Biaya Admin</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="pinjam_biaya_admin" name="pinjam_biaya_admin" value="0">
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">Dipotong di awal dari pencairan.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pinjam_bunga_koperasi" class="form-label fw-bold small">Total Bunga/Margin</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="pinjam_bunga_koperasi" name="pinjam_bunga_koperasi" value="0">
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">Margin keuntungan dicicil.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pinjam_tenor_bulan" class="form-label fw-bold small">Tenor / Jangka Waktu <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <select class="form-select" id="pinjam_tenor_bulan" name="tenor_bulan" required>
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6" selected>6 Bulan</option>
                                <option value="12">12 Bulan</option>
                                <option value="18">18 Bulan</option>
                                <option value="24">24 Bulan</option>
                                <option value="36">36 Bulan</option>
                            </select>
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>

                    <!-- Pengaturan Akun COA Jurnal -->
                    <!-- Pengaturan Akun COA Jurnal -->
                    <div class="border rounded p-3 bg-light mb-3">
                        <h6 class="fw-bold mb-2 text-dark small"><i class="fas fa-book me-1"></i> Pemetaan Akun Jurnal (Double Entry)</h6>

                        <!-- COA Piutang -->
                        <div class="mb-2">
                            <label class="form-label small mb-1">COA Piutang (Debet)</label>
                            <select class="form-select form-select-sm select2-coa-pinjam" id="pinjam_coa_piutang" name="coa_piutang">
                                <option value=""></option>
                                @foreach($coaList as $coa)
                                <option value="{{ $coa->coa_code }}" {{ str_contains(strtolower($coa->coa_name), 'piutang') ? 'selected' : '' }}>
                                    {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- COA Kas/Bank -->
                        <div class="mb-2">
                            <label class="form-label small mb-1">COA Kas/Bank Pencairan (Kredit Netto)</label>
                            <select class="form-select form-select-sm select2-coa-pinjam" id="pinjam_sumber_dana_coa" name="sumber_dana_coa">
                                <option value=""></option>
                                @foreach($coaList as $coa)
                                <option value="{{ $coa->coa_code }}" {{ (str_contains(strtolower($coa->coa_name), 'kas') || str_contains(strtolower($coa->coa_name), 'bank')) ? 'selected' : '' }}>
                                    {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <!-- COA Pendapatan Admin -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label small mb-1">COA Pend. Admin</label>
                                <select class="form-select form-select-sm select2-coa-pinjam" id="pinjam_coa_pendapatan_admin" name="coa_pendapatan_admin">
                                    <option value=""></option>
                                    @foreach($coaList as $coa)
                                    <option value="{{ $coa->coa_code }}" {{ str_contains(strtolower($coa->coa_name), 'admin') ? 'selected' : '' }}>
                                        {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- COA Pendapatan Bunga -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label small mb-1">COA Pend. Bunga</label>
                                <select class="form-select form-select-sm select2-coa-pinjam" id="pinjam_coa_pendapatan_bunga" name="coa_pendapatan_bunga">
                                    <option value=""></option>
                                    @foreach($coaList as $coa)
                                    <option value="{{ $coa->coa_code }}" {{ (str_contains(strtolower($coa->coa_name), 'bunga') || str_contains(strtolower($coa->coa_name), 'margin')) ? 'selected' : '' }}>
                                        {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-kalkulasi-pinjaman" class="btn btn-primary w-100 fw-bold shadow-sm">
                        <i class="fas fa-calculator me-1"></i> Hitung Simulasi & Draf
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- HASIL SIMULASI & PROYEKSI ANGSURAN -->
    <div class="col-lg-7 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-chart-line text-success me-2"></i>Ringkasan Pencairan & Schedule Angsuran
                </h6>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <!-- Box Indikator Ringkasan Finansial -->
                <div class="row g-2 mb-3">
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <span class="d-block text-muted small">Pencairan Netto</span>
                            <strong id="lbl-pinjam-pencairan-netto" class="text-success fs-2 font-monospace">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <span class="d-block text-muted small">Total Piutang</span>
                            <strong id="lbl-pinjam-total-piutang" class="text-primary fs-2 font-monospace">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <span class="d-block text-muted small">Tenor</span>
                            <strong id="lbl-pinjam-tenor" class="text-dark fs-2 font-monospace">0 Bln</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <span class="d-block text-muted small">Cicilan / Bln</span>
                            <strong id="lbl-pinjam-cicilan-bulanan" class="text-danger fs-2 font-monospace">Rp 0</strong>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Jurnal Pencairan Awal -->
                <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                    <h6 class="fw-bold small mb-2 text-secondary"><i class="fas fa-balance-scale me-1"></i> Draft Jurnal Pencairan Pinjaman (Awal)</h6>
                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.8rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Akun / Rekening</th>
                                <th class="text-end">Debet</th>
                                <th class="text-end">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>[Debet] Piutang Pinjaman Anggota</td>
                                <td class="text-end font-monospace fw-bold text-success" id="j-pinjam-debit-piutang">Rp 0</td>
                                <td class="text-end font-monospace text-muted">Rp 0</td>
                            </tr>
                            <tr>
                                <td>[Kredit] Kas/Bank Koperasi (Cair Netto)</td>
                                <td class="text-end font-monospace text-muted">Rp 0</td>
                                <td class="text-end font-monospace fw-bold text-danger" id="j-pinjam-kredit-kas">Rp 0</td>
                            </tr>
                            <tr>
                                <td>[Kredit] Pendapatan Biaya Admin</td>
                                <td class="text-end font-monospace text-muted">Rp 0</td>
                                <td class="text-end font-monospace fw-bold text-dark" id="j-pinjam-kredit-admin">Rp 0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Jadwal Tenor -->
                <div class="table-responsive border rounded mb-3 flex-grow-1" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.825rem;">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-3">Angsuran</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Pokok</th>
                                <th class="text-end">Bunga</th>
                                <th class="text-end pe-3">Total Angsuran</th>
                            </tr>
                        </thead>
                        <tbody id="simulasi-pinjaman-tenor-tbody">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Klik tombol <strong>Hitung Simulasi</strong> untuk melihat rincian angsuran.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Terbitkan Kontrak -->
                <button type="button" id="btn-submit-final-pinjaman" class="btn btn-success w-100 fw-bold py-2 shadow-sm d-none">
                    <i class="fas fa-check-circle me-1"></i> Konfirmasi & Terbitkan Akad Pinjaman
                </button>

            </div>
        </div>
    </div>
</div>

<!-- LOG & RIWAYAT TRANSAKSI PEMINJAMAN UANG -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-history text-secondary me-2 fs-5"></i>
                        <h5 class="card-title mb-0 fw-bold text-dark">Log Akad Pinjaman & Status Tenor</h5>
                    </div>
                    <!-- Filter Status -->
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-status-pinjaman" class="form-label mb-0 fw-bold text-secondary small">Filter Status:</label>
                        <select id="filter-status-pinjaman" class="form-select form-select-sm" style="width: 160px;">
                            <option value="">Semua Status</option>
                            <option value="DRAFT">DRAFT</option>
                            <option value="BELUM_LUNAS">BELUM LUNAS</option>
                            <option value="LUNAS">LUNAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="table-log-pinjaman" class="table table-hover align-middle mb-0 w-100" style="font-size: 0.875rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No. Nota / Akad</th>
                                <th>Peserta Koperasi</th>
                                <th>Tujuan</th>
                                <th class="text-end">Plafon Pinjaman</th>
                                <th class="text-end">Biaya Admin</th>
                                <th class="text-end">Pencairan Netto</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-end">Cicilan / Bln</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
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
                                <td>{{ $row->tujuan_pinjaman ?? '-' }}</td>
                                <td class="text-end font-monospace fw-semibold">Rp {{ number_format($row->jumlah_pinjaman, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace text-muted">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace text-success fw-bold">Rp {{ number_format($row->pencairan_netto, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace fw-semibold text-primary">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $row->tenor_bulan }} Bulan</span></td>
                                <td class="text-end font-monospace fw-bold text-danger">Rp {{ number_format($row->cicilan_per_bulan, 0, ',', '.') }}</td>

                                <!-- Status Tagihan -->
                                <td class="text-center">
                                    @if(strtoupper(trim($row->status_tagihan)) == 'DRAFT')
                                    <span class="badge bg-secondary">DRAFT</span>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'LUNAS')
                                    <span class="badge bg-success">LUNAS</span>
                                    @else
                                    <span class="badge bg-warning text-dark">{{ $row->status_tagihan }}</span>
                                    @endif
                                </td>

                                <!-- Action Button (Kirim WA untuk DRAFT) -->
                                <td class="text-center">
                                    @if(strtoupper(trim($row->status_tagihan)) == 'DRAFT')
                                    @php
                                    $phone = preg_replace('/[^0-9]/', '', $row->peserta_hp ?? '');
                                    if (str_starts_with($phone, '0')) {
                                    $phone = '62' . substr($phone, 1);
                                    }

                                    $pesanWA = "Halo *" . $row->kop_master_peserta_name . "*,\n\n"
                                    . "Berikut draf pengajuan peminjaman uang Anda di Koperasi:\n"
                                    . "- *No. Akad:* " . $row->nota_nomor . "\n"
                                    . "- *Plafon Pinjaman:* Rp " . number_format($row->jumlah_pinjaman, 0, ',', '.') . "\n"
                                    . "- *Pencairan Netto:* Rp " . number_format($row->pencairan_netto, 0, ',', '.') . "\n"
                                    . "- *Tenor:* " . $row->tenor_bulan . " Bulan\n"
                                    . "- *Cicilan/Bln:* Rp " . number_format($row->cicilan_per_bulan, 0, ',', '.') . "\n\n"
                                    . "Mohon konfirmasi jika persetujuan akad sudah sesuai. Terima kasih!";
                                    @endphp

                                    <a href="https://wa.me/{{ $phone }}?text={{ urlencode($pesanWA) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 shadow-sm">
                                        <i class="fab fa-whatsapp fs-6"></i>
                                        <span>Kirim WA</span>
                                    </a>
                                    @else
                                    <span class="text-muted small">-</span>
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
<!-- SweetAlert2, Select2, & DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {

        // DataTables Init
        let logPinjamanTable = $('#table-log-pinjaman').DataTable({
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(disaring dari total _MAX_ data)",
                zeroRecords: "Data pinjaman tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            pageLength: 10,
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [9, 10]
            }]
        });

        // Filter Status Dropdown
        $('#filter-status-pinjaman').on('change', function() {
            let selectedStatus = $(this).val();
            if (selectedStatus) {
                logPinjamanTable.column(9).search('^' + selectedStatus + '$', true, false).draw();
            } else {
                logPinjamanTable.column(9).search('').draw();
            }
        });

        // Select2 Init
        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta-pinjam').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Cari NIP, Code, atau Nama Peserta...',
                allowClear: true
            });

            $('.select2-coa-pinjam').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Helpers
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

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

        function cleanNumber(value) {
            if (!value) return 0;
            return parseFloat(value.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }
        // Masking Realtime
        $(document).on('keyup input', '.rupiah-input', function() {
            let formatted = formatNumberThousand($(this).val());
            $(this).val(formatted);
        });

        // Kalkulasi Simulasi
        $('#btn-kalkulasi-pinjaman').on('click', function() {
            let anggota = $('#pinjam_anggota_id').val();
            let tgl = $('#tanggal_pinjaman').val();

            let jumlahPinjaman = cleanNumber($('#jumlah_pinjaman').val());
            let biayaAdmin = cleanNumber($('#pinjam_biaya_admin').val());
            let bungaKoperasi = cleanNumber($('#pinjam_bunga_koperasi').val());
            let tenor = parseInt($('#pinjam_tenor_bulan').val()) || 1;

            let coaPiutang = $('#pinjam_coa_piutang').val();
            let bankCoa = $('#pinjam_sumber_dana_coa').val();
            let coaAdmin = $('#pinjam_coa_pendapatan_admin').val();
            let coaBunga = $('#pinjam_coa_pendapatan_bunga').val();
            if (!anggota || jumlahPinjaman <= 0) {
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Pastikan Anda telah memilih peserta dan menginput nominal pengajuan pinjaman.',
                    icon: 'warning'
                });
                return;
            }

            if (!coaPiutang || !bankCoa || !coaAdmin || !coaBunga) {
                Swal.fire({
                    title: 'COA Jurnal Belum Dipilih',
                    text: 'Silahkan tentukan Akun Piutang Pinjaman, Kas/Bank, Admin, dan Bunga pada tabel Draft Jurnal.',
                    icon: 'warning'
                });
                return;
            }
            let pencairanNetto = jumlahPinjaman - biayaAdmin;
            let totalPiutangPengembalian = jumlahPinjaman + bungaKoperasi;
            let cicilanPerBulan = Math.round(totalPiutangPengembalian / tenor);
            let pokokPerBulan = Math.floor(jumlahPinjaman / tenor);
            let sisaPokokAkhir = jumlahPinjaman - (pokokPerBulan * tenor);

            let bungaPerBulan = Math.floor(bungaKoperasi / tenor);
            let sisaBungaAkhir = bungaKoperasi - (bungaPerBulan * tenor);

            $('#lbl-pinjam-pencairan-netto').text(formatRupiah(pencairanNetto));
            $('#lbl-pinjam-total-piutang').text(formatRupiah(totalPiutangPengembalian));
            $('#lbl-pinjam-tenor').text(tenor + ' Bln');
            $('#lbl-pinjam-cicilan-bulanan').text(formatRupiah(cicilanPerBulan));

            $('#j-pinjam-debit-piutang').text(formatRupiah(jumlahPinjaman));
            $('#j-pinjam-kredit-kas').text(formatRupiah(pencairanNetto));
            $('#j-pinjam-kredit-admin').text(formatRupiah(biayaAdmin));

            let htmlTimeline = '';
            let startDate = new Date(tgl);

            for (let i = 1; i <= tenor; i++) {
                let dueDate = new Date(startDate.getTime());
                dueDate.setMonth(startDate.getMonth() + i);

                let day = dueDate.getDate().toString().padStart(2, '0');
                let month = (dueDate.getMonth() + 1).toString().padStart(2, '0');
                let year = dueDate.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                let currentPokok = (i === tenor) ? (pokokPerBulan + sisaPokokAkhir) : pokokPerBulan;
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

            $('#simulasi-pinjaman-tenor-tbody').html(htmlTimeline);
            $('#btn-submit-final-pinjaman').removeClass('d-none');
        });

        // Submit Form via AJAX
        $('#btn-submit-final-pinjaman').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pinjaman',
                text: "Kontrak peminjaman uang ini akan diterbitkan. Jadwal tagihan angsuran bulanan peserta akan langsung diaktifkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Terbitkan Kontrak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Kontrak Pinjaman',
                        text: 'Silahkan tunggu, sistem sedang memproses akad & pencairan...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let payloadData = {};
                    let rawArray = $('#form-peminjaman-uang').serializeArray();

                    $.each(rawArray, function(_, field) {
                        if (['jumlah_pinjaman', 'pinjam_biaya_admin', 'pinjam_bunga_koperasi'].includes(field.name)) {
                            payloadData[field.name] = cleanNumber(field.value);
                        } else {
                            payloadData[field.name] = field.value;
                        }
                    });

                    $.ajax({
                        url: `{{ route('menu_koperasi_peminjaman_uang_anggota_save') }}`,
                        type: "POST",
                        data: payloadData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                if (response.wa_url) {
                                    Swal.fire({
                                        title: 'Berhasil Disimpan!',
                                        text: response.message,
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#25D366',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: '<i class="fab fa-whatsapp me-1"></i> Kirim Notifikasi WA',
                                        cancelButtonText: 'Tutup'
                                    }).then((waResult) => {
                                        if (waResult.isConfirmed) {
                                            window.open(response.wa_url, '_blank');
                                        }
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            } else {
                                Swal.fire('Gagal Menyimpan', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMsg = 'Terjadi masalah koneksi ke server.';
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
@endsection
