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
<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Prediksi Restok</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- INFO -->
            <div class="alert alert-info">
                Fitur ini membantu menentukan <strong>jumlah restok optimal</strong>
                berdasarkan histori penjualan dan stok saat ini.
            </div>

            <!-- FILTER PREDIKSI -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Parameter Prediksi</h3>
                </div>

                <div class="card-body">
                    <form method="GET">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Produk</label>
                                <select name="produk_id" class="form-control" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->id }}" {{ request('produk_id') == $p->id ? 'selected' : '' }}>
                                            ({{ $p->warna }} {{ $p->ukuran }}) {{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Periode Analisis</label>
                                <select name="periode" class="form-control" required>
                                    <option value="7" {{ request('periode') == 7 ? 'selected' : '' }}>7 Hari Terakhir
                                    </option>
                                    <option value="14" {{ request('periode') == 14 ? 'selected' : '' }}>14 Hari Terakhir
                                    </option>
                                    <option value="30" {{ request('periode') == 30 ? 'selected' : '' }}>30 Hari Terakhir
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Metode Prediksi</label>
                                <select class="form-control" disabled>
                                    <option>Moving Average</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-chart-line"></i> Generate Prediksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($prediksi)
                <!-- HASIL PREDIKSI -->
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">Hasil Prediksi Restok</h3>
                    </div>

                    <div class="card-body">
                        <div class="row text-center">

                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-text">Stok Saat Ini</span>
                                    <span class="info-box-number">{{ $prediksi['stok_sekarang'] }} Unit</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-text">Rata-rata Penjualan</span>
                                    <span class="info-box-number">{{ $prediksi['rata_rata'] }} Unit / Hari</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-text">Safety Stock</span>
                                    <span class="info-box-number">{{ $prediksi['safety_stock'] }} Unit</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-text">Estimasi Habis</span>
                                    <span class="info-box-number">{{ $prediksi['estimasi_habis'] }} Hari</span>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="text-center">
                            <h4 class="text-danger">
                                Rekomendasi Restok: <strong>{{ $prediksi['rekomendasi'] }} Unit</strong>
                            </h4>
                            <small>
                                (Untuk mencukupi kebutuhan {{ request('periode') ?? 7 }} hari ke depan)
                            </small>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-success btn-sm">Buat Pembelian</button>
                        <button class="btn btn-secondary btn-sm">Export Laporan</button>
                    </div>
                </div>
            @endif

        </div>
    </section>
</div>

