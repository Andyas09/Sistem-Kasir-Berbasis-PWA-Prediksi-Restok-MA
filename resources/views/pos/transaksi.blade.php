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
            <h1>Transaksi Penjualan (POS)</h1>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <!-- ================== PILIH PRODUK ================== -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Pilih Produk</h3>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('pos.transaksi') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                                    value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="kategori" class="form-control">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($kategoris as $kat)
                                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
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
                                        <option value="{{ $u }}" {{ request('ukuran') == $u ? 'selected' : '' }}>
                                            {{ $u }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm">Filter</button>
                                <a href="{{ route('pos.transaksi') }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    </form>


                    <!-- LIST PRODUK -->
                    <div class="row" id="produkList">

                        @forelse($produk as $p)
                                            <div class="col-md-3 mb-3 produk-item" data-nama="{{ strtolower($p->nama_produk) }}"
                                                data-id="{{ $p->id }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}">

                                                <div class="card h-100">
                                                    <img src="{{ $p->gambar
                            ? asset('storage/' . $p->gambar)
                            : asset('assets/img/produk-default.png') }}" class="card-img-top"
                                                        style="height:160px; object-fit:cover;" alt="{{ $p->nama_produk }}">

                                                    <div class="card-body text-center">
                                                        <h6 class="mb-1">{{ $p->nama_produk }} ({{ $p->ukuran }})</h6>
                                                        <td>
                                                            <span class="badge badge-primary">
                                                                Stok : {{ $p->stok ?? '-' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                {{ $p->kategori->nama_kategori ?? '-' }}
                                                            </span>
                                                        </td>
                                                        <p class="text-success mb-2">
                                                            Rp {{ number_format($p->harga_jual) }}
                                                        </p>

                                                        @if($p->stok > 0)
                                                            <form action="{{ route('pos.cart.add') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                                                <button class="btn btn-success btn-sm btn-block">
                                                                    Tambah
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm btn-block" disabled>
                                                                Stok Habis
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">
                                Produk tidak tersedia
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>


            <!-- ================== KERANJANG ================== -->
            <div class="card-body" id="keranjang">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th width="120">Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th width="50">#</th>
                        </tr>
                    </thead>
                    <tbody>
@php $total = 0; @endphp

@forelse($cart as $id => $item)
@php $subtotal = $item['qty'] * $item['harga']; $total += $subtotal; @endphp
<tr>
    <td>{{ $item['nama'] }}</td>
    <td class="text-center">
        <form action="{{ route('pos.cart.minus', $id) }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-secondary">-</button>
        </form>

        {{ $item['qty'] }}

        <form action="{{ route('pos.cart.add') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $id }}">
            <button class="btn btn-sm btn-secondary">+</button>
        </form>
    </td>
    <td>Rp {{ number_format($item['harga']) }}</td>
    <td>Rp {{ number_format($subtotal) }}</td>
    <td>
        <form action="{{ route('pos.cart.remove', $id) }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">X</button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        Keranjang kosong
    </td>
</tr>
@endforelse
</tbody>
                </table>

                <div class="text-right">
                    <h4>Total: <strong>Rp {{ number_format($total) }}</strong></h4>

<form action="{{ route('pos.pending') }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-warning" {{ empty($cart) ? 'disabled' : '' }}>
        Hold
    </button>
</form>

<button 
    type="button"
    class="btn btn-success"
    data-toggle="modal"
    data-target="#modalBayar"
    {{ empty($cart) ? 'disabled' : '' }}>
    Bayar
</button>


                </div>
            </div>


        </div>
    </section>
</div>
<div class="modal fade" id="modalBayar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('pos.bayar') }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    {{-- ================= RINGKASAN CART ================= --}}
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Produk</th>
                                <th width="80">Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php 
                                    $subtotal = $item['qty'] * $item['harga'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>Rp {{ number_format($item['harga']) }}</td>
                                    <td>Rp {{ number_format($subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th>Rp {{ number_format($total) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    @csrf
                    <input type="hidden" name="total" value="{{ $total }}">

                    {{-- ================= METODE ================= --}}
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="metode" id="metode" class="form-control" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    {{-- ================= CASH ================= --}}
                    <div id="cashField" style="display:none">
                        <div class="form-group">
                            <label>Uang Dibayar</label>
                            <input type="number" name="bayar" id="bayar"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Kembalian</label>
                            <input type="text" id="kembalian"
                                   class="form-control" readonly>
                        </div>
                    </div>
                    {{-- ================= CETAK STRUK ================= --}}
<div class="form-group">
    <label>Cetak Struk</label>
    <div>
        <div class="custom-control custom-switch">
            <input type="checkbox"
                   class="custom-control-input"
                   id="cetakStruk"
                   name="cetak_struk"
                   value="Ya"
                   checked>
            <label class="custom-control-label" for="cetakStruk">
                Ya
            </label>
        </div>
    </div>
</div>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const metode = document.getElementById('metode');
    const cashField = document.getElementById('cashField');
    const bayar = document.getElementById('bayar');
    const kembalian = document.getElementById('kembalian');
    const total = {{ $total }};

    metode.addEventListener('change', function () {
        if (this.value === 'Cash') {
            cashField.style.display = 'block';
            bayar.required = true;
        } else {
            cashField.style.display = 'none';
            bayar.required = false;
            bayar.value = '';
            kembalian.value = '';
        }
    });

    bayar.addEventListener('input', function () {
        let kembali = this.value - total;
        kembalian.value = kembali >= 0 
            ? 'Rp ' + kembali.toLocaleString('id-ID')
            : 'Uang kurang';
    });
});
</script>

