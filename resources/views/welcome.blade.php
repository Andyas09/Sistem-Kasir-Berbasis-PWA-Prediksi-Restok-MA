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
              <h3>{{ $totalProduk }}</h3>
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
              <h3>{{ $stokRendah }}</h3>
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
              <h3>{{ $totalUser }}</h3>
              <p>Total User</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
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

    </div>
  </section>
</div>


{{-- ======================= CHART.JS ======================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('stokChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($produk->pluck('nama_produk')) !!},
      datasets: [{
        label: 'Jumlah Stok',
        data: {!! json_encode($produk->pluck('stok')) !!},
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
