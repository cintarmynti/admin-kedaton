<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Xendit\Xendit;


class XenditController extends Controller
{
    private $token = 'xnd_development_j8CM3HD1RHQRhXPCeRsbYJW6HeMR0LZl5PIQyJXiYQ6uThWp4orLqKLxYWPPNvn';

    public function getBank()
    {
        Xendit::setApiKey($this->token);
        $getVaBanks = \Xendit\VirtualAccounts::getVABanks();
        return response()->json([
            'data' => $getVaBanks
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


            $params = ["external_id" => $code,
            "bank_code" => $request->code,
            "name" => $request->name,
            "expected_amount" => $request->pembayaran
            ];


            foreach($request->tagihan_id as $tagihan){
                $cek_tagihan = Tagihan::where('id', $tagihan)->first();

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
        return response()->json([
            'data' => $createVA
        ])->setStatusCode(200);

    }
}
