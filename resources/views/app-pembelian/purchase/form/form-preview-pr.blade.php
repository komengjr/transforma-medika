<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Preview Report Purchase Request</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="" id="menu-preview-pr">

    </div>
</div>

<script>
    $('#menu-preview-pr').html(
        '<div class="spinner-border spinner-border-sm my-3 text-primary" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span> </div>'
    );
    $.ajax({
        url: "{{ route('purchase_req_report_pr') }}",
        type: "POST",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
            "code": "{{ $code }}"
        },
        dataType: 'html',
    }).done(function (data) {
        $('#menu-preview-pr').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:533px;" frameborder="0"></iframe>');
    }).fail(function () {
        $('#menu-preview-pr').html('eror');
    });
</script>
