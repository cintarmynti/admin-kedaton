<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Tagihan;
use App\Models\User;
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

            $user = User::where('id', $request->user_id)->first();
            $params = ["external_id" => $code,
            "bank_code" => $request->code,
            "name" => $user->name,
            "expected_amount" => $request->pembayaran
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
        return ResponseFormatter::success('berhasil mengambil data riwayat Internet!', $createVA);

    }

    public function closeVaPayment($id, Request $request)
    {
        Xendit::setApiKey($this->token);

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

        dd($result);
    }
}
