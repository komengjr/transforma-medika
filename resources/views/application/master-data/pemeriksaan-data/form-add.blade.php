<div class="modal-content retro-modal-content">
    <div class="modal-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark); color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark);">
        <h4 class="mb-0 fw-bolder text-white" id="staticBackdropLabel">
            <i class="fas fa-plus-square me-2"></i> TAMBAH DATA PEMERIKSAAN
        </h4>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button> -->
    </div>

    <div class="modal-body p-0" style="background-color: var(--retro-bg);">
        <ul class="nav nav-tabs retro-tabs px-4 pt-3" id="myTab" role="tablist" style="border-bottom: 3px solid var(--retro-dark);">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bolder" id="satuan-tab" data-bs-toggle="tab" data-bs-target="#satuan" type="button" role="tab" style="color: var(--retro-dark); border: 3px solid var(--retro-dark); border-bottom: none; background-color: var(--retro-green); margin-right: 5px; border-radius: 8px 8px 0 0;">
                    <i class="fas fa-edit me-1"></i> INPUT SATUAN
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bolder" id="import-tab" data-bs-toggle="tab" data-bs-target="#import" type="button" role="tab" style="color: var(--retro-dark); border: 3px solid var(--retro-dark); border-bottom: none; background-color: #ffffff; border-radius: 8px 8px 0 0;">
                    <i class="fas fa-file-excel me-1"></i> IMPORT EXCEL
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- TAB 1: INPUT SATUAN -->
            <div class="tab-pane fade show active p-4" id="satuan" role="tabpanel" style="background-color: #ffffff;">
                <!-- TAMBAHKAN ID DISINI: form-add-pemeriksaan -->
                <form id="form-add-pemeriksaan" class="row g-3" action="{{ route('master_pemeriksaan_data_save') }}" method="post">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">KODE LAYANAN</label>
                        <input class="form-control py-2" type="text" placeholder="Auto Generate (Misal: LAB-001)" style="background-color: #e9ecef; border: 2px solid var(--retro-dark); border-radius: 6px; font-weight: 700;" readonly />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">TIPE LAYANAN <span class="text-danger">*</span></label>
                        <select name="tipe_layanan_id" class="form-select retro-input py-2" required>
                            <option value="">-- PILIH TIPE LAYANAN --</option>
                            @foreach ($cat as $cats)
                            <option value="{{ $cats->id }}">{{ strtoupper($cats->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">NAMA PEMERIKSAAN <span class="text-danger">*</span></label>
                        <input class="form-control retro-input py-2" type="text" name="nama_layanan" placeholder="Misal: Cek Darah Lengkap" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">JENIS PEMERIKSAAN <span class="text-danger">*</span></label>
                        <select name="is_paket" class="form-select retro-input py-2" required>
                            <option value="0">SATUAN (NON-PAKET)</option>
                            <option value="1">PAKET PEMERIKSAAN</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">TARIF DASAR (Rp) <span class="text-danger">*</span></label>
                        <input class="form-control retro-input py-2" type="number" name="harga" placeholder="0" min="0" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">ESTIMASI WAKTU (MENIT)</label>
                        <input class="form-control retro-input py-2" type="number" name="estimasi_waktu_menit" value="15" min="1" />
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="button" class="btn retro-btn retro-btn-light me-2" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn retro-btn retro-btn-primary" id="btn-save-pemeriksaan">
                            <i class="fas fa-save me-1"></i> SIMPAN DATA
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: IMPORT EXCEL -->
            <div class="tab-pane fade p-4" id="import" role="tabpanel" style="background-color: #ffffff;">
                <div class="alert alert-info border-3 mb-4" style="background-color: var(--retro-cyan); border-color: var(--retro-dark); color: var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                    <h6 class="fw-bolder mb-1"><i class="fas fa-info-circle me-1"></i> PANDUAN IMPORT</h6>
                    <small class="fw-bold">Pastikan format kolom Excel sesuai dengan template. Jika kosong, kode layanan akan digenerate secara otomatis.</small>
                </div>

                <form id="form-import-pemeriksaan" class="row g-3" action="{{ route('master_pemeriksaan_import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 text-center mb-3">
                        <a href="{{ url('/master-data/pemeriksaan/download-template') }}" class="btn retro-btn retro-btn-warning w-100 mb-2">
                            <i class="fas fa-download me-1"></i> DOWNLOAD TEMPLATE EXCEL
                        </a>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bolder" style="color: var(--retro-dark);">UPLOAD FILE EXCEL (.xlsx / .csv) <span class="text-danger">*</span></label>
                        <input class="form-control retro-input py-2" type="file" name="file_excel" accept=".xlsx, .xls, .csv" required />
                    </div>
                    <div class="col-12 mt-4 text-end">
                        <button type="button" class="btn retro-btn retro-btn-light me-2" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn retro-btn retro-btn-primary">
                            <i class="fas fa-upload me-1"></i> UPLOAD & PROSES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script Warna Tab Retro
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        $('button[data-bs-toggle="tab"]').css('background-color', '#ffffff');
        var activeTabId = $(e.target).attr('id');
        if (activeTabId === 'satuan-tab') {
            $(e.target).css('background-color', 'var(--retro-green)');
        } else if (activeTabId === 'import-tab') {
            $(e.target).css('background-color', 'var(--retro-yellow)');
        }
    });
</script>
