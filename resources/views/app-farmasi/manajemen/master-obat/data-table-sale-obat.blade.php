<table class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>GRN</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Desc</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $datas)
            <tr>
                <td>{{ $datas->pem_grn_token_number }}</td>
                <td>@currency($datas->farm_data_obat_sale_buy)</td>
                <td>@currency($datas->farm_data_obat_sale_sell)</td>
                <td>{{ $datas->farm_data_obat_sale_desc }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
