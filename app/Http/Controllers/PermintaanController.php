<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetsRequest;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AssetsRequest::all();
        return view('pengadaan.index', ['data' => $data]);
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = AssetsRequest::findOrFail($id);
        return view('pengadaan.show', compact('data', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AssetsRequest::findOrFail($id);
        return view('pengadaan.edit', compact('data'));
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
            $data[] = [
                'index' => $key + 1,
                'id' => $asset->id,
                'column2_aset' => '<div class="text-light">' . $asset->location . '</div>',
                'column3_aset' => '<div class="text-light">Dibuat pada: ' . $asset->created_at . '<br>Terakhir di update: ' . $asset->updated_at . '</div>',
                'column4_aset' => '<button class="btn btn-sm btn-outline-secondary m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square text-light"></i></button><button class="btn btn-sm btn-outline-secondary btn-action m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye text-light"></i></button><button class="btn btn-sm btn-outline-secondary btn-action m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3 text-light"></i></button>',
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
