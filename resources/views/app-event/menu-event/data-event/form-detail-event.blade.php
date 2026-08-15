<style>
    /* Gradient Banner Header Modal */
    .modal-header-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #2563eb 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    /* Main Event Card (Gambar di Atas, Detail di Bawah) */
    .event-main-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
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

    /* Gradient overlay pada gambar agar teks/badge di atasnya tetap jelas */
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

    /* Card Item untuk Sub Event Grid */
    .sub-event-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.25s ease-in-out;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .sub-event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.12);
        border-color: #bfdbfe;
    }

    .sub-event-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Info Pill Badges */
    .info-pill {
        background-color: #f1f5f9;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.8rem;
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
        <form class="row g-3" id="form-input-sub-event">
            @csrf
            <div class="row g-3">
                <!-- Sidebar Info Event Utama (Gambar Atas, Detail Bawah - Berwarna) -->
                <div class="col-lg-4 col-xl-3">
                    <div class="card event-main-card h-100">
                        <!-- Banner Gambar di Atas -->
                        <div class="event-banner-wrapper">
                            <img id="videoPreview" src="{{ Storage::url($data->event_data_template) }}" alt="Event Cover" />
                            <div class="event-banner-overlay"></div>
                            <span class="badge-event-tag"><i class="fas fa-star me-1"></i> Main Event</span>
                            <h5 class="event-banner-title fs-0">{{ $data->event_data_tittle }}</h5>
                        </div>

                        <!-- Detail Informasi Event di Bawah -->
                        <div class="card-body p-3">
                            <div class="d-flex flex-column gap-2">
                                <!-- Info Tanggal -->
                                <div class="info-pill border-start border-4 border-primary">
                                    <small class="text-primary d-block fw-bold fs--2 text-uppercase mb-1">
                                        <i class="far fa-calendar-alt me-1"></i> Tanggal Pelaksanaan
                                    </small>
                                    <span class="fs--1 text-dark fw-semibold d-block">
                                        {{ $data->event_data_start_date }}
                                    </span>
                                    <span class="fs--2 text-muted">s/d {{ $data->event_data_end_date }}</span>
                                </div>

                                <!-- Info Lokasi -->
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

                <!-- Panel Tampilan Sub Event Berbentuk CARD GRID -->
                <div class="col-lg-8 col-xl-9">
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-900 fw-bold d-flex align-items-center">
                                <i class="fas fa-cubes text-primary me-2"></i> Sub Event List
                            </h5>
                            <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ count($sub_event) }} Sub Event</span>
                        </div>
                        <div class="card-body p-3 p-md-4 bg-light">
                            <!-- Card Grid Container -->
                            <div class="row g-3">
                                @forelse ($sub_event as $sub_events)
                                <div class="col-md-6 col-xl-6">
                                    <div class="card sub-event-card h-100">
                                        <!-- Header Card Sub Event -->
                                        <div class="sub-event-card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 text-primary fw-bold fs-0">
                                                <i class="fas fa-layer-group me-1"></i> {{ $sub_events->event_data_sub_name }}
                                            </h6>
                                            <span class="badge rounded-pill bg-soft-success text-success fs--2">Aktif</span>
                                        </div>

                                        <!-- Body Card Sub Event -->
                                        <div class="card-body p-3">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="far fa-play-circle text-success me-2 fs--1"></i>
                                                    <div>
                                                        <small class="text-muted d-block fs--2">Waktu Mulai</small>
                                                        <span class="fs--1 fw-semibold text-dark">{{ $sub_events->event_data_sub_start }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="far fa-stop-circle text-danger me-2 fs--1"></i>
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
        </form>
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-200 border-top-0 d-flex justify-content-end">
    <button class="btn btn-secondary btn-sm rounded-pill px-4" type="button" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i> Tutup
    </button>
</div>
