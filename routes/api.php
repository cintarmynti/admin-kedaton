<?php

use App\Http\Controllers\API\RenovasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/renovasi', [RenovasiController::class, 'index']);
Route::post('/renovasi/create', [RenovasiController::class, 'create']);
Route::get('/renovasi/show/{id}', [RenovasiController::class, 'show']);
Route::get('/renovasi/update/{id}', [RenovasiController::class, 'update']);
Route::get('/renovasi/delete/{id}', [RenovasiController::class, 'delete']);



