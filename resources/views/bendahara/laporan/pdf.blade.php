<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kas Kelas</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
        }

        .summary {
            width: 100%;
            margin-bottom: 30px;
        }

        .summary td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .summary .label {
            font-weight: bold;
            background: #f9f9f9;
            width: 30%;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data th {
            background: #3498db;
            color: white;
            padding: 10px;
            text-align: left;
        }

        table.data td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-end {
            text-align: right;
        }

        .text-success {
            color: green;
            font-weight: bold;
        }

        .text-danger {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .signature {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Laporan Keuangan Kas Kelas</div>
        <div class="subtitle">Periode: {{ $periode }}</div>
    </div>

    <table class="summary">
        <tr>
            <td class="label">Total Pemasukan</td>
            <td class="text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total Pengeluaran</td>
            <td class="text-danger">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Saldo Akhir</td>
            <td style="font-size: 14px; font-weight: bold;">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="50%">Keterangan</th>
                <th width="10%">Jenis</th>
                <th width="25%" class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $trx->keterangan }}</td>
                    <td>{{ ucfirst($trx->jenis) }}</td>
                    <td class="text-end">
                        <span class="{{ $trx->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                            {{ $trx->jenis === 'masuk' ? '' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d F Y H:i:s') }}
        <div class="signature">
            Bendahara Kelas,<br><br><br><br>
            ({{ auth()->user()->name }})
        </div>
    </div>
</body>

</html>