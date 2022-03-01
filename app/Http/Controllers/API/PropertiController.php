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
use App\Models\Pengajuan;


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
        $cek_pengajuan = Pengajuan::where('user_id', $request->user_id)->where('properti_id', $request->properti_id)->first();
        if($cek_pengajuan){
            return ResponseFormatter::failed('pengajuan anda masih dalam proses, mohon tunggu konfirmasi admin!', 401);
        }
        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $request->user_id;
        $pengajuan->properti_id = $request->properti_id;
        $pengajuan->save();

        $properti= Properti::where('id', $request->properti_id)->first();
        $properti->status_pengajuan = 1;
        $properti->update();

        if($pengajuan){
            return ResponseFormatter::success('berhasil mengirimm pengajuan properti baru!', $pengajuan);
        }else{
            return ResponseFormatter::failed('gagal mengirim pengajuan!', 401);
        }
    }

    public function getNomer(Request $request){
        $no_rumah = Properti::where('cluster_id', $request->cluster_id)->where('pemilik_id', null)->get();

        if($no_rumah){
            return ResponseFormatter::success('berhasil mengambil data no rumah yang tidak ada pemilik!', $no_rumah);
        }else{
            return ResponseFormatter::failed('gagal mengambil data no rumah yang tidak ada pemilik!', 401);
        }
    }
//    public function store(Request $request)
//   {
//         $properti = Properti::
//   }


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

   private function checkEmailExists($email)
   {
       return User::where('email', $email)->first();
   }

   private function checkUsernameExists($name)
   {
       return User::where('name', $name)->first();
   }

   private function checkNikExists($nik)
   {
       return User::where('nik', $nik)->first();
   }


   public function addPenghuni(Request $request){
       $user = $request->all();
        $validator = Validator::make($user, [
            'nik' => 'required',
            'name' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::failed('User Registration Failed!', 401, $validator->errors());
        }

        if ($this->checkNikExists($user['nik'])) {
            return ResponseFormatter::failed('User nik Already Exists!', 409, $validator->errors());
        }

        if ($this->checkUsernameExists($user['name'])) {
            return ResponseFormatter::failed('User name Already Exists!', 409, $validator->errors());
        }

        if ($this->checkEmailExists($user['email'])) {
            return ResponseFormatter::failed('User Email Already Exists!', 409, $validator->errors());
        }


        $user = new User();
        $user -> name = $request->name;
        $user -> email = $request->email;
        $user -> nik = $request->nik;
        $user -> alamat = $request -> alamat;
        $user -> user_status = 'pengguna';
        $user -> phone = $request -> phone;

        if($request->photo_identitas){
            $image = $request->photo_identitas;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName =  time().rand(0,2000).'.'.'png';
            File::put('user_photo/' . $imageName, base64_decode($image));
            $user->photo_identitas = '/user_photo/'.$imageName;
        }
        $user->save();

        if($user){
            return ResponseFormatter::success('berhasil menambah penghuni!', $user);
        }else{
            return ResponseFormatter::failed('gagal menambah penghuni!', 401);
        }
   }
}
