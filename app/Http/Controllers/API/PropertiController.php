<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Cluster;
use App\Models\Properti;
use App\Models\tarif_ipkl;
use Illuminate\Http\Request;
use App\Models\Properti_image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\ResponseFormatter;
use App\Mail\KedatonNewMember;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PropertiController extends Controller
{
    public function getcluster(){
        $cluster = Cluster::all();

        if($cluster){
            return ResponseFormatter::success('berhasil mengambil data cluster!', $cluster);
        }else{
            return ResponseFormatter::failed('gagal mengambil data cluster!', 401);
        }
    }

    public function newProp(Request $request){

        $cek_properti = Properti::find($request->properti_id);
        if($cek_properti == null){
            return ResponseFormatter::failed('tidak ada properti dengan id tersebut!', 404);
        }

        if($cek_properti->pemilik_id != null){
            return ResponseFormatter::failed('rumah ini sudah memiliki pemilik!', 404);
        }

        $cek_pengajuan = Pengajuan::where('user_id', $request->user_id)->where('properti_id', $request->properti_id)->first();
        if($cek_pengajuan){
            return ResponseFormatter::success('rumah ini sudah diajukan, pengajuan anda masih dalam proses, mohon tunggu konfirmasi admin!', 200);
        }

        if(!$request->user_id || !$request->properti_id){
            return ResponseFormatter::failed('isi inputan terlebih dahulu!', 404);

        }

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $request->user_id;
        $pengajuan->properti_id = $request->properti_id;
        $pengajuan->save();

        $properti= Properti::where('id', $request->properti_id)->first();
        $properti->status_pengajuan = 1;
        $properti->update();

        if($pengajuan){
            return ResponseFormatter::success('berhasil mengirimm pengajuan properti baru, mohon tunggu konfirmasi admin!', $pengajuan);
        }else{
            return ResponseFormatter::failed('gagal mengirim pengajuan!', 404);
        }
    }

    public function getNomer(Request $request){
        $no_rumah = Properti::with('cluster')->where('cluster_id', $request->cluster_id)->where('pemilik_id', null)->get();
        $cek_isi = Properti::where('cluster_id', $request->cluster_id)->where('pemilik_id', null)->first();

        if(!$request->cluster_id){
            return ResponseFormatter::failed('beri paramater cluster terlebih dahulu!', 401);
        }

        if($cek_isi == null){
            return ResponseFormatter::failed('tidak ada data, mohon isi properti terlebih dahulu atau mungkin semua properti sudah dimiliki!', 401);
        }

        if($no_rumah){
            return ResponseFormatter::success('berhasil mengambil data no rumah yang tidak ada pemilik!', $no_rumah);
        }else{
            return ResponseFormatter::failed('gagal mengambil data no rumah yang tidak ada pemilik!', 401);
        }
    }


   public function index(Request $request)
    {
        $pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $penghuni = Properti::where('penghuni_id', $request->user_id)->first();
            // dd($pemilik);
        if($pemilik != null){
                $rumah_pemilik = Properti::with('cluster', 'penghuni', 'pemilik')->where('pemilik_id', $request->user_id)->get();
                return ResponseFormatter::success('successful to create new prop!', $rumah_pemilik);
        }else if($penghuni != null){
                $rumah_penghuni = Properti::with('cluster', 'penghuni', 'pemilik')->where('penghuni_id', $request->user_id)->get();
                return ResponseFormatter::success('successful to create new prop!', $rumah_penghuni);
        }else if($pemilik == null && $penghuni == null){
                return ResponseFormatter::failed('user ini tidak memiliki properti!', 401);
        }
    }

   public function detailprop(Request $request){

        if(!$request->prop_id){
            return ResponseFormatter::failed('beri paramater properti id terlebih dahulu!', 401);
        }

        $properti = Properti::with( [
            'pemilik' => function ($pemilik) {
                $pemilik->select('id','name');
            },
            'penghuni' => function ($penghuni) {
                $penghuni->select('id','name');
            },
            'cluster' => function ($cluster) {
                $cluster->select('id','name');
            }
        ])->where('id', $request->prop_id)->select('id','no_rumah', 'penghuni_id', 'pemilik_id', 'cluster_id', 'luas_tanah', 'luas_bangunan', 'jumlah_kamar', 'kamar_mandi', 'carport')->first();
        $properti->gambar = url('/').'/storage/'.$properti->cover_url;

        // dd($properti);

        if($properti == null){
            return ResponseFormatter::failed('tidak ada properti dengan id tsb!', 400);
        }

        if($properti){
            return ResponseFormatter::success('berhasil menampilkan detail properti!', $properti);
        }else{
            return ResponseFormatter::failed('gagal menampilkan detail properti!', 401);
        }

   }

   private function checkEmailExists($email)
   {
       return User::where('email', $email)->first();
   }



   public function addPenghuni(Request $request){
       $cek_nik = User::where('nik', $request->nik)->first();

       if(Properti::where('id', $request->properti_id == null)){
         return ResponseFormatter::failed('tidak ada properti id ini!', 401);
       }

        if( $cek_nik != null && $request->snk == 1){
           $properti_disewa = Properti::where('id', $request->properti_id)->first();
           $properti_disewa -> penghuni_id = $cek_nik->id;
           $properti_disewa->save;


        $cek_pengajuan = Pengajuan::where('user_id', $cek_nik->id)->where('properti_id_penghuni', $request->properti_id)->first();
        if($cek_pengajuan){
            return ResponseFormatter::success('penghuni ini sudah diajukan, pengajuan anda masih dalam proses, mohon tunggu konfirmasi admin!', 200);
        }

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $cek_nik->id;
        $pengajuan->properti_id_penghuni = $request->properti_id_penghuni;
        $pengajuan->update();

        $properti= Properti::where('id', $request->properti_id)->first();
        $properti->status_pengajuan_penghuni = 1;
        $properti->update();

            return ResponseFormatter::success('berhasil menambah penghuni, menunggu konfirmasi!', [$cek_nik]);

        }

        if(User::where('email', $request->email)->first() != null){
            return ResponseFormatter::failed('email ini sudah terdaftar silahkan login!', 401);
        }

        $user = new User();
        $user -> name = $request->name;
        $user -> email = $request->email;
        $user -> nik = $request->nik;
        $user -> alamat = $request -> alamat;
        $user -> user_status = 'pengguna';
        $user -> phone = $request -> phone;
        $user -> snk = $request -> snk;

        if($request->foto_ktp){
            $image = $request->foto_ktp;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'user_photo_ktp/'.Str::random(10) . '.png';

            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        $user -> photo_ktp = $imageName;
        $user->save();
        $pw = Str::random(8);

        $details = [
            'recipient' => $request->email,
            'fromEmail' => 'coba@gmail.com',
            'nik' => $request->nik,
            'subject' => $pw
        ];

        Mail::to($details['recipient'])->send(new KedatonNewMember($details));

        $user_penghuni = User::where('id', $user->id)->first();
        $user_penghuni ->photo_ktp = $user_penghuni ->image_ktp;

        $cek_pengajuan = Pengajuan::where('user_id', $user_penghuni->id)->where('properti_id_penghuni', $request->properti_id)->first();
        if($cek_pengajuan){
            return ResponseFormatter::success('penghuni ini sudah diajukan, pengajuan anda masih dalam proses, mohon tunggu konfirmasi admin!', 200);
        }

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $user_penghuni->id;
        $pengajuan->properti_id_penghuni = $request->properti_id;
        $pengajuan->save();

        $properti= Properti::where('id', $request->properti_id)->first();
        // dd($properti);
        $properti->status_pengajuan_penghuni = 1;
        $properti->save();


        if($user){
            return ResponseFormatter::success('berhasil menambah penghuni!', [$user_penghuni, $pw]);
        }else{
            return ResponseFormatter::failed('gagal menambah penghuni!', 401);
        }
   }
}
