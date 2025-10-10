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
            $total = 0;
            $total1 = 0;
        @endphp
        @foreach ($data as $datas)
            @php
                $supp = DB::table('pem_pr_order_datas')
                    ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
                    ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                    ->where('pem_pr_order_datas.pem_pr_req_data_code', $datas->pem_pr_req_data_code)->first();
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $datas->master_item_name }}</td>
                <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                <td>
                    @currency($datas->pem_pr_order_data_harga)
                    / <small>{{ $datas->master_item_opt }}</small>
                    @if ($supp)
                        <br>
                        <strong class="text-warning">@currency($supp->pem_pr_order_datas_harga)</strong>
                    @endif
                </td>
                <td>
                    -
                    @currency($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100)
                    ( {{ $datas->pem_pr_order_data_discount }} % )
                    @if ($supp)
                        <br>
                        <strong class="text-warning">
                            -
                            @currency($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100)
                            ( {{ $supp->pem_pr_order_datas_discount }} % )
                        </strong>
                    @endif
                </td>
                <td class="text-end">
                    @currency(($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100))
                    @if ($supp)
                        <br>
                        <strong class="text-warning">
                            @currency(($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty) - ($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100))
                        </strong>
                    @endif
                </td>
                <td class="text-center">
                    @if ($supp)
                        @if ($supp->pem_pr_order_datas_status == 0)
                            <button class="btn btn-falcon-warning btn-sm m-2" id="button-checklist-purchase-order"
                                data-code="{{ $supp->pem_pr_req_data_code }}"><span
                                    class="far fa-check-square fs-2"></span></button>
                        @else
                            <button class="btn btn-falcon-success btn-sm m-0"><span
                                    class="far fa-check-square fs-2"></span></button>
                        @endif
                    @endif
                </td>
            </tr>
            @php
                $total = $total + (($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100));
            @endphp
            @if ($supp)
                @php
                    $total1 = $total1 + (($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty) - ($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100));
                @endphp
            @endif
        @endforeach
    </tbody>
    <tfoot class="bg-300 text-dark border-white">
        <tr>
            <td colspan="2">Total</td>
            <td colspan="4" class="text-end">@currency($total)<br><strong
                    class="text-warning">@currency($total1)</strong></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">PPN {{ $info->pem_pr_order_ppn_v }} %</td>
            <td colspan="4" class="text-end">
                @currency($total * $info->pem_pr_order_ppn_v / 100)<br>
                <strong class="text-warning">@currency($total1 * $info->pem_pr_order_ppn_v / 100)</strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Total Payment</td>
            <td colspan="4" class="text-end">
                <strong>@currency($total + ($total * $info->pem_pr_order_ppn_v / 100) - $info->pem_pr_order_discount)<br><strong
                        class="text-warning">@currency($total1 + ($total1 * $info->pem_pr_order_ppn_v / 100))</strong></strong>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
<script>
    new DataTable('#data_barang', {
        responsive: true,
        // searching: false,
        paging: false,
        info: false
    });
</script>
