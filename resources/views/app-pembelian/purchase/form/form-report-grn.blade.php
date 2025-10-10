<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Goods Recived Note</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-goods-recived-note">

    </div>
    <div class="p-4 pt-2 pb-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="">Masukan No Invoice</label>
                        <input type="text" name="" class="form-control form-control-lg" id="no_invoice">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-bayar-grn">
        <button class="btn btn-primary" id="button-bayar" data-id="paynow" data-code="{{ $code }}" data-name="Bayar Sekarang">Bayar Sekarang</button>
        <button class="btn btn-warning" id="button-bayar" data-id="paylater" data-code="{{ $code }}" data-name="Bayar Nanti">Bayar Nanti</button>
    </span>
</div>
<script>
    $('#menu-goods-recived-note').html(
        '<div class="spinner-border spinner-border-sm" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span> </div>'
    );
    $.ajax({
        url: "{{ route('goods_recived_note_report') }}",
        type: "POST",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
            "code": "{{ $code }}"
        },
        dataType: 'html',
    }).done(function (data) {
        $('#menu-goods-recived-note').html(
            '<iframe src="data:application/pdf;base64, ' +
            data +
            '" style="width:100%; height:533px;" frameborder="0"></iframe>');
    }).fail(function () {
        $('#menu-goods-recived-note').html('eror');
    });
</script>
