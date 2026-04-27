@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<script src="{{ ENV('MIDTRANS_JS_LINK') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

@endsection
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h5 class="mb-2">{{ Auth::user()->fullname }} (<a href="mailto:tony@gmail.com">{{ Auth::user()->email }}</a>)</h5><a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-plus fs--2 me-1"></span>Add note</a>
                <button class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                <div class="dropdown-menu"><a class="dropdown-item" href="#">Edit</a><a class="dropdown-item" href="#">Report</a><a class="dropdown-item" href="#">Archive</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#">Delete user</a>
                </div>
            </div>
            <div class="col-auto d-none d-sm-block">
                <h6 class="text-uppercase text-600">Customer<span class="fas fa-user ms-2"></span></h6>
            </div>
        </div>
    </div>
    <div class="card-body border-top">
        <div class="d-flex"><span class="fab fa-whatsapp text-success me-2" data-fa-transform="down-5"></span>
            <div class="flex-1">
                <p class="mb-0">Number Connected</p>
                <p class="fs--1 mb-0 text-600">{{ date('d-m-Y  H:i:s')}}</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Status Akun</h5>
            </div>
            <div class="col-auto"><a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-pencil-alt fs--2 me-1"></span>Update details</a></div>
        </div>
    </div>
    <div class="card-body bg-light border-top">
        <div class="row">
            <div class="col-lg col-xxl-5">
                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Account Information</h6>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">ID</p>
                    </div>
                    <div class="col">{{ Auth::user()->userid }}</div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Created</p>
                    </div>
                    <div class="col">{{ Auth::user()->created_at }}</div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Email</p>
                    </div>
                    <div class="col"><a href="mailto:tony@gmail.com">{{ Auth::user()->email }}</a></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">No Handphone</p>
                    </div>
                    <div class="col">
                        <p class="fst-italic text-400 mb-1">{{ Auth::user()->number_handphone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Billing Information</h6>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Phone number</p>
                    </div>
                    <div class="col"><a href="tel:+12025550110">Random</a></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-0">Totoal Kuota</p>
                    </div>
                    <div class="col">
                        <p class="fw-semi-bold mb-0">7C23435</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer border-top text-end">
        <a class="btn btn-primary btn-sm" href="#!" id="button-add-kuota-whatsapp" data-bs-toggle="modal" data-bs-target="#modal-brodcast"><span class="fas fa-dollar-sign fs--2 me-1"></span>Beli Kuota</a>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Logs</h5>
    </div>
    <div class="card-body border-top p-0">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Tiket Pesan</th>
                    <th>Nama Kontak</th>
                    <th>Nomor Kontak</th>
                    <th>Gambar</th>
                    <th>PDF</th>
                    <th>Isi Pesan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->v_log_whatsapp_code }}</td>
                    <td>{{ $datas->v_log_whatsapp_name }}</td>
                    <td>{{ $datas->v_log_whatsapp_number }}</td>
                    <td>
                        @if ($datas->v_log_whatsapp_picture == '0')
                        <span class="badge bg-danger">No</span>
                        @else
                        <span class="badge bg-primary">Yes</span>
                        @endif
                    </td>
                    <td>
                        @if ($datas->v_log_whatsapp_file == 'N')
                        <span class="badge bg-danger">No</span>
                        @else
                        <span class="badge bg-primary">Yes</span>
                        @endif
                    </td>
                    <td>{{ $datas->v_log_whatsapp_text }}</td>
                    <td>
                        @if ($datas->v_log_whatsapp_status == 0)
                        <span class="badge bg-danger">Belum Terkirim</span>
                        @elseif($datas->v_log_whatsapp_status == 1)
                        <span class="badge bg-primary">Terkirim</span>
                        @elseif($datas->v_log_whatsapp_status == 1)
                        <span class="badge bg-warning">No Tidak Terdaftar</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- <div class="card-footer bg-light p-0"><a class="btn btn-link d-block w-100" href="#!">View more logs<span class="fas fa-chevron-right fs--2 ms-1"></span></a></div> -->
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-brodcast" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-brodcast"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>


<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-add-kuota-whatsapp", function(e) {
        e.preventDefault();
        $('#menu-brodcast').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_brodcast_configure_whatsapp_buy_kuota') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-brodcast').html(data);
        }).fail(function() {
            $('#menu-brodcast').html('eror');
        });
    });
    $(document).on("click", "#pay-button-force", function(e) {
        e.preventDefault();
        $('#menu-payment-force').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_brodcast_configure_whatsapp_token_payment') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            snap.pay(data, {
                onSuccess: function(result) {
                    alert("payment success!");
                    $.ajax({
                        url: "{{ route('master_brodcast_configure_whatsapp_confrim_payment') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        location.reload();
                    })
                },
                onPending: function(result) {
                    alert("wating your payment!");
                    console.log(result);
                    location.reload();
                },
                onError: function(result) {
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    alert('you closed the popup without finishing the payment');
                    location.reload();
                }
            });
        }).fail(function() {
            $('#menu-payment-force').html('eror');
        });
    });
</script>
@endsection
