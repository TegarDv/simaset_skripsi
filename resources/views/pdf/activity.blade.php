<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Aktivitas</title>
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
            <th>Tanggal</th>
            <th>Tindakan</th>
            <th>User</th>
            <th>Detail</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->created_at }}</td>
            <td>{{ $looping->action }}</td>
            <td>{{ $looping->data_user->name }}</td>
            <td>{{ $looping->detail }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>