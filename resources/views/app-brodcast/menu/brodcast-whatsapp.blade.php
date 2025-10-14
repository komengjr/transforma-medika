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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/wa.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Brodcast <span
                                class="text-white fw-medium" style="color: white !important;">Whatsapp</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="card">
        <div class="card-header bg-300">
            <h5 class="mb-0">New message</h5>
        </div>
        <div class="card-body p-0">
            <div class="border border-top-0 border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" id="number" type="text"
                    aria-describedby="email-to" placeholder="Nomor Whatsapp . Ex. 0828829xxxx" />
            </div>
            <div class="border border-y-0 border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" id="subject" type="text"
                    aria-describedby="email-subject" placeholder="Subject" />
            </div>
            <div class="min-vh-50">
                <textarea class="form-control" rows="15" name="content" id="pesan-wa"></textarea>
            </div>
            <!-- <div class="bg-light px-card py-3">
                                <div class="d-inline-flex flex-column">
                                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span
                                            class="fs-1 far fa-image"></span><span class="ms-2">winter.jpg (873kb)</span><a
                                            class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Detach"><span class="fas fa-times"></span></a></div>
                                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span
                                            class="fs-1 far fa-file-archive"></span><span class="ms-2">coffee.zip (342kb)</span><a
                                            class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Detach"><span class="fas fa-times"></span></a></div>
                                </div>
                            </div> -->
        </div>
        <div class="card-footer border-top border-200 d-flex flex-between-center">
            <div class="d-flex align-items-center">
                <div id="loading-button">
                    <button class="btn btn-primary btn-sm px-5 me-2" type="button" id="button-send-messages">Send</button>
                </div>
                <input class="d-none" id="email-attachment" type="file" />
                <label class="me-2 btn btn-light btn-sm mb-0 cursor-pointer" for="email-attachment" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Attach files"><span class="fas fa-paperclip fs-1"
                        data-fa-transform="down-2"></span></label>
                <input class="d-none" id="email-image" type="file" accept="image/*" />
                <label class="btn btn-light btn-sm mb-0 cursor-pointer" for="email-image" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Attach images"><span class="fas fa-image fs-1"
                        data-fa-transform="down-2"></span></label>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown font-sans-serif me-2 btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"
                        id="email-options" type="button" data-bs-toggle="dropdown" data-boundary="viewport"
                        aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v"
                            data-fa-transform="down-2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-options"><a
                            class="dropdown-item" href="#!">Print</a><a class="dropdown-item" href="#!">Check spelling</a><a
                            class="dropdown-item" href="#!">Plain text mode</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Archive</a>
                    </div>
                </div>
                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Delete"> <span class="fas fa-trash"></span></button>
            </div>
        </div>
    </form>
@endsection
@section('base.js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).on("click", "#button-send-messages", function (e) {
            e.preventDefault();
            var number = document.getElementById("number").value;
            var subject = document.getElementById("subject").value;
            var editorContent = document.getElementById("pesan-wa").value;
            if (number == "" || editorContent == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Hal Yang Kosong Itu Tidak Bagus",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $('#loading-button').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('menu_brodcast_whatsapp_send') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "number": number,
                        "subject": subject,
                        "text": editorContent,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $('#loading-button').html(data);
                    location.reload();
                }).fail(function () {
                    $('#loading-button').html('eror');
                });
            }
        });
    </script>
@endsection
