<div class="card-header bg-300 d-flex justify-content-between">
    <div>
        <button class="btn btn-falcon-default"><span class="fas fa-cart-plus"></span></button>
        <span class="mx-1 mx-sm-2 text-danger">|</span>

        <button class="btn btn-falcon-default"><span class="fas fa-cloud-upload-alt"></span></button>
    </div>
    <div class="d-flex">
        <select name="group_pemeriksaan" id="group_pemeriksaan"
            class="form-control choices-single-layanan form-select-sm">
            <option value="">Pilih Layanan Pemeriksaan</option>
            @foreach ($layanan as $lay)
                <option value="{{ $lay->t_layanan_cat_code }}">{{ $lay->t_layanan_cat_name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="card-body fs--1">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead class="bg-200 text-700">
            <tr>
                <th>No</th>
                <th>Kode Pemeriksaan</th>
                <th>Kategori Pemeriksaan</th>
                <th>Nama Pemeriksaan</th>
                <th>Status Pemeriksaan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
        </tbody>
    </table>
</div>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    new window.Choices(document.querySelector(".choices-single-layanan"));
</script>
