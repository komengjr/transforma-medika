<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Data Registrasi Pasien</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4">
        <div class="row g-3">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    @php
                        $no = $data->count();
                    @endphp
                    @foreach ($data as $datas)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$datas->id_d_reg_order}}" aria-expanded="true"
                                    aria-controls="collapse2">
                                    Pemeriksaan ke {{ $no-- }} - {{ $datas->d_reg_order_date }} - {{ $datas->t_layanan_cat_name }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse{{$datas->id_d_reg_order}}"
                                aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                <div class="accordion-body">You can issue either partial or full refunds. There are no fees
                                    to refund a charge, but the fees from the original charge are not returned.</div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
