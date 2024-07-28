<?php

use App\Http\Controllers\AsetLocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\PermintaanPeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TrxPeminjamanController;
use App\Http\Controllers\TrxPengembalianController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\QrCodeController;
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


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::resource('/asset-list', PengadaanController::class);
    Route::get('pengadaanJson', [PengadaanController::class, 'pengadaanDataTableJson'])->name('pengadaanJson');

    Route::resource('/asset-permintaan', PermintaanController::class);
    Route::get('asset-permintaan/{id}/accept', [PermintaanController::class, 'accept_asset'])->name('asset-permintaan.accept');
    Route::post('/asset-permintaan/{id}/accept', [PermintaanController::class, 'accept_store'])->name('asset-permintaan-accept.input');
    Route::get('permintaanJson', [PermintaanController::class, 'datatableJson'])->name('permintaanJson');

    Route::resource('/asset-status', StatusController::class);
    Route::get('statusJson', [StatusController::class, 'dataTableJson'])->name('statusJson');

    Route::resource('/asset-location', AsetLocationController::class);
    Route::get('locationJson', [AsetLocationController::class, 'lokasiDataTableJson'])->name('locationJson');

    Route::resource('/users', UsersController::class);
    Route::get('usersJson', [UsersController::class, 'usersDataTableJson'])->name('usersJson');

    Route::resource('/transaksi-pinjam', TrxPeminjamanController::class);
    Route::get('trxPinjamJson', [TrxPeminjamanController::class, 'trxPinjamDataTableJson'])->name('trxPinjamJson');

    Route::resource('/transaksi-kembali', TrxPengembalianController::class);
    Route::get('trxKembaliJson', [TrxPengembalianController::class, 'trxKembaliDataTableJson'])->name('trxKembaliJson');

    Route::resource('/transaksi-permintaan', PermintaanPeminjamanController::class);
    Route::post('/transaksi-permintaan/{id}/accept', [PermintaanPeminjamanController::class, 'accept_store'])->name('asset-permintaan-accept.input');
    Route::post('/transaksi-permintaan/{id}/reject', [PermintaanPeminjamanController::class, 'reject_store'])->name('asset-permintaan-reject.input');
    Route::get('trx_permintaanJson', [PermintaanPeminjamanController::class, 'datatableJson'])->name('trx_permintaanJson');

    Route::resource('/log-user', LogActivityController::class);
    Route::get('logJson', [LogActivityController::class, 'datatableJson'])->name('logJson');

    Route::get('/laporan-assets', [LaporanController::class, 'laporan_aset'])->name('laporan-assets.index');
    Route::get('/laporan-assets/create', [LaporanController::class, 'laporan_aset_create'])->name('laporan-assets.create');
    Route::post('/laporan-assets/pdf', [PDFController::class, 'asset_print'])->name('asset_print');
    Route::get('/laporanAssetsJson', [LaporanController::class, 'AsetDatatableJson'])->name('laporanAssetsJson');
    
    Route::get('/laporan-transaksi', [LaporanController::class, 'laporan_transaksi'])->name('laporan-transaksi.index');
    Route::get('/laporan-transaksi/create', [LaporanController::class, 'laporan_transaksi_create'])->name('laporan-transaksi.create');
    Route::post('/laporan-transaksi/pdf', [PDFController::class, 'transaksi_print'])->name('transaksi_print');
    Route::get('/laporanTrxJson', [LaporanController::class, 'laporanTrxJson'])->name('laporanTrxJson');
    
    Route::get('/laporan-activity', [LaporanController::class, 'laporan_activity'])->name('laporan-activity.index');
    Route::get('/laporan-activity/create', [LaporanController::class, 'laporan_activity_create'])->name('laporan-activity.create');
    Route::post('/laporan-activity/pdf', [PDFController::class, 'activity_print'])->name('activity_print');
    Route::get('/laporanActivityJson', [LaporanController::class, 'laporanActivityJson'])->name('laporanActivityJson');

    // Route::get('/qrcode-test', [QrCodeController::class, 'show']);
    // Route::get('/qrcode-download', [QrCodeController::class, 'download']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
