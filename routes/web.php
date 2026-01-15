<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengaturanController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login.proses');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| PROFIL (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'profil'])
        ->name('profil.index');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD (ADMIN & KASIR)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');
});

/*
|--------------------------------------------------------------------------
| POS - KASIR & ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin,Kasir'])->prefix('pos')->name('pos.')->group(function () {

    Route::get('/transaksi', [PosController::class, 'transaksi'])
        ->name('transaksi');

    Route::get('/daftar', [PosController::class, 'daftarTransaksi'])
        ->name('daftar');

    Route::get('/retur', [PosController::class, 'retur'])
        ->name('retur');

    Route::get('/hold', [PosController::class, 'hold'])
        ->name('hold');

    Route::get('/riwayat', [PosController::class, 'riwayat'])
        ->name('riwayat');

    Route::post('/cart/add', [PosController::class, 'cartAdd'])->name('cart.add');
    Route::post('/cart/minus/{id}', [PosController::class, 'cartMinus'])->name('cart.minus');
    Route::post('/cart/remove/{id}', [PosController::class, 'cartRemove'])->name('cart.remove');

    Route::post('/pending', [PosController::class, 'pending'])->name('pending');
    Route::post('/bayar', [PosController::class, 'bayar'])->name('bayar');
    Route::get('/struk/{id}', [PosController::class, 'struk'])
        ->name('struk');
    Route::get('/export-pos-excel', [PosController::class, 'exportExcel'])
        ->name('daftar.exportE');
    Route::get('/export-pos-pdf', [PosController::class, 'exportPdf'])
        ->name('daftar.exportP');


});

Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {
    Route::get('/produks', [ProdukController::class, 'index'])
        ->name('produk.index');
    Route::post('/store', [ProdukController::class, 'store'])
        ->name('produk.store');
    Route::put('/produks/{id}', [ProdukController::class, 'update'])
        ->name('produk.update');
    Route::delete('/produks/{id}', [ProdukController::class, 'destroy'])
        ->name('produk.destroy');

});
Route::middleware(['auth', 'role:Admin,Kasir'])->prefix('stok')->name('stok.')->group(function () {

    Route::get('/masuk', [StokController::class, 'masuk'])
        ->name('masuk');
    Route::post('/store', [StokController::class, 'store'])
        ->name('store');
    Route::post('/store-keluar', [StokController::class, 'store_keluar'])
        ->name('store-keluar');
    Route::get('/exportK-excel', [StokController::class, 'exportExcelK'])
        ->name('keluar.excelE');
    Route::get('/exporK-pdf', [StokController::class, 'exportPdfK'])
        ->name('keluar.exportP');
    Route::get('/export-masuk-excel', [StokController::class, 'exportExcelM'])
        ->name('masuk.exportE');
    Route::get('/export-masuk-pdf', [StokController::class, 'exportPdfM'])
        ->name('masuk.exportP');

    Route::get('/keluar', [StokController::class, 'keluar'])
        ->name('keluar');

    Route::get('/penyesuaian', [StokController::class, 'penyesuaian'])
        ->name('penyesuaian');

    Route::get('/opname', [StokController::class, 'opname'])
        ->name('opname');
    Route::get(
        '/stock-opname/template-excel',
        [StokController::class, 'exportTemplateSO']
    )->name('export-template');

    Route::post('/stock-opname/store', [StokController::class, 'opname_store'])->name('so.store');
    Route::delete('/stock-opname/{id}', [StokController::class, 'destroy_opname'])->name('so.destroy');
    Route::get('/riwayat', [StokController::class, 'riwayat'])
        ->name('riwayat');

    Route::get('/prediksi', [StokController::class, 'prediksi'])
        ->name('prediksi');
});

/*
|--------------------------------------------------------------------------
| LAPORAN (ADMIN & KASIR)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| PENGGUNA & HAK AKSES (ADMIN SAJA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->prefix('pengguna')->name('pengguna.')->group(function () {

    Route::get('/', [PenggunaController::class, 'index'])
        ->name('index');

    Route::post('/store', [PenggunaController::class, 'store'])
        ->name('store');

    Route::post('/{id}/reset', [PenggunaController::class, 'resetPassword'])
        ->name('reset');

    Route::post('/{id}/toggle', [PenggunaController::class, 'toggleStatus'])
        ->name('toggle');
});

/*
|--------------------------------------------------------------------------
| PENGATURAN SISTEM (ADMIN SAJA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('pengaturan.index');
});
