<div class="table-responsive">
    <table id="data-menu" class="table table-custom nowrap w-100">
        <thead>
            <tr>
                <th style="width: 50px;" class="text-center">No</th>
                <th style="width: 210px;">Menu</th>
                <th>Sub Menu</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $datas)
                <tr>
                    <td class="text-center fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $no++ }}</td>
                    <td>
                        <span class="ent-badge mb-1" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.28);">
                            <i class="fas fa-layer-group"></i> {{ $datas->menu_super_name }}
                        </span>
                        <div class="fw-bold text-primary small mt-1">
                            <i class="fas fa-folder-open me-1"></i>{{ $datas->menu_name }}
                        </div>
                    </td>
                    <td>
                        @php
                            $menu = DB::table('z_menu_sub')->where('menu_code', $datas->menu_code)->get();
                        @endphp

                        @if ($menu->count() > 0)
                            <div class="sub-menu-stack">
                                @foreach ($menu as $menus)
                                    @php
                                        $cekmenu = DB::table('z_menu_user')
                                            ->where('access_code', $code)
                                            ->where('menu_sub_code', $menus->menu_sub_code)
                                            ->first();
                                    @endphp

                                    <div class="sub-menu-row">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-angle-right text-primary"></i>
                                            <span class="fw-bold small">{{ $menus->menu_sub_name }}</span>
                                        </div>

                                        @if ($cekmenu)
                                            <span class="status-toggle-pill status-pill-active"
                                                id="button-update-menu"
                                                data-code="{{ $menus->menu_sub_code }}"
                                                data-id="{{ $code }}"
                                                title="Klik untuk menonaktifkan">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        @else
                                            <span class="status-toggle-pill status-pill-inactive"
                                                id="button-update-menu"
                                                data-code="{{ $menus->menu_sub_code }}"
                                                data-id="{{ $code }}"
                                                title="Klik untuk mengaktifkan">
                                                <i class="fas fa-times-circle"></i> Belum Aktif
                                            </span>
                                        @endif
                                    </div>

                                    @php
                                        $sub = DB::table('z_menu_sub_main')->where('menu_sub_code', $menus->menu_sub_code)->get();
                                    @endphp
                                    @foreach ($sub as $subs)
                                        @php
                                            $ceksubmenu = DB::table('z_menu_user_sub')
                                                ->where('access_code', $code)
                                                ->where('menu_main_sub_code', $subs->menu_main_sub_code)
                                                ->first();
                                        @endphp

                                        <div class="sub-menu-child-row">
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($ceksubmenu)
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill" style="font-size: 0.62rem;">Sub</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill" style="font-size: 0.62rem;">Sub</span>
                                                @endif
                                                <span class="fw-semibold">{{ $subs->menu_main_sub_name }}</span>
                                            </div>

                                            @if ($ceksubmenu)
                                                <span class="status-toggle-pill status-pill-active"
                                                    id="button-update-sub-menu"
                                                    data-code="{{ $subs->menu_main_sub_code }}"
                                                    data-id="{{ $code }}"
                                                    title="Klik untuk menonaktifkan">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="status-toggle-pill status-pill-inactive"
                                                    id="button-update-sub-menu"
                                                    data-code="{{ $subs->menu_main_sub_code }}"
                                                    data-id="{{ $code }}"
                                                    title="Klik untuk mengaktifkan">
                                                    <i class="fas fa-times-circle"></i> Belum Aktif
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @else
                            <span class="opacity-50 small fst-italic">Belum ada sub menu tersedia</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    new DataTable('#data-menu', {
        responsive: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ menu",
            infoEmpty: "Tidak ada data menu",
            zeroRecords: "Menu tidak ditemukan",
            emptyTable: "Belum ada data menu"
        }
    });
</script>
```[cite: 14]
