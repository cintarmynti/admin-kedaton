<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\complain_image;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ComplainController extends Controller
{
    public function store(Request $request)
    {
        $complain = new Complain();
        $complain->user_id = $request->user_id;
        $complain->nama = $request->nama;
        $complain->alamat = $request->alamat;
        $complain->catatan = $request->catatan;
        $complain->status = 'diajukan';
        $complain->save();

        foreach($request->gambar as $gbr){

            $image = $gbr;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'complain_image/'. Str::random(10) . '.png';

            Storage::disk('public')->put($imageName, base64_decode($image));

            $complain_image = new complain_image();
            $complain_image->image = $imageName;
            $complain_image->complain_id = $complain->id;
            $complain_image->save();
        }

        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'BERHASIL MENGAJUKAN COMPLAIN';
        $notifikasi->desc = 'Complain berhasil dikirim, complain anda masih diajukan, menunggu perubahan status oleh admin';
        $notifikasi->save();

        $notifikasi_admin = new Notifikasi();
        $notifikasi_admin ->user_id = null;
        $notifikasi_admin ->sisi_notifikasi = 'admin';
        $notifikasi_admin -> heading = 'PENGAJUAN COMPLAIN BARU';
        $notifikasi_admin ->desc = 'ada pengajuan complain baru';
        $notifikasi_admin ->save();

        return ResponseFormatter::success('berhasil mengirim complain!', $complain);

    }

    public function getComplain(Request $request){
        if(!$request->user_id){
            return ResponseFormatter::failed('tidak boleh ada field kososng!', 404);
        }

        if($request->status){
            $complain = Complain::where('status', $request->status)->where('user_id', $request->user_id)->get();
            if($complain->count() == 0){
            return ResponseFormatter::failed('tidak ada complaiin dengan status tsb!', 401);
            }
            return ResponseFormatter::success('berhasil mengembil complin dengann status!', $complain);
        }

        $complain = Complain::where('user_id', $request->user_id)->get();
        return ResponseFormatter::success('berhasil mengembil semua complain!', $complain);
    }
}
