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
            <th>Tanggal</th>
            <th>Tindakan</th>
            <th>User</th>
            <th>Detail</th>
        </tr>
        @foreach($data as $looping)
        <tr>
            <td>{{ $looping->created_at }}</td>
            <td>{{ $looping->action }}</td>
            <td>
                Nama: {{ $looping->data_user->name }}<br>
                Email: {{ $looping->data_user->email }}<br>
                Username: {{ $looping->data_user->username }}<br>
            </td>
            <td>{{ $looping->detail }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>