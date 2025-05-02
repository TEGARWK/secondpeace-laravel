<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .date-range {
            text-align: right;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tfoot {
            font-weight: bold;
            background-color: #343a40;
        }

        tfoot tr th {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #212529;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
            color: #212529;
        }

        .total-row {
            background-color: #343a40;
            color: white;
        }

        .no-data {
            background-color: #fff;
            color: #212529;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            grid-column: span 7; /* Span across all 7 columns */
        }

        .empty-row {
            text-align: center;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan Second Peace</h1>

    <div class="date-range">
        <p>Tanggal: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(count($laporan) == 0)
                <tr class="empty-row">
                    <td colspan="7" class="no-data">Tidak ada data penjualan pada rentang waktu ini.</td>
                </tr>
            @else
                @foreach($laporan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $item->status_pesanan }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot class="total-row">
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan</th>
                <th colspan="2" class="total">Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
