<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
    <div class="col-auto navbar-vertical-label">
        <h4><span class="badge bg-warning">POLIKLINIK</span></h4>
    </div>
    <div class="col ps-0">
        <hr class="mb-0 navbar-vertical-divider">
    </div>
</div>

<div class="row g-3">
    <!-- 1. Pilihan Tanggal Periksa -->
    <div class="col-md-4">
        <label for="tanggal_periksa" class="form-label text-success fw-bold">Tanggal Periksa</label>
        <div class="input-group">
            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control form-control-lg border-start-0" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    <!-- 2. Pilihan Poliklinik -->
    <div class="col-md-4">
        <label for="poli" class="form-label text-success fw-bold">Pilih Poli</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-hospital-user"></i></span>
            <select name="poli" id="poli" class="form-select form-select-lg single-select">
                <option value="">-- Pilih Poli --</option>
                @foreach($poli as $p)
                <option value="{{ $p->m_poli_code }}" data-id="{{ $p->id_m_poli }}">{{ $p->m_poli_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- 3. Pilihan Dokter (Dinamis dari AJAX) -->
    <div class="col-md-4">
        <label for="doctor" class="form-label text-success fw-bold">Pilih Dokter</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
            <select name="doctor" id="doctor" class="form-select form-select-lg single-select" disabled>
                <option value="">-- Pilih Dokter --</option>
            </select>
        </div>
    </div>
</div>

<input id="link_penunjang" type="text" name="link_penunjang" class="form-control" hidden>
<input id="id_schedule" type="hidden" name="id_schedule">

<!-- Area untuk menampilkan Kuota & Jam Praktik Dokter -->
<div id="menu-pilihan-poliklinik" class="mt-4"></div>

<script>
    $(document).ready(function() {

        // Helper Toast / Notification
        function showWarning(msg) {
            if (typeof Lobibox !== 'undefined') {
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: msg
                });
            } else {
                alert(msg);
            }
        }

        // Reset dropdown dokter dan detail kuota
        function resetDokterAndSchedule() {
            $('#doctor').html('<option value="">-- Pilih Dokter --</option>').prop('disabled', true);
            $('#menu-pilihan-poliklinik').html('');
            $('#id_schedule').val('');
        }

        // Event 1: Ketika Tanggal atau Poli Berubah -> Fetch daftar dokter
        $('#tanggal_periksa, #poli').on("change", function() {
            var poliCode = $("#poli").val();
            var tgl = $("#tanggal_periksa").val();

            if (!poliCode) {
                resetDokterAndSchedule();
                return;
            }

            if (!tgl) {
                showWarning('Harap isi Tanggal Periksa terlebih dahulu.');
                resetDokterAndSchedule();
                return;
            }

            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "m_poli_code": poliCode,
                    "tanggal_periksa": tgl
                },
                dataType: 'json',
                success: function(response) {
                    $('#doctor').html('<option value="">-- Pilih Dokter --</option>');
                    $('#menu-pilihan-poliklinik').html('');
                    $('#id_schedule').val('');

                    if (response.status && response.doctors.length > 0) {
                        $.each(response.doctors, function(key, doc) {
                            var titleF = doc.master_doctor_title_f ? doc.master_doctor_title_f + ' ' : '';
                            var titleE = doc.master_doctor_title_e ? ', ' + doc.master_doctor_title_e : '';
                            var fullName = titleF + doc.master_doctor_name + titleE;

                            $('#doctor').append('<option value="' + doc.master_doctor_code + '">' + fullName + '</option>');
                        });
                        $('#doctor').prop('disabled', false);
                    } else {
                        $('#doctor').prop('disabled', true);
                        showWarning(response.message || 'Tidak ada jadwal dokter aktif pada hari/tanggal ini.');
                    }
                },
                error: function() {
                    showWarning('Gagal mengambil data dokter.');
                }
            });
        });

        // Event 2: Ketika Dokter Dipilih -> Fetch Info Kuota & Jam Kerja
        $('#doctor').on("change", function() {
            var doctorCode = $(this).val();
            var poliCode = $("#poli").val();
            var tgl = $("#tanggal_periksa").val();

            if (!doctorCode) {
                $('#menu-pilihan-poliklinik').html('');
                $('#id_schedule').val('');
                return;
            }

            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_get_dokter_quota') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "m_poli_code": poliCode,
                    "master_doctor_code": doctorCode,
                    "tanggal_periksa": tgl
                },
                dataType: 'html',
                success: function(data) {
                    $("#menu-pilihan-poliklinik").html(data);
                },
                error: function() {
                    showWarning('Gagal mengambil kuota jadwal dokter.');
                }
            });
        });

    });
</script>
