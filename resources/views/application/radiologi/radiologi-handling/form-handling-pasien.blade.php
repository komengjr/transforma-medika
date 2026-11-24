<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
       (SCOPED FOR RADIOLOGI HANDLING PARTIAL)
       ========================================= */
    :root {
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
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 12px 16px;
    }

    .ent-dark-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 3px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        cursor: pointer;
        font-size: 0.78rem;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-btn-warning {
        background-color: rgba(245, 158, 11, 0.16);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #d97706;
    }

    .ent-btn-warning:hover:not(:disabled) {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    .ent-btn-reset {
        background-color: rgba(100, 116, 139, 0.12);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-reset:hover:not(:disabled) {
        background-color: rgba(100, 116, 139, 0.22);
        color: var(--bs-body-color);
    }

    .ent-info-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 10px 12px;
    }

    .ent-info-box .info-label {
        font-size: 0.66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 2px;
    }

    .ent-info-box .info-value {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--bs-body-color);
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Item Pemeriksaan Card */
    .item-pemeriksaan-card {
        border: 1px solid var(--ent-grid-border);
        border-left-width: 4px;
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        transition: all 0.18s ease;
    }

    /* Nav Pills Ekspertise */
    #ekspertiseTab .custom-tab-btn {
        border-radius: 8px;
        border: 1px solid var(--ent-grid-border);
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        font-weight: 700;
        font-size: 0.72rem;
    }

    #ekspertiseTab .custom-tab-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    /* Select2 Adaptive & Solid Dropdown */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 36px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 10px !important;
        padding-right: 28px !important;
        box-shadow: none !important;
        opacity: 1 !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.35 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.28) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1095 !important;
        font-size: 0.8rem;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-solid-bg) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-results__options {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        max-height: 230px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 7px 12px !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>

<!-- CARD PROFIL PASIEN & DAFTAR PEMERIKSAAN -->
<div class="row g-3">
    <!-- CARD KIRI: IDENTITAS PASIEN -->
    <div class="col-lg-6">
        <div class="card ent-card">
            <div class="ent-card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold fs--1 d-flex align-items-center gap-2">
                        <i class="fas fa-user-injured text-primary"></i> Identitas Pasien
                    </h6>
                    <span class="ent-badge" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">Radiologi</span>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                    <div class="patient-avatar-wrapper flex-shrink-0" style="width: 52px; height: 52px;">
                        <img src="{{ !empty($data->master_patient_profile) ? $data->master_patient_profile : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                            class="patient-avatar rounded-circle shadow-sm"
                            alt="Foto Pasien" style="width: 52px; height: 52px; object-fit: cover; border: 2px solid var(--ent-indigo);">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 fs-0">{{ $data->master_patient_name }}</h5>
                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
                            RM: {{ $data->master_patient_code }}
                        </span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="ent-info-box">
                            <div class="info-label"><i class="fas fa-id-card text-primary me-1"></i> NIK</div>
                            <div class="info-value text-truncate" style="font-family: 'JetBrains Mono', monospace;">{{ $data->master_patient_nik ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ent-info-box">
                            <div class="info-label"><i class="fas fa-calendar-alt text-primary me-1"></i> Tgl Lahir</div>
                            <div class="info-value">{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ent-info-box">
                            <div class="info-label"><i class="fas fa-venus-mars text-primary me-1"></i> Jenis Kelamin</div>
                            <div class="info-value">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : ($data->master_patient_jk == 'P' ? 'Perempuan' : '-') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ent-info-box">
                            <div class="info-label"><i class="fas fa-phone text-primary me-1"></i> No. HP</div>
                            <div class="info-value">{{ $data->master_patient_no_hp ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ent-info-box">
                            <div class="info-label"><i class="fas fa-map-marker-alt text-primary me-1"></i> Tempat Lahir</div>
                            <div class="info-value text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ent-info-box">
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
        <div class="card ent-card h-100">
            <div class="ent-card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold fs--1 d-flex align-items-center gap-2">
                        <i class="fas fa-list-alt text-primary"></i> Daftar Pemeriksaan Radiologi
                    </h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.35);">
                        {{ count($pemeriksaanList) }} Item
                    </span>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="d-flex flex-column gap-2" style="max-height: 340px; overflow-y: auto; padding-right: 4px;" id="list-pemeriksaan-container">
                    @forelse($pemeriksaanList as $index => $item)
                    @php $status = strtolower($item->status_pemeriksaan ?? 'menunggu'); @endphp

                    <div class="p-3 item-pemeriksaan-card @if($status == 'selesai') border-success @elseif($status == 'proses') border-warning @else border-primary @endif">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 26px; height: 26px; font-size: 0.75rem; background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.35);">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h6 class="fw-bold mb-0 fs--1">{{ $item->nama_pemeriksaan ?? 'Radiologi' }}</h6>
                                    <small class="opacity-75 fw-semibold fs--2" style="font-family: 'JetBrains Mono', monospace;">
                                        <i class="fas fa-hashtag text-primary me-1"></i>{{ $item->order_rad_list_code }}
                                    </small>
                                    <div class="durasi-badge-wrapper">
                                        @if(isset($item->durasi_pengerjaan_menit) && $item->durasi_pengerjaan_menit > 0)
                                        <span class="ent-badge mt-1" style="background: rgba(14, 165, 233, 0.12); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.3);">
                                            <i class="fas fa-stopwatch me-1"></i> Durasi: <span class="durasi-val mx-1">{{ $item->durasi_pengerjaan_menit }}</span> Menit
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="status-badge-container">
                                @if($status == 'selesai')
                                <span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);">
                                    <i class="fas fa-check-circle me-1"></i> Selesai
                                </span>
                                @elseif($status == 'proses')
                                <span class="ent-badge" style="background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.35);">
                                    <i class="fas fa-spinner fa-spin me-1"></i> Diproses
                                </span>
                                @else
                                <span class="ent-badge" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.35);">
                                    <i class="fas fa-clock me-1"></i> Menunggu
                                </span>
                                @endif
                            </div>
                        </div>
                        <hr class="my-2" style="border-color: var(--ent-grid-border);" />
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <span class="opacity-75 fw-semibold fs--2">Aksi Petugas:</span>
                            <div class="d-inline-flex gap-2 action-button-container align-items-center">
                                <button type="button" class="btn btn-xs ent-btn ent-btn-reset px-2 py-1 btn-print-barcode" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-barcode me-1"></i> Barcode
                                </button>

                                @if($status == 'menunggu')
                                <button type="button" class="btn btn-xs ent-btn ent-btn-warning px-3 py-1 btn-mulai-proses" data-id="{{ $item->detail_id }}" data-code="{{ $item->order_rad_list_code }}">
                                    <i class="fas fa-play me-1"></i> Mulai Proses
                                </button>
                                @elseif($status == 'proses')
                                <button type="button" class="btn btn-xs ent-btn ent-btn-success px-3 py-1 btn-selesai-proses" data-id="{{ $item->detail_id }}">
                                    <i class="fas fa-check me-1"></i> Selesai Proses
                                </button>
                                @else
                                <span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);">
                                    <i class="fas fa-check-double me-1"></i> Siap Diisi
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="ent-info-box p-4 text-center">
                        <p class="opacity-75 fw-semibold mb-0 fs--1">Tidak ada rincian item pemeriksaan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function initSelect2RadDetail(containerSelector) {
        if (!(window.jQuery && $.fn.select2)) return;
        const $scope = containerSelector ? $(containerSelector) : $(document);
        const $modalParent = $scope.closest('.modal');
        const $dropdownParent = $modalParent.length ? $modalParent : $(document.body);

        $scope.find('select.select2-rad-ekspertise').each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $dropdownParent,
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

    $(document).ready(function() {
        initSelect2RadDetail('#ekspertiseTabContent');

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const targetPane = $(e.target).attr('data-bs-target');
            if (targetPane) {
                initSelect2RadDetail(targetPane);
            }
        });
    });

    // Event Handler Cetak Barcode
    $(document).off('click.radBarcode').on('click.radBarcode', '.btn-print-barcode', function(e) {
        e.preventDefault();
        var orderRadListCode = $(this).data("code");
        var printUrl = "{{ route('menu_radiologi_handling_pasien_print_barcode', ':code') }}".replace(':code', orderRadListCode);
        window.open(printUrl, 'CetakBarcodeWindow', 'width=500,height=400,scrollbars=yes,resizable=yes');
    });

    // Event Handler Mulai Proses Handling (Tanpa Reload)
    $(document).off('click.radMulai').on('click.radMulai', '.btn-mulai-proses', function(e) {
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
                    <span class="ent-badge" style="background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.35);">
                        <i class="fas fa-spinner fa-spin me-1"></i> Diproses
                    </span>
                `);

                card.find(".action-button-container").find(".btn-mulai-proses").replaceWith(`
                    <button type="button" class="btn btn-xs ent-btn ent-btn-success px-3 py-1 btn-selesai-proses" data-id="${detailId}">
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
    $(document).off('click.radSelesai').on('click.radSelesai', '.btn-selesai-proses', function(e) {
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
                    <span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);">
                        <i class="fas fa-check-circle me-1"></i> Selesai
                    </span>
                `);

                if (res.durasi) {
                    card.find(".durasi-badge-wrapper").html(`
                        <span class="ent-badge mt-1" style="background: rgba(14, 165, 233, 0.12); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.3);">
                            <i class="fas fa-stopwatch me-1"></i> Durasi: <span class="durasi-val mx-1">${res.durasi}</span> Menit
                        </span>
                    `);
                }

                card.find(".action-button-container").find(".btn-selesai-proses").replaceWith(`
                    <span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);">
                        <i class="fas fa-check-double me-1"></i> Siap Diisi
                    </span>
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
<div class="row g-3">
    <!-- KOLOM KIRI: CITRA RADIOLOGI PACS ORTHANC -->
    <div class="col-lg-6">
        <div class="card ent-card h-100">
            <div class="ent-dark-header p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-x-ray text-info fs-0"></i>
                        <h6 class="mb-0 text-white fw-bold fs--1">Citra Radiologi PACS Orthanc</h6>
                        <span class="ent-badge" style="background: rgba(255, 255, 255, 0.14); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.25);">
                            {{ count($pemeriksaanList) }} Item
                        </span>
                    </div>
                    <button id="btn-fetch-orthanc" type="button" class="btn btn-xs ent-btn px-2 py-1 fs--2 text-white" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
                <div class="border-top border-secondary border-opacity-50 pt-2 mt-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <span class="text-white-50 fs--2 fw-semibold"><i class="fas fa-desktop text-info me-1"></i> Buka Full DICOM Viewer:</span>
                    <div class="dropdown" id="container-ohif-dropdown">
                        <button class="btn btn-sm ent-btn ent-btn-primary dropdown-toggle px-3 py-1 fs--2" type="button" id="dropdownOhifMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-external-link-alt me-1"></i> Pilih OHIF Viewer
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg py-1 fs--1 mt-1" aria-labelledby="dropdownOhifMenu" id="container-ohif-buttons" style="min-width: 250px; border-radius: 12px; border: 1px solid var(--ent-grid-border);">
                            @forelse($pemeriksaanList as $index => $item)
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between link-ohif-item fw-semibold" href="#" target="_blank" data-code="{{ $item->order_rad_list_code }}">
                                    <span class="fs--1"><i class="fas fa-file-medical-alt text-primary me-2"></i> OHIF: <strong>{{ $item->nama_pemeriksaan }}</strong></span>
                                    <i class="fas fa-external-link-alt opacity-50 fs--2 ms-2"></i>
                                </a>
                            </li>
                            @if(!$loop->last)<li>
                                <hr class="dropdown-divider my-0 opacity-25">
                            </li>@endif
                            @empty
                            <li><span class="dropdown-item disabled opacity-75 fs--2 text-center py-2">Tidak ada link viewer</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-3" style="max-height: 500px; overflow-y: auto;">
                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3 fs--1 p-2 rounded-3" role="alert">
                    <div class="d-flex align-items-center"><i class="fas fa-exclamation-triangle me-2 fs-0"></i><span id="orthanc-alert-text"></span></div>
                    <button type="button" class="btn-close py-2" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                </div>
                <div id="orthanc-loader" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;"><span class="visually-hidden">Loading DICOM...</span></div>
                    <p class="mt-2 fs--1 mb-0 fw-semibold">Mengambil citra dari PACS Orthanc...</p>
                </div>
                <div id="orthanc-gallery" class="row g-2 d-none"></div>
                <div id="orthanc-empty" class="ent-info-box text-center py-4 d-none">
                    <i class="fas fa-file-medical-alt fa-2x text-primary mb-2"></i>
                    <p class="mb-0 fs--1 fw-semibold" id="orthanc-empty-text">Belum ada foto/citra radiologi yang diunggah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM EKSPERTISE -->
    <div class="col-lg-6">
        <div class="card ent-card h-100">
            <div class="ent-card-header">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 fw-bold fs--1 d-flex align-items-center gap-2">
                        <i class="fas fa-file-signature text-primary"></i> Pengisian Ekspertise / Hasil
                    </h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.35);">
                        {{ count($pemeriksaanList) }} Pemeriksaan
                    </span>
                </div>
                @if(count($pemeriksaanList) > 1)
                <div class="pt-2 mt-2" style="border-top: 1px solid var(--ent-grid-border);">
                    <ul class="nav nav-pills card-header-pills gap-1" id="ekspertiseTab" role="tablist">
                        @foreach($pemeriksaanList as $index => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm py-1 px-3 custom-tab-btn {{ $index === 0 ? 'active' : '' }} {{ !$item->is_ready ? 'disabled opacity-50' : '' }}"
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
                <div id="alert-no-image" class="alert alert-warning d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold">
                    <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                    <div><strong>Peringatan:</strong> Citra/foto radiologi belum diunggah. Ekspertise belum dapat diisi.</div>
                </div>

                <div class="tab-content" id="ekspertiseTabContent">
                    @foreach($pemeriksaanList as $index => $item)
                    @php $totalParams = count($item->parameters); @endphp
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-item-{{ $index }}" role="tabpanel">

                        @if(!$item->is_ready)
                        <div class="alert alert-danger d-flex align-items-center mb-3 fs--1 p-2 rounded-3 fw-semibold">
                            <i class="fas fa-ban me-2 fs-0"></i>
                            <div>Status handling atau pembayaran untuk <strong>{{ $item->nama_pemeriksaan }}</strong> belum selesai/lunas. Form terkunci.</div>
                        </div>
                        @endif

                        <form class="form-ekspertise-single" action="{{ route('menu_radiologi_handling_pasien_simpan_hasil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="order_rad_list_code" value="{{ $item->order_rad_list_code }}">
                            <input type="hidden" name="t_pemeriksaan_list_code" value="{{ $item->t_pemeriksaan_list_code }}">

                            <div class="ent-info-box d-flex align-items-center justify-content-between mb-3">
                                <span class="fs--1 fw-bold"><i class="fas fa-stethoscope text-primary me-1"></i> {{ $item->nama_pemeriksaan }}</span>
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo); border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
                                    {{ $item->t_pemeriksaan_list_code ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold fs--1 mb-1">Dokter Pemeriksa / Radiolog</label>
                                <input type="text" class="form-control form-control-sm ent-input fw-semibold" name="dokter_radiologi" value="{{ auth()->user()->name ?? 'Dr. Radiologi' }}" readonly>
                            </div>

                            <div class="rounded-3 p-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                    <h6 class="fs--1 fw-bold mb-0"><i class="fas fa-list-check text-primary me-1"></i> Parameter Hasil Pemeriksaan</h6>
                                    <span class="ent-badge" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">
                                        {{ $totalParams }} Parameter
                                    </span>
                                </div>

                                @forelse($item->parameters as $valIndex => $val)
                                @php
                                $optType = strtolower($val->t_pem_list_val_opt ?? 'textarea');
                                $computedRows = (!empty($val->t_pem_list_val_kali) && is_numeric($val->t_pem_list_val_kali)) ? (int)$val->t_pem_list_val_kali : ($totalParams <= 1 ? 6 : ($totalParams==2 ? 4 : 3));

                                $savedResult = \DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', $val->t_pem_list_val_code)->value('h_reg_rad_value');
                                $currentValue = $savedResult ?? $val->t_pem_list_val_nilai ?? '';
                                @endphp

                                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                                    <label class="form-label fw-bold fs--1 mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-angle-right text-primary me-1 fs--2"></i> {{ $val->t_pem_list_val_name }} <span class="text-danger">*</span></span>
                                        <div>
                                            @if(!empty($val->t_pem_list_val_satuan))
                                            <span class="ent-badge me-1" style="background: rgba(100, 116, 139, 0.14); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">{{ $val->t_pem_list_val_satuan }}</span>
                                            @endif
                                            @if($optType != 'select' && $optType != 'option' && $optType != 'text' && $optType != 'input' && $optType != 'string')
                                            <button type="button" class="btn btn-xs ent-btn ent-btn-reset py-0 px-2 btn-open-editor" data-target="#textarea-{{ $val->t_pem_list_val_code }}" data-title="{{ $val->t_pem_list_val_name }}" {{ !$item->is_ready ? 'disabled' : '' }} title="Perbesar Teks Editor">
                                                <i class="fas fa-expand-arrows-alt"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </label>
                                    <input type="hidden" name="results[{{ $valIndex }}][t_pem_list_val_code]" value="{{ $val->t_pem_list_val_code }}">

                                    @if(($optType == 'select' || $optType == 'option') && !empty($val->t_pem_list_val_opt_code))
                                    <select name="results[{{ $valIndex }}][nilai]" class="form-select form-select-sm ent-input select2-rad-ekspertise" data-placeholder="-- Pilih {{ $val->t_pem_list_val_name }} --" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                        <option value="">-- Pilih {{ $val->t_pem_list_val_name }} --</option>
                                        @foreach(explode(',', $val->t_pem_list_val_opt_code) as $opt)
                                        <option value="{{ trim($opt) }}" {{ $currentValue == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                        @endforeach
                                    </select>
                                    @elseif($optType == 'text' || $optType == 'input' || $optType == 'string')
                                    <input type="text" class="form-control form-control-sm ent-input" name="results[{{ $valIndex }}][nilai]" placeholder="Masukkan hasil..." value="{{ $currentValue }}" {{ !$item->is_ready ? 'disabled' : '' }} required>
                                    @else
                                    <textarea id="textarea-{{ $val->t_pem_list_val_code }}" class="form-control form-control-sm ent-input field-ekspertise" name="results[{{ $valIndex }}][nilai]" rows="{{ $computedRows }}" placeholder="Ketik deskripsi hasil..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $currentValue }}</textarea>
                                    @endif

                                    @if(!empty($val->t_pem_list_val_rujukan))
                                    <div class="form-text fs--2 mt-1 fw-semibold"><i class="fas fa-info-circle text-primary me-1"></i> Nilai Rujukan: <code>{{ $val->t_pem_list_val_rujukan }}</code></div>
                                    @endif
                                </div>
                                @empty
                                @php $fallbackResult = \DB::table('h_reg_rad')->where('order_rad_list_code', $item->order_rad_list_code)->where('t_pem_list_val_code', 'DEFAULT')->value('h_reg_rad_value'); @endphp
                                <div class="mb-2">
                                    <label class="form-label fw-bold fs--1 mb-1 d-flex justify-content-between align-items-center">
                                        <span>Hasil Pemeriksaan / Deskripsi <span class="text-danger">*</span></span>
                                        <button type="button" class="btn btn-xs ent-btn ent-btn-reset py-0 px-2 btn-open-editor" data-target="#textarea-fallback-{{ $index }}" data-title="{{ $item->nama_pemeriksaan }}" {{ !$item->is_ready ? 'disabled' : '' }}>
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </button>
                                    </label>
                                    <textarea id="textarea-fallback-{{ $index }}" class="form-control ent-input field-ekspertise" name="hasil_ekspertise" rows="5" placeholder="Ketik hasil ekspertise..." {{ !$item->is_ready ? 'disabled' : '' }} required>{{ $fallbackResult ?? '' }}</textarea>
                                </div>
                                @endforelse
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm ent-btn ent-btn-success px-4 btn-save-ekspertise" {{ !$item->is_ready ? 'disabled' : '' }}>
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
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-dark-header py-3 px-4">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="fas fa-edit me-2 text-info"></i> <span id="editor-title">Editor Ekspertise</span></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <textarea id="large-textarea-input" class="form-control border-0 rounded-0 fw-semibold" style="height: 60vh; font-size: 1.05rem; line-height: 1.6; padding: 20px; resize: none;"></textarea>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                <span class="opacity-75 fw-semibold fs--2 me-auto"><i class="fas fa-info-circle text-primary me-1"></i> Teks akan tersimpan ke form saat Anda klik 'Terapkan &amp; Tutup'</span>
                <button type="button" class="btn btn-sm ent-btn ent-btn-reset" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-4" id="btn-apply-editor">Terapkan &amp; Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL EDITOR TEXT -->
<script>
    $(document).ready(function() {
        var currentTargetId = '';

        $(document).off('click.radOpenEditor').on('click.radOpenEditor', '.btn-open-editor', function(e) {
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
            }, 400);
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
<div class="card ent-card mb-3" style="border-color: rgba(225, 29, 72, 0.4);">
    <div class="card-body p-5 text-center">
        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
            style="width: 70px; height: 70px; background: rgba(225, 29, 72, 0.14); border: 1px solid rgba(225, 29, 72, 0.35); color: #e11d48;">
            <i class="fas fa-lock fs-2"></i>
        </div>
        <h5 class="fw-bold mb-2">Hasil Belum Dapat Diakses</h5>
        <p class="opacity-75 fw-semibold mb-3" style="max-width: 500px; margin: 0 auto;">Pasien belum menyelesaikan administrasi/pembayaran untuk pemeriksaan radiologi ini.</p>
        <span class="ent-badge px-3 py-2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35); font-size: 0.78rem;">
            Status: Belum Lunas
        </span>
    </div>
</div>
@endif
