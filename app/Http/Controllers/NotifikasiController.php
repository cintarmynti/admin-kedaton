<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailPages($id)
    {
        $notif = Notifikasi::find($id);
        $notif->status_dibaca = 2;
        $notif->save();

        return redirect($notif->link);
    }

    public function readAll()
    {
        $notif = Notifikasi::where('sisi_notifikasi', 'admin')->get();
        foreach($notif as $n){
            $n->status_dibaca = 2;
            $n->save();
        }

        return redirect()->back();
    }

    // public function allNotif(){
    //     $banyak_notif = Notifikasi::where('sisi_notifikasi', 'admin')->where('status_dibaca', 1)->get()->count();
    //     $semua_notif = Notifikasi::where('sisi_notifikasi', 'admin')->orderBy('created_at', 'desc')->get();

    //     return view('includes.navbar', ['banyak' => $banyak_notif, 'semua' => $semua_notif]);
    // }


}
