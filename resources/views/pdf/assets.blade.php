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