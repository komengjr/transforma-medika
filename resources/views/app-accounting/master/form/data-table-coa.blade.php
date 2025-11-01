<table class="table table-bordered fs--2" id="data-account">
    <thead class="bg-200">
        <tr>
            <th>No</th>
            <th>Master Account</th>
            <th>Sub Account</th>
            <th>Nomor Account</th>
            <th>Nama Account</th>
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
                <td>{{ $datas->acc_master_coa_code }}</td>
                <td>{{ $datas->acc_coa_data_code }}</td>
                <td>{{ $datas->acc_coa_data_no }}</td>
                <td>{{ $datas->acc_coa_data_name }}</td>
                <td class="text-center">
                    @if ($datas->acc_coa_data_opt == 0)
                        <span class="badge bg-warning">Single</span>
                    @else
                        <span class="badge bg-primary">Multi</span>
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
<script>
    new DataTable('#data-account', {
        responsive: true,
        ordering: false,
        "lengthMenu": [[5, 50, 25], [5, 50, 25]]
    });
</script>
