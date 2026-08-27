<div class="row g-3">
    <!-- SUB EVENT CLASS SECTION -->
    <div class="col-md-7">
        <div class="card-header bg-warning">
            <h5 class="mb-0 text-white">Sub Event Class</h5>
        </div>
        <div class="card-body bg-light">
            <div id="data-table-event-class">
                <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Event Class Name</th>
                            <th>Room</th>
                            <th>Price</th>
                            <th>Kuota</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $datas)
                        <tr>
                            <td>{{ $datas->event_data_sub_class_name }}</td>
                            <td>{{ $datas->event_data_sub_class_room }}</td>
                            <td class="text-center align-middle">
                                Rp {{ number_format($datas->event_data_sub_class_price, 0, ',', '.') }}
                            </td>
                            <td class="text-center align-middle">{{ $datas->event_data_sub_class_kuota }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-delete-class" data-id="{{ $datas->id_event_data_sub_class }}">
                                    <span class="fas fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted fs--1">Belum ada class ditambahkan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                <form action="#" id="forms-sub-event-class" method="post">
                    @csrf
                    <input type="hidden" name="code_event" id="class_code_event" value="{{ $code }}">
                    <div class="row gx-2">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label" for="nama_class">Class Name</label>
                            <input class="form-control form-control-sm" id="nama_class" name="nama_class" type="text" placeholder="e.g. Workshop VIP">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label" for="nama_room">Room Name</label>
                            <input class="form-control form-control-sm" id="nama_room" name="nama_room" type="text" placeholder="e.g. Room A">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label" for="class_price">Price</label>
                            <input class="form-control form-control-sm" id="class_price" type="number" name="class_price" placeholder="e.g. 150000">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label" for="class_kuota">Kuota</label>
                            <input class="form-control form-control-sm" id="class_kuota" type="number" name="class_kuota" placeholder="e.g. 50">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label" for="field-type">Type Class</label>
                            <select class="form-select form-select-sm" id="field-type" name="class_type">
                                <option value="default" selected>Default</option>
                                <option value="hide">Hide</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div id="button-save-event-detail">
                <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class">
                    <span class="fas fa-plus"></span> Add
                </button>
            </div>
        </div>
    </div>

    <!-- SUB EVENT SESSION SECTION -->
    <div class="col-md-5">
        <div class="card-header bg-warning">
            <h5 class="mb-0 text-white">Sub Event Session</h5>
        </div>
        <div class="card-body bg-light">
            <div id="data-table-event-session">
                <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Session Name</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($session as $sessions)
                        <tr>
                            <td>{{ $sessions->event_data_sub_session_name }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-delete-session" data-id="{{ $sessions->id_event_data_sub_session }}">
                                    <span class="fas fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted fs--1">Belum ada session ditambahkan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                <form action="#" id="form-sub-event-session" method="post">
                    @csrf
                    <input type="hidden" name="code_event" id="session_code_event" value="{{ $code }}">
                    <div class="row gx-2">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="nama_session">Session Name</label>
                            <input class="form-control form-control-sm" id="nama_session" name="nama_session" type="text" placeholder="Name (e.g. Session 1)">
                        </div>
                    </div>
                </form>
            </div>
            <div id="button-save-event-session">
                <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-session">
                    <span class="fas fa-plus"></span> Add
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // AJAX Setup Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // --- 1. PROSES ADD & DELETE SUB EVENT CLASS ---
    $(document).off("click", "#button-add-event-class").on("click", "#button-add-event-class", function(e) {
        e.preventDefault();
        var formData = $("#forms-sub-event-class").serialize();

        $('#button-save-event-detail').html('<div class="spinner-border text-primary my-2" role="status"></div>');

        $.ajax({
            url: "{{ route('menu_event_data_detail_event_saveClass') }}",
            type: "POST",
            data: formData,
            dataType: 'html',
            success: function(response) {
                if ($.trim(response) === "0") {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Mohon isi field dengan lengkap!"
                    });
                } else {
                    $('#data-table-event-class').html(response);
                    $('#nama_class, #nama_room, #class_price, #class_kuota').val('');
                }
            },
            complete: function() {
                $('#button-save-event-detail').html('<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class"><span class="fas fa-plus"></span> Add</button>');
            }
        });
    });

    $(document).off("click", ".btn-delete-class").on("click", ".btn-delete-class", function() {
        let id = $(this).data('id');
        let code = $('#class_code_event').val();

        if (confirm("Yakin ingin menghapus class ini?")) {
            $.ajax({
                url: `/event/sub-class/delete/${id}/${code}`,
                type: 'DELETE',
                dataType: 'html',
                success: function(response) {
                    $('#data-table-event-class').html(response);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Class dihapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });

    // --- 2. PROSES ADD & DELETE SUB EVENT SESSION ---
    $(document).off("click", "#button-add-event-session").on("click", "#button-add-event-session", function(e) {
        e.preventDefault();
        var formData = $("#form-sub-event-session").serialize();

        $('#button-save-event-session').html('<div class="spinner-border text-primary my-2" role="status"></div>');

        $.ajax({
            url: "{{ route('menu_event_data_detail_event_save_session') }}",
            type: "POST",
            data: formData,
            dataType: 'html',
            success: function(response) {
                if ($.trim(response) === "0") {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Mohon isi nama sesi!"
                    });
                } else {
                    $('#data-table-event-session').html(response);
                    $('#nama_session').val('');
                }
            },
            complete: function() {
                $('#button-save-event-session').html('<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-session"><span class="fas fa-plus"></span> Add</button>');
            }
        });
    });

    $(document).off("click", ".btn-delete-session").on("click", ".btn-delete-session", function() {
        let id = $(this).data('id');
        let code = $('#session_code_event').val();

        if (confirm("Yakin ingin menghapus session ini?")) {
            $.ajax({
                url: `/event/sub-session/delete/${id}/${code}`,
                type: 'DELETE',
                dataType: 'html',
                success: function(response) {
                    $('#data-table-event-session').html(response);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Session dihapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });
</script>
