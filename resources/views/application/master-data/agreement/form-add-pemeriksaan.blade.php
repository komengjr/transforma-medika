<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Agrement Project</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="row g-3 p-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row flex-between-center">
                        <div class="col-sm-auto mb-2 mb-sm-0 ">
                            <h5 class="mb-0" data-anchor="data-anchor">
                                Data Pemeriksaan
                            </h5>
                        </div>
                        <div class="col-sm-auto">

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
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->master_pemeriksaan_name }}</td>
                                        <td>
                                            <button class="btn btn-falcon-primary" id="button-pilih-pemeriksaan"
                                                data-id="{{ $item->master_pemeriksaan_code }}"
                                                data-code="{{ $code }}">Pilih</button>
                                        </td>
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
                        <div class="col-sm-auto mb-sm-0 mb-2">
                            <h5 class="mb-0" data-anchor="data-anchor">
                                Data Agrement
                            </h5>
                        </div>
                        <div class="col-sm-auto">
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
                                    <th>Pemeriksaan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->master_pemeriksaan_name }}</td>
                                        <td>
                                            <button class="btn btn-falcon-primary" id="button-hapus-pemeriksaan"
                                                data-id="{{ $item->id_mou_agreement_sub }}" data-code="{{$item->mou_agreement_code}}"><span
                                                    class="fas fa-trash"></span> Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
