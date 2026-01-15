@include('template.header')
@include('template.menu')

<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Riwayat Transaksi</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- ================= FILTER ================= -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">Filter Transaksi</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ request('tanggal') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control">
                                    <option value="">-- Semua Bulan --</option>
                                    @for($i=1;$i<=12;$i++)
                                        <option value="{{ $i }}"
                                            {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0,0,0,$i,1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control">
                                    <option value="">-- Semua Tahun --</option>
                                    @for($y = date('Y'); $y >= date('Y')-5; $y--)
                                        <option value="{{ $y }}"
                                            {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary mr-2">Filter</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- ================= RIWAYAT ================= -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">Riwayat Transaksi</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Kasir</th>
                                <th>Item</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09:21</td>
                                <td>Wahyu</td>
                                <td>Sabun (2)</td>
                                <td>Rp 20.000</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#strukModal1">
                                        Lihat Struk
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>10:05</td>
                                <td>Admin</td>
                                <td>Minyak Goreng (1)</td>
                                <td>Rp 14.000</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#strukModal2">
                                        Lihat Struk
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ================= MODAL STRUK (CONTOH) ================= -->
<div class="modal fade" id="strukModal1" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Struk Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <strong>TOKO MAJU JAYA</strong><br>
                ------------------------<br>
                Sabun Mandi x2<br>
                Total: Rp 20.000<br><br>
                <small>Kasir: Wahyu</small>
            </div>
        </div>
    </div>
</div>
