<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data MOU : <strong
                class="text-primary">123</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <table id="data-mou" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>MOU Perusahaan</th>
                    <th>Nama Perusahaan</th>
                    <th>Mulai MCU</th>
                    <th>Selesai MCU</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $datas)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$datas->company_mou_name}}</td>
                        <td>{{$datas->master_company_name}}</td>
                        <td>{{$datas->company_mou_start}}</td>
                        <td>{{$datas->company_mou_end}}</td>
                        <td>
                            <button class="btn btn-falcon-primary btn-sm" id="button-setup-akses-mou" data-id="{{$datas->company_mou_code }}" data-code="{{$code}}">Pilih</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-mou', {
        responsive: true
    });
</script>
