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