<div class="container-fluid px-0">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Informasi Pasien -->
    <div class="card shadow-sm border-0 mb-3 bg-light">
        <div class="card-body py-3">
            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-user-injured me-1"></i> Identitas Pasien</h6>
            <div class="row">
                <div class="col-md-3 mb-1">
                    <span class="text-muted d-block small">No. Registrasi</span>
                    <strong>{{ $registration->registration_number }}</strong>
                </div>
                <div class="col-md-3 mb-1">
                    <span class="text-muted d-block small">No. Rekam Medis (RM)</span>
                    <strong>{{ $registration->medical_record_number }}</strong>
                </div>
                <div class="col-md-3 mb-1">
                    <span class="text-muted d-block small">Nama Pasien</span>
                    <strong>{{ $registration->patient_name }}</strong>
                </div>
                <div class="col-md-3 mb-1">
                    <span class="text-muted d-block small">Unit Asal / Pengirim</span>
                    <strong>{{ $registration->origin_unit }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Utama & Panel Grafik DICOM Orthanc -->
    <form action="{{ route('elektromedis.store_ecg', $registration->id) }}" method="POST" id="formEcgModal">
        @csrf
        <div class="row">
            <!-- KOLOM KIRI: Parameter & Form Interpretasi (Lebar 7) -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0"><i class="fas fa-file-medical-alt me-1"></i> Parameter & Hasil Interpretasi ECG</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Heart Rate -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Heart Rate (Denyut Jantung)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="heart_rate" class="form-control form-control-sm" placeholder="Contoh: 80" value="{{ $ecgResult->heart_rate ?? '' }}" required>
                                    <span class="input-group-text">bpm</span>
                                </div>
                            </div>

                            <!-- Irama / Rhythm -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Irama (Rhythm)</label>
                                <select name="rhythm" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Irama --</option>
                                    <option value="Sinus Rhythm" {{ (isset($ecgResult) && $ecgResult->rhythm == 'Sinus Rhythm') ? 'selected' : '' }}>Sinus Rhythm (Normal)</option>
                                    <option value="Sinus Tachycardia" {{ (isset($ecgResult) && $ecgResult->rhythm == 'Sinus Tachycardia') ? 'selected' : '' }}>Sinus Tachycardia</option>
                                    <option value="Sinus Bradycardia" {{ (isset($ecgResult) && $ecgResult->rhythm == 'Sinus Bradycardia') ? 'selected' : '' }}>Sinus Bradycardia</option>
                                    <option value="Atrial Fibrillation (AF)" {{ (isset($ecgResult) && $ecgResult->rhythm == 'Atrial Fibrillation (AF)') ? 'selected' : '' }}>Atrial Fibrillation (AF)</option>
                                    <option value="Arrhythmia Lainnya" {{ (isset($ecgResult) && $ecgResult->rhythm == 'Arrhythmia Lainnya') ? 'selected' : '' }}>Lainnya / Aritmia</option>
                                </select>
                            </div>

                            <!-- Aksis / Axis -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Aksis Jantung (Axis)</label>
                                <select name="axis" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Aksis --</option>
                                    <option value="Normal Axis" {{ (isset($ecgResult) && $ecgResult->axis == 'Normal Axis') ? 'selected' : '' }}>Normal Axis</option>
                                    <option value="Left Axis Deviation (LAD)" {{ (isset($ecgResult) && $ecgResult->axis == 'Left Axis Deviation (LAD)') ? 'selected' : '' }}>Left Axis Deviation (LAD)</option>
                                    <option value="Right Axis Deviation (RAD)" {{ (isset($ecgResult) && $ecgResult->axis == 'Right Axis Deviation (RAD)') ? 'selected' : '' }}>Right Axis Deviation (RAD)</option>
                                    <option value="Extreme Axis" {{ (isset($ecgResult) && $ecgResult->axis == 'Extreme Axis') ? 'selected' : '' }}>Extreme Axis</option>
                                </select>
                            </div>

                            <!-- Interval PR -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Interval PR</label>
                                <input type="text" name="pr_interval" class="form-control form-control-sm" placeholder="Contoh: 0.16 detik" value="{{ $ecgResult->pr_interval ?? '' }}">
                            </div>

                            <!-- Kompleks QRS -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Kompleks QRS</label>
                                <input type="text" name="qrs_complex" class="form-control form-control-sm" placeholder="Contoh: 0.08 detik" value="{{ $ecgResult->qrs_complex ?? '' }}">
                            </div>

                            <!-- Segmen ST -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Segmen ST</label>
                                <select name="st_segment" class="form-select form-select-sm">
                                    <option value="Isoelectric (Normal)" {{ (isset($ecgResult) && $ecgResult->st_segment == 'Isoelectric (Normal)') ? 'selected' : '' }}>Isoelectric (Normal)</option>
                                    <option value="ST Elevation" {{ (isset($ecgResult) && $ecgResult->st_segment == 'ST Elevation') ? 'selected' : '' }}>ST Elevation (STEMI)</option>
                                    <option value="ST Depression" {{ (isset($ecgResult) && $ecgResult->st_segment == 'ST Depression') ? 'selected' : '' }}>ST Depression (Iskemia)</option>
                                </select>
                            </div>

                            <!-- Gelombang T -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Gelombang T (T Wave)</label>
                                <select name="t_wave" class="form-select form-select-sm">
                                    <option value="Normal (Positif)" {{ (isset($ecgResult) && $ecgResult->t_wave == 'Normal (Positif)') ? 'selected' : '' }}>Normal (Positif)</option>
                                    <option value="T Inversion" {{ (isset($ecgResult) && $ecgResult->t_wave == 'T Inversion') ? 'selected' : '' }}>T Inversion</option>
                                    <option value="Tall T Wave" {{ (isset($ecgResult) && $ecgResult->t_wave == 'Tall T Wave') ? 'selected' : '' }}>Tall T Wave</option>
                                </select>
                            </div>

                            <!-- Kesimpulan / Interpretasi Klinis -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Kesimpulan / Interpretasi <span class="text-danger">*</span></label>
                                <input type="text" name="clinical_impression" class="form-control form-control-sm" placeholder="Contoh: Normal ECG / STEMI Inferior" value="{{ $ecgResult->clinical_impression ?? '' }}" required>
                            </div>

                            <!-- Catatan Dokter / Keterangan Tambahan -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label fw-bold small">Catatan / Keterangan Pemeriksa</label>
                                <textarea name="doctor_notes" class="form-control form-control-sm" rows="2" placeholder="Masukkan catatan tambahan...">{{ $ecgResult->doctor_notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Grafik / Viewer ECG DICOM dari Orthanc (Lebar 5) -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-3 h-100">
                    <div class="card-header bg-dark text-white py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-heart-pulse me-1"></i> Grafik ECG (Orthanc PACS)</h6>
                        @if(isset($dicomData) && isset($dicomData->study_instance_uid))
                        <a href="http://lokal-orthanc-anda/app/explorer.html?uuid={{ $dicomData->study_instance_uid }}" target="_blank" class="btn btn-xs btn-light text-dark" style="font-size: 11px; padding: 2px 6px;">
                            <i class="fas fa-external-link-alt"></i> Buka Orthanc
                        </a>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center bg-secondary bg-opacity-10 p-2" style="min-height: 380px;">
                        @if(isset($dicomData) && !empty($dicomData->preview_url))
                        <!-- Jika menggunakan gambar/preview dari server Orthanc -->
                        <img src="{{ $dicomData->preview_url }}" alt="Grafik ECG DICOM" class="img-fluid rounded border shadow-sm bg-white" style="max-height: 400px; width: 100%; object-fit: contain;">
                        @elseif(isset($dicomData) && !empty($dicomData->study_instance_uid))
                        <!-- Jika menggunakan embedded OHIF / Cornerstone Web Viewer -->
                        <iframe src="http://lokal-orthanc-anda/ohif/viewer?StudyInstanceUIDs={{ $dicomData->study_instance_uid }}" class="w-100 rounded border" style="height: 400px;" frameborder="0"></iframe>
                        @else
                        <!-- Placeholder jika data DICOM belum tersedia -->
                        <div class="text-center text-muted p-4">
                            <i class="fas fa-file-waveform fa-3x mb-3 text-secondary opacity-50"></i>
                            <p class="small mb-1 fw-bold">Belum ada data grafik ECG dari Orthanc</p>
                            <span class="text-muted" style="font-size: 11px;">Pastikan file DICOM dari alat rekam jantung sudah tersinkronisasi ke tabel <code>medical_dicom_ecg</code>.</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi di Bawah -->
        <div class="card shadow-sm border-0">
            <div class="card-body bg-white py-2 text-end">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success btn-sm px-4">
                    <i class="fas fa-save me-1"></i> Simpan Hasil & Kirim
                </button>
            </div>
        </div>
    </form>
</div>
