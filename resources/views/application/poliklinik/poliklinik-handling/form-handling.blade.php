<style>
    /* =========================================
       MODERN ENTERPRISE HANDLING MODAL STYLES
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    .ent-modal-wrap {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #10b981;
        --ent-sky: #0ea5e9;
        --ent-amber: #f59e0b;
        --ent-rose: #f43f5e;
        --tooth-red: #ef4444;
        --tooth-blue: #3b82f6;
        --tooth-dark: #1e293b;
        --tooth-gray: #64748b;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border: 1.5px solid var(--ent-grid-border) !important;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.18);
    }

    .ent-modal-wrap .ent-section-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.06);
        background-color: var(--bs-body-bg);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .ent-modal-wrap .ent-banner-top {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1.5px solid var(--ent-grid-border);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-modal-wrap .ent-banner-top::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-modal-wrap .form-header-ent {
        background-color: rgba(79, 70, 229, 0.08);
        color: var(--bs-body-color);
        padding: 12px 18px;
        font-weight: 700;
        font-size: 0.86rem;
        letter-spacing: 0.02em;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .ent-modal-wrap .input-group-text {
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid var(--ent-grid-border);
        border-left: none;
        color: var(--bs-body-color);
        font-weight: 600;
        font-size: 0.78rem;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .ent-modal-wrap .input-group-text-left {
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid var(--ent-grid-border);
        border-right: none;
        color: var(--bs-secondary-color, #64748b);
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .ent-modal-wrap .form-control,
    .ent-modal-wrap .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg) !important;
        font-weight: 600;
        font-size: 0.83rem;
        color: var(--bs-body-color) !important;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .ent-modal-wrap .input-group > .form-control:first-child {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .ent-modal-wrap .input-group > .form-select:last-child {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-modal-wrap .form-control:focus,
    .ent-modal-wrap .form-select:focus,
    .ent-modal-wrap textarea:focus {
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        border-color: var(--ent-indigo) !important;
        outline: none;
    }

    /* Modern Buttons */
    .ent-modal-wrap .btn-ent {
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.82rem;
    }

    .ent-modal-wrap .btn-ent:hover {
        transform: translateY(-1px);
    }

    .ent-modal-wrap .btn-ent-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-modal-wrap .btn-ent-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-modal-wrap .btn-ent-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-modal-wrap .btn-ent-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-modal-wrap .btn-ent-warning {
        background-color: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #f59e0b;
    }

    .ent-modal-wrap .btn-ent-warning:hover {
        background-color: #f59e0b;
        color: #ffffff;
    }

    /* Enterprise Table with Colored Grid & Full Action Cell */
    .ent-modal-wrap .table-ent {
        width: 100%;
        border-collapse: collapse !important;
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-color: var(--bs-body-color);
    }

    .ent-modal-wrap .table-ent thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
        color: var(--bs-body-color) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        text-transform: uppercase;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 10px 12px;
        letter-spacing: 0.04em;
    }

    .ent-modal-wrap .table-ent tbody tr {
        height: 1px;
        transition: background-color 0.15s ease;
    }

    .ent-modal-wrap .table-ent tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .ent-modal-wrap .table-ent tbody td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        font-size: 0.82rem;
        color: var(--bs-body-color) !important;
        padding: 9px 12px;
        vertical-align: middle;
    }

    .ent-modal-wrap .table-ent tbody td.action-cell-full {
        padding: 0 !important;
        height: 100%;
    }

    .ent-modal-wrap .table-ent tbody td.action-cell-full .btn-hapus-row {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: 40px;
        border-radius: 0 !important;
        border: none !important;
        background-color: rgba(244, 63, 94, 0.12);
        color: #f43f5e;
        transition: all 0.15s ease;
    }

    .ent-modal-wrap .table-ent tbody td.action-cell-full .btn-hapus-row:hover {
        background-color: #e11d48;
        color: #ffffff;
    }

    /* ODONTOGRAM STYLES (ADAPTIVE) */
    .odontogram-container {
        display: flex;
        flex-direction: column;
        gap: 14px;
        align-items: center;
        background-color: rgba(79, 70, 229, 0.04);
        padding: 20px;
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        overflow-x: auto;
    }

    .odontogram-row {
        display: flex;
        gap: 18px;
    }

    .odontogram-quadrant {
        display: flex;
        gap: 6px;
    }

    .tooth-box {
        width: 36px;
        height: 46px;
        border: 1.5px solid var(--ent-grid-border);
        border-radius: 8px;
        background-color: var(--bs-body-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.82rem;
        color: var(--bs-body-color);
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.08);
        transition: all 0.15s ease;
        position: relative;
    }

    .tooth-box:hover {
        transform: translateY(-2px);
        border-color: var(--ent-indigo);
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
    }

    .tooth-normal {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        text-shadow: none;
        background-image: none !important;
    }

    .ent-badge-pill {
        border-radius: 9999px;
        padding: 4px 11px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
    }

    /* Custom Checkbox dalam SweetAlert */
    .swal2-html-container .form-check-input {
        border: 1.5px solid #6366f1;
        cursor: pointer;
    }

    .swal2-html-container .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
</style>

<div class="modal-body p-0 ent-modal-wrap bg-white">
    <div class="ent-banner-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2 bg-white">
        <div class="position-relative" style="z-index: 2;">
            <h5 class="mb-1 text-white fw-bold d-flex align-items-center">
                <i class="fas fa-notes-medical text-info me-2"></i> Handling: {{ $data->m_poli_name ?? 'Poliklinik' }}
            </h5>
            <span class="ent-badge-pill" style="background: rgba(56, 189, 248, 0.18); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                Template Aktif: {{ $template_type }}
            </span>
        </div>
        <div class="text-end position-relative me-4" style="z-index: 2;">
            <span class="ent-badge-pill px-3 py-2" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
                <i class="fas fa-hashtag text-info me-1"></i> {{ $data->no_registrasi }}
            </span>
        </div>
    </div>

    <div class="p-3 p-md-4 bg-white">
        <div class="row g-3">
            <!-- IDENTITAS PASIEN -->
            <div class="col-12">
                <div class="ent-section-card p-0">
                    <div class="row g-0">
                        <div class="col-md-2 d-flex align-items-center justify-content-center p-3" style="background: rgba(79, 70, 229, 0.08); border-right: 1px solid var(--ent-grid-border);">
                            @if (empty($data->master_patient_profile))
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle shadow-sm" alt="Foto Pasien" style="width: 78px; height: 78px; object-fit: cover; border: 2px solid rgba(99, 102, 241, 0.45);">
                            @else
                                <img src="{{ $data->master_patient_profile }}" class="rounded-circle shadow-sm" alt="Foto Pasien" style="width: 78px; height: 78px; object-fit: cover; border: 2px solid rgba(99, 102, 241, 0.45);">
                            @endif
                        </div>
                        <div class="col-md-10 p-3 p-md-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label text-uppercase fw-bold opacity-75 mb-1" style="font-size: 0.68rem;">Nama Pasien</label>
                                    <div class="fw-bold fs-2">{{ $data->master_patient_name }}</div>
                                    <div class="fw-semibold opacity-75" style="font-size: 0.78rem; font-family: 'JetBrains Mono', monospace;">
                                        <i class="fas fa-qrcode text-primary me-1"></i>RM: {{ $data->master_patient_code }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-uppercase fw-bold opacity-75 mb-1" style="font-size: 0.68rem;">Gender & Tgl Lahir</label>
                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
                                    <div class="fw-semibold opacity-75" style="font-size: 0.82rem;">{{ $data->master_patient_tgl_lahir }}</div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label text-uppercase fw-bold opacity-75 mb-1" style="font-size: 0.68rem;">Dokter & Penjamin</label>
                                    <div class="fw-bold" style="font-size: 0.88rem;"><i class="fas fa-user-md text-primary me-1"></i> {{ $data->master_doctor_name ?? 'Belum Ditentukan' }}</div>
                                    <div class="mt-1">
                                        <span class="ent-badge-pill" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">
                                            <i class="fas fa-shield-alt me-1"></i> {{ $data->nama_penjamin ?? 'UMUM' }}
                                            {{ !empty($data->nama_sub_penjamin) ? ' - ' . $data->nama_sub_penjamin : '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM TEMPLATE -->
            <div class="col-12">
                <form id="form-handling-medis">
                    @csrf
                    <input type="hidden" name="no_registrasi" value="{{ $code }}">
                    <input type="hidden" name="jenis_template" value="{{ $template_type }}">

                    @if(!empty($data->instruksi_poli))
                    <div class="alert d-flex align-items-center fw-semibold mb-4" style="background: rgba(245, 158, 11, 0.14); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; border-radius: 12px;">
                        <i class="fas fa-info-circle me-2 fs-2"></i>
                        <div>Instruksi: {{ $data->instruksi_poli }}</div>
                    </div>
                    @endif

                    <!-- 1. ODONTOGRAM (MUNCUL JIKA DICENTANG DI TEMPLATE & TIPE GIGI) -->
                    @if($template_type === 'GIGI' && in_array('odontogram', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-tooth text-warning"></i> Odontogram Interaktif & Asesmen Gigi
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="odontogram-container">
                                        <h6 class="fw-bold mb-1 pb-1 text-uppercase opacity-75" style="font-size: 0.75rem; border-bottom: 1px solid var(--ent-grid-border);">RAHANG ATAS</h6>
                                        <div class="odontogram-row">
                                            <div class="odontogram-quadrant" id="quadrant-1">
                                                @foreach(range(18, 11) as $tooth)
                                                <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                @endforeach
                                            </div>
                                            <div style="width: 2px; background-color: rgba(99, 102, 241, 0.45);"></div>
                                            <div class="odontogram-quadrant" id="quadrant-2">
                                                @foreach(range(21, 28) as $tooth)
                                                <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                @endforeach
                                            </div>
                                        </div>
                                        <div style="height: 2px; width: 100%; background-color: rgba(99, 102, 241, 0.45); margin: 4px 0;"></div>
                                        <div class="odontogram-row">
                                            <div class="odontogram-quadrant" id="quadrant-4">
                                                @foreach(range(48, 41) as $tooth)
                                                <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                @endforeach
                                            </div>
                                            <div style="width: 2px; background-color: rgba(99, 102, 241, 0.45);"></div>
                                            <div class="odontogram-quadrant" id="quadrant-3">
                                                @foreach(range(31, 38) as $tooth)
                                                <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                @endforeach
                                            </div>
                                        </div>
                                        <h6 class="fw-bold mt-1 pt-1 text-uppercase opacity-75" style="font-size: 0.75rem; border-top: 1px solid var(--ent-grid-border);">RAHANG BAWAH</h6>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                                        <div class="d-flex align-items-center gap-1.5"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; border:1.5px solid var(--ent-grid-border); background:var(--bs-body-bg);"></span> <span class="fw-semibold small">Normal</span></div>
                                        <div class="d-flex align-items-center gap-1.5"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-red);"></span> <span class="fw-semibold small">Karies/Lubang</span></div>
                                        <div class="d-flex align-items-center gap-1.5"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-blue);"></span> <span class="fw-semibold small">Tumpatan/Tambal</span></div>
                                        <div class="d-flex align-items-center gap-1.5"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-dark);"></span> <span class="fw-semibold small">Hilang/Cabut</span></div>
                                        <div class="d-flex align-items-center gap-1.5"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-gray);"></span> <span class="fw-semibold small">Sisa Akar</span></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-1">Kalkulus / Karang Gigi</label>
                                    <select class="form-select" name="gigi_kalkulus">
                                        <option value="TIDAK_ADA">Tidak Ada</option>
                                        <option value="RINGAN">Ringan</option>
                                        <option value="SEDANG">Sedang</option>
                                        <option value="BERAT">Berat</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-1">Catatan Khusus Gigi Utama</label>
                                    <textarea class="form-control" rows="2" name="keluhan_gigi"></textarea>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="fw-semibold small mb-2">Rincian Tindakan per Gigi</label>
                                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                        <table class="table table-ent w-100 mb-0" id="tabel-log-gigi">
                                            <thead>
                                                <tr>
                                                    <th width="15%" class="text-center">No Gigi</th>
                                                    <th width="35%">Kondisi / Diagnosa (Multiple)</th>
                                                    <th width="50%">Catatan / Rencana Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- 2. ANAMNESA (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                    @if(in_array('anamnesa', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-comment-medical text-info"></i> Anamnesa & Riwayat Medis Pasien
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1">Keluhan Utama <span class="text-danger">*</span></label>
                                    <textarea name="keluhan_utama" class="form-control" rows="2" placeholder="Tuliskan keluhan utama secara rinci...">{{ $existing_anamnesa->keluhan_utama ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Riwayat Penyakit Sekarang</label>
                                    <textarea name="riwayat_penyakit_sekarang" class="form-control" rows="2" placeholder="Perjalanan penyakit saat ini...">{{ $existing_anamnesa->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Riwayat Penyakit Dahulu</label>
                                    <textarea name="riwayat_penyakit_dahulu" class="form-control" rows="2" placeholder="Contoh: Hipertensi, Diabetes, Asma...">{{ $existing_anamnesa->riwayat_penyakit_dahulu ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small mb-1">Riwayat Penyakit Keluarga</label>
                                    <input type="text" name="riwayat_penyakit_keluarga" class="form-control" value="{{ $existing_anamnesa->riwayat_penyakit_keluarga ?? '' }}" placeholder="Penyakit turunan/menular dalam keluarga">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small mb-1">Riwayat Alergi</label>
                                    <input type="text" name="riwayat_alergi" class="form-control" value="{{ $existing_anamnesa->riwayat_alergi ?? '' }}" placeholder="Alergi obat, makanan, dll">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small mb-1">Riwayat Penggunaan Obat</label>
                                    <input type="text" name="riwayat_penggunaan_obat" class="form-control" value="{{ $existing_anamnesa->riwayat_penggunaan_obat ?? '' }}" placeholder="Obat yang sedang rutin dikonsumsi">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- 3. VITAL SIGN (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                    @if(in_array('vital_sign', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-heartbeat text-danger"></i> Fisik Umum & Tanda Vital (Vital Signs)
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Kesadaran</label>
                                    <select name="kesadaran" class="form-select">
                                        @php $kesadaranVal = $existing_vs->kesadaran ?? 'Compos Mentis'; @endphp
                                        <option value="Compos Mentis" {{ $kesadaranVal == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis (Sadar)</option>
                                        <option value="Apatis" {{ $kesadaranVal == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                        <option value="Delirium" {{ $kesadaranVal == 'Delirium' ? 'selected' : '' }}>Delirium</option>
                                        <option value="Somnolen" {{ $kesadaranVal == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                        <option value="Sopor" {{ $kesadaranVal == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                        <option value="Coma" {{ $kesadaranVal == 'Coma' ? 'selected' : '' }}>Coma</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Tekanan Darah (TD)</label>
                                    <div class="input-group">
                                        <input type="text" name="tekanan_darah" class="form-control" value="{{ $existing_vs->tekanan_darah ?? '' }}" placeholder="120/80">
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Nadi</label>
                                    <div class="input-group">
                                        <input type="number" name="nadi" class="form-control" value="{{ $existing_vs->nadi ?? '' }}" placeholder="80">
                                        <span class="input-group-text">x/min</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Suhu Tubuh</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="suhu" class="form-control" value="{{ $existing_vs->suhu ?? '' }}" placeholder="36.5">
                                        <span class="input-group-text">&deg;C</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Pernapasan (RR)</label>
                                    <div class="input-group">
                                        <input type="number" name="pernapasan" class="form-control" value="{{ $existing_vs->pernapasan ?? '' }}" placeholder="20">
                                        <span class="input-group-text">x/min</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Saturasi Oksigen (SpO2)</label>
                                    <div class="input-group">
                                        <input type="number" name="saturasi_o2" class="form-control" value="{{ $existing_vs->saturasi_o2 ?? '' }}" placeholder="98">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Berat Badan (BB)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="berat_badan" class="form-control" value="{{ $existing_vs->berat_badan ?? '' }}" placeholder="60">
                                        <span class="input-group-text">Kg</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small mb-1">Tinggi Badan (TB)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ $existing_vs->tinggi_badan ?? '' }}" placeholder="170">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label fw-semibold small mb-1">Pemeriksaan Fisik Lain / Status Generalis</label>
                                    <textarea name="pemeriksaan_fisik_lain" class="form-control" rows="2" placeholder="Catatan tambahan pemeriksaan fisik...">{{ $existing_vs->pemeriksaan_fisik_lain ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- 4. ORDER TINDAKAN (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                    @if(in_array('tindakan', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="fas fa-vial text-primary me-2"></i> Order Pemeriksaan Lab / Rad / Tindakan Poli</span>
                            <span class="ent-badge-pill" style="background: rgba(79, 70, 229, 0.15); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.35);">
                                Tarif: {{ $data->nama_sub_penjamin ?? ($data->nama_penjamin ?? 'UMUM') }}
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-2 mb-3">
                                <div class="col-md-9">
                                    <label class="fw-semibold small mb-1">Cari Layanan / Tindakan</label>
                                    <div class="input-group">
                                        <span class="input-group-text-left px-3 d-flex align-items-center"><i class="fas fa-search"></i></span>
                                        <select id="input_pemeriksaan" class="form-select">
                                            <option value="" disabled selected>Pilih Layanan / Tindakan...</option>
                                            @foreach($daftar_tindakan ?? [] as $tindakan)
                                            <option value="{{ $tindakan->id }}"
                                                data-nama="{{ $tindakan->nama_layanan }}"
                                                data-kategori="{{ $tindakan->kategori_tindakan }}"
                                                data-harga="{{ $tindakan->harga_akhir }}">
                                                [{{ $tindakan->kategori_tindakan }}] {{ $tindakan->nama_layanan }} - Rp {{ number_format($tindakan->harga_akhir, 0, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-ent btn-ent-primary w-100 py-2" id="btn-tambah-pemeriksaan">
                                        <i class="fas fa-plus me-1"></i> Tambah Order
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-ent w-100 mb-0" id="tabel-order-pemeriksaan">
                                    <thead>
                                        <tr>
                                            <th width="50%">Nama Tindakan / Pemeriksaan</th>
                                            <th width="20%">Kategori</th>
                                            <th width="20%">Tarif Akhir</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- 5. E-RESEP OBAT (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                    @if(in_array('resep', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="fas fa-pills text-warning me-2"></i> E-Resep Dokter (Order Obat)</span>
                            <span class="ent-badge-pill" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.35);">
                                Harga: {{ $data->nama_sub_penjamin ?? ($data->nama_penjamin ?? 'UMUM') }}
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <label class="fw-semibold small mb-1">Nama Obat</label>
                                    <select id="input_obat" class="form-select">
                                        <option value="" disabled selected>Pilih Obat...</option>
                                        @foreach($daftar_obat ?? [] as $obat)
                                        <option value="{{ $obat->farm_data_obat_code }}"
                                            data-nama="{{ $obat->farm_data_obat_name }}"
                                            data-satuan="{{ $obat->farm_data_obat_satuan }}"
                                            data-harga="{{ $obat->harga_jual }}"
                                            data-stok="{{ $obat->farm_data_obat_stok }}">
                                            {{ $obat->farm_data_obat_name }} (Stok: {{ $obat->farm_data_obat_stok }}) - Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="fw-semibold small mb-1">Jumlah</label>
                                    <input type="number" id="input_jumlah_obat" class="form-control" min="1" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-semibold small mb-1">Signa / Aturan Pakai</label>
                                    <input type="text" id="input_signa_obat" class="form-control" placeholder="3 x 1 sesudah makan">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-ent btn-ent-warning w-100 py-2" id="btn-tambah-resep">
                                        <i class="fas fa-plus me-1"></i> Resep
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-ent w-100 mb-0" id="tabel-resep-obat">
                                    <thead>
                                        <tr>
                                            <th width="35%">Nama Obat</th>
                                            <th width="15%" class="text-center">Jumlah</th>
                                            <th width="15%">Satuan / Harga</th>
                                            <th width="25%">Aturan Pakai</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- 6. DIAGNOSA AKHIR (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                    @if(in_array('diagnosa', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-stethoscope text-success"></i> Diagnosa Utama Dokter
                        </div>
                        <div class="card-body p-4">
                            <textarea name="diagnosa_akhir" class="form-control" rows="2" placeholder="Masukkan diagnosa medis akhir..." required></textarea>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Footer Action Button -->
            <div class="col-12 mt-2 pt-3 text-end" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn btn-outline-secondary btn-ent px-4 py-2 me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-ent btn-ent-success px-4 py-2" id="button-save-data-diagnosa-pasien-poli">
                    <i class="fas fa-save me-2"></i> Simpan Hasil Pemeriksaan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- ODONTOGRAM LOGIC ---
    $('.tooth-box').click(async function() {
        const toothNo = $(this).data('tooth');
        const box = $(this);
        const inputHidden = $('#input-gigi-' + toothNo);
        const currentVals = inputHidden.val().split(',');

        const conditionOpts = {
            'KARIES': 'Karies (Berlubang)',
            'TAMBALAN': 'Tumpatan (Tambalan)',
            'HILANG': 'Hilang / Dicabut',
            'SISA_AKAR': 'Sisa Akar'
        };

        let htmlCheckboxes = '<div class="text-start px-3 mt-2"><div class="form-check mb-2"><input class="form-check-input swal-tooth-check" type="checkbox" value="NORMAL" id="check-NORMAL" ' + (currentVals.includes('NORMAL') ? 'checked' : '') + '><label class="form-check-label fw-semibold" for="check-NORMAL">Normal / Sehat (Reset)</label></div><hr class="my-2">';
        for (const [val, label] of Object.entries(conditionOpts)) {
            let isChecked = currentVals.includes(val) ? 'checked' : '';
            htmlCheckboxes += `<div class="form-check mb-2"><input class="form-check-input swal-tooth-check" type="checkbox" value="${val}" id="check-${val}" ${isChecked}><label class="form-check-label fw-semibold" for="check-${val}">${label}</label></div>`;
        }
        htmlCheckboxes += '</div>';

        const {
            value: selectedStatuses
        } = await Swal.fire({
            title: 'Diagnosa Gigi ' + toothNo,
            html: htmlCheckboxes,
            showCancelButton: true,
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-primary px-4 mx-1',
                cancelButton: 'btn btn-outline-secondary px-4 mx-1'
            },
            buttonsStyling: false,
            didOpen: () => {
                $('.swal-tooth-check').change(function() {
                    if ($(this).val() === 'NORMAL' && $(this).is(':checked')) $('.swal-tooth-check').not(this).prop('checked', false);
                    else if ($(this).val() !== 'NORMAL' && $(this).is(':checked')) $('#check-NORMAL').prop('checked', false);
                });
            },
            preConfirm: () => {
                let vals = [];
                $('.swal-tooth-check:checked').each(function() {
                    vals.push($(this).val());
                });
                if (vals.length === 0) {
                    Swal.showValidationMessage('Pilih minimal satu kondisi!');
                    return false;
                }
                return vals;
            }
        });

        if (selectedStatuses) {
            let catatan = '';
            if (!selectedStatuses.includes('NORMAL')) {
                let currentCatatan = $(`#catatan-gigi-${toothNo}`).val() || '';
                let labels = selectedStatuses.map(s => conditionOpts[s]).join(' + ');
                const {
                    value: textCatatan
                } = await Swal.fire({
                    title: 'Catatan Gigi ' + toothNo,
                    text: 'Kondisi: ' + labels,
                    input: 'text',
                    inputValue: currentCatatan,
                    inputPlaceholder: 'Rencana / Detail (Opsional)',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Lewati',
                    customClass: {
                        confirmButton: 'btn btn-success px-4 mx-1',
                        cancelButton: 'btn btn-outline-secondary px-4 mx-1'
                    },
                    buttonsStyling: false
                });
                catatan = textCatatan || '';
            }

            inputHidden.val(selectedStatuses.join(','));
            box.removeClass('tooth-normal').css({
                'background-image': 'none',
                'background-color': '',
                'color': '',
                'text-shadow': 'none'
            });

            if (selectedStatuses.includes('NORMAL')) {
                box.addClass('tooth-normal');
            } else {
                const colorMap = {
                    'KARIES': 'var(--tooth-red)',
                    'TAMBALAN': 'var(--tooth-blue)',
                    'HILANG': 'var(--tooth-dark)',
                    'SISA_AKAR': 'var(--tooth-gray)'
                };
                let activeColors = selectedStatuses.map(s => colorMap[s]);
                box.css({
                    'color': '#ffffff',
                    'text-shadow': '0 1px 2px rgba(0,0,0,0.6)'
                });
                if (activeColors.length === 1) box.css('background-color', activeColors[0]);
                else {
                    let gradient = 'linear-gradient(135deg, ',
                        step = 100 / activeColors.length,
                        stops = [];
                    for (let i = 0; i < activeColors.length; i++) {
                        stops.push(`${activeColors[i]} ${i*step}%`);
                        stops.push(`${activeColors[i]} ${(i+1)*step}%`);
                    }
                    box.css('background-image', gradient + stops.join(', ') + ')');
                }
            }

            $('#log-gigi-' + toothNo).remove();
            if (!selectedStatuses.includes('NORMAL')) {
                let displayStatus = selectedStatuses.map(s => `<span class="ent-badge-pill me-1" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.35);">${conditionOpts[s]}</span>`).join('');
                let row = `<tr id="log-gigi-${toothNo}"><td class="text-center fw-bold align-middle" style="font-family: 'JetBrains Mono', monospace;">${toothNo}</td><td class="align-middle">${displayStatus}</td><td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" id="catatan-gigi-${toothNo}" class="form-control form-control-sm" value="${catatan}"></td></tr>`;
                $('#tabel-log-gigi tbody').append(row);
            }
        }
    });

    // --- ORDER PEMERIKSAAN DENGAN TARIF PENJAMIN ---
    $('#btn-tambah-pemeriksaan').click(function() {
        let select = $('#input_pemeriksaan option:selected');
        let id = select.val();
        let nama = select.data('nama');
        let kategori = select.data('kategori');
        let harga = select.data('harga');

        if (!id) return Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih pemeriksaan!'
        });

        let row = `
            <tr>
                <td class="fw-semibold">
                    ${nama}
                    <input type="hidden" name="order_pemeriksaan_id[]" value="${id}">
                    <input type="hidden" name="order_tarif[]" value="${harga}">
                </td>
                <td><span class="ent-badge-pill" style="background: rgba(14, 165, 233, 0.14); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.35);">${kategori}</span></td>
                <td class="fw-bold">Rp ${parseInt(harga).toLocaleString('id-ID')}</td>
                <td class="action-cell-full text-center"><button type="button" class="btn btn-hapus-row" title="Hapus"><i class="fas fa-trash"></i></button></td>
            </tr>`;
        $('#tabel-order-pemeriksaan tbody').append(row);
        $('#input_pemeriksaan').val('');
    });

    // --- TAMBAH E-RESEP ---
    $('#btn-tambah-resep').click(function() {
        let select = $('#input_obat option:selected');
        let kodeObat = select.val();
        let nama = select.data('nama');
        let satuan = select.data('satuan');
        let harga = select.data('harga');
        let stok = parseInt(select.data('stok') || 0);
        let jumlah = parseInt($('#input_jumlah_obat').val());
        let signa = $('#input_signa_obat').val();

        if (!kodeObat || !jumlah || !signa) {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih obat, isi jumlah dan aturan pakai!'
            });
        }

        if (jumlah > stok) {
            return Swal.fire({
                icon: 'error',
                title: 'Stok Tidak Cukup',
                text: `Stok obat saat ini tersisa ${stok} ${satuan}.`
            });
        }

        let row = `
            <tr>
                <td class="fw-semibold">
                    ${nama}
                    <input type="hidden" name="resep_obat_code[]" value="${kodeObat}">
                    <input type="hidden" name="resep_harga[]" value="${harga}">
                </td>
                <td class="text-center fw-semibold">
                    ${jumlah} ${satuan}
                    <input type="hidden" name="resep_jumlah[]" value="${jumlah}">
                </td>
                <td class="fw-bold">Rp ${parseInt(harga * jumlah).toLocaleString('id-ID')}</td>
                <td>
                    ${signa}
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                </td>
                <td class="action-cell-full text-center">
                    <button type="button" class="btn btn-hapus-row" title="Hapus"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;

        $('#tabel-resep-obat tbody').append(row);
        $('#input_obat').val('');
        $('#input_jumlah_obat').val('1');
        $('#input_signa_obat').val('');
    });

    $(document).on('click', '.btn-hapus-row', function() {
        $(this).closest('tr').remove();
    });

    // --- SIMPAN FINAL ---
    $('#button-save-data-diagnosa-pasien-poli').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Simpan Pemeriksaan?",
            text: "Data anamnesa, order tindakan, resep, dan diagnosa akan disimpan secara final.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: 'btn btn-success px-4 mx-2',
                cancelButton: 'btn btn-outline-secondary px-4 mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $('#form-handling-medis').serialize();

                $.ajax({
                    url: "{{ route('store_handling_medis') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success px-4'
                                },
                                buttonsStyling: false
                            }).then(() => {
                                $('.modal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            }
        });
    });
</script>
<script>
    // --- AUTOLOAD DATA LAMA JIKA SUDAH PERNAH DIISI ---
    $(document).ready(function() {
        @if(isset($existing_soap) && $existing_soap)
            // 1. Munculkan Diagnosa Akhir yang lama
            $('textarea[name="diagnosa_akhir"]').val("{{ $existing_soap->asesmen }}");

            // 2. Jika Poli Gigi, Load Odontogram lama dari JSON
            @if($template_type === 'GIGI' && !empty($existing_soap->data_spesifik_poli))
                let savedData = {!! $existing_soap->data_spesifik_poli !!};

                if (savedData.kalkulus) {
                    $('select[name="gigi_kalkulus"]').val(savedData.kalkulus);
                }

                if (savedData.gigi_status) {
                    for (const [toothNo, statusStr] of Object.entries(savedData.gigi_status)) {
                        if (statusStr !== 'NORMAL') {
                            let inputHidden = $('#input-gigi-' + toothNo);
                            inputHidden.val(statusStr);
                            let statuses = statusStr.split(',');
                            let box = $(`[data-tooth="${toothNo}"]`);

                            // Warnai kotak gigi
                            box.removeClass('tooth-normal');
                            const colorMap = {'KARIES': 'var(--tooth-red)', 'TAMBALAN': 'var(--tooth-blue)', 'HILANG': 'var(--tooth-dark)', 'SISA_AKAR': 'var(--tooth-gray)'};
                            let activeColors = statuses.map(s => colorMap[s]);
                            box.css({'color': '#ffffff', 'text-shadow': '0 1px 2px rgba(0,0,0,0.6)'});

                            if(activeColors.length === 1) {
                                box.css('background-color', activeColors[0]);
                            } else {
                                let gradient = 'linear-gradient(135deg, ', step = 100 / activeColors.length, stops = [];
                                for(let i=0; i < activeColors.length; i++) {
                                    stops.push(`${activeColors[i]} ${i*step}%`);
                                    stops.push(`${activeColors[i]} ${(i+1)*step}%`);
                                }
                                box.css('background-image', gradient + stops.join(', ') + ')');
                            }

                            // Masukkan ke tabel rincian gigi
                            let conditionOpts = {'KARIES': 'Karies (Berlubang)', 'TAMBALAN': 'Tumpatan (Tambalan)', 'HILANG': 'Hilang / Dicabut', 'SISA_AKAR': 'Sisa Akar'};
                            let displayStatus = statuses.map(s => `<span class="ent-badge-pill me-1" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.35);">${conditionOpts[s]}</span>`).join('');
                            let catatanVal = savedData.gigi_catatan[toothNo] || '';

                            let row = `<tr id="log-gigi-${toothNo}">
                                <td class="text-center fw-bold align-middle" style="font-family: 'JetBrains Mono', monospace;">${toothNo}</td>
                                <td class="align-middle">${displayStatus}</td>
                                <td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" id="catatan-gigi-${toothNo}" class="form-control form-control-sm" value="${catatanVal}"></td>
                            </tr>`;
                            $('#tabel-log-gigi tbody').append(row);
                        }
                    }
                }
            @endif
        @endif

        // 3. Load Tabel Order Tindakan Lama
        @if(isset($existing_tindakan))
            @foreach($existing_tindakan as $tind)
                let rowTindakan = `
                    <tr>
                        <td class="fw-semibold">{{ $tind->nama_layanan }}<input type="hidden" name="order_pemeriksaan_id[]" value="{{ $tind->id }}"></td>
                        <td><span class="ent-badge-pill" style="background: rgba(14, 165, 233, 0.14); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.35);">{{ $tind->kategori_tindakan }}</span></td>
                        <td class="fw-bold">Rp {{ number_format($tind->tarif, 0, ',', '.') }}</td>
                        <td class="action-cell-full text-center"><button type="button" class="btn btn-hapus-row" title="Hapus"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $('#tabel-order-pemeriksaan tbody').append(rowTindakan);
            @endforeach
        @endif

        // 4. Load Tabel Resep Obat Lama
        @if(isset($existing_resep))
            @foreach($existing_resep as $rsp)
                let rowResep = `
                    <tr>
                        <td class="fw-semibold">
                            {{ $rsp->farm_data_obat_name }}
                            <input type="hidden" name="resep_obat_code[]" value="{{ $rsp->farm_data_obat_code }}">
                            <input type="hidden" name="resep_harga[]" value="{{ $rsp->harga }}">
                        </td>
                        <td class="text-center fw-semibold">
                            {{ $rsp->qty }} {{ $rsp->farm_data_obat_satuan }}
                            <input type="hidden" name="resep_jumlah[]" value="{{ $rsp->qty }}">
                        </td>
                        <td class="fw-bold">Rp {{ number_format($rsp->harga * $rsp->qty, 0, ',', '.') }}</td>
                        <td>
                            {{ $rsp->signa }}
                            <input type="hidden" name="resep_signa[]" value="{{ $rsp->signa }}">
                        </td>
                        <td class="action-cell-full text-center">
                            <button type="button" class="btn btn-hapus-row" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                $('#tabel-resep-obat tbody').append(rowResep);
            @endforeach
        @endif
    });
</script>
