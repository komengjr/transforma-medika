<!-- CARD PROFIL PASIEN -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card retro-card h-100">
            <div class="card-header text-dark fw-bolder py-2" style="background-color: var(--retro-cyan); border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-dark fw-bolder fs--1"><i class="fas fa-user-injured me-2"></i> Identitas Pasien</h6>
                    <span class="badge bg-white text-dark border border-dark rounded-2 fw-bold px-2 py-1">Ekspertise Radiologi</span>
                </div>
            </div>
            <div class="card-body bg-white p-3">
                <div class="row g-3 align-items-center">
                    <!-- Avatar Ukuran Standar (50px) -->
                    <div class="col-auto">
                        <div class="patient-avatar-wrapper flex-shrink-0" style="width: 50px; height: 50px;">
                            <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                                class="patient-avatar rounded-circle shadow-sm"
                                alt="Foto Pasien" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                        </div>
                    </div>
                    <!-- Info Utama -->
                    <div class="col-md-3 border-end border-dark" style="border-right-width: 2px !important;">
                        <h5 class="fw-bolder mb-1 text-dark fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="badge bg-white text-dark border border-dark fw-bold fs--1 mb-2 shadow-sm">RM: {{ $data->master_patient_code }}</span>
                        <div class="d-flex flex-column gap-1">
                            <span class="fs--2 text-dark fw-bold"><i class="fas fa-id-card text-dark me-1"></i> {{ $data->master_patient_nik ?? '-' }}</span>
                            <span class="fs--2 text-dark fw-bold"><i class="fas fa-venus-mars text-dark me-1"></i> {{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</span>
                        </div>
                    </div>
                    <!-- Info Tambahan -->
                    <div class="col-md-7">
                        <div class="row g-2">
                            <div class="col-sm-4">
                                <div class="p-2 rounded bg-light h-100" style="border: 2px solid var(--retro-dark);">
                                    <div class="info-label"><i class="fas fa-calendar-alt text-dark me-1"></i> Tgl Lahir</div>
                                    <div class="info-value fs--1 text-dark fw-bold">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 rounded bg-light h-100" style="border: 2px solid var(--retro-dark);">
                                    <div class="info-label"><i class="fas fa-phone text-dark me-1"></i> No. HP</div>
                                    <div class="info-value fs--1 text-dark fw-bold">{{ $data->master_patient_no_hp ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 rounded bg-light h-100" style="border: 2px solid var(--retro-dark);">
                                    <div class="info-label"><i class="fas fa-map-marker-alt text-dark me-1"></i> Tempat Lahir</div>
                                    <div class="info-value fs--1 text-dark fw-bold text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
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
        <div class="card retro-card h-100">
            <div class="card-header text-white p-3" style="background-color: var(--retro-dark); border-bottom: 2px solid var(--retro-dark);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-x-ray text-info fs-0"></i>
                        <h6 class="mb-0 text-white fw-bolder fs--1">Citra Radiologi PACS Orthanc</h6>
                        <span class="badge bg-white text-dark border border-dark fw-bold fs--2 rounded-2 px-2">{{ count($pemeriksaanList) }} Item</span>
                    </div>
                    <button id="btn-fetch-orthanc" type="button" class="btn btn-xs btn-light border border-dark rounded-2 px-2.5 py-1 fs--2 fw-bolder" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
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

            <div class="card-body p-3 bg-white" style="max-height: 600px; overflow-y: auto;">
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

            <div class="card-body p-3 bg-white" style="max-height: 600px; overflow-y: auto;">
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-2 border border-dark fw-bold">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div><strong>Perhatian:</strong> Citra/foto radiologi belum termuat secara sempurna. Pastikan DICOM telah diunggah sebelum memverifikasi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php
                    $totalParams = isset($item->parameters) ? count($item->parameters) : 0;
                    $header = $item->saved_header;
                    $isLocked = (!$item->is_ready || $item->is_verified);
                    @endphp

                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-2 border border-dark fw-bold" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum diproses oleh petugas radiografer. Form terkunci.</div>
                        </div>
                        @elseif($item->is_verified)
                        <div class="alert alert-success d-flex align-items-center mb-3 fs--1 p-2 rounded-2 border border-dark fw-bold" style="background-color: var(--retro-green); color: var(--retro-dark);">
                            <i class="fas fa-check-circle me-2 fs-0"></i>
                            <div>Ekspertise ini telah diverifikasi final pada <strong>{{ date('d-m-Y H:i', strtotime($header->tanggal_verifikasi)) }}</strong>. Data telah dikunci.</div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="{{ route('menu_radiologi_handling_pasien_simpan_hasil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="transaksi_detail_id" value="{{ $item->detail_id }}">
                            <input type="hidden" name="order_rad_list_code" value="{{ $item->order_rad_list_code }}">
                            <input type="hidden" name="t_pemeriksaan_list_code" value="{{ $item->t_pemeriksaan_list_code }}">

                            <div class="d-flex align-items-center justify-content-between p-2 mb-3 bg-light rounded-2 border border-dark">
                                <span class="fs--1 fw-bolder text-dark"><i class="fas fa-stethoscope text-dark me-1"></i> {{ $item->nama_pemeriksaan }}</span>
                                <span class="badge bg-white text-dark border border-dark font-monospace fs--2 fw-bold">{{ $item->t_pemeriksaan_list_code ?? '-' }}</span>
                            </div>

                            <div class="mb-3 row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder fs--2 text-dark mb-1">Klinis / Indikasi</label>
                                    <input type="text" class="form-control form-control-sm fw-bold" name="klinis_indikasi" value="{{ $header->klinis_indikasi ?? '' }}" placeholder="Ketik indikasi..." {{ $isLocked ? 'disabled readonly' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder fs--2 text-dark mb-1">Teknik Pemeriksaan</label>
                                    <input type="text" class="form-control form-control-sm fw-bold" name="teknik_pemeriksaan" value="{{ $header->teknik_pemeriksaan ?? '' }}" placeholder="Contoh: AP / Lateral" {{ $isLocked ? 'disabled readonly' : '' }}>
                                </div>
                            </div>

                            <div class="border border-dark rounded-2 p-2 mb-3 bg-white shadow-sm">
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom border-dark pb-1" style="border-bottom-width: 2px !important;">
                                    <h6 class="fs--1 fw-bolder text-dark mb-0"><i class="fas fa-list-check me-1"></i> Detail Ekspertise</h6>
                                    <span class="badge bg-white text-dark border border-dark fs--2 fw-bold">{{ $totalParams }} Parameter</span>
                                </div>

                                @forelse($item->parameters as $valIndex => $val)
                                @php
                                $optType = strtolower($val->t_pem_list_val_opt ?? 'textarea');
                                $computedRows = (!empty($val->t_pem_list_val_kali) && is_numeric($val->t_pem_list_val_kali)) ? (int)$val->t_pem_list_val_kali : 3;
                                $currentValue = $val->saved_value;
                                @endphp

                                <div class="mb-3 p-2 border-bottom border-dark last-border-0">
                                    <label class="form-label fw-bolder fs--1 text-dark mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-angle-right text-dark me-1 fs--2"></i> {{ $val->t_pem_list_val_name }}</span>
                                        <div>
                                            @if(!empty($val->t_pem_list_val_satuan))<span class="badge bg-white text-dark border border-dark fw-bold fs--2 me-1">{{ $val->t_pem_list_val_satuan }}</span>@endif
                                            @if($optType != 'select' && $optType != 'option' && $optType != 'text' && $optType != 'input' && $optType != 'string' && !$isLocked)
                                            <button type="button" class="btn btn-xs btn-light border border-dark py-0 px-2 btn-open-editor fw-bold shadow-sm" data-target="#textarea-{{ $item->detail_id }}-{{ $val->t_pem_list_val_code }}" data-title="{{ $val->t_pem_list_val_name }}" title="Perbesar Teks Editor">
                                                <i class="fas fa-expand-arrows-alt"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </label>

                                    <input type="hidden" name="details[{{ $valIndex }}][parameter_code]" value="{{ $val->t_pem_list_val_code }}">
                                    <input type="hidden" name="details[{{ $valIndex }}][nama_parameter]" value="{{ $val->t_pem_list_val_name }}">

                                    @if(($optType == 'select' || $optType == 'option') && !empty($val->t_pem_list_val_opt_code))
                                    <select name="details[{{ $valIndex }}][nilai_hasil]" class="form-select form-select-sm fw-bold" {{ $isLocked ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Hasil --</option>
                                        @foreach(explode(',', $val->t_pem_list_val_opt_code) as $opt)
                                        <option value="{{ trim($opt) }}" {{ $currentValue == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                        @endforeach
                                    </select>
                                    @elseif($optType == 'text' || $optType == 'input' || $optType == 'string')
                                    <input type="text" class="form-control form-control-sm fw-bold" name="details[{{ $valIndex }}][nilai_hasil]" placeholder="Masukkan hasil..." value="{{ $currentValue }}" {{ $isLocked ? 'readonly disabled' : '' }}>
                                    @else
                                    <textarea id="textarea-{{ $item->detail_id }}-{{ $val->t_pem_list_val_code }}" class="form-control form-control-sm field-ekspertise fw-bold" name="details[{{ $valIndex }}][nilai_hasil]" rows="{{ $computedRows }}" placeholder="Ketik deskripsi hasil..." {{ $isLocked ? 'readonly disabled' : '' }}>{{ $currentValue }}</textarea>
                                    @endif
                                </div>
                                @empty
                                <div class="text-center p-3 text-dark fw-bold fs--2 border border-dark rounded bg-light mb-2">
                                    Tidak ada template parameter khusus. Silakan isi kesan & kesimpulan di bawah.
                                </div>
                                @endforelse

                                <div class="mb-2 mt-3 p-2 rounded border border-dark shadow-sm" style="background-color: var(--retro-cyan);">
                                    <label class="form-label fw-bolder fs--1 text-dark mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-clipboard-check text-dark me-1 fs--2"></i> Kesan / Kesimpulan (Impression) <span class="text-danger">*</span></span>
                                        @if(!$isLocked)
                                        <button type="button" class="btn btn-xs btn-light border border-dark py-0 px-2 btn-open-editor fw-bold shadow-sm" data-target="#textarea-kesan-{{ $item->detail_id }}" data-title="Kesan & Kesimpulan" style="background-color: var(--retro-yellow);">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </button>
                                        @endif
                                    </label>
                                    <textarea id="textarea-kesan-{{ $item->detail_id }}" class="form-control form-control-sm fw-bold" name="kesan_kesimpulan" rows="5" placeholder="Ketik kesimpulan pemeriksaan radiologi di sini..." required {{ $isLocked ? 'readonly disabled' : '' }}>{{ $header->kesan_kesimpulan ?? '' }}</textarea>
                                </div>

                                <div class="mb-2 p-2">
                                    <label class="form-label fw-bolder fs--2 text-dark mb-1">Saran / Rekomendasi Tambahan (Opsional)</label>
                                    <textarea class="form-control form-control-sm text-dark fw-bold" name="saran" rows="2" placeholder="Ketik saran pemeriksaan lanjutan jika ada..." {{ $isLocked ? 'readonly disabled' : '' }}>{{ $header->saran ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                @if($item->is_verified)
                                <button type="button" class="btn btn-sm px-4 shadow-sm btn-cetak-hasil fw-bolder" data-code="{{ $code }}" data-reg="{{ $item->order_rad_list_code }}" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                    <i class="fas fa-print me-1"></i> Cetak Hasil
                                </button>
                                @else
                                <button type="submit" class="btn btn-sm px-3 shadow-sm btn-save-ekspertise fw-bolder" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);" {{ $isLocked ? 'disabled' : '' }}>
                                    <i class="fas fa-save me-1"></i> Simpan Draf
                                </button>
                                <button type="button" class="btn btn-sm px-3 shadow-sm btn-verifikasi-final fw-bolder"
                                    data-transaksi-id="{{ $item->detail_id }}"
                                    data-code="{{ $item->order_rad_list_code }}"
                                    style="background-color: var(--retro-green); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);"
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

<!-- MODAL EDITOR LAYAR PENUH (FULL SCREEN TEXT EDITOR) -->
<div class="modal fade" id="modal-text-editor" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
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
                <button type="button" class="btn btn-sm px-4 fw-bolder shadow-sm" id="btn-apply-editor" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 2px solid var(--retro-dark);">Terapkan & Tutup</button>
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

        $('.form-ekspertise-single').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('.btn-save-ekspertise');
            var originalText = btn.html();

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    btn.prop('disabled', false).html(originalText);
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
                    btn.prop('disabled', false).html(originalText);
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
                }
            });
        });
    });

    $(document).on('click', '.btn-verifikasi-final', function(e) {
        e.preventDefault();
        let detailId = $(this).data('transaksi-id');
        let form = $(this).closest('form');

        Swal.fire({
            title: "Verifikasi Hasil?",
            text: "Apakah Anda yakin ekspertise ini sudah benar? Setelah diverifikasi, data akan dikunci.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ffde59",
            cancelButtonColor: "#ffa6c9",
            confirmButtonText: "Ya, Verifikasi Final",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
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
                            Swal.fire("Gagal", "Terjadi kesalahan saat memverifikasi data.", "error");
                        });
                    },
                    error: function() {
                        Swal.fire("Gagal Menyimpan", "Periksa kembali isian form Anda.", "error");
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-cetak-hasil', function(e) {
        e.preventDefault();
        let code = $(this).data('code');
        let reg = $(this).data('reg');

        Swal.fire({
            title: 'Memproses PDF...',
            text: 'Mohon tunggu, sistem sedang men-generate laporan radiologi.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
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
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memproses file PDF.'
                });
            }
        });
    });
</script>

@else
<div class="card retro-card mb-4" style="border: 2px solid var(--retro-pink);">
    <div class="card-body p-5 text-center">
        <div class="avatar avatar-4xl rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold" style="width: 70px; height: 70px; background-color: var(--retro-pink); border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);"><i class="fas fa-lock fs-2 text-dark"></i></div>
        <h4 class="fw-bolder text-dark">Hasil Belum Dapat Diakses</h4>
        <p class="text-dark fw-bold mb-3 opacity-75" style="max-width: 500px; margin: 0 auto;">Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.</p>
        <span class="badge bg-white text-dark border border-dark px-3 py-2 fs-0 fw-bolder shadow-sm">Status: Belum Lunas</span>
    </div>
</div>
@endif
