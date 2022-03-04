<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PanicButton;
use App\Models\User;
use Illuminate\Http\Request;

class PanicButtonController extends Controller
{
    public function store(Request $request)
    {
        if(!$request -> user_id || !$request -> properti_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 401);
        }

        $user = User::where('id', $request -> user_id)->first();
        if($user == null){
            return ResponseFormatter::failed('tidak ada data user ini!', 401);
        }
        $panic = new PanicButton();
        $panic -> user_id = $request -> user_id;
        $panic -> id_rumah = $request -> properti_id;
        $panic -> status_keterangan = 'not checked';
        $panic -> save();

        if($panic){
            return ResponseFormatter::success('berhasil mengambil data panic buttond!', $panic);
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

