@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
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

    .nav-tabs .nav-link {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 800;
        color: var(--retro-dark);
        background-color: #e4dfd5;
        box-shadow: 2px 2px 0px var(--retro-dark);
        margin-right: 5px;
        border-radius: 6px 6px 0 0 !important;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--retro-cyan) !important;
        color: var(--retro-dark) !important;
        box-shadow: 3px 3px 0px var(--retro-dark);
        transform: translateY(-2px);
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
                            <i class="fas fa-file-invoice-dollar text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Master Data</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Manajemen Tarif Layanan & Penjamin</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABS NAVIGATION -->
<ul class="nav nav-tabs border-0 mb-3" id="tarifTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="poli-tab" data-bs-toggle="tab" data-bs-target="#poli-pane" type="button" role="tab">
            <i class="fas fa-stethoscope me-2"></i> Tarif Rawat Jalan (Poli)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="inap-tab" data-bs-toggle="tab" data-bs-target="#inap-pane" type="button" role="tab">
            <i class="fas fa-bed me-2"></i> Tarif Rawat Inap
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="igd-tab" data-bs-toggle="tab" data-bs-target="#igd-pane" type="button" role="tab">
            <i class="fas fa-ambulance me-2"></i> Tarif IGD
        </button>
    </li>
</ul>

<!-- TAB CONTENT CONTAINER -->
<div class="tab-content" id="tarifTabContent">

    <!-- 1. TAB RAWAT JALAN / POLI -->
    <div class="tab-pane fade show active" id="poli-pane" role="tabpanel">
        <div class="retro-card">
            <div class="card-header bg-white border-bottom border-dark py-3 px-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-stethoscope text-primary me-2"></i> Daftar Tarif Rawat Jalan (Poli)</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3" data-bs-toggle="modal" data-bs-target="#modal-tambah-poli">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Tarif Poli
                </button>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-custom table-tarif align-middle w-100 mb-0">
                        <!-- PERBAIKAN -->
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Poliklinik</th>
                                <th>Sub Penjamin</th>
                                <th>Kategori Biaya</th>
                                <th>Nama Tarif</th>
                                <th class="text-end">Nominal Tarif (Rp)</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($tarifPoli as $tp)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="fw-bold">{{ $tp->nama_poli }}</td>
                                <td>
                                    @if($tp->nama_sub_penjamin)
                                    <span class="retro-badge" style="background-color: var(--retro-yellow);">{{ $tp->nama_sub_penjamin }}</span>
                                    @else
                                    <span class="badge bg-secondary">Semua Penjamin (Umum/Default)</span>
                                    @endif
                                </td>
                                <td><code>{{ $tp->kategori_biaya }}</code></td>
                                <td class="fw-bolder">{{ $tp->nama_tarif }}</td>
                                <td class="text-end text-primary fw-bolder">Rp {{ number_format($tp->tarif, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-poli"
                                        data-id="{{ $tp->id }}"
                                        data-poli="{{ $tp->poli_id }}"
                                        data-subpenjamin="{{ $tp->sub_penjamin_id }}"
                                        data-kategori="{{ $tp->kategori_biaya }}"
                                        data-nama="{{ $tp->nama_tarif }}"
                                        data-tarif="{{ $tp->tarif }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data tarif poli.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TAB RAWAT INAP -->
    <div class="tab-pane fade" id="inap-pane" role="tabpanel">
        <div class="retro-card">
            <div class="card-header bg-white border-bottom border-dark py-3 px-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-bed text-success me-2"></i> Daftar Tarif Rawat Inap</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3" data-bs-toggle="modal" data-bs-target="#modal-tambah-inap">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Tarif Inap
                </button>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-custom table-tarif align-middle w-100 mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Kelas Kamar</th>
                                <th>Sub Penjamin</th>
                                <th class="text-end">Tarif Kamar / Hari</th>
                                <th class="text-end">Visite Dokter / Hari</th>
                                <th class="text-end">Asuhan Keperawatan</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($tarifRawatInap as $tri)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="fw-bolder">{{ $tri->kelas }}</td>
                                <td><span class="retro-badge" style="background-color: var(--retro-cyan);">{{ $tri->nama_sub_penjamin }}</span></td>
                                <td class="text-end text-success">Rp {{ number_format($tri->tarif_kamar_per_hari, 0, ',', '.') }}</td>
                                <td class="text-end text-primary">Rp {{ number_format($tri->tarif_visite_dokter_per_hari, 0, ',', '.') }}</td>
                                <td class="text-end text-dark">Rp {{ number_format($tri->tarif_asuhan_keperawatan_per_hari, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-inap"
                                        data-id="{{ $tri->id }}"
                                        data-kelas="{{ $tri->kelas }}"
                                        data-subpenjamin="{{ $tri->sub_penjamin_id }}"
                                        data-kamar="{{ $tri->tarif_kamar_per_hari }}"
                                        data-visite="{{ $tri->tarif_visite_dokter_per_hari }}"
                                        data-askep="{{ $tri->tarif_asuhan_keperawatan_per_hari }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data tarif rawat inap.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TAB IGD -->
    <div class="tab-pane fade" id="igd-pane" role="tabpanel">
        <div class="retro-card">
            <div class="card-header bg-white border-bottom border-dark py-3 px-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-ambulance text-danger me-2"></i> Daftar Tarif IGD</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3" data-bs-toggle="modal" data-bs-target="#modal-tambah-igd">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Tarif IGD
                </button>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-custom table-tarif align-middle w-100 mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Sub Penjamin</th>
                                <th>Kategori Biaya</th>
                                <th>Nama Tarif</th>
                                <th class="text-end">Nominal Tarif (Rp)</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($tarifIgd as $tigd)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td><span class="retro-badge" style="background-color: var(--retro-pink);">{{ $tigd->nama_sub_penjamin }}</span></td>
                                <td><code>{{ $tigd->kategori_biaya }}</code></td>
                                <td class="fw-bolder">{{ $tigd->nama_tarif }}</td>
                                <td class="text-end text-danger fw-bolder">Rp {{ number_format($tigd->tarif, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-igd"
                                        data-id="{{ $tigd->id }}"
                                        data-subpenjamin="{{ $tigd->sub_penjamin_id }}"
                                        data-kategori="{{ $tigd->kategori_biaya }}"
                                        data-nama="{{ $tigd->nama_tarif }}"
                                        data-tarif="{{ $tigd->tarif }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data tarif IGD.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ========================================================== -->
<!-- MODAL TAMBAH & EDIT TARIF POLI, RAWAT INAP, DAN IGD        -->
<!-- ========================================================== -->

<!-- Modal Tambah Tarif Poli -->
<div class="modal fade" id="modal-tambah-poli" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Tambah Tarif Poli (Rawat Jalan)</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form action="{{ route('tarif_poli_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Poliklinik</label>
                        <select class="form-select retro-input" name="poli_id" required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach($masterPoli as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin (Opsional / Kosongkan jika Umum)</label>
                        <select class="form-select retro-input" name="sub_penjamin_id">
                            <option value="">-- Semua / Umum --</option>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kategori Biaya</label>
                        <input type="text" class="form-control retro-input" name="kategori_biaya" placeholder="Contoh: ADMINISTRASI, JASA_DOKTER" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Tarif</label>
                        <input type="text" class="form-control retro-input" name="nama_tarif" placeholder="Contoh: Konsultasi Dokter Spesialis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nominal Tarif (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" name="tarif" placeholder="0" required>
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

<!-- Modal Edit Tarif Poli -->
<div class="modal fade" id="modal-edit-poli" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Edit Tarif Poli</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="form-edit-poli" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Poliklinik</label>
                        <select class="form-select retro-input" id="edit-poli-id" name="poli_id" required>
                            @foreach($masterPoli as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <select class="form-select retro-input" id="edit-poli-subpenjamin" name="sub_penjamin_id">
                            <option value="">-- Semua / Umum --</option>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kategori Biaya</label>
                        <input type="text" class="form-control retro-input" id="edit-poli-kategori" name="kategori_biaya" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Tarif</label>
                        <input type="text" class="form-control retro-input" id="edit-poli-nama" name="nama_tarif" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nominal Tarif (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" id="edit-poli-tarif" name="tarif" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tarif Rawat Inap -->
<div class="modal fade" id="modal-tambah-inap" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Tambah Tarif Rawat Inap</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form action="{{ route('tarif_rawatinap_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kelas Kamar</label>
                        <input type="text" class="form-control retro-input" name="kelas" placeholder="Contoh: Kelas 1, Kelas 2, VIP, VVIP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <select class="form-select retro-input" name="sub_penjamin_id" required>
                            <option value="">-- Pilih Sub Penjamin --</option>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Kamar / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" name="tarif_kamar_per_hari" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Visite Dokter / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" name="tarif_visite_dokter_per_hari" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Asuhan Keperawatan / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" name="tarif_asuhan_keperawatan_per_hari" placeholder="0" required>
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

<!-- Modal Edit Tarif Rawat Inap -->
<div class="modal fade" id="modal-edit-inap" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Edit Tarif Rawat Inap</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="form-edit-inap" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kelas Kamar</label>
                        <input type="text" class="form-control retro-input" id="edit-inap-kelas" name="kelas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <select class="form-select retro-input" id="edit-inap-subpenjamin" name="sub_penjamin_id" required>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Kamar / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" id="edit-inap-kamar" name="tarif_kamar_per_hari" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Visite Dokter / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" id="edit-inap-visite" name="tarif_visite_dokter_per_hari" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Tarif Asuhan Keperawatan / Hari (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" id="edit-inap-askep" name="tarif_asuhan_keperawatan_per_hari" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tarif IGD -->
<div class="modal fade" id="modal-tambah-igd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Tambah Tarif IGD</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form action="{{ route('tarif_igd_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <select class="form-select retro-input" name="sub_penjamin_id" required>
                            <option value="">-- Pilih Sub Penjamin --</option>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kategori Biaya</label>
                        <input type="text" class="form-control retro-input" name="kategori_biaya" placeholder="Contoh: ADMINISTRASI, JASA_DOKTER_IGD" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Tarif</label>
                        <input type="text" class="form-control retro-input" name="nama_tarif" placeholder="Contoh: Biaya Administrasi IGD" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nominal Tarif (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" name="tarif" placeholder="0" required>
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

<!-- Modal Edit Tarif IGD -->
<div class="modal fade" id="modal-edit-igd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder">Edit Tarif IGD</h5>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="form-edit-igd" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Sub Penjamin</label>
                        <select class="form-select retro-input" id="edit-igd-subpenjamin" name="sub_penjamin_id" required>
                            @foreach($subPenjamin as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_penjamin }} - {{ $sp->nama_sub_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kategori Biaya</label>
                        <input type="text" class="form-control retro-input" id="edit-igd-kategori" name="kategori_biaya" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Tarif</label>
                        <input type="text" class="form-control retro-input" id="edit-igd-nama" name="nama_tarif" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nominal Tarif (Rp)</label>
                        <input type="number" step="0.01" class="form-control retro-input" id="edit-igd-tarif" name="tarif" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
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
    $(document).ready(function() {
        // Inisialisasi DataTable untuk masing-masing tabel tarif
        $('.table-tarif').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari data tarif..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });

        // Trigger Edit Tarif Poli
        $(document).on('click', '.btn-edit-poli', function() {
            let id = $(this).data('id');
            $('#edit-poli-id').val($(this).data('poli'));
            $('#edit-poli-subpenjamin').val($(this).data('subpenjamin'));
            $('#edit-poli-kategori').val($(this).data('kategori'));
            $('#edit-poli-nama').val($(this).data('nama'));
            $('#edit-poli-tarif').val($(this).data('tarif'));
            $('#form-edit-poli').attr('action', `/master-data/master-penjamin/tarif-poli/update/${id}`);
            $('#modal-edit-poli').modal('show');
        });

        // Trigger Edit Tarif Rawat Inap
        $(document).on('click', '.btn-edit-inap', function() {
            let id = $(this).data('id');
            $('#edit-inap-kelas').val($(this).data('kelas'));
            $('#edit-inap-subpenjamin').val($(this).data('subpenjamin'));
            $('#edit-inap-kamar').val($(this).data('kamar'));
            $('#edit-inap-visite').val($(this).data('visite'));
            $('#edit-inap-askep').val($(this).data('askep'));
            $('#form-edit-inap').attr('action', `/master-data/master-penjamin/tarif-rawatinap/update/${id}`);
            $('#modal-edit-inap').modal('show');
        });

        // Trigger Edit Tarif IGD
        $(document).on('click', '.btn-edit-igd', function() {
            let id = $(this).data('id');
            $('#edit-igd-subpenjamin').val($(this).data('subpenjamin'));
            $('#edit-igd-kategori').val($(this).data('kategori'));
            $('#edit-igd-nama').val($(this).data('nama'));
            $('#edit-igd-tarif').val($(this).data('tarif'));
            $('#form-edit-igd').attr('action', `/master-data/master-penjamin/tarif-igd/update/${id}`);
            $('#modal-edit-igd').modal('show');
        });
    });
</script>
@endsection
