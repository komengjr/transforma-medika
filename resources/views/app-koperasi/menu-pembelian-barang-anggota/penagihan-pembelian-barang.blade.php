<div class="row mb-4">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-primary border-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-hand-holding-usd fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Penagihan & Pembayaran Cicilan</h4>
                    <p class="text-muted mb-0 fs-6">Penerimaan setoran angsuran berkala atas pengadaan barang peserta koperasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- FILTER PENCARIAN NOTA -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body bg-light rounded p-3 shadow-inner">
                <form action="{{ route('menu_koperasi_penagihan_barang_anggota') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-7">
                        <label class="form-label fw-bold text-secondary">Cari Nota / Nama Kontrak Aktif</label>
                        <select class="form-select select2-nota" name="pembelian_id" id="pembelian_id" data-placeholder="-- Pilih Nota Pembelian / Nama Anggota --">
                            <option value=""></option>
                            @foreach($listNota as $n)
                            <option value="{{ $n->id_pembelian }}" {{ request('pembelian_id') == $n->id_pembelian ? 'selected' : '' }}>
                                {{ $n->nota_nomor }} - {{ $n->kop_master_peserta_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 d-grid d-sm-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold flex-grow-1">
                            <i class="fas fa-search me-2"></i>Buka Data Tagihan
                        </button>
                        <a href="{{ route('penagihan.anggota.index') }}" class="btn btn-outline-secondary px-3">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($kontrak)
    <!-- INFORMASI KONTRAK UTAMA -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white py-3">
                <h6 class="card-title mb-0 fw-bold"><i class="fas fa-file-contract me-2"></i>Resume Kontrak Piutang</h6>
            </div>
            <div class="card-body fs-6">
                <div class="mb-3 text-center border-bottom pb-2">
                    <small class="text-muted d-block font-monospace">NOMOR NOTA</small>
                    <span class="fs-5 fw-bold text-success font-monospace">{{ $kontrak->nota_nomor }}</span>
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td width="40%" class="text-muted">Nama Peserta</td>
                        <td width="5%">:</td>
                        <td class="fw-bold">{{ $kontrak->kop_master_peserta_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kode Peserta</td>
                        <td>:</td>
                        <td class="font-monospace fw-semibold">{{ $kontrak->kop_master_peserta_code }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Barang</td>
                        <td>:</td>
                        <td>{{ $kontrak->barang_nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Harga Modal</td>
                        <td>:</td>
                        <td class="font-monospace">Rp {{ number_format($kontrak->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Piutang</td>
                        <td>:</td>
                        <td class="font-monospace text-primary fw-bold">Rp {{ number_format($kontrak->total_piutang, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tenor Kontrak</td>
                        <td>:</td>
                        <td><span class="badge bg-secondary">{{ $kontrak->tenor_bulan }} Bulan</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Cicilan / Bln</td>
                        <td>:</td>
                        <td class="font-monospace text-success fw-bold fs-5">Rp {{ number_format($kontrak->cicilan_per_bulan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- PILIHAN KAS MASUK -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title mb-0 fw-bold text-dark"><i class="fas fa-boxes me-2 text-primary"></i>Destinasi Kas Koperasi</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label fw-bold text-secondary">Akun Kas/Bank Penerima <span class="text-danger">*</span></label>
                    <select class="form-select" id="sumber_dana_coa_pembayaran" required>
                        @foreach($bankCoa as $coa)
                        <option value="{{ $coa->coa_code }}">
                            [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <small class="text-muted form-text">Pilih akun tempat uang angsuran ini disimpan secara riil.</small>
            </div>
        </div>
    </div>

    <!-- TABEL JADWAL TENOR ANGSURAN (EKSEKUSI BAYAR) -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title mb-0 fw-bold text-dark"><i class="fas fa-list-ol me-2 text-warning"></i>Jadwal Cicilan & Aksi Pelunasan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 0.875rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Angsuran Ke</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Jumlah Tagihan</th>
                                <th class="text-center">Status</th>
                                <th>Tanggal Bayar</th>
                                <th class="pe-3 text-end">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailJadwal as $t)
                            <tr class="{{ $t->status_bayar == 'LUNAS' ? 'table-success bg-opacity-25' : '' }}">
                                <td class="ps-3 fw-bold text-secondary">Bulan Ke-{{ $t->angsuran_ke }}</td>
                                <td><i class="far fa-calendar-alt text-muted me-1"></i> {{ date('d-m-Y', strtotime($t->jatuh_tempo)) }}</td>
                                <td class="text-end font-monospace fw-bold">Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $t->status_bayar == 'LUNAS' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $t->status_bayar }}
                                    </span>
                                </td>
                                <td class="text-muted font-monospace">
                                    {{ $t->tanggal_bayar ? date('d-m-Y H:i', strtotime($t->tanggal_bayar)) : '-' }}
                                </td>
                                <td class="pe-3 text-end">
                                    @if($t->status_bayar == 'BELUM')
                                    <button type="button" class="btn btn-sm btn-success fw-bold btn-proses-bayar-cicilan" data-id="{{ $t->id_tenor }}" data-ke="{{ $t->angsuran_ke }}">
                                        <i class="fas fa-check-circle me-1"></i> Bayar
                                    </button>
                                    @else
                                    <span class="text-success"><i class="fas fa-check-double me-1"></i> Terverifikasi</span>
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
    @else
    <!-- STATE SAAT BELUM MEMILIH NOTA -->
    <div class="col-12">
        <div class="card border-0 shadow-sm py-5 text-center text-muted">
            <div class="card-body">
                <i class="fas fa-search-dollar fa-4x mb-3 text-black-50"></i>
                <h5>Silahkan pilih nomor nota pembiayaan peserta terlebih dahulu.</h5>
                <p class="mb-0 text-sm">Sistem akan memuat rincian jadwal jatuh tempo angsuran dan tombol eksekusi pelunasan.</p>
            </div>
        </div>
    </div>
    @endif
</div>
