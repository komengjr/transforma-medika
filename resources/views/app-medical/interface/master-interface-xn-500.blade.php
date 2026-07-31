@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<style>
    .json-container {
        max-height: 250px;
        overflow-y: auto;
        background-color: #1a1e21;
        color: #00ff66;
        padding: 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 12px;
    }
</style>
@endsection

@section('content')


<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-0">
            <div>
                <h2 class="fw-bold text-dark mb-0">Sysmex XN-500 Hematology System</h2>
                <p class="text-muted mb-0">Penerimaan Data Otomatis via Serial / TCP Client Mode</p>
            </div>
            <div>
                <!-- <span id="mainStatusBadge" class="badge bg-danger status-badge shadow-sm">
                    <i id="mainStatusIcon" class="bi bi-broadcast-pin me-1"></i>
                    <span id="mainStatusText">ALAT DISKONEK</span>
                </span> -->
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Panel Left: Perangkat Status -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-bold text-secondary">Perangkat Sysmex XN-500</div>
            <div class="card-body text-center">
                <div class="device-img-container mb-3 border p-2 rounded">
                    <img id="deviceImage" src="https://www.sysmex.com/-/media/project/sysmex/sysmex/images/pdp_hero/xn-550_v3_724x498.png?h=498&iar=0&w=724&sc_lang=en-us&hash=5A9B85B57F677A631EA467054C6D3B12" alt="Sysmex XN-500" style="max-height: 180px; object-fit: contain;">
                </div>
                <small class="text-muted d-block fw-bold">Automated Hematology Analyzer</small>
            </div>
        </div>
    </div>

    <!-- Panel Right: Table Data Database -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-dark">Data Hasil Laboratorium (Sysmex XN-500)</h5>
                <button id="btnReloadTable" class="btn btn-sm btn-outline-primary px-3">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableSysmex" class="table table-striped table-hover w-100 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No. Lab</th>
                                <th>Tanggal</th>
                                <th>Inst. ID</th>
                                <th>QC</th>
                                <th>Query</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail JSON -->
<div class="modal fade" id="modalDetailData" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDetailTitle">Detail Hasil Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold text-primary mb-2">Results (JSON)</h6>
                <pre id="jsonResults" class="json-container mb-3"></pre>

                <h6 class="fw-bold text-secondary mb-2">Raw Payload / ASTM (JSON)</h6>
                <pre id="jsonRawPayload" class="json-container"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
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

<script>
    let tableSysmex;

    $(document).ready(function() {
        tableSysmex = $('#tableSysmex').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('master_medical_interface_xn_500_get_data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nolab',
                    name: 'nolab'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'instrument_id',
                    name: 'instrument_id'
                },
                {
                    data: 'flag_qc',
                    render: d => d === 'Y' ? '<span class="badge bg-warning text-dark">QC</span>' : '<span class="badge bg-secondary">N</span>'
                },
                {
                    data: 'flag_query',
                    render: d => d === 'Y' ? '<span class="badge bg-info">QUERY</span>' : '<span class="badge bg-secondary">N</span>'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [2, 'desc']
            ]
        });

        $('#btnReloadTable').on('click', () => tableSysmex.ajax.reload(null, false));
    });



    function showDetail(nolab, resultsJson, rawPayloadJson) {
        $('#modalDetailTitle').text('Detail Result - No. Lab: ' + nolab);
        $('#jsonResults').text(JSON.stringify(resultsJson, null, 4));
        $('#jsonRawPayload').text(JSON.stringify(rawPayloadJson, null, 4));

        new bootstrap.Modal(document.getElementById('modalDetailData')).show();
    }
</script>
@endsection
