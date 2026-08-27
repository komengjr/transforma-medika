<style>
    /* Gradient Banner Header Modal */
    .modal-header-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #2563eb 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    /* Main Event Card */
    .event-main-card {
        border: 1px solid #cbd5e1 !important;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background-color: #ffffff;
    }

    .event-banner-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
        background-color: #0f172a;
    }

    .event-banner-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 0%, rgba(15, 23, 42, 0.8) 100%);
    }

    .badge-event-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .event-banner-title {
        position: absolute;
        bottom: 12px;
        left: 16px;
        right: 16px;
        color: #ffffff;
        margin: 0;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Card Sub Event (Border Ditegaskan & Hover Effect) */
    .sub-event-card {
        border: 2px solid #cbd5e1 !important;
        border-radius: 12px;
        transition: all 0.25s ease-in-out;
        background-color: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .sub-event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        border-color: #3b82f6 !important;
    }

    .sub-event-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .info-pill {
        background-color: #f1f5f9;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.8rem;
    }

    /* Section Card Border Fix */
    .section-bordered-card {
        border: 2px solid #cbd5e1 !important;
        border-radius: 12px;
        background-color: #ffffff;
    }

    /* DESAIN KARTU ATM REKENING */
    .atm-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        border-radius: 14px;
        padding: 16px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .atm-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .atm-chip {
        width: 38px;
        height: 26px;
        background: linear-gradient(135deg, #fef08a 0%, #eab308 100%);
        border-radius: 5px;
        border: 1px solid #ca8a04;
    }

    .atm-number {
        font-family: 'Courier New', Courier, monospace;
        letter-spacing: 2px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #f8fafc;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6);
    }

    /* DESAIN KARTU NAMA CONTACT PERSON */
    .id-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        border-left: 5px solid #10b981 !important;
        padding: 14px;
        position: relative;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s;
    }

    .id-card:hover {
        transform: translateY(-2px);
    }

    .avatar-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: #d1fae5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal Banner -->
    <div class="modal-header-gradient py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-white fw-bold d-flex align-items-center" id="staticBackdropLabel">
                <i class="fas fa-sliders-h me-2 fs-0"></i> Form Setup Sub Event
            </h4>
            <p class="fs--2 mb-0 text-white-50">
                Support by <a class="text-white text-decoration-underline fw-semibold" href="#!">{{ env('APP_NAME') }}</a>
            </p>
        </div>
    </div>

    <!-- Body Form -->
    <div class="p-3 bg-light">
        <div class="row g-3">
            <!-- Sidebar Info Event Utama -->
            <div class="col-md-4">
                <div class="card event-main-card h-100">
                    <div class="event-banner-wrapper">
                        <img id="videoPreview" src="{{ Storage::url($data->event_data_template) }}" alt="Event Cover" />
                        <div class="event-banner-overlay"></div>
                        <span class="badge-event-tag"><i class="fas fa-star me-1"></i> Main Event</span>
                        <h5 class="event-banner-title fs-0">{{ $data->event_data_tittle }}</h5>
                    </div>

                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2">
                            <div class="info-pill border-start border-4 border-primary">
                                <small class="text-primary d-block fw-bold fs--2 text-uppercase mb-1">
                                    <i class="far fa-calendar-alt me-1"></i> Tanggal Pelaksanaan
                                </small>
                                <span class="fs--1 text-dark fw-semibold d-block">
                                    {{ $data->event_data_start_date }}
                                </span>
                                <span class="fs--2 text-muted">s/d {{ $data->event_data_end_date }}</span>
                            </div>

                            <div class="info-pill border-start border-4 border-danger">
                                <small class="text-danger d-block fw-bold fs--2 text-uppercase mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i> Lokasi Event
                                </small>
                                <span class="fs--1 text-dark fw-semibold d-block">
                                    {{ $data->event_data_venue }}
                                </span>
                                <span class="fs--2 text-muted">{{ $data->event_data_city }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REKENING SECTION (ATM MODEL) -->
            <div class="col-md-4">
                <div class="card section-bordered-card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h6 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                <i class="fas fa-credit-card me-2 fs-0"></i> Data Rekening Event
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold" data-bs-toggle="collapse" data-bs-target="#collapseFormRekening">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </button>
                        </div>

                        <!-- Form Accordion Tambah Rekening (Perbaikan Struktur Form) -->
                        <div class="collapse mb-3" id="collapseFormRekening">
                            <form id="formAddRekening" class="p-3 bg-light border rounded-3 shadow-sm" onsubmit="return false;">
                                @csrf
                                <input type="hidden" name="event_data_code" id="rek_event_data_code" value="{{ $data->event_data_code }}">

                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Nama Bank / E-Wallet <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" placeholder="Contoh: BCA / Mandiri / GoPay" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">No. Rekening / No. HP <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number" id="account_number" class="form-control form-control-sm" placeholder="Contoh: 1234567890" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Atas Nama (a.n) <span class="text-danger">*</span></label>
                                    <input type="text" name="account_holder" id="account_holder" class="form-control form-control-sm" placeholder="Contoh: Panitia Event" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Cabang <span class="text-muted fw-normal">(Opsional)</span></label>
                                    <input type="text" name="bank_branch" id="bank_branch" class="form-control form-control-sm" placeholder="Contoh: KCU Jakarta">
                                </div>
                                <button type="button" id="btnSubmitRekening" onclick="submitRekeningAjax()" class="btn btn-sm btn-primary w-100 mt-2 fw-bold">Simpan Rekening</button>
                            </form>
                        </div>

                        <!-- List Rekening Render Modal ATM -->
                        <div id="listRekeningContainer" class="d-flex flex-column gap-3">
                            <!-- Render via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTACT PERSON SECTION (NAME CARD MODEL) -->
            <div class="col-md-4">
                <div class="card section-bordered-card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h6 class="fw-bold mb-0 text-success d-flex align-items-center">
                                <i class="fas fa-address-book me-2 fs-0"></i> Contact Person Event
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill fw-semibold" data-bs-toggle="collapse" data-bs-target="#collapseFormContact">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </button>
                        </div>

                        <!-- Form Accordion Tambah Contact -->
                        <div class="collapse mb-3" id="collapseFormContact">
                            <form id="formAddContact" class="p-3 bg-light border rounded-3 shadow-sm" onsubmit="return false;">
                                @csrf
                                <input type="hidden" name="event_data_code" id="contact_event_data_code" value="{{ $data->event_data_code }}">

                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Nama Panitia <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_name" id="contact_name" class="form-control form-control-sm" placeholder="Contoh: Ahmad" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Jabatan / Peran <span class="text-muted fw-normal">(Opsional)</span></label>
                                    <input type="text" name="contact_role" id="contact_role" class="form-control form-control-sm" placeholder="Contoh: Humas / Admin Tiket">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control form-control-sm" placeholder="Contoh: 08123456789" required>
                                </div>
                                <button type="button" id="btnSubmitContact" onclick="submitContactAjax()" class="btn btn-sm btn-success w-100 mt-2 fw-bold">Simpan Contact</button>
                            </form>
                        </div>

                        <!-- List Contact Render Kartu Nama -->
                        <div id="listContactContainer" class="d-flex flex-column gap-2">
                            <!-- Render via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SEKSI SUB EVENT LIST ================= -->
        <div class="row g-3 mt-3 border-top pt-0">
            <div class="col">
                <div class="card section-bordered-card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 text-900 fw-bold d-flex align-items-center">
                            <i class="fas fa-cubes text-primary me-2"></i> Sub Event List
                        </h5>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ count($sub_event) }} Sub Event</span>
                    </div>
                    <div class="card-body p-3 p-md-4 bg-light">
                        <div class="row g-3">
                            @forelse ($sub_event as $sub_events)
                            <div class="col-md-4 col-xl-4">
                                <div class="card sub-event-card h-100">
                                    <div class="sub-event-card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-primary fw-bold fs-0">
                                            <i class="fas fa-layer-group me-1"></i> {{ $sub_events->event_data_sub_name }}
                                        </h6>
                                        <span class="badge rounded-pill bg-soft-success text-success fs--2">Aktif</span>
                                    </div>

                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="far fa-play-circle text-success me-2 fs-0"></i>
                                                <div>
                                                    <small class="text-muted d-block fs--2">Waktu Mulai</small>
                                                    <span class="fs--1 fw-semibold text-dark">{{ $sub_events->event_data_sub_start }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="far fa-stop-circle text-danger me-2 fs-0"></i>
                                                <div>
                                                    <small class="text-muted d-block fs--2">Waktu Selesai</small>
                                                    <span class="fs--1 fw-semibold text-dark">{{ $sub_events->event_data_sub_end }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-2 border-top">
                                            <button class="btn btn-warning btn-sm w-100 rounded-pill shadow-sm fw-bold fs--1"
                                                type="button"
                                                id="button-add-type-peserta"
                                                data-code="{{ $sub_events->event_data_sub_code }}">
                                                <i class="fas fa-plus-circle me-1"></i> Add Class & Session
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-4 bg-white rounded-3 border">
                                    <i class="fas fa-folder-open text-300 fs-4 mb-2"></i>
                                    <p class="text-muted mb-0 fs--1">Belum ada data sub event yang ditambahkan.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Dynamic Menu Type Peserta Container -->
                <div class="card border-0 shadow-sm rounded-3 mb-3" id="menu-type-peserta"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-200 border-top-0 d-flex justify-content-end">
    <button class="btn btn-secondary btn-sm rounded-pill px-4" type="button" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i> Tutup
    </button>
</div>

<script>
    window.eventCode = "{{ $data->event_data_code }}";

    // Global Setup AJAX CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // --- LOAD DATA REKENING ---
    function loadRekening() {
        if (!window.eventCode) return;
        $.get(`/event/rekening/${window.eventCode}`, function(res) {
            let html = '';
            if (!res.data || res.data.length === 0) {
                html = `<div class="text-center py-3 text-muted fst-italic border rounded-3 bg-light fs--1">Belum ada data rekening ditambahkan.</div>`;
            } else {
                res.data.forEach(item => {
                    html += `
                    <div class="atm-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-uppercase tracking-wider fs--1 text-warning">${item.bank_name}</span>
                            <button type="button" class="btn btn-sm text-danger p-0 border-0 btn-delete-rek" data-id="${item.id_event_data_rekening}">
                                <i class="fas fa-trash-alt fs-0"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="atm-chip"></div>
                            <small class="text-white-50 fs--2">${item.bank_branch ?? 'UTAMA'}</small>
                        </div>
                        <div class="atm-number mb-2">${item.account_number}</div>
                        <div class="d-flex justify-content-between align-items-end fs--2 text-uppercase">
                            <div>
                                <span class="text-white-50 d-block fs--3">Atas Nama</span>
                                <span class="fw-semibold text-white">${item.account_holder}</span>
                            </div>
                            <i class="fas fa-wifi text-white-50"></i>
                        </div>
                    </div>`;
                });
            }
            $('#listRekeningContainer').html(html);
        });
    }

    // --- LOAD DATA CONTACT ---
    function loadContact() {
        if (!window.eventCode) return;
        $.get(`/event/contact/${window.eventCode}`, function(res) {
            let html = '';
            if (!res.data || res.data.length === 0) {
                html = `<div class="text-center py-3 text-muted fst-italic border rounded-3 bg-light fs--1">Belum ada data kontak ditambahkan.</div>`;
            } else {
                res.data.forEach(item => {
                    let initial = item.contact_name ? item.contact_name.charAt(0).toUpperCase() : 'C';
                    html += `
                    <div class="id-card d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-icon shadow-sm">
                                ${initial}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark fs--1">${item.contact_name}</h6>
                                <span class="badge bg-soft-success text-success fs--2 mb-1">${item.contact_role ?? 'Panitia'}</span>
                                <div class="text-muted fs--2 d-flex align-items-center">
                                    <i class="fab fa-whatsapp text-success me-1"></i> ${item.contact_number}
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-delete-contact" data-id="${item.id_event_data_contact}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>`;
                });
            }
            $('#listContactContainer').html(html);
        });
    }

    // Load Data Awal
    loadRekening();
    loadContact();

    // Submit Rekening
    function submitRekeningAjax() {
        let form = $('#formAddRekening');

        if (!$('#bank_name').val() || !$('#account_number').val() || !$('#account_holder').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Mohon lengkapi field yang wajib diisi!'
            });
            return;
        }

        $.ajax({
            url: '/event/rekening/store',
            type: 'POST',
            data: form.serialize(),
            beforeSend: function() {
                $('#btnSubmitRekening').prop('disabled', true).text('Menyimpan...');
            },
            success: function(res) {
                form[0].reset();
                $('#collapseFormRekening').collapse('hide');
                loadRekening();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: res.message || 'Rekening berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr) {
                if (xhr.status === 419) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sesi Kadaluarsa',
                        text: 'Token CSRF kadaluarsa. Silakan refresh halaman Anda.'
                    });
                } else {
                    let errorMsg = xhr.responseJSON?.message || 'Gagal menyimpan data rekening.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMsg
                    });
                }
            },
            complete: function() {
                $('#btnSubmitRekening').prop('disabled', false).text('Simpan Rekening');
            }
        });
    }

    // Submit Contact Person
    function submitContactAjax() {
        let form = $('#formAddContact');

        if (!$('#contact_name').val() || !$('#contact_number').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Mohon lengkapi field yang wajib diisi!'
            });
            return;
        }

        $.ajax({
            url: '/event/contact/store',
            type: 'POST',
            data: form.serialize(),
            beforeSend: function() {
                $('#btnSubmitContact').prop('disabled', true).text('Menyimpan...');
            },
            success: function(res) {
                form[0].reset();
                $('#collapseFormContact').collapse('hide');
                loadContact();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: res.message || 'Kontak berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Gagal menyimpan data kontak.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorMsg
                });
            },
            complete: function() {
                $('#btnSubmitContact').prop('disabled', false).text('Simpan Contact');
            }
        });
    }

    // Hapus Rekening
    $(document).off('click', '.btn-delete-rek').on('click', '.btn-delete-rek', function() {
        let id = $(this).data('id');
        if (confirm("Hapus rekening ini?")) {
            $.ajax({
                url: `/event/rekening/delete/${id}`,
                type: 'DELETE',
                success: function(res) {
                    loadRekening();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message || 'Berhasil menghapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });

    // Hapus Contact
    $(document).off('click', '.btn-delete-contact').on('click', '.btn-delete-contact', function() {
        let id = $(this).data('id');
        if (confirm("Hapus kontak ini?")) {
            $.ajax({
                url: `/event/contact/delete/${id}`,
                type: 'DELETE',
                success: function(res) {
                    loadContact();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message || 'Berhasil menghapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });
</script>
