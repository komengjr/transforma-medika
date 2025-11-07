<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">Report Dokumentasi Hasil</h5>
            @if ($data->d_reg_order_lab_status == 3)
                <button class="btn btn-falcon-primary btn-sm" id="button-kirim-dokumentasi-hasil"
                    data-code="{{$code}}">Kirim</button>
            @else
                <button class="btn btn-falcon-danger btn-sm" id="button-batal-kirim-dokumentasi-hasil"
                    data-code="{{$code}}">Batal Kirim</button>
            @endif
        </div>
    </div>
    <div class="card-body bg-light">
        <iframe src="{{ Storage::url('hasil/lab/' . $code . '.pdf')}}" frameborder="0"
            style="width: 100%; height: 450px;"></iframe>
    </div>
</div>
