<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Proses Data Pengajuan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a>
        </p>
    </div>
    <div class="p-4 pb-4" id="menu-add-data-pr-all">
        <div class="card mb-3">
            <div class="card-header bg-300">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="horizontal-form-label-sizing">Data Pengajuan Peminjaman Barang<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#horizontal-form-label-sizing" style="padding-left: 0.375em;"></a></h5>
                        <p class="mb-0 mt-2 mb-0">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet doloribus minima fugit ullam asperiores laudantium ad dicta accusantium eius, perferendis repellat nulla commodi. Laudantium odio assumenda voluptas fugit eos! Nihil.</p>
                    </div>
                    <div class="col-auto ms-auto">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-500">Report to</h6>
                        <h5>{{ $data->kop_master_peserta_name }}</h5>
                        <p class="fs--1">{{ $data->kop_master_peserta_nik }}<br>{{ $data->kop_master_peserta_tgl_lahir }}<br>{{ $data->kop_master_peserta_tempat_lahir }}</p>
                        <p class="fs--1"><a href="mailto:example@gmail.com">{{ $data->kop_master_peserta_email }}</a><br><a href="tel:444466667777">{{ $data->kop_master_peserta_no_hp }}</a></p>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <tr>
                                        <th class="">No Pengajuan</th>
                                        <td>: 14</td>
                                    </tr>
                                    <tr>
                                        <th class="">Nominal Pengajuan</th>
                                        <td>: @currency($data->kop_proses_brg_nominal)</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tanggal Pengajuan </th>
                                        <td>: {{ $data->kop_proses_brg_tgl }}</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tenor :</th>
                                        <td>: {{ $data->kop_proses_brg_tenor }} Bulan</td>
                                    </tr>
                                    <tr class="alert-success fw-bold">
                                        <th class="">Suku Bunga </th>
                                        <td>: {{ $data->kop_proses_brg_bunga }} %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive scrollbar mt-4 fs--1">
                    <table class="table table-striped border-bottom">
                        <thead class="light">
                            <tr class="bg-primary text-white dark__bg-1000">
                                <th class="border-0">Bulan</th>
                                <th class="border-0 text-center">Tenor Ke</th>
                                <th class="border-0 text-center">Suku Bunga {{ $data->kop_proses_brg_bunga }} %</th>
                                <th class="border-0 text-end">Angsuran Pokok</th>
                                <th class="border-0 text-end">Total Angsuran Bulanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0 ;
                            $pokok = $data->kop_proses_brg_nominal/$data->kop_proses_brg_tenor ;
                            $suku_bunga = ($data->kop_proses_brg_nominal * ($data->kop_proses_brg_bunga / 100) )/$data->kop_proses_brg_tenor;
                            $admin = ($data->kop_proses_brg_admin / 100) * $data->kop_proses_brg_nominal;
                            @endphp
                            @for ($i = 1 ; $i <= $data->kop_proses_brg_tenor ; $i++)
                                <tr>
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">{{ date('d - M - Y', strtotime('+' . $i .' month', strtotime($data->kop_proses_brg_tgl))) }}</h6>
                                    </td>
                                    <td class="align-middle text-center">{{ $i }}</td>
                                    <td class="align-middle text-center">@currency($suku_bunga)</td>
                                    <td class="align-middle text-end">@currency($pokok)</td>
                                    <td class="align-middle text-end">@currency($pokok + $suku_bunga)</td>
                                </tr>
                                @php
                                $total = $total + ( $pokok + $suku_bunga );
                                @endphp
                                @endfor
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <table class="table table-sm table-borderless fs--1 text-end">
                            <tbody>
                                <tr>
                                    <th class="text-900">Subtotal :</th>
                                    <td class="fw-semi-bold">@currency($total)</td>
                                </tr>
                                <tr class="border-top">
                                    <th class="text-900">Biaya Admin :</th>
                                    <td class="fw-semi-bold">@currency($admin)</td>
                                </tr>
                                <tr class="border-top border-top-2 fw-bolder text-900">
                                    <th>Total :</th>
                                    <td>@currency($total + $admin)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-300">
                <div class="row flex-between-center">
                    <div class="col-sm-auto">
                        <h5 class="mb-2 mb-sm-0">User Mengetahui </h5>
                    </div>
                    <div class="col-sm-auto" id="loading-button-kirim">
                        <a class="btn btn-falcon-primary btn-sm" href="#!" id="button-kirim-verifikasi-pengajuan" data-code="{{ $data->kop_proses_brg_code }}">
                            <span class="fab fa-whatsapp"></span> Kirim Verifikasi
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        @php
                        $kacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code',$data->kop_proses_brg_kacab)->first();
                        @endphp
                        <div class="form-check mb-0 custom-radio">
                            <!-- <input class="form-check-input" id="address-1" type="radio" name="clientName" checked="checked"> -->
                            <label class="form-check-label mb-0 fw-bold d-block" for="address-1">
                                Kepala Cabang
                                <span class="radio-select-content">
                                    <span> {{ $kacab->kop_user_verifikasi_name }},<br>
                                        {{ $kacab->kop_user_verifikasi_email }}<br>
                                        {{ $kacab->kop_user_verifikasi_whatsapp }}
                                        <span class="d-block mb-0 pt-2">
                                            @php
                                            $kcb = DB::table('kop_proses_verif_brg')
                                            ->where('kop_proses_brg_code',$data->kop_proses_brg_code)
                                            ->where('kop_proses_verif_brg_user',$data->kop_proses_brg_kacab)->first();
                                            @endphp
                                            @if ($kcb)
                                            @if ($kcb->kop_proses_verif_brg_status == '0')
                                            <span class="badge bg-warning">Menunggu di verifikasi</span>
                                            @elseif ($kcb->kop_proses_verif_brg_status == '1')
                                            <span class="badge bg-primary">Sudah di verifikasi</span>
                                            @else
                                            <span class="badge bg-danger">Belum di verifikasi</span>
                                            @endif
                                            @else
                                            <span class="badge bg-danger">Belum di verifikasi</span>
                                            @endif

                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @php
                        $kacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code',$data->kop_proses_brg_ketua)->first();
                        @endphp
                        <div class="position-relative">
                            <div class="form-check mb-0 custom-radio">
                                <!-- <input class="form-check-input" id="address-2" type="radio" name="clientName"> -->
                                <label class="form-check-label mb-0 fw-bold d-block" for="address-1">
                                    Ketua Koperasi
                                    <span class="radio-select-content">
                                        <span> {{ $kacab->kop_user_verifikasi_name }},<br>
                                            {{ $kacab->kop_user_verifikasi_email }}<br>
                                            {{ $kacab->kop_user_verifikasi_whatsapp }}
                                            <span class="d-block mb-0 pt-2">
                                                @php
                                                $ketua = DB::table('kop_proses_verif_brg')
                                                ->where('kop_proses_brg_code',$data->kop_proses_brg_code)
                                                ->where('kop_proses_verif_brg_user',$data->kop_proses_brg_ketua)->first();
                                                @endphp
                                                @if ($ketua)
                                                @if ($ketua->kop_proses_verif_brg_status == '0')
                                                <span class="badge bg-warning">Menunggu di verifikasi</span>
                                                @elseif ($ketua->kop_proses_verif_brg_status == '1')
                                                <span class="badge bg-primary">Sudah di verifikasi</span>
                                                @else
                                                <span class="badge bg-danger">Belum di verifikasi</span>
                                                @endif
                                                @else
                                                <span class="badge bg-danger">Belum di verifikasi</span>
                                                @endif

                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-300">
                <div class="row flex-between-center">
                    <div class="col-sm-auto">
                        <h5 class="mb-2 mb-sm-0">Pilih Akun Pencairan</h5>
                    </div>
                    <div class="col-sm-auto" id="loading-button-kirim">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label for="">Pilih Akun Pencairan</label>
                        <select class="form-select form-control-lg" name="akun_pencairan" id="akun_pencairan">
                            <option value="">Pilih Akun</option>
                            @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-simpan-data-verifikasi" data-code="{{ $data->kop_proses_brg_code }}">Pencairan Dana Pinjaman</button>
    </span>
</div>
