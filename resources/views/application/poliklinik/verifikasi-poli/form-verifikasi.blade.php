<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Verifikasi Pasien Poli</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">{{ Env('APP_LABEL')}}</a></p>
    </div>
    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-2 d-flex justify-content-center">
                <div class="avatar avatar-5xl shadow-sm img-thumbnail justify-content-center">
                    <div class="h-100 w-100 overflow-hidden">
                        @if ($data->master_patient_profile == "")
                            <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                                data-dz-thumbnail="data-dz-thumbnail">
                        @else
                            <img src="{{ Storage::url($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                        @endif
                    </div>

                </div>

            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-user-friends"></i></span>
                            <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                                value="{{ $data->master_patient_name }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik" value="{{ $data->master_patient_nik }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="inputLastName1" class="form-label text-youtube">No Rekam
                            Medis</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik" value="{{ $data->master_patient_code }}" disabled>
                            <input type="text" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}" hidden>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis
                            Kelamin</label>

                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-transgender"></i></span>
                            <input type="text" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                                value="{{ $data->master_patient_jk }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Tanggal
                            Lahir</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <input type="date" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                                value="{{ $data->master_patient_tgl_lahir }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <div class="accordion border-x border-top rounded" id="accordionFaq">
                            <div class="card shadow-none border-bottom rounded-bottom-0">
                                <div class="card-header p-0" id="faqAccordionHeading1">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion1">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Fisik
                                            Umum</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion1"
                                    aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($fisik as $f)
                                                @php
                                                    $val = DB::table('diag_poli_fisik_umum_d')
                                                        ->where('diag_poli_fisik_umum_code', $f->diag_poli_fisik_umum_code)
                                                        ->where('d_reg_order_poli_code', $code)->first();
                                                @endphp
                                                <div class="col-md-4">
                                                    <label for="">{{$f->diag_poli_fisik_umum_name}}</label>
                                                    <div class="input-group">
                                                        @if ($val)
                                                            <input type="text" name="{{$f->diag_poli_fisik_umum_code}}"
                                                                class="form-control form-control-lg bg-white border-end-0"
                                                                value="{{ $val->diag_poli_fisik_umum_d_val }}" disabled>
                                                            <span class="input-group-text">
                                                                {{$f->diag_poli_fisik_satuan}}
                                                            </span>
                                                        @else
                                                            <input type="text" name="{{$f->diag_poli_fisik_umum_code}}"
                                                                class="form-control form-control-lg bg-white border-end-0"
                                                                disabled>
                                                            <span class="input-group-text">
                                                                {{$f->diag_poli_fisik_satuan}}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- <div class="col-md-4">
                                                <label for="">Tinggi Badan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <input type="text" name="tgl_lahir"
                                                        class="form-control form-control-lg bg-white border-start-0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Tensi</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <input type="text" name="tgl_lahir"
                                                        class="form-control form-control-lg bg-white border-start-0">
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Keluhan Saat
                                            Ini</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq" style="">
                                    <div class="card-body">
                                        @foreach ($fisik1 as $f1)
                                            @php
                                                $val = DB::table('diag_poli_fisik_umum_d')
                                                    ->where('diag_poli_fisik_umum_code', $f1->diag_poli_fisik_umum_code)
                                                    ->where('d_reg_order_poli_code', $code)->first();
                                            @endphp
                                            <label for="">{{$f1->diag_poli_fisik_umum_name}}</label>
                                            @if ($val)
                                                <textarea name="{{$f1->diag_poli_fisik_umum_code}}" class="form-control"
                                                    id="">{{ $val->diag_poli_fisik_umum_d_val }}</textarea>
                                            @else
                                                <textarea name="{{$f1->diag_poli_fisik_umum_code}}" class="form-control"
                                                    id=""></textarea>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Diagnosa
                                            Umum</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        @php
                                            $diagnosa = DB::table('diag_poli_gigi_umum')->where('d_reg_order_poli_code', $code)->get();
                                        @endphp
                                        @if ($diagnosa->isEmpty())
                                            Diagnosa Tidak ada
                                        @else
                                            @foreach ($diagnosa as $dig)
                                                {{ $dig->diag_poli_gigi_umum_name }} : {{ $dig->diag_poli_gigi_umum_desc }}
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Diagnosa
                                            Odontograf</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        @php
                                            $odontograf = DB::table('diag_poli_gigi_odon')->where('d_reg_order_poli_code', $code)->get();
                                        @endphp
                                        @if ($odontograf->isEmpty())
                                            Odontograf Tidak di temukan
                                        @else
                                            @foreach ($odontograf as $odon)
                                                <strong>Gigi No . {{ $odon->diag_poli_gigi_odon_no }}</strong>
                                                <small>: {{ $odon->diag_poli_gigi_odon_val }}</small>
                                                <p>Keterangan : {{ $odon->diag_poli_gigi_odon_note }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span id="menu-verifikasi-pasien-poli">
        <button class="btn btn-primary float-end" id="button-verifikasi-pasien-poli" data-code="{{$code}}">Proses
            Verifikasi</button>
    </span>
</div>
