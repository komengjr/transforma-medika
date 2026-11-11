<div class="card-body fs--1 p-4" style="background-color: var(--retro-bg);">
    <div class="row g-3">
        <div class="col-12">
            <label class="form-label fw-bolder text-dark" for="data_specimen">PILIH SPECIMEN</label>
            <select name="data_specimen" id="data_specimen" class="form-select retro-input py-2">
                <option value="">-- Pilih Specimen --</option>
                @foreach ($specimen as $spec)
                <option value="{{ $spec->id }}">{{ $spec->s_specimen_data_name }} ({{ $spec->wadah_tabung ?? 'Tabung Umum' }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 text-end">
            <button class="btn btn-sm retro-btn retro-btn-primary w-100" id="button-simpan-data-specimen-pemeriksaan" data-code="{{ $code }}">
                <i class="fas fa-plus me-1"></i> SIMPAN SPESIMEN
            </button>
        </div>
    </div>
</div>

<div class="card-footer bg-white border-top border-dark p-3">
    <label class="form-label fw-bolder text-dark small mb-2 d-block">SPESIMEN TERDAFTAR:</label>
    <div id="menu-master-specimen-detail" class="d-flex flex-wrap gap-1">
        @if(count($data) > 0)
        @foreach ($data as $datas)
        <span class="retro-badge" style="background-color: var(--retro-purple); color: var(--retro-dark); font-size: 0.75rem;">
            <i class="fas fa-vial me-1"></i> {{$datas->s_specimen_data_name}}
        </span>
        @endforeach
        @else
        <small class="text-muted fst-italic">Belum ada spesimen yang ditambahkan.</small>
        @endif
    </div>
</div>

<script>
    // Inisialisasi ulang jika menggunakan choices.js atau select2 jika diperlukan
    if (typeof window.Choices !== 'undefined' && document.querySelector("#data_specimen")) {
        new window.Choices(document.querySelector("#data_specimen"));
    }
</script>
