<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
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

    public function laporan_transaksi()
    {
        return view('laporan.transaksi');
    }

    public function laporan_activity()
    {
        return view('laporan.log_aktivitas');
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
                'column2_aset' => $asset->kode_aset,
                'column3_aset' => 'Nama: ' . $asset->nama_aset . "\n" . 'Tipe: ' . $asset->tipe_aset . "\n" . 'Sisa stok: ' . $asset->stok_sekarang . "\n" . 'Harga: ' . $asset->harga . "\n" . 'Tipe: ' . $asset->tipe_aset,
                'column4_aset' => 'Masa berlaku: ' . $asset->masa_berlaku . "\n" . 'Dibuat pada: ' . $asset->created_at . "\n" . 'Terakhir di update: ' . $asset->updated_at,
                'column5_aset' => '<span class="badge rounded-pill border text-bg-' . $asset->status_color . '">' . $asset->status_nama . '</span>',
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
                'column3_table' => $loop_data->action . "\n" . 'Oleh: ' . $loop_data->data_user->name,
                'column4_table' => 'Detail: ' . $loop_data->detail,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
