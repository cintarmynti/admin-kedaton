<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\RenovasiController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\IPKLController;
use App\Http\Controllers\API\LayananController;
use App\Http\Controllers\API\NotifikasiController;
use App\Http\Controllers\API\ListingController;
use App\Http\Controllers\API\PropertiController;
use App\Models\Properti;
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


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('profile', [UserController::class, 'profile']);
Route::post('profile-update/{id}', [UserController::class, 'update']);

Route::post('create-properti', [PropertiController::class, 'store']);
Route::post('edit-properti/{id}', [PropertiController::class, 'edit']);
Route::get('get-properti-user', [PropertiController::class, 'index']);
Route::post('create-penghuni', [PropertiController::class, 'addPenghuni']);

Route::post('bayar-ipkl', [IPKLController::class, 'store']);
Route::get('sudah-acc', [IPKLController::class, 'ipklAcc']);

Route::get('belom-bayar-ipkl', [IPKLController::class, 'belomDibayar']);
Route::get('sudah-bayar-ipkl', [IPKLController::class, 'sudahDibayar']);
Route::get('total-bayar', [IPKLController::class, 'total_tagihan']);

Route::get('riwayat-bayar', [IPKLController::class, 'riwayat_bayar']);

Route::get('count-notif', [NotifikasiController::class, 'countNotif']);
Route::get('semua-notif', [NotifikasiController::class, 'notif']);

Route::post('pengajuan-layanan', [LayananController::class, 'pengajuan']);
Route::get('get-layanan', [LayananController::class, 'ambilLayanan']);
Route::get('daftar-layanan', [LayananController::class, 'daftarLayanan']);

Route::get('get-banner', [BannerController::class, 'getBanner']);
Route::get('get-artikel', [BannerController::class, 'getArtikel']);
Route::get('get-artikel/{id}', [BannerController::class, 'getArtikelDetail']);

Route::post('create-listing', [ListingController::class, 'create_listing']);
Route::get('get-properti', [ListingController::class, 'getProperti']);

Route::post('create-image', [ListingController::class, 'createImage']);
