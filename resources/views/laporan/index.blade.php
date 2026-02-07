@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Laporan</h1>
                </div>
                <div class="col-sm-6 text-right">
                        <a href="{{ route('stok.masuk.exportE', parameters: request()->query()) }}" class="btn btn-success">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </a>
                    </div>
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- FILTER LAPORAN -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Filter Laporan</h3>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.index') }}">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Dari Tanggal</label>
                                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Sampai Tanggal</label>
                                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Jenis Laporan</label>
                                <select name="jenis" class="form-control">
                                    <option value="">-- Semua --</option>
                                    <option value="penjualan" {{ request('jenis') == 'penjualan' ? 'selected' : '' }}>
                                        Penjualan</option>
                                    <option value="stok_masuk" {{ request('jenis') == 'stok_masuk' ? 'selected' : '' }}>
                                        Stok
                                        Masuk</option>
                                    <option value="stok_keluar" {{ request('jenis') == 'stok_keluar' ? 'selected' : '' }}>
                                        Stok
                                        Keluar</option>
                                    <option value="opname" {{ request('jenis') == 'opname' ? 'selected' : '' }}>Stok
                                        Opname
                                    </option>
                                    <option value="prediksi" {{ request('jenis') == 'prediksi' ? 'selected' : '' }}>
                                        Prediksi
                                        Restok</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            <!-- RINGKASAN -->
            <div class="row mt-3">

                <div class="col-md-3 col-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-success">
                            <i class="fas fa-receipt"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Transaksi</span>
                            <span class="info-box-number">{{ $ringkasan['total_transaksi'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Omzet</span>
                            <span class="info-box-number">
                                Rp {{ number_format($ringkasan['total_omzet'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-warning">
                            <i class="fas fa-arrow-down"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barang Masuk</span>
                            <span class="info-box-number">
                                {{ $ringkasan['barang_masuk'] }} <small>Unit</small>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-danger">
                            <i class="fas fa-arrow-up"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barang Keluar</span>
                            <span class="info-box-number">
                                {{ $ringkasan['barang_keluar'] }} <small>Unit</small>
                            </span>
                        </div>
                    </div>
                </div>

            </div>


            <!-- TABEL LAPORAN -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Detail Laporan</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $row)
                                <tr>
                                    <td>{{ $row['tanggal'] }}</td>
                                    <td>{{ $row['keterangan'] }}</td>
                                    <td>{{ $row['produk'] }}</td>
                                    <td>{{ $row['qty'] }}</td>
                                    <td>Rp {{ number_format($row['total'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>