<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

        Assets::create([
            'kode_aset'            => $request->kode_aset,
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

        return back()->with('success', 'Data Berhasil Disimpan!');
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
        $assets = Assets::findOrFail($id);
        return view('pengadaan.edit', compact('assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateData($request);

        Assets::update([
            'kode_aset'            => $request->kode_aset,
            'tipe_aset'            => $request->tipe_aset,
            'nama_aset'            => $request->nama_aset,
            'jumlah'               => $request->jumlah,
            'harga'                => $request->harga,
            'spesifikasi'          => $request->spesifikasi,
            'keterangan'           => $request->keterangan,
            'status'               => $request->status,
            'kondisi_aset'         => $request->kondisi_aset,
            'masa_berlaku'         => $request->masa_berlaku,
            'updated_at'           => now(),
        ]);

        return back()->with('success', 'Data Berhasil Disimpan!');
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
            'kode_aset'            => 'required',
            'tipe_aset'            => 'required',
            'nama_aset'            => 'required',
            'jumlah'               => 'required',
            'harga'                => 'required',
            'spesifikasi'          => 'required',
            'keterangan'           => 'required',
            'status'               => 'required',
            'kondisi_aset'         => 'required',
            'masa_berlaku'         => 'required',
        ]);
    }

    public function pengadaanJson()
    {
        $assets = Assets::select('id', 'kode_aset', 'tipe_aset', 'nama_aset', 'jumlah', 'harga', 'spesifikasi', 'keterangan', 'status', 'kondisi_aset', 'masa_berlaku', 'created_at', 'updated_at')->get();
        return response()->json([
            'data' => $assets,
        ]);
    }
}
