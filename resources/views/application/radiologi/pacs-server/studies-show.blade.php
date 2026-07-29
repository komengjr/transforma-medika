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
        body,
        html {
            height: 100%;
            margin: 0;
            background-color: #1a1a1a;
            color: #ffffff;
            overflow: hidden;
        }

        .main-layout {
            display: flex;
            height: calc(100vh - 56px);
            width: 100vw;
            position: relative;
        }

        /* Styling Sidebar dengan Transisi Halus */
        .sidebar-info {
            width: 320px;
            min-width: 320px;
            background-color: #242424;
            border-right: 1px solid #333;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
            margin-left: 0;
        }

        /* Class ketika sidebar disembunyikan */
        .sidebar-info.collapsed {
            margin-left: -320px;
            padding-left: 0;
            padding-right: 0;
            opacity: 0;
            visibility: hidden;
        }

        .viewer-container {
            flex-grow: 1;
            height: 100%;
            background-color: #000;
            transition: all 0.3s ease-in-out;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .info-group {
            margin-bottom: 15px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        .info-label {
            font-size: 0.75rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary px-3">
        <div class="d-flex align-items-center">

            <!-- Tombol Toggle Buka/Tutup Sidebar -->
            <button id="toggleSidebarBtn" class="btn btn-sm btn-primary me-3" onclick="toggleSidebar()" title="Buka/Tutup Sidebar Info">
                <i class="fa-solid fa-bars me-1" id="toggleIcon"></i>
                <span id="toggleText"></span>
            </button>

            <span class="navbar-brand mb-0 h1 fs-6">
                <i class="fa-solid fa-x-ray me-2 text-primary"></i>Orthanc Medical Viewer
            </span>
        </div>
        <div>
            <span class="badge bg-primary">Study UUID: {{ Str::limit($studyId, 12) }}</span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-layout">

        <!-- Sidebar Detail Pasien -->
        <div class="sidebar-info" id="sidebarInfo">
            <h6 class="text-primary mb-3"><i class="fa-solid fa-id-card me-2"></i>Informasi Pasien</h6>

            <div class="info-group">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value text-warning">
                    {{ $studyDetail['PatientMainDicomTags']['PatientName'] ?? 'N/A' }}
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">ID Pasien / RM</div>
                <div class="info-value">
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

            <h6 class="text-primary mt-4 mb-3"><i class="fa-solid fa-file-medical me-2"></i>Detail Pemeriksaan</h6>

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
                <div class="info-value">
                    {{ $studyDetail['MainDicomTags']['AccessionNumber'] ?? '-' }}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ $ohifUrl ?? $viewerUrl }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Viewer Tab Baru
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
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleBtn = document.getElementById('toggleSidebarBtn');

            // Toggle Class Collapsed
            sidebar.classList.toggle('collapsed');

            // Ubah Teks dan Ikon Tombol
            if (sidebar.classList.contains('collapsed')) {
                // toggleText.textContent = 'Tampilkan Info';
                toggleIcon.className = 'fa-solid fa-bars-staggered me-1';
                toggleBtn.className = 'btn btn-sm btn-outline-primary me-3';
            } else {
                // toggleText.textContent = 'Sembunyikan Info';
                toggleIcon.className = 'fa-solid fa-bars me-1';
                toggleBtn.className = 'btn btn-sm btn-primary me-3';
            }
        }
    </script>

</body>

</html>
