@extends('layouts.layouts')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- 1. FILTER PANEL & SETUP COA -->
        <form action="{{ route('menu_koperasi_simpanan_wajib_bayar') }}" method="POST" onsubmit="return confirm('Proses pembayaran simpanan wajib kolektif untuk semua anggota yang dicentang?')">
            @csrf

            <!-- Input Tersembunyi Untuk Menyimpan Cabang yang Dipilih -->
            <input type="hidden" name="cabang_terpilih" id="cabang_terpilih">
            <input type="hidden" name="nominal_wajib" value="{{ $nominal_wajib }}">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 text-white">Menu Penagihan Kolektif Simpanan Wajib (Akhir Bulan)</h5>
                </div>
                <div class="card-body bg-white p-4">
                    <div class="row">
                        <!-- Dropdown Filter Cabang -->
                        <div class="col-md-4 mb-3">
                            <label for="select-cabang" class="form-label fw-bold">Pilih Cabang</label>
                            <select id="select-cabang" class="form-select">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($list_cabang as $cabang)
                                <option value="{{ $cabang }}">{{ strtoupper($cabang) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- COA Pembayaran -->
                        <div class="col-md-4 mb-3">
                            <label for="coa_pembayaran" class="form-label fw-bold">Metode Penerimaan Uang</label>
                            <select name="coa_pembayaran" id="coa_pembayaran" class="form-select" required>
                                <option value="">-- Pilih Kas / Bank --</option>
                                @foreach($coa_pembayaran as $coa)
                                <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- COA Simpanan Wajib -->
                        <div class="col-md-4 mb-3">
                            <label for="coa_simpanan" class="form-label fw-bold">Alokasi Akun Rekening</label>
                            <select name="coa_simpanan" id="coa_simpanan" class="form-select" required>
                                <option value="">-- Pilih Akun Simpanan Wajib --</option>
                                @foreach($coa_simpanan as $coa)
                                <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFO BOX & TABLE PANEL -->
            <div id="status-message" class="alert alert-info text-center border-0 shadow-sm">
                Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu untuk memuat daftar anggota aktif.
            </div>

            <div id="card-peserta" class="card shadow-sm border-0 d-none">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0">Daftar Anggota Aktif - Cabang: <strong id="label-cabang">-</strong></h6>
                    <span class="badge bg-white text-dark">Tarif Bulanan: Rp {{ number_format($nominal_wajib, 0, ',', '.') }} / Anggota</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center px-4" style="width: 80px;">
                                        <!-- Checkbox Master -->
                                        <input type="checkbox" id="check-all" class="form-check-input">
                                    </th>
                                    <th>Kode Anggota</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK / NIP</th>
                                    <th>Periode Tagihan</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-peserta-body">
                                <!-- Diisi secara dinamis oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Footer Card untuk Trigger Aksi Massal -->
                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <div class="text-secondary fw-semibold">
                        Total Dipilih: <span id="total-terpilih" class="text-primary fw-bold">0</span> Anggota
                    </div>
                    <button type="submit" id="btn-submit-massal" class="btn btn-success px-5 fw-bold" disabled>
                        Proses Bayar Massal Berdasarkan Cabang
                    </button>
                </div>
            </div>
        </form>

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
        const hiddenCabang = document.getElementById('cabang_terpilih');

        hiddenCabang.value = cabang;

        if (!cabang) {
            cardPeserta.classList.add('d-none');
            statusMessage.classList.remove('d-none');
            statusMessage.innerHTML = 'Silakan tentukan filter <strong>Cabang Koperasi</strong>.';
            return;
        }

        statusMessage.classList.remove('d-none');
        statusMessage.innerHTML = '<div class="spinner-border spinner-border-sm text-primary me-2"></div> Menghimpun data anggota aktif cabang...';
        cardPeserta.classList.add('d-none');
        tabelBody.innerHTML = '';

        // Ambil Data dari API JSON
        fetch(`{{ route('menu_koperasi_simpanan_wajib_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    statusMessage.classList.add('d-none');
                    labelCabang.textContent = cabang.toUpperCase();

                    const options = {
                        month: 'long',
                        year: 'numeric'
                    };
                    const bulanIni = new Date().toLocaleDateString('id-ID', options);

                    res.data.forEach(item => {
                        // Tentukan template checkbox & status berdasarkan history pembayaran
                        let checkbox = `<input type="checkbox" name="ids_anggota[]" value="${item.id_kop_master_peserta}" class="form-check-input check-item">`;
                        let badgeStatus = `<span class="badge bg-warning-subtle text-warning px-2 py-1">Belum Bayar</span>`;
                        let rowClass = '';

                        if (item.sudah_bayar) {
                            checkbox = `<input type="checkbox" class="form-check-input" disabled checked>`;
                            badgeStatus = `<span class="badge bg-success text-white px-2 py-1">✓ LUNAS</span>`;
                            rowClass = 'table-light text-muted'; // baris jadi abu-abu penanda sudah aman
                        }

                        const row = `
                                        <tr class="${rowClass}">
                                            <td class="text-center px-4">${checkbox}</td>
                                            <td class="fw-bold">${item.kop_master_peserta_code}</td>
                                            <td>${item.kop_master_peserta_name}</td>
                                            <td>
                                                <small class="d-block">NIK: ${item.kop_master_peserta_nik}</small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-secondary">${bulanIni}</span>
                                            </td>
                                            <td>${badgeStatus}</td>
                                        </tr>
                                    `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });

                    cardPeserta.classList.remove('d-none');
                    initCheckboxLogic();
                } else {
                    statusMessage.classList.remove('d-none');
                    statusMessage.innerHTML = `Tidak ada anggota di cabang <strong>${cabang}</strong>.`;
                }
            })
            .catch(error => {
                console.error(error);
                statusMessage.innerHTML = '<span class="text-danger">Gagal memuat data dari database.</span>';
            });
    });

    // Logika Fungsi Pilihan Checkbox Massal
    function initCheckboxLogic() {
        const checkAll = document.getElementById('check-all');
        const checkItems = document.querySelectorAll('.check-item');
        const btnSubmit = document.getElementById('btn-submit-massal');
        const textTotal = document.getElementById('total-terpilih');

        checkAll.checked = false;
        textTotal.textContent = '0';
        btnSubmit.disabled = true;

        // Aksi Klik Checkbox Master Header
        checkAll.addEventListener('change', function() {
            checkItems.forEach(item => item.checked = this.checked);
            updateFooterStatus();
        });

        // Aksi Klik Checkbox Individual Anggota
        checkItems.forEach(item => {
            item.addEventListener('change', function() {
                // Jika ada satu saja yang tidak dicentang, master check di header mati
                if (!this.checked) checkAll.checked = false;
                // Jika semua dicentang secara manual, master check ikut aktif
                if (document.querySelectorAll('.check-item:checked').length === checkItems.length) checkAll.checked = true;

                updateFooterStatus();
            });
        });

        function updateFooterStatus() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            textTotal.textContent = checkedCount;
            // Tombol proses massal aktif hanya jika ada minimal 1 anggota dicentang
            btnSubmit.disabled = checkedCount === 0;
        }
    }
</script>
@endsection
