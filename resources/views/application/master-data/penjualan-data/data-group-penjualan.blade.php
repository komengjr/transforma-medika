<div class="card-header bg-300 d-flex justify-content-between">
    <div>
        <button class="btn btn-falcon-default btn-sm me-1 mb-2" id="button-add-data-penjualan" data-code="{{$code}}"><span class="fas fa-cart-plus"></span></button>
        <span class="mx-1 mx-sm-2 text-danger mb-1">|</span>
        <button class="btn btn-falcon-default btn-sm me-1 mb-2" id="button-import-data-penjualan"><span class="fas fa-file-import"></span></button>
    </div>
    <div class="">
        <select name="group_layanan" id="group_layanan" class="form-control choices-single-layanan form-select-sm">
            <option value="">Pilih Layanan Pemeriksaan</option>
            @foreach ($data as $datas)
                <option value="{{ $datas->p_sales_cat_code  }}">{{ $datas->t_layanan_cat_name }}
                    {{ $datas->p_sales_cat_name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="card-body fs--1">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead class="bg-200 text-700">
            <tr>
                <th>No</th>
                <th>Nama Item</th>
                <th>Kategori Penjualan</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Diskon</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($harga as $hargas)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$hargas->t_pemeriksaan_list_name}}</td>
                    <td>{{$hargas->p_sales_cat_name}}</td>
                    <td>{{$hargas->t_layanan_cat_name}}</td>
                    <td>@currency($hargas->p_sales_data_price)</td>
                    <td>{{$hargas->p_sales_data_disc}} %</td>
                </tr>
            @endforeach
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
