<?php

namespace App\Http\Controllers\API;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Models\pembayaranMobilePulsa;
use App\Models\Riwayat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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


        $ref = mt_rand(1000000000,9000000000);

        if(!$request->user_id || !$request->no_pelanggan){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $indihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'inq-pasca',
            'username'	=> $username,
            'code'	=> 'TELKOMPSTN',
            'hp'        => $request->no_pelanggan,
            'ref_id'	=> $ref,
            'sign'	=> md5($username.'54562298422ad2a7'.$ref)
        ])->json();

        if($indihome["data"]["response_code"] == 14){
        $ref1 = mt_rand(1000000000,9000000000);
            $nonIndihome  = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
                'commands' => 'inq-pasca',
                'username' => $username,
                'code'     => 'CBN',
                'hp'       => $request->no_pelanggan,
                'ref_id'   => $ref1,
                'sign'     =>  md5($username.'54562298422ad2a7'.$ref1)


            ])->json();

            if($nonIndihome["data"]["response_code"] == 14){
                $ref2 = mt_rand(1000000000,9000000000);

                $PLN = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
                    'commands'	=> 'inq-pasca',
                    'username'	=> $username,
                    'code'	=> 'PLNPOSTPAID',
                    'hp'	=> $request->no_pelanggan,
                    'ref_id'    => $ref2,
                    'sign'	=> md5($username.'54562298422ad2a7'.$ref2)
                ])->json();

                $PLN['type'] = 4;
                return $PLN;
            }
            $nonIndihome['type'] = 3;
            return $nonIndihome;
        }

        $indihome['type'] = 3;
        return $indihome;
    }



    public function paymentTelkom(Request  $request){
    $today = Carbon::now()->toDateString();
    $cek_pembayaran = pembayaranMobilePulsa::where('no_pelanggan', $request->no_pelanggan)->where('status', '!=', 2)->orderBy('id', 'desc')->first();
    // dd($cek_pembayaran);
    if($cek_pembayaran != null){
        $tgl = Carbon::parse($cek_pembayaran->created_at)->toDateString();
    if($tgl == $today){
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

        $fileName = Str::random(10).'.png';
        Storage::put('bukti_tf/' . $fileName, $data);

        $url = 'storage/bukti_tf/'. $fileName;
        $image = Image::make($url);
        $image->resize(500, null, function($constraint){
            $constraint->aspectRatio();
        });


        Storage::put('bukti_tf/'.$fileName, (string) $image->encode());
        // dd($fileName);
        $image_path = 'bukti_tf/'.$fileName;
        $mobilPulsa->update(
            [
                'bukti_tf' => $image_path
            ]
        );
      $mobilPulsa->bukti_tf = $image_path;

    }

      $mobilPulsa->save();

      return ResponseFormatter::success('berhasil melakukan pembayaran', $mobilPulsa);

    }



    public function riwayat(Request $request){
        if(!$request->user_id){
            return ResponseFormatter::failed('data tidak boleh kosong!', 404);
        }


        $cekriwayat = Riwayat::with('type')->where('user_id', $request->user_id)->orderBy('created_at', 'desc')->get();

        if($cekriwayat->count() == 0){
            return ResponseFormatter::failed('tidak ada riwayat!', 404);
        }

        $riwayat = [];

        $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        for ($i = 1; $i <= 12; $i++) {
            $total_income['month'] = $data[$i - 1];
            $total_income['lists'] = Riwayat::with('type')->where('user_id', $request->user_id)->whereMonth('created_at', $i)->orderBy('created_at', 'desc')->get();

            if($total_income['lists']->count() != 0){
                array_push($riwayat, $total_income);
            }
        }
        return ResponseFormatter::success('berhasil mengambil data riwayat!', $riwayat);

    }


    // public function paymentPDAM(Request $request){
    //     if(!$request->user_id || !$request->tr_id){
    //         return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
    //     }
    //     $username = '087859277817';
    //     $pdam = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
    //         'commands' => 'pay-pasca',
    //         'username' => $username,
    //         'tr_id'    => $request->tr_id,
    //         'sign'     => md5($username.'54562298422ad2a7'.$request->tr_id)
    //     ])->json();

    //     if($pdam["data"]["response_code"] == 01){
    //         return $pdam;
    //     }

    //     $riwayat = new Riwayat();
    //     $riwayat->user_id = $request->user_id;
    //     $riwayat->harga = $pdam["data"]["price"];
    //     $riwayat->type_pembayaran = 3;
    //     $riwayat->save();

    //     return $pdam;
    // }

    // public function inquiryPDAM(Request $request){
    //     if(!$request->user_id || !$request->no_pdam){
    //         return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
    //     }
    //     $username = '087859277817';
    //     $ref = time();
    //     $pdam = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
    //         'commands'	=> 'inq-pasca',
    //         'username'	=> $username,
    //         'code'	=> 'PDAMKOTA.SURABAYA',
    //         'hp'	=> $request->no_pdam,
    //         'ref_id'	=> $ref,
    //         'sign'      => md5($username.'54562298422ad2a7'.$ref)
    //     ])->json();

    //     $pdam['type'] = 4;
    //     return $pdam;
    // }




}
