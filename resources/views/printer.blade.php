<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Cetak Zebra USB - Cloud to Local</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">🖨️ Cetak Label Pasien (Zebra USB)</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">
                            Sistem ini akan mendownload ZPL dari Server Cloud lalu mencetak langsung ke printer USB <strong>"Zebra_USB"</strong> melalui Print Agent di PC ini.
                        </p>

                        <!-- Box Status / Alert -->
                        <div id="statusAlert" class="alert d-none" role="alert"></div>

                        <div class="d-grid gap-2 mt-4">
                            <button id="btnPrint" class="btn btn-success btn-lg" onclick="processPrint()">
                                Cetak Label Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function processPrint() {
            const btn = document.getElementById('btnPrint');
            btn.disabled = true;
            btn.innerText = 'Memproses Cetak...';
            showAlert('info', 'Mengambil data ZPL dari server...');

            try {
                // STEP 1: Ambil String ZPL dari Backend Server (Laravel Cloud/VPS)
                const resCloud = await fetch("{{ route('printer.get-zpl') }}", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const dataCloud = await resCloud.json();

                if (!dataCloud.status || !dataCloud.zpl) {
                    throw new Error(dataCloud.message || 'Gagal mengambil ZPL dari server Cloud.');
                }

                showAlert('info', 'ZPL diterima. Mengirim ke printer lokal PC...');

                // STEP 2: Kirim String ZPL ke Agent Lokal yang berjalan di PC Kasir
                // Mengirim ke http://localhost:8080/print (atau port tempat agent lokal Anda aktif)
                const resLocal = await fetch('http://localhost:8080/print', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        zpl: dataCloud.zpl,
                        printer_name: 'Zebra_USB' // Sesuai nama share printer lokal Anda
                    })
                });

                const dataLocal = await resLocal.json();

                if (dataLocal.status) {
                    showAlert('success', '✅ <strong>Berhasil!</strong> ' + dataLocal.message);
                } else {
                    throw new Error(dataLocal.message || 'Agent lokal gagal mencetak.');
                }

            } catch (error) {
                console.error('Error Cetak:', error);
                showAlert('danger', '❌ <strong>Gagal:</strong> ' + error.message);
            } finally {
                btn.disabled = false;
                btn.innerText = 'Cetak Label Sekarang';
            }
        }

        function showAlert(type, message) {
            const alertBox = document.getElementById('statusAlert');
            alertBox.className = `alert alert-${type}`;
            alertBox.innerHTML = message;
            alertBox.classList.remove('d-none');
        }
    </script>
</body>

</html>
