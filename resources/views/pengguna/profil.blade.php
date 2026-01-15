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
            <h1>Profil Pengguna</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- PROFIL KIRI -->
                <div class="col-md-4">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('assets/img/produk-default.png') }}"
                                 alt="User profile picture">

                            <h3 class="profile-username mt-2">
                                {{ Auth::user()->nama ?? 'Admin HNSM' }}
                            </h3>

                            <p class="text-muted">
                                {{ Auth::user()->role->nama_role ?? 'Administrator' }}
                            </p>

                            <ul class="list-group list-group-unbordered mb-3 text-left">
                                <li class="list-group-item">
                                    <b>Username</b>
                                    <span class="float-right">
                                        {{ Auth::user()->username ?? '-' }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <span class="float-right">
                                        {{ Auth::user()->email ?? '-' }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b>
                                    <span class="float-right badge badge-success">
                                        {{ Auth::user()->status ?? '-' }}
                                    </span>
                                </li>
                            </ul>

                            <button class="btn btn-success btn-block" data-toggle="modal" data-target="#fotoModal">
                                <b>Ganti Foto Profil</b>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PROFIL KANAN -->
                <div class="col-md-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profil</h3>
                        </div>

                        <form method="POST" action="#">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control"
                                           value="{{ Auth::user()->nama ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control"
                                           value="{{ Auth::user()->username ?? '' }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control"
                                           value="{{ Auth::user()->email ?? '' }}">
                                </div>

                                <hr>

                                <h5>Ubah Password</h5>

                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control">
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- MODAL FOTO PROFIL -->
<div class="modal fade" id="fotoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Ganti Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Foto</label>
                        <input type="file" class="form-control" accept="image/*">
                        <small class="text-muted">Format JPG/PNG, max 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
