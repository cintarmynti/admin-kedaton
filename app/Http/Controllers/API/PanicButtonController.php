<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PanicButton;
use Illuminate\Http\Request;

class PanicButtonController extends Controller
{
    public function store(Request $request)
    {
        $panic = new PanicButton();
        $panic -> user_id = $request -> user_id;
        $panic -> id_rumah = $request -> properti_id;
        $panic -> save();

        if($panic){
            return ResponseFormatter::success('berhasil menambah penghuni!', $panic);
        }else{
            return ResponseFormatter::failed('gagal menambah penghuni!', 401);
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
}
