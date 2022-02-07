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
use Hash;

class UserController extends Controller
{



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

       public function register(Request $request)
    {
        $input = $request->all();
        $properti = $request->all();


        $validator = Validator::make($input, [
            'nik' => 'required',
            'name' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $validator = Validator::make($properti, [
            'cluster_id' => 'required',
            'no_rumah' => 'required',
            'no_listrik' => 'required',
            'no_pam_bsd' => 'required',
        ]);




        if ($validator->fails()) {
            return ResponseFormatter::failed('User Registration Failed!', 401, $validator->errors());
        }

        if ($this->checkNikExists($input['nik'])) {
            return ResponseFormatter::failed('User nik Already Exists!', 409, $validator->errors());
        }

        if ($this->checkUsernameExists($input['name'])) {
            return ResponseFormatter::failed('User name Already Exists!', 409, $validator->errors());
        }

        if ($this->checkEmailExists($input['email'])) {
            return ResponseFormatter::failed('User Email Already Exists!', 409, $validator->errors());
        }

      //   $user->user_status = 'pengguna';
          if($request->hasFile('photo_identitas'))
          {
              $file = $request->file('photo_identitas');
              $extention = $file->getClientOriginalExtension();
              $filename=time().'.'.$extention;
              $file->move('user_photo',$filename);
              $input['photo_identitas']=$filename;
          }


        $input['user_status'] = 'pengguna';

        $user = User::create($input);
        $properti['pemilik_id'] = $user->id;
        $tbl_properti = Properti::create($properti);

        return ResponseFormatter::success('User Registration Success!', [$user, $tbl_properti]);
    }



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


}
