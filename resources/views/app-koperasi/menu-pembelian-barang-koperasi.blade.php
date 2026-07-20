@extends('layouts.layouts')

@section('content')

<!-- HEADER HALAMAN (Diperbarui dengan Tombol List) -->
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <div>
        <h4 class="fw-bold text-dark text-uppercase m-0">
            <i class="fas fa-cart-plus-fill text-success me-2"></i> Pengadaan & Pembelian Barang
        </h4>
        <p class="text-muted small mb-0">Pencatatan transaksi pembelian barang operasional dan inventaris koperasi.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <!-- TOMBOL BARU UNTUK LIHAT LIST -->
        <button type="button" class="btn btn-outline-primary fw-bold btn-sm shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalListBarang" id="btn-buka-list">
            <i class="bi bi-table me-1"></i> Data List Barang
        </button>
        <span class="badge bg-secondary p-2 font-monospace">{{ date('d F Y') }}</span>
    </div>
</div>

<form id="form-pembelian" method="POST" action="#">
    @csrf
    <div class="row g-3">

        <!-- PANEL KIRI: DATA TRANSAKSI -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white fw-bold py-3">
                    <i class="bi bi-file-earmark-medical me-2"></i> Informasi Utama Pembelian
                </div>
                <div class="card-body p-4">
                    <!-- Nomor Bukti & Tanggal -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">No. Transaksi / Invoice</label>
                            <input type="text" class="form-control border-secondary bg-light font-monospace" value="PO-{{ date('Ymd') }}-XXXX" readonly>
                            <div class="form-text text-muted" style="font-size: 11px;">Otomatis dari sistem backend</div>
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_beli" class="form-label small fw-bold text-secondary">Tanggal Transaksi *</label>
                            <input type="date" id="tgl_beli" name="tgl_beli" class="form-control border-primary fw-semibold" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Vendor / Supplier -->
                    <div class="mb-3">
                        <label for="supplier" class="form-label small fw-bold text-secondary">Nama Supplier / Vendor *</label>
                        <input type="text" id="supplier" name="supplier" class="form-control border-secondary" placeholder="Contoh: PT. Sumber Makmur atau Toko ATK Jaya" required>
                    </div>

                    <hr class="text-muted my-4">

                    <!-- PENGATURAN KEUANGAN & AKUNTANSI -->
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-cash-stack text-success me-2"></i> Alokasi Dana & Jurnal</h6>

                    <!-- Pilihan COA Pembayaran -->
                    <div class="mb-3">
                        <label for="coa_pembayaran" class="form-label small fw-bold text-secondary">Sumber Dana / Metode Pembayaran *</label>
                        <select id="coa_pembayaran" name="coa_pembayaran" class="form-select border-primary fw-semibold" required>
                            <option value="">-- Pilih Rekening Pembayaran --</option>
                            @foreach($coas as $coa)
                            <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted" style="font-size: 11px;">Akun Kredit pada pembukuan jurnal.</div>
                    </div>

                    <!-- Keterangan Jurnal -->
                    <div class="mb-0">
                        <label for="keterangan" class="form-label small fw-bold text-secondary">Keterangan Tambahan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control border-secondary" rows="3" placeholder="Contoh: Pembelian Laptop Inventaris Cabang Baru..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL KANAN: RINCIAN BARANG & KATEGORI ASET -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center py-3">
                    <span><i class="bi bi-box-seam-fill me-2"></i> Detail Item & Spesifikasi Kategori</span>
                    <span class="badge bg-white text-success fw-bold text-uppercase">Kategorisasi Barang</span>
                </div>
                <div class="card-body p-4">

                    <!-- Pilihan Kategori Krusial (Aset vs Bukan Aset) -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark d-block mb-2">
                            <i class="bi bi-question-circle-fill text-primary me-1"></i> Bagaimana Barang Ini Diklasifikasikan?
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-primary h-100 card-radio p-3 cursor-pointer">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori_barang" id="kat_aset" value="ASET" checked>
                                        <label class="form-check-label fw-bold text-dark" for="kat_aset">
                                            <i class="bi bi-building text-primary me-1"></i> MASUK DALAM ASET
                                        </label>
                                        <p class="text-muted mb-0 small mt-1" style="font-size: 12px;">
                                            Untuk barang dengan masa manfaat panjang (> 1 tahun) & nilai tinggi. Sistem otomatis mengaktifkan modul depresiasi/penyusutan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-secondary h-100 card-radio p-3 cursor-pointer">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori_barang" id="kat_non_aset" value="NON_ASET">
                                        <label class="form-check-label fw-bold text-dark" for="kat_non_aset">
                                            <i class="bi bi-journal-x text-secondary me-1"></i> TIDAK DIMASUKKAN ASET
                                        </label>
                                        <p class="text-muted mb-0 small mt-1" style="font-size: 12px;">
                                            Untuk barang habis pakai (ATK, perlengkapan, konsumsi) atau bernilai kecil yang langsung dibebankan pada bulan berjalan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NAMA & RINCIAN FISIK BARANG -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label for="nama_barang" class="form-label small fw-bold text-secondary">Nama / Spesifikasi Barang *</label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Contoh: Asus ExpertBook Core i5 atau Kertas A4 Sinar Dunia" required>
                        </div>
                        <div class="col-md-4">
                            <label for="satuan" class="form-label small fw-bold text-secondary">Satuan *</label>
                            <select id="satuan" name="satuan" class="form-select text-center" required>
                                <option value="Unit">Unit / Pcs</option>
                                <option value="Rim">Rim</option>
                                <option value="Box">Box</option>
                                <option value="Paket">Paket</option>
                            </select>
                        </div>
                    </div>

                    <!-- HARGA & KUANTITAS -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="qty" class="form-label small fw-bold text-secondary">Kuantitas (Qty) *</label>
                            <input type="number" id="qty" name="qty" class="form-control text-center font-monospace border-secondary" min="1" value="1" required>
                        </div>
                        <div class="col-md-8">
                            <label for="harga_satuan" class="form-label small fw-bold text-secondary">Harga Satuan (Rp) *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                <input type="number" id="harga_satuan" name="harga_satuan" class="form-control text-end font-monospace border-secondary" min="0" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-PANEL DINAMIS KHUSUS JIKA KATEGORI = ASET -->
                    <div id="section-detail-aset" class="bg-light p-3 border rounded-3 border-primary mb-4 animate-fade-in">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-calculator-fill me-2"></i> Konfigurasi Depresiasi Aktiva Tetap</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="coa_aset" class="form-label small fw-bold text-secondary">Target Akun Aset (COA)</label>
                                <select id="coa_aset" name="coa_aset" class="form-select border-primary bg-white fw-semibold">
                                    <option value="">-- Pilih COA Aset Tetap --</option>
                                    @foreach($coas as $coa)
                                    <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text" style="font-size:11px;">Akun Debit Neraca (misal: 1210 - Inventaris Kantor)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="umur_ekonomis" class="form-label small fw-bold text-secondary">Umur Ekonomis (Masa Manfaat)</label>
                                <div class="input-group">
                                    <input type="number" id="umur_ekonomis" name="umur_ekonomis" class="form-control bg-white" min="1" value="4">
                                    <span class="input-group-text bg-white">Tahun</span>
                                </div>
                                <div class="form-text" style="font-size:11px;">Estimasi durasi penyusutan barang</div>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-PANEL DINAMIS KHUSUS JIKA KATEGORI = BUKAN ASET -->
                    <div id="section-detail-non-aset" class="bg-light p-3 border rounded-3 border-secondary mb-4 d-none">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-journal-text me-2"></i> Pembebanan Biaya Operasional</h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="coa_beban" class="form-label small fw-bold text-secondary">Target Akun Beban / Perlengkapan (COA)</label>
                                <select id="coa_beban" name="coa_beban" class="form-select border-secondary bg-white fw-semibold">
                                    <option value="">-- Pilih COA Beban / Perlengkapan --</option>
                                    @foreach($coas as $coa)
                                    <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text" style="font-size:11px;">Akun Debit Laba Rugi (misal: 5102 - Biaya ATK / 1140 - Perlengkapan)</div>
                            </div>
                        </div>
                    </div>

                    <!-- KOTAK RINGKASAN TOTAL -->
                    <div class="alert alert-warning border-0 p-3 mb-4 rounded-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-uppercase text-dark"><i class="bi bi-tag-fill me-2 fs-5 text-warning"></i> Total Kewajiban Bayar</span>
                        <span id="label-total-bayar" class="fw-bold fs-3 text-dark font-monospace">Rp 0</span>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="text-end">
                        <button type="reset" class="btn btn-secondary fw-bold px-4 py-2 me-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                        <button type="button" id="btn-simpan-pembelian" class="btn btn-success fw-bold px-5 py-2 shadow-sm">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan & Bukukan Jurnal
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</form>


<!-- MODAL POP-UP BOOTSTRAP 5 UNTUK LIST BARANG -->
<div class="modal fade" id="modalListBarang" tabindex="-1" aria-labelledby="modalListBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold" id="modalListBarangLabel">
                    <i class="bi bi-list-stars text-warning me-2"></i> Riwayat & List Pembelian Barang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="table-responsive bg-white rounded-3 shadow-sm p-2">
                    <table class="table table-hover table-striped align-middle m-0" id="tabel-list-barang">
                        <thead class="table-primary text-uppercase small text-center">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Kode Transaksi</th>
                                <th style="width: 12%">Tanggal</th>
                                <th style="width: 15%">Supplier</th>
                                <th>Nama Barang</th>
                                <th style="width: 10%">Kategori</th>
                                <th style="width: 8%">Qty</th>
                                <th style="width: 15%">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="body-list-barang" class="small text-center">
                            <!-- Data akan dimuat secara dinamis via AJAX Javascript -->
                            <tr>
                                <td colspan="8" class="text-muted py-4">Memuat data transaksi...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-toggle="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Formatter Mata Uang
        const rupiahFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        const radioAset = document.getElementById('kat_aset');
        const radioNonAset = document.getElementById('kat_non_aset');

        const sectionAset = document.getElementById('section-detail-aset');
        const sectionNonAset = document.getElementById('section-detail-non-aset');

        const inputQty = document.getElementById('qty');
        const inputHarga = document.getElementById('harga_satuan');
        const labelTotal = document.getElementById('label-total-bayar');

        const selectCoaAset = document.getElementById('coa_aset');
        const selectCoaBban = document.getElementById('coa_beban');

        // 1. Toggling Sub-Panel Kategori (Aset vs Non-Aset) via Radio Buttons
        radioAset.addEventListener('change', toggleCategoryPanels);
        radioNonAset.addEventListener('change', toggleCategoryPanels);

        function toggleCategoryPanels() {
            if (radioAset.checked) {
                sectionAset.classList.remove('d-none');
                sectionNonAset.classList.add('d-none');

                // Atur requirement properti input HTML
                selectCoaAset.required = true;
                selectCoaBban.required = false;
                selectCoaBban.value = ""; // Clear data sebelah
            } else {
                sectionAset.classList.add('d-none');
                sectionNonAset.classList.remove('d-none');

                // Atur requirement properti input HTML
                selectCoaAset.required = false;
                selectCoaBban.required = true;
                selectCoaAset.value = ""; // Clear data sebelah
            }
        }

        // Set default requirement on load
        toggleCategoryPanels();

        // 2. Kalkulasi Real-time Total Bayar (Qty * Harga Satuan)
        inputQty.addEventListener('input', hitungTotal);
        inputHarga.addEventListener('input', hitungTotal);

        function hitungTotal() {
            const qty = parseFloat(inputQty.value) || 0;
            const harga = parseFloat(inputHarga.value) || 0;
            const total = qty * harga;

            labelTotal.innerText = rupiahFormatter.format(total);
        }

        // 3. Efek Visual Klik pada Card Radio Bootstrap
        document.querySelectorAll('.card-radio').forEach(card => {
            card.addEventListener('click', function() {
                const radioInput = this.querySelector('input[type="radio"]');
                radioInput.checked = true;

                // Trigger event change manual karena DOM diubah manual via click card
                const event = new Event('change');
                radioInput.dispatchEvent(event);

                // Perbarui border highlight
                document.querySelectorAll('.card-radio').forEach(c => c.classList.replace('border-primary', 'border-secondary'));
                if (radioAset.checked) {
                    radioAset.closest('.card-radio').classList.replace('border-secondary', 'border-primary');
                } else {
                    radioNonAset.closest('.card-radio').classList.replace('border-secondary', 'border-primary');
                }
            });
        });

        // 4. Validasi & Submit Data Menggunakan AJAX Fetch
        const btnSimpan = document.getElementById('btn-simpan-pembelian');
        btnSimpan.addEventListener('click', function() {
            const form = document.getElementById('form-pembelian');

            // Periksa fungsi validasi bawaan HTML5 form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (confirm("Apakah Anda yakin seluruh data pembelian ini sudah valid dan siap dibukukan ke dalam jurnal keuangan?")) {
                btnSimpan.disabled = true;
                btnSimpan.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...`;

                // Kumpulkan data forms payload
                const payload = {
                    tgl_beli: document.getElementById('tgl_beli').value,
                    supplier: document.getElementById('supplier').value,
                    coa_pembayaran: document.getElementById('coa_pembayaran').value,
                    keterangan: document.getElementById('keterangan').value,
                    kategori: document.querySelector('input[name="kategori_barang"]:checked').value,
                    nama_barang: document.getElementById('nama_barang').value,
                    satuan: document.getElementById('satuan').value,
                    qty: inputQty.value,
                    harga_satuan: inputHarga.value,
                    coa_aset: selectCoaAset.value,
                    umur_ekonomis: document.getElementById('umur_ekonomis').value,
                    coa_beban: selectCoaBban.value
                };

                // Kirim data ke backend controller
                fetch(`{{ route('menu_koperasi_pembelian_barang_save') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal memproses ke server.');
                        return res.json();
                    })
                    .then(data => {
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = `<i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan & Bukukan Jurnal`;

                        if (data.status === 'success') {
                            alert(`Sukses! Pembelian barang berhasil dicatat.\nNomor Jurnal Terbentuk: ${data.jurnal_no}`);
                            form.reset();
                            labelTotal.innerText = "Rp 0";
                            toggleCategoryPanels();
                        } else {
                            alert('Gagal: ' + data.message);
                        }
                    })
                    .catch(err => {
                        alert('Terjadi error jaringan atau server gagal membuat jurnal pembukuan.');
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = `<i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan & Bukukan Jurnal`;
                    });
            }
        });
    });
</script>
<script>
    document.getElementById('btn-buka-list').addEventListener('click', function() {
        const tbody = document.getElementById('body-list-barang');
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4"><span class="spinner-border spinner-border-sm me-2"></span> Mengambil data riwayat koperasi...</td></tr>`;

        // UBAH BAGIAN INI: Menggunakan path relatif agar aman dari error javascript syntax
        fetch(`{{ route('menu_koperasi_pembelian_barang_get_data') }}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Respon server bermasalah');
                }
                return res.json();
            })
            .then(data => {
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="8" class="text-muted py-4">Belum ada data pembelian barang tercatat.</td></tr>`;
                    return;
                }

                // Pastikan format mata uang rupiah sudah terdefinisi
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });

                data.forEach((item, index) => {
                    const badgeKat = item.kategori === 'ASET' ?
                        `<span class="badge bg-primary"><i class="bi bi-building"></i> ASET</span>` :
                        `<span class="badge bg-secondary"><i class="bi bi-journal-x"></i> BUKAN ASET</span>`;

                    const row = `
                    <tr>
                        <td class="fw-bold">${index + 1}</td>
                        <td class="font-monospace text-primary small fw-semibold">${item.pembelian_code}</td>
                        <td>${item.tgl_beli}</td>
                        <td class="text-start">${item.supplier}</td>
                        <td class="text-start fw-semibold">${item.nama_barang} <span class="text-muted small">(${item.satuan})</span></td>
                        <td>${badgeKat}</td>
                        <td class="font-monospace fw-bold">${item.qty}</td>
                        <td class="text-end font-monospace fw-bold text-success">${formatter.format(item.total_harga)}</td>
                    </tr>
                `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(err => {
                console.error(err); // Melihat detail error asli di Inspect Element (Console)
                tbody.innerHTML = `<tr><td colspan="8" class="text-danger py-4">Gagal memuat data dari server. Silakan coba lagi.</td></tr>`;
            });
    });
</script>
<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .card-radio:hover {
        background-color: var(--bs-gray-100);
        transition: background-color 0.2s ease-in-out;
    }
</style>
@endsection
