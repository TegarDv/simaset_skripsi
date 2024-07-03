<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->authorizeSuperAdmin();
            // $this->authorizeAdminOrSuperAdmin();
            $this->authorizeAllUser();
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
        $this->validateData($request);

        DataStatus::create([
            'nama_status'          => $request->nama_status,
            'color'                => $request->color,
            'created_at'           => now(),
            'updated_at'           => now(),
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
        $this->validateData($request);

        $data = DataStatus::findOrFail($id);

        $data->update([
            'nama_status'          => $request->nama_status,
            'color'                => $request->color,
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
        $data = DataStatus::findOrFail($id);
        $data->delete();
        
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
        $get_data = DataStatus::all();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $loop_data->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '<button class="btn btn-sm btn-label-primary m-1 view-app-btn" data-app-id="' . $loop_data->id . '" title="View"><i class="bi bi-eye"></i></button>';
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
