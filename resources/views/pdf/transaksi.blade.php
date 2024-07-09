<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        /* Define styles for table-bordered class */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd; /* Border color */
            padding: 8px; /* Padding inside cells */
        }
        .table-bordered th {
            background-color: #f2f2f2; /* Header background color */
        }
    </style>
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