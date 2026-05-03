<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Report Data Pengajuan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a>
        </p>
    </div>
    <div class="p-4 pb-4" id="menu-report-data-pengajuan">

    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-verifikasi">

    </span>
</div>
<script>
    $('#menu-report-data-pengajuan').html(
        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
    );
    $.ajax({
        url: "{{ route('menu_peminjaman_list_cetak_pengajuan_report') }}",
        type: "POST",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
            "code": "{{ $code }}",
            "reg": 123,
        },
        dataType: 'html',
    }).done(function(data) {
        $('#menu-report-data-pengajuan').html(
            '<iframe src="data:application/pdf;base64, ' +
            data +
            '" style="width:100%; height:533px;" frameborder="0"></iframe>');
    }).fail(function() {
        $('#menu-report-data-pengajuan').html('eror');
    });
</script>
