@php
$canAccessVerification = !empty($hasAnyPaidItem) || in_array(strtoupper($data->status_pembayaran ?? ''), ['LUNAS', 'SEBAGIAN']);
$resolvedFallbackDicom = $fallbackDicomUrl ?? asset('dicom/data.dcm');
@endphp

<!-- HEADER UTAMA VERIFIKASI & EKSPERTISE RADIOLOGI -->
<div class="row g-3 mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 text-white position-relative" style="z-index: 2;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ent-glass-pill d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px;">
                            <i class="fas fa-file-medical-alt fs-5 text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.28); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-radiation me-1"></i> Radiologi
                                </span>
                                @if(!empty($data->no_registrasi))
                                <span class="code-chip" style="background: rgba(255,255,255,0.12); color: #fff; border-color: rgba(255,255,255,0.25);">
                                    REG: {{ $data->no_registrasi }}
                                </span>
                                @endif
                                @if(!empty($code))
                                <span class="code-chip code-chip-cyan">
                                    CODE: {{ $code }}
                                </span>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Verifikasi &amp; Pengisian Ekspertise Hasil Radiologi
                            </h5>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if($canAccessVerification)
                        <span class="ent-badge px-3 py-2" style="background: rgba(5, 150, 105, 0.22); color: #6ee7b7; border: 1px solid rgba(5, 150, 105, 0.45);">
                            <i class="fas fa-check-circle me-1"></i> {{ $data->status_pembayaran ?? 'TERBAYAR' }}
                        </span>
                        @else
                        <span class="ent-badge px-3 py-2" style="background: rgba(225, 29, 72, 0.22); color: #fda4af; border: 1px solid rgba(225, 29, 72, 0.45);">
                            <i class="fas fa-times-circle me-1"></i> {{ $data->status_pembayaran ?? 'LUNAS' }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CARD PROFIL PASIEN -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card ent-card h-100">
            <div class="ent-card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold fs--1"><i class="fas fa-user-injured me-2 text-primary"></i> Identitas Pasien</h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.35);">Ekspertise Radiologi</span>
                </div>
            </div>
            <div class="card-body ent-table-surface p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <div class="patient-avatar-wrapper flex-shrink-0" style="width: 50px; height: 50px;">
                            <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                                class="rounded-circle"
                                alt="Foto Pasien" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--ent-grid-border);">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3" style="border-right: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold mb-1 fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="ent-badge mb-2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35); font-family: 'JetBrains Mono', monospace;">RM: {{ $data->master_patient_code }}</span>
                        <div class="d-flex flex-column gap-1">
                            <span class="fs--2 fw-semibold opacity-75"><i class="fas fa-id-card text-primary me-1"></i> {{ $data->master_patient_nik ?? '-' }}</span>
                            <span class="fs--2 fw-semibold opacity-75"><i class="fas fa-venus-mars text-primary me-1"></i> {{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</span>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8">
                        <div class="row g-2">
                            <div class="col-sm-4">
                                <div class="p-2 rounded h-100" style="border: 1px solid var(--ent-grid-border); background: rgba(79, 70, 229, 0.04);">
                                    <div class="ent-field-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tgl Lahir</div>
                                    <div class="fs--1 fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 rounded h-100" style="border: 1px solid var(--ent-grid-border); background: rgba(79, 70, 229, 0.04);">
                                    <div class="ent-field-label"><i class="fas fa-phone text-primary me-1"></i> No. HP</div>
                                    <div class="fs--1 fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $data->master_patient_no_hp ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 rounded h-100" style="border: 1px solid var(--ent-grid-border); background: rgba(79, 70, 229, 0.04);">
                                    <div class="ent-field-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</div>
                                    <div class="fs--1 fw-bold text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CEK STATUS PEMBAYARAN TRANSAKSI / ITEM -->
@if($canAccessVerification)

<!-- CONTAINER UTAMA FOTO RADIOLOGI & FORM EKSPERTISE -->
<div class="row g-3 mb-4 align-items-stretch">
    <!-- KOLOM KIRI: CITRA RADIOLOGI PACS ORTHANC -->
    <div class="col-lg-6">
        <div class="card ent-card h-100">
            <div class="ent-card-header p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <i class="fas fa-x-ray text-primary fs-0"></i>
                        <h6 class="mb-0 fw-bold fs--1">Citra Radiologi PACS Orthanc</h6>
                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.35);">{{ count($pemeriksaanList) }} Item</span>
                    </div>
                    <button id="btn-fetch-orthanc" type="button" class="btn btn-sm ent-btn ent-btn-reset px-2.5 py-1 fs--2 flex-shrink-0">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
                <div class="pt-2 mt-2 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 1px dashed var(--ent-grid-border);">
                    <span class="opacity-75 fs--2 fw-semibold"><i class="fas fa-desktop text-primary me-1"></i> Buka Full DICOM Viewer:</span>
                    <div class="dropdown" id="container-ohif-dropdown">
                        <button class="btn btn-sm ent-btn ent-btn-primary dropdown-toggle px-3 py-1 fs--2" type="button" id="dropdownOhifMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-external-link-alt me-1"></i> Pilih OHIF Viewer
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end ent-dropdown-menu py-1 fs--1 mt-1" aria-labelledby="dropdownOhifMenu" id="container-ohif-buttons" style="min-width: 250px;">
                            @forelse($pemeriksaanList as $index => $item)
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between link-ohif-item fw-semibold" href="#" target="_blank" data-code="{{ $item->order_rad_list_code }}" data-fallback-dicom="{{ $resolvedFallbackDicom }}">
                                    <span class="fs--1"><i class="fas fa-file-medical-alt text-primary me-2"></i> OHIF: <strong>{{ $item->nama_pemeriksaan }}</strong></span>
                                    <i class="fas fa-external-link-alt opacity-50 fs--2 ms-2"></i>
                                </a>
                            </li>
                            @if(!$loop->last)<li>
                                <hr class="dropdown-divider my-0 opacity-25">
                            </li>@endif
                            @empty
                            <li><span class="dropdown-item disabled opacity-50 fs--2 text-center py-2">Tidak ada link viewer</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-3 ent-table-surface" style="max-height: 640px; overflow-y: auto;">
                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3 fs--1 p-2 rounded-3" role="alert" style="border: 1px solid rgba(225, 29, 72, 0.35);">
                    <div class="d-flex align-items-center"><i class="fas fa-exclamation-triangle me-2 fs-0"></i><span id="orthanc-alert-text"></span></div>
                    <button type="button" class="btn-close py-2" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                </div>
                <div id="orthanc-loader" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;"><span class="visually-hidden">Loading DICOM...</span></div>
                    <p class="mt-2 fs--1 mb-0 fw-semibold opacity-75">Mengambil citra dari PACS Orthanc...</p>
                </div>
                <div id="orthanc-gallery" class="row g-2 d-none"></div>

                <!-- CARD RENDER OTOMATIS FILE DICOM DEFAULT (TANPA TOMBOL KLIK) -->
                <div id="orthanc-empty" class="d-none">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35);">
                            <i class="fas fa-file-medical me-1"></i> Otomatis: public/dicom/data.dcm
                        </span>
                        <div class="d-inline-flex gap-1">
                            <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#card-dicom-viewport" data-action="zoom-in" title="Perbesar">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#card-dicom-viewport" data-action="zoom-out" title="Perkecil">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#card-dicom-viewport" data-action="invert" title="Invert Warna">
                                <i class="fas fa-adjust"></i>
                            </button>
                            <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#card-dicom-viewport" data-action="reset" title="Reset Tampilan">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                        <span id="card-dicom-status" class="opacity-75 fw-semibold fs--2">Memproses data.dcm...</span>
                    </div>

                    <div id="card-dicom-alert" class="alert alert-danger d-none fs--1 p-2 rounded-3 mb-2" role="alert"></div>

                    <div class="dicom-viewport-wrap mb-3" style="position: relative; background-color: #020617; border: 1px solid rgba(99, 102, 241, 0.35); border-radius: 12px; width: 100%; height: 360px; overflow: hidden;">
                        <div id="card-dicom-viewport" style="width: 100%; height: 100%;" oncontextmenu="return false"></div>
                    </div>

                    <div class="row g-2" id="card-dicom-metadata"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM EKSPERTISE -->
    <div class="col-lg-6">
        <div class="card ent-card h-100">
            <div class="ent-card-header p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <h6 class="mb-0 fw-bold fs--1"><i class="fas fa-file-signature me-2 text-primary"></i> Pengisian Ekspertise / Hasil</h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.35);">{{ count($pemeriksaanList) }} Pemeriksaan</span>
                </div>
                @if(count($pemeriksaanList) > 1)
                <div class="pt-2 mt-2" style="border-top: 1px dashed var(--ent-grid-border);">
                    <ul class="nav nav-pills card-header-pills gap-1" id="ekspertiseTab" role="tablist">
                        @foreach($pemeriksaanList as $index => $item)
                        @php $itemPaid = isset($item->is_paid) ? $item->is_paid : true; @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm py-1 px-3 fw-semibold fs--2 custom-tab-btn {{ $index === 0 ? 'active' : '' }} {{ (!$item->is_ready || !$itemPaid) ? 'disabled opacity-50' : '' }}"
                                id="tab-item-{{ $index }}" data-bs-toggle="tab" data-bs-target="#content-item-{{ $index }}" type="button" role="tab"
                                @if(!$item->is_ready || !$itemPaid) disabled tabindex="-1" aria-disabled="true" @endif>
                                <i class="fas {{ (!$item->is_ready || !$itemPaid) ? 'fa-lock' : 'fa-x-ray' }} me-1"></i> {{ $item->nama_pemeriksaan }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="card-body p-3 ent-table-surface" style="max-height: 640px; overflow-y: auto;">
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold" style="border: 1px solid rgba(217, 119, 6, 0.35);">
                    <i class="fas fa-exclamation-triangle me-2 fs-0 text-warning"></i>
                    <div><strong>Perhatian:</strong> Citra/foto radiologi belum termuat secara sempurna. Pastikan DICOM telah diunggah sebelum memverifikasi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php
                    $totalParams = isset($item->parameters) ? count($item->parameters) : 0;
                    $header = $item->saved_header;
                    $itemPaid = isset($item->is_paid) ? $item->is_paid : true;
                    $isLocked = (!$itemPaid || !$item->is_ready || $item->is_verified);
                    @endphp

                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$itemPaid)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Pembayaran item <strong>{{ $item->nama_pemeriksaan }}</strong> masih <strong>{{ $item->status_pembayaran ?? 'BELUM LUNAS' }}</strong>. Form terkunci.</div>
                        </div>
                        @elseif(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum diproses oleh petugas radiografer. Form terkunci.</div>
                        </div>
                        @elseif($item->is_verified)
                        <div class="alert alert-success d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);">
                            <i class="fas fa-check-circle me-2 fs-0"></i>
                            <div>Ekspertise ini telah diverifikasi final pada <strong>{{ !empty($header->tanggal_verifikasi) ? date('d-m-Y H:i', strtotime($header->tanggal_verifikasi)) : '-' }}</strong>. Data telah dikunci.</div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="{{ route('menu_radiologi_handling_pasien_simpan_hasil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="transaksi_detail_id" value="{{ $item->detail_id }}">
                            <input type="hidden" name="order_rad_list_code" value="{{ $item->order_rad_list_code }}">
                            <input type="hidden" name="t_pemeriksaan_list_code" value="{{ $item->t_pemeriksaan_list_code }}">

                            <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded-3" style="border: 1px solid var(--ent-grid-border); background: rgba(79, 70, 229, 0.05);">
                                <div>
                                    <span class="fs--1 fw-bold"><i class="fas fa-stethoscope text-primary me-1"></i> {{ $item->nama_pemeriksaan }}</span>
                                    <span class="ent-badge ms-1" style="{{ $itemPaid ? 'background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);' : 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);' }}">
                                        {{ $item->status_pembayaran ?? 'LUNAS' }}
                                    </span>
                                </div>
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border); font-family: 'JetBrains Mono', monospace;">{{ $item->t_pemeriksaan_list_code ?? '-' }}</span>
                            </div>

                            <div class="mb-3 row g-2">
                                <div class="col-md-6">
                                    <label class="ent-field-label">Klinis / Indikasi</label>
                                    <input type="text" class="form-control ent-input form-control-sm" name="klinis_indikasi" value="{{ $header->klinis_indikasi ?? '' }}" placeholder="Ketik indikasi..." {{ $isLocked ? 'disabled readonly' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <label class="ent-field-label">Teknik Pemeriksaan</label>
                                    <input type="text" class="form-control ent-input form-control-sm" name="teknik_pemeriksaan" value="{{ $header->teknik_pemeriksaan ?? '' }}" placeholder="Contoh: AP / Lateral" {{ $isLocked ? 'disabled readonly' : '' }}>
                                </div>
                            </div>

                            <div class="rounded-3 p-2 mb-3 ent-table-surface" style="border: 1px solid var(--ent-grid-border);">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                    <h6 class="fs--1 fw-bold mb-0"><i class="fas fa-list-check me-1 text-primary"></i> Detail Ekspertise</h6>
                                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">{{ $totalParams }} Parameter</span>
                                </div>

                                @forelse($item->parameters as $valIndex => $val)
                                @php
                                $optType = strtolower($val->t_pem_list_val_opt ?? 'textarea');
                                $computedRows = (!empty($val->t_pem_list_val_kali) && is_numeric($val->t_pem_list_val_kali)) ? (int)$val->t_pem_list_val_kali : 3;
                                $currentValue = $val->saved_value;
                                @endphp

                                <div class="mb-3 p-2" style="border-bottom: 1px dashed var(--ent-grid-border);">
                                    <label class="form-label fw-bold fs--1 mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-angle-right text-primary me-1 fs--2"></i> {{ $val->t_pem_list_val_name }}</span>
                                        <div class="d-flex align-items-center gap-1">
                                            @if(!empty($val->t_pem_list_val_satuan))<span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35);">{{ $val->t_pem_list_val_satuan }}</span>@endif
                                            @if($optType != 'select' && $optType != 'option' && $optType != 'text' && $optType != 'input' && $optType != 'string' && !$isLocked)
                                            <button type="button" class="btn btn-sm ent-btn ent-btn-reset py-0 px-2 btn-open-editor" data-target="#textarea-{{ $item->detail_id }}-{{ $val->t_pem_list_val_code }}" data-title="{{ $val->t_pem_list_val_name }}" title="Perbesar Teks Editor">
                                                <i class="fas fa-expand-arrows-alt"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </label>

                                    <input type="hidden" name="details[{{ $valIndex }}][parameter_code]" value="{{ $val->t_pem_list_val_code }}">
                                    <input type="hidden" name="details[{{ $valIndex }}][nama_parameter]" value="{{ $val->t_pem_list_val_name }}">

                                    @if(($optType == 'select' || $optType == 'option') && !empty($val->t_pem_list_val_opt_code))
                                    <select name="details[{{ $valIndex }}][nilai_hasil]" class="form-select ent-input form-select-sm" {{ $isLocked ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Hasil --</option>
                                        @foreach(explode(',', $val->t_pem_list_val_opt_code) as $opt)
                                        <option value="{{ trim($opt) }}" {{ $currentValue == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                        @endforeach
                                    </select>
                                    @elseif($optType == 'text' || $optType == 'input' || $optType == 'string')
                                    <input type="text" class="form-control ent-input form-control-sm" name="details[{{ $valIndex }}][nilai_hasil]" placeholder="Masukkan hasil..." value="{{ $currentValue }}" {{ $isLocked ? 'readonly disabled' : '' }}>
                                    @else
                                    <textarea id="textarea-{{ $item->detail_id }}-{{ $val->t_pem_list_val_code }}" class="form-control ent-input form-control-sm field-ekspertise" name="details[{{ $valIndex }}][nilai_hasil]" rows="{{ $computedRows }}" placeholder="Ketik deskripsi hasil..." {{ $isLocked ? 'readonly disabled' : '' }}>{{ $currentValue }}</textarea>
                                    @endif
                                </div>
                                @empty
                                <div class="text-center p-3 fw-semibold fs--2 rounded-3 mb-2 opacity-75" style="border: 1px dashed var(--ent-grid-border); background: rgba(79, 70, 229, 0.04);">
                                    Tidak ada template parameter khusus. Silakan isi kesan &amp; kesimpulan di bawah.
                                </div>
                                @endforelse

                                <div class="mb-2 mt-3 p-2 rounded-3" style="border: 1px solid rgba(2, 132, 199, 0.35); background: rgba(2, 132, 199, 0.07);">
                                    <label class="form-label fw-bold fs--1 mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-clipboard-check text-primary me-1 fs--2"></i> Kesan / Kesimpulan (Impression) <span class="text-danger">*</span></span>
                                        @if(!$isLocked)
                                        <button type="button" class="btn btn-sm ent-btn ent-btn-reset py-0 px-2 btn-open-editor" data-target="#textarea-kesan-{{ $item->detail_id }}" data-title="Kesan &amp; Kesimpulan">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </button>
                                        @endif
                                    </label>
                                    <textarea id="textarea-kesan-{{ $item->detail_id }}" class="form-control ent-input form-control-sm" name="kesan_kesimpulan" rows="5" placeholder="Ketik kesimpulan pemeriksaan radiologi di sini..." required {{ $isLocked ? 'readonly disabled' : '' }}>{{ $header->kesan_kesimpulan ?? '' }}</textarea>
                                </div>

                                <div class="mb-2 p-2">
                                    <label class="ent-field-label">Saran / Rekomendasi Tambahan (Opsional)</label>
                                    <textarea class="form-control ent-input form-control-sm" name="saran" rows="2" placeholder="Ketik saran pemeriksaan lanjutan jika ada..." {{ $isLocked ? 'readonly disabled' : '' }}>{{ $header->saran ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                @if($item->is_verified)
                                <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-4 btn-cetak-hasil" data-code="{{ $code }}" data-reg="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-print me-1"></i> Cetak Hasil
                                </button>
                                @else
                                <button type="submit" class="btn btn-sm ent-btn ent-btn-reset px-3 btn-save-ekspertise" {{ $isLocked ? 'disabled' : '' }}>
                                    <i class="fas fa-save me-1"></i> Simpan Draf
                                </button>
                                <button type="button" class="btn btn-sm ent-btn px-3 btn-verifikasi-final"
                                    data-transaksi-id="{{ $item->detail_id }}"
                                    data-code="{{ $item->order_rad_list_code }}"
                                    style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none;"
                                    {{ $isLocked ? 'disabled' : '' }}>
                                    <i class="fas fa-check-double me-1"></i> Verifikasi Final
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL READER FILE DICOM (OTOMATIS TER-RENDER SAAT MODAL DIBUKA) -->
<div class="modal fade" id="modal-dicom-viewer" tabindex="-1" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-dark-header py-3 px-4">
                <div>
                    <h6 class="modal-title fw-bold text-white mb-0">
                        <i class="fas fa-x-ray me-2 text-info"></i>
                        <span id="dicom-modal-title">DICOM Reader</span>
                    </h6>
                    <small class="text-white-50 fs--2" id="dicom-modal-file-path"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.3);">
                        <i class="fas fa-book-open me-1"></i> Auto Render Modal
                    </span>
                    <div class="d-inline-flex gap-1">
                        <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#dicom-cornerstone-element" data-action="zoom-in" title="Perbesar">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#dicom-cornerstone-element" data-action="zoom-out" title="Perkecil">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#dicom-cornerstone-element" data-action="invert" title="Invert Warna">
                            <i class="fas fa-adjust"></i>
                        </button>
                        <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-dicom-tool" data-target="#dicom-cornerstone-element" data-action="reset" title="Reset Tampilan">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                    <span id="dicom-modal-status" class="opacity-75 fw-semibold fs--2">Memproses file DICOM...</span>
                </div>
                <div id="dicom-modal-alert" class="alert alert-danger d-none fs--1 p-2 rounded-3 mb-2" role="alert"></div>
                <div class="dicom-viewport-wrap mb-3" style="position: relative; background-color: #020617; border: 1px solid rgba(99, 102, 241, 0.35); border-radius: 12px; width: 100%; height: 380px; overflow: hidden;">
                    <div id="dicom-cornerstone-element" style="width: 100%; height: 100%;" oncontextmenu="return false"></div>
                </div>
                <div class="row g-2" id="dicom-modal-metadata"></div>
            </div>
            <div class="modal-footer py-2 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn btn-sm ent-btn ent-btn-reset px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITOR LAYAR PENUH (FULL SCREEN TEXT EDITOR) -->
<div class="modal fade" id="modal-text-editor" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header py-2 ent-card-header">
                <h5 class="modal-title fs-0 fw-bold mb-0"><i class="fas fa-edit me-2 text-primary"></i> <span id="editor-title">Editor Ekspertise</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 ent-table-surface">
                <textarea id="large-textarea-input" class="form-control border-0 rounded-0 fw-semibold" style="height: 60vh; font-size: 1.05rem; line-height: 1.6; padding: 20px; resize: none;"></textarea>
            </div>
            <div class="modal-footer py-2" style="border-top: 1px solid var(--ent-grid-border);">
                <span class="fw-semibold fs--2 me-auto opacity-75"><i class="fas fa-info-circle me-1 text-primary"></i> Teks akan tersimpan ke form saat Anda klik 'Terapkan'</span>
                <button type="button" class="btn btn-sm ent-btn ent-btn-reset" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-4" id="btn-apply-editor">Terapkan &amp; Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX MODAL (UNTUK GAMBAR DICOM) -->
<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <button type="button" class="btn-close btn-close-white ms-auto m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                <div class="container-fluid p-0 w-100 h-100 d-flex align-items-center justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK AUTO-RENDER DICOM DI CARD & MODAL, EDITOR TEXT & VERIFIKASI -->
<script>
    window.RAD_FALLBACK_DICOM_URL = "{{ $resolvedFallbackDicom }}";

    window.ensureCornerstoneDicomReady = window.ensureCornerstoneDicomReady || function() {
        if (window._csDicomPromise) return window._csDicomPromise;

        function loadScript(src) {
            return new Promise(function(resolve, reject) {
                var existing = document.querySelector('script[src="' + src + '"]');
                if (existing) {
                    if (existing.dataset.loaded === '1') return resolve();
                    existing.addEventListener('load', resolve);
                    existing.addEventListener('error', reject);
                    return;
                }
                var s = document.createElement('script');
                s.src = src;
                s.async = true;
                s.onload = function() {
                    s.dataset.loaded = '1';
                    resolve();
                };
                s.onerror = reject;
                document.head.appendChild(s);
            });
        }

        window._csDicomPromise = loadScript('https://cdn.jsdelivr.net/npm/dicom-parser@1.8.21/dist/dicomParser.min.js')
            .then(function() {
                return loadScript('https://cdn.jsdelivr.net/npm/cornerstone-core@2.6.1/dist/cornerstone.min.js');
            })
            .then(function() {
                return loadScript('https://cdn.jsdelivr.net/npm/cornerstone-wado-image-loader@4.13.2/dist/cornerstoneWADOImageLoader.bundle.min.js');
            })
            .then(function() {
                if (window.cornerstoneWADOImageLoader && window.cornerstone && window.dicomParser) {
                    window.cornerstoneWADOImageLoader.external.cornerstone = window.cornerstone;
                    window.cornerstoneWADOImageLoader.external.dicomParser = window.dicomParser;
                    if (!window._csWadoConfigured) {
                        window.cornerstoneWADOImageLoader.configure({
                            useWebWorkers: false,
                            decodeConfig: {
                                convertFloatPixelDataToInt: false
                            }
                        });
                        window._csWadoConfigured = true;
                    }
                }
            })
            .catch(function(err) {
                window._csDicomPromise = null;
                throw err;
            });

        return window._csDicomPromise;
    };

    window.renderDicomMetadataGrid = window.renderDicomMetadataGrid || function(buffer, metaListEl) {
        if (!metaListEl) return;
        var patientName = '-',
            modality = '-',
            dimensions = '-',
            transferSyntax = '-',
            studyDate = '-',
            seriesDesc = '-';

        if (window.dicomParser) {
            try {
                var dataSet = window.dicomParser.parseDicom(new Uint8Array(buffer));
                patientName = dataSet.string('x00100010') || '-';
                modality = dataSet.string('x00080060') || '-';
                studyDate = dataSet.string('x00080020') || '-';
                seriesDesc = dataSet.string('x0008103e') || '-';
                transferSyntax = dataSet.string('x00020010') || '-';
                var rows = dataSet.uint16('x00280010');
                var cols = dataSet.uint16('x00280011');
                var bits = dataSet.uint16('x00280100');
                if (rows && cols) {
                    dimensions = cols + ' x ' + rows + ' px' + (bits ? ' (' + bits + '-bit)' : '');
                }
            } catch (e) {}
        }

        metaListEl.innerHTML =
            '<div class="col-6"><div class="ent-info-box py-2"><div class="info-label">Nama Pasien (DICOM)</div><div class="info-value text-truncate">' + patientName + '</div></div></div>' +
            '<div class="col-6"><div class="ent-info-box py-2"><div class="info-label">Kategori / Modality</div><div class="info-value">' + modality + (studyDate !== '-' ? ' • ' + studyDate : '') + '</div></div></div>' +
            '<div class="col-6"><div class="ent-info-box py-2"><div class="info-label">Ukuran Citra</div><div class="info-value">' + dimensions + '</div></div></div>' +
            '<div class="col-6"><div class="ent-info-box py-2"><div class="info-label">Transfer Syntax / Deskripsi</div><div class="info-value text-truncate" title="' + transferSyntax + '">' + (seriesDesc !== '-' ? seriesDesc : transferSyntax) + '</div></div></div>';
    };

    // Fungsi inti render DICOM langsung ke elemen target tanpa klik tombol
    window.renderDicomIntoElement = function(dicomUrl, viewportEl, metaListEl, statusEl, alertEl) {
        var targetUrl = dicomUrl || window.RAD_FALLBACK_DICOM_URL;
        if (!viewportEl) return Promise.reject(new Error('Viewport tidak ditemukan'));

        if (statusEl) statusEl.textContent = 'Memuat decoder & membaca file DICOM...';
        if (alertEl) {
            alertEl.classList.add('d-none');
            alertEl.textContent = '';
        }

        return Promise.all([
            window.ensureCornerstoneDicomReady(),
            fetch(targetUrl, {
                cache: 'no-store'
            }).then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.arrayBuffer();
            })
        ])
        .then(function(results) {
            var buffer = results[1];
            window.renderDicomMetadataGrid(buffer, metaListEl);

            if (!window.cornerstone || !window.cornerstoneWADOImageLoader) {
                throw new Error('Library Cornerstone DICOM gagal dimuat.');
            }

            try {
                window.cornerstone.disable(viewportEl);
            } catch (e) {}
            window.cornerstone.enable(viewportEl);

            var blob = new Blob([buffer], {
                type: 'application/dicom'
            });
            var imageId = window.cornerstoneWADOImageLoader.wadouri.fileManager.add(blob);

            return window.cornerstone.loadAndCacheImage(imageId).then(function(image) {
                window.cornerstone.displayImage(viewportEl, image);
                window.cornerstone.resize(viewportEl, true);
                window.cornerstone.fitToWindow(viewportEl);
                window._activeCsElement = viewportEl;

                if (statusEl) {
                    statusEl.textContent = 'Terbaca otomatis (' + image.columns + ' x ' + image.rows + ' px)';
                }
                return { rendered: true, rows: image.rows, cols: image.columns };
            });
        })
        .catch(function(err) {
            if (statusEl) statusEl.textContent = 'Gagal merender citra DICOM';
            if (alertEl) {
                alertEl.textContent = 'Gagal membaca gambar DICOM (' + targetUrl + '): ' + (err && err.message ? err.message : 'Format tidak didukung');
                alertEl.classList.remove('d-none');
            }
        });
    };

    // Langsung tampilkan & render data.dcm di dalam card tanpa klik tombol
    window.renderDefaultDicomFallback = function(reasonMessage) {
        var alertBox = document.getElementById('orthanc-alert');
        var alertText = document.getElementById('orthanc-alert-text');
        var loaderBox = document.getElementById('orthanc-loader');
        var emptyBox = document.getElementById('orthanc-empty');
        var galleryBox = document.getElementById('orthanc-gallery');

        if (loaderBox) loaderBox.classList.add('d-none');
        if (galleryBox) galleryBox.classList.add('d-none');

        if (reasonMessage && alertBox && alertText) {
            alertText.textContent = reasonMessage;
            alertBox.classList.remove('d-none');
        }

        if (emptyBox) {
            emptyBox.classList.remove('d-none');
            var vpEl = document.getElementById('card-dicom-viewport');
            var metaEl = document.getElementById('card-dicom-metadata');
            var statusEl = document.getElementById('card-dicom-status');
            var alertEl = document.getElementById('card-dicom-alert');

            setTimeout(function() {
                window.renderDicomIntoElement(window.RAD_FALLBACK_DICOM_URL, vpEl, metaEl, statusEl, alertEl);
            }, 120);
        }
    };

    window.handleOrthancImageError = function() {
        window.renderDefaultDicomFallback('Koneksi ke server PACS Orthanc gagal atau citra tidak ditemukan; menampilkan otomatis file public/dicom/data.dcm.');
    };

    // Jika dibuka sebagai modal / via window.openDicomReaderModal, langsung proses & render otomatis
    window.openDicomReaderModal = function(dicomUrl, titleText) {
        var targetUrl = dicomUrl || window.RAD_FALLBACK_DICOM_URL;
        var modalEl = document.getElementById('modal-dicom-viewer');
        if (!modalEl) return;

        var titleEl = document.getElementById('dicom-modal-title');
        var urlLabelEl = document.getElementById('dicom-modal-file-path');
        var statusEl = document.getElementById('dicom-modal-status');
        var metaEl = document.getElementById('dicom-modal-metadata');
        var csEl = document.getElementById('dicom-cornerstone-element');
        var alertEl = document.getElementById('dicom-modal-alert');

        if (titleEl) titleEl.textContent = titleText || 'DICOM Reader — data.dcm';
        if (urlLabelEl) urlLabelEl.textContent = targetUrl;
        if (metaEl) metaEl.innerHTML = '';

        var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        bsModal.show();

        setTimeout(function() {
            window.renderDicomIntoElement(targetUrl, csEl, metaEl, statusEl, alertEl);
        }, 220);
    };

    (function($) {
        $(document).off('.radVerifModal');

        var currentTargetId = '';
        var isGeneratingPdf = false;
        var activePdfAjax = null;

        $(document).ready(function() {
            // Jika form ini tampil di dalam .modal, langsung render otomatis file DICOM modal
            var $parentModal = $('#card-dicom-viewport').closest('.modal');
            if ($parentModal.length) {
                var modalCsEl = document.getElementById('card-dicom-viewport');
                var modalMetaEl = document.getElementById('card-dicom-metadata');
                var modalStatusEl = document.getElementById('card-dicom-status');
                var modalAlertEl = document.getElementById('card-dicom-alert');
                var emptyBox = document.getElementById('orthanc-empty');
                var loaderBox = document.getElementById('orthanc-loader');
                if (loaderBox) loaderBox.classList.add('d-none');
                if (emptyBox) emptyBox.classList.remove('d-none');
                setTimeout(function() {
                    window.renderDicomIntoElement(window.RAD_FALLBACK_DICOM_URL, modalCsEl, modalMetaEl, modalStatusEl, modalAlertEl);
                }, 250);
            }

            // Fallback otomatis di card bila fetch Orthanc tidak mengisi galeri
            setTimeout(function() {
                var loaderEl = document.getElementById('orthanc-loader');
                var galleryEl = document.getElementById('orthanc-gallery');
                var emptyEl = document.getElementById('orthanc-empty');
                var galleryEmpty = !galleryEl || galleryEl.classList.contains('d-none') || galleryEl.children.length === 0;
                var stillLoading = loaderEl && !loaderEl.classList.contains('d-none');
                var emptyVisible = emptyEl && !emptyEl.classList.contains('d-none');

                if (galleryEmpty && (stillLoading || emptyVisible)) {
                    window.renderDefaultDicomFallback('');
                }
            }, 1800);
        });

        $(document).on('click.radVerifModal', '.btn-dicom-tool', function(e) {
            e.preventDefault();
            var action = $(this).data('action');
            var targetSelector = $(this).data('target');
            var el = targetSelector ? document.querySelector(targetSelector) : window._activeCsElement;
            if (!el || !window.cornerstone) return;

            try {
                var vp = window.cornerstone.getViewport(el);
                if (action === 'zoom-in') {
                    vp.scale += 0.25;
                    window.cornerstone.setViewport(el, vp);
                } else if (action === 'zoom-out') {
                    vp.scale = Math.max(0.2, vp.scale - 0.25);
                    window.cornerstone.setViewport(el, vp);
                } else if (action === 'invert') {
                    vp.invert = !vp.invert;
                    window.cornerstone.setViewport(el, vp);
                } else if (action === 'reset') {
                    window.cornerstone.reset(el);
                    window.cornerstone.fitToWindow(el);
                }
            } catch (err) {}
        });

        $(document).on('click.radVerifModal', '.btn-open-editor', function(e) {
            e.preventDefault();
            currentTargetId = $(this).data('target');
            var title = $(this).data('title');
            var currentText = $(currentTargetId).val();

            $('#editor-title').text('Editor Ekspertise: ' + title);
            $('#large-textarea-input').val(currentText);

            var editorModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-text-editor'));
            editorModal.show();

            setTimeout(function() {
                $('#large-textarea-input').focus();
            }, 400);
        });

        $(document).on('click.radVerifModal', '#btn-apply-editor', function() {
            var updatedText = $('#large-textarea-input').val();
            if (currentTargetId) {
                $(currentTargetId).val(updatedText);
            }
            var editorModal = bootstrap.Modal.getInstance(document.getElementById('modal-text-editor'));
            if (editorModal) {
                editorModal.hide();
            }
        });

        $(document).on('submit.radVerifModal', '.form-ekspertise-single', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('.btn-save-ekspertise');
            var originalText = btn.html();

            if (btn.prop('disabled')) return;
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Ekspertise berhasil disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        if (xhr.responseJSON.errors) {
                            let firstKey = Object.keys(xhr.responseJSON.errors)[0];
                            errorMsg = xhr.responseJSON.errors[firstKey][0];
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: errorMsg
                    });
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        $(document).on('click.radVerifModal', '.btn-verifikasi-final', function(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            let detailId = $btn.data('transaksi-id');
            let form = $btn.closest('form');

            Swal.fire({
                title: "Verifikasi Hasil?",
                text: "Apakah Anda yakin ekspertise ini sudah benar? Setelah diverifikasi, data akan dikunci.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4f46e5",
                cancelButtonColor: "#e11d48",
                confirmButtonText: "Ya, Verifikasi Final",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $btn.prop('disabled', true);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {
                            $.post("{{ route('radiologi.verifikasi_final') }}", {
                                _token: "{{ csrf_token() }}",
                                transaksi_detail_id: detailId
                            }, function(res) {
                                Swal.fire("Terverifikasi!", "Hasil radiologi berhasil diverifikasi dan dikunci.", "success").then(() => {
                                    location.reload();
                                });
                            }).fail(function() {
                                $btn.prop('disabled', false);
                                Swal.fire("Gagal", "Terjadi kesalahan saat memverifikasi data.", "error");
                            });
                        },
                        error: function() {
                            $btn.prop('disabled', false);
                            Swal.fire("Gagal Menyimpan", "Periksa kembali isian form Anda.", "error");
                        }
                    });
                }
            });
        });

        $(document).on('click.radVerifModal', '.btn-cetak-hasil', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            if (isGeneratingPdf) return;
            isGeneratingPdf = true;

            var $btn = $(this);
            var originalBtnHtml = $btn.html();
            let code = $btn.data('code');
            let reg = $btn.data('reg');

            $('.btn-cetak-hasil').prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');

            Swal.fire({
                title: 'Memproses PDF...',
                text: 'Mohon tunggu, sistem sedang men-generate laporan radiologi.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            if (activePdfAjax && activePdfAjax.readyState !== 4) {
                activePdfAjax.abort();
            }

            activePdfAjax = $.ajax({
                url: '{{ route("hasil_radiologi_verifikasi_data") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    code: code,
                    reg: reg
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'File PDF laporan radiologi berhasil dibuat.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        let pdfUrl = '{{ asset("storage/hasil/rad") }}/' + reg + '.pdf';
                        window.open(pdfUrl, '_blank');
                    });
                },
                error: function(xhr, status) {
                    if (status === 'abort') return;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat memproses file PDF.'
                    });
                },
                complete: function() {
                    isGeneratingPdf = false;
                    activePdfAjax = null;
                    $('.btn-cetak-hasil').prop('disabled', false);
                    $btn.html(originalBtnHtml);
                }
            });
        });
    })(jQuery);
</script>

@else
<div class="card ent-card mb-4">
    <div class="card-body ent-table-surface p-5 text-center">
        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(225, 29, 72, 0.14); border: 1px solid rgba(225, 29, 72, 0.35);"><i class="fas fa-lock fs-2 text-danger"></i></div>
        <h4 class="fw-bold">Hasil Belum Dapat Diakses</h4>
        <p class="fw-semibold mb-3 opacity-75" style="max-width: 500px; margin: 0 auto;">Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.</p>
        <span class="ent-badge px-3 py-2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">Status: Belum Lunas</span>
    </div>
</div>
@endif
