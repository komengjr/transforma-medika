<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Session Check-In - {{ $session->event_data_sub_session_name }}</title>

    <!-- Bootstrap 5.3 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@600&display=swap" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sea-blue: #0284c7;
            --ocean-cyan: #06b6d4;
            --sand-gold: #f59e0b;
            --sand-light: #fef3c7;
            --bg-beach: #f0f9ff;
            --card-glass: rgba(255, 255, 255, 0.85);
            --gradient-ocean: linear-gradient(135deg, #0284c7 0%, #0d9488 100%);
            --gradient-sand: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        }

        body {
            background-color: var(--bg-beach);
            background-image: radial-gradient(#e0f2fe 1px, transparent 1px);
            background-size: 24px 24px;
            color: #0f172a;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Card Custom Beach Theme */
        .glass-card-light {
            background: var(--card-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px -5px rgba(14, 165, 233, 0.1);
        }

        .header-ocean {
            background: var(--gradient-ocean);
            border-radius: 1.5rem;
            box-shadow: 0 12px 35px -10px rgba(2, 132, 199, 0.4);
        }

        /* Stat Cards */
        .stat-card-total {
            background: #ffffff;
            border: 2px solid #e0f2fe;
        }

        .stat-card-success {
            background: #f0fdf4;
            border: 2px solid #bbf7d0;
        }

        /* Input Custom Beach */
        .input-scan-beach {
            background: #ffffff !important;
            border: 2px solid #38bdf8 !important;
            color: #0369a1 !important;
            letter-spacing: 1.5px;
            transition: all 0.3s ease;
        }

        .input-scan-beach:focus {
            border-color: #0284c7 !important;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4) !important;
        }

        /* Table Bright Styling */
        .table-beach {
            --bs-table-bg: transparent;
            --bs-table-color: #334155;
        }

        .table-beach thead th {
            background: #e0f2fe;
            color: #0369a1;
            border-bottom: 2px solid #bae6fd;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
        }

        .table-beach tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .table-beach tbody tr:hover {
            background: rgba(224, 242, 254, 0.4);
        }

        /* Pulsating animation for checked row */
        @keyframes pulseSuccessLight {
            0% {
                background-color: #dcfce7;
            }

            100% {
                background-color: transparent;
            }
        }

        .row-just-checked {
            animation: pulseSuccessLight 2.5s ease-out;
        }

        /* DataTables Custom Overrides Bright */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #475569 !important;
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            border-radius: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .page-item.active .page-link {
            background-color: var(--sea-blue) !important;
            border-color: var(--sea-blue) !important;
            color: #fff !important;
        }

        .page-link {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #0284c7 !important;
            border-radius: 0.5rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid px-3 px-md-4 py-4">
        <!-- Header Banner Beach Theme -->
        <div class="header-ocean p-4 mb-4 text-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative overflow-hidden">
            <i class="fas fa-umbrella-beach position-absolute text-white opacity-10" style="font-size: 10rem; right: -20px; bottom: -30px;"></i>
            <div class="position-relative z-1">
                <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1 rounded-pill shadow-sm">
                    <i class="fas fa-sun text-danger me-1"></i> Session Check-In
                </span>
                <h2 class="fw-extrabold mb-1">{{ $session->event_data_sub_session_name }}</h2>
                <p class="mb-0 text-white-50">
                    Sub Event: <strong class="text-white">{{ $subEvent->event_data_sub_name }}</strong>
                    <span class="mx-2">•</span>
                    <!-- Session Code: <code class="bg-white text-dark px-2 py-1 rounded font-mono fw-bold">{{ $session->event_data_sub_session_code }}</code> -->
                </p>
            </div>
            <div class="position-relative z-1">
                <a href="javascript:history.back()" class="btn btn-light text-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Panel Left: Scanner & Stats -->
            <div class="col-lg-4">
                <!-- Camera & Input Card -->
                <div class="glass-card-light p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-water text-info me-2"></i>Scan Ticket</h5>
                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold" id="btn-toggle-camera">
                            <i class="fas fa-camera me-1"></i> Buka Kamera
                        </button>
                    </div>

                    <!-- Camera Container -->
                    <div id="reader-container" class="mb-3 d-none">
                        <div id="reader" class="rounded-4 overflow-hidden border border-info shadow-sm"></div>
                        <small class="text-muted d-block text-center mt-2">Arahkan QR Code Registrasi ke Kamera</small>
                    </div>

                    <!-- Input Form -->
                    <form id="form-scan-session" autocomplete="off">
                        @csrf
                        <input type="hidden" name="session_code" value="{{ $session->event_data_sub_session_code }}">

                        <div class="mb-3">
                            <label for="input_registration_code" class="form-label text-secondary small fw-bold">
                                KODE REGISTRASI PESERTA
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text border-0 bg-sky-100 text-info" style="background-color: #e0f2fe;"><i class="fas fa-barcode"></i></span>
                                <input type="text"
                                    class="form-control form-control-lg input-scan-beach font-mono text-uppercase fw-bold"
                                    id="input_registration_code"
                                    name="registration_code"
                                    placeholder="REG-XXXXX"
                                    autofocus
                                    required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 fw-bold rounded-3 text-white shadow-md border-0" id="btn-submit-scan" style="background: var(--gradient-ocean);">
                            <i class="fas fa-check-circle me-2"></i> Check Session Now
                        </button>
                    </form>
                </div>

                <!-- Stats Counters -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="glass-card-light stat-card-total p-3 text-center rounded-4">
                            <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Peserta</span>
                            <h3 class="fw-bold text-primary mb-0 font-mono">{{ count($participants) }}</h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="glass-card-light stat-card-success p-3 text-center rounded-4">
                            <span class="text-success small fw-bold text-uppercase d-block mb-1">Sudah Masuk</span>
                            <h3 class="fw-bold text-success mb-0 font-mono" id="counter-hadir">
                                {{ $participants->whereNotNull('executed_at')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Right: Table -->
            <div class="col-lg-8">
                <div class="glass-card-light p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-list-check text-info me-2"></i>Daftar Kehadiran Sesi
                        </h5>
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3 py-2 fw-semibold">
                            <i class="fas fa-sync fa-spin me-1"></i> Live Update
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table id="tableExecuteSession" class="table table-beach align-middle w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Registrasi</th>
                                    <th>Peserta</th>
                                    <th>Instansi</th>
                                    <th class="text-center">Status Sesi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants as $idx => $item)
                                <tr id="row-reg-{{ $item->registration_code }}">
                                    <td>{{ $idx + 1 }}</td>
                                    <td>
                                        <span class="badge bg-light text-primary border border-info border-opacity-50 font-mono px-2 py-1 fs-6 shadow-sm">
                                            {{ $item->registration_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->full_name }}</div>
                                        <small class="text-muted font-mono">{{ $item->participant_code }}</small>
                                    </td>
                                    <td><span class="text-secondary">{{ $item->institution ?? '-' }}</span></td>
                                    <td class="status-col text-center">
                                        @if($item->executed_at)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold">
                                            <i class="fas fa-circle-check me-1"></i>
                                            <span class="time-text font-mono">{{ \Carbon\Carbon::parse($item->executed_at)->format('H:i:s') }}</span>
                                        </span>
                                        @else
                                        <span class="badge bg-secondary bg-opacity-10 text-muted border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Belum Diproses
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Feedback -->
    <audio id="sound-success" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
    <audio id="sound-error" src="https://assets.mixkit.co/active_storage/sfx/2868/2868-preview.mp3" preload="auto"></audio>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        $(document).ready(function() {
            let table = $('#tableExecuteSession').DataTable({
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "",
                    searchPlaceholder: "🔍 Cari nama / registration code..."
                }
            });

            $('#form-scan-session').on('submit', function(e) {
                e.preventDefault();
                let inputReg = $('#input_registration_code');
                let regCode = inputReg.val().trim();
                if (regCode) submitSessionCheck(regCode);
            });

            function submitSessionCheck(registrationCode) {
                let inputReg = $('#input_registration_code');

                $.ajax({
                    url: "{{ route('admin.session.process-check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        session_code: "{{ $session->event_data_sub_session_code }}",
                        registration_code: registrationCode
                    },
                    beforeSend: function() {
                        $('#btn-submit-scan').prop('disabled', true);
                    },
                    success: function(res) {
                        inputReg.val('').focus();
                        $('#btn-submit-scan').prop('disabled', false);

                        if (res.status === 'success') {
                            document.getElementById('sound-success').play();

                            // Alert Swal Berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Check-In!',
                                html: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            let targetRow = $(`#row-reg-${registrationCode}`);
                            let nowTime = new Date().toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            });

                            if (targetRow.length) {
                                targetRow.addClass('row-just-checked');
                                targetRow.find('.status-col').html(`
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold">
                                    <i class="fas fa-circle-check me-1"></i> ${nowTime}
                                </span>
                            `);
                            }

                            let counterElem = $('#counter-hadir');
                            counterElem.text((parseInt(counterElem.text()) || 0) + 1);
                        } else {
                            document.getElementById('sound-error').play();

                            // Alert Swal Peringatan / Gagal Logical
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal Check-In',
                                html: res.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0284c7'
                            });
                        }
                    },
                    error: function(xhr) {
                        inputReg.val('').focus();
                        $('#btn-submit-scan').prop('disabled', false);
                        document.getElementById('sound-error').play();

                        let res = xhr.responseJSON;
                        let errorMessage = (res && res.message) ? res.message : 'Registration Code Tidak Valid atau Gangguan Sistem!';

                        // Alert Swal Gagal / Error System
                        Swal.fire({
                            icon: 'error',
                            title: 'Scan Gagal',
                            html: errorMessage,
                            confirmButtonText: 'Coba Lagi',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }

            // Camera Handler
            let html5QrCode = null;
            let isCameraActive = false;

            $('#btn-toggle-camera').on('click', function() {
                let container = $('#reader-container');

                if (!isCameraActive) {
                    container.removeClass('d-none');
                    html5QrCode = new Html5Qrcode("reader");

                    html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 15,
                            qrbox: {
                                width: 220,
                                height: 220
                            }
                        },
                        (decodedText) => {
                            $('#input_registration_code').val(decodedText);
                            submitSessionCheck(decodedText);
                        }
                    ).catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kamera Error',
                            text: 'Akses kamera ditolak atau tidak tersedia.'
                        });
                        container.addClass('d-none');
                    });

                    $(this).removeClass('btn-outline-info').addClass('btn-danger text-white').html('<i class="fas fa-stop me-1"></i> Tutup Kamera');
                    isCameraActive = true;
                } else {
                    if (html5QrCode) {
                        html5QrCode.stop().then(() => container.addClass('d-none'));
                    }
                    $(this).removeClass('btn-danger text-white').addClass('btn-outline-info').html('<i class="fas fa-camera me-1"></i> Buka Kamera');
                    isCameraActive = false;
                }
            });
        });
    </script>
</body>

</html>
