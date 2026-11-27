<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DICOM Preview - {{ $studyDetail['PatientMainDicomTags']['PatientName'] ?? $studyId }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pacs-bg: #0b1120;
            --pacs-surface: #131c31;
            --pacs-surface-elevated: #1b2742;
            --pacs-cyan: #38bdf8;
            --pacs-indigo: #6366f1;
            --pacs-border: rgba(148, 163, 184, 0.2);
            --pacs-border-accent: rgba(56, 189, 248, 0.35);
            --pacs-text: #f8fafc;
            --pacs-muted: #94a3b8;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background-color: var(--pacs-bg);
            color: var(--pacs-text);
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .mono-text {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Top Navbar */
        .pacs-navbar {
            height: 58px;
            background: linear-gradient(135deg, #090e1a 0%, #111a30 55%, #172554 100%);
            border-bottom: 1px solid var(--pacs-border-accent);
            padding: 0 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
            z-index: 20;
        }

        .pacs-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            background: rgba(56, 189, 248, 0.12);
            color: var(--pacs-cyan);
            border: 1px solid rgba(56, 189, 248, 0.35);
        }

        /* Layout Container */
        .main-layout {
            display: flex;
            height: calc(100vh - 58px);
            width: 100vw;
            position: relative;
        }

        /* Sidebar */
        .sidebar-info {
            width: 356px;
            min-width: 356px;
            background-color: var(--pacs-surface);
            border-right: 1px solid var(--pacs-border);
            padding: 16px;
            overflow-y: auto;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10;
        }

        .sidebar-info.collapsed {
            margin-left: -356px;
            padding-left: 0;
            padding-right: 0;
            opacity: 0;
            visibility: hidden;
        }

        .sidebar-info::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-info::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.4);
        }

        .sidebar-info::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }

        /* Pills Tab */
        .pacs-nav-pills {
            background-color: var(--pacs-bg);
            border: 1px solid var(--pacs-border);
            border-radius: 12px;
            padding: 4px;
        }

        .pacs-nav-pills .nav-link {
            color: var(--pacs-muted);
            border-radius: 9px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 7px 10px;
            transition: all 0.18s ease;
        }

        .pacs-nav-pills .nav-link:hover {
            color: var(--pacs-text);
        }

        .pacs-nav-pills .nav-link.active {
            background: linear-gradient(135deg, #0284c7 0%, #4f46e5 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }

        /* Section Title & Cards */
        .sidebar-section-title {
            color: var(--pacs-cyan);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .sidebar-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(56, 189, 248, 0.35), transparent);
        }

        .info-card-box {
            background-color: var(--pacs-bg);
            border: 1px solid var(--pacs-border);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 14px;
        }

        .info-row-item {
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px dashed rgba(148, 163, 184, 0.14);
        }

        .info-row-item:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-size: 0.66rem;
            font-weight: 700;
            color: var(--pacs-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
            display: block;
        }

        .info-value {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--pacs-text);
            word-break: break-word;
        }

        .info-value-highlight {
            color: var(--pacs-cyan);
            font-weight: 700;
        }

        /* Buttons & Inputs */
        .btn-pacs-back {
            background: rgba(255, 255, 255, 0.06);
            color: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 9px;
            padding: 5px 10px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.18s ease;
        }

        .btn-pacs-back:hover {
            background: rgba(56, 189, 248, 0.16);
            border-color: var(--pacs-cyan);
            color: #ffffff;
            transform: translateX(-1px);
        }

        .btn-cyan-toggle {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            border: 1px solid rgba(56, 189, 248, 0.4);
            border-radius: 9px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.18s ease;
        }

        .btn-cyan-toggle:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
        }

        .btn-cyan-outline {
            background-color: rgba(56, 189, 248, 0.08);
            color: var(--pacs-cyan);
            border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.18s ease;
        }

        .btn-cyan-outline:hover {
            background-color: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }

        .btn-pacs-save {
            background: linear-gradient(135deg, #4f46e5 0%, #0284c7 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.82rem;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transition: all 0.18s ease;
        }

        .btn-pacs-save:hover {
            transform: translateY(-1px);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.4);
        }

        .form-control-dark {
            background-color: var(--pacs-bg);
            border: 1px solid var(--pacs-border);
            border-radius: 10px;
            color: var(--pacs-text);
            font-size: 0.82rem;
            font-weight: 500;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .form-control-dark:focus {
            background-color: var(--pacs-bg);
            border-color: var(--pacs-cyan);
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.18);
        }

        /* Viewer Frame */
        .viewer-container {
            flex-grow: 1;
            height: 100%;
            background-color: #000000;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <nav class="navbar pacs-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button type="button"
                onclick="goBackPage()"
                class="btn btn-sm btn-pacs-back"
                title="Kembali ke Halaman Sebelumnya">
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <button id="toggleSidebarBtn"
                type="button"
                class="btn btn-sm btn-cyan-toggle px-2.5 py-1.5"
                onclick="toggleSidebar()"
                title="Buka/Tutup Sidebar Info">
                <i class="fa-solid fa-bars me-1" id="toggleIcon"></i>
                <span id="toggleText" class="d-none d-sm-inline">Info &amp; Bacaan</span>
            </button>

            <span class="navbar-brand mb-0 h1 fs-6 d-flex align-items-center ms-1">
                <span class="d-inline-flex align-items-center justify-content-center rounded-2 me-2"
                    style="width: 28px; height: 28px; background: rgba(56, 189, 248, 0.14); border: 1px solid rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-x-ray text-info" style="font-size: 0.85rem; color: #38bdf8 !important;"></i>
                </span>
                <span class="fw-bold text-white" style="letter-spacing: -0.01em;">Orthanc OHIF Viewer</span>
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="pacs-badge-pill mono-text d-none d-md-inline-flex">
                <i class="fa-solid fa-hashtag"></i>
                <span>UUID: {{ \Illuminate\Support\Str::limit($studyId, 14) }}</span>
            </span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-layout">

        <!-- Sidebar Detail Pasien & Bacaan Dokter -->
        <aside class="sidebar-info" id="sidebarInfo">
            <ul class="nav nav-pills nav-fill pacs-nav-pills mb-3" id="sidebarTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#tab-info" type="button" role="tab">
                        <i class="fa-solid fa-id-card me-1"></i> Info Pasien
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="expertise-tab" data-bs-toggle="pill" data-bs-target="#tab-expertise" type="button" role="tab">
                        <i class="fa-solid fa-stethoscope me-1"></i> Expertise
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="sidebarTabContent">
                <!-- TAB 1: INFORMASI PASIEN & STUDI -->
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <div class="sidebar-section-title">
                        <i class="fa-solid fa-user-injured"></i> Data Pasien
                    </div>

                    <div class="info-card-box">
                        <div class="info-row-item">
                            <span class="info-label">Nama Pasien</span>
                            <div class="info-value info-value-highlight">
                                {{ $studyDetail['PatientMainDicomTags']['PatientName'] ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="info-row-item">
                            <span class="info-label">ID Pasien / No. RM</span>
                            <div class="info-value mono-text">
                                {{ $studyDetail['PatientMainDicomTags']['PatientID'] ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="info-row-item">
                            <span class="info-label">Jenis Kelamin / Tgl Lahir</span>
                            <div class="info-value mono-text">
                                {{ $studyDetail['PatientMainDicomTags']['PatientSex'] ?? '-' }} /
                                {{ $studyDetail['PatientMainDicomTags']['PatientBirthDate'] ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-section-title mt-3">
                        <i class="fa-solid fa-file-medical"></i> Detail Pemeriksaan
                    </div>

                    <div class="info-card-box">
                        <div class="info-row-item">
                            <span class="info-label">Tanggal Pemeriksaan</span>
                            <div class="info-value">
                                @php $rawDate = $studyDetail['MainDicomTags']['StudyDate'] ?? ''; @endphp
                                @if(strlen($rawDate) === 8 && is_numeric($rawDate))
                                {{ \Carbon\Carbon::createFromFormat('Ymd', $rawDate)->format('d M Y') }}
                                @else
                                {{ $rawDate ?: 'N/A' }}
                                @endif
                            </div>
                        </div>

                        <div class="info-row-item">
                            <span class="info-label">Deskripsi Study</span>
                            <div class="info-value">
                                {{ $studyDetail['MainDicomTags']['StudyDescription'] ?? 'Tidak ada deskripsi' }}
                            </div>
                        </div>

                        <div class="info-row-item">
                            <span class="info-label">Accession Number</span>
                            <div class="info-value mono-text">
                                {{ $studyDetail['MainDicomTags']['AccessionNumber'] ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <a href="{{ $iframeUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-cyan-outline py-2">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1.5"></i> Buka Viewer di Tab Baru
                        </a>
                        <a href="{{ url('/pacs-proxy/studies/' . $studyId . '/archive') }}" class="btn btn-sm btn-outline-secondary text-light py-2 rounded-3 fw-semibold" style="border-color: var(--pacs-border); font-size: 0.8rem;">
                            <i class="fa-solid fa-download me-1.5"></i> Unduh DICOM (.ZIP)
                        </a>
                    </div>
                </div>

                <!-- TAB 2: FORM BACAAN / EXPERTISE DOKTER -->
                <div class="tab-pane fade" id="tab-expertise" role="tabpanel">
                    <div class="sidebar-section-title">
                        <i class="fa-solid fa-notes-medical"></i> Input Hasil Bacaan
                    </div>

                    <form id="formExpertise" class="info-card-box">
                        @csrf
                        <input type="hidden" name="study_instance_uid" value="{{ $uid }}">
                        <input type="hidden" name="orthanc_study_id" value="{{ $studyId }}">

                        <div class="mb-3">
                            <label class="info-label">Klinis / Indikasi</label>
                            <input type="text" name="klinis" class="form-control form-control-dark" placeholder="Indikasi klinis...">
                        </div>

                        <div class="mb-3">
                            <label class="info-label">Uraian Hasil Pemeriksaan</label>
                            <textarea name="hasil_bacaan" rows="8" class="form-control form-control-dark" placeholder="Tuliskan hasil bacaan radiologi..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="info-label">Kesan / Kesimpulan</label>
                            <textarea name="kesan" rows="3" class="form-control form-control-dark" placeholder="Kesimpulan..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-sm btn-pacs-save py-2">
                                <i class="fa-solid fa-floppy-disk me-1.5"></i> Simpan Expertise
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Frame DICOM Viewer -->
        <main class="viewer-container">
            <iframe src="{{ $iframeUrl }}" allowfullscreen></iframe>
        </main>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript Navigation & Toggle Sidebar -->
    <script>
        function goBackPage() {
            if (window.history.length > 1) {
                window.history.back();
            } else if (document.referrer) {
                window.location.href = document.referrer;
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarInfo');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleBtn = document.getElementById('toggleSidebarBtn');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.className = 'fa-solid fa-bars-staggered me-1';
                toggleBtn.className = 'btn btn-sm btn-cyan-outline px-2.5 py-1.5';
            } else {
                toggleIcon.className = 'fa-solid fa-bars me-1';
                toggleBtn.className = 'btn btn-sm btn-cyan-toggle px-2.5 py-1.5';
            }
        }
    </script>

</body>

</html>
