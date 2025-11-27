@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    #button-pick-request {
        cursor: pointer;
    }

    #button-pick-request:hover {
        background: rgb(223, 217, 25);
    }

    #button-terima-order-barang-peminjaman:hover {
        background: rgb(223, 217, 25);
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-info bg-info">
            <div class="row gx-0 flex-between-center" style="color: white !important;">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1">{{env('APP_NAME')}} <span class="text-white fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0">Tambah <span class="text-white fw-medium">Event</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card cover-image mb-3"><img class="card-img-top" src="{{ asset('asset/img/generic/13.jpg') }}" alt="" />
    <input class="d-none" id="upload-cover-image" type="file" />
    <label class="cover-image-file-input" for="upload-cover-image"><span class="fas fa-camera me-2"></span><span>Change cover photo</span></label>
</div>
<form id="formEvent" method="post">
    @csrf
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-header bg-300">
                    <h5 class="mb-0">Event Details</h5>
                </div>
                <div class="card-body bg-light">
                    <form>
                        <div class="row gx-2">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="event-name">Event Title</label>
                                <input class="form-control" id="event-name" name="title" type="text" placeholder="Event Title" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="start-date">Start Date</label>
                                <input class="form-control datetimepicker" name="start_date" id="datetimepicker" type="text" placeholder="d/m/y H:i" data-options='{"enableTime":true,"dateFormat":"d/m/y H:i","disableMobile":true}' />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="end-date">End Date</label>
                                <input class="form-control datetimepicker" name="end_date" id="datetimepicker" type="text" placeholder="d/m/y H:i" data-options='{"enableTime":true,"dateFormat":"d/m/y H:i","disableMobile":true}' />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="event-venue">Venue</label>
                                <input class="form-control" name="venue" id="event-venue" type="text" placeholder="Venue" />
                                <button class="btn btn-link btn-sm btn p-0" type="button">Online Event</button>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="event-address">Address</label>
                                <input class="form-control" name="address" id="event-address" type="text" placeholder="Address" />
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="event-city">City</label>
                                <input class="form-control" name="city" id="event-city" type="text" placeholder="City" />
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="event-state">State</label>
                                <input class="form-control" name="state" id="event-state" type="text" placeholder="State" />
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="event-country">Country</label>
                                <input class="form-control" name="country" id="event-country" type="text" placeholder="Country" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="event-description">Description</label>
                                <textarea class="form-control" name="desc" id="event-description" rows="6"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-3 bg-300">
                <div class="card-header">
                    <h5 class="mb-0">Schedule Sub Event</h5>
                </div>
                <div class="card-body bg-light">
                    <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">
                        <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                            <button class="btn btn-link btn-sm p-0" type="button"><span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span></button>
                        </div>
                        <div class="row gx-2">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="schedule-title">Sub Title</label>
                                <input class="form-control form-control-sm" id="schedule-title" type="text" placeholder="Title" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="schedule-start-date">Start Date</label>
                                <input class="form-control form-control-sm datetimepicker" id="schedule-start-date" type="text" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","enableTime":false}' />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="schedule-start-time">Start Time</label>
                                <input class="form-control form-control-sm datetimepicker" id="schedule-start-time" type="text" placeholder="H:i" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i"}' />
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="schedule-start-date">Room</label>
                                <input class="form-control form-control-sm datetimepicker" id="schedule-start-date" type="text" placeholder="Ballroom" />
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="field-type">Type Event</label>
                                <select class="form-select form-select-sm" id="field-type">
                                    <option>Select a type</option>
                                    <option value="free">Free</option>
                                    <option value="prabayar">Prabayar</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="field-name">Nominal</label>
                                <input class="form-control form-control-sm" id="field-name" type="text" placeholder="@currency(100000)" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="field-options">Field Options</label>
                                <textarea class="form-control form-control-sm" id="field-options" rows="3"></textarea>
                                <div class="form-text fs--1 text-warning">* Separate your options with comma</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-falcon-default btn-sm mt-2" type="button"><span class="fas fa-plus fs--2 me-1" data-fa-transform="up-1"></span>Add Item </button>
                </div>
            </div>

        </div>
        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
                <div class="card mb-lg-0">
                    <div class="card-header bg-300">
                        <h5 class="mb-0">Other Info</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="mb-3">
                            <div class="d-flex flex-between-center">
                                <label class="form-label" for="organizer">Upload Cover</label>
                                <button class="btn btn-primary btn-sm" type="button">Pilih Gambar</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="card overflow-hidden">
                                <div class="card-img-top"><img class="img-fluid" src="https://i.pinimg.com/736x/a5/c2/8a/a5c28a83e4929a3f4775287888cd32f9.jpg" alt="Card image cap" /></div>
                                <div class="card-body">
                                    <h5 class="card-title">Nama Event</h5>
                                    <p class="card-text">Nama Sub Event</p>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="mb-0" for="event-tags">Tags</label>
                                <button class="btn btn-link btn-sm pe-0" type="button">Add New</button>
                            </div>
                            <select class="form-select js-choice" id="event-tags" multiple="multiple" size="1" name="tags" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select tags...</option>
                                <option>Concert</option>
                                <option>New Year</option>
                                <option>Party</option>
                            </select>
                        </div>
                        <div class="border-dashed-bottom my-3"></div>
                        <h6>Listing Privacy</h6>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" id="customRadio4" type="radio" name="listingPrivacy" checked="checked" />
                            <label class="form-label mb-0" for="customRadio4"> <strong>Public page:</strong></label>
                            <div class="form-text mt-0">Discoverable by anyone on Falcon, our distribution partners, and search engines.</div>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" id="customRadio5" type="radio" name="listingPrivacy" />
                            <label class="form-label mb-0" for="customRadio5"> <strong>Private page:</strong></label>
                            <div class="form-text mt-0">Accessible only by people you specify. </div>
                        </div>
                        <div class="border-dashed-bottom my-3"></div>
                        <h6>Remaining Tickets</h6>
                        <div class="form-check custom-checkbox mb-0">
                            <input class="form-check-input" id="customRadio6" type="checkbox" />
                            <label class="form-label mb-0" for="customRadio6">Show the number of remaining tickets. </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card mt-3">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-md">
                <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5>
            </div>
            <div class="col-auto" id="proses-save-event">
                <button class="btn btn-falcon-primary btn-sm" id="button-save-event">Make your Event</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-save-event", function(e) {
        e.preventDefault();
        var data = $("#formEvent").serialize();
        $('#proses-save-event').html(
            '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_create_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 1) {
                Swal.fire({
                    title: "Simpan Data Berhasil!",
                    icon: "success",
                    draggable: true
                });
                location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#proses-save-event').html(
                    '<button class="btn btn-falcon-primary btn-sm" id="button-save-event">Make your Event</button>'
                );
            }
        }).fail(function() {
            $('#proses-save-event').html('eror');
        });
    });
</script>
@endsection
