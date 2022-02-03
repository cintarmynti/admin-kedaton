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
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IPKLController;
use App\Http\Controllers\RumahController;

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



Route::group(['middleware' => 'auth'], function(){

    Route::get('/', function () {
        return redirect('/dashboard');
    });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
// Route::get('/siswa', 'SiswaController@index');
Route::get('/user/export_excel', [UserController::class, 'export_excel'])->name('user.excel');


Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
Route::get('/blog/detail/{id}', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/blog-img/delete/{id}', [BlogController::class, 'imgdelete'])->name('blogimg.delete');



Route::get('/listing', [ListingController::class, 'index'])->name('listing');
Route::get('/listing/create', [ListingController::class, 'create'])->name('listing.create');
Route::post('/listing/store', [ListingController::class, 'store'])->name('listing.store');
Route::get('/listing/detail/{id}', [ListingController::class, 'detail'])->name('listing.detail');
Route::get('/listing/delete/{id}', [ListingController::class, 'delete'])->name('listing.delete');
Route::get('/listing-img/delete/{id}', [ListingController::class, 'imgdelete'])->name('listingimg.delete');
Route::get('/listing/edit/{id}', [ListingController::class, 'edit'])->name('listing.edit');
Route::put('/listing/update/{id}', [ListingController::class, 'update'])->name('listing.update');

Route::get('/banner', [BannerController::class, 'index'])->name('banner');
Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
Route::get('/banner/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');

Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
Route::post('/promo/store', [PromoController::class, 'store'])->name('promo.store');
Route::get('/promo/delete/{id}', [PromoController::class, 'delete'])->name('promo.delete');
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
Route::get('/renovasi/delete/{id}', [RenovasiController::class, 'delete'])->name('renovasi.delete');
Route::get('/renovasi/edit/{id}', [RenovasiController::class, 'edit'])->name('renovasi.edit');
Route::put('/renovasi/update/{id}', [RenovasiController::class, 'update'])->name('renovasi.update');
Route::get('/renovasi/detail/{id}', [RenovasiController::class, 'detail'])->name('renovasi.detail');
Route::get('/renovasi-img/delete/{id}', [RenovasiController::class, 'imgdelete'])->name('renovasiimg.delete');
Route::get('/renovasi/export_excel', [RenovasiController::class, 'export_excel'])->name('renovasi.excel');




Route::get('/complain', [LaporanComplainController::class, 'index'])->name('complain');
Route::get('/complain/create', [LaporanComplainController::class, 'create'])->name('complain.create');
Route::post('/complain/store', [LaporanComplainController::class, 'store'])->name('complain.store');
Route::get('/complain/delete/{id}', [LaporanComplainController::class, 'delete'])->name('complain.delete');
Route::get('/complain/edit/{id}', [LaporanComplainController::class, 'edit'])->name('complain.edit');
Route::put('/complain/update/{id}', [LaporanComplainController::class, 'update'])->name('complain.update');
Route::get('/complain/detail/{id}', [LaporanComplainController::class, 'detail'])->name('complain.detail');
Route::get('/complain-img/delete/{id}', [LaporanComplainController::class, 'imgdelete'])->name('complainimg.delete');
Route::get('/complain/export_excel', [LaporanComplainController::class, 'export_excel'])->name('complain.excel');




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

Route::get('/cluster', [ClusterController::class, 'index'])->name('cluster');
Route::get('/cluster/create', [ClusterController::class, 'create'])->name('cluster.create');
Route::post('/cluster/store', [ClusterController::class, 'store'])->name('cluster.store');
Route::delete('/cluster/delete/{id}', [ClusterController::class, 'delete'])->name('cluster.delete');
Route::get('/cluster/edit/{id}', [ClusterController::class, 'edit'])->name('cluster.edit');
Route::put('/cluster/update/{id}', [ClusterController::class, 'update'])->name('cluster.update');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/ipkl', [IPKLController::class, 'index'])->name('ipkl');
Route::get('/ipkl/status/{id}', [IPKLController::class, 'status'])->name('ipkl.status');
Route::get('/ipkl/create', [IPKLController::class, 'create'])->name('ipkl.create');
Route::post('/ipkl/store', [IPKLController::class, 'store'])->name('ipkl.store');
Route::get('/ipkl/delete/{id}', [IPKLController::class, 'delete'])->name('ipkl.delete');
Route::get('/ipkl/edit/{id}', [IPKLController::class, 'edit'])->name('ipkl.edit');
Route::put('/ipkl/update/{id}', [IPKLController::class, 'update'])->name('ipkl.update');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('/rumah-pengguna', RumahController::class);
Route::get('/rumah-pengguna/cluster/{id}', [RumahController::class,'getIPKLid']);
Route::get('/rumah-pengguna/delete/{id}', [RumahController::class,'delete']);

});

Auth::routes();


