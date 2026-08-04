<style>
    /* RADIOLOGY MODERN STYLES */
    .rad-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .patient-avatar-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
        margin: 0 auto;
    }

    .patient-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
    }

    /* RADIOLOGY IMAGE GALLERY */
    .rad-img-card {
        position: relative;
        background-color: #0f172a;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #334155;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rad-img-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .rad-img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .rad-img-card:hover .rad-img-overlay {
        opacity: 1;
    }

    /* LIGHTBOX STYLES */
    .lightbox-modal .modal-content {
        background: #0f172a;
        border: none;
    }

    .lightbox-modal .btn-close {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1050;
        filter: invert(1);
    }

    .lightbox-modal .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 0;
    }

    .lightbox-modal img {
        max-height: 85vh;
        max-width: 100%;
        object-fit: contain;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.8);
    }

    /* Styling Tab Ekspertise */
    .custom-tab-btn {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        transition: all 0.2s ease-in-out;
    }

    /* Saat Tab Di-hover (Arahkan Mouse) */
    .custom-tab-btn:hover:not(.disabled) {
        background-color: rgba(255, 255, 255, 0.35) !important;
        color: #ffffff !important;
    }

    /* Saat Tab Aktif (DIKLIK) */
    .custom-tab-btn.active {
        background-color: #ffffff !important;
        color: #0d6efd !important;
        /* Warna Biru Utama Bootstrap */
        border-color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    /* Status Disabled */
    .custom-tab-btn.disabled,
    .custom-tab-btn:disabled {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        border-color: transparent !important;
        cursor: not-allowed;
    }
</style>

<!-- CARD PROFIL PASIEN -->
<!-- CONTAINER PROFIL & PEMERIKSAAN (2 CARD SEJAJAR) -->
<div class="row g-3 mb-4">

    <!-- CARD KIRI: IDENTITAS PASIEN -->
    <div class="col-lg-6">
        <div class="card rad-card h-100 border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary bg-gradient text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold fs--1">
                        <i class="fas fa-user-injured me-2"></i> Identitas Pasien
                    </h6>
                    <span class="badge bg-white text-primary fw-bold">Radiologi</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <!-- Foto & Nama Pasien -->
                <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <div class="patient-avatar-wrapper flex-shrink-0" style="width: 65px; height: 65px;">
                        <img src="{{ asset($data->master_patient_profile) }}"
                            class="patient-avatar rounded-circle border border-2 border-primary shadow-sm"
                            style="width: 100%; height: 100%; object-fit: cover;"
                            alt="Foto Pasien"
                            onerror="this.src='https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg'">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-dark fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="badge bg-soft-primary text-primary fw-bold fs--1">
                            RM: {{ $data->master_patient_code }}
                        </span>
                    </div>
                </div>

                <!-- Grid Data Pasien -->
                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-id-card text-primary me-1"></i> NIK</div>
                            <div class="info-value text-truncate">{{ $data->master_patient_nik ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tgl Lahir</div>
                            <div class="info-value">
                                {{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $data->master_patient_jk ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-phone text-primary me-1"></i> No. HP</div>
                            <div class="info-value">{{ $data->master_patient_no_hp ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</div>
                            <div class="info-value text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-pray text-primary me-1"></i> Agama</div>
                            <div class="info-value">{{ $data->master_patient_agama ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD KANAN: DAFTAR PEMERIKSAAN & PRINT BARCODE -->
    <div class="col-lg-6">
        <div class="card rad-card h-100 border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold fs--1">
                        <i class="fas fa-list-alt me-2 text-info"></i> Daftar Pemeriksaan Radiologi
                    </h6>
                    <span class="badge bg-info text-dark fw-bold">{{ count($pemeriksaanList) }} Item</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <!-- Container List dengan Scrollbar -->
                <div class="d-flex flex-column gap-2" style="max-height: 340px; overflow-y: auto; padding-right: 4px;">

                    @forelse($pemeriksaanList as $index => $item)
                    @php
                    $status = strtolower($item->status_pembayaran ?? 'pending');
                    @endphp

                    <!-- Item Card Pemeriksaan -->
                    <div class="p border rounded-3 bg-light-subtle hover-shadow transition-all p-3 border-start border-3 @if($status == 'lunas' || $status == 'done' || $status == 'selesai') border-success @elseif($status == 'proses' || $status == 'handling') border-warning @else border-primary @endif">

                        <!-- Baris Atas: Info Pemeriksaan & Badge Status -->
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Number Badge -->
                                <span class="badge bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px; font-size: 0.75rem;">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 fs--1">
                                        {{ $item->nama_pemeriksaan ?? 'Pemeriksaan Radiologi' }}
                                    </h6>
                                    <small class="text-muted font-monospace fs--2">
                                        <i class="fas fa-hashtag text-secondary me-1"></i>{{ $item->order_rad_list_code }}
                                    </small>
                                </div>
                            </div>

                            <!-- Badge Status -->
                            <div>
                                @if($status == 'lunas' || $status == 'done' || $status == 'selesai')
                                <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-check-circle me-1"></i> Ready
                                </span>
                                @elseif($status == 'proses' || $status == 'handling')
                                <span class="badge bg-soft-warning text-warning rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-spinner fa-spin me-1"></i> Diproses
                                </span>
                                @else
                                <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-clock me-1"></i> {{ ucfirst($item->status_pembayaran ?? 'Pending') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <hr class="my-2 text-200" />

                        <!-- Baris Bawah: Tombol Aksi -->
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted fs--2">Aksi Pemeriksaan:</span>
                            <div class="d-inline-flex gap-2">
                                <!-- Tombol Cetak Barcode -->
                                <button type="button"
                                    class="btn btn-xs btn-outline-secondary rounded-pill px-2.5 py-1 btn-print-barcode"
                                    data-code="{{ $item->order_rad_list_code }}"
                                    data-nama="{{ $item->nama_pemeriksaan ?? 'Radiologi' }}"
                                    title="Cetak Barcode Item Pemeriksaan">
                                    <i class="fas fa-barcode me-1"></i> Barcode
                                </button>

                                <!-- Tombol Proses Handling Item -->
                                <button type="button"
                                    class="btn btn-xs btn-primary rounded-pill px-3 py-1 btn-proses-handling-item shadow-sm"
                                    data-id="{{ $item->id_d_reg_order_rad_list }}"
                                    data-code="{{ $item->order_rad_list_code }}"
                                    data-nama="{{ $item->nama_pemeriksaan ?? 'Radiologi' }}"
                                    title="Mulai Proses Handling Pemeriksaan Ini">
                                    <i class="fas fa-play me-1"></i> Proses
                                </button>
                            </div>
                        </div>

                    </div>
                    @empty
                    <!-- Empty State -->
                    <div class="p-4 text-center border rounded-3 bg-light">
                        <i class="fas fa-folder-open fa-2x text-400 mb-2"></i>
                        <p class="text-muted mb-0 fs--1">Tidak ada rincian item pemeriksaan.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

</div>
<script>
    // Event Handler Klik Tombol Print Barcode
    $(document).on("click", ".btn-print-barcode", function(e) {
        e.preventDefault();

        var orderRadListCode = $(this).data("code");

        // Sesuaikan nama route cetak barcode dengan sistem Anda
        var printUrl = "{{ route('menu_radiologi_handling_pasien_print_barcode', ':code') }}".replace(':code', orderRadListCode);

        // Membuka jendela pop-up khusus cetak
        window.open(
            printUrl,
            'CetakBarcodeWindow',
            'width=500,height=400,scrollbars=yes,resizable=yes'
        );
    });
</script>
@php
$payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code', $code)->first();
@endphp

@if ($payment)
<!-- CONTAINER UTAMA FOTO RADIOLOGI & FORM -->
<div class="row g-3 mb-4">
    <!-- KOLOM KIRI: GALERI CITRA RADIOLOGI -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-dark text-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="mb-0 text-white fw-bold fs--1">
                    <i class="fas fa-x-ray me-2 text-info"></i> Citra Radiologi PACS Orthanc
                    <span class="badge bg-info text-dark ms-2">{{ count($pemeriksaanList) }} Pemeriksaan</span>
                </h6>

                <!-- CONTAINER TOMBOL OHIF DINAMIS -->
                <div class="d-flex align-items-center gap-2 flex-wrap" id="container-ohif-buttons">
                    <!-- Button OHIF Viewer akan di-inject oleh JavaScript di sini -->
                </div>

                <button id="btn-fetch-orthanc" class="btn btn-xs btn-outline-light rounded-pill px-3">
                    <i class="fas fa-sync-alt me-1"></i> Refresh Citra
                </button>
            </div>

            <div class="card-body p-3 bg-light">
                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="orthanc-alert-text"></span>
                    </div>
                    <button type="button" class="btn-close" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                </div>

                <div id="orthanc-loader" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading DICOM...</span>
                    </div>
                    <p class="text-muted mt-2 fs--1 mb-0">Mengambil citra dari PACS Orthanc...</p>
                </div>

                <div id="orthanc-gallery" class="row g-2 d-none">
                    <!-- Image items di-inject via JS -->
                </div>

                <div id="orthanc-empty" class="text-center py-4 bg-white rounded border d-none">
                    <i class="fas fa-file-medical-alt fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0 fs--1" id="orthanc-empty-text">Belum ada foto/citra radiologi yang diunggah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM PENGISIAN EKSPERTISE -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 h-100">

            <!-- CARD HEADER -->
            <div class="card-header bg-primary text-white p-3">
                <!-- BARIS 1: Judul Card & Total Badge -->
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 text-white fw-bold fs--1">
                        <i class="fas fa-file-signature me-2"></i> Pengisian Ekspertise
                    </h6>
                    <span class="badge bg-white text-primary fw-bold px-2 py-1 fs--2">
                        {{ count($pemeriksaanList) }} Pemeriksaan
                    </span>
                </div>

                <!-- BARIS 2: TAB HEADER (Hanya jika > 1 pemeriksaan, diletakkan di baris terpisah) -->
                <!-- BARIS 2: TAB HEADER DENGAN KONTRAS WARNA YANG JELAS -->
                @if(count($pemeriksaanList) > 1)
                <div class="border-top border-white border-opacity-25 pt-2 mt-2">
                    <ul class="nav nav-pills card-header-pills gap-1" id="ekspertiseTab" role="tablist">
                        @foreach($pemeriksaanList as $index => $item)
                        @php
                        $namaExam = $item->nama_pemeriksaan ?? $item->d_reg_order_rad_item_name ?? 'Pemeriksaan ' . ($index + 1);
                        $isItemDisabled = isset($item->is_ready) ? !$item->is_ready : false;
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm py-1 px-3 fw-bold fs--2 custom-tab-btn {{ $index === 0 ? 'active' : '' }} {{ $isItemDisabled ? 'disabled opacity-50' : '' }}"
                                id="tab-item-{{ $index }}"
                                data-bs-toggle="tab"
                                data-bs-target="#content-item-{{ $index }}"
                                type="button"
                                role="tab"
                                @if($isItemDisabled) disabled tabindex="-1" aria-disabled="true" @endif>

                                <i class="fas {{ $isItemDisabled ? 'fa-lock' : 'fa-x-ray' }} me-1"></i>
                                {{ $namaExam }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- CARD BODY -->
            <div class="card-body p-3">

                <!-- Alert Peringatan Umum jika Gambar Belum Ada -->
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div>
                        <strong>Peringatan:</strong> Citra/foto radiologi belum diunggah. Ekspertise belum dapat diisi.
                    </div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php
                    $namaExam = $item->nama_pemeriksaan ?? $item->d_reg_order_rad_item_name ?? 'Radiologi';
                    $isItemDisabled = isset($item->is_ready) ? !$item->is_ready : false;
                    @endphp

                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        <!-- ALERT SPESIFIK JIKA PEMERIKSAAN INI TERKUNCI/BELUM SIAP -->
                        @if($isItemDisabled)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>
                                Status untuk <strong>{{ $namaExam }}</strong> belum diproses. Form di-disable.
                            </div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="#" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="rad_item_id" value="{{ $item->id_d_reg_order_rad_list ?? $item->d_reg_order_rad_id ?? '' }}">

                            <!-- STRIP NAMA PEMERIKSAAN (Minimalis & Elegan) -->
                            <div class="d-flex align-items-center justify-content-between p-2 mb-3 bg-light rounded-2 border">
                                <span class="fs--1 fw-bold text-dark">
                                    <i class="fas fa-stethoscope text-primary me-1"></i> {{ $namaExam }}
                                </span>
                                <span class="badge bg-soft-primary text-primary font-monospace fs--2">
                                    {{ $item->order_rad_list_code ?? '-' }}
                                </span>
                            </div>

                            <!-- INPUT DOKTER RADIOLOGI -->
                            <div class="mb-3">
                                <label class="form-label fw-bold fs--1 text-secondary mb-1">Dokter Pemeriksa / Radiolog</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="dokter_radiologi"
                                    value="{{ auth()->user()->name ?? 'Dr. Radiologi' }}" readonly disabled>
                            </div>

                            <!-- DESKRIPSI EKSPERTISE -->
                            <div class="mb-3">
                                <label class="form-label fw-bold fs--1 text-secondary mb-1">
                                    Hasil Bacaan / Deskripsi Ekspertise <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control field-ekspertise"
                                    name="hasil_ekspertise"
                                    rows="4"
                                    placeholder="Ketik hasil ekspertise untuk {{ $namaExam }}..."
                                    required
                                    @if($isItemDisabled) disabled @else disabled @endif></textarea>
                            </div>

                            <!-- KESAN / KESIMPULAN -->
                            <div class="mb-3">
                                <label class="form-label fw-bold fs--1 text-secondary mb-1">Kesan / Kesimpulan</label>
                                <textarea class="form-control field-ekspertise"
                                    name="kesan"
                                    rows="2"
                                    placeholder="Kesan klinis untuk {{ $namaExam }}..."
                                    @if($isItemDisabled) disabled @else disabled @endif></textarea>
                            </div>

                            <!-- TOMBOL SIMPAN -->
                            <div class="d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-sm btn-success px-3 btn-save-ekspertise shadow-sm"
                                    @if($isItemDisabled) disabled @else disabled @endif>
                                    <i class="fas fa-save me-1"></i> Simpan Ekspertise
                                </button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX MODAL -->
<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <button type="button" class="btn-close btn-close-white ms-auto m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                <div class="container-fluid p-0 w-100 h-100 d-flex align-items-center justify-content-center">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        // ------------------------------------------------------------------------
        // 1. INISIALISASI VARIABEL & ROUTE
        // ------------------------------------------------------------------------
        const code = "{{ $code }}";
        const fetchUrl = "{{ route('menu_radiologi_handling_pasien_image', ':code') }}".replace(':code', code);
        const ohifRoutePattern = "{{ route('pacs_server_studies_show', ':studyId') }}";

        // Element Selector UI Radiologi
        const containerOhif = document.getElementById("container-ohif-buttons");
        const btnFetch = document.getElementById("btn-fetch-orthanc");
        const loader = document.getElementById("orthanc-loader");
        const gallery = document.getElementById("orthanc-gallery");
        const emptyState = document.getElementById("orthanc-empty");
        const emptyText = document.getElementById("orthanc-empty-text");

        // Element Selector Alert
        const alertBox = document.getElementById("orthanc-alert");
        const alertText = document.getElementById("orthanc-alert-text");
        const alertNoImage = document.getElementById("alert-no-image");

        // Element Selector Form Ekspertise
        const formEkspertiseFields = document.querySelectorAll(".field-ekspertise");
        const btnSaveEkspertise = document.querySelectorAll(".btn-save-ekspertise");

        // Variable Penyimpan Data Gambar Sementara (untuk Lightbox Carousel)
        let loadedImages = [];

        // ------------------------------------------------------------------------
        // 2. HELPER FUNCTIONS
        // ------------------------------------------------------------------------

        // Control Status Form Ekspertise (Enable / Disable)
        function setEkspertiseFormStatus(enabled) {
            if (enabled) {
                formEkspertiseFields.forEach(field => field.removeAttribute("disabled"));
                btnSaveEkspertise.forEach(btn => btn.removeAttribute("disabled"));
                if (alertNoImage) alertNoImage.classList.add("d-none");
            } else {
                formEkspertiseFields.forEach(field => field.setAttribute("disabled", "disabled"));
                btnSaveEkspertise.forEach(btn => btn.setAttribute("disabled", "disabled"));
                if (alertNoImage) alertNoImage.classList.remove("d-none");
            }
        }

        // Alert Helper
        function triggerAlert(message) {
            if (alertText && alertBox) {
                alertText.innerText = message;
                alertBox.classList.remove("d-none");
            }
        }

        function hideAlert() {
            if (alertBox) alertBox.classList.add("d-none");
        }

        // ------------------------------------------------------------------------
        // 3. FUNGSI UTAMA: MEMUAT CITRA RADIOLOGI DARI ORTHANC
        // ------------------------------------------------------------------------
        function loadOrthancImages() {
            if (!loader || !gallery) return;

            // Reset Tampilan UI
            loader.classList.remove("d-none");
            gallery.classList.add("d-none");
            emptyState.classList.add("d-none");
            if (containerOhif) containerOhif.innerHTML = "";
            gallery.innerHTML = "";
            hideAlert();

            // Nonaktifkan Form selama data belum siap
            setEkspertiseFormStatus(false);

            // Fetch Data PACS via AJAX
            fetch(fetchUrl, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Gagal menghubungkan ke server (" + response.status + ")");
                    }
                    return response.json();
                })
                .then(data => {
                    loader.classList.add("d-none");

                    if (data.success && data.studies_list && data.studies_list.length > 0) {

                        // A. RENDER TOMBOL OHIF VIEWER DIPISAH PER PEMERIKSAAN
                        if (containerOhif) {
                            data.studies_list.forEach((study) => {
                                const ohifUrl = ohifRoutePattern.replace(':studyId', study.orthanc_study_id);
                                const btnHtml = `
                            <a href="${ohifUrl}" target="_blank" class="btn btn-xs btn-outline-info rounded-pill px-2 shadow-sm fw-bold" title="Buka OHIF Viewer ${study.nama_pemeriksaan}">
                                <i class="fas fa-microscope me-1"></i> OHIF: ${study.nama_pemeriksaan}
                            </a>
                        `;
                                containerOhif.insertAdjacentHTML('beforeend', btnHtml);
                            });
                        }

                        // B. RENDER GALERI GAMBAR JIKA TERSEDIA
                        if (data.images && data.images.length > 0) {
                            loadedImages = data.images;
                            renderGallery(data.images);
                            gallery.classList.remove("d-none");
                            setEkspertiseFormStatus(true); // Aktifkan form jika citra ditemukan
                        } else {
                            emptyText.innerText = "Study DICOM ditemukan, tetapi preview gambar belum tersedia.";
                            emptyState.classList.remove("d-none");
                            setEkspertiseFormStatus(false);
                        }

                    } else {
                        emptyText.innerText = data.message || "Belum ada foto/citra radiologi di Orthanc.";
                        emptyState.classList.remove("d-none");
                        setEkspertiseFormStatus(false);
                    }
                })
                .catch(error => {
                    loader.classList.add("d-none");
                    emptyState.classList.remove("d-none");
                    setEkspertiseFormStatus(false);
                    triggerAlert("Kesalahan PACS: " + error.message);
                });
        }

        // ------------------------------------------------------------------------
        // 4. RENDER GALERI CITRA
        // ------------------------------------------------------------------------
        function renderGallery(images) {
            gallery.innerHTML = "";

            images.forEach((img, index) => {
                const col = document.createElement("div");
                col.className = "col-6 col-md-4";
                col.innerHTML = `
                <div class="rad-img-card shadow-sm">
                    <img src="${img.preview_url}" alt="${img.caption}" loading="lazy">
                    <div class="rad-img-overlay">
                        <a href="#" class="btn btn-sm btn-light rounded-circle shadow open-lightbox" data-index="${index}" title="Pratinjau Gambar">
                            <i class="fas fa-search-plus text-dark"></i>
                        </a>
                        <a href="${img.preview_url}" download="radiologi-${index + 1}.png" class="btn btn-sm btn-info rounded-circle shadow" title="Unduh Gambar">
                            <i class="fas fa-download text-white"></i>
                        </a>
                    </div>
                </div>
            `;
                gallery.appendChild(col);
            });

            attachLightboxEvents();
        }

        // ------------------------------------------------------------------------
        // 5. LIGHTBOX MODAL & CAROUSEL EVENT HANDLER
        // ------------------------------------------------------------------------
        const lightboxModal = document.getElementById("lightbox-modal");
        let bsModal = null;

        if (lightboxModal && typeof bootstrap !== 'undefined') {
            bsModal = new bootstrap.Modal(lightboxModal);
        }

        function attachLightboxEvents() {
            document.querySelectorAll(".open-lightbox").forEach(el => {
                el.onclick = function(e) {
                    e.preventDefault();
                    const activeIndex = parseInt(this.getAttribute("data-index"));
                    createCarousel(activeIndex);
                    if (bsModal) bsModal.show();
                };
            });
        }

        function createCarousel(activeIndex) {
            if (!lightboxModal) return;

            const modalBody = lightboxModal.querySelector(".modal-body .container-fluid");
            let slides = "";

            loadedImages.forEach((img, idx) => {
                slides += `
                <div class="carousel-item ${idx === activeIndex ? 'active' : ''} text-center py-4">
                    <img src="${img.preview_url}" class="img-fluid mx-auto" style="max-height: 80vh; object-fit: contain;" alt="${img.caption}">
                    <div class="carousel-caption bg-dark bg-opacity-75 rounded p-2 mt-2">
                        <p class="m-0 fw-bold text-white mb-2">${img.caption}</p>
                        <a href="${img.preview_url}" download="radiologi-${idx + 1}.png" class="btn btn-xs btn-outline-light rounded-pill px-3">
                            <i class="fas fa-download me-1"></i> Unduh Gambar
                        </a>
                    </div>
                </div>
            `;
            });

            modalBody.innerHTML = `
            <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
                <div class="carousel-inner">${slides}</div>
                <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        `;
        }

        // ------------------------------------------------------------------------
        // 6. EVENT LISTENERS
        // ------------------------------------------------------------------------
        if (btnFetch) {
            btnFetch.addEventListener("click", function(e) {
                e.preventDefault();
                loadOrthancImages();
            });
        }

        // Jalankan Otomatis saat halaman/section selesai dirender
        loadOrthancImages();

    })();
</script>

@else
<div class="card rad-card mb-4 border-danger">
    <div class="card-body p-5 text-center">
        <div class="avatar avatar-4xl bg-soft-danger text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-lock fs-2"></i>
        </div>
        <h4 class="fw-bold text-danger">Hasil Belum Dapat Diakses</h4>
        <p class="text-muted mb-3" style="max-width: 500px; margin: 0 auto;">
            Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.
        </p>
        <span class="badge bg-danger px-3 py-2 fs-0">Status: Belum Melakukan Pembayaran</span>
    </div>
</div>
@endif
