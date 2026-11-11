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
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Riwayat & Histori Pasien IGD</h3>
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
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Dari Tanggal:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Sampai Tanggal:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-check-circle text-success me-1"></i> Status Kunjungan:</label>
                <select id="status_kunjungan" name="status_kunjungan" class="form-select retro-input">
                    <option value="">-- Semua Status --</option>
                    <option value="MENUNGGU">Menunggu</option>
                    <option value="PROSES">Penanganan</option>
                    <option value="SELESAI">Selesai / Pulang</option>
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

<!-- MAIN TABLE RIWAYAT IGD -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Data Histori Kunjungan IGD</h5>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-riwayat-igd" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg & Waktu</th>
                        <th>Pasien & RM</th>
                        <th>Dokter Pemeriksa</th>
                        <th class="text-center">Status Akhir</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL RIWAYAT IGD -->
<div class="modal fade" id="modalDetailRiwayatIgd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-card border-0">
            <div class="modal-header bg-cyan text-dark border-bottom border-dark py-3">
                <h5 class="modal-title fw-bolder"><i class="fas fa-notes-medical me-2"></i> Riwayat Penanganan IGD: <span id="igd_nama_pasien"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <!-- Info Ringkas -->
                <div class="alert alert-light border border-dark mb-3">
                    <strong class="text-dark d-block mb-1">Keluhan / Catatan Medis Utama:</strong>
                    <p id="igd_keluhan" class="mb-0 fw-bold text-danger">-</p>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light h-100">
                            <small class="fw-bold text-muted d-block">Anamnesis / Pemeriksaan Awal:</small>
                            <span id="igd_anamnesis" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light h-100">
                            <small class="fw-bold text-muted d-block">Diagnosis / Tindakan Utama:</small>
                            <span id="igd_diagnosis" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bolder text-dark mb-2"><i class="fas fa-list-ul text-success me-1"></i> Rincian Tindakan & Layanan Selama di IGD</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Layanan / Tindakan</th>
                                <th class="text-center" style="width: 80px;">Jumlah</th>
                                <th class="text-end" style="width: 150px;">Tarif</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-igd-tindakan">
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
    let tableRiwayatIgd;

    $(document).ready(function() {
        tableRiwayatIgd = $('#table-riwayat-igd').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('igd.riwayat.datatable') }}",
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status_kunjungan = $('#status_kunjungan').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_registrasi',
                    name: 'reg.no_registrasi'
                },
                {
                    data: 'nama_pasien',
                    name: 'p.nama'
                },
                {
                    data: 'dokter',
                    name: 'doc_poli.nama_lengkap'
                },
                {
                    data: 'status',
                    name: 'reg.status_kunjungan',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'tagihan',
                    name: 't.total_tagihan',
                    className: 'text-end'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari data riwayat IGD..."
            }
        });
    });

    function reloadTable() {
        tableRiwayatIgd.ajax.reload(null, false);
    }

    function resetFilter() {
        $('#start_date').val("{{ date('Y-m-01') }}");
        $('#end_date').val("{{ date('Y-m-d') }}");
        $('#status_kunjungan').val('');
        $('#keyword').val('');
        reloadTable();
    }

    function lihatRiwayatIgd(registrasiId, namaPasien) {
        $('#igd_nama_pasien').text(namaPasien);
        $('#igd_keluhan').text('Memuat...');
        $('#igd_anamnesis').text('Memuat...');
        $('#igd_diagnosis').text('Memuat...');
        $('#tbody-igd-tindakan').html('<tr><td colspan="3" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailRiwayatIgd').modal('show');

        // Menggunakan rute detail handling IGD yang sama dari menu sebelumnya
        $.ajax({
            url: "{{ route('igd.detail.handling') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    let igd = res.igd;
                    $('#igd_keluhan').text(igd && igd.keluhan_utama ? igd.keluhan_utama : 'Penanganan kegawatdaruratan medis IGD unit.');
                    $('#igd_anamnesis').text(igd && igd.anamnesis ? igd.anamnesis : 'Pemeriksaan fisik awal dan stabilisasi pasien.');
                    $('#igd_diagnosis').text(igd && igd.diagnosis ? igd.diagnosis : 'Sesuai catatan pemeriksaan dokter DPJP IGD.');

                    let tindakanRows = '';
                    if (res.tindakanList && res.tindakanList.length > 0) {
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
                        tindakanRows = '<tr><td colspan="3" class="text-center text-muted py-3">Belum ada tindakan atau layanan IGD tercatat.</td></tr>';
                    }
                    $('#tbody-igd-tindakan').html(tindakanRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat rincian histori penanganan IGD.', 'error');
            }
        });
    }
</script>
@endsection
