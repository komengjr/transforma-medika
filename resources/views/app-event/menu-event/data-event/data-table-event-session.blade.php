<table class="table table-bordered mt-0 bg-white dark__bg-1100">
    <thead>
        <tr class="fs--1 bg-300">
            <th>Sesion Name</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $datas)
        <tr>
            <td>{{ $datas->event_data_sub_session_name }}</td>
            <td class="text-center"><span class="fas fa-trash text-danger"></span></td>
        </tr>
    @endforeach
    </tbody>
</table>
