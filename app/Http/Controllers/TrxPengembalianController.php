<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrxPengembalianController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->authorizeSuperAdmin();
            // $this->authorizeAdminOrSuperAdmin();
            $this->authorizeAllUser();
            return $next($request);
        });
    }
    public function index()
    {
        return view('transaksi_pengembalian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Assets::all();
        $users = User::all();
        return view('transaksi_pengembalian.create', compact('assets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $typePart = 'TRX-PNG';
        $randomChars = strtoupper(str_shuffle(preg_replace('/[^A-Z]/', '', Str::random(3))));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomChars = '';
        for ($i = 0; $i < 2; $i++) {
            $randomChars .= $characters[rand(0, strlen($characters) - 1)];
        }
        $datePart = now()->format('ymd');
        $numberPart = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $kode = "$typePart-$randomChars$datePart-$numberPart";
        $asset_data = Assets::where('kode_aset', $request->asset)->first();

        if (($request->jumlah + $asset_data->stok_sekarang) > $asset_data->stok_awal) {
            return response()->json([
                'error' => true,
                'message' => 'Stock melebihi stock awal'
            ], 403);
        }

        $data = AssetsTransaction::create([
            'asset_id'          => $asset_data->id,
            'user_id'           => $request->user,
            'tipe_transaksi'    => 'pengembalian',
            'kode_transaksi'    => $kode,
            'stok'              => $request->jumlah,
            'stok_sebelum'      => $asset_data->stok_sekarang,
            'stok_sesudah'      => $asset_data->stok_sekarang - $request->jumlah,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $asset_data->update([
            'stok_sekarang'        => $asset_data->stok_sekarang + $request->jumlah,
            'updated_at'           => now(),
        ]);

        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah Transaksi Pengembalian',
            'detail'                => $data,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        // return back()->with('success', 'Data Berhasil Disimpan!');
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = AssetsTransaction::findOrFail($id);
        return view('transaksi_pengembalian.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AssetsTransaction::findOrFail($id);
        $assets = Assets::all();
        $asset_select = Assets::findOrFail($data->asset_id);
        $users = User::all();
        return view('transaksi_pengembalian.edit', compact('data', 'assets', 'users', 'asset_select'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetsTransaction::findOrFail($id);
        $asset_data_lama = Assets::findOrFail($data->asset_id);
        $asset_data_baru = Assets::where('kode_aset', $request->asset)->first();
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        if ($request->jumlah > $asset_data_baru->stok_sekarang) {
            return response()->json([
                'error' => true,
                'message' => 'Stock melebihi stock awal'
            ], 403);
        }

        $asset_data_lama->update([
            'stok_sekarang' => $asset_data_lama->stok_sekarang - $data->stok,
        ]);

        $data->update([
            'asset_id'          => $asset_data_baru->id,
            'user_id'           => $request->user,
            'stok'              => $request->jumlah,
            'stok_sesudah'      => $asset_data_baru->stok_sekarang + $request->jumlah,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal,
            'updated_at'        => now(),
        ]);

        $asset_data_baru2 = Assets::where('kode_aset', $request->asset)->first();
        $asset_data_baru2->update([
            'stok_sekarang' => $asset_data_baru2->stok_sekarang + $request->jumlah,
            'updated_at'    => now(),
        ]);

        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Asset ID: {$data_lama['asset_id']}\n" .
                            "User ID: {$data_lama['user_id']}\n" .
                            "Stok: {$data_lama['stok']}\n" .
                            "Stok Sebelum: {$data_lama['stok_sebelum']}\n" .
                            "Stok Sesudah: {$data_lama['stok_sesudah']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Tanggal Transaksi: {$data_lama['tanggal_transaksi']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Asset ID: {$data_baru['asset_id']}\n" .
                            "User ID: {$data_baru['user_id']}\n" .
                            "Stok: {$data_baru['stok']}\n" .
                            "Stok Sebelum: {$data_baru['stok_sebelum']}\n" .
                            "Stok Sesudah: {$data_baru['stok_sesudah']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Tanggal Transaksi: {$data_baru['tanggal_transaksi']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Transaksi Pengembalian',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error'   => false,
            'message' => 'Data Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = AssetsTransaction::findOrFail($id);
        $asset_data_lama = Assets::findOrFail($data->asset_id);
        $asset_data_lama->update([
            'stok_sekarang'        => $asset_data_lama->stok_sekarang - $data->stok,
        ]);
        $data->delete();
        
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'tanggal'           => 'required|date',
            'user'              => 'required|integer|min:1',
            'jumlah'            => 'required|integer|min:1',
            'asset'             => 'required',
            'keterangan'        => 'required',
        ]);
    }

    public function trxKembaliDataTableJson()
    {
        if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            $get_data = AssetsTransaction::with('dataAsset' , 'dataUser')->where('tipe_transaksi', 'pengembalian')->orderBy('tanggal_transaksi', 'asc')->get();
        }  else {
            $user_login = auth()->user();
            $get_data = AssetsTransaction::with('dataAsset' , 'dataUser')->where('tipe_transaksi', 'pengembalian')->where('user_id', $user_login->id)->orderBy('tanggal_transaksi', 'asc')->get();
        }

        $data = [];
        foreach ($get_data as $key => $loop) {
            if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
                $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $loop->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $loop->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $loop->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            } else {
                $edit_btn = '';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $loop->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '';
            }
            $data[] = [
                'index' => $key + 1,
                'id' => $loop->id,
                'column2_trx' => $loop->tanggal_transaksi,
                'column3_trx' => $loop->kode_transaksi,
                'column4_trx' => $loop->dataAsset->kode_aset,
                'column5_trx' => $loop->stok,
                'column6_trx' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
