<?php

namespace App\Http\Controllers\API;

use Kutia\Larafirebase\Facades\Larafirebase;
use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Notifikasi;
use App\Models\Riwayat;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Xendit\Xendit;


class XenditController extends Controller
{

     private $token = 'xnd_production_WoG3EIpY1zgk8d3iNBfyRq29FMinssAtMkPAsl1Xwy7Y0tByt8WUeKlqVF5yX';

    public function getBank()
    {
        Xendit::setApiKey($this->token);
        $bank = [];
        $getVaBanks = \Xendit\VirtualAccounts::getVABanks();
        foreach($getVaBanks as $getva){
            if($getva["code"] != "BSI"){
                if($getva["code"] != "BJB"){
                    if($getva["code"] != "SAHABAT_SAMPOERNA"){
                        if($getva["code"] != "CIMB"){
                            if($getva["code"] != "PERMATA"){
                                if($getva["code"] != "BNI"){
                                    array_push($bank, $getva);
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'data' => $bank
        ])->setStatusCode(200);

    }

    public function createVa(){
        Xendit::setApiKey($this->token);

        $params = ["external_id" => "VA_fixed-12341235",
            "bank_code" => "MANDIRI",
            "name" => "Steve Wozniak",
            "expected_amount" => 12000
            ];


            $createVA = \Xendit\VirtualAccounts::create($params);
            return response()->json([
                'data' => $createVA
            ])->setStatusCode(200);
    }

    public function store(Request $request)
    {
        Xendit::setApiKey($this->token);
        $code = "INV-" . time() . "-" . str_pad(rand(0,99), 4 , "0", STR_PAD_LEFT);

        // dd($request->pembayaran);

            $user = User::where('id', $request->user_id)->first();
            $params = ["external_id" => $code,
            "bank_code" => $request->code,
            "name" => $user->name,
            "amount" => $request->pembayaran
            ];

            foreach($request->tagihan_id as $tagihan){
                $cek_tagihan = Tagihan::where('id', $tagihan)->first();

                if($cek_tagihan == null){
                    return ResponseFormatter::failed('tidak ada tagihan!', 404);

                }

                $ipkl[] = IPKL::create([
                    'user_id' => $request->user_id,
                    'bank' => $request->code,
                    'tagihan_id' => $cek_tagihan->id,
                    'nominal' => $cek_tagihan->jumlah_pembayaran,
                    'status' => 1,
                    'periode_pembayaran' => Carbon::now(),
                    'type' => $cek_tagihan->type_id,
                    'bukti_tf' =>null,
                    'transaction_code' => $code
                ]);

                // dd($ipkl);
            }


        $createVA = \Xendit\VirtualAccounts::create($params);
        $date = $createVA["expiration_date"];
        // $fixed = date('l, d-m-Y H:i:s', strtotime($date));
        $fixed2 =Carbon::now()->addDay(1)->locale('id')->isoFormat('dddd, MMMM Do YYYY, h:mm:ss ');
        // $fixed3 = Carbon::parse($date)->locale('id')->isoFormat('dddd, MMMM Do YYYY, h:mm:ss ');
        $createVA["expiration_date"] = $fixed2;

        return ResponseFormatter::success('berhasil mengambil data riwayat Internet!', $createVA);

    }

    public function closeVaPayment($id, Request $request)
    {
        Xendit::setApiKey($this->token);

        // $cek_harga = IPKL::where('transaction_code', $id)->first();
        // // dd($cek_harga);
        // if($cek_harga->nominal != $request->amount){
        //     return ResponseFormatter::failed('amount yang dimasukkan tidak sama!', 404);
        // }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co/callback_virtual_accounts/external_id=' . $id . '/simulate_payment');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=".$request->amount);
        curl_setopt($ch, CURLOPT_USERPWD, $this->token . ':' . '');

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);




        return response()->json([
            'data' => json_decode($result, true)
        ])->setStatusCode(200);
    }

    public function callback(Request $request){
        Log::info($request);
        try {
            if ($request->external_id) {
                $transaction_id = $request->external_id;
                // $transaction = IPKL::find($transaction_id);
                $transaction = IPKL::where('transaction_code', $transaction_id)->get();
                $transaction_user = IPKL::where('transaction_code', $transaction_id)->first();

                Log::info($transaction_id);

                // $user = IPKL::where('user_id', $transaction_user->user_id)->first();
                if (count($transaction) > 0) {

                    foreach($transaction as $tr){
                        $tr->status = 3;
                        $tr->save();

                        $tagihan = Tagihan::where('id', $tr->tagihan_id)->first();
                        $tagihan->status = 3;
                        $tagihan->save();

                        $riwayat = new Riwayat();
                        $riwayat->user_id = $transaction_user->user_id;
                        $riwayat->type_pembayaran = 1;
                        $riwayat->harga = $tagihan->jumlah_pembayaran;
                        $riwayat->save();
                    }




                    $notifikasi = new Notifikasi();
                    $notifikasi->type = 1;
                    $notifikasi->user_id = $transaction_user->user_id;
                    $notifikasi->sisi_notifikasi  = 'pengguna';
                    $notifikasi->heading = 'BERHASIL MELAKUKAN PEMBAYARAN IPKL';
                    $notifikasi->desc = 'Terimakasih sudah melakukan pembayaran IPKL, pembayaran anda sedang di proses Admin';
                    $notifikasi->save();

                    // $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    $fcmTokens = User::where('id', $transaction_user->user_id)->first()->fcm_token;
                    // dd($fcmTokens);
                     larafirebase::withTitle('BERHASIL MELAKUKAN PEMBAYARAN IPKL')
                    ->withBody('Terimakasih sudah melakukan pembayaran IPKL, pembayaran anda sedang di proses Admin')
                    // ->withImage('https://firebase.google.com/images/social.png')
                    ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
                    ->withClickAction('admin/notifications')
                    ->withPriority('high')
                    ->withAdditionalData([
                        'halo' => 'isinya',
                    ])
                    ->sendNotification([$fcmTokens]);
                }

            }
        } catch (\Throwable$th) {
            Log::info($th);
            throw $th;
        }
    }

    public function status_tagihan(Request $request){
        $tagihan = IPKL::where('transaction_code', $request->id)->first();
        if($tagihan->status == 3){
            $tagihan->status = "success";
        }else if($tagihan->status == 2){
            $tagihan->status = "pending";
        }else if($tagihan->status == 1){
            $tagihan->status = "belum dibayar";
        }
        return ResponseFormatter::success('berhasil mengecek status!', $tagihan);

    }
}
