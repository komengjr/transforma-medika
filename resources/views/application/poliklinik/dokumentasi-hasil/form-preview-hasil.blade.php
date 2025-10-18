<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Preview Dokumentasi Hasil Pasien</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL') }}</a></p>
    </div>
    <div id="menu-preview-hasil"></div>
</div>
<script>
    $('#menu-preview-hasil').html(
        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
    );
    $.ajax({
        url: "{{ route('verifikasi_poliklinik_dokumentasi_hasil_preview_report') }}",
        type: "POST",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
            "code": '{{$code}}'
        },
        dataType: 'html',
    }).done(function (data) {
        $('#menu-preview-hasil').html('<iframe src="data:application/pdf;base64, ' +
            data +
            '" style="width:100%; height:533px;" frameborder="0"></iframe>');
    }).fail(function () {
        $('#menu-preview-hasil').html('eror');
    });
</script>
