@extends('layouts.layouts')

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-hand-holding-usd fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Penagihan & Pelunasan Cicilan Peminjaman Uang</h4>
                    <p class="text-muted mb-0">Penerimaan setoran angsuran pinjaman tunai dari peserta koperasi (Multi-Pembayaran)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- DROP DOWN FILTER NOTA PINJAMAN -->
    <div class="col-12">
        <div class="card border border-success shadow-sm bg-light p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label fw-bold text-secondary">Pilih Kontrak Nota Pinjaman Anggota Aktif</label>
                    <select class="form-select select2-nota" name="peminjaman_id" id="filter_peminjaman_id" data-placeholder="-- Pilih Nota Pinjaman / Nama Anggota --">
                        <option value=""></option>
                        @foreach($listNota as $n)
                        <option value="{{ $n->id_peminjaman }}">{{ $n->nota_nomor }} - {{ $n->kop_master_peserta_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" class="btn btn-secondary fw-bold py-2" id="btn-reset-filter">
                        <i class="fas fa-undo me-1"></i> Reset Pencarian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- WRAPPER KONTEN DINAMIS (Awalnya Tersembunyi) -->
    <div class="col-12 d-none" id="section-detail-penagihan">
        <div class="row g-3">
            <!-- PANEL RESUME KONTRAK & RINGKASAN PEMBAYARAN MULTI -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-dark text-white fw-bold py-3">
                        <i class="fas fa-file-contract me-2"></i>Detail Kontrak Pinjaman
                    </div>
                    <div class="card-body px-0">
                        <div class="mb-3 text-center border-bottom pb-2">
                            <small class="text-muted d-block font-monospace">NOMOR NOTA</small>
                            <span class="fs-2 fw-bold text-success font-monospace" id="res-nota">-</span>
                        </div>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="42%" class="text-muted">Nama Peserta</td>
                                <td width="3%">:</td>
                                <td class="fw-bold" id="res-nama">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kode Peserta</td>
                                <td>:</td>
                                <td class="font-monospace" id="res-kode">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Plafon Pinjaman</td>
                                <td>:</td>
                                <td class="font-monospace fw-bold text-primary" id="res-plafon">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jasa / Bunga</td>
                                <td>:</td>
                                <td class="font-monospace text-warning fw-bold" id="res-bunga">-</td>
                            </tr>
                            <tr class="border-top">
                                <td class="text-muted fw-bold">Total Piutang</td>
                                <td>:</td>
                                <td class="font-monospace text-success fw-bold fs-2" id="res-total">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Cicilan / Bln</td>
                                <td>:</td>
                                <td class="font-monospace text-dark fw-bold fs-2" id="res-cicilan">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom fw-bold">
                        <i class="fas fa-calculator text-success me-2"></i>Ringkasan & Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Simpan Uang Masuk Ke <span class="text-danger">*</span></label>
                            <select class="form-select" id="sumber_dana_coa_pembayaran">
                                <option value="">-- Pilih Akun Kas / Bank --</option>
                                @foreach($bankCoa as $coa)
                                <option value="{{ $coa->coa_code }}">[{{ $coa->coa_code }}] {{ $coa->coa_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-light p-3 rounded mb-3 border">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Bulan Dipilih:</span>
                                <span class="fw-bold font-monospace" id="label-total-bulan">0 Bulan</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-bold">Total Bayar:</span>
                                <span class="fs-4 fw-bold text-success font-monospace" id="label-total-nominal">Rp 0</span>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-success fw-bold py-2 shadow-sm" id="btn-proses-multi-bayar" disabled>
                                <i class="fas fa-check-double me-1"></i> Proses Pembayaran Multi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL TABEL TENOR JADWAL -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold py-3 border-bottom d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-list-ol text-warning me-2"></i>Daftar Angsuran Pinjaman</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                            <label class="form-check-label fw-semibold text-secondary small" for="select-all-checkbox">Pilih Semua Belum Lunas</label>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="table-jadwal-cicilan">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 text-center" width="5%">Pilih</th>
                                        <th>Angsuran</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end">Total Tagihan</th>
                                        <th class="text-center pe-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Diisi secara dinamis via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PLACEHOLDER STATE KOSONG -->
    <div class="col-12" id="section-placeholder-kosong">
        <div class="card border-0 shadow-sm py-5 text-center text-muted">
            <div class="card-body">
                <i class="fas fa-search-dollar fa-4x mb-3 text-black-50"></i>
                <h5>Silahkan pilih nomor nota pembiayaan pinjaman peserta terlebih dahulu.</h5>
                <p class="mb-0 text-sm">Sistem akan memuat rincian data cicilan peminjaman uang melalui API backend secara terpisah.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2-nota').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Helper Format Currency Rupiah
        function formatRupiah(angka) {
            if (angka === null || angka === undefined) return 'Rp 0';
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
        }

        // Helper Format Tanggal Indonesia
        function formatTanggal(stringTanggal) {
            if (!stringTanggal) return '-';
            let date = new Date(stringTanggal);
            if (isNaN(date.getTime())) return stringTanggal;
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Kalkulasi Total saat Checkbox Berubah
        function hitungTotalPilihan() {
            let totalNominal = 0;
            let totalBulan = 0;

            $('.checkbox-tenor:checked').each(function() {
                totalNominal += parseFloat($(this).data('nominal') || 0);
                totalBulan++;
            });

            $('#label-total-bulan').text(totalBulan + ' Bulan');
            $('#label-total-nominal').text(formatRupiah(totalNominal));

            if (totalBulan > 0) {
                $('#btn-proses-multi-bayar').removeAttr('disabled');
            } else {
                $('#btn-proses-multi-bayar').attr('disabled', 'disabled');
            }
        }

        // Event handler ketika dropdown nota pinjaman dipilih
        $('#filter_peminjaman_id').on('change', function() {
            let id = $(this).val();
            if (!id) {
                resetView();
                return;
            }

            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil informasi rincian tenor angsuran pinjaman',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX Call ke Controller Method Get Data Pinjaman
            $.ajax({
                url: `{{ url('koperasi/menu-koperasi/penagihan-peminjaman/get-data') }}/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        let kontrak = response.kontrak;
                        let jadwal = response.jadwal;

                        // 1. Render Resume Data Kontrak Pinjaman
                        $('#res-nota').text(kontrak.nota_nomor ?? '-');
                        $('#res-nama').text(kontrak.kop_master_peserta_name ?? '-');
                        $('#res-kode').text(kontrak.kop_master_peserta_code ?? '-');
                        $('#res-plafon').text(formatRupiah(kontrak.jumlah_pinjaman ?? kontrak.plafon));
                        $('#res-bunga').text(formatRupiah(kontrak.total_bunga ?? kontrak.bunga));
                        $('#res-total').text(formatRupiah(kontrak.total_piutang));
                        $('#res-cicilan').text(formatRupiah(kontrak.cicilan_per_bulan));

                        // 2. Render Baris Tabel Jadwal Cicilan Pinjaman dengan Checkbox
                        let html = '';
                        if (jadwal && jadwal.length > 0) {
                            jadwal.forEach(function(row) {
                                let isLunas = (row.status_bayar === 'LUNAS');
                                let rowClass = isLunas ? 'table-success bg-opacity-25' : '';
                                let badgeClass = isLunas ? 'bg-success' : 'bg-warning text-dark';

                                let bunga = parseFloat(row.bunga_tagihan ?? 0);
                                let totalTagihan = parseFloat(row.jumlah_tagihan ?? 0);
                                let pokokTagihan = totalTagihan - bunga;

                                let checkboxInput = isLunas ?
                                    `<span class="text-success"><i class="fas fa-check-double"></i></span>` :
                                    `<input class="form-check-input checkbox-tenor shadow-sm" type="checkbox" value="${row.id}" data-nominal="${totalTagihan}">`;

                                html += `
                                    <tr class="${rowClass}">
                                        <td class="ps-3 text-center">${checkboxInput}</td>
                                        <td class="fw-bold text-secondary">Bulan Ke-${row.angsuran_ke}</td>
                                        <td><i class="far fa-calendar-alt text-muted me-1"></i> ${formatTanggal(row.jatuh_tempo)}</td>
                                        <td class="text-end font-monospace text-muted">${formatRupiah(pokokTagihan)}</td>
                                        <td class="text-end font-monospace text-warning fw-bold">${formatRupiah(bunga)}</td>
                                        <td class="text-end font-monospace fw-bold text-success">${formatRupiah(totalTagihan)}</td>
                                        <td class="text-center pe-3"><span class="badge ${badgeClass}">${row.status_bayar}</span></td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada rincian jadwal tenor untuk kontrak pinjaman ini.</td></tr>`;
                        }

                        $('#table-jadwal-cicilan tbody').html(html);
                        $('#select-all-checkbox').prop('checked', false);
                        hitungTotalPilihan();

                        // Switch Visibility
                        $('#section-placeholder-kosong').addClass('d-none');
                        $('#section-detail-penagihan').removeClass('d-none');
                    } else {
                        Swal.fire('Perhatian', response.message || 'Gagal memuat data pinjaman', 'warning');
                        resetView();
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat detail data cicilan peminjaman uang.';
                    Swal.fire('Error', msg, 'error');
                    resetView();
                }
            });
        });

        // Event Checkbox Pilih Semua
        $(document).on('change', '#select-all-checkbox', function() {
            $('.checkbox-tenor:not(:disabled)').prop('checked', this.checked);
            hitungTotalPilihan();
        });

        // Event Checkbox Satuan Berubah
        $(document).on('change', '.checkbox-tenor', function() {
            hitungTotalPilihan();
        });

        // Event Handler Eksekusi Pelunasan Multi Pembayaran
        $('#btn-proses-multi-bayar').on('click', function() {
            let coa = $('#sumber_dana_coa_pembayaran').val();
            if (!coa) {
                Swal.fire('Perhatian', 'Silahkan pilih Akun Kas/Bank Penerima terlebih dahulu!', 'warning');
                return;
            }

            let selectedIds = [];
            $('.checkbox-tenor:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire('Perhatian', 'Pilih minimal satu bulan angsuran yang ingin dilunasi!', 'warning');
                return;
            }

            let totalBulanStr = $('#label-total-bulan').text();
            let totalNominalStr = $('#label-total-nominal').text();

            Swal.fire({
                title: 'Konfirmasi Pembayaran Multi',
                text: `Proses pelunasan sebanyak ${totalBulanStr} dengan total sebesar ${totalNominalStr}? Jurnal penerimaan kas akan diterbitkan otomatis.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Proses Bayar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Pembayaran...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('menu_koperasi_approval_penagihan_peminjaman_uang_anggota_save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tenors: selectedIds,
                            sumber_dana_coa: coa
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status === 'success') {
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    $('#filter_peminjaman_id').trigger('change');
                                });
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan sistem saat memproses pembayaran pinjaman.';
                            Swal.fire('Error!', msg, 'error');
                        }
                    });
                }
            });
        });

        // Function Reset Tampilan Ke Placeholder
        function resetView() {
            $('#section-detail-penagihan').addClass('d-none');
            $('#section-placeholder-kosong').removeClass('d-none');
            $('#table-jadwal-cicilan tbody').html('');
            $('#label-total-bulan').text('0 Bulan');
            $('#label-total-nominal').text('Rp 0');
            $('#btn-proses-multi-bayar').attr('disabled', 'disabled');
        }

        // Event Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#filter_peminjaman_id').val('').trigger('change');
        });
    });
</script>
@endsection
