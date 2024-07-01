<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Aset</title>
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
            <th>Kode Aset</th>
            <th>Tipe Aset</th>
            <th>Data Aset</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->kode_aset }}</td>
            <td>{{ $looping->tipe_aset }}</td>
            <td>{{ $looping->nama_aset }}<br>{{ $looping->stok_sekarang }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>