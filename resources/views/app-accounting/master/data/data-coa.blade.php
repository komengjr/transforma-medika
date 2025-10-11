<ul class="treeview treeview-stripe" id="treeviewStriped" data-options='{"striped":true}'>
                <!-- TINGKAT MASTER  -->
    @foreach ($data as $datas)
        <li class="treeview-list-item">
            <a data-bs-toggle="collapse" href="#treeviewStriped-1-{{$datas->id_acc_master_coa}}" role="button"
                aria-expanded="false">
                <p class="treeview-text">
                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}. </span> {{$datas->acc_master_coa_name}}
                </p>
            </a>
            <ul class="collapse treeview-list" id="treeviewStriped-1-{{$datas->id_acc_master_coa}}"
                data-show="true">
                @php
                    $sub = DB::table('acc_master_coa_data')
                        ->where('acc_master_coa_code', $datas->acc_master_coa_code)
                        ->where('acc_coa_data_level', 1)
                        ->get();
                    $no = 1;
                @endphp
                <!-- TINGKAT 1 START -->
                @foreach ($sub as $subs)
                    @if ($subs->acc_coa_data_opt == 1)
                        <li class="treeview-list-item">
                            <a data-bs-toggle="collapse" href="#treeviewStriped-2-{{$subs->id_acc_master_coa_data}}" oncontextmenu="myFunction('{{$subs->acc_coa_data_code}}'); return false;"
                                role="button" aria-expanded="false">
                                <p class="treeview-text">
                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no++ }}</span> {{$subs->acc_coa_data_name}}
                                </p>
                            </a>
                            <ul class="collapse treeview-list" id="treeviewStriped-2-{{$subs->id_acc_master_coa_data}}"
                                data-show="true">
                                @php
                                    $sub1 = DB::table('acc_master_coa_data')
                                        ->where('acc_master_coa_code', $subs->acc_coa_data_code)
                                        ->where('acc_coa_data_level', 2)
                                        ->get();
                                    $no1 = 1;
                                @endphp
                                <!-- TINGKAT 2 -->
                                @foreach ($sub1 as $subs1)
                                    @if ($subs1->acc_coa_data_opt == 1)
                                        <div class="treeview-row treeview-row-even"></div>
                                        <li class="treeview-list-item">
                                            <a data-bs-toggle="collapse" href="#treeviewStriped-2-{{$subs1->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs1->acc_coa_data_code}}'); return false;"
                                                aria-expanded="false">
                                                <p class="treeview-text">
                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1++ }}</span> {{$subs1->acc_coa_data_name}}
                                                </p>
                                            </a>
                                            <ul class="collapse treeview-list" id="treeviewStriped-2-{{$subs1->id_acc_master_coa_data}}" data-show="true">
                                                @php
                                                    $sub2 = DB::table('acc_master_coa_data')
                                                        ->where('acc_master_coa_code', $subs1->acc_coa_data_code)
                                                        ->where('acc_coa_data_level', 3)
                                                        ->get();
                                                    $no2 = 1;
                                                @endphp
                                                <!-- TINGKAT 3 -->
                                                @foreach ($sub2 as $subs2)
                                                    @if ($subs2->acc_coa_data_opt == 1)
                                                        <li class="treeview-list-item">
                                                            <a data-bs-toggle="collapse" href="#treeviewStriped-3-{{$subs2->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs2->acc_coa_data_code}}'); return false;"
                                                                aria-expanded="false">
                                                                <p class="treeview-text">
                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span> {{$subs2->acc_coa_data_name}}
                                                                </p>
                                                            </a>
                                                            <ul class="collapse treeview-list" id="treeviewStriped-3-{{$subs2->id_acc_master_coa_data}}" data-show="true">
                                                                @php
                                                                    $sub3 = DB::table('acc_master_coa_data')
                                                                        ->where('acc_master_coa_code', $subs2->acc_coa_data_code)
                                                                        ->where('acc_coa_data_level', 4)
                                                                        ->get();
                                                                    $no3 = 1;
                                                                @endphp
                                                                <!-- TINGKAT 4 -->
                                                                @foreach ($sub3 as $subs3)
                                                                    @if ($subs3->acc_coa_data_opt == 1)
                                                                        <li class="treeview-list-item">
                                                                            <a data-bs-toggle="collapse" href="#treeviewStriped-3-{{$subs3->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs3->acc_coa_data_code}}'); return false;"
                                                                                aria-expanded="false">
                                                                                <p class="treeview-text">
                                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span> {{$subs3->acc_coa_data_name}}
                                                                                </p>
                                                                            </a>
                                                                            <ul class="collapse treeview-list" id="treeviewStriped-3-{{$subs3->id_acc_master_coa_data}}" data-show="true">
                                                                                @php
                                                                                    $sub4 = DB::table('acc_master_coa_data')
                                                                                        ->where('acc_master_coa_code', $subs3->acc_coa_data_code)
                                                                                        ->where('acc_coa_data_level', 5)
                                                                                        ->get();
                                                                                    $no4 = 1;
                                                                                @endphp
                                                                                <!-- TINGKAT 5 -->
                                                                                @foreach ($sub4 as $subs4)
                                                                                    @if ($subs4->acc_coa_data_opt == 1)
                                                                                        <li class="treeview-list-item">
                                                                                            <div class="treeview-item">
                                                                                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs4->acc_coa_data_code}}'); return false;">
                                                                                                    <p class="treeview-text">
                                                                                                        <span class="me-2 fas fa-universal-access text-primary"></span>
                                                                                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4++ }}</span> {{$subs4->acc_coa_data_name}}
                                                                                                    </p>
                                                                                                </a>
                                                                                                <div class="dot bg-info"></div>
                                                                                            </div>
                                                                                        </li>
                                                                                    @else ($subs4->acc_coa_data_opt == 0)
                                                                                        <li class="treeview-list-item">
                                                                                            <div class="treeview-item">
                                                                                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs4->acc_coa_data_code}}'); return false;">
                                                                                                    <p class="treeview-text">
                                                                                                        <span class="me-2 fas fa-universal-access text-primary"></span>
                                                                                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4++ }}</span> {{$subs4->acc_coa_data_name}}
                                                                                                    </p>
                                                                                                </a>
                                                                                                <div class="dot bg-info"></div>
                                                                                            </div>
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                                <li class="treeview-list-item">
                                                                                    <div class="treeview-item">
                                                                                        <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4 }}" data-level="5" data-code="{{ $subs3->acc_coa_data_code }}">
                                                                                            <p class="treeview-text">
                                                                                                <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                                                add Data x.x.x.x.x.x
                                                                                            </p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    @else ($subs3->acc_coa_data_opt == 0)
                                                                        <li class="treeview-list-item">
                                                                            <div class="treeview-item">
                                                                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs3->acc_coa_data_code}}'); return false;">
                                                                                    <p class="treeview-text">
                                                                                        <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span> {{$subs3->acc_coa_data_name}}
                                                                                    </p>
                                                                                </a>
                                                                                <div class="dot bg-info"></div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                                <li class="treeview-list-item">
                                                                    <div class="treeview-item">
                                                                        <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3 }}" data-level="4" data-code="{{ $subs2->acc_coa_data_code }}">
                                                                            <p class="treeview-text">
                                                                                <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                                add Data x.x.x.x.x
                                                                            </p>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @else ($subs2->acc_coa_data_opt == 0)
                                                        <li class="treeview-list-item">
                                                            <div class="treeview-item">
                                                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs2->acc_coa_data_code}}'); return false;">
                                                                    <p class="treeview-text">
                                                                        <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span> {{$subs2->acc_coa_data_name}}
                                                                    </p>
                                                                </a>
                                                                <div class="dot bg-info"></div>
                                                            </div>
                                                        </li>

                                                    @endif
                                                @endforeach
                                                <li class="treeview-list-item">
                                                    <div class="treeview-item">
                                                        <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2 }}" data-level="3" data-code="{{ $subs1->acc_coa_data_code }}">
                                                            <p class="treeview-text">
                                                                <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                add Data x.x.x.x
                                                            </p>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    @else ($subs1->acc_coa_data_opt == 0)
                                        <li class="treeview-list-item">
                                            <div class="treeview-item">
                                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs1->acc_coa_data_code}}'); return false;">
                                                    <p class="treeview-text">
                                                        <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1++ }}</span> {{$subs1->acc_coa_data_name}}
                                                    </p>
                                                </a>
                                                <div class="dot bg-info"></div>
                                            </div>
                                        </li>

                                    @endif
                                @endforeach
                                <li class="treeview-list-item">
                                    <div class="treeview-item">
                                        <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1 }}" data-level="2" data-code="{{ $subs->acc_coa_data_code }}">
                                            <p class="treeview-text">
                                                <span class="me-2 fas fa-plus-circle text-success"></span>
                                                add Data x.x.x
                                            </p>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @elseif($subs->acc_coa_data_opt == 0)
                        <li class="treeview-list-item">
                            <div class="treeview-item">
                                <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs->acc_coa_data_code}}'); return false;">
                                    <p class="treeview-text">
                                        <span class="me-2 fas fa-universal-access text-primary"></span>
                                        <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no++ }}</span> {{$subs->acc_coa_data_name}}
                                    </p>
                                </a>
                                <div class="dot bg-info"></div>
                            </div>
                        </li>
                    @endif
                @endforeach
                <!-- TINGKAT 1 END-->
                <li class="treeview-list-item">
                    <div class="treeview-item">
                        <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no }}" data-level="1" data-code="{{ $datas->acc_master_coa_code }}">
                            <p class="treeview-text">
                                <span class="me-2 fas fa-plus-circle text-success"></span>
                                add Data x.x
                            </p>
                        </a>
                    </div>
                </li>
            </ul>
        </li>
    @endforeach
    <!-- CONFIGURASI TAMBAHAN -->
    <li class="treeview-list-item">
        <div class="treeview-item">
            <a class="flex-1" href="#!">
                <p class="treeview-text">
                    <span class="me-2 fab fa-node-js text-success"></span>
                    package-lock.json
                </p>
            </a>
        </div>
    </li>
    <li class="treeview-list-item">
        <div class="treeview-item">
            <a class="flex-1" href="#!">
                <p class="treeview-text">
                    <span class="me-2 fas fa-exclamation-circle text-primary"></span>
                    README.md
                </p>
            </a>
        </div>
    </li>
</ul>
