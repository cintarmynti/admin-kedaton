<?php

use App\Models\IPKL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IPKLController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SplashController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\RenovasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanComplainController;
use App\Http\Controllers\LaporanPanicButtonController;

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



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/dashboard/notif-admin', [DashboardController::class, 'notif_admin']);
    Route::get('/notif/{id}', [NotifikasiController::class, 'detailPages']);
    Route::get('/all-notif', [NotifikasiController::class, 'allNotif']);
    Route::get('/read-all', [NotifikasiController::class, 'readAll']);

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/detail/{id}', [UserController::class, 'show'])->name('user.detail');
    Route::get('/user/detail/rumah/{id}', [UserController::class, 'detail_rumah'])->name('user.rumah');
    Route::get('/user/export_excel', [UserController::class, 'export_excel'])->name('user.excel');
    Route::get('/user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/addpenghuni/{id}', [UserController::class, 'addPenghuni'])->name('user.addPenghuni');
    Route::post('/user/storepenghuni', [UserController::class, 'storePenghuni'])->name('user.storePenghuni');
    Route::get('/user/nomer/{id}', [UserController::class, 'getNomerid'])->name('user.nomer');
    Route::get('/user/daftarUser', [UserController::class, 'daftarUser'])->name('user.daftarUser');
    Route::patch('/user/updatePenghuni/{id}', [UserController::class, 'updatePenghuni'])->name('user.updatePenghuni');
    Route::get('/user/create-properti/{id}', [UserController::class, 'newProp'])->name('user.newProp');
    Route::get('/user-detail-json/{name}', [UserController::class, 'detailJson'])->name('user.detail.json');
    Route::post('/user/storeProp', [UserController::class, 'storeProp'])->name('user.addNewProp');
    Route::patch('/user/user-activated', [UserController::class, 'activated'])->name('user.activated');
    Route::get('/user/user-cancel', [UserController::class, 'canceled'])->name('user.canceled');
    Route::get('/user/detail_penghuni/{id}', [UserController::class, 'detail_penghuni'])->name('user.detail_penghuni');


    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/blog/detail/{id}', [BlogController::class, 'detail'])->name('blog.detail');
    Route::get('/blog-img/delete/{id}', [BlogController::class, 'imgdelete'])->name('blogimg.delete');


    Route::get('/properti', [PropertiController::class, 'index'])->name('properti');
    Route::get('/properti/create', [PropertiController::class, 'create'])->name('properti.create');
    Route::post('/properti/store', [PropertiController::class, 'store'])->name('properti.store');
    Route::get('/properti/detail/{id}', [PropertiController::class, 'detail'])->name('properti.detail');
    Route::get('/properti/delete/{id}', [PropertiController::class, 'delete'])->name('properti.delete');
    Route::get('/properti-img/delete/{id}', [PropertiController::class, 'imgdelete'])->name('propertiimg.delete');
    Route::get('/properti/edit/{id}', [PropertiController::class, 'edit'])->name('properti.edit');
    Route::put('/properti/update/{id}', [PropertiController::class, 'update'])->name('properti.update');
    Route::get('/properti/export_excel', [PropertiController::class, 'export_excel'])->name('properti.excel');
    Route::get('/properti/riwayat/{id}', [PropertiController::class, 'riwayat'])->name('properti.riwayat');
    Route::get('/properti-detail-json/{id}', [PropertiController::class, 'detailJson'])->name('properti.detail.json');
    Route::get('properti/user/{id}', [PropertiController::class, 'datauser'])->name('properti.user.json');
    Route::get('properti/penghuni/{id}', [PropertiController::class, 'penghuni'])->name('properti.penghuni');
    Route::patch('/properti/pemilik-update', [PropertiController::class, 'update_pemilik'])->name('properti.pemilik');
    Route::patch('/properti/penghuni-update', [PropertiController::class, 'update_penghuni'])->name('properti.penghuni_id');



    Route::get('/listing', [ListingController::class, 'index'])->name('listing');
    Route::get('/listing/create', [ListingController::class, 'create'])->name('listing.create');
    Route::post('/listing/store', [ListingController::class, 'store'])->name('listing.store');
    Route::get('/listing/detail/{id}', [ListingController::class, 'detail'])->name('listing.detail');
    Route::get('/listing/delete/{id}', [ListingController::class, 'delete'])->name('listing.delete');
    Route::get('/listing-img/delete/{id}', [ListingController::class, 'imgdelete'])->name('listingimg.delete');
    Route::get('/listing/edit/{id}', [ListingController::class, 'edit'])->name('listing.edit');
    Route::put('/listing/update/{id}', [ListingController::class, 'update'])->name('listing.update');
    Route::get('/listing/export_excel', [ListingController::class, 'export_excel']);
    Route::get('/listing/properti/{id}', [ListingController::class, 'getProperti']);


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
    Route::get('/complain/detail/image/{id}', [LaporanComplainController::class, 'detail'])->name('complain.detail.image');
    Route::get('/complain-img/delete/{id}', [LaporanComplainController::class, 'imgdelete'])->name('complainimg.delete');
    Route::get('/complain/export_excel', [LaporanComplainController::class, 'export_excel'])->name('complain.excel');
    Route::get('/complain/detail/{id}', [LaporanComplainController::class, 'complainDetail'])->name('complain.detail');
    Route::patch('/complain/status', [LaporanComplainController::class, 'updateStatus'])->name('complain.status');

    Route::get('/panic-button', [LaporanPanicButtonController::class, 'index'])->name('panic');
    Route::patch('/panic-button/status', [LaporanPanicButtonController::class, 'status'])->name('panic.status');
    Route::get('/panic-button/export_excel', [LaporanPanicButtonController::class, 'export_excel']);
    Route::get('/panic-button/detail/{id}', [LaporanPanicButtonController::class, 'get_detail']);
    Route::get('/panic-button/dashboard/{id}', [LaporanPanicButtonController::class, 'dashboard_update']);
    Route::get('/panic-button/dashboard-all', [LaporanPanicButtonController::class, 'dashboard_all']);
    Route::get('/panic-button/edit/{id}', [LaporanPanicButtonController::class, 'edit']);
    Route::get('/panic-button/belum_dicek', [LaporanPanicButtonController::class, 'belum_dicek']);


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
    Route::patch('/cluster/update', [ClusterController::class, 'update'])->name('cluster.update');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/ipkl', [IPKLController::class, 'index'])->name('ipkl');
    Route::get('/ipkl/status/{id}', [IPKLController::class, 'status'])->name('ipkl.status');
    Route::get('/ipkl/create', [IPKLController::class, 'create'])->name('ipkl.create');
    Route::post('/ipkl/store', [IPKLController::class, 'store'])->name('ipkl.store');
    Route::get('/ipkl/delete/{id}', [IPKLController::class, 'delete'])->name('ipkl.delete');
    Route::get('/ipkl/edit/{id}', [IPKLController::class, 'edit'])->name('ipkl.edit');
    Route::put('/ipkl/update/{id}', [IPKLController::class, 'update'])->name('ipkl.update');
    Route::get('/ipkl/cluster/{id}', [IPKLController::class, 'getIPKLid'])->name('ipkl.cluster');
    Route::get('/ipkl/harga/{id}', [IPKLController::class, 'getIPKLharga'])->name('ipkl.harga');
    Route::get('/ipkl/riwayat/{id}', [IPKLController::class, 'get_riwayat']);
    Route::patch('/ipkl/riwayat-create', [IPKLController::class, 'create_riwayat']);
    Route::get('/ipkl/pembayar/{id}', [IPKLController::class, 'pembayar'])->name('ipkl.pembayar');
    Route::get('/ipkl/export_excel', [IPKLController::class, 'export_excel']);
    Route::patch('/ipkl/tolak', [IPKLController::class, 'penolakan_pembayaran']);

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::get('/layanan/status/{id}', [LayananController::class, 'status'])->name('layanan.status');
    Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/delete/{id}', [LayananController::class, 'delete'])->name('layanan.delete');
    Route::get('/layanan/edit/{id}', [LayananController::class, 'edit'])->name('layanan.edit');
    Route::put('/layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::get('/layanan/cluster/{id}', [LayananController::class, 'getlayananid'])->name('layanan.cluster');
    Route::get('/layanan/harga/{id}', [LayananController::class, 'getlayananharga'])->name('layanan.harga');
    Route::get('/layanan/riwayat/{id}', [LayananController::class, 'get_riwayat']);
    Route::patch('/layanan/riwayat-create', [LayananController::class, 'create_riwayat']);
    Route::get('/layanan/pembayar/{id}', [LayananController::class, 'pembayar'])->name('layanan.pembayar');





    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('/rumah-pengguna', RumahController::class);
    Route::get('/rumah-pengguna/cluster/{id}', [RumahController::class, 'getIPKLid']);
    Route::get('/rumah-pengguna/delete/{id}', [RumahController::class, 'delete']);

    Route::resource('/splash-screen', SplashController::class);
    Route::get('/splash-screen/delete/{id}', [SplashController::class, 'delete']);
});

Auth::routes();


Route::get('/ipkl/new_tagihan', [IPKLController::class, 'generate_tagihan']);
