<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Sepatu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #5D4037; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #5D4037; padding: 8px; text-align: left; }
        th { background-color: #5D4037; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2> KICKS STORE</h2>
        <p>Laporan Data Sepatu</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sepatu</th>
                <th>Merk</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shoes as $key => $shoe)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $shoe->nama }}</td>
                <td>{{ $shoe->merk }}</td>
                <td>{{ $shoe->ukuran }}</td>
                <td>Rp {{ number_format($shoe->harga, 0, ',', '.') }}</td>
                <td>{{ $shoe->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $shoes->count() }} sepatu</p>
    </div>
</body>
</html>