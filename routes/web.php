<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RenovasiController;
use App\Http\Controllers\LaporanComplainController;
use App\Http\Controllers\LaporanPanicButtonController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\IuranController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
Route::delete('/blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');

Route::get('/listing', [ListingController::class, 'index'])->name('listing');
Route::get('/listing/create', [ListingController::class, 'create'])->name('listing.create');
Route::post('/listing/store', [ListingController::class, 'store'])->name('listing.store');
Route::get('/listing/detail/{id}', [ListingController::class, 'detail'])->name('listing.detail');
Route::delete('/listing/delete/{id}', [ListingController::class, 'delete'])->name('listing.delete');
Route::get('/listing/edit/{id}', [ListingController::class, 'edit'])->name('listing.edit');
Route::put('/listing/update/{id}', [ListingController::class, 'update'])->name('listing.update');

Route::get('/banner', [BannerController::class, 'index'])->name('banner');
Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');

Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
Route::post('/promo/store', [PromoController::class, 'store'])->name('promo.store');
Route::delete('/promo/delete/{id}', [PromoController::class, 'delete'])->name('promo.delete');
Route::get('/promo/edit/{id}', [PromoController::class, 'edit'])->name('promo.edit');
Route::put('/promo/update/{id}', [PromoController::class, 'update'])->name('promo.update');

Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
Route::post('/promo/store', [PromoController::class, 'store'])->name('promo.store');
Route::delete('/promo/delete/{id}', [PromoController::class, 'delete'])->name('promo.delete');
Route::get('/promo/edit/{id}', [PromoController::class, 'edit'])->name('promo.edit');
Route::put('/promo/update/{id}', [PromoController::class, 'update'])->name('promo.update');

Route::get('/renovasi', [RenovasiController::class, 'index'])->name('renovasi');
Route::get('/renovasi/create', [RenovasiController::class, 'create'])->name('renovasi.create');
Route::post('/renovasi/store', [RenovasiController::class, 'store'])->name('renovasi.store');
Route::delete('/renovasi/delete/{id}', [RenovasiController::class, 'delete'])->name('renovasi.delete');
Route::get('/renovasi/edit/{id}', [RenovasiController::class, 'edit'])->name('renovasi.edit');
Route::put('/renovasi/update/{id}', [RenovasiController::class, 'update'])->name('renovasi.update');

Route::get('/complain', [LaporanComplainController::class, 'index'])->name('complain');
Route::get('/complain/create', [LaporanComplainController::class, 'create'])->name('complain.create');
Route::post('/complain/store', [LaporanComplainController::class, 'store'])->name('complain.store');
Route::delete('/complain/delete/{id}', [LaporanComplainController::class, 'delete'])->name('complain.delete');
Route::get('/complain/edit/{id}', [LaporanComplainController::class, 'edit'])->name('complain.edit');
Route::put('/complain/update/{id}', [LaporanComplainController::class, 'update'])->name('complain.update');

Route::get('/panic-button', [LaporanPanicButtonController::class, 'index'])->name('panic');
Route::get('/panic-button/create', [LaporanPanicButtonController::class, 'create'])->name('panic.create');
Route::post('/panic-button/store', [LaporanPanicButtonController::class, 'store'])->name('panic.store');
Route::delete('/panic-button/delete/{id}', [LaporanPanicButtonController::class, 'delete'])->name('panic.delete');
Route::get('/panic-button/edit/{id}', [LaporanPanicButtonController::class, 'edit'])->name('panic.edit');
Route::put('/panic-button/update/{id}', [LaporanPanicButtonController::class, 'update'])->name('panic.update');

Route::get('/iuran', [IuranController::class, 'index'])->name('iuran');
Route::get('/iuran/create', [IuranController::class, 'create'])->name('iuran.create');
Route::post('/iuran/store', [IuranController::class, 'store'])->name('iuran.store');
Route::delete('/iuran/delete/{id}', [IuranController::class, 'delete'])->name('iuran.delete');
Route::get('/iuran/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
Route::put('/iuran/update/{id}', [IuranController::class, 'update'])->name('iuran.update');

Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('bayar');
Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('bayar.create');
Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('bayar.store');
Route::delete('/pembayaran/delete/{id}', [PembayaranController::class, 'delete'])->name('bayar.delete');
Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('bayar.edit');
Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('bayar.update');


