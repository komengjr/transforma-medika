<form class="row g-3 p-4" action="{{ route('mou_company_insert_peserta_mcu_upload_save') }}" method="post"
    enctype="multipart/form-data">
    @csrf
    <div class="col-md-6">
        <label class="form-label" for="inputAddress">Pilih Agrement</label>
        <select name="id" class="form-control choices-single-jenis" required>
            <option value="">Pilih Agrement</option>
            @foreach ($data as $datas)
                <option value="{{ $datas->mou_agreement_code }}">{{ $datas->mou_agreement_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputAddress">Pilih File</label>
        <input class="form-control form-control-lg" id="file" type="file" name="file" placeholder="120"
            required />
        <input type="text" name="code" value="{{ $code }}" hidden>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" id="gridCheck" type="checkbox" required />
            <label class="form-check-label" for="gridCheck">Check me</label>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
    </div>
</form>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
</script>
