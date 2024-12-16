<?php

use App\Http\Controllers\AtasanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PegawaiController;
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

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginPost', [AuthController::class, 'loginPost'])->name('loginPost');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// absensi
Route::post('/absensi/store', [AuthController::class, 'storeAbsensi'])->name('absensi.store');

// api
Route::get('/get-pegawai/{nip}', [AuthController::class, 'getPegawai'])->name('get-pegawai');

Route::group(['middleware' => ['auth.check:karyawan']], function () {  
    Route::get('/karyawan/dashboard', [PegawaiController::class, 'dashboard'])->name('karyawan.dashboard');
});

Route::group(['middleware' => ['auth.check:atasan']], function () {  
    Route::get('/atasan/dashboard', [AtasanController::class, 'dashboard'])->name('atasan.dashboard');

    // data karyawan
    Route::get('/atasan/data-pegawai', [AtasanController::class, 'dataKaryawan'])->name('atasan.data-pegawai');

    // data absensi
    Route::get('/atasan/data-absensi', [AtasanController::class, 'dataAbsensi'])->name('atasan.data-absensi');

    // download excel
    Route::get('/atasan/data-absensi/download/excel/{bulan}/{tahun}', [AtasanController::class, 'downloadExcel'])->name('atasan.data-absensi.download.excel');

    // download pdf
    Route::get('/atasan/data-absensi/download/pdf/{bulan}/{tahun}', [AtasanController::class, 'downloadPdf'])->name('atasan.data-absensi.download.pdf');
});

Route::group(['middleware' => ['auth.check:operator']], function () {  
    Route::get('/operator/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');

    // data karyawan
    Route::get('/operator/data-pegawai', [OperatorController::class, 'dataPegawai'])->name('operator.data-pegawai');
    Route::post('/operator/store-pegawai', [OperatorController::class, 'storePegawai'])->name('operator.store-pegawai');
    Route::post('/operator/update-pegawai', [OperatorController::class, 'updatePegawai'])->name('operator.update-pegawai');
    Route::get('/operator/delete-pegawai/{id}', [OperatorController::class, 'deletePegawai'])->name('operator.delete-pegawai');
    
    Route::get('/operator/generate-qrcode', [OperatorController::class,'generateQrCode'])->name('operator.generate-qrcode');

    // data absensi
    Route::get('/operator/data-absensi', [OperatorController::class, 'dataAbsensi'])->name('operator.data-absensi');

    // download excel
    Route::get('/operator/data-absensi/download/excel/{bulan}/{tahun}', [OperatorController::class, 'downloadExcel'])->name('operator.data-absensi.download.excel');

    // download pdf
    Route::get('/operator/data-absensi/download/pdf/{bulan}/{tahun}', [OperatorController::class, 'downloadPdf'])->name('operator.data-absensi.download.pdf');
});
