<div class="modal-content retro-modal-content">
    <div class="modal-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow); color: var(--retro-dark); border-bottom: 3px solid var(--retro-dark);">
        <h4 class="mb-0 fw-bolder" id="staticBackdropLabel">
            <i class="far fa-edit me-2"></i> UPDATE DATA PEMERIKSAAN
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
    </div>

    <div class="modal-body p-4" style="background-color: var(--retro-bg);">
        <form id="form-update-pemeriksaan" class="row g-3" action="{{ route('master_pemeriksaan_update_save') }}" method="post">
            @csrf
            <!-- Input Hidden Kode Layanan Lama -->
            <input type="hidden" name="kode_layanan" value="{{ $data->kode_layanan }}">

            <div class="col-md-6">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">KODE LAYANAN</label>
                <input class="form-control py-2" type="text" value="{{ $data->kode_layanan }}" style="background-color: #e9ecef; border: 2px solid var(--retro-dark); border-radius: 6px; font-weight: 700; color: var(--retro-dark);" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">TIPE LAYANAN <span class="text-danger">*</span></label>
                <select name="tipe_layanan_id" class="form-select retro-input py-2" required>
                    <option value="">-- PILIH TIPE LAYANAN --</option>
                    @foreach ($cat as $cats)
                    <option value="{{ $cats->id }}" {{ $data->tipe_layanan_id == $cats->id ? 'selected' : '' }}>
                        {{ strtoupper($cats->nama_tipe) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">NAMA PEMERIKSAAN <span class="text-danger">*</span></label>
                <input class="form-control retro-input py-2" type="text" name="nama_layanan" value="{{ $data->nama_layanan }}" required />
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">JENIS PEMERIKSAAN <span class="text-danger">*</span></label>
                <select name="is_paket" class="form-select retro-input py-2" required>
                    <option value="0" {{ $data->is_paket == 0 ? 'selected' : '' }}>SATUAN (NON-PAKET)</option>
                    <option value="1" {{ $data->is_paket == 1 ? 'selected' : '' }}>PAKET PEMERIKSAAN</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">TARIF DASAR (Rp) <span class="text-danger">*</span></label>
                <input class="form-control retro-input py-2" type="number" name="harga" value="{{ round($data->harga) }}" min="0" required />
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">ESTIMASI WAKTU (MENIT)</label>
                <input class="form-control retro-input py-2" type="number" name="estimasi_waktu_menit" value="{{ $data->estimasi_waktu_menit }}" min="1" />
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bolder" style="color: var(--retro-dark);">STATUS LAYANAN <span class="text-danger">*</span></label>
                <select name="is_active" class="form-select retro-input py-2" required>
                    <option value="1" {{ $data->is_active == 1 ? 'selected' : '' }}>AKTIF</option>
                    <option value="0" {{ $data->is_active == 0 ? 'selected' : '' }}>NON-AKTIF</option>
                </select>
            </div>

            <div class="col-12 mt-4 text-end">
                <button type="button" class="btn retro-btn retro-btn-light me-2" data-bs-dismiss="modal">BATAL</button>
                <button type="submit" class="btn retro-btn retro-btn-warning" id="btn-update-pemeriksaan">
                    <i class="fas fa-save me-1"></i> SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>
</div>

