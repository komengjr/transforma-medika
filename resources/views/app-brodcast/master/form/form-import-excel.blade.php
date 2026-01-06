<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Import Data Contact</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="response">
        <p>Download Template <a href="{{ asset('data/Template_contact.xlsx') }}">Here</a></p>
        <form class="row g-3" id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6 position-relative">
                <input type="file" class="form-control" id="excelFile" name="file" required>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" type="submit">Proses Import</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('#response').html('<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>');
        $.ajax({
            url: "{{route('master_brodcast_contact_import_save')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                $('#response').html(res);
                location.reload();
            },
            error: function(err) {
                $('#response').html(`<p style="color:red">${err.responseJSON.message}</p>`);
            }
        });
    });
</script>
