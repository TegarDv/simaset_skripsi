<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Label {{ $data->kode_aset ?? 'No Data' }}</title>
    <style>
        .label {
            border: 1px solid black;
            width: 300px;
            height: 100px;
            padding: 10px;
            font-family: Arial, sans-serif;
            position: relative;
        }
        .header {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            font-size: 12px;
        }
        .qr-code {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="label">
        <div class="header">
            {{ $data->kode_aset ?? '???' }}
        </div>
        <div class="content">
            <div>{{ $data->nama_aset ?? '???' }}</div>
            <div>Lokasi: {{ $data->dataLokasi->location ?? '???' }}</div>
            <div class="qr-code">{!! QrCode::size(60)->backgroundColor(255, 255, 255)->color(0, 0, 0)->margin(1)->generate($qr_link) !!}</div>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>