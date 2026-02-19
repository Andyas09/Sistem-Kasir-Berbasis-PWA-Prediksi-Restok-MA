<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi POS</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #1c2182ff;
            line-height: 1.4;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #1c2182ff; /* Tema coklat dari project */
            padding-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border: none;
        }

        .header-table td {
            border: none;
            padding: 0;
        }

        .store-info {
            width: 70%;
        }

        .store-name {
            font-size: 18px;
            font-weight: bold;
            color: #1c2182ff;
            margin: 0;
        }

        .report-info {
            width: 30%;
            text-align: right;
            vertical-align: bottom;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #1c2182ff;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px 5px;
            border: 1px solid #094697ff;
        }

        td {
            padding: 6px 5px;
            border: 1px solid #dddddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .summary {
            width: 100%;
            margin-top: 30px;
        }

        .summary-box {
            float: right;
            width: 250px;
            background-color: #f8f8f8;
            padding: 10px;
            border: 1px solid #eeeeee;
        }

        .summary-row {
            clear: both;
            margin-bottom: 5px;
        }

        .summary-label {
            float: left;
            width: 60%;
        }

        .summary-value {
            float: right;
            width: 40%;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            font-size: 10px;
            color: #777;
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #333; }
        .badge-danger { background-color: #dc3545; }

    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="store-info">
                    <h1 class="store-name">HNSM Store</h1>
                    <div style="margin-top: 5px;">
                        Tejowarno, RT.1/RW.14, Bakalan, Tamanagung<br>
                        Kec. Muntilan, Kabupaten Magelang, Jawa Tengah<br>
                    </div>
                </td>
                <td class="report-info">
                    <div class="report-title">LAPORAN TRANSAKSI</div>
                    <div>Periode: {{ request('tanggal') ?? (request('bulan') ? date('F', mktime(0, 0, 0, request('bulan'), 10)) : (request('tahun') ?? 'Semua Waktu')) }}</div>
                    <div>Dicetak: {{ date('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">No Invoice</th>
                <th width="15%">Kasir</th>
                <th width="15%" class="text-right">Total</th>
                <th width="12%">Metode</th>
                <th width="10%" class="text-center">Status</th>
                <th width="28%">Tanggal dan Waktu</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRevenue = 0;
            @endphp
            @foreach($data as $item)
                @php
                    if($item->status == 'Selesai') $totalRevenue += $item->total;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->details->first()->no_invoice ?? '-' }}</td>
                    <td>{{ $item->user->name ?? $item->user->nama ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->metode }}</td>
                    <td class="text-center">
                        <span class="badge {{ $item->status == 'Selesai' ? 'badge-success' : ($item->status == 'Pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-box">
            <div class="summary-row">
                <span class="summary-label">Total Pendapatan (Selesai):</span>
                <span class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

</body>
</html>