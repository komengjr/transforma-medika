<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Batch Obat :
            {{ $obat->farm_data_obat_name }}
        </h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <table id="data-batch" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>GRN</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Keterangan</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $datas->pem_grn_token_number }}</td>
                        <td>@currency($datas->farm_data_obat_sale_buy)</td>
                        <td>@currency($datas->farm_data_obat_sale_sell)</td>
                        <td>{{ $datas->farm_data_obat_sale_desc }}</td>
                        <td>
                            @php
                                $exp = DB::table('farm_data_obat_exp')->where('pem_grn_token_code', $datas->pem_grn_token_code)->get();
                            @endphp
                            @foreach ($exp as $exps)
                                <div class="col-sm-12 col-lg-12 m-2">
                                    <div class="card text-white bg-facebook">
                                        <div class="card-body py-1">
                                            <div class="card-title my-0 fs--2 ">Tanggal Masuk <strong
                                                    class="text-warning">|</strong> Expierd <strong
                                                    class="text-warning">|</strong> Stok</div>
                                            <p class="card-text fs--1">{{ $exps->data_obat_tanggal_masuk }} <strong
                                                    class="text-warning">|</strong> {{ $exps->data_obat_tanggal_exp }} <strong
                                                    class="text-warning">|</strong> {{ $exps->data_obat_stok }}</p>
                                            <!-- <p class="card-text">{{ $exps->data_obat_tanggal_exp }}</p>
                                                    <p class="card-text">{{ $exps->data_obat_stok }}</p> -->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new DataTable('#data-batch', {
        responsive: true
    });
</script>
