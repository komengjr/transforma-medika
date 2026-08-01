@extends('layouts.layouts')
@section('base.css')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- DataTables Bootstrap 5 CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- FontAwesome for Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .pre-raw {
        background-color: #1e1e1e;
        color: #00ff66;
        padding: 15px;
        border-radius: 6px;
        font-family: 'Courier New', Courier, monospace;
        max-height: 400px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endsection
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white"><i class="fas fa-microscope me-2"></i> Data Hasil Interface Laboratory Information System</h5>
    </div>
    <div class="card-body">

        <!-- Filter Form -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label fw-bold">No. Laboratorium</label>
                <input type="text" id="filter_nolab" class="form-control" placeholder="Cari No Lab...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Tanggal Pemeriksaan</label>
                <input type="date" id="filter_tanggal" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Pilih Alat / Instrument</label>
                <select id="filter_instrument" class="form-select">
                    <option value="">-- Semua Alat --</option>
                    @foreach($alatList as $alat)
                    <option value="{{ $alat->instrument_id }}">{{ $alat->nama_alat }} ({{ $alat->kode_alat }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="button" id="btn-filter" class="btn btn-primary flex-fill">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button type="button" id="btn-reset" class="btn btn-secondary">
                    <i class="fas fa-rotate-left"></i> Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="table-medical-results" class="table table-striped table-bordered align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>No. Lab</th>
                        <th>Instrument / Alat</th>
                        <th>Tanggal</th>
                        <th class="text-center" style="width: 80px;">QC</th>
                        <th class="text-center" style="width: 80px;">Query</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

@endsection
@section('base.js')

<!-- Modal Detail Hasil -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa-solid fa-list-check me-2"></i> Detail Hasil Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Info Header -->
                <div class="row mb-3 bg-light p-2 rounded border">
                    <div class="col-md-6">
                        <strong>No. Lab:</strong> <span id="info-nolab">-</span><br>
                        <strong>Alat:</strong> <span id="info-alat">-</span>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <strong>Tanggal:</strong> <span id="info-tanggal">-</span><br>
                        <strong>Status:</strong> <span id="info-status">-</span>
                    </div>
                </div>

                <!-- Table Hasil -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Parameter</th>
                                <th>Hasil</th>
                                <th>Satuan</th>
                                <th>Nilai Rujukan</th>
                                <th>Flag</th>
                            </tr>
                        </thead>
                        <tbody id="detail-results-body">
                            <!-- Injected via Javascript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Raw Payload -->
<div class="modal fade" id="modalRaw" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-code me-2"></i> Raw Payload (ASTM / HL7 / Protocol Data)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>No. Lab: <strong id="raw-nolab">-</strong></p>
                <pre id="raw-content" class="pre-raw">Memuat data...</pre>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {

        // 1. Inisialisasi DataTables
        var table = $('#table-medical-results').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('interfave_lab_data_result_get_data') }}",
                data: function(d) {
                    d.nolab = $('#filter_nolab').val();
                    d.tanggal = $('#filter_tanggal').val();
                    d.instrument_id = $('#filter_instrument').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'mir.id'
                },
                {
                    data: 'nolab',
                    name: 'mir.nolab'
                },
                {
                    data: 'nama_instrument',
                    name: 'mma.nama_alat'
                },
                {
                    data: 'tanggal',
                    name: 'mir.tanggal'
                },
                {
                    data: 'flag_qc',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'flag_query',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ]
        });

        // 2. Event Handler Filter & Reset
        $('#btn-filter').click(function() {
            table.draw();
        });

        $('#btn-reset').click(function() {
            $('#filter_nolab').val('');
            $('#filter_tanggal').val('');
            $('#filter_instrument').val('');
            table.draw();
        });

        // 3. Event Handler Dropdown Action
        $('#table-medical-results').on('change', '.action-select', function() {
            var action = $(this).val();
            var id = $(this).data('id');

            // Reset dropdown pilihan ke default
            $(this).val('');

            if (action === 'toggle-detail') {
                loadDetail(id);
            } else if (action === 'raw-payload') {
                loadRawPayload(id);
            }
        });

        // 4. Function Ajax Detail Hasil
        // Function Ajax Detail Hasil
        function loadDetail(id) {
            var url = "{{ route('interfave_lab_data_result_show_data_detail', ':id') }}".replace(':id', id);

            $.get(url, function(res) {
                if (res.status === 'success') {
                    $('#info-nolab').text(res.info.nolab);
                    $('#info-alat').text(res.info.nama_alat + ' (' + res.info.kode_alat + ')');
                    $('#info-tanggal').text(res.info.tanggal);

                    var flags = '';
                    if (res.info.flag_qc === 'Y') flags += '<span class="badge bg-warning text-dark me-1">QC</span>';
                    if (res.info.flag_query === 'Y') flags += '<span class="badge bg-danger">Query</span>';
                    if (flags === '') flags = '<span class="badge bg-secondary">Normal</span>';
                    $('#info-status').html(flags);

                    var tbody = $('#detail-results-body');
                    tbody.empty();

                    if (!res.results || res.results.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center text-muted">Tidak ada item hasil pemeriksaan</td></tr>');
                    } else {
                        $.each(res.results, function(index, item) {
                            // Penyesuaian Key JSON:
                            // 1. Parameter/Code -> item.px
                            // 2. Nilai Hasil -> item.result
                            // 3. Satuan -> item.unit
                            // 4. Flag -> item.flag

                            var param = item.px || item.test_name || item.code || '-';
                            var hasil = item.result || item.value || '-';
                            var satuan = item.unit || '-';
                            var rujukan = item.reference_range || '-';
                            var flag = item.flag ?
                                `<span class="badge bg-danger">${item.flag}</span>` :
                                '-';

                            tbody.append(`
                        <tr>
                            <td><strong>PX ${param}</strong></td>
                            <td>${hasil}</td>
                            <td>${satuan}</td>
                            <td>${rujukan}</td>
                            <td class="text-center">${flag}</td>
                        </tr>
                    `);
                        });
                    }

                    $('#modalDetail').modal('show');
                }
            }).fail(function() {
                alert('Gagal mengambil detail data.');
            });
        }

        // 5. Function Ajax Raw Payload
        function loadRawPayload(id) {
            var url = "{{ route('interfave_lab_data_result_show_data_raw', ':id') }}".replace(':id', id);

            $('#raw-content').text('Memuat data...');
            $('#modalRaw').modal('show');

            $.get(url, function(res) {
                if (res.status === 'success') {
                    $('#raw-nolab').text(res.nolab);

                    // Format jika berbentuk JSON String
                    try {
                        var parsed = JSON.parse(res.raw_payload);
                        $('#raw-content').text(JSON.stringify(parsed, null, 4));
                    } catch (e) {
                        $('#raw-content').text(res.raw_payload);
                    }
                }
            }).fail(function() {
                $('#raw-content').text('Gagal memuat raw payload.');
            });
        }

    });
</script>
@endsection
