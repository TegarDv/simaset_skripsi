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
    /**
     * Display a listing of the resource.
     */
    public function laporan_aset()
    {
        return view('laporan.assets');
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
        return view('laporan.transaksi');
    }

    public function laporan_transaksi_create()
    {
        return view('laporan.transaksi_create');
    }

    public function laporan_activity()
    {
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
        foreach ($assets as $key => $asset) {
            $data[] = [
                'index' => $key + 1,
                'id' => $asset->id,
                'column2_table' => $asset->kode_aset,
                'column3_table' => 'Nama: ' . $asset->nama_aset . "<br>" . 'Tipe: ' . $asset->tipe_aset . "<br>" . 'Sisa stok: ' . $asset->stok_sekarang . "<br>" . 'Harga: ' . $asset->harga . "<br>" . 'Tipe: ' . $asset->tipe_aset,
                'column4_table' => 'Masa berlaku: ' . $asset->masa_berlaku . "<br>" . 'Dibuat pada: ' . $asset->created_at . "<br>" . 'Terakhir di update: ' . $asset->updated_at,
                'column5_table' => '<span class="badge rounded-pill border text-bg-' . $asset->status_color . '">' . $asset->status_nama . '</span>',
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
        foreach ($get_data as $key => $loop) {
            $data[] = [
                'index' => $key + 1,
                'id' => $loop->id,
                'column2_table' => $loop->tanggal_transaksi,
                'column3_table' => $loop->tipe_transaksi,
                'column4_table' => $loop->kode_transaksi,
                'column5_table' => $loop->dataAsset->kode_aset,
                'column6_table' => $loop->stok,
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
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
