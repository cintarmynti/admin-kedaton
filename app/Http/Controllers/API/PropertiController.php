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


class PropertiController extends Controller
{
   public function store(Request $request)
   {
    $properti = new Properti();
    $properti->alamat = $request-> alamat;
    $properti->no_rumah = $request-> no_rumah;
    $properti->no_listrik = $request->no_listrik;
    $properti->no_pam_bsd = $request->no_pam_bsd;
    $properti->RT = $request-> RT;
    $properti->RW = $request-> RW;
    $properti->lantai = $request->lantai;
    $properti->jumlah_kamar = $request->jumlah_kamar;
    $properti->luas_tanah = $request->luas_tanah; //ini luas kavling
    $properti->luas_bangunan = $request->luas_bangunan;
    $properti->penghuni_id = $request->penghuni_id;
    $properti->pemilik_id = $request->pemilik_id;
    $properti->status = $request->status;
    $properti->harga = $request->harga;

    $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request-> luas_tanah)->where('luas_kavling_akhir', '>=', $request-> luas_tanah)->first();

    $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
    $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

    if($ipkl == null){
        if($request->luas_tanah <= $terbesar && $request->luas_tanah <= $terkecil){
            $properti-> tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
        }else if($request->luas_tanah >= $terbesar && $request->luas_tanah >= $terkecil){
            $properti-> tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
        }
    }else if($ipkl != null){
        $properti->tarif_ipkl = $ipkl->tarif * $request-> luas_tanah;
    }

    $cluster = Cluster::where('id', $request->cluster_id)->first();
    // dd($cluster);
    if ($cluster === null) {
        // User does not exist
        $clus = new Cluster();
        $clus->name = $request->cluster_id;
        $clus->save();

        $properti->cluster_id = $clus->id;

    } else {
        $properti->cluster_id = $request->cluster_id;
    }

    $properti->save();

    if($request->image)
     {
        foreach($request->image as $file)
        {
            // dd($request->image);

            $image = $file;
            // dd($image);  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            // dd($image);
            $imageName =  time().rand(0,2000).'.'.'png';
            // dd($imageName);
            File::put('properti_photo/' . $imageName, base64_decode($image));

            $file= new Properti_image();
            $file->properti_id = $properti->id;
            $file->image = '/properti_photo/'.$imageName;
            $file->save();
        }
     }



     if($properti){
        return ResponseFormatter::success('successful to create new prop!', $properti);
    }else{
        return ResponseFormatter::failed('failed to create new prop!', 401);
    }

   }

   public function edit(Request $request, $id)
   {
    $properti = properti::findOrFail($id);
    $properti-> alamat = $request-> alamat;
    $properti-> no_rumah = $request-> no;
    $properti->no_listrik = $request->listrik;
    $properti->no_pam_bsd = $request->pam;
    $properti-> RT = $request-> RT;
    $properti-> RW = $request-> RW;
    $properti-> lantai = $request->lantai;
    $properti->jumlah_kamar = $request->jumlah_kamar;
    $properti-> luas_tanah = $request->luas_tanah;
    $properti->luas_bangunan = $request->luas_bangunan;
    $properti->penghuni_id = $request->penghuni;
    $properti->pemilik_id = $request->pemilik;
    $properti-> status = $request->status;
    $properti->harga = $request->harga;

    $cluster = Cluster::where('id', $request->cluster_id)->first();
    // dd($cluster);
    if ($cluster === null) {
        // User does not exist
        $clus = new Cluster();
        $clus->name = $request->cluster_id;
        $clus->save();

        $properti->cluster_id = $clus->id;

    } else {
        $properti->cluster_id = $request->cluster_id;
    }
    $properti->update();

    if($request->image)
     {
        foreach($request->image as $file)
        {
            // $name = time().rand(1,100).'.'.$file->extension();
            // $file->move(public_path('files'), $name);
            // $files[] = $name;
            // $img = Image::make($file);
            // $img->resize(521, null,  function ($constraint)
            // {
            //     $constraint->aspectRatio();
            // });

            // $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
            // $img_path = 'properti_photo/'.$filename;
            // Storage::put($img_path, $img->encode());

            // $file= new Properti_image();
            // $file->properti_id = $properti->id;
            // $file->image = $img_path;
            // $file->save();
            $image = $file;
            // dd($image);  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            // dd($image);
            $imageName =  time().rand(0,2000).'.'.'png';
            // dd($imageName);
            File::put('properti_photo/' . $imageName, base64_decode($image));

            $file= new Properti_image();
            $file->properti_id = $properti->id;
            $file->image = '/properti_photo/'.$imageName;
            $file->save();
        }
     }

    if ($properti) {
        return ResponseFormatter::success('successful to create new prop!', $properti);
    } else {
        return ResponseFormatter::failed('failed to create new prop!', 401);
    }
   }

   public function index(Request $request)
   {
       $pemilik = Properti::where('pemilik_id', $request->user_id)->first();
       $penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        dd($pemilik);
       if($pemilik != null){
            $rumah_pemilik = Properti::where('pemilik_id', $request->user_id)->get();
            return ResponseFormatter::success('successful to create new prop!', $rumah_pemilik);
       }else if($penghuni != null){
            $rumah_penghuni = Properti::where('penghuni_id', $request->user_id)->get();
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
