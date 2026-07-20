@extends('layouts.layouts')

@section('content')
<div class="row mb-4">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-primary border-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-3 me-3">
                    <i class="fas fa-hand-holding-usd fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Penagihan & Pelunasan Cicilan</h4>
                    <p class="text-muted mb-0 fs-2">Penerimaan setoran uang angsuran barang dari peserta koperasi</p>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- DROP DOWN FILTER NOTA -->
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-light p-3">
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
                    <button type="button" class="btn btn-secondary fw-bold py-2" id="btn-reset-filter">Reset Pencarian</button>
                </div>
            </div>
        </div>
    </div>

    <!-- WRAPPER KONTEN DINAMIS (Awalnya Tersembunyi) -->
    <div class="col-12 d-none" id="section-detail-penagihan">
        <div class="row g-4">
            <!-- PANEL RESUME KONTRAK -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white fw-bold">Detail Kontrak</div>
                    <div class="card-body" style="font-size: 0.9rem;">
                        <p class="mb-1"><strong>Nama:</strong> <span id="res-nama">-</span></p>
                        <p class="mb-1"><strong>Barang:</strong> <span id="res-barang">-</span></p>
                        <p class="mb-1"><strong>Total Piutang:</strong> <span id="res-total">-</span></p>
                        <p class="mb-0 text-success fs-2"><strong>Cicilan/Bln: <span id="res-cicilan">-</span></strong></p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <label class="form-label fw-bold">Simpan Uang Masuk Ke *</label>
                        <select class="form-select" id="sumber_dana_coa_pembayaran">
                            @foreach($bankCoa as $coa)
                            <option value="{{ $coa->coa_code }}">[{{ $coa->coa_code }}] {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- PANEL TABEL TENOR JADWAL -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold border-bottom">Daftar Angsuran Bulanan</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="table-jadwal-cicilan">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Aksi</th>
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
<!-- 3. Tema Bootstrap 5 untuk Select2 (Opsional, jika menggunakan tema bootstrap-5) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<script>
    $(document).ready(function() {
        $('.select2-nota').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
        }

        function formatTanggal(stringTanggal) {
            if (!stringTanggal) return '-';
            let date = new Date(stringTanggal);
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

            // Load data via route JSON yang baru dibuat
            $.ajax({
                url: `{{ url('koperasi/menu-koperasi/penagihan-barang-anggota/get-data') }}/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    if (response.status === 'success') {
                        let kontrak = response.kontrak;
                        let jadwal = response.jadwal;

                        // 1. Isi resume data kontrak
                        $('#res-nama').text(kontrak.kop_master_peserta_name);
                        $('#res-barang').text(kontrak.barang_nama);
                        $('#res-total').text(formatRupiah(kontrak.total_piutang));
                        $('#res-cicilan').text(formatRupiah(kontrak.cicilan_per_bulan));

                        // 2. Render baris tabel jadwal cicilan
                        let html = '';
                        jadwal.forEach(function(row) {
                            let isLunas = row.status_bayar === 'LUNAS';
                            let rowClass = isLunas ? 'table-success' : '';
                            let badgeClass = isLunas ? 'bg-success' : 'bg-warning text-dark';

                            let actionBtn = isLunas ?
                                `<span class="text-muted"><i class="fas fa-check-double text-success"></i> Lunas</span>` :
                                `<button class="btn btn-sm btn-success fw-bold btn-proses-bayar" data-id="${row.id_tenor}" data-ke="${row.angsuran_ke}">Bayar</button>`;

                            html += `
                                <tr class="${rowClass}">
                                    <td class="ps-3 fw-bold">Ke-${row.angsuran_ke}</td>
                                    <td>${formatTanggal(row.jatuh_tempo)}</td>
                                    <td class="text-end font-monospace">${formatRupiah(row.jumlah_tagihan)}</td>
                                    <td class="text-center"><span class="badge ${badgeClass}">${row.status_bayar}</span></td>
                                    <td class="text-end pe-3">${actionBtn}</td>
                                </tr>
                            `;
                        });

                        $('#table-jadwal-cicilan tbody').html(html);

                        // Tampilkan section konten dan sembunyikan placeholder kosong
                        $('#section-placeholder-kosong').addClass('d-none');
                        $('#section-detail-penagihan').removeClass('d-none');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat detail data cicilan anggota.', 'error');
                    resetView();
                }
            });
        });

        // Proses pelunasan pembayaran cicilan bulanan
        $(document).on('click', '.btn-proses-bayar', function() {
            let id = $(this).data('id');
            let ke = $(this).data('ke');
            let coa = $('#sumber_dana_coa_pembayaran').val();

            Swal.fire({
                title: 'Bayar Cicilan?',
                text: `Terima setoran angsuran ke-${ke}?`,
                icon: 'warning',
                showCancelButton: true
            }).then((r) => {
                if (r.isConfirmed) {
                    $.ajax({
                        url: "{{ route('menu_koperasi_penagihan_barang_anggota_save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tenor: id,
                            sumber_dana_coa: coa
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Sukses', res.message, 'success').then(() => {
                                    // Trigger ulang event change untuk me-refresh data tabel tanpa reload halaman penuh
                                    $('#filter_pembelian_id').trigger('change');
                                });
                            }
                        }
                    });
                }
            });
        });

        function resetView() {
            $('#section-detail-penagihan').addClass('d-none');
            $('#section-placeholder-kosong').removeClass('d-none');
            $('#table-jadwal-cicilan tbody').html('');
        }

        $('#btn-reset-filter').on('click', function() {
            $('#filter_pembelian_id').val('').trigger('change');
        });
    });
</script>
@endsection
