@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Registrasi <span class="text-success fw-medium">Peserta</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3 border border-success">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Form Pendaftaran Kepesertaan Anggota Koperasi</h5>
                <p class="mb-0 mt-2 mb-0">Selamat Datang di aplikasi Koperasi Simpan Pinjam</p>
            </div>
            <div class="col-auto ms-auto">
                <button class="btn btn-primary btn-sm" type="button"><span class="fas fa-search"></span> Cari Data</button>
            </div>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="tab-content">
            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-f1d388f8-6223-48cd-b720-917f0290eedd" id="dom-f1d388f8-6223-48cd-b720-917f0290eedd">
                <form class="row g-3 pb-3" id="form-peserta-registrasi" method="POST">
                    @csrf
                    <div class="col-md-2 d-flex justify-content-center">
                        <div class="avatar avatar-5xl shadow-sm img-thumbnail rounded-circle justify-content-center">
                            <div class="h-100 w-100 rounded-circle overflow-hidden">
                                <img src="{{ asset('asset/img/team/avatar.png') }}" width="200" alt="" id="videoPreview"
                                    data-dz-thumbnail="data-dz-thumbnail">
                                <input class="d-none" id="profile-image" type="file">
                                <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                                    <span class="bg-holder overlay overlay-0"></span>
                                    <span class="z-index-1 text-white dark__text-white text-center fs--1">
                                        <span class="d-block">Upload</span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">Nama Lengkap</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-user-friends"></i></span>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg border-start-0"
                                        id="nama_lengkap" placeholder="Ex. Jhon Doe">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">Jenis Kelamin</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-transgender fs-2"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control-lg single-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="l">Laki Laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-money-check"></i></span>
                                    <input type="text" name="nik" class="form-control form-control-lg border-start-0" id="nik"
                                        placeholder="*12 Digit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">NIP</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-money-check"></i></span>
                                    <input type="text" name="nip" class="form-control form-control-lg border-start-0" id="nik"
                                        placeholder="*12 Digit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Tanggal Lahir</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                            <input type="date" name="tgl_lahir" class="form-control form-control-lg border-start-0" id="tgl_lahir"
                                placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            <input type="text" name="tempat_lahir" class="form-control form-control-lg border-start-0"
                                id="inputLastName1" placeholder="Ex. Pontianak">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray"></i></span>
                            <select name="agama" id="agama" class="form-control form-control-lg single-select">
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                            <input type="text" name="no_hp" class="form-control form-control-lg border-start-0" id="no_hp"
                                placeholder="Ex. 08982839182xxx">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName2" class="form-label">Email</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                            <input type="email" name="email" class="form-control form-control-lg border-start-0" id="inputLastName2" placeholder="Ex. Contoh@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Pilih Cabang</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <select name="cabang" id="" class="form-control form-control-lg single-select">
                                <option value="">Pilih Cabang</option>
                                @foreach ($cabang as $cab)
                                <option value="{{ $cab->kop_master_cabang_code }}">{{ $cab->kop_master_cabang_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Pilih Divisi / Departemen</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <select name="divisi" id="divisi" class="form-control form-control-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($divisi as $div)
                                <option value="{{ $div->kop_master_div_bag_code }}">{{ $div->kop_master_divisi_name }} - {{ $div->kop_master_div_bag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName2" class="form-label">Tanggal Masuk Kerja</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                            <input type="date" name="tgl_masuk" class="form-control form-control-lg border-start-0">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
                        <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Enter Address"
                            rows="3"></textarea>
                    </div>
                    <input id="link" type="text" name="link" class="form-control" hidden>
                    <div class="col-md-4">
                        <label class="form-label" for="event-type">Pilih Simpanan Pokok</label>
                        <div class="input-group"> <span class="input-group-text"><i class="far fa-file-archive"></i></span>
                            <select name="simpanan_pokok" id="" class="form-control form-control-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($pokok as $pok)
                                <option value="{{ $pok->kop_simpanan_pokok_code }}">{{ $pok->kop_simpanan_pokok_name }}, @currency($pok->kop_simpanan_pokok_nominal)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="event-type">Pilih Simpanan Wajib</label>
                        <div class="input-group"> <span class="input-group-text"><i class="far fa-file-archive"></i></span>
                            <select name="simpanan_wajib" id="" class="form-control form-control-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($wajib as $jib)
                                    <option value="{{ $jib->kop_simpanan_wajib_code }}">{{ $jib->kop_simpanan_wajib_name }}, @currency($jib->kop_simpanan_wajib_nominal)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="event-type">Pilih Simpanan Sukarela</label>
                        <div class="input-group"> <span class="input-group-text"><i class="far fa-file-archive"></i></span>
                            <select name="simpanan_sukarela" id="simpanan_sukarela" class="form-control form-control-lg single-select">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 pt-3">
                        <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60">
                            <div class="flex-1">
                                <h5 class="mb-2">Proteksi Keanggotaan</h5>
                                <div class="form-check mb-0">
                                    <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked">
                                    <label class="form-check-label mb-0" for="protection-option-1"> <strong>Full Refund </strong>If you don't <br class="d-none d-md-block d-lg-none">receive your order</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked">
                                    <label class="form-check-label mb-0" for="protection-option-2"> <strong>Full or Partial Refund, </strong>If the product is not as described in details</label>
                                </div><a class="fs--1 ms-3 ps-2" href="#!">Learn More<svg class="svg-inline--fa fa-caret-right fa-w-6 ms-1" data-fa-transform="down-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.625em;">
                                        <g transform="translate(96 256)">
                                            <g transform="translate(0, 64)  scale(1, 1)  rotate(0 0 0)">
                                                <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                            </g>
                                        </g>
                                    </svg><!-- <span class="fas fa-caret-right ms-1" data-fa-transform="down-2">    </span> Font Awesome fontawesome.com --></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-footer" id="menu-footer-registrasi">
        <button class="btn btn-primary btn-sm float-end" id="button-simpan-data-registrasi"><span class="fas fa-save"></span> Simpan Data</button>
    </div>
</div>

@endsection
@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-penjualan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-penjualan"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-simpan-data-registrasi", function(e) {
        e.preventDefault();
        var data = $("#form-peserta-registrasi").serialize();
        $('#menu-footer-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_registrasi_peserta_add') }}",
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
                $('#menu-footer-registrasi').html('<button class="btn btn-success float-end" id="button-simpan-data-peserta" data-code="">Simpan Data</button>');
            } else {
                Swal.fire({
                    title: "Berhasil Registrasi Kepesertaan Koperasi",
                    icon: "success",
                    html: `
                        You can use <b>bold text</b>,
                        <a href="#" autofocus>links</a>,
                        and other HTML tags
                    `,
                    allowOutsideClick: false,
                    confirmButtonText: "Oke",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire("Saved!", "", "success");
                        location.reload();
                    }
                });
                // $('#menu-footer-registrasi').html(data);
            }
        }).fail(function() {
            $('#menu-footer-registrasi').html('eror');
        });
    });
</script>

@endsection
