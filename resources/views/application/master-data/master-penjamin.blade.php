@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
        background-color: #ffffff;
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
        letter-spacing: 0.5px;
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
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
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
        letter-spacing: 0.5px;
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

    .list-group-item-penjamin {
        border: 2px solid var(--retro-dark) !important;
        margin-bottom: 8px;
        border-radius: 8px !important;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 2px 2px 0px var(--retro-dark);
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .list-group-item-penjamin:hover {
        background-color: var(--retro-yellow);
        transform: translate(-1px, -1px);
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .list-group-item-penjamin.active {
        background-color: var(--retro-cyan) !important;
        color: var(--retro-dark) !important;
        border-color: var(--retro-dark) !important;
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-handshake text-dark fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-database me-1"></i> Master Data
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Manajemen <span class="fw-normal">Penjamin & Sub Penjamin</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN LAYOUT -->
<div class="row g-4">
    <!-- KOLOM KIRI: PENJAMIN UTAMA -->
    <div class="col-lg-4">
        <div class="retro-card h-100">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder fs-0"><i class="fas fa-building me-1"></i> Penjamin Utama</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-2 py-1 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-penjamin">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <div class="mb-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white text-dark" style="border: 2px solid var(--retro-dark); border-right: none;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="search-penjamin-utama" class="form-control retro-input form-control-sm" placeholder="Cari penjamin utama...">
                    </div>
                </div>

                <div class="list-group" id="list-penjamin-utama" style="max-height: 440px; overflow-y: auto;">
                    @forelse ($penjaminUtama as $utama)
                    <div class="list-group-item list-group-item-penjamin p-2 px-3 d-flex justify-content-between align-items-center @if($loop->first) active @endif"
                        data-id="{{ $utama->id }}"
                        data-nama="{{ $utama->nama_penjamin }}">
                        <div class="flex-grow-1 text-truncate pe-2 item-click-target">
                            <i class="fas fa-folder-open me-2"></i>
                            <span class="nama-penjamin-text fw-bold">{{ $utama->nama_penjamin }}</span>
                            <br>
                            <small>
                                <span class="badge bg-dark text-warning" style="font-size: 0.6rem;">
                                    {{ $utama->jenis_kategori ?? 'Umum / Lainnya' }}
                                </span>
                            </small>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-utama"
                                data-id="{{ $utama->id }}"
                                data-nama="{{ $utama->nama_penjamin }}"
                                data-kategori="{{ $utama->jenis_kategori }}"
                                title="Edit Penjamin Utama" style="font-size: 0.65rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <i class="fas fa-chevron-right fs--2 text-muted ms-1"></i>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted fw-bold fst-italic">Belum ada penjamin utama.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL SUB PENJAMIN -->
    <div class="col-lg-8">
        <div class="retro-card h-100">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark); color: white;">
                <h5 class="mb-0 text-white fw-bolder fs-0">
                    <i class="fas fa-list-alt text-info me-1"></i> Sub Penjamin untuk: <span id="selected-penjamin-title" class="text-warning text-decoration-underline">Pilih Penjamin</span>
                </h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3 py-1 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-sub-penjamin" id="btn-tambah-sub-trigger" disabled>
                    <i class="fas fa-plus-circle me-1"></i> Tambah Sub Penjamin
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <div class="table-responsive">
                    <table id="table-sub-penjamin" class="table table-custom align-middle w-100 mb-0 fs--1 table-bordered" style="border: 2px solid var(--retro-dark);">
                        <thead>
                            <tr>
                                <th class="py-2 px-3 text-center" style="width: 40px;">No</th>
                                <th class="py-2 px-3">Nama Perusahaan / Asuransi</th>
                                <th class="py-2 px-3 text-center">Status</th>
                                <th class="py-2 px-3 text-center">Metode Bayar</th>
                                <th class="py-2 px-3">Kontak PIC</th>
                                <th class="py-2 px-3 text-center">Agreement / Ref</th>
                                <th class="py-2 px-3 text-center" style="width: 85px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sub-penjamin-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PENJAMIN UTAMA -->
<div class="modal fade" id="modal-tambah-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-plus-circle me-1"></i> Tambah Penjamin Utama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('master_penjamin_utama_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Penjamin Utama</label>
                        <input type="text" class="form-control retro-input" name="nama_penjamin" placeholder="Contoh: BPJS, Asuransi Swasta, Umum..." required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SUB PENJAMIN (DISESUAIKAN DENGAN SKEMA TABEL TERBARU) -->
<div class="modal fade" id="modal-tambah-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-plus-circle me-1"></i> Form Sub Penjamin / Rekanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                <form action="{{ route('sub_penjamin_store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="modal-penjamin-id" name="penjamin_id">

                    <div class="row g-3">
                        <!-- SECTION 1: IDENTITAS & KONTRAK -->
                        <div class="col-md-12">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-info-circle me-1"></i> Identitas & Kontrak</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Nama Perusahaan / Asuransi*</label>
                            <input type="text" class="form-control retro-input" name="nama_sub_penjamin" placeholder="Nama Perusahaan..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">No. Kontrak / SPK / MoU</label>
                            <input type="text" class="form-control retro-input" name="no_ref" placeholder="No Referensi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Tgl. Mulai</label>
                            <input type="date" class="form-control retro-input" name="tgl_mulai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Tgl. Selesai</label>
                            <input type="date" class="form-control retro-input" name="tgl_selesai">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark fs--1">Catatan Pelayanan</label>
                            <textarea class="form-control retro-input" name="catatan_pelayanan" rows="2" placeholder="Catatan khusus pelayanan..."></textarea>
                        </div>

                        <!-- SECTION 2: PEMBAYARAN & KEUANGAN -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-calculator me-1"></i> Pengaturan Pembayaran & Keuangan</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Metode Pembayaran</label>
                            <select class="form-select retro-input" name="tipe_pembayaran" required>
                                <option value="CASH_DI_AWAL">Cash di Awal</option>
                                <option value="CORPORATE_BILLING">Corporate Billing</option>
                                <option value="INSURANCE_CLAIM">Insurance Claim</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Jatuh Tempo (Hari)</label>
                            <input type="number" class="form-control retro-input" name="jatuh_tempo_hari" value="30">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Min DP (%)</label>
                            <input type="number" step="0.01" class="form-control retro-input" name="min_dp_persen" value="0.00">
                        </div>

                        <!-- SKEMA TANGGUNGAN (COVERAGE RULE) -->
                        <div class="col-md-12 pt-2">
                            <div class="row g-2 p-3 border border-dark rounded" style="background-color: var(--retro-bg);">
                                <div class="col-md-12 mb-1">
                                    <label class="fw-bold text-dark fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Biaya (Coverage Rule)</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark fs--1">Pola Tanggungan</label>
                                    <select class="form-select retro-input form-select-sm" name="pola_tanggungan" id="add-pola-tanggungan">
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 add-wrapper-tanggungan d-none" id="add-wrapper-persen">
                                    <label class="form-label fw-bold text-dark fs--1">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control retro-input form-select-sm" name="tanggungan_perusahaan_persen" value="0.00">
                                </div>
                                <div class="col-md-4 add-wrapper-tanggungan d-none" id="add-wrapper-plafon">
                                    <label class="form-label fw-bold text-dark fs--1">Maks. Plafon (Rp)</label>
                                    <input type="number" step="0.01" class="form-control retro-input form-select-sm" name="tanggungan_perusahaan_maksimal_rp" value="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: KONTAK & ALAMAT UTAMA -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas id-card me-1"></i> Kontak & Alamat Utama</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">No. Telp Perusahaan</label>
                            <input type="text" class="form-control retro-input" name="telp_perusahaan" placeholder="No Telepon...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Alamat</label>
                            <textarea class="form-control retro-input" name="alamat" rows="2" placeholder="Alamat perusahaan..."></textarea>
                        </div>

                        <!-- SECTION 4: MULTI-PIC KEUANGAN -->
                        <div class="col-md-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-1">
                                <h6 class="fw-bold text-success mb-0"><i class="fas fa-id-card me-1"></i> PIC Keuangan / Klaim</h6>
                                <button type="button" class="btn btn-sm retro-btn retro-btn-primary py-0 px-2 fs--2" id="btn-tambah-pic-row">
                                    <i class="fas fa-plus"></i> Tambah PIC
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="container-pic-rows" class="d-flex flex-column gap-2">
                                <div class="card p-2 bg-light border border-dark pic-item-row">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control retro-input form-control-sm" name="pics[0][nama_pic]" placeholder="Nama PIC..." required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control retro-input form-control-sm" name="pics[0][telepon]" placeholder="No. HP...">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control retro-input form-control-sm" name="pics[0][email]" placeholder="Email...">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 5: KETENTUAN KHUSUS & STATUS -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-cog me-1"></i> Ketentuan & Status</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input border-dark" type="checkbox" name="wajib_surat_garansi" value="1" id="add_wajib_lo">
                                <label class="form-check-label fw-bold text-dark fs--1" for="add_wajib_lo">Wajib melampirkan Surat Garansi / LoG (Letter of Guarantee)</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input border-dark" type="checkbox" value="1" name="status_aktif" id="add_status_aktif" checked>
                                <label class="form-check-label fw-bold text-dark fs--1" for="add_status_aktif">Status Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT SUB PENJAMIN (DISESUAIKAN DENGAN SKEMA TABEL TERBARU) -->
<div class="modal fade" id="modal-edit-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-edit me-1"></i> Edit Sub Penjamin / Rekanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                <form id="form-edit-sub-penjamin" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- SECTION 1: IDENTITAS & KONTRAK -->
                        <div class="col-md-12">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-info-circle me-1"></i> Identitas & Kontrak</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Nama Perusahaan / Asuransi*</label>
                            <input type="text" class="form-control retro-input" id="edit-nama-sub-penjamin" name="nama_sub_penjamin" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">No. Kontrak / SPK / MoU</label>
                            <input type="text" class="form-control retro-input" id="edit-no-ref" name="no_ref" placeholder="No Referensi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Tgl. Mulai</label>
                            <input type="date" class="form-control retro-input" id="edit-tgl-mulai" name="tgl_mulai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Tgl. Selesai</label>
                            <input type="date" class="form-control retro-input" id="edit-tgl-selesai" name="tgl_selesai">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark fs--1">Catatan Pelayanan</label>
                            <textarea class="form-control retro-input" id="edit-catatan-pelayanan" name="catatan_pelayanan" rows="2" placeholder="Catatan khusus pelayanan..."></textarea>
                        </div>

                        <!-- SECTION 2: PEMBAYARAN & KEUANGAN -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-calculator me-1"></i> Pengaturan Pembayaran & Keuangan</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Metode Pembayaran</label>
                            <select class="form-select retro-input" id="edit-tipe-pembayaran" name="tipe_pembayaran" required>
                                <option value="CASH_DI_AWAL">Cash di Awal</option>
                                <option value="CORPORATE_BILLING">Corporate Billing</option>
                                <option value="INSURANCE_CLAIM">Insurance Claim</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Jatuh Tempo (Hari)</label>
                            <input type="number" class="form-control retro-input" id="edit-jatuh-tempo" name="jatuh_tempo_hari">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Min DP (%)</label>
                            <input type="number" step="0.01" class="form-control retro-input" id="edit-min-dp" name="min_dp_persen">
                        </div>

                        <!-- SKEMA TANGGUNGAN (COVERAGE RULE) MODAL EDIT -->
                        <div class="col-md-12 pt-2">
                            <div class="row g-2 p-3 border border-dark rounded" style="background-color: var(--retro-bg);">
                                <div class="col-md-12 mb-1">
                                    <label class="fw-bold text-dark fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Biaya (Coverage Rule)</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark fs--1">Pola Tanggungan</label>
                                    <select class="form-select retro-input form-select-sm" name="pola_tanggungan" id="edit-pola-tanggungan">
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 edit-wrapper-tanggungan d-none" id="edit-wrapper-persen">
                                    <label class="form-label fw-bold text-dark fs--1">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control retro-input form-select-sm" id="edit-tanggungan-persen" name="tanggungan_perusahaan_persen" value="0.00">
                                </div>
                                <div class="col-md-4 edit-wrapper-tanggungan d-none" id="edit-wrapper-plafon">
                                    <label class="form-label fw-bold text-dark fs--1">Maks. Plafon (Rp)</label>
                                    <input type="number" step="0.01" class="form-control retro-input form-select-sm" id="edit-tanggungan-plafon" name="tanggungan_perusahaan_maksimal_rp" value="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: KONTAK & ALAMAT UTAMA -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-id-card me-1"></i> Kontak & Alamat Utama</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">No. Telp Perusahaan</label>
                            <input type="text" class="form-control retro-input" id="edit-telp-perusahaan" name="telp_perusahaan" placeholder="No Telepon...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Alamat</label>
                            <textarea class="form-control retro-input" id="edit-alamat" name="alamat" rows="2" placeholder="Alamat perusahaan..."></textarea>
                        </div>

                        <!-- SECTION 4: MULTI-PIC KEUANGAN -->
                        <div class="col-md-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-1">
                                <h6 class="fw-bold text-success mb-0"><i class="fas fa-id-card me-1"></i> PIC Keuangan / Klaim</h6>
                                <button type="button" class="btn btn-sm retro-btn retro-btn-primary py-0 px-2 fs--2" id="btn-tambah-pic-row-edit">
                                    <i class="fas fa-plus"></i> Tambah PIC
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="container-pic-rows-edit" class="d-flex flex-column gap-2"></div>
                        </div>

                        <!-- SECTION 5: KETENTUAN KHUSUS & STATUS -->
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold text-success border-bottom pb-1 mb-0"><i class="fas fa-cog me-1"></i> Ketentuan & Status</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input border-dark" type="checkbox" name="wajib_surat_garansi" value="1" id="edit_wajib_lo">
                                <label class="form-check-label fw-bold text-dark fs--1" for="edit_wajib_lo">Wajib melampirkan Surat Garansi / LoG (Letter of Guarantee)</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input border-dark" type="checkbox" value="1" name="status_aktif" id="edit_status_aktif">
                                <label class="form-check-label fw-bold text-dark fs--1" for="edit_status_aktif">Status Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENGATURAN TARIF (DINAMIS 3 TABEL) -->
<div class="modal fade" id="modal-pengaturan-tarif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-cyan);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-tags me-1"></i> Pengaturan Tarif Khusus: <span id="title-tarif-nama" class="text-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-0 bg-white">
                <div class="row g-0 h-100">
                    <!-- KOLOM KIRI: FORM TAMBAH -->
                    <div class="col-md-4 p-4 border-end border-dark bg-light" style="max-height: 500px; overflow-y: auto;">
                        <h6 class="fw-bold text-dark border-bottom border-dark pb-2 mb-3"><i class="fas fa-plus-circle me-1"></i> Tambah Tarif</h6>
                        <form id="form-pengaturan-tarif">
                            @csrf
                            <input type="hidden" name="sub_penjamin_id" id="tarif-sub-id">
                            <div class="mb-3 p-3 border border-dark rounded bg-warning bg-opacity-10">
                                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-copy me-1"></i> Salin Data dari Sub Penjamin Lain</label>
                                <div class="input-group input-group-sm">
                                    <select class="form-select retro-input form-select-sm" id="select-sumber-sub-penjamin">
                                        <option value="">-- Pilih Sub Penjamin Sumber --</option>
                                    </select>
                                    <button type="button" class="btn retro-btn retro-btn-warning px-3" id="btn-proses-salin-tarif">
                                        <i class="fas fa-file-import"></i> Salin
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Menyalin semua data tarif IGD, Poli, dan Ranap ke sub penjamin ini.</small>
                            </div>
                            <hr class="border-dark my-3">

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark fs--1">Kategori Layanan</label>
                                <select class="form-select retro-input" name="kategori_layanan" id="select-kategori-tarif" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <option value="IGD">Tarif IGD</option>
                                    <option value="POLI">Tarif Poliklinik (Rajal)</option>
                                    <option value="RANAP">Tarif Rawat Inap (Ranap)</option>
                                </select>
                            </div>

                            <!-- FORM KHUSUS IGD -->
                            <div id="form-group-igd" class="d-none dynamic-tarif-form p-3 mb-3 border border-dark rounded bg-white">
                                <h6 class="fw-bold text-danger border-bottom pb-1 fs--1"><i class="fas fa-ambulance"></i> Form Tarif IGD</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Kategori Biaya</label>
                                    <select class="form-select form-select-sm retro-input" name="igd_kategori_biaya">
                                        <option value="ADMINISTRASI">Administrasi</option>
                                        <option value="JASA_DOKTER_IGD">Jasa Dokter IGD</option>
                                        <option value="SARANA_IGD">Sarana IGD</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Nama Tarif</label>
                                    <input type="text" class="form-control form-control-sm retro-input" name="igd_nama_tarif" placeholder="Cth: Konsultasi Dokter Jaga">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Nominal Tarif (Rp)</label>
                                    <input type="number" class="form-control form-control-sm retro-input" name="igd_tarif" placeholder="0">
                                </div>
                            </div>

                            <!-- FORM KHUSUS POLI -->
                            <div id="form-group-poli" class="d-none dynamic-tarif-form p-3 mb-3 border border-dark rounded bg-white">
                                <h6 class="fw-bold text-success border-bottom pb-1 fs--1"><i class="fas fa-stethoscope"></i> Form Tarif Poliklinik</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Pilih Poliklinik</label>
                                    <select class="form-select form-select-sm retro-input" name="poli_id" id="select-master-poli">
                                        <option value="">-- Memuat data Poli... --</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Kategori Biaya</label>
                                    <select class="form-select form-select-sm retro-input" name="poli_kategori_biaya">
                                        <option value="ADMINISTRASI">Administrasi</option>
                                        <option value="JASA_DOKTER">Jasa Dokter</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Nama Tarif</label>
                                    <input type="text" class="form-control form-control-sm retro-input" name="poli_nama_tarif" placeholder="Cth: Jasa Konsultasi Spesialis">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Nominal Tarif (Rp)</label>
                                    <input type="number" class="form-control form-control-sm retro-input" name="poli_tarif" placeholder="0">
                                </div>
                            </div>

                            <!-- FORM KHUSUS RAWAT INAP (RANAP) -->
                            <div id="form-group-ranap" class="d-none dynamic-tarif-form p-3 mb-3 border border-dark rounded bg-white">
                                <h6 class="fw-bold text-primary border-bottom pb-1 fs--1"><i class="fas fa-procedures"></i> Form Tarif Rawat Inap</h6>

                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Pilih Ruangan</label>
                                    <select class="form-select form-select-sm retro-input" name="ruangan_id" id="select-master-ruangan">
                                        <option value="">-- Memuat data Ruangan... --</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Pilih Bed (Opsional)</label>
                                    <select class="form-select form-select-sm retro-input" name="bed_id" id="select-master-bed" disabled>
                                        <option value="">-- Pilih Ruangan Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                <input type="hidden" name="ranap_kelas" id="hidden-ranap-kelas">

                                <div class="mb-2 mt-3 border-top border-dark pt-2">
                                    <label class="form-label fw-bold text-dark fs--2">Tarif Kamar / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm retro-input" name="ranap_tarif_kamar" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Tarif Visite Dokter / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm retro-input" name="ranap_tarif_visite" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Tarif Askep / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm retro-input" name="ranap_tarif_askep" placeholder="0">
                                </div>
                            </div>

                            <!-- SKEMA TANGGUNGAN KHUSUS LAYANAN INI -->
                            <div class="p-3 mb-3 border border-dark rounded bg-light" id="form-group-coverage" style="display: none;">
                                <h6 class="fw-bold text-dark border-bottom border-dark pb-1 fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Tarif Ini</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark fs--2">Aturan Tanggungan</label>
                                    <select class="form-select form-select-sm retro-input" name="pola_tanggungan" id="tarif-pola-tanggungan">
                                        <option value="IKUT_ATURAN_INDUK">Ikut Aturan Induk (Default)</option>
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="mb-2 tarif-wrapper-tanggungan d-none" id="tarif-wrapper-persen">
                                    <label class="form-label fw-bold text-dark fs--2">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm retro-input" name="tanggungan_perusahaan_persen" value="0">
                                </div>
                                <div class="mb-2 tarif-wrapper-tanggungan d-none" id="tarif-wrapper-plafon">
                                    <label class="form-label fw-bold text-dark fs--2">Maks. Tanggungan (Rp)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm retro-input" name="tanggungan_perusahaan_maksimal_rp" value="0">
                                </div>
                            </div>

                            <button type="submit" class="btn retro-btn retro-btn-primary w-100 btn-sm mt-2" id="btn-save-tarif" disabled>Simpan Tarif</button>
                        </form>
                    </div>

                    <!-- KOLOM KANAN: TABEL LISTING -->
                    <div class="col-md-8 p-4">
                        <h6 class="fw-bold text-dark border-bottom border-dark pb-2 mb-3"><i class="fas fa-list me-1"></i> Daftar Tarif Layanan</h6>
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-custom align-middle w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th>Layanan</th>
                                        <th>Detail Kategori / Nama Tarif</th>
                                        <th class="text-end">Rincian Harga (Rp)</th>
                                        <th class="text-center" style="width: 70px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-list-tarif">
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Pilih Kategori Layanan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENGATURAN PEMERIKSAAN -->
<div class="modal fade" id="modal-pengaturan-pemeriksaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-pink);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-stethoscope me-1"></i> Pengaturan Harga Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form id="form-pengaturan-pemeriksaan" method="POST">
                    @csrf
                    <input type="hidden" name="sub_penjamin_id" id="pemeriksaan-sub-id">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <input type="text" class="form-control retro-input bg-light text-muted" id="pemeriksaan-sub-nama" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Jenis Pemeriksaan</label>
                        <select class="form-select retro-input" name="jenis_pemeriksaan" required>
                            <option value="Laboratorium">Laboratorium</option>
                            <option value="Radiologi">Radiologi</option>
                            <option value="Fisioterapi">Fisioterapi</option>
                            <option value="Poliklinik Spesialis">Poliklinik Spesialis</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Harga Acuan Khusus (Rp)</label>
                        <input type="number" class="form-control retro-input" name="harga_khusus" placeholder="Contoh: 150000" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-info btn-sm px-4">Simpan Pemeriksaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let currentSubPenjaminData = [];
    let subTable;
    let picIndexAdd = 1;
    let picIndexEdit = 1;

    $(document).ready(function() {
        $('#add-pola-tanggungan').on('change', function() {
            let val = $(this).val();
            $('.add-wrapper-tanggungan').addClass('d-none');
            if (val === 'SPLIT_PERSENTASE') {
                $('#add-wrapper-persen').removeClass('d-none');
            } else if (val === 'SPLIT_PLAFON') {
                $('#add-wrapper-plafon').removeClass('d-none');
            }
        });

        $('#edit-pola-tanggungan').on('change', function() {
            let val = $(this).val();
            $('.edit-wrapper-tanggungan').addClass('d-none');
            if (val === 'SPLIT_PERSENTASE') {
                $('#edit-wrapper-persen').removeClass('d-none');
            } else if (val === 'SPLIT_PLAFON') {
                $('#edit-wrapper-plafon').removeClass('d-none');
            }
        });

        subTable = $('#table-sub-penjamin').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari sub penjamin...",
                emptyTable: "Pilih penjamin utama untuk melihat data."
            },
            pageLength: 10
        });

        $('#btn-tambah-pic-row').on('click', function() {
            let rowHtml = `
            <div class="card p-2 bg-light border border-dark pic-item-row">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control retro-input form-control-sm" name="pics[${picIndexAdd}][nama_pic]" placeholder="Nama PIC..." required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control retro-input form-control-sm" name="pics[${picIndexAdd}][telepon]" placeholder="No. HP...">
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control retro-input form-control-sm" name="pics[${picIndexAdd}][email]" placeholder="Email...">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
            $('#container-pic-rows').append(rowHtml);
            picIndexAdd++;
        });

        $('#btn-tambah-pic-row-edit').on('click', function() {
            let rowHtml = `
            <div class="card p-2 bg-light border border-dark pic-item-row-edit">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control retro-input form-control-sm" name="pics[${picIndexEdit}][nama_pic]" placeholder="Nama PIC..." required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control retro-input form-control-sm" name="pics[${picIndexEdit}][telepon]" placeholder="No. HP...">
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control retro-input form-control-sm" name="pics[${picIndexEdit}][email]" placeholder="Email...">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
            $('#container-pic-rows-edit').append(rowHtml);
            picIndexEdit++;
        });

        $(document).on('click', '.btn-hapus-pic', function() {
            let container = $(this).closest('#container-pic-rows, #container-pic-rows-edit');
            if (container.find('.card').length > 1) {
                $(this).closest('.card').remove();
            } else {
                Swal.fire('Perhatian', 'Minimal harus ada 1 form PIC.', 'warning');
            }
        });

        triggerFirstVisiblePenjamin();
    });

    function triggerFirstVisiblePenjamin() {
        let firstItem = $('#list-penjamin-utama .list-group-item-penjamin:visible').first();
        if (firstItem.length > 0) {
            firstItem.find('.item-click-target').trigger('click');
        } else {
            $('#selected-penjamin-title').text('Tidak ada data');
            $('#btn-tambah-sub-trigger').prop('disabled', true);
            subTable.clear().draw();
        }
    }

    $(document).on('click', '.list-group-item-penjamin .item-click-target', function(e) {
        e.stopPropagation();
        let parentItem = $(this).closest('.list-group-item-penjamin');
        $('.list-group-item-penjamin').removeClass('active');
        parentItem.addClass('active');

        let penjaminId = parentItem.data('id');
        let penjaminNama = parentItem.data('nama');

        $('#selected-penjamin-title').text(penjaminNama + ' (Memuat...)');
        $('#modal-penjamin-id').val(penjaminId);
        $('#btn-tambah-sub-trigger').prop('disabled', true);
        subTable.clear().draw();

        $.ajax({
            url: `/master-data/penjamin/get-sub/${penjaminId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#selected-penjamin-title').text(penjaminNama);
                    $('#btn-tambah-sub-trigger').prop('disabled', false);
                    currentSubPenjaminData = response.data;
                    renderSubPenjaminTable(currentSubPenjaminData);
                } else {
                    $('#selected-penjamin-title').text(penjaminNama + ' (Gagal memuat)');
                    Swal.fire('Error', 'Gagal memuat data sub penjamin.', 'error');
                }
            },
            error: function() {
                $('#selected-penjamin-title').text(penjaminNama + ' (Gagal memuat)');
                Swal.fire('Error', 'Terjadi kesalahan jaringan atau server.', 'error');
            }
        });
    });

    function renderSubPenjaminTable(dataArray) {
        subTable.clear();
        if (dataArray && dataArray.length > 0) {
            dataArray.forEach((sub, index) => {
                let badgeBilling = 'bg-secondary';
                if (sub.tipe_pembayaran === 'CORPORATE_BILLING') badgeBilling = 'bg-warning text-dark';
                else if (sub.tipe_pembayaran === 'INSURANCE_CLAIM') badgeBilling = 'bg-info text-dark';
                else badgeBilling = 'bg-success text-white';

                let rawStatus = sub.status_aktif !== undefined ? sub.status_aktif : 1;
                let statusVal = Number(rawStatus);
                let statusBadge = (statusVal === 1) ?
                    '<span class="retro-badge bg-success text-white">Aktif</span>' :
                    '<span class="retro-badge bg-danger text-white">Non-Aktif</span>';

                let picListHtml = '<span class="text-muted fst-italic">Belum ada PIC</span>';
                if (sub.pics && sub.pics.length > 0) {
                    picListHtml = sub.pics.map(p => `<span class="fw-bold">${p.nama_pic}</span> <small class="text-muted">(${p.telepon || '-'})</small>`).join('<br>');
                }

                let agreementInfo = `<span class="fw-bold">Kontrak / Ref</span><br><small class="text-muted">Ref: ${sub.no_ref || '-'}</small>`;

                let actionBtn = `<div class="d-flex justify-content-center gap-1">`;
                actionBtn += `<button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-sub"
                                data-id="${sub.sub_penjamin_id}"
                                data-aktif="${statusVal}"
                                title="Edit Sub Penjamin" style="font-size: 0.7rem;">
                                <i class="fas fa-edit"></i>
                              </button>`;

                if (statusVal === 0) {
                    actionBtn += `<button class="btn btn-sm retro-btn retro-btn-primary px-2 py-1 btn-tarif"
                                    data-id="${sub.sub_penjamin_id}"
                                    title="Pengaturan Tarif" style="font-size: 0.7rem;">
                                    <i class="fas fa-tags"></i>
                                  </button>`;

                    actionBtn += `<button class="btn btn-sm retro-btn retro-btn-info px-2 py-1 btn-pemeriksaan"
                                    data-id="${sub.sub_penjamin_id}"
                                    title="Pengaturan Pemeriksaan" style="font-size: 0.7rem;">
                                    <i class="fas fa-stethoscope"></i>
                                  </button>`;
                }
                actionBtn += `</div>`;

                subTable.row.add([
                    `<div class="text-center">${index + 1}</div>`,
                    `<div class="fw-bolder text-dark">${sub.nama_sub_penjamin}<br><small class="text-muted">Ref: ${sub.no_ref || '-'}</small></div>`,
                    `<div class="text-center">${statusBadge}</div>`,
                    `<div class="text-center"><span class="retro-badge ${badgeBilling}">${sub.tipe_pembayaran || 'CASH'}</span></div>`,
                    `<div>${picListHtml}</div>`,
                    `<div class="text-center">${agreementInfo}</div>`,
                    actionBtn
                ]);
            });
        }
        subTable.draw();
    }

    $(document).on('click', '.btn-edit-sub', function() {
        let id = $(this).data('id');
        let statusAktif = Number($(this).data('aktif'));
        let sub = currentSubPenjaminData.find(item => item.sub_penjamin_id == id);
        if (!sub) return;

        if (statusAktif === 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Sub Penjamin Sedang Aktif',
                text: 'Data yang berstatus AKTIF tidak dapat diubah. Apakah Anda ingin menonaktifkannya sekarang?',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-power-off"></i> Ya, Nonaktifkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#1e1e24'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('<form>', {
                        'method': 'POST',
                        'action': `/master-data/master-penjamin/nonaktifkan-sub/${id}`
                    });
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));
                    $('body').append(form);
                    form.submit();
                }
            });
            return;
        }

        bukaModalEditLengkap(sub, id);
    });

    $(document).on('click', '.btn-tarif', function() {
        let id = $(this).data('id');
        let sub = currentSubPenjaminData.find(item => item.sub_penjamin_id == id);
        if (!sub) return;

        $('#title-tarif-nama').text(sub.nama_sub_penjamin);
        $('#tarif-sub-id').val(id);
        $('#form-pengaturan-tarif')[0].reset();
        $('.dynamic-tarif-form').addClass('d-none');
        $('#form-group-coverage').hide();
        $('#btn-save-tarif').prop('disabled', true);
        $('#form-pengaturan-tarif').attr('action', `/master-data/master-penjamin/store-tarif/${id}`);

        loadDropdownSumberSubPenjamin(id);
        $('#modal-pengaturan-tarif').modal('show');
        loadTableTarif(id);
    });

    let isMasterPoliLoaded = false;
    let isMasterRuanganLoaded = false;

    $('#select-kategori-tarif').on('change', function() {
        let val = $(this).val();
        $('.dynamic-tarif-form').addClass('d-none');
        $('#btn-save-tarif').prop('disabled', true);

        if (val) {
            $('#form-group-coverage').show();
            $('#btn-save-tarif').prop('disabled', false);
        } else {
            $('#form-group-coverage').hide();
        }

        if (val === 'IGD') {
            $('#form-group-igd').removeClass('d-none');
        } else if (val === 'POLI') {
            $('#form-group-poli').removeClass('d-none');
            if (!isMasterPoliLoaded) {
                $('#select-master-poli').html('<option value="">-- Memuat data... --</option>');
                $.get('/master-data/master-penjamin/polis-json', function(res) {
                    let options = '<option value="">-- Pilih Poli --</option>';
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(poli => {
                            options += `<option value="${poli.id}">${poli.nama_poli}</option>`;
                        });
                    }
                    $('#select-master-poli').html(options);
                    isMasterPoliLoaded = true;
                }).fail(function() {
                    $('#select-master-poli').html('<option value="">Gagal memuat data poli</option>');
                });
            }
        } else if (val === 'RANAP') {
            $('#form-group-ranap').removeClass('d-none');
            if (!isMasterRuanganLoaded) {
                $('#select-master-ruangan').html('<option value="">-- Memuat data... --</option>');
                $.get('master-data/master-penjamin/get-all', function(res) {
                    let options = '<option value="">-- Pilih Ruangan --</option>';
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(rg => {
                            options += `<option value="${rg.id}" data-kelas="${rg.kelas}">${rg.nama_ruangan} (Kelas ${rg.kelas})</option>`;
                        });
                    }
                    $('#select-master-ruangan').html(options);
                    isMasterRuanganLoaded = true;
                }).fail(function() {
                    $('#select-master-ruangan').html('<option value="">Gagal memuat data ruangan</option>');
                });
            }
        }
    });

    $('#select-master-ruangan').on('change', function() {
        let ruanganId = $(this).val();
        let kelasTerkait = $(this).find('option:selected').data('kelas');
        $('#hidden-ranap-kelas').val(kelasTerkait || '');
        let bedSelect = $('#select-master-bed');

        if (ruanganId) {
            bedSelect.prop('disabled', false).html('<option value="">-- Memuat bed... --</option>');
            $.get(`master-data/master-penjamin/bed-tersedia/${ruanganId}`, function(res) {
                let options = '<option value="">-- Pilih Bed --</option>';
                if (res.data && res.data.length > 0) {
                    res.data.forEach(bed => {
                        options += `<option value="${bed.id}">${bed.nomor_bed} - [${bed.status}]</option>`;
                    });
                } else {
                    options = '<option value="">Bed tidak tersedia</option>';
                }
                bedSelect.html(options);
            }).fail(function() {
                bedSelect.html('<option value="">Gagal memuat data bed</option>');
            });
        } else {
            bedSelect.prop('disabled', true).html('<option value="">-- Pilih Ruangan Terlebih Dahulu --</option>');
        }
    });

    $('#tarif-pola-tanggungan').on('change', function() {
        let val = $(this).val();
        $('.tarif-wrapper-tanggungan').addClass('d-none');
        if (val === 'SPLIT_PERSENTASE') $('#tarif-wrapper-persen').removeClass('d-none');
        else if (val === 'SPLIT_PLAFON') $('#tarif-wrapper-plafon').removeClass('d-none');
    });

    $('#form-pengaturan-tarif').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let submitBtn = $('#btn-save-tarif');
        let subId = $('#tarif-sub-id').val();

        if (!subId) {
            Swal.fire('Error', 'ID Sub Penjamin tidak ditemukan.', 'error');
            return;
        }

        let formData = form.serialize();
        let actionUrl = `/master-data/master-penjamin/store-tarif/${subId}`;
        let originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Tarif berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadTableTarif(subId);
                    form.find('input[type="number"], input[type="text"]').val('');
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal menyimpan tarif.', 'error');
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                let errorMsg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    function renderCoverageInfo(row, totalTarif) {
        const formatRp = (angka) => new Intl.NumberFormat('id-ID').format(angka);
        let pola = row.pola_tanggungan || 'IKUT_ATURAN_INDUK';
        let total = parseFloat(totalTarif) || 0;

        if (pola === 'IKUT_ATURAN_INDUK') {
            return `<div class="mt-1"><span class="badge bg-secondary w-100" style="font-size:0.6rem;">Ikut Aturan Induk</span></div>`;
        }
        if (pola === 'FULL_PASIEN') {
            return `<div class="mt-1 text-danger fw-bolder" style="font-size:0.7rem;"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(total)}</div>`;
        }
        if (pola === 'FULL_PERUSAHAAN') {
            return `<div class="mt-1 text-success fw-bolder" style="font-size:0.7rem;"><i class="fas fa-building me-1"></i>Prsh: Rp ${formatRp(total)}</div>`;
        }
        if (pola === 'SPLIT_PERSENTASE') {
            let persen = parseFloat(row.tanggungan_perusahaan_persen) || 0;
            let prsh = total * (persen / 100);
            let psn = total - prsh;
            return `<div class="mt-1 border-top border-dark pt-1" style="font-size:0.7rem;">
                        <div class="text-success fw-bold"><i class="fas fa-building me-1"></i>Prsh (${persen}%): Rp ${formatRp(prsh)}</div>
                        <div class="text-danger fw-bold"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(psn)}</div>
                    </div>`;
        }
        if (pola === 'SPLIT_PLAFON') {
            let plafon = parseFloat(row.tanggungan_perusahaan_maksimal_rp) || 0;
            let prsh = Math.min(total, plafon);
            let psn = total - prsh;
            return `<div class="mt-1 border-top border-dark pt-1" style="font-size:0.7rem;">
                        <div class="text-success fw-bold"><i class="fas fa-building me-1"></i>Prsh (Maks): Rp ${formatRp(prsh)}</div>
                        <div class="text-danger fw-bold"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(psn)}</div>
                    </div>`;
        }
        return '';
    }

    function loadTableTarif(subPenjaminId) {
        $('#tbody-list-tarif').html('<tr><td colspan="5" class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i> Memuat data...</td></tr>');

        $.get(`/master-data/master-penjamin/get-tarif/${subPenjaminId}`, function(response) {
            let tbody = '';
            let no = 1;
            const formatRp = (angka) => new Intl.NumberFormat('id-ID').format(angka);

            if (response.status === 'success') {
                if (response.data.igd && response.data.igd.length > 0) {
                    response.data.igd.forEach(row => {
                        let coverageHtml = renderCoverageInfo(row, row.tarif);
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td class="fw-bold text-danger"><span class="badge bg-danger">IGD</span></td>
                            <td><small class="text-muted fw-bold">${row.kategori_biaya}</small><br><span class="fw-bold">${row.nama_tarif}</span></td>
                            <td class="text-end">
                                <div class="fw-bolder text-dark">Rp ${formatRp(row.tarif)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (response.data.poli && response.data.poli.length > 0) {
                    response.data.poli.forEach(row => {
                        let coverageHtml = renderCoverageInfo(row, row.tarif);
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td class="fw-bold text-success"><span class="badge bg-success">POLIKLINIK</span></td>
                            <td><small class="text-muted fw-bold">${row.kategori_biaya}</small><br><span class="fw-bold">${row.nama_tarif}</span></td>
                            <td class="text-end">
                                <div class="fw-bolder text-dark">Rp ${formatRp(row.tarif)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (response.data.ranap && response.data.ranap.length > 0) {
                    response.data.ranap.forEach(row => {
                        let totalRanap = parseFloat(row.tarif_kamar_per_hari) + parseFloat(row.tarif_visite_dokter_per_hari) + parseFloat(row.tarif_asuhan_keperawatan_per_hari);
                        let coverageHtml = renderCoverageInfo(row, totalRanap);
                        let rincian = `Kamar: Rp ${formatRp(row.tarif_kamar_per_hari)}<br>Visite: Rp ${formatRp(row.tarif_visite_dokter_per_hari)}<br>Askep: Rp ${formatRp(row.tarif_asuhan_keperawatan_per_hari)}`;
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td class="fw-bold text-primary"><span class="badge bg-primary">RAWAT INAP</span></td>
                            <td class="fw-bold">Kelas: ${row.kelas}</td>
                            <td class="text-end">
                                <div style="font-size: 0.75rem;" class="mb-1 text-muted">${rincian}</div>
                                <div class="fw-bolder text-dark border-top border-dark pt-1">Total: Rp ${formatRp(totalRanap)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center align-middle"><button class="btn btn-sm btn-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (no === 1) tbody = `<tr><td colspan="5" class="text-center py-4 text-muted fst-italic fw-bold">Belum ada tarif terdaftar.</td></tr>`;
            } else {
                tbody = `<tr><td colspan="5" class="text-center py-4 text-danger fw-bold">Gagal memuat format data.</td></tr>`;
            }
            $('#tbody-list-tarif').html(tbody);
        });
    }

    function bukaModalEditLengkap(sub, id) {
        $('#edit-nama-sub-penjamin').val(sub.nama_sub_penjamin);
        $('#edit-no-ref').val(sub.no_ref);
        $('#edit-tgl-mulai').val(sub.tgl_mulai);
        $('#edit-tgl-selesai').val(sub.tgl_selesai);
        $('#edit-catatan-pelayanan').val(sub.catatan_pelayanan);

        $('#edit-tipe-pembayaran').val(sub.tipe_pembayaran);
        $('#edit-min-dp').val(sub.min_dp_persen);
        $('#edit-jatuh-tempo').val(sub.jatuh_tempo_hari);

        $('#edit-telp-perusahaan').val(sub.telp_perusahaan);
        $('#edit-alamat').val(sub.alamat);

        let rawStatusEdit = sub.status_aktif !== undefined ? sub.status_aktif : 0;
        $('#edit_status_aktif').prop('checked', Number(rawStatusEdit) === 1);
        $('#edit_wajib_lo').prop('checked', Number(sub.wajib_surat_garansi) === 1);

        $('#edit-pola-tanggungan').val(sub.pola_tanggungan || 'FULL_PASIEN').trigger('change');
        $('#edit-tanggungan-persen').val(sub.tanggungan_perusahaan_persen || 0);
        $('#edit-tanggungan-plafon').val(sub.tanggungan_perusahaan_maksimal_rp || 0);

        loadPicEditModal(sub);

        $('#form-edit-sub-penjamin').attr('action', `/master-data/master-penjamin/update-sub/${id}`);
        $('#modal-edit-sub-penjamin').modal('show');
    }

    function loadPicEditModal(sub) {
        let picContainerEdit = $('#container-pic-rows-edit');
        picContainerEdit.empty();

        if (sub.pics && sub.pics.length > 0) {
            sub.pics.forEach((p, idx) => {
                let rowHtml = `
                    <div class="card p-2 bg-light border border-dark pic-item-row-edit">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <input type="text" class="form-control retro-input form-control-sm" name="pics[${idx}][nama_pic]" value="${p.nama_pic || ''}" placeholder="Nama PIC..." required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control retro-input form-control-sm" name="pics[${idx}][telepon]" value="${p.telepon || ''}" placeholder="No. HP...">
                            </div>
                            <div class="col-md-4">
                                <input type="email" class="form-control retro-input form-control-sm" name="pics[${idx}][email]" value="${p.email || ''}" placeholder="Email...">
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>`;
                picContainerEdit.append(rowHtml);
                picIndexEdit = idx + 1;
            });
        } else {
            picContainerEdit.append(`
                <div class="card p-2 bg-light border border-dark pic-item-row-edit">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control retro-input form-control-sm" name="pics[0][nama_pic]" placeholder="Nama PIC..." required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control retro-input form-control-sm" name="pics[0][telepon]" placeholder="No. HP...">
                        </div>
                        <div class="col-md-4">
                            <input type="email" class="form-control retro-input form-control-sm" name="pics[0][email]" placeholder="Email...">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-sm btn-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>`);
            picIndexEdit = 1;
        }
    }

    function loadDropdownSumberSubPenjamin(currentSubId) {
        let select = $('#select-sumber-sub-penjamin');
        select.html('<option value="">Memuat data sub penjamin...</option>');

        $.get('/master-data/master-penjamin/get-all-sub', function(response) {
            let options = '<option value="">-- Pilih Sub Penjamin Sumber --</option>';
            if (response.status === 'success' && response.data.length > 0) {
                response.data.forEach(sub => {
                    if (sub.sub_penjamin_id != currentSubId) {
                        options += `<option value="${sub.sub_penjamin_id}">${sub.nama_sub_penjamin} (${sub.nama_penjamin})</option>`;
                    }
                });
            } else {
                options = '<option value="">Tidak ada sub penjamin lain</option>';
            }
            select.html(options);
        }).fail(function() {
            select.html('<option value="">Gagal memuat data</option>');
        });
    }

    $('#btn-proses-salin-tarif').on('click', function() {
        let sumberSubId = $('#select-sumber-sub-penjamin').val();
        let targetSubId = $('#tarif-sub-id').val();

        if (!sumberSubId) {
            Swal.fire('Perhatian', 'Silakan pilih sub penjamin sumber terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Salin Data Tarif?',
            text: 'Semua tarif dari sub penjamin terpilih akan disalin ke sub penjamin ini.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Salin Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#1e1e24'
        }).then((result) => {
            if (result.isConfirmed) {
                let btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '/master-data/master-penjamin/salin-tarif',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sumber_sub_id: sumberSubId,
                        target_sub_id: targetSubId
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html('<i class="fas fa-file-import"></i> Salin');
                        if (response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success');
                            loadTableTarif(targetSubId);
                        } else {
                            Swal.fire('Gagal', response.message || 'Gagal menyalin tarif.', 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-file-import"></i> Salin');
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
