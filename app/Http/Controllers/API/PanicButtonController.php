<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Lib\PusherFactory;
use App\Models\Notifikasi;
use App\Models\PanicButton;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanicButtonController extends Controller
{
    public function store(Request $request)
    {
        if(!$request -> user_id || !$request -> properti_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $user = User::where('id', $request -> user_id)->first();
        $properti = Properti::where('id', $request -> properti_id)->first();
        if($user == null){
            return ResponseFormatter::failed('tidak ada data user ini!', 401);
        }

        if($properti == null){
            return ResponseFormatter::failed('tidak ada properti ini!', 401);

        }
        $panic = new PanicButton();
        $panic -> user_id = $request -> user_id;
        $panic -> id_rumah = $request -> properti_id;
        $panic -> status_keterangan = 'not checked';
        $panic -> save();

        $notifikasi_admin = new Notifikasi();
        $notifikasi_admin ->user_id = null;
        $notifikasi_admin ->sisi_notifikasi = 'admin';
        $notifikasi_admin -> heading = 'PANIC BUTTON BARU, PADA ALAMAT '.$properti->alamat .' OLEH '.$user->name;
        $notifikasi_admin ->desc = 'ada panic button baru';
        $notifikasi_admin -> link = '/panic-button';
        $notifikasi_admin ->save();

        // PusherFactory::make()->trigger('admin', 'kirim', ['data' => $notifikasi_admin]);

        $panic_button['panic'] = PanicButton::where('id', $panic->id)->first('id');
        $panic_button['properti'] = Properti::with('cluster')->where('id', $panic -> id_rumah)->first(['id', 'no_rumah', 'cluster_id']);
        // dd($panic_button);

        PusherFactory::make()->trigger('chat', 'send', ['data' => $panic_button]);

        if($panic){
            return ResponseFormatter::success('berhasil mengambil data panic buttond!', $panic_button);
        }else{
            return ResponseFormatter::failed('gagal mengambil data panic button!', 401);
        }
    }

    // public function status($id){
    //     $data = PanicButton::findOrFail($id);
    //     // dd($status_id);
    //     $status_sekarang = $data->status_keterangan;
    //     if($status_sekarang == 1){
    //         PanicButton::where('id', $id)->update([
    //             'status_keterangan' => 'checked'
    //         ]);
    //     }

    //     return redirect('/ipkl');
}

