<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Menu</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_gateway_whatsapp_send_message_prosess') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-12">
            <label class="form-label" for="inputAddress">Pesan</label>
            <input class="form-control" id="inputAddress" type="text" name="pesan" placeholder="dashboard"
                required />
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
