@extends('layouts.layouts')
@section('content')

<div class="col-md-12">

    <!-- Flash Alert -->
    @if(session('success')) <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger border-0 shadow-sm mb-3">{{ session('error') }}</div> @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">Transaksi & Pengelolaan Saldo Sukarela Anggota</h5>
        </div>
        <div class="card-body bg-white p-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter Cabang</label>
                    <select id="select-cabang" class="form-select">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($list_cabang as $cabang)
                        <option value="{{ $cabang }}">{{ strtoupper($cabang) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE UTAMA -->
    <div id="card-tabel" class="card shadow-sm border-0 d-none">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No Anggota</th>
                        <th>Nama Lengkap</th>
                        <th>Saldo Sukarela Berjalan</th>
                        <th class="text-center" style="width: 200px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="tabel-body"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TRANSAKSI -->
<div class="modal fade" id="modalTransaksi" static data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('menu_koperasi_simpanan_sukarela_koperasi_bayar') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id_kop_master_peserta" id="modal-id-peserta">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Form Mutasi Saldo - <span id="modal-nama-label"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Perubahan Saldo</label>
                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-select" required>
                        <option value="SETORAN">SETORAN (Tambah Saldo / Uang Masuk)</option>
                        <option value="PENARIKAN">PENARIKAN (Tarik Tunai / Saldo Berkurang)</option>
                        <option value="POTONG_VOUCHER">POTONG VOUCHER (Bayar Belanjaan / Potong Saldo)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nominal Uang (Rp)</label>
                    <input type="number" name="nominal" class="form-control" placeholder="Contoh: 50000" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Metode Keuangan (Kas/Bank)</label>
                    <select name="coa_kas_bank" class="form-select" required>
                        @foreach($coa_pembayaran as $coa)
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Akun Rekening Sukarela</label>
                    <select name="coa_sukarela" class="form-select" required>
                        @foreach($coa_sukarela as $coa)
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan transaksi..."></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success fw-bold px-4">Proses Pemutakhiran</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('base.js')

<script>
    document.getElementById('select-cabang').addEventListener('change', function() {
        const cabang = this.value;
        const cardTabel = document.getElementById('card-tabel');
        const tabelBody = document.getElementById('tabel-body');

        if (!cabang) {
            cardTabel.classList.add('d-none');
            return;
        }

        fetch(`{{ route('menu_koperasi_simpanan_sukarela_koperasi_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(res => res.json())
            .then(res => {
                tabelBody.innerHTML = '';
                if (res.data.length > 0) {
                    res.data.forEach(item => {
                        let formattedSaldo = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(item.saldo_sukarela);

                        let row = `
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">${item.kop_master_peserta_code}</td>
                            <td>${item.kop_master_peserta_name}</td>
                            <td class="fw-bold text-primary">${formattedSaldo}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary px-3 fw-bold"
                                        onclick="bukaModalTransaksi(${item.id_kop_master_peserta}, '${item.kop_master_peserta_name}')">
                                    ± Mutasi Saldo
                                </button>
                            </td>
                        </tr>
                    `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });
                    cardTabel.classList.remove('d-none');
                } else {
                    alert('Tidak ada anggota di cabang ini.');
                    cardTabel.classList.add('d-none');
                }
            });
    });

    function bukaModalTransaksi(id, nama) {
        document.getElementById('modal-id-peserta').value = id;
        document.getElementById('modal-nama-label').textContent = nama;

        let modalEl = new bootstrap.Modal(document.getElementById('modalTransaksi'));
        modalEl.show();
    }
</script>
@endsection
