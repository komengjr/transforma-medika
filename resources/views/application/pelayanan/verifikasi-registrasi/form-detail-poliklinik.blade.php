@if (!$diagnosa->isEmpty())
    Pemeriksaan Umum
    <ul>
        @foreach ($diagnosa as $diag)
            <li>
                <code>{{$diag->diag_poli_fisik_umum_name}}</code> - {{$diag->diag_poli_fisik_umum_d_val}}
                <code> {{$diag->diag_poli_fisik_satuan}}</code>
            </li>
        @endforeach
    </ul>
@endif
@if (!$odontogram->isEmpty())
    Pemeriksaan odontogram
    <ul>
        @foreach ($odontogram as $odon)
            <li>
                <code>{{$odon->diag_poli_gigi_odon_no}}</code> - {{$odon->diag_poli_gigi_odon_val}}
                <code> {{$odon->diag_poli_gigi_odon_note}}</code>
            </li>
        @endforeach
    </ul>
@endif
