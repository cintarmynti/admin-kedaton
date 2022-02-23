<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Models\Listing;
use App\Models\Properti;
use Illuminate\Support\Facades\File;
// use Hash;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
// use Mail;

class UserController extends Controller
{
    public function getNik(Request $request){

        $user_detail = User::where('nik', $request->nik)->first();
        if($request->nik == null){
            return ResponseFormatter::failed('mohon masukkan nik terlebih dahulu!', 404);
        }

        if($user_detail == null){
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
        }
        return ResponseFormatter::success('sukses mengambil detail user!', [$user_detail]);

    }

    private function checkEmailExists($email)
    {
        return User::where('email', $email)->first();
    }

    public function register(Request $request){


            $cekNik = User::where('nik', $request->nik)->first();
            if($cekNik == null){
                return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
            }

            

            // dd($cekNik != null);
            if($cekNik != null && $request->snk == 1){
                $pw = Str::random(8);
                // dd($pw);
                $hashed_random_password = Hash::make($pw);
                $cekNik->password = $hashed_random_password;
                $cekNik->email = $request->email;
                $cekNik->snk = 1;
                $cekNik->save();

            dd($cekNik);

                $details = [
                    'recipient' => $request->email,
                    'fromEmail' => 'coba@gmail.com',
                    'nik' => $request->nik,
                    'subject' => $pw
                ];

                Mail::to($details['recipient'])->send(new MyTestMail($details));

                dd("Email sudah terkirim.");

                return ResponseFormatter::success('anda telah sukses regristasi! password dikirim melalui email', $pw);

            }
    }



    public function login(Request $request){
        $cekNik = User::where('nik', $request->nik)->first();
        if($cekNik == null){
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
        }

        $pw = Hash::check($request->password, $cekNik->password);
        if($cekNik != null && $pw){
            return ResponseFormatter::success('User telah berhasil login!', $cekNik);
        }else{
            return ResponseFormatter::failed('User Login Failed!', 401, ['Unauthorized']);

        }
    }






    public function profile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        // dd($user);
        $properti = Properti::where('pemilik_id', $user->id)->get  ();
        // dd($properti);
        return ResponseFormatter::success('get user profile n properti!', [$user, $properti]);

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
