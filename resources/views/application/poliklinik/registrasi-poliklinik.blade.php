@extends('layouts.layouts')

@section('content')
<style>
    :root {
        --primary-color: #0d6efd;
        --card-radius: 14px;
    }

    /* Wrapper utama mengikuti warna background tema aktif Bootstrap */
    .register-wrapper {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        border-radius: var(--card-radius);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Step Section Header */
    .step-header {
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px solid var(--bs-border-color);
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .step-badge {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
    }

    /* Form Controls Adaptive */
    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 0.6rem 0.85rem;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.12);
    }

    /* Doctor Schedule Card Styling */
    .doctor-card {
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid var(--bs-border-color);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
    }

    .doctor-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(13, 110, 253, 0.15);
    }

    /* Seleksi Card Adaptif */
    .doctor-card.selected {
        border-color: #198754 !important;
        background-color: var(--bs-success-bg-subtle) !important;
        box-shadow: 0 6px 16px rgba(25, 135, 84, 0.2);
    }

    /* Icon Check FontAwesome saat selected */
    .doctor-card.selected::after {
        content: "\f00c";
        font-family: "Font Awesome 5 Free", "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 12px;
        color: #198754;
        font-size: 1.1rem;
    }

    /* Queue Ticket Modal Styling */
    .queue-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: 2px;
        line-height: 1;
    }

    .btn-submit-custom {
        background: linear-gradient(135deg, #198754, #157347);
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.25);
        transition: all 0.2s ease;
    }

    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(25, 135, 84, 0.35);
    }
</style>

<div class="container-fluid py-4 register-wrapper">
    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-hospital text-primary me-2"></i>Pendaftaran Pasien Poliklinik
            </h4>
            <p class="text-body-secondary small mb-0">Sistem pendaftaran pasien online, pencarian data medis, dan pencetakan antrean</p>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small">
            <i class="fas fa-clock me-1"></i> Layanan Poliklinik Realtime
        </span>
    </div>

    <form id="formPendaftaran" onsubmit="submitRegistration(event)">
        @csrf
        <div class="row g-4">

            <!-- BAGIAN KIRI: SEARCH & IDENTITAS PASIEN -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3 mb-4 h-100 bg-body-tertiary">
                    <div class="card-body p-4">

                        <div class="step-header">
                            <div class="step-badge">1</div>
                            <h6 class="fw-bold mb-0">Identitas & Pencarian Pasien</h6>
                        </div>

                        <!-- Search Bar -->
                        <div class="p-3 bg-body rounded-3 border mb-3">
                            <label class="form-label small fw-semibold text-body-secondary">Cari Data Pasien Lama</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0"><i class="fas fa-search text-body-secondary"></i></span>
                                <input type="text" id="search_pasien" class="form-control border-start-0" placeholder="Masukkan NIK / Kode RM..." onkeydown="if(event.key==='Enter'){event.preventDefault(); searchPatient();}">
                                <button type="button" class="btn btn-primary px-3" onclick="searchPatient()">
                                    Cari
                                </button>
                                <button type="button" class="btn btn-outline-success px-3" onclick="resetToNewPatient()">
                                    <i class="fas fa-user-plus me-1"></i> Baru
                                </button>
                            </div>
                        </div>

                        <!-- Alert Notice -->
                        <div id="patient_info_alert" class="alert alert-info d-none small shadow-sm"></div>

                        <!-- Form Data Pasien -->
                        <input type="hidden" name="id_master_patient" id="id_master_patient">
                        <input type="hidden" name="is_new_patient" id="is_new_patient" value="0">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-body-secondary">Kode Pasien (RM)</label>
                            <input type="text" name="master_patient_code" id="master_patient_code" class="form-control form-control-sm bg-body" readonly placeholder="Otomatis terisi...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-body-secondary">NIK Pasien <span class="text-danger">*</span></label>
                            <input type="text" name="master_patient_nik" id="master_patient_nik" class="form-control form-control-sm" required readonly placeholder="Nomor Induk Kependudukan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-body-secondary">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                            <input type="text" name="master_patient_name" id="master_patient_name" class="form-control form-control-sm" required readonly placeholder="Nama sesuai KTP">
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="master_patient_tempat_lahir" id="master_patient_tempat_lahir" class="form-control form-control-sm" required readonly placeholder="Kota Lahir">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="master_patient_tgl_lahir" id="master_patient_tgl_lahir" class="form-control form-control-sm" required readonly>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="master_patient_jk" id="master_patient_jk" class="form-select form-select-sm" required disabled>
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">Agama <span class="text-danger">*</span></label>
                                <select name="master_patient_agama" id="master_patient_agama" class="form-select form-select-sm" required disabled>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">No. HP / WhatsApp</label>
                                <input type="text" name="master_patient_no_hp" id="master_patient_no_hp" class="form-control form-control-sm" readonly placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-body-secondary">Email</label>
                                <input type="email" name="master_patient_email" id="master_patient_email" class="form-control form-control-sm" readonly placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-semibold text-body-secondary">Alamat Lengkap</label>
                            <textarea name="master_patient_alamat" id="master_patient_alamat" class="form-control form-control-sm" rows="2" readonly placeholder="Alamat tempat tinggal"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN KANAN: POLIKLINIK, DOKTER & PENJAMIN -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 mb-4 h-100 bg-body-tertiary">
                    <div class="card-body p-4">

                        <div class="step-header">
                            <div class="step-badge">2</div>
                            <h6 class="fw-bold mb-0">Pilih Poliklinik, Dokter & Jadwal Praktek</h6>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-body-secondary">Tanggal Berobat <span class="text-danger">*</span></label>
                                <input type="date" id="visit_date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" onchange="onFilterPoliOrDateChange()" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-body-secondary">Poliklinik Tujuan <span class="text-danger">*</span></label>
                                <select id="poli_code" name="m_poli_code" class="form-select" onchange="onFilterPoliOrDateChange()" required>
                                    <option value="">-- Pilih Poliklinik --</option>
                                    @foreach($poliklinik as $p)
                                    <option value="{{ $p->m_poli_code }}">{{ $p->m_poli_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Schedule List Container -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-body-secondary d-block">Jadwal Dokter Praktek Tersedia <span class="text-danger">*</span></label>
                            <input type="hidden" name="schedule_id" id="selected_schedule_id" required>

                            <div id="doctor_schedule_container" class="row g-2">
                                <div class="col-12 text-center py-5 text-body-secondary border rounded-3 bg-body">
                                    <i class="far fa-calendar-check fa-2x text-primary opacity-50 d-block mb-2"></i>
                                    Silakan pilih Poliklinik & Tanggal Berobat di atas.
                                </div>
                            </div>
                        </div>

                        <div class="step-header mt-4">
                            <div class="step-badge">3</div>
                            <h6 class="fw-bold mb-0">Penjamin & Pembayaran</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-body-secondary">Jenis Penjamin <span class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-select" onchange="toggleInsuranceInput()" required>
                                    <option value="UMUM">UMUM / Mandiri</option>
                                    <option value="BPJS">BPJS Kesehatan</option>
                                    <option value="ASURANSI">Asuransi Swasta</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-none" id="insurance_number_wrapper">
                                <label class="form-label small fw-semibold text-body-secondary">No. Kartu BPJS / Asuransi <span class="text-danger">*</span></label>
                                <input type="text" name="insurance_no" id="insurance_no" class="form-control" placeholder="Masukkan nomor kartu">
                            </div>
                        </div>

                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-success btn-submit-custom text-white shadow" id="btnSubmit">
                                <i class="fas fa-check-circle me-2"></i> Proses Pendaftaran Pasien
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Modal Struk Tiket Antrean -->
<div class="modal fade" id="modalTiket" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <!-- Ganti bg-body menjadi bg-white di sini -->
        <div class="modal-content text-center border-0 shadow-lg rounded-4 overflow-hidden bg-white">

            <div class="bg-primary text-white p-3 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <i class="fas fa-check-circle fa-3x"></i>
                <h6 class="fw-bold mb-0 mt-2">RSUD HOSPITAL</h6>
                <small class="opacity-75">Bukti Pendaftaran Poliklinik</small>
            </div>

            <div class="modal-body p-4 bg-white" id="printableTicket">
                <span class="text-body-secondary extra-small fw-semibold text-uppercase tracking-wider d-block">Nomor Antrean Anda</span>
                <div class="queue-number my-2" id="ticket_queue_no">A-000</div>

                <h6 class="fw-bold mb-0" id="ticket_poli_name">Poli Umum</h6>
                <p class="small text-body-secondary mb-3" id="ticket_doctor_name">dr. John Doe</p>

                <!-- Ganti bg-body-tertiary menjadi bg-light -->
                <div class="bg-light p-3 rounded-3 text-start small mb-3 border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Kode Pasien:</span>
                        <span class="fw-bold" id="ticket_patient_code">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Pasien:</span>
                        <span class="fw-semibold" id="ticket_patient_name">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Penjamin:</span>
                        <span class="fw-semibold" id="ticket_payment">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-body-secondary">Tanggal:</span>
                        <span class="fw-semibold" id="ticket_date">-</span>
                    </div>
                </div>

                <p class="text-body-secondary extra-small mb-0"><i class="fas fa-info-circle me-1"></i>Harap datang 15 menit sebelum jam praktek dimulai.</p>
            </div>

            <!-- Ganti bg-body-tertiary menjadi bg-light -->
            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" id="btnCetakTiket" class="btn btn-primary w-100 fw-semibold" onclick="cetakStrukViaAjax()">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let modalTiket;

    document.addEventListener('DOMContentLoaded', function() {
        modalTiket = new bootstrap.Modal(document.getElementById('modalTiket'));
    });

    // Fungsi untuk mereset/membuka form pendaftaran pasien baru secara manual
    function resetToNewPatient() {
        // Reset nilai input pencarian
        document.getElementById('search_pasien').value = '';

        // Aktifkan form dalam status Pasien Baru
        setPatientFormState({}, true);

        Swal.fire({
            icon: 'info',
            title: 'Mode Pasien Baru',
            text: 'Form telah dibuka. Silakan isi data pasien baru.',
            timer: 1500,
            showConfirmButton: false
        });
    }
    // 1. Function Pencarian Pasien
    function searchPatient() {
        const query = document.getElementById('search_pasien').value.trim();
        if (!query) {
            Swal.fire('Perhatian', 'Masukkan NIK atau Kode RM Pasien untuk mencari!', 'warning');
            return;
        }

        fetch(`{{ route('poliklinik_register_poli_searchPatient') }}?keyword=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success' && res.data) {
                    setPatientFormState(res.data, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Pasien Ditemukan',
                        text: `Data pasien atas nama ${res.data.name} berhasil dimuat.`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Pasien Tidak Ditemukan',
                        text: 'Apakah Anda ingin mendaftarkan sebagai Pasien Baru?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Daftar Baru',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setPatientFormState({}, true);
                            if (!isNaN(query) && query.length === 16) {
                                document.getElementById('master_patient_nik').value = query;
                            }
                        }
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Gagal terhubung ke server saat pencarian pasien.', 'error');
            });
    }

    // Helper State Form
    function setPatientFormState(data, isNew) {
        const fields = [
            'master_patient_nik',
            'master_patient_name',
            'master_patient_tempat_lahir',
            'master_patient_tgl_lahir',
            'master_patient_jk',
            'master_patient_agama',
            'master_patient_no_hp',
            'master_patient_email',
            'master_patient_alamat'
        ];
        const alertBox = document.getElementById('patient_info_alert');

        document.getElementById('is_new_patient').value = isNew ? "1" : "0";
        document.getElementById('id_master_patient').value = data.id || '';
        document.getElementById('master_patient_code').value = data.code || (isNew ? 'OTOMATIS' : '');

        document.getElementById('master_patient_nik').value = data.nik || '';
        document.getElementById('master_patient_name').value = data.name || '';
        document.getElementById('master_patient_tempat_lahir').value = data.tempat_lahir || '';
        document.getElementById('master_patient_tgl_lahir').value = data.tgl_lahir || '';
        document.getElementById('master_patient_jk').value = data.jk || '';
        document.getElementById('master_patient_agama').value = data.agama || '';
        document.getElementById('master_patient_no_hp').value = data.no_hp || '';
        document.getElementById('master_patient_email').value = data.email || '';
        document.getElementById('master_patient_alamat').value = data.alamat || '';

        fields.forEach(field => {
            const el = document.getElementById(field);
            if (el) {
                if (isNew) {
                    el.removeAttribute('readonly');
                    el.removeAttribute('disabled');
                    el.style.pointerEvents = 'auto';
                } else {
                    el.setAttribute('readonly', 'readonly');
                    if (field === 'master_patient_jk' || field === 'master_patient_agama') {
                        el.removeAttribute('disabled');
                        el.style.pointerEvents = 'none';
                        el.classList.add('bg-body');
                    }
                }
            }
        });

        if (!isNew) {
            alertBox.classList.remove('d-none');
            alertBox.className = "alert alert-success d-block small shadow-sm";
            alertBox.innerHTML = `<i class="fas fa-check-circle me-1"></i> Data Pasien Terverifikasi (Kode RM: ${data.code})`;
        } else {
            alertBox.classList.remove('d-none');
            alertBox.className = "alert alert-warning d-block small shadow-sm";
            alertBox.innerHTML = `<i class="fas fa-edit me-1"></i> Mode Registrasi Pasien Baru. Silakan lengkapi formulir.`;
        }
    }

    // 2. Fetch Doctor Schedules
    function onFilterPoliOrDateChange() {
        const poliCode = document.getElementById('poli_code').value;
        const date = document.getElementById('visit_date').value;
        const container = document.getElementById('doctor_schedule_container');

        document.getElementById('selected_schedule_id').value = '';

        if (!poliCode || !date) {
            container.innerHTML = `
                <div class="col-12 text-center py-5 text-body-secondary border rounded-3 bg-body">
                    <i class="far fa-calendar-check fa-2x text-primary opacity-50 d-block mb-2"></i>
                    Silakan pilih Poliklinik & Tanggal Berobat di atas.
                </div>`;
            return;
        }

        container.innerHTML = `
            <div class="col-12 text-center py-5 text-body-secondary border rounded-3 bg-body">
                <span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span> Memuat jadwal dokter...
            </div>`;

        fetch(`{{ route('poliklinik_register_poli_getAvailableDoctors') }}?m_poli_code=${encodeURIComponent(poliCode)}&date=${encodeURIComponent(date)}`)
            .then(res => res.json())
            .then(res => {
                container.innerHTML = '';

                if (!res.data || res.data.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center py-4 text-danger border rounded-3 bg-body">
                            <i class="fas fa-exclamation-triangle fa-2x d-block mb-2"></i>
                            Tidak ada dokter praktek di poliklinik dan tanggal ini.
                        </div>`;
                    return;
                }

                res.data.forEach(item => {
                    const fullName = `${item.master_doctor_title_f || ''} ${item.master_doctor_name} ${item.master_doctor_title_e || ''}`.trim();
                    const quotaRemaining = item.quota - (item.quota_used || 0);
                    const isFull = quotaRemaining <= 0;

                    container.innerHTML += `
                        <div class="col-md-6">
                            <div class="card doctor-card p-3 ${isFull ? 'opacity-50 bg-body-tertiary' : 'bg-body'}"
                                 id="card-schedule-${item.id_schedule}"
                                 onclick="${isFull ? '' : `selectDoctorSchedule(${item.id_schedule})`}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="fw-bold pe-3">${fullName}</span>
                                    <span class="badge ${isFull ? 'bg-danger' : 'bg-success-subtle text-success border border-success-subtle'} me-2">
                                        ${isFull ? 'Kuota Habis' : 'Tersedia'}
                                    </span>
                                </div>
                                <div class="small text-body-secondary mb-2">
                                    <i class="far fa-clock me-1 text-primary"></i> ${item.time_start ? item.time_start.substring(0,5) : ''} - ${item.time_end ? item.time_end.substring(0,5) : ''} WIB
                                </div>
                                <div class="small fw-semibold ${isFull ? 'text-danger' : 'text-primary'}">
                                    <i class="fas fa-user-check me-1"></i> Sisa Kuota: ${quotaRemaining} / ${item.quota}
                                </div>
                            </div>
                        </div>`;
                });
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<div class="col-12 text-center py-4 text-danger border rounded-3 bg-body">Gagal memuat jadwal dokter.</div>`;
            });
    }

    function selectDoctorSchedule(scheduleId) {
        document.querySelectorAll('.doctor-card').forEach(card => card.classList.remove('selected'));
        const selectedCard = document.getElementById(`card-schedule-${scheduleId}`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
        document.getElementById('selected_schedule_id').value = scheduleId;
    }

    function toggleInsuranceInput() {
        const method = document.getElementById('payment_method').value;
        const wrapper = document.getElementById('insurance_number_wrapper');
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

    // 3. Submit Pendaftaran
    function submitRegistration(e) {
        e.preventDefault();

        const scheduleId = document.getElementById('selected_schedule_id').value;
        if (!scheduleId) {
            Swal.fire('Perhatian', 'Silakan pilih jadwal dokter praktek terlebih dahulu!', 'warning');
            return;
        }

        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses Pendaftaran...';

        const form = document.getElementById('formPendaftaran');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`{{ route('poliklinik_register_poli_store') }}?${params}`, {
                method: "GET",
                headers: {
                    "Accept": "application/json"
                }
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan pendaftaran');
                return data;
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Proses Pendaftaran Pasien';

                if (res.status === 'success') {
                    document.getElementById('ticket_queue_no').innerText = res.data.queue_number;
                    document.getElementById('ticket_poli_name').innerText = res.data.poli_name;
                    document.getElementById('ticket_doctor_name').innerText = res.data.doctor_name;
                    document.getElementById('ticket_patient_code').innerText = res.data.patient_code;
                    document.getElementById('ticket_patient_name').innerText = res.data.patient_name;
                    document.getElementById('ticket_payment').innerText = res.data.payment_method;
                    document.getElementById('ticket_date').innerText = res.data.visit_date;

                    modalTiket.show();

                    form.reset();
                    setPatientFormState({}, true);
                    document.getElementById('doctor_schedule_container').innerHTML = `
                    <div class="col-12 text-center py-5 text-body-secondary border rounded-3 bg-body">
                        <i class="far fa-calendar-check fa-2x text-primary opacity-50 d-block mb-2"></i>
                        Silakan pilih Poliklinik & Tanggal Berobat di atas.
                    </div>`;
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Proses Pendaftaran Pasien';
                Swal.fire('Gagal Pendaftaran', err.message, 'error');
            });
    }

    function cetakStrukViaAjax() {
        const btnCetak = $('#btnCetakTiket');

        // 1. Ambil data dari elemen HTML modal
        const dataTiket = {
            queue_no: $('#ticket_queue_no').text().trim(),
            poli_name: $('#ticket_poli_name').text().trim(),
            doctor_name: $('#ticket_doctor_name').text().trim(),
            patient_code: $('#ticket_patient_code').text().trim(),
            patient_name: $('#ticket_patient_name').text().trim(),
            payment: $('#ticket_payment').text().trim(),
            date: $('#ticket_date').text().trim()
        };

        // 2. Ubah state tombol menjadi loading
        btnCetak.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Mencetak...');

        // 3. Kirim AJAX ke endpoint cetak
        $.ajax({
            url: '/api/print-ticket', // Sesuaikan URL endpoint backend Anda
            type: 'POST',
            data: JSON.stringify(dataTiket),
            contentType: 'application/json',
            success: function(response) {
                alert('Struk berhasil dikirim ke printer!');
                $('#modalTiket').modal('hide');
            },
            error: function(xhr, status, error) {
                alert('Gagal mencetak struk: ' + (xhr.responseJSON?.message || error));
            },
            complete: function() {
                // Kembalikan tombol ke kondisi awal
                btnCetak.prop('disabled', false).html('<i class="fas fa-print me-1"></i> Cetak Struk');
            }
        });
    }
</script>
@endsection
