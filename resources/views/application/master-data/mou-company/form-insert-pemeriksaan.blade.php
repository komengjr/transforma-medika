<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Insert Pemeriksaan MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <div class="row g-3" id="menu-pemeriksaan-mcu">
            <div class="col-md-6 ">
                <div class="card border border-primary">
                    <div class="card-header pb-0">
                        <div class="row flex-between-center">
                            <div class="col-sm-auto mb-2 mb-sm-0 ">
                                <h5 class="mb-0" data-anchor="data-anchor">
                                    Master Pemeriksaan
                                </h5>
                            </div>
                            <div class="col-sm-auto">
                                {{-- <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><span class="fas fa-align-left me-1"
                                            data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#modal-category" id="button-add-data-category-v2"><span
                                                class="far fa-edit"></span>
                                            Tambah Category</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body pt-0 mt-0">
                        <div class="tab-content">
                            <table id="data-v2" class="table table-striped nowrap" style="width:100%">
                                <thead class="bg-200 text-700">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemeriksaan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($pemeriksaan as $item)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$item->master_pemeriksaan_name}}</td>
                                            <td><button class="btn btn-falcon-warning" id="button-pilih-pemeriksaan-mou" data-id="{{$item->master_pemeriksaan_code}}" data-code="{{$data->company_mou_code}}">Pilih</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row flex-between-center">
                            <div class="col-sm-auto mb-sm-0 ">
                                <h5 class="mb-0" data-anchor="data-anchor">
                                    Pemeriksaan MCU
                                </h5>
                            </div>
                            <div class="col-sm-auto">
                                {{-- <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><span class="fas fa-align-left me-1"
                                            data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" id="button-clone-master-klasifikasi-barang"><span
                                                class="far fa-folder-open"></span>
                                            Clone Data</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body pt-0" id="menu-data-v3">
                        <div class="tab-content">
                            <table id="data-v3" class="table table-striped nowrap" style="width:100%">
                                <thead class="bg-200 text-700">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Klasifikasi</th>
                                        <th>Nama Klasifikasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    new DataTable('#data-v2', {
        responsive: true
    });
    new DataTable('#data-v3', {
        responsive: true
    });
</script>
