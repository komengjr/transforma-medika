<style>
    /* =========================================
       MODERN ENTERPRISE PREVIEW & VERIFY MODAL
       (SYNCED WITH LIST-PASIEN-REGISTRASI UI)
       ========================================= */
    .ent-modal-wrap {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --tooth-red: #ef4444;
        --tooth-blue: #3b82f6;
        --tooth-dark: #1e293b;
        --tooth-gray: #64748b;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px;
        overflow: hidden;
    }

    .ent-modal-wrap .ent-section-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: var(--bs-body-bg);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .ent-modal-wrap .ent-banner-top {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-modal-wrap .ent-banner-top::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;

        pointer-events: none;
    }

    .ent-modal-wrap .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-modal-wrap .form-header-ent {
        background-color: rgba(79, 70, 229, 0.09);
        color: var(--bs-body-color);
        padding: 13px 18px;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .ent-modal-wrap .form-label-ent {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
        display: block;
    }

    .ent-modal-wrap .form-control,
    .ent-modal-wrap .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg) !important;
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--bs-body-color) !important;
        border-radius: 10px !important;
        padding: 8px 12px;
        transition: all 0.2s ease;
    }

    .ent-modal-wrap input.form-control,
    .ent-modal-wrap select.form-select {
        height: 42px;
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
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        font-size: 0.82rem;
    }

    .ent-modal-wrap .btn-ent:hover {
        transform: translateY(-1px);
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

    .ent-modal-wrap .btn-ent-outline {
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-modal-wrap .btn-ent-outline:hover {
        background-color: rgba(79, 70, 229, 0.08);
        border-color: var(--ent-indigo);
        color: var(--bs-body-color);
    }

    /* Enterprise Table with Colored Grid */
    .ent-modal-wrap .table-ent {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .ent-modal-wrap .table-ent thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px 12px;
        letter-spacing: 0.04em;
    }

    .ent-modal-wrap .table-ent thead th:first-child {
        border-left: none !important;
    }

    .ent-modal-wrap .table-ent thead th:last-child {
        border-right: none !important;
    }

    .ent-modal-wrap .table-ent tbody tr {
        transition: background-color 0.15s ease;
    }

    .ent-modal-wrap .table-ent tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .ent-modal-wrap .table-ent tbody td {

        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .ent-modal-wrap .table-ent tbody td:first-child {
        border-left: none !important;
    }

    .ent-modal-wrap .table-ent tbody td:last-child {
        border-right: none !important;
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

    .tooth-normal {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        text-shadow: none;
        background-image: none !important;
    }

    .ent-badge-pill {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
    }
</style>

<div class="modal-body p-0 ent-modal-wrap">
    <!-- HEADER BANNER -->
    <div class="ent-banner-top p-3 p-md-4">
        <div class="row align-items-center gy-2 position-relative" style="z-index: 2;">
            <div class="col-md-8 d-flex align-items-center">
                <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width: 52px; height: 52px;">
                    <i class="fas fa-stethoscope text-info fs-2"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="ent-badge-pill" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                            <i class="fas fa-file-medical me-1"></i> TEMPLATE: {{ $template_type }}
                        </span>
                        <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Otorisasi Pemeriksaan Medis</span>
                    </div>
                    <h5 class="mb-0 text-white fw-bold" style="letter-spacing: -0.02em;">
                        Pratinjau & Verifikasi: <span class="fw-normal" style="color: #cbd5e1;">{{ $data->m_poli_name ?? 'Poliklinik' }}</span>
                    </h5>
                </div>
            </div>
            <div class="col-md-4 text-md-end pe-md-4">
                <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                    <span class="fw-bold text-white" style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">
                        <i class="fas fa-hashtag text-info me-1"></i>{{ $data->no_registrasi }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3 p-md-4 bg-white">
        <div class="row g-3">
            <!-- IDENTITAS PASIEN -->
            <div class="col-12">
                <div class="ent-section-card p-0">
                    <div class="row g-0">
                        <div class="col-md-2 d-flex align-items-center justify-content-center p-3" style="background: rgba(79, 70, 229, 0.07); border-right: 1px solid var(--ent-grid-border);">
                            @if (empty($data->master_patient_profile))
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle shadow-sm" alt="Foto" style="width: 76px; height: 76px; object-fit: cover; border: 2px solid rgba(99, 102, 241, 0.45);">
                            @else
                                <img src="{{ $data->master_patient_profile }}" class="rounded-circle shadow-sm" alt="Foto" style="width: 76px; height: 76px; object-fit: cover; border: 2px solid rgba(99, 102, 241, 0.45);">
                            @endif
                        </div>
                        <div class="col-md-10 p-3 p-md-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <span class="form-label-ent">Nama Pasien</span>
                                    <div class="fw-bold fs-2">{{ $data->master_patient_name }}</div>
                                    <div class="fw-semibold opacity-75 mt-1" style="font-size: 0.78rem; font-family: 'JetBrains Mono', monospace;">
                                        <i class="fas fa-qrcode text-primary me-1"></i>RM: {{ $data->master_patient_code }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span class="form-label-ent">Gender & Tgl Lahir</span>
                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
                                    <div class="fw-semibold opacity-75 mt-1" style="font-size: 0.82rem;">
                                        <i class="far fa-calendar-alt me-1"></i>{{ $data->master_patient_tgl_lahir }}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <span class="form-label-ent">Dokter & Penjamin</span>
                                    <div class="fw-bold" style="font-size: 0.88rem;">
                                        <i class="fas fa-user-md text-primary me-1"></i> {{ $data->master_doctor_name ?? 'Belum Ditentukan' }}
                                    </div>
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

            <!-- FORM HANDLING PREVIEW -->
            <div class="col-12">
                <form id="form-handling-medis">
                    @csrf
                    <input type="hidden" name="no_registrasi" value="{{ $code }}">
                    <input type="hidden" name="jenis_template" value="{{ $template_type }}">

                    <!-- ODONTOGRAM PREVIEW (JIKA POLI GIGI & MENU AKTIF) -->
                    @if($template_type === 'GIGI' && in_array('odontogram', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-tooth text-warning"></i> Pratinjau Odontogram Interaktif & Asesmen Gigi
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="odontogram-container">
                                        <h6 class="fw-bold mb-1 pb-1 text-uppercase opacity-75" style="font-size: 0.72rem; letter-spacing: 0.04em; border-bottom: 1px solid var(--ent-grid-border);">RAHANG ATAS</h6>
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
                                        <h6 class="fw-bold mt-1 pt-1 text-uppercase opacity-75" style="font-size: 0.72rem; letter-spacing: 0.04em; border-top: 1px solid var(--ent-grid-border);">RAHANG BAWAH</h6>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                                        <div class="d-flex align-items-center gap-2"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; border:1.5px solid var(--ent-grid-border); background:var(--bs-body-bg);"></span> <span class="fw-semibold small">Normal</span></div>
                                        <div class="d-flex align-items-center gap-2"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-red);"></span> <span class="fw-semibold small">Karies/Lubang</span></div>
                                        <div class="d-flex align-items-center gap-2"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-blue);"></span> <span class="fw-semibold small">Tumpatan/Tambal</span></div>
                                        <div class="d-flex align-items-center gap-2"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-dark);"></span> <span class="fw-semibold small">Hilang/Cabut</span></div>
                                        <div class="d-flex align-items-center gap-2"><span style="display:inline-block; width:14px; height:14px; border-radius: 4px; background:var(--tooth-gray);"></span> <span class="fw-semibold small">Sisa Akar</span></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Kalkulus / Karang Gigi</label>
                                    <select class="form-select" name="gigi_kalkulus">
                                        <option value="TIDAK_ADA">Tidak Ada</option>
                                        <option value="RINGAN">Ringan</option>
                                        <option value="SEDANG">Sedang</option>
                                        <option value="BERAT">Berat</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Catatan Khusus Gigi Utama</label>
                                    <textarea class="form-control" rows="2" name="keluhan_gigi"></textarea>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label-ent mb-2">Rincian Tindakan per Gigi</label>
                                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                        <table class="table table-ent w-100 mb-0" id="tabel-log-gigi">
                                            <thead>
                                                <tr>
                                                    <th width="15%" class="text-center">No Gigi</th>
                                                    <th width="35%">Kondisi / Diagnosa</th>
                                                    <th width="50%">Catatan / Rencana</th>
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

                    <!-- ANAMNESA PREVIEW -->
                    @if(in_array('anamnesa', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-comment-medical text-info"></i> Pratinjau Anamnesa & Riwayat Medis
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-ent">Keluhan Utama</label>
                                    <textarea name="keluhan_utama" class="form-control" rows="2">{{ $existing_anamnesa->keluhan_utama ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Riwayat Penyakit Sekarang</label>
                                    <textarea name="riwayat_penyakit_sekarang" class="form-control" rows="2">{{ $existing_anamnesa->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Riwayat Penyakit Dahulu</label>
                                    <textarea name="riwayat_penyakit_dahulu" class="form-control" rows="2">{{ $existing_anamnesa->riwayat_penyakit_dahulu ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-ent">Riwayat Penyakit Keluarga</label>
                                    <input type="text" name="riwayat_penyakit_keluarga" class="form-control" value="{{ $existing_anamnesa->riwayat_penyakit_keluarga ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-ent">Riwayat Alergi</label>
                                    <input type="text" name="riwayat_alergi" class="form-control" value="{{ $existing_anamnesa->riwayat_alergi ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-ent">Riwayat Penggunaan Obat</label>
                                    <input type="text" name="riwayat_penggunaan_obat" class="form-control" value="{{ $existing_anamnesa->riwayat_penggunaan_obat ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- VITAL SIGN PREVIEW -->
                    @if(in_array('vital_sign', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-heartbeat text-danger"></i> Pratinjau Tanda Vital & Fisik Umum
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label-ent">Kesadaran</label>
                                    <select name="kesadaran" class="form-select">
                                        @php $kesadaranVal = $existing_vs->kesadaran ?? 'Compos Mentis'; @endphp
                                        <option value="Compos Mentis" {{ $kesadaranVal == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                        <option value="Apatis" {{ $kesadaranVal == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                        <option value="Delirium" {{ $kesadaranVal == 'Delirium' ? 'selected' : '' }}>Delirium</option>
                                        <option value="Somnolen" {{ $kesadaranVal == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                        <option value="Sopor" {{ $kesadaranVal == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                        <option value="Coma" {{ $kesadaranVal == 'Coma' ? 'selected' : '' }}>Coma</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Tekanan Darah (TD)</label>
                                    <input type="text" name="tekanan_darah" class="form-control" value="{{ $existing_vs->tekanan_darah ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Nadi</label>
                                    <input type="number" name="nadi" class="form-control" value="{{ $existing_vs->nadi ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Suhu Tubuh</label>
                                    <input type="number" step="0.1" name="suhu" class="form-control" value="{{ $existing_vs->suhu ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Pernapasan (RR)</label>
                                    <input type="number" name="pernapasan" class="form-control" value="{{ $existing_vs->pernapasan ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Saturasi O2</label>
                                    <input type="number" name="saturasi_o2" class="form-control" value="{{ $existing_vs->saturasi_o2 ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Berat Badan (BB)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="form-control" value="{{ $existing_vs->berat_badan ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Tinggi Badan (TB)</label>
                                    <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ $existing_vs->tinggi_badan ?? '' }}">
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label-ent">Pemeriksaan Fisik Lain</label>
                                    <textarea name="pemeriksaan_fisik_lain" class="form-control" rows="2">{{ $existing_vs->pemeriksaan_fisik_lain ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ORDER TINDAKAN PREVIEW -->
                    @if(in_array('tindakan', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-vial text-primary"></i> Pratinjau Order Tindakan / Pemeriksaan
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-ent w-100 mb-0">
                                    <thead>
                                        <tr>
                                            <th width="60%">Nama Tindakan</th>
                                            <th width="20%">Kategori</th>
                                            <th width="20%" class="text-end">Tarif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($existing_tindakan ?? [] as $tind)
                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $tind->nama_layanan }}
                                                <input type="hidden" name="order_pemeriksaan_id[]" value="{{ $tind->id }}">
                                                <input type="hidden" name="order_tarif[]" value="{{ $tind->tarif }}">
                                            </td>
                                            <td>
                                                <span class="ent-badge-pill" style="background: rgba(14, 165, 233, 0.14); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.35);">
                                                    {{ $tind->kategori_tindakan }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($tind->tarif, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center opacity-75 py-4">Belum ada order tindakan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- E-RESEP PREVIEW -->
                    @if(in_array('resep', $menu_aktif))
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-pills text-warning"></i> Pratinjau E-Resep Obat
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-ent w-100 mb-0">
                                    <thead>
                                        <tr>
                                            <th width="40%">Nama Obat</th>
                                            <th width="15%" class="text-center">Jumlah</th>
                                            <th width="20%" class="text-end">Subtotal Harga</th>
                                            <th width="25%">Aturan Pakai (Signa)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($existing_resep ?? [] as $rsp)
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
                                            <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($rsp->harga * $rsp->qty, 0, ',', '.') }}</td>
                                            <td>
                                                {{ $rsp->signa }}
                                                <input type="hidden" name="resep_signa[]" value="{{ $rsp->signa }}">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center opacity-75 py-4">Belum ada resep obat.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- DIAGNOSA AKHIR -->
                    @if(in_array('diagnosa', $menu_aktif))
                    <div class="ent-section-card mb-0">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-stethoscope text-success"></i> Diagnosa Utama Dokter
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <textarea name="diagnosa_akhir" class="form-control" rows="2" required>{{ $existing_soap->asesmen ?? '' }}</textarea>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Footer Action Button -->
            <div class="col-12 mt-3 pt-3 d-flex justify-content-end gap-2" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn btn-ent btn-ent-outline px-4 py-2" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-ent btn-ent-success px-4 py-2" id="button-save-data-diagnosa-pasien-poli">
                    <i class="fas fa-check-circle me-2"></i> Verifikasi & Setujui Pemeriksaan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- AUTOLOAD DATA LAMA PADA PRATINJAU (VERIFIKASI) ---
    $(document).ready(function() {
        @if(isset($existing_soap) && $existing_soap)
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

                            let conditionOpts = {'KARIES': 'Karies (Berlubang)', 'TAMBALAN': 'Tumpatan (Tambalan)', 'HILANG': 'Hilang / Dicabut', 'SISA_AKAR': 'Sisa Akar'};
                            let displayStatus = statuses.map(s => `<span class="ent-badge-pill me-1" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.35);">${conditionOpts[s]}</span>`).join('');
                            let catatanVal = savedData.gigi_catatan[toothNo] || '';

                            let row = `<tr id="log-gigi-${toothNo}">
                                <td class="text-center fw-bold align-middle" style="font-family: 'JetBrains Mono', monospace;">${toothNo}</td>
                                <td class="align-middle">${displayStatus}</td>
                                <td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" class="form-control form-control-sm" value="${catatanVal}"></td>
                            </tr>`;
                            $('#tabel-log-gigi tbody').append(row);
                        }
                    }
                }
            @endif
        @endif
    });
</script>
