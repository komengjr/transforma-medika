@extends('layouts.layouts')
@section('base.css')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')

<!-- CARD FILTER -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="fa-solid fa-filter me-1"></i> Filter Data</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="filter_nolab" class="form-label small text-muted">Nomor Lab / Sample ID</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-vial"></i></span>
                    <input type="text" id="filter_nolab" class="form-control" placeholder="Contoh: LAB-20260801-001">
                </div>
            </div>
            <div class="col-md-4">
                <label for="filter_tanggal" class="form-label small text-muted">Tanggal Pemeriksaan</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" id="filter_tanggal" class="form-control">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button id="btn-filter" class="btn btn-primary w-100">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                </button>
                <button id="btn-reset" class="btn btn-outline-secondary w-100">
                    <i class="fa-solid fa-rotate-right me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CARD DATA TABLE -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle" id="medicalTable" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>No. Lab / Sample</th>
                        <th>Instrument ID</th>
                        <th>Waktu Pemeriksaan</th>
                        <th class="text-center">QC Status</th>
                        <th class="text-center">Query Status</th>
                        <th style="width: 180px;" class="text-center">Menu Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Diisi via AJAX DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('base.js')
<!-- MODAL DETAIL HASIL & RAW PAYLOAD -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="detailModalLabel">
                    <i class="fa-solid fa-file-medical me-2"></i> Detail Data - <span id="modalNoLab"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <!-- Konten dinamis akan disisipkan via JS (Tabel Detail / Raw JSON) -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // 1. Inisialisasi DataTable Server-Side
        let table = $('#medicalTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('interfave_lab_data_result_get_data') }}",
                type: "GET",
                data: function(d) {
                    d.nolab = $('#filter_nolab').val();
                    d.tanggal = $('#filter_tanggal').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nolab',
                    name: 'nolab',
                    className: 'fw-bold text-primary'
                },
                {
                    data: 'instrument_id',
                    name: 'instrument_id'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
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
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                search: "Cari Cepat:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        // 2. Event Listener: Ketika Select Dropdown Aksi Diubah
        $('#medicalTable').on('change', '.action-select', function() {
            let selectElement = $(this);
            let selectedValue = selectElement.val();
            let id = selectElement.data('id');

            if (!selectedValue) return;

            // Ambil data detail via AJAX
            $.ajax({
                url: "{{ url('application/interface-lab/data-result') }}/" + id,
                type: "GET",
                beforeSend: function() {
                    selectElement.prop('disabled', true);
                },
                success: function(data) {
                    $('#modalNoLab').text(data.nolab);
                    let content = '';

                    // Opsi 1: Tampilkan Detail Hasil Pemeriksaan
                    if (selectedValue === 'toggle-detail') {
                        $('#detailModalLabel').html('<i class="fa-solid fa-square-poll-vertical me-2"></i> Detail Hasil Lab - ' + data.nolab);

                        let rows = '';
                        if (data.results && Array.isArray(data.results) && data.results.length > 0) {
                            data.results.forEach(item => {
                                let flagBadge = item.flag ?
                                    `<span class="badge bg-warning text-dark">${item.flag}</span>` :
                                    `<span class="badge bg-light text-dark">-</span>`;

                                rows += `<tr>
                                <td class="fw-semibold">${item.px || item.parameter || '-'}</td>
                                <td class="text-primary fw-bold">${item.result || item.nilai || '-'}</td>
                                <td>${flagBadge}</td>
                            </tr>`;
                            });
                        } else {
                            rows = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada detail hasil pemeriksaan.</td></tr>';
                        }

                        content = `
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Parameter (PX)</th>
                                        <th>Hasil (Result)</th>
                                        <th>Flag</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>
                    `;
                    }
                    // Opsi 2: Tampilkan Raw Payload Data
                    else if (selectedValue === 'raw-payload') {
                        $('#detailModalLabel').html('<i class="fa-solid fa-code me-2"></i> Raw Payload - ' + data.nolab);

                        let payloadText = data.raw_payload ?
                            JSON.stringify(data.raw_payload, null, 2) :
                            'Raw payload kosong.';

                        content = `
                        <div class="bg-dark text-success p-3 rounded" style="max-height: 400px; overflow-y: auto;">
                            <pre class="mb-0" style="font-size: 13px;"><code>${payloadText}</code></pre>
                        </div>
                    `;
                    }

                    // Inject Konten ke Modal Body dan Tampilkan Modal
                    $('#modalBodyContent').html(content);
                    $('#detailModal').modal('show');

                    // Reset nilai select kembali ke default
                    selectElement.val('');
                    selectElement.prop('disabled', false);
                },
                error: function() {
                    alert('Gagal mengambil data detail!');
                    selectElement.prop('disabled', false);
                    selectElement.val('');
                }
            });
        });

        // 3. Custom Filter Events
        $('#btn-filter').click(function() {
            table.draw();
        });

        $('#btn-reset').click(function() {
            $('#filter_nolab').val('');
            $('#filter_tanggal').val('');
            table.draw();
        });
    });
</script>

@endsection
