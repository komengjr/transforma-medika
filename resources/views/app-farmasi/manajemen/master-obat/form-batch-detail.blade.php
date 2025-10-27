<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Batch Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <table class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>GRN</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Exp</th>
                    <th>Stok</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $datas->pem_grn_token_code }}</td>
                        <td>{{ $datas->data_obat_tanggal_masuk }}</td>
                        <td>{{ $datas->data_obat_tanggal_exp }}</td>
                        <td>{{ $datas->data_obat_stok }}</td>
                        <td>{{ $datas->data_obat_rak }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
