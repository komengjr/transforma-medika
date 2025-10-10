@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center" style="color: white !important;">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 style="color: white !important;" class="fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 style="color: white !important;" class="fw-bold mb-1">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Order <span
                                class="text-white fw-medium" style="color: white !important;">Peminjaman</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-4 pe-lg-2 mb-3">
            <div class="sticky-sidebar">
                <div class="card mb-lg-0">
                    <div class="card-header bg-primary">
                        <div class="row flex-between-center">
                            <div class="col">
                                <h5 class="mb-0 text-white" style="color: white !important;">Detail Info</h5>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-falcon-default btn-sm me-2" role="button">Create</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="mb-3">
                            <label class="form-label" for="event-name">Title Peminjaman</label>
                            <input class="form-control" id="event-name" type="text" placeholder="Event Title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="event-type">Type Peminjaman</label>
                            <select class="form-select" id="event-type" name="event-type">
                                <option>Select event type...</option>
                                <option>Class, Training, or Workshop</option>
                                <option>Concert or Performance</option>
                                <option>Conference</option>
                                <option>Convention</option>
                                <option>Dinner or Gala</option>
                                <option>Festival or Fair</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="event-topic">Event Topic</label>
                            <select class="form-select" id="event-topic" name="even-topic">
                                <option value="" selected="selected">Select a topic</option>
                                <option>Auto, Boat &amp; Air</option>
                                <option>Business &amp; Professional</option>
                                <option>Charity &amp; Causes</option>
                                <option>Community &amp; Culture</option>
                                <option>Family &amp; Education</option>
                                <option>Fashion &amp; Beauty</option>
                                <option>Film, Media &amp; Entertainment</option>
                                <option>Food &amp; Drink</option>
                                <option>Government &amp; Politics</option>
                            </select>
                        </div>

                        <div class="border-dashed-bottom my-3"></div>
                        <h6>Listing Privacy</h6>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" id="customRadio4" type="radio" name="listingPrivacy"
                                checked="checked">
                            <label class="form-label mb-0" for="customRadio4"> <strong>Public page:</strong></label>
                            <div class="form-text mt-0">Discoverable by anyone on Falcon, our distribution partners, and
                                search engines.</div>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" id="customRadio5" type="radio" name="listingPrivacy">
                            <label class="form-label mb-0" for="customRadio5"> <strong>Private page:</strong></label>
                            <div class="form-text mt-0">Accessible only by people you specify. </div>
                        </div>
                        <div class="border-dashed-bottom my-3"></div>
                        <h6>Remaining Tickets</h6>
                        <div class="form-check custom-checkbox mb-0">
                            <input class="form-check-input" id="customRadio6" type="checkbox">
                            <label class="form-label mb-0" for="customRadio6">Show the number of remaining tickets. </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8  ps-lg-2">
            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <div class="row flex-between-center">
                        <div class="col">
                            <h5 class="mb-0 text-white" style="color: white !important;">Detail Barang</h5>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-falcon-default btn-sm me-2" role="button">Cari</button>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <table id="example" class="table table-striped nowrap" style="width:100%">
                        <thead class="bg-200 text-700 fs--2">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Status Peminjaman</th>
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
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Schedule</h5>
                </div>
                <div class="card-body bg-light">
                    <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">
                        <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                            <button class="btn btn-link btn-sm p-0" type="button"><svg
                                    class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1"
                                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                    style="transform-origin: 0.5em 0.5em;">
                                    <g transform="translate(256 256)">
                                        <g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"
                                                transform="translate(-256 -256)"></path>
                                        </g>
                                    </g>
                                </svg><!-- <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span> Font Awesome fontawesome.com --></button>
                        </div>
                        <div class="row gx-2">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="schedule-title">Title</label>
                                <input class="form-control form-control-sm" id="schedule-title" type="text"
                                    placeholder="Title">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="schedule-start-date">Start Date</label>
                                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                                    id="schedule-start-date" type="text" placeholder="d/m/y"
                                    data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;enableTime&quot;:false}"
                                    readonly="readonly">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="schedule-start-time">Start Time</label>
                                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                                    id="schedule-start-time" type="text" placeholder="H:i"
                                    data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;}"
                                    readonly="readonly">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label class="form-label" for="schedule-end-date">End Date</label>
                                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                                    id="schedule-end-date" type="text" placeholder="d/m/y"
                                    data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;enableTime&quot;:false}"
                                    readonly="readonly">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="schedule-end-time">End Time</label>
                                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                                    id="schedule-end-time" type="text" placeholder="H:i"
                                    data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;}"
                                    readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-falcon-default btn-sm mt-2" type="button"><svg
                            class="svg-inline--fa fa-plus fa-w-14 fs--2 me-1" data-fa-transform="up-1" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="plus" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""
                            style="transform-origin: 0.4375em 0.4375em;">
                            <g transform="translate(224 256)">
                                <g transform="translate(0, -32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor"
                                        d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"
                                        transform="translate(-224 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-plus fs--2 me-1" data-fa-transform="up-1"></span> Font Awesome fontawesome.com -->Add
                        Item </button>
                </div>
            </div>
            <div class="card mb-3 mb-lg-0">
                <div class="card-header">
                    <h5 class="mb-0">Custom Fields</h5>
                </div>
                <div class="card-body bg-light">
                    <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                        <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                            <button class="btn btn-link btn-sm p-0" type="button"><svg
                                    class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1"
                                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                    style="transform-origin: 0.5em 0.5em;">
                                    <g transform="translate(256 256)">
                                        <g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)">
                                            <path fill="currentColor"
                                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"
                                                transform="translate(-256 -256)"></path>
                                        </g>
                                    </g>
                                </svg><!-- <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span> Font Awesome fontawesome.com --></button>
                        </div>
                        <div class="row gx-2">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="field-name">Name</label>
                                <input class="form-control form-control-sm" id="field-name" type="text"
                                    placeholder="Name (e.g. T-shirt)">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="field-type">Type</label>
                                <select class="form-select form-select-sm" id="field-type">
                                    <option>Select a type</option>
                                    <option>Text</option>
                                    <option>Checkboxes</option>
                                    <option>Radio Buttons</option>
                                    <option>Textarea</option>
                                    <option>Date</option>
                                    <option>Dropdowns</option>
                                    <option>File</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="field-options">Field Options</label>
                                <textarea class="form-control form-control-sm" id="field-options" rows="3"></textarea>
                                <div class="form-text fs--1 text-warning">* Separate your options with comma</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-falcon-default btn-sm mt-2" type="submit"><svg
                            class="svg-inline--fa fa-plus fa-w-14 fs--2 me-1" data-fa-transform="up-1" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="plus" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""
                            style="transform-origin: 0.4375em 0.4375em;">
                            <g transform="translate(224 256)">
                                <g transform="translate(0, -32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor"
                                        d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"
                                        transform="translate(-224 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-plus fs--2 me-1" data-fa-transform="up-1"></span> Font Awesome fontawesome.com -->Add
                        Item</button>
                </div>
            </div>
        </div>

    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-falcon-default btn-sm me-2">Save</button>
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
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
@endsection
