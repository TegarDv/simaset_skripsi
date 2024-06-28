<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetLocation;
use App\Models\AssetsRequest;
use App\Models\DataStatus;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AssetsRequest::all();
        return view('permintaan.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permintaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetsRequest::create([
            'tipe_aset'            => $request->tipe_aset,
            'nama_aset'            => $request->nama_aset,
            'harga'                => $request->harga,
            'stok_permintaan'      => $request->stok_permintaan,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'pemilik_aset'         => $user_login->id,
            'masa_berlaku'         => $request->masa_berlaku,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah Permintaan Aset',
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
        $data = AssetsRequest::findOrFail($id);
        return view('permintaan.show', compact('data', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AssetsRequest::findOrFail($id);
        return view('permintaan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetsRequest::findOrFail($id);
        $data_lama = $data->replicate();

        $data->update([
            'tipe_aset'            => $request->tipe_aset,
            'nama_aset'            => $request->nama_aset,
            'harga'                => $request->harga,
            'stok_permintaan'      => $request->stok_permintaan,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'masa_berlaku'         => $request->masa_berlaku,
            'updated_at'           => now(),
        ]);
        $data_baru = $data;

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Permintaan Aset',
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
        try {
            $data = AssetsRequest::findOrFail($id);
            $data->delete();
            
            return response()->json([
                'error' => false,
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error occurred while deleting data: ' . $e->getMessage()
            ]);
        }
    }

    public function accept_asset(string $id)
    {
        $data = AssetsRequest::findOrFail($id);
        $status = DataStatus::all();
        $lokasi = AssetLocation::all();
        $user = User::all();
        return view('permintaan.accept', compact('data', 'status', 'lokasi', 'user'));
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'tipe_aset'             => 'required',
            'nama_aset'             => 'required',
            'harga'                 => 'required|numeric',
            'spesifikasi'           => 'required',
            'keterangan'            => 'required',
            'stok_permintaan'       => 'nullable',
            'masa_berlaku'          => 'required|date',
        ]);
    }

    public function datatableJson()
    {
        $assets = AssetsRequest::all();

        $data = [];
        foreach ($assets as $key => $asset) {
            $edit_btn = '<button class="btn btn-sm btn-label-secondary m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '<button class="btn btn-sm btn-label-secondary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye text-light"></i></button>';
            $delete_btn = '<button class="btn btn-sm btn-label-secondary m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3 text-light"></i></button>';
            $accept_btn = '<button class="btn btn-sm btn-label-success m-1 accept-app-btn" data-app-id="' . $asset->id . '" title="accept">Setujui permintaan</button>';
            $data[] = [
                'index' => $key + 1,
                'id' => $asset->id,
                'column2_aset' => 'Permintaan pada: ' . $asset->created_at . '<br>Terakhir di update: ' . $asset->updated_at,
                'column3_aset' => 'Nama: ' . $asset->nama_aset . '<br>Stok Permintaan: ' . $asset->stok_permintaan . '<br>Harga: ' . $asset->harga,
                'column4_aset' => $asset->tipe_aset,
                'column5_aset' => $edit_btn . $read_btn . $delete_btn . $accept_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
