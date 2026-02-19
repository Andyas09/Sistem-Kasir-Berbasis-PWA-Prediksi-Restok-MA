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
                                                    @php
                                                        $detailsFormatted = $trx->details->map(function ($d) {
                                                            return [
                                                                'nama' => $d->produk->nama_produk ?? '-',
                                                                'qty' => $d->qty,
                                                                'harga' => $d->harga_jual,
                                                                'subtotal' => $d->sub_total
                                                            ];
                                                        });
                                                    @endphp

                                                    <button type="button" class="btn btn-success btn-sm btn-lanjutkan"
                                                        data-toggle="modal" data-target="#modalBayarHold"
                                                        data-id="{{ $trx->id }}" data-total="{{ $trx->total }}"
                                                        data-details='@json($detailsFormatted)'>
                                                        Lanjutkan
                                                    </button>

                                                    <form action="{{ route('pos.hold.destroy', $trx->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
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

{{-- ================= MODAL BAYAR HOLD ================= --}}
<div class="modal fade" id="modalBayarHold" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formBayarHold" action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Transaksi Hold</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    {{-- RINGKASAN PRODUK --}}
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Produk</th>
                                <th width="80">Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="listProdukHold">
                            <!-- Populated by JS -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th id="totalHoldText">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>

                    <input type="hidden" name="total" id="totalHoldInput">

                    {{-- METODE --}}
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="metode" id="metodeHold" class="form-control" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    {{-- CASH FIELD --}}
                    <div id="cashFieldHold" style="display:none">
                        <div class="form-group">
                            <label>Uang Dibayar</label>
                            <input type="number" name="bayar" id="bayarHold" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Kembalian</label>
                            <input type="text" id="kembalianHold" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- CETAK STRUK --}}
                    <div class="form-group">
                        <label>Cetak Struk</label>
                        <div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="cetakStrukHold"
                                    name="cetak_struk" value="Ya" checked>
                                <label class="custom-control-label" for="cetakStrukHold">Ya</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Populate Modal Data
        const btnsLanjutkan = document.querySelectorAll('.btn-lanjutkan');
        const form = document.getElementById('formBayarHold');
        const listProduk = document.getElementById('listProdukHold');
        const totalText = document.getElementById('totalHoldText');
        const totalInput = document.getElementById('totalHoldInput');

        const metode = document.getElementById('metodeHold');
        const cashField = document.getElementById('cashFieldHold');
        const bayar = document.getElementById('bayarHold');
        const kembalian = document.getElementById('kembalianHold');

        let currentTotal = 0;

        btnsLanjutkan.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const total = this.getAttribute('data-total');
                const details = JSON.parse(this.getAttribute('data-details'));

                currentTotal = parseInt(total);

                // Set Form Action
                form.action = `/pos/hold/${id}/bayar`;

                // Set Total
                totalText.innerText = 'Rp ' + currentTotal.toLocaleString('id-ID');
                totalInput.value = currentTotal;

                // Render Details
                listProduk.innerHTML = '';
                details.forEach(d => {
                    listProduk.innerHTML += `
                    <tr>
                        <td>${d.nama}</td>
                        <td>${d.qty}</td>
                        <td>Rp ${parseInt(d.harga).toLocaleString('id-ID')}</td>
                        <td>Rp ${parseInt(d.subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `;
                });

                // Reset Fields
                metode.value = '';
                cashField.style.display = 'none';
                bayar.value = '';
                bayar.required = false;
                kembalian.value = '';
            });
        });

        // Payment Logic
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
            let kembali = this.value - currentTotal;
            kembalian.value = kembali >= 0
                ? 'Rp ' + kembali.toLocaleString('id-ID')
                : 'Uang kurang';
        });

        // Delete Confirmation
        const btnsHapus = document.querySelectorAll('.btn-hapus');
        btnsHapus.forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus Transaksi?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@include('template.footer')