<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataStatus;
use Illuminate\Http\RedirectResponse;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_status = DataStatus::all();
        return view('status.index', ['data_status' => $data_status]);
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
            'status'               => '1',
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
            'status'               => $request->status,
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
        try {
            $data = DataStatus::findOrFail($id);
            $data->update([
                'status'               => '0',
                'updated_at'           => now(),
            ]);
            
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
            'nama_status'   => 'required',
            'status'        => 'nullable|in:0,1',
            'color'         => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
        ]);
    }

    public function statusJson()
    {
        $data_status = DataStatus::select('id', 'nama_status', 'color', 'status', 'created_at', 'updated_at')->get();
        return response()->json([
            'data' => $data_status,
        ]);
    }
}
