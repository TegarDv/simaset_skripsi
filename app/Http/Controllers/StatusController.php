<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataStatus;
use App\Models\LogUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorizeAdminOrSuperAdmin();
            return $next($request);
        });
    }
    public function index()
    {
        $this->authorize('isSuperAdmin');

        return view('status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = DataStatus::create([
            'nama_status'          => $request->nama_status,
            'color'                => $request->color,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $dataFormatted = "Nama Status: {$data->nama_status}\n" .
                        "Color: {$data->color}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Tambah Status Data',
            'detail'    => $dataFormatted,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        $data = DataStatus::findOrFail($id);
        return view('status.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DataStatus::findOrFail($id);
        return view('status.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = DataStatus::findOrFail($id);
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        $data->update([
            'nama_status' => $request->nama_status,
            'color'       => $request->color,
            'updated_at'  => now(),
        ]);
        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Nama Status: {$data_lama['nama_status']}\n" .
                            "Color: {$data_lama['color']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Nama Status: {$data_baru['nama_status']}\n" .
                            "Color: {$data_baru['color']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update Data Status',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error'   => false,
            'toast'   => 'success',
            'message' => 'Data Berhasil Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_login = auth()->user();
        $data = DataStatus::findOrFail($id);

        $dataFormatted = "Nama Status: {$data->nama_status}\n" .
                        "Color: {$data->color}\n" .
                        "Created At: " . $data->created_at->format('d/M/Y H:i') . "\n" .
                        "Updated At: " . $data->updated_at->format('d/M/Y H:i');

        $data->delete();

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Hapus Data Status',
            'detail'    => $dataFormatted,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'nama_status'   => 'required',
            'color'         => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
        ]);
    }

    // public function statusJson()
    // {
    //     $data_status = DataStatus::select('id', 'nama_status', 'color', 'status', 'created_at', 'updated_at')->get();
    //     return response()->json([
    //         'data' => $data_status,
    //     ]);
    // }

    public function dataTableJson()
    {
        $get_data = DataStatus::latest()->get();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $loop_data->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '';
            $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $loop_data->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            $data[] = [
                'index' => $key + 1,
                'column2_table' => $loop_data->nama_status,
                'column3_table' => '<span class="badge rounded-pill border text-bg-'. $loop_data->color .'">'. $loop_data->nama_status .'</span>',
                'column4_table' => 'Dibuat pada: ' . $loop_data->created_at . '<br>Terakhir di update: ' . $loop_data->updated_at,
                'column5_table' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
