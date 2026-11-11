<!-- CARD PROFIL PASIEN & DAFTAR PEMERIKSAAN -->
<div class="row g-3 mb-2">
    <!-- CARD KIRI: IDENTITAS PASIEN -->
    <div class="col-lg-6">
        <div class="card retro-card h-100">
            <div class="card-header text-dark fw-bolder py-2" style="background-color: var(--retro-cyan); border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bolder text-dark fs--1"><i class="fas fa-user-injured me-2"></i> Identitas Pasien</h6>
                    <span class="badge bg-white text-dark border border-dark rounded-2 fw-bold px-2 py-1">Radiologi</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom border-dark" style="border-bottom-width: 2px !important;">
                    <!-- Ukuran wrapper disesuaikan menjadi standar (50px) -->
                    <div class="patient-avatar-wrapper flex-shrink-0" style="width: 50px; height: 50px;">
                        <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                            class="patient-avatar rounded-circle shadow-sm"
                            alt="Foto Pasien" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                    </div>
                    <div>
                        <h5 class="fw-bolder mb-1 text-dark fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="badge bg-white text-dark border border-dark fw-bold fs--1 shadow-sm">RM: {{ $data->master_patient_code }}</span>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-id-card text-dark me-1"></i> NIK</div>
                            <div class="info-value text-truncate">{{ $data->master_patient_nik ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-calendar-alt text-dark me-1"></i> Tgl Lahir</div>
                            <div class="info-value">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-venus-mars text-dark me-1"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-phone text-dark me-1"></i> No. HP</div>
                            <div class="info-value">{{ $data->master_patient_no_hp ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-map-marker-alt text-dark me-1"></i> Tempat Lahir</div>
                            <div class="info-value text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light" style="border: 2px solid var(--retro-dark);">
                            <div class="info-label"><i class="fas fa-pray text-dark me-1"></i> Agama</div>
                            <div class="info-value">{{ $data->master_patient_agama ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD KANAN: DAFTAR PEMERIKSAAN & AKSI HANDLING -->
    <div class="col-lg-6">
        <div class="card retro-card h-100">
            <div class="card-header text-dark fw-bolder py-2" style="background-color: var(--retro-yellow); border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-dark fw-bolder fs--1"><i class="fas fa-list-alt me-2"></i> Daftar Pemeriksaan Radiologi</h6>
                    <span class="badge bg-white text-dark border border-dark fw-bold">{{ count($pemeriksaanList) }} Item</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="d-flex flex-column gap-2" style="max-height: 340px; overflow-y: auto; padding-right: 4px;" id="list-pemeriksaan-container">
                    @forelse($pemeriksaanList as $index => $item)
                    @php $status = strtolower($item->status_pemeriksaan ?? 'menunggu'); @endphp

                    <div class="p border rounded-3 bg-white p-3 border-start border-4 item-pemeriksaan-card @if($status == 'selesai') border-success @elseif($status == 'proses') border-warning @else border-primary @endif" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-white text-dark border border-dark rounded-circle d-flex align-items-center justify-content-center fw-bolder shadow-sm" style="width: 26px; height: 26px; font-size: 0.75rem;">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h6 class="fw-bolder text-dark mb-0 fs--1">{{ $item->nama_pemeriksaan ?? 'Radiologi' }}</h6>
                                    <small class="text-dark fw-bold font-monospace fs--2"><i class="fas fa-hashtag text-muted me-1"></i>{{ $item->order_rad_list_code }}</small>
                                    <div class="durasi-badge-wrapper">
                                        @if(isset($item->durasi_pengerjaan_menit) && $item->durasi_pengerjaan_menit > 0)
                                        <br><span class="badge bg-white text-dark fs--2 border border-dark mt-1 fw-bold shadow-sm"><i class="fas fa-stopwatch text-dark me-1"></i> Durasi: <span class="durasi-val">{{ $item->durasi_pengerjaan_menit }}</span> Menit</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="status-badge-container">
                                @if($status == 'selesai')
                                <span class="badge bg-white text-success border border-dark rounded-2 px-2 py-1 fs--2 fw-bolder"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                @elseif($status == 'proses')
                                <span class="badge bg-white text-warning border border-dark rounded-2 px-2 py-1 fs--2 fw-bolder"><i class="fas fa-spinner fa-spin me-1"></i> Diproses</span>
                                @else
                                <span class="badge bg-white text-secondary border border-dark rounded-2 px-2 py-1 fs--2 fw-bolder"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                @endif
                            </div>
                        </div>
                        <hr class="my-2 text-dark opacity-100" style="border-top: 2px solid var(--retro-dark);" />
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-dark fw-bold fs--2">Aksi Petugas:</span>
                            <div class="d-inline-flex gap-2 action-button-container">
                                <button type="button" class="btn btn-xs btn-light border border-dark rounded-2 px-2.5 py-1 btn-print-barcode fw-bold shadow-sm" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-barcode me-1"></i> Barcode
                                </button>

                                @if($status == 'menunggu')
                                <button type="button" class="btn btn-xs btn-warning border border-dark rounded-2 px-3 py-1 btn-mulai-proses fw-bolder shadow-sm" data-id="{{ $item->detail_id }}" data-code="{{ $item->order_rad_list_code }}" style="background-color: var(--retro-yellow);">
                                    <i class="fas fa-play me-1"></i> Mulai Proses
                                </button>
                                @elseif($status == 'proses')
                                <button type="button" class="btn btn-xs btn-success border border-dark rounded-2 px-3 py-1 btn-selesai-proses fw-bolder shadow-sm" data-id="{{ $item->detail_id }}" style="background-color: var(--retro-green);">
                                    <i class="fas fa-check me-1"></i> Selesai Proses
                                </button>
                                @else
                                <span class="badge bg-white text-success border border-dark fs--2 px-2 py-1 fw-bold"><i class="fas fa-check-double"></i> Siap Diisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center border border-dark rounded-3 bg-light">
                        <p class="text-dark fw-bold mb-0 fs--1">Tidak ada rincian item pemeriksaan.</p>
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
                card.removeClass("border-primary border-success").addClass("border-warning");

                card.find(".status-badge-container").html(`
                    <span class="badge bg-white text-warning border border-dark rounded-2 px-2 py-1 fs--2 fw-bolder">
                        <i class="fas fa-spinner fa-spin me-1"></i> Diproses
                    </span>
                `);

                card.find(".action-button-container").find(".btn-mulai-proses").replaceWith(`
                    <button type="button" class="btn btn-xs btn-success border border-dark rounded-2 px-3 py-1 btn-selesai-proses fw-bolder shadow-sm" data-id="${detailId}" style="background-color: var(--retro-green);">
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
                card.removeClass("border-primary border-warning").addClass("border-success");

                card.find(".status-badge-container").html(`
                    <span class="badge bg-white text-success border border-dark rounded-2 px-2 py-1 fs--2 fw-bolder">
                        <i class="fas fa-check-circle me-1"></i> Selesai
                    </span>
                `);

                if (res.durasi) {
                    card.find(".durasi-badge-wrapper").html(`
                        <br><span class="badge bg-white text-dark fs--2 border border-dark mt-1 fw-bold shadow-sm"><i class="fas fa-stopwatch text-dark me-1"></i> Durasi: <span class="durasi-val">${res.durasi}</span> Menit</span>
                    `);
                }

                card.find(".action-button-container").find(".btn-selesai-proses").replaceWith(`
                    <span class="badge bg-white text-success border border-dark fs--2 px-2 py-1 fw-bolder"><i class="fas fa-check-double"></i> Siap Diisi</span>
                `);

                location.reload();
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
<div class="row g-3 mb-3">
    <!-- KOLOM KIRI: CITRA RADIOLOGI PACS ORTHANC -->
    <div class="col-lg-6">
        <div class="card retro-card h-100">
            <div class="card-header text-dark p-3" style="background-color: var(--retro-dark); color: #fff; border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-x-ray text-info fs-0"></i>
                        <h6 class="mb-0 text-white fw-bolder fs--1">Citra Radiologi PACS Orthanc</h6>
                        <span class="badge bg-white text-dark border border-dark fw-bold fs--2 rounded-2 px-2">{{ count($pemeriksaanList) }} Item</span>
                    </div>
                    <button id="btn-fetch-orthanc" type="button" class="btn btn-xs btn-light border border-dark rounded-2 px-2.5 py-1 fs--2 fw-bolder">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
                <div class="border-top border-secondary border-opacity-50 pt-2 mt-2 d-flex align-items-center justify-content-between">
                    <span class="text-white-50 fs--2 fw-bold"><i class="fas fa-desktop text-info me-1"></i> Buka Full DICOM Viewer:</span>
                    <div class="dropdown" id="container-ohif-dropdown">
                        <button class="btn btn-sm dropdown-toggle px-3 py-1 fs--2 rounded-2 fw-bolder shadow-sm" type="button" id="dropdownOhifMenu" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); color: var(--retro-dark);">
                            <i class="fas fa-external-link-alt me-1"></i> Pilih OHIF Viewer
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-2 border-dark py-1 fs--1 mt-1" aria-labelledby="dropdownOhifMenu" id="container-ohif-buttons" style="min-width: 250px; border-radius: 8px;">
                            @forelse($pemeriksaanList as $index => $item)
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between text-dark link-ohif-item fw-bold" href="#" target="_blank" data-code="{{ $item->order_rad_list_code }}">
                                    <span class="fs--1 text-dark"><i class="fas fa-file-medical-alt text-dark me-2"></i> OHIF: <strong>{{ $item->nama_pemeriksaan }}</strong></span>
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

            <div class="card-body p-3 bg-white" style="max-height: 500px; overflow-y: auto;">
                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3 fs--1 p-2 rounded-3 shadow-sm border border-dark" role="alert">
                    <div class="d-flex align-items-center"><i class="fas fa-exclamation-triangle me-2 fs-0"></i><span id="orthanc-alert-text"></span></div>
                    <button type="button" class="btn-close py-2" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                </div>
                <div id="orthanc-loader" class="text-center py-5">
                    <div class="spinner-border text-dark" role="status" style="width: 2.2rem; height: 2.2rem;"><span class="visually-hidden">Loading DICOM...</span></div>
                    <p class="text-dark mt-2 fs--1 mb-0 fw-bold">Mengambil citra dari PACS Orthanc...</p>
                </div>
                <div id="orthanc-gallery" class="row g-2 d-none"></div>
                <div id="orthanc-empty" class="text-center py-4 bg-light rounded border border-dark d-none">
                    <i class="fas fa-file-medical-alt fa-2x text-dark mb-2"></i>
                    <p class="text-dark mb-0 fs--1 fw-bold" id="orthanc-empty-text">Belum ada foto/citra radiologi yang diunggah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM EKSPERTISE -->
    <div class="col-lg-6">
        <div class="card retro-card h-100">
            <div class="card-header text-dark p-3" style="background-color: var(--retro-purple); border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 text-dark fw-bolder fs--1"><i class="fas fa-file-signature me-2"></i> Pengisian Ekspertise / Hasil</h6>
                    <span class="badge bg-white text-dark border border-dark fw-bolder px-2 py-1 fs--2">{{ count($pemeriksaanList) }} Pemeriksaan</span>
                </div>
                @if(count($pemeriksaanList) > 1)
                <div class="border-top border-dark border-opacity-25 pt-2 mt-2" style="border-top-width: 2px !important;">
                    <ul class="nav nav-pills card-header-pills gap-1" id="ekspertiseTab" role="tablist">
                        @foreach($pemeriksaanList as $index => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm py-1 px-3 fw-bolder fs--2 custom-tab-btn {{ $index === 0 ? 'active' : '' }} {{ !$item->is_ready ? 'disabled opacity-50' : '' }}"
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

            <div class="card-body p-3 bg-white">
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-2 border border-dark fw-bold">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div><strong>Peringatan:</strong> Citra/foto radiologi belum diunggah. Ekspertise belum dapat diisi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php $totalParams = count($item->parameters); @endphp
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-2 border border-dark fw-bold" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling atau pembayaran untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum selesai/lunas. Form terkunci.</div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="{{ route('menu_radiologi_handling_pasien_simpan_hasil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="order_rad_list_code" value="{{ $item->order_rad_list_code }}">
                            <input type="hidden" name="t_pemeriksaan_list_code" value="{{ $item->t_pemeriksaan_list_code }}">

                            <div class="d-flex align-items-center justify-content-between p-2 mb-3 bg-light rounded-2 border border-dark">
                                <span class="fs--1 fw-bolder text-dark"><i class="fas fa-stethoscope text-dark me-1"></i> {{ $item->nama_pemeriksaan }}</span>
                                <span class="badge bg-white text-dark border border-dark font-monospace fs--2 fw-bold">{{ $item->t_pemeriksaan_list_code ?? '-' }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bolder fs--1 text-dark mb-1">Dokter Pemeriksa / Radiolog</label>
                                <input type="text" class="form-control form-control-sm bg-light fw-bold" name="dokter_radiologi" value="{{ auth()->user()->name ?? 'Dr. Radiologi' }}" readonly>
                            </div>

                            <div class="border border-dark rounded-2 p-2 mb-3 bg-white shadow-sm">
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom border-dark pb-1" style="border-bottom-width: 2px !important;">
                                    <h6 class="fs--1 fw-bolder text-dark mb-0"><i class="fas fa-list-check me-1"></i> Parameter Hasil Pemeriksaan</h6>
                                    <span class="badge bg-white text-dark border border-dark fs--2 fw-bold">{{ $totalParams }} Parameter</span>
                                </div>

                                @forelse($item->parameters as $valIndex => $val)
                                @php
                                $optType = strtolower($val->t_pem_list_val_opt ?? 'textarea');
                                $computedRows = (!empty($val->t_pem_list_val_kali) && is_numeric($val->t_pem_list_val_kali)) ? (int)$val->t_pem_list_val_kali : ($totalParams <= 1 ? 6 : ($totalParams==2 ? 4 : 3));

                                    $savedResult=\DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', $val->t_pem_list_val_code)->value('h_reg_rad_value');
                                    $currentValue = $savedResult ?? $val->t_pem_list_val_nilai ?? '';
                                    @endphp

                                    <div class="mb-3 p-2 border-bottom border-dark last-border-0">
                                        <label class="form-label fw-bolder fs--1 text-dark mb-1 d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-angle-right text-dark me-1 fs--2"></i> {{ $val->t_pem_list_val_name }} <span class="text-danger">*</span></span>
                                            <div>
                                                @if(!empty($val->t_pem_list_val_satuan))<span class="badge bg-white text-dark border border-dark fw-bold fs--2 me-1">{{ $val->t_pem_list_val_satuan }}</span>@endif
                                                @if($optType != 'select' && $optType != 'option' && $optType != 'text' && $optType != 'input' && $optType != 'string')
                                                <button type="button" class="btn btn-xs btn-light border border-dark py-0 px-2 btn-open-editor fw-bold shadow-sm" data-target="#textarea-{{ $val->t_pem_list_val_code }}" data-title="{{ $val->t_pem_list_val_name }}" {{ !$item->is_ready ? 'disabled' : '' }} title="Perbesar Teks Editor">
                                                    <i class="fas fa-expand-arrows-alt"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </label>
                                        <input type="hidden" name="results[{{ $valIndex }}][t_pem_list_val_code]" value="{{ $val->t_pem_list_val_code }}">

                                        @if(($optType == 'select' || $optType == 'option') && !empty($val->t_pem_list_val_opt_code))
                                        <select name="results[{{ $valIndex }}][nilai]" class="form-select form-select-sm fw-bold" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                            <option value="">-- Pilih {{ $val->t_pem_list_val_name }} --</option>
                                            @foreach(explode(',', $val->t_pem_list_val_opt_code) as $opt)
                                            <option value="{{ trim($opt) }}" {{ $currentValue == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                            @endforeach
                                        </select>
                                        @elseif($optType == 'text' || $optType == 'input' || $optType == 'string')
                                        <input type="text" class="form-control form-control-sm fw-bold" name="results[{{ $valIndex }}][nilai]" placeholder="Masukkan hasil..." value="{{ $currentValue }}" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                        @else
                                        <textarea id="textarea-{{ $val->t_pem_list_val_code }}" class="form-control form-control-sm field-ekspertise fw-bold" name="results[{{ $valIndex }}][nilai]" rows="{{ $computedRows }}" placeholder="Ketik deskripsi hasil..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $currentValue }}</textarea>
                                        @endif

                                        @if(!empty($val->t_pem_list_val_rujukan))
                                        <div class="form-text fs--2 mt-1 text-dark fw-bold"><i class="fas fa-info-circle me-1"></i> Nilai Rujukan: <code>{{ $val->t_pem_list_val_rujukan }}</code></div>
                                        @endif
                                    </div>
                                    @empty
                                    @php $fallbackResult = \DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', 'DEFAULT')->value('h_reg_rad_value'); @endphp
                                    <div class="mb-3">
                                        <label class="form-label fw-bolder fs--1 text-dark mb-1 d-flex justify-content-between align-items-center">
                                            <span>Hasil Pemeriksaan / Deskripsi <span class="text-danger">*</span></span>
                                            <button type="button" class="btn btn-xs btn-light border border-dark py-0 px-2 btn-open-editor fw-bold shadow-sm" data-target="#textarea-fallback-{{ $index }}" data-title="{{ $item->nama_pemeriksaan }}" {{ !$item->is_ready ? 'disabled' : '' }}>
                                                <i class="fas fa-expand-arrows-alt"></i>
                                            </button>
                                        </label>
                                        <textarea id="textarea-fallback-{{ $index }}" class="form-control field-ekspertise fw-bold" name="hasil_ekspertise" rows="5" placeholder="Ketik hasil ekspertise..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $fallbackResult ?? '' }}</textarea>
                                    </div>
                                    @endforelse
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm btn-success px-4 btn-save-ekspertise fw-bolder shadow-sm" style="background-color: var(--retro-green); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);" {{ !$item->is_ready ? 'disabled' : '' }}>
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
        <div class="modal-content border-2 border-dark shadow-lg rounded-3 overflow-hidden">
            <div class="modal-header py-2" style="background-color: var(--retro-cyan); border-bottom: 2px solid var(--retro-dark);">
                <h5 class="modal-title fs-0 fw-bolder text-dark"><i class="fas fa-edit me-2"></i> <span id="editor-title">Editor Ekspertise</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <textarea id="large-textarea-input" class="form-control border-0 rounded-0 fw-bold" style="height: 60vh; font-size: 1.1rem; line-height: 1.6; padding: 20px; resize: none;"></textarea>
            </div>
            <div class="modal-footer bg-light py-2 border-top border-dark" style="border-top-width: 2px !important;">
                <span class="text-dark fw-bold fs--2 me-auto"><i class="fas fa-info-circle me-1"></i> Teks akan tersimpan ke form saat Anda klik 'Terapkan'</span>
                <button type="button" class="btn btn-sm btn-light border border-dark fw-bold shadow-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm btn-primary px-4 fw-bolder shadow-sm" id="btn-apply-editor" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 2px solid var(--retro-dark);">Terapkan & Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL EDITOR TEXT -->
<script>
    $(document).ready(function() {
        var currentTargetId = '';

        $(document).on('click', '.btn-open-editor', function(e) {
            e.preventDefault();
            currentTargetId = $(this).data('target');
            var title = $(this).data('title');
            var currentText = $(currentTargetId).val();

            $('#editor-title').text('Editor Ekspertise: ' + title);
            $('#large-textarea-input').val(currentText);

            var editorModal = new bootstrap.Modal(document.getElementById('modal-text-editor'));
            editorModal.show();

            setTimeout(function() {
                $('#large-textarea-input').focus();
            }, 500);
        });

        $('#btn-apply-editor').on('click', function() {
            var updatedText = $('#large-textarea-input').val();
            if (currentTargetId) {
                $(currentTargetId).val(updatedText);
            }
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
<div class="card retro-card mb-3" style="border: 2px solid var(--retro-pink);">
    <div class="card-body p-5 text-center">
        <div class="avatar avatar-4xl rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold" style="width: 70px; height: 70px; background-color: var(--retro-pink); border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);"><i class="fas fa-lock fs-2 text-dark"></i></div>
        <h4 class="fw-bolder text-dark">Hasil Belum Dapat Diakses</h4>
        <p class="text-dark fw-bold mb-3 opacity-75" style="max-width: 500px; margin: 0 auto;">Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.</p>
        <span class="badge bg-white text-dark border border-dark px-3 py-2 fs-0 fw-bolder shadow-sm">Status: Belum Lunas</span>
    </div>
</div>
@endif
