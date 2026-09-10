<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #047857 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
    }

    .card-frame {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        /* background: #ffffff; */
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card-frame-header {
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .btn-kategori-card {
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        /* background: #ffffff; */
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .btn-kategori-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
    }

    .btn-layanan-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.2s ease;

    }

    .btn-layanan-card:hover,
    .btn-layanan-card.active {
        border-color: #0284c7;
        background: #165f90;
        color: #fff;
    }

    .icon-wrapper {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .form-control-custom,
    .form-select-custom {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 0.85rem;
    }

    .camera-box {
        width: 100%;
        max-width: 240px;
        height: 180px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        overflow: hidden;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .camera-box video,
    .camera-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="p-3 bg-slate-100 min-vh-100 fs--1">
    <!-- Top Header Status -->
    <div class="alert bg-white border-0 shadow-sm rounded-3 d-flex align-items-center justify-content-between mb-3 p-3 border-start border-4 border-primary">
        <div class="d-flex align-items-center">
            <div class="badge bg-primary bg-opacity-10 text-white rounded-circle p-3 m-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="fas fa-notes-medical fs-2"></i>
            </div>
            <div>
                <span class="badge bg-primary text-uppercase px-2 py-1 fs--2 mb-1">Status Antrian Active</span>
                <h6 class="mb-0 text-dark fw-bold">Memproses Registrasi & Layanan Pasien</h6>
            </div>
        </div>
        <div class="text-end">
            <span class="text-muted fs--2 d-block text-uppercase fw-semibold">Nomor Antrian</span>
            <span class="badge bg-primary fs-6 px-3 py-1 rounded-pill shadow-sm"><i class="fas fa-hashtag me-1"></i>{{ $nomorAntrian }}</span>
        </div>
    </div>

    <!-- TAHAP 1: Pilih Jenis Penjamin -->
    <div id="stepKategori" class="card-frame mb-3">
        <div class="card-frame-header bg-light d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0 text-dark fs--1">Langkah 1: Pilih Jenis Penjamin / Pasien</h6>
            <span class="badge bg-light text-secondary border fs--2">Step 1 of 3</span>
        </div>
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-3 shadow-sm h-100" onclick="selectKategori('Pasien Umum')">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-primary bg-opacity-10 text-white me-3"><i class="fas fa-wallet"></i></div>
                            <div>
                                <div class="fw-bold fs--1 text-dark">Pasien Umum</div>
                                <div class="fs--2 text-muted">Mandiri / Tunai</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-3 shadow-sm h-100" onclick="selectKategori('Pasien BPJS')">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-success bg-opacity-10 text-white me-3"><i class="fas fa-file-medical"></i></div>
                            <div>
                                <div class="fw-bold fs--1 text-dark">Pasien BPJS</div>
                                <div class="fs--2 text-muted">Direct VClaim</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-3 shadow-sm h-100" onclick="selectKategori('Pasien Perusahaan')">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-warning bg-opacity-10 text-white me-3"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="fw-bold fs--1 text-dark">Perusahaan</div>
                                <div class="fs--2 text-muted">Instansi Partner</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-3 shadow-sm h-100" onclick="selectKategori('Pasien Asuransi Swasta')">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-info bg-opacity-10 text-white me-3"><i class="fas fa-id-card-alt"></i></div>
                            <div>
                                <div class="fw-bold fs--1 text-dark">Asuransi Swasta</div>
                                <div class="fs--2 text-muted">Jaminan Non-BPJS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAHAP 2: Cari / Registrasi Pasien -->
    <div id="stepPasien" class="d-none">
        <div class="d-flex justify-content-between align-items-center mb-3 p-2 px-3 bg-white rounded-3 border shadow-sm">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success rounded-circle p-1"><i class="fas fa-check text-white fs--2"></i></span>
                <span class="fw-bold text-secondary fs--1">Penjamin:</span>
                <span id="labelSelectedKategori" class="badge bg-primary fs--1 px-3 py-1 rounded-pill"></span>
                <span id="labelSelectedPerusahaan" class="badge bg-warning text-dark fs--1 px-3 py-1 rounded-pill d-none">
                    <i class="fas fa-building me-1"></i> <span id="namaPerusahaanText"></span>
                </span>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill fs--2 px-3" onclick="resetKategori()">
                <i class="fas fa-undo me-1"></i> Ganti Penjamin
            </button>
        </div>

        <!-- Filter Perusahaan -->
        <div id="containerPilihPerusahaan" class="card-frame border-warning border-opacity-50 mb-3 d-none">
            <div class="card-frame-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark fs--1"><i class="fas fa-building me-2 text-warning"></i>Pilih Nama Perusahaan</h6>
                <span class="badge bg-warning text-dark fs--2">Step 2a</span>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-9">
                        <select class="form-select form-select-custom" id="selectPerusahaan" onchange="onPerusahaanChange()">
                            <option value="">-- Pilih Nama Perusahaan / Instansi --</option>
                            <option value="PT Pertamina Persero">PT Pertamina Persero</option>
                            <option value="PT Telkom Indonesia">PT Telkom Indonesia</option>
                            <option value="PT Bank Rakyat Indonesia">PT Bank Rakyat Indonesia</option>
                            <option value="PT PLN (Persero)">PT PLN (Persero)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-warning w-100 fs--1 fw-bold text-dark" onclick="cariPesertaPerusahaan()">
                            <i class="fas fa-users me-1"></i> Cari Peserta
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab">
            <li class="nav-item">
                <button class="nav-link active fs--1 py-2" id="tab-cari-pasien" data-bs-toggle="pill" data-bs-target="#content-cari">
                    <i class="fas fa-search me-2"></i>Cari Data Pasien Existing
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fs--1 py-2" id="tab-buat-pasien" data-bs-toggle="pill" data-bs-target="#content-buat" onclick="initCamera()">
                    <i class="fas fa-user-plus me-2"></i>Registrasi Pasien Baru
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- CARI PASIEN -->
            <div class="tab-pane fade show active" id="content-cari">
                <div class="card-frame border-primary border-opacity-25">
                    <div class="card-body p-3">
                        <div class="row g-2 mb-3">
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-custom" id="keywordPasien" placeholder="Ketik NIK, Nomor BPJS, atau Kode RM..." onkeypress="if(event.key === 'Enter') cariPasien()">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary w-100 fs--1 fw-bold" onclick="cariPasien()">
                                    <i class="fas fa-search me-1"></i> Cari Data
                                </button>
                            </div>
                        </div>
                        <div id="resultCariPasien" class="border rounded-3 p-4 bg-light text-center fs--1 text-muted">
                            Silakan lakukan pencarian data pasien.
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTRASI PASIEN BARU -->
            <div class="tab-pane fade" id="content-buat">
                <div class="card-frame border-success border-opacity-25">
                    <div class="card-body p-3">
                        <form id="formCreatePasien" onsubmit="submitPasienBaru(event)">
                            @csrf
                            <input type="hidden" name="jenis_penjamin" id="inputJenisPenjamin">
                            <input type="hidden" name="nama_perusahaan" id="inputNamaPerusahaan">
                            <input type="hidden" name="foto_pasien_base64" id="fotoPasienBase64">

                            <div class="row mb-3 pb-3 border-bottom align-items-center g-3">
                                <div class="col-md-4 d-flex flex-column align-items-center">
                                    <div class="camera-box mb-2">
                                        <video id="webcam" autoplay playsinline></video>
                                        <img id="previewFoto" class="d-none">
                                        <canvas id="canvas" class="d-none"></canvas>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-primary fs--2 fw-bold" onclick="takeSnapshot()">Ambil Foto</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary fs--2 d-none" id="btnRetake" onclick="resetCamera()">Foto Ulang</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select fs--1 mb-2" id="selectCamera" onchange="switchCamera(this.value)"></select>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">NIK *</label>
                                    <input type="text" class="form-control form-control-custom" id="inputNik" name="master_patient_nik" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">Nama Lengkap *</label>
                                    <input type="text" class="form-control form-control-custom" id="inputNama" name="master_patient_name" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">Jenis Kelamin *</label>
                                    <select class="form-select form-select-custom" id="inputJk" name="master_patient_jk" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">Tanggal Lahir *</label>
                                    <input type="date" class="form-control form-control-custom" id="inputTglLahir" name="master_patient_tgl_lahir" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">No HP / WA</label>
                                    <input type="text" class="form-control form-control-custom" id="inputNoHp" name="master_patient_no_hp">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2">Alamat</label>
                                    <input type="text" class="form-control form-control-custom" id="inputAlamat" name="master_patient_alamat">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-sm btn-success fs--1 px-4 fw-bold">
                                    <i class="fas fa-arrow-right me-1"></i> Lanjut ke Layanan Medis
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAHAP 3: PEMILIHAN TUJUAN LAYANAN & EXAM DATA -->
    <!-- TAHAP 3: PEMILIHAN TUJUAN LAYANAN & EXAM DATA -->
    <div id="stepLayanan" class="d-none">

        <!-- Info Pasien Selected Banner -->
        <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fs-2 me-3"></i>
                <div>
                    <span class="badge bg-info text-uppercase fs--2">Pasien Terpilih</span>
                    <h6 class="mb-0 fw-bold text-dark" id="dispNamaPasien">-</h6>
                    <span class="fs--2 text-muted" id="dispInfoPasien">-</span>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-secondary rounded-pill fs--2" onclick="kembaliKePilihPasien()">
                <i class="fas fa-user-edit me-1"></i> Ganti Pasien
            </button>
        </div>

        <div class="card-frame">
            <div class="card-frame-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark fs--1"><i class="fas fa-stethoscope me-2 text-primary"></i>Langkah 3: Pilih Tujuan Layanan & Input Pemeriksaan</h6>
                <span class="badge bg-primary fs--2">Step 3 of 3</span>
            </div>
            <div class="card-body p-3">
                <form id="formFinalLayanan" onsubmit="submitFinalLayanan(event)">
                    @csrf
                    <input type="hidden" name="id_master_patient" id="finalIdPatient">
                    <input type="hidden" name="jenis_penjamin" id="finalJenisPenjamin">
                    <input type="hidden" name="nama_perusahaan" id="finalNamaPerusahaan">
                    <input type="hidden" name="nomor_antrian" value="{{ $nomorAntrian }}">
                    <input type="hidden" name="tujuan_layanan" id="inputTujuanLayanan" value="POLIKLINIK">

                    <!-- Pilihan Opsi Layanan (Grid 4 Kolom) -->
                    <div class="row g-2 mb-4">
                        <div class="col-md-3">
                            <div class="btn-layanan-card active" id="btnOptPoli" onclick="selectTujuanLayanan('POLIKLINIK')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary bg-opacity-10 text-white me-2"><i class="fas fa-clinic-medical"></i></div>
                                    <div>
                                        <div class="fw-bold fs--1">Poliklinik</div>
                                        <div class="fs--2 text-muted">Rawat Jalan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-layanan-card" id="btnOptIgd" onclick="selectTujuanLayanan('IGD')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-danger bg-opacity-10 text-white me-2"><i class="fas fa-ambulance"></i></div>
                                    <div>
                                        <div class="fw-bold fs--1">IGD</div>
                                        <div class="fs--2 text-muted">Gawat Darurat</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-layanan-card" id="btnOptPenunjang" onclick="selectTujuanLayanan('PENUNJANG')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-warning bg-opacity-10 text-white me-2"><i class="fas fa-x-ray"></i></div>
                                    <div>
                                        <div class="fw-bold fs--1">Penunjang Medis</div>
                                        <div class="fs--2 text-muted">Rad / Lab / Elektromedis</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-layanan-card" id="btnOptExam" onclick="selectTujuanLayanan('PEMERIKSAAN')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success bg-opacity-10 text-white me-2"><i class="fas fa-heartbeat"></i></div>
                                    <div>
                                        <div class="fw-bold fs--1">Tanda Vital</div>
                                        <div class="fs--2 text-muted">Direct Assessment</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM POLIKLINIK DENGAN TABEL DINAMIS -->
                    <div id="sectionPoli" class="p-3 bg-light rounded-3 border mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold fs--1 text-primary mb-0"><i class="fas fa-hospital-user me-2"></i>Jadwal Poliklinik Hari Ini</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary fs--2 rounded-pill" onclick="loadPoliSchedules()">
                                <i class="fas fa-sync-alt me-1"></i> Refresh Jadwal
                            </button>
                        </div>

                        <!-- Hidden Input untuk Pendaftaran -->
                        <input type="hidden" name="poli_code" id="selectedPoliCode">
                        <input type="hidden" name="doctor_code" id="selectedDoctorCode">
                        <input type="hidden" name="id_schedule" id="selectedScheduleId">

                        <div class="table-responsive bg-white rounded-3 border">
                            <table class="table table-hover align-middle mb-0 fs--1">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">Pilih</th>
                                        <th>Poliklinik</th>
                                        <th>Dokter DPJP</th>
                                        <th>Hari & Jam Praktik</th>
                                        <th class="text-center">Kuota</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPoliSchedules">
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data poliklinik...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- FORM IGD -->
                    <div id="sectionIgd" class="p-3 bg-light rounded-3 border mb-3 d-none">
                        <h6 class="fw-bold fs--1 text-danger mb-3"><i class="fas fa-briefcase-medical me-2"></i>Pendaftaran Unit Gawat Darurat (IGD)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold fs--2">Kategori Triase *</label>
                                <select class="form-select form-select-custom" name="triase_level">
                                    <option value="MERAH">Merah (Resusitasi / Kritis)</option>
                                    <option value="KUNING">Kuning (Emergency / Urgent)</option>
                                    <option value="HIJAU">Hijau (Non-Urgent)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold fs--2">Dokter Jaga IGD *</label>
                                <select class="form-select form-select-custom" name="dokter_igd_id">
                                    <option value="DOC_IGD_1">dr. Denny Pratama (Dokter Jaga)</option>
                                    <option value="DOC_IGD_2">dr. Maya Indah (Dokter Jaga)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold fs--2">Nama Pengantar / Penanggung Jawab</label>
                                <input type="text" class="form-control form-control-custom" name="pengantar_nama" placeholder="Keluarga / Kerabat">
                            </div>
                        </div>
                    </div>

                    <!-- FORM PENUNJANG MEDIS (RADIOLOGI, LAB, ELEKTROMEDIS) -->
                    <div id="sectionPenunjang" class="p-3 bg-light rounded-3 border mb-3 d-none">
                        <h6 class="fw-bold fs--1 text-warning mb-3"><i class="fas fa-microscope me-2"></i>Order Pemeriksaan Penunjang Medis</h6>
                        <div class="row g-3">
                            <div class="col-md-4 border-end">
                                <label class="form-label fw-bold fs--2 text-primary"><i class="fas fa-vial me-1"></i> Laboratorium</label>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_lab[]" value="Darah Lengkap" id="lab1">
                                    <label class="form-check-label" for="lab1">Darah Rutin / Lengkap</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_lab[]" value="Gula Darah Sewaktu" id="lab2">
                                    <label class="form-check-label" for="lab2">Gula Darah Sewaktu (GDS)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_lab[]" value="Fungsi Ginjal (Ureum/Kreatinin)" id="lab3">
                                    <label class="form-check-label" for="lab3">Fungsi Ginjal (Ureum/Kreatinin)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_lab[]" value="Fungsi Hati (SGOT/SGPT)" id="lab4">
                                    <label class="form-check-label" for="lab4">Fungsi Hati (SGOT/SGPT)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_lab[]" value="Urine Lengkap" id="lab5">
                                    <label class="form-check-label" for="lab5">Urine Lengkap</label>
                                </div>
                            </div>

                            <div class="col-md-4 border-end">
                                <label class="form-label fw-bold fs--2 text-danger"><i class="fas fa-x-ray me-1"></i> Radiologi & Imaging</label>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_radiologi[]" value="Rontgen Thorax PA" id="rad1">
                                    <label class="form-check-label" for="rad1">Thorax PA (Dada)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_radiologi[]" value="Rontgen Ekstremitas" id="rad2">
                                    <label class="form-check-label" for="rad2">Foto Tulang / Ekstremitas</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_radiologi[]" value="USG Abdomen" id="rad3">
                                    <label class="form-check-label" for="rad3">USG Abdomen (Kandungan/Perut)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_radiologi[]" value="CT-Scan" id="rad4">
                                    <label class="form-check-label" for="rad4">CT-Scan Head / Abdomen</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold fs--2 text-success"><i class="fas fa-heartbeat me-1"></i> Elektromedis & Diagnostic</label>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_elektromedis[]" value="EKG (Jantung)" id="em1">
                                    <label class="form-check-label" for="em1">EKG (Rekam Jantung)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_elektromedis[]" value="Echocardiography" id="em2">
                                    <label class="form-check-label" for="em2">Echocardiography</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_elektromedis[]" value="Spirometri" id="em3">
                                    <label class="form-check-label" for="em3">Spirometri (Paru)</label>
                                </div>
                                <div class="form-check fs--2">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_elektromedis[]" value="EEG (Gelombang Otak)" id="em4">
                                    <label class="form-check-label" for="em4">EEG (Gelombang Otak)</label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold fs--2">Dokter Perujuk / Pengirim *</label>
                                <select class="form-select form-select-custom mb-2" name="dokter_perujuk_id">
                                    <option value="">-- Pilih Dokter Perujuk --</option>
                                    <option value="DOC_1">dr. Ahmad Dahlan, Sp.PD</option>
                                    <option value="DOC_3">dr. Budi Santoso (Umum)</option>
                                    <option value="EXTERNAL">Pengirim Rujukan Luar</option>
                                </select>
                                <label class="form-label fw-bold fs--2">Catatan Klinis / Indikasi Pemeriksaan</label>
                                <textarea class="form-control form-control-custom" name="indikasi_penunjang" rows="2" placeholder="Catatan/diagnosa sementara dari dokter..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- FORM DATA PEMERIKSAAN / TANDA VITAL -->
                    <div id="sectionAssessment" class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold fs--1 text-success mb-3"><i class="fas fa-stethoscope me-2"></i>Pengisian Data Tanda-Tanda Vital</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold fs--2">Tekanan Darah (mmHg)</label>
                                <input type="text" class="form-control form-control-custom" name="td" placeholder="120/80">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold fs--2">Suhu Tubuh (°C)</label>
                                <input type="number" step="0.1" class="form-control form-control-custom" name="suhu" placeholder="36.5">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold fs--2">Nadi (x/menit)</label>
                                <input type="number" class="form-control form-control-custom" name="nadi" placeholder="80">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold fs--2">Respirasi (x/menit)</label>
                                <input type="number" class="form-control form-control-custom" name="respirasi" placeholder="20">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold fs--2">Keluhan Utama Pasien</label>
                                <textarea class="form-control form-control-custom" name="keluhan_utama" rows="2" placeholder="Tuliskan keluhan atau alasan kedatangan pasien..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Selesaikan Registrasi & Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadPoliSchedules();
    });
    let selectedKategori = '';
    let selectedPerusahaan = '';
    let selectedPatientData = null;
    let currentStream = null;

    function selectKategori(kategori) {
        selectedKategori = kategori;
        document.getElementById('labelSelectedKategori').textContent = kategori;
        document.getElementById('inputJenisPenjamin').value = kategori;

        const containerPerusahaan = document.getElementById('containerPilihPerusahaan');
        if (kategori === 'Pasien Perusahaan') {
            containerPerusahaan.classList.remove('d-none');
        } else {
            containerPerusahaan.classList.add('d-none');
            document.getElementById('labelSelectedPerusahaan').classList.add('d-none');
            document.getElementById('inputNamaPerusahaan').value = '';
        }

        document.getElementById('stepKategori').classList.add('d-none');
        document.getElementById('stepPasien').classList.remove('d-none');
    }

    function onPerusahaanChange() {
        const val = document.getElementById('selectPerusahaan').value;
        selectedPerusahaan = val;
        document.getElementById('inputNamaPerusahaan').value = val;

        const labelP = document.getElementById('labelSelectedPerusahaan');
        if (val) {
            document.getElementById('namaPerusahaanText').textContent = val;
            labelP.classList.remove('d-none');
        } else {
            labelP.classList.add('d-none');
        }
    }

    function resetKategori() {
        selectedKategori = '';
        selectedPerusahaan = '';
        stopCamera();
        document.getElementById('stepPasien').classList.add('d-none');
        document.getElementById('stepKategori').classList.remove('d-none');
    }

    function cariPesertaPerusahaan() {
        const pt = document.getElementById('selectPerusahaan').value;
        if (!pt) {
            Swal.fire('Perhatian', 'Pilih perusahaan terlebih dahulu!', 'warning');
            return;
        }

        const keyword = document.getElementById('keywordPasien').value;
        const containerResult = document.getElementById('resultCariPasien');
        containerResult.innerHTML = '<div class="py-3 text-center"><div class="spinner-border spinner-border-sm text-warning"></div> Mencari data...</div>';

        fetch(`{{ route("registrasi_pasien_find_data_pasien") }}?keyword=${encodeURIComponent(keyword)}&perusahaan=${encodeURIComponent(pt)}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    let html = '<div class="table-responsive"><table class="table table-sm align-middle text-start fs--1"><thead><tr><th>RM</th><th>NIK</th><th>Nama</th><th>Aksi</th></tr></thead><tbody>';
                    data.data.forEach(item => {
                        html += `<tr>
                            <td>${item.master_patient_code || '-'}</td>
                            <td>${item.master_patient_nik || '-'}</td>
                            <td class="fw-bold">${item.master_patient_name}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary fs--2" onclick='pilihPasienToLayanan(${JSON.stringify(item)})'>
                                    Pilih Pasien
                                </button>
                            </td>
                        </tr>`;
                    });
                    html += '</tbody></table></div>';
                    containerResult.innerHTML = html;
                } else {
                    containerResult.innerHTML = `<div class="p-3 text-center">
                        <div class="fw-bold mb-1">Peserta tidak ditemukan</div>
                        <button class="btn btn-sm btn-success" onclick="alihkanKeTambahPasienBaru()">Daftarkan Pasien Baru</button>
                    </div>`;
                }
            });
    }

    function cariPasien() {
        if (selectedKategori === 'Pasien Perusahaan') {
            cariPesertaPerusahaan();
            return;
        }
        const keyword = document.getElementById('keywordPasien').value;
        const containerResult = document.getElementById('resultCariPasien');
        containerResult.innerHTML = '<div class="py-3 text-center"><div class="spinner-border spinner-border-sm text-primary"></div> Mencari data...</div>';

        fetch(`{{ route("registrasi_pasien_find_data_pasien") }}?keyword=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    let html = '<div class="table-responsive"><table class="table table-sm align-middle text-start fs--1"><thead><tr><th>RM</th><th>NIK</th><th>Nama</th><th>Aksi</th></tr></thead><tbody>';
                    data.data.forEach(item => {
                        html += `<tr>
                            <td>${item.master_patient_code || '-'}</td>
                            <td>${item.master_patient_nik || '-'}</td>
                            <td class="fw-bold">${item.master_patient_name}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary fs--2" onclick='pilihPasienToLayanan(${JSON.stringify(item)})'>
                                    Pilih Pasien
                                </button>
                            </td>
                        </tr>`;
                    });
                    html += '</tbody></table></div>';
                    containerResult.innerHTML = html;
                } else {
                    containerResult.innerHTML = `<div class="p-3 text-center">
                        <div class="fw-bold mb-1">Data Pasien tidak ditemukan</div>
                        <button class="btn btn-sm btn-success" onclick="alihkanKeTambahPasienBaru()">Daftarkan Pasien Baru</button>
                    </div>`;
                }
            });
    }

    function alihkanKeTambahPasienBaru() {
        const tabBuat = new bootstrap.Tab(document.getElementById('tab-buat-pasien'));
        tabBuat.show();
        initCamera();
    }

    // PROSES PINDAH KE TAHAP 3: PILIH PASIEN & MASUKAN DATA LAYANAN
    function pilihPasienToLayanan(patientData) {
        selectedPatientData = patientData;
        stopCamera();

        document.getElementById('finalIdPatient').value = patientData.id_master_patient || '';
        document.getElementById('finalJenisPenjamin').value = selectedKategori;
        document.getElementById('finalNamaPerusahaan').value = selectedPerusahaan;

        document.getElementById('dispNamaPasien').textContent = patientData.master_patient_name;
        document.getElementById('dispInfoPasien').textContent = `RM: ${patientData.master_patient_code || '-'} | NIK: ${patientData.master_patient_nik || '-'}`;

        document.getElementById('stepPasien').classList.add('d-none');
        document.getElementById('stepLayanan').classList.remove('d-none');
    }

    function kembaliKePilihPasien() {
        document.getElementById('stepLayanan').classList.add('d-none');
        document.getElementById('stepPasien').classList.remove('d-none');
    }

    function selectTujuanLayanan(type) {
        document.getElementById('inputTujuanLayanan').value = type;

        document.getElementById('btnOptPoli').classList.remove('active');
        document.getElementById('btnOptIgd').classList.remove('active');
        document.getElementById('btnOptPenunjang').classList.remove('active');
        document.getElementById('btnOptExam').classList.remove('active');

        document.getElementById('sectionPoli').classList.add('d-none');
        document.getElementById('sectionIgd').classList.add('d-none');
        document.getElementById('sectionPenunjang').classList.add('d-none');

        if (type === 'POLIKLINIK') {
            document.getElementById('btnOptPoli').classList.add('active');
            document.getElementById('sectionPoli').classList.remove('d-none');
        } else if (type === 'IGD') {
            document.getElementById('btnOptIgd').classList.add('active');
            document.getElementById('sectionIgd').classList.remove('d-none');
        } else if (type === 'PENUNJANG') {
            document.getElementById('btnOptPenunjang').classList.add('active');
            document.getElementById('sectionPenunjang').classList.remove('d-none');
        } else if (type === 'PEMERIKSAAN') {
            document.getElementById('btnOptExam').classList.add('active');
        }
    }

    // SUBMIT SIMPAN PASIEN BARU -> LANGSUNG KE TAHAP 3 LAYANAN
    function submitPasienBaru(e) {
        e.preventDefault();
        const formData = new FormData(document.getElementById('formCreatePasien'));

        fetch("{{ route('registrasi_pasien_save_data_pasien') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    pilihPasienToLayanan({
                        id_master_patient: data.id_master_patient,
                        master_patient_name: data.master_patient_name,
                        master_patient_code: data.master_patient_code,
                        master_patient_nik: data.master_patient_nik
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Pasien Didaftarkan',
                        text: 'Silakan lanjutkan memilih Poliklinik/IGD atau isi pemeriksaan awal.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            });
    }

    // FINAL SUBMIT (POLI / IGD / ASSESSMENT)
    function submitFinalLayanan(e) {
        e.preventDefault();
        const formData = new FormData(document.getElementById('formFinalLayanan'));

        fetch("{{ route('registrasi_pasien_save_pemeriksaan_layanan') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        text: 'Data pendaftaran & pemeriksaan pasien telah berhasil disimpan.'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            });
    }

    async function initCamera(deviceId = null) {
        stopCamera();
        const video = document.getElementById('webcam');
        const selectCamera = document.getElementById('selectCamera');

        try {
            const constraints = {
                video: deviceId ? {
                    deviceId: {
                        exact: deviceId
                    }
                } : true
            };
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;

            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            selectCamera.innerHTML = '';
            videoDevices.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.text = device.label || `Kamera ${index + 1}`;
                if (deviceId && device.deviceId === deviceId) option.selected = true;
                selectCamera.appendChild(option);
            });
        } catch (err) {
            console.error("Akses Kamera Gagal:", err);
        }
    }

    function switchCamera(deviceId) {
        if (deviceId) initCamera(deviceId);
    }

    function takeSnapshot() {
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const preview = document.getElementById('previewFoto');
        const inputBase64 = document.getElementById('fotoPasienBase64');

        canvas.width = video.videoWidth || 240;
        canvas.height = video.videoHeight || 180;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg');
        inputBase64.value = dataUrl;
        preview.src = dataUrl;
        preview.classList.remove('d-none');
        video.classList.add('d-none');
        document.getElementById('btnRetake').classList.remove('d-none');
    }

    function resetCamera() {
        document.getElementById('fotoPasienBase64').value = '';
        document.getElementById('previewFoto').classList.add('d-none');
        document.getElementById('webcam').classList.remove('d-none');
        document.getElementById('btnRetake').classList.add('d-none');
    }

    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
    }


    function loadPoliSchedules() {
        const tbody = document.getElementById('tbodyPoliSchedules');
        tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data poliklinik...</td></tr>`;

        fetch("{{ route('registrasi_pasien_get_poli_schedules') }}")
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data.length > 0) {
                    let html = '';
                    res.data.forEach((item, idx) => {
                        const namaDokter = `${item.master_doctor_title_f ? item.master_doctor_title_f + ' ' : ''}${item.master_doctor_name}${item.master_doctor_title_e ? ', ' + item.master_doctor_title_e : ''}`;
                        const jamPraktik = `${item.time_start.substring(0,5)} - ${item.time_end.substring(0,5)}`;

                        html += `
                            <tr class="cursor-pointer" onclick="pilihRowPoli('${item.m_poli_code}', '${item.master_doctor_code}', '${item.id_schedule}', 'radio_poli_${idx}')">
                                <td class="ps-3">
                                    <input class="form-check-input" type="radio" name="radio_poli_select" id="radio_poli_${idx}" value="${item.id_schedule}">
                                </td>
                                <td class="fw-bold text-dark">${item.m_poli_name}</td>
                                <td><i class="fas fa-user-md me-1 text-primary"></i> ${namaDokter}</td>
                                <td><span class="badge bg-light text-dark border"><i class="far fa-clock me-1"></i> ${item.day_name}, ${jamPraktik} WIB</span></td>
                                <td class="text-center"><span class="badge bg-info">${item.quota} Pasien</span></td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted"><i class="fas fa-exclamation-circle me-1"></i> Tidak ada jadwal poliklinik aktif untuk hari ini.</td></tr>`;
                }
            })
            .catch(err => {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-danger">Gagal memuat jadwal poliklinik.</td></tr>`;
            });
    }

    function pilihRowPoli(poliCode, doctorCode, scheduleId, radioId) {
        document.getElementById(radioId).checked = true;
        document.getElementById('selectedPoliCode').value = poliCode;
        document.getElementById('selectedDoctorCode').value = doctorCode;
        document.getElementById('selectedScheduleId').value = scheduleId;
    }
</script>
