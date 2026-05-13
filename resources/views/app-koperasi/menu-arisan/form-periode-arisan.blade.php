<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Periode Arisan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-periode-arisan">
        <table id="data_periode" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Periode Tanggal Arisan</th>
                    <th class="text-end">Nominal Pokok</th>
                    <th class="text-end">Nominal Keuntungan</th>
                    <th class="text-end">Nominal Total</th>
                    <th>Peserta Terpilih</th>
                    <th>Status Periode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->kop_arisan_tagihan_date }}</td>
                    <td class="text-end">@currency($datas->kop_arisan_tagihan_pokok)</td>
                    <td class="text-end">@currency($datas->kop_arisan_tagihan_bunga)</td>
                    <td class="text-end">@currency($datas->kop_arisan_tagihan_nominal)</td>
                    <td>
                        @php
                            $peserta = DB::table('kop_arisan_tagihan_peserta')
                            ->join('kop_arisan_group_user', 'kop_arisan_group_user.kop_arisan_group_user_code', '=', 'kop_arisan_tagihan_peserta.kop_arisan_group_user_code')
                            ->join('kop_master_peserta','kop_master_peserta.kop_master_peserta_code','=','kop_arisan_group_user.kop_master_peserta_code')
                            ->where('kop_arisan_tagihan_peserta.kop_arisan_tagihan_code',$datas->kop_arisan_tagihan_code)->get();
                        @endphp
                        @foreach ($peserta as $pes)
                            <li>{{ $pes->kop_master_peserta_name }} <br> @currency($pes->kop_tagihan_peserta_nominal)</li>
                        @endforeach
                    </td>
                    <td>
                        @if ($datas->kop_arisan_tagihan_status == '0')
                        <span class="badge bg-danger">Token Belum dibuat</span>
                        @elseif ($datas->kop_arisan_tagihan_status == '1')
                        <span class="badge bg-dark">Periode dijalankan</span>
                        @elseif ($datas->kop_arisan_tagihan_status == '2')
                        <span class="badge bg-primary">Periode Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                @if ($datas->kop_arisan_tagihan_status < '1' )
                                    <button class="dropdown-item text-dark" id="button-proses-pembuatan-token-arisan"
                                    data-code="{{ $datas->kop_arisan_tagihan_code }}" data-id="{{ $datas->kop_arisan_group_code }}"><span
                                        class="fab fa-keycdn"></span>
                                    Proses Pembuatan Token</button>
                                    @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new DataTable('#data_periode', {
        responsive: true
    });
</script>
