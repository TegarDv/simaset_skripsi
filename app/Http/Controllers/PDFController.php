<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function asset_print(Request $request)
    {
        $this->validate($request, [
            'tipe_aset'         => 'required',
            'status_aset'       => 'required',
            'tanggal_awal'      => 'nullable|date',
            'tanggal_akhir'     => 'nullable|date',
        ]);

        $query = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi');

        if ($request->tipe_aset && $request->tipe_aset != 'all') {
            $query->where('tipe_aset', $request->tipe_aset);
        }

        if ($request->status_aset && $request->status_aset != 'all') {
            $query->where('status_aset', $request->status_aset);
        }

        if ($request->tanggal_awal || $request->tanggal_akhir) {
            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
            } elseif ($request->tanggal_awal) {
                $query->where('created_at', '>=', $request->tanggal_awal);
            } elseif ($request->tanggal_akhir) {
                $query->where('created_at', '<=', $request->tanggal_akhir);
            }
        }

        $assets = $query->get();

        $assets->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [
            'title' => 'Print PDF',
            'date' => date('m/d/Y'),
            'data' => $assets
        ];

        $pdf = PDF::loadView('pdf.assets', $data);
        return $pdf->download('print.pdf');
    }



    public function generatePDF()
    {
        $users = User::get();
        $data = [
            'title' => 'Print PDF',
            'date' => date('m/d/Y'),
            'users' => $users
        ]; 
        $pdf = PDF::loadView('pdf.example', $data);
        return $pdf->download('print.pdf');
    }
}
