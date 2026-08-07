<div class="card border border-soft-primary shadow-xs h-100">
    <!-- Header Form -->
    <div class="card-header bg-soft-primary py-2 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fs--1 fw-bold text-primary">
            <i class="fas fa-file-medical me-1"></i> Form Order Pemeriksaan Penunjang
        </h6>
        <span class="badge bg-primary fs--2">6 Item Tersedia</span>
    </div>

    <!-- Body Form -->
    <div class="card-body p-3 bg-white d-flex flex-column justify-content-between">
        <form id="form-order-penunjang-dummy">
            <!-- Label Petunjuk & Shortcut Pilih Semua -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fs--2 font-sans-serif fw-bold text-700">Pilih Item Pemeriksaan:</span>
                <button type="button" class="btn btn-link btn-sm p-0 fs--2 text-decoration-none" id="btn-select-all-dummy">
                    Pilih Semua
                </button>
            </div>

            <!-- Grid Checkbox Item Order Dummy (Scrollable Grid) -->
            <div class="row g-2 mb-3 overflow-auto" style="max-height: 200px;">
                <!-- Dummy Item 1 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="LAB001" id="chk_1">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_1">
                            Darah Lengkap (DL)
                        </label>
                    </div>
                </div>

                <!-- Dummy Item 2 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="LAB002" id="chk_2">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_2">
                            Gula Darah Sewaktu (GDS)
                        </label>
                    </div>
                </div>

                <!-- Dummy Item 3 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="LAB003" id="chk_3">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_3">
                            Fungsi Ginjal (Ureum/Kreatinin)
                        </label>
                    </div>
                </div>

                <!-- Dummy Item 4 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="RAD001" id="chk_4">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_4">
                            Foto Thorax PA
                        </label>
                    </div>
                </div>

                <!-- Dummy Item 5 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="RAD002" id="chk_5">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_5">
                            Panoramic Dental X-Ray
                        </label>
                    </div>
                </div>

                <!-- Dummy Item 6 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check border rounded p-2 ps-4 hover-bg-100 cursor-pointer h-100 d-flex align-items-center">
                        <input class="form-check-input item-checkbox-dummy me-2" type="checkbox" value="RAD003" id="chk_6">
                        <label class="form-check-label fs--2 text-800 cursor-pointer mb-0 w-100" for="chk_6">
                            Dental Periapikal Foto
                        </label>
                    </div>
                </div>
            </div>

            <!-- Input Catatan Dokter Dummy -->
            <div class="mb-2">
                <label for="catatan_dokter_dummy" class="form-label fs--2 fw-bold text-700 mb-1">Catatan Klinik / Indikasi Dokter:</label>
                <textarea class="form-control form-control-sm"
                    id="catatan_dokter_dummy"
                    rows="2"
                    placeholder="Contoh: Evaluasi kedalaman impaksi M3 bawah kanan..."></textarea>
            </div>
        </form>

        <!-- Footer / Action Buttons Dummy -->
        <div class="pt-2 border-top d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm fs--2 py-1 px-3" onclick="$('#menu-order-layanan-dokter').empty(); $('.btn-order-category').removeClass('active-order-btn');">
                Batal
            </button>
            <button type="button" class="btn btn-primary btn-sm fs--2 py-1 px-3" id="btn-submit-dummy">
                <i class="fas fa-paper-plane me-1"></i> Kirim Order
            </button>
        </div>
    </div>
</div>

<script>
    // Toggle Select All Checkbox
    let isAllSelected = false;
    $('#btn-select-all-dummy').on('click', function() {
        isAllSelected = !isAllSelected;
        $('.item-checkbox-dummy').prop('checked', isAllSelected);
        $(this).text(isAllSelected ? 'Batal Pilih Semua' : 'Pilih Semua');
    });

    // Simulasi Alert Submit
    $('#btn-submit-dummy').on('click', function(e) {
        e.preventDefault();
        var selectedCount = $('.item-checkbox-dummy:checked').length;
        if (selectedCount === 0) {
            alert('Silakan pilih minimal 1 item pemeriksaan.');
        } else {
            alert('Tampilan UI Berhasil! ' + selectedCount + ' item terpilih siap diorder.');
        }
    });
</script>
