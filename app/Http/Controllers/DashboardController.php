<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AssetsRequest;
use App\Models\AssetsTransaction;
use App\Models\LogUsers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asset_count = Assets::all()->count();
        $assets = Assets::with('dataStatus', 'dataKondisi', 'dataLokasi')->latest()->take(5)->get();
        $assets_request = AssetsRequest::with('dataUser')->latest()->take(5)->get();
        $transaksi = AssetsTransaction::with('dataAsset' , 'dataUser')->orderBy('tanggal_transaksi', 'asc')->take(5)->get();
        $log_user = LogUsers::with('data_user')->latest()->take(5)->get();
        return view('dashboard', [
            'asset_count' => $asset_count,
            'assets' => $assets,
            'assets_request' => $assets_request,
            'transaksi' => $transaksi,
            'log_user' => $log_user,
        ]);
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
}
