<table id="data_peserta" class="table table-striped" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>No Handphone</th>
            <th>Email</th>
            <th>Lembaga</th>
            <th>Kode Booking</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $datas->b_event_peserta_name }}</td>
                <td>{{ $datas->b_event_peserta_hp }}</td>
                <td>{{ $datas->b_event_peserta_email }}</td>
                <td>{{ $datas->b_event_peserta_lembaga }}</td>
                <td>{{ $datas->b_event_peserta_booking }}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#data_peserta', {
        responsive: true
    });
</script>
