<div class="card-header bg-300 btn-reveal-trigger d-flex flex-between-center">
    <h5 class="mb-0">Order</h5>
    <a class="btn btn-falcon-warning btn-sm btn-reveal" href="#" id="button-proses-payment"><span
            class="fab fa-product-huntt"></span> Payment
    </a>
</div>
<div class="card-body pb-0">
    <div class="row g-3">
        <div class="col-md-2 d-flex justify-content-center">
            <div class="avatar avatar-5lg shadow-sm justify-content-center">
                <div class="h-100 w-100 overflow-hidden">
                    @if ($pasien->master_patient_profile == "")
                        <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                            data-dz-thumbnail="data-dz-thumbnail">
                    @else
                        <img src="{{ Storage::url($pasien->master_patient_profile) }}" class="img-thumbnail " alt=""
                            id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                        <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                            value="{{ $pasien->master_patient_name }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                        <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                            id="nik" value="{{ $pasien->master_patient_nik }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="inputLastName1" class="form-label text-youtube">No Rekam
                        Medis</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                        <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                            id="nik" value="{{ $pasien->master_patient_code }}" disabled>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<hr>
<div class="card-body">
    @php
        $total = 0;
    @endphp
    @foreach ($data as $datas)
        <h6>{{ $datas->t_layanan_cat_name }}</h6>
        @if ($datas->t_layanan_cat_name == 'POLIKLINIK')

            <!-- RADIOLOGI -->
        @elseif ($datas->t_layanan_cat_name == 'RADIOLOGI')
            @php
                $harga = DB::table('d_reg_order_rad_list')
                    ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
                    ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                    ->where('d_reg_order_rad_list.d_reg_order_rad_code', $datas->d_reg_order_list_code)->get();
            @endphp
            <table class="table table-borderless fs--1 mb-0 border">
                @foreach ($harga as $hargas)
                    <tr class="border-bottom">
                        <th class="align-middle py-2" style="width: 10px;">
                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" id="customer-0"
                                    data-bulk-select-row="data-bulk-select-row" />
                            </div>
                        </th>
                        <th class="ps-0 text-black">{{$hargas->t_pemeriksaan_list_name}}
                            <div class="text-400 fw-normal fs--2">Normal Price : @currency($hargas->order_rad_log_price) Disc.
                                {{$hargas->order_rad_log_discount}} %</div>
                        </th>
                        <th class="fs-1 text-end">
                            @currency($hargas->order_rad_log_price - ($hargas->order_rad_log_discount * $hargas->order_rad_log_price / 100))
                        </th>
                    </tr>
                    @php
                        $total = $total + $hargas->order_rad_log_price - ($hargas->order_rad_log_discount * $hargas->order_rad_log_price / 100);
                    @endphp
                @endforeach
            </table>

            <!-- LABORATORIUM -->
        @elseif ($datas->t_layanan_cat_name == 'LABORATORIUM')
            @php
                $harga = DB::table('d_reg_order_lab_list')
                    ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
                    ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                    ->where('d_reg_order_lab_list.d_reg_order_lab_code', $datas->d_reg_order_list_code)->get();
            @endphp
            <table class="table table-borderless fs--1 mb-0 border">
                @foreach ($harga as $hargas)
                    <tr class="border-bottom">
                        <th class="align-middle py-2" style="width: 10px;">
                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" id="customer-0"
                                    data-bulk-select-row="data-bulk-select-row" />
                            </div>
                        </th>
                        <th class="ps-0 text-black">{{$hargas->t_pemeriksaan_list_name}}
                            <div class="text-400 fw-normal fs--2">Normal Price : @currency($hargas->order_lab_log_price) Disc.
                                {{$hargas->order_lab_log_discount}} %</div>
                        </th>
                        <th class="fs-1 text-end">
                            @currency($hargas->order_lab_log_price - ($hargas->order_lab_log_discount * $hargas->order_lab_log_price / 100))
                        </th>
                    </tr>
                    @php
                        $total = $total + $hargas->order_lab_log_price - ($hargas->order_lab_log_discount * $hargas->order_lab_log_price / 100);
                    @endphp
                @endforeach
            </table>
        @elseif ($datas->t_layanan_cat_name == 'FARMASI')
        @elseif ($datas->t_layanan_cat_name == 'IGD')

        @endif


    @endforeach
</div>
<div class="card-footer d-flex justify-content-between bg-light">
    <div class="fw-semi-bold">Payable Total</div>
    <div class="fw-bold fs-1 text-black">@currency($total)</div>
    <input type="text" name="total_pembayaran" id="total_pembayaran" value="{{$total}}" hidden>
    <input type="text" name="no_reg" id="no_reg" value="{{$code}}" hidden>
</div>
