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
    <section class="content-header">
        <div class="container-fluid">
            <h1>Transaksi Hold</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Daftar Transaksi yang di-Hold</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('pos.hold') }}" class="mb-3">
                        <div class="row">

                            <div class="card-body">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Invoice</th>
                                            <th>Tanggal</th>
                                            <th>Kasir</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transaksis as $trx)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ optional($trx->details->first())->no_invoice ?? '-' }}</td>
                                                <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ $trx->user->nama ?? '-' }}</td>
                                                <td>Rp {{ number_format($trx->total) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-success btn-sm">
                                                        Lanjutkan
                                                    </a>
                                                    <a href="" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </a>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    Tidak ada transaksi hold
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