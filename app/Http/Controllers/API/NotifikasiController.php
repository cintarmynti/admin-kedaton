<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function countNotif(Request $request)
    {
        $notif = Notifikasi::where('user_id', $request->user_id)->count();
        return ResponseFormatter::success('Success to count notifications!', $notif);

    }

    public function notif(Request $request)
    {
        $notif = Notifikasi::where('user_id', $request->user_id)->get();
        return ResponseFormatter::success('Success to get notifications!', $notif);

    }
}
