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
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
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
                            <i class="fas fa-history text-primary fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Arsip & Rekam Medis</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Riwayat & Histori Pasien Rawat Inap</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR KOMPREHENSIF -->
<div class="retro-card mb-4 p-3 bg-white">
    <form id="form-filter-riwayat" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Dari Tanggal Masuk:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Sampai Tanggal Masuk:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-stethoscope text-success me-1"></i> Status / Kondisi Pulang:</label>
                <select id="status_pulang" name="status_pulang" class="form-select retro-input">
                    <option value="">-- Semua Status Pulang --</option>
                    <option value="SEBUH">Sembuh / Membaik</option>
                    <option value="RUJUK">Dirujuk</option>
                    <option value="PULANG_PAKSA">Pulang Paksa (APS)</option>
                    <option value="MENINGGAL">Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-hospital text-success me-1"></i> Kelas Perawatan:</label>
                <select id="kelas" name="kelas" class="form-select retro-input">
                    <option value="">-- Semua Kelas --</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                    <option value="VIP">VIP</option>
                    <option value="VVIP">VVIP</option>
                    <option value="ICU">ICU</option>
                </select>
            </div>
            <div class="col-md-9">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-search text-success me-1"></i> Kata Kunci Pencarian:</label>
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari No. Registrasi, Nama Pasien, atau No. RM..." />
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm w-50 fw-bold" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <button type="button" onclick="resetFilter()" class="btn retro-btn btn-secondary btn-sm w-50 fw-bold" style="height: 38px;" title="Reset Filter">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE RIWAYAT -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Data Histori Pasien Rawat Inap</h5>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-riwayat-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg & Waktu Inap</th>
                        <th>Pasien & RM</th>
                        <th>Ruangan & Bed</th>
                        <th>Dokter DPJP</th>
                        <th class="text-center">Status Pulang</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL MONITORING & HASIL PASIEN -->
<div class="modal fade" id="modalDetailRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-card border-0">
            <div class="modal-header bg-cyan text-dark border-bottom border-dark py-3">
                <h5 class="modal-title fw-bolder"><i class="fas id-card me-2"></i> Monitor & Hasil Perawatan: <span id="riwayat_nama_pasien"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <!-- Info Ringkas -->
                <div class="alert alert-light border border-dark mb-3">
                    <div class="row g-2 fs--1">
                        <div class="col-md-6"><strong>No. Registrasi:</strong> <span id="riwayat_no_reg" class="text-success fw-bold"></span></div>
                        <div class="col-md-6"><strong>No. RM:</strong> <span id="riwayat_pid" class="text-dark fw-bold"></span></div>
                        <div class="col-md-6"><strong>Tgl Masuk:</strong> <span id="riwayat_tgl_masuk"></span></div>
                        <div class="col-md-6"><strong>Tgl Keluar:</strong> <span id="riwayat_tgl_keluar"></span></div>
                        <div class="col-md-12"><strong>Catatan Pulang:</strong> <span id="riwayat_catatan" class="text-danger fw-bold"></span></div>
                    </div>
                </div>

                <!-- Bagian SOAP Terakhir / Perkembangan -->
                <h6 class="fw-bolder text-dark mb-2"><i class="fas fa-stethoscope text-success me-1"></i> Catatan Medis (SOAP) Terakhir</h6>
                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Subjektif (Keluhan):</small>
                            <span id="r_subjektif" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Objektif (Pemeriksaan Fisik/TTV):</small>
                            <span id="r_objektif" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Asesmen (Diagnosis):</small>
                            <span id="r_asesmen" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Planning (Terapi/Instruksi):</small>
                            <span id="r_planning" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Item Tindakan / Layanan -->
                <h6 class="fw-bolder text-dark mb-2"><i class="fas fa-list-ul text-success me-1"></i> Rincian Tindakan & Layanan Selama Inap</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Layanan / Tindakan</th>
                                <th class="text-center" style="width: 80px;">Jumlah</th>
                                <th class="text-end" style="width: 150px;">Tarif</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-riwayat-tindakan">
                            <!-- Diisi via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top border-dark py-3">
                <button type="button" class="btn retro-btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableRiwayatRanap;

    $(document).ready(function() {
        tableRiwayatRanap = $('#table-riwayat-ranap').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: "{{ route('ranap.riwayat.datatable') }}",
                type: "GET",
                dataSrc: 'data',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status_pulang = $('#status_pulang').val();
                    d.kelas = $('#kelas').val();
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
                        let tglKeluar = row.tgl_keluar ? new Date(row.tgl_keluar).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '<span class="text-success">Masih Dirawat</span>';
                        return `<span class="fw-bold text-success">${row.no_registrasi}</span><br>
                                <small class="text-muted"><i class="fas fa-sign-in-alt text-success"></i> ${tglMasuk}</small><br>
                                <small class="text-muted"><i class="fas fa-sign-out-alt text-danger"></i> ${tglKeluar}</small>`;
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
                    data: 'status_pulang',
                    render: function(data) {
                        if (!data) return '<span class="retro-badge bg-warning text-dark">AKTIF</span>';
                        let badgeColor = 'bg-success text-white';
                        if (data === 'RUJUK') badgeColor = 'bg-info text-white';
                        else if (data === 'PULANG_PAKSA') badgeColor = 'bg-warning text-dark';
                        else if (data === 'MENINGGAL') badgeColor = 'bg-danger text-white';
                        return `<span class="retro-badge ${badgeColor}">${data}</span>`;
                    },
                    className: 'text-center'
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
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1 fs--2" onclick="lihatMonitorRiwayat('${row.registrasi_id}', '${row.nama_pasien}', '${row.no_registrasi}', '${row.pid}', '${row.tgl_masuk}', '${row.tgl_keluar}', '${row.catatan_pulang}')" title="Lihat Monitor & Hasil Pasien">
                                    <i class="fas fa-eye"></i> Detail
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
        tableRiwayatRanap.ajax.reload(null, false);
    }

    function resetFilter() {
        $('#start_date').val("{{ date('Y-m-01') }}");
        $('#end_date').val("{{ date('Y-m-d') }}");
        $('#status_pulang').val('');
        $('#kelas').val('');
        $('#keyword').val('');
        reloadTable();
    }

    function lihatMonitorRiwayat(registrasiId, namaPasien, noReg, pid, tglMasuk, tglKeluar, catatan) {
        $('#riwayat_nama_pasien').text(namaPasien);
        $('#riwayat_no_reg').text(noReg);
        $('#riwayat_pid').text(pid);
        $('#riwayat_tgl_masuk').text(tglMasuk ? new Date(tglMasuk).toLocaleString('id-ID') : '-');
        $('#riwayat_tgl_keluar').text(tglKeluar && tglKeluar !== 'null' ? new Date(tglKeluar).toLocaleString('id-ID') : 'Masih Dirawat');
        $('#riwayat_catatan').text(catatan && catatan !== 'null' ? catatan : '-');

        $('#r_subjektif').text('Memuat...');
        $('#r_objektif').text('Memuat...');
        $('#r_asesmen').text('Memuat...');
        $('#r_planning').text('Memuat...');
        $('#tbody-riwayat-tindakan').html('<tr><td colspan="3" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailRiwayat').modal('show');

        // Gunakan route detail handling yang sudah ada untuk mengambil data SOAP & tindakan
        $.ajax({
            url: "{{ route('ranap.detail.handling') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    let soap = res.soap;
                    $('#r_subjektif').text(soap && soap.subjektif ? soap.subjektif : '-');
                    $('#r_objektif').text(soap && soap.objektif ? soap.objektif : '-');
                    $('#r_asesmen').text(soap && soap.asesmen ? soap.asesmen : '-');
                    $('#r_planning').text(soap && soap.planning ? soap.planning : '-');

                    let tindakanRows = '';
                    if (res.tindakanList.length > 0) {
                        res.tindakanList.forEach(function(item) {
                            tindakanRows += `
                                <tr>
                                    <td class="fw-bold text-dark">${item.nama_layanan}</td>
                                    <td class="text-center">${item.jumlah}</td>
                                    <td class="text-end">Rp ${Number(item.tarif).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tindakanRows = '<tr><td colspan="3" class="text-center text-muted py-3">Belum ada tindakan atau layanan tercatat.</td></tr>';
                    }
                    $('#tbody-riwayat-tindakan').html(tindakanRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat monitor dan hasil perawatan pasien.', 'error');
            }
        });
    }
</script>
@endsection
