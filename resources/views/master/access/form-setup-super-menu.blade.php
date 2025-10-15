<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Form Setup Super Menu</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-3">
        <table id="data-menu" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Super Menu</th>
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
                        <td>{{ $datas->menu_super_name }}</td>
                        <td class="text-center">
                            @php
                                $cek = DB::table('z_menu_user_super')->where('menu_super_code', $datas->menu_super_code)
                                    ->where('access_code', $code)->first();
                            @endphp
                            @if ($cek)
                                <button class="btn btn-primary btn-sm" data-code="{{ $datas->menu_super_code }}">Aktif</button>
                            @else
                                <button class="btn btn-danger btn-sm">Belum Aktif</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-menu', {
        responsive: true
    });
</script>
