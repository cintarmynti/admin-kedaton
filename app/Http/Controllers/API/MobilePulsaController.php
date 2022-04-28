<?php

namespace App\Http\Controllers\API;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Lib\PusherFactory;
use App\Models\Notifikasi;
use App\Models\pembayaranMobilePulsa;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Kutia\Larafirebase\Facades\Larafirebase;

class MobilePulsaController extends Controller
{
    public function balance()
    {
        $balance = Http::post('https://testprepaid.mobilepulsa.net/v1/legacy/index', [
            'commands' => 'balance',
            'username' => '087859277817',
            'sign'     => 'e847641e5dd7ff2299294976646f76b7'
        ])->json();

        return $balance;
    }

    public function pascatelkom(Request $request)
    {
        $username = '087859277817';
        // $ref = time();


        $ref = mt_rand(1000000000, 9000000000);

        if (!$request->user_id || !$request->no_pelanggan) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $indihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'inq-pasca',
            'username'    => $username,
            'code'    => 'TELKOMPSTN',
            'hp'        => $request->no_pelanggan,
            'ref_id'    => $ref,
            'sign'    => md5($username . '54562298422ad2a7' . $ref)
        ])->json();

        if ($indihome["data"]["response_code"] == 14) {
            $ref1 = mt_rand(1000000000, 9000000000);
            $nonIndihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
                'commands' => 'inq-pasca',
                'username' => $username,
                'code'     => 'CBN',
                'hp'       => $request->no_pelanggan,
                'ref_id'   => $ref1,
                'sign'     =>  md5($username . '54562298422ad2a7' . $ref1)


            ])->json();

            if ($nonIndihome["data"]["response_code"] == 14) {
                $ref2 = mt_rand(1000000000, 9000000000);

                $PLN = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
                    'commands'    => 'inq-pasca',
                    'username'    => $username,
                    'code'    => 'PLNPOSTPAID',
                    'hp'    => $request->no_pelanggan,
                    'ref_id'    => $ref2,
                    'sign'    => md5($username . '54562298422ad2a7' . $ref2)
                ])->json();

                $PLN['type'] = 4;


                if ($PLN["data"]["response_code"] == 14){
                    return ResponseFormatter::failed('tidak boleh nomer pelanggan!', 404);

                }
                return $PLN;

            }
            $nonIndihome['type'] = 3;
            return $nonIndihome;
        }

        $indihome['type'] = 3;
        return $indihome;
    }



    public function paymentTelkom(Request  $request)
    {
        if(!$request->type || !$request->tr_id || !$request->user_id || !$request->no_pelanggan || !$request->bank || !$request->price || !$request->bukti_tf){
            return ResponseFormatter::failed('tidak boleh ada field kososng!', 404);
        }

        $today = Carbon::now()->toDateString();
        $cek_pembayaran = pembayaranMobilePulsa::where('user_id', $request->user_id)->where('no_pelanggan', $request->no_pelanggan)->where('status', '!=', 2)->orderBy('id', 'desc')->first();
        // dd($cek_pembayaran);
        if ($cek_pembayaran != null) {
            $tgl = Carbon::parse($cek_pembayaran->created_at)->toDateString();
            if ($tgl == $today) {
                return ResponseFormatter::failed('tagihan ini sudah dibayar!', 404);
            }
        }



        $mobilPulsa = new pembayaranMobilePulsa();
        $mobilPulsa->type = $request->type;
        $mobilPulsa->tr_id = $request->tr_id;
        $mobilPulsa->user_id = $request->user_id;
        $mobilPulsa->no_pelanggan = $request->no_pelanggan;
        $mobilPulsa->bank = $request->bank;
        $mobilPulsa->nominal = $request->price;
        if ($request->bukti_tf) {
            $data = substr($request->bukti_tf, strpos($request->bukti_tf, ',') + 1);
            $data = base64_decode($data);

            $fileName = Str::random(10) . '.png';
            Storage::put('bukti_tf/' . $fileName, $data);

            $url = 'storage/bukti_tf/' . $fileName;
            $image = Image::make($url);
            $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });


            Storage::put('bukti_tf/' . $fileName, (string) $image->encode());
            // dd($fileName);
            $image_path = 'bukti_tf/' . $fileName;
            $mobilPulsa->update(
                [
                    'bukti_tf' => $image_path
                ]
            );
            $mobilPulsa->bukti_tf = $image_path;
        }

        $mobilPulsa->save();

        if($request->type == 3){
            $tipe_notif = 6;
        }else if($request->type == 4){
            $tipe_notif = 5;
        }

        if($request->type == 3){
            $tipe = 'INTERNET';
        }else if($request->type == 4){
            $tipe = 'PLN';
        }

        $notifikasi_admin = new Notifikasi();
        $notifikasi_admin ->user_id = null;
        $notifikasi_admin ->sisi_notifikasi = 'admin';
        $notifikasi_admin -> heading = 'PEMBAYARAN ' .$tipe. ' BARU';
        $notifikasi_admin ->desc = 'ada penghuni yang melakukan pembayaran';
        $notifikasi_admin -> link = '/mobile-pulsa';
        $notifikasi_admin ->save();

        PusherFactory::make()->trigger('admin', 'kirim', ['data' => $notifikasi_admin]);

        $notifikasi = new Notifikasi();
        $notifikasi->type = $tipe_notif;
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'BERHASIL MELAKUKAN PEMBAYARAN '. $tipe;
        $notifikasi->desc = 'Terimakasih sudah melakukan pembayaran ' .$tipe. ', pembayaran anda sedang di proses Admin';
        $notifikasi->save();

        // $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
            // dd($fcmTokens);
             larafirebase::withTitle('BERHASIL MELAKUKAN PEMBAYARAN '. $tipe)
            ->withBody('Terimakasih sudah melakukan pembayaran ' .$tipe. ', pembayaran anda sedang di proses Admin')
            // ->withImage('https://firebase.google.com/images/social.png')
            ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
            ->withClickAction('admin/notifications')
            ->withPriority('high')
            ->withAdditionalData([
                'halo' => 'isinya',
            ])
            ->sendNotification($fcmTokens);

        return ResponseFormatter::success('berhasil melakukan pembayaran', $mobilPulsa);
    }



    public function riwayat(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('data tidak boleh kosong!', 404);
        }


        $cekriwayat = Riwayat::with('type')->where('user_id', $request->user_id)->orderBy('created_at', 'desc')->get();

        if ($cekriwayat->count() == 0) {
            return ResponseFormatter::failed('tidak ada riwayat!', 404);
        }

        if($request->status){
            if($request->status == 1){
                $riwayat = [];
                $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                for ($i = 1; $i <= 12; $i++) {
                    $total_income['month'] = $data[$i - 1];
                    $total_income['lists'] = Riwayat::with('type')->where('type_pembayaran', 1)->where('user_id', $request->user_id)->whereMonth('created_at', $i)->orderBy('created_at', 'desc')->get();

                    if ($total_income['lists']->count() != 0) {
                        array_push($riwayat, $total_income);
                    }
                }
                return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);
            }else if($request->status == 3){
                $riwayat = [];
                $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                for ($i = 1; $i <= 12; $i++) {
                    $total_income['month'] = $data[$i - 1];
                    $total_income['lists'] = Riwayat::with('type')->where('type_pembayaran', 3)->where('user_id', $request->user_id)->whereMonth('created_at', $i)->orderBy('created_at', 'desc')->get();

                    if ($total_income['lists']->count() != 0) {
                        array_push($riwayat, $total_income);
                    }
                }
                return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);
            }else if($request->status == 4){
                $riwayat = [];
                $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                for ($i = 1; $i <= 12; $i++) {
                    $total_income['month'] = $data[$i - 1];
                    $total_income['lists'] = Riwayat::with('type')->where('type_pembayaran', 4)->where('user_id', $request->user_id)->whereMonth('created_at', $i)->orderBy('created_at', 'desc')->get();

                    if ($total_income['lists']->count() != 0) {
                        array_push($riwayat, $total_income);
                    }
                }
                return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);
            }
        }else{
            $riwayat = [];

            $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            for ($i = 1; $i <= 12; $i++) {
                $total_income['month'] = $data[$i - 1];
                $total_income['lists'] = Riwayat::with('type')->where('user_id', $request->user_id)->whereMonth('created_at', $i)->orderBy('created_at', 'desc')->get();

                if ($total_income['lists']->count() != 0) {
                    array_push($riwayat, $total_income);
                }
            }
            return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);
        }


    }

    public function riwayatMobilePulsa(Request $request){
        if(!$request->user_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if($request->status){
            if($request->status == 3){
                $cekriwayat = Riwayat::with('type')->where('user_id', $request->user_id)->where('type_pembayaran', 3)->orderBy('created_at', 'desc')->get();

                if ($cekriwayat->count() == 0) {
                    return ResponseFormatter::failed('tidak ada riwayat!', 404);
                }

                return ResponseFormatter::success('berhasil mengambil data riwayat PLN!', $cekriwayat);
            }else if($request->status == 4){
                $cekriwayat = Riwayat::with('type')->where('user_id', $request->user_id)->where('type_pembayaran', 4)->orderBy('created_at', 'desc')->get();

                if ($cekriwayat->count() == 0) {
                    return ResponseFormatter::failed('tidak ada riwayat!', 404);
                }

                return ResponseFormatter::success('berhasil mengambil data riwayat Internet!', $cekriwayat);
            }
        }else{
            return ResponseFormatter::failed('Masukkan status!', 404);
        }


    }





}
