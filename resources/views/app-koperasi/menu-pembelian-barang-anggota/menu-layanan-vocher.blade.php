@extends('layouts.layouts')

@section('content')
<style>
    .btn-check:checked+.payment-card {
        border-color: #0d6efd !important;
        background-color: #f8fbff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.15) !important;
    }

    .payment-card {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .payment-card:hover {
        border-color: #b0c4de !important;
    }
</style>
<!-- Header Page -->
<div class="mb-3">
    <h1 class="text-dark fw-bold mb-1 fs--2">Tagihan & Layanan Pembelian</h1>
    <p class="text-muted mb-0 fs--2">Kelola transaksi tagihan layanan anggota (Listrik, PDAM, Internet, Pulsa, dll) secara langsung.</p>
</div>

<!-- Statistik Ringkas Berdasarkan Status -->
<!-- Statistik Ringkas Berdasarkan Status Dari Database -->
<div class="row g-3 mb-3">
    <!-- Status Pending -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-warning border-4">
            <div class="card-body">
                <div class="fw-bold text-warning text-uppercase mb-1 fs--2">Status Pending</div>
                <div class="mb-0 fw-bold text-gray-800 fs--2">Rp {{ number_format($totalPending ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <!-- Status Piutang -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body">
                <div class="fw-bold text-info text-uppercase mb-1 fs--2">Status Piutang</div>
                <div class="mb-0 fw-bold text-gray-800 fs--2">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <!-- Total Lunas Bulan Ini -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body">
                <div class="fw-bold text-success text-uppercase mb-1 fs--2">Total Lunas Bulan Ini</div>
                <div class="mb-0 fw-bold text-gray-800 fs--2">Rp {{ number_format($totalLunasBulanIni ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <!-- Status Batal -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <div class="fw-bold text-danger text-uppercase mb-1 fs--2">Status Batal</div>
                <div class="mb-0 fw-bold text-gray-800 fs--2">Rp {{ number_format($totalBatal ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Layout Utama: Kiri (Form Input), Kanan (Tabel Data) -->
<div class="row g-3">
    <!-- SISI KIRI: Form Input Transaksi -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-semibold fs--2"><i class="fas fa-file-invoice-dollar me-2"></i>Form Transaksi Baru</h5>
            </div>
            <form action="{{ route('menu_koperasi_pembelian_vocher_layanan_save') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Kode Transaksi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold fs--2">Kode Transaksi</label>
                            <input type="text" class="form-control bg-light font-monospace fs--2" name="kode_transaksi" value="TRX-{{ date('Ymd') }}-{{ rand(100,999) }}" readonly required>
                        </div>

                        <!-- Anggota ID -->
                        <div class="col-12">
                            <label class="form-label fw-semibold fs--2">Anggota (Peserta)</label>
                            <select class="form-select fs--2" name="anggota_id" required>
                                <option value="" selected disabled>-- Pilih Anggota --</option>
                                @foreach($peserta as $p)
                                <option value="{{ $p->id_kop_master_peserta }}">
                                    {{ $p->kop_master_peserta_code }} - {{ $p->kop_master_peserta_name }} (NIP: {{ $p->kop_master_peserta_nip }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Layanan Enum -->
                        <div class="col-12">
                            <label class="form-label fw-semibold fs--2">Jenis Layanan</label>
                            <select class="form-select fs--2" name="jenis_layanan" required>
                                <option value="" selected disabled>-- Pilih Layanan --</option>
                                <option value="LISTRIK">LISTRIK (Token / PLN)</option>
                                <option value="PDAM">PDAM (Air)</option>
                                <option value="INTERNET">INTERNET / WiFi</option>
                                <option value="PULSA">PULSA & Paket Data</option>
                                <option value="LAINNYA">LAINNYA (Voucher Game)</option>
                            </select>
                        </div>

                        <!-- Nomor Tujuan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold fs--2">Nomor Tujuan / No. Pelanggan</label>
                            <input type="text" class="form-control fs--2" name="nomor_tujuan" placeholder="Cth: 5412893120" required>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold fs--2">Nama Pelanggan (Opsional)</label>
                            <input type="text" class="form-control fs--2" name="nama_pelanggan" placeholder="Nama sesuai tagihan asli">
                        </div>

                        <!-- Nominal Tagihan -->
                        <div class="col-6">
                            <label class="form-label fw-semibold fs--2">Nominal (Rp)</label>
                            <input type="text" class="form-control fs--2" id="inputNominal" name="nominal" placeholder="0" required>
                        </div>

                        <!-- Admin Fee -->
                        <div class="col-6">
                            <label class="form-label fw-semibold fs--2">Biaya Admin (Rp)</label>
                            <input type="text" class="form-control fs--2" id="inputAdmin" name="admin_fee" value="2.500" required>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Pilihan Metode Pembayaran Berbentuk Kartu Bergambar/Ikon Interaktif -->
                        <!-- Pilihan Metode Pembayaran Berbentuk Kartu Bergambar/Ikon Interaktif -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark fs--2 mb-2"><i class="fas fa-wallet text-primary me-1"></i> Metode Pembayaran:</label>
                            <div class="row g-2">
                                <!-- Opsi 1: Saldo Anggota (LUNAS) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodeSaldo" value="SALDO" autocomplete="off" checked>
                                    <label class="btn btn-outline-light border text-dark w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 shadow-sm h-100" for="metodeSaldo">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2 mb-1 text-success">
                                            <i class="fas fa-wallet fa-lg"></i>
                                        </div>
                                        <span class="fw-bold fs--2 text-center text-dark">Saldo Anggota</span>
                                        <span class="badge bg-success mt-1 fs--2">LUNAS</span>
                                    </label>
                                </div>
                                <!-- Opsi 2: Potong Gaji (PIUTANG) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodePotongGaji" value="POTONG_GAJI" autocomplete="off">
                                    <label class="btn btn-outline-light border text-dark w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 shadow-sm h-100" for="metodePotongGaji">
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2 mb-1 text-info">
                                            <i class="fas fa-file-invoice-dollar fa-lg"></i>
                                        </div>
                                        <span class="fw-bold fs--2 text-center text-dark">Potong Gaji</span>
                                        <span class="badge bg-info text-white mt-1 fs--2">PIUTANG</span>
                                    </label>
                                </div>
                                <!-- Opsi 3: Tagihan Bulan Ini (PENDING) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodeTagihanBulan" value="TAGIHAN_BULAN" autocomplete="off">
                                    <label class="btn btn-outline-light border text-dark w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 shadow-sm h-100" for="metodeTagihanBulan">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 mb-1 text-warning">
                                            <i class="fas fa-clock fa-lg"></i>
                                        </div>
                                        <span class="fw-bold fs--2 text-center text-dark">Tagihan Bulan</span>
                                        <span class="badge bg-warning text-white mt-1 fs--2">PENDING</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Input Status Tagihan yang akan otomatis berubah nilainya -->
                        <input type="hidden" name="status_tagihan" id="inputStatusTagihan" value="LUNAS">

                        <!-- Pilihan Akun / Rekening COA bergaya Jurnal Akuntansi -->
                        <div class="col-12 mt-3">
                            <div class="card border shadow-sm">
                                <div class="card-header bg-dark text-white py-2 px-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs--2"><i class="fas fa-balance-scale me-1"></i> Pilih Akun / Rekening COA</span>
                                    <div class="fs--2">
                                        <span class="me-3">Debit</span>
                                        <span>Kredit</span>
                                    </div>
                                </div>
                                <div class="card-body p-3 bg-light">

                                    <!-- Baris 1: Akun Piutang Anggota (Debet) -->
                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-semibold text-dark fs--2 mb-0">Akun Piutang Anggota (Debet)</label>
                                            <span class="text-success fw-semibold fs--2" id="txtDebitPiutang">Rp 0</span>
                                        </div>
                                        <select class="form-select fs--2 bg-white" name="piutang_coa" id="selectPiutangCoa" required>
                                            <option value="" disabled selected>-- Pilih COA Piutang --</option>
                                            @foreach($coas as $coa)
                                            <option value="{{ $coa->coa_code }}">
                                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Baris 2: Akun Kas/Bank Netto (Kredit) -->
                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-semibold text-secondary fs--2 mb-0 ps-3">
                                                <i class="fas fa-level-down-alt fa-rotate-90 text-muted me-1"></i> Akun Kas/Bank Netto (Kredit)
                                            </label>
                                            <span class="text-danger fw-semibold fs--2" id="txtKreditKas">Rp 0</span>
                                        </div>
                                        <select class="form-select fs--2 bg-white ms-3 w-95" name="sumber_dana_coa" id="selectKasCoa" required>
                                            <option value="" disabled selected>-- Pilih COA Kas/Bank --</option>
                                            @foreach($coas as $coa)
                                            <option value="{{ $coa->coa_code }}">
                                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Baris 3: Akun Pendapatan Biaya Admin (Kredit) -->
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-semibold text-secondary fs--2 mb-0 ps-3">
                                                <i class="fas fa-level-down-alt fa-rotate-90 text-muted me-1"></i> Akun Pendapatan Biaya Admin (Kredit)
                                            </label>
                                            <span class="text-danger fw-semibold fs--2" id="txtKreditAdmin">Rp 0</span>
                                        </div>
                                        <select class="form-select fs--2 bg-white ms-3 w-95" name="pendapatan_admin_coa" id="selectAdminCoa" required>
                                            <option value="" disabled selected>-- Pilih COA Admin --</option>
                                            @foreach($coas as $coa)
                                            <option value="{{ $coa->coa_code }}" {{ $coa->coa_type == 'pendapatan' ? 'selected' : '' }}>
                                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Kotak Ringkasan Total Kalkulasi Debet & Kredit -->
                                    <div id="autoCoaDetails" class="mt-3 pt-2 border-top text-dark fs--2">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Keseluruhan:</span>
                                            <div>
                                                <span class="text-success me-4" id="sumTotalDebit">Rp 0</span>
                                                <span class="text-danger" id="sumTotalKredit">Rp 0</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer bg-light text-end py-3">
                    <button type="reset" class="btn btn-outline-secondary me-1 fs--2">Reset</button>
                    <button type="submit" class="btn btn-primary px-3 fs--2"><i class="fas fa-save me-1"></i> Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SISI KANAN: Tabel Data Riwayat Transaksi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-secondary fs--2"><i class="fas fa-list me-2"></i>Daftar Tagihan & Layanan</h5>
                <div class="input-group w-50">
                    <input type="text" class="form-control fs--2" placeholder="Cari Kode / Pelanggan...">
                    <button class="btn btn-outline-secondary fs--2" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 fs--2">
                        <thead class="table-light text-uppercase text-muted">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Kode & Anggota</th>
                                <th>Layanan & Tujuan</th>
                                <th>Total & COA</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $index => $trx)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark font-monospace">{{ $trx->kode_transaksi }}</div>
                                    <span class="text-muted">{{ $trx->kop_master_peserta_name }} ({{ $trx->kop_master_peserta_code }})</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-15 text-white fs--2">{{ $trx->jenis_layanan }}</span>
                                    <div class="font-monospace text-dark mt-1">{{ $trx->nomor_tujuan }}</div>
                                    @if($trx->nama_pelanggan)
                                    <small class="text-muted">Pelanggan: {{ $trx->nama_pelanggan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">Rp {{ number_format($trx->total_tagihan, 0, ',', '.') }}</div>
                                    <span class="badge bg-dark text-success border mt-1 fs--2"><i class="fas fa-wallet me-1"></i> {{ $trx->sumber_dana_coa }}</span>
                                </td>
                                <td>
                                    @if($trx->status_tagihan == 'LUNAS')
                                    <span class="badge bg-success fs--2">LUNAS</span>
                                    @elseif($trx->status_tagihan == 'PIUTANG' || $trx->status_tagihan == 'DITAGIHKAN')
                                    <span class="badge bg-info text-dark fs--2">{{ $trx->status_tagihan }}</span>
                                    @elseif($trx->status_tagihan == 'PENDING')
                                    <span class="badge bg-warning text-dark fs--2">PENDING</span>
                                    @else
                                    <span class="badge bg-danger fs--2">{{ $trx->status_tagihan }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    {{-- Tombol Pelunasan (Hanya muncul jika status belum LUNAS) --}}
                                    @if($trx->status_tagihan != 'LUNAS')
                                    <button class="btn btn-sm btn-outline-success py-0 px-1 fs--2 btn-lunas"
                                        title="Lunasi Tagihan"
                                        data-id="{{ $trx->id }}"
                                        data-kode="{{ $trx->kode_transaksi }}"
                                        data-total="{{ $trx->total_tagihan }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPelunasan">
                                        <i class="fas fa-check-circle"></i> Lunasi
                                    </button>
                                    @else
                                    <span class="badge bg-success fs--2">Lunas</span>
                                    @endif

                                    {{-- Tombol Hapus (Hanya muncul jika status BELUM LUNAS / PENDING / PIUTANG) --}}
                                    @if($trx->status_tagihan != 'LUNAS')
                                    <form action="{{ route('menu_koperasi_pembelian_vocher_layanan_destroy', $trx->id) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1 fs--2" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4 fs--2">Belum ada data transaksi tersimpan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="text-muted fs--2">Menampilkan data transaksi</span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link fs--2" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link fs--2" href="#">1</a></li>
                        <li class="page-item"><a class="page-link fs--2" href="#">Selanjutnya</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pelunasan Tagihan -->
<div class="modal fade" id="modalPelunasan" tabindex="-1" aria-labelledby="modalPelunasanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('menu_koperasi_pembelian_vocher_layanan_lunas') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h5 class="modal-title fs--2 fw-bold" id="modalPelunasanLabel"><i class="fas fa-money-bill-wave me-1"></i> Form Pelunasan Tagihan Layanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs--2">
                    <!-- Hidden ID Transaksi -->
                    <input type="hidden" name="id_transaksi" id="lunasIdTransaksi">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Transaksi</label>
                        <input type="text" class="form-control fs--2 bg-light font-monospace" id="lunasKodeTransaksi" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Tagihan yang Harus Dibayar</label>
                        <input type="text" class="form-control fs--2 bg-light fw-bold text-danger" id="lunasTotalTagihan" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Akun Kas / Bank Pembayaran (Debet/Kas Masuk)</label>
                        <select class="form-select fs--2" name="sumber_dana_pelunasan_coa" required>
                            <option value="" disabled selected>-- Pilih COA Kas / Bank --</option>
                            @foreach($coas as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary fs--2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fs--2"><i class="fas fa-save me-1"></i> Simpan Pelunasan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('base.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputNominal = document.getElementById('inputNominal');
        const inputAdmin = document.getElementById('inputAdmin');

        const txtDebitPiutang = document.getElementById('txtDebitPiutang');
        const txtKreditKas = document.getElementById('txtKreditKas');
        const txtKreditAdmin = document.getElementById('txtKreditAdmin');

        const sumTotalDebit = document.getElementById('sumTotalDebit');
        const sumTotalKredit = document.getElementById('sumTotalKredit');



        let terbilangContainer = document.getElementById('terbilangNominal');
        if (!terbilangContainer && inputNominal) {
            terbilangContainer = document.createElement('div');
            terbilangContainer.id = 'terbilangNominal';
            terbilangContainer.className = 'form-text text-muted fst-italic mt-1 fs--2';
            inputNominal.parentNode.appendChild(terbilangContainer);
        }

        const radioSaldo = document.getElementById('metodeSaldo');
        const radioPotongGaji = document.getElementById('metodePotongGaji');
        const radioTagihanBulan = document.getElementById('metodeTagihanBulan');
        const inputStatusTagihan = document.getElementById('inputStatusTagihan');

        function updateStatusTagihan() {
            if (radioSaldo.checked) {
                inputStatusTagihan.value = 'LUNAS';
            } else if (radioPotongGaji.checked) {
                inputStatusTagihan.value = 'PIUTANG'; // Atau sesuaikan dengan enum database Anda
            } else if (radioTagihanBulan.checked) {
                inputStatusTagihan.value = 'PENDING';
            }
        }

        if (radioSaldo && radioPotongGaji && radioTagihanBulan) {
            radioSaldo.addEventListener('change', updateStatusTagihan);
            radioPotongGaji.addEventListener('change', updateStatusTagihan);
            radioTagihanBulan.addEventListener('change', updateStatusTagihan);
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(angka);
        }

        function cleanNumber(nilai) {
            if (!nilai) return 0;
            return parseFloat(nilai.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }

        function penyebut(nilai) {
            nilai = Math.abs(nilai);
            var huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
            var temp = "";
            if (nilai < 12) {
                temp = " " + huruf[nilai];
            } else if (nilai < 20) {
                temp = penyebut(nilai - 10) + " Belas";
            } else if (nilai < 100) {
                temp = penyebut(Math.floor(nilai / 10)) + " Puluh" + penyebut(nilai % 10);
            } else if (nilai < 200) {
                temp = " Seratus" + penyebut(nilai - 100);
            } else if (nilai < 1000) {
                temp = penyebut(Math.floor(nilai / 100)) + " Ratus" + penyebut(nilai % 100);
            } else if (nilai < 2000) {
                temp = " Seribu" + penyebut(nilai - 1000);
            } else if (nilai < 1000000) {
                temp = penyebut(Math.floor(nilai / 1000)) + " Ribu" + penyebut(nilai % 1000);
            } else if (nilai < 1000000000) {
                temp = penyebut(Math.floor(nilai / 1000000)) + " Juta" + penyebut(nilai % 1000000);
            } else if (nilai < 1000000000000) {
                temp = penyebut(Math.floor(nilai / 1000000000)) + " Miliar" + penyebut(nilai % 1000000000);
            }
            return temp;
        }

        function terbilang(nilai) {
            if (nilai == 0) return "Nol Rupiah";
            var hasil = penyebut(nilai).trim();
            return hasil + " Rupiah";
        }

        function handleInputFormatting(e) {
            let val = e.target.value.replace(/[^,\d]/g, '').toString();
            let split = val.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            e.target.value = rupiah;
        }

        function calculateJournal() {
            const nominal = cleanNumber(inputNominal.value);
            const admin = cleanNumber(inputAdmin.value);
            const totalTagihan = nominal + admin;

            if (txtDebitPiutang) txtDebitPiutang.textContent = formatRupiah(totalTagihan);
            if (txtKreditKas) txtKreditKas.textContent = formatRupiah(nominal);
            if (txtKreditAdmin) txtKreditAdmin.textContent = formatRupiah(admin);

            if (sumTotalDebit) sumTotalDebit.textContent = formatRupiah(totalTagihan);
            if (sumTotalKredit) sumTotalKredit.textContent = formatRupiah(totalTagihan);

            if (terbilangContainer) {
                if (nominal > 0) {
                    terbilangContainer.textContent = "Terbilang: " + terbilang(nominal);
                } else {
                    terbilangContainer.textContent = "";
                }
            }
        }

        if (inputNominal && inputAdmin) {
            inputNominal.addEventListener('input', function(e) {
                handleInputFormatting(e);
                calculateJournal();
            });

            inputAdmin.addEventListener('input', function(e) {
                handleInputFormatting(e);
                calculateJournal();
            });

            // Set default value format and run calculation on load
            if (inputAdmin.value && !inputAdmin.value.includes('.')) {
                inputAdmin.value = Number(inputAdmin.value).toLocaleString('id-ID');
            }
            calculateJournal();
        }
        // Script untuk mengisi data ke Modal Pelunasan
        const modalPelunasan = document.getElementById('modalPelunasan');
        if (modalPelunasan) {
            modalPelunasan.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;

                let id = button.getAttribute('data-id');
                let kode = button.getAttribute('data-kode');
                let total = button.getAttribute('data-total');

                document.getElementById('lunasIdTransaksi').value = id;
                document.getElementById('lunasKodeTransaksi').value = kode;
                document.getElementById('lunasTotalTagihan').value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(total);
            });
        }
    });
</script>
@endsection
