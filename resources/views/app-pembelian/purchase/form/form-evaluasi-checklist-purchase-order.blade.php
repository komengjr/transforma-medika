<div class="card border mt-3">
    <div class="card-body">
        <table class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>Penawaran / Supplier</th>
                    <th>Nama Barang </th>
                    <th>Qty</th>
                    <th>Harga Barang </th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Penawaran Awal</td>
                    <td>{{ $data->master_item_name }}</td>
                    <td>
                        {{$data->pem_pr_order_data_qty}} {{$data->master_item_opt}}
                    </td>
                    <td>@currency($data->pem_pr_order_data_harga) / {{$data->master_item_opt}}</td>
                    <td>{{$data->pem_pr_order_data_discount}} %</td>
                    <td>@currency(($data->pem_pr_order_data_harga * $data->pem_pr_req_data_qty) - ($data->pem_pr_order_data_harga * $data->pem_pr_order_data_qty * $data->pem_pr_order_data_discount / 100))
                    </td>
                    <td>
                        <!-- <button class="btn btn-danger btn-sm">Pilih</button> -->
                    </td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>{{ $data_supp->master_item_name }}</td>
                    <td>{{$data_supp->pem_pr_order_datas_qty}} {{$data_supp->master_item_opt}}</td>
                    <td>@currency($data_supp->pem_pr_order_datas_harga) / {{$data_supp->master_item_opt}}</td>
                    <td>{{$data_supp->pem_pr_order_datas_discount}} %</td>
                    <td>@currency(($data_supp->pem_pr_order_datas_harga * $data_supp->pem_pr_order_datas_qty) - ($data_supp->pem_pr_order_datas_harga * $data_supp->pem_pr_order_datas_qty * $data_supp->pem_pr_order_datas_discount / 100))
                    </td>
                    <td>
                        <!-- <button class="btn btn-danger btn-sm">Pilih</button> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary float-end" id="button-accept-evaluasi-purchase-order"
            data-code="{{ $data->pem_pr_order_code }}" data-id="{{ $data->pem_pr_req_data_code }}">Terima</button>
        <button class="btn btn-danger" id="button-simpan-item-purchase-order">Tolak</button>
    </div>
</div>
<!-- <script src="{{ asset('asset/js/rupiah.js') }}"></script> -->
