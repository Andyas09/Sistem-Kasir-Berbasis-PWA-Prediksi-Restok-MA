@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Pengaturan Sistem</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- TABS -->
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#umum">Umum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#transaksi">Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pos">POS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pengguna">Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#sistem">Sistem</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body tab-content">

                    <!-- UMUM -->
                    <div class="tab-pane fade show active" id="umum">
                        <form>
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <input type="text" class="form-control" value="HNSM Store">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control">Jl. Contoh No. 12</textarea>
                            </div>

                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="text" class="form-control" value="08123456789">
                            </div>

                            <div class="form-group">
                                <label>Mata Uang</label>
                                <select class="form-control">
                                    <option selected>Rupiah (Rp)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Logo Toko</label>
                                <input type="file" class="form-control">
                            </div>
                        </form>
                    </div>

                    <!-- TRANSAKSI -->
                    <div class="tab-pane fade" id="transaksi">
                        <form>
                            <div class="form-group">
                                <label>Metode Stok</label>
                                <select class="form-control">
                                    <option>FIFO</option>
                                    <option>LIFO</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PPN (%)</label>
                                <input type="number" class="form-control" value="11">
                            </div>

                            <div class="form-group">
                                <label>Safety Stock (Minimum)</label>
                                <input type="number" class="form-control" value="10">
                            </div>

                            <div class="form-group">
                                <label>Pembulatan Harga</label>
                                <select class="form-control">
                                    <option>Tidak</option>
                                    <option>Ratusan</option>
                                    <option>Ribuan</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- POS -->
                    <div class="tab-pane fade" id="pos">
                        <form>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Cetak Struk Otomatis</label>
                            </div>

                            <div class="form-group mt-2">
                                <label>Ukuran Kertas</label>
                                <select class="form-control">
                                    <option>58mm</option>
                                    <option>80mm</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Header Struk</label>
                                <textarea class="form-control">Terima Kasih Telah Berbelanja</textarea>
                            </div>
                        </form>
                    </div>

                    <!-- PENGGUNA -->
                    <div class="tab-pane fade" id="pengguna">
                        <form>
                            <div class="form-group">
                                <label>Session Timeout (menit)</label>
                                <input type="number" class="form-control" value="30">
                            </div>

                            <div class="form-group">
                                <label>Maks Login Gagal</label>
                                <input type="number" class="form-control" value="5">
                            </div>
                        </form>
                    </div>

                    <!-- SISTEM -->
                    <div class="tab-pane fade" id="sistem">
                        <button class="btn btn-secondary mb-2">
                            Backup Database
                        </button>
                        <button class="btn btn-warning mb-2">
                            Maintenance Mode
                        </button>
                        <p class="mt-3">
                            Versi Aplikasi: <strong>v1.0.0</strong>
                        </p>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan Pengaturan</button>
                </div>

            </div>

        </div>
    </section>
</div>
