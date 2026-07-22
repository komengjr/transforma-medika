@extends('layouts.layouts')

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-primary border-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-hand-holding-usd fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Penagihan & Pelunasan Cicilan</h4>
                    <p class="text-muted mb-0">Penerimaan setoran uang angsuran barang dari peserta koperasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- DROP DOWN FILTER NOTA -->
    <div class="col-12">
        <div class="card border border-primary shadow-sm bg-light p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label fw-bold text-secondary">Pilih Kontrak Nota Anggota Aktif</label>
                    <select class="form-select select2-nota" name="pembelian_id" id="filter_pembelian_id" data-placeholder="-- Pilih Nota Pembelian / Nama Anggota --">
                        <option value=""></option>
                        @foreach($listNota as $n)
                        <option value="{{ $n->id_pembelian }}">{{ $n->nota_nomor }} - {{ $n->kop_master_peserta_name }}</option>
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
            <!-- PANEL RESUME KONTRAK & PILIHAN KAS -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-dark text-white fw-bold py-3">
                        <i class="fas fa-file-contract me-2"></i>Detail Kontrak
                    </div>
                    <div class="card-body px-0">
                        <div class="mb-3 text-center border-bottom pb-2">
                            <small class="text-muted d-block font-monospace">NOMOR NOTA</small>
                            <span class="fs-2 fw-bold text-primary font-monospace" id="res-nota">-</span>
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
                                <td class="text-muted">Barang</td>
                                <td>:</td>
                                <td id="res-barang">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Harga Beli</td>
                                <td>:</td>
                                <td class="font-monospace fw-bold" id="res-harga-beli">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Biaya Admin</td>
                                <td>:</td>
                                <td class="font-monospace text-secondary" id="res-biaya-admin">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Bunga Koperasi</td>
                                <td>:</td>
                                <td class="font-monospace text-warning fw-bold" id="res-bunga-koperasi">-</td>
                            </tr>
                            <tr class="border-top">
                                <td class="text-muted fw-bold">Total Piutang</td>
                                <td>:</td>
                                <td class="font-monospace text-primary fw-bold fs-2" id="res-total">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Cicilan / Bln</td>
                                <td>:</td>
                                <td class="font-monospace text-success fw-bold fs-2" id="res-cicilan">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom fw-bold">
                        <i class="fas fa-university text-primary me-2"></i>Destinasi Pembayaran
                    </div>
                    <div class="card-body">
                        <label class="form-label fw-bold text-secondary">Simpan Uang Masuk Ke <span class="text-danger">*</span></label>
                        <select class="form-select" id="sumber_dana_coa_pembayaran">
                            <option value="">Pilih Dulu</option>
                            @foreach($bankCoa as $coa)
                            <option value="{{ $coa->coa_code }}">[{{ $coa->coa_code }}] {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">Akun Kas/Bank ini digunakan sebagai posisi Debet saat jurnal diterbitkan.</small>
                    </div>
                </div>
            </div>

            <!-- PANEL TABEL TENOR JADWAL -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold py-3 border-bottom d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-list-ol text-warning me-2"></i>Daftar Angsuran Bulanan</span>
                        <span class="badge bg-info text-dark font-monospace" id="res-tenor-badge">0 Bulan</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="table-jadwal-cicilan">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Angsuran</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end">Total Tagihan</th>
                                        <th class="text-center">Status</th>
                                        <th class="pe-3 text-end">Aksi</th>
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
                <h5>Silahkan pilih nomor nota pembiayaan peserta terlebih dahulu.</h5>
                <p class="mb-0 text-sm">Sistem akan memuat rincian data cicilan melalui API backend secara terpisah.</p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('base.js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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

        // Event handler ketika dropdown nota dipilih
        $('#filter_pembelian_id').on('change', function() {
            let id = $(this).val();
            if (!id) {
                resetView();
                return;
            }

            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil informasi rincian tenor angsuran',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX Call ke Controller Method Get Data
            $.ajax({
                url: `{{ url('koperasi/menu-koperasi/penagihan-barang-anggota/get-data') }}/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        let kontrak = response.kontrak;
                        let jadwal = response.jadwal;

                        // 1. Render Resume Data Kontrak
                        $('#res-nota').text(kontrak.nota_nomor ?? '-');
                        $('#res-nama').text(kontrak.kop_master_peserta_name ?? '-');
                        $('#res-kode').text(kontrak.kop_master_peserta_code ?? '-');
                        $('#res-barang').text(kontrak.barang_nama ?? '-');
                        $('#res-harga-beli').text(formatRupiah(kontrak.harga_beli));
                        $('#res-biaya-admin').text(formatRupiah(kontrak.biaya_admin));
                        $('#res-bunga-koperasi').text(formatRupiah(kontrak.bunga_koperasi));
                        $('#res-total').text(formatRupiah(kontrak.total_piutang));
                        $('#res-cicilan').text(formatRupiah(kontrak.cicilan_per_bulan));
                        $('#res-tenor-badge').text((kontrak.tenor_bulan ?? 0) + ' Bulan');

                        // 2. Render Baris Tabel Jadwal Cicilan
                        let html = '';
                        if (jadwal && jadwal.length > 0) {
                            jadwal.forEach(function(row) {
                                let isLunas = (row.status_bayar === 'LUNAS');
                                let rowClass = isLunas ? 'table-success bg-opacity-25' : '';
                                let badgeClass = isLunas ? 'bg-success' : (row.status_bayar === 'PARTIAL' ? 'bg-info text-dark' : 'bg-warning text-dark');

                                // Perhitungan Bunga dan Pokok Tagihan
                                let bunga = parseFloat(row.bunga_tagihan ?? 0);
                                let totalTagihan = parseFloat(row.jumlah_tagihan ?? 0);
                                let pokokTagihan = totalTagihan - bunga;

                                let actionBtn = isLunas ?
                                    `<span class="text-success fw-bold"><i class="fas fa-check-double me-1"></i> Lunas</span>` :
                                    `<button class="btn btn-sm btn-success fw-bold btn-proses-bayar shadow-sm"
                                            data-id="${row.id}"
                                            data-ke="${row.angsuran_ke}"
                                            data-nominal="${formatRupiah(totalTagihan)}">
                                        <i class="fas fa-check-circle me-1"></i> Bayar
                                    </button>`;

                                html += `
                                    <tr class="${rowClass}">
                                        <td class="ps-3 fw-bold text-secondary">Bulan Ke-${row.angsuran_ke}</td>
                                        <td><i class="far fa-calendar-alt text-muted me-1"></i> ${formatTanggal(row.jatuh_tempo)}</td>
                                        <td class="text-end font-monospace text-muted">${formatRupiah(pokokTagihan)}</td>
                                        <td class="text-end font-monospace text-warning fw-bold">${formatRupiah(bunga)}</td>
                                        <td class="text-end font-monospace fw-bold text-primary">${formatRupiah(totalTagihan)}</td>
                                        <td class="text-center"><span class="badge ${badgeClass}">${row.status_bayar}</span></td>
                                        <td class="text-end pe-3">${actionBtn}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada rincian jadwal tenor untuk kontrak ini.</td></tr>`;
                        }

                        $('#table-jadwal-cicilan tbody').html(html);

                        // Switch Visibility
                        $('#section-placeholder-kosong').addClass('d-none');
                        $('#section-detail-penagihan').removeClass('d-none');
                    } else {
                        Swal.fire('Perhatian', response.message || 'Gagal memuat data', 'warning');
                        resetView();
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat detail data cicilan anggota.';
                    Swal.fire('Error', msg, 'error');
                    resetView();
                }
            });
        });

        // Event Handler Eksekusi Pelunasan Pembayaran Cicilan
        $(document).on('click', '.btn-proses-bayar', function() {
            let id = $(this).data('id');
            let ke = $(this).data('ke');
            let nominal = $(this).data('nominal');
            let coa = $('#sumber_dana_coa_pembayaran').val();

            if (!coa) {
                Swal.fire('Perhatian', 'Silahkan pilih Akun Kas/Bank Penerima terlebih dahulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Terima setoran angsuran Bulan Ke-${ke} sebesar ${nominal}? Jurnal penerimaan kas akan otomatis diterbitkan.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Bayar Sekarang',
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
                        url: "{{ route('menu_koperasi_penagihan_barang_anggota_save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tenor: id,
                            sumber_dana_coa: coa
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status === 'success') {
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    $('#filter_pembelian_id').trigger('change');
                                });
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan sistem saat memproses pembayaran.';
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
        }

        // Event Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#filter_pembelian_id').val('').trigger('change');
        });
    });
</script>
@endsection
