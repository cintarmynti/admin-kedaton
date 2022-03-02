<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\MyTestMail;
use App\Mail\PasswordBaru;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Models\Listing;
use App\Models\Properti;
use Illuminate\Support\Facades\DB;
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

            if ($this->checkEmailExists($request->email)) {
                return ResponseFormatter::failed('User name Already Exists!', 409);
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

            // dd($cekNik);

                $details = [
                    'recipient' => $request->email,
                    'fromEmail' => 'coba@gmail.com',
                    'nik' => $request->nik,
                    'subject' => $pw
                ];

                Mail::to($details['recipient'])->send(new MyTestMail($details));

                // dd("Email sudah terkirim.");

                return ResponseFormatter::success('anda telah sukses regristasi! password dikirim melalui email', $pw);

            }
    }

    public function editpass(Request $request){
        $user = User::find($request->id);

        if($user == null){
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $cek_pw_lama = Hash::check($request->password_lama, $user->password);
        // dd($cek_pw_lama);
        if($cek_pw_lama == true){
            $pw_baru = Hash::make($request->password_baru);
            $user->password = $pw_baru;
            $user->update();

            return ResponseFormatter::success('password telah diperbarui!', $pw_baru);
        }

        return ResponseFormatter::failed('gagal update password baru, cek kembali passwod lama!', 404);


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
        $pemilik = User::where('id', $request->id)->first([ 'nik','name', 'alamat', 'phone', 'email', 'photo_ktp', 'photo_identitas']);

        $pemilik->photo_identitas = $pemilik->image_url;
        $pemilik->photo_ktp = $pemilik->image_ktp;



        $properti = DB::table('properti')
        ->join('users', 'users.id', '=', 'properti.pemilik_id')
        ->join('cluster', 'cluster.id', 'properti.cluster_id')
        ->select('users.name as pemilik_id', 'cluster.name as cluster_id','luas_tanah', 'luas_bangunan', 'jumlah_kamar', 'kamar_mandi', 'carport')
        ->get();

        // dd($properti);
        $return['pemilik'] = $pemilik;
        $return['properti'] = $properti;
        return ResponseFormatter::success('get user profile n properti!', $return);

    }

    public function forget(Request $request){

        $user = User::where('email', $request->email)->first();
        $pw = Str::random(8);
        $hashed_random_password = Hash::make($pw);
        $user->password = $hashed_random_password;
        $user->save();
        $details = [
            'recipient' => $request->email,
            // 'fromEmail' => 'coba@gmail.com',
            // 'nik' => $request->nik,
            'subject' => $pw
        ];

        Mail::to($details['recipient'])->send(new PasswordBaru($details));

        return ResponseFormatter::success('password baru telah dikirim silahkan di cek', $pw);


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
