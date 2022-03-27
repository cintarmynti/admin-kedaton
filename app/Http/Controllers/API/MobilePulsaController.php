<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mobile_pulsa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $ref = time();

        if(!$request->user_id || !$request->no_hp){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $indihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'inq-pasca',
            'username'	=> $username,
            'code'	=> 'TELKOMPSTN',
            'hp'        => $request->no_hp,
            'ref_id'	=> $ref,
            'sign'	=> md5($username.'54562298422ad2a7'.$ref)
        ])->json();


            $mobile = new Mobile_pulsa();
            $mobile->user_id = $request->user_id;
            $mobile->no_hp = $request->no_hp;
            $mobile->jenis_pembayaran = 'INDIHOME_INTERNET';
            $mobile->total = $indihome["data"]["price"];
            $mobile->save();

        return $indihome;
    }
}
