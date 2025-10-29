<table id="example" class="table table-striped border" style="width:100%">
    <thead class="bg-warning text-100">
        <tr>
            <th>Kode</th>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th class="text-center">Stok Minimum</th>
            <th class="text-center">Batch & Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="dataBody">
        @php
            $no = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td data-label="Kode">{{$no++}}</td>
                <td data-label="Nama">{{ $datas->farm_data_obat_name }}</td>
                <td data-label="Satuan">{{ $datas->farm_data_obat_satuan }}</td>
                <td data-label="Kategori">{{ $datas->farm_data_obat_cat }}</td>
                <td data-label="Pabrikan">{{ $datas->farm_data_obat_jenis }}</td>
                <td class="text-center">{{ $datas->farm_data_obat_stok_minimum }}</td>
                <td class="text-center">
                    @php
                        $total = DB::table('farm_data_obat_exp')->where('farm_data_obat_code', $datas->farm_data_obat_code)->count();
                    @endphp
                    <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal-obat"
                        id="button-bacth-detail" data-code="{{ $datas->farm_data_obat_code }}">{{ $total }}</button>
                </td>
                <td data-label="Aksi">
                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal-obat"
                        id="button-update-data-obat" data-code="{{ $datas->farm_data_obat_code }}">✏️</button>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-obat"
                        id="button-add-batch-obat" data-code="{{ $datas->farm_data_obat_code }}"><i
                            class="fab fa-ioxhost"></i></button>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-obat"
                        id="button-sale-data-obat" data-code="{{ $datas->farm_data_obat_code }}"><i
                            class="fab fa-shopify"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
