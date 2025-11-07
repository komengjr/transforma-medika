<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">Pasien Details</h5>
            <button class="btn btn-falcon-primary">Skip</button>
        </div>
    </div>
    <div class="card-body bg-light" id="menu-proses-specimen-collection">
        <form>
            <div class="row g-3">
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="avatar avatar-5lg shadow-sm justify-content-center">
                        <div class="h-100 w-100 overflow-hidden ">
                            @if ($data->master_patient_profile == "")
                                <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                                    data-dz-thumbnail="data-dz-thumbnail">
                            @else
                                <img src="{{ Storage::url($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                    id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                            @endif
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
                        <input type="date" name="tgl_lahir" class="form-control form-control-lg bg-white border-start-0"
                            id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Jenis
                        Kelamin</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-transgender fs-2"></i></span>
                        <input type="text" class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
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


            </div>
        </form>
        <div class="table-responsive scrollbar mt-4 fs--1">
            <table class="table table-striped border">
                <thead class="light">
                    <tr class="bg-primary text-white dark__bg-1000">
                        <th class="border-0">Jenis Sample</th>

                        <th class="border-0 text-end">Specimen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">{{$pem->t_pemeriksaan_list_name}}</h6>
                                @php
                                    $specimen = DB::table('t_pem_specimen')
                                        ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
                                        ->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)->get();
                                    $no = 1;
                                @endphp
                            </td>
                            <td class="align-middle text-end">
                                @foreach ($specimen as $spec)
                                    @php
                                        $log = DB::table('s_specimen_log')->where('t_pem_specimen_code', $spec->t_pem_specimen_code)->where('d_reg_order_list_code', $code)->first();
                                    @endphp
                                    @if ($log)
                                        <span id="menudata{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}">
                                            @if ($log->s_specimen_log_status == 0)
                                                <button class="btn btn-falcon-warning btn-sm"
                                                    id="button-simpan-specimen{{$pem->id_t_pemeriksaan_list}}{{ $spec->t_pem_specimen_code  }}"
                                                    data-code="{{$pem->id_t_pemeriksaan_list}}"
                                                    data-specimen="{{ $spec->t_pem_specimen_code }}"
                                                    data-reg="{{ $code }}">{{ $log->s_specimen_log_time }}</button>
                                            @else
                                                <button class="btn btn-falcon-success btn-sm" id="" data-code="132">Selesai</button>
                                            @endif
                                        </span>
                                    @else
                                        <span id="menudata{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}">
                                            <button class="btn btn-falcon-danger btn-sm"
                                                id="button-collection-specimen{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}"
                                                data-code="{{$pem->id_t_pemeriksaan_list}}"
                                                data-specimen="{{ $spec->t_pem_specimen_code }}"
                                                data-reg="{{ $code }}">{{ $spec->s_specimen_data_name }}</button>
                                        </span>
                                    @endif
                                    <script>
                                        $(document).on("click", "#button-collection-specimen{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}", function (e) {
                                            e.preventDefault();
                                            var code = $(this).data("code");
                                            var specimen = $(this).data("specimen");
                                            var reg = $(this).data("reg");
                                            console.log(specimen);

                                            const swalWithBootstrapButtons = Swal.mixin({
                                                customClass: {
                                                    confirmButton: "btn btn-falcon-success",
                                                    cancelButton: "btn btn-falcon-danger"
                                                },
                                                buttonsStyling: true
                                            });
                                            swalWithBootstrapButtons.fire({
                                                title: "Are you sure?",
                                                text: "You want be prosess this!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonText: "Yes, proses it!",
                                                cancelButtonText: "No, cancel!",
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: "{{ route('data_specimen_collection_lab_proses') }}",
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            "code": code,
                                                            "specimen": specimen,
                                                            "reg": reg,
                                                        },
                                                        dataType: 'html',
                                                    }).done(function (data) {
                                                        $('#menudata{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}').html(data);
                                                        const Toast = Swal.mixin({
                                                            toast: true,
                                                            position: "top-end",
                                                            showConfirmButton: false,
                                                            timer: 3000,
                                                            timerProgressBar: true,
                                                            didOpen: (toast) => {
                                                                toast.onmouseenter = Swal.stopTimer;
                                                                toast.onmouseleave = Swal.resumeTimer;
                                                            }
                                                        });
                                                        Toast.fire({
                                                            icon: "success",
                                                            title: "Prosess Speciment"
                                                        });
                                                    }).fail(function () {
                                                        swalWithBootstrapButtons.fire({
                                                            title: "Failed",
                                                            text: "Your Proses Has been Failed:)",
                                                            icon: "error"
                                                        });
                                                    })

                                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                    swalWithBootstrapButtons.fire({
                                                        title: "Cancelled",
                                                        text: "Your imaginary file is safe :)",
                                                        icon: "error"
                                                    });
                                                }
                                            });
                                        });
                                        $(document).on("click", "#button-simpan-specimen{{$pem->id_t_pemeriksaan_list}}{{ $spec->t_pem_specimen_code  }}", function (e) {
                                            e.preventDefault();
                                            var code = $(this).data("code");
                                            var specimen = $(this).data("specimen");
                                            var reg = $(this).data("reg");
                                            const swalWithBootstrapButtons = Swal.mixin({
                                                customClass: {
                                                    confirmButton: "btn btn-falcon-success",
                                                    cancelButton: "btn btn-falcon-danger"
                                                },
                                                buttonsStyling: true
                                            });
                                            swalWithBootstrapButtons.fire({
                                                title: "Are you sure?",
                                                text: "You want be prosess this!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonText: "Yes, proses it!",
                                                cancelButtonText: "No, cancel!",
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: "{{ route('data_specimen_collection_lab_proses_simpan') }}",
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            "code": code,
                                                            "specimen": specimen,
                                                            "reg": reg,
                                                        },
                                                        dataType: 'html',
                                                    }).done(function (data) {
                                                        swalWithBootstrapButtons.fire({
                                                            title: "Success!",
                                                            text: "Your prosess is running.",
                                                            icon: "success"
                                                        });
                                                        $('#menudata{{$pem->id_t_pemeriksaan_list}}{{ $spec->id_s_specimen_data  }}').html(data);
                                                    }).fail(function () {
                                                        swalWithBootstrapButtons.fire({
                                                            title: "Failed",
                                                            text: "Your Proses Has been Failed:)",
                                                            icon: "error"
                                                        });
                                                    })

                                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                    swalWithBootstrapButtons.fire({
                                                        title: "Cancelled",
                                                        text: "Your imaginary file is safe :)",
                                                        icon: "error"
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                @endforeach
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
        <button class="btn btn-falcon-primary btn-sm" id="button-simpan-proses-specimen-collection"
            data-code="{{ $code }}">Simpan</button>
    </div>
</div>
