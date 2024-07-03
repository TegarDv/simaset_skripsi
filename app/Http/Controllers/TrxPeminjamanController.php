<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrxPeminjamanController extends Controller
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
        return view('transaksi_peminjaman.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Assets::all();
        $users = User::all();
        return view('transaksi_peminjaman.create', compact('assets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $typePart = 'TRX-PMJ';
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

        if ($request->jumlah > $asset_data->stok_sekarang) {
            return response()->json([
                'error' => true,
                'message' => 'Stock tidak mencukupi'
            ], 403);
        }

        $data = AssetsTransaction::create([
            'asset_id'          => $asset_data->id,
            'user_id'           => $request->user,
            'tipe_transaksi'    => 'peminjaman',
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
            'stok_sekarang'        => $asset_data->stok_sekarang - $request->jumlah,
            'updated_at'           => now(),
        ]);

        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah Transaksi Peminjaman',
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
        //
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
        return view('transaksi_peminjaman.edit', compact('data', 'assets', 'users', 'asset_select'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetsTransaction::findOrFail($id);
        $asset_data = Assets::where('kode_aset', $request->asset)->first();
        $data_lama = $data->replicate();

        if ($request->jumlah > $asset_data->stok_sekarang) {
            return response()->json([
                'error' => true,
                'message' => 'Stock tidak mencukupi'
            ], 403);
        }

        if ($request->new_password == null) {
            $password = $data->password;
        } else {
            $password = Hash::make($request->new_password);
        }
        $data->update([
            'asset_id'          => $asset_data->id,
            'user_id'           => $request->user,
            'stok'              => $request->jumlah,
            'stok_sesudah'      => $asset_data->stok_sebelum - $request->jumlah,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal,
            'updated_at'        => now(),
        ]);
        $data_baru = $data;

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update User',
            'detail'    => 'Old Data: ' . json_encode($data_lama->toArray()) . "\n" . 'Update to' . "\n" . 'New Data: ' . json_encode($data_baru->toArray()),
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
        //
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

    public function trxPinjamDataTableJson()
    {
        $get_data = AssetsTransaction::with('dataAsset' , 'dataUser')->where('tipe_transaksi', 'peminjaman')->orderBy('tanggal_transaksi', 'asc')->get();

        $data = [];
        foreach ($get_data as $key => $loop) {
            $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $loop->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $loop->id . '" title="View"><i class="bi bi-eye"></i></button>';
            $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $loop->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
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
