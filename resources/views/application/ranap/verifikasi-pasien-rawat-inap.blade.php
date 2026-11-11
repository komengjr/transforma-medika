@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
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
        background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: white;
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-info {
        background-color: #17a2b8;
        color: white;
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
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
            <div class="card-body p-4 text-white">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-clipboard-check text-primary fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Monitoring Rawat Inap</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Verifikasi & Monitoring Pasien Rawat Inap</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="retro-card mb-4 p-3">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <button type="button" onclick="reloadTable()" class="btn retro-btn retro-btn-primary btn-sm px-3 fw-bold d-flex align-items-center gap-1" style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md">
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari No Reg / Nama / RM..." />
            </div>
            <div class="col-auto">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm px-3" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE MONITORING -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Daftar Pasien Rawat Inap Aktif</h5>
        <span class="retro-badge bg-cyan text-dark">Total Aktif: {{ $totalAktif }} Pasien</span>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-verifikasi-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg & Tgl Masuk</th>
                        <th>Pasien & RM</th>
                        <th>Ruangan & Bed</th>
                        <th>Dokter DPJP</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center">Status Pembayaran</th>
                        <th class="text-center" style="width: 180px;">Aksi & Verifikasi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail & Verifikasi Handling Rawat Inap (Tampilan Tabel Murni Verifikator) -->
<div class="modal fade" id="modalDetailHandling" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 retro-card">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
                <h5 class="modal-title fw-bolder text-dark">
                    <i class="fas fa-clipboard-check me-2"></i> Verifikasi Data Handling Pasien: <span id="detail_nama_pasien" class="text-danger"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">

                <!-- Tab Navigasi Verifikasi -->
                <ul class="nav nav-tabs border-0 mb-3" id="verifRanapTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#verif-soap-pane" type="button">
                            <i class="fas fa-id-card me-1"></i> 1. SOAP & Perkembangan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#verif-tindakan-pane" type="button">
                            <i class="fas fa-stethoscope me-1"></i> 2. Tindakan & Visite
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-danger" data-bs-toggle="tab" data-bs-target="#verif-resep-pane" type="button">
                            <i class="fas fa-pills me-1"></i> 3. Order Resep Obat
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- PANE 1: SOAP -->
                    <div class="tab-pane fade show active" id="verif-soap-pane" role="tabpanel">
                        <div class="p-3 border border-dark rounded bg-light mb-3">
                            <div class="row g-3">
                                <div class="col-md-6"><strong>Subjektif:</strong>
                                    <p id="txt_subjektif" class="mb-0 text-dark fw-bold">-</p>
                                </div>
                                <div class="col-md-6"><strong>Objektif:</strong>
                                    <p id="txt_objektif" class="mb-0 text-dark fw-bold">-</p>
                                </div>
                                <div class="col-md-6"><strong>Asesmen:</strong>
                                    <p id="txt_asesmen" class="mb-0 text-dark fw-bold">-</p>
                                </div>
                                <div class="col-md-6"><strong>Planning:</strong>
                                    <p id="txt_planning" class="mb-0 text-dark fw-bold">-</p>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="d-flex justify-content-between align-items-center fs--1">
                                <div><strong>Penginput:</strong> <span id="soap_input_by" class="text-primary">-</span> | <strong>Verifikator:</strong> <span id="soap_verifikator" class="text-success">-</span></div>
                                <div><strong>Status:</strong> <span id="soap_status" class="badge bg-warning text-dark">-</span></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-sm btn-success fw-bold px-3" onclick="prosesVerifikasi('soap', 'Verified')"><i class="fas fa-check me-1"></i> Setujui SOAP</button>
                            <button class="btn btn-sm btn-danger fw-bold px-3" onclick="prosesVerifikasi('soap', 'Rejected')"><i class="fas fa-times me-1"></i> Tolak</button>
                        </div>
                    </div>

                    <!-- PANE 2: TINDAKAN -->
                    <div class="tab-pane fade" id="verif-tindakan-pane" role="tabpanel">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-sm fs--1 align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Layanan</th>
                                        <th>Jml</th>
                                        <th class="text-end">Tarif</th>
                                        <th>Penginput</th>
                                        <th>Verifikator</th>
                                        <th style="width: 140px;">Status / Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-detail-tindakan">
                                    <tr>
                                        <td colspan="6" class="text-center py-3">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <!-- Tombol simpan masal untuk tindakan -->
                            <button class="btn btn-sm btn-primary fw-bold px-3" onclick="simpanVerifikasiGranular('tindakan')">
                                <i class="fas fa-save me-1"></i> Simpan Status Tindakan
                            </button>
                        </div>
                    </div>

                    <!-- PANE 3: RESEP OBAT -->
                    <div class="tab-pane fade" id="verif-resep-pane" role="tabpanel">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-sm fs--1 align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Qty</th>
                                        <th>Signa (Aturan Pakai)</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th>Penginput</th>
                                        <th>Verifikator</th>
                                        <th style="width: 140px;">Status / Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-detail-resep">
                                    <tr>
                                        <td colspan="7" class="text-center py-3">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <!-- Tombol simpan masal untuk resep -->
                            <button class="btn btn-sm btn-primary fw-bold px-3" onclick="simpanVerifikasiGranular('resep')">
                                <i class="fas fa-save me-1"></i> Simpan Status Resep
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-light border-top border-dark">
                <button type="button" class="btn btn-secondary btn-sm fw-bold px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VERIFIKASI & IZIN PULANG -->
<div class="modal fade" id="modalVerifikasiPulang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <form id="form-verifikasi-pulang">
                @csrf
                <input type="hidden" name="registrasi_id" id="val_registrasi_id">
                <input type="hidden" name="bed_id" id="val_bed_id">

                <div class="modal-header bg-warning text-dark border-bottom border-dark py-3">
                    <h5 class="modal-title fw-bolder"><i class="fas fa-clipboard-check me-2"></i> Verifikasi & Pemulangan Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="alert alert-light border border-dark mb-3">
                        <small class="text-muted d-block">Pasien yang akan diproses:</small>
                        <strong class="text-dark fs-6" id="label_nama_pasien"></strong><br>
                        <small class="text-success fw-bold"><i class="fas fa-bed"></i> Tempat Tidur yang akan dibuka: <span id="label_nomor_bed"></span></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Status / Kondisi Pulang</label>
                        <select class="form-select retro-input" name="status_pulang" required>
                            <option value="">-- Pilih Kondisi Pulang --</option>
                            <option value="SEBUH">Sembuh / Membaik</option>
                            <option value="RUJUK">Dirujuk ke Rumah Sakit Lain</option>
                            <option value="PULANG_PAKSA">Pulang Atas Permintaan Sendiri (Paksa)</option>
                            <option value="MENINGGAL">Meninggal Dunia</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Catatan Kepulangan / Instruksi Dokter</label>
                        <textarea class="form-control retro-input" name="catatan_pulang" rows="3" placeholder="Instruksi obat pulang, kontrol ulang, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top border-dark py-3">
                    <button type="button" class="btn retro-btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn retro-btn retro-btn-success btn-sm px-4" id="btn-submit-pulang">Izin Pulang & Buka Bed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableVerifikasiRanap;
    let currentRegistrasiId = null;

    $(document).ready(function() {
        tableVerifikasiRanap = $('#table-verifikasi-ranap').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: "{{ route('ranap.verifikasi.datatable') }}",
                type: "GET",
                dataSrc: 'data',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let tglMasuk = row.tgl_masuk ? new Date(row.tgl_masuk).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '-';
                        return `<span class="fw-bold text-success">${row.no_registrasi}</span><br>
                                <small class="text-muted"><i class="far fa-clock"></i> ${tglMasuk}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-dark">${row.nama_pasien}</span><br>
                                <small class="text-muted">RM: ${row.pid}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-primary">${row.nama_ruangan} (${row.kelas})</span><br>
                                <small class="text-success fw-bold"><i class="fas fa-bed"></i> Bed: ${row.nomor_bed}</small>`;
                    }
                },
                {
                    data: 'nama_dokter',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'total_tagihan',
                    render: function(data) {
                        let total = data ? parseFloat(data) : 0;
                        return `Rp ${total.toLocaleString('id-ID')}`;
                    },
                    className: 'text-end fw-bolder text-danger'
                },
                {
                    data: 'status_pembayaran',
                    render: function(data) {
                        let status = data ? data : 'BELUM LUNAS';
                        let badgePay = (status === 'LUNAS') ? 'bg-success text-white' : 'bg-warning text-dark';
                        return `<span class="retro-badge ${badgePay}">${status}</span>`;
                    },
                    className: 'text-center'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1 fs--2" onclick="lihatDetailHandling('${row.registrasi_id}', '${row.nama_pasien}')" title="Verifikasi SOAP, Tindakan & Resep">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                <button type="button" class="btn retro-btn retro-btn-warning btn-sm px-2 py-1 fs--2" onclick="bukaModalVerifikasi('${row.registrasi_id}', '${row.nama_pasien}', '${row.bed_id}', '${row.nomor_bed}')" title="Verifikasi & Pulang">
                                    <i class="fas fa-check-circle"></i> Pulang
                                </button>
                            </div>
                        `;
                    },
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function reloadTable() {
        tableVerifikasiRanap.ajax.reload(null, false);
    }

    function lihatDetailHandling(registrasiId, namaPasien) {
        currentRegistrasiId = registrasiId;
        $('#detail_nama_pasien').text(namaPasien);
        $('#txt_subjektif').text('Memuat...');
        $('#txt_objektif').text('Memuat...');
        $('#txt_asesmen').text('Memuat...');
        $('#txt_planning').text('Memuat...');
        $('#soap_input_by').text('-');
        $('#soap_verifikator').text('-');
        $('#soap_status').text('-').attr('class', 'badge bg-warning text-dark');
        $('#tbody-detail-tindakan').html('<tr><td colspan="6" class="text-center py-3">Memuat data...</td></tr>');
        $('#tbody-detail-resep').html('<tr><td colspan="7" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailHandling').modal('show');

        $.ajax({
            url: "{{ route('ranap.detail.handling') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    // 1. Render SOAP
                    let soap = res.soap;
                    $('#txt_subjektif').text(soap && soap.subjektif ? soap.subjektif : '-');
                    $('#txt_objektif').text(soap && soap.objektif ? soap.objektif : '-');
                    $('#txt_asesmen').text(soap && soap.asesmen ? soap.asesmen : '-');
                    $('#txt_planning').text(soap && soap.planning ? soap.planning : '-');
                    $('#soap_input_by').text(soap && soap.input_by ? soap.input_by : '-');
                    $('#soap_verifikator').text(soap && soap.dokter_verifikasi_kode ? soap.dokter_verifikasi_kode : 'Belum Diverifikasi');

                    let soapStatus = soap && soap.status_verifikasi ? soap.status_verifikasi : 'Pending';
                    $('#soap_status').text(soapStatus).attr('class', 'badge ' + (soapStatus === 'Verified' ? 'bg-success' : soapStatus === 'Rejected' ? 'bg-danger' : 'bg-warning text-dark'));

                    // 2. Render Tindakan (Dengan Select Opsi)
                    let tindakanRows = '';
                    if (res.tindakanList && res.tindakanList.length > 0) {
                        res.tindakanList.forEach(function(item) {
                            let isPending = item.status_verifikasi === 'Pending';
                            let selectHtml = '';

                            // Jika masih pending, tampilkan dropdown. Jika sudah acc/reject, tampilkan badge
                            if (isPending) {
                                selectHtml = `
                                    <select class="form-select form-select-sm fw-bold sel-tindakan-verif" data-id="${item.id}">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Verified">Verified (ACC)</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                `;
                            } else {
                                let badgeColor = item.status_verifikasi === 'Verified' ? 'bg-success' : 'bg-danger';
                                selectHtml = `<span class="badge ${badgeColor}">${item.status_verifikasi}</span>`;
                            }

                            tindakanRows += `
                                <tr>
                                    <td class="fw-bold text-dark text-start">${item.nama_layanan}</td>
                                    <td>${item.jumlah}</td>
                                    <td class="text-end">Rp ${Number(item.tarif).toLocaleString('id-ID')}</td>
                                    <td>${item.input_by || '-'}</td>
                                    <td>${item.dokter_verifikasi_kode || '-'}</td>
                                    <td>${selectHtml}</td>
                                </tr>`;
                        });
                    } else {
                        tindakanRows = '<tr><td colspan="6" class="text-center text-muted py-3">Belum ada tindakan tercatat.</td></tr>';
                    }
                    $('#tbody-detail-tindakan').html(tindakanRows);

                    // 3. Render Resep Obat (Dengan Select Opsi)
                    let resepRows = '';
                    if (res.resepList && res.resepList.length > 0) {
                        res.resepList.forEach(function(item) {
                            let isPending = item.status_verifikasi === 'Pending';
                            let selectHtml = '';

                            if (isPending) {
                                selectHtml = `
                                    <select class="form-select form-select-sm fw-bold sel-resep-verif" data-id="${item.id}">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Verified">Verified (ACC)</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                `;
                            } else {
                                let badgeColor = item.status_verifikasi === 'Verified' ? 'bg-success' : 'bg-danger';
                                selectHtml = `<span class="badge ${badgeColor}">${item.status_verifikasi}</span>`;
                            }

                            resepRows += `
                                <tr>
                                    <td class="fw-bold text-dark text-start">${item.farm_data_obat_name}</td>
                                    <td>${item.qty}</td>
                                    <td>${item.signa || '-'}</td>
                                    <td class="text-end">Rp ${Number(item.harga).toLocaleString('id-ID')}</td>
                                    <td>${item.input_by || '-'}</td>
                                    <td>${item.dokter_verifikasi_kode || '-'}</td>
                                    <td>${selectHtml}</td>
                                </tr>`;
                        });
                    } else {
                        resepRows = '<tr><td colspan="7" class="text-center text-muted py-3">Belum ada order resep obat tercatat.</td></tr>';
                    }
                    $('#tbody-detail-resep').html(resepRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat rincian verifikasi pasien.', 'error');
            }
        });
    }

    // Fungsi Untuk Mengirim Data (Status per Item) ke Controller
    function simpanVerifikasiGranular(kategori) {
        if (!currentRegistrasiId) return;

        let payloadTindakan = [];
        let payloadResep = [];

        // Ambil dokter login (Anda bisa memodifikasinya dari session atau auth)
        // Di sini kita asumsikan Controller menangkap Auth::user otomatis, atau kita kirim default.
        let kodeDokter = "DR-AKTIF";

        if (kategori === 'tindakan') {
            $('.sel-tindakan-verif').each(function() {
                let id = $(this).data('id');
                let status = $(this).val();
                if (status !== 'Pending') { // Hanya kirim yang sudah dirubah statusnya
                    payloadTindakan.push({
                        id: id,
                        status: status
                    });
                }
            });

            if (payloadTindakan.length === 0) {
                return Swal.fire('Info', 'Tidak ada tindakan baru yang diverifikasi/ditolak.', 'info');
            }
        }

        if (kategori === 'resep') {
            $('.sel-resep-verif').each(function() {
                let id = $(this).data('id');
                let status = $(this).val();
                if (status !== 'Pending') {
                    payloadResep.push({
                        id: id,
                        status: status
                    });
                }
            });

            if (payloadResep.length === 0) {
                return Swal.fire('Info', 'Tidak ada resep baru yang diverifikasi/ditolak.', 'info');
            }
        }

        Swal.fire({
            title: `Simpan Verifikasi ${kategori.toUpperCase()}?`,
            text: "Data yang telah di-ACC akan langsung diteruskan ke bagian Kasir/Farmasi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('ranap.proses.verifikasi.handling') }}", // Arahkan ke Controller POST Baru
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        registrasi_id: currentRegistrasiId,
                        dokter_kode: kodeDokter,
                        tindakan: payloadTindakan,
                        resep: payloadResep
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Disimpan',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Refresh modal untuk memperbarui dropdown menjadi badge
                            lihatDetailHandling(currentRegistrasiId, $('#detail_nama_pasien').text());
                            reloadTable(); // Refresh tabel belakang agar tagihan update
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal memproses ke server.', 'error');
                    }
                });
            }
        });
    }

    // Fungsi khusus untuk menyetujui keseluruhan form SOAP
    function prosesVerifikasi(jenis, status) {
        if (!currentRegistrasiId || jenis !== 'soap') return;

        Swal.fire({
            title: 'Verifikasi SOAP',
            text: `Anda akan menetapkan status SOAP menjadi ${status}. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('ranap.verify.order') }}", // Arahkan ke route SOAP lama Anda
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        registrasi_id: currentRegistrasiId,
                        jenis: jenis,
                        status: status
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Sukses', 'Status SOAP diperbarui.', 'success');
                            lihatDetailHandling(currentRegistrasiId, $('#detail_nama_pasien').text());
                        }
                    }
                });
            }
        });
    }

    function bukaModalVerifikasi(registrasiId, namaPasien, bedId, nomorBed) {
        $('#val_registrasi_id').val(registrasiId);
        $('#val_bed_id').val(bedId);
        $('#label_nama_pasien').text(namaPasien);
        $('#label_nomor_bed').text(nomorBed);
        $('#modalVerifikasiPulang').modal('show');
    }

    $('#btn-submit-pulang').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);

        Swal.fire({
            title: 'Konfirmasi Izin Pulang?',
            text: "Pasien akan dinyatakan pulang dan status bed akan otomatis dibuka kembali menjadi tersedia!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#38ef7d',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Proses Pulang!'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).text('Memproses...');

                $.ajax({
                    url: "{{ route('ranap.proses.pulang') }}",
                    type: "POST",
                    data: $('#form-verifikasi-pulang').serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).text('Izin Pulang & Buka Bed');
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                reloadTable();
                                $('#modalVerifikasiPulang').modal('hide');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Izin Pulang & Buka Bed');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
