<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Account Koperasi</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">

        <div id="data-table-accoaunt-coa">
            <table class="table table-bordered fs--2" id="data-account">
                <thead class="bg-200">
                    <tr>
                        <th>No</th>
                        <th>No Account</th>
                        <th>Nama Account</th>
                        <th>Type Account</th>
                        <th>Nominal Account</th>
                        <th>Type Account</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->coa_code }}</td>
                        <td>{{ $datas->coa_name }}</td>
                        <td>{{ $datas->coa_type }}</td>
                        <td>{{ $datas->normal_balance }}</td>
                        <td class="text-center">
                            @if ($datas->is_active == 0)
                            <span class="badge bg-warning">Not Active</span>
                            @else
                            <span class="badge bg-primary">Active</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <button class="btn btn-primary btn-sm" id="button-proses-sinkrosnisasi-data-coa">Proses Sinkronisasi</button>
</div>
<script>
    new DataTable('#data-account', {
        responsive: true,
        ordering: false,
        "lengthMenu": [
            [10, 50, 25],
            [10, 50, 25]
        ]
    });
</script>
