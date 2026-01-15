@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Riwayat Stok</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- FILTER -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Filter Riwayat Stok</h3>
                </div>

                <div class="card-body">
                    <form method="GET">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Produk</label>
                                <select name="produk_id" class="form-control">
                                    <option value="">Semua Produk</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->id }}" {{ request('produk_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Jenis Transaksi</label>
                                <select class="form-control">
                                    <option>Semua</option>
                                    <option>Stok Masuk</option>
                                    <option>Stok Keluar</option>
                                    <option>Penyesuaian</option>
                                    <option>Stok Opname</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary btn-block">
                                    <i class="fas fa-filter"></i> Terapkan Filter
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- TABEL RIWAYAT -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Log Riwayat Stok</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Qty</th>
                                <th>Stok Awal</th>
                                <th>Stok Akhir</th>
                                <th>Keterangan</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                                <tr>
                                    <td>{{ $r['tanggal']->format('d/m/Y H:i') }}</td>
                                    <td>{{ $r['produk']->nama_produk }} {{ $r['produk']->warna }} {{ $r['produk']->ukuran }}
                                    </td>
                                    <td>{{ $r['produk']->kategori->nama_kategori }}</td>
                                    <td>
                                        <span class="badge {{ $r['jenis'] == 'masuk' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($r['jenis']) }}
                                        </span>
                                    </td>
                                    <td>{{ $r['qty'] }}</td>
                                    <td>{{ $r['stok_awal'] }}</td>
                                    <td>{{ $r['stok_akhir'] }}</td>
                                    <td>{{ $r['keterangan'] }}</td>
                                    <td>{{ $r['user'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('stok.masuk.exportE', parameters: request()->query()) }}" class="btn btn-success">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('stok.masuk.exportP', request()->query()) }}" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>