<style>
    /* =========================================
       MODERN ENTERPRISE HANDLING IGD MODAL
       (SYNCED WITH ENTERPRISE HEALTHCARE UI)
       ========================================= */
    .ent-igd-modal {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px;
        overflow: hidden;
    }

    [data-bs-theme="dark"] .ent-igd-modal,
    .dark .ent-igd-modal {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    .ent-igd-modal .ent-banner-top {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-igd-modal .ent-banner-top::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(244, 63, 94, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-igd-modal .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-igd-modal .ent-badge-pill {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
    }

    .ent-igd-modal .ent-section-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.06);
        background-color: var(--bs-body-bg);
        overflow: hidden;
    }

    .ent-igd-modal .form-header-ent {
        background-color: rgba(79, 70, 229, 0.09);
        color: var(--bs-body-color);
        padding: 12px 16px;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .ent-igd-modal .form-label-ent {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
        display: block;
    }

    /* Modern Enterprise Nav Tabs */
    .ent-igd-modal .ent-nav-tabs {
        background-color: rgba(79, 70, 229, 0.06);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 5px;
        gap: 6px;
        display: flex;
        flex-wrap: wrap;
    }

    .ent-igd-modal .ent-nav-tabs .nav-link {
        border: none !important;
        border-radius: 9px !important;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--bs-body-color);
        padding: 9px 14px;
        transition: all 0.18s ease;
        background: transparent;
    }

    .ent-igd-modal .ent-nav-tabs .nav-link:hover {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--ent-indigo);
    }

    .ent-igd-modal .ent-nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    /* Form Controls */
    .ent-igd-modal .ent-input,
    .ent-igd-modal .form-control,
    .ent-igd-modal .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg) !important;
        font-weight: 600 !important;
        font-size: 0.82rem !important;
        color: var(--bs-body-color) !important;
        border-radius: 10px !important;
        box-shadow: none !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-igd-modal input.ent-input,
    .ent-igd-modal select.ent-input {
        height: 42px !important;
    }

    .ent-igd-modal .ent-input:focus,
    .ent-igd-modal .form-control:focus,
    .ent-igd-modal .form-select:focus,
    .ent-igd-modal textarea:focus {
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        border-color: var(--ent-indigo) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling di Dalam Modal */
    .ent-igd-modal .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .ent-igd-modal .select2-container--bootstrap-5 .select2-selection {
        min-height: 42px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 11px !important;
        padding-right: 30px !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .ent-igd-modal .select2-container--bootstrap-5.select2-container--disabled .select2-selection {
        background-color: rgba(99, 102, 241, 0.08) !important;
        opacity: 0.75 !important;
    }

    .ent-igd-modal .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .ent-igd-modal .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .ent-igd-modal .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.4 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal {
        background-color: var(--ent-solid-bg, #ffffff) !important;
        color: var(--ent-solid-text, #0f172a) !important;
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.28) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1095 !important;
        font-size: 0.82rem;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal,
    .dark .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-search--dropdown {
        background-color: inherit !important;
        padding: 8px !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.24);
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-search--dropdown .select2-search__field {
        background-color: inherit !important;
        color: inherit !important;
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-radius: 8px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
        opacity: 1 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-results__options {
        background-color: inherit !important;
        color: inherit !important;
        max-height: 240px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-results__option {
        background-color: inherit !important;
        color: inherit !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 8px 12px !important;
        line-height: 1.35 !important;
        opacity: 1 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-results__option--highlighted[aria-selected] {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown.select2-dropdown-igd-modal .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: #4f46e5 !important;
    }

    /* Modern Buttons */
    .ent-igd-modal .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        font-size: 0.82rem;
        border: none;
        box-shadow: none;
    }

    .ent-igd-modal .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-igd-modal .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-igd-modal .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-igd-modal .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-igd-modal .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-igd-modal .ent-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .ent-igd-modal .ent-btn-warning:hover {
        box-shadow: 0 6px 16px rgba(217, 119, 6, 0.35);
        color: #ffffff;
    }

    .ent-igd-modal .ent-btn-outline {
        border: 1px solid var(--ent-grid-border);
        background-color: transparent;
        color: var(--bs-body-color);
    }

    .ent-igd-modal .ent-btn-outline:hover {
        background-color: rgba(79, 70, 229, 0.08);
        border-color: var(--ent-indigo);
        color: var(--bs-body-color);
    }

    /* Enterprise Table with Colored Grid */
    .ent-igd-modal .table-ent {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-bg: rgba(99, 102, 241, 0.03);
        --bs-table-hover-bg: rgba(79, 70, 229, 0.07);
        --bs-table-color: var(--bs-body-color);
        --bs-table-border-color: var(--ent-grid-border);
    }

    .ent-igd-modal .table-ent thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 11px 12px;
        letter-spacing: 0.04em;
    }

    .ent-igd-modal .table-ent thead th:first-child {
        border-left: none !important;
    }

    .ent-igd-modal .table-ent thead th:last-child {
        border-right: none !important;
    }

    .ent-igd-modal .table-ent tbody td {
        background-color: transparent !important;
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .ent-igd-modal .table-ent tbody td:first-child {
        border-left: none !important;
    }

    .ent-igd-modal .table-ent tbody td:last-child {
        border-right: none !important;
    }

    .ent-igd-modal .table-ent tfoot td {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-top: 2px solid rgba(79, 70, 229, 0.45) !important;
        border-bottom: none !important;
        border-left: 1px solid var(--ent-grid-border) !important;
        border-right: 1px solid var(--ent-grid-border) !important;
        padding: 11px 12px;
        color: var(--bs-body-color) !important;
    }

    .ent-igd-modal .table-ent tfoot td:first-child {
        border-left: none !important;
    }

    .ent-igd-modal .table-ent tfoot td:last-child {
        border-right: none !important;
    }
</style>

<div class="modal-body p-0 ent-igd-modal">
    <!-- HEADER HERO BANNER -->
    <div class="ent-banner-top p-3 p-md-4">
        <div class="row align-items-center gy-2 position-relative" style="z-index: 2;">
            <div class="col-md-8 d-flex align-items-center">
                <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width: 52px; height: 52px;">
                    <i class="fas fa-notes-medical text-danger fs-5"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="ent-badge-pill" style="background: rgba(244, 63, 94, 0.22); border: 1px solid rgba(244, 63, 94, 0.45); color: #fda4af;">
                            <i class="fas fa-ambulance me-1"></i> PENANGANAN IGD
                        </span>
                        <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Emergency Medical Record</span>
                    </div>
                    <h5 class="mb-0 text-white fw-bold" style="letter-spacing: -0.02em;">
                        {{ $pasien->nama_pasien }}
                    </h5>
                </div>
            </div>
            <div class="col-md-4 text-md-end pe-md-4">
                <div class="ent-glass-pill d-inline-flex flex-column align-items-end px-3 py-2">
                    <span class="fw-bold text-white" style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">
                        <i class="fas fa-hashtag text-info me-1"></i>{{ $pasien->no_registrasi }}
                    </span>
                    <span style="color: #cbd5e1; font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">
                        RM: {{ $pasien->pid }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3 p-md-4" style="background-color: var(--bs-body-bg);">
        <!-- INFORMASI SINGKAT PASIEN -->
        <div class="ent-section-card p-3 mb-4" style="background-color: rgba(79, 70, 229, 0.04);">
            <div class="row g-3 align-items-center">
                <div class="col-6 col-md-3">
                    <span class="form-label-ent">No. Registrasi</span>
                    <span class="ent-badge-pill" style="background: rgba(244, 63, 94, 0.14); color: #e11d48; border: 1px solid rgba(244, 63, 94, 0.35); font-family: 'JetBrains Mono', monospace;">
                        {{ $pasien->no_registrasi }}
                    </span>
                </div>
                <div class="col-6 col-md-3">
                    <span class="form-label-ent">Tanggal &amp; Jam Masuk</span>
                    <div class="fw-bold" style="font-size: 0.84rem;">
                        <i class="far fa-clock text-primary me-1"></i>{{ date('d/m/Y H:i', strtotime($pasien->tanggal_registrasi)) }}
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <span class="form-label-ent">Penjamin / Kelompok</span>
                    <div>
                        <span class="ent-badge-pill" style="background: rgba(16, 185, 129, 0.14); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);">
                            <i class="fas fa-shield-alt me-1"></i>{{ $pasien->nama_penjamin ?? 'Umum' }} - {{ $pasien->nama_sub_penjamin }}
                        </span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <span class="form-label-ent">Dokter Jaga IGD</span>
                    <div class="fw-bold" style="font-size: 0.84rem;">
                        <i class="fas fa-user-md text-primary me-1"></i>{{ $pasien->nama_dokter ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB NAVIGASI HANDLING -->
        <ul class="nav ent-nav-tabs mb-4" id="handlingTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="triase-tab" data-bs-toggle="tab" data-bs-target="#triase-pane" type="button" role="tab">
                    <i class="fas fa-heartbeat me-1"></i> 1. Triase &amp; TTV
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="soap-tab" data-bs-toggle="tab" data-bs-target="#soap-pane" type="button" role="tab">
                    <i class="fas fa-id-card me-1"></i> 2. Anamnesis (SOAP)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tindakan-tab" data-bs-toggle="tab" data-bs-target="#tindakan-pane" type="button" role="tab">
                    <i class="fas fa-stethoscope me-1"></i> 3. Tindakan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep-pane" type="button" role="tab">
                    <i class="fas fa-pills me-1"></i> 4. E-Resep Obat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="disposisi-tab" data-bs-toggle="tab" data-bs-target="#disposisi-pane" type="button" role="tab">
                    <i class="fas fa-door-open me-1"></i> 5. Disposisi
                </button>
            </li>
        </ul>

        <form id="form-handling-igd">
            @csrf
            <input type="hidden" name="registrasi_id" value="{{ $pasien->id }}">
            <input type="hidden" id="current_sub_penjamin_id" value="{{ $pasien->sub_penjamin_id }}">

            <div class="tab-content" id="handlingTabContent">
                <!-- PANE 1: TRIASE & TTV -->
                <div class="tab-pane fade show active" id="triase-pane" role="tabpanel">
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-heartbeat text-danger"></i> Asesmen Triase &amp; Tanda-Tanda Vital (TTV)
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label-ent">Skala Triase</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-skala-triage" name="skala_triage" data-placeholder="Pilih Skala Triase">
                                        <option value="1" {{ optional($triase)->skala_triage == 1 ? 'selected' : '' }}>Level 1 - Resusitasi (Merah)</option>
                                        <option value="2" {{ optional($triase)->skala_triage == 2 ? 'selected' : '' }}>Level 2 - Emergent (Kuning)</option>
                                        <option value="3" {{ optional($triase)->skala_triage == 3 ? 'selected' : '' }}>Level 3 - Urgent (Hijau)</option>
                                        <option value="4" {{ optional($triase)->skala_triage == 4 ? 'selected' : '' }}>Level 4 - Semi Urgent / Non Urgent</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label-ent">Keluhan Utama</label>
                                    <input type="text" class="form-control ent-input" name="keluhan_utama" value="{{ optional($triase)->keluhan_utama ?? $pasien->keluhan_medis }}" placeholder="Contoh: Nyeri dada sebelah kiri, sesak napas...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Tekanan Darah (mmHg)</label>
                                    <input type="text" class="form-control ent-input" name="tekanan_darah" value="{{ optional($triase)->tekanan_darah }}" placeholder="120/80">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Nadi (x/menit)</label>
                                    <input type="text" class="form-control ent-input" name="nadi" value="{{ optional($triase)->nadi }}" placeholder="80">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Suhu (°C)</label>
                                    <input type="text" class="form-control ent-input" name="suhu" value="{{ optional($triase)->suhu }}" placeholder="36.5">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Saturasi Oksigen (%)</label>
                                    <input type="text" class="form-control ent-input" name="saturasi_oksigen" value="{{ optional($triase)->saturasi_oksigen }}" placeholder="98">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Pernapasan (x/menit)</label>
                                    <input type="text" class="form-control ent-input" name="pernapasan" value="{{ optional($triase)->pernapasan }}" placeholder="20">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Kesadaran (GCS / AVPU)</label>
                                    <input type="text" class="form-control ent-input" name="kesadaran" value="{{ optional($triase)->kesadaran }}" placeholder="Compos Mentis (E4V5M6)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PANE 2: ANAMNESIS SOAP -->
                <div class="tab-pane fade" id="soap-pane" role="tabpanel">
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-comment-medical text-info"></i> Catatan Perkembangan Pasien (SOAP)
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-ent">Subjektif (Anamnesis)</label>
                                    <textarea class="form-control ent-input" name="subjektif" rows="3" placeholder="Keluhan tambahan riwayat penyakit...">{{ optional($soap)->subjektif }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Objektif (Pemeriksaan Fisik)</label>
                                    <textarea class="form-control ent-input" name="objektif" rows="3" placeholder="Hasil pemeriksaan fisik organ...">{{ optional($soap)->objektif }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Asesmen (Diagnosis Kerja)</label>
                                    <textarea class="form-control ent-input" name="asesmen" rows="3" placeholder="Diagnosis medis...">{{ optional($soap)->asesmen }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Planning (Rencana Terapi / Instruksi)</label>
                                    <textarea class="form-control ent-input" name="planning" rows="3" placeholder="Rencana pengobatan, diet, atau observasi...">{{ optional($soap)->planning }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PANE 3: TINDAKAN & LAYANAN -->
                <div class="tab-pane fade" id="tindakan-pane" role="tabpanel">
                    <div class="ent-section-card mb-3">
                        <div class="form-header-ent d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-plus-circle text-primary"></i> Order Pemeriksaan &amp; Tindakan IGD
                            </span>
                            <span class="ent-badge-pill" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">
                                Tarif Berlaku: {{ $pasien->nama_sub_penjamin ?? 'UMUM' }}
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-9">
                                    <label class="form-label-ent">Cari Pemeriksaan / Tindakan Medis</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-master-tindakan" data-placeholder="-- Cari Layanan Medis / Tindakan IGD --" disabled>
                                        <option value="">-- Memuat Data Layanan... --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn ent-btn ent-btn-success w-100 d-flex align-items-center justify-content-center gap-2" id="btn-tambah-tindakan-list" style="height: 42px;">
                                        <i class="fas fa-plus"></i> Tambah Tindakan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ent-section-card">
                        <div class="table-responsive">
                            <table class="table table-ent align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start">Nama Tindakan / Pemeriksaan</th>
                                        <th class="text-end" style="width: 190px;">Tarif (Rp)</th>
                                        <th class="text-center" style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tindakan-terpilih-tbody">
                                    @forelse($tindakanList as $tindakan)
                                    <tr data-id="{{ $tindakan->master_pemeriksaan_id }}" data-tarif="{{ $tindakan->tarif ?? 0 }}">
                                        <td class="fw-semibold">
                                            {{ $tindakan->nama_layanan }}
                                            <input type="hidden" name="tindakan_ids[]" value="{{ $tindakan->master_pemeriksaan_id }}">
                                            <input type="hidden" name="tarif_tindakan[]" value="{{ $tindakan->tarif ?? 0 }}">
                                        </td>
                                        <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($tindakan->tarif ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger rounded-2 py-1 px-2 btn-hapus-tindakan" title="Hapus Tindakan">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="empty-row-tindakan">
                                        <td colspan="3" class="text-center opacity-75 py-4 fw-semibold">Belum ada tindakan atau pemeriksaan yang ditambahkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end fw-bold text-uppercase" style="font-size: 0.8rem;">Total Harga Tindakan:</td>
                                        <td class="text-end fw-bold text-danger" id="total-tarif-text" style="font-family: 'JetBrains Mono', monospace; font-size: 0.92rem;">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- PANE 4: E-RESEP OBAT -->
                <div class="tab-pane fade" id="resep-pane" role="tabpanel">
                    <div class="ent-section-card mb-3">
                        <div class="form-header-ent d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-pills text-warning"></i> Order E-Resep Obat IGD
                            </span>
                            <span class="ent-badge-pill" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);">
                                Harga: {{ $pasien->nama_sub_penjamin ?? 'UMUM' }}
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label-ent">Cari Obat Farmasi</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-master-obat" data-placeholder="-- Cari atau Pilih Obat --">
                                        <option value="">-- Cari atau Pilih Obat --</option>
                                        @foreach($daftarObat ?? [] as $obat)
                                        <option value="{{ $obat->farm_data_obat_code }}"
                                            data-nama="{{ $obat->farm_data_obat_name }}"
                                            data-satuan="{{ $obat->farm_data_obat_satuan }}"
                                            data-harga="{{ $obat->harga_jual }}">
                                            {{ $obat->farm_data_obat_name }} (Stok: {{ $obat->farm_data_obat_stok }}) - Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label-ent">Jumlah (Qty)</label>
                                    <input type="number" id="input_jumlah_obat" class="form-control ent-input text-center" min="1" value="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-ent">Signa / Aturan Pakai</label>
                                    <input type="text" id="input_signa_obat" class="form-control ent-input" placeholder="Cth: 3 x 1">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn ent-btn ent-btn-warning w-100 d-flex align-items-center justify-content-center gap-2" id="btn-tambah-resep-list" style="height: 42px;">
                                        <i class="fas fa-plus"></i> Resep
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ent-section-card">
                        <div class="table-responsive">
                            <table class="table table-ent align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start">Nama Obat</th>
                                        <th class="text-center" style="width: 110px;">Qty</th>
                                        <th class="text-start" style="width: 210px;">Aturan Pakai</th>
                                        <th class="text-end" style="width: 160px;">Subtotal (Rp)</th>
                                        <th class="text-center" style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="resep-terpilih-tbody">
                                    @forelse($resepList as $resep)
                                    <tr data-code="{{ $resep->farm_data_obat_code }}">
                                        <td class="fw-semibold">
                                            {{ $resep->farm_data_obat_name ?? 'Obat Farmasi' }}
                                            <input type="hidden" name="resep_obat_code[]" value="{{ $resep->farm_data_obat_code }}">
                                            <input type="hidden" name="resep_harga[]" value="{{ $resep->harga ?? 0 }}">
                                        </td>
                                        <td class="text-center fw-semibold">
                                            {{ $resep->qty ?? 1 }} {{ $resep->farm_data_obat_satuan ?? '' }}
                                            <input type="hidden" name="resep_jumlah[]" value="{{ $resep->qty ?? 1 }}">
                                        </td>
                                        <td>
                                            {{ $resep->signa ?? '-' }}
                                            <input type="hidden" name="resep_signa[]" value="{{ $resep->signa ?? '-' }}">
                                        </td>
                                        <td class="text-end fw-bold subtotal-obat" style="font-family: 'JetBrains Mono', monospace;">
                                            Rp {{ number_format(($resep->qty ?? 1) * ($resep->harga ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger rounded-2 py-1 px-2 btn-hapus-obat" title="Hapus Obat">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="empty-row-obat">
                                        <td colspan="5" class="text-center opacity-75 py-4 fw-semibold">Belum ada resep obat yang ditambahkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold text-uppercase" style="font-size: 0.8rem;">Total Harga Obat:</td>
                                        <td class="text-end fw-bold text-danger" id="total-obat-text" style="font-family: 'JetBrains Mono', monospace; font-size: 0.92rem;">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- PANE 5: DISPOSISI PASIEN -->
                <div class="tab-pane fade" id="disposisi-pane" role="tabpanel">
                    <div class="ent-section-card">
                        <div class="form-header-ent d-flex align-items-center gap-2">
                            <i class="fas fa-door-open text-success"></i> Status Kunjungan &amp; Disposisi Akhir Pasien
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-ent">Status Kunjungan Akhir</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-status-kunjungan" name="status_kunjungan" data-placeholder="Pilih Status Kunjungan">
                                        <option value="PROSES" {{ $pasien->status_kunjungan == 'PROSES' ? 'selected' : '' }}>Dalam Penanganan / Observasi</option>
                                        <option value="SELESAI" {{ $pasien->status_kunjungan == 'SELESAI' ? 'selected' : '' }}>Selesai / Pulang / Rawat Inap</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-ent">Tindak Lanjut / Disposisi (Verifikasi Akhir)</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-tindak-lanjut" name="tindak_lanjut" data-placeholder="Pilih Tindak Lanjut">
                                        <option value="PULANG">Pulang (Berobat Jalan / Kontrol)</option>
                                        <option value="RAWAT_INAP">Pindah Rawat Inap (Otomatis Masuk Ranap)</option>
                                        <option value="RUJUK">Rujuk ke Rumah Sakit Lain</option>
                                        <option value="MENINGGAL">Meninggal Dunia</option>
                                    </select>
                                </div>
                                <div class="col-md-12" id="div-ruangan-inap" style="display: none;">
                                    <label class="form-label-ent text-danger"><i class="fas fa-bed me-1"></i> Pilih Ruangan &amp; Bed / Kasur Rawat Inap</label>
                                    <select class="form-select ent-input select2-igd-modal" id="select-ruangan-bed" name="ruangan_bed_id" data-placeholder="-- Pilih Bed / Kasur Kosong --">
                                        <option value="">-- Pilih Bed / Kasur Kosong --</option>
                                        @foreach($ruanganInap as $bed)
                                        <option value="{{ $bed->id }}">{{ $bed->nama_ruangan ?? 'Bangsal' }} - Bed: {{ $bed->nomor_bed ?? $bed->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-ent">Catatan / Edukasi Pulang / Alasan Masuk Ranap</label>
                                    <textarea class="form-control ent-input" name="catatan_pulang" rows="3" placeholder="Instruksi dokter, indikasi rawat inap..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER ACTION BUTTONS -->
            <div class="d-flex justify-content-end gap-2 pt-3 mt-4" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn ent-btn-outline px-4 py-2" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn ent-btn ent-btn-success px-4 py-2" id="btn-simpan-handling">
                    <i class="fas fa-save me-1"></i> Simpan Handling IGD
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.cacheDataPemeriksaan = {}; // Cache tindakan medis
    window.cacheDataObat = {}; // Cache obat farmasi

    function initSelect2IgdModal(selector) {
        if (!(window.jQuery && $.fn.select2)) return;
        const $modalParent = $('#modal-handling-igd').length ? $('#modal-handling-igd') : $(document.body);

        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $modalParent,
                dropdownCssClass: 'select2-dropdown-igd-modal',
                placeholder: placeholderText,
                allowClear: hasEmptyOption,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });
    }

    // ==========================================
    // 1. LOGIKA TINDAKAN MEDIS IGD
    // ==========================================
    function hitungTotalTarif() {
        let total = 0;
        $('#tindakan-terpilih-tbody tr').each(function() {
            let tarif = parseFloat($(this).attr('data-tarif')) || 0;
            total += tarif;
        });
        $('#total-tarif-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function loadLayananTarifIGD() {
        let subPenjaminId = $('#current_sub_penjamin_id').val();
        let tindakanSelect = $('#select-master-tindakan');

        if (tindakanSelect.hasClass('select2-hidden-accessible')) {
            tindakanSelect.select2('destroy');
        }

        tindakanSelect.html('<option value="">-- Memuat Layanan... --</option>').prop('disabled', true);
        window.cacheDataPemeriksaan = {};

        $.ajax({
            url: "{{ route('api.get.tarif.igd') }}",
            type: "GET",
            data: {
                sub_penjamin_id: subPenjaminId
            },
            success: function(response) {
                tindakanSelect.html('<option value="">-- Cari Layanan Medis / Tindakan IGD --</option>');

                if (response.data && response.data.length > 0) {
                    let existingIds = [];
                    $('#tindakan-terpilih-tbody tr').each(function() {
                        let tid = $(this).data('id');
                        if (tid) existingIds.push(String(tid));
                    });

                    response.data.forEach(function(item) {
                        let isDisabled = existingIds.includes(String(item.id)) ? 'disabled' : '';
                        let tarifVal = item.tarif ? Number(item.tarif) : 0;

                        window.cacheDataPemeriksaan[item.id] = {
                            nama: item.nama_pemeriksaan,
                            tarif: tarifVal
                        };

                        let labelText = `${item.nama_pemeriksaan} - Rp ${tarifVal.toLocaleString('id-ID')}`;
                        tindakanSelect.append(`<option value="${item.id}" ${isDisabled}>${labelText}</option>`);
                    });

                    tindakanSelect.prop('disabled', false);
                    initSelect2IgdModal('#select-master-tindakan');
                } else {
                    tindakanSelect.html('<option value="">Tidak ada data layanan</option>');
                    initSelect2IgdModal('#select-master-tindakan');
                }
            },
            error: function() {
                tindakanSelect.html('<option value="">Gagal memuat layanan</option>');
                initSelect2IgdModal('#select-master-tindakan');
            }
        });
    }

    $('#btn-tambah-tindakan-list').on('click', function(e) {
        e.preventDefault();

        let idTindakan = $('#select-master-tindakan').val();
        if (!idTindakan || idTindakan === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih pemeriksaan atau tindakan terlebih dahulu!'
            });
        }

        let itemData = window.cacheDataPemeriksaan[idTindakan];
        let namaPemeriksaan = itemData ? itemData.nama : 'Pemeriksaan IGD';
        let tarifTindakan = itemData ? itemData.tarif : 0;

        let sudahAda = false;
        $('#tindakan-terpilih-tbody tr').each(function() {
            if ($(this).data('id') == idTindakan) sudahAda = true;
        });

        if (sudahAda) return Swal.fire({
            icon: 'error',
            title: 'Duplikasi',
            text: 'Pemeriksaan ini sudah ditambahkan!'
        });

        $('#empty-row-tindakan').remove();

        let htmlRow = `
            <tr data-id="${idTindakan}" data-tarif="${tarifTindakan}">
                <td class="fw-semibold">
                    ${namaPemeriksaan}
                    <input type="hidden" name="tindakan_ids[]" value="${idTindakan}">
                    <input type="hidden" name="tarif_tindakan[]" value="${tarifTindakan}">
                </td>
                <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(tarifTindakan).toLocaleString('id-ID')}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger rounded-2 py-1 px-2 btn-hapus-tindakan" title="Hapus Tindakan">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#tindakan-terpilih-tbody').append(htmlRow);
        $('#select-master-tindakan option[value="' + idTindakan + '"]').prop('disabled', true);

        hitungTotalTarif();
        $('#select-master-tindakan').val('').trigger('change');
    });

    $(document).on('click', '.btn-hapus-tindakan', function() {
        const $row = $(this).closest('tr');
        const removedId = $row.data('id');
        if (removedId) {
            $('#select-master-tindakan option[value="' + removedId + '"]').prop('disabled', false);
        }
        $row.remove();
        if ($('#tindakan-terpilih-tbody tr').length === 0) {
            $('#tindakan-terpilih-tbody').html('<tr id="empty-row-tindakan"><td colspan="3" class="text-center opacity-75 py-4 fw-semibold">Belum ada tindakan atau pemeriksaan yang ditambahkan.</td></tr>');
        }
        hitungTotalTarif();
    });

    // ==========================================
    // 2. LOGIKA E-RESEP OBAT IGD
    // ==========================================
    function hitungTotalObat() {
        let totalObat = 0;
        $('#resep-terpilih-tbody tr').each(function() {
            let harga = parseFloat($(this).find('input[name="resep_harga[]"]').val()) || 0;
            let qty = parseFloat($(this).find('input[name="resep_jumlah[]"]').val()) || 0;
            totalObat += (harga * qty);
        });
        $('#total-obat-text').text('Rp ' + totalObat.toLocaleString('id-ID'));
    }

    function setupCacheObat() {
        window.cacheDataObat = {};
        let existingCodes = [];
        $('#resep-terpilih-tbody tr').each(function() {
            let code = $(this).data('code');
            if (code) existingCodes.push(String(code));
        });

        $('#select-master-obat option').each(function() {
            let code = $(this).val();
            if (code) {
                if (existingCodes.includes(String(code))) {
                    $(this).prop('disabled', true);
                }
                window.cacheDataObat[code] = {
                    nama: $(this).attr('data-nama'),
                    satuan: $(this).attr('data-satuan'),
                    harga: parseFloat($(this).attr('data-harga')) || 0
                };
            }
        });
    }

    $('#btn-tambah-resep-list').on('click', function(e) {
        e.preventDefault();

        let kodeObat = $('#select-master-obat').val();
        if (!kodeObat || kodeObat === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih obat terlebih dahulu!'
            });
        }

        let obatData = window.cacheDataObat[kodeObat];
        let namaObat = obatData ? obatData.nama : 'Obat Farmasi';
        let satuanObat = obatData ? obatData.satuan : '';
        let hargaObat = obatData ? obatData.harga : 0;

        let qty = parseInt($('#input_jumlah_obat').val()) || 1;
        let signa = $('#input_signa_obat').val() || '-';
        let subtotal = hargaObat * qty;

        let sudahAda = false;
        $('#resep-terpilih-tbody tr').each(function() {
            if ($(this).data('code') == kodeObat) sudahAda = true;
        });

        if (sudahAda) return Swal.fire({
            icon: 'error',
            title: 'Duplikasi',
            text: 'Obat ini sudah diresepkan!'
        });

        $('#empty-row-obat').remove();

        let htmlRow = `
            <tr data-code="${kodeObat}">
                <td class="fw-semibold">
                    ${namaObat}
                    <input type="hidden" name="resep_obat_code[]" value="${kodeObat}">
                    <input type="hidden" name="resep_harga[]" value="${hargaObat}">
                </td>
                <td class="text-center fw-semibold">
                    ${qty} ${satuanObat}
                    <input type="hidden" name="resep_jumlah[]" value="${qty}">
                </td>
                <td>
                    ${signa}
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                </td>
                <td class="text-end fw-bold subtotal-obat" style="font-family: 'JetBrains Mono', monospace;">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger rounded-2 py-1 px-2 btn-hapus-obat" title="Hapus Obat">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#resep-terpilih-tbody').append(htmlRow);
        $('#select-master-obat option[value="' + kodeObat + '"]').prop('disabled', true);

        hitungTotalObat();
        $('#select-master-obat').val('').trigger('change');

        $('#input_jumlah_obat').val(1);
        $('#input_signa_obat').val('');
    });

    $(document).on('click', '.btn-hapus-obat', function() {
        const $row = $(this).closest('tr');
        const removedCode = $row.data('code');
        if (removedCode) {
            $('#select-master-obat option[value="' + removedCode + '"]').prop('disabled', false);
        }
        $row.remove();
        if ($('#resep-terpilih-tbody tr').length === 0) {
            $('#resep-terpilih-tbody').html('<tr id="empty-row-obat"><td colspan="5" class="text-center opacity-75 py-4 fw-semibold">Belum ada resep obat yang ditambahkan.</td></tr>');
        }
        hitungTotalObat();
    });

    // ==========================================
    // 3. AJAX SIMPAN HANDLING IGD
    // ==========================================
    $(document).on('click', '#btn-simpan-handling', function(e) {
        e.preventDefault();

        let form = $('#form-handling-igd');
        let formData = form.serialize();
        let submitBtn = $(this);

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('igd.handling.store') }}",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Handling IGD');

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data handling IGD berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modal-handling-igd, #modalHandlingIgd').modal('hide');
                        if (typeof reloadTable === 'function') {
                            reloadTable();
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                    });
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Handling IGD');

                let errorMessage = 'Terjadi kesalahan pada server.';
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n';
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessage
                });
            }
        });
    });

    // ==========================================
    // 4. INISIALISASI DOCUMENT READY
    // ==========================================
    $(document).ready(function() {
        hitungTotalTarif();
        hitungTotalObat();

        setupCacheObat();
        initSelect2IgdModal('#select-skala-triage, #select-master-obat, #select-status-kunjungan, #select-tindak-lanjut, #select-ruangan-bed');
        loadLayananTarifIGD();

        // Tampilkan/Sembunyikan Pilihan Ruangan Inap berdasarkan Disposisi
        $('#select-tindak-lanjut').on('change', function() {
            if ($(this).val() === 'RAWAT_INAP') {
                $('#div-ruangan-inap').slideDown(180, function() {
                    initSelect2IgdModal('#select-ruangan-bed');
                });
            } else {
                $('#div-ruangan-inap').slideUp(180);
                $('#select-ruangan-bed').val('').trigger('change');
            }
        });
    });
</script>
