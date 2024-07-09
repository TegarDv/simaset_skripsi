<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetLocation;
use App\Models\Assets;
use App\Models\DataStatus;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asset = Assets::all();
        return view('pengadaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdminOrSuperAdmin();
        $status = DataStatus::all();
        $lokasi = AssetLocation::all();
        $user = User::all();
        return view('pengadaan.create', [
            'status' => $status,
            'lokasi' => $lokasi,
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOrSuperAdmin();
        $user_login = auth()->user();
        $this->validateData($request);

        if ($request->tipe_aset == 'fisik') {
            $typePart = 'FS';
        } elseif ($request->tipe_aset == 'digital') {
            $typePart = 'DG';
        } elseif ($request->tipe_aset == 'layanan') {
            $typePart = 'LY';
        }

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomChars = '';
        for ($i = 0; $i < 2; $i++) {
            $randomChars .= $characters[rand(0, strlen($characters) - 1)];
        }
        $datePart = now()->format('ymd');
        $numberPart = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $kodeAset = "$typePart-$randomChars$datePart-$numberPart";

        $data = Assets::create([
            'tipe_aset'            => $request->tipe_aset,
            'kode_aset'            => $kodeAset,
            'nama_aset'            => $request->nama_aset,
            'harga'                => $request->harga,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'stok_awal'            => $request->stok_awal,
            'stok_sekarang'        => $request->stok_awal,
            'masa_berlaku'         => $request->masa_berlaku,
            'tanggal_penerimaan'   => $request->tanggal_penerimaan,
            'status_aset'          => $request->status_aset,
            'kondisi_aset'         => $request->kondisi_aset,
            'lokasi_aset'          => $request->lokasi_aset,
            'pemilik_aset'         => $request->pemilik_aset,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // Format the data for logging
        $newDataFormatted = "Tipe Aset: {$data->tipe_aset}\n" .
                            "Kode Aset: {$data->kode_aset}\n" .
                            "Nama Aset: {$data->nama_aset}\n" .
                            "Harga: {$data->harga}\n" .
                            "Spesifikasi: {$data->spesifikasi}\n" .
                            "Keterangan: {$data->keterangan}\n" .
                            "Stok Awal: {$data->stok_awal}\n" .
                            "Stok Sekarang: {$data->stok_sekarang}\n" .
                            "Masa Berlaku: {$data->masa_berlaku}\n" .
                            "Tanggal Penerimaan: {$data->tanggal_penerimaan}\n" .
                            "Status Aset: {$data->status_aset}\n" .
                            "Kondisi Aset: {$data->kondisi_aset}\n" .
                            "Lokasi Aset: {$data->lokasi_aset}\n" .
                            "Pemilik Aset: {$data->pemilik_aset}\n" .
                            "Created At: {$data->created_at}\n" .
                            "Updated At: {$data->updated_at}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Tambah Aset',
            'detail'    => $newDataFormatted,
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
        $data = Assets::findOrFail($id);
        $status = DataStatus::all();
        return view('pengadaan.show', compact('data', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizeAdminOrSuperAdmin();
        $data = Assets::findOrFail($id);
        $status = DataStatus::all();
        $lokasi = AssetLocation::all();
        $pemilik = User::all();
        return view('pengadaan.edit', compact('data', 'status', 'lokasi', 'pemilik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorizeAdminOrSuperAdmin();
        $user_login = auth()->user();
        $this->validateData($request);

        $data = Assets::findOrFail($id);
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        $data->update([
            'tipe_aset'            => $request->tipe_aset,
            'nama_aset'            => $request->nama_aset,
            'harga'                => $request->harga,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'stok_sekarang'        => $request->stok_sekarang,
            'masa_berlaku'         => $request->masa_berlaku,
            'tanggal_penerimaan'   => $request->tanggal_penerimaan,
            'status_aset'          => $request->status_aset,
            'kondisi_aset'         => $request->kondisi_aset,
            'lokasi_aset'          => $request->lokasi_aset,
            'pemilik_aset'         => $request->pemilik_aset,
            'updated_at'           => now(),
        ]);
        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data_baru->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data_baru->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Tipe Aset: {$data_lama['tipe_aset']}\n" .
                            "Nama Aset: {$data_lama['nama_aset']}\n" .
                            "Harga: {$data_lama['harga']}\n" .
                            "Spesifikasi: {$data_lama['spesifikasi']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Stok Sekarang: {$data_lama['stok_sekarang']}\n" .
                            "Masa Berlaku: {$data_lama['masa_berlaku']}\n" .
                            "Tanggal Penerimaan: {$data_lama['tanggal_penerimaan']}\n" .
                            "Status Aset: {$data_lama['status_aset']}\n" .
                            "Kondisi Aset: {$data_lama['kondisi_aset']}\n" .
                            "Lokasi Aset: {$data_lama['lokasi_aset']}\n" .
                            "Pemilik Aset: {$data_lama['pemilik_aset']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: " . ($data_lama['updated_at'] ?? 'N/A');

        $newDataFormatted = "Tipe Aset: {$data_baru['tipe_aset']}\n" .
                            "Nama Aset: {$data_baru['nama_aset']}\n" .
                            "Harga: {$data_baru['harga']}\n" .
                            "Spesifikasi: {$data_baru['spesifikasi']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Stok Sekarang: {$data_baru['stok_sekarang']}\n" .
                            "Masa Berlaku: {$data_baru['masa_berlaku']}\n" .
                            "Tanggal Penerimaan: {$data_baru['tanggal_penerimaan']}\n" .
                            "Status Aset: {$data_baru['status_aset']}\n" .
                            "Kondisi Aset: {$data_baru['kondisi_aset']}\n" .
                            "Lokasi Aset: {$data_baru['lokasi_aset']}\n" .
                            "Pemilik Aset: {$data_baru['pemilik_aset']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: " . ($data_baru['updated_at'] ?? 'N/A');

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Aset',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error' => false,
            'toast' => 'success',
            'message' => 'Data Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizeAdminOrSuperAdmin();
        $data = Assets::findOrFail($id);
        $data->delete();
        
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'tipe_aset'             => 'required',
            'nama_aset'             => 'required',
            'harga'                 => 'required|numeric',
            'spesifikasi'           => 'required',
            'keterangan'            => 'required',
            'stok_awal'             => 'required',
            'stok_sekarang'         => 'nullable',
            'masa_berlaku'          => 'required|date',
            'tanggal_penerimaan'    => 'required|date',
            'status_aset'           => 'required|numeric',
            'kondisi_aset'          => 'required',
            'lokasi_aset'           => 'required',
            'pemilik_aset'          => 'required',
        ]);
    }

    public function pengadaanJson()
    {
        $assets = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi')->get();

        $assets->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        return response()->json([
            'data' => $assets,
        ]);
    }

    public function pengadaanDataTableJson()
    {
        $assets = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi')->get();

        $assets->each(function ($asset) {
            $asset->append('status_nama', 'status_color');
        });

        $data = [];
        foreach ($assets as $key => $asset) {
            if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
                $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            } else {
                $edit_btn = '';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '';
            }
            $data[] = [
                'index' => $key + 1,
                'id' => $asset->id,
                'column2_aset' => $asset->kode_aset,
                'column3_aset' => 'Nama: ' . $asset->nama_aset . '<br>Tipe: ' . $asset->tipe_aset . '<br>Sisa stok: ' . $asset->stok_sekarang . '<br>Harga: ' . $asset->harga,
                'column4_aset' => 'Masa berlaku: ' . $asset->masa_berlaku . '<br>Dibuat pada: ' . $asset->created_at . '<br>Terakhir di update: ' . $asset->updated_at,
                'column5_aset' => '<span class="badge rounded-pill border text-bg-' . $asset->status_color . '">' . $asset->status_nama . '</span>',
                'column6_aset' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
