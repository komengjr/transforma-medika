<table id="data_barang" class="table table-striped nowrap" style="width:100%">
    <thead class="bg-200 text-700 fs--2">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $datas->master_item_name }}</td>
                <td>{{ $datas->pem_pr_req_data_type }}</td>
                <td>{{ $datas->pem_pr_req_data_qty }}</td>
                <td class="text-center"><button class="btn btn-danger btn-sm" id="button-remove-item-pr"
                        data-id="{{ $datas->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                            class="fas fa-trash"></span></button></td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
