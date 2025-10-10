{{-- <link href="{{ asset('vendors/glightbox/glightbox.min.css') }}" rel="stylesheet" /> --}}
<style>
    /* IMAGE GRID STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .image-grid figure {
        margin-bottom: 0;
    }

    .image-grid img {
        box-shadow: 0 1rem 1rem rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.2s;
    }

    .image-grid a:hover img {
        box-shadow: 0 1rem 1rem rgba(0, 0, 0, 0.35);
    }


    /* LIGHTBOX STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .lightbox-modal .modal-content {
        background: var(--lightbox);
    }

    .lightbox-modal .btn-close {
        position: absolute;
        top: 20px;
        right: 18px;
        font-size: 1.2rem;
        z-index: 10;
    }

    .lightbox-modal .modal-body {
        display: flex;
        align-items: center;
        padding: 0;
        text-align: center;
    }

    .lightbox-modal img {
        width: auto;
        max-height: 100vh;
        max-width: 100%;
    }

    .lightbox-modal .carousel-caption {
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(36, 36, 36, 0.75);
    }

    .lightbox-modal .carousel-control-prev,
    .lightbox-modal .carousel-control-next {
        top: 50%;
        bottom: auto;
        transform: translateY(-50%);
        width: auto;
    }

    .lightbox-modal .carousel-control-prev {
        left: 10px;
    }

    .lightbox-modal .carousel-control-next {
        right: 10px;
    }


    /* FOOTER STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .page-footer {
        position: fixed;
        right: 0;
        bottom: 60px;
        display: flex;
        align-items: center;
        font-size: 1rem;
        padding: 5px;
        background: rgba(255, 255, 255, 0.65);
    }

    .page-footer a {
        display: flex;
        margin-left: 9px;
    }
</style>
<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Pasien Details</h5>
    </div>
    <div class="card-body bg-light">
        <form>
            <div class="row g-3">
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="avatar avatar-5lg shadow-sm justify-content-center">
                        <div class="h-100 w-100 overflow-hidden ">
                            <img src="{{ asset($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                        </div>

                    </div>

                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-user-friends"></i></span>
                                <input type="text" name="nama"
                                    class="form-control form-control-lg border-start-0 bg-white"
                                    value="{{ $data->master_patient_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-money-check"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    value="{{ $data->master_patient_nik }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName1" class="form-label text-youtube">No Rekam
                                Medis</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-money-check"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    value="{{ $data->master_patient_code }}" disabled>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Tanggal
                        Lahir</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                        <input type="date" name="tgl_lahir"
                            class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                            value="{{ $data->master_patient_tgl_lahir }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Jenis
                        Kelamin</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-transgender fs-2"></i></span>
                        <input type="text"class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                            value="{{ $data->master_patient_jk }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-map-marked-alt"></i></span>
                        <input type="text" name="tempat_lahir"
                            class="form-control form-control-lg border-start-0 bg-white" id="inputLastName1"
                            value="{{ $data->master_patient_tempat_lahir }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray fs-2"></i></span>
                        <input type="text"class="form-control form-control-lg bg-white border-start-0"
                            value="{{ $data->master_patient_agama }}" disabled>
                    </div>

                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-phone-square-alt"></i></span>
                        <input type="text" name="no_hp"
                            class="form-control form-control-lg border-start-0 bg-white" id="no_hp"
                            value="{{ $data->master_patient_no_hp }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label">Email</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                        <input type="email" name="email"
                            class="form-control form-control-lg border-start-0 bg-white" id="inputLastName2"
                            value="{{ $data->master_patient_email }}" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@php
    $payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code', $code)->first();
@endphp
@if ($payment)
    <div class="card mb-3">
        <div class="card-header bg-300">
            <h5 class="mb-0">Hasil Bacaan</h5>
        </div>
        <div class="card-body bg-light">
            <div class="image-grid pb-3">
                <div class="row gy-3">
                    <div class="col-12 col-sm-6 col-md-4">
                        <figure>
                            <a class="d-block" href="">
                                <img  src="{{ asset('data/hasil_rad/1.jpg') }}" width="200"
                                    alt="Ring of Kerry, County Kerry, Ireland"
                                    data-caption="Hasil 1" >
                            </a>
                        </figure>
                    </div>

                    {{-- <div class="col-12 col-sm-6 col-md-4">
                        <figure>
                            <a class="d-block" href="">
                                <img width="1920" height="1280"
                                    src="{{ asset('data/hasil_rad/3.jpg') }}" class="img-fluid"
                                    alt="Anne Street, Dublin, Ireland" data-caption="Anne Street, Dublin, Ireland">
                            </a>
                        </figure>
                    </div> --}}
                </div>
            </div>
            <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                    <button class="btn btn-link btn-sm p-0" type="button"><span
                            class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span></button>
                </div>
                <div class="row gx-2">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label" for="field-name">Name</label>
                        <input class="form-control form-control-sm" id="field-name" type="text"
                            placeholder="Name (e.g. T-shirt)" />
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
            <button class="btn btn-falcon-default btn-sm mt-2" type="submit"><span class="fas fa-plus fs--2 me-1"
                    data-fa-transform="up-1"></span>Add Item</button>
        </div>
    </div>
    <div class="modal lightbox-modal" id="lightbox-modal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <!-- JS content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('vendors/glightbox/glightbox.min.js') }}"></script> --}}
    <script>
        var imageGrid = document.querySelector(".image-grid");
        var links = imageGrid.querySelectorAll("a");
        var imgs = imageGrid.querySelectorAll("img");
        var lightboxModal = document.getElementById("lightbox-modal");
        var bsModal = new bootstrap.Modal(lightboxModal);
        var modalBody = document.querySelector(".modal-body .container-fluid");

        for (var link of links) {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                var currentImg = link.querySelector("img");
                var lightboxCarousel = document.getElementById("lightboxCarousel");
                if (lightboxCarousel) {
                    var parentCol = link.parentElement.parentElement;
                    var index = [...parentCol.parentElement.children].indexOf(parentCol);
                    var bsCarousel = new bootstrap.Carousel(lightboxCarousel);
                    bsCarousel.to(index);
                } else {
                    createCarousel(currentImg);
                }
                bsModal.show();
            });
        }

        function createCarousel(img) {
            var markup = `
    <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
      <div class="carousel-inner">
        ${createSlides(img)}
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
       <span class="carousel-control-prev-icon" aria-hidden="true"></span>
       <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    `;

            modalBody.innerHTML = markup;
        }

        function createSlides(img) {
            let markup = "";
            var currentImgSrc = img.getAttribute("src");

            for (var img of imgs) {
                var imgSrc = img.getAttribute("src");
                var imgAlt = img.getAttribute("alt");
                var imgCaption = img.getAttribute("data-caption");

                markup += `
    <div class="carousel-item${currentImgSrc === imgSrc ? " active" : ""}">
      <img src=${imgSrc} alt=${imgAlt}>
      ${imgCaption ? createCaption(imgCaption) : ""}
    </div>
    `;
            }

            return markup;
        }

        function createCaption(caption) {
            return `<div class="carousel-caption">
     <p class="m-0">${caption}</p>
    </div>`;
        }
    </script>
@else
    <div class="card mb-3">
        <div class="card-header bg-300">
            <h5 class="mb-0">Hasil Bacaan</h5>
        </div>
        <div class="card-body bg-light">
            <span class="badge bg-danger">Belum Melakukan Pembayaran</span>
        </div>
    </div>
@endif
