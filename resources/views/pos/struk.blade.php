<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan</title>

    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 12px;
            margin: 0;
            padding: 5px;
        }

        @media print {
            .noprn { display: none; }
        }

        /* =====================
           UKURAN STRUK
           ===================== */
        .container {
            width: 260px; /* 58mm ≈ 260px | 80mm ≈ 320px */
            margin: auto;
        }

        /* =====================
           ALIGN
           ===================== */
        .center { text-align: center; }
        .right { text-align: right; }
        .left { text-align: left; }
        .bold { font-weight: bold; }
        .small { font-size: 10px; }

        hr {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* =====================
           LOGO
           ===================== */
        .logo {
            max-width: 70px;
            margin-bottom: 4px;
        }

        /* =====================
           BUTTON
           ===================== */
        .btn {
            padding: 6px 12px;
            margin: 5px;
            border: none;
            background: #000;
            color: #fff;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body onload="window.print()">

<div class="container">

    <!-- =====================
         HEADER
         ===================== -->
    <div class="center">
        <img src="{{ asset('assets/logo/logo.jpeg') }}" class="logo" alt="Logo">
        <div class="small">
            Tejowarno, RT.1/RW.14, Bakalan, Tamanagung<br>
            Kec. Muntilan, Kabupaten Magelang<br> Jawa Tengah
        </div>
    </div>

    <hr>

    <div class="center bold">
        BUKTI PEMBELIAN
    </div>
    <div class="center">
        {{ $transaksi->details->first()->no_invoice ?? '-' }}
    </div>

    <hr>

    <!-- =====================
         INFO TRANSAKSI
         ===================== -->
    <table>
        <tr>
            <td>Tanggal</td>
            <td class="right">
                {{ $transaksi->created_at->format('d/m/Y H:i') }}
            </td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="right">
                {{ $transaksi->user->nama }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- =====================
         ITEM
         ===================== -->
    <table>
        @foreach($transaksi->details as $d)
            <tr>
                <td colspan="2">
                    {{ $d->produk->nama_produk }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ $d->qty }} x {{ number_format($d->harga_jual) }}
                </td>
                <td class="right">
                    {{ number_format($d->sub_total) }}
                </td>
            </tr>
        @endforeach
    </table>

    <hr>

    <!-- =====================
         TOTAL
         ===================== -->
    <table>
        <tr>
            <td class="bold">Total</td>
            <td class="right bold">
                {{ number_format($transaksi->total) }}
            </td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="right">
                {{ number_format($transaksi->bayar) }}
            </td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="right">
                {{ number_format($transaksi->kembalian) }}
            </td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="right">
                {{ strtoupper($transaksi->metode) }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- =====================
         FOOTER
         ===================== -->
    <div class="bold center small">
        IN HNSM WE TRUST<br>
        Barang yang sudah dibeli<br>
        tidak dapat dikembalikan
    </div>

    <!-- =====================
         ACTION
         ===================== -->
    <div class="center noprn">
        <button class="btn" onclick="window.print()">Cetak</button>
        <a href="{{ route('pos.transaksi') }}">
            <button class="btn">Tutup</button>
        </a>
    </div>

</div>

</body>
</html>
