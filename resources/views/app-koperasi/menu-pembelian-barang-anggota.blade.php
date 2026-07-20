@extends('layouts.layouts')

@section('content')
<!-- HEADER PAGE -->
<div class="row mb-4">
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
<div class="row g-4">
    <!-- FORM INPUT PENGADAAN BARANG -->
    <div class="col-xl-5 col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cart-plus text-success me-2 fs-5"></i>
                    <h5 class="card-title mb-0 fw-bold text-dark">Form Input Transaksi</h5>
                </div>
            </div>
            <div class="card-body py-4">
                <form id="form-pembelian-barang">
                    <input type="hidden" name="_token" value="{{ csrf_token() ?? '' }}">

                    <!-- Pilih Peserta (Menggunakan Select2 untuk kemudahan search) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Pilih Peserta Koperasi <span class="text-danger">*</span></label>
                        <select class="form-select select2-peserta" name="anggota_id" id="anggota_id" data-placeholder="Cari NIP, NIK atau Nama Peserta..." required>
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
                            <input type="number" class="form-control fw-bold font-monospace fs-5 text-dark" name="harga_beli" id="harga_beli" placeholder="0" min="1" required>
                        </div>
                        <div class="form-text text-muted">Nilai uang tunai yang dikeluarkan koperasi ke supplier.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Margin / Keuntungan Koperasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                            <input type="number" class="form-control font-monospace text-dark" name="margin_koperasi" id="margin_koperasi" value="0" min="0">
                        </div>
                        <div class="form-text text-muted">Nilai keuntungan flat koperasi yang dibebankan ke anggota.</div>
                    </div>

                    <!-- Pembayaran Vendor & Tenor -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-bold text-secondary">Sumber Dana Koperasi <span class="text-danger">*</span></label>
                            <select class="form-select" name="sumber_dana_coa" id="sumber_dana_coa" required>
                                <option value="">-- Pilih Kas/Bank --</option>
                                @foreach($bankCoa as $coa)
                                <option value="{{ $coa->coa_code }}" data-name="{{ $coa->coa_name }}">
                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
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
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-success py-2.5 fw-bold" id="btn-kalkulasi-simulasi">
                            <i class="fas fa-calculator me-2"></i>Kalkulasi & Simulasikan Cicilan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LIVE SIMULASI DAN PRATINJAU JURNAL -->
    <div class="col-xl-7 col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-invoice-dollar text-primary me-2 fs-5"></i>
                    <h5 class="card-title mb-0 fw-bold text-dark">Lembar Simulasi & Proyeksi Jurnal</h5>
                </div>
            </div>
            <div class="card-body">
                <!-- Info Box Kanan -->
                <div class="row g-3 text-center mb-4">
                    <div class="col-sm-4">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Total Piutang</small>
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
                            <small class="text-success fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Tagihan / Bulan</small>
                            <span class="fw-bold text-white font-monospace fs-2" id="lbl-cicilan-bulanan">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Jurnal Akuntansi -->
                <div class="mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-balance-scale me-2 text-info"></i>1. Draft Otomatis Jurnal Akuntansi</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered bg-light align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-dark">
                                <tr>
                                    <th width="15%">Kode COA</th>
                                    <th width="45%">Nama Rekening Jurnal</th>
                                    <th width="20%" class="text-end">Debit</th>
                                    <th width="20%" class="text-end">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-secondary">121-0001</td>
                                    <td>Piutang Pembelian Barang Anggota</td>
                                    <td class="text-end font-monospace text-success fw-bold" id="j-debit-piutang">Rp 0</td>
                                    <td class="text-end font-monospace text-muted">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary ps-3" id="j-coa-kas-code">11X-XXXX</td>
                                    <td class="ps-3 text-muted" id="j-coa-kas-name">↳ Kas / Bank Koperasi</td>
                                    <td class="text-end font-monospace text-muted">Rp 0</td>
                                    <td class="text-end font-monospace text-danger fw-bold" id="j-kredit-kas">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary ps-3">412-0005</td>
                                    <td class="ps-3 text-muted">↳ Pendapatan Margin Pembiayaan Barang</td>
                                    <td class="text-end font-monospace text-muted">Rp 0</td>
                                    <td class="text-end font-monospace text-danger fw-bold" id="j-kredit-margin">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Timeline Jadwal Angsuran -->
                <div>
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-calendar-alt me-2 text-warning"></i>2. Proyeksi Jadwal Angsuran Bulanan</h6>
                    <div class="table-responsive border rounded" style="max-height: 220px; overflow-y: auto;">
                        <table class="table table-sm table-striped table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light sticky-top shadow-sm">
                                <tr>
                                    <th class="ps-3">Angsuran Ke-</th>
                                    <th>Estimasi Jatuh Tempo</th>
                                    <th class="text-end pe-3">Jumlah Tagihan</th>
                                </tr>
                            </thead>
                            <tbody id="simulasi-tenor-tbody">
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
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

<!-- DATA TABEL RIWAYAT TRANSAKSI -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list text-secondary me-2 fs-5"></i>
                    <h5 class="card-title mb-0 fw-bold text-dark">Log Kontrak Pembelian Barang & Status Tenor</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 0.875rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No. Nota</th>
                                <th>Peserta Koperasi</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga Modal</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-end">Cicilan / Bln</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $row)
                            <tr>
                                <td class="ps-3 font-monospace fw-bold text-success">{{ $row->nota_nomor }}</td>
                                <td>
                                    <small class="text-muted d-block font-monospace">{{ $row->kop_master_peserta_code }}</small>
                                    <strong>{{ $row->kop_master_peserta_name }}</strong>
                                </td>
                                <td>{{ $row->barang_nama }}</td>
                                <td class="text-end font-monospace">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-end font-monospace fw-semibold text-primary">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $row->tenor_bulan }} Bulan</span></td>
                                <td class="text-end font-monospace fw-bold text-success">Rp {{ number_format($row->cicilan_per_bulan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $row->status_tagihan == 'LUNAS' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $row->status_tagihan }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada kontrak pengadaan barang peserta yang terdaftar.</td>
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

        // Inisialisasi Select2 untuk mempermudah pencarian nama peserta
        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                allowClear: true
            });
        }

        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
        }

        // Event Handler saat klik kalkulasi
        $('#btn-kalkulasi-simulasi').on('click', function() {
            let anggota = $('#anggota_id').val();
            let barang = $('#barang_nama').val();
            let tgl = $('#tanggal_transaksi').val();
            let hargaBeli = parseFloat($('#harga_beli').val()) || 0;
            let margin = parseFloat($('#margin_koperasi').val()) || 0;
            let tenor = parseInt($('#tenor_bulan').val()) || 1;

            let bankCoa = $('#sumber_dana_coa').val();
            let bankName = $('#sumber_dana_coa option:selected').data('name');

            if (!anggota || !barang || hargaBeli <= 0 || !bankCoa) {
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Pastikan Anda telah mengisi entitas peserta, nama barang, harga beli, dan akun kas asal koperasi.',
                    icon: 'warning'
                });
                return;
            }

            let totalPiutang = hargaBeli + margin;
            let cicilanPerBulan = Math.ceil(totalPiutang / tenor);

            // Tampilkan Ringkasan ke Info Box Atas
            $('#lbl-total-piutang').text(formatRupiah(totalPiutang));
            $('#lbl-tenor').text(tenor + ' Bln');
            $('#lbl-cicilan-bulanan').text(formatRupiah(cicilanPerBulan));

            // Tampilkan ke Draft Jurnal Akuntansi
            $('#j-debit-piutang').text(formatRupiah(totalPiutang));
            $('#j-coa-kas-code').text(bankCoa);
            $('#j-coa-kas-name').text('↳ ' + bankName);
            $('#j-kredit-kas').text(formatRupiah(hargaBeli));
            $('#j-kredit-margin').text(formatRupiah(margin));

            // Generate Timeline Jadwal Proyeksi Penagihan Bulanan
            let htmlTimeline = '';
            let dateObj = new Date(tgl);

            for (let i = 1; i <= tenor; i++) {
                // Majukan bulan untuk proyeksi tempo berikutnya
                dateObj.setMonth(dateObj.getMonth() + 1);

                let day = dateObj.getDate().toString().padStart(2, '0');
                let month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                let year = dateObj.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                htmlTimeline += `
                    <tr>
                        <td class="fw-semibold text-secondary ps-3">Angsuran Ke-${i}</td>
                        <td><i class="far fa-calendar-check me-2 text-muted"></i> ${formattedDate}</td>
                        <td class="text-end font-monospace fw-bold text-dark pe-3">${formatRupiah(cicilanPerBulan)}</td>
                    </tr>
                `;

                // Reset dateObj kembali ke baseline tgl awal lalu pasang kelipatan indeks agar lompatan bulan presisi
                dateObj = new Date(tgl);
                dateObj.setMonth(dateObj.getMonth() + i);
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

                    $.ajax({
                        url: `{{ route('menu_koperasi_pembelian_barang_anggota_save') }}`,
                        type: "POST",
                        data: $('#form-pembelian-barang').serialize(),
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
                            Swal.fire('Error Transaksi', 'Terjadi masalah interkoneksi ke database server koin/koperasi.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
