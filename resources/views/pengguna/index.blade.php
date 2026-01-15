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
            <h1>Manajemen Pengguna & Hak Akses</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- TOMBOL TAMBAH -->
            <div class="mb-3 text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-user-plus"></i> Tambah Pengguna
                </button>
            </div>

            <!-- TABEL PENGGUNA -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Daftar Pengguna</h3>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email / Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="220">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->nama }}</td>
                                            <td>
                                                {{ $user->email }} <br>
                                                <small class="text-muted">{{ $user->username }}</small>
                                            </td>
                                            <td>
                                                <span class="badge 
                                {{ $user->role->nama_role == 'Admin' ? 'badge-danger' : 'badge-primary' }}">
                                                    {{ $user->role->nama_role }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                {{ $user->status == 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#modalHakAkses{{ $user->id }}">
                                                    Hak Akses
                                                </button>

                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalEdit{{ $user->id }}">
                                                    Edit
                                                </button>

                                                <form action="{{ route('pengguna.reset', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-secondary btn-sm"
                                                        onclick="return confirm('Reset password user ini?')">
                                                        Reset Password
                                                    </button>
                                                </form>

                                                <form action="{{ route('pengguna.toggle', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Ubah status user?')">
                                                        {{ $user->status == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Data pengguna belum tersedia
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ================= MODAL TAMBAH PENGGUNA ================= -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">Kasir</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ================= MODAL HAK AKSES ================= -->
<div class="modal fade" id="modalHakAkses">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Hak Akses</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">

                        <div class="col-md-4">
                            <h6>Master Data</h6>
                            <label><input type="checkbox"> Produk</label><br>
                            <label><input type="checkbox"> Supplier</label><br>
                            <label><input type="checkbox"> Kategori</label>
                        </div>

                        <div class="col-md-4">
                            <h6>Transaksi</h6>
                            <label><input type="checkbox"> Penjualan</label><br>
                            <label><input type="checkbox"> Stok Masuk</label><br>
                            <label><input type="checkbox"> Stok Keluar</label>
                        </div>

                        <div class="col-md-4">
                            <h6>Laporan</h6>
                            <label><input type="checkbox"> Lihat Laporan</label><br>
                            <label><input type="checkbox"> Export</label>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan Hak Akses</button>
            </div>

        </div>
    </div>
</div>