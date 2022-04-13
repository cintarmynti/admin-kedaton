<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mobile_pulsa;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

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
        $ref1 = time();
        $ref = mt_rand(1000000000,9000000000);

        if(!$request->user_id || !$request->no_telkom){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $indihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'inq-pasca',
            'username'	=> $username,
            'code'	=> 'TELKOMPSTN',
            'hp'        => $request->no_telkom,
            'ref_id'	=> $ref1,
            'sign'	=> md5($username.'54562298422ad2a7'.$ref1)
        ])->json();

        if($indihome["data"]["response_code"] == 14){
            $nonIndihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
                'commands' => 'inq-pasca',
                'username' => $username,
                'code'     => 'CBN',
                'hp'       => $request->no_telkom,
                'ref_id'   => $ref,
                'sign'     =>  md5($username.'54562298422ad2a7'.$ref)


            ])->json();

            return $nonIndihome;
        }


        return $indihome;
    }

    public function paymentTelkom(Request  $request){
        $username = '087859277817';

        if(!$request->user_id || !$request->tr_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $indihome = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'pay-pasca',
            'username' => $username,
            'tr_id'    => $request->tr_id,
            'sign'     => md5($username.'54562298422ad2a7'.$request->tr_id)
        ])->json();

        if($indihome["data"]["response_code"] == 01){
            return $indihome;
        }

        $riwayat = new Riwayat();
        $riwayat->user_id = $request->user_id;
        $riwayat->harga = $indihome["data"]["price"];
        $riwayat->type_pembayaran = 4;
        $riwayat->save();

        return $indihome;
    }

    public function inquiryPDAM(Request $request){
        if(!$request->user_id || !$request->no_pdam){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $username = '087859277817';
        $ref = time();
        $pdam = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands'	=> 'inq-pasca',
            'username'	=> $username,
            'code'	=> 'PDAMKOTA.SURABAYA',
            'hp'	=> $request->no_pdam,
            'ref_id'	=> $ref,
            'sign'      => md5($username.'54562298422ad2a7'.$ref)
        ])->json();

        return $pdam;
    }


    public function paymentPDAM(Request $request){
        if(!$request->user_id || !$request->tr_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $username = '087859277817';
        $pdam = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'pay-pasca',
            'username' => $username,
            'tr_id'    => $request->tr_id,
            'sign'     => md5($username.'54562298422ad2a7'.$request->tr_id)
        ])->json();

        if($pdam["data"]["response_code"] == 01){
            return $pdam;
        }

        $riwayat = new Riwayat();
        $riwayat->user_id = $request->user_id;
        $riwayat->harga = $pdam["data"]["price"];
        $riwayat->type_pembayaran = 3;
        $riwayat->save();

        return $pdam;
    }


    public function inquiryPLN(Request $request){

        $username = '087859277817';
        $ref = time();
        if(!$request->user_id || !$request->no_pln){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $pln = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands'	=> 'inq-pasca',
            'username'	=> $username,
            'code'	=> 'PLNPOSTPAID',
            'hp'	=> $request->no_pln,
            'ref_id'    => $ref,
            'sign'	=> md5($username.'54562298422ad2a7'.$ref)
        ])->json();

        return $pln;
    }

    public function paymentPLN(Request $request){
        if(!$request->user_id || !$request->tr_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $username = '087859277817';
        $pln = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'pay-pasca',
            'username' => $username,
            'tr_id'    => $request->tr_id,
            'sign'     => md5($username.'54562298422ad2a7'.$request->tr_id)
        ])->json();


        if($pln["data"]["response_code"] == 01){
            return $pln;
        }

        $riwayat = new Riwayat();
        $riwayat->user_id = $request->user_id;
        $riwayat->harga = $pln["data"]["price"];
        $riwayat->type_pembayaran = 5;
        $riwayat->save();

        return $pln;
    }

    public function riwayat(Request $request){
        $riwayat = Riwayat::with('type')->where('user_id', $request->id)->orderBy('created_at', 'desc')->get();
        if($riwayat->count() == 0){
            return ResponseFormatter::failed('tidak ada riwayat!', 404);
        }
        return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);

    }

    public function getMutasi(){
        $today = Carbon::now();
        $stringToSign = "GET".":"."https://api.klikbca.com/banking/v3/corporates/BCAAPI2016/accounts/0201245680/statem
        ents?StartDate=2016-01-29&EndDate=2016-01-30".":".bin2hex(hash('sha256', '')).":".$today;
    }
}
