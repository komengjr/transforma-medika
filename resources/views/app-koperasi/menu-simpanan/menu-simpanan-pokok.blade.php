@extends('layouts.layouts')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- KARTU FILTER CABANG -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0 text-white">Menu Simpanan Pokok Awal Anggota</h5>
            </div>
            <div class="card-body bg-white p-4">
                <div class="row">
                    <div class="col-md-12">
                        <label for="select-cabang" class="form-label fw-bold">1. Pilih Cabang Koperasi</label>
                        <select id="select-cabang" class="form-select form-select-lg">
                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                            @foreach($list_cabang as $cabang)
                            <option value="{{ $cabang->kop_master_cabang_code }}">{{ $cabang->kop_master_cabang_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTAINER PESAN LOADING / PROMPT AWAL -->
        <div id="status-message" class="alert alert-info text-center border-0 shadow-sm">
            Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu pada form di atas untuk menampilkan data anggota.
        </div>

        <!-- KARTU DATA ANGGOTA (Akan disembunyikan sampai cabang dipilih) -->
        <div id="card-peserta" class="card shadow-sm border-0 d-none">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Daftar Anggota Koperasi - Cabang: <strong id="label-cabang">-</strong></h6>
                <span class="badge bg-light text-dark">Tarif Pokok: Rp {{ number_format($nominal_simpanan_pokok, 0, ',', '.') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Kode Anggota</th>
                                <th>Nama Lengkap</th>
                                <th>NIK / NIP</th>
                                <th>Status Pembayaran</th>
                                <th class="text-center">Aksi Pemrosesan</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-peserta-body">
                            <!-- Data peserta akan dimasukkan di sini oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Tambahkan ini di bagian bawah body, sebelum tag </body> -->

<!-- MODAL PROSES PEMBAYARAN & COA -->
<div class="modal fade" id="modalBayar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalBayarLabel">Konfirmasi Pembayaran Simpanan Pokok</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-pembayaran-pokok" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Informasi Anggota Ringkas -->
                    <div class="bg-light p-3 rounded mb-3 border-start border-success border-4">
                        <div class="fw-bold text-dark" id="modal-nama-anggota">-</div>
                        <small class="text-muted" id="modal-kode-anggota">-</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Nominal Simpanan Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-semibold">Rp</span>
                            <input type="text" class="form-control bg-light fw-bold text-dark" value="{{ number_format($nominal_simpanan_pokok, 0, ',', '.') }}" readonly>
                            <input type="hidden" name="nominal_pokok" id="" value="{{ $nominal_simpanan_pokok }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Tanggal Menjadi Anggota Koperasi</label>
                        <div class="input-group">

                            <input type="date" name="tanggal_anggota" class="form-control">
                        </div>
                    </div>

                    <!-- Pilihan COA Pembayaran (Asset / Kas-Bank) -->
                    <div class="mb-3">
                        <label for="coa_pembayaran" class="form-label fw-bold">Diterima Melalui (Akun Kas / Bank)</label>
                        <select name="coa_pembayaran" id="coa_pembayaran" class="form-select" required>
                            <option value="">-- Pilih Akun Kas / Bank --</option>
                            @foreach($coa_pembayaran as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Akun debit untuk mencatat masuknya uang pendaftaran.</small>
                    </div>

                    <!-- Pilihan COA Ekuitas / Hutang Pokok -->
                    <div class="mb-3">
                        <label for="coa_simpanan" class="form-label fw-bold">Alokasi Akun (Ekuitas / Hutang Simpanan)</label>
                        <select name="coa_simpanan" id="coa_simpanan" class="form-select" required>
                            <option value="">-- Pilih Akun Simpanan --</option>
                            @foreach($coa_simpanan as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Akun kredit penyeimbang transaksi modal/kewajiban.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    document.getElementById('select-cabang').addEventListener('change', function() {
        const cabang = this.value;
        const statusMessage = document.getElementById('status-message');
        const cardPeserta = document.getElementById('card-peserta');
        const labelCabang = document.getElementById('label-cabang');
        const tabelBody = document.getElementById('tabel-peserta-body');

        // Jika user mengosongkan pilihan cabang
        if (!cabang) {
            cardPeserta.classList.add('d-none');
            statusMessage.classList.remove('d-none');
            statusMessage.innerHTML = 'Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu.';
            return;
        }

        // Tampilkan pesan loading
        statusMessage.classList.remove('d-none');
        statusMessage.innerHTML = '<div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data peserta...';
        cardPeserta.classList.add('d-none');
        tabelBody.innerHTML = '';

        // Lakukan Request AJAX ke Route GET data peserta
        fetch(`{{ route('menu_koperasi_simpanan_pokok_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    statusMessage.classList.add('d-none');
                    labelCabang.textContent = cabang.toUpperCase();

                    // Looping data dan render ke tabel HTML
                    res.data.forEach(item => {
                        // Logika Status Badge
                        const isAktif = item.kop_master_peserta_status === 'AKTIF';
                        const badgeClass = isAktif ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
                        const badgeText = isAktif ? 'Lunas (Aktif)' : 'Belum Bayar (Pending)';

                        // Logika Tombol Aksi
                        let actionButton = '';
                        if (!isAktif) {
                            actionButton = `
                                        <button type="button"
                                                class="btn btn-sm btn-success px-3 btn-trigger-bayar"
                                                data-id="${item.id_kop_master_peserta}"
                                                data-nama="${item.kop_master_peserta_name}"
                                                data-kode="${item.kop_master_peserta_code}">
                                            Bayar Pokok
                                        </button>
                                    `;
                        } else {
                            actionButton = `<button class="btn btn-sm btn-outline-secondary px-3" disabled>Selesai</button>`;
                        }

                        // Format inisial huruf jika foto kosong
                        const initial = item.kop_master_peserta_name.substring(0, 2).toUpperCase();
                        const photoHtml = item.kop_master_peserta_photo ?
                            `<img src="/storage/${item.kop_master_peserta_photo}" class="rounded-circle me-2" width="35" height="35">` :
                            `<div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 12px;">${initial}</div>`;

                        // Tambah baris ke tabel
                        const row = `
                        <tr>
                            <td class="px-4 fw-bold text-secondary">${item.kop_master_peserta_code}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    ${photoHtml}
                                    <div>${item.kop_master_peserta_name}</div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">NIK: ${item.kop_master_peserta_nik}</small><br>
                                <small class="text-muted">NIP: ${item.kop_master_peserta_nip}</small>
                            </td>
                            <td>
                                <span class="badge ${badgeClass} px-3 py-2 rounded-pill">${badgeText}</span>
                            </td>
                            <td class="text-center">${actionButton}</td>
                        </tr>
                    `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });

                    cardPeserta.classList.remove('d-none');
                } else {
                    statusMessage.classList.remove('d-none');
                    statusMessage.innerHTML = `Tidak ditemukan data anggota di cabang <strong>${cabang}</strong>.`;
                }
            })
            .catch(error => {
                console.error(error);
                statusMessage.classList.remove('d-none');
                statusMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan sistem saat mengambil data.</span>';
            });
    });
    // Menangani klik tombol bayar untuk memicu modal secara dinamis
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn-trigger-bayar')) {
            const id = event.target.getAttribute('data-id');
            const nama = event.target.getAttribute('data-nama');
            const kode = event.target.getAttribute('data-kode');

            // Set info teks di dalam modal
            document.getElementById('modal-nama-anggota').textContent = nama;
            document.getElementById('modal-kode-anggota').textContent = kode;

            // Set action form secara dinamis mengarah ke endpoint Laravel
            const form = document.getElementById('form-pembayaran-pokok');
            form.setAttribute('action', `/koperasi/menu-koperasi/simpanan-pokok/bayar/${id}`);

            // Tampilkan Modal
            const modalBayar = new bootstrap.Modal(document.getElementById('modalBayar'));
            modalBayar.show();
        }
    });
</script>
@endsection
