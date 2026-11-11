<div class="card retro-card border-0 mb-0" style="box-shadow: none !important;">
    <!-- Header Banner Panel Kanan -->
    <div class="card-header py-3 px-4" style="background-color: var(--retro-green); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-1 text-dark fw-bolder" id="staticBackdropLabel">
            <i class="fas fa-capsules me-2"></i> Form Add Master Obat
        </h5>
        <p class="fs--2 mb-0 text-dark fw-bold opacity-75">Support by {{ Env('APP_LABEL') }}</p>
    </div>

    @php
    $jenis = DB::table('farm_data_jenis')->get();$satuan = DB::table('farm_data_satuan')->get();
    @endphp

    <!-- Body Panel Form -->
    <div class="card-body p-4 bg-white">
        <form class="row g-3" id="form-input-obat">
            @csrf

            <div class="col-md-7">
                <label class="form-label fw-bold text-dark fs--1">Nama Obat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-pills text-dark"></i></span>
                    <input type="text" name="name" class="form-control retro-input border-start-0" placeholder="Masukkan nama obat...">
                </div>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-bold text-dark fs--1">Kategori Obat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-tags text-dark"></i></span>
                    <select name="kategori" class="form-select retro-input border-start-0">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="tablet">Tablet / Kaplet / Kapsul</option>
                        <option value="sirup">Sirup / Suspensi</option>
                        <option value="Injeksi">Injeksi</option>
                        <option value="salep">Salep / Krim / Gel</option>
                        <option value="tetes">Tetes (mata, telinga, hidung)</option>
                        <option value="Suppositoria">Suppositoria</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold text-dark fs--1">Satuan Obat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-balance-scale text-dark"></i></span>
                    <select name="satuan" class="form-select retro-input border-start-0">
                        <option value="">Pilih Satuan</option>
                        @foreach ($satuan as$sa)
                        <option value="{{ $sa->farm_data_satuan_code }}">{{ $sa->farm_data_satuan_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold text-dark fs--1">Jenis Obat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-notes-medical text-dark"></i></span>
                    <select name="jenis" class="form-select retro-input border-start-0">
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenis as$je)
                        <option value="{{ $je->farm_data_jenis_code }}">{{ $je->farm_data_jenis_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold text-dark fs--1">Stok Minimum</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-dark border-2 rounded-start" style="border-right: none !important;"><i class="fas fa-exclamation-triangle text-dark"></i></span>
                    <input type="number" name="stok_min" class="form-control retro-input border-start-0" value="0" min="0">
                </div>
            </div>
        </form>
    </div>

    <!-- Footer Panel -->
    <div class="card-footer bg-light border-top border-dark py-3 px-4 text-end">
        <span id="menu-add-data-obat">
            <button class="btn retro-btn retro-btn-success btn-sm px-4 fw-bold" id="button-simpan-data-obat">
                <i class="fas fa-save me-1"></i> Simpan Data Obat
            </button>
        </span>
    </div>
</div>
