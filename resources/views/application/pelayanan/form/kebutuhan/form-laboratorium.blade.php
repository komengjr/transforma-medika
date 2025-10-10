<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
    <div class="col-auto navbar-vertical-label">
        <h4><span class="badge bg-primary">LABORATORIUM</span></h4>
    </div>
    <div class="col ps-0">
        <hr class="mb-0 navbar-vertical-divider">
    </div>
</div>
<div class="row mb-3">
    @if ($cat->isEmpty())
    <div class="col-12 mb-2">
        <span class="badge bg-danger">Template Belum Ada</span>
    </div>
    @else
    @endif
    @foreach ($cat as $cats)
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label text-info">{{ $cats->t_pasien_cat_data_name }}</label>
        <div class="input-group">
            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
            <input type="text" class="form-control form-control-lg border-start-0">
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label text-danger">Tanggal Pemeriksaan</label>
        <div class="input-group"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            <input type="date" name="tanggal_periksa" id="tgl_pemeriksaan"
                class="form-control form-control-lg border-start-0">
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label text-danger">Pilih Dokter Rujukan</label>

        <select name="rujukan" id="rujukan" class="form-select choices-single-jenis">
            <option value="">-</option>
            @foreach ($dokter as $dok)
            <option value="{{ $dok->master_doctor_code }}">{{ $dok->master_doctor_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label text-danger">File Rujukan</label>
        <div class="input-group"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            <input type="file" name="file" id="file"
                class="form-control form-control-lg border-start-0">
        </div>
    </div>
</div>
<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
    <div class="col-auto navbar-vertical-label">
        <h5><span class="badge bg-warning">Pemilihan Pemeriksaan</span></h5>
    </div>
    <div class="col ps-0">
        <hr class="mb-0 navbar-vertical-divider">
    </div>
</div>
<div class="row g-3 pt-0">

    <div class="col-xl-7">
        <div class="card mb-3">
            <div class="card-header bg-300">
                <div class="row flex-between-center">
                    <div class="col-sm-auto">
                        <h5 class="mb-2 mb-sm-0">Pencarian Paket</h5>
                    </div>
                    <div class="col-sm-auto">
                        <!-- <a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-plus me-2" data-fa-transform="shrink-2"></span>Add New Address </a> -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Pilih Master</label>
                        <select name="pilih_agrement_lab" class="form-control choices-single-master" id="pilih_agrement_lab">
                            <option value="">Pilih</option>
                            @foreach ($agrement as $item)
                            <option value="{{ $item->p_sales_code }}">{{ $item->p_sales_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col" id="menu-pilihan-agrement">
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-header bg-300">
                <h5 class="mb-0">Pencarian Pemeriksaan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive scrollbar" id="menu-pilihan-type-agrement">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 order-xl-1">
        <div class="card">
            <div class="card-header bg-300 btn-reveal-trigger d-flex flex-between-center">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <span id="menu-harga-pemeriksaan">
            </span>
        </div>
    </div>
</div>
<div id="menu-pilihan-poliklinik"></div>
<script>
    new window.Choices(document.querySelector(".choices-single-master"));

    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
<script>
    $('#poli').on("change", function() {
        var dataid = $("#poli option:selected").attr('data-id');
        var tgl = document.getElementById("tanggal_periksa").value;
        if (dataid == null || tgl == '') {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Layanan & Tanggal Sudah diisiss'
            });
        } else {
            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#menu-pilihan-poliklinik").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
    $('#tanggal_periksa').on("change", function() {
        $("#menu-pilihan-dokter-poli").html('');
    });
    $('#pilih_agrement_lab').on("change", function() {
        var dataid = document.getElementById("pilih_agrement_lab").value;
        console.log(dataid);

        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Layanan & Tanggal Sudah diisi'
            });
        } else {
            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_agrement') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                    "code": '{{ $code }}',
                },
                dataType: 'html',
            }).done(function(data) {
                $("#menu-pilihan-agrement").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
<script>
    $(document).on("click", "#button-fix-registrasi-lab", function(e) {
        e.preventDefault();
        var rujukan = document.getElementById("rujukan").value;
        var date = document.getElementById("tgl_pemeriksaan").value;
        var no_reg = document.getElementById("no_registrasi").value;
        var no_rm = document.getElementById("no_rm").value;
        var cat = document.getElementById("kategori").value;
        var layanan = document.getElementById("layanan").value;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-falcon-success",
                cancelButton: "btn btn-falcon-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "rujukan": rujukan,
                        "date": date,
                        "layanan": layanan,
                        "no_reg": no_reg,
                        "no_rm": no_rm,
                        "cat": cat,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    swalWithBootstrapButtons.fire({
                        title: "Registrated!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    document.getElementById("menu-fasilitas-layanan").disabled = true;
                    document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                    document.getElementById("pill-contact-tab").click();
                    document.getElementById("button-pilih-end-proses").click();
                }).fail(function() {
                    console.log('eror');
                });

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    });
</script>
