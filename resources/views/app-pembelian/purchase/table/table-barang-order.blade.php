<div class="col-md-6">
    <div class="card border">
        <div class="card-body bg-light border-top">
            <table id="data_barang" class="table table-striped border" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>No Purchase Req</th>
                        <th>Nama Barang</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @if (!$data->isEmpty())
                        @foreach ($data as $datas)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $datas->pem_pr_req_nomor }} <br> <small>{{ $datas->pem_pr_req_data_code }}</small></td>
                                <td>{{ $datas->master_item_name }}</td>
                                <td>{{ $datas->pem_pr_req_data_type }}</td>
                                <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                                <td class="text-end">
                                    @php
                                        $cek = DB::table('pem_pr_order_data')->where('pem_pr_req_data_code', $datas->pem_pr_req_data_code)->first();
                                    @endphp
                                    @if ($cek)
                                        <span class="badge bg-primary">Ok</span>
                                    @else
                                        <button class="btn btn-warning btn-sm" id="button-pilih-item-order"
                                            data-id="{{ $datas->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                                                class="far fa-arrow-alt-circle-right"></span></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="col-md-6">
    <div class="card border">
        <div class="card-body bg-light border-top" id="table-barang-request-order">
            <table id="data_barang_req" class="table table-striped border" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($order as $orders)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $orders->master_item_name }}</td>
                            <td>{{ $orders->pem_pr_req_data_type }}</td>
                            <td>{{ $orders->pem_pr_req_data_qty }} {{ $orders->master_item_opt }}</td>
                            <td class="text-end">
                                <button class="btn btn-danger btn-sm" id="button-remove-item-order"
                                    data-id="{{ $orders->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                                        class="far fa-trash-alt"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    new DataTable('#data_barang', {
        responsive: true
    });
    new DataTable('#data_barang_req', {
        responsive: true
    });
</script>
