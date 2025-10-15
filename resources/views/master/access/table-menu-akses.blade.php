<table id="data-menu" class="table table-striped nowrap" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Sub Menu</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td>{{ $no++ }}</td>
                <td><strong class="text-primary">{{ $datas->menu_super_name }}</strong> <br>
                    <small>{{ $datas->menu_name }}</small>
                </td>
                <td>
                    @php
                        $menu = DB::table('z_menu_sub')->where('menu_code', $datas->menu_code)->get();
                    @endphp
                    @foreach ($menu as $menus)
                        @php
                            $cekmenu = DB::table('z_menu_user')
                                ->where('access_code', $code)
                                ->where('menu_sub_code', $menus->menu_sub_code)->first();
                        @endphp

                        @if ($cekmenu)
                            <li>{{ $menus->menu_sub_name }} <strong class="text-primary" style="float: right;"
                                    id="button-update-menu" data-code="{{ $menus->menu_sub_code }}" data-id="{{ $code }}"></span>
                                    Aktif</strong></li>
                        @else
                            <li>{{ $menus->menu_sub_name }} <strong class="text-danger" style="float: right;"
                                    id="button-update-menu" data-code="{{ $menus->menu_sub_code }}" data-id="{{ $code }}"></span>
                                    Belum
                                    Aktif</strong></li>
                        @endif

                        @php
                            $sub = DB::table('z_menu_sub_main')->where('menu_sub_code', $menus->menu_sub_code)->get();
                        @endphp
                        @foreach ($sub as $subs)
                            @php
                                $ceksubmenu = DB::table('z_menu_user_sub')
                                    ->where('access_code', $code)
                                    ->where('menu_main_sub_code', $subs->menu_main_sub_code)->first();
                            @endphp

                            @if ($ceksubmenu)
                                <li><strong class="text-primary">Sub</strong> {{ $subs->menu_main_sub_name }}<strong
                                        class="text-primary" style="float: right;" id="button-update-sub-menu"
                                        data-code="{{ $subs->menu_main_sub_code }}" data-id="{{ $code }}"></span> Aktif</strong></li>
                            @else
                                <li><strong class="text-warning">Sub</strong> {{ $subs->menu_main_sub_name }}<strong class="text-danger"
                                        style="float: right;" id="button-update-sub-menu" data-code="{{ $subs->menu_main_sub_code }}"
                                        data-id="{{ $code }}"></span> Belum
                                        Aktif</strong></li>
                            @endif

                        @endforeach

                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
