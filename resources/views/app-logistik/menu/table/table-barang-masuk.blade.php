<table id="data_barang" class="table table-striped border" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Quantity</th>
            <th>Harga / <small>Item</small> </th>
            <th>Discount </th>
            <th class="text-end">Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $datas->master_item_name }} <br> <small class="text-warning">No Grn :
                        {{ $datas->pem_grn_token_number }}</small> </td>
                <td>{{ $datas->pem_pr_order_datas_qty }} / <small> {{ $datas->master_item_opt }}</small></td>
                <td class="text-end">@currency($datas->pem_pr_order_datas_harga)</td>
                <td>{{ $datas->pem_pr_order_datas_discount }} %</td>
                <td class="text-end">
                    @currency($datas->pem_pr_order_datas_harga * $datas->pem_pr_order_datas_qty)</td>
                <td class="text-center"><button class="btn btn-primary btn-sm" id="button-input-product-in"
                        data-code="{{ $datas->pem_pr_order_datas_code }}" data-id="{{ $code }}">Barang Masuk</button></td>
            </tr>
        @endforeach
    </tbody>

</table>
<hr>
<span class="badge bg-facebook">List Barang Masuk</span>
<table id="data_barang_masuk" class="table table-striped border" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Quantity</th>
            <th>Harga / <small>Item</small> </th>
            <th>Discount </th>
            <th class="text-end">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($product as $products)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $products->master_item_name }} <br> <small class="text-warning">No Grn : {{ $products->pem_grn_token_number }}</small> </td>
                <td>{{ $products->pem_pr_order_datas_qty }} / <small> {{ $products->master_item_opt }}</small></td>
                <td class="text-end">@currency($products->pem_pr_order_datas_harga)</td>
                <td>{{ $products->pem_pr_order_datas_discount }} %</td>
                <td class="text-end">
                    @currency($products->pem_pr_order_datas_harga * $products->pem_pr_order_datas_qty)</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#data_barang', {
        "pageLength": 5,
        responsive: true
    });
    new DataTable('#data_barang_masuk', {
        "pageLength": 5,
        responsive: true
    });
</script>
