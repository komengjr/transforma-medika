<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Account</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3 mb-3">
            <div class="col-12">
                <form class="row" id="form-input-coa">
                    @csrf
                    <input type="text" name="level" id="" value="{{ $level }}" hidden>
                    <input type="text" name="code" id="" value="{{ $code }}" hidden>
                    <input type="text" name="nomor" id="" value="{{ $nomor }}" hidden>
                    <!-- <h5><span class="badge bg-primary">Nomor : {{ $nomor }}</span></h5> -->
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Account Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white"
                                id="nama_account">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Optional Account</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="option" class="form-control form-control-lg" id="option_account">
                                <option value=""></option>
                                <option value="0">Single</option>
                                <option value="1">Multi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 pt-3">
                        <span id="menu-add-data-coa">
                            <button class="btn btn-success float-end" id="button-simpan-data-level-coa">Simpan
                                Data</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div id="data-table-accoaunt-coa">
            <table class="table table-bordered">
                <thead class="bg-200">
                    <tr>
                        <th>No</th>
                        <th>Master Account</th>
                        <th>Sub Account</th>
                        <th>Nomor Account</th>
                        <th>Nama Account</th>
                        <th>Type Account</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->acc_coa_data_code }}</td>
                            <td>{{ $datas->acc_master_coa_code }}</td>
                            <td>{{ $datas->acc_coa_data_no }}</td>
                            <td>{{ $datas->acc_coa_data_name }}</td>
                            <td>
                                @if ($datas->acc_coa_data_opt == 0)
                                    <span class="badge bg-warning">Single</span>
                                @else
                                    <span class="badge bg-primary">Multi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
