<div class="card" id="customersTable"
    data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
    <div class="card-header bg-primary">
        <div class="row flex-between-center">
            <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0" style="color: white;">Data Kehadiran</h5>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <div class="d-none" id="table-customers-actions">
                    <div class="d-flex">
                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                            <option selected="">Bulk actions</option>
                            <option value="Refund">Refund</option>
                            <option value="Delete">Delete</option>
                            <option value="Archive">Archive</option>
                        </select>
                        <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                    </div>
                </div>
                <div id="table-customers-replace-element">
                    <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter"
                            data-fa-transform="shrink-3 down-2"></span><span
                            class="d-none d-sm-inline-block ms-1">Filter</span></button>
                    <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                            data-fa-transform="shrink-3 down-2"></span><span
                            class="d-none d-sm-inline-block ms-1">Export</span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0 mb-3 mt-3">
        <div class="card m-3 border mt-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-2">
                        <!-- <h5 class="mb-3 fs-0">Personal</h5> -->
                        <div class="d-flex"><img class="me-3" src="{{asset('img/pp.png')}}" width="70" height="70"
                                alt="">
                            <div class="flex-1">
                                <h6 class="mb-0">Antony Hopkins</h6>
                                <p class="mb-0 fs--1">{{$data}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-2">
                        <h5 class="mb-3 fs-0">Account Information</h5>
                        <h6 class="mb-2">Antony Hopkins</h6>
                        <p class="mb-0 fs--1"> <strong>NIP : </strong><a href="mailto:ricky@gmail.com"> 23123123</a></p>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h5 class="mb-3 fs-0">Jabatan</h5>
                        <h6 class="mb-2">Manager Nasional</h6>
                        <div class="text-500 fs--1">Divisi Internasional</div>
                    </div>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden table-bordered border"
                id="data-absen">
                <thead class="bg-200 text-900 fs--1">
                    <tr>
                        <th class="align-middle white-space-nowrap">Hari</th>
                        <th class="align-middle white-space-nowrap">Tanggal</th>
                        <th class="align-middle white-space-nowrap">Jam Kerja</th>
                        <th class="align-middle white-space-nowrap px-3">Absen Masuk</th>
                        <th class="align-middle white-space-nowrap px-3">Absen Pulang</th>
                        <th class="align-middle white-space-nowrap px-3">Keterlambatan</th>
                        <th class="align-middle">Lembur</th>
                        <th>Kelebihan Jam</th>
                        <th class="align-middle white-space-nowrap">Lembur (Hari libur)</th>
                    </tr>
                </thead>
                <tbody class="list fs--1">
                    @for ($i = 0; $i <= $data; $i++)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle py-2 px-2">{{ $hari[$i] }}</td>
                            <td class="align-middle py-2 white-space-nowrap px-2">{{ $tgl[$i] }}</td>
                            <td class="align-middle white-space-nowrap px-2"><?php echo $jam_kerja[$i]?></td>
                            <td class="align-middle py-2 white-space-nowrap text-center">-</td>
                            <td class="align-middle py-2 white-space-nowrap text-center">-</td>
                            <td class="align-middle py-2 white-space-nowrap">-</td>

                            <td class="align-middle">-</td>
                            <td class="joined align-middle py-2">-</td>
                            <td class="joined align-middle py-2">-</td>
                        </tr>
                    @endfor
                    <!-- <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2 white-space-nowrap">26-07-2025</td>
                        <td class="align-middle white-space-nowrap">06:30:00 12:30:00</td>
                        <td class="align-middle py-2 white-space-nowrap text-center">06:29</td>
                        <td class="align-middle py-2 white-space-nowrap text-center">16:29</td>
                        <td class="align-middle py-2 white-space-nowrap">-</td>

                        <td class="align-middle">-</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    new DataTable('#data-absen', {
        responsive: true,
        ordering: false,
        "lengthMenu": [[28, 50, 25], [28, 50, 25]]
    });
</script>
