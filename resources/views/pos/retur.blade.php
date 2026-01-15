@include('template.header')
@include('template.menu')

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

                    <div class="form-group">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" value="TRX-001">
                    </div>

                    <div class="form-group">
                        <label>Produk</label>
                        <select class="form-control">
                            <option>Sabun Mandi</option>
                            <option>Minyak Goreng</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Qty Retur</label>
                        <input type="number" class="form-control" value="1">
                    </div>

                    <div class="form-group">
                        <label>Alasan</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <button class="btn btn-danger">Proses Retur</button>

                </div>
            </div>

        </div>
    </section>
</div>
