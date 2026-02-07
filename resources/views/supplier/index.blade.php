@include('template.header')
@include('template.menu')
<style>
    .ukuran-box {
        border: 2px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 18px;
        cursor: pointer;
        font-weight: 500;
        transition: all .2s ease;
        background: #fff;
    }

    .ukuran-box input {
        display: none;
    }

    /* HOVER */
    .ukuran-box:hover {
        border-color: #28a745;
        background: #eafaf0;
    }

    /* ACTIVE (CHECKED) */
    .ukuran-box input:checked + span {
        color: #155724;
        font-weight: 600;
    }

    .ukuran-box:has(input:checked) {
        border-color: #28a745;
        background: #28a745;
        color: #fff;
    }

    .ukuran-box:has(input:checked):hover {
        background: #218838;
        border-color: #1e7e34;
    }
</style>
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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Supplier</h1>
                </div>
                <div class="col-sm-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahProduk">
                        <i class="fas fa-plus"></i> Tambah Supplier
                    </button>
                    </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Supplier</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('supplier.index') }}" class="mb-3">
    <div class="row">
        {{-- Search --}}
        <div class="col-md-2">
            <input type="text" name="search" class="form-control"
                placeholder="Cari nama supplier..."
                value="{{ request('search') }}">
        </div>


        {{-- Button --}}
        <div class="col-md-4">
            <button class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
        
    </div>
</form>


                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($supplier as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama_supplier }}</td>
                                        <td>{{ $s->alamat }}</td>
                                        <td>{{ $s->telepon }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $s->id }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapus{{ $s->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- ================= MODAL EDIT ================= --}}
                                    <div class="modal fade" id="edit{{ $s->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('supplier.update', $s->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">Edit Supplier</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Supplier</label>
                                                            <input type="text" name="nama_supplier"
                                                                value="{{ $s->nama_supplier }}" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" name="alamat"
                                                                value="{{ $s->alamat }}" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Telepon</label>
                                                            <input type="number" name="telepon"
                                                                value="{{ $s->telepon }}" class="form-control" required>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button class="btn btn-warning">Update</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ================= MODAL HAPUS ================= --}}
                                    <div class="modal fade" id="hapus{{ $s->id }}">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">

                                                <form action="{{ route('supplier.destroy', $s->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Supplier</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body text-center">
                                                        <p>Yakin hapus supplier:</p>
                                                        <strong>{{ $s->nama_supplier }}</strong> ?
                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Batal</button>
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                {{-- ================= MODAL TAMBAH PRODUK ================= --}}
                <div class="modal fade" id="tambahProduk">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header bg-info">
                                    <h5 class="modal-title">Tambah Supplier</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama Supplier</label>
                                        <input type="text" name="nama_supplier" placeholder="Masukkan nama supplier" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" name="alamat" placeholder="Masukkan alamat supplier" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Telepon Supplier</label>
                                        <input type="number" name="telepon" placeholder="Masukkan telepon supplier" class="form-control" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-info">Simpan</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
