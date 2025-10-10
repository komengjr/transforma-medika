<div class="card mt-4 border">
    {{-- <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0" id="followers"><span class="badge bg-primary">{{ $data->m_poli_name }}</span></h3>
            </div>
            <div class="col">
                <form>
                    <div class="row g-0">
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" placeholder="Search...">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="card bg-light px-1 py-0">
        <div class="row g-0 text-center fs--1">
            @foreach ($dokter as $dokters)
                <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-1">
                    <div class="p-3 h-100"><a href="#"><img
                                class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm"
                                src="{{ asset($dokters->master_doctor_profile) }}" alt="" width="100"></a>
                        <h6 class="mb-0"><a
                                href="#" id="button-pilih-dokter-poliklinik" data-code="{{$dokters->m_doctor_poli_code}}">{{ $dokters->master_doctor_title_f . ' ' . $dokters->master_doctor_name . ' ' . $dokters->master_doctor_title_e }}</a>
                        </h6>
                        <p class="fs--2 mb-0"><a class="text-700" href="#!">Technext limited</a></p>
                        <span class="badge bg-primary">Aktif</span>
                    </div>
                </div>
            @endforeach
            {{-- <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-1">
                <div class="p-3 h-100"><a href="#"><img
                            class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm"
                            src="{{ asset('asset/img/team/2.jpg') }}" alt="" width="100"></a>
                    <h6 class="mb-0"><a href="#">dr. Kit Harington</a>
                    </h6>
                    <p class="fs--2 mb-0"><a class="text-700" href="#!">Harvard Korea Society</a></p>
                    <span class="badge bg-danger">Tidak Aktif</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-1">
                <div class="p-3 h-100"><a href="#"><img
                            class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm"
                            src="{{ asset('asset/img/team/5.jpg') }}" alt="" width="100"></a>
                    <h6 class="mb-0"><a href="#">dr. Abdul</a>
                    </h6>
                    <p class="fs--2 mb-0"><a class="text-700" href="#!">Harvard Korea Society</a></p>
                    <span class="badge bg-warning">Cuti</span>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<span id="menu-pilihan-dokter-poli"></span>
