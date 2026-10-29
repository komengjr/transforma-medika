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

    /* RADIOLOGY IMAGE GALLERY & LIGHTBOX */
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

    /* Custom Tab & Links */
    .custom-tab-btn {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        transition: all 0.2s ease-in-out;
    }

    .custom-tab-btn:hover:not(.disabled) {
        background-color: rgba(255, 255, 255, 0.35) !important;
        color: #ffffff !important;
    }

    .custom-tab-btn.active {
        background-color: #ffffff !important;
        color: #0d6efd !important;
        border-color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .custom-tab-btn.disabled,
    .custom-tab-btn:disabled {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        border-color: transparent !important;
        cursor: not-allowed;
    }

    .link-ohif-item {
        text-decoration: none !important;
        color: #2c3e50 !important;
        transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    .link-ohif-item:hover {
        background-color: #f1f5f9 !important;
        color: #0d6efd !important;
    }

    .link-ohif-item:hover i {
        color: #0d6efd !important;
    }
</style>

<!-- CARD PROFIL PASIEN & DAFTAR PEMERIKSAAN -->
<div class="row g-3 mb-4">
    <!-- CARD KIRI: IDENTITAS PASIEN -->
    <div class="col-lg-6">
        <div class="card rad-card h-100 border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary bg-gradient text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold fs--1"><i class="fas fa-user-injured me-2"></i> Identitas Pasien</h6>
                    <span class="badge bg-white text-primary fw-bold">Radiologi</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <div class="patient-avatar-wrapper flex-shrink-0" style="width: 65px; height: 65px;">
                        <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                            class="patient-avatar rounded-circle border border-2 border-primary shadow-sm"
                            alt="Foto Pasien">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-dark fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="badge bg-soft-primary text-primary fw-bold fs--1">RM: {{ $data->master_patient_code }}</span>
                    </div>
                </div>

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
                            <div class="info-value">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <div class="info-label"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</div>
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

    <!-- CARD KANAN: DAFTAR PEMERIKSAAN & AKSI HANDLING -->
    <div class="col-lg-6">
        <div class="card rad-card h-100 border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold fs--1"><i class="fas fa-list-alt me-2 text-info"></i> Daftar Pemeriksaan Radiologi</h6>
                    <span class="badge bg-info text-dark fw-bold">{{ count($pemeriksaanList) }} Item</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="d-flex flex-column gap-2" style="max-height: 340px; overflow-y: auto; padding-right: 4px;" id="list-pemeriksaan-container">
                    @forelse($pemeriksaanList as $index => $item)
                    @php $status = strtolower($item->status_pemeriksaan ?? 'menunggu'); @endphp

                    <div class="p border rounded-3 bg-light-subtle p-3 border-start border-3 item-pemeriksaan-card @if($status == 'selesai') border-success @elseif($status == 'proses') border-warning @else border-primary @endif" data-detail-id="{{ $item->detail_id }}">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px; font-size: 0.75rem;">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 fs--1">{{ $item->nama_pemeriksaan ?? 'Radiologi' }}</h6>
                                    <small class="text-muted font-monospace fs--2"><i class="fas fa-hashtag text-secondary me-1"></i>{{ $item->order_rad_list_code }}</small>
                                    <div class="durasi-badge-wrapper">
                                        @if(isset($item->durasi_pengerjaan_menit) && $item->durasi_pengerjaan_menit > 0)
                                        <br><span class="badge bg-light text-dark fs--2 border mt-1"><i class="fas fa-stopwatch text-warning me-1"></i> Durasi: <span class="durasi-val">{{ $item->durasi_pengerjaan_menit }}</span> Menit</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="status-badge-container">
                                @if($status == 'selesai')
                                <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 fs--2"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                @elseif($status == 'proses')
                                <span class="badge bg-soft-warning text-warning rounded-pill px-2 py-1 fs--2"><i class="fas fa-spinner fa-spin me-1"></i> Diproses</span>
                                @else
                                <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 fs--2"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                @endif
                            </div>
                        </div>
                        <hr class="my-2 text-200" />
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted fs--2">Aksi Petugas:</span>
                            <div class="d-inline-flex gap-2 action-button-container">
                                <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2.5 py-1 btn-print-barcode" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-barcode me-1"></i> Barcode
                                </button>

                                @if($status == 'menunggu')
                                <button type="button" class="btn btn-xs btn-warning rounded-pill px-3 py-1 btn-mulai-proses shadow-sm" data-id="{{ $item->detail_id }}" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-play me-1"></i> Mulai Proses
                                </button>
                                @elseif($status == 'proses')
                                <button type="button" class="btn btn-xs btn-success rounded-pill px-3 py-1 btn-selesai-proses shadow-sm" data-id="{{ $item->detail_id }}">
                                    <i class="fas fa-check me-1"></i> Selesai Proses
                                </button>
                                @else
                                <span class="badge bg-soft-success text-success fs--2 px-2 py-1"><i class="fas fa-check-double"></i> Siap Diisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center border rounded-3 bg-light">
                        <p class="text-muted mb-0 fs--1">Tidak ada rincian item pemeriksaan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Event Handler Cetak Barcode
    $(document).on("click", ".btn-print-barcode", function(e) {
        e.preventDefault();
        var orderRadListCode = $(this).data("code");
        var printUrl = "{{ route('menu_radiologi_handling_pasien_print_barcode', ':code') }}".replace(':code', orderRadListCode);
        window.open(printUrl, 'CetakBarcodeWindow', 'width=500,height=400,scrollbars=yes,resizable=yes');
    });

    // Event Handler Mulai Proses Handling (Tanpa Reload)
    $(document).on("click", ".btn-mulai-proses", function(e) {
        e.preventDefault();
        var btn = $(this);
        var detailId = btn.data("id");
        var orderCode = btn.data("code");
        var card = btn.closest(".item-pemeriksaan-card");

        btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');

        $.post("{{ route('radiologi.mulai_handling') }}", {
            _token: "{{ csrf_token() }}",
            detail_id: detailId,
            order_code: orderCode
        }, function(res) {
            if (res.success) {
                // Ubah border card menjadi kuning/warning
                card.removeClass("border-primary border-success").addClass("border-warning");

                // Ubah badge status menjadi Diproses
                card.find(".status-badge-container").html(`
                    <span class="badge bg-soft-warning text-warning rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-spinner fa-spin me-1"></i> Diproses
                    </span>
                `);

                // Ubah tombol Mulai Proses menjadi Selesai Proses
                card.find(".action-button-container").find(".btn-mulai-proses").replaceWith(`
                    <button type="button" class="btn btn-xs btn-success rounded-pill px-3 py-1 btn-selesai-proses shadow-sm" data-id="${detailId}">
                        <i class="fas fa-check me-1"></i> Selesai Proses
                    </button>
                `);
            } else {
                alert("Gagal memproses pemeriksaan.");
                btn.prop("disabled", false).html('<i class="fas fa-play me-1"></i> Mulai Proses');
            }
        }).fail(function() {
            alert("Terjadi kesalahan pada server.");
            btn.prop("disabled", false).html('<i class="fas fa-play me-1"></i> Mulai Proses');
        });
    });

    // Event Handler Selesai Proses Handling (Tanpa Reload & Unlock Form)
    $(document).on("click", ".btn-selesai-proses", function(e) {
        e.preventDefault();
        var btn = $(this);
        var detailId = btn.data("id");
        var card = btn.closest(".item-pemeriksaan-card");

        btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyelesaikan...');

        $.post("{{ route('radiologi.selesai_handling') }}", {
            _token: "{{ csrf_token() }}",
            detail_id: detailId
        }, function(res) {
            if (res.success) {
                // Ubah border card menjadi hijau/success
                card.removeClass("border-primary border-warning").addClass("border-success");

                // Ubah badge status menjadi Selesai
                card.find(".status-badge-container").html(`
                    <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-check-circle me-1"></i> Selesai
                    </span>
                `);

                // Tampilkan durasi pengerjaan jika dikembalikan dari server
                if (res.durasi) {
                    card.find(".durasi-badge-wrapper").html(`
                        <br><span class="badge bg-light text-dark fs--2 border mt-1"><i class="fas fa-stopwatch text-warning me-1"></i> Durasi: <span class="durasi-val">${res.durasi}</span> Menit</span>
                    `);
                }

                // Ubah tombol Selesai Proses menjadi badge Siap Diisi
                card.find(".action-button-container").find(".btn-selesai-proses").replaceWith(`
                    <span class="badge bg-soft-success text-success fs--2 px-2 py-1"><i class="fas fa-check-double"></i> Siap Diisi</span>
                `);

                // Aktifkan form tab ekspertise yang sesuai jika item ini sedang aktif atau dibuka
                // (Otomatis membuka kunci form input ekspertise di sebelah kanan)
                location.reload(); // Opsional jika ingin merefresh bagian form input ekspertise agar terbuka kuncinya secara instan.
            } else {
                alert("Gagal menyelesaikan pemeriksaan.");
                btn.prop("disabled", false).html('<i class="fas fa-check me-1"></i> Selesai Proses');
            }
        }).fail(function() {
            alert("Terjadi kesalahan pada server.");
            btn.prop("disabled", false).html('<i class="fas fa-check me-1"></i> Selesai Proses');
        });
    });
</script>

<!-- CEK STATUS PEMBAYARAN PADA TRANSAKSI UTAMA -->
@if(in_array($data->status_pembayaran, ['LUNAS', 'SEBAGIAN']))

<!-- CONTAINER UTAMA FOTO RADIOLOGI & FORM EKSPERTISE -->
<div class="row g-3 mb-4">
    <!-- KOLOM KIRI: CITRA RADIOLOGI PACS ORTHANC -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-dark text-white p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-x-ray text-info fs-0"></i>
                        <h6 class="mb-0 text-white fw-bold fs--1">Citra Radiologi PACS Orthanc</h6>
                        <span class="badge bg-info text-dark fw-bold fs--2 rounded-pill px-2">{{ count($pemeriksaanList) }} Item</span>
                    </div>
                    <button id="btn-fetch-orthanc" type="button" class="btn btn-xs btn-outline-light rounded-pill px-2.5 py-1 fs--2">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
                <div class="border-top border-secondary border-opacity-50 pt-2 mt-2 d-flex align-items-center justify-content-between">
                    <span class="text-white-50 fs--2 fw-semibold"><i class="fas fa-desktop text-info me-1"></i> Buka Full DICOM Viewer:</span>
                    <div class="dropdown" id="container-ohif-dropdown">
                        <button class="btn btn-sm btn-info text-dark fw-bold dropdown-toggle px-3 py-1 fs--2 rounded-2 shadow-sm" type="button" id="dropdownOhifMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-external-link-alt me-1"></i> Pilih OHIF Viewer
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-1 fs--1 mt-1" aria-labelledby="dropdownOhifMenu" id="container-ohif-buttons" style="min-width: 250px;">
                            @forelse($pemeriksaanList as $index => $item)
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between text-dark link-ohif-item" href="#" target="_blank" data-code="{{ $item->order_rad_list_code }}">
                                    <span class="fs--1 text-dark"><i class="fas fa-file-medical-alt text-primary me-2"></i> OHIF: <strong>{{ $item->nama_pemeriksaan }}</strong></span>
                                    <i class="fas fa-external-link-alt text-muted fs--2 ms-2"></i>
                                </a>
                            </li>
                            @if(!$loop->last)<li>
                                <hr class="dropdown-divider my-0 opacity-25">
                            </li>@endif
                            @empty
                            <li><span class="dropdown-item disabled text-muted fs--2 text-center py-2">Tidak ada link viewer</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-3 bg-light" style="max-height: 500px; overflow-y: auto;">
                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3 fs--1 p-2 rounded-3 shadow-sm" role="alert">
                    <div class="d-flex align-items-center"><i class="fas fa-exclamation-triangle me-2 fs-0"></i><span id="orthanc-alert-text"></span></div>
                    <button type="button" class="btn-close py-2" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                </div>
                <div id="orthanc-loader" class="text-center py-5">
                    <div class="spinner-border text-info" role="status" style="width: 2.2rem; height: 2.2rem;"><span class="visually-hidden">Loading DICOM...</span></div>
                    <p class="text-muted mt-2 fs--1 mb-0">Mengambil citra dari PACS Orthanc...</p>
                </div>
                <div id="orthanc-gallery" class="row g-2 d-none"></div>
                <div id="orthanc-empty" class="text-center py-4 bg-white rounded border d-none">
                    <i class="fas fa-file-medical-alt fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0 fs--1" id="orthanc-empty-text">Belum ada foto/citra radiologi yang diunggah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM EKSPERTISE -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-primary text-white p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 text-white fw-bold fs--1"><i class="fas fa-file-signature me-2"></i> Pengisian Ekspertise / Hasil</h6>
                    <span class="badge bg-white text-primary fw-bold px-2 py-1 fs--2">{{ count($pemeriksaanList) }} Pemeriksaan</span>
                </div>
                @if(count($pemeriksaanList) > 1)
                <div class="border-top border-white border-opacity-25 pt-2 mt-2">
                    <ul class="nav nav-pills card-header-pills gap-1" id="ekspertiseTab" role="tablist">
                        @foreach($pemeriksaanList as $index => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm py-1 px-3 fw-bold fs--2 custom-tab-btn {{ $index === 0 ? 'active' : '' }} {{ !$item->is_ready ? 'disabled opacity-50' : '' }}"
                                id="tab-item-{{ $index }}" data-bs-toggle="tab" data-bs-target="#content-item-{{ $index }}" type="button" role="tab"
                                @if(!$item->is_ready) disabled tabindex="-1" aria-disabled="true" @endif>
                                <i class="fas {{ !$item->is_ready ? 'fa-lock' : 'fa-x-ray' }} me-1"></i> {{ $item->nama_pemeriksaan }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="card-body p-3">
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div><strong>Peringatan:</strong> Citra/foto radiologi belum diunggah. Ekspertise belum dapat diisi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php $totalParams = count($item->parameters); @endphp
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling atau pembayaran untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum selesai/lunas. Form terkunci.</div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="{{ route('menu_radiologi_handling_pasien_simpan_hasil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="order_rad_list_code" value="{{ $item->order_rad_list_code }}">
                            <input type="hidden" name="t_pemeriksaan_list_code" value="{{ $item->t_pemeriksaan_list_code }}">

                            <div class="d-flex align-items-center justify-content-between p-2 mb-3 bg-light rounded-2 border">
                                <span class="fs--1 fw-bold text-dark"><i class="fas fa-stethoscope text-primary me-1"></i> {{ $item->nama_pemeriksaan }}</span>
                                <span class="badge bg-soft-primary text-primary font-monospace fs--2">{{ $item->t_pemeriksaan_list_code ?? '-' }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold fs--1 text-secondary mb-1">Dokter Pemeriksa / Radiolog</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="dokter_radiologi" value="{{ auth()->user()->name ?? 'Dr. Radiologi' }}" readonly>
                            </div>

                            <div class="border rounded-2 p-2 mb-3 bg-white">
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-1">
                                    <h6 class="fs--1 fw-bold text-dark mb-0"><i class="fas fa-list-check me-1 text-primary"></i> Parameter Hasil Pemeriksaan</h6>
                                    <span class="badge bg-light text-secondary fs--2 border">{{ $totalParams }} Parameter</span>
                                </div>

                                @forelse($item->parameters as $valIndex => $val)
                                @php
                                $optType = strtolower($val->t_pem_list_val_opt ?? 'textarea');
                                $computedRows = (!empty($val->t_pem_list_val_kali) && is_numeric($val->t_pem_list_val_kali)) ? (int)$val->t_pem_list_val_kali : ($totalParams <= 1 ? 6 : ($totalParams==2 ? 4 : 3));

                                    // Ambil nilai tersimpan
                                    $savedResult=\DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', $val->t_pem_list_val_code)->value('h_reg_rad_value');
                                    $currentValue = $savedResult ?? $val->t_pem_list_val_nilai ?? '';
                                    @endphp

                                    <div class="mb-3 p-2 border-bottom last-border-0">
                                        <label class="form-label fw-bold fs--1 text-dark mb-1 d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-angle-right text-primary me-1 fs--2"></i> {{ $val->t_pem_list_val_name }} <span class="text-danger">*</span></span>
                                            <div>
                                                @if(!empty($val->t_pem_list_val_satuan))<span class="badge bg-soft-secondary text-secondary fw-normal fs--2 me-1">{{ $val->t_pem_list_val_satuan }}</span>@endif
                                                @if($optType != 'select' && $optType != 'option' && $optType != 'text' && $optType != 'input' && $optType != 'string')
                                                <!-- TOMBOL BUKA MODAL EDITOR -->
                                                <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 btn-open-editor" data-target="#textarea-{{ $val->t_pem_list_val_code }}" data-title="{{ $val->t_pem_list_val_name }}" {{ !$item->is_ready ? 'disabled' : '' }} title="Perbesar Teks Editor">
                                                    <i class="fas fa-expand-arrows-alt"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </label>
                                        <input type="hidden" name="results[{{ $valIndex }}][t_pem_list_val_code]" value="{{ $val->t_pem_list_val_code }}">

                                        @if(($optType == 'select' || $optType == 'option') && !empty($val->t_pem_list_val_opt_code))
                                        <select name="results[{{ $valIndex }}][nilai]" class="form-select form-select-sm" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                            <option value="">-- Pilih {{ $val->t_pem_list_val_name }} --</option>
                                            @foreach(explode(',', $val->t_pem_list_val_opt_code) as $opt)
                                            <option value="{{ trim($opt) }}" {{ $currentValue == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                            @endforeach
                                        </select>
                                        @elseif($optType == 'text' || $optType == 'input' || $optType == 'string')
                                        <input type="text" class="form-control form-control-sm" name="results[{{ $valIndex }}][nilai]" placeholder="Masukkan hasil..." value="{{ $currentValue }}" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                        @else
                                        <!-- TEXTAREA DENGAN ID KHUSUS -->
                                        <textarea id="textarea-{{ $val->t_pem_list_val_code }}" class="form-control form-control-sm field-ekspertise" name="results[{{ $valIndex }}][nilai]" rows="{{ $computedRows }}" placeholder="Ketik deskripsi hasil..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $currentValue }}</textarea>
                                        @endif

                                        @if(!empty($val->t_pem_list_val_rujukan))
                                        <div class="form-text fs--2 mt-1 text-muted"><i class="fas fa-info-circle me-1"></i> Nilai Rujukan: <code>{{ $val->t_pem_list_val_rujukan }}</code></div>
                                        @endif
                                    </div>
                                    @empty
                                    @php $fallbackResult = \DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', 'DEFAULT')->value('h_reg_rad_value'); @endphp
                                    <div class="mb-3">
                                        <label class="form-label fw-bold fs--1 text-secondary mb-1 d-flex justify-content-between align-items-center">
                                            <span>Hasil Pemeriksaan / Deskripsi <span class="text-danger">*</span></span>
                                            <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 btn-open-editor" data-target="#textarea-fallback-{{ $index }}" data-title="{{ $item->nama_pemeriksaan }}" {{ !$item->is_ready ? 'disabled' : '' }}>
                                                <i class="fas fa-expand-arrows-alt"></i>
                                            </button>
                                        </label>
                                        <textarea id="textarea-fallback-{{ $index }}" class="form-control field-ekspertise" name="hasil_ekspertise" rows="5" placeholder="Ketik hasil ekspertise..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $fallbackResult ?? '' }}</textarea>
                                    </div>
                                    @endforelse
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm btn-success px-3 btn-save-ekspertise shadow-sm" {{ !$item->is_ready ? 'disabled' : '' }}>
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

<!-- MODAL EDITOR LAYAR PENUH (FULL SCREEN TEXT EDITOR) -->
<div class="modal fade" id="modal-text-editor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title fs-0 fw-bold"><i class="fas fa-edit me-2"></i> <span id="editor-title">Editor Ekspertise</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Textarea Super Besar -->
                <textarea id="large-textarea-input" class="form-control border-0 rounded-0" style="height: 60vh; font-size: 1.1rem; line-height: 1.6; padding: 20px; resize: none;"></textarea>
            </div>
            <div class="modal-footer bg-light py-2">
                <span class="text-muted fs--2 me-auto"><i class="fas fa-info-circle me-1"></i> Teks akan tersimpan ke form saat Anda klik 'Terapkan'</span>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm btn-primary px-4 fw-bold" id="btn-apply-editor">Terapkan & Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL EDITOR TEXT -->
<script>
    $(document).ready(function() {
        var currentTargetId = ''; // Menyimpan ID textarea asli yang sedang diedit

        // Saat tombol Expand (Panah besar) diklik
        $(document).on('click', '.btn-open-editor', function(e) {
            e.preventDefault();

            currentTargetId = $(this).data('target'); // Contoh: #textarea-VAL123
            var title = $(this).data('title'); // Contoh: Cor / Pulmo

            // Ambil teks dari form asli
            var currentText = $(currentTargetId).val();

            // Set judul dan isi textarea di dalam modal
            $('#editor-title').text('Editor Ekspertise: ' + title);
            $('#large-textarea-input').val(currentText);

            // Tampilkan Modal Bootstrap
            var editorModal = new bootstrap.Modal(document.getElementById('modal-text-editor'));
            editorModal.show();

            // Fokus otomatis ke textarea besar
            setTimeout(function() {
                $('#large-textarea-input').focus();
            }, 500);
        });

        // Saat tombol 'Terapkan' diklik di dalam modal
        $('#btn-apply-editor').on('click', function() {
            var updatedText = $('#large-textarea-input').val(); // Ambil teks dari editor besar

            // Kembalikan teks ke form aslinya
            if (currentTargetId) {
                $(currentTargetId).val(updatedText);
            }

            // Tutup Modal
            var editorModal = bootstrap.Modal.getInstance(document.getElementById('modal-text-editor'));
            editorModal.hide();
        });
    });
</script>

<!-- LIGHTBOX MODAL (UNTUK GAMBAR DICOM) -->
<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <button type="button" class="btn-close btn-close-white ms-auto m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                <div class="container-fluid p-0 w-100 h-100 d-flex align-items-center justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

@else
<div class="card rad-card mb-4 border-danger">
    <div class="card-body p-5 text-center">
        <div class="avatar avatar-4xl bg-soft-danger text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"><i class="fas fa-lock fs-2"></i></div>
        <h4 class="fw-bold text-danger">Hasil Belum Dapat Diakses</h4>
        <p class="text-muted mb-3" style="max-width: 500px; margin: 0 auto;">Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.</p>
        <span class="badge bg-danger px-3 py-2 fs-0">Status: Belum Lunas</span>
    </div>
</div>
@endif
