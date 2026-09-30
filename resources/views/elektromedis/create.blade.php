<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Elektromedis - SIMRS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-heartbeat me-2"></i> Form Pendaftaran Pemeriksaan Elektromedis</h4>
                        <small>Instalasi Elektromedis / Penunjang Diagnostik Rumah Sakit</small>
                    </div>
                    <div class="card-body p-4">

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali form di bawah.
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('elektromedis.store') }}" method="POST" id="formElektromedis">
                            @csrf

                            <h5 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-user-injured me-1"></i> 1. Informasi Pasien</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Rekam Medis (RM) <span class="text-danger">*</span></label>
                                    <input type="text" name="medical_record_number" class="form-control" placeholder="Contoh: 00-12-34-56" required value="{{ old('medical_record_number') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" class="form-control" placeholder="Sesuai KTP / Kartu Berobat" required value="{{ old('patient_name') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="birth_date" class="form-control" required value="{{ old('birth_date') }}">
                                </div>
                            </div>

                            <h5 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-stethoscope me-1"></i> 2. Rujukan & Detail Klinis</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Poli / Unit Asal Pengirim <span class="text-danger">*</span></label>
                                    <select name="origin_unit" class="form-select" required>
                                        <option value="">-- Pilih Unit Asal --</option>
                                        @foreach($units as $unit)
                                        <option value="{{ $unit }}" {{ old('origin_unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Dokter Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" name="doctor_sender" class="form-control" placeholder="Nama Dokter + Gelar" required value="{{ old('doctor_sender') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Pemeriksaan Elektromedis <span class="text-danger">*</span></label>
                                    <select name="examination_type" class="form-select" required>
                                        <option value="">-- Pilih Jenis Pemeriksaan --</option>
                                        @foreach($examinationTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('examination_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prioritas Pelayanan <span class="text-danger">*</span></label>
                                    <select name="priority" class="form-select" required>
                                        <option value="Normal">Normal</option>
                                        <option value="Cito / Darurat">Cito / Darurat (Emergency)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jadwal Tindakan / Jam Rencana <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="scheduled_at" class="form-control" required value="{{ old('scheduled_at') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Catatan Klinis / Indikasi</label>
                                    <textarea name="clinical_notes" class="form-control" rows="2" placeholder="Keterangan singkat klinis pasien...">{{ old('clinical_notes') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-secondary px-4"><i class="fas fa-undo me-1"></i> Reset</button>
                                <button type="submit" class="btn btn-primary px-5"><i class="fas fa-save me-1"></i> Daftarkan Pasien</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Contoh konfirmasi sederhana sebelum submit form (opsional)
        document.getElementById('formElektromedis').addEventListener('submit', function(e) {
            // Bisa ditambahkan konfirmasi interaktif SweetAlert jika diinginkan
        });
    </script>
</body>

</html>
