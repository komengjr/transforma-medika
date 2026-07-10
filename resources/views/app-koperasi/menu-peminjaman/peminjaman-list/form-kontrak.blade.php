<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Kontrak - {{ $data->kop_master_peserta_name }}</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a>
        </p>
    </div>
    <div class="p-4 pb-4" id="menu-data-show-peminjaman-baru">
        <div class="card mb-2" id="menu-status-kontrak">
            <div class="card-header bg-300">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="horizontal-form-label-sizing">Data Pengajuan Peminjaman Uang<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#horizontal-form-label-sizing" style="padding-left: 0.375em;"></a></h5>
                        <p class="mb-0 mt-2 mb-0">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem minima non quis fugiat natus quo officia nam maiores! Minima mollitia id cumque repellat modi consequatur quasi quas hic est sed?</p>
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
                                        <td>: @currency($data->kop_proses_uang_nominal)</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tanggal Pengajuan </th>
                                        <td>: {{ $data->kop_proses_uang_tgl }}</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tenor :</th>
                                        <td>: {{ $data->kop_proses_uang_tenor }} Bulan</td>
                                    </tr>
                                    <tr class="alert-success fw-bold">
                                        <th class="">Suku Bunga </th>
                                        <td>: {{ $data->kop_proses_uang_bunga }} %</td>
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
                                <th class="border-0 text-center">Suku Bunga {{ $data->kop_proses_uang_bunga }} %</th>
                                <th class="border-0 text-end">Angsuran Pokok</th>
                                <th class="border-0 text-end">Total Angsuran Bulanan</th>
                                <th class="border-0 text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0 ;
                            $paid = 0;
                            $pokok = $data->kop_proses_uang_nominal/$data->kop_proses_uang_tenor ;
                            $suku_bunga = ($data->kop_proses_uang_nominal * ($data->kop_proses_uang_bunga / 100))/$data->kop_proses_uang_tenor;
                            $admin = ($data->kop_proses_uang_admin / 100) * $data->kop_proses_uang_nominal;
                            @endphp
                            @for ($i = 1 ; $i <= $data->kop_proses_uang_tenor ; $i++)
                                <tr>
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">{{ date('d - M - Y', strtotime('+' . $i .' month', strtotime($data->kop_proses_uang_tgl))) }}</h6>
                                    </td>
                                    <td class="align-middle text-center">{{ $i }}</td>
                                    <td class="align-middle text-center">@currency($suku_bunga)</td>
                                    <td class="align-middle text-end">@currency($pokok)</td>
                                    <td class="align-middle text-end">@currency($pokok + $suku_bunga)</td>
                                    <td class="align-middle text-end">
                                        @php
                                        $cek = DB::table('kop_log_peminjaman_uang')
                                        ->where('kop_proses_uang_code', $data->kop_proses_uang_code)
                                        ->where('kop_log_peminjaman_uang_tenor', $i)
                                        ->first();
                                        @endphp
                                        @if ($cek)
                                        @if ($cek->kop_log_peminjaman_uang_status == '0')

                                        @if ($cek->kop_log_peminjaman_uang_date <= date('Y-m-d') )
                                            <button class="btn btn-info btn-sm" id="button-proses-pembayaran-bulanan" data-code="{{ $cek->kop_log_peminjaman_uang_code }}">Proses</button>
                                            @else
                                            <button class="btn btn-dark btn-sm" disabled>Menunggu</button>
                                            @endif

                                            @else
                                            <span class="badge bg-primary">Sudah Bayar</span>
                                            @php
                                            $paid = $paid + $cek->kop_log_peminjaman_uang_nominal;
                                            @endphp

                                            @endif
                                            @else
                                            <span class="badge bg-danger">Unvalid</span>
                                            @endif
                                    </td>
                                </tr>
                                @php
                                $total = $total + ( $pokok + $suku_bunga );
                                @endphp
                                @endfor
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-900" colspan="4">Subtotal :</td>
                                <td class="fw-semi-bold align-middle text-end ">@currency($total)</td>
                                <td class="fw-semi-bold align-middle text-end text-success">@currency($paid)</td>
                            </tr>
                            <tr class="border-top">
                                <td class="text-900" colspan="4">Biaya Admin :</td>
                                <td class="align-middle text-end">@currency($admin)</td>
                                <td class="fw-semi-bold align-middle text-end">@currency(0)</td>
                            </tr>
                            <tr class="border-top border-top-2 fw-bolder text-900">
                                <td class="text-900" colspan="4">Total :</td>
                                <td class="align-middle text-end">@currency($total + $admin)</td>
                                <td class="fw-semi-bold align-middle text-end text-danger">@currency($paid + $admin)</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    @if ($total + $admin == $paid + $admin)
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-penyelesaian-data-kontrak" data-code="{{ $data->kop_proses_uang_code }}">Penyelesaian Data</button>
    </span>
    @else
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-create-data-kontrak-baru" data-code="{{ $data->kop_proses_uang_code }}">Membuat Kontrak Baru</button>
    </span>
    @endif
</div>
