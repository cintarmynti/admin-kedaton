<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\User;

class NotifikasiController extends Controller
{
    public function countNotif(Request $request)
    {
        $cek_user = User::where('id', $request->user_id)->first();
        // dd($cek_user);

        if($cek_user == null){
            return ResponseFormatter::failed('tidak ada User dengan dengan id yang di input!', 401);
        }
        $notif = Notifikasi::where('user_id', $request->user_id)->count();
        return ResponseFormatter::success('Success to count notifications!', $notif);
    }

    public function notif(Request $request)
    {
        $cek_user = User::where('id', $request->user_id)->first();
        if($cek_user == null){
            return ResponseFormatter::failed('tidak ada User dengan dengan id yang di input!', 401);
        }
        $notif = Notifikasi::where('user_id', $request->user_id)->get();
        return ResponseFormatter::success('Success to get notifications!', $notif);

    }
}
