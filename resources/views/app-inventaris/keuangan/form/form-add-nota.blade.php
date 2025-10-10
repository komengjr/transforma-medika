<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Nota : {{ $code }}</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-nota-form">
        <div class="row g-3">
            <div class="col-md-2 d-flex justify-content-center">
                <div class="avatar avatar-5xl shadow-sm img-thumbnail rounded-circle">
                    <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                            src="{{asset('img/nota.png')}}" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail">
                        <input class="d-none" id="profile-image" type="file">
                        <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span
                                class="bg-holder overlay overlay-0"></span><span
                                class="z-index-1 text-white dark__text-white text-center fs--1"><svg
                                    class="svg-inline--fa fa-camera fa-w-16" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="camera" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z">
                                    </path>
                                </svg><!-- <span class="fas fa-camera"></span> Font Awesome fontawesome.com --><span
                                    class="d-block">Upload Nota</span></span></label>
                    </div>
                </div>

            </div>
            <div class="col-md-10">
                <form class="row" id="form-input-invoice">
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">No Nota / Invoice</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Total Pembelian</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="harga" class="form-control form-control-lg border-start-0 bg-white"
                                id="dengan-rupiah">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Tanggal Pembelian</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Pilih Supplier</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="" class="form-control form-control-lg" id="">
                                @foreach ($supp as $supps)
                                    <option value="{{ $supps->master_supplier_code }}">{{ $supps->master_supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Type Invoice</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <select name="invoice_type" class="form-control form-control-lg" id="">
                                <option value="">Pilih Type</option>
                                <option value="Sales Invoice">Sales Invoice ( Faktur Penjualan )</option>
                                <option value="Proforma Invoice">Proforma Invoice ( Invoice Proforma ) </option>
                                <option value="Commercial Invoice">Commercial Invoice ( Invoice Komersial )  </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Deskripsi</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <input type="text" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body" id="table-barang-invoice">
                        <table id="data_barang" class="table table-striped nowrap" style="width:100%">
                            <thead class="bg-200 text-700 fs--2">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>No Inventaris</th>
                                    <th>Klasifikasi</th>
                                    <th>Merk / Type</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Harga Perolehan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>{{ $datas->inv_data_master_no }}</td>
                                        <td>
                                            @if ($datas->inv_data_master_file == "")
                                                <div class="avatar avatar-3xl">
                                                    <img src="{{ asset('img/app.png')}}" alt="" />
                                                </div>
                                            @else
                                                <div class="avatar avatar-3xl">
                                                    <img src="{{ Storage::url($datas->inv_data_master_file)}}" alt="" />
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <h6>{{ $datas->inv_data_master_name }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $datas->inv_data_master_code  }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $datas->id_inv_data_class_code  }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $datas->inv_data_master_merk  }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $datas->inv_data_master_tgl_beli  }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-warning">@currency($datas->inv_data_master_harga)</h6>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" id="button-pilih-barang-invoice" data-code="{{ $code }}" data-id="{{ $datas->inv_data_master_code  }}">Pilih</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-nota">
        <button class="btn btn-success float-end" id="button-simpan-data-nota" data-code="">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
