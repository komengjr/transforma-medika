<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Data Peserta Koperasi</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-loading-peserta-koperasi">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK / NIP</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Cabang</th>
                    <th>Divisi / Jabatan</th>
                    <th>Status Peserta</th>
                    <th>Action</th>
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
                    <td>{{ $datas->kop_master_peserta_tempat_lahir }}, {{ $datas->kop_master_peserta_tgl_lahir }}</td>
                    <td>{{ $datas->kop_master_peserta_cabang }}</td>
                    <td>
                        @php
                        $divisi = DB::table('kop_master_peserta_job')
                        ->join('kop_master_div_bag', 'kop_master_div_bag.kop_master_div_bag_code', '=', 'kop_master_peserta_job.kop_master_div_bag_code')
                        ->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')
                        ->where('kop_master_peserta_code',$datas->kop_master_peserta_code)->first();
                        @endphp
                        @if ($divisi)
                        {{ $divisi->kop_master_divisi_name }} - {{ $divisi->kop_master_div_bag_name }}
                        @endif
                    </td>
                    <td>
                        @php
                        $anggota = DB::table('kop_peserta_sim_pok')->where('kop_master_peserta_code',$datas->kop_master_peserta_code)->first();
                        @endphp
                        @if ($anggota)
                        <span class="badge bg-primary">Aktif</span>
                        @else
                        <span class="badge bg-danger">Belum Aktif</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" id="button-pilih-peserta-arisan" data-code="{{ $datas->kop_master_peserta_code }}" data-id="{{ $code }}">Pilih</button>
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
    new DataTable('#example', {
        responsive: true
    });
</script>
