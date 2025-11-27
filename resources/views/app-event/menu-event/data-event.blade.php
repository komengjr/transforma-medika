@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/brodcast.png') }}" alt="" width="50" />
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
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Event <span
                            class="text-white fw-medium" style="color: white !important;">Data</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Management Data Event</span></h3>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                            id="button-add-event" data-code="123"><span class="far fa-edit"></span>
                            Add Event Brodcast</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                            id="button-add-123" data-code="123"><span class="far fa-folder-open"></span>
                            Add Sub Event</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Gambar Event</th>
                    <th>Nama Event</th>
                    <th>Lokasi Event</th>
                    <th>Mulai Event</th>
                    <th>Berakhir Event</th>
                    <th>Sub Event</th>
                    <th>Status</th>
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
                    <td>
                        @if ($datas->event_data_template == '')
                        <img src="{{ asset('no_pict.png') }}" alt="lightbox" class="img-thumbnail"
                            id="videoPreview" width="70" height="70">
                        @else
                        <img src="{{ Storage::url($datas->event_data_template) }}" alt=""
                            width="80" />
                        @endif
                    </td>
                    <td>{{ $datas->event_data_tittle }}</td>
                    <td>{{ $datas->event_data_venue }}</td>
                    <td>{{ $datas->event_data_start_date }}</td>
                    <td>{{ $datas->event_data_end_date }}</td>
                    <td></td>
                    <td>0</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-brodcast"
                                    id="button-add-event" data-code="123"><span class="far fa-edit"></span>
                                    Detail Event</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-event"
                                    id="button-add-sub-event" data-code="{{$datas->event_data_code}}"><span class="fas fa-calendar-plus"></span>
                                    Add Sub Event</button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-event" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-event"></div>
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
    $(document).on("click", "#button-add-event", function(e) {
        e.preventDefault();
        $('#menu-brodcast').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_brodcast_management_add') }}",
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
</script>
@endsection
