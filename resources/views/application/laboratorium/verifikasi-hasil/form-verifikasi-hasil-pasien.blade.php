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

<!-- CARD PROFIL PASIEN -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card rad-card h-100 border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary bg-gradient text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold fs--1"><i class="fas fa-user-injured me-2"></i> Identitas Pasien</h6>
                    <span class="badge bg-white text-primary fw-bold">Ekspertise Radiologi</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="row g-3 align-items-center">
                    <!-- Avatar -->
                    <div class="col-auto">
                        <div class="patient-avatar-wrapper flex-shrink-0" style="width: 80px; height: 80px;">
                            <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                                class="patient-avatar rounded-circle border border-2 border-primary shadow-sm"
                                alt="Foto Pasien">
                        </div>
                    </div>
                    <!-- Info Utama -->
                    <div class="col-md-3 border-end">
                        <h5 class="fw-bold mb-1 text-dark fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="badge bg-soft-primary text-primary fw-bold fs--1 mb-2">RM: {{ $data->master_patient_code }}</span>
                        <div class="d-flex flex-column gap-1">
                            <span class="fs--2 text-muted"><i class="fas fa-id-card text-primary me-1"></i> {{ $data->master_patient_nik ?? '-' }}</span>
                            <span class="fs--2 text-muted"><i class="fas fa-venus-mars text-primary me-1"></i> {{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</span>
                        </div>
                    </div>
                    <!-- Info Tambahan -->
                    <div class="col-md-7">
                        <div class="row g-2">
                            <div class="col-sm-4">
                                <div class="p-2 border rounded bg-light h-100">
                                    <div class="info-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tgl Lahir</div>
                                    <div class="info-value fs--1">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 border rounded bg-light h-100">
                                    <div class="info-label"><i class="fas fa-phone text-primary me-1"></i> No. HP</div>
                                    <div class="info-value fs--1">{{ $data->master_patient_no_hp ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 border rounded bg-light h-100">
                                    <div class="info-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</div>
                                    <div class="info-value fs--1 text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

            <div class="card-body p-3 bg-light" style="max-height: 600px; overflow-y: auto;">
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

            <div class="card-body p-3" style="max-height: 600px; overflow-y: auto;">
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div><strong>Perhatian:</strong> Citra/foto radiologi belum termuat secara sempurna. Pastikan DICOM telah diunggah sebelum memverifikasi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php $totalParams = isset($item->parameters) ? count($item->parameters) : 0; @endphp
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum diproses oleh petugas radiografer. Form terkunci.</div>
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
                                        <textarea id="textarea-fallback-{{ $index }}" class="form-control field-ekspertise" name="hasil_ekspertise" rows="10" placeholder="Ketik hasil ekspertise..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $fallbackResult ?? '' }}</textarea>
                                    </div>
                                    @endforelse
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-sm btn-primary px-3 shadow-sm btn-save-ekspertise" {{ !$item->is_ready ? 'disabled' : '' }}>
                                    <i class="fas fa-save me-1"></i> Simpan Draf
                                </button>
                                <!-- TOMBOL VERIFIKASI SELESAI -->
                                <button type="button" class="btn btn-sm btn-success px-3 shadow-sm" {{ !$item->is_ready ? 'disabled' : '' }} id="btn-verifikasi-final" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-check-double me-1"></i> Verifikasi Final
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
<div class="modal fade" id="modal-text-editor" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
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

<!-- SCRIPT UNTUK MODAL EDITOR TEXT & VERIFIKASI -->
<script>
    $(document).ready(function() {
        var currentTargetId = ''; // Menyimpan ID textarea asli yang sedang diedit

        // Saat tombol Expand (Panah besar) diklik
        $(document).on('click', '.btn-open-editor', function(e) {
            e.preventDefault();

            currentTargetId = $(this).data('target');
            var title = $(this).data('title');

            // Ambil teks dari form asli
            var currentText = $(currentTargetId).val();

            // Set judul dan isi textarea di dalam modal
            $('#editor-title').text('Editor Ekspertise: ' + title);
            $('#large-textarea-input').val(currentText);

            // Tampilkan Modal Bootstrap (Perhatikan z-index jika dipanggil di dalam modal lain)
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

        // Form Submit Handler untuk Simpan Draf (Ajax Form Submit)
        $('.form-ekspertise-single').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('.btn-save-ekspertise');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Draf');
                    // Tampilkan notif sukses jika diperlukan
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Ekspertise berhasil disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Draf');
                    alert('Terjadi kesalahan saat menyimpan data.');
                }
            });
        });
    });
</script>

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
