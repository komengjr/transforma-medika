<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <table id="data-v3" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>NIP</th>
                    <th>Departemen</th>
                    <th>Paket</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                    $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pesertas->mou_peserta_name }}</td>
                        <td>{{ $pesertas->mou_peserta_nik }}</td>
                        <td>{{ $pesertas->mou_peserta_ttl }}</td>
                        <td>
                            @if ($pesertas->mou_peserta_jk == 'L')
                                Laki - Laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td>{{ $pesertas->mou_peserta_email }}</td>
                        <td>{{ $pesertas->mou_peserta_no_hp }}</td>
                        <td>{{ $pesertas->mou_peserta_nip }}</td>
                        <td>{{ $pesertas->mou_peserta_departemen }}</td>
                        <td>
                            @php
                                $paket = DB::table('company_mou_agreement')
                                    ->where('mou_agreement_code', $pesertas->mou_agreement_code)
                                    ->first();
                            @endphp
                            @if ($paket)
                                {{ $paket->mou_agreement_name }}
                            @else
                            <span class="badge bg-danger">Belum Memilih Paket</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-v3', {
        responsive: true
    });
</script>
