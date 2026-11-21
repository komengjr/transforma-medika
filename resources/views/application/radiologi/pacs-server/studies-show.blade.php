<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DICOM Preview - {{ $studyDetail['PatientMainDicomTags']['PatientName'] ?? $studyId }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --rad-dark-bg: #0f172a;
            --rad-card-bg: #1e293b;
            --rad-accent-cyan: #38bdf8;
            --rad-glow-cyan: rgba(56, 189, 248, 0.35);
            --rad-border: #334155;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background-color: var(--rad-dark-bg);
            color: #f8fafc;
            overflow: hidden;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .pacs-navbar {
            height: 56px;
            background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
            border-bottom: 1px solid var(--rad-border);
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .main-layout {
            display: flex;
            height: calc(100vh - 56px);
            width: 100vw;
            position: relative;
        }

        .sidebar-info {
            width: 340px;
            min-width: 340px;
            background-color: var(--rad-card-bg);
            border-right: 1px solid var(--rad-border);
            padding: 18px;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 0;
            z-index: 10;
        }

        .sidebar-info.collapsed {
            margin-left: -340px;
            padding-left: 0;
            padding-right: 0;
            opacity: 0;
            visibility: hidden;
        }

        .viewer-container {
            flex-grow: 1;
            height: 100%;
            background-color: #000000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .sidebar-section-title {
            color: var(--rad-accent-cyan);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px dashed var(--rad-border);
            padding-bottom: 8px;
            margin-bottom: 14px;
        }

        .info-group {
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #f1f5f9;
            word-break: break-word;
        }

        .info-value-highlight {
            color: #38bdf8;
        }

        .sidebar-info::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-info::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }

        .sidebar-info::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        .btn-cyan-outline {
            background-color: rgba(56, 189, 248, 0.08);
            color: var(--rad-accent-cyan);
            border: 1px solid rgba(56, 189, 248, 0.3);
            transition: all 0.2s ease;
        }

        .btn-cyan-outline:hover {
            background-color: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        }

        .btn-cyan-toggle {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
        }

        .btn-cyan-toggle:hover {
            background-color: #0369a1;
            color: #ffffff;
        }

        .form-control-dark {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
            font-size: 0.85rem;
        }

        .form-control-dark:focus {
            background-color: #0f172a;
            border-color: #38bdf8;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.2);
        }
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <nav class="navbar pacs-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('pacs.studies', ['akses' => $akses, 'id' => $code]) }}"
                class="btn btn-sm btn-outline-secondary text-white border-secondary me-2"
                title="Kembali ke Daftar Pemeriksaan">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <button id="toggleSidebarBtn" class="btn btn-sm btn-cyan-toggle me-3 shadow-sm" onclick="toggleSidebar()" title="Buka/Tutup Sidebar Info">
                <i class="fa-solid fa-bars me-1" id="toggleIcon"></i>
                <span id="toggleText" class="d-none d-sm-inline">Info & Bacaan</span>
            </button>

            <span class="navbar-brand mb-0 h1 fs-6 d-flex align-items-center">
                <i class="fa-solid fa-x-ray me-2 text-info" style="color: #38bdf8 !important;"></i>
                <span class="fw-bold text-white">Orthanc OHIF Viewer</span>
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark text-info border border-info border-opacity-30 px-3 py-2 rounded-pill font-monospace d-none d-md-inline-block" style="color: #38bdf8 !important;">
                <i class="fa-solid fa-hashtag me-1"></i>UUID: {{ \Illuminate\Support\Str::limit($studyId, 14) }}
            </span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-layout">

        <!-- Sidebar Detail Pasien & Bacaan Dokter -->
        <div class="sidebar-info" id="sidebarInfo">
            <ul class="nav nav-pills nav-fill mb-3 p-1 rounded" style="background-color: #0f172a;" id="sidebarTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-1 px-2 small fw-semibold" id="info-tab" data-bs-toggle="pill" data-bs-target="#tab-info" type="button" role="tab">
                        <i class="fa-solid fa-id-card me-1"></i> Info Pasien
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-1 px-2 small fw-semibold" id="expertise-tab" data-bs-toggle="pill" data-bs-target="#tab-expertise" type="button" role="tab">
                        <i class="fa-solid fa-stethoscope me-1"></i> Expertise
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="sidebarTabContent">
                <!-- TAB 1: INFORMASI PASIEN & STUDI -->
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <div class="sidebar-section-title">
                        <i class="fa-solid fa-user-injured me-2"></i>Data Pasien
                    </div>

                    <div class="info-group">
                        <div class="info-label">Nama Pasien</div>
                        <div class="info-value info-value-highlight">
                            {{ $studyDetail['PatientMainDicomTags']['PatientName'] ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">ID Pasien / No. RM</div>
                        <div class="info-value font-monospace">
                            {{ $studyDetail['PatientMainDicomTags']['PatientID'] ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Jenis Kelamin / Tgl Lahir</div>
                        <div class="info-value">
                            {{ $studyDetail['PatientMainDicomTags']['PatientSex'] ?? '-' }} /
                            {{ $studyDetail['PatientMainDicomTags']['PatientBirthDate'] ?? '-' }}
                        </div>
                    </div>

                    <div class="sidebar-section-title mt-4">
                        <i class="fa-solid fa-file-medical me-2"></i>Detail Pemeriksaan
                    </div>

                    <div class="info-group">
                        <div class="info-label">Tanggal Pemeriksaan</div>
                        <div class="info-value">
                            @php $rawDate = $studyDetail['MainDicomTags']['StudyDate'] ?? ''; @endphp
                            @if(strlen($rawDate) === 8 && is_numeric($rawDate))
                            {{ \Carbon\Carbon::createFromFormat('Ymd', $rawDate)->format('d M Y') }}
                            @else
                            {{ $rawDate ?: 'N/A' }}
                            @endif
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Deskripsi Study</div>
                        <div class="info-value">
                            {{ $studyDetail['MainDicomTags']['StudyDescription'] ?? 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Accession Number</div>
                        <div class="info-value font-monospace">
                            {{ $studyDetail['MainDicomTags']['AccessionNumber'] ?? '-' }}
                        </div>
                    </div>

                    <div class="mt-4 pt-2 d-grid gap-2">
                        <a href="{{ $iframeUrl }}" target="_blank" class="btn btn-sm btn-cyan-outline py-2 fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Tab Baru
                        </a>
                        <a href="{{ url('/pacs-proxy/studies/' . $studyId . '/archive') }}" class="btn btn-sm btn-outline-secondary text-light py-2">
                            <i class="fa-solid fa-download me-1"></i> Unduh DICOM (.ZIP)
                        </a>
                    </div>
                </div>

                <!-- TAB 2: FORM BACAAN / EXPERTISE DOKTER -->
                <div class="tab-pane fade" id="tab-expertise" role="tabpanel">
                    <div class="sidebar-section-title">
                        <i class="fa-solid fa-notes-medical me-2"></i>Input Hasil Bacaan
                    </div>

                    <form id="formExpertise">
                        @csrf
                        <input type="hidden" name="study_instance_uid" value="{{ $uid }}">
                        <input type="hidden" name="orthanc_study_id" value="{{ $studyId }}">

                        <div class="mb-3">
                            <label class="info-label">Klinis / Indikasi</label>
                            <input type="text" name="klinis" class="form-control form-control-dark" placeholder="Indikasi klinis...">
                        </div>

                        <div class="mb-3">
                            <label class="info-label">Uraian Hasil Pemeriksaan</label>
                            <textarea name="hasil_bacaan" rows="9" class="form-control form-control-dark" placeholder="Tuliskan hasil bacaan radiologi..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="info-label">Kesan / Kesimpulan</label>
                            <textarea name="kesan" rows="3" class="form-control form-control-dark" placeholder="Kesimpulan..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-sm btn-cyan-toggle py-2 fw-semibold">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Expertise
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Frame DICOM Viewer -->
        <div class="viewer-container">
            <iframe src="{{ $iframeUrl }}" allowfullscreen></iframe>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarInfo');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleBtn = document.getElementById('toggleSidebarBtn');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.className = 'fa-solid fa-bars-staggered me-1';
                toggleBtn.className = 'btn btn-sm btn-outline-info me-3 shadow-sm';
            } else {
                toggleIcon.className = 'fa-solid fa-bars me-1';
                toggleBtn.className = 'btn btn-sm btn-cyan-toggle me-3 shadow-sm';
            }
        }
    </script>

</body>

</html>
