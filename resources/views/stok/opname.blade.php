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
            <h1>Stok Opname</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- INFO -->
            <div class="alert alert-info">
                <strong>Stock Opname (SO)</strong> digunakan untuk mencocokkan stok fisik
                dengan stok sistem dan mencatat selisih, kerusakan, atau kehilangan.
            </div>

            <!-- CARD -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h3 class="card-title mb-0">Daftar Sesi Stock Opname</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Sesi</th>
                                <th>Tanggal</th>
                                <th>Total Stok</th>
                                <th>Selisih</th>
                                <th>Barang Rusak</th>
                                <th>Status</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesi as $index => $s)
                                @php
                                    $totalStok = $s->opname->sum('stok_fisik');
                                    $stokAwal = $s->opname->sum('stok_sistem');
                                    $terjual = $s->opname->sum('terjual');
                                    $rusak = $s->opname->sum('rusak');
                                    $selisih = $totalStok - $stokAwal;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $s->nama_sesi }}</td>
                                    <td>{{ $s->tanggal}}</td>
                                    <td>{{ $totalStok }}</td>
                                    <td class="{{ $selisih < 0 ? 'text-danger' : 'text-success' }}">{{ $selisih }}</td>
                                    <td>{{ $rusak }}</td>
                                    <td>
                                        <span class="badge {{ $selisih == 0 ? 'badge-success' : 'badge-warning' }}">
                                            {{ $selisih == 0 ? 'Selesai' : 'Ada Selisih' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-info btn-sm">Detail</a>
                                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('stok.so.destroy', $s->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus sesi ini?')"
                                                class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modalTambahSO">
                        Tambah Sesi SO Baru
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
<!-- ================= MODAL TAMBAH SESI SO ================= -->
<div class="modal fade" id="modalTambahSO" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Buat Sesi Stock Opname</h5>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('stok.so.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Sesi SO</label>
                            <input type="text" name="nama_sesi" class="form-control"
                                placeholder="Contoh: SO Akhir Bulan">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Input Stok</label>
                            <select name="input_type" id="input_type" class="form-control">
                                <option value="manual">Input Manual</option>
                                <option value="excel">Import Excel</option>
                            </select>
                        </div>
                    </div>
                    <div id="excel-section" style="display:none">
                        <div class="mt-2">
                            <a href="{{ route('stok.export-template') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Download Template Excel
                            </a>
                        </div>

                        <div class="mt-2">
                            <label>Upload File Excel</label>
                            <input type="file" name="file_excel" class="form-control" accept=".xlsx,.xls">
                        </div>
                    </div>

                    <hr>
                    <div id="manual-section">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Stok Awal</label>
                                <input type="number" name="stok_awal" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Terjual</label>
                                <input type="number" name="terjual" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Rusak / Hilang</label>
                                <input type="number" name="rusak" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label>Keterangan</label>
                        <textarea class="form-control" placeholder="Catatan selisih, kondisi barang, dll"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan Sesi SO</button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    document.getElementById('input_type').addEventListener('change', function () {
        let manual = document.getElementById('manual-section');
        let excel = document.getElementById('excel-section');

        if (this.value === 'excel') {
            manual.style.display = 'none';
            excel.style.display = 'block';
        } else {
            manual.style.display = 'block';
            excel.style.display = 'none';
        }
    });
</script>