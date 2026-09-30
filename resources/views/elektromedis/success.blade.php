<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran Elektromedis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">
                        <div class="mb-4 text-success">
                            <i class="fas fa-check-circle fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-2">Pendaftaran Berhasil!</h3>
                        <p class="text-muted">Pasien telah terdaftar dalam antrean instalasi elektromedis.</p>

                        <div class="bg-light border rounded p-3 my-4 text-start">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-secondary" width="40%">No. Registrasi</td>
                                    <td>: <span class="fw-bold text-primary">{{ $registration->registration_number }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">No. Rekam Medis</td>
                                    <td>: {{ $registration->medical_record_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Nama Pasien</td>
                                    <td>: {{ $registration->patient_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Pemeriksaan</td>
                                    <td>: <span class="badge bg-info text-dark">{{ $registration->examination_type }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Prioritas</td>
                                    <td>: <span class="badge {{ $registration->priority == 'Cito / Darurat' ? 'bg-danger' : 'bg-secondary' }}">{{ $registration->priority }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Jadwal Tindakan</td>
                                    <td>: {{ date('d-m-Y H:i', strtotime($registration->scheduled_at)) }} WIB</td>
                                </tr>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('elektromedis.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Input Pendaftaran Lain
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="fas fa-print me-1"></i> Cetak Bukti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
