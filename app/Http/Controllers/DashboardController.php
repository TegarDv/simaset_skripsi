<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsRequest;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use App\Models\TransactionRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax() && $request->input('action') == 'get_kadaluarsa') {
            $assets = Assets::with(['dataStatus', 'dataKondisi', 'dataLokasi'])->where('masa_berlaku', '<=', now())->latest()->get();

            $data = $assets->map(function ($asset) {
                $asset->harga = number_format($asset->harga, 0, ',', '.');
                $asset->tanggal_penerimaan = Carbon::parse($asset->tanggal_penerimaan)->format('d F Y');
                $asset->masa_berlaku = Carbon::parse($asset->masa_berlaku)->format('d F Y');

                return [
                    'column2' => 'Nama: ' . $asset->nama_aset . '<br>Tipe: ' . $asset->tipe_aset . '<br>Lokasi: ' . $asset->dataLokasi->location . '<br>Harga: Rp ' . $asset->harga . '<br>Aset masuk pada: ' . $asset->tanggal_penerimaan,
                    'column3' => $asset->kode_aset,
                    'column4' => 'Masa berlaku: ' . $asset->masa_berlaku,
                    'column5' => '<span class="badge border text-bg-info">Segera lakukan pembaruan!</span>',
                ];
            });

            return response()->json(['data' => $data]);
        } elseif ($request->ajax() && $request->input('action') == 'get_deviasi') {
            $assets = Assets::with(['dataStatus', 'dataKondisi', 'dataLokasi'])->where('tipe_aset', 'fisik')->oldest('tanggal_penerimaan')->get();

            $data = $assets->map(function ($asset) {
                $years_since_received = now()->diffInYears($asset->tanggal_penerimaan);
                $deviasi_amount = $asset->harga;
                for ($i = 0; $i < $years_since_received; $i++) {
                    $deviasi_amount *= 0.9;
                }
                // $deviasi_amount = $asset->harga * pow(0.9, $years_since_received);
                $deviasi_percentage = (( $asset->harga - $deviasi_amount) / $asset->harga) * 100;

                $asset->harga = number_format($asset->harga, 0, ',', '.');
                $asset->tanggal_penerimaan = Carbon::parse($asset->tanggal_penerimaan)->format('d F Y');

                return [
                    'column2' => 'Nama: ' . $asset->nama_aset . '<br>Tipe: ' . $asset->tipe_aset . '<br>Lokasi: ' . $asset->dataLokasi->location . '<br>Harga: Rp ' . $asset->harga . '<br>Aset masuk pada: ' . $asset->tanggal_penerimaan,
                    'column3' => $asset->kode_aset,
                    'column4' => 'Kemungkinan harga saat ini: ' . $deviasi_amount . '<br>Penurunan: ' . $deviasi_percentage . '%',
                ];
            });

            return response()->json(['data' => $data]);
        } elseif ($request->ajax() && $request->input('action') == 'get_maintenance') {
            $assets = Assets::whereHas('dataKondisi', function ($query) {
                $query->where('kategori', 'rusak');
            })->latest('tanggal_penerimaan')->get();

            $data = $assets->map(function ($asset) {
                $biaya_perbaikan = $asset->harga * $asset->dataKondisi->biaya_perbaikan;
                $biaya_perbaikan_percentage = $asset->dataKondisi->biaya_perbaikan * 100;

                $asset->harga = number_format($asset->harga, 0, ',', '.');
                $asset->tanggal_penerimaan = Carbon::parse($asset->tanggal_penerimaan)->format('d F Y');

                return [
                    'column2' => 'Nama: ' . $asset->nama_aset . '<br>Tipe: ' . $asset->tipe_aset . '<br>Lokasi: ' . $asset->dataLokasi->location . '<br>Harga: Rp ' . $asset->harga . '<br>Aset masuk pada: ' . $asset->tanggal_penerimaan,
                    'column3' => $asset->kode_aset,
                    'column4' => '<span class="badge border text-bg-'. $asset->dataKondisi->color .'">' . $asset->dataKondisi->nama_status . '</span>',
                    'column5' => 'Biaya Perbaikan: ' . $biaya_perbaikan . '<br>Persentase: ' . $biaya_perbaikan_percentage . '%',
                ];
            });

            return response()->json(['data' => $data]);
        }
        $user_login = auth()->user();
        $asset_count = Assets::all()->count();
        $asset_sum = Assets::sum('harga');
        $asset_normal_count = Assets::whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'normal');
        })->count();
        $asset_rusak_count = Assets::whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'rusak');
        })->count();
        $aset_fisik_count = Assets::where('tipe_aset', 'fisik')->count();
        $aset_fisik_sum = Assets::where('tipe_aset', 'fisik')->sum('harga');
        $asset_fisik_normal_count = Assets::where('tipe_aset', 'fisik')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'normal');
        })->count();
        $asset_fisik_rusak_count = Assets::where('tipe_aset', 'fisik')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'rusak');
        })->count();
        $aset_layanan_count = Assets::where('tipe_aset', 'layanan')->count();
        $aset_layanan_sum = Assets::where('tipe_aset', 'layanan')->sum('harga');
        $asset_layanan_normal_count = Assets::where('tipe_aset', 'layanan')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'normal');
        })->count();
        $asset_layanan_rusak_count = Assets::where('tipe_aset', 'layanan')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'rusak');
        })->count();
        $aset_digital_count = Assets::where('tipe_aset', 'digital')->count();
        $aset_digital_sum = Assets::where('tipe_aset', 'digital')->sum('harga');
        $asset_digital_normal_count = Assets::where('tipe_aset', 'digital')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'normal');
        })->count();
        $asset_digital_rusak_count = Assets::where('tipe_aset', 'digital')->whereHas('dataKondisi', function ($query) {
            $query->where('kategori', 'rusak');
        })->count();
        $assets = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi')->latest()->take(5)->get();
        $assets_request = AssetsRequest::with('dataUser')->latest()->take(5)->get();
        $peminjaman_aset_request = TransactionRequest::with('dataAsset', 'dataUser')->latest()->take(5)->get();
        $transaksi = AssetsTransaction::with('dataAsset' , 'dataUser')->orderBy('tanggal_transaksi', 'asc')->take(5)->get();
        $log_user = LogUsers::with('data_user')->latest()->take(5)->get();
        return view('dashboard', [
            'user_login' => $user_login,
            'asset_count' => $asset_count,
            'asset_sum' => $asset_sum,
            'asset_normal_count' => $asset_normal_count,
            'asset_rusak_count' => $asset_rusak_count,
            'aset_fisik_count' => $aset_fisik_count,
            'aset_fisik_sum' => $aset_fisik_sum,
            'asset_fisik_normal_count' => $asset_fisik_normal_count,
            'asset_fisik_rusak_count' => $asset_fisik_rusak_count,
            'aset_layanan_count' => $aset_layanan_count,
            'aset_layanan_sum' => $aset_layanan_sum,
            'asset_layanan_normal_count' => $asset_layanan_normal_count,
            'asset_layanan_rusak_count' => $asset_layanan_rusak_count,
            'aset_digital_count' => $aset_digital_count,
            'aset_digital_sum' => $aset_digital_sum,
            'asset_digital_normal_count' => $asset_digital_normal_count,
            'asset_digital_rusak_count' => $asset_digital_rusak_count,
            'assets' => $assets,
            'assets_request' => $assets_request,
            'peminjaman_aset_request' => $peminjaman_aset_request,
            'transaksi' => $transaksi,
            'log_user' => $log_user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $data = Assets::where('kode_aset', $code)->first();
        if (!$data) {
            abort(404, 'Asset not found');
        }
        $qr_link = env('APP_URL') . '/qrcode/' .  $data->kode_aset;
        return view('qr_code_detail', compact('data', 'qr_link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
