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
            <th>Kode Aset</th>
            <th>Tipe Aset</th>
            <th>Data Aset</th>
            <th>Stok Aset</th>
            <th>Kondisi & Status</th>
            <th>Spesifikasi</th>
            <th>Keterangan</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->kode_aset }}</td>
            <td>{{ $looping->tipe_aset }}</td>
            <td>Nama: {{ $looping->nama_aset }}<br>Harga: {{ $looping->harga }}<br>Masa berlaku: {{ $looping->masa_berlaku }}<br>Tanggal Penerimaan: {{ $looping->tanggal_penerimaan }}<br>Pemilik Aset: {{ $looping->dataUser->name }}</td>
            <td>Stok awal: {{ $looping->stok_awal }}<br>Stok sekarang: {{ $looping->stok_sekarang }}</td>
            <td>Kondisi: {{ $looping->dataKondisi->nama_status }}<br>Status: {{ $looping->dataStatus->nama_status }}</td>
            <td>{!! $looping->spesifikasi !!}</td>
            <td>{!! $looping->keterangan !!}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>