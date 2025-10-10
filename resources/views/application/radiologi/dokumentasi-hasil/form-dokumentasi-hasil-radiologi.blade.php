<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">Report Dokumentasi Hasil {{ $code }}</h5>
            <button class="btn btn-falcon-warning btn-sm" id="button-kirim-dokumentasi-hasil" data-code="{{$code}}" >Kirim</button>
        </div>
    </div>
    <div class="card-body bg-light">
        <iframe src="{{ Storage::url('hasil/rad/'.$code.'.pdf' )}}" frameborder="0" style="width: 100%; height: 450px;"></iframe>
    </div>
</div>
