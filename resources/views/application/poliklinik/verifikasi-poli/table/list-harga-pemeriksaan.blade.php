<table class="table table-borderless fs--1 mb-0">
    <tbody>
        @php
            $harga = 0;
        @endphp
        @foreach ($list as $lists)
            <tr class="border-bottom">
                <th class="ps-0 pt-0">{{$lists->t_pemeriksaan_list_name}}
                    <div class="text-400 fw-normal fs--2">{{$lists->order_poli_log_code}}</div>
                </th>
                <th class="pe-0 text-end pt-0">@currency($lists->order_poli_log_price)</th>
            </tr>
            @php
                $harga = $harga + $lists->order_poli_log_price;
            @endphp
        @endforeach

        <tr>
            <th class="ps-0 pb-0">Total</th>
            <th class="pe-0 text-end pb-0">@currency($harga)</th>
        </tr>
    </tbody>
</table>
