<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Poliklinik Rawat Jalan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #0dcaf0;
            --bg-light: #f4f7f6;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --border-radius: 16px;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-bottom: 50px;
        }

        /* Top Header Navigation */
        .navbar-brand-custom {
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--primary-color);
        }

        /* Hero Banner Section */
        .hero-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #004085 100%);
            color: #fff;
            padding: 40px 0 80px 0;
            border-radius: 0 0 30px 30px;
            margin-bottom: -50px;
        }

        /* Form Card Layout */
        .main-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            background: #ffffff;
            overflow: hidden;
        }

        .card-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f3f5;
        }

        .card-section-title i {
            color: var(--primary-color);
        }

        /* Form Controls Styling */
        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1.5px solid #e0e6ed;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #f8f9fa;
            border: 1.5px solid #e0e6ed;
            border-right: none;
        }

        .input-group .form-control {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        /* Doctor Schedule Card Radio selection */
        .schedule-option {
            display: none;
        }

        .schedule-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            background-color: #fff;
        }

        .schedule-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .schedule-option:checked+.schedule-card {
            border-color: var(--primary-color);
            background-color: #f0f7ff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }

        .schedule-option:checked+.schedule-card::after {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 12px;
            right: 12px;
            color: var(--primary-color);
            font-size: 1rem;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 1.05rem;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        /* Ticket Result Styling */
        .ticket-modal {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
        }

        .ticket-header {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .ticket-body {
            padding: 30px;
        }

        .ticket-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 2px;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom d-flex align-items-center gap-2" href="#">
                <i class="fa-solid fa-hospital-user fa-lg"></i>
                <span>MEDICA E-HEALTH</span>
            </a>
            <span class="badge bg-primary-subtle text-primary fw-medium px-3 py-2 rounded-pill">
                <i class="fa-regular fa-clock me-1"></i> Layanan Registrasi Online
            </span>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-banner text-center">
        <div class="container">
            <h2 class="fw-bold mb-2">Pendaftaran Poliklinik Rawat Jalan</h2>
            <p class="lead opacity-75 fs-6 mb-0">Silakan isi formulir pendaftaran secara akurat untuk mendapatkan nomor antrean</p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container" style="margin-top: -20px;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card main-card">
                    <div class="card-body p-4 p-md-5">

                        <form id="formPendaftaran" onsubmit="submitRegistration(event)">
                            @csrf
                            <input type="hidden" id="id_master_patient" name="id_master_patient">
                            <input type="hidden" id="is_new_patient" name="is_new_patient" value="1">

                            <!-- SECTION 1: POLIKLINIK & JADWAL -->
                            <div class="mb-5">
                                <div class="card-section-title">
                                    <i class="fa-solid fa-stethoscope"></i>
                                    <span>1. Pilih Poliklinik & Waktu Kunjungan</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small text-secondary">Poliklinik Tujuan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-clinic-medical text-muted"></i></span>
                                            <select id="m_poli_code" name="m_poli_code" class="form-select" onchange="onFilterPoliOrDateChange()" required>
                                                <option value="">-- Pilih Poliklinik --</option>
                                                @foreach($poliklinik as $p)
                                                <option value="{{ $p->m_poli_code }}">{{ $p->m_poli_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small text-secondary">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-calendar-alt text-muted"></i></span>
                                            <input type="date" id="visit_date" name="visit_date" class="form-control"
                                                min="{{ date('Y-m-d') }}" onchange="onFilterPoliOrDateChange()" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Container Dokter & Jadwal (Dynamic via API) -->
                                <div class="mt-4">
                                    <label class="form-label fw-medium small text-secondary">Jadwal Dokter Praktek <span class="text-danger">*</span></label>

                                    <div id="schedule_loading" class="text-center py-4 d-none">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="small text-muted mt-2">Mencari jadwal dokter...</p>
                                    </div>

                                    <div id="schedule_empty" class="alert alert-light text-center border p-4 rounded-3 d-none">
                                        <i class="fa-solid fa-user-doctor text-muted fa-2x mb-2"></i>
                                        <p class="text-muted mb-0 small">Silakan pilih Poliklinik dan Tanggal Kunjungan untuk melihat jadwal dokter.</p>
                                    </div>

                                    <div id="schedule_container" class="row g-3">
                                        <!-- Radio cards dokter dimasukkan lewat JS -->
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: DATA PASIEN -->
                            <div class="mb-5">
                                <div class="card-section-title">
                                    <i class="fa-solid fa-id-card"></i>
                                    <span>2. Identitas Pasien</span>
                                </div>

                                <!-- Search Box NIK/No.RM -->
                                <div class="p-3 bg-light rounded-3 mb-4 border">
                                    <label class="form-label fw-semibold small">Cari Data Pasien Lama</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                        <input type="text" id="search_keyword" class="form-control" placeholder="Masukkan NIK Pasien / Nomor Rekam Medis (RM)">
                                        <button class="btn btn-primary px-4" type="button" onclick="searchPatient()">
                                            <i class="fa-solid fa-search me-1"></i> Cari Pasien
                                        </button>
                                    </div>
                                    <span class="form-text text-muted small">*Jika Pasien Baru, langsung lengkapi formulir di bawah ini.</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small text-secondary">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                        <input type="text" id="master_patient_nik" name="master_patient_nik" class="form-control" maxlength="16" placeholder="16 digit NIK" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small text-secondary">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                                        <input type="text" id="master_patient_name" name="master_patient_name" class="form-control" placeholder="Nama sesuai KTP" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select id="master_patient_jk" name="master_patient_jk" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" id="master_patient_tempat_lahir" name="master_patient_tempat_lahir" class="form-control" placeholder="Kota Kelahiran" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" id="master_patient_tgl_lahir" name="master_patient_tgl_lahir" class="form-control" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Agama <span class="text-danger">*</span></label>
                                        <select id="master_patient_agama" name="master_patient_agama" class="form-select" required>
                                            <option value="">-- Pilih Agama --</option>
                                            <option value="ISLAM">Islam</option>
                                            <option value="KRISTEN">Kristen</option>
                                            <option value="KATOLIK">Katolik</option>
                                            <option value="HINDU">Hindu</option>
                                            <option value="BUDDHA">Buddha</option>
                                            <option value="KONGHUCU">Konghucu</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Nomor Handphone (WhatsApp)</label>
                                        <input type="tel" id="master_patient_no_hp" name="master_patient_no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-medium small text-secondary">Email</label>
                                        <input type="email" id="master_patient_email" name="master_patient_email" class="form-control" placeholder="contoh@email.com">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-medium small text-secondary">Alamat Lengkap Pasien</label>
                                        <textarea id="master_patient_alamat" name="master_patient_alamat" class="form-control" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: METODE PEMBAYARAN -->
                            <div class="mb-5">
                                <div class="card-section-title">
                                    <i class="fa-solid fa-wallet"></i>
                                    <span>3. Metode Pembayaran</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small text-secondary">Jenis Penjamin <span class="text-danger">*</span></label>
                                        <select id="payment_method" name="payment_method" class="form-select" onchange="toggleInsuranceInput()" required>
                                            <option value="UMUM">UMUM / Mandiri</option>
                                            <option value="BPJS">BPJS Kesehatan</option>
                                            <option value="ASURANSI">Asuransi Swasta</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 d-none" id="insurance_wrapper">
                                        <label class="form-label fw-medium small text-secondary">Nomor Kartu BPJS / Asuransi <span class="text-danger">*</span></label>
                                        <input type="text" id="insurance_no" name="insurance_no" class="form-control" placeholder="Masukkan nomor kartu">
                                    </div>
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="text-end">
                                <button type="submit" id="btnSubmit" class="btn btn-primary btn-submit text-white px-5">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pendaftaran
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CETAK TIKET -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ticket-modal border-0 shadow-lg">
                <div class="ticket-header">
                    <i class="fa-solid fa-circle-check fa-3x mb-2 text-white"></i>
                    <h4 class="fw-bold mb-0">Pendaftaran Berhasil!</h4>
                    <p class="small opacity-75 mb-0">Simpan atau cetak nomor antrean Anda</p>
                </div>
                <div class="ticket-body text-center">
                    <p class="text-muted mb-1 small fw-semibold">NOMOR ANTREAN</p>
                    <div id="t_queue_number" class="ticket-number">A-000</div>

                    <div class="p-3 bg-light rounded-3 text-start small mb-4">
                        <div class="row mb-1">
                            <span class="col-5 text-muted">Poliklinik:</span>
                            <span class="col-7 fw-bold" id="t_poli"></span>
                        </div>
                        <div class="row mb-1">
                            <span class="col-5 text-muted">Dokter:</span>
                            <span class="col-7 fw-semibold" id="t_doctor"></span>
                        </div>
                        <div class="row mb-1">
                            <span class="col-5 text-muted">Tanggal Kunjungan:</span>
                            <span class="col-7 fw-semibold" id="t_date"></span>
                        </div>
                        <div class="row mb-1">
                            <span class="col-5 text-muted">No. Rekam Medis:</span>
                            <span class="col-7 fw-bold text-primary" id="t_rm"></span>
                        </div>
                        <div class="row">
                            <span class="col-5 text-muted">Nama Pasien:</span>
                            <span class="col-7 fw-semibold" id="t_patient"></span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fa-solid fa-print me-2"></i> Cetak Tiket
                        </button>
                        <button class="btn btn-secondary" onclick="location.reload()">
                            Selesai & Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>

    <script>
        // Set Default Input Date -> Today
        document.getElementById('visit_date').value = new Date().toISOString().split('T')[0];

        // 1. Toggle Input Asuransi
        function toggleInsuranceInput() {
            const method = document.getElementById('payment_method').value;
            const wrapper = document.getElementById('insurance_wrapper');
            const input = document.getElementById('insurance_no');

            if (method === 'BPJS' || method === 'ASURANSI') {
                wrapper.classList.remove('d-none');
                input.setAttribute('required', 'required');
            } else {
                wrapper.classList.add('d-none');
                input.removeAttribute('required');
                input.value = '';
            }
        }

        // 2. Fetch Doctor Schedules
        function onFilterPoliOrDateChange() {
            const poliCode = document.getElementById('m_poli_code').value;
            const date = document.getElementById('visit_date').value;

            const container = document.getElementById('schedule_container');
            const loading = document.getElementById('schedule_loading');
            const empty = document.getElementById('schedule_empty');

            container.innerHTML = '';

            if (!poliCode || !date) {
                empty.classList.remove('d-none');
                return;
            }

            empty.classList.add('d-none');
            loading.classList.remove('d-none');

            fetch(`/poliklinik/get-available-doctors?m_poli_code=${poliCode}&date=${date}`)
                .then(res => res.json())
                .then(res => {
                    loading.classList.add('d-none');

                    if (res.status === 'success' && res.data.length > 0) {
                        res.data.forEach(item => {
                            const availableQuota = item.quota - item.quota_used;
                            const isFull = availableQuota <= 0;
                            const doctorTitle = `${item.master_doctor_title_f || ''} ${item.master_doctor_name} ${item.master_doctor_title_e || ''}`.trim();

                            const col = document.createElement('div');
                            col.className = 'col-md-6';
                            col.innerHTML = `
                                <input type="radio" name="schedule_id" value="${item.id_schedule}" id="sch_${item.id_schedule}" class="schedule-option" ${isFull ? 'disabled' : ''} required>
                                <label for="sch_${item.id_schedule}" class="schedule-card w-100 ${isFull ? 'opacity-50' : ''}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-primary-subtle text-primary p-3">
                                            <i class="fa-solid fa-user-md fa-xl"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">${doctorTitle}</h6>
                                            <div class="small text-muted mb-1">
                                                <i class="fa-regular fa-clock me-1"></i> ${item.time_start.substring(0,5)} - ${item.time_end.substring(0,5)} WIB
                                            </div>
                                            <span class="badge ${isFull ? 'bg-danger' : 'bg-success'}">
                                                ${isFull ? 'Kuota Habis' : 'Sisa Kuota: ' + availableQuota}
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            `;
                            container.appendChild(col);
                        });
                    } else {
                        empty.classList.remove('d-none');
                        empty.querySelector('p').innerText = 'Tidak ada jadwal praktek dokter pada tanggal dan poliklinik ini.';
                    }
                })
                .catch(err => {
                    loading.classList.add('d-none');
                    empty.classList.remove('d-none');
                    empty.querySelector('p').innerText = 'Gagal memuat data jadwal dokter.';
                });
        }

        // 3. Search Patient Logic
        function searchPatient() {
            const keyword = document.getElementById('search_keyword').value.trim();
            if (!keyword) {
                Swal.fire('Perhatian', 'Masukkan NIK atau Nomor Rekam Medis terlebih dahulu.', 'warning');
                return;
            }

            Swal.showLoading();

            fetch(`/poliklinik/search-patient?keyword=${keyword}`)
                .then(res => res.json())
                .then(res => {
                    Swal.close();
                    if (res.status === 'success') {
                        const p = res.data;
                        document.getElementById('id_master_patient').value = p.id;
                        document.getElementById('is_new_patient').value = '0';

                        document.getElementById('master_patient_nik').value = p.nik;
                        document.getElementById('master_patient_name').value = p.name;
                        document.getElementById('master_patient_jk').value = p.jk;
                        document.getElementById('master_patient_tempat_lahir').value = p.tempat_lahir;
                        document.getElementById('master_patient_tgl_lahir').value = p.tgl_lahir;
                        document.getElementById('master_patient_agama').value = p.agama;
                        document.getElementById('master_patient_no_hp').value = p.no_hp;
                        document.getElementById('master_patient_email').value = p.email;
                        document.getElementById('master_patient_alamat').value = p.alamat;

                        // Lock fields for existing patient
                        setPatientFormState(false);

                        Swal.fire('Data Ditemukan', `Pasien ${p.name} (RM: ${p.code}) berhasil dimuat.`, 'success');
                    } else {
                        // Reset & Enable Form for New Patient
                        resetPatientForm();
                        document.getElementById('master_patient_nik').value = keyword;
                        Swal.fire('Informasi', 'Data pasien tidak ditemukan. Silakan isi form sebagai Pasien Baru.', 'info');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Gagal terhubung ke server.', 'error');
                });
        }

        function setPatientFormState(isNew) {
            const fields = [
                'master_patient_nik', 'master_patient_name', 'master_patient_jk',
                'master_patient_tempat_lahir', 'master_patient_tgl_lahir', 'master_patient_agama',
                'master_patient_no_hp', 'master_patient_email', 'master_patient_alamat'
            ];

            fields.forEach(f => {
                const el = document.getElementById(f);
                if (el) {
                    if (isNew) {
                        el.removeAttribute('readonly');
                        el.style.pointerEvents = 'auto';
                        el.classList.remove('bg-light');
                    } else {
                        el.setAttribute('readonly', 'readonly');
                        el.style.pointerEvents = 'none';
                        el.classList.add('bg-light');
                    }
                }
            });
        }

        function resetPatientForm() {
            document.getElementById('id_master_patient').value = '';
            document.getElementById('is_new_patient').value = '1';
            setPatientFormState(true);
        }

        // 4. Submit Registration
        function submitRegistration(e) {
            e.preventDefault();

            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

            const form = document.getElementById('formPendaftaran');
            const formData = new FormData(form);

            fetch('/poliklinik/register-store', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Kirim Pendaftaran';

                    if (res.status === 'success') {
                        // Populate Modal Ticket
                        document.getElementById('t_queue_number').innerText = res.data.queue_number;
                        document.getElementById('t_poli').innerText = res.data.poli_name;
                        document.getElementById('t_doctor').innerText = res.data.doctor_name;
                        document.getElementById('t_date').innerText = res.data.visit_date;
                        document.getElementById('t_rm').innerText = res.data.patient_code;
                        document.getElementById('t_patient').innerText = res.data.patient_name;

                        // Show Modal
                        const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
                        modal.show();
                    } else {
                        Swal.fire('Gagal Menyimpan', res.message || 'Terjadi kesalahan sistem.', 'error');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Kirim Pendaftaran';
                    Swal.fire('Error', 'Gagal memproses pendaftaran. Periksa koneksi Anda.', 'error');
                });
        }
    </script>
</body>

</html>
