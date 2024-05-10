<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asset = Assets::all();
        return view('pengadaan.index', ['assets' => $asset]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengadaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $tipePart = Str::upper(Str::substr($request->nama_aset, 0, 2));
        $lastAsset = Assets::latest()->first();
        $numberPart = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $kodeAset = "$typePart-$randomChars$datePart-$numberPart";

        Assets::create([
            'id_user'              => '1',
            'kode_aset'            => $kodeAset,
            'tipe_aset'            => $request->tipe_aset,
            'nama_aset'            => $request->nama_aset,
            'jumlah'               => $request->jumlah,
            'harga'                => $request->harga,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'status'               => $request->status,
            'kondisi_aset'         => $request->kondisi_aset,
            'masa_berlaku'         => $request->masa_berlaku,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // return back()->with('success', 'Data Berhasil Disimpan!');
        return response()->json([
            'error' => false,
            'toast' => 'success',
            'message' => 'Data Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Assets::findOrFail($id);
        return view('pengadaan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Assets::findOrFail($id);
        return view('pengadaan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateData($request);

        $aset = Assets::findOrFail($id);

        $aset->update([
            // 'kode_aset'            => $request->kode_aset,
            'nama_aset'            => $request->nama_aset,
            'tipe_aset'            => $request->tipe_aset,
            'jumlah'               => $request->jumlah,
            'harga'                => $request->harga,
            'status'               => $request->status,
            'kondisi_aset'         => $request->kondisi_aset,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'masa_berlaku'         => $request->masa_berlaku,
            'updated_at'           => now(),
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
        try {
            $data = Assets::findOrFail($id);
            $data->delete();
            
            return response()->json([
                'error' => false,
                'toast' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'toast' => 'danger',
                'message' => 'Error occurred while deleting data: ' . $e->getMessage()
            ]);
        }
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'nama_aset'     => 'required',
            'tipe_aset'     => 'required',
            'jumlah'        => 'required|numeric',
            'harga'         => 'required|numeric',
            'status'        => 'required|numeric',
            'kondisi_aset'  => 'required',
            'masa_berlaku'  => 'required|date',
            'spesifikasi'   => 'required',
            'keterangan'    => 'required',
        ]);
    }

    public function pengadaanJson()
    {
        $assets = Assets::select('id', 'kode_aset', 'tipe_aset', 'nama_aset', 'jumlah', 'harga', 'spesifikasi', 'keterangan', 'status', 'kondisi_aset', 'masa_berlaku', 'created_at', 'updated_at')
                        ->get()
                        ->map(function ($asset) {
                            return [
                                'id' => $asset->id,
                                'kode_aset' => $asset->kode_aset,
                                'tipe_aset' => $asset->tipe_aset,
                                'nama_aset' => $asset->nama_aset,
                                'jumlah' => $asset->jumlah,
                                'harga' => $asset->harga,
                                'spesifikasi' => $asset->spesifikasi,
                                'keterangan' => $asset->keterangan,
                                'status' => $asset->status,
                                'status_nama' => $asset->status_nama, // Accessing getStatusNamaAttribute
                                'status_color' => $asset->status_color, // Accessing getStatusColorAttribute
                                'kondisi_aset' => $asset->kondisi_aset,
                                'masa_berlaku' => $asset->masa_berlaku,
                                'created_at' => $asset->created_at,
                                'updated_at' => $asset->updated_at,
                            ];
                        });

        return response()->json([
            'data' => $assets,
        ]);
    }
}
