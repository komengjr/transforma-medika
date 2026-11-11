@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: #ff6b6b;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
        font-size: 0.8rem !important;
    }

    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.7rem;
    }

    .summary-card {
        background: linear-gradient(135deg, var(--retro-dark) 0%, #2c2c35 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-green);
        padding: 1.5rem;
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-truck-loading text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Purchase Order (PO) Pembelian Barang</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bolder text-dark mb-0"><i class="fas fa-clipboard-list text-warning me-2"></i> Form Pencatatan PO Baru</h5>
    <button class="btn retro-btn retro-btn-success px-4 py-2" id="simpanTransaksi"><i class="fas fa-save me-1"></i> Simpan Transaksi PO</button>
</div>

<!-- Informasi Pembelian -->
<div class="retro-card p-4 mb-4 bg-white">
    <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Informasi Dokumen PO</h6>
    <form class="row g-3" id="formInfoPO">
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">No. PO</label>
            <input type="text" class="form-control retro-input" id="noPO" value="PO-{{ date('Ymd') }}-001" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Tanggal Pembelian</label>
            <input type="date" class="form-control retro-input" id="tglPO" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Supplier</label>
            <select class="form-select retro-input" id="supplierPO">
                <option value="">-- Pilih Supplier --</option>
                <option value="PT Medika Farma">PT Medika Farma</option>
                <option value="PT Kimia Sehat">PT Kimia Sehat</option>
                <option value="Apotek Sentosa">Apotek Sentosa</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Petugas Penerima</label>
            <input type="text" class="form-control retro-input" id="petugasPO" value="Agus Prasetyo">
        </div>
    </form>
</div>

<!-- Input Barang -->
<div class="retro-card p-4 mb-4 bg-white">
    <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-pills text-success me-2"></i> Tambah Item Obat / Barang</h6>
    <form id="formBarang" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Pilih Master Obat</label>
            <select class="form-select retro-input" id="pilihObat">
                <option value="">-- Pilih Obat --</option>
                @foreach ($data as $obat)
                <option value="{{ $obat->farm_data_obat_code }}" data-nama="{{ $obat->farm_data_obat_name }}">
                    [{{ $obat->farm_data_obat_code }}] {{ $obat->farm_data_obat_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-bold text-dark fs--1">Qty (Jumlah)</label>
            <input type="number" class="form-control retro-input" id="qtyBarang" min="1" value="1">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Harga Satuan (Rp)</label>
            <input type="text" class="form-control retro-input" id="hargaBarangFormat" placeholder="0" value="0">
            <input type="hidden" id="hargaBarang" value="0">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark fs--1">Tanggal Expired (Exp)</label>
            <input type="date" class="form-control retro-input" id="expBarang">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn retro-btn retro-btn-primary w-100 py-2" id="tambahBarang" title="Tambah ke Daftar">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>
</div>

<!-- Tabel Barang -->
<div class="retro-card p-4 mb-4 bg-white">
    <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-list-ul text-danger me-2"></i> Daftar Barang Pembelian PO</h6>
    <div class="table-responsive">
        <table class="table table-custom align-middle text-center w-100 mb-0" id="tabelPembelian">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th style="width: 80px;">Qty</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-end">Total Harga</th>
                    <th>Exp Date</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="dataPembelianTbody">
                <tr>
                    <td colspan="8" class="text-muted py-4 fw-bold">Belum ada item barang ditambahkan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Ringkasan Total -->
<div class="summary-card mb-4">
    <h5 class="fw-bolder mb-1"><i class="fas fa-file-invoice-dollar me-2"></i> Total Keseluruhan Pembelian PO</h5>
    <h2 id="totalPembelian" class="fw-bolder mb-0">Rp 0</h2>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let daftarBarang = [];

    // Helper format rupiah
    function formatRupiah(angka) {
        let numberString = String(angka).replace(/[^,\d]/g, "").toString();
        let split = numberString.split(",");
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        return split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    }

    // Input format harga satuan barang
    document.getElementById("hargaBarangFormat").addEventListener("input", function() {
        let formatted = formatRupiah(this.value);
        this.value = formatted;
        let rawValue = formatted.replace(/\./g, '');
        document.getElementById("hargaBarang").value = rawValue === '' ? 0 : rawValue;
    });

    // Event pilih dropdown obat untuk otomatis mengisi kode/nama
    document.getElementById("pilihObat").addEventListener("change", function() {
        let selectedOption = this.options[this.selectedIndex];
        let kode = selectedOption.value;
        // Jika ingin otomatis set fokus atau data lain bisa ditambahkan di sini
    });

    // Tambah Barang ke Tabel List
    document.getElementById("tambahBarang").addEventListener("click", () => {
        let selectObat = document.getElementById("pilihObat");
        let kode = selectObat.value;
        let nama = selectObat.options[selectObat.selectedIndex].getAttribute("data-nama");
        let qty = parseInt(document.getElementById("qtyBarang").value) || 0;
        let harga = parseInt(document.getElementById("hargaBarang").value) || 0;
        let exp = document.getElementById("expBarang").value;

        if (!kode || qty <= 0 || harga <= 0) {
            Swal.fire('Perhatian', 'Pilih obat, masukkan Qty, dan harga satuan dengan benar!', 'warning');
            return;
        }

        let total = qty * harga;

        // Cek apakah barang sudah ada di list, jika ada update qty & totalnya
        let existingIndex = daftarBarang.findIndex(item => item.kode === kode);
        if (existingIndex >= 0) {
            daftarBarang[existingIndex].qty += qty;
            daftarBarang[existingIndex].total = daftarBarang[existingIndex].qty * daftarBarang[existingIndex].harga;
        } else {
            daftarBarang.push({
                kode,
                nama,
                qty,
                harga,
                total,
                exp
            });
        }

        renderTable();
        clearFormBarang();
    });

    function renderTable() {
        let tbody = document.getElementById("dataPembelianTbody");
        tbody.innerHTML = "";
        let grandTotal = 0;

        if (daftarBarang.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-muted py-4 fw-bold">Belum ada item barang ditambahkan.</td></tr>`;
            document.getElementById("totalPembelian").innerText = "Rp 0";
            return;
        }

        daftarBarang.forEach((item, index) => {
            grandTotal += item.total;
            tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-danger fw-bold">${item.kode}</td>
                        <td class="fw-bolder text-dark text-start">${item.nama}</td>
                        <td>${item.qty}</td>
                        <td class="text-end">Rp ${item.harga.toLocaleString('id-ID')}</td>
                        <td class="text-end fw-bold text-success">Rp ${item.total.toLocaleString('id-ID')}</td>
                        <td>${item.exp || '-'}</td>
                        <td>
                            <button class="btn btn-sm retro-btn retro-btn-danger px-2 py-1 fs--2" onclick="hapusItem(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
        });

        document.getElementById("totalPembelian").innerText = `Rp ${grandTotal.toLocaleString('id-ID')}`;
    }

    function hapusItem(i) {
        daftarBarang.splice(i, 1);
        renderTable();
    }

    function clearFormBarang() {
        document.getElementById("pilihObat").value = "";
        document.getElementById("qtyBarang").value = 1;
        document.getElementById("hargaBarangFormat").value = "0";
        document.getElementById("hargaBarang").value = "0";
        document.getElementById("expBarang").value = "";
    }

    // Simpan Transaksi PO
    document.getElementById("simpanTransaksi").addEventListener("click", () => {
        let noPO = document.getElementById("noPO").value;
        let tglPO = document.getElementById("tglPO").value;
        let supplier = document.getElementById("supplierPO").value;
        let petugas = document.getElementById("petugasPO").value;

        if (!supplier) {
            Swal.fire('Perhatian', 'Silakan pilih Supplier terlebih dahulu!', 'warning');
            return;
        }

        if (daftarBarang.length === 0) {
            Swal.fire('Perhatian', 'Daftar barang pembelian masih kosong!', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi PO',
            text: `Simpan transaksi Purchase Order ${noPO}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan pengiriman data via AJAX ke backend Laravel di sini
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Purchase Order berhasil disimpan!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
</script>
@endsection
