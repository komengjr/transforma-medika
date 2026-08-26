<style>
    /* Menggunakan FontAwesome Plus (+) */
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control::before {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
        content: "\f067" !important;
        /* Unicode fa-plus */
        background-color: #4f46e5 !important;
        color: #fff !important;
        border-radius: 50% !important;
        width: 20px !important;
        height: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: none !important;
    }

    /* Menggunakan FontAwesome Minus (-) saat terbuka */
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control::before {
        content: "\f068" !important;
        /* Unicode fa-minus */
        background-color: #ef4444 !important;
    }
</style>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <!-- Header -->
    <div class="card-header bg-dark py-3 border-0 d-flex align-items-center justify-content-between">
        <h5 class="fw-bold mb-0 text-white">Daftar Peserta Terdaftar</h5>
        <span class="badge bg-primary-subtle text-white fw-bold rounded-pill px-3 py-2" id="participant-count-badge">
            {{ count($participants) }} Peserta
        </span>
    </div>

    <!-- Body -->
    <div class="card-body p-3">
        @if(count($participants) > 0)
        <table id="tablePeserta" class="table table-hover align-middle mb-0 w-100">
            <thead class="bg-light">
                <tr class="text-uppercase fs--2 text-secondary">
                    <th class="ps-3">No</th>
                    <th>Kode Booking / Token</th>
                    <th>Kode Peserta</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. WhatsApp</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th class="pe-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @foreach($participants as $index => $participant)
                @php
                $idRegistration = $participant->id_registration ?? ($participant->registration->id_registration ?? null);
                $tokenCode = $participant->qr_code_token ?? ($participant->registrationClass->qr_code_token ?? '-');
                $phoneFormatted = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $participant->phone_number));

                // Pesan WA Kirim Kode
                $waTextCode = rawurlencode("Halo " . $participant->full_name . ",\nBerikut adalah Kode Booking / QR Token Anda: *" . $tokenCode . "*.\nTerima kasih!");

                $payStatus = $participant->payment_status ?? ($participant->registration->payment_status ?? 'pending');

                $emailRoute = $idRegistration ? route('menu_event_data_form_registrasi_sub_event_data_peserta_send_email', $idRegistration) : '#';
                $deleteRoute = $idRegistration ? route('menu_event_data_form_registrasi_sub_event_data_peserta_remove', $idRegistration) : '#';

                // Route Verifikasi Pelunasan (Silakan sesuaikan nama route di web.php Anda jika berbeda)
                $verifyRoute = $idRegistration ? route('menu_event_data_form_registrasi_sub_event_data_peserta_verify_payment', $idRegistration) : '#';
                @endphp
                <tr id="row-participant-{{ $idRegistration }}">
                    <td class="ps-3 fw-semibold text-secondary row-number">{{ $index + 1 }}</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-mono px-2 py-1">
                            {{ $tokenCode }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border fw-mono">
                            {{ $participant->participant_code }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $participant->full_name }}</div>
                        <div class="small text-muted">{{ $participant->institution ?? '-' }}</div>
                    </td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->phone_number }}</td>
                    <td id="status-badge-{{ $idRegistration }}">
                        @if($payStatus == 'paid')
                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 fs--2"><i class="fas fa-wallet me-1"></i>Paid</span>
                        @elseif($payStatus == 'pending')
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1 fs--2"><i class="fas fa-clock me-1"></i>Pending</span>
                        @elseif($payStatus == 'failed')
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 fs--2"><i class="fas fa-exclamation-triangle me-1"></i>Failed</span>
                        @else
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1 fs--2"><i class="fas fa-ban me-1"></i>Cancelled</span>
                        @endif
                    </td>
                    <td class="small text-muted" data-order="{{ strtotime($participant->registration_date ?? ($participant->register_date ?? $participant->created_at)) }}">
                        {{ \Carbon\Carbon::parse($participant->registration_date ?? ($participant->register_date ?? $participant->created_at))->format('d M Y H:i') }}
                    </td>
                    <td class="pe-3 text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle rounded-3 px-3 py-1 fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-1 text-secondary"></i> Opsi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="event.preventDefault(); sendEmailAjax('{{ $emailRoute }}', '{{ $participant->full_name }}');">
                                        <i class="fas fa-envelope text-primary width-16"></i>
                                        <span>Kirim Kode via Email</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="https://wa.me/{{ $phoneFormatted }}?text={{ $waTextCode }}" target="_blank">
                                        <i class="fab fa-whatsapp text-success width-16"></i>
                                        <span>Kirim Kode via WA</span>
                                    </a>
                                </li>

                                <!-- Tombol Verifikasi Pelunasan (Hanya muncul jika BELUM PAID) -->
                                @if($payStatus != 'paid' && $idRegistration)
                                <li id="verify-opt-{{ $idRegistration }}">
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-success fw-medium" href="#" onclick="event.preventDefault(); verifyPaymentAjax('{{ $verifyRoute }}', '{{ $idRegistration }}', '{{ $participant->full_name }}');">
                                        <i class="fas fa-check-circle text-success width-16"></i>
                                        <span>Verifikasi Pelunasan</span>
                                    </a>
                                </li>
                                @endif

                                @if($idRegistration)
                                <li>
                                    <hr class="dropdown-divider opacity-50">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger fw-medium" href="#" onclick="event.preventDefault(); confirmDeleteParticipant('{{ $deleteRoute }}', '{{ $idRegistration }}', '{{ $participant->full_name }}');">
                                        <i class="fas fa-trash-alt width-16"></i>
                                        <span>Hapus Peserta</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-users fa-3x text-secondary opacity-50 mb-2"></i>
            <p class="mb-0 fw-semibold">Belum ada peserta yang mendaftar pada Sub Event ini.</p>
        </div>
        @endif
    </div>
</div>

<!-- CSRF Token Meta untuk jQuery AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Library DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .width-16 {
        width: 16px;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0;
    }

    table.dataTable {
        border-collapse: collapse !important;
    }
</style>

<script>
    var dataTableInstance = dataTableInstance || null;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if ($('#tablePeserta').length) {
            dataTableInstance = $('#tablePeserta').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 peserta",
                    infoFiltered: "(disaring dari _MAX_ total peserta)",
                    zeroRecords: "Data peserta tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selesai",
                        previous: "Sebelumnya"
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [8]
                    },
                    {
                        className: "align-middle",
                        targets: "_all"
                    }
                ]
            });
        }
    });

    // 1. FUNGSI AJAX KIRIM EMAIL
    function sendEmailAjax(url, name) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Mengirim Email...',
                text: 'Mohon tunggu, sedang mengirim kode ke ' + name,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                let msg = response.message || 'Kode registrasi berhasil dikirim ke email peserta.';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: msg,
                        confirmButtonColor: '#3085d6',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                } else {
                    alert(msg);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Gagal mengirim email. Silakan coba lagi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMsg,
                        confirmButtonColor: '#ef4444',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                } else {
                    alert(errorMsg);
                }
            }
        });
    }

    // 2. FUNGSI AJAX VERIFIKASI PELUNASAN (BARU)
    function verifyPaymentAjax(url, id, name) {
        const executeVerify = () => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memverifikasi pelunasan ' + name,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    payment_status: 'paid',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // Update badge status di tabel secara langsung
                    $('#status-badge-' + id).html('<span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 fs--2"><i class="fas fa-wallet me-1"></i>Paid</span>');

                    // Sembunyikan opsi verifikasi pelunasan
                    $('#verify-opt-' + id).remove();

                    let msg = response.message || 'Status pembayaran berhasil diubah menjadi Lunas (Paid).';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Dilunasi!',
                            text: msg,
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-4'
                            }
                        });
                    } else {
                        alert(msg);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal memverifikasi pelunasan. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg,
                            confirmButtonColor: '#ef4444',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        });
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Verifikasi Pelunasan?',
                text: "Apakah Anda yakin pembayaran dari " + name + " sudah LUNAS?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tandai Lunas',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executeVerify();
                }
            });
        } else {
            if (confirm("Konfirmasi pelunasan untuk " + name + "?")) {
                executeVerify();
            }
        }
    }

    // 3. FUNGSI AJAX HAPUS PESERTA
    function confirmDeleteParticipant(url, id, name) {
        const executeDelete = () => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    const targetRow = $('#row-participant-' + id);
                    if (dataTableInstance && targetRow.length) {
                        dataTableInstance.row(targetRow).remove().draw(false);
                    } else {
                        targetRow.remove();
                    }

                    updateParticipantCount(-1);

                    let msg = response.message || 'Data peserta berhasil dihapus.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: msg,
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-4'
                            }
                        });
                    } else {
                        alert(msg);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal menghapus peserta. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg,
                            confirmButtonColor: '#ef4444',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        });
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Peserta?',
                text: "Data pendaftaran untuk " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executeDelete();
                }
            });
        } else {
            if (confirm("Apakah Anda yakin ingin menghapus data pendaftaran " + name + "?")) {
                executeDelete();
            }
        }
    }

    function updateParticipantCount(change) {
        const badge = $('#participant-count-badge');
        if (badge.length) {
            let currentText = badge.text().trim();
            let currentNum = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
            let newNum = Math.max(0, currentNum + change);
            badge.text(newNum + ' Peserta');
        }
    }
</script>
