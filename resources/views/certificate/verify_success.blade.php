<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Verifikasi Keabsahan - {{ $participant->registration_code }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .document-wrapper {
            max-width: 780px;
            margin: 0 auto;
        }

        .official-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        /* Top Security Bar */
        .security-bar {
            height: 6px;
            background: linear-gradient(90deg, #10b981 0%, #059669 50%, #047857 100%);
        }

        /* Watermark Background */
        .watermark-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 8rem;
            font-weight: 900;
            color: rgba(16, 185, 129, 0.03);
            white-space: nowrap;
            user-select: none;
            pointer-events: none;
            z-index: 0;
        }

        /* Official Badge Stamp */
        .stamp-badge {
            background: rgba(16, 185, 129, 0.1);
            border: 1.5px solid #10b981;
            color: #047857;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .document-header {
            border-bottom: 2px dashed #e2e8f0;
            padding-bottom: 20px;
        }

        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
        }

        .info-value {
            font-size: 0.95rem;
            color: #0f172a;
            font-weight: 700;
        }

        .info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }

        /* Signer Card */
        .signer-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 16px;
            transition: all 0.2s ease;
        }

        .signer-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .digital-seal {
            width: 42px;
            height: 42px;
            background: #ecfdf5;
            color: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="py-4 py-md-5">

    <div class="container document-wrapper">
        <div class="card official-card">

            <!-- Top Security Accent -->
            <div class="security-bar"></div>

            <!-- Watermark Text -->
            <div class="watermark-bg">VERIFIED OFFICIAL</div>

            <div class="card-body p-4 p-md-5 position-relative" style="z-index: 1;">

                <!-- Kop / Header Surat Keterangan -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 text-center text-md-start document-header gap-3">
                    <div>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                            <i class="fa-solid fa-shield-halved text-emerald text-success fa-xl"></i>
                            <span class="fw-extrabold text-uppercase text-dark tracking-wide small" style="letter-spacing: 1px;">Sistem Verifikasi Sertifikat Digital</span>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">SURAT KETERANGAN KEABSAHAN</h3>
                    </div>
                    <div>
                        <span class="stamp-badge">
                            <i class="fa-solid fa-circle-check"></i> RESMI & TERVERIFIKASI
                        </span>
                    </div>
                </div>

                <!-- Sub-Header Metadata Scan -->
                <div class="alert alert-light border-0 bg-light d-flex justify-content-between align-items-center p-3 mb-4 rounded-3 small">
                    <span class="text-muted">
                        <i class="fa-regular fa-calendar-check me-1 text-primary"></i> Tanggal Pemindaian: <strong class="text-dark">{{ $verified_at }}</strong>
                    </span>
                    <span class="text-muted d-none d-sm-inline">
                        <i class="fa-solid fa-lock text-success me-1"></i> SSL 256-bit Encrypted
                    </span>
                </div>

                <!-- Pernyataan Resmi -->
                <p class="text-secondary small mb-4 lead fs-6">
                    Menerangkan secara resmi bahwa Sertifikat Digital dengan rincian data di bawah ini adalah <strong>Sah, Asli, dan Terdaftar</strong> pada sistem basis data kami:
                </p>

                <!-- Detail Penerima (Grid Modern Layout) -->
                <div class="info-box mb-4">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <div class="info-label">Nomor Registrasi</div>
                            <div class="info-value text-primary">
                                <i class="fa-solid fa-barcode me-1"></i>{{ $participant->registration_code }}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <div class="info-label">Nama Lengkap Penerima</div>
                            <div class="info-value text-uppercase fs-6">{{ $participant->full_name }}</div>
                        </div>
                        <div class="col-12">
                            <hr class="my-1 text-muted opacity-25">
                        </div>
                        <div class="col-12">
                            <div class="info-label">Nama Agenda / Event</div>
                            <div class="info-value">{{ $participant->event_data_tittle }}</div>
                        </div>

                        @if(isset($participantClasses) && count($participantClasses) > 0)
                        <div class="col-12">
                            <div class="info-label mb-1">Kelas / Sub-Event Terdaftar</div>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($participantClasses as $item)
                                <span class="badge bg-white text-dark border px-2 py-1 font-monospace">
                                    <i class="fa-solid fa-bookmark text-warning me-1"></i>
                                    {{ $item->event_data_sub_name }} — <i>{{ $item->event_data_sub_class_name }}</i>
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Section Penandatangan Elektronik -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="text-uppercase text-secondary fw-bold small mb-0" style="letter-spacing: 0.5px;">
                            <i class="fa-solid fa-signature text-primary me-1"></i> Pengesahan Tanda Tangan Elektronik (TTE)
                        </h6>
                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">Status: Valid</span>
                    </div>

                    <div class="row g-3">
                        <!-- Pengesah 1 -->
                        <div class="col-md-{{ ($config['signer_mode'] ?? '1') == '2' ? '6' : '12' }}">
                            <div class="signer-card h-100 d-flex align-items-start gap-3">
                                <div class="digital-seal flex-shrink-0">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate">{{ $config['signer1_name'] ?? 'Dr. John Doe, M.Pd' }}</div>
                                    <div class="text-muted small text-truncate">{{ $config['signer1_title'] ?? 'Ketua Panitia Pelaksana' }}</div>
                                    <div class="d-flex align-items-center gap-1 mt-2 text-success small fw-semibold">
                                        <i class="fa-solid fa-shield-check"></i> Terverifikasi Digital
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengesah 2 -->
                        @if(($config['signer_mode'] ?? '1') == '2')
                        <div class="col-md-6">
                            <div class="signer-card h-100 d-flex align-items-start gap-3">
                                <div class="digital-seal flex-shrink-0">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate">{{ $config['signer2_name'] ?? 'Prof. Jane Smith, Ph.D' }}</div>
                                    <div class="text-muted small text-truncate">{{ $config['signer2_title'] ?? 'Ketua Umum Organisasi' }}</div>
                                    <div class="d-flex align-items-center gap-1 mt-2 text-success small fw-semibold">
                                        <i class="fa-solid fa-shield-check"></i> Terverifikasi Digital
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Informasi Keamanan -->
                <div class="text-center pt-3 border-top">
                    <p class="small text-muted mb-1">
                        Dokumen ini diterbitkan secara sah melalui sistem validasi kriptografis otomatis dan tidak memerlukan cap/tanda tangan basah fisik tambahan.
                    </p>
                    <span class="font-monospace text-muted extra-small" style="font-size: 11px;">
                        Hash Auth: {{ md5($participant->registration_code . $verified_at) }}
                    </span>
                </div>

            </div>
        </div>

        <!-- System Copyright -->
        <div class="text-center mt-4">
            <p class="text-muted small">© {{ date('Y') }} System E-Certificate Verification Services. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
