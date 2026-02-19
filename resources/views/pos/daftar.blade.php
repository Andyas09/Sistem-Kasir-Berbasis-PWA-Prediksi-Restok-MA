@include('template.header')
@include('template.menu')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Transaksi</h1>
            <div class="text-right">
                <a href="{{ route('pos.exportE', parameters: request()->query()) }}" class="btn btn-success">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('pos.exportP', request()->query()) }}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Semua Transaksi</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('pos.daftar') }}">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control">
                                    <option value="">-- Semua Bulan --</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control">
                                    <option value="">-- Semua Tahun --</option>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
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


                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kode Invoice</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Kasir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transaksis as $trx)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td class="text-center">
                                        {{ optional($trx->details->first())->no_invoice ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $trx->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="text-right">
                                        Rp {{ number_format($trx->total) }}
                                    </td>

                                    <td class="text-center">
                                        {{ $trx->user->nama ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        @if($trx->status === 'Selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-warning">{{ $trx->status }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('pos.struk', $trx->id) }}" class="btn btn-sm btn-info"
                                            target="_blank">
                                            <i class="fa fa-print"></i> Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Belum ada transaksi
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