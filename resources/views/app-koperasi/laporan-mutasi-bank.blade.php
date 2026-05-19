@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ Env('APP_LABEL') }}
                            <span class="text-white fw-medium" style="color: white !important;">Management
                                System</span>
                        </h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Laporan <span
                            class="text-white fw-medium" style="color: white !important;">Mutasi Bank</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card" id="customersTable"
    data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
    <div class="card-header bg-primary">
        <div class="row flex-between-center">
            <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi" id="button-add-data-mutasi">
                    <span class="fas fa-plus me-2"></span> Buat Mutasi
                </a>
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
                    <div class="position-relative">
                        <input class="form-control form-control-lg datetimepicker" id="data_date" type="text"
                            placeholder="d/m/y to d/m/y"
                            data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0 mb-3 mt-3">
        <div class="table-responsive">
            <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden" id="data-ledger">
                <thead class="bg-200 text-900 fs--1">
                    <tr>
                        <th class="align-middle white-space-nowrap">No</th>
                        <th class="align-middle white-space-nowrap">Tanggal</th>
                        <th class="align-middle white-space-nowrap">Nama Bank</th>
                        <th class="align-middle white-space-nowrap">Keterangan</th>
                        <th class="text-end white-space-nowrap">Debit ( IDR )</th>
                        <th class="text-end white-space-nowrap">Credit ( IDR )</th>
                        <th class="text-end white-space-nowrap">Saldo ( IDR )</th>
                    </tr>
                </thead>
                <tbody class="list fs--2">
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->kop_mutasi_bank_date }}</td>
                        <td>{{ $datas->kop_master_bank_name }}</td>
                        <td>{{ $datas->kop_mutasi_bank_desc }}</td>
                        <td class="text-end">@currency($datas->kop_mutasi_bank_debit)</td>
                        <td class="text-end">@currency($datas->kop_mutasi_bank_kredit)</td>
                        <td class="text-end">@currency($datas->kop_mutasi_bank_total)</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
@section('base.js')
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on("click", "#button-add-data-mutasi", function(e) {
        e.preventDefault();
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('laporan_koperasi_mutasi_bank_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 123
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-mutasi", function(e) {
        e.preventDefault();
        var data = $("#form-add-mutasi-baru").serialize();
        $('#menu-add-data-mutasi').html(
            '<div class="spinner-border my-0" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('laporan_koperasi_mutasi_bank_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-mutasi').html('<button class="btn btn-success float-end" id="button-simpan-data-mutasi" data-code="">Simpan Data</button>');
            } else {
                Swal.fire('Berhasil!', 'Data Tagihan Berhasil di Buat', 'success').then(() => {
                    location.reload();
                });
            }
        }).fail(function() {
            $('#menu-add-data-mutasi').html('eror');
        });
    });
</script>
<script>
    new DataTable('#data-ledger', {
        responsive: true,
        "lengthMenu": [
            [28, 50, 25],
            [28, 50, 25]
        ],
        layout: {
            topStart: {
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: 'Export Excel',
                    title: 'Data Laporan Keuangan'
                }],
            }
        }
    });
</script>
@endsection
