@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (MASTER PRODUK & STOK)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card > .card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-card .form-control,
    .ent-card .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .ent-card .form-control:focus,
    .ent-card .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-boxes fa-2x text-warning"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-warehouse me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} INVENTORY
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Modul Inventori &amp; Penjualan</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Manajemen Master Produk &amp; Stok</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola master komoditas barang koperasi, pasokan stok masuk, dan pemantauan stok aktif.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="ent-badge px-3 py-2" id="total-jenis-barang"
                            style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <i class="fas fa-cubes me-1"></i> Total: {{ count($produk) }} Item
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MENU PILIHAN INPUT UTAMA -->
<div class="row g-3 mb-4">

    <!-- KOLOM KIRI: FORM CREATE MASTER PRODUCT -->
    <div class="col-lg-6">
        <div class="ent-card p-4 h-100">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-primary text-white p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-plus-square fa-lg"></i>
                </div>
                <h6 class="fw-bold mb-0">1. Buat Master Produk Baru</h6>
            </div>
            <p class="opacity-75 small mb-3">Daftarkan nama komoditas/barang baru koperasi ke dalam database sistem terlebih dahulu.</p>

            <form id="form-master-produk" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label ent-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Kulkas Sharp 2 Pintu" required>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-label">Foto / Gambar Produk</label>
                    <input type="file" name="gambar_produk" class="form-control" accept="image/jpeg,image/png,image/jpg">
                    <div class="form-text opacity-75 small">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label ent-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Sembako">Sembako</option>
                            <option value="Furnitur">Furnitur</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label ent-label">Satuan Unit</label>
                        <input type="text" name="satuan" class="form-control" placeholder="Pcs / Unit / Pack" value="Pcs" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label ent-label">Est. Harga Beli (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_beli" class="form-control" placeholder="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label ent-label">Est. Harga Jual (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_jual" class="form-control" placeholder="0" required>
                    </div>
                </div>

                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 mt-1">
                    <i class="fas fa-save me-1"></i> Simpan Master Barang
                </button>
            </form>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM MASUKAN STOK BARANG -->
    <div class="col-lg-6">
        <div class="ent-card p-4 h-100">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-success text-white p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-dolly fa-lg"></i>
                </div>
                <h6 class="fw-bold mb-0">2. Masukkan Pasokan / Stok Barang</h6>
            </div>
            <p class="opacity-75 small mb-3">Tambahkan jumlah kuantitas fisik produk yang dibeli dari supplier untuk menambah persediaan ritel.</p>

            <form id="form-tambah-stok">
                @csrf
                <div class="mb-3">
                    <label class="form-label ent-label">Pilih Produk <span class="text-danger">*</span></label>
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
                        <label class="form-label ent-label">Jumlah Kuantitas Masuk <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_masuk" class="form-control" min="1" placeholder="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label ent-label">Harga Beli Satuan Baru (Rp)</label>
                        <input type="number" name="harga_beli" id="input-harga-beli-stok" class="form-control" placeholder="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-label">Tanggal Masuk Dokumen <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-label">Keterangan / Supplier</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Pembelian dari PT. Elektronik Indah">
                </div>

                <button type="submit" class="btn ent-btn ent-btn-success w-100 py-2 mt-1">
                    <i class="fas fa-plus-circle me-1"></i> Submit Stok Masuk
                </button>
            </form>
        </div>
    </div>

</div>

<!-- TABEL MONITORING STOK PRODUK AKTIF -->
<div class="ent-card mb-4">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2"
        style="background-color: rgba(79, 70, 229, 0.06);">
        <h6 class="fw-bold mb-0">
            <i class="fas fa-list-ol me-2 text-primary"></i>Status Inventori Produk Saat Ini
        </h6>
        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
            {{ count($produk) }} Produk Terdaftar
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-custom" id="table-produk">
            <thead>
                <tr>
                    <th class="ps-4">Gambar</th>
                    <th>Kode</th>
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
                    <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $p->kode_produk }}</td>
                    <td><strong>{{ $p->nama_produk }}</strong></td>
                    <td><span class="badge bg-light text-dark border">{{ $p->kategori }}</span></td>
                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($p->harga_beli_default, 0, ',', '.') }}</td>
                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($p->harga_jual_default, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($p->stok_aktual <= 0)
                            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2">0 (Kosong)</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-bold px-3 py-2">{{ $p->stok_aktual }}</span>
                        @endif
                    </td>
                    <td class="pe-4 text-center opacity-75">{{ $p->satuan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 opacity-75">Belum ada data master produk yang diinput.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#select-produk-stok').on('change', function() {
            let hargaBeliDefault = $(this).find(':selected').data('beli');
            if (hargaBeliDefault !== undefined && hargaBeliDefault !== '') {
                $('#input-harga-beli-stok').val(hargaBeliDefault);
            }
        });

        $('#form-master-produk').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('menu_koperasi_penjualan_product_koperasi_save_master') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            refreshDataProduk();
                            $('#form-master-produk')[0].reset();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Terjadi kesalahan.', 'error');
                }
            });
        });

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
                    Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Terjadi kesalahan.', 'error');
                }
            });
        });

        function refreshDataProduk() {
            $.ajax({
                url: "{{ route('menu_koperasi_penjualan_product_koperasi_get_data') }}",
                type: "GET",
                dataType: "JSON",
                success: function(res) {
                    if (res.status === 'success') {
                        let data = res.data || [];
                        let htmlTable = '';
                        let htmlSelect = '<option value="">-- Pilih Barang Terdaftar --</option>';

                        data.forEach(function(p) {
                            let formatBeli = 'Rp ' + (parseFloat(p.harga_beli_default) || 0).toLocaleString('id-ID');
                            let formatJual = 'Rp ' + (parseFloat(p.harga_jual_default) || 0).toLocaleString('id-ID');
                            let badgeStok = p.stok_aktual <= 0
                                ? `<span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2">0 (Kosong)</span>`
                                : `<span class="badge bg-success-subtle text-success fw-bold px-3 py-2">${p.stok_aktual}</span>`;

                            htmlTable += `
                                <tr>
                                    <td class="ps-4">
                                        <img src="${p.url_gambar || 'https://placehold.co/50x50?text=No+Image'}" alt="Produk" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${p.kode_produk}</td>
                                    <td><strong>${p.nama_produk}</strong></td>
                                    <td><span class="badge bg-light text-dark border">${p.kategori}</span></td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${formatBeli}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${formatJual}</td>
                                    <td class="text-center">${badgeStok}</td>
                                    <td class="pe-4 text-center opacity-75">${p.satuan}</td>
                                </tr>
                            `;

                            htmlSelect += `<option value="${p.id_produk}" data-beli="${p.harga_beli_default}">[${p.kode_produk}] ${p.nama_produk}</option>`;
                        });

                        $('#table-produk tbody').html(htmlTable || '<tr><td colspan="8" class="text-center py-5 opacity-75">Belum ada data master produk yang diinput.</td></tr>');
                        $('#select-produk-stok').html(htmlSelect);
                        $('#total-jenis-barang').html(`<i class="fas fa-cubes me-1"></i> Total: ${data.length} Item`);
                    }
                }
            });
        }
    });
</script>
@endsection
