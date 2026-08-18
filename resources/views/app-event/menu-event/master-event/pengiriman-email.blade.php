@extends('layouts.layouts')

@section('content')


<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Filter Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3 text-dark">
            <i class="fas fa-filter text-primary me-2"></i> Pengiriman Email Tiket Peserta
        </h5>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary small">1. Pilih Event Utama</label>
                <select id="selectEvent" class="form-select form-select-lg rounded-3">
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $event)
                    <option value="{{ $event->id_event_data }}">{{ $event->event_data_tittle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4" id="wrapperSubEvent" style="display: none;">
                <label class="form-label fw-semibold text-secondary small">2. Pilih Sub Event</label>
                <select id="selectSubEvent" class="form-select form-select-lg rounded-3">
                    <option value="">-- Pilih Sub Event --</option>
                </select>
            </div>

            <div class="col-md-4" id="wrapperClass" style="display: none;">
                <label class="form-label fw-semibold text-secondary small">3. Pilih Kelas (Opsional)</label>
                <select id="selectClass" class="form-select form-select-lg rounded-3">
                    <option value="">-- Semua Kelas --</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4" id="wrapperTablePeserta" style="display: none;">
    <div class="card-header bg-white py-3 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 fw-bold text-dark">Daftar Peserta</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2" id="badgeTotalPeserta">0 Peserta</span>
        </div>

        <!-- Filter Status Email & Tombol Kirim Massal -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-group btn-group-sm" role="group" aria-label="Filter Status Email">
                <input type="radio" class="btn-check" name="filterStatusEmail" id="filterAll" value="all" checked autocomplete="off">
                <label class="btn btn-outline-secondary px-3" for="filterAll">Semua Peserta</label>

                <input type="radio" class="btn-check" name="filterStatusEmail" id="filterUnsent" value="unsent" autocomplete="off">
                <label class="btn btn-outline-warning text-dark fw-semibold px-3" for="filterUnsent">Belum Terkirim</label>
            </div>

            <button class="btn btn-sm btn-success rounded-3 px-3 py-2 fw-semibold" id="btnKirimSemua" onclick="sendEmailBulk()">
                <i class="fas fa-paper-plane me-1"></i> Kirim Semua Email
            </button>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="tablePeserta" class="table table-hover align-middle w-100">
                <thead class="bg-light">
                    <tr class="text-uppercase small text-secondary">
                        <th width="5%">No</th>
                        <th>QR Token</th>
                        <th>Nama Peserta</th>
                        <th>Kelas</th>
                        <th>Email</th>
                        <th>Status Email</th>
                        <th>Status Bayar</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPeserta"></tbody>
            </table>
        </div>
    </div>
</div>



<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let dataTableInstance = null;
    let rawParticipantsData = [];

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#selectEvent').on('change', function() {
            let eventId = $(this).val();
            resetTableAndData();
            $('#selectSubEvent').html('<option value="">-- Pilih Sub Event --</option>');
            $('#selectClass').html('<option value="">-- Semua Kelas --</option>');
            $('#wrapperSubEvent').hide();
            $('#wrapperClass').hide();
            $('#wrapperTablePeserta').hide();

            if (eventId) {
                $.ajax({
                    url: `/event-email/get-sub-events/${eventId}`,
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

        $('#selectSubEvent').on('change', function() {
            let subCode = $(this).val();
            resetTableAndData();
            $('#selectClass').html('<option value="">-- Semua Kelas --</option>');
            $('#wrapperClass').hide();

            if (subCode) {
                $.ajax({
                    url: `/event-email/get-classes/${subCode}`,
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

                loadParticipants(subCode, null);
            } else {
                $('#wrapperTablePeserta').hide();
            }
        });

        $('#selectClass').on('change', function() {
            let subCode = $('#selectSubEvent').val();
            let classId = $(this).val();
            if (subCode) {
                loadParticipants(subCode, classId);
            }
        });

        $('input[name="filterStatusEmail"]').on('change', function() {
            renderTableData();
        });
    });

    function resetTableAndData() {
        if (dataTableInstance !== null) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }
        $('#tbodyPeserta').empty();
        rawParticipantsData = [];
    }

    function loadParticipants(subCode, classId) {
        resetTableAndData();

        $('#wrapperTablePeserta').show();
        $('#tbodyPeserta').html('<tr><td colspan="8" class="text-center py-4"><div class="spinner-border text-primary"></div><div class="mt-2 text-muted">Memuat data peserta...</div></td></tr>');

        $.ajax({
            url: '{{ route("event.email.get_participants") }}',
            type: 'GET',
            data: {
                sub_code: subCode,
                class_id: classId
            },
            success: function(data) {
                rawParticipantsData = data || [];
                $('#filterAll').prop('checked', true);
                renderTableData();
            },
            error: function() {
                resetTableAndData();
                $('#tbodyPeserta').html('<tr><td colspan="8" class="text-center py-4 text-danger">Gagal mengambil data peserta.</td></tr>');
            }
        });
    }

    function renderTableData() {
        if (dataTableInstance !== null) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }

        let filterType = $('input[name="filterStatusEmail"]:checked').val();
        let displayData = rawParticipantsData;

        if (filterType === 'unsent') {
            displayData = rawParticipantsData.filter(item => !item.email_sent_at);
        }

        $('#badgeTotalPeserta').text(displayData.length + ' Peserta');

        let tbodyHtml = '';

        if (displayData.length > 0) {
            $.each(displayData, function(i, item) {
                let paymentBadge = item.payment_status === 'paid' ?
                    '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Paid</span>' :
                    '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">' + (item.payment_status || 'Pending') + '</span>';

                // Badge Status Pengiriman Email
                let emailStatusBadge = item.email_sent_at ?
                    `<span class="badge bg-success text-white" title="${item.email_sent_at}"><i class="fas fa-check-circle me-1"></i> Terkirim</span>` :
                    `<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Belum</span>`;

                let phoneFormatted = item.phone_number ? item.phone_number.replace(/^0/, '62').replace(/[^0-9]/g, '') : '';

                tbodyHtml += `
                <tr>
                    <td>${i + 1}</td>
                    <td><span class="badge bg-light text-dark border font-monospace">${item.qr_code_token || '-'}</span></td>
                    <td>
                        <div class="fw-bold text-dark">${item.full_name || '-'}</div>
                        <small class="text-muted">${item.institution || '-'}</small>
                    </td>
                    <td><span class="badge bg-primary-subtle text-primary">${item.event_data_sub_class_name || '-'}</span></td>
                    <td>${item.email || '-'}</td>
                    <td>${emailStatusBadge}</td>
                    <td>${paymentBadge}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary rounded-3 me-1" onclick="sendEmailSingle('${item.id_registration}', '${item.full_name}')">
                            <i class="fas fa-paper-plane me-1"></i> Email
                        </button>
                        ${phoneFormatted ? `
                        <a href="https://wa.me/${phoneFormatted}" target="_blank" class="btn btn-sm btn-success rounded-3">
                            <i class="fab fa-whatsapp"></i>
                        </a>` : ''}
                    </td>
                </tr>
            `;
            });

            $('#tbodyPeserta').html(tbodyHtml);

            dataTableInstance = $('#tablePeserta').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari Peserta:",
                    lengthMenu: "_MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ Peserta",
                    zeroRecords: "Tidak ada data peserta"
                }
            });

        } else {
            let msg = filterType === 'unsent' ? 'Semua peserta sudah menerima email.' : 'Tidak ada data peserta.';
            $('#tbodyPeserta').html(`<tr><td colspan="8" class="text-center py-4 text-muted">${msg}</td></tr>`);
        }
    }

    function sendEmailSingle(idRegistration, name) {
        Swal.fire({
            title: 'Kirim Email Tiket?',
            text: 'Sistem akan mengirimkan tiket ke ' + name,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim Email...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `/event-email/send-single/${idRegistration}`,
                    type: 'POST',
                    success: function(res) {
                        Swal.fire('Berhasil!', res.message, 'success');
                        loadParticipants($('#selectSubEvent').val(), $('#selectClass').val());
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal mengirim email.', 'error');
                    }
                });
            }
        });
    }

    function sendEmailBulk() {
        let filterType = $('input[name="filterStatusEmail"]:checked').val();
        let targetList = rawParticipantsData;

        // Hanya kirim ke yang belum terkirim jika filter "Belum Terkirim" aktif atau secara default
        if (filterType === 'unsent') {
            targetList = rawParticipantsData.filter(item => !item.email_sent_at);
        } else {
            targetList = rawParticipantsData.filter(item => !item.email_sent_at); // Filter otomatis yang belum terkirim
        }

        if (targetList.length === 0) {
            Swal.fire('Info', 'Semua peserta pada daftar ini sudah menerima email tiket.', 'info');
            return;
        }

        let targetIds = targetList.map(p => p.id_registration);

        Swal.fire({
            title: 'Kirim Email Massal?',
            text: `Sistem akan mengirim email ke ${targetIds.length} peserta yang belum terkirim. Lanjutkan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Proses Pengiriman...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route("event.email.send_bulk") }}',
                    type: 'POST',
                    data: {
                        target_ids: targetIds
                    },
                    success: function(res) {
                        Swal.fire('Selesai!', res.message, 'success');
                        loadParticipants($('#selectSubEvent').val(), $('#selectClass').val());
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal mengirim email massal.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
