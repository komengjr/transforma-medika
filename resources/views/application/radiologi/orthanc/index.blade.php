<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan DICOM - Orthanc</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0 text-primary">
                    <i class="fa-solid fa-hospital-user me-2"></i>Daftar Pemeriksaan DICOM
                </h2>
                <p class="text-muted">Data terintegrasi dari Server Orthanc PACS</p>
            </div>
            <a href="{{ url()->current() }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-rotate-right me-1"></i> Refresh Data
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="ps-4">No</th>
                                <th scope="col">ID Pasien</th>
                                <th scope="col">Nama Pasien</th>
                                <th scope="col">Tanggal Pemeriksaan</th>
                                <th scope="col">Orthanc Study ID</th>
                                <th scope="col" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studiesList as $index => $study)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $study['patient_id'] }}
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    {{ $study['patient_name'] }}
                                </td>
                                <td>
                                    <i class="fa-regular fa-calendar-days text-muted me-1"></i>
                                    @if($study['study_date'] !== 'N/A' && strlen($study['study_date']) === 8)
                                    {{ \Carbon\Carbon::createFromFormat('Ymd', $study['study_date'])->format('d M Y') }}
                                    @else
                                    {{ $study['study_date'] }}
                                    @endif
                                </td>
                                <td>
                                    <code class="text-muted small">{{ $study['orthanc_study_id'] }}</code>
                                </td>
                                <td class="text-center pe-4">
                                    <!-- Tombol untuk membuka viewer di tab baru -->
                                    <a href="{{ route('orthanc.viewer', $study['orthanc_study_id']) }}"
                                        class="btn btn-sm btn-primary px-3 rounded-pill"
                                        target="_blank"
                                        title="Buka Preview DICOM">
                                        <i class="fa-solid fa-eye me-1"></i> Preview
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary"></i>
                                        <h5>Tidak ada data pemeriksaan ditemukan</h5>
                                        <p class="small mb-0">Pastikan server Orthanc aktif atau gambar DICOM sudah dikirim dari konsol Fujifilm.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
