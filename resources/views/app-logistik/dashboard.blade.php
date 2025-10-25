@extends('layouts.layouts')
@section('content')
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
        </div>
        <!--/.bg-holder-->

        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Dashboard Logistik</h3>
                    <p class="mb-0">Below you'll find answers to the questions we get <br class="d-none.d-sm-block"> asked
                        the most about to join with Falcon</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Summary Cards -->
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-center p-3 bg-primary text-white">
                <h6>Total Barang</h6>
                <h3>1,240</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-success text-white">
                <h6>Barang Masuk Bulan Ini</h6>
                <h3>520</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-warning text-dark">
                <h6>Barang Keluar Bulan Ini</h6>
                <h3>410</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-danger text-white">
                <h6>Stok Menipis</h6>
                <h3>35</h3>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card p-3">
                <h6>Grafik Barang Masuk & Keluar</h6>
                <div class="chart-container">
                    <canvas id="grafikTransaksi"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Stok Berdasarkan Kategori</h6>
                <div class="chart-container">
                    <canvas id="grafikKategori"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Ringkasan -->
    <div class="card mt-3 p-3">
        <h6>Ringkasan Stok Terbaru</h6>
        <table class="table table-striped table-hover mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>BRG001</td>
                    <td>Masker Medis</td>
                    <td>Alat Kesehatan</td>
                    <td>350</td>
                    <td>Box</td>
                </tr>
                <tr>
                    <td>BRG002</td>
                    <td>Sarung Tangan</td>
                    <td>Alat Kesehatan</td>
                    <td>220</td>
                    <td>Box</td>
                </tr>
                <tr>
                    <td>BRG003</td>
                    <td>Infus Set</td>
                    <td>Medis</td>
                    <td>180</td>
                    <td>Pcs</td>
                </tr>
                <tr>
                    <td>BRG004</td>
                    <td>Alkohol 70%</td>
                    <td>Bahan Kimia</td>
                    <td>95</td>
                    <td>Botol</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Barang Masuk & Keluar
        const ctx = document.getElementById('grafikTransaksi');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [120, 150, 180, 200, 170, 210, 250, 300, 280, 320],
                        borderColor: 'green',
                        tension: 0.3
                    },
                    {
                        label: 'Barang Keluar',
                        data: [80, 100, 150, 180, 160, 190, 220, 250, 230, 270],
                        borderColor: 'orange',
                        tension: 0.3
                    }
                ]
            }
        });

        // Grafik Pie Kategori
        const ctx2 = document.getElementById('grafikKategori');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Alat Kesehatan', 'Medis', 'Kimia', 'Lainnya'],
                datasets: [{
                    data: [45, 25, 20, 10],
                }]
            }
        });
    </script>
@endsection
