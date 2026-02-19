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
                    <h1>Data Produk</h1>
                </div>
                <div class="col-sm-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahProduk">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                    </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Produk</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('produk.index') }}" class="mb-3">
    <div class="row">
        {{-- Search --}}
        <div class="col-md-2">
            <input type="text" name="search" class="form-control"
                placeholder="Cari nama produk..."
                value="{{ request('search') }}">
        </div>

        {{-- Kategori --}}
        <div class="col-md-2">
            <select name="kategori" class="form-control">
                <option value="">-- Semua Kategori --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}"
                        {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Ukuran --}}
        <div class="col-md-2">
            <select name="ukuran" class="form-control">
                <option value="">-- Semua Ukuran --</option>
                @foreach($ukurans as $u)
                    <option value="{{ $u }}"
                        {{ request('ukuran') == $u ? 'selected' : '' }}>
                        {{ $u }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Stok --}}
        <div class="col-md-2">
            <select name="stok" class="form-control">
                <option value="">-- Semua Stok --</option>
                <option value="ada" {{ request('stok') == 'ada' ? 'selected' : '' }}>Stok Tersedia</option>
                <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
            </select>
        </div>

        {{-- Button --}}
        <div class="col-md-4">
            <button class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
        
    </div>
</form>


                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Ketegori</th>
                                    <th>Ukuran</th>
                                    <th>Variasi</th>
                                    <th>Deskripsi</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Supplier</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($produk as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($p->gambar)
                                                <img src="{{ asset('storage/' . $p->gambar) }}" width="50">
                                            @else -
                                            @endif
                                        </td>
                                        <td>{{ $p->nama_produk }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $p->kategori->nama_kategori ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $p->ukuran }}</td>
                                        <td>{{ $p->warna }}</td>
                                        <td>{{ $p->deskripsi }}</td>
                                        <td>Rp {{ number_format($p->harga_jual) }}</td>
                                        <td>{{ $p->stok }}</td>
                                        <td>{{ $p->supplier->nama_supplier ?? '-'}}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $p->id }}">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapus{{ $p->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- ================= MODAL EDIT ================= --}}
                                    <div class="modal fade" id="edit{{ $p->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('produk.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">Edit Produk</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
    <label>Supplier</label>
    <select name="supplier_id" class="form-control" required>
        <option value="">-- Pilih Supplier --</option>
        @foreach($supplier as $s)
            <option 
                value="{{ $s->id }}"
                {{ $p->supplier_id == $s->id ? 'selected' : '' }}>
                {{ $s->nama_supplier }}
            </option>
        @endforeach
    </select>
</div>

                                                        <div class="form-group">
                                                            <label>Nama Produk</label>
                                                            <input type="text" name="nama_produk"
                                                                value="{{ $p->nama_produk }}" class="form-control" required>
                                                        </div>
                                                        
                                                        <div class="form-group">
    <label>Kategori</label>
    <select name="kategori_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>

        @foreach($kategoris as $kat)
            <option value="{{ $kat->id }}"
                {{ $p->kategori_id == $kat->id ? 'selected' : '' }}>
                {{ $kat->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>


                                                        <div class="form-group">
    <label class="d-block mb-2">Ukuran</label>

    @php
        $ukuranDefault = ['S','M','L','XL'];
        $isLainnya = !in_array($p->ukuran, $ukuranDefault);
    @endphp

    <select name="ukuran_pilihan"
            id="ukuranSelect{{ $p->id }}"
            class="form-control ukuran-select"
            data-id="{{ $p->id }}"
            required>
        <option value="">-- Pilih Ukuran --</option>
        @foreach($ukuranDefault as $u)
            <option value="{{ $u }}"
                {{ $p->ukuran == $u ? 'selected' : '' }}>
                {{ $u }}
            </option>
        @endforeach
        <option value="lainnya" {{ $isLainnya ? 'selected' : '' }}>
            Lainnya
        </option>
    </select>

    {{-- Input ukuran lainnya --}}
    <input type="text"
           name="ukuran_lainnya"
           id="ukuranLainnya{{ $p->id }}"
           class="form-control mt-2"
           placeholder="Masukkan ukuran lain"
           value="{{ $isLainnya ? $p->ukuran : '' }}"
           style="{{ $isLainnya ? '' : 'display:none;' }}">
</div>


                                                        <div class="form-group">
                                                            <label>Harga Modal</label>
                                                            <input type="number" name="harga_modal" value="{{ $p->harga_modal }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Variasi</label>
                                                            <input type="text" name="warna" value="{{ $p->warna }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Harga Jual</label>
                                                            <input type="number" name="harga_jual" value="{{ $p->harga_jual }}"
                                                                class="form-control" required>
                                                        </div>
                                                        

                                                        <div class="form-group">
                                                            <label>Stok</label>
                                                            <input type="number" name="stok" value="{{ $p->stok }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Gambar</label>
                                                            <input type="file" name="gambar" class="form-control" id="inputGambar">
                                                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small><br>
                                                            @if($p->gambar && file_exists(public_path('storage/' . $p->gambar)))
                                                            <img src="{{ asset('storage/' . $p->gambar) }}" width="100" class="mt-2">
                                                            @endif
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
                                    <div class="modal fade" id="hapus{{ $p->id }}">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">

                                                <form action="{{ route('produk.destroy', $p->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Produk</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body text-center">
                                                        <p>Yakin hapus produk:</p>
                                                        <strong>{{ $p->nama_produk }}</strong> ?
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

                            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header bg-info">
                                    <h5 class="modal-title">Tambah Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-manual-tab" data-toggle="pill" href="#pills-manual" role="tab">Input Manual</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-excel-tab" data-toggle="pill" href="#pills-excel" role="tab">Import Excel</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        {{-- manual --}}
                                        <div class="tab-pane fade show active" id="pills-manual" role="tabpanel">
                                            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="'form-group">
                                                    <label>Supplier</label>
                                                    <select name="supplier_id" class="form-control" required>
                                                        <option value="">-- Pilih Supplier --</option>
                                                        @foreach($supplier as $s)
                                                            <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Produk</label>
                                                    <input type="text" name="nama_produk" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="d-block mb-2">Ukuran</label>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach(['S','M','L','XL','Lainnya'] as $size)
                                                            <label class="ukuran-box">
                                                                <input type="radio" name="ukuran_pilihan" value="{{ strtolower($size) == 'lainnya' ? 'lainnya' : $size }}" class="ukuran-radio">
                                                                <span>{{ $size }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <input type="text" name="ukuran_lainnya" id="inputUkuranLainnya" class="form-control mt-3" placeholder="Masukkan ukuran lain" style="display:none;">
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <input type="text" name="deskripsi" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Variasi</label>
                                                    <input type="text" name="warna" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Harga Modal</label>
                                                    <input type="number" name="harga_modal" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Harga Jual</label>
                                                    <input type="number" name="harga_jual" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Stok</label>
                                                    <input type="number" name="stok" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select name="kategori_id" class="form-control" required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        @foreach($kategoris as $kat)
                                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Gambar Produk</label>
                                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                                    <small class="text-muted">Opsional (jpg, png)</small>
                                                </div>
                                                <div class="modal-footer px-0 pb-0">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-info">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- excel --}}
                                        <div class="tab-pane fade" id="pills-excel" role="tabpanel">
                                            <form action="{{ route('produk.import-excel') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="alert alert-info py-2">
                                                    <small><i class="fas fa-info-circle mr-1"></i> Gunakan format Excel yang sesuai untuk bulk import.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>File Excel (.xlsx, .xls, .csv)</label>
                                                    <input type="file" name="file" class="form-control" required>
                                                </div>
                                                <div class="modal-footer px-0 pb-0 mt-4">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-file-excel mr-1"></i> Import Sekarang
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    document.querySelectorAll('.ukuran-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            const input = document.getElementById('inputUkuranLainnya');

            if (this.value === 'lainnya') {
                input.style.display = 'block';
                input.required = true;
            } else {
                input.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        });
    });
</script>
<script>
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('ukuran-select')) {
            const id = e.target.dataset.id;
            const input = document.getElementById('ukuranLainnya' + id);

            if (e.target.value === 'lainnya') {
                input.style.display = 'block';
                input.required = true;
            } else {
                input.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }
    });
</script>

