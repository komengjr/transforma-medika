@php
    $total = 0;
    $rand = mt_rand(1000, 9999);
    $no = 1;
@endphp
@foreach ($data as $datas)
    <tr>
        <td>{{$no++}}</td>
        <td>{{ $datas->farm_data_obat_name}}</td>
        <td>@currency($datas->farm_list_log_harga)</td>
        <td>{{ $datas->farm_list_log_qty }}</td>
        <td>@currency($datas->farm_list_log_harga * $datas->farm_list_log_qty)</th>
        <td><button class="btn btn-danger btn-sm" id="button-remove-list-obat" data-code="{{ $datas->farm_list_log_code }}"><i class="fas fa-trash"></i></button></td>
    </tr>
    @php
        $total = $total + ($datas->farm_list_log_harga * $datas->farm_list_log_qty);
    @endphp
@endforeach

<script>
    const totalHarga<?php echo $rand ?> = document.getElementById("totalHarga");
    totalHarga<?php echo $rand ?>.innerText = `@currency($total)`;
</script>
