<div class="card retro-card border-0 mb-0" style="box-shadow: none !important;">
    <!-- Header Banner Panel Kanan -->
    <div class="card-header py-3 px-4" style="background-color: var(--retro-pink); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-1 text-dark fw-bolder" id="staticBackdropLabel">
            <i class="fas fa-boxes-packing me-2"></i> Form Add Batch Obat
        </h5>
        <p class="fs--2 mb-0 text-dark fw-bold opacity-75">Support by {{ Env('APP_LABEL') }}</p>
    </div>

    <style>
        .choices__inner {
            border: 2px solid var(--retro-dark) !important;
            border-radius: 6px !important;
            box-shadow: 2px 2px 0px var(--retro-dark) !important;
            background-color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 0.8rem !important;
        }
    </style>

    <!-- Body Panel Form -->
    <div class="card-body p-4 bg-white">
        <form class="row g-3" id="form-save-batch">
            @csrf
            <input type="hidden" name="code" value="{{ $code }}">

            <div class="col-md-12">
                <label class="form-label fw-bold text-dark fs--1">No GRN / Penerimaan</label>
                <select name="grn" class="form-select retro-input choices-single-company" id="grn">
                    <option value="">-- Pilih GRN --</option>
                    @foreach ($grns as$grns)
                    <option value="{{ $grns->pem_grn_token_code }}">{{ $grns->pem_grn_token_number }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Stok Obat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-cubes text-dark"></i></span>
                    <input type="number" name="stok" class="form-control retro-input border-start-0" placeholder="Jumlah stok..." min="0">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Lokasi Penyimpanan (Rak)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-map-marker-alt text-dark"></i></span>
                    <input type="text" name="rak" class="form-control retro-input border-start-0" placeholder="Kode rak...">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Tanggal Masuk</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="far fa-calendar-alt text-dark"></i></span>
                    <input type="date" name="masuk" class="form-control retro-input border-start-0" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Tanggal Kadaluarsa (Exp)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-hourglass-end text-dark"></i></span>
                    <input type="date" name="exp" class="form-control retro-input border-start-0">
                </div>
            </div>
        </form>
    </div>

    <!-- Footer Panel -->
    <div class="card-footer bg-light border-top border-dark py-3 px-4 text-end">
        <span id="menu-add-data-batch">
            <button class="btn retro-btn retro-btn-success btn-sm px-4 fw-bold" id="button-simpan-batch-obat">
                <i class="fas fa-save me-1"></i> Simpan Data Batch
            </button>
        </span>
    </div>
</div>

<script>
    // Inisialisasi ulang plugin Choices.js untuk elemen select GRN
    if (document.querySelector(".choices-single-company")) {
        new window.Choices(document.querySelector(".choices-single-company"), {
            searchEnabled: true,
            itemSelectText: '',
            placeholder: true,
            shouldSort: false
        });
    }
</script>
