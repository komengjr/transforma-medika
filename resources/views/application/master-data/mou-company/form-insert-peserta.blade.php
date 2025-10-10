<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Upload Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    {{-- <h3 class="m-0"><span class="badge bg-primary m-0 p-0"></span></h3> --}}
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span> Metode
                            Insert</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" id="button-add-form-mou-company"
                                data-code="{{ $data->company_mou_code }}"><span class="far fa-edit"></span>
                                Add Manual
                            </button>
                            <button class="dropdown-item" id="button-add-upload-mou-company"
                                data-code="{{ $data->company_mou_code }}"><span class="fas fa-upload"></span>
                                Import Excel By Agrement
                            </button>
                            <button class="dropdown-item" id="button-add-upload-excel-mou-company"
                                data-code="{{ $data->company_mou_code }}"><span class="fas fa-coins"></span>
                                Import Excel All Peserta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border border-primary" id="menu-metode-insert"></div>
    </div>
</div>
