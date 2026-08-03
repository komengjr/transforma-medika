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
        /* ==========================================
         * RADIOLOGY DICOM VIEWER DARK THEME
         * ========================================== */
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

        /* Top Navigation Header */
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

        /* Sidebar Styling dengan Transisi Smooth */
        .sidebar-info {
            width: 320px;
            min-width: 320px;
            background-color: var(--rad-card-bg);
            border-right: 1px solid var(--rad-border);
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 0;
            z-index: 10;
        }

        /* State ketika Sidebar Disembunyikan */
        .sidebar-info.collapsed {
            margin-left: -320px;
            padding-left: 0;
            padding-right: 0;
            opacity: 0;
            visibility: hidden;
        }

        /* Container Frame Viewer */
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

        /* Information Card Blocks */
        .sidebar-section-title {
            color: var(--rad-accent-cyan);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px dashed var(--rad-border);
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .info-group {
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-label {
            font-size: 0.725rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.925rem;
            font-weight: 600;
            color: #f1f5f9;
            word-break: break-word;
        }

        .info-value-highlight {
            color: #38bdf8;
        }

        /* Custom Scrollbar untuk Sidebar */
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

        /* Custom Button Theme */
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
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <nav class="navbar pacs-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <!-- Tombol Toggle Buka/Tutup Sidebar -->
            <button id="toggleSidebarBtn" class="btn btn-sm btn-cyan-toggle me-3 shadow-sm" onclick="toggleSidebar()" title="Buka/Tutup Sidebar Info">
                <i class="fa-solid fa-bars me-1" id="toggleIcon"></i>
                <span id="toggleText" class="d-none d-sm-inline">Info</span>
            </button>

            <span class="navbar-brand mb-0 h1 fs-6 d-flex align-items-center">
                <i class="fa-solid fa-x-ray me-2 text-info" style="color: #38bdf8 !important;"></i>
                <span class="fw-bold text-white">Orthanc Medical Viewer</span>
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark text-info border border-info border-opacity-30 px-3 py-2 rounded-pill font-monospace" style="color: #38bdf8 !important;">
                <i class="fa-solid fa-hashtag me-1"></i>UUID: {{ Str::limit($studyId, 12) }}
            </span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-layout">

        <!-- Sidebar Detail Pasien -->
        <div class="sidebar-info" id="sidebarInfo">
            <div class="sidebar-section-title">
                <i class="fa-solid fa-id-card me-2"></i>Informasi Pasien
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
                    @if(isset($studyDetail['MainDicomTags']['StudyDate']))
                    {{ \Carbon\Carbon::createFromFormat('Ymd', $studyDetail['MainDicomTags']['StudyDate'])->format('d M Y') }}
                    @else
                    N/A
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

            <div class="mt-4 pt-2">
                <a href="{{ $ohifUrl ?? $viewerUrl }}" target="_blank" class="btn btn-sm btn-cyan-outline w-100 py-2 fw-semibold">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Tab Baru
                </a>
            </div>
        </div>

        <!-- Frame DICOM Viewer -->
        <div class="viewer-container">
            <iframe src="{{ $ohifUrl ?? $viewerUrl }}" allowfullscreen></iframe>
        </div>

    </div>

    <!-- JavaScript Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarInfo');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleBtn = document.getElementById('toggleSidebarBtn');

            // Toggle Class Collapsed
            sidebar.classList.toggle('collapsed');

            // Ubah Ikon & Style Tombol
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
