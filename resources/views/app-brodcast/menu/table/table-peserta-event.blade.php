<table id="data_peserta" class="table table-striped" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>No Handphone</th>
            <th>Email</th>
            <th>Lembaga</th>
            <th>Kode Booking</th>
            <th>Status WA</th>
            <th>Status Email</th>
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
                <td>
                    @php
                        $status = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $datas->b_event_peserta_code)->first();
                    @endphp
                    @if ($status)
                        @if ($status->v_log_whatsapp_status == 0)
                            <span class="badge bg-warning">Prosess</span>
                        @else
                            <span class="badge bg-primary">Terkirim</span>
                        @endif
                    @else
                        <span class="badge bg-danger">Belum dikirim</span>
                    @endif
                </td>
                <td></td>
                <td>Soon</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#data_peserta', {
        responsive: true
    });
</script>
