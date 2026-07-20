<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Surat & Tanda Tangan Digital</title>
    <style>
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: #e9ecef;
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .letter-paper {
            background-color: white;
            width: 100%;
            max-width: 800px;
            min-height: 100vh;
            padding: 40px 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 1.6rem;
        }

        /* Form Input di Dalam Surat */
        .form-section {
            margin-bottom: 25px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
        }

        .input-group.full-width {
            grid-column: span 2;
        }

        .input-group label {
            font-weight: bold;
            margin-bottom: 5px;
            font-family: Arial, sans-serif;
            font-size: 0.9rem;
        }

        .input-group input,
        .input-group select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            font-family: 'Times New Roman', Times, serif;
            background-color: #fff;
        }

        .input-group input[readonly] {
            background-color: #e9ecef;
            color: #495057;
            cursor: not-allowed;
        }

        .content {
            font-size: 1.1rem;
            line-height: 1.6;
            text-align: justify;
            margin-top: 15px;
        }

        .date {
            text-align: right;
            margin-bottom: 20px;
        }

        /* Signature Area */
        .signature-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 30px;
        }

        .signature-box {
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        .canvas-container {
            border: 2px solid #333;
            background-color: #fff;
            margin: 10px 0;
            touch-action: none;
            border-radius: 8px;
        }

        canvas {
            width: 100%;
            height: auto;
            display: block;
            background: #fff;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: white;
        }

        .btn-clear {
            background-color: #6c757d;
        }

        .btn-save {
            background-color: #28a745;
        }

        #result-area {
            margin-top: 20px;
            width: 100%;
            display: none;
            padding: 15px;
            background: #fff;
            border: 1px solid #28a745;
            border-radius: 8px;
        }

        textarea {
            width: 100%;
            height: 80px;
            font-size: 10px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .letter-paper {
                padding: 25px 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .input-group.full-width {
                grid-column: span 1;
            }

            .signature-wrapper {
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <div class="letter-paper">
        <div class="header">
            <h1>SURAT PERMOHONAN PEMINJAMAN UANG</h1>
            <p>Formulir Digital Pengajuan Internal</p>
        </div>

        <div class="date">{{ $data->kop_master_cabang_name }}, {{ date('d - m - Y') }}</div>

        <!-- Section Input Data -->
        <div class="form-section">
            <div class="form-grid">
                <!-- Data Anggota -->
                <div class="input-group">
                    <label>Nama Lengkap Anggota</label>
                    <input type="text" id="input-nama" value="{{ $data->kop_master_peserta_name }}" readonly>
                    <input type="text" id="data-code" value="{{ $data->kop_proses_uang_code }}" hidden>
                </div>

                <div class="input-group">
                    <label>Tanggal Masuk Anggota</label>
                    <input type="text" value="" readonly>
                </div>

                <!-- Rekam Jejak Kredit -->
                <div class="input-group">
                    <label>Jumlah Histori Pinjam (Frekuensi)</label>
                    <input type="text" value="" readonly>
                </div>

                <div class="input-group">
                    <label>Sisa Pinjaman Berjalan</label>
                    <input type="text" value="" readonly>
                </div>

                <!-- Informasi Transaksi -->
                <div class="input-group">
                    <label>Nominal Pengajuan Baru (Rp)</label>
                    <input type="text" id="input-nominal" value="@currency($data->kop_proses_uang_nominal)" readonly>
                </div>

                <div class="input-group">
                    <label>Status Kelayakan / Kolektibilitas</label>
                    <input type="text" value="" readonly style="font-weight: bold;">
                </div>

                <!-- Keputusan Validasi -->
                <div class="input-group full-width">
                    <label>Keputusan Persetujuan Verifikator</label>
                    <select id="input-kebutuhan">
                        <option value="">-- Pilih Persetujuan --</option>
                        <option value="Y">Setuju</option>
                        <option value="N">Tidak Setuju</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="content">
            <p>Berdasarkan data keanggotaan di atas, yang bersangkutan telah terdaftar sebagai anggota sejak tanggal <b>20-10-2025</b> dan telah melakukan pinjaman sebanyak <b>{{ $data->kop_proses_uang_frequency ?? '0' }} kali</b>.</p>
            <p>Saya yang bertanda tangan di bawah ini selaku verifikator menyatakan bertanggung jawab penuh atas keputusan pengajuan peminjaman ini sesuai dengan aturan kelayakan internal yang berlaku pada sistem koperasi.</p>
        </div>

        <div class="signature-wrapper">
            <div class="signature-box">
                <p>Hormat Saya,</p>
                <div class="canvas-container">
                    <canvas id="signature-pad" width="300" height="150"></canvas>
                </div>

                <div class="button-group">
                    <input type="text" name="vocher_code" id="vocher_code" value="{{ $data->kop_proses_verif_code }}" hidden>
                    <button class="btn-clear" onclick="clearCanvas()">Ulangi</button>
                    <button class="btn-save" onclick="saveData()">Simpan Data</button>
                </div>
                <p><strong id="display-nama">( {{ $data->kop_user_verifikasi_name }} )</strong></p>
            </div>
        </div>

        <!-- Output Hasil -->
        <div id="result-area">
            <h4 style="margin:0; color:#28a745;">Data Berhasil Disimpan!</h4>
            <div id="data-summary" style="font-size: 0.9rem; margin-top: 10px;"></div>
            <p style="font-size: 0.8rem; margin-top: 10px;">String Tanda Tangan (Base64):</p>
            <textarea id="base64-output" readonly></textarea>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        // Inisialisasi Canvas
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        // Update Nama di bawah tanda tangan secara real-time
        document.getElementById('input-nama').addEventListener('input', function(e) {
            document.getElementById('display-nama').innerText = `( ${e.target.value || 'Nama Terang'} )`;
        });

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            let clientX = e.touches ? e.touches[0].clientX : e.clientX;
            let clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: (clientX - rect.left) * scaleX,
                y: (clientY - rect.top) * scaleY
            };
        }

        function startDrawing(e) {
            drawing = true;
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }

        function draw(e) {
            if (!drawing) return;
            e.preventDefault();
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }

        function stopDrawing() {
            drawing = false;
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('result-area').style.display = 'none';
        }

        function saveData() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Persetujuan Tanda Tangan?",
                text: "Yakin untuk melakukan penyimpanan tanda tangan digital?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Setuju",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    const nama = document.getElementById('input-nama').value;
                    const nominal = document.getElementById('input-nominal').value;
                    const kebutuhan = document.getElementById('input-kebutuhan').value;
                    const vocher = document.getElementById('vocher_code').value;
                    const proses_code = document.getElementById('data-code').value;

                    // Validasi Form
                    if (!nama || !nominal || !kebutuhan) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Pastikan Keputusan Persetujuan Sudah Terisi!"
                        });
                        return;
                    }

                    // Validasi Tanda Tangan
                    const blank = document.createElement('canvas');
                    blank.width = canvas.width;
                    blank.height = canvas.height;
                    if (canvas.toDataURL() === blank.toDataURL()) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Pastikan Tanda Tangan Sudah Terisi!"
                        });
                        return;
                    }

                    const base64String = canvas.toDataURL('image/png');

                    // Tampilkan Hasil
                    document.getElementById('data-summary').innerHTML = `
                        <b>Nama:</b> ${nama}<br>
                        <b>Nominal Pengajuan:</b> ${nominal}<br>
                        <b>Persetujuan:</b> ${kebutuhan === 'Y' ? 'Setuju' : 'Tidak Setuju'}`;
                    document.getElementById('base64-output').value = base64String;
                    document.getElementById('result-area').style.display = 'block';

                    $.ajax({
                        url: "{{ route('data_peminjaman_uang_sign') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": vocher,
                            "persetujuan": kebutuhan,
                            "proses": proses_code,
                            "sign": base64String,
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        if (data == 1) {
                            Swal.fire('Berhasil!', 'Tanda Tangan telah disimpan.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', 'Gagal memproses tanda tangan.', 'error');
                        }
                    }).fail(function() {
                        Swal.fire('Gagal!', 'Koneksi ke server terputus.', 'error');
                    });

                    // Scroll otomatis ke hasil
                    document.getElementById('result-area').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        }
    </script>
</body>

</html>
