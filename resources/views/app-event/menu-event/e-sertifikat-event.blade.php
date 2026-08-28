@extends('layouts.layouts')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include DataTables + Buttons CSS & SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    :root {
        --certificate-gold: #d97706;
        --bg-gold-light: #fffbeb;
        --card-glass: rgba(255, 255, 255, 0.95);
        --gradient-certificate: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
    }

    .font-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .glass-card-light {
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px -5px rgba(217, 119, 6, 0.1);
    }

    .header-certificate {
        background: var(--gradient-certificate);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px -10px rgba(217, 119, 6, 0.3);
    }

    .table-cert {
        --bs-table-bg: transparent;
        --bs-table-color: #334155;
    }

    .table-cert thead th {
        color: #92400e;
        border-bottom: 2px solid #fde68a;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
    }
</style>

<!-- Header Banner E-Certificate -->
<div class="header-certificate p-4 mb-3 text-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative overflow-hidden">
    <i class="fas fa-award position-absolute text-white opacity-10" style="font-size: 10rem; right: -20px; bottom: -30px;"></i>
    <div class="position-relative z-1">
        <span class="badge bg-white text-warning fw-bold mb-2 px-3 py-1 rounded-pill shadow-sm">
            <i class="fas fa-certificate text-warning me-1"></i> E-Certificate Generator
        </span>
        <h2 class="fw-extrabold mb-1 text-white">E-Sertifikat Peserta Event</h2>
        <p class="mb-0 text-white-50">Filter bertingkat Event &rarr; Sub Event &rarr; Kelas &rarr; Sesi untuk cetak & kirim sertifikat peserta.</p>
    </div>
</div>

<!-- Filter Card -->
<div class="glass-card-light p-4 mb-3">
    <h5 class="fw-bold mb-3 text-dark">
        <i class="fas fa-filter text-warning me-2"></i> Filter Data Peserta Sertifikat
    </h5>

    <div class="row g-3">
        <!-- 1. Event Utama -->
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary small">1. Event Utama</label>
            <select id="selectEvent" class="form-select form-select-lg rounded-3 border-warning shadow-sm fw-semibold">
                <option value="">-- Pilih Event --</option>
                @foreach($events as $event)
                <option value="{{ $event->event_data_code }}">{{ $event->event_data_tittle }}</option>
                @endforeach
            </select>
        </div>

        <!-- 2. Sub Event -->
        <div class="col-md-3" id="wrapperSubEvent" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">2. Sub Event</label>
            <select id="selectSubEvent" class="form-select form-select-lg rounded-3 border-warning shadow-sm fw-semibold">
                <option value="">-- Pilih Sub Event --</option>
            </select>
        </div>

        <!-- 3. Kelas (Opsional) -->
        <div class="col-md-3" id="wrapperClass" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">3. Kelas (Opsional)</label>
            <select id="selectClass" class="form-select form-select-lg rounded-3 border-warning shadow-sm fw-semibold">
                <option value="">-- Semua Kelas --</option>
            </select>
        </div>

        <!-- 4. Session Check (Opsional) -->
        <div class="col-md-3" id="wrapperSession" style="display: none;">
            <label class="form-label fw-semibold text-secondary small">4. Sesi Check-In (Opsional)</label>
            <select id="selectSession" class="form-select form-select-lg rounded-3 border-warning shadow-sm fw-semibold">
                <option value="">-- Semua Sesi --</option>
            </select>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="glass-card-light p-4" id="wrapperTablePeserta" style="display: none;">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-file-certificate text-warning me-2"></i>Daftar Penerima Sertifikat</h5>
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 font-mono" id="badgeTotalPeserta">0 Peserta</span>
        </div>

        <!-- Filter Status Kehadiran & Tombol Cetak/Export -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-group btn-group-sm me-2" role="group">
                <input type="radio" class="btn-check" name="filterStatusPresence" id="filterAll" value="all" checked autocomplete="off">
                <label class="btn btn-outline-warning text-dark px-3 fw-semibold" for="filterAll">Semua</label>

                <input type="radio" class="btn-check" name="filterStatusPresence" id="filterPresent" value="present" autocomplete="off">
                <label class="btn btn-outline-success px-3 fw-semibold" for="filterPresent">Hadir (Eligible)</label>
            </div>

            <!-- Tombol Print Massal -->
            <button id="btnBulkPrint" class="btn btn-sm btn-dark rounded-3 fw-semibold shadow-sm">
                <i class="fas fa-print me-1"></i> Cetak Semua PDF
            </button>

            <!-- Container Tombol Export DataTables -->
            <div id="exportButtonsContainer"></div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tablePeserta" class="table table-cert align-middle w-100">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th>Kode Reg</th>
                    <th>Nama Peserta</th>
                    <th>Instansi</th>
                    <th>Kelas</th>
                    <th class="text-center">Status Kehadiran</th>
                    <th class="text-center">Check-In Sesi</th>
                    <th class="text-center" width="18%">Aksi Sertifikat</th>
                </tr>
            </thead>
            <tbody id="tbodyPeserta"></tbody>
        </table>
    </div>
</div>

<!-- MODAL PREVIEW CERTIFICATE -->
<div class="modal fade" id="modalPreviewCert" tabindex="-1" aria-labelledby="modalPreviewCertLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-warning text-dark border-0 rounded-top-4">
                <h5 class="modal-header-title mb-0 fw-bold" id="modalPreviewCertLabel">
                    <i class="fas fa-certificate me-2"></i> Preview E-Sertifikat Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 75vh;">
                <iframe id="iframeCertPreview" src="" class="w-100 h-100 border-0"></iframe>
            </div>
            <div class="modal-footer bg-light border-0 rounded-bottom-4">
                <button type="button" class="btn btn-secondary rounded-3 fw-bold" data-bs-dismiss="modal">Tutup</button>
                <a id="btnDirectDownloadCert" href="#" target="_blank" class="btn btn-warning text-dark rounded-3 fw-bold">
                    <i class="fas fa-external-link-alt me-1"></i> Buka / Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Library -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables Export Plugins -->
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

        // Filter status kehadiran
        $('input[name="filterStatusPresence"]').on('change', function() {
            renderTableData();
        });

        // Action Bulk Print
        $('#btnBulkPrint').on('click', function() {
            let subCode = $('#selectSubEvent').val();
            let classId = $('#selectClass').val() || 'ALL';
            let sessionCode = $('#selectSession').val() || 'ALL';

            if (!subCode) {
                Swal.fire('Perhatian', 'Pilih Sub Event terlebih dahulu.', 'warning');
                return;
            }

            let bulkUrl = `/admin/events/certificates/bulk-print?sub_code=${subCode}&class_id=${classId}&session_code=${sessionCode}`;
            window.open(bulkUrl, '_blank');
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
        $('#tbodyPeserta').html('<tr><td colspan="8" class="text-center py-4"><div class="spinner-border text-warning"></div><div class="mt-2 text-muted">Memuat data penerima sertifikat...</div></td></tr>');

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
                $('#tbodyPeserta').html('<tr><td colspan="8" class="text-center py-4 text-danger">Gagal mengambil data peserta sertifikat.</td></tr>');
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
        }

        $('#badgeTotalPeserta').text(displayData.length + ' Peserta');

        let tbodyHtml = '';

        if (displayData.length > 0) {
            $.each(displayData, function(i, item) {
                let isPresent = item.attendance_status === 'present';

                // Status Kehadiran Badge + Timestamp Waktu
                let attendanceTime = item.attended_at ? `<div class="fs--2 text-muted mt-1"><i class="far fa-clock me-1"></i>${item.attended_at}</div>` : '';
                let statusBadge = isPresent ?
                    `<div><span class="badge bg-success bg-opacity-10 text-white border border-success rounded-pill px-3 py-1 fw-bold"><i class="fas fa-check-circle me-1"></i>Hadir</span>${attendanceTime}</div>` :
                    `<div><span class="badge bg-warning bg-opacity-10 text-white border border-warning rounded-pill px-3 py-1 fw-bold"><i class="fas fa-clock me-1"></i>Belum Hadir</span></div>`;

                // Status Session Check Badge + Timestamp Waktu Sesi
                let sessionTime = item.session_check_in_at ? `<div class="fs--2 text-muted mt-1"><i class="far fa-clock me-1"></i>${item.session_check_in_at}</div>` : '';
                let sessionCheckBadge = item.session_check_in_at ?
                    `<div><span class="badge bg-info bg-opacity-10 text-white border border-info rounded-pill px-3 py-1 fw-bold">Executed</span>${sessionTime}</div>` :
                    `<div><span class="badge bg-secondary bg-opacity-10 text-muted border rounded-pill px-3 py-1">Belum Sesi</span></div>`;

                // Combined Action Buttons (Cetak Modal & Send Email Swal)
                let actionBtn = isPresent ?
                    `<div class="d-flex align-items-center justify-content-center gap-1">
                        <button onclick="openModalCertificate('${item.registration_code}')" class="btn btn-xs btn-warning text-dark fw-bold rounded-3 shadow-sm px-2" title="Cetak PDF Sertifikat">
                            <i class="fas fa-certificate me-1"></i> Cetak
                        </button>
                        <button onclick="confirmSendEmail('${item.registration_code}', '${item.full_name}')" class="btn btn-xs btn-info text-white fw-bold rounded-3 shadow-sm px-2" title="Kirim Sertifikat via Email">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Email
                        </button>
                    </div>` :
                    `<button class="btn btn-xs btn-secondary opacity-50 rounded-3 px-3" disabled title="Peserta harus hadir untuk cetak/kirim sertifikat">
                        <i class="fas fa-lock me-1"></i> Terkunci
                    </button>`;

                tbodyHtml += `
                <tr>
                    <td>${i + 1}</td>
                    <td><span class="badge bg-light text-warning border border-warning font-mono px-2 py-1">${item.registration_code || '-'}</span></td>
                    <td>
                        <div class="fw-bold text-dark">${item.full_name || '-'}</div>
                        <small class="text-muted font-mono">${item.participant_code || '-'}</small>
                    </td>
                    <td>${item.institution || '-'}</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">${item.event_data_sub_class_name || '-'}</span></td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="text-center">${sessionCheckBadge}</td>
                    <td class="text-center">${actionBtn}</td>
                </tr>
            `;
            });

            $('#tbodyPeserta').html(tbodyHtml);

            // Inisialisasi DataTables
            dataTableInstance = $('#tablePeserta').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel me-1"></i> Export Excel',
                        className: 'btn btn-sm btn-success rounded-3 fw-semibold shadow-sm',
                        title: 'Daftar Penerima Sertifikat Event'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf me-1"></i> Export PDF List',
                        className: 'btn btn-sm btn-danger rounded-3 fw-semibold shadow-sm ms-1',
                        title: 'Daftar Penerima Sertifikat Event',
                        orientation: 'portrait',
                        pageSize: 'A4'
                    }
                ],
                language: {
                    search: "Cari Peserta:",
                    lengthMenu: "_MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ Peserta",
                    zeroRecords: "Tidak ada data peserta untuk sertifikat"
                }
            });

            dataTableInstance.buttons().container().appendTo('#exportButtonsContainer');

        } else {
            $('#tbodyPeserta').html(`<tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada data peserta ditemukan.</td></tr>`);
        }
    }

    // 1. Function Buka Modal Cetak Sertifikat
    function openModalCertificate(regCode) {
        let certUrl = `/admin/events/certificates/print/${regCode}`;
        $('#iframeCertPreview').attr('src', certUrl);
        $('#btnDirectDownloadCert').attr('href', certUrl);
        $('#modalPreviewCert').modal('show');
    }

    // 2. Function SweetAlert Konfirmasi & Loading Kirim Email
    function confirmSendEmail(regCode, name) {
        Swal.fire({
            title: 'Kirim E-Sertifikat?',
            text: `Apakah Anda yakin ingin mengirim sertifikat ke email milik ${name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0ea5e9',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-paper-plane me-1"></i> Ya, Kirim Email',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan Swal Loading
                Swal.fire({
                    title: 'Mengirim Email...',
                    text: 'Mohon tunggu sebentar, sertifikat sedang dikirim.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Eksekusi Kirim Email via AJAX
                $.ajax({
                    url: `/admin/events/certificates/send-email/${regCode}`,
                    type: 'POST',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'Sertifikat telah berhasil dikirim ke email peserta.',
                            icon: 'success',
                            confirmButtonColor: '#0ea5e9'
                        });
                    },
                    error: function(xhr) {
                        let errMsg = xhr.responseJSON?.message || 'Gagal mengirim email sertifikat.';
                        Swal.fire({
                            title: 'Gagal!',
                            text: errMsg,
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                });
            }
        });
    }
</script>
@endsection
