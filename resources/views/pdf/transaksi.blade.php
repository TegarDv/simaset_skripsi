<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    </p>
    <table class="table table-bordered">
        <tr>
            <th>Tanggal Transaksi</th>
            <th>Kode Transaksi</th>
            <th>Tipe Transaksi</th>
            <th>Kode Aset</th>
            <th>Stok Sebelum</th>
            <th>Stok Sesudah</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->tanggal_transaksi }}</td>
            <td>{{ $looping->kode_transaksi }}</td>
            <td>{{ $looping->tipe_transaksi }}</td>
            <td>{{ $looping->dataAsset->kode_aset }}</td>
            <td>{{ $looping->stok_sebelum }}</td>
            <td>{{ $looping->stok_sesudah }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>