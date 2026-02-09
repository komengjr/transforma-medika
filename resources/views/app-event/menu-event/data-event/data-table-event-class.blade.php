<table class="table table-bordered mt-0 bg-white dark__bg-1100">
    <thead>
        <tr class="fs--1 bg-300">
            <th>Event Class Name</th>
            <th>Room</th>
            <th>Price</th>
            <th>Kuota</th>
            <th>-</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $datas)
        <tr>
            <td>
                {{$datas->event_data_sub_class_name}}
            </td>
            <td>
                {{$datas->event_data_sub_class_room}}
            </td>
            <td class="text-center align-middle">
                {{$datas->event_data_sub_class_price}}
            </td>
            <td class="text-center align-middle">
                {{$datas->event_data_sub_class_kuota}}
            </td>
            <td class="text-center">
                <span class="fas fa-trash text-danger"></span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
