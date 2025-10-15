<style>
    #button-pilih-data-pasien:hover {
        color: rgb(222, 218, 12);
        cursor: pointer;
    }
</style>
<div class="px-2">
    <table id="data-pasien" class="table table-striped" style="width:100%">
        <thead class="bg-info text-dark fs--2">
            <tr>
                <th>Gambar</th>
                <th>No Rekam Medik</th>
                <th>Nama Pasien</th>
                <th>NIK </th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>No Handphone</th>
            </tr>
        </thead>
        <tbody class="fs--2 list">
            @php
                $no = 1;
            @endphp
            @foreach ($data as $datas)
                <tr>
                    <td>
                        @if ($datas->master_patient_profile == "")
                            <img class="h-60 w-60 overflow-hidden img-thumbnail shadow-sm" src="{{ asset('img/pp.png') }}"
                                width="100" alt="">
                        @else
                            <img class="h-60 w-60 overflow-hidden img-thumbnail shadow-sm"
                                src="{{ Storage::url($datas->master_patient_profile) }}" width="100" alt="">
                        @endif

                    </td>
                    <td><strong id="button-pilih-data-pasien"
                            data-code="{{ $datas->master_patient_code }}">{{ $datas->master_patient_code }}</strong></td>
                    <td>{{ $datas->master_patient_name }}</td>
                    <td>{{ $datas->master_patient_nik }}</td>
                    <td>
                        @if ($datas->master_patient_jk == 'l')
                            Laki - Laki
                        @else
                            Perempuan
                        @endif
                    </td>
                    <td>{{ $datas->master_patient_tempat_lahir }}</td>
                    <td>{{ $datas->master_patient_tgl_lahir }}</td>
                    <td>{{ $datas->master_patient_no_hp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    new DataTable('#data-pasien', {
        responsive: true
    });
</script>
