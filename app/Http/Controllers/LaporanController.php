<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsTransaction;
use App\Models\DataStatus;
use App\Models\LogUsers;
use Illuminate\Http\Request;

class LaporanController extends Controller
{    
    public function laporan_aset()
    {
        $this->authorizeAdminOrSuperAdmin();
        $status = DataStatus::all();
        return view('laporan.assets', [
            'status' => $status,
        ]);
    }

    public function laporan_aset_create()
    {
        $status = DataStatus::all();
        return view('laporan.assets_create', [
            'status' => $status,
        ]);
    }

    public function laporan_transaksi()
    {
        $this->authorizeAdminOrSuperAdmin();
        return view('laporan.transaksi');
    }

    public function laporan_transaksi_create()
    {
        return view('laporan.transaksi_create');
    }

    public function laporan_activity()
    {
        $this->authorizeSuperAdmin();
        return view('laporan.log_aktivitas');
    }

    public function laporan_activity_create()
    {
        return view('laporan.log_aktivitas_create');
    }

    public function AsetDatatableJson()
    {
        $assets = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi')->get();

        $assets->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [];
        foreach ($assets as $key => $loop_data) {
            $data[] = [
                'index' => $key + 1,
                'id' => $loop_data->id,
                'column2_table' => $loop_data->kode_aset,
                'column3_table' => 'Nama: ' . $loop_data->nama_aset . "<br>" . 'Tipe: ' . $loop_data->tipe_aset . "<br>" . 'Sisa stok: ' . $loop_data->stok_sekarang . "<br>" . 'Harga: ' . $loop_data->harga . "<br>" . 'Tipe: ' . $loop_data->tipe_aset,
                'column4_table' => '<span class="badge rounded-pill border text-bg-' . $loop_data->status_color . '">' . $loop_data->status_nama . '</span>',
                'column5_table' => 'Masa berlaku: ' . $loop_data->masa_berlaku . "<br>" . 'Dibuat pada: ' . $loop_data->created_at . "<br>" . 'Terakhir di update: ' . $loop_data->updated_at,
                'created_at' => $loop_data->created_at,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function laporanTrxJson()
    {
        $get_data = AssetsTransaction::with('dataAsset' , 'dataUser')->orderBy('tanggal_transaksi', 'asc')->get();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $data[] = [
                'index' => $key + 1,
                'id' => $loop_data->id,
                'column2_table' => $loop_data->tanggal_transaksi,
                'column3_table' => $loop_data->tipe_transaksi,
                'column4_table' => $loop_data->kode_transaksi,
                'column5_table' => $loop_data->dataAsset->kode_aset,
                'column6_table' => $loop_data->stok,
                'created_at' => $loop_data->created_at,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function laporanActivityJson()
    {
        $get_data = LogUsers::with('data_user')->get();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $data[] = [
                'index' => $key + 1,
                'id' => $loop_data->id,
                'column2_table' => 'Tanggal tindakan: ' . $loop_data->created_at,
                'column3_table' => $loop_data->action . "<br>" . 'Oleh: ' . $loop_data->data_user->name,
                'column4_table' => 'Detail: ' . $loop_data->detail,
                'created_at' => $loop_data->created_at,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
