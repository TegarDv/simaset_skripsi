<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>
        {{ $desk }}
    </p>
    <table class="table table-bordered">
        <tr>
            <th>Tanggal Transaksi</th>
            <th>Kode</th>
            <th>Tipe Transaksi</th>
            <th>Pelaku Transaksi</th>
            <th>Stok</th>
            <th>Keterangan Transaksi</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->tanggal_transaksi }}</td>
            <td>
                Kode Transaksi: {{ $looping->kode_transaksi }}<br>
                Kode Aset: {{ $looping->dataAsset->kode_aset }}
            </td>
            <td>{{ $looping->tipe_transaksi }}</td>
            <td>{{ $looping->dataUser->name }}</td>
            <td>
                Sebelum: {{ $looping->stok_sebelum }}<br>
                Sesudah: {{ $looping->stok_sesudah }}
            </td>
            <td>{{ $looping->keterangan }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>