<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Proses Data Iuran Bulanan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <table id="data-peserta" class="table table-bordered" style="width:100%" border="1">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK / NIP</th>
                    <th>Biaya Pokok</th>
                    <th>Biaya Bunga</th>
                    <th>Total Pembayaran</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->kop_master_peserta_name }}</td>
                    <td>{{ $datas->kop_master_peserta_nik }} / {{ $datas->kop_master_peserta_nip }}</td>
                    <td class="text-end">@currency($datas->kop_tagihan_bulan_peserta_pokok)</td>
                    <td class="text-end">@currency($datas->kop_tagihan_bulan_peserta_bunga)</td>
                    <td class="text-end">@currency($datas->kop_tagihan_bulan_peserta_nominal)</td>
                    <td class="text-center">
                        @php
                        $status = DB::table('kop_log_tagihan_bulan')
                        ->join('kop_tagihan_bulan_peserta','kop_tagihan_bulan_peserta.kop_tagihan_bulan_peserta_code','=','kop_log_tagihan_bulan.kop_tagihan_bulan_peserta_code')
                        ->where('kop_master_peserta_code',$datas->kop_master_peserta_code)
                        ->where('kop_tagihan_bulan_code',$code)->first();
                        @endphp
                        @if ($status)
                        <span class="badge bg-primary">Sudah Lunas</span>
                        @else
                        <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-tagihan-bulan">
        <button class="btn btn-success float-end" id="button-payment-tagihan-bulan-peserta" data-code="{{ $code }}">
            Lakukan Pembayaran</button>
    </span>
</div>
<script>
    new DataTable('#data-peserta', {
        responsive: true
    });
</script>
