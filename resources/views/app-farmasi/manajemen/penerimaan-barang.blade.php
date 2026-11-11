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
                            <i class="fas fa-boxes-stacked text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Penerimaan Barang (Purchase Order)</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM UTAMA PENERIMAAN BARANG -->
<form id="formPO" class="fade-in">
    <div class="retro-card p-4 mb-4 bg-white">
        <h5 class="fw-bolder text-dark mb-3"><i class="fas fa-file-invoice text-warning me-2"></i> Informasi Dokumen Penerimaan</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Nomor PO</label>
                <input type="text" class="form-control retro-input" id="noPO" placeholder="Masukkan nomor PO..." required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Tanggal Penerimaan</label>
                <input type="date" class="form-control retro-input" id="tglTerima" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Supplier</label>
                <input type="text" class="form-control retro-input" id="supplier" placeholder="Nama supplier pengirim..." required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Diterima Oleh</label>
                <input type="text" class="form-control retro-input" id="diterima" value="Agus Prasetyo" required>
            </div>
        </div>
    </div>

    <!-- DETAIL BARANG -->
    <div class="retro-card p-4 mb-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bolder text-dark mb-0"><i class="fas fa-pills text-success me-2"></i> Detail Barang Diterima</h5>
            <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-3 py-2" id="tambahBarang">
                <i class="fas fa-plus-circle me-1"></i> Tambah Baris Barang
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle text-center w-100 mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Pilih / Nama Barang</th>
                        <th style="width: 120px;">Qty PO</th>
                        <th style="width: 120px;">Qty Diterima</th>
                        <th style="width: 120px;">Satuan</th>
                        <th>Keterangan / Kondisi</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyBarang">
                    <tr>
                        <td>1</td>
                        <td>
                            <select class="form-select retro-input" required>
                                <option value="">-- Pilih Master Obat --</option>
                                @foreach ($data as $obat)
                                <option value="{{ $obat->farm_data_obat_code }}">{{ $obat->farm_data_obat_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" class="form-control retro-input text-center" placeholder="0" min="0" required></td>
                        <td><input type="number" class="form-control retro-input text-center" placeholder="0" min="0" required></td>
                        <td><input type="text" class="form-control retro-input text-center" placeholder="Satuan"></td>
                        <td><input type="text" class="form-control retro-input" placeholder="Keterangan..."></td>
                        <td>
                            <button type="button" class="btn btn-sm retro-btn retro-btn-danger px-2 py-1 btn-hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn retro-btn retro-btn-success px-5 py-2">
                <i class="fas fa-save me-1"></i> Simpan Data Penerimaan
            </button>
        </div>
    </div>
</form>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<audio id="popSound" src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_1e1b4f8c5f.mp3?filename=pop-94319.mp3"></audio>

<script>
    const tbody = document.getElementById('tbodyBarang');
    const tambahBtn = document.getElementById('tambahBarang');
    const formPO = document.getElementById('formPO');
    const sound = document.getElementById('popSound');

    // Data obat options dari backend untuk baris baru
    const optionsObat = `
            <option value="">-- Pilih Master Obat --</option>
            @foreach ($data as $obat)
                <option value="{{ $obat->farm_data_obat_code }}">{{ $obat->farm_data_obat_name }}</option>
            @endforeach
        `;

    // Tambah baris barang
    tambahBtn.addEventListener('click', () => {
        const row = document.createElement('tr');
        row.classList.add('fade-in');
        row.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>
                    <select class="form-select retro-input" required>
                        ${optionsObat}
                    </select>
                </td>
                <td><input type="number" class="form-control retro-input text-center" placeholder="0" min="0" required></td>
                <td><input type="number" class="form-control retro-input text-center" placeholder="0" min="0" required></td>
                <td><input type="text" class="form-control retro-input text-center" placeholder="Satuan"></td>
                <td><input type="text" class="form-control retro-input" placeholder="Keterangan..."></td>
                <td>
                    <button type="button" class="btn btn-sm retro-btn retro-btn-danger px-2 py-1 btn-hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
        tbody.appendChild(row);
        try {
            sound.currentTime = 0;
            sound.play();
        } catch (e) {}
        updateNo();
    });

    // Hapus baris barang
    tbody.addEventListener('click', (e) => {
        if (e.target.closest('.btn-hapus')) {
            const row = e.target.closest('tr');
            try {
                sound.currentTime = 0;
                sound.play();
            } catch (e) {}
            row.remove();
            updateNo();
        }
    });

    // Update nomor urut otomatis
    function updateNo() {
        [...tbody.children].forEach((tr, index) => {
            tr.children[0].textContent = index + 1;
        });
    }

    // Simpan form
    formPO.addEventListener('submit', (e) => {
        e.preventDefault();
        try {
            sound.currentTime = 0;
            sound.play();
        } catch (e) {}

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data penerimaan barang berhasil disimpan!',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            formPO.reset();
            tbody.innerHTML = '';
            tambahBtn.click(); // tambah satu baris kosong default
        });
    });
</script>
@endsection
