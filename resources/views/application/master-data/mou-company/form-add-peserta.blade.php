<form class="row g-3 p-4" action="{{ route('mou_company_insert_peserta_mcu_manual_save') }}" method="post"
    enctype="multipart/form-data">
    @csrf
    <div class="col-md-6">
        <label class="form-label" for="inputAddress">Pilih Agrement</label>
        <select name="agreement" class="form-control choices-single-jenis" required>
            <option value="">Pilih Agrement</option>
            @foreach ($data as $datas)
                <option value="{{ $datas->mou_agreement_code }}">{{ $datas->mou_agreement_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputAddress">Nama Peserta</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="nama"
            placeholder="Jhon Doe" required />
        <input type="text" name="code" value="{{ $code }}" id="" hidden>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="inputAddress">NIK</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="nik"
            placeholder="00000000" required />
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputAddress">NIP</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="nip"
            placeholder="00000000" required />
    </div>
    <div class="col-md-4">
        <label class="form-label" for="inputAddress">Email</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="email"
            placeholder="00000000" required />
    </div>
    <div class="col-md-4">
        <label class="form-label" for="inputAddress">No Hp</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="no_hp"
            placeholder="00000000" required />
    </div>
    <div class="col-md-4">
        <label class="form-label" for="inputAddress">Departemen</label>
        <input class="form-control form-control-lg" id="inputAddress" type="text" name="departemen" placeholder="-"
            required />
    </div>
    <div class="col-6">
        <label class="form-label" for="inputAddress">Jenis Kelamin</label>
        <select name="jk" class="form-select form-select-lg" id="">
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L">Laki - Laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>
    <div class="col-6">
        <label class="form-label" for="inputAddress">Tanggal Lahir</label>
        <input class="form-control form-control-lg" id="inputAddress" type="date" name="ttl" placeholder="120"
            required />
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
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
