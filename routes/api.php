<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\RenovasiController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\IPKLController;
use App\Http\Controllers\API\LayananController;
use App\Http\Controllers\API\NotifikasiController;
use App\Http\Controllers\API\ListingController;
use App\Http\Controllers\API\PanicButtonController;
use App\Http\Controllers\API\PropertiController;
use App\Http\Controllers\API\MobilePulsaController;
use App\Http\Controllers\API\XenditController;
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


//semua riwayat
Route::get('riwayat', [MobilePulsaController::class, 'riwayat']);
Route::get('riwayat-mobile-pulsa', [MobilePulsaController::class, 'riwayatMobilePulsa']);

Route::get('get-bank', [XenditController::class, 'getBank']);
Route::post('create-va', [XenditController::class, 'createVA']);
Route::post('store-va', [XenditController::class, 'store']);
Route::get('close-va/{id}', [XenditController::class, 'closeVaPayment']);
Route::post('callback', [XenditController::class, 'callback']);
Route::get('/status-tagihan/{id}', [XenditController::class, 'status_tagihan']);




Route::get('/renovasi', [RenovasiController::class, 'index']);
Route::post('/renovasi/create', [RenovasiController::class, 'create']);
Route::get('/renovasi/show/{id}', [RenovasiController::class, 'show']);
Route::get('/renovasi/update/{id}', [RenovasiController::class, 'update']);
Route::get('/renovasi/delete/{id}', [RenovasiController::class, 'delete']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('profile', [UserController::class, 'profile']);
Route::post('profile-update', [UserController::class, 'update']);
Route::get('get-nik', [UserController::class, 'getNik']);
Route::post('forget-pass', [UserController::class, 'forget']);
Route::post('edit-pass', [UserController::class, 'editpass']);
Route::post('resend-password', [UserController::class, 'resendpass']);
Route::post('edit-foto-profile', [UserController::class, 'edit_foto']);


Route::post('panic-button', [PanicButtonController::class, 'store']);

Route::post('create-properti', [PropertiController::class, 'store']);
Route::post('create-penghuni', [PropertiController::class, 'addPenghuni']);
Route::get('daftar-cluster', [PropertiController::class, 'getcluster']);
Route::get('daftar-rumah', [PropertiController::class, 'getNomer']);
Route::post('new-prop', [PropertiController::class, 'newProp']);
Route::get('prop-detail', [PropertiController::class, 'detailprop']);

Route::post('bayar-tagihan', [IPKLController::class, 'store']);

Route::get('sudah-bayar', [IPKLController::class, 'sudahBayarIpkl']);
Route::get('belom-bayar', [IPKLController::class, 'belomDibayar']);
Route::get('list-tagihan', [IPKLController::class, 'listTagihan']);
Route::get('detail-ipkl', [IPKLController::class, 'detailIpkl']);

// Route::get('sudah-bayar-tagihan', [IPKLController::class, 'sudahDibayar']);
Route::get('total-bayar', [IPKLController::class, 'total_tagihan']);
Route::get('riwayat-bayar', [IPKLController::class, 'riwayat_bayar']);

Route::get('count-notif', [NotifikasiController::class, 'countNotif']);
Route::get('semua-notif', [NotifikasiController::class, 'notif']);
Route::post('/fcm-token', [NotifikasiController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[NotifikasiController::class,'notification'])->name('notification');

Route::post('pengajuan-layanan', [LayananController::class, 'pengajuan']);
Route::get('get-layanan', [LayananController::class, 'ambilLayanan']);
Route::get('daftar-layanan', [LayananController::class, 'daftarLayanan']);

Route::get('get-banner', [BannerController::class, 'getBanner']);
Route::get('get-artikel', [BannerController::class, 'getArtikel']);
Route::get('get-artikel/detail', [BannerController::class, 'getArtikelDetail']);

Route::post('create-listing', [ListingController::class, 'create_listing']);
Route::get('get-listing', [ListingController::class, 'getProperti']);
Route::get('detail-listing', [ListingController::class, 'detail_listing']);
Route::post('create-image', [ListingController::class, 'createImage']);

Route::post('create-complain', [ComplainController::class, 'store']);
Route::get('get-complain', [ComplainController::class, 'getComplain']);


Route::get('/mobile-pulsa', [MobilePulsaController::class, 'balance']);
Route::post('/mobile-pulsa/cek-pembayaran', [MobilePulsaController::class, 'pascatelkom']);
Route::post('/mobile-pulsa/bayar', [MobilePulsaController::class, 'paymentTelkom']);

