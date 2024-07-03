<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetLocation;
use App\Models\LogUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AsetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorizeAdminOrSuperAdmin();
            return $next($request);
        });
    }
    public function index()
    {
        return view('location.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetLocation::create([
            'location'            => $request->location,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah Lokasi',
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
        $data = AssetLocation::findOrFail($id);
        return view('location.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = AssetLocation::findOrFail($id);
        $data_lama = $data->replicate();

        $data->update([
            'location'  => $request->location,
            'updated_at' => now(),
        ]);
        $data_baru = $data;

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Lokasi',
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
            'location'     => 'required',
        ]);
    }

    public function lokasiDataTableJson()
    {
        $assets = AssetLocation::all();

        $data = [];
        foreach ($assets as $key => $asset) {
            $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $asset->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $asset->id . '" title="View"><i class="bi bi-eye"></i></button>';
            $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $asset->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            $data[] = [
                'index' => $key + 1,
                'column2_aset' => '<div class="text-light">' . $asset->location . '</div>',
                'column3_aset' => '<div class="text-light">Dibuat pada: ' . $asset->created_at . '<br>Terakhir di update: ' . $asset->updated_at . '</div>',
                'column4_aset' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
