<?php

use App\Http\Controllers\AsetLocationController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TrxInController;
use App\Http\Controllers\TrxOutController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('/pengadaan', PengadaanController::class);
    Route::get('pengadaanJson', [PengadaanController::class, 'pengadaanDataTableJson'])->name('pengadaanJson');

    Route::resource('/status', StatusController::class);
    Route::get('statusJson', [StatusController::class, 'statusJson'])->name('statusJson');

    Route::resource('/location', AsetLocationController::class);
    Route::get('locationJson', [AsetLocationController::class, 'lokasiDataTableJson'])->name('locationJson');

    Route::resource('/users', UsersController::class);
    Route::get('usersJson', [UsersController::class, 'usersDataTableJson'])->name('usersJson');

    Route::resource('/transaction-in', TrxInController::class);
    Route::get('trxInJson', [TrxInController::class, 'trxInDataTableJson'])->name('trxInJson');

    Route::resource('/transaction-out', TrxOutController::class);
    Route::get('trxOutJson', [TrxOutController::class, 'trxOutDataTableJson'])->name('trxOutJson');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
