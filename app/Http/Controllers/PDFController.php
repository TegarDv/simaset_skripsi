<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public $formattedDate;

    public function __construct()
    {
        $this->formattedDate = Carbon::now()->locale('id')->translatedFormat('j F Y');
    }
    public function asset_print(Request $request)
    {
        $this->authorizeAdminOrSuperAdmin();
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
                $tanggal_awal = $request->tanggal_awal;
            } elseif ($request->tanggal_akhir) {
                $query->where('created_at', '<=', $request->tanggal_akhir);
                $tanggal_akhir = $request->tanggal_akhir;
            }
        }

        $tanggal_awal = $request->tanggal_awal ? $request->tanggal_awal : '-';
        $tanggal_akhir = $request->tanggal_akhir ? $request->tanggal_akhir : '-';

        $assets = $query->get();

        $assets->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [
            'title' => 'Laporan Data Aset',
            'desk' => 'Laporan data aset yang di buat pada tanggal ' .  $tanggal_awal . ' sampai tanggal ' . $tanggal_akhir,
            'date' => $this->formattedDate,
            'data' => $assets
        ];

        $pdf = PDF::loadView('pdf.assets', $data);
        return $pdf->download('Laporan Data Aset.pdf');
    }

    public function transaksi_print(Request $request)
    {
        $this->authorizeAdminOrSuperAdmin();
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

        $tanggal_awal = $request->tanggal_awal ? $request->tanggal_awal : '-';
        $tanggal_akhir = $request->tanggal_akhir ? $request->tanggal_akhir : '-';
        $tipe = $request->tipe_transaksi === 'all' ? 'Semua Kategori Transaksi' : ($request->tipe_transaksi ? $request->tipe_transaksi : 'Semua Kategori Transaksi');

        $data = [
            'title' => 'Laporan Data Transaksi Aset',
            'desk' => 'Laporan data transaksi aset ' . $tipe . ' yang di buat pada tanggal ' .  $tanggal_awal . ' sampai tanggal ' . $tanggal_akhir,
            'date' => $this->formattedDate,
            'data' => $get_data
        ];

        $pdf = PDF::loadView('pdf.transaksi', $data);
        return $pdf->download('Laporan Data Transaksi Aset.pdf');
    }

    public function activity_print(Request $request)
    {
        $this->authorizeSuperAdmin();

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

        $tanggal_awal = $request->tanggal_awal ? $request->tanggal_awal : '-';
        $tanggal_akhir = $request->tanggal_akhir ? $request->tanggal_akhir : '-';

        $data = [
            'title' => 'Laporan Aktivitas User Pada Sistem',
            'desk' => 'Laporan aktivitas user pada sistem yang di buat pada tanggal ' .  $tanggal_awal . ' sampai tanggal ' . $tanggal_akhir,
            'date' => $this->formattedDate,
            'data' => $get_data
        ];

        $pdf = PDF::loadView('pdf.activity', $data);
        return $pdf->download('Laporan Aktivitas User.pdf');
    }
}
