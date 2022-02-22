<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Listing;
use App\Models\Properti;
use Illuminate\Support\Facades\File;
use Hash;

class UserController extends Controller
{       
    public function getNik(Request $request){
    
        $user_detail = User::where('nik', $request->nik)->first();
        if($request->nik == null){
            return ResponseFormatter::failed('mohon masukkan nik terlebih dahulu!');
        }

        if($user_detail == null){
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!');
        }
        return ResponseFormatter::success('sukses mengambil detail user!', [$user_detail]);

    } 

    // public function register(Request $reques){

    // }



    public function login(Request $request)
    {

        $check_no_rumah = Properti::where('no_rumah', $request->no_rumah)->first();
        if($check_no_rumah == null){
            return ResponseFormatter::failed('User Login Failed!', 401, ['Unauthorized']);

        }
        $user = User::where('id', $check_no_rumah->pemilik_id)->first();
        $user_penghuni = User::where('id', $check_no_rumah->penghuni_id)->first();
        $pw = Hash::check($request->password, $user->password);

        if($check_no_rumah->id != null &&  $pw){
            $user_login = User::with('properti')->where('id', $user->id)->first();
            return ResponseFormatter::success('User Login Pemilik Success!', [$user_login]);
        }else if($check_no_rumah->id !=null && Hash::check($request->password, $user_penghuni->password)){
            $user_login = User::with('properti_penghuni')->where('id', $user_penghuni->id)->first();
            return ResponseFormatter::success('User Login penghuni Success!', [$user_login]);
        }

        return ResponseFormatter::failed('User Login Failed!', 401, ['Unauthorized']);



}



    public function profile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        // dd($user);
        $properti = Properti::where('pemilik_id', $user->id)->first();
        // dd($properti);
        return ResponseFormatter::success('get user profile!', [$user, $properti]);

    }


    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($request->photo_identitas) {
            $image = $request->photo_identitas;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName =  time().rand(0,2000).'.'.'png';
            File::put('user_photo/' . $imageName, base64_decode($image));
        }else{
            $imageName = $user->photo_identitas;;
        }

        $user -> name = $request->name;
        $user -> email = $request -> email;
        $user -> nik = $request -> nik;
        $user -> alamat = $request -> alamat;
        $user-> password = bcrypt($request->password);
        $user -> phone = $request -> phone;
        $user -> photo_identitas = $imageName;
        $user->update();


        if($user){
            return ResponseFormatter::success('successful to update user profile!', $user);
        }else{
            return ResponseFormatter::failed('failed to update profile!', 401);
        }




    }


}
