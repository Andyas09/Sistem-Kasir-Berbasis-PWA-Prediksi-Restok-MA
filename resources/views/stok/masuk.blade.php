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
            <h1>Data Stok Masuk</h1>
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
                                    placeholder="Nama Produk / SKU / Supplier" value="{{ request('keyword') }}">
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="supplier" class="form-control">
                                    <option value="">-- Semua Supplier --</option>
                                    @foreach($supplier as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
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
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">Riwayat Stok Masuk</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>SKU</th>
                                <th>Penerima</th>
                                <th>Supplier</th>
                                <th>Produk</th>
                                <th>Variasi/Ukuran</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Saldo Stok</th>
                                <th>Harga Beli</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Catatan</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stok_masuk as $sm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sm->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $sm->created_at->format('H:i') }}</td>
                                    <td>{{ $sm->sku }}</td>
                                    <td>{{ $sm->user->nama }}</td>
                                    <td>{{ $sm->supplier->nama_supplier }}</td>
                                    <td>{{ $sm->produk->nama_produk }}</td>
                                    <td>{{ $sm->produk->warna }} ({{ $sm->produk->ukuran }})</td>
                                    <td>{{ $sm->satuan }}</td>
                                    <td>{{ $sm->jumlah }}</td>
                                    <td>{{ $sm->produk->stok }}</td>
                                    <td>Rp {{ number_format($sm->harga_beli) }}</td>
                                    <td>Rp {{ number_format($sm->diskon) }}</td>
                                    <td>Rp {{ number_format($sm->harga_beli) }}</td>
                                    <td>{{ $sm->catatan }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="#" onclick="return confirm('Hapus data ini?')"
                                                class="btn btn-danger btn-sm">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modalTambah">
                        Tambah Stok Masuk
                    </button>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('stok.masuk.exportE', parameters: request()->query()) }}" class="btn btn-success">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('stok.masuk.exportP', request()->query()) }}" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </a>
                </div>
                <div class="modal fade" id="modalTambah" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Tambah Stok Masuk</h5>
                                <button class="close text-white" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="{{ route('stok.store') }}" method="POST">
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

                                        <div class="col-md-6">
                                            <label>Supplier</label>
                                            <select name="supplier_id" class="form-control" required>
                                                <option value="">-- Pilih Supplier --</option>
                                                @foreach($supplier as $s)
                                                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label>Qty Masuk</label>
                                            <input type="number" name="jumlah" class="form-control hitung" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Satuan</label>
                                            <select name="satuan" class="form-control" required>
                                                <option value="">-- Pilih Satuan --</option>
                                                <option value="PCS">PCS</option>
                                                <option value="BOX">BOX</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label>Harga Beli</label>
                                            <input type="number" name="harga_beli" class="form-control hitung" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Diskon</label>
                                            <input type="number" name="diskon" class="form-control hitung" value="0">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Total</label>
                                            <input type="number" name="total" id="total" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label>Catatan</label>
                                            <textarea class="form-control" name="catatan" required></textarea>
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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<!-- ================= MODAL TAMBAH STOK ================= -->


{{-- Script hitung total --}}
<script>
    document.addEventListener('input', function () {
        let qty = document.querySelector('input[name="jumlah"]').value || 0;
        let harga = document.querySelector('input[name="harga_beli"]').value || 0;
        let diskon = document.querySelector('input[name="diskon"]').value || 0;

        let total = (qty * harga) - diskon;
        document.getElementById('total').value = total > 0 ? total : 0;
    });
</script>