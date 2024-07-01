<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogUsers;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorizeSuperAdmin();
            // $this->authorizeAdminOrSuperAdmin();
            // $this->authorizeAllUser();
            return $next($request);
        });
    }
    public function index()
    {
        return view('log_activity.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    public function datatableJson()
    {
        $get_data = LogUsers::with('data_user')->get();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $data[] = [
                'index' => $key + 1,
                'id' => $loop_data->id,
                'column2_table' => 'Tanggal tindakan: ' . $loop_data->created_at,
                'column3_table' => $loop_data->action . '<br>Oleh: ' . $loop_data->data_user->name,
                'column4_table' => 'Detail: ' . $loop_data->detail,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
