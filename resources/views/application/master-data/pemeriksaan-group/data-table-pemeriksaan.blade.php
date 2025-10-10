<div class="card mb-3 border">
    <div class="card-body d-flex justify-content-between">
        <div>
            <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#modal-pemeriksaan" id="button-add-jenis-pemeriksaan" data-code="{{ $code }}">
                <span class="fas fa-plus-circle"></span>
            </a><span class="mx-1 mx-sm-2 text-300">|</span>
            <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Archive" aria-label="Archive"><svg class="svg-inline--fa fa-archive fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="archive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z"></path>
                </svg><!-- <span class="fas fa-archive"></span> Font Awesome fontawesome.com --></button>
            <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg class="svg-inline--fa fa-trash-alt fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path>
                </svg><!-- <span class="fas fa-trash-alt"></span> Font Awesome fontawesome.com --></button>

        </div>
        <div class="d-flex">
            <div class="dropdown font-sans-serif">
                <button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2" type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path>
                    </svg><!-- <span class="fas fa-cog"></span> Font Awesome fontawesome.com --></button>
                <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-settings"><a class="dropdown-item" href="#!">Configure inbox</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Settings</a><a class="dropdown-item" href="#!">Themes</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Send feedback</a><a class="dropdown-item" href="#!">Help</a>
                </div>
            </div>
        </div>
    </div>
</div>
<table id="example" class="table table-striped nowrap" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Pemeriksaan</th>
            <th>Jenis Pemeriksaan</th>
            <th>Type Pemeriksaan</th>
            <th>Item Pemeriksaan</th>
            <th>Status Pemeriksaan</th>
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
            <td>{{ $datas->t_pemeriksaan_list_name }}</td>
            <td>{{ $datas->t_pemeriksaan_list_option }}</td>
            <td>{{ $datas->t_pemeriksaan_list_type }}</td>
            <td>
                <?php
                $pem = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code',$datas->t_pemeriksaan_list_code)->get();
                ?>
                @foreach ($pem as $pems)
                    <li>{{ $pems->t_pem_list_val_name }}</li>
                @endforeach
            </td>
            <td></td>
            <td>
                <div class="dropdown font-sans-serif">
                    <button class="btn btn-falcon-primary text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2" type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-cogs"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-settings">
                        <a class="dropdown-item" href="#!">Configure Data</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!" id="button-add-value-pemeriksaan" data-code="{{ $datas->t_pemeriksaan_list_code }}" data-bs-toggle="modal" data-bs-target="#modal-pemeriksaan">Add Value</a>
                        <a class="dropdown-item" href="#!">Themes</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!">Send feedback</a>
                        <a class="dropdown-item" href="#!">Help</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
