<style>
    .ranap-info-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 16px;
    }

    .ranap-subbox {
        background-color: rgba(79, 70, 229, 0.04);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 16px;
    }

    .ent-nav-tabs {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        gap: 6px;
    }

    .ent-nav-tabs .nav-link {
        border: 1px solid transparent !important;
        border-radius: 10px 10px 0 0 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        color: var(--bs-secondary-color, #64748b) !important;
        padding: 9px 14px !important;
        transition: all 0.15s ease;
    }

    .ent-nav-tabs .nav-link:hover {
        color: var(--bs-body-color) !important;
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .ent-nav-tabs .nav-link.active {
        color: var(--ent-indigo) !important;
        background-color: var(--bs-body-bg) !important;
        border-color: var(--ent-grid-border) var(--ent-grid-border) var(--bs-body-bg) !important;
    }

    [data-bs-theme="dark"] .ent-nav-tabs .nav-link.active,
    .dark .ent-nav-tabs .nav-link.active {
        color: #a5b4fc !important;
    }

    .ent-textarea {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 500 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding: 10px 12px !important;
        font-size: 0.82rem !important;
        min-height: 42px;
        transition: all 0.2s ease;
    }

    .ent-textarea:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-btn-secondary {
        background-color: rgba(100, 116, 139, 0.14);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-secondary:hover {
        background-color: rgba(100, 116, 139, 0.24);
        color: var(--bs-body-color);
    }

    /* Choices.js Adaptive Styling inside Modal */
    #modal-handling-ranap .choices {
        margin-bottom: 0;
    }

    #modal-handling-ranap .choices__inner {
        min-height: 38px;
        padding: 4px 10px;
        border-radius: 10px;
        background-color: var(--bs-body-bg);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    #modal-handling-ranap .choices.is-focused .choices__inner,
    #modal-handling-ranap .choices.is-open .choices__inner {
        border-color: var(--ent-indigo);
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15);
    }

    #modal-handling-ranap .choices__list--dropdown,
    #modal-handling-ranap .choices__list[aria-expanded] {
        background-color: var(--bs-body-bg, var(--ent-surface));
        color: var(--bs-body-color);
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.22);
        z-index: 1090;
    }

    #modal-handling-ranap .choices__input {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        font-size: 0.8rem;
        margin-bottom: 0;
    }

    #modal-handling-ranap .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: var(--ent-indigo);
        color: #ffffff;
    }
</style>

<div class="card ent-card border-0 mb-0">
    <div class="ent-card-header py-3 px-4 d-flex justify-content-between align-items-center gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-bed text-primary"></i>
                <span>Form Handling Pasien Rawat Inap:</span>
                <span class="text-danger">{{ $pasien->nama_pasien }}</span>
            </h6>
            <span class="code-chip">RM: {{ $pasien->pid }}</span>
        </div>
        <button type="button" class="btn btn-sm ent-btn ent-btn-secondary d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; border-radius: 50%; padding: 0;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="card-body p-3 p-md-4 ent-table-surface">
        <!-- Info Singkat Pasien & Penjamin -->
        <div class="ranap-info-box mb-4">
            <div class="row g-2 fs--1">
                <div class="col-sm-6 col-lg-3">
                    <span class="ent-field-label">No. Registrasi</span>
                    <span class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $pasien->no_registrasi }}</span>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <span class="ent-field-label">Tgl Masuk</span>
                    <span class="fw-semibold" style="font-family: 'JetBrains Mono', monospace;">{{ date('d/m/Y H:i', strtotime($pasien->tanggal_registrasi)) }}</span>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <span class="ent-field-label">Ruangan / Bed</span>
                    <span class="fw-semibold">{{ $pasien->nama_ruangan ?? '-' }} <span class="text-success fw-bold">({{ $pasien->nomor_bed }})</span></span>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <span class="ent-field-label">Dokter DPJP</span>
                    <span class="fw-semibold"><i class="fas fa-user-md text-primary me-1"></i>{{ $pasien->nama_dokter ?? '-' }}</span>
                </div>
                <div class="col-sm-6 pt-2 mt-2" style="border-top: 1px dashed var(--ent-grid-border);">
                    <span class="ent-field-label">Penjamin Utama</span>
                    <span class="fw-bold text-primary">{{ $pasien->nama_penjamin ?? 'Umum / Mandiri' }}</span>
                </div>
                <div class="col-sm-6 pt-2 mt-2" style="border-top: 1px dashed var(--ent-grid-border);">
                    <span class="ent-field-label">Sub Penjamin</span>
                    <span class="fw-bold text-danger">{{ $pasien->nama_sub_penjamin ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Tab Navigasi -->
        <ul class="nav nav-tabs ent-nav-tabs mb-3" id="handlingRanapTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="soap-ranap-tab" data-bs-toggle="tab" data-bs-target="#soap-ranap-pane" type="button" role="tab">
                    <i class="fas fa-notes-medical me-1"></i> 1. SOAP &amp; Perkembangan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tindakan-ranap-tab" data-bs-toggle="tab" data-bs-target="#tindakan-ranap-pane" type="button" role="tab">
                    <i class="fas fa-stethoscope me-1"></i> 2. Tindakan &amp; Visite
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resep-ranap-tab" data-bs-toggle="tab" data-bs-target="#resep-ranap-pane" type="button" role="tab">
                    <i class="fas fa-pills me-1 text-danger"></i> 3. Order Resep / Obat Farmasi
                </button>
            </li>
        </ul>

        <form id="form-handling-ranap">
            @csrf
            <input type="hidden" name="registrasi_id" value="{{ $pasien->id }}">
            <input type="hidden" id="sub_penjamin_id" value="{{ $pasien->sub_penjamin_id }}">

            <div class="tab-content" id="handlingRanapTabContent">
                <!-- PANE 1: SOAP RANAP -->
                <div class="tab-pane fade show active" id="soap-ranap-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="ent-field-label">Subjektif (Keluhan Harian)</label>
                            <textarea class="form-control ent-textarea" name="subjektif" rows="3" placeholder="Perkembangan keluhan pasien...">{{ optional($soap)->subjektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-field-label">Objektif (Pemeriksaan Fisik &amp; TTV)</label>
                            <textarea class="form-control ent-textarea" name="objektif" rows="3" placeholder="Keadaan umum, TTV, dll...">{{ optional($soap)->objektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-field-label">Asesmen (Diagnosis Medis)</label>
                            <textarea class="form-control ent-textarea" name="asesmen" rows="3" placeholder="Diagnosis saat ini...">{{ optional($soap)->asesmen }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="ent-field-label">Planning (Instruksi / Terapi Lanjutan)</label>
                            <textarea class="form-control ent-textarea" name="planning" rows="3" placeholder="Instruksi cairan infus, obat, diet...">{{ optional($soap)->planning }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- PANE 2: TINDAKAN RANAP -->
                <div class="tab-pane fade" id="tindakan-ranap-pane" role="tabpanel">
                    <div class="ranap-subbox mb-3">
                        <h6 class="fw-bold mb-3 fs--1">
                            <i class="fas fa-hand-holding-medical me-1 text-primary"></i> Penambahan Tindakan &amp; Layanan (Menyesuaikan Penjamin Pasien)
                        </h6>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-10">
                                <label class="ent-field-label">Pilih Layanan, Tindakan &amp; Jasa Dokter Visite</label>
                                <select class="form-select ent-input" id="select-master-tindakan-ranap">
                                    <option value="">-- Memuat Data Layanan --</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn ent-btn ent-btn-success w-100 fw-semibold" id="btn-tambah-tindakan-ranap" style="height: 38px;">
                                    <i class="fas fa-plus me-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-sm fs--1 table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="py-2 px-3 text-start">Nama Tindakan / Pemeriksaan</th>
                                    <th class="py-2 px-3 text-end" style="width: 180px;">Tarif (Rp)</th>
                                    <th class="py-2 px-3 text-center" style="width: 70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tindakan-ranap-tbody" class="ent-table-surface">
                                @forelse($tindakanList as $tind)
                                <tr data-id="{{ $tind->master_pemeriksaan_id }}" data-tarif="{{ $tind->tarif ?? 0 }}">
                                    <td class="fw-semibold px-3 py-2">
                                        {{ $tind->nama_layanan }}
                                        <input type="hidden" name="tindakan_ids[]" value="{{ $tind->master_pemeriksaan_id }}">
                                        <input type="hidden" name="tarif_tindakan[]" value="{{ $tind->tarif }}">
                                    </td>
                                    <td class="text-end fw-bold px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($tind->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-2 btn-hapus-tindakan fw-bold rounded-2"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-ranap">
                                    <td colspan="3" class="text-center opacity-75 py-3 fw-semibold">Belum ada tindakan yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr style="background-color: rgba(79, 70, 229, 0.06);">
                                    <td class="text-end fw-bold px-3 py-2 text-uppercase">Total Keseluruhan Tarif:</td>
                                    <td class="text-end fw-bold text-danger px-3 py-2" id="total-tarif-ranap-text" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- PANE 3: ORDER RESEP / OBAT FARMASI -->
                <div class="tab-pane fade" id="resep-ranap-pane" role="tabpanel">
                    <div class="ranap-subbox mb-3">
                        <h6 class="fw-bold mb-3 fs--1">
                            <i class="fas fa-prescription-bottle-medical me-1 text-primary"></i> Input Resep &amp; Permintaan Obat ke Farmasi
                        </h6>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="ent-field-label">Pilih Master Obat</label>
                                <select class="form-select ent-input" id="select_obat_farmasi">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($obatList as $obt)
                                    <option value="{{ $obt->farm_data_obat_code }}">
                                        [{{ $obt->farm_data_obat_code }}] {{ $obt->farm_data_obat_name }} - Rp {{ number_format($obt->harga_jual ?? 0, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="ent-field-label">Jumlah (Qty)</label>
                                <input type="number" class="form-control ent-input text-center" id="qty_obat_resep" value="1" min="1" style="height: 38px !important; padding-top: 6px !important;">
                            </div>
                            <div class="col-md-3">
                                <label class="ent-field-label">Aturan Pakai / Signa</label>
                                <input type="text" class="form-control ent-input" id="signa_obat_resep" placeholder="Cth: 3 x 1 Tablet" style="height: 38px !important; padding-top: 6px !important;">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn ent-btn ent-btn-success w-100 fw-bold" id="btn-tambah-resep-ranap" style="height: 38px;" title="Tambah Resep">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-sm fs--1 table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="py-2 px-3 text-start">Nama Obat</th>
                                    <th class="py-2 px-3 text-center" style="width: 80px;">Qty</th>
                                    <th class="py-2 px-3 text-start" style="width: 200px;">Signa / Aturan Pakai</th>
                                    <th class="py-2 px-3 text-end" style="width: 140px;">Harga Satuan</th>
                                    <th class="py-2 px-3 text-end" style="width: 150px;">Subtotal</th>
                                    <th class="py-2 px-3 text-center" style="width: 70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="resep-ranap-tbody" class="ent-table-surface">
                                @forelse($resepList as $rsp)
                                <tr data-kode="{{ $rsp->farm_data_obat_code }}" data-qty="{{ $rsp->qty }}" data-harga="{{ $rsp->harga }}">
                                    <td class="fw-semibold px-3 py-2">
                                        {{ $rsp->farm_data_obat_name }}
                                        <input type="hidden" name="resep_obat_code[]" value="{{ $rsp->farm_data_obat_code }}">
                                        <input type="hidden" name="resep_qty[]" value="{{ $rsp->qty }}">
                                        <input type="hidden" name="resep_signa[]" value="{{ $rsp->signa }}">
                                        <input type="hidden" name="resep_harga[]" value="{{ $rsp->harga }}">
                                    </td>
                                    <td class="text-center px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">{{ $rsp->qty }}</td>
                                    <td class="px-3 py-2">{{ $rsp->signa }}</td>
                                    <td class="text-end px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($rsp->harga, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-success px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($rsp->qty * $rsp->harga, 0, ',', '.') }}</td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-2 btn-hapus-resep fw-bold rounded-2"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-resep">
                                    <td colspan="6" class="text-center opacity-75 py-3 fw-semibold">Belum ada item resep obat yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr style="background-color: rgba(79, 70, 229, 0.06);">
                                    <td colspan="4" class="text-end fw-bold px-3 py-2 text-uppercase">Total Estimasi Biaya Resep:</td>
                                    <td class="text-end fw-bold text-danger px-3 py-2" id="total-resep-ranap-text" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 mt-4" style="border-top: 1px dashed var(--ent-grid-border);">
                <button type="button" class="btn ent-btn ent-btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn ent-btn ent-btn-success btn-sm px-4" id="btn-simpan-handling-ranap">
                    <i class="fas fa-save me-1"></i> Simpan Handling Ranap
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    $(document).off('.ranapHandlingForm');

    if (window.choicesRanap && typeof window.choicesRanap.destroy === 'function') {
        try { window.choicesRanap.destroy(); } catch (err) {}
        window.choicesRanap = null;
    }
    if (window.choicesObat && typeof window.choicesObat.destroy === 'function') {
        try { window.choicesObat.destroy(); } catch (err) {}
        window.choicesObat = null;
    }

    window.masterLayananData = window.masterLayananData || {};
    window.masterObatData = window.masterObatData || {};
    let isSavingRanap = false;

    @foreach($obatList as $obt)
        window.masterObatData["{{ $obt->farm_data_obat_code }}"] = {
            nama: "{{ addslashes($obt->farm_data_obat_name) }}",
            harga: {{ $obt->harga_jual ?? 0 }}
        };
    @endforeach

    function hitungTotalRanap() {
        let total = 0;
        $('#tindakan-ranap-tbody tr[data-tarif]').each(function() {
            let tarif = parseFloat($(this).attr('data-tarif')) || 0;
            total += tarif;
        });
        $('#total-tarif-ranap-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function hitungTotalResep() {
        let total = 0;
        $('#resep-ranap-tbody tr[data-qty][data-harga]').each(function() {
            let qty = parseFloat($(this).attr('data-qty')) || 0;
            let harga = parseFloat($(this).attr('data-harga')) || 0;
            total += (qty * harga);
        });
        $('#total-resep-ranap-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function loadLayananDanJasa(subPenjaminId) {
        let laySelect = $('#select-master-tindakan-ranap');
        if (window.choicesRanap && typeof window.choicesRanap.destroy === 'function') {
            try { window.choicesRanap.destroy(); } catch (err) {}
            window.choicesRanap = null;
        }
        laySelect.html('<option value="">Sedang memuat layanan...</option>');

        $.ajax({
            url: "{{ route('ranap.get.layanan') }}",
            type: "GET",
            data: { sub_penjamin_id: subPenjaminId },
            success: function(res) {
                let options = '<option value="">-- Pilih Pemeriksaan / Jasa Visite --</option>';
                window.masterLayananData = {};

                (res || []).forEach(function(item) {
                    window.masterLayananData[item.id] = {
                        nama: item.nama_layanan,
                        tarif: parseFloat(item.tarif) || 0
                    };

                    options += `<option value="${item.id}">
                        ${item.nama_layanan} (Rp ${Number(item.tarif).toLocaleString('id-ID')})
                    </option>`;
                });

                laySelect.html(options);
                const el = document.getElementById('select-master-tindakan-ranap');
                if (el && typeof Choices !== 'undefined') {
                    window.choicesRanap = new Choices(el, {
                        searchEnabled: true,
                        itemSelectText: '',
                        placeholder: true,
                        shouldSort: false
                    });
                }
            }
        });
    }

    $(document).ready(function() {
        hitungTotalRanap();
        hitungTotalResep();

        const obatEl = document.getElementById('select_obat_farmasi');
        if (obatEl && typeof Choices !== 'undefined') {
            window.choicesObat = new Choices(obatEl, {
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                shouldSort: false
            });
        }

        let subPenjaminId = $('#sub_penjamin_id').val();
        if (subPenjaminId) {
            loadLayananDanJasa(subPenjaminId);
        }
    });

    // Tambah Tindakan ke Tabel Sementara
    $(document).on('click.ranapHandlingForm', '#btn-tambah-tindakan-ranap', function(e) {
        e.preventDefault();
        let selectEl = document.getElementById('select-master-tindakan-ranap');
        if (!selectEl) return;
        let idTindakan = selectEl.value;

        if (!idTindakan) {
            Swal.fire('Perhatian', 'Pilih layanan/tindakan terlebih dahulu!', 'warning');
            return;
        }

        let tindakanInfo = window.masterLayananData[idTindakan];
        if (!tindakanInfo) {
            Swal.fire('Error', 'Data layanan tidak ditemukan!', 'error');
            return;
        }

        let namaPemeriksaan = tindakanInfo.nama;
        let tarifTindakan = tindakanInfo.tarif;

        let sudahAda = false;
        $('#tindakan-ranap-tbody tr[data-id]').each(function() {
            if ($(this).attr('data-id') == idTindakan) sudahAda = true;
        });

        if (sudahAda) {
            Swal.fire('Duplikasi', 'Tindakan ini sudah ditambahkan!', 'error');
            return;
        }

        $('#empty-row-ranap').remove();
        let htmlRow = `
            <tr data-id="${idTindakan}" data-tarif="${tarifTindakan}">
                <td class="fw-semibold px-3 py-2">${namaPemeriksaan}
                    <input type="hidden" name="tindakan_ids[]" value="${idTindakan}">
                    <input type="hidden" name="tarif_tindakan[]" value="${tarifTindakan}">
                </td>
                <td class="text-end fw-bold px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp ${tarifTindakan.toLocaleString('id-ID')}</td>
                <td class="text-center py-2"><button type="button" class="btn btn-sm btn-danger py-0 px-2 btn-hapus-tindakan fw-bold rounded-2"><i class="fas fa-times"></i></button></td>
            </tr>`;
        $('#tindakan-ranap-tbody').append(htmlRow);
        hitungTotalRanap();

        if (window.choicesRanap) {
            window.choicesRanap.setChoiceByValue("");
        } else {
            $(selectEl).val("").trigger("change");
        }
    });

    $(document).on('click.ranapHandlingForm', '.btn-hapus-tindakan', function() {
        $(this).closest('tr').remove();
        if ($('#tindakan-ranap-tbody tr[data-tarif]').length === 0) {
            $('#tindakan-ranap-tbody').html('<tr id="empty-row-ranap"><td colspan="3" class="text-center opacity-75 py-3 fw-semibold">Belum ada tindakan yang ditambahkan.</td></tr>');
        }
        hitungTotalRanap();
    });

    // Tambah Resep Obat ke Tabel Sementara
    $(document).on('click.ranapHandlingForm', '#btn-tambah-resep-ranap', function(e) {
        e.preventDefault();
        let selectEl = document.getElementById('select_obat_farmasi');
        if (!selectEl) return;
        let obatCode = selectEl.value;
        let qty = parseInt($('#qty_obat_resep').val()) || 1;
        let signa = $('#signa_obat_resep').val().trim();

        if (!obatCode || qty <= 0) {
            Swal.fire('Perhatian', 'Pilih obat dan masukkan jumlah (qty) dengan benar!', 'warning');
            return;
        }

        let obatInfo = window.masterObatData[obatCode];
        if (!obatInfo) {
            Swal.fire('Error', 'Data obat tidak ditemukan!', 'error');
            return;
        }

        let namaObat = obatInfo.nama;
        let hargaJual = obatInfo.harga;
        let subtotal = qty * hargaJual;

        let sudahAda = false;
        $('#resep-ranap-tbody tr[data-kode]').each(function() {
            if ($(this).attr('data-kode') == obatCode) sudahAda = true;
        });

        if (sudahAda) {
            Swal.fire('Duplikasi', 'Obat ini sudah ada dalam daftar resep!', 'error');
            return;
        }

        $('#empty-row-resep').remove();
        let htmlRow = `
            <tr data-kode="${obatCode}" data-qty="${qty}" data-harga="${hargaJual}">
                <td class="fw-semibold px-3 py-2">${namaObat}
                    <input type="hidden" name="resep_obat_code[]" value="${obatCode}">
                    <input type="hidden" name="resep_qty[]" value="${qty}">
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                    <input type="hidden" name="resep_harga[]" value="${hargaJual}">
                </td>
                <td class="text-center px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">${qty}</td>
                <td class="px-3 py-2">${signa || '-'}</td>
                <td class="text-end px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp ${hargaJual.toLocaleString('id-ID')}</td>
                <td class="text-end fw-bold text-success px-3 py-2" style="font-family: 'JetBrains Mono', monospace;">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center py-2"><button type="button" class="btn btn-sm btn-danger py-0 px-2 btn-hapus-resep fw-bold rounded-2"><i class="fas fa-times"></i></button></td>
            </tr>`;
        $('#resep-ranap-tbody').append(htmlRow);
        hitungTotalResep();

        if (window.choicesObat) {
            window.choicesObat.setChoiceByValue("");
        } else {
            $(selectEl).val("").trigger("change");
        }
        $('#qty_obat_resep').val('1');
        $('#signa_obat_resep').val('');
    });

    $(document).on('click.ranapHandlingForm', '.btn-hapus-resep', function() {
        $(this).closest('tr').remove();
        if ($('#resep-ranap-tbody tr[data-qty][data-harga]').length === 0) {
            $('#resep-ranap-tbody').html('<tr id="empty-row-resep"><td colspan="6" class="text-center opacity-75 py-3 fw-semibold">Belum ada item resep obat yang ditambahkan.</td></tr>');
        }
        hitungTotalResep();
    });

    // Simpan Handling Ranap
    $(document).on('click.ranapHandlingForm', '#btn-simpan-handling-ranap', function(e) {
        e.preventDefault();
        if (isSavingRanap) return;
        isSavingRanap = true;

        let btn = $(this);
        let originalHtml = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('ranap.handling.store') }}",
            type: "POST",
            data: $('#form-handling-ranap').serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        const modalEl = document.getElementById('modal-handling-ranap');
                        if (modalEl && window.bootstrap) {
                            const inst = bootstrap.Modal.getInstance(modalEl);
                            if (inst) inst.hide();
                        }
                        if (typeof reloadTable === 'function') reloadTable();
                    });
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
            },
            complete: function() {
                isSavingRanap = false;
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
})();
</script>
