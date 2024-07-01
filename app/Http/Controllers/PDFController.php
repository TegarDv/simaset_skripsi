<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorizeSuperAdmin();
            // $this->authorizeAdminOrSuperAdmin();
            // $this->authorizeAllUser();
            return $next($request);
        });
    }
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

    public function transaksi_print(Request $request)
    {
        $this->validate($request, [
            'tipe_transaksi'    => 'required',
            'tanggal_awal'      => 'nullable|date',
            'tanggal_akhir'     => 'nullable|date',
        ]);

        $query = AssetsTransaction::with('dataAsset' , 'dataUser');

        if ($request->tipe_transaksi && $request->tipe_transaksi != 'all') {
            $query->where('tipe_transaksi', $request->tipe_transaksi);
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

        $get_data = $query->get();

        $get_data->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [
            'title' => 'Print PDF',
            'date' => date('m/d/Y'),
            'data' => $get_data
        ];

        $pdf = PDF::loadView('pdf.transaksi', $data);
        return $pdf->download('print.pdf');
    }

    public function activity_print(Request $request)
    {
        $this->validate($request, [
            'tanggal_awal'      => 'nullable|date',
            'tanggal_akhir'     => 'nullable|date',
        ]);

        $query = LogUsers::with('data_user');

        if ($request->tanggal_awal || $request->tanggal_akhir) {
            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
            } elseif ($request->tanggal_awal) {
                $query->where('created_at', '>=', $request->tanggal_awal);
            } elseif ($request->tanggal_akhir) {
                $query->where('created_at', '<=', $request->tanggal_akhir);
            }
        }

        $get_data = $query->get();

        $get_data->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [
            'title' => 'Print PDF',
            'date' => date('m/d/Y'),
            'data' => $get_data
        ];

        $pdf = PDF::loadView('pdf.activity', $data);
        return $pdf->download('print.pdf');
    }
}
