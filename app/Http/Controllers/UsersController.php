<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $password = Hash::make($request->password);

        $data = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'username'          => $request->username,
            'password'          => $password,
            'role'              => $request->role,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        LogUsers::create([
            'id_user'               => $user_login->id,
            'action'                => 'Tambah User',
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
        $data = User::findOrFail($id);
        return view('users.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_login = auth()->user();
        $this->validateData($request);

        $data = User::findOrFail($id);
        $data_lama = $data->replicate()->toArray();
        $data_lama['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_lama['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        if ($request->new_password == null) {
            $password = $data->password;
        } else {
            $password = Hash::make($request->new_password);
        }

        $data->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'username'   => $request->username,
            'password'   => $password,
            'role'       => $request->role,
            'updated_at' => now(),
        ]);

        $data_baru = $data->toArray();
        $data_baru['created_at'] = $data->created_at->format('d/M/Y H:i');
        $data_baru['updated_at'] = $data->updated_at->format('d/M/Y H:i');

        // Prepare old and new data in a readable format
        $oldDataFormatted = "Name: {$data_lama['name']}\n" .
                            "Email: {$data_lama['email']}\n" .
                            "Username: {$data_lama['username']}\n" .
                            "Role: {$data_lama['role']}\n" .
                            "Created At: {$data_lama['created_at']}\n" .
                            "Updated At: {$data_lama['updated_at']}";

        $newDataFormatted = "Name: {$data_baru['name']}\n" .
                            "Email: {$data_baru['email']}\n" .
                            "Username: {$data_baru['username']}\n" .
                            "Role: {$data_baru['role']}\n" .
                            "Created At: {$data_baru['created_at']}\n" .
                            "Updated At: {$data_baru['updated_at']}";

        LogUsers::create([
            'id_user'   => $user_login->id,
            'action'    => 'Update User',
            'detail'    => "Old Data:\n$oldDataFormatted\n\nUpdate to:\n$newDataFormatted",
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
        $this->authorizeAdminOrSuperAdmin();
        $data = User::findOrFail($id);
        $data->delete();
        
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    private function validateData(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'username'      => 'required',
            'password'      => 'required',
            'new_password'  => 'nullable',
            'role'          => 'required',
        ]);
    }

    public function usersDataTableJson()
    {
        $users = User::with('dataRole')->get();

        $data = [];
        foreach ($users as $key => $user) {
            $edit_btn = '<button class="btn btn-sm btn-label-warning m-1 edit-app-btn" data-app-id="' . $user->id . '" title="Edit"><i class="bi bi-pencil-square"></i></button>';
            $read_btn = '';
            $delete_btn = '<button class="btn btn-sm btn-label-danger m-1 delete-app-btn" data-app-id="' . $user->id . '" title="Delete"><i class="bi bi-trash3"></i></button>';
            $data[] = [
                'index' => $key + 1,
                'id' => $user->id,
                'column2_user' => 'Nama: ' . $user->name . '<br>Email: ' . $user->email . '<br>Username: ' . $user->username,
                'column3_user' => $user->dataRole->name,
                'column4_user' => 'Dibuat pada: ' . $user->created_at . '<br>Terakhir di update: ' . $user->updated_at,
                'column5_user' => $edit_btn . $read_btn . $delete_btn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
