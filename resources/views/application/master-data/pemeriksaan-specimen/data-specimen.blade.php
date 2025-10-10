<div class="card-body fs--1">
    <div class="row g-3">
        <div class="col-12">
            <label class="form-label text-warning" for="inputAddress">Specimen </label>
            <select name="data_specimen" id="data_specimen" class="form-control choices-single-layanan">
                <option value="">Pilih Specimen</option>
                @foreach ($specimen as $spec)
                <option value="{{ $spec->s_specimen_data_code }}">{{ $spec->s_specimen_data_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-falcon-primary" id="button-simpan-data-specimen-pemeriksaan" data-code="{{ $code }}">Simpan</button>
        </div>
    </div>
</div>
<div class="card-footer bg-light  border-top">
    <div id="menu-master-specimen-detail">
        @foreach ($data as $datas)
        <span class="badge bg-primary">{{$datas->s_specimen_data_name}}</span>
        @endforeach
    </div>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-layanan"));
</script>
