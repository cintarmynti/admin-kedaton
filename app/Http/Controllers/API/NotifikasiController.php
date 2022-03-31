<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\User;
use Kutia\Larafirebase\Facades\Larafirebase;

class NotifikasiController extends Controller
{
    public function countNotif(Request $request)
    {
        if(!$request->user_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $cek_user = User::where('id', $request->user_id)->first();
        // dd($cek_user);

        if($cek_user == null){
            return ResponseFormatter::failed('tidak ada User dengan dengan id yang di input!', 401);
        }
        $notif = Notifikasi::where('user_id', $request->user_id)->where('sisi_notifikasi', 'pengguna')->where('status_dibaca', 1)->count();
        return ResponseFormatter::success('Success to count notifications!', $notif);
    }

    public function notif(Request $request)
    {
        if(!$request->user_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }
        $cek_user = User::where('id', $request->user_id)->first();
        if($cek_user == null){
            return ResponseFormatter::failed('tidak ada User dengan dengan id yang di input!', 401);
        }
        $notif = Notifikasi::where('user_id', $request->user_id)->where('sisi_notifikasi', 'pengguna')->orderBy('created_at', 'desc')->get();

        foreach($notif as $n){
            $n -> status_dibaca = 2;
            $n->save();
        }

        if($notif->count() == 0){
            return ResponseFormatter::failed('tidak ada notif!', 401);
        }
        return ResponseFormatter::success('Success to get notifications!', $notif);

    }

    public function updateToken(Request $request){
        try{

            $user = User::where('id', $request->user_id)->first();
            $user->fcm_token = $request->token;
            $user->save();
            return response()->json([
                'success'=>true
            ]);

        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function notification(Request $request){
        // $request->validate([
        //     'title'=>'required',
        //     'message'=>'required'
        // ]);

        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            Larafirebase::withTitle($request->title = 'PEMBAYARAN IPKL TELAH DISETUJUI')
                ->withBody($request->message ='Pembayaran IPKL telah disetujui admin, terimakasih sudah membayar')
                ->sendMessage($fcmTokens);

            return response()->json(['success'=>'Notification Sent Successfully!!']);

        }catch(\Exception $e){
            report($e);
            return response()->json(['error'=>'Something goes wrong while sending notification.']);
        }
    }
}
