<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Lib\PusherFactory;
use Intervention\Image\Facades\Image;
use App\Models\Complain;
use App\Models\complain_image;
use App\Models\Notifikasi;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kutia\Larafirebase\Facades\Larafirebase;

class ComplainController extends Controller
{
    public function store(Request $request)
    {
        $complain = new Complain();
        $complain->user_id = $request->user_id;
        $complain->nama = $request->nama;
        $complain->alamat = $request->alamat;
        $complain->catatan = $request->catatan;
        $complain->properti_id = $request->properti_id;
        $complain->status = 'diajukan';
        $complain->save();

        foreach($request->gambar as $gbr){

            // $image = $gbr;  // your base64 encoded
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $image);
            // $imageName = 'complain_image/'. Str::random(10) . '.png';

            // Storage::disk('public')->put($imageName, base64_decode($image));


            $data = substr($gbr, strpos($gbr, ',') + 1);
            $data = base64_decode($data);

            $fileName = Str::random(10) . '.png';
            Storage::put('complain_image/' . $fileName, $data);

            $url = 'storage/complain_image/' . $fileName;
            $image = Image::make($url);
            $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });


            Storage::put('complain_image/' . $fileName, (string) $image->encode());
            // dd($fileName);
            $image_path = 'complain_image/' . $fileName;


            $complain_image = new complain_image();
            $complain_image->image = $image_path;
            $complain_image->complain_id = $complain->id;
            $complain_image->save();
        }

        $notifikasi = new Notifikasi();
        $notifikasi->type = 3;
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'BERHASIL MENGAJUKAN COMPLAIN';
        $notifikasi->desc = 'Complain berhasil dikirim, complain anda masih diajukan, menunggu perubahan status oleh admin';
        $notifikasi->save();

        //batas
        $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        $notif = larafirebase::withTitle('BERHASIL MENGAJUKAN COMPLAIN')
        ->withBody('Complain berhasil dikirim, complain anda masih diajukan, menunggu perubahan status oleh admin')
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);

        $notifikasi_admin = new Notifikasi();
        $notifikasi_admin ->user_id = null;
        $notifikasi_admin ->sisi_notifikasi = 'admin';
        $notifikasi_admin -> heading = 'PENGAJUAN COMPLAIN BARU, PADA ALAMAT '.$request->alamat .' OLEH '. $request->nama ;
        $notifikasi_admin ->desc = 'ada pengajuan complain baru';
        $notifikasi_admin -> link = '/complain/detail/image/'.$complain->id;
        $notifikasi_admin ->save();

        PusherFactory::make()->trigger('admin', 'kirim', ['data' => $notifikasi_admin]);

        return ResponseFormatter::success('berhasil mengirim complain!', $complain);

    }

    public function getComplain(Request $request){
        if(!$request->user_id){
            return ResponseFormatter::failed('tidak boleh ada field kososng!', 404);
        }

        if($request->status){
            $complain = Complain::where('status', $request->status)->where('user_id', $request->user_id)->get();
            if($complain->count() == 0){
            return ResponseFormatter::failed('tidak ada complaiin dengan status tsb!', 404);
            }
            return ResponseFormatter::success('berhasil mengembil complin dengann status!', $complain);
        }

        $complain = Complain::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
        // foreach($complain as $com){
            // foreach($complain->gambar as $gbr){
            //     $complain->gambar_image = $gbr;
            // }

        // }
        return ResponseFormatter::success('berhasil mengembil semua complain!', $complain);
    }

    public function getProperti(Request $request){
        $properti = Properti::with(
            [
                'cluster' => function ($cluster) {
                    $cluster->select('id','name');
                }
            ]
        )->where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get(['id', 'cluster_id', 'no_rumah']);

        if($properti->count() == 0){
            return ResponseFormatter::failed('user tidak memiliki rumah!', 404);
        }

        return ResponseFormatter::success('berhasil mengembil semua complain!', $properti);
    }
}
