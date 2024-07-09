<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetLocation;
use App\Models\Assets;
use App\Models\AssetsRequest;
use App\Models\DataStatus;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorizeAllUser();
            return $next($request);
        });
    }
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

        $dataFormatted = "Tipe Aset: {$data->tipe_aset}\n" .
                        "Nama Aset: {$data->nama_aset}\n" .
                        "Harga: {$data->harga}\n" .
                        "Stok Permintaan: {$data->stok_permintaan}\n" .
                        "Spesifikasi: {$data->spesifikasi}\n" .
                        "Keterangan: {$data->keterangan}\n" .
                        "Pemilik Aset: {$data->pemilik_aset}\n" .
                        "Masa Berlaku: {$data->masa_berlaku}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Tambah Permintaan Aset',
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
        $data = AssetsRequest::findOrFail($id);
        return view('permintaan.show', compact('data'));
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
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

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
        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Tipe Aset: {$data_lama['tipe_aset']}\n" .
                            "Nama Aset: {$data_lama['nama_aset']}\n" .
                            "Harga: {$data_lama['harga']}\n" .
                            "Stok Permintaan: {$data_lama['stok_permintaan']}\n" .
                            "Spesifikasi: {$data_lama['spesifikasi']}\n" .
                            "Keterangan: {$data_lama['keterangan']}\n" .
                            "Masa Berlaku: {$data_lama['masa_berlaku']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: " . $data_lama['updated_at'];

        $newDataFormatted = "Tipe Aset: {$data_baru['tipe_aset']}\n" .
                            "Nama Aset: {$data_baru['nama_aset']}\n" .
                            "Harga: {$data_baru['harga']}\n" .
                            "Stok Permintaan: {$data_baru['stok_permintaan']}\n" .
                            "Spesifikasi: {$data_baru['spesifikasi']}\n" .
                            "Keterangan: {$data_baru['keterangan']}\n" .
                            "Masa Berlaku: {$data_baru['masa_berlaku']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: " . $data_baru['updated_at'];

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Permintaan Aset',
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
        $data = AssetsRequest::findOrFail($id);

        $dataFormatted = "Tipe Aset: {$data->tipe_aset}\n" .
                        "Nama Aset: {$data->nama_aset}\n" .
                        "Harga: {$data->harga}\n" .
                        "Spesifikasi: {$data->spesifikasi}\n" .
                        "Keterangan: {$data->keterangan}\n" .
                        "Stok Permintaan: {$data->stok_permintaan}\n" .
                        "Pemilik Aset: {$data->pemilik_aset}\n" .
                        "Masa Berlaku: {$data->masa_berlaku}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        $data->delete();

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Hapus Permintaan Aset',
            'detail'    => $dataFormatted,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    public function accept_asset(string $id)
    {
        $data = AssetsRequest::findOrFail($id);
        $status = DataStatus::all();
        $lokasi = AssetLocation::all();
        $user = User::all();
        return view('permintaan.accept', compact('data', 'status', 'lokasi', 'user'));
    }

    public function accept_store(Request $request, string $id)
    {
        $user_login = auth()->user();
        $data = AssetsRequest::findOrFail($id);
        $this->validate($request, [
            'tanggal_penerimaan'    => 'required|date',
            'status_aset'           => 'required|numeric',
            'kondisi_aset'          => 'required|numeric',
            'lokasi_aset'           => 'required|numeric',
        ]);

        // Determine asset type code part
        if ($data->tipe_aset == 'fisik') {
            $typePart = 'FS';
        } elseif ($data->tipe_aset == 'digital') {
            $typePart = 'DG';
        } elseif ($data->tipe_aset == 'layanan') {
            $typePart = 'LY';
        }

        // Generate random characters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomChars = '';
        for ($i = 0; $i < 2; $i++) {
            $randomChars .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Generate code parts
        $datePart = now()->format('ymd');
        $numberPart = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $kodeAset = "$typePart-$randomChars$datePart-$numberPart";

        $asset = Assets::create([
            'tipe_aset'            => $data->tipe_aset,
            'kode_aset'            => $kodeAset,
            'nama_aset'            => $data->nama_aset,
            'harga'                => $data->harga,
            'spesifikasi'          => $data->spesifikasi,
            'keterangan'           => $data->keterangan,
            'stok_awal'            => $data->stok_permintaan,
            'stok_sekarang'        => $data->stok_permintaan,
            'masa_berlaku'         => $data->masa_berlaku,
            'tanggal_penerimaan'   => $request->tanggal_penerimaan,
            'status_aset'          => $request->status_aset,
            'kondisi_aset'         => $request->kondisi_aset,
            'lokasi_aset'          => $request->lokasi_aset,
            'pemilik_aset'         => $data->pemilik_aset,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $assetFormatted = "Tipe Aset: {$asset->tipe_aset}\n" .
                        "Kode Aset: {$asset->kode_aset}\n" .
                        "Nama Aset: {$asset->nama_aset}\n" .
                        "Harga: {$asset->harga}\n" .
                        "Spesifikasi: {$asset->spesifikasi}\n" .
                        "Keterangan: {$asset->keterangan}\n" .
                        "Stok Awal: {$asset->stok_awal}\n" .
                        "Stok Sekarang: {$asset->stok_sekarang}\n" .
                        "Masa Berlaku: {$asset->masa_berlaku}\n" .
                        "Tanggal Penerimaan: {$asset->tanggal_penerimaan}\n" .
                        "Status Aset: {$asset->status_aset}\n" .
                        "Kondisi Aset: {$asset->kondisi_aset}\n" .
                        "Lokasi Aset: {$asset->lokasi_aset}\n" .
                        "Pemilik Aset: {$asset->pemilik_aset}\n" .
                        "Created At: " . $asset->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $asset->updated_at->format('d/M/Y H:i');
        
        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Persetujuan Tambah Aset',
            'detail'                => "Aset Baru Dari Permintaan:\n{$assetFormatted}",
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
        $data->delete();
        
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Ditambahkan'
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
            'stok_permintaan'       => 'nullable',
            'masa_berlaku'          => 'required|date',
        ]);
    }

    public function datatableJson()
    {
        if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            $assets = AssetsRequest::latest()->get();
        }  else {
            $user_login = auth()->user();
            $assets = AssetsRequest::where('pemilik_aset', $user_login->id)->latest()->get();
        }

        $data = [];
        foreach ($assets as $key => $asset) {
            if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
                $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
                $accept_btn = '<button class="btn btn-sm btn-label-success m-1 accept-app-btn" data-app-id="' . $asset->id . '" title="accept">Setujui permintaan</button>';
            } else {
                $edit_btn = '';
                $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
                $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
                $accept_btn = '';
            }
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
