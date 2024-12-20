<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/get-pegawai/{nip}', function ($nip) {
    $pegawai = Employee::where('nip', $nip)->first();
    return response()->json([
        'nama' => $pegawai->name,
        'pangkat' => $pegawai->pangkat,
        'gol_ruang' => $pegawai->gol_ruang,
    ]);
});
