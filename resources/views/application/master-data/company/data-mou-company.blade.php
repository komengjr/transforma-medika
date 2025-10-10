<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data MOU Perusahaan</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="card-body border-top p-3">
        <table id="mou-table" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--3">
                <tr>
                    <th>No</th>
                    <th>MOU Persuahaan</th>
                    <th>Nama Perusahaan</th>
                    <th>Jumlah Peserta</th>
                    <th>Tanggal</th>
                    <th>Agreement</th>
                    <th>Status MOU</th>
                </tr>
            </thead>
            <tbody class="fs--3">
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->company_mou_name }}</td>
                        <td>{{ $datas->master_company_name }}</td>
                        <td>
                            @php
                                $total = DB::table('company_mou_peserta')
                                    ->where('company_mou_code', $datas->company_mou_code)
                                    ->count();
                            @endphp
                            {{ $total }}
                        </td>
                        <td>{{ $datas->company_mou_start }} <br>{{ $datas->company_mou_end }}</td>
                        <td>
                            @php
                                $agreement = DB::table('company_mou_agreement')
                                    ->where('company_mou_code', $datas->company_mou_code)
                                    ->get();
                            @endphp
                            @foreach ($agreement as $item)
                                <li>{{ $item->mou_agreement_name }}</li>
                            @endforeach
                        </td>
                        <td>
                            @if ($datas->company_mou_status == 0)
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @else
                                <span class="badge bg-primary">Aktif</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#mou-table', {
        responsive: true
    });
</script>
