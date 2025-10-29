<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Penjualan Data Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <style>
        .choices {
            width: 100%;
            border-radius: 5px;
        }
    </style>
    <div class="p-4 pt-3">
        <form class="row pb-3" id="form-input-data-sale-obat">
            @csrf
            <input type="text" name="code" id="" value="{{ $code }}" hidden>
            <div class="col-md-7">
                <label for="inputLastName1" class="form-label text-youtube">Goods Recive Notes ( GRN )</label>
                <select name="grn" class="form-select form-select-lg choices-single-company" id="grn">
                    <option value="">Pilih Grn</option>
                    @foreach ($grn as $grns)
                        <option value="{{ $grns->pem_grn_token_code }}">{{ $grns->pem_grn_token_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="inputLastName1" class="form-label text-youtube">Harga Jual</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="number" name="harga" class="form-control form-control-lg border-start-0 bg-white"
                        value="0" id="harga">
                </div>
            </div>
            <div class="col-12 pt-3">
                <span id="menu-add-data-sale-obat">
                    <button class="btn btn-primary btn-sm" id="button-save-data-sale-obat">Simpan</button>
                </span>
            </div>
        </form>
        <div id="data-table-sale-obat">
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
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new window.Choices(document.querySelector(".choices-single-company"));
</script>
