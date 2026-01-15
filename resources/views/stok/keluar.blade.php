@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Data Stok Keluar</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- ================= FILTER & SEARCH ================= -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">Filter & Pencarian</h3>
                </div>
                <div class="card-body">
                    <form method="GET">
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="keyword" class="form-control"
                                    placeholder="Nama Produk / Penerima" value="{{ request('keyword') }}">
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="alasan" class="form-control">
                                    <option value="">-- Semua Alasan --</option>
                                    <option value="Penjualan" {{ request('alasan') == 'Penjualan' ? 'selected' : '' }}>
                                        Penjualan</option>
                                    <option value="Retur" {{ request('alasan') == 'Retur' ? 'selected' : '' }}>Retur</option>
                                    <option value="Rusak" {{ request('alasan') == 'Rusak' ? 'selected' : '' }}>Barang Rusak
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary">Filter</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- ================= DATA TABLE ================= -->
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between">
                    <h3 class="card-title mb-0">Riwayat Stok Keluar</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Penanggung Jawab</th>
                                <th>Produk</th>
                                <th>Variasi/Ukuran</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Saldo Stok</th>
                                <th>Alasan</th>
                                <th>Penerima/Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stok_keluar as $sk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sk->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $sk->created_at->format('H:i') }}</td>
                                    <td>{{ $sk->user->nama }}</td>
                                    <td>{{ $sk->produk->nama_produk }}</td>
                                    <td>{{ $sk->produk->warna }} ({{ $sk->produk->ukuran }})</td>
                                    <td>{{ $sk->jumlah }}</td>
                                    <td>{{ $sk->satuan }}</td>
                                    <td>{{ $sk->produk->stok }}</td>
                                    <td>{{ $sk->alasan }}</td>
                                    <td>{{ $sk->supplier->nama_supplier ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalTambah">
                        Tambah Stok Keluar
                    </button>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('stok.keluar.excelE', request()->query()) }}" class="btn btn-success">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('stok.keluar.exportP', request()->query()) }}" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </a>
                </div>
                <div class="modal fade" id="modalTambah" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Tambah Stok Keluar</h5>
                                <button class="close text-white" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="{{ route('stok.store-keluar') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Produk</label>
                                            <select name="produk_id" class="form-control" required>
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach($produk as $p)
                                                    <option value="{{ $p->id }}">
                                                        ({{ $p->warna }} {{ $p->ukuran }}) {{ $p->nama_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Qty Keluar</label>
                                            <input type="number" name="jumlah" class="form-control hitung" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Satuan</label>
                                            <select name="satuan" class="form-control" required>
                                                <option value="">-- Pilih Satuan --</option>
                                                <option value="PCS">PCS</option>
                                                <option value="BOX">BOX</option>
                                            </select>
                                            <label>Alasan</label>
                                            <select name="alasan" id="alasan" class="form-control" required>
                                                <option value="">-- Pilih Alasan --</option>
                                                <option value="Retur">Retur</option>
                                                <option value="Rusak">Rusak</option>
                                            </select>

                                            <div id="supplier-wrapper" style="display:none; margin-top:10px;">
                                                <label>Supplier</label>
                                                <select name="supplier_id" class="form-control" required>
                                                    <option value="">-- Pilih Supplier --</option>
                                                    @foreach($supplier as $s)
                                                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-success">Simpan</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<script>
    document.getElementById('alasan').addEventListener('change', function () {
        const supplierWrapper = document.getElementById('supplier-wrapper');

        if (this.value === 'Rusak') {
            supplierWrapper.style.display = 'block';
        } else {
            supplierWrapper.style.display = 'none';
        }
    });
</script>