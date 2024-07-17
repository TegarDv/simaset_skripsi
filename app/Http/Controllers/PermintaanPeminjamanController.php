<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\LogUsers;
use App\Models\TransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\TrxPeminjamanController;
use Illuminate\Support\Facades\Log;

class PermintaanPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('permintaan_peminjaman.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Assets::all();
        return view('permintaan_peminjaman.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);
        $asset_data = Assets::where('kode_aset', $request->asset)->first();

        if ($request->jumlah > $asset_data->stok_sekarang) {
            return response()->json([
                'error' => true,
                'message' => 'Stock tidak mencukupi'
            ], 403);
        }

        $data = TransactionRequest::create([
            'asset_id' => $asset_data->id,
            'user_id' => $user_login->id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal_permintaan' => $request->tanggal,
            'status_permintaan' => 'pending',
            'catatan_permintaan' => 'Pemintaan telah disimpan',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $dataFormatted = "Asset ID: {$data->asset_id}\n" .
                        "User ID: {$data->user_id}\n" .
                        "Jumlah Peminjaman: {$data->jumlah}\n" .
                        "Keterangan: {$data->keterangan}\n" .
                        "Tanggal Permintaan: {$data->tanggal_permintaan}\n" .
                        "Status Permintaan: {$data->status_permintaan}\n" .
                        "Catatan Permintaan: {$data->catatan_permintaan}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Tambah Pemintaan Peminjaman',
            'detail'    => $dataFormatted,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        $data = TransactionRequest::findOrFail($id);
        return view('permintaan_peminjaman.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = TransactionRequest::findOrFail($id);
        if ($data->status_permintaan == 'disetujui') {
            return response()->json([
                'error' => true,
                'message' => 'Permintaan sudah disetujui, data tidak dapat di edit'
            ], 403);
        }
        $assets = Assets::all();
        $asset_select = Assets::findOrFail($data->asset_id);
        return view('permintaan_peminjaman.edit', compact('data', 'assets', 'asset_select'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = TransactionRequest::findOrFail($id);
        if ($data->status_permintaan == 'disetujui') {
            return response()->json([
                'error' => true,
                'message' => 'Permintaan sudah disetujui, data tidak dapat di edit'
            ], 403);
        }
        $asset_data = Assets::where('kode_aset', $request->asset)->first();
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        if ($request->jumlah > $asset_data->stok_sekarang) {
            return response()->json([
                'error' => true,
                'message' => 'Stock tidak mencukupi'
            ], 403);
        }

        $data->update([
            'asset_id' => $asset_data->id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal_permintaan' => $request->tanggal,
            'catatan_permintaan' => 'Pemintaan telah disimpan',
            'updated_at'        => now(),
        ]);

        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Asset ID: {$data_lama['asset_id']}\n" .
                            "User ID: {$data_lama['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_lama['jumlah']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_lama['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_lama['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_lama['catatan_permintaan']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Asset ID: {$data_baru['asset_id']}\n" .
                            "User ID: {$data_baru['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_baru['jumlah']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_baru['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_baru['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_baru['catatan_permintaan']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Pemintaan Peminjaman',
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
        $user_login = auth()->user();
        $data = TransactionRequest::findOrFail($id);

        if ($data->status_permintaan == 'disetujui') {
            return response()->json([
                'error' => true,
                'message' => 'Permintaan sudah disetujui, data tidak dapat di hapus'
            ], 403);
        }

        $dataFormatted = "Asset ID: {$data->asset_id}\n" .
                        "User ID: {$data->user_id}\n" .
                        "Jumlah Peminjaman: {$data->jumlah}\n" .
                        "Keterangan: {$data->keterangan}\n" .
                        "Tanggal Permintaan: {$data->tanggal_permintaan}\n" .
                        "Status Permintaan: {$data->status_permintaan}\n" .
                        "Catatan Permintaan: {$data->catatan_permintaan}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        $data->delete();

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Hapus Pemintaan Peminjaman',
            'detail'    => $dataFormatted,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    public function accept_store(Request $request, string $id, TrxPeminjamanController $trxPeminjamanController)
    {
        $user_login = auth()->user();
        $data = TransactionRequest::findOrFail($id);
        $asset_data = Assets::where('id', $data->asset_id)->first();
        if ($data->status_permintaan == 'disetujui') {
            return response()->json([
                'error' => true,
                'message' => 'Permintaan sudah disetujui, data tidak dapat di edit'
            ], 403);
        }
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');
        $this->validate($request, [
            'keterangan'    => 'required',
        ]);

        // Custom Request trxPeminjamanController Store
        $customRequest = new Request([
            'tanggal'    => $data->tanggal_permintaan,
            'user'       => $data->user_id,
            'jumlah'     => $data->jumlah,
            'asset'      => $asset_data->kode_aset,
            'keterangan' => $data->keterangan,
        ]);

        // Call trxPeminjamanController Store
        $response = $trxPeminjamanController->store($customRequest);
        $responseData = $response->getData(true);

        if ($responseData['error']) {
            return response()->json([
                'error' => true,
                'message' => $responseData['message']
            ], 403);
        }

        $data->update([
            'status_permintaan' => 'disetujui',
            'catatan_permintaan' => 'Permintaan disetujui. Kode transaksi anda xxx.' . "\n" . $request->keterangan,
            'updated_at'        => now(),
        ]);

        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        $oldDataFormatted = "Asset ID: {$data_lama['asset_id']}\n" .
                            "User ID: {$data_lama['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_lama['jumlah']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_lama['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_lama['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_lama['catatan_permintaan']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Asset ID: {$data_baru['asset_id']}\n" .
                            "User ID: {$data_baru['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_baru['jumlah']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_baru['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_baru['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_baru['catatan_permintaan']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Persetujuan Pemintaan Peminjaman',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error'   => false,
            'message' => 'Permintaan berhasil disetujui'
        ]);
    }

    public function reject_store(Request $request, string $id)
    {
        $user_login = auth()->user();
        $data = TransactionRequest::findOrFail($id);
        if ($data->status_permintaan == 'disetujui') {
            return response()->json([
                'error' => true,
                'message' => 'Permintaan sudah disetujui, data tidak dapat di edit'
            ], 403);
        }
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');
        $this->validate($request, [
            'keterangan'    => 'required',
        ]);

        $data->update([
            'status_permintaan' => 'ditolak',
            'catatan_permintaan' => 'Permintaan ditolak.' . "\n" . $request->keterangan,
            'updated_at'        => now(),
        ]);

        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        $oldDataFormatted = "Asset ID: {$data_lama['asset_id']}\n" .
                            "User ID: {$data_lama['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_lama['jumlah']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_lama['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_lama['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_lama['catatan_permintaan']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Asset ID: {$data_baru['asset_id']}\n" .
                            "User ID: {$data_baru['user_id']}\n" .
                            "Jumlah Peminjaman: {$data_baru['jumlah']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Tanggal Permintaan: {$data_baru['tanggal_permintaan']}\n" .
                            "Status Permintaan: {$data_baru['status_permintaan']}\n" .
                            "Catatan Permintaan: {$data_baru['catatan_permintaan']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Penolakan Pemintaan Peminjaman',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error'   => false,
            'message' => 'Permintaan berhasil ditolak'
        ]);
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:1',
            'asset'             => 'required',
            'keterangan'        => 'required',
        ]);
    }

    public function datatableJson()
    {
        if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            $assets = TransactionRequest::latest()->get();
        }  else {
            $user_login = auth()->user();
            $assets = TransactionRequest::where('user_id', $user_login->id)->latest()->get();
        }

        $data = [];
        foreach ($assets as $key => $asset) {
            // Btn
            if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
                $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            } else {
                $edit_btn = '';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            }

            // Status
            if ($asset->status_permintaan == 'pending') {
                $status_print = '<span class="badge rounded-pill border text-bg-warning">' . $asset->status_permintaan . '</span>';
            } elseif ($asset->status_permintaan == 'disetujui') {
                $status_print = '<span class="badge rounded-pill border text-bg-success">' . $asset->status_permintaan . '</span>';
            } elseif ($asset->status_permintaan == 'ditolak') {
                $status_print = '<span class="badge rounded-pill border text-bg-danger">' . $asset->status_permintaan . '</span>';
            } else {
                $status_print = '<span class="badge rounded-pill border text-bg-secondary">Unknow</span>';
            }
            $data[] = [
                'index' => $key + 1,
                'id' => $asset->id,
                'column2' => $asset->tanggal_permintaan . '<br>Oleh: ' . $asset->dataUser->name,
                'column3' => $asset->dataAsset->kode_aset,
                'column4' => $status_print,
                'column5' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
