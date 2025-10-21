<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Data Tagihan Belum Bayar</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4" id="menu-add-data-pr-all">
        <table id="example" class="table table-bordered table-striped border" style="width:100%">
            <thead class="bg-800 text-200 fs--2">
                <tr>
                    <th class="sort" data-sort="no">No</th>
                    <th class="sort" data-sort="reg">No Reg</th>
                    <th class="sort" data-sort="name">Nama Pasien</th>
                    <th class="sort" data-sort="tgl">Tanggal Reg</th>
                    <th class="sort" data-sort="poli">List Pembayaran</th>
                    <th class="sort" data-sort="act">Action</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->d_reg_order_code  }}</td>
                        <td>{{ $datas->master_patient_name }}</td>
                        <td>{{ $datas->d_reg_order_date }}</td>
                        <td>
                            @php
                                $list = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)->get();
                            @endphp
                            @foreach ($list as $lists)
                                @php
                                    $payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code', $lists->d_reg_order_list_code)->first();
                                @endphp
                                @if ($payment)
                                    <li class="ms-3">{{ $lists->d_reg_order_list_code  }} <span class="text-primary">Lunas</span></li>
                                @else
                                    <li class="ms-3">{{ $lists->d_reg_order_list_code  }} <span class="text-danger">Belum Lunas</span></li>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                    <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                        data-bs-target="#modal-keuangan" id="button-proses-transaksi"
                                        data-code="{{ $datas->d_reg_order_code }}"><span class="fab fa-amazon-pay"></span>
                                        Proses Transaksi</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                        id="button-data-barang-cabang" data-code="123"><span
                                            class="far fa-folder-open"></span>
                                        History</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
