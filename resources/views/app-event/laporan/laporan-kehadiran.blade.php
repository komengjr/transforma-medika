@extends('layouts.layouts')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include DataTables + Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<style>
    :root {
        --sea-blue: #0284c7;
        --bg-beach: #f0f9ff;
        --card-glass: rgba(255, 255, 255, 0.95);
        --gradient-ocean: linear-gradient(135deg, #0284c7 0%, #0d9488 100%);
    }

    /* body {
        background-color: var(--bg-beach);
        background-image: radial-gradient(#e0f2fe 1px, transparent 1px);
        background-size: 24px 24px;
    } */

    .font-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .glass-card-light {
        /* background: var(--card-glass); */
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px -5px rgba(14, 165, 233, 0.1);
    }

    .header-ocean {
        background: var(--gradient-ocean);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px -10px rgba(2, 132, 199, 0.3);
    }

    .table-beach {
        --bs-table-bg: transparent;
        --bs-table-color: #334155;
    }

    .table-beach thead th {
        /* background: #e0f2fe; */
        color: #0369a1;
        border-bottom: 2px solid #bae6fd;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
    }
</style>

<!-- Header Banner Beach Vibe -->
<div class="header-ocean p-4 mb-3 text-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative overflow-hidden">
    <i class="fas fa-umbrella-beach position-absolute text-white opacity-10" style="font-size: 10rem; right: -20px; bottom: -30px;"></i>
    <div class="position-relative z-1">
        <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1 rounded-pill shadow-sm">
            <i class="fas fa-sun text-danger me-1"></i> Beach Vibe Report
        </span>
        <h2 class="fw-extrabold mb-1 text-white">Laporan Kehadiran Peserta</h2>
        <p class="mb-0 text-white-50">Filter bertingkat Event &rarr; Sub Event &rarr; Kelas &rarr; Sesi Check-In.</p>
    </div>
</div>

<!-- Filter Card -->
<div class="glass-card-light p-4 mb-3">
    <h5 class="fw-bold mb-3 text-dark">
        <i class="fas fa-filter text-info me-2"></i> Filter Data Laporan
    </h5>

    <div class="row g-3">
        <!-- 1. Event Utama -->
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary small">1. Event Utama</label>
            <select id="selectEvent" class="form-select form-select-lg rounded-3 border-info shadow-sm fw-semibold">
                <option value="">-- Pilih Event --</option>
                @foreach($events as $event)
                <option value="{{ $event->event_data_code }}">{{ $event->event_data_tittle }}</option>
                @endforeach
            </select>
        </div>

        <!-- 2. Sub Event -->
        <div class="col-md-3" id="wrapperSubEvent" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">2. Sub Event</label>
            <select id="selectSubEvent" class="form-select form-select-lg rounded-3 border-info shadow-sm fw-semibold">
                <option value="">-- Pilih Sub Event --</option>
            </select>
        </div>

        <!-- 3. Kelas (Opsional) -->
        <div class="col-md-3" id="wrapperClass" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">3. Kelas (Opsional)</label>
            <select id="selectClass" class="form-select form-select-lg rounded-3 border-info shadow-sm fw-semibold">
                <option value="">-- Semua Kelas --</option>
            </select>
        </div>

        <!-- 4. Session Check (Opsional) -->
        <div class="col-md-3" id="wrapperSession" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">4. Sesi Check-In (Opsional)</label>
            <select id="selectSession" class="form-select form-select-lg rounded-3 border-info shadow-sm fw-semibold">
                <option value="">-- Semua Sesi --</option>
            </select>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="glass-card-light p-4" id="wrapperTablePeserta" style="display: none;">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-check text-info me-2"></i>Daftar Kehadiran Peserta</h5>
            <span class="badge bg-info text-white rounded-pill px-3 py-2 font-mono" id="badgeTotalPeserta">0 Peserta</span>
        </div>

        <!-- Quick Status Filters & Container Tombol Export -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-group btn-group-sm me-2" role="group">
                <input type="radio" class="btn-check" name="filterStatusPresence" id="filterAll" value="all" checked autocomplete="off">
                <label class="btn btn-outline-info px-3 fw-semibold" for="filterAll">Semua</label>

                <input type="radio" class="btn-check" name="filterStatusPresence" id="filterPresent" value="present" autocomplete="off">
                <label class="btn btn-outline-success px-3 fw-semibold" for="filterPresent">Hadir</label>

                <input type="radio" class="btn-check" name="filterStatusPresence" id="filterAbsent" value="absent" autocomplete="off">
                <label class="btn btn-outline-warning text-dark px-3 fw-semibold" for="filterAbsent">Belum Hadir</label>
            </div>

            <!-- Wadah Tombol Export Excel & PDF DataTables -->
            <div id="exportButtonsContainer"></div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tablePeserta" class="table table-beach align-middle w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kode Reg</th>
                    <th>Nama Peserta</th>
                    <th>Instansi</th>
                    <th>Kelas</th>
                    <th class="text-center">Status Kelas</th>
                    <th class="text-center">Check-In Sesi</th>
                </tr>
            </thead>
            <tbody id="tbodyPeserta"></tbody>
        </table>
    </div>
</div>

<!-- Scripts Library -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Scripts Export DataTables (JSZip, pdfmake, Buttons) -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    let dataTableInstance = null;
    let rawParticipantsData = [];

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 1. Event Utama Change
        $('#selectEvent').on('change', function() {
            let eventCode = $(this).val();
            resetTableAndData();
            $('#selectSubEvent').html('<option value="">-- Pilih Sub Event --</option>');
            $('#selectClass').html('<option value="">-- Semua Kelas --</option>');
            $('#selectSession').html('<option value="">-- Semua Sesi --</option>');

            $('#wrapperSubEvent').hide();
            $('#wrapperClass').hide();
            $('#wrapperSession').hide();
            $('#wrapperTablePeserta').hide();

            if (eventCode) {
                $.ajax({
                    url: `/admin/reports/attendance/get-sub-events/${eventCode}`,
                    type: 'GET',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, sub) {
                                $('#selectSubEvent').append(`<option value="${sub.event_data_sub_code}">${sub.event_data_sub_name}</option>`);
                            });
                            $('#wrapperSubEvent').fadeIn();
                        }
                    }
                });
            }
        });

        // 2. Sub Event Change
        $('#selectSubEvent').on('change', function() {
            let subCode = $(this).val();
            resetTableAndData();
            $('#selectClass').html('<option value="">-- Semua Kelas --</option>');
            $('#selectSession').html('<option value="">-- Semua Sesi --</option>');

            $('#wrapperClass').hide();
            $('#wrapperSession').hide();

            if (subCode) {
                // Dropdown Kelas
                $.ajax({
                    url: `/admin/reports/attendance/get-classes/${subCode}`,
                    type: 'GET',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, cls) {
                                $('#selectClass').append(`<option value="${cls.id_event_data_sub_class}">${cls.event_data_sub_class_name}</option>`);
                            });
                            $('#wrapperClass').fadeIn();
                        }
                    }
                });

                // Dropdown Sessions
                $.ajax({
                    url: `/admin/reports/attendance/get-sessions/${subCode}`,
                    type: 'GET',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, sess) {
                                $('#selectSession').append(`<option value="${sess.event_data_sub_session_code}">${sess.event_data_sub_session_name}</option>`);
                            });
                            $('#wrapperSession').fadeIn();
                        }
                    }
                });

                loadParticipants(subCode, null, null);
            } else {
                $('#wrapperTablePeserta').hide();
            }
        });

        // 3. Kelas Change
        $('#selectClass').on('change', function() {
            let subCode = $('#selectSubEvent').val();
            let classId = $(this).val();
            let sessionCode = $('#selectSession').val();

            if (subCode) {
                loadParticipants(subCode, classId, sessionCode);
            }
        });

        // 4. Session Change
        $('#selectSession').on('change', function() {
            let subCode = $('#selectSubEvent').val();
            let classId = $('#selectClass').val();
            let sessionCode = $(this).val();

            if (subCode) {
                loadParticipants(subCode, classId, sessionCode);
            }
        });

        // Radio Status Filter
        $('input[name="filterStatusPresence"]').on('change', function() {
            renderTableData();
        });
    });

    function resetTableAndData() {
        if (dataTableInstance !== null) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }
        $('#tbodyPeserta').empty();
        $('#exportButtonsContainer').empty();
        rawParticipantsData = [];
    }

    function loadParticipants(subCode, classId, sessionCode) {
        resetTableAndData();

        $('#wrapperTablePeserta').show();
        $('#tbodyPeserta').html('<tr><td colspan="7" class="text-center py-4"><div class="spinner-border text-info"></div><div class="mt-2 text-muted">Memuat data kehadiran...</div></td></tr>');

        $.ajax({
            url: '{{ route("admin.reports.attendance.get_participants") }}',
            type: 'GET',
            data: {
                sub_code: subCode,
                class_id: classId,
                session_code: sessionCode
            },
            success: function(data) {
                rawParticipantsData = data || [];
                $('#filterAll').prop('checked', true);
                renderTableData();
            },
            error: function() {
                resetTableAndData();
                $('#tbodyPeserta').html('<tr><td colspan="7" class="text-center py-4 text-danger">Gagal mengambil data kehadiran.</td></tr>');
            }
        });
    }

    function renderTableData() {
        if (dataTableInstance !== null) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }
        $('#exportButtonsContainer').empty();

        let filterType = $('input[name="filterStatusPresence"]:checked').val();
        let displayData = rawParticipantsData;

        if (filterType === 'present') {
            displayData = rawParticipantsData.filter(item => item.attendance_status === 'present');
        } else if (filterType === 'absent') {
            displayData = rawParticipantsData.filter(item => item.attendance_status !== 'present');
        }

        $('#badgeTotalPeserta').text(displayData.length + ' Peserta');

        let tbodyHtml = '';

        if (displayData.length > 0) {
            $.each(displayData, function(i, item) {
                let statusKelasBadge = item.attendance_status === 'present' ?
                    `<span class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold">Hadir</span>` :
                    `<span class="badge bg-warning bg-opacity-10 text-white border border-warning border-opacity-25 rounded-pill px-3 py-2 fw-bold">Terdaftar</span>`;

                let sessionCheckBadge = item.session_check_in_at ?
                    `<span class="badge bg-info bg-opacity-10 text-white border border-info border-opacity-25 rounded-pill px-3 py-2 fw-bold">Executed</span>` :
                    `<span class="badge bg-secondary bg-opacity-10 text-muted border border-opacity-25 rounded-pill px-3 py-2">Belum Sesi</span>`;

                tbodyHtml += `
                <tr>
                    <td>${i + 1}</td>
                    <td><span class="badge bg-light text-primary border border-info font-mono px-2 py-1">${item.registration_code || '-'}</span></td>
                    <td>
                        <div class="fw-bold text-dark">${item.full_name || '-'}</div>
                        <small class="text-muted font-mono">${item.participant_code || '-'}</small>
                    </td>
                    <td>${item.institution || '-'}</td>
                    <td><span class="badge bg-info bg-opacity-10 text-dark border border-info border-opacity-25">${item.event_data_sub_class_name || '-'}</span></td>
                    <td class="text-center">${statusKelasBadge}</td>
                    <td class="text-center">${sessionCheckBadge}</td>
                </tr>
            `;
            });

            $('#tbodyPeserta').html(tbodyHtml);

            // Inisialisasi DataTables beserta Tombol Export
            dataTableInstance = $('#tablePeserta').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel me-1"></i> Export Excel',
                        className: 'btn btn-sm btn-success rounded-3 fw-semibold shadow-sm',
                        title: 'Laporan Kehadiran Peserta'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf me-1"></i> Export PDF',
                        className: 'btn btn-sm btn-danger rounded-3 fw-semibold shadow-sm ms-1',
                        title: 'Laporan Kehadiran Peserta',
                        orientation: 'portrait',
                        pageSize: 'A4'
                    }
                ],
                language: {
                    search: "Cari Peserta:",
                    lengthMenu: "_MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ Peserta",
                    zeroRecords: "Tidak ada data kehadiran peserta"
                }
            });

            // Pindahkan posisi tombol export ke wadah khusus di atas tabel
            dataTableInstance.buttons().container().appendTo('#exportButtonsContainer');

        } else {
            $('#tbodyPeserta').html(`<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data peserta ditemukan.</td></tr>`);
        }
    }
</script>
@endsection
