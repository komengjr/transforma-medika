<form class="row" action="{{ route('data_registrasi_poliklinik_handling_order_layanan_rad') }}" method="POST">
    @csrf
    <div class="col-12 mb-2">
        <span class="badge bg-danger">FORM RADIOLOGI</span>
    </div>
    <div class="col-md-6">
        <label for="">Dokter Rujukan</label>
        <select name="dokter" class="form-control choices-single-dokter-rujukan" required>
            <option value="">Pilih Dokter</option>
            @foreach ($dokter as $dok)
                <option value="{{ $dok->master_doctor_code }}">{{ $dok->master_doctor_name }}</option>
            @endforeach
        </select>
        <input type="text" name="no_reg" class="form-control" value="{{ $reg }}" hidden>
        <input type="text" name="layanan" class="form-control" value="{{ $code }}" hidden>
    </div>
    <div class="col-md-6">
        <label for="">Pilih Pemeriksaan</label>
        <select name="pemeriksaan" class="form-control choices-single-dokter-periksa" required>
            <option value="">Pilih</option>
            @foreach ($pemeriksaan as $pem)
                <option value="{{ $pem->p_sales_data_code }}"> {{ $pem->t_pemeriksaan_list_name }} - @currency($pem->p_sales_data_price)</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label for="">Deskripsi</label>
        <textarea name="desc" class="form-control" id=""></textarea>
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
    </div>
</form>
<script>
    new window.Choices(document.querySelector(".choices-single-dokter-rujukan"));
    new window.Choices(document.querySelector(".choices-single-dokter-periksa"));

    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
