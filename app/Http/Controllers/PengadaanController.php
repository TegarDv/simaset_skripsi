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

        $randomChars = strtoupper(str_shuffle(preg_replace('/[^A-Z]/', '', Str::random(3))));

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
        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah Aset',
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
        $data_lama = $data->replicate();

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
        $data_baru = $data;

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Aset',
            'detail'    => 'Old Data: ' . json_encode($data_lama->toArray()) . "\n" . 'Update to' . "\n" . 'New Data: ' . json_encode($data_baru->toArray()),
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
