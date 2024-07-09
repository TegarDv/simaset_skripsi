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

    public function datatableJson()
    {
        $get_data = LogUsers::with('data_user')->latest()->get();

        $data = [];
        foreach ($get_data as $key => $loop_data) {
            $detail = nl2br(e($loop_data->detail));

            $data[] = [
                'index' => $key + 1,
                'id' => $loop_data->id,
                'column2_table' => 'Tanggal tindakan: ' . $loop_data->created_at,
                'column3_table' => $loop_data->action . '<br>Oleh: ' . $loop_data->data_user->name,
                'column4_table' => $detail,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
