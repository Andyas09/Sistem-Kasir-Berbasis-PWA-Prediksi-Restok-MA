@include('template.header')
@include('template.menu')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}'
});
</script>
@endif

<div class="content-wrapper" style="background-color: rgba(255, 255, 255, 1);">
  <div class="content-header py-3 shadow-sm" style="background: white;">
    <div class="container-fluid">
      <h1 class="m-0" style="color: black;">Dashboard Analisis</h1>
    </div>
  </div>

  <section class="content mt-3">
    <div class="container-fluid">

      {{-- ======================= DASHBOARD ======================= --}}
      <div class="row">

        <!-- Total Produk -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>120</h3>
              <p>Total Produk</p>
            </div>
            <div class="icon">
              <i class="fas fa-box"></i>
            </div>
          </div>
        </div>

        <!-- Stok Rendah -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>8</h3>
              <p>Produk Stok Rendah</p>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
          </div>
        </div>

        <!-- Total User -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>15</h3>
              <p>Total User</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
          </div>
        </div>

        <!-- Aktivitas Hari Ini -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>32</h3>
              <p>Aktivitas Hari Ini</p>
            </div>
            <div class="icon">
              <i class="fas fa-history"></i>
            </div>
          </div>
        </div>
      </div>


      {{-- ======================= CHART BARANG ======================= --}}
      <div class="card mt-4">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title">Grafik Stok Produk</h3>
        </div>
        <div class="card-body">
          <canvas id="stokChart" height="120"></canvas>
        </div>
      </div>


      {{-- ======================= TABEL AKTIVITAS ======================= --}}
      <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
          <h3 class="card-title">Aktivitas Pengguna Terbaru</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Adiva</th>
                <th>Aksi</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Dika</td>
                <td>Menambah Produk Baru</td>
                <td>2025-12-10 10:21</td>
              </tr>
              <tr>
                <td>Admin</td>
                <td>Update Stok Produk</td>
                <td>2025-12-10 09:44</td>
              </tr>
              <tr>
                <td>Admin</td>
                <td>Menghapus Produk</td>
                <td>2025-12-10 09:12</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>



      {{-- ======================= LAPORAN ======================= --}}
      <div class="card mt-5">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title">Laporan Manajemen Produk & Stok</h3>
        </div>

        <div class="card-body">

          {{-- FILTER TANGGAL --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Dari Tanggal</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-4">
              <label>Sampai Tanggal</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-4">
              <button class="btn btn-primary mt-4 w-100">
                <i class="fas fa-filter"></i> Filter
              </button>
            </div>
          </div>

          <hr>

          {{-- TABEL LAPORAN --}}
          <table class="table table-bordered table-hover">
            <thead class="bg-light">
              <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Stok Awal</th>
                <th>Stok Masuk</th>
                <th>Stok Keluar</th>
                <th>Stok Akhir</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Nike Shoes</td>
                <td>Sepatu</td>
                <td>50</td>
                <td>20</td>
                <td>10</td>
                <td>60</td>
              </tr>
              <tr>
                <td>Tshirt</td>
                <td>Baju</td>
                <td>100</td>
                <td>30</td>
                <td>50</td>
                <td>80</td>
              </tr>
              <tr>
                <td>Dickies Pants</td>
                <td>Celana</td>
                <td>70</td>
                <td>15</td>
                <td>25</td>
                <td>60</td>
              </tr>
            </tbody>
          </table>

          <button class="btn btn-success mt-3">
            <i class="fas fa-file-download"></i> Export PDF
          </button>

          <button class="btn btn-info mt-3">
            <i class="fas fa-print"></i> Print
          </button>

        </div>
      </div>

    </div>
  </section>
</div>


{{-- ======================= CHART.JS ======================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('stokChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Baju', 'Celana', 'Topi', 'Sepatu', 'Tas'],
      datasets: [{
        label: 'Jumlah Stok',
        data: [60, 80, 60, 30, 50],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
