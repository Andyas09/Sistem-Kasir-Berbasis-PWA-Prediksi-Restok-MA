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
            <h1>Retur Barang</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title">Form Retur</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.retur.proses') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nomor Invoice</label>
                            <div class="input-group">
                                <input type="text" name="invoice" id="invoice_number" class="form-control" placeholder="Contoh: INV-..." required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" id="btnCheckInvoice">
                                        <i class="fas fa-search"></i> Cek Invoice
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="returFormBody" style="display: none;">
                            <div class="form-group">
                                <label>Pilih Produk</label>
                                <select name="produk_id" id="produk_id" class="form-control" required>
                                    <option value="">-- Pilih Produk --</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Qty Pembelian</label>
                                        <input type="text" id="qty_pembelian" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Qty Retur</label>
                                        <input type="number" name="qty" id="qty_retur" class="form-control" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Alasan Retur</label>
                                <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Barang cacat, Salah ukuran, dll" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-undo"></i> Proses Retur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    let invoiceData = [];

    $('#btnCheckInvoice').click(function() {
        const invoice = $('#invoice_number').val();
        if (!invoice) {
            Swal.fire('Peringatan', 'Silakan masukkan nomor invoice', 'warning');
            return;
        }

        $(this).html('<i class="fas fa-spinner fa-spin"></i> Mengecek...').attr('disabled', true);

        $.ajax({
            url: "{{ route('pos.retur.check') }}",
            type: "GET",
            data: { invoice: invoice },
            success: function(response) {
                $('#btnCheckInvoice').html('<i class="fas fa-search"></i> Cek Invoice').attr('disabled', false);
                
                if (response.success) {
                    invoiceData = response.data;
                    $('#produk_id').html('<option value="">-- Pilih Produk --</option>');
                    
                    response.data.forEach(item => {
                        $('#produk_id').append(`<option value="${item.id}">${item.nama_produk} (Qty: ${item.qty})</option>`);
                    });

                    $('#returFormBody').fadeIn();
                    Swal.fire({
                        icon: 'success',
                        title: 'Invoice Ditemukan',
                        text: 'Silakan pilih produk yang akan diretur',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    $('#returFormBody').hide();
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                $('#btnCheckInvoice').html('<i class="fas fa-search"></i> Cek Invoice').attr('disabled', false);
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    });

    $('#produk_id').change(function() {
        const productId = $(this).val();
        const selectedItem = invoiceData.find(item => item.id == productId);
        
        if (selectedItem) {
            $('#qty_pembelian').val(selectedItem.qty);
            $('#qty_retur').attr('max', selectedItem.qty).val(1);
        } else {
            $('#qty_pembelian').val('');
            $('#qty_retur').val('');
        }
    });
});
</script>
