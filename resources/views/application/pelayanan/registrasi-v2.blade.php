<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien Rumah Sakit</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .step-container {
            display: none;
        }

        .step-container.active {
            display: block;
        }

        .form-section-title {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Pendaftaran Pasien</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="registrationForm" onsubmit="event.preventDefault(); alert('Pendaftaran Berhasil Disimpan!');">

                            <!-- STEP 1: Data Pasien -->
                            <div id="step-1" class="step-container active">
                                <h5 class="form-section-title">Langkah 1: Identitas Pasien</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status Pasien</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_pasien" id="pasienLama" value="lama" onchange="togglePatientForm()" checked>
                                            <label class="form-check-label" for="pasienLama">Pasien Lama (Sudah Terdaftar)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_pasien" id="pasienBaru" value="baru" onchange="togglePatientForm()">
                                            <label class="form-check-label" for="pasienBaru">Pasien Baru</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Pencarian Pasien Lama -->
                                <div id="form-pasien-lama">
                                    <div class="mb-3">
                                        <label for="search_patient" class="form-label">Cari NIK / Nomor Rekam Medis (Kode Pasien)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_patient" placeholder="Masukkan NIK atau Kode Pasien...">
                                            <button class="btn btn-outline-secondary" type="button">Cari Data</button>
                                        </div>
                                        <small class="text-muted">Pilih data pasien yang muncul setelah pencarian.</small>
                                    </div>
                                </div>

                                <!-- Form Pendaftaran Pasien Baru (Sesuai Schema) -->
                                <div id="form-pasien-baru" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="master_patient_nik" placeholder="16 Digit NIK">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="master_patient_name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-select" name="master_patient_jk">
                                                <option value="">Pilih...</option>
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Agama</label>
                                            <select class="form-select" name="master_patient_agama">
                                                <option value="">Pilih...</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen Protestan</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="master_patient_tempat_lahir">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="master_patient_tgl_lahir">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">No. HP / WhatsApp</label>
                                            <input type="text" class="form-control" name="master_patient_no_hp">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="master_patient_email">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" name="master_patient_alamat" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">Selanjutnya &raquo;</button>
                                </div>
                            </div>

                            <!-- STEP 2: Kategori & Layanan -->
                            <div id="step-2" class="step-container">
                                <h5 class="form-section-title">Langkah 2: Kategori Pasien & Tujuan Layanan</h5>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Kategori Pasien <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori_pasien" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="umum">Umum</option>
                                        <option value="perusahaan">Perusahaan</option>
                                        <option value="asuransi">Asuransi (BPJS/Swasta)</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Pilih Layanan / Instalasi <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_layanan" id="layananPoli" value="poliklinik" onchange="toggleService()">
                                            <label class="form-check-label" for="layananPoli">Poliklinik</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_layanan" id="layananLab" value="laboratorium" onchange="toggleService()">
                                            <label class="form-check-label" for="layananLab">Laboratorium</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_layanan" id="layananRad" value="radiologi" onchange="toggleService()">
                                            <label class="form-check-label" for="layananRad">Radiologi</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Area Dinamis: Poliklinik -->
                                <div id="area-poliklinik" class="bg-light p-3 border rounded mb-3" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Poliklinik</label>
                                        <select class="form-select" id="pilihan_poli">
                                            <option value="">-- Pilih Poli --</option>
                                            <option value="Penyakit Dalam">Poli Penyakit Dalam</option>
                                            <option value="Anak">Poli Anak</option>
                                            <option value="Kandungan">Poli Kandungan (Obgyn)</option>
                                            <option value="Gigi">Poli Gigi</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Dokter</label>
                                        <select class="form-select" id="pilihan_dokter">
                                            <option value="">-- Pilih Dokter --</option>
                                            <option value="Dr. A">Dr. A (Sp.PD)</option>
                                            <option value="Dr. B">Dr. B (Sp.A)</option>
                                            <option value="Dr. C">Dr. C (Sp.OG)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Area Dinamis: Laboratorium -->
                                <div id="area-laboratorium" class="bg-light p-3 border rounded mb-3" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Pemeriksaan Laboratorium</label>
                                        <select class="form-select" id="pilihan_lab">
                                            <option value="">-- Pilih Pemeriksaan --</option>
                                            <option value="Darah Lengkap">Darah Lengkap</option>
                                            <option value="Gula Darah">Gula Darah Puasa / Sewaktu</option>
                                            <option value="Urine">Urine Lengkap</option>
                                            <option value="Kolesterol">Cek Kolesterol</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Area Dinamis: Radiologi -->
                                <div id="area-radiologi" class="bg-light p-3 border rounded mb-3" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Pemeriksaan Radiologi</label>
                                        <select class="form-select" id="pilihan_rad">
                                            <option value="">-- Pilih Pemeriksaan --</option>
                                            <option value="Rontgen Thorax">Rontgen Thorax (Dada)</option>
                                            <option value="USG Abdomen">USG Abdomen</option>
                                            <option value="CT Scan">CT Scan Kepala</option>
                                            <option value="MRI">MRI</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary" onclick="prevStep(2, 1)">&laquo; Kembali</button>
                                    <button type="submit" class="btn btn-success">Simpan Pendaftaran</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk menampilkan/menyembunyikan form pasien baru vs lama
        function togglePatientForm() {
            const isLama = document.getElementById('pasienLama').checked;
            const formLama = document.getElementById('form-pasien-lama');
            const formBaru = document.getElementById('form-pasien-baru');

            if (isLama) {
                formLama.style.display = 'block';
                formBaru.style.display = 'none';
            } else {
                formLama.style.display = 'none';
                formBaru.style.display = 'block';
            }
        }

        // Fungsi untuk navigasi antar langkah (Wizard)
        function nextStep(current, next) {
            document.getElementById(`step-${current}`).classList.remove('active');
            document.getElementById(`step-${next}`).classList.add('active');
        }

        function prevStep(current, prev) {
            document.getElementById(`step-${current}`).classList.remove('active');
            document.getElementById(`step-${prev}`).classList.add('active');
        }

        // Fungsi untuk menampilkan detail layanan sesuai pilihan radio button
        function toggleService() {
            const jenisLayanan = document.querySelector('input[name="jenis_layanan"]:checked').value;

            // Sembunyikan semua area terlebih dahulu
            document.getElementById('area-poliklinik').style.display = 'none';
            document.getElementById('area-laboratorium').style.display = 'none';
            document.getElementById('area-radiologi').style.display = 'none';

            // Tampilkan area yang dipilih
            if (jenisLayanan === 'poliklinik') {
                document.getElementById('area-poliklinik').style.display = 'block';
            } else if (jenisLayanan === 'laboratorium') {
                document.getElementById('area-laboratorium').style.display = 'block';
            } else if (jenisLayanan === 'radiologi') {
                document.getElementById('area-radiologi').style.display = 'block';
            }
        }
    </script>

</body>

</html>
