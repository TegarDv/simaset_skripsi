<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function show()
    {
        return QrCode::size(200)
        ->backgroundColor(255, 255, 255)
        ->color(0, 0, 0)
        ->margin(1)
        ->generate(
            'https://example.com/',
        );
    }

    public function download()
    {
        return response()->streamDownload(
            function () {
                echo QrCode::size(200)
                    ->format('png')
                    ->generate('https://example.com');
            },
            'qr-code.png',
            [
                'Content-Type' => 'image/png',
            ]
        );
    }
}
