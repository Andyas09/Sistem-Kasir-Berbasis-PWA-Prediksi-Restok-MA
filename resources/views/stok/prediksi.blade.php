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
                <div class="card-header text-white" style="background-color: #000B49;">
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
                        <style>
                            .prediction-card {
                                border-radius: 12px;
                                border: none;
                                transition: all 0.3s ease;
                                background: #fff;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                            }
                            .prediction-card:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 8px 15px rgba(0,0,0,0.1);
                            }
                            .prediction-icon {
                                width: 50px;
                                height: 50px;
                                border-radius: 10px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 24px;
                                margin-bottom: 15px;
                            }
                            .bg-soft-blue { background: #eef2ff; color: #4338ca; }
                            .bg-soft-green { background: #ecfdf5; color: #047857; }
                            .bg-soft-orange { background: #fff7ed; color: #c2410c; }
                            .bg-soft-red { background: #fef2f2; color: #b91c1c; }
                            
                            .metric-value {
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: #1e293b;
                            }
                            .metric-label {
                                color: #64748b;
                                font-size: 0.875rem;
                                text-transform: uppercase;
                                letter-spacing: 0.025em;
                                font-weight: 600;
                            }
                            .recommendation-banner {
                                background: linear-gradient(135deg, #000B49 0%, #001a6e 100%);
                                border-radius: 15px;
                                padding: 25px;
                                color: white;
                                overflow: hidden;
                                position: relative;
                            }
                            .recommendation-banner::after {
                                content: '\f201';
                                font-family: 'Font Awesome 5 Free';
                                font-weight: 900;
                                position: absolute;
                                right: -20px;
                                bottom: -20px;
                                font-size: 120px;
                                opacity: 0.1;
                            }
                        </style>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <div class="card prediction-card h-100 p-3">
                                    <div class="prediction-icon bg-soft-blue">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <span class="metric-label">Stok Saat Ini</span>
                                    <span class="metric-value">{{ $prediksi['stok_sekarang'] }} <small>Unit</small></span>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="card prediction-card h-100 p-3">
                                    <div class="prediction-icon bg-soft-green">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <span class="metric-label">Rata-rata Penjualan</span>
                                    <span class="metric-value">{{ $prediksi['rata_rata'] }} <small>Unit / Hari</small></span>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="card prediction-card h-100 p-3">
                                    <div class="prediction-icon bg-soft-orange">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <span class="metric-label">Safety Stock</span>
                                    <span class="metric-value">{{ $prediksi['safety_stock'] }} <small>Unit</small></span>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="card prediction-card h-100 p-3">
                                    <div class="prediction-icon bg-soft-red">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                    <span class="metric-label">Estimasi Habis</span>
                                    <span class="metric-value">{{ $prediksi['estimasi_habis'] }} <small>Hari</small></span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 recommendation-banner text-center shadow-lg">
                            <h5 class="text-uppercase mb-2" style="letter-spacing: 2px; opacity: 0.8;">Rekomendasi Restok</h5>
                            <h2 class="display-4 font-weight-bold mb-0">
                                {{ $prediksi['rekomendasi'] }} <span style="font-size: 1.5rem">Unit</span>
                            </h2>
                            <p class="mb-0 mt-2" style="opacity: 0.9;">
                                <i class="fas fa-info-circle mr-1"></i>
                                Untuk mencukupi kebutuhan {{ request('periode') ?? 7 }} hari ke depan
                            </p>
                        </div>

                    </div>

                    <div class="card-footer bg-white border-top-0 d-flex justify-content-end pb-4 pr-4">
                        <button class="btn btn-secondary btn-sm mr-2 shadow-sm">
                            <i class="fas fa-file-export mr-1"></i> Export Laporan
                        </button>
                        <button class="btn btn-primary shadow-sm" style="background-color: #000B49; border: none;">
                            <i class="fas fa-plus-circle mr-1"></i> Buat Pembelian
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </section>
</div>

