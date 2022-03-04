<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\KedatonNewMember;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\MyTestMail;
use App\Mail\PasswordBaru;
use App\Mail\ResendEmail;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Models\Listing;
use App\Models\Properti;
use App\Models\Properti_image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
// use Hash;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
// use Mail;

class UserController extends Controller
{
    public function getNik(Request $request)
    {

        $user_detail = User::where('nik', $request->nik)->first();
        if ($request->nik == null) {
            return ResponseFormatter::failed('mohon masukkan nik terlebih dahulu!', 404);
        }

        if ($user_detail == null) {
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
        }
        return ResponseFormatter::success('sukses mengambil detail user!', [$user_detail]);
    }

    private function checkEmailExists($email)
    {
        return User::where('email', $email)->first();
    }

    public function register(Request $request)
    {


        $cekNik = User::where('nik', $request->nik)->first();
        if ($cekNik == null) {
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
        }

        if (!$request->email || !$request->nik || !$request->snk) {
            return ResponseFormatter::failed('tidak boleh ada filed kosong', 404);
        }


        if($cekNik && $cekNik->snk == 1){
            return ResponseFormatter::failed('user ini sudah register, silahkan login', 404);
        }

        if ($this->checkEmailExists($request->email)) {
            return ResponseFormatter::failed('User email Already Exists!', 404);
        }

        // dd($cekNik != null);
        if ($cekNik != null && $request->snk == 1) {
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

            Mail::to($details['recipient'])->send(new KedatonNewMember($details));

            // dd("Email sudah terkirim.");

            return ResponseFormatter::success('anda telah sukses regristasi! password dikirim melalui email', $pw);
        }
    }

    public function editpass(Request $request)
    {

        $user = User::find($request->id);

        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        if (!$request->id || !$request->password_lama || !$request->password_baru || !$request->konfimasi_password_baru) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        $cek_pw_lama = Hash::check($request->password_lama, $user->password);
        if ($cek_pw_lama == false) {
            return ResponseFormatter::failed('password lama anda salah, cek kembali passwod lama!', 404);
        }

        // dd(strcmp("Hello world!","Hello world!"));
        // dd(strcmp($request->password_baru, $request->konfimasi_password_baru) == 0);
        if (strcmp($request->password_baru, $request->konfimasi_password_baru) != 0) {
            return ResponseFormatter::failed('password baru harus sama dengan pasword konfirmasi!', 404);
        }

        if (strcmp($request->password_baru, $request->password_lama) == 0) {
            return ResponseFormatter::failed('password baru tidak boleh sama dengan password lama!', 404);
        }

        $pw_baru = Hash::make($request->password_baru);
        $user->password = $pw_baru;
        $user->update();

        return ResponseFormatter::success('password telah diperbarui!', $request->password_baru);
    }

    public function login(Request $request)
    {
        if (!$request->password || !$request->nik) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        $cekNik = User::where('nik', $request->nik)->first();
        if ($cekNik == null) {
            return ResponseFormatter::failed('tidak ada user dengan nik tersebut!', 404);
        }

        $pw = Hash::check($request->password, $cekNik->password);
        if ($cekNik != null && $pw) {
            return ResponseFormatter::success('User telah berhasil login!', $cekNik);
        } else {
            return ResponseFormatter::failed('User Login Failed!', 401, ['Unauthorized']);
        }
    }

    public function profile(Request $request)
    {

        if (!$request->id) {
            return ResponseFormatter::failed('masukkan id terlebih dahulu!', 404);
        }

        $user = User::where('id', $request->id)->first(['nik', 'name', 'alamat', 'phone', 'email', 'photo_ktp', 'photo_identitas', 'status_penghuni']);

        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user dengan id ini!', 404);
        }

        $user->photo_identitas = $user->image_url;
        $user->photo_ktp = $user->image_ktp;

        $cek_kepemilikan_prop = Properti::where('pemilik_id', $request->id)->first();
        $cek_penghuni_prop = Properti::where('penghuni_id', $request->id)->first();

        if ($cek_kepemilikan_prop != null) {

            $properti = Properti::with(
                    [
                        'pemilik' => function ($pemilik) {
                            $pemilik->select('id','name');
                        },
                        'penghuni' => function ($penghuni) {
                            $penghuni->select('id','name');
                        },
                        'cluster' => function ($cluster) {
                            $cluster->select('id','name');
                        }
                    ]
                )
                ->where('pemilik_id', $request->id)->select('id','no_rumah', 'penghuni_id', 'pemilik_id', 'cluster_id', 'luas_tanah', 'luas_bangunan', 'jumlah_kamar', 'kamar_mandi', 'carport')->get();
            // dd($properti);
            foreach ($properti as $q) {
                $q->gambar =  url('/').'/storage/'.$q->cover_url;
            }

            if($properti->count() == 0){
                return ResponseFormatter::failed('user ini tidak punya properti!', 404);
            }


            // dd($properti);
            // $return['image_properti'] =
            $return['pemilik'] = $user;
            $return['properti'] = $properti;
            // $return['properti']['image'] =
            return ResponseFormatter::success('get user profile n properti!', $return);
        } else if ($cek_penghuni_prop != null) {
            $properti = Properti::with(
                [
                    'pemilik' => function ($pemilik) {
                        $pemilik->select('id','name');
                    },
                    'penghuni' => function ($penghuni) {
                        $penghuni->select('id','name');
                    },
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    }
                ]
            )
            ->where('penghuni_id', $request->id)->select('id', 'no_rumah', 'penghuni_id', 'pemilik_id', 'cluster_id', 'luas_tanah', 'luas_bangunan', 'jumlah_kamar', 'kamar_mandi', 'carport')->get();
            foreach ($properti as $q) {
                $q->gambar =  url('/').'/storage/'.$q->cover_url;
            }

            if($properti->count() == 0){
                return ResponseFormatter::failed('user ini tidak punya properti!', 404);
            }

            // dd($properti);
            $return['penghuni'] = $user;
            $return['properti'] = $properti;
            return ResponseFormatter::success('get user profile n properti!', $return);
        }
    }

    public function forget(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        // dd($user);
        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user dengan email tersebut!', 404);
        }

        if (!$request->email) {
            return ResponseFormatter::failed('tidak boeh ada field kosong!', 404);
        }

        $pw = Str::random(8);
        // dd($pw);
        $hashed_random_password = Hash::make($pw);
        $user->password = $hashed_random_password;
        // dd($user->password);
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



    public function update(Request $request)
    {
        if (!$request->id || !$request->email || !$request->phone) {
            return ResponseFormatter::failed('masukkan inputan terlebih dahulu!', 401);
        }
        $user = User::find($request->id);
        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user id tersebut!', 401);
        }
        // dd($user->email);

        if ($request->email == $user->email && $request->phone != $user->phone) {
            $user->phone = $request->phone;
            $user->save();
        } else if ($request->email != $user->email && $request->phone == $user->phone) {
            $user->email = $request->email;
            $user->save();
        } else if ($request->email != $user->email && $request->phone != $user->phone) {
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
        } else {
            return ResponseFormatter::failed('data anda sudah sama dengan database!', 401);
        }

        // dd($user);


        $data_user = User::where('id', $request->id)->first(['id', 'email', 'phone']);
        if ($data_user) {
            return ResponseFormatter::success('successful to update user profile!', $data_user);
        } else {
            return ResponseFormatter::failed('failed to update profile!', 401);
        }
    }

    public function resendpass(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // dd($user);
        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user dengan email tersebut!', 404);
        }

        if (!$request->email) {
            return ResponseFormatter::failed('tidak boeh ada field kosong!', 404);
        }

        $pw = Str::random(8);
        // dd($pw);
        $hashed_random_password = Hash::make($pw);
        $user->password = $hashed_random_password;
        // dd($user->password);
        $user->save();
        $details = [
            'recipient' => $request->email,
            // 'fromEmail' => 'coba@gmail.com',
            'nik' => $user->nik,
            'subject' => $pw
        ];

        Mail::to($details['recipient'])->send(new ResendEmail($details));

        return ResponseFormatter::success('informasi login sudah dikirim melalui email', $pw);
    }
}
