<style>
    /* Custom Styling Card & UI */
    .card-frame {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
    }

    .card-frame-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 10px 16px;
    }

    .btn-kategori-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .btn-kategori-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.06) !important;
        border-color: #0284c7;
    }

    .nav-pills-custom .nav-link {
        border-radius: 10px;
        padding: 8px 16px;
        color: #64748b;
        background: #f1f5f9;
        margin: 0 4px;
        transition: all 0.2s ease;
    }

    .nav-pills-custom .nav-link.active {
        background: #0284c7 !important;
        color: #ffffff !important;
        box-shadow: 0 3px 10px rgba(2, 132, 199, 0.25);
    }

    .camera-box {
        width: 100%;
        max-width: 260px;
        height: 195px;
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .camera-box video,
    .camera-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="p-3 bg-light min-vh-100 fs--1">
    <!-- Header Informasi Antrian -->
    <div class="alert alert-primary border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-2 px-3 bg-white" role="alert">
        <div class="badge bg-primary rounded-circle p-2 me-3">
            <i class="fa-solid fa-ticket fs-1 text-white"></i>
        </div>
        <div>
            <div class="fs--2 text-muted fw-bold text-uppercase tracking-wider">Antrian Aktif</div>
            <div class="fs--1 mb-0 text-dark">
                Memproses registrasi untuk nomor antrian: <span class="badge bg-primary fs--1 ms-1">{{ $nomorAntrian }}</span>
            </div>
        </div>
    </div>

    <!-- TAHAP 1: Pilih Jenis Pasien / Penjamin -->
    <div id="stepKategori" class="card-frame">
        <div class="card-frame-header d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-2 fs--2"><i class="fa-solid fa-layer-group"></i></span>
            <h6 class="fw-bold mb-0 text-dark fs--1"><i class="fa-solid fa-id-card-clip me-2 text-primary"></i>Pilih Jenis Penjamin / Pasien</h6>
        </div>
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-2 px-3 shadow-sm h-100" onclick="selectKategori('Pasien Umum')">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-2">
                                <i class="fa-solid fa-wallet fs-1 text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs--1 text-dark"><i class="fa-solid fa-user me-1 text-primary"></i> Pasien Umum</div>
                                <div class="fs--2 text-muted">Pembayaran Mandiri / Tunai</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-2 px-3 shadow-sm h-100" onclick="selectKategori('Pasien BPJS')">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-2 rounded-3 me-2">
                                <i class="fa-solid fa-notes-medical fs-1 text-success"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs--1 text-dark"><i class="fa-solid fa-shield-halved me-1 text-success"></i> Pasien BPJS</div>
                                <div class="fs--2 text-muted">Direct Integration BPJS / VClaim</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-2 px-3 shadow-sm h-100" onclick="selectKategori('Pasien Perusahaan')">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-2">
                                <i class="fa-solid fa-building fs-1 text-warning"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs--1 text-dark"><i class="fa-solid fa-briefcase me-1 text-warning"></i> Pasien Perusahaan</div>
                                <div class="fs--2 text-muted">Kerjasama Instansi / Perusahaan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-kategori-card p-2 px-3 shadow-sm h-100" onclick="selectKategori('Pasien Asuransi Swasta')">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-2 rounded-3 me-2">
                                <i class="fa-solid fa-file-invoice-dollar fs-1 text-info"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs--1 text-dark"><i class="fa-solid fa-building-shield me-1 text-info"></i> Asuransi Swasta</div>
                                <div class="fs--2 text-muted">Jaminan Asuransi Non-BPJS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAHAP 2 & 3: Pilihan Opsi & Form Data Pasien -->
    <div id="stepPasien" class="d-none">
        <div class="d-flex justify-content-between align-items-center mb-2 p-2 px-3 bg-white rounded-3 border shadow-sm">
            <div class="d-flex align-items-center">
                <span class="badge bg-success rounded-circle me-2 fs--2"><i class="fa-solid fa-check"></i></span>
                <span class="fw-bold text-secondary fs--1 me-2">Jenis Penjamin Terpilih:</span>
                <span id="labelSelectedKategori" class="badge bg-primary fs--1 px-2 py-1 rounded-pill"></span>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill fs--2 px-2 py-1" onclick="resetKategori()">
                <i class="fa-solid fa-rotate-left me-1"></i> Ganti Jenis Pasien
            </button>
        </div>

        <ul class="nav nav-pills nav-pills-custom nav-fill mb-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fs--1 fw-bold py-1" id="tab-cari-pasien" data-bs-toggle="pill" data-bs-target="#content-cari" type="button" role="tab">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari Data Pasien
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fs--1 fw-bold py-1" id="tab-buat-pasien" data-bs-toggle="pill" data-bs-target="#content-buat" type="button" role="tab" onclick="initCamera()">
                    <i class="fa-solid fa-user-plus me-1"></i> Buat Pasien Baru
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- TAB 1: CARI DATA PASIEN -->
            <div class="tab-pane fade show active" id="content-cari" role="tabpanel">
                <div class="card-frame">
                    <div class="card-frame-header bg-primary bg-opacity-10 border-primary border-opacity-10 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-primary fs--1">
                            <i class="fa-solid fa-database me-2"></i> Pencarian Data Pasien
                        </h6>
                        <span id="badgeSearchSource" class="badge bg-secondary fs--2">Database Lokal</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2 mb-2">
                            <div class="col-md-9">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search text-muted fs--1"></i></span>
                                    <input type="text" class="form-control border-start-0 fs--1" id="keywordPasien" placeholder="Ketik NIK, Nomor BPJS, atau Kode RM...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-primary w-100 fs--1 fw-bold shadow-sm" onclick="cariPasien()">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari Pasien
                                </button>
                            </div>
                        </div>

                        <div id="resultCariPasien" class="border rounded-3 p-3 bg-light text-center fs--1 text-muted" style="min-height: 120px;">
                            <i class="fa-solid fa-folder-open fs-2 text-black-50 mb-1 d-block"></i>
                            Silakan masukkan NIK, Nomor BPJS, atau Kode RM untuk memulai pencarian.
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: BUAT PASIEN BARU -->
            <div class="tab-pane fade" id="content-buat" role="tabpanel">
                <div class="card-frame">
                    <div class="card-frame-header bg-success bg-opacity-10 border-success border-opacity-10 py-2">
                        <h6 class="fw-bold mb-0 text-success fs--1">
                            <i class="fa-solid fa-user-plus me-2"></i> Form Registrasi Pasien Baru
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <form id="formCreatePasien" onsubmit="submitPasienBaru(event)">
                            @csrf
                            <input type="hidden" name="log_id" value="{{ $logId }}">
                            <input type="hidden" name="nomor_antrian" value="{{ $nomorAntrian }}">
                            <input type="hidden" name="jenis_penjamin" id="inputJenisPenjamin">
                            <input type="hidden" name="foto_pasien_base64" id="fotoPasienBase64">

                            <!-- SECTION CAPTURE KAMERA EKSTERNAL -->
                            <div class="row mb-3 pb-2 border-bottom align-items-center g-2">
                                <div class="col-md-4 d-flex flex-column align-items-center">
                                    <div class="camera-box shadow-sm mb-2">
                                        <video id="webcam" autoplay playsinline></video>
                                        <img id="previewFoto" class="d-none" alt="Preview Foto">
                                        <canvas id="canvas" class="d-none"></canvas>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-primary fs--1 py-1" onclick="takeSnapshot()">
                                            <i class="fa-solid fa-camera me-1"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary fs--1 py-1 d-none" id="btnRetake" onclick="resetCamera()">
                                            <i class="fa-solid fa-rotate me-1"></i> Foto Ulang
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="p-2 bg-light rounded-3 border">
                                        <h6 class="fw-bold fs--1 text-dark mb-1"><i class="fa-solid fa-video me-1 text-primary"></i>Pilih Kamera Eksternal</h6>
                                        <p class="fs--2 text-muted mb-2">Pilih perangkat kamera jika menggunakan periferal eksternal.</p>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white"><i class="fa-solid fa-webcam text-secondary fs--1"></i></span>
                                            <select class="form-select fs--1" id="selectCamera" onchange="switchCamera(this.value)">
                                                <option value="">-- Memuat Perangkat Kamera... --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FORM INPUT DATA PASIEN -->
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-id-card me-1 text-primary"></i> NIK / No. Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm fs--1" id="inputNik" name="master_patient_nik" placeholder="16 Digit NIK" required>
                                </div>
                                <div class="col-md-4" id="containerNoBpjs">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-shield-halved me-1 text-success"></i> No. Kartu BPJS
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control fs--1" id="inputNoBpjs" name="master_patient_no_bpjs" placeholder="13 Digit No. BPJS">
                                        <button class="btn btn-outline-success fs--2" type="button" onclick="cekBpjsDirect()"><i class="fa-solid fa-sync me-1"></i> Cek BPJS</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-user me-1 text-primary"></i> Nama Lengkap Pasien <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm fs--1" id="inputNama" name="master_patient_name" placeholder="Nama Sesuai Identitas" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-venus-mars me-1 text-primary"></i> Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-sm fs--1" id="inputJk" name="master_patient_jk" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-city me-1 text-primary"></i> Tempat Lahir
                                    </label>
                                    <input type="text" class="form-control form-control-sm fs--1" id="inputTempatLahir" name="master_patient_tempat_lahir" placeholder="Kota / Kab Lahir">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-calendar-days me-1 text-primary"></i> Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control form-control-sm fs--1" id="inputTglLahir" name="master_patient_tgl_lahir" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-hands-praying me-1 text-primary"></i> Agama
                                    </label>
                                    <select class="form-select form-select-sm fs--1" name="master_patient_agama">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-phone me-1 text-primary"></i> No. HP / WA
                                    </label>
                                    <input type="text" class="form-control form-control-sm fs--1" id="inputNoHp" name="master_patient_no_hp" placeholder="08xxxxxxxxxx">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-envelope me-1 text-primary"></i> Email
                                    </label>
                                    <input type="email" class="form-control form-control-sm fs--1" name="master_patient_email" placeholder="email@domain.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold fs--2 text-secondary mb-1">
                                        <i class="fa-solid fa-location-dot me-1 text-primary"></i> Alamat Lengkap
                                    </label>
                                    <textarea class="form-control form-control-sm fs--1" id="inputAlamat" name="master_patient_alamat" rows="2" placeholder="Alamat Tinggal Pasien"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                                <button type="button" class="btn btn-sm btn-light border fs--1 px-3" data-bs-dismiss="modal" onclick="stopCamera()">
                                    <i class="fa-solid fa-xmark me-1"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-sm btn-success fs--1 px-3 shadow-sm fw-bold">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan & Daftarkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedKategori = '';
    let currentStream = null;

    function selectKategori(kategori) {
        selectedKategori = kategori;
        document.getElementById('labelSelectedKategori').textContent = kategori;
        document.getElementById('inputJenisPenjamin').value = kategori;

        const badgeSearch = document.getElementById('badgeSearchSource');
        const keywordInput = document.getElementById('keywordPasien');

        if (kategori === 'Pasien BPJS') {
            badgeSearch.className = 'badge bg-success fs--2';
            badgeSearch.innerHTML = '<i class="fa-solid fa-plug me-1"></i> Terhubung BPJS VClaim';
            keywordInput.placeholder = 'Ketik NIK atau Nomor Kartu BPJS...';
        } else {
            badgeSearch.className = 'badge bg-secondary fs--2';
            badgeSearch.innerHTML = 'Database Lokal';
            keywordInput.placeholder = 'Ketik NIK, Kode RM, atau Nama Pasien...';
        }

        document.getElementById('stepKategori').classList.add('d-none');
        document.getElementById('stepPasien').classList.remove('d-none');
    }

    function resetKategori() {
        selectedKategori = '';
        document.getElementById('inputJenisPenjamin').value = '';
        stopCamera();

        document.getElementById('stepPasien').classList.add('d-none');
        document.getElementById('stepKategori').classList.remove('d-none');
    }

    function cariPasien() {
        const keyword = document.getElementById('keywordPasien').value;
        if (!keyword) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Masukkan NIK / No. BPJS / Nama untuk dicari.'
            });
            return;
        }

        const containerResult = document.getElementById('resultCariPasien');
        containerResult.innerHTML = '<div class="py-3 text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div><div class="fs--1 text-muted mt-2">Mencari data...</div></div>';

        if (selectedKategori === 'Pasien BPJS') {
            fetch(`{{ route("registrasi_pasien_find_bpjs") }}?keyword=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const bpjs = data.data;
                        let html = `<div class="card border-success text-start fs--1 p-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <span class="fw-bold text-success"><i class="fa-solid fa-circle-check me-1"></i> Data BPJS Ditemukan</span>
                                <span class="badge ${bpjs.status_peserta === 'AKTIF' ? 'bg-success' : 'bg-danger'} fs--2">${bpjs.status_peserta}</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6"><strong>No. Kartu BPJS:</strong> ${bpjs.no_kartu}</div>
                                <div class="col-md-6"><strong>NIK:</strong> ${bpjs.nik}</div>
                                <div class="col-md-6"><strong>Nama Pasien:</strong> ${bpjs.nama}</div>
                                <div class="col-md-6"><strong>Tgl Lahir:</strong> ${bpjs.tgl_lahir}</div>
                                <div class="col-md-6"><strong>Jenis Kelamin:</strong> ${bpjs.sex === 'L' ? 'Laki-laki' : 'Perempuan'}</div>
                                <div class="col-md-6"><strong>Faskes 1:</strong> ${bpjs.faskes_1 || '-'}</div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-sm btn-success fs--1 fw-bold px-3 rounded-pill" onclick='autofillFromBpjs(${JSON.stringify(bpjs)})'>
                                    <i class="fa-solid fa-user-plus me-1"></i> Gunakan Data Ini
                                </button>
                            </div>
                        </div>`;
                        containerResult.innerHTML = html;
                    } else {
                        containerResult.innerHTML = `<div class="text-danger p-2 fs--1"><i class="fa-solid fa-circle-exclamation me-1"></i>${data.message || 'Data Kepesertaan BPJS Tidak Ditemukan.'}</div>`;
                    }
                })
                .catch(() => {
                    containerResult.innerHTML = '<div class="text-danger p-2 fs--1">Gagal terhubung ke layanan server BPJS.</div>';
                });
        } else {
            fetch(`{{ route("registrasi_pasien_find_data_pasien") }}?keyword=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        let html = '<div class="table-responsive"><table class="table table-sm table-hover align-middle text-start fs--1 mb-0">';
                        html += '<thead class="table-light"><tr><th>Kode RM</th><th>NIK</th><th>Nama Pasien</th><th>Tgl Lahir</th><th class="text-center">Aksi</th></tr></thead><tbody>';

                        data.data.forEach(item => {
                            html += `<tr>
                                <td class="fw-bold text-primary">${item.master_patient_code || '-'}</td>
                                <td>${item.master_patient_nik || '-'}</td>
                                <td class="fw-bold text-dark">${item.master_patient_name}</td>
                                <td>${item.master_patient_tgl_lahir || '-'}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary fs--2 px-2 py-0 rounded-pill" onclick="pilihPasienExisting('${item.id_master_patient}', '${item.master_patient_name}')">
                                        <i class="fa-solid fa-check me-1"></i> Pilih Pasien
                                    </button>
                                </td>
                            </tr>`;
                        });
                        html += '</tbody></table></div>';
                        containerResult.innerHTML = html;
                    } else {
                        containerResult.innerHTML = '<div class="text-danger p-2 fs--1"><i class="fa-solid fa-circle-exclamation me-1"></i>Data pasien tidak ditemukan. Silakan beralih ke tab "Buat Pasien Baru".</div>';
                    }
                })
                .catch(() => {
                    containerResult.innerHTML = '<div class="text-danger p-2 fs--1">Gagal terhubung ke server untuk mencari data.</div>';
                });
        }
    }

    function autofillFromBpjs(bpjs) {
        const tabBuat = new bootstrap.Tab(document.getElementById('tab-buat-pasien'));
        tabBuat.show();

        document.getElementById('inputNik').value = bpjs.nik || '';
        document.getElementById('inputNoBpjs').value = bpjs.no_kartu || '';
        document.getElementById('inputNama').value = bpjs.nama || '';
        document.getElementById('inputJk').value = bpjs.sex || '';
        document.getElementById('inputTglLahir').value = bpjs.tgl_lahir || '';
        document.getElementById('inputNoHp').value = bpjs.no_telepon || '';
        document.getElementById('inputAlamat').value = bpjs.alamat || '';

        initCamera();

        Swal.fire({
            icon: 'info',
            title: 'Data BPJS Terisi',
            text: 'Data dari BPJS berhasil dimasukkan ke form.',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function cekBpjsDirect() {
        const noBpjs = document.getElementById('inputNoBpjs').value;
        const nik = document.getElementById('inputNik').value;
        const query = noBpjs || nik;

        if (!query) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Isi NIK atau No. BPJS terlebih dahulu.'
            });
            return;
        }

        Swal.showLoading();
        fetch(`{{ route("registrasi_pasien_find_bpjs") }}?keyword=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    autofillFromBpjs(data.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Ditemukan',
                        text: data.message
                    });
                }
            })
            .catch(() => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal terhubung ke server BPJS.'
                });
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
        const btnRetake = document.getElementById('btnRetake');

        canvas.width = video.videoWidth || 260;
        canvas.height = video.videoHeight || 195;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg');
        inputBase64.value = dataUrl;

        preview.src = dataUrl;
        preview.classList.remove('d-none');
        video.classList.add('d-none');
        btnRetake.classList.remove('d-none');
    }

    function resetCamera() {
        const video = document.getElementById('webcam');
        const preview = document.getElementById('previewFoto');
        const inputBase64 = document.getElementById('fotoPasienBase64');
        const btnRetake = document.getElementById('btnRetake');

        inputBase64.value = '';
        preview.classList.add('d-none');
        video.classList.remove('d-none');
        btnRetake.classList.add('d-none');
    }

    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
    }

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
                    stopCamera();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `Pasien terdaftar dengan Kode RM: ${data.master_patient_code}`
                    }).then(() => {
                        const modalEl = document.getElementById('modalFullRegistrasi');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                }
            });
    }

    function pilihPasienExisting(idMasterPatient, namaPasien) {
        Swal.fire({
            title: 'Konfirmasi Registrasi',
            text: `Daftarkan pasien "${namaPasien}" dengan penjamin ${selectedKategori}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Daftarkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Pasien berhasil didaftarkan.'
                });
            }
        });
    }
</script>
