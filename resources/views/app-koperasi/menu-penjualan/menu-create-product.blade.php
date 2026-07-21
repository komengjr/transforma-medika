<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Master Produk & Stok</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand-custom {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            background-color: #f1f3f5;
            color: #495057;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- TOP NAVIGATION HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 mb-4">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="#"><i class="fas fa-boxes me-2 text-warning"></i>KOPERASI - PORTAL PRODUK</a>
            <span class="navbar-text text-white-50 d-none d-sm-inline">Modul Inventori & Penjualan</span>
        </div>
    </nav>

    <div class="container pb-5">

        <!-- MENU PILIHAN INPUT UTAMA -->
        <div class="row g-4 mb-4">

            <!-- KOLOM KIRI: FORM CREATE MASTER PRODUCT -->
            <div class="col-md-6">
                <div class="card card-custom p-4 bg-white h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white p-2 rounded-3 me-3"><i class="fas fa-plus-square fa-lg"></i></div>
                        <h5 class="fw-bold text-dark mb-0">1. Buat Master Produk Baru</h5>
                    </div>
                    <p class="text-muted small">Daftarkan nama komoditas/barang baru koperasi ke dalam database sistem terlebih dahulu.</p>

                    <form id="form-master-produk" class="mt-2" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Produk *</label>
                            <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Kulkas Sharp 2 Pintu" required>
                        </div>

                        <!-- NEW: Input Gambar Produk -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto / Gambar Produk</label>
                            <input type="file" name="gambar_produk" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text text-muted small">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Input kategori dan satuan tetap sama seperti sebelumnya -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Sembako">Sembako</option>
                                    <option value="Furnitur">Furnitur</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Satuan Unit</label>
                                <input type="text" name="satuan" class="form-control" placeholder="Pcs / Unit / Pack" value="Pcs" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Est. Harga Beli (Rp) *</label>
                                <input type="number" name="harga_beli" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Est. Harga Jual (Rp) *</label>
                                <input type="number" name="harga_jual" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 mt-2">Simpan Master Barang</button>
                    </form>
                </div>
            </div>

            <!-- KOLOM KANAN: FORM MASUKAN STOK BARANG -->
            <div class="col-md-6">
                <div class="card card-custom p-4 bg-white h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white p-2 rounded-3 me-3"><i class="fas fa-dolly fa-lg"></i></div>
                        <h5 class="fw-bold text-dark mb-0">2. Masukkan Pasokan / Stok Barang</h5>
                    </div>
                    <p class="text-muted small">Tambahkan jumlah kuantitas fisik produk yang dibeli dari supplier untuk menambah persediaan ritel.</p>

                    <form id="form-tambah-stok" class="mt-2">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pilih Produk *</label>
                            <select name="produk_id" id="select-produk-stok" class="form-select" required>
                                <option value="">-- Pilih Barang Terdaftar --</option>
                                @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}" data-beli="{{ $p->harga_beli_default }}">
                                    [{{ $p->kode_produk }}] {{ $p->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Jumlah Kuantitas Masuk *</label>
                                <input type="number" name="jumlah_masuk" class="form-control" min="1" placeholder="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Harga Beli Satuan Baru (Rp)</label>
                                <input type="number" name="harga_beli" id="input-harga-beli-stok" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tanggal Masuk Dokumen *</label>
                            <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Keterangan / Supplier</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Pembelian dari PT. Elektronik Indah">
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-3">Submit Stok Masuk</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- TABEL MONITORING STOK PRODUK AKTIF -->
        <div class="card card-custom p-0 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-list-ol me-2 text-secondary"></i>Status Inventori Produk Saat Ini</h5>
                <span class="badge bg-secondary px-3 py-2" id="total-jenis-barang">Total: {{ count($produk) }} Item</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom" id="table-produk">
                    <thead>
                        <tr>
                            <th class="ps-4">Gambar</th> <!-- NEW -->
                            <th class="ps-4">Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Harga Jual</th>
                            <th class="text-center">Stok Aktif</th>
                            <th class="pe-4 text-center">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $p)
                        <tr>
                            <td class="ps-4">
                                @if($p->gambar_produk)
                                <img src="{{ asset('storage/produk/' . $p->gambar_produk) }}" alt="Produk" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <img src="https://placehold.co/50x50?text=No+Image" alt="No Image" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td class="ps-4 font-monospace fw-bold text-primary">{{ $p->kode_produk }}</td>
                            <td><strong>{{ $p->nama_produk }}</strong></td>
                            <td><span class="badge bg-light text-dark border">{{ $p->kategori }}</span></td>
                            <td class="text-end font-monospace">Rp {{ number_format($p->harga_beli_default, 0, ',', '.') }}</td>
                            <td class="text-end font-monospace">Rp {{ number_format($p->harga_jual_default, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($p->stok_aktual <= 0)
                                    <span class="badge bg-danger-subtle text-danger fw-bold fs-6 px-3">0 (Kosong)</span>
                                    @else
                                    <span class="badge bg-success-subtle text-success fw-bold fs-6 px-3">{{ $p->stok_aktual }}</span>
                                    @endif
                            </td>
                            <td class="pe-4 text-center text-muted">{{ $p->satuan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data master produk yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // Sinkronisasi otomatis harga beli default ketika nama produk dipilih di form stok
            $('#select-produk-stok').on('change', function() {
                let hargaBeliDefault = $(this).find(':selected').data('beli');
                if (hargaBeliDefault) {
                    $('#input-harga-beli-stok').val(hargaBeliDefault);
                }
            });

            // 1. Submit Form Master Produk via AJAX
            $('#form-master-produk').on('submit', function(e) {
                e.preventDefault();

                // Menggunakan FormData agar file gambar terbawa
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('menu_koperasi_penjualan_product_koperasi_save_master') }}",
                    type: "POST",
                    data: formData,
                    contentType: false, // Wajib jika memakai FormData
                    processData: false, // Wajib jika memakai FormData
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                refreshDataProduk();
                                $('#form-master-produk')[0].reset();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error');
                    }
                });
            });

            // 2. Submit Form Tambah Stok Masuk via AJAX
            $('#form-tambah-stok').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('menu_koperasi_penjualan_product_koperasi_save_stok') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Stok Ditambahkan', res.message, 'success').then(() => {
                                refreshDataProduk();
                                $('#form-tambah-stok')[0].reset();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error');
                    }
                });
            });

            // Penyesuaian render otomatis pada fungsi refreshDataProduk() bagian loop data.forEach:
            function refreshDataProduk() {
                $.ajax({
                    url: "{{ route('menu_koperasi_penjualan_product_koperasi_get_data') }}",
                    type: "GET",
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status === 'success') {
                            let data = res.data;
                            let htmlTable = '';
                            let htmlSelect = '<option value="">-- Pilih Barang Terdaftar --</option>';

                            data.forEach(function(p) {
                                let formatBeli = 'Rp ' + parseFloat(p.harga_beli_default).toLocaleString('id-ID');
                                let formatJual = 'Rp ' + parseFloat(p.harga_jual_default).toLocaleString('id-ID');
                                let badgeStok = p.stok_aktual <= 0 ?
                                    `<span class="badge bg-danger-subtle text-danger fw-bold fs-6 px-3">0 (Kosong)</span>` :
                                    `<span class="badge bg-success-subtle text-success fw-bold fs-6 px-3">${p.stok_aktual}</span>`;

                                htmlTable += `
                        <tr>
                            <td class="ps-4">
                                <img src="${p.url_gambar}" alt="Produk" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="font-monospace fw-bold text-primary">${p.kode_produk}</td>
                            <td><strong>${p.nama_produk}</strong></td>
                            <td><span class="badge bg-light text-dark border">${p.kategori}</span></td>
                            <td class="text-end font-monospace">${formatBeli}</td>
                            <td class="text-end font-monospace">${formatJual}</td>
                            <td class="text-center">${badgeStok}</td>
                            <td class="pe-4 text-center text-muted">${p.satuan}</td>
                        </tr>
                    `;

                                htmlSelect += `<option value="${p.id_produk}" data-beli="${p.harga_beli_default}">[${p.kode_produk}] ${p.nama_produk}</option>`;
                            });

                            $('#table-produk tbody').html(htmlTable || '<tr><td colspan="8" class="text-center py-5 text-muted">Belum ada data master produk yang diinput.</td></tr>');
                            $('#select-produk-stok').html(htmlSelect);
                            $('#total-jenis-barang').text('Total: ' + data.length + ' Item');
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
