<?php

use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProfileController;
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

Route::resource('/pengadaan', PengadaanController::class)->middleware('auth');
Route::get('pengadaanJson', [PengadaanController::class, 'pengadaanDataTableJson'])->name('pengadaanJson')->middleware('auth');

Route::resource('/status', StatusController::class)->middleware('auth');
Route::get('statusJson', [StatusController::class, 'statusJson'])->name('statusJson')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
