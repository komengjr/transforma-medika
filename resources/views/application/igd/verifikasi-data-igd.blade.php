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
        background: linear-gradient(135deg, #cb356b 0%, #bd3f32 100%);
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
                            <i class="fas fa-ambulance text-danger fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Instalasi Gawat Darurat</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Verifikasi & Monitoring Data Pasien IGD</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR KOMPREHENSIF -->
<div class="retro-card mb-4 p-3 bg-white">
    <form id="form-filter-igd" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Dari Tanggal:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="far fa-calendar-alt text-success me-1"></i> Sampai Tanggal:</label>
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-heartbeat text-success me-1"></i> Status Triage:</label>
                <select id="triage" name="triage" class="form-select retro-input">
                    <option value="">-- Semua Triage --</option>
                    <option value="MERAH">Merah (Emergency)</option>
                    <option value="KUNING">Kuning (Urgent)</option>
                    <option value="HIJAU">Hijau (Non-Urgent)</option>
                    <option value="HITAM">Hitam (Death on Arrival)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-check-circle text-success me-1"></i> Status Kunjungan:</label>
                <select id="status_kunjungan" name="status_kunjungan" class="form-select retro-input">
                    <option value="">-- Semua Status --</option>
                    <option value="PROSES">Proses Penanganan</option>
                    <option value="SELESAI">Selesai / Pulang</option>
                    <option value="RAWAT_INAP">Dirujuk ke Rawat Inap</option>
                </select>
            </div>
            <div class="col-md-9">
                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-search text-success me-1"></i> Kata Kunci Pencarian:</label>
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari No. Registrasi, Nama Pasien, atau No. RM..." />
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm w-50 fw-bold" style="height: 38px;">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <button type="button" onclick="resetFilter()" class="btn retro-btn btn-secondary btn-sm w-50 fw-bold" style="height: 38px;">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE VERIFIKASI IGD -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Daftar Kunjungan Pasien IGD</h5>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-verifikasi-igd" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg & Waktu</th>
                        <th>Pasien & RM</th>
                        <th class="text-center">Triage</th>
                        <th>Keluhan Utama</th>
                        <th>Dokter Pemeriksa</th>
                        <th class="text-end">Tagihan</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL HASIL & HANDLING IGD -->
<div class="modal fade" id="modalDetailIgd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-card border-0">
            <div class="modal-header bg-cyan text-dark border-bottom border-dark py-3">
                <h5 class="modal-title fw-bolder"><i class="fas fa-notes-medical me-2"></i> Rincian Hasil & Penanganan IGD: <span id="igd_nama_pasien"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="alert alert-light border border-dark mb-3">
                    <strong class="text-dark d-block mb-1">Keluhan Utama:</strong>
                    <p id="igd_keluhan" class="mb-0 fw-bold text-danger">-</p>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Anamnesis / Pemeriksaan Fisik:</small>
                            <span id="igd_anamnesis" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border border-dark rounded bg-light">
                            <small class="fw-bold text-muted d-block">Diagnosis / Tindakan Utama:</small>
                            <span id="igd_diagnosis" class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bolder text-dark mb-2"><i class="fas fa-stethoscope text-success me-1"></i> Daftar Tindakan & Layanan Medis IGD</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Layanan / Tindakan</th>
                                <th class="text-center" style="width: 80px;">Jumlah</th>
                                <th class="text-end" style="width: 150px;">Tarif</th>
                                <th class="text-center" style="width: 90px;">Aksi</th>
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
    let tableVerifikasiIgd;

    $(document).ready(function() {
        tableVerifikasiIgd = $('#table-verifikasi-igd').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('igd.verifikasi.datatable') }}",
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.triage = $('#triage').val();
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
                    data: 'triage',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'keluhan',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'dokter',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tagihan',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ]
        });
    });

    function reloadTable() {
        tableVerifikasiIgd.ajax.reload(null, false);
    }

    function resetFilter() {
        $('#start_date').val("{{ date('Y-m-d') }}");
        $('#end_date').val("{{ date('Y-m-d') }}");
        $('#triage').val('');
        $('#status_kunjungan').val('');
        $('#keyword').val('');
        reloadTable();
    }

    let currentRegistrasiId = null;
    let currentNamaPasien = '';

    function lihatDetailIgd(registrasiId, namaPasien) {
        currentRegistrasiId = registrasiId;
        currentNamaPasien = namaPasien;

        $('#igd_nama_pasien').text(namaPasien);
        $('#igd_keluhan').text('Memuat...');
        $('#igd_anamnesis').text('Memuat...');
        $('#igd_diagnosis').text('Memuat...');
        $('#tbody-igd-tindakan').html('<tr><td colspan="4" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailIgd').modal('show');
        loadDetailIgdContent(registrasiId);
    }

    function loadDetailIgdContent(registrasiId) {
        $.ajax({
            url: "{{ route('igd.detail.verifikasi') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    let igd = res.igd;
                    $('#igd_keluhan').text(igd && igd.keluhan_utama ? igd.keluhan_utama : '-');
                    $('#igd_anamnesis').text(igd && igd.anamnesis ? igd.anamnesis : '-');
                    $('#igd_diagnosis').text(igd && igd.diagnosis ? igd.diagnosis : '-');

                    let tindakanRows = '';
                    if (res.tindakanList.length > 0) {
                        res.tindakanList.forEach(function(item) {
                            let btnCancel = '';
                            if (item.status_pembayaran !== 'LUNAS') {
                                btnCancel = `<button type="button" class="btn btn-sm btn-danger py-0 px-2 fw-bold" onclick="batalkanItemIgd('${item.detail_id}')" title="Batalkan Item"><i class="fas fa-trash-alt"></i></button>`;
                            } else {
                                btnCancel = `<span class="badge bg-success">Lunas</span>`;
                            }

                            tindakanRows += `
                            <tr>
                                <td class="fw-bold text-dark">${item.nama_layanan}</td>
                                <td class="text-center">${item.jumlah}</td>
                                <td class="text-end">Rp ${Number(item.tarif).toLocaleString('id-ID')}</td>
                                <td class="text-center">${btnCancel}</td>
                            </tr>
                        `;
                        });
                    } else {
                        tindakanRows = '<tr><td colspan="4" class="text-center text-muted py-3">Belum ada tindakan atau layanan IGD tercatat.</td></tr>';
                    }
                    $('#tbody-igd-tindakan').html(tindakanRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat rincian hasil dan penanganan IGD.', 'error');
            }
        });
    }

    function batalkanItemIgd(detailId) {
        Swal.fire({
            title: 'Batalkan Tindakan?',
            text: "Tindakan atau resep ini akan dihapus dan total tagihan kasir akan disesuaikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#bd3f32',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('igd.detail.cancel-item') }}", // Sesuaikan nama route Anda
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        detail_id: detailId
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil', res.message, 'success');
                            // Reload isi modal dan tabel utama di belakang
                            loadDetailIgdContent(currentRegistrasiId);
                            reloadTable();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
