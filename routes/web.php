<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PelangganController;
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
    return view('app');
});

/**
 * API
 */
Route::prefix('api/')->name('api.')->group(function () {
    Route::prefix('barang-index/')->name('barang-index.')->group(function () {
        Route::get('get-data',[BarangController::class,'getIndexedData']);
    });

    Route::prefix('master/')->name('master.')->group(function () {
        Route::get('get-table-size',[MasterController::class,'getTableSize']);
    });

    Route::prefix('pelanggan-index/')->name('pelanggan-index.')->group(function () {
        Route::get('get-data',[PelangganController::class,'getIndexedData']);
    });

    Route::prefix('detail-transaksi/')->name('detail-transaksi.')->group(function () {
        Route::post('store-data',[DetailTransaksiController::class,'storeData']);
        Route::get('get-data',[DetailTransaksiController::class,'getData']);
    });

    Route::prefix('detail-transaksi-index/')->name('detail-transaksi-index.')->group(function () {
        Route::post('store-data',[DetailTransaksiController::class,'storeIndexedData']);
        Route::get('get-data',[DetailTransaksiController::class,'getIndexedData']);
    });

    Route::prefix('detail-transaksi-json/')->name('detail-transaksi-json.')->group(function () {
        Route::post('store-data',[DetailTransaksiController::class,'storeJSONData']);
        Route::get('get-data',[DetailTransaksiController::class,'getJSONData']);
    });
    Route::prefix('detail-transaksi-cache/')->name('detail-transaksi-cache.')->group(function () {
        // Route::post('store-data',[DetailTransaksiController::class,'storeCacheData']);
        Route::get('get-data',[DetailTransaksiController::class,'getCachedData']);
    });
});

Route::get('/spa/{any}', function () {
    return view('app'); // Assuming you have a Blade template named 'app.blade.php'
})->where('any', '.*');
