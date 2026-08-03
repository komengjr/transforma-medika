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
    .rad-img-container {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        background: #000;
        border: 2px solid #2d3748;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .rad-img-container img {
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.9;
    }

    .rad-img-container:hover img {
        transform: scale(1.05);
        opacity: 1;
    }

    .rad-img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .rad-img-container:hover .rad-img-overlay {
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

    .lightbox-modal .carousel-caption {
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        border-radius: 8px;
        padding: 10px 20px;
        bottom: 20px;
    }
</style>

<!-- CARD PROFIL PASIEN -->
<div class="card rad-card mb-4 overflow-hidden">
    <div class="card-header bg-primary bg-gradient text-white py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0 text-white"><i class="fas fa-user-injured me-2"></i>Informasi Pasien</h5>
            <span class="badge bg-white text-primary fw-bold">Radiologi</span>
        </div>
    </div>
    <div class="card-body bg-white p-4">
        <div class="row align-items-center g-4">
            <!-- Avatar & Quick Tag -->
            <div class="col-lg-3 col-md-4 text-center border-end-md">
                <div class="patient-avatar-wrapper mb-3">
                    <img src="{{ asset($data->master_patient_profile) }}"
                        class="patient-avatar"
                        alt="Foto Pasien"
                        onerror="this.src='https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg'">
                </div>
                <h5 class="fw-bold mb-1 text-dark">{{ $data->master_patient_name }}</h5>
                <span class="badge bg-soft-primary text-primary px-3 py-1 rounded-pill fw-bold">
                    RM: {{ $data->master_patient_code }}
                </span>
            </div>

            <!-- Detail Data Grid -->
            <div class="col-lg-9 col-md-8">
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-id-card text-primary me-1"></i> NIK</div>
                            <div class="info-value">{{ $data->master_patient_nik ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tgl Lahir</div>
                            <div class="info-value">
                                {{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $data->master_patient_jk ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</div>
                            <div class="info-value">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-pray text-primary me-1"></i> Agama</div>
                            <div class="info-value">{{ $data->master_patient_agama ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-phone text-primary me-1"></i> No. HP</div>
                            <div class="info-value">{{ $data->master_patient_no_hp ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
$payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code', $code)->first();
@endphp

@if ($payment)
<!-- CARD HASIL RADIOLOGI & EKSPERTISE -->
<div class="card rad-card mb-4">
    <div class="card-header bg-dark text-white py-3 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 text-white"><i class="fas fa-x-ray me-2 text-info"></i>Hasil Bacaan Radiologi</h5>
        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>
    </div>
    <div class="card-body bg-light p-4">

        <!-- GALERI FOTO RADIOLOGI (LOADED VIA FETCH / AJAX) -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-uppercase text-secondary mb-0 fs--1" style="letter-spacing: 0.5px;">
                    <i class="fas fa-images me-1"></i> Citra / Foto Radiologi (PACS Orthanc)
                </h6>
                <button id="btn-reload-orthanc" class="btn btn-xs btn-outline-primary rounded-pill">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
            </div>

            <!-- Spinner Loading -->
            <div id="orthanc-loader" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading DICOM...</span>
                </div>
                <p class="text-muted mt-2 fs--1">Mengambil citra dari PACS Orthanc...</p>
            </div>

            <!-- Container Gambar -->
            <div id="orthanc-gallery" class="row g-3 d-none">
                <!-- Image items akan di-inject melalui Fetch API -->
            </div>

            <!-- State Kosong (Tidak ada citra) -->
            <div id="orthanc-empty" class="text-center py-4 bg-white rounded border d-none">
                <i class="fas fa-file-medical-alt fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">Belum ada foto/citra radiologi yang diunggah di Orthanc.</p>
            </div>
        </div>

        <!-- HASIL BACAAN / EKSPERTISE DOKTER -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-file-medical-alt me-2"></i>Ekspertise Radiolog
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-secondary">Diagnosis / Klinis</label>
                        <input type="text" class="form-control bg-light" value="Batuk kronis > 2 minggu, dicurigai TB Paru" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-secondary">Hasil Deskripsi / BACAAN</label>
                        <textarea class="form-control bg-light" rows="4" readonly>
- Cor: Ukuran dan bentuk CTR normal.
- Pulmo: Tampak infiltrat pada lapangan atas paru kanan. Corakan vaskuler paru normal.
- Sinus kostofrenikus kanan dan kiri lancip.
- Diafragma kanan dan kiri normal.
- Tulang-tulang intak.
                            </textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-danger">KESIMPULAN / KESAN</label>
                        <textarea class="form-control bg-light fw-bold text-dark" rows="2" readonly>Gambaran TB Paru Aktif Dupleks (Kanan atas).</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- LIGHTBOX MODAL -->
<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <!-- Carousel dynamic injection -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT FETCH & LIGHTBOX VIEWER -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const code = "{{ $code }}";
        const fetchUrl = "{{ route('menu_radiologi_handling_pasien_image', ':code') }}".replace(':code', code);

        const loader = document.getElementById("orthanc-loader");
        const gallery = document.getElementById("orthanc-gallery");
        const emptyState = document.getElementById("orthanc-empty");
        const btnReload = document.getElementById("btn-reload-orthanc");

        let loadedImages = [];

        // Function Fetch Gambar dari Controller Proxy
        function loadOrthancImages() {
            loader.classList.remove("d-none");
            gallery.classList.add("d-none");
            emptyState.classList.add("d-none");
            gallery.innerHTML = "";

            fetch(fetchUrl, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loader.classList.add("d-none");

                    if (data.success && data.images.length > 0) {
                        loadedImages = data.images;
                        renderGallery(data.images);
                        gallery.classList.remove("d-none");
                    } else {
                        emptyState.classList.remove("d-none");
                    }
                })
                .catch(error => {
                    console.error("Error loading Orthanc images:", error);
                    loader.classList.add("d-none");
                    emptyState.classList.remove("d-none");
                    emptyState.innerHTML = `
                <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                <p class="text-danger mb-0">Gagal terhubung ke PACS Orthanc.</p>
            `;
                });
        }

        // Function Render HTML Grid
        function renderGallery(images) {
            images.forEach((img, index) => {
                const col = document.createElement("div");
                col.className = "col-6 col-sm-4 col-md-3";
                col.innerHTML = `
                <div class="rad-img-container">
                    <a href="#" class="d-block open-lightbox" data-index="${index}">
                        <img src="${img.preview_url}"
                             class="img-fluid w-100"
                             alt="${img.caption}"
                             loading="lazy">
                        <div class="rad-img-overlay">
                            <span class="btn btn-sm btn-light rounded-circle shadow-sm">
                                <i class="fas fa-search-plus text-dark"></i>
                            </span>
                        </div>
                    </a>
                </div>
            `;
                gallery.appendChild(col);
            });

            attachLightboxEvents();
        }

        // Lightbox / Carousel Handler
        const lightboxModal = document.getElementById("lightbox-modal");
        const bsModal = new bootstrap.Modal(lightboxModal);
        const modalBody = lightboxModal.querySelector(".modal-body .container-fluid");

        function attachLightboxEvents() {
            document.querySelectorAll(".open-lightbox").forEach(el => {
                el.addEventListener("click", function(e) {
                    e.preventDefault();
                    const activeIndex = parseInt(this.getAttribute("data-index"));
                    createCarousel(activeIndex);
                    bsModal.show();
                });
            });
        }

        function createCarousel(activeIndex) {
            let slides = "";
            loadedImages.forEach((img, idx) => {
                slides += `
                <div class="carousel-item ${idx === activeIndex ? 'active' : ''}">
                    <img src="${img.preview_url}" alt="${img.caption}">
                    <div class="carousel-caption">
                        <p class="m-0 fw-bold">${img.caption}</p>
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

        btnReload.addEventListener("click", loadOrthancImages);

        // Initial load
        loadOrthancImages();
    });
</script>


@else
<!-- STATE BELUM BAYAR -->
<div class="card rad-card mb-4 border-danger">
    <div class="card-body p-5 text-center">
        <div class="avatar avatar-4xl bg-soft-danger text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-lock fs-2"></i>
        </div>
        <h4 class="fw-bold text-danger">Hasil Belum Dapat Diakses</h4>
        <p class="text-muted mb-3" style="max-width: 500px; margin: 0 auto;">
            Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini. Silakan selesaikan pembayaran terlebih dahulu untuk membuka ekspertise dan hasil foto.
        </p>
        <span class="badge bg-danger px-3 py-2 fs-0">Status: Belum Melakukan Pembayaran</span>
    </div>
</div>
@endif
