@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Penyesuaian Stok</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- ================= INFO METODE ================= -->
            <div class="alert alert-info">
                <strong>Metode Stok:</strong> FIFO |
                <strong>Safety Stock Aktif</strong> |
                Sistem akan mencatat semua perubahan stok sebagai <em>audit trail</em>.
            </div>

            <!-- ================= DATA OPNAME ================= -->
            <div class="card">
                <div class="card-header bg-warning text-white d-flex justify-content-between">
                    <h3 class="card-title mb-0">Riwayat Stock Opname</h3>
                    <div>
                        <button class="btn btn-light btn-sm">Laporan Penyesuaian</button>
                    </div>
                </div>

                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Stok Sistem</th>
                                <th>Stok Fisik</th>
                                <th>Selisih</th>
                                <th>Alasan</th>
                                <th>User</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- CONTOH DATA -->
                            <tr>
                                <td>1</td>
                                <td>2025-01-15</td>
                                <td>Sabun Mandi</td>
                                <td>50</td>
                                <td>48</td>
                                <td class="text-danger">-2</td>
                                <td>Barang rusak</td>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-info btn-sm">Log</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ================= MODAL STOCK OPNAME ================= -->
<div class="modal fade" id="modalOpname" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Form Stock Opname</h5>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Produk</label>
                            <select class="form-control">
                                <option>-- Pilih Produk --</option>
                                <option>Sabun Mandi</option>
                                <option>Minyak Goreng</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Stok Sistem</label>
                            <input type="number" class="form-control" readonly value="50">
                        </div>

                        <div class="col-md-3">
                            <label>Stok Fisik</label>
                            <input type="number" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Alasan Penyesuaian</label>
                            <select class="form-control">
                                <option>Barang Rusak</option>
                                <option>Barang Hilang</option>
                                <option>Kadaluarsa</option>
                                <option>Salah Hitung</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Keterangan</label>
                            <textarea class="form-control"
                                placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Tanggal</label>
                            <input type="date" class="form-control"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Petugas</label>
                            <input type="text" class="form-control"
                                   value="{{ auth()->user()->name ?? 'Admin' }}" readonly>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-warning">Sesuaikan Stok</button>
                </div>

            </form>

        </div>
    </div>
</div>
